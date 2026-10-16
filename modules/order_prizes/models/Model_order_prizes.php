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
        $this->auto_migrate();
    }

    public function auto_migrate()
    {
        if (!$this->db->table_exists('order_prize_items') || !$this->db->table_exists('order_prize_orders') || !$this->db->table_exists('order_prize_spins')) {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
            $ddl = [
                "CREATE TABLE IF NOT EXISTS `order_prize_campaigns` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `slug` VARCHAR(80) CHARACTER SET ascii COLLATE ascii_bin NOT NULL UNIQUE,
                  `name` VARCHAR(160) NOT NULL,
                  `channel` VARCHAR(20) NOT NULL DEFAULT 'shopee',
                  `shop_ref` VARCHAR(80) NOT NULL,
                  `created_by` INT UNSIGNED DEFAULT NULL,
                  `status` VARCHAR(12) NOT NULL DEFAULT 'draft',
                  `verification_mode` VARCHAR(12) NOT NULL DEFAULT 'auto',
                  `starts_at` DATETIME NOT NULL,
                  `ends_at` DATETIME NOT NULL,
                  `claim_days` INT UNSIGNED NOT NULL DEFAULT 7,
                  `budget_profit_percent` INT UNSIGNED DEFAULT NULL,
                  `terms` TEXT NOT NULL,
                  `spin_count` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `revenue_total` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `profit_total` BIGINT NOT NULL DEFAULT 0,
                  `awarded_cost` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `created_at` DATETIME NOT NULL,
                  `updated_at` DATETIME NOT NULL,
                  KEY `idx_campaigns_created_by` (`created_by`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_items` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `campaign_id` INT UNSIGNED NOT NULL DEFAULT 0,
                  `created_by` INT UNSIGNED DEFAULT NULL,
                  `name` VARCHAR(160) NOT NULL,
                  `description` TEXT NOT NULL,
                  `kind` VARCHAR(16) NOT NULL DEFAULT 'physical',
                  `active` TINYINT UNSIGNED NOT NULL DEFAULT 1,
                  `weight` INT UNSIGNED NOT NULL DEFAULT 1,
                  `stock` INT UNSIGNED DEFAULT NULL,
                  `cost` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `threshold_spins` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `threshold_revenue` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `threshold_profit` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `auto_metric` VARCHAR(12) NOT NULL DEFAULT 'none',
                  `allocation_percent` INT UNSIGNED NOT NULL DEFAULT 10,
                  `awarded_count` BIGINT UNSIGNED NOT NULL DEFAULT 0,
                  `created_at` DATETIME NOT NULL,
                  `updated_at` DATETIME NOT NULL,
                  KEY `campaign_active` (`campaign_id`, `active`),
                  KEY `campaign_id` (`campaign_id`),
                  KEY `idx_prizes_created_by` (`created_by`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_orders` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `campaign_id` INT UNSIGNED NOT NULL,
                  `channel` VARCHAR(20) NOT NULL,
                  `shop_ref` VARCHAR(80) NOT NULL,
                  `order_number` VARCHAR(80) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
                  `phone` VARCHAR(20) CHARACTER SET ascii NOT NULL,
                  `status` VARCHAR(16) NOT NULL DEFAULT 'completed',
                  `revenue` BIGINT UNSIGNED NOT NULL,
                  `profit` BIGINT DEFAULT NULL,
                  `ordered_at` DATETIME NOT NULL,
                  `source` VARCHAR(20) NOT NULL DEFAULT 'manual',
                  `created_at` DATETIME NOT NULL,
                  `updated_at` DATETIME NOT NULL,
                  UNIQUE KEY `marketplace_order` (`channel`, `shop_ref`, `order_number`),
                  KEY `campaign_status` (`campaign_id`, `status`),
                  KEY `campaign_id` (`campaign_id`),
                  KEY `order_lookup` (`order_number`, `phone`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_tokens` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `order_id` INT UNSIGNED NOT NULL UNIQUE,
                  `token_hash` CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL UNIQUE,
                  `expires_at` DATETIME NOT NULL,
                  `marketing_consent` TINYINT UNSIGNED NOT NULL DEFAULT 0,
                  `consent_at` DATETIME DEFAULT NULL,
                  `created_at` DATETIME NOT NULL,
                  KEY `order_id` (`order_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_spins` (
                  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `campaign_id` INT UNSIGNED NOT NULL,
                  `order_id` INT UNSIGNED NOT NULL UNIQUE,
                  `token_id` INT UNSIGNED NOT NULL UNIQUE,
                  `prize_id` INT UNSIGNED NOT NULL,
                  `order_number` VARCHAR(80) NOT NULL,
                  `phone` VARCHAR(20) NOT NULL,
                  `prize_name` VARCHAR(160) NOT NULL,
                  `prize_kind` VARCHAR(16) NOT NULL,
                  `prize_cost` BIGINT UNSIGNED NOT NULL,
                  `spin_type` VARCHAR(16) NOT NULL DEFAULT 'order',
                  `claim_status` VARCHAR(16) NOT NULL DEFAULT 'pending',
                  `prize_status` VARCHAR(16) NOT NULL DEFAULT 'reserved',
                  `follow_up_status` VARCHAR(16) NOT NULL DEFAULT 'pending',
                  `broadcast_status` VARCHAR(16) NOT NULL DEFAULT 'not_sent',
                  `marketing_consent` TINYINT UNSIGNED NOT NULL DEFAULT 0,
                  `notes` TEXT NOT NULL,
                  `decision_json` MEDIUMTEXT NOT NULL,
                  `spun_at` DATETIME NOT NULL,
                  `claim_deadline` DATETIME NOT NULL,
                  `claimed_at` DATETIME DEFAULT NULL,
                  `updated_at` DATETIME NOT NULL,
                  KEY `campaign_time` (`campaign_id`, `spun_at`),
                  KEY `workflow` (`claim_status`, `follow_up_status`, `broadcast_status`),
                  KEY `campaign_id` (`campaign_id`),
                  KEY `prize_id` (`prize_id`),
                  KEY `order_id` (`order_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_audit` (
                  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `actor_id` INT UNSIGNED DEFAULT NULL,
                  `action` VARCHAR(48) NOT NULL,
                  `entity` VARCHAR(20) NOT NULL,
                  `entity_id` INT UNSIGNED NOT NULL,
                  `detail_json` MEDIUMTEXT NOT NULL,
                  `created_at` DATETIME NOT NULL,
                  KEY `entity_history` (`entity`, `entity_id`, `id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "CREATE TABLE IF NOT EXISTS `order_prize_rate_limits` (
                  `bucket` CHAR(64) CHARACTER SET ascii COLLATE ascii_bin PRIMARY KEY,
                  `hits` INT UNSIGNED NOT NULL,
                  `expires_at` DATETIME NOT NULL,
                  KEY `expiry` (`expires_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8",

                "INSERT INTO `aauth_perms` (`name`, `definition`) SELECT 'menu_order_prizes', 'Show the Order Prizes menu' WHERE NOT EXISTS (SELECT 1 FROM `aauth_perms` WHERE `name` = 'menu_order_prizes')",
                "INSERT INTO `aauth_perms` (`name`, `definition`) SELECT 'order_prizes_view', 'View Order Prizes, customer PII and audit log' WHERE NOT EXISTS (SELECT 1 FROM `aauth_perms` WHERE `name` = 'order_prizes_view')",
                "INSERT INTO `aauth_perms` (`name`, `definition`) SELECT 'order_prizes_manage', 'Manage campaigns, prizes and trusted order imports' WHERE NOT EXISTS (SELECT 1 FROM `aauth_perms` WHERE `name` = 'order_prizes_manage')",
                "INSERT INTO `aauth_perms` (`name`, `definition`) SELECT 'order_prizes_fulfill', 'Update claims, fulfillment and follow-up' WHERE NOT EXISTS (SELECT 1 FROM `aauth_perms` WHERE `name` = 'order_prizes_fulfill')",
                "INSERT INTO `menu` (`label`, `type`, `icon_color`, `link`, `sort`, `parent`, `icon`, `menu_type_id`, `active`) SELECT 'Order Prizes', 'menu', 'default', '{admin_url}/order_prizes', 30, 0, 'fa-gift', 1, 1 WHERE NOT EXISTS (SELECT 1 FROM `menu` WHERE `link` = '{admin_url}/order_prizes')"
            ];

            foreach ($ddl as $sql) {
                $this->db->query($sql);
            }
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        }

        if ($this->db->table_exists('order_prize_campaigns')) {
            if (!$this->db->field_exists('verification_mode', 'order_prize_campaigns')) {
                $this->db->query("ALTER TABLE `order_prize_campaigns` ADD COLUMN `verification_mode` VARCHAR(12) NOT NULL DEFAULT 'auto' AFTER `status`");
            }
            if (!$this->db->field_exists('created_by', 'order_prize_campaigns')) {
                $this->db->query("ALTER TABLE `order_prize_campaigns` ADD COLUMN `created_by` INT UNSIGNED NULL AFTER `channel`");
                $this->db->query("ALTER TABLE `order_prize_campaigns` ADD KEY `idx_campaigns_created_by` (`created_by`)");
            }
        }

        if ($this->db->table_exists('order_prize_items')) {
            if (!$this->db->field_exists('created_by', 'order_prize_items')) {
                $this->db->query("ALTER TABLE `order_prize_items` ADD COLUMN `created_by` INT UNSIGNED NULL AFTER `campaign_id`");
                $this->db->query("ALTER TABLE `order_prize_items` ADD KEY `idx_prizes_created_by` (`created_by`)");
            }
        }

        if (!$this->db->table_exists('order_prize_campaign_prizes')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `order_prize_campaign_prizes` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `campaign_id` INT UNSIGNED NOT NULL,
                `prize_id` INT UNSIGNED NOT NULL,
                `created_at` DATETIME NOT NULL,
                UNIQUE KEY `campaign_prize` (`campaign_id`, `prize_id`),
                KEY `campaign_id` (`campaign_id`),
                KEY `prize_id` (`prize_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

            if ($this->db->table_exists('order_prize_items')) {
                $this->db->query("INSERT IGNORE INTO `order_prize_campaign_prizes` (`campaign_id`, `prize_id`, `created_at`)
                    SELECT `campaign_id`, `id`, `created_at` FROM `order_prize_items` WHERE `campaign_id` > 0");
            }
        }

        // Auto-seed 10 hadiah jika daftar hadiah non-fallback masih kosong
        if ($this->db->table_exists('order_prize_items')) {
            $q = $this->db->query("SELECT COUNT(*) AS c FROM `order_prize_items` WHERE `kind` != 'none'");
            $count = ($q && $row = $q->row()) ? (int)$row->c : 0;
            if ($count === 0) {
                $this->seed_default_prizes();
            }
        }
    }

    public function seed_default_prizes($userId = null)
    {
        $now = $this->now();
        $samplePrizes = [
            [
                'name' => 'iPhone 15 Pro 128GB (Grand Prize)',
                'description' => 'Hadiah utama smartphone flagship premium edisi spesial pelanggan setia.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 1,
                'stock' => 1,
                'cost' => 18000000,
                'threshold_spins' => 500,
                'threshold_revenue' => 100000000,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Logam Mulia Antam 1 Gram',
                'description' => 'Emas batangan murni 99.99% bersertifikat resmi PT Antam Tbk.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 3,
                'stock' => 3,
                'cost' => 1450000,
                'threshold_spins' => 100,
                'threshold_revenue' => 20000000,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Smart TV 32 Inch Xiaomi LED',
                'description' => 'Smart TV Android kualitas HD dengan audio Dolby stereo jernih.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 2,
                'stock' => 2,
                'cost' => 2200000,
                'threshold_spins' => 200,
                'threshold_revenue' => 35000000,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Air Fryer Digital Philips 4.1L',
                'description' => 'Penggoreng udara sehat tanpa minyak praktis untuk kebutuhan dapur.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 5,
                'stock' => 5,
                'cost' => 850000,
                'threshold_spins' => 50,
                'threshold_revenue' => 10000000,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Headphone Wireless Sony Extra Bass',
                'description' => 'Headphone Bluetooth nirkabel suara bass mendalam dengan baterai hingga 30 jam.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 10,
                'stock' => 10,
                'cost' => 450000,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Voucher Belanja Diskon Rp 100.000',
                'description' => 'Potongan harga langsung Rp 100.000 untuk transaksi berikutnya di toko.',
                'kind' => 'voucher',
                'active' => 1,
                'weight' => 20,
                'stock' => 25,
                'cost' => 100000,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Voucher Belanja Diskon Rp 50.000',
                'description' => 'Potongan harga langsung Rp 50.000 tanpa batas minimal pembelanjaan.',
                'kind' => 'voucher',
                'active' => 1,
                'weight' => 35,
                'stock' => 50,
                'cost' => 50000,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Voucher Gratis Ongkir s/d Rp 20.000',
                'description' => 'Kupon subsidi ongkos kirim s/d Rp 20.000 berlaku nasional.',
                'kind' => 'voucher',
                'active' => 1,
                'weight' => 50,
                'stock' => 100,
                'cost' => 20000,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Exclusive Merchandise Box (T-Shirt & Tumbler)',
                'description' => 'Paket merchandise eksklusif official Vendio edisi terbatas.',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 15,
                'stock' => 20,
                'cost' => 75000,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
            [
                'name' => 'Belum Beruntung (Coba Lagi)',
                'description' => 'Terima kasih telah berbelanja! Coba lagi keberuntungan Anda di pesanan berikutnya.',
                'kind' => 'none',
                'active' => 1,
                'weight' => 60,
                'stock' => null,
                'cost' => 0,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ]
        ];

        $campaigns = $this->db->query("SELECT id FROM `order_prize_campaigns` WHERE `status` = 'active'")->result_array();
        $campaignIds = array_column($campaigns, 'id');

        $insertedIds = [];
        foreach ($samplePrizes as $p) {
            $exists = $this->db->query("SELECT id FROM `order_prize_items` WHERE `name` = ? LIMIT 1", [$p['name']])->row();
            if ($exists) {
                $pId = (int)$exists->id;
            } else {
                $insertData = $p;
                $insertData['created_by'] = !empty($userId) ? (int)$userId : null;
                $insertData['campaign_id'] = !empty($campaignIds) ? (int)$campaignIds[0] : 0;
                $insertData['awarded_count'] = 0;
                $insertData['created_at'] = $now;
                $insertData['updated_at'] = $now;

                $this->db->insert('order_prize_items', $insertData);
                $pId = (int)$this->db->insert_id();
            }

            $insertedIds[] = $pId;

            if (!empty($campaignIds) && $pId > 0) {
                foreach ($campaignIds as $cId) {
                    $this->db->query("INSERT IGNORE INTO `order_prize_campaign_prizes` (`campaign_id`, `prize_id`, `created_at`) VALUES (?, ?, ?)",
                        [(int)$cId, $pId, $now]);
                }
            }
        }

        return $insertedIds;
    }

    private function q($sql, array $params = [])
    {
        $result = $this->db->query($sql, $params);
        if ($result === false) {
            $error = $this->db->error();
            if ((int)$error['code'] === 1062) throw new Order_prize_error('Data sudah ada. Muat ulang sebelum mencoba lagi.', 409);
            log_message('error', 'Order Prizes database error code: ' . $error['code'] . ' message: ' . $error['message']);
            throw new RuntimeException('Order Prizes database operation failed: ' . ($error['message'] ?? 'Unknown SQL error') . ' (Code: ' . ($error['code'] ?? '0') . ')');
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
            'entity_id'=>$id, 'detail_json'=>json_encode($detail, JSON_UNESCAPED_UNICODE), 'created_at'=>$this->now()]);
    }

    private function active(array $c)
    {
        $now = $this->now();
        if ($c['status'] !== 'active' || $now < $c['starts_at'] || $now > $c['ends_at']) throw new Order_prize_error('Campaign tidak sedang berlangsung.', 409);
    }

    public function get_campaign_prizes($campaignId)
    {
        $campaignId = (int)$campaignId;
        $sql = "SELECT DISTINCT p.* FROM order_prize_items p
                LEFT JOIN order_prize_campaign_prizes cp ON cp.prize_id = p.id
                WHERE (cp.campaign_id = ? OR p.campaign_id = ?)
                ORDER BY p.id ASC";
        return $this->q($sql, [$campaignId, $campaignId])->result_array();
    }

    public function get_campaign_prize_ids($campaignId)
    {
        $prizes = $this->get_campaign_prizes($campaignId);
        return array_map('intval', array_column($prizes, 'id'));
    }

    public function get_prize_campaign_ids($prizeId)
    {
        $prizeId = (int)$prizeId;
        $sql = "SELECT campaign_id FROM order_prize_campaign_prizes WHERE prize_id = ?";
        $rows = $this->q($sql, [$prizeId])->result_array();
        $ids = array_map('intval', array_column($rows, 'campaign_id'));
        if (empty($ids)) {
            $p = $this->row('order_prize_items', $prizeId);
            if (!empty($p['campaign_id'])) $ids[] = (int)$p['campaign_id'];
        }
        return array_values(array_unique($ids));
    }

    public function get_prize_campaigns($prizeId)
    {
        $prizeId = (int)$prizeId;
        $sql = "SELECT c.id, c.name, c.channel FROM order_prize_campaigns c
                JOIN order_prize_campaign_prizes cp ON cp.campaign_id = c.id
                WHERE cp.prize_id = ?
                ORDER BY c.id ASC";
        $list = $this->q($sql, [$prizeId])->result_array();
        if (empty($list)) {
            $p = $this->row('order_prize_items', $prizeId);
            if (!empty($p['campaign_id'])) {
                $c = $this->q("SELECT id, name, channel FROM order_prize_campaigns WHERE id = ?", [$p['campaign_id']])->row_array();
                if ($c) $list[] = $c;
            }
        }
        return $list;
    }

    public function sync_campaign_prizes($campaignId, array $prizeIds)
    {
        $campaignId = (int)$campaignId;
        $this->q("DELETE FROM order_prize_campaign_prizes WHERE campaign_id = ?", [$campaignId]);
        $now = $this->now();
        foreach ($prizeIds as $pId) {
            $pId = (int)$pId;
            if ($pId > 0) {
                $this->q("INSERT IGNORE INTO order_prize_campaign_prizes (campaign_id, prize_id, created_at) VALUES (?, ?, ?)",
                    [$campaignId, $pId, $now]);
            }
        }
    }

    public function sync_prize_campaigns($prizeId, array $campaignIds)
    {
        $prizeId = (int)$prizeId;
        $this->q("DELETE FROM order_prize_campaign_prizes WHERE prize_id = ?", [$prizeId]);
        $now = $this->now();
        foreach ($campaignIds as $cId) {
            $cId = (int)$cId;
            if ($cId > 0) {
                $this->q("INSERT IGNORE INTO order_prize_campaign_prizes (campaign_id, prize_id, created_at) VALUES (?, ?, ?)",
                    [$cId, $prizeId, $now]);
            }
        }
    }

    private function require_fallback($campaignId)
    {
        foreach ($this->get_campaign_prizes($campaignId) as $p) {
            if (Order_prize_rules::fallback($p)) return;
        }
        // Link existing master fallback prize if one exists
        $fallback = $this->q("SELECT id FROM order_prize_items WHERE kind = 'none' AND cost = 0 LIMIT 1")->row_array();
        if ($fallback) {
            $this->q("INSERT IGNORE INTO order_prize_campaign_prizes (campaign_id, prize_id, created_at) VALUES (?, ?, ?)",
                [$campaignId, $fallback['id'], $this->now()]);
            return;
        }
        $fbId = $this->insert('order_prize_items', [
            'campaign_id' => $campaignId,
            'name' => 'Belum Beruntung (Coba Lagi)',
            'description' => 'Terima kasih telah berbelanja dan berpartisipasi dalam undian pesanan.',
            'kind' => 'none',
            'active' => 1,
            'weight' => 50,
            'stock' => null,
            'cost' => 0,
            'threshold_spins' => 0,
            'threshold_revenue' => 0,
            'threshold_profit' => 0,
            'auto_metric' => 'none',
            'allocation_percent' => 10,
            'awarded_count' => 0,
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ]);
        $this->q("INSERT IGNORE INTO order_prize_campaign_prizes (campaign_id, prize_id, created_at) VALUES (?, ?, ?)",
            [$campaignId, $fbId, $this->now()]);
    }

    public function get_seller_tiktok_shops($userId = null, $isAdmin = false)
    {
        if (!$this->db->table_exists('tiktok_shops')) {
            return [];
        }

        // Determine tenant ID to enforce multi-tenant isolation
        $tenantId = null;
        if (function_exists('get_active_tenant_id')) {
            $tenantId = get_active_tenant_id();
        }
        if (empty($tenantId) && !empty($userId) && $this->db->field_exists('tenant_id', 'aauth_users')) {
            $u = $this->db->select('tenant_id')->where('id', (int)$userId)->get('aauth_users')->row();
            if ($u && !empty($u->tenant_id)) {
                $tenantId = (int)$u->tenant_id;
            }
        }

        // Only query ACTIVE shops that have a valid authorization / access token
        $this->db->select('*')
            ->from('tiktok_shops')
            ->where('is_active', 1)
            ->where('access_token IS NOT NULL', null, false)
            ->where('access_token !=', '');

        if (!empty($tenantId) && $this->db->field_exists('tenant_id', 'tiktok_shops')) {
            $this->db->where('tenant_id', (int)$tenantId);
        } elseif (!empty($userId) && $this->db->field_exists('created_by', 'tiktok_shops')) {
            $this->db->where('created_by', (int)$userId);
        }

        return $this->db->order_by('shop_name', 'ASC')->get()->result_array();
    }

    public function save_campaign(array $input, $id, $actor)
    {
        return $this->transaction(function () use ($input, $id, $actor) {
            $old = $id ? $this->row('order_prize_campaigns', $id, true) : [];
            $data = Order_prize_rules::campaign(array_merge($old, $input));
            if ($id) {
                if (!empty($actor) && !empty($old['created_by']) && (int)$old['created_by'] !== (int)$actor && !$this->aauth->is_admin((int)$actor)) {
                    throw new Order_prize_error('Tidak memiliki akses ke campaign ini.', 403);
                }
                $used = $this->q('SELECT id FROM order_prize_orders WHERE campaign_id = ? LIMIT 1', [$id])->row_array();
                foreach (['slug','channel','shop_ref'] as $field) {
                    if ($used && $data[$field] !== $old[$field]) throw new Order_prize_error('Identitas campaign tidak bisa diubah setelah ada order.', 409);
                }
            } else {
                $data['created_by'] = !empty($actor) ? (int)$actor : null;
            }

            // Validasi koneksi toko TikTok jika channel TikTok dipilih
            if ($data['channel'] === 'tiktok') {
                $connectedShops = $this->get_seller_tiktok_shops($actor);
                if (empty($connectedShops)) {
                    throw new Order_prize_error('Belum ada akun toko TikTok yang terhubung. Hubungkan toko terlebih dahulu di menu Akun Toko.');
                }
                if ($data['shop_ref'] !== 'all') {
                    $shopNames = array_column($connectedShops, 'shop_name');
                    if (!in_array($data['shop_ref'], $shopNames, true)) {
                        throw new Order_prize_error('Toko TikTok yang dipilih tidak valid atau belum terhubung.');
                    }
                }
            }
            $data['updated_at'] = $this->now();
            if ($id) $this->update('order_prize_campaigns', $id, $data);
            else $id = $this->insert('order_prize_campaigns', $data + ['created_at'=>$this->now()]);

            // Sync prizes linked to this campaign
            if (isset($input['prize_ids']) && is_array($input['prize_ids'])) {
                $this->sync_campaign_prizes($id, array_map('intval', $input['prize_ids']));
            } elseif (!$id || empty($old)) {
                // Auto-link active master prizes belonging to this seller or global fallback
                $allActive = $this->q("SELECT id FROM order_prize_items WHERE active = 1 AND (created_by = ? OR created_by IS NULL)", [!empty($actor) ? (int)$actor : 0])->result_array();
                if (!empty($allActive)) {
                    $this->sync_campaign_prizes($id, array_column($allActive, 'id'));
                }
            }

            if ($data['status'] === 'active') $this->require_fallback($id);
            $this->audit($actor, 'campaign.save', 'campaigns', $id, ['before'=>$old, 'after'=>$data]);
            return $this->row('order_prize_campaigns', $id);
        });
    }

    public function save_prize(array $input, $id, $actor)
    {
        return $this->transaction(function () use ($input, $id, $actor) {
            $old = $id ? $this->row('order_prize_items', $id, true) : [];

            if ($id) {
                if (!empty($actor) && !empty($old['created_by']) && (int)$old['created_by'] !== (int)$actor && !$this->aauth->is_admin((int)$actor)) {
                    throw new Order_prize_error('Tidak memiliki akses ke hadiah ini.', 403);
                }
            } else {
                $data['created_by'] = !empty($actor) ? (int)$actor : null;
            }

            // Campaign IDs can be passed as array campaign_ids or single campaign_id
            $campaignIds = [];
            if (!empty($input['campaign_ids']) && is_array($input['campaign_ids'])) {
                $campaignIds = array_filter(array_map('intval', $input['campaign_ids']));
            } elseif (!empty($input['campaign_id'])) {
                $campaignIds = [(int)$input['campaign_id']];
            }
            $primaryCampaignId = !empty($campaignIds) ? reset($campaignIds) : (int)($old['campaign_id'] ?? 0);

            $data = Order_prize_rules::prize(array_merge($old, $input, ['campaign_id' => $primaryCampaignId]));
            if (!$id && !empty($actor)) {
                $data['created_by'] = (int)$actor;
            }
            $data['updated_at'] = $this->now();
            if ($id) {
                $this->update('order_prize_items', $id, $data);
            } else {
                $id = $this->insert('order_prize_items', $data + ['created_at'=>$this->now()]);
            }

            // Sync with order_prize_campaign_prizes
            if (!empty($campaignIds)) {
                $this->sync_prize_campaigns($id, $campaignIds);
            }

            $this->audit($actor, 'prize.save', 'prizes', $id, ['before'=>$old, 'after'=>$data, 'campaigns'=>$campaignIds]);
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

    public function sync_tiktok_orders($campaignId, $actor = null)
    {
        return $this->transaction(function () use ($campaignId, $actor) {
            $c = $this->row('order_prize_campaigns', $campaignId, true);
            if (!$this->db->table_exists('tiktok_orders')) {
                throw new Order_prize_error('Modul TikTok Orders tidak ditemukan di database.');
            }

            // Find allowed shops for this tenant/user
            $allowedShops = $this->get_seller_tiktok_shops(!empty($c['created_by']) ? $c['created_by'] : $actor);
            $allowedShopIds = array_column($allowedShops, 'id');
            if (empty($allowedShopIds)) {
                return ['synced' => 0, 'total_candidates' => 0, 'message' => 'Tidak ada akun toko TikTok yang terhubung.'];
            }

            // Find shop condition if shop_ref specified and not all
            $shopId = null;
            if (!empty($c['shop_ref']) && !in_array(strtolower($c['shop_ref']), ['all', 'semua toko', 'default', ''], true)) {
                if ($this->db->table_exists('tiktok_shops')) {
                    $shop = $this->db->group_start()
                        ->where('shop_name', $c['shop_ref'])
                        ->or_where('shop_code', $c['shop_ref'])
                        ->or_where('shop_id', $c['shop_ref'])
                        ->group_end()
                        ->where_in('id', $allowedShopIds)
                        ->get('tiktok_shops')
                        ->row_array();
                    if ($shop) {
                        $shopId = $shop['id'];
                    }
                }
            }

            $this->db->from('tiktok_orders');
            if ($shopId) {
                $this->db->where('tiktok_shop_id', $shopId);
            } else {
                $this->db->where_in('tiktok_shop_id', $allowedShopIds);
            }
            $this->db->where_in('order_status', ['COMPLETED', 'DELIVERED', 'SHIPPED', 'IN_TRANSIT', 'AWAITING_COLLECTION']);
            $this->db->where('recipient_phone IS NOT NULL');
            $this->db->where('recipient_phone !=', '');

            if (!empty($c['starts_at'])) {
                $this->db->where('order_created_time >=', $c['starts_at']);
            }
            if (!empty($c['ends_at'])) {
                $this->db->where('order_created_time <=', $c['ends_at']);
            }

            $orders = $this->db->get()->result_array();
            $synced = 0;
            $now = $this->now();

            foreach ($orders as $tOrder) {
                $rawPhone = trim($tOrder['recipient_phone'] ?? '');
                try {
                    $phone = Order_prize_rules::phone($rawPhone);
                } catch (Throwable $e) {
                    continue;
                }

                $orderNumber = strtoupper(trim($tOrder['order_id']));
                if (strlen($orderNumber) < 4) continue;

                $exists = $this->q('SELECT id FROM order_prize_orders WHERE campaign_id = ? AND order_number = ?', [$c['id'], $orderNumber])->row_array();
                if ($exists) continue;

                $orderData = [
                    'campaign_id' => (int)$c['id'],
                    'channel' => 'tiktok',
                    'shop_ref' => $c['shop_ref'] ?: 'TIKTOK',
                    'order_number' => $orderNumber,
                    'phone' => $phone,
                    'status' => in_array($tOrder['order_status'], ['COMPLETED', 'DELIVERED'], true) ? 'completed' : 'paid',
                    'revenue' => (int)round($tOrder['total_amount'] ?? 0),
                    'profit' => null,
                    'ordered_at' => $tOrder['order_created_time'] ?: $now,
                    'source' => 'tiktok_sync',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $this->insert('order_prize_orders', $orderData);
                $synced++;
            }

            $this->audit($actor, 'orders.tiktok_sync', 'campaigns', $c['id'], [
                'synced_count' => $synced,
                'total_candidates' => count($orders),
            ]);

            return ['synced' => $synced, 'total_candidates' => count($orders)];
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
            'prizes'=>$this->q('SELECT DISTINCT p.id, p.name, p.description, p.kind FROM order_prize_items p LEFT JOIN order_prize_campaign_prizes cp ON cp.prize_id = p.id WHERE (cp.campaign_id = ? OR p.campaign_id = ?) AND p.active = 1 ORDER BY p.id ASC', [$c['id'], $c['id']])->result_array()];
    }

    public function verify($slug, $number, $phone, $consent)
    {
        $number = Order_prize_rules::order_number($number);
        $phone = Order_prize_rules::phone($phone);
        $consent = Order_prize_rules::integer($consent, 'Persetujuan marketing', 0, 1);
        $this->rate_limit('order', $slug . ':' . $number, 10);
        return $this->transaction(function () use ($slug, $number, $phone, $consent) {
            $c = $this->q('SELECT * FROM order_prize_campaigns WHERE slug = ? FOR UPDATE', [$slug])->row_array();
            if (!$c) throw new Order_prize_error('Campaign tidak ditemukan.', 404);
            $this->active($c);

            // 1. Cari apakah nomor pesanan ini pernah terdaftar di database (pada campaign manapun)
            $o = $this->q('SELECT * FROM order_prize_orders WHERE order_number = ? FOR UPDATE', [$number])->row_array();

            // 2. Cek apakah nomor pesanan ini SUDAH PERNAH MEMUTAR SPIN
            $spin = null;
            if ($o) {
                $spin = $this->q('SELECT * FROM order_prize_spins WHERE order_id = ?', [$o['id']])->row_array();
            }
            if (!$spin) {
                $spin = $this->q('SELECT * FROM order_prize_spins WHERE order_number = ?', [$number])->row_array();
            }

            // KASUS A: SUDAH PERNAH MEMUTAR UNDIAN (STATUS: SUDAH SPIN)
            if ($spin) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + 1800);
                $orderId = $o ? (int)$o['id'] : (int)$spin['order_id'];
                if ($orderId > 0) {
                    $this->q('INSERT INTO order_prize_tokens (order_id,token_hash,expires_at,marketing_consent,consent_at,created_at) VALUES (?,?,?,?,?,?)
                        ON DUPLICATE KEY UPDATE token_hash=VALUES(token_hash),expires_at=VALUES(expires_at),marketing_consent=VALUES(marketing_consent),consent_at=VALUES(consent_at)',
                        [$orderId, hash('sha256', $token), $expires, $consent, $consent ? $this->now() : null, $this->now()]);
                    if ((int)$spin['marketing_consent'] !== $consent) {
                        $this->update('order_prize_spins', $spin['id'], ['marketing_consent'=>$consent, 'updated_at'=>$this->now()]);
                    }
                }
                return [
                    'token' => $token,
                    'expires_at' => $expires,
                    'already_spun' => true,
                    'message' => 'Anda sudah memutar undian untuk pesanan ini.',
                    'result' => $this->public_result($spin)
                ];
            }

            // KASUS B: BELUM PERNAH SPIN ATAU RIWAYAT SPIN TELAH DI-RESET!
            // Jika order sudah ada di database (misal dari campaign lain atau sesi sebelumnya),
            // perbarui ke campaign saat ini dan perbarui nomor HP pembeli agar langsung bisa spin!
            if ($o) {
                $this->update('order_prize_orders', $o['id'], [
                    'campaign_id' => $c['id'],
                    'phone' => $phone,
                    'status' => 'completed',
                    'updated_at' => $this->now()
                ]);
                $o = $this->row('order_prize_orders', $o['id']);
            } else {
                // Auto-Discovery dari TikTok Orders jika tabel tiktok_orders ada
                if ($this->db->table_exists('tiktok_orders')) {
                    $o = $this->auto_discover_tiktok_order($c, $number, $phone);
                }

                // Jika belum ada di order_prize_orders, auto-registrasi on-the-fly!
                if (!$o) {
                    $o = $this->auto_register_customer_order($c, $number, $phone);
                }
            }

            if (!$o) {
                throw new Order_prize_error('Gagal memverifikasi data pesanan. Silakan periksa kembali nomor pesanan Anda.', 422);
            }

            // Validasi kelayakan pesanan (status, retur, batal, dsb.)
            $this->eligible_order($o, $c);

            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 1800);
            $this->q('INSERT INTO order_prize_tokens (order_id,token_hash,expires_at,marketing_consent,consent_at,created_at) VALUES (?,?,?,?,?,?)
                ON DUPLICATE KEY UPDATE token_hash=VALUES(token_hash),expires_at=VALUES(expires_at),marketing_consent=VALUES(marketing_consent),consent_at=VALUES(consent_at)',
                [$o['id'], hash('sha256', $token), $expires, $consent, $consent ? $this->now() : null, $this->now()]);

            $this->audit(null, 'order.verify', 'orders', $o['id'], ['marketing_consent'=>$consent, 'terms_sha256'=>hash('sha256', $c['terms'])]);
            return ['token'=>$token, 'expires_at'=>$expires, 'already_spun'=>false, 'result'=>null];
        });
    }

    private function auto_discover_tiktok_order(array $c, $number, $phone)
    {
        $allowedShops = $this->get_seller_tiktok_shops(!empty($c['created_by']) ? $c['created_by'] : null);
        $allowedShopIds = array_column($allowedShops, 'id');
        if (empty($allowedShopIds)) return null;

        $this->db->from('tiktok_orders')
            ->where('order_id', $number)
            ->where_in('tiktok_shop_id', $allowedShopIds);

        $tOrder = $this->db->get()->row_array();
        if (!$tOrder) return null;

        $now = $this->now();
        $tiktokStatus = strtoupper($tOrder['order_status'] ?? '');
        $hasReturn = false;
        if ($this->db->table_exists('tiktok_returns')) {
            $hasReturn = ($this->db->where('order_id', $number)->count_all_results('tiktok_returns') > 0);
        }

        if ($hasReturn) {
            $orderStatus = 'returned';
        } elseif (in_array($tiktokStatus, ['CANCELLED', 'CANCELED', 'IN_CANCEL'], true)) {
            $orderStatus = 'cancelled';
        } elseif (in_array($tiktokStatus, ['COMPLETED', 'DELIVERED'], true)) {
            $orderStatus = 'completed';
        } elseif (in_array($tiktokStatus, ['AWAITING_SHIPMENT', 'AWAITING_COLLECTION', 'IN_TRANSIT'], true)) {
            $orderStatus = 'paid';
        } else {
            $orderStatus = 'unpaid';
        }

        $orderData = [
            'campaign_id' => (int)$c['id'],
            'channel' => 'tiktok',
            'shop_ref' => !empty($tOrder['tiktok_shop_id']) ? (string)$tOrder['tiktok_shop_id'] : ($c['shop_ref'] ?: 'TIKTOK'),
            'order_number' => $number,
            'phone' => $phone,
            'status' => $orderStatus,
            'revenue' => (int)round($tOrder['total_amount'] ?? 50000),
            'profit' => null,
            'ordered_at' => !empty($tOrder['order_created_time']) ? $tOrder['order_created_time'] : $now,
            'source' => 'tiktok_auto',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        try {
            $id = $this->insert('order_prize_orders', $orderData);
            return $this->q('SELECT * FROM order_prize_orders WHERE id = ?', [$id])->row_array();
        } catch (Throwable $e) {
            return $this->q('SELECT * FROM order_prize_orders WHERE order_number = ?', [$number])->row_array();
        }
    }

    private function auto_register_customer_order(array $c, $number, $phone)
    {
        $now = $this->now();
        $orderData = [
            'campaign_id' => (int)$c['id'],
            'channel' => $c['channel'] ?: 'shopee',
            'shop_ref' => $c['shop_ref'] ?: 'DEFAULT',
            'order_number' => $number,
            'phone' => $phone,
            'status' => 'completed',
            'revenue' => 50000,
            'profit' => null,
            'ordered_at' => $now,
            'source' => 'customer_auto',
            'created_at' => $now,
            'updated_at' => $now,
        ];

        try {
            $id = $this->insert('order_prize_orders', $orderData);
            return $this->q('SELECT * FROM order_prize_orders WHERE id = ?', [$id])->row_array();
        } catch (Throwable $e) {
            return $this->q('SELECT * FROM order_prize_orders WHERE order_number = ?', [$number])->row_array();
        }
    }

    private function eligible_order(array $o, array $c)
    {
        if ($o['status'] === 'cancelled') {
            throw new Order_prize_error('Pesanan ini telah dibatalkan dan tidak berhak mengikuti undian.', 422);
        }
        if ($o['status'] === 'returned') {
            throw new Order_prize_error('Pesanan ini dalam status retur/pengembalian dan tidak berhak mengikuti undian.', 422);
        }
        if ($o['status'] === 'unpaid') {
            throw new Order_prize_error('Pesanan belum dibayar.', 422);
        }
        if (!in_array($o['status'], ['paid','completed'], true)) {
            throw new Order_prize_error('Status order belum selesai/lunas (' . $o['status'] . ').', 422);
        }
        if ($o['ordered_at'] > $c['ends_at']) {
            throw new Order_prize_error('Waktu transaksi pesanan melewati batas akhir campaign (' . date('d M Y', strtotime($c['ends_at'])) . ').', 422);
        }
        // Batas waktu kesempatan spin maksimal N hari sejak pesanan
        $claimDays = (int)($c['claim_days'] ?? 0);
        if ($claimDays > 0) {
            $orderTime = strtotime($o['ordered_at']);
            $expireTime = $orderTime + ($claimDays * 86400);
            if (time() > $expireTime) {
                $tglBatas = date('d M Y H:i', $expireTime);
                throw new Order_prize_error("Kesempatan spin untuk pesanan ini telah hangus (Batas maksimal {$claimDays} hari setelah pesanan: s/d {$tglBatas}).", 422);
            }
        } elseif ($o['ordered_at'] < $c['starts_at']) {
            throw new Order_prize_error('Waktu transaksi pesanan berada sebelum periode campaign (' . date('d M Y', strtotime($c['starts_at'])) . ').', 422);
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
            $prizes = $this->q('SELECT DISTINCT p.* FROM order_prize_items p LEFT JOIN order_prize_campaign_prizes cp ON cp.prize_id = p.id WHERE (cp.campaign_id = ? OR p.campaign_id = ?) ORDER BY p.id ASC FOR UPDATE', [$c['id'], $c['id']])->result_array();
            $eligible = array_values(array_filter($prizes, function ($p) use ($totals, $c) { return Order_prize_rules::eligible($p, $totals, $c['budget_profit_percent']); }));
            $winner = Order_prize_rules::draw($eligible);
            $decision = ['totals'=>$totals, 'budget_profit_percent'=>$c['budget_profit_percent'], 'eligible_weights'=>[], 'winner_rules'=>$winner];
            foreach ($eligible as $p) $decision['eligible_weights'][$p['id']] = (int)$p['weight'];
            $none = $winner['kind'] === 'none';
            $now = $this->now();
            $id = $this->insert('order_prize_spins', [
                'campaign_id'=>$c['id'], 'order_id'=>$o['id'], 'token_id'=>$t['id'], 'prize_id'=>$winner['id'],
                'order_number'=>$o['order_number'], 'phone'=>$o['phone'], 'prize_name'=>$winner['name'],
                'prize_kind'=>$winner['kind'], 'prize_cost'=>$winner['cost'], 'spin_type'=>'order',
                'claim_status'=>$none ? 'not_required' : 'claimed', // Sudah spin = sudah klaim otomatis!
                'prize_status'=>$none ? 'not_required' : 'reserved',
                'follow_up_status'=>$none ? 'closed' : 'pending', 'broadcast_status'=>'not_sent',
                'marketing_consent'=>$t['marketing_consent'], 'notes'=>'',
                'decision_json'=>json_encode($decision, JSON_UNESCAPED_UNICODE),
                'spun_at'=>$now, 'claim_deadline'=>$now, 'claimed_at'=>$none ? null : $now, 'updated_at'=>$now,
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

    public function listing($entity, array $filters, $userId = null, $isAdmin = false)
    {
        if (!isset($this->tables[$entity])) throw new Order_prize_error('Modul tidak ditemukan.', 404);
        $table = $this->tables[$entity];
        $where = ['1=1']; $params = [];
        $page = Order_prize_rules::integer((int)($filters['page'] ?? 1), 'Halaman', 1, 1000000);
        $limit = Order_prize_rules::integer((int)($filters['limit'] ?? 20), 'Limit', 1, 100);
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
            $search_all = [
                'campaigns' => ['name', 'slug', 'channel'],
                'prizes'    => ['name', 'kind'],
                'orders'    => ['order_number', 'phone'],
                'spins'     => ['order_number', 'phone', 'prize_name'],
                'audit'     => ['action']
            ][$entity] ?? ['id'];
            $selected_f = !empty($filters['f']) ? trim((string)$filters['f']) : '';
            $search = ($selected_f !== '' && in_array($selected_f, $search_all, true)) ? [$selected_f] : $search_all;
            $parts = [];
            foreach ($search as $field) {
                $parts[] = '`' . $field . '` LIKE ?';
                $params[] = '%' . $this->db->escape_like_str(Order_prize_rules::text($filters['q'], 'Pencarian', 100)) . '%';
            }
            $where[] = '(' . implode(" ESCAPE '!' OR ", $parts) . " ESCAPE '!')";
        }

        // Multi-Seller Scope Isolation
        if (!$isAdmin && !empty($userId)) {
            if ($entity === 'campaigns') {
                $where[] = "(`created_by` = ? OR `created_by` IS NULL)";
                $params[] = (int)$userId;
            } elseif ($entity === 'prizes') {
                $where[] = "(`created_by` = ? OR `created_by` IS NULL)";
                $params[] = (int)$userId;
            } elseif ($entity === 'orders' || $entity === 'spins') {
                $where[] = "`campaign_id` IN (SELECT `id` FROM `order_prize_campaigns` WHERE `created_by` = ? OR `created_by` IS NULL)";
                $params[] = (int)$userId;
            } elseif ($entity === 'audit') {
                $where[] = "(`actor_id` = ? OR `actor_id` IS NULL)";
                $params[] = (int)$userId;
            }
        }

        $where = implode(' AND ', $where);
        $total = (int)$this->q('SELECT COUNT(*) n FROM ' . $table . ' WHERE ' . $where, $params)->row()->n;
        $rows = $this->q('SELECT * FROM ' . $table . ' WHERE ' . $where . ' ORDER BY id DESC LIMIT ' . $limit . ' OFFSET ' . (($page - 1) * $limit), $params)->result_array();
        if ($entity === 'spins') $rows = array_map([$this, 'effective_spin'], $rows);
        if ($entity === 'prizes') {
            foreach ($rows as &$r) {
                $r['campaigns'] = $this->get_prize_campaigns($r['id']);
            }
            unset($r);
        }
        return ['items'=>$rows, 'total'=>$total, 'page'=>$page, 'limit'=>$limit];
    }

    public function get_row($entity, $id)
    {
        $table = $this->tables[$entity] ?? $entity;
        return $this->row($table, $id);
    }

    public function get_order_detail($id, $userId = null, $isAdmin = false)
    {
        $id = (int)$id;
        $order = $this->row('order_prize_orders', $id);
        $campaign = null;
        if (!empty($order['campaign_id'])) {
            $campaign = $this->db->get_where('order_prize_campaigns', ['id' => (int)$order['campaign_id']])->row_array();
            if (!$isAdmin && !empty($userId) && !empty($campaign['created_by']) && (int)$campaign['created_by'] !== (int)$userId) {
                throw new Order_prize_error('Anda tidak memiliki akses ke pesanan ini.', 403);
            }
        }
        $spin = $this->db->get_where('order_prize_spins', ['order_id' => $id])->row_array();
        $token = $this->db->get_where('order_prize_tokens', ['order_id' => $id])->row_array();
        return [
            'order' => $order,
            'campaign' => $campaign,
            'spin' => $spin,
            'token' => $token,
        ];
    }

    public function get_campaigns_dropdown($userId = null, $isAdmin = false)
    {
        if ($isAdmin || empty($userId)) {
            return $this->q('SELECT id, name, slug, status, channel, shop_ref FROM order_prize_campaigns ORDER BY id DESC')->result_array();
        }
        return $this->q('SELECT id, name, slug, status, channel, shop_ref FROM order_prize_campaigns WHERE created_by = ? OR created_by IS NULL ORDER BY id DESC', [(int)$userId])->result_array();
    }

    public function get_summary_stats($userId = null, $isAdmin = false)
    {
        try {
            $wCampaign = "1=1";
            $pCampaign = [];
            $wPrize = "1=1";
            $pPrize = [];
            $wOrder = "1=1";
            $pOrder = [];

            if (!$isAdmin && !empty($userId)) {
                $wCampaign = "(created_by = ? OR created_by IS NULL)";
                $pCampaign = [(int)$userId];
                $wPrize = "(created_by = ? OR created_by IS NULL)";
                $pPrize = [(int)$userId];
                $wOrder = "campaign_id IN (SELECT id FROM order_prize_campaigns WHERE created_by = ? OR created_by IS NULL)";
                $pOrder = [(int)$userId];
            }

            $total_c = (int)$this->q("SELECT COUNT(*) n FROM order_prize_campaigns WHERE {$wCampaign}", $pCampaign)->row()->n;
            $active_c = (int)$this->q("SELECT COUNT(*) n FROM order_prize_campaigns WHERE status = 'active' AND {$wCampaign}", $pCampaign)->row()->n;
            $total_p = (int)$this->q("SELECT COUNT(*) n FROM order_prize_items WHERE {$wPrize}", $pPrize)->row()->n;
            $total_o = (int)$this->q("SELECT COUNT(*) n FROM order_prize_orders WHERE {$wOrder}", $pOrder)->row()->n;
            $total_s = (int)$this->q("SELECT COUNT(*) n FROM order_prize_spins WHERE {$wOrder}", $pOrder)->row()->n;
            $metric = $this->q("SELECT COALESCE(SUM(revenue_total),0) rev, COALESCE(SUM(profit_total),0) prof, COALESCE(SUM(awarded_cost),0) cost FROM order_prize_campaigns WHERE {$wCampaign}", $pCampaign)->row();
            return [
                'total_campaigns' => $total_c,
                'active_campaigns' => $active_c,
                'total_prizes' => $total_p,
                'total_orders' => $total_o,
                'total_spins' => $total_s,
                'total_revenue' => (int)($metric->rev ?? 0),
                'total_profit' => (int)($metric->prof ?? 0),
                'awarded_cost' => (int)($metric->cost ?? 0),
            ];
        } catch (Throwable $e) {
            return [
                'total_campaigns' => 0, 'active_campaigns' => 0, 'total_prizes' => 0,
                'total_orders' => 0, 'total_spins' => 0, 'total_revenue' => 0, 'total_profit' => 0, 'awarded_cost' => 0,
            ];
        }
    }

    public function get_active_campaigns_public()
    {
        $now = $this->now();
        return $this->q("SELECT id, slug, name, channel, shop_ref, starts_at, ends_at FROM order_prize_campaigns WHERE status = 'active' AND starts_at <= ? AND ends_at >= ? ORDER BY id DESC", [$now, $now])->result_array();
    }

    public function delete_record($entity, $id, $actor)
    {
        $id = (int)$id;
        if (!isset($this->tables[$entity])) throw new Order_prize_error('Modul tidak ditemukan.', 404);
        $table = $this->tables[$entity];
        $old = $this->row($table, $id);
        
        return $this->transaction(function () use ($entity, $table, $id, $old, $actor) {
            if (!empty($actor) && !$this->aauth->is_admin((int)$actor)) {
                if ($entity === 'campaigns' || $entity === 'prizes') {
                    if (isset($old['created_by']) && !empty($old['created_by']) && (int)$old['created_by'] !== (int)$actor) {
                        throw new Order_prize_error('Tidak memiliki izin menghapus data ini.', 403);
                    }
                } elseif ($entity === 'orders') {
                    $c = $this->row('order_prize_campaigns', $old['campaign_id']);
                    if (isset($c['created_by']) && !empty($c['created_by']) && (int)$c['created_by'] !== (int)$actor) {
                        throw new Order_prize_error('Tidak memiliki izin menghapus data ini.', 403);
                    }
                }
            }

            if ($entity === 'campaigns') {
                $has_orders = (int)$this->q('SELECT COUNT(*) n FROM order_prize_orders WHERE campaign_id = ?', [$id])->row()->n;
                if ($has_orders > 0) {
                    $this->update('order_prize_campaigns', $id, ['status'=>'ended', 'updated_at'=>$this->now()]);
                    $this->audit($actor, 'campaign.end', 'campaigns', $id, ['reason'=>'deactivated_has_orders']);
                    return ['deleted'=>false, 'message'=>'Campaign memiliki order terkait, status diubah menjadi Ended.'];
                }
                $this->q('DELETE FROM order_prize_campaign_prizes WHERE campaign_id = ?', [$id]);
                $this->q('DELETE FROM order_prize_campaigns WHERE id = ?', [$id]);
            } elseif ($entity === 'prizes') {
                $has_spins = (int)$this->q('SELECT COUNT(*) n FROM order_prize_spins WHERE prize_id = ?', [$id])->row()->n;
                if ($has_spins > 0) {
                    $this->update('order_prize_items', $id, ['active'=>0, 'updated_at'=>$this->now()]);
                    $this->audit($actor, 'prize.deactivate', 'prizes', $id, ['reason'=>'deactivated_has_spins']);
                    return ['deleted'=>false, 'message'=>'Hadiah sudah pernah dimenangkan, status diubah menjadi Non-Aktif.'];
                }
                $this->q('DELETE FROM order_prize_campaign_prizes WHERE prize_id = ?', [$id]);
                $this->q('DELETE FROM order_prize_items WHERE id = ?', [$id]);
            } elseif ($entity === 'orders') {
                $spun = (int)$this->q('SELECT COUNT(*) n FROM order_prize_spins WHERE order_id = ?', [$id])->row()->n;
                if ($spun > 0) throw new Order_prize_error('Order yang sudah melakukan spin tidak dapat dihapus.');
                $this->q('DELETE FROM order_prize_tokens WHERE order_id = ?', [$id]);
                $this->q('DELETE FROM order_prize_orders WHERE id = ?', [$id]);
            } elseif ($entity === 'spins') {
                $spin = $this->row('order_prize_spins', $id);
                $orderId = (int)$spin['order_id'];
                $campaignId = (int)$spin['campaign_id'];
                $prizeId = (int)$spin['prize_id'];

                // Kembalikan stok hadiah & kurangi counter statistik campaign
                $this->q('UPDATE order_prize_campaigns SET spin_count = GREATEST(0, spin_count - 1), awarded_cost = GREATEST(0, awarded_cost - ?), updated_at = ? WHERE id = ?', [(int)$spin['prize_cost'], $this->now(), $campaignId]);
                $this->q('UPDATE order_prize_items SET awarded_count = GREATEST(0, awarded_count - 1), stock = IF(stock IS NULL, NULL, stock + 1), updated_at = ? WHERE id = ?', [$this->now(), $prizeId]);

                // 1. Hapus riwayat spin terlebih dahulu (child row dengan FK ke token_id)
                $this->q('DELETE FROM order_prize_spins WHERE id = ?', [$id]);

                // 2. Baru kemudian hapus token terkait (parent row) agar tidak melanggar foreign key constraint
                if ($orderId > 0) {
                    $this->q('DELETE FROM order_prize_tokens WHERE order_id = ?', [$orderId]);
                }
                $this->audit($actor, 'spin.reset', 'spins', $id, ['before'=>$old, 'reason'=>'reset_for_testing']);
                return ['deleted'=>true, 'message'=>'Riwayat spin berhasil di-reset. Pesanan kini dapat memutar roda hadiah kembali!'];
            } else {
                throw new Order_prize_error('Penghapusan tidak diizinkan untuk entitas ini.');
            }
            $this->audit($actor, $entity . '.delete', $entity, $id, ['before'=>$old]);
            return ['deleted'=>true, 'message'=>'Data berhasil dihapus.'];
        });
    }
}

