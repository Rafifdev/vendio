<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__DIR__) . '/libraries/Order_prize_rules.php';

class Model_order_prizes extends CI_Model
{
    private $tables = ['campaigns'=>'order_prize_campaigns', 'prizes'=>'order_prize_items',
        'orders'=>'order_prize_orders', 'spins'=>'order_prize_spins', 'audit'=>'order_prize_audit'];

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Turn query failures into exceptions, never expose SQL or commit partial awards.
        $this->db->db_debug = false;
    }

    private function q($sql, array $params = [])
    {
        $result = $this->db->query($sql, $params);
        if ($result === false) {
            $error = $this->db->error();
            if ((int)$error['code'] === 1062) throw new Order_prize_error('Data sudah ada. Muat ulang sebelum mencoba lagi.', 409);
            log_message('error', 'Order Prizes database error code: ' . $error['code']);
            throw new RuntimeException('Order Prizes database operation failed');
        }
        return $result;
    }

    private function transaction(callable $work)
    {
        if (!$this->db->trans_begin()) throw new RuntimeException('Cannot begin transaction');
        try {
            $result = $work();
            if (!$this->db->trans_status() || !$this->db->trans_commit()) throw new RuntimeException('Cannot commit transaction');
            return $result;
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            throw $e;
        }
    }

    private function now() { return date('Y-m-d H:i:s'); }

    private function row($table, $id, $lock = false)
    {
        $row = $this->q('SELECT * FROM ' . $table . ' WHERE id = ?' . ($lock ? ' FOR UPDATE' : ''), [$id])->row_array();
        if (!$row) throw new Order_prize_error('Data tidak ditemukan.', 404);
        return $row;
    }

    private function insert($table, array $data)
    {
        $this->q('INSERT INTO ' . $table . ' (`' . implode('`,`', array_keys($data)) . '`) VALUES (' . implode(',', array_fill(0, count($data), '?')) . ')', array_values($data));
        return (int)$this->db->insert_id();
    }

    private function update($table, $id, array $data)
    {
        $set = [];
        foreach ($data as $key=>$value) $set[] = '`' . $key . '` = ?';
        $this->q('UPDATE ' . $table . ' SET ' . implode(',', $set) . ' WHERE id = ?', array_merge(array_values($data), [$id]));
    }

    private function audit($actor, $action, $entity, $id, array $detail)
    {
        // Audit never stores raw bearer tokens; PII remains admin-only.
        $this->insert('order_prize_audit', ['actor_id'=>$actor, 'action'=>$action, 'entity'=>$entity,
            'entity_id'=>$id, 'detail_json'=>json_encode($detail, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR), 'created_at'=>$this->now()]);
    }

    private function active(array $c)
    {
        $now = $this->now();
        if ($c['status'] !== 'active' || $now < $c['starts_at'] || $now > $c['ends_at']) throw new Order_prize_error('Campaign tidak sedang berlangsung.', 409);
    }

    private function require_fallback($campaignId)
    {
        foreach ($this->q('SELECT * FROM order_prize_items WHERE campaign_id = ?', [$campaignId])->result_array() as $p) {
            if (Order_prize_rules::fallback($p)) return;
        }
        throw new Order_prize_error('Campaign aktif wajib punya hadiah fallback: aktif, stok unlimited, cost 0, tanpa threshold.');
    }

    public function save_campaign(array $input, $id, $actor)
    {
        return $this->transaction(function () use ($input, $id, $actor) {
            $old = $id ? $this->row('order_prize_campaigns', $id, true) : [];
            $data = Order_prize_rules::campaign(array_merge($old, $input));
            if ($id) {
                $used = $this->q('SELECT id FROM order_prize_orders WHERE campaign_id = ? LIMIT 1', [$id])->row_array();
                foreach (['slug','channel','shop_ref'] as $field) {
                    if ($used && $data[$field] !== $old[$field]) throw new Order_prize_error('Identitas campaign tidak bisa diubah setelah ada order.', 409);
                }
            }
            $data['updated_at'] = $this->now();
            if ($id) $this->update('order_prize_campaigns', $id, $data);
            else $id = $this->insert('order_prize_campaigns', $data + ['created_at'=>$this->now()]);
            if ($data['status'] === 'active') $this->require_fallback($id);
            $this->audit($actor, 'campaign.save', 'campaigns', $id, ['before'=>$old, 'after'=>$data]);
            return $this->row('order_prize_campaigns', $id);
        });
    }

    public function save_prize(array $input, $id, $actor)
    {
        $context = $id ? $this->row('order_prize_items', $id) : [];
        $campaignId = Order_prize_rules::integer($context['campaign_id'] ?? ($input['campaign_id'] ?? ''), 'Campaign', 1, 4294967295);
        return $this->transaction(function () use ($input, $id, $actor, $campaignId) {
            $c = $this->row('order_prize_campaigns', $campaignId, true);
            $old = $id ? $this->row('order_prize_items', $id, true) : [];
            $data = Order_prize_rules::prize(array_merge($old, $input));
            if ($data['campaign_id'] !== $campaignId) throw new Order_prize_error('Hadiah tidak bisa dipindah campaign.');
            if (!$id && $this->q('SELECT COUNT(*) n FROM order_prize_items WHERE campaign_id = ?', [$campaignId])->row()->n >= 100) {
                throw new Order_prize_error('Maksimal 100 hadiah per campaign.');
            }
            $data['updated_at'] = $this->now();
            if ($id) $this->update('order_prize_items', $id, $data);
            else $id = $this->insert('order_prize_items', $data + ['created_at'=>$this->now()]);
            if ($c['status'] === 'active') $this->require_fallback($campaignId);
            $this->audit($actor, 'prize.save', 'prizes', $id, ['before'=>$old, 'after'=>$data]);
            return $this->row('order_prize_items', $id);
        });
    }

    private function order_data(array $input, array $campaign, $source)
    {
        $data = [
            'campaign_id'=>(int)$campaign['id'], 'channel'=>$campaign['channel'], 'shop_ref'=>$campaign['shop_ref'],
            'order_number'=>Order_prize_rules::order_number($input['order_number'] ?? ''),
            'phone'=>Order_prize_rules::phone($input['phone'] ?? ''),
            'status'=>Order_prize_rules::choice($input['status'] ?? 'completed', 'Status order', ['paid','completed','cancelled','refunded']),
            'revenue'=>Order_prize_rules::integer($input['revenue'] ?? '', 'Omset IDR', 0, 1000000000),
            'profit'=>Order_prize_rules::integer($input['profit'] ?? null, 'Profit IDR', -1000000000, 1000000000, true),
            'ordered_at'=>Order_prize_rules::datetime($input['ordered_at'] ?? '', 'Waktu order'),
            'source'=>$source, 'updated_at'=>$this->now(),
        ];
        if ($data['profit'] !== null && $data['profit'] > $data['revenue']) throw new Order_prize_error('Profit tidak boleh melebihi omset.');
        if ($data['ordered_at'] < $campaign['starts_at'] || $data['ordered_at'] > $campaign['ends_at'] || $data['ordered_at'] > $this->now()) {
            throw new Order_prize_error('Waktu order harus di dalam periode campaign dan bukan masa depan.');
        }
        return $data;
    }

    public function save_order(array $input, $id, $actor)
    {
        $context = $id ? $this->row('order_prize_orders', $id) : [];
        $campaignId = Order_prize_rules::integer($context['campaign_id'] ?? ($input['campaign_id'] ?? ''), 'Campaign', 1, 4294967295);
        return $this->transaction(function () use ($input, $id, $actor, $campaignId) {
            $c = $this->row('order_prize_campaigns', $campaignId, true);
            $old = $id ? $this->row('order_prize_orders', $id, true) : [];
            if (isset($input['campaign_id']) && (int)$input['campaign_id'] !== $campaignId) throw new Order_prize_error('Order tidak bisa dipindah campaign.');
            $data = $this->order_data(array_merge($old, $input), $c, $old['source'] ?? 'manual');
            $spun = $id && $this->q('SELECT id FROM order_prize_spins WHERE order_id = ?', [$id])->row_array();
            if ($spun) {
                foreach (['order_number','phone','revenue','profit','ordered_at'] as $field) {
                    if ((string)$old[$field] !== (string)$data[$field]) throw new Order_prize_error('Data order yang sudah spin tidak dapat diubah, kecuali status.', 409);
                }
            }
            $data['updated_at'] = $this->now();
            if ($id) {
                $this->update('order_prize_orders', $id, $data);
                // Invalidate unspent tokens after any trusted order edit.
                if (!$spun) $this->q('DELETE FROM order_prize_tokens WHERE order_id = ?', [$id]);
            } else $id = $this->insert('order_prize_orders', $data + ['created_at'=>$this->now()]);
            $this->audit($actor, 'order.save', 'orders', $id, ['before'=>$old, 'after'=>$data]);
            return $this->row('order_prize_orders', $id);
        });
    }

    public function import_orders($campaignId, array $rows, $actor)
    {
        if (!$rows || count($rows) > 1000) throw new Order_prize_error('CSV harus berisi 1–1000 order.');
        return $this->transaction(function () use ($campaignId, $rows, $actor) {
            $c = $this->row('order_prize_campaigns', $campaignId, true);
            $ids = [];
            foreach ($rows as $index=>$row) {
                try {
                    $data = $this->order_data($row, $c, 'csv');
                    $ids[] = $this->insert('order_prize_orders', $data + ['created_at'=>$this->now()]);
                } catch (Order_prize_error $e) {
                    throw new Order_prize_error('CSV baris ' . ($index + 2) . ': ' . $e->getMessage() . ' Tidak ada baris diimpor.', $e->http_status);
                }
            }
            $this->audit($actor, 'orders.import', 'campaigns', $campaignId, ['order_ids'=>$ids, 'count'=>count($ids)]);
            return ['imported'=>count($ids)];
        });
    }

    public function rate_limit($scope, $identity, $limit = 30)
    {
        $window = intdiv(time(), 900);
        $bucket = hash('sha256', $scope . ':' . $identity . ':' . $window);
        $this->q('INSERT INTO order_prize_rate_limits (bucket,hits,expires_at) VALUES (?,1,?) ON DUPLICATE KEY UPDATE hits = hits + 1', [$bucket, date('Y-m-d H:i:s', ($window + 2) * 900)]);
        $count = $this->q('SELECT hits FROM order_prize_rate_limits WHERE bucket = ?', [$bucket])->row()->hits;
        $this->q('DELETE FROM order_prize_rate_limits WHERE expires_at < ? LIMIT 100', [$this->now()]);
        if ($count > $limit) throw new Order_prize_error('Terlalu banyak percobaan. Coba lagi dalam 15 menit.', 429);
    }

    public function public_campaign($slug)
    {
        $c = $this->q('SELECT * FROM order_prize_campaigns WHERE slug = ?', [$slug])->row_array();
        if (!$c) throw new Order_prize_error('Campaign tidak ditemukan.', 404);
        if ($c['status'] === 'draft') throw new Order_prize_error('Campaign belum dipublikasikan.', 404);
        return ['status'=>$c['status'], 'is_open'=>$c['status'] === 'active' && $this->now() >= $c['starts_at'] && $this->now() <= $c['ends_at'], 'slug'=>$c['slug'], 'name'=>$c['name'], 'terms'=>$c['terms'], 'ends_at'=>$c['ends_at'],
            'claim_days'=>(int)$c['claim_days'], 'timezone'=>date_default_timezone_get(),
            'prizes'=>$this->q('SELECT id,name,description,kind FROM order_prize_items WHERE campaign_id = ? AND active = 1 ORDER BY id', [$c['id']])->result_array()];
    }

    public function verify($slug, $number, $phone, $consent)
    {
        $number = Order_prize_rules::order_number($number);
        $phone = Order_prize_rules::phone($phone);
        $consent = Order_prize_rules::integer($consent, 'Persetujuan marketing', 0, 1);
        $this->rate_limit('order', $slug . ':' . $number, 10);
        return $this->transaction(function () use ($slug, $number, $phone, $consent) {
            $c = $this->q('SELECT * FROM order_prize_campaigns WHERE slug = ? FOR UPDATE', [$slug])->row_array();
            if (!$c) throw new Order_prize_error('Pesanan/nomor HP tidak memenuhi syarat.', 422);
            $o = $this->q('SELECT * FROM order_prize_orders WHERE campaign_id = ? AND order_number = ? FOR UPDATE', [$c['id'], $number])->row_array();
            if (!$o || !hash_equals($o['phone'], $phone)) throw new Order_prize_error('Pesanan/nomor HP tidak memenuhi syarat.', 422);
            $spin = $this->q('SELECT * FROM order_prize_spins WHERE order_id = ?', [$o['id']])->row_array();
            if (!$spin) {
                $this->active($c);
                $this->eligible_order($o, $c);
            }
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 1800);
            $this->q('INSERT INTO order_prize_tokens (order_id,token_hash,expires_at,marketing_consent,consent_at,created_at) VALUES (?,?,?,?,?,?)
                ON DUPLICATE KEY UPDATE token_hash=VALUES(token_hash),expires_at=VALUES(expires_at),marketing_consent=VALUES(marketing_consent),consent_at=VALUES(consent_at)',
                [$o['id'], hash('sha256', $token), $expires, $consent, $consent ? $this->now() : null, $this->now()]);
            if ($spin && (int)$spin['marketing_consent'] !== $consent) {
                $this->update('order_prize_spins', $spin['id'], ['marketing_consent'=>$consent, 'updated_at'=>$this->now()]);
            }
            $this->audit(null, 'order.verify', 'orders', $o['id'], ['marketing_consent'=>$consent, 'terms_sha256'=>hash('sha256', $c['terms'])]);
            return ['token'=>$token, 'expires_at'=>$expires, 'already_spun'=>(bool)$spin, 'result'=>$spin ? $this->public_result($spin) : null];
        });
    }

    private function eligible_order(array $o, array $c)
    {
        if (!in_array($o['status'], ['paid','completed'], true) || $o['ordered_at'] < $c['starts_at'] || $o['ordered_at'] > $c['ends_at']) {
            throw new Order_prize_error('Pesanan tidak memenuhi syarat.', 422);
        }
    }

    private function token_context($raw)
    {
        if (!is_string($raw) || !preg_match('/^[a-f0-9]{64}$/D', $raw)) throw new Order_prize_error('Token tidak valid atau kedaluwarsa.', 401);
        $t = $this->q('SELECT t.*,o.campaign_id FROM order_prize_tokens t JOIN order_prize_orders o ON o.id=t.order_id WHERE t.token_hash=?', [hash('sha256', $raw)])->row_array();
        if (!$t) throw new Order_prize_error('Token tidak valid atau kedaluwarsa.', 401);
        return $t;
    }

    private function locked_token($raw, array $context)
    {
        $t = $this->q('SELECT * FROM order_prize_tokens WHERE id = ? FOR UPDATE', [$context['id']])->row_array();
        if (!$t || !hash_equals($t['token_hash'], hash('sha256', $raw)) || $t['expires_at'] <= $this->now()) {
            throw new Order_prize_error('Token tidak valid atau kedaluwarsa. Verifikasi pesanan lagi.', 401);
        }
        return $t;
    }

    public function spin($raw)
    {
        $context = $this->token_context($raw);
        return $this->transaction(function () use ($raw, $context) {
            // Every mutating operation uses campaign -> order -> token -> prize/spin lock order.
            $c = $this->row('order_prize_campaigns', $context['campaign_id'], true);
            $o = $this->row('order_prize_orders', $context['order_id'], true);
            $t = $this->locked_token($raw, $context);
            $existing = $this->q('SELECT * FROM order_prize_spins WHERE order_id = ?', [$o['id']])->row_array();
            if ($existing) return $this->public_result($existing); // Idempotent even when campaign has ended.
            $this->active($c);
            $this->eligible_order($o, $c);
            $totals = ['spin_count'=>(int)$c['spin_count'] + 1, 'revenue_total'=>(int)$c['revenue_total'] + (int)$o['revenue'],
                'profit_total'=>(int)$c['profit_total'] + (int)$o['profit'], 'awarded_cost'=>(int)$c['awarded_cost']];
            foreach ($totals as $value) {
                if (abs($value) > 100000000000000) throw new Order_prize_error('Batas akumulasi campaign tercapai.', 409);
            }
            $prizes = $this->q('SELECT * FROM order_prize_items WHERE campaign_id = ? ORDER BY id FOR UPDATE', [$c['id']])->result_array();
            $eligible = array_values(array_filter($prizes, function ($p) use ($totals, $c) { return Order_prize_rules::eligible($p, $totals, $c['budget_profit_percent']); }));
            $winner = Order_prize_rules::draw($eligible);
            $decision = ['totals'=>$totals, 'budget_profit_percent'=>$c['budget_profit_percent'], 'eligible_weights'=>[], 'winner_rules'=>$winner];
            foreach ($eligible as $p) $decision['eligible_weights'][$p['id']] = (int)$p['weight'];
            $none = $winner['kind'] === 'none';
            $id = $this->insert('order_prize_spins', [
                'campaign_id'=>$c['id'], 'order_id'=>$o['id'], 'token_id'=>$t['id'], 'prize_id'=>$winner['id'],
                'order_number'=>$o['order_number'], 'phone'=>$o['phone'], 'prize_name'=>$winner['name'],
                'prize_kind'=>$winner['kind'], 'prize_cost'=>$winner['cost'], 'spin_type'=>'order',
                'claim_status'=>$none ? 'not_required' : 'pending', 'prize_status'=>$none ? 'not_required' : 'reserved',
                'follow_up_status'=>$none ? 'closed' : 'pending', 'broadcast_status'=>'not_sent',
                'marketing_consent'=>$t['marketing_consent'], 'notes'=>'',
                'decision_json'=>json_encode($decision, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'spun_at'=>$this->now(), 'claim_deadline'=>date('Y-m-d H:i:s', time() + (int)$c['claim_days'] * 86400), 'updated_at'=>$this->now(),
            ]);
            $this->q('UPDATE order_prize_items SET stock = IF(stock IS NULL,NULL,stock-1), awarded_count=awarded_count+1, updated_at=? WHERE id=?', [$this->now(), $winner['id']]);
            $totals['awarded_cost'] += (int)$winner['cost'];
            $this->update('order_prize_campaigns', $c['id'], $totals + ['updated_at'=>$this->now()]);
            $this->audit(null, 'spin.awarded', 'spins', $id, ['prize_id'=>$winner['id'], 'token_id'=>$t['id']]);
            return $this->public_result($this->row('order_prize_spins', $id));
        });
    }

    private function effective_spin(array $s)
    {
        if ($s['claim_status'] === 'pending' && $s['claim_deadline'] <= $this->now()) $s['claim_status'] = 'expired';
        return $s;
    }

    private function public_result(array $s)
    {
        $s = $this->effective_spin($s);
        return array_intersect_key($s, array_flip(['id','prize_id','prize_name','prize_kind','spin_type','claim_status','prize_status','spun_at','claim_deadline','claimed_at']));
    }

    public function result_or_claim($raw, $claim = false)
    {
        $context = $this->token_context($raw);
        return $this->transaction(function () use ($raw, $context, $claim) {
            $this->row('order_prize_campaigns', $context['campaign_id'], true);
            $o = $this->row('order_prize_orders', $context['order_id'], true);
            $this->locked_token($raw, $context);
            $s = $this->q('SELECT * FROM order_prize_spins WHERE order_id = ? FOR UPDATE', [$context['order_id']])->row_array();
            if (!$s) throw new Order_prize_error('Pesanan belum spin.', 409);
            $s = $this->effective_spin($s);
            if ($claim && $s['claim_status'] !== 'claimed') {
                if ($s['claim_status'] !== 'pending') throw new Order_prize_error('Hadiah tidak dapat diklaim.', 409);
                if (!in_array($o['status'], ['paid','completed'], true)) throw new Order_prize_error('Status order tidak memenuhi syarat klaim.', 409);
                $this->update('order_prize_spins', $s['id'], ['claim_status'=>'claimed','claimed_at'=>$this->now(),'updated_at'=>$this->now()]);
                $this->audit(null, 'claim.submitted', 'spins', $s['id'], []);
                $s = $this->row('order_prize_spins', $s['id']);
            }
            return $this->public_result($s);
        });
    }

    public function fulfill($id, array $input, $actor)
    {
        $context = $this->row('order_prize_spins', $id);
        return $this->transaction(function () use ($id, $input, $actor, $context) {
            $this->row('order_prize_campaigns', $context['campaign_id'], true);
            $o = $this->row('order_prize_orders', $context['order_id'], true);
            $old = $this->effective_spin($this->row('order_prize_spins', $id, true));
            $maps = [
                'claim_status'=>['pending'=>['claimed','rejected'], 'claimed'=>['rejected'], 'expired'=>['rejected']],
                'prize_status'=>['reserved'=>['processing','void'], 'processing'=>['sent','delivered','void'], 'sent'=>['delivered']],
                'follow_up_status'=>['pending'=>['contacted','closed'], 'contacted'=>['closed','pending'], 'closed'=>['pending']],
                'broadcast_status'=>['not_sent'=>['queued'], 'queued'=>['sent','failed','not_sent'], 'failed'=>['queued','not_sent']],
            ];
            $data = [];
            foreach ($maps as $field=>$map) {
                $to = Order_prize_rules::text($input[$field] ?? $old[$field], $field, 20);
                Order_prize_rules::transition($old[$field], $to, $map, $field);
                $data[$field] = $to;
            }
            if (in_array($data['broadcast_status'], ['queued','sent'], true) && $data['broadcast_status'] !== $old['broadcast_status'] && !$old['marketing_consent']) {
                throw new Order_prize_error('Customer belum menyetujui marketing/broadcast.', 409);
            }
            if (in_array($data['prize_status'], ['processing','sent','delivered'], true) && $data['claim_status'] !== 'claimed') throw new Order_prize_error('Hadiah harus diklaim sebelum diproses.', 409);
            if (($data['claim_status'] === 'claimed' && $old['claim_status'] !== 'claimed') || ($data['prize_status'] !== $old['prize_status'] && in_array($data['prize_status'], ['processing','sent','delivered'], true))) {
                if (!in_array($o['status'], ['paid','completed'], true)) throw new Order_prize_error('Order dibatalkan/refund tidak dapat dipenuhi.', 409);
            }
            if ($data['prize_status'] === 'void' && !in_array($data['claim_status'], ['rejected','expired'], true)) throw new Order_prize_error('Hadiah void harus disertai klaim rejected/expired.');
            if ($data['claim_status'] === 'rejected' && $data['prize_status'] !== 'void') throw new Order_prize_error('Klaim ditolak harus disertai hadiah void.');
            $data['notes'] = Order_prize_rules::text($input['notes'] ?? $old['notes'], 'Catatan', 5000, false);
            if (($data['claim_status'] === 'rejected' || $data['prize_status'] === 'void') && $data['notes'] === '') throw new Order_prize_error('Isi alasan penolakan/void.');
            if ($data['claim_status'] === 'claimed' && $old['claim_status'] !== 'claimed') $data['claimed_at'] = $this->now();
            $data['updated_at'] = $this->now();
            $this->update('order_prize_spins', $id, $data);
            $this->audit($actor, 'spin.fulfill', 'spins', $id, ['before'=>array_intersect_key($old, $data), 'after'=>$data]);
            return $this->effective_spin($this->row('order_prize_spins', $id));
        });
    }

    public function listing($entity, array $filters)
    {
        if (!isset($this->tables[$entity])) throw new Order_prize_error('Modul tidak ditemukan.', 404);
        $table = $this->tables[$entity];
        $where = ['1=1']; $params = [];
        $page = Order_prize_rules::integer($filters['page'] ?? 1, 'Halaman', 1, 1000000);
        $limit = Order_prize_rules::integer($filters['limit'] ?? 25, 'Limit', 1, 100);
        $allowed = ['campaigns'=>['status'], 'prizes'=>['campaign_id','active'], 'orders'=>['campaign_id','status'],
            'spins'=>['campaign_id','prize_status','follow_up_status','broadcast_status','marketing_consent'], 'audit'=>['entity','entity_id']];
        foreach ($allowed[$entity] as $field) {
            if (isset($filters[$field]) && $filters[$field] !== '') { $where[] = '`' . $field . '` = ?'; $params[] = Order_prize_rules::text($filters[$field], $field, 80); }
        }
        if ($entity === 'spins' && !empty($filters['claim_status'])) {
            $where[] = "(CASE WHEN claim_status='pending' AND claim_deadline <= ? THEN 'expired' ELSE claim_status END) = ?";
            $params[] = $this->now(); $params[] = Order_prize_rules::text($filters['claim_status'], 'claim_status', 20);
        }
        if (!empty($filters['q'])) {
            $search = ['campaigns'=>['name','slug'], 'prizes'=>['name'], 'orders'=>['order_number','phone'], 'spins'=>['order_number','phone','prize_name'], 'audit'=>['action']][$entity];
            $parts = [];
            foreach ($search as $field) { $parts[] = '`' . $field . '` LIKE ?'; $params[] = '%' . $this->db->escape_like_str(Order_prize_rules::text($filters['q'], 'Pencarian', 100)) . '%'; }
            $where[] = '(' . implode(" ESCAPE '!' OR ", $parts) . " ESCAPE '!')";
        }
        $where = implode(' AND ', $where);
        $total = (int)$this->q('SELECT COUNT(*) n FROM ' . $table . ' WHERE ' . $where, $params)->row()->n;
        $rows = $this->q('SELECT * FROM ' . $table . ' WHERE ' . $where . ' ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . (($page - 1) * $limit), $params)->result_array();
        if ($entity === 'spins') $rows = array_map([$this, 'effective_spin'], $rows);
        return ['items'=>$rows, 'total'=>$total, 'page'=>$page, 'limit'=>$limit];
    }
}
