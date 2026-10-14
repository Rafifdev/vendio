<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Pure rules: whole IDR only; no browser-supplied financial or random input. */
class Order_prize_error extends RuntimeException
{
    public $http_status;
    public function __construct($message, $status = 422)
    {
        parent::__construct($message);
        $this->http_status = $status;
    }
}

class Order_prize_rules
{
    public static function text($value, $name, $max, $required = true)
    {
        if (!is_scalar($value) && $value !== null) {
            throw new Order_prize_error($name . ' tidak valid.');
        }
        $value = trim((string) $value);
        if (($required && $value === '') || strlen($value) > $max || !preg_match('//u', $value) || preg_match('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', $value)) {
            throw new Order_prize_error($name . ' tidak valid / terlalu panjang.');
        }
        return $value;
    }

    public static function integer($value, $name, $min = 0, $max = 1000000000000, $nullable = false)
    {
        if ($nullable && ($value === null || $value === '')) return null;
        if ((!is_int($value) && !is_string($value)) || !preg_match('/^-?\d+$/D', (string) $value) || $value < $min || $value > $max) {
            throw new Order_prize_error($name . ' harus bilangan bulat ' . $min . '–' . $max . '.');
        }
        return (int) $value;
    }

    public static function choice($value, $name, array $choices)
    {
        if (!in_array($value, $choices, true)) throw new Order_prize_error($name . ' tidak valid.');
        return $value;
    }

    public static function datetime($value, $name)
    {
        $value = str_replace('T', ' ', self::text($value, $name, 19));
        if (strlen($value) === 16) $value .= ':00';
        $date = DateTime::createFromFormat('!Y-m-d H:i:s', $value);
        if (!$date || $date->format('Y-m-d H:i:s') !== $value) throw new Order_prize_error($name . ' harus YYYY-MM-DD HH:MM:SS.');
        return $value;
    }

    public static function phone($value)
    {
        $value = self::text($value, 'Nomor HP', 32);
        if (!preg_match('/^[+0-9 ()-]+$/D', $value)) throw new Order_prize_error('Nomor HP tidak valid; data masked tidak diterima.');
        $value = preg_replace('/[ ()+-]/', '', $value);
        if (substr($value, 0, 1) === '0') $value = '62' . substr($value, 1);
        if (!preg_match('/^628[0-9]{7,11}$/D', $value)) throw new Order_prize_error('Gunakan nomor seluler Indonesia 08… atau +628….');
        return $value;
    }

    public static function order_number($value)
    {
        $value = strtoupper(self::text($value, 'Nomor pesanan', 80));
        if (!preg_match('/^[A-Z0-9][A-Z0-9_-]{3,79}$/D', $value)) throw new Order_prize_error('Nomor pesanan tidak valid.');
        return $value;
    }

    public static function campaign(array $in)
    {
        $d = array_merge(['status'=>'draft', 'channel'=>'shopee', 'claim_days'=>7, 'budget_profit_percent'=>null, 'terms'=>''], $in);
        $slug = self::text($d['slug'] ?? '', 'Slug', 80);
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/D', $slug)) throw new Order_prize_error('Slug harus huruf kecil, angka, dan strip.');
        $out = [
            'slug'=>$slug, 'name'=>self::text($d['name'] ?? '', 'Nama', 160),
            'channel'=>self::choice($d['channel'], 'Channel', ['shopee','tiktok','other']),
            'shop_ref'=>self::text($d['shop_ref'] ?? '', 'Referensi toko', 80),
            'status'=>self::choice($d['status'], 'Status', ['draft','active','paused','ended']),
            'starts_at'=>self::datetime($d['starts_at'] ?? '', 'Mulai'),
            'ends_at'=>self::datetime($d['ends_at'] ?? '', 'Selesai'),
            'claim_days'=>self::integer($d['claim_days'], 'Batas klaim (hari)', 1, 90),
            'budget_profit_percent'=>self::integer($d['budget_profit_percent'], 'Budget profit (%)', 1, 100, true),
            'terms'=>self::text($d['terms'], 'Syarat & ketentuan', 10000, false),
        ];
        if ($out['ends_at'] <= $out['starts_at']) throw new Order_prize_error('Selesai harus setelah mulai.');
        if ($out['status'] === 'active' && $out['terms'] === '') throw new Order_prize_error('Isi syarat & ketentuan sebelum aktivasi.');
        return $out;
    }

    public static function prize(array $in)
    {
        $d = array_merge(['description'=>'','kind'=>'physical','active'=>1,'weight'=>1,'stock'=>null,'cost'=>0,
            'threshold_spins'=>0,'threshold_revenue'=>0,'threshold_profit'=>0,'auto_metric'=>'none','allocation_percent'=>10], $in);
        $out = ['campaign_id'=>self::integer($d['campaign_id'] ?? '', 'Campaign', 1, 4294967295),
            'name'=>self::text($d['name'] ?? '', 'Nama hadiah', 160),
            'description'=>self::text($d['description'], 'Deskripsi', 4000, false),
            'kind'=>self::choice($d['kind'], 'Jenis hadiah', ['physical','voucher','none']),
            'active'=>self::integer($d['active'], 'Aktif', 0, 1),
            'weight'=>self::integer($d['weight'], 'Bobot peluang', 1, 1000000),
            'stock'=>self::integer($d['stock'], 'Sisa stok', 0, 1000000, true),
            'auto_metric'=>self::choice($d['auto_metric'], 'Threshold otomatis', ['none','revenue','profit']),
            'allocation_percent'=>self::integer($d['allocation_percent'], 'Alokasi (%)', 1, 100)];
        foreach (['cost','threshold_spins','threshold_revenue','threshold_profit'] as $key) {
            $out[$key] = self::integer($d[$key], $key, 0, $key === 'threshold_spins' ? 1000000 : 1000000000);
        }
        if ($out['kind'] === 'none' && $out['cost'] !== 0) throw new Order_prize_error('Hadiah none harus berbiaya nol.');
        if ($out['auto_metric'] !== 'none' && $out['cost'] === 0) throw new Order_prize_error('Threshold otomatis perlu cost > 0.');
        return $out;
    }

    public static function fallback(array $p)
    {
        return $p['active'] && $p['stock'] === null && (int)$p['cost'] === 0 &&
            (int)$p['threshold_spins'] === 0 && (int)$p['threshold_revenue'] === 0 &&
            (int)$p['threshold_profit'] === 0 && $p['auto_metric'] === 'none';
    }

    /** Recurring cumulative gates. Each prize's (awarded_count + 1) unlocks its next unit. */
    public static function eligible(array $p, array $totals, $budgetPercent)
    {
        if (!$p['active'] || ($p['stock'] !== null && $p['stock'] <= 0)) return false;
        $next = (int)$p['awarded_count'] + 1;
        $revenue = (int)$p['threshold_revenue'];
        $profit = (int)$p['threshold_profit'];
        if ($p['auto_metric'] !== 'none') {
            $auto = intdiv((int)$p['cost'] * 100 + (int)$p['allocation_percent'] - 1, (int)$p['allocation_percent']);
            if ($p['auto_metric'] === 'revenue') $revenue = max($revenue, $auto);
            else $profit = max($profit, $auto);
        }
        // Division avoids multiplying potentially large campaign lifetime totals.
        foreach (['spin_count'=>(int)$p['threshold_spins'], 'revenue_total'=>$revenue, 'profit_total'=>$profit] as $metric=>$gate) {
            if ($gate > 0 && intdiv(max(0, (int)$totals[$metric]), $gate) < $next) return false;
        }
        if ($budgetPercent !== null && (int)$p['cost'] > 0) {
            $budget = intdiv(max(0, (int)$totals['profit_total']) * (int)$budgetPercent, 100);
            if ((int)$totals['awarded_cost'] + (int)$p['cost'] > $budget) return false;
        }
        return true;
    }

    public static function draw(array $prizes, $ticket = null)
    {
        if (!$prizes) throw new Order_prize_error('Belum ada hadiah tersedia.', 409);
        $total = array_sum(array_column($prizes, 'weight'));
        $ticket = $ticket === null ? random_int(1, $total) : $ticket;
        if ($ticket < 1 || $ticket > $total) throw new InvalidArgumentException('Invalid draw ticket');
        foreach ($prizes as $p) {
            $ticket -= (int)$p['weight'];
            if ($ticket <= 0) return $p;
        }
        throw new LogicException('Unreachable draw');
    }

    public static function transition($from, $to, array $map, $label)
    {
        if ($from !== $to && !in_array($to, $map[$from] ?? [], true)) throw new Order_prize_error('Transisi ' . $label . ' tidak valid: ' . $from . ' → ' . $to, 409);
    }
}
