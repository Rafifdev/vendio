<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tenant Helper for Vendio SaaS Multi-Tenancy
 */

if (!function_exists('get_active_tenant_id')) {
    /**
     * Get active tenant ID for current logged in user
     * 
     * @return int
     */
    function get_active_tenant_id() {
        static $cached_tenant_id = null;
        if ($cached_tenant_id !== null) {
            return $cached_tenant_id;
        }

        $ci =& get_instance();
        ensure_multi_tenancy_schema($ci);

        if (!$ci->load->is_loaded('session')) {
            $ci->load->library('session');
        }

        $session_tenant = $ci->session->userdata('tenant_id');
        if (!empty($session_tenant)) {
            $cached_tenant_id = (int) $session_tenant;
            return $cached_tenant_id;
        }

        $user_id = $ci->session->userdata('id');
        if ($user_id) {
            // Cek apakah kolom tenant_id ada di aauth_users sebelum query agar tidak error jika database belum diupdate
            $col = $ci->db->query("SHOW COLUMNS FROM `aauth_users` LIKE 'tenant_id'");
            if ($col && $col->num_rows() > 0) {
                $query = $ci->db->query("SELECT `tenant_id` FROM `aauth_users` WHERE `id` = ? LIMIT 1", [(int) $user_id]);
                if ($query && $user = $query->row()) {
                    if (!empty($user->tenant_id)) {
                        $ci->session->set_userdata('tenant_id', (int) $user->tenant_id);
                        $cached_tenant_id = (int) $user->tenant_id;
                        return $cached_tenant_id;
                    }
                }
            } else {
                // Tambahkan kolom tenant_id jika belum ada
                $ci->db->query("ALTER TABLE `aauth_users` ADD COLUMN `tenant_id` INT(11) DEFAULT 1 AFTER `id`");
            }
        }

        $cached_tenant_id = 1; // Default tenant fallback
        return $cached_tenant_id;
    }
}

if (!function_exists('ensure_multi_tenancy_schema')) {
    /**
     * Ensure tenants, plans, and tenant_id columns exist across all core tables.
     * Auto-creates or self-heals missing multi-tenant columns idempotently.
     */
    function ensure_multi_tenancy_schema($ci) {
        static $checked = false;
        if ($checked) {
            return;
        }
        $checked = true;

        // 1. Cek tabel tenants & plans
        $check = $ci->db->query("SHOW TABLES LIKE 'tenants'");
        if (!$check || $check->num_rows() == 0) {
            // Buat tabel plans
            $ci->db->query("CREATE TABLE IF NOT EXISTS `plans` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL,
                `code` varchar(50) NOT NULL,
                `description` text DEFAULT NULL,
                `price_monthly` decimal(12,2) NOT NULL DEFAULT 0.00,
                `discount_3_months` decimal(5,2) NOT NULL DEFAULT 0.00,
                `price_3_months` decimal(12,2) NOT NULL DEFAULT 0.00,
                `discount_6_months` decimal(5,2) NOT NULL DEFAULT 0.00,
                `price_6_months` decimal(12,2) NOT NULL DEFAULT 0.00,
                `discount_12_months` decimal(5,2) NOT NULL DEFAULT 0.00,
                `price_12_months` decimal(12,2) NOT NULL DEFAULT 0.00,
                `price_yearly` decimal(12,2) NOT NULL DEFAULT 0.00,
                `is_special` tinyint(1) NOT NULL DEFAULT 0,
                `special_badge` varchar(50) DEFAULT 'Paling Populer',
                `max_shops` int(11) NOT NULL DEFAULT 1,
                `max_users` int(11) NOT NULL DEFAULT 2,
                `max_warehouses` int(11) NOT NULL DEFAULT 1,
                `max_products` int(11) NOT NULL DEFAULT 0,
                `max_orders_per_month` int(11) NOT NULL DEFAULT 0,
                `features` text DEFAULT NULL,
                `status` enum('active','inactive') NOT NULL DEFAULT 'active',
                `sort_order` int(11) NOT NULL DEFAULT 0,
                `cta_text` varchar(50) NOT NULL DEFAULT 'Pilih Paket',
                `created_at` datetime NOT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $ci->db->query("INSERT IGNORE INTO `plans` (`id`, `name`, `code`, `description`, `price_monthly`, `max_shops`, `max_users`, `max_warehouses`, `status`, `sort_order`, `created_at`) VALUES
                (1, 'Starter / Free Trial', 'starter-free-trial', 'Pilihan tepat untuk UMKM pemula.', 149000.00, 2, 2, 1, 'active', 1, NOW()),
                (2, 'Growth / Pro', 'growth-pro', 'Solusi favorit bagi pebisnis berkembang.', 399000.00, 5, 10, 5, 'active', 2, NOW()),
                (3, 'Enterprise', 'enterprise', 'Kapasitas tanpa batas dan dukungan enterprise.', 999000.00, 999, 999, 999, 'active', 3, NOW())");

            // Buat tabel tenants
            $ci->db->query("CREATE TABLE IF NOT EXISTS `tenants` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `tenant_name` varchar(150) NOT NULL,
                `tenant_slug` varchar(150) NOT NULL,
                `owner_user_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
                `plan_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
                `status` enum('trial','active','expired','suspended') NOT NULL DEFAULT 'trial',
                `trial_ends_at` datetime DEFAULT NULL,
                `subscription_ends_at` datetime DEFAULT NULL,
                `phone` varchar(30) DEFAULT NULL,
                `address` text DEFAULT NULL,
                `created_at` datetime NOT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

            $ci->db->query("INSERT IGNORE INTO `tenants` (`id`, `tenant_name`, `tenant_slug`, `owner_user_id`, `plan_id`, `status`, `trial_ends_at`, `subscription_ends_at`, `created_at`) VALUES
                (1, 'Vendio HQ', 'vendio-hq', 1, 3, 'active', '2030-01-01 00:00:00', '2030-01-01 00:00:00', NOW())");
        }

        // 2. Daftar tabel yang harus memiliki kolom tenant_id untuk multi-tenancy
        $tables_to_ensure = [
            'aauth_users',
            'tiktok_shops',
            'tiktok_orders',
            'tiktok_order_items',
            'tiktok_order_price_details',
            'tiktok_order_status_logs',
            'tiktok_products',
            'tiktok_product_skus',
            'tiktok_finance',
            'tiktok_statement_transactions',
            'tiktok_settlements',
            'tiktok_unsettled_transactions',
            'tiktok_withdrawals',
            'tiktok_warehouses',
            'tiktok_returns',
            'tiktok_cancellations'
        ];

        // Ambil daftar kolom tenant_id yang sudah ada di database saat ini
        $tables_with_tenant = [];
        $col_query = $ci->db->query("SELECT LOWER(TABLE_NAME) as tbl FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'tenant_id'");
        if ($col_query && $col_query->num_rows() > 0) {
            foreach ($col_query->result() as $row) {
                $tables_with_tenant[$row->tbl] = true;
            }
        }

        // Ambil daftar tabel yang memang ada di database saat ini
        $tables_in_db = [];
        $tbl_query = $ci->db->query("SELECT LOWER(TABLE_NAME) as tbl FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE()");
        if ($tbl_query && $tbl_query->num_rows() > 0) {
            foreach ($tbl_query->result() as $row) {
                $tables_in_db[$row->tbl] = true;
            }
        }

        // Tambahkan kolom tenant_id jika tabel ada di DB tetapi belum memiliki kolom tenant_id
        foreach ($tables_to_ensure as $table) {
            $table_lower = strtolower($table);
            if (isset($tables_in_db[$table_lower]) && !isset($tables_with_tenant[$table_lower])) {
                $ci->db->query("ALTER TABLE `{$table}` ADD COLUMN `tenant_id` INT(10) UNSIGNED NOT NULL DEFAULT 1");
                $tables_with_tenant[$table_lower] = true;
            }
        }
    }
}

if (!function_exists('get_active_tenant')) {
    /**
     * Get full active tenant details including plan information
     * 
     * @return object|null
     */
    function get_active_tenant() {
        static $cached_tenant = null;
        if ($cached_tenant !== null) {
            return $cached_tenant;
        }

        $ci =& get_instance();
        $tenant_id = get_active_tenant_id();

        // Pastikan skema tabel multi-tenancy tersedia
        ensure_multi_tenancy_schema($ci);

        $check = $ci->db->query("SHOW TABLES LIKE 'tenants'");
        if (!$check || $check->num_rows() == 0) {
            // Fallback aman jika tabel tidak dapat dibuat
            $cached_tenant = (object)[
                'id' => (int) $tenant_id,
                'tenant_name' => 'Vendio HQ',
                'tenant_slug' => 'vendio-hq',
                'owner_user_id' => 1,
                'plan_id' => 3,
                'plan_name' => 'Enterprise',
                'plan_code' => 'enterprise',
                'status' => 'active',
                'trial_ends_at' => null,
                'subscription_ends_at' => null,
                'max_shops' => 999,
                'max_users' => 999,
                'max_warehouses' => 999
            ];
            return $cached_tenant;
        }

        // Gunakan raw query agar terisolasi dari query builder aktif
        $query = $ci->db->query(
            "SELECT `tenants`.*, `plans`.`name` AS `plan_name`, `plans`.`code` AS `plan_code`, 
                    `plans`.`max_shops`, `plans`.`max_users`, `plans`.`max_warehouses` 
             FROM `tenants` 
             LEFT JOIN `plans` ON `plans`.`id` = `tenants`.`plan_id` 
             WHERE `tenants`.`id` = ? 
             LIMIT 1",
            [(int) $tenant_id]
        );

        $cached_tenant = ($query && $query->num_rows() > 0) ? $query->row() : null;
        if (!$cached_tenant) {
            // Fallback default jika row tenant belum ada
            $cached_tenant = (object)[
                'id' => (int) $tenant_id,
                'tenant_name' => 'Vendio HQ',
                'tenant_slug' => 'vendio-hq',
                'owner_user_id' => 1,
                'plan_id' => 3,
                'plan_name' => 'Enterprise',
                'plan_code' => 'enterprise',
                'status' => 'active',
                'trial_ends_at' => null,
                'subscription_ends_at' => null,
                'max_shops' => 999,
                'max_users' => 999,
                'max_warehouses' => 999
            ];
        }
        return $cached_tenant;
    }
}

if (!function_exists('is_super_admin')) {
    /**
     * Check if current user is Super Admin (Platform Owner)
     * 
     * @return bool
     */
    function is_super_admin() {
        $ci =& get_instance();
        if (!isset($ci->aauth)) {
            $ci->load->library('aauth');
        }

        // Must be logged in
        if (!$ci->aauth->is_loggedin()) {
            return false;
        }

        // Group 1 in Cicool is "Admin"
        $user_id = $ci->session->userdata('id');
        if ($ci->aauth->is_admin($user_id)) {
            // If user is admin and belongs to default tenant HQ (1) or has superadmin flag
            $tenant_id = $ci->session->userdata('tenant_id');
            if (empty($tenant_id) || $tenant_id == 1) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('is_tenant_owner')) {
    /**
     * Check if current user is the owner of active tenant
     * 
     * @return bool
     */
    function is_tenant_owner() {
        $ci =& get_instance();
        $user_id = $ci->session->userdata('id');
        $tenant = get_active_tenant();

        if ($tenant && $tenant->owner_user_id == $user_id) {
            return true;
        }

        return is_super_admin();
    }
}

if (!function_exists('tenant_quota_check')) {
    /**
     * Check whether tenant has reached quota for a specific metric
     * 
     * @param string $metric 'shops' | 'users' | 'warehouses'
     * @return array ['allowed' => bool, 'current' => int, 'max' => int, 'message' => string]
     */
    function tenant_quota_check($metric = 'shops') {
        $ci =& get_instance();
        $tenant = get_active_tenant();
        $tenant_id = get_active_tenant_id();

        // Super admins have unlimited quota
        if (is_super_admin()) {
            return ['allowed' => true, 'current' => 0, 'max' => 999999, 'message' => 'Super Admin Unlimited'];
        }

        if (!$tenant) {
            return ['allowed' => false, 'current' => 0, 'max' => 0, 'message' => 'Tenant tidak ditemukan'];
        }

        // Check if tenant is expired
        if ($tenant->status == 'expired' || $tenant->status == 'suspended') {
            return [
                'allowed' => false,
                'current' => 0,
                'max' => 0,
                'message' => 'Masa aktif langganan akun Anda telah berakhir. Silakan perpanjang untuk melanjutkan.'
            ];
        }

        $current = 0;
        $max = 1;

        switch ($metric) {
            case 'shops':
                $q = $ci->db->query("SELECT COUNT(*) AS total FROM `tiktok_shops` WHERE `tenant_id` = ?", [(int) $tenant_id]);
                $current = ($q && $row = $q->row()) ? (int) $row->total : 0;
                $max = (int) ($tenant->max_shops ?: 1);
                $label = 'toko marketplace';
                break;

            case 'users':
                $q = $ci->db->query("SELECT COUNT(*) AS total FROM `aauth_users` WHERE `tenant_id` = ?", [(int) $tenant_id]);
                $current = ($q && $row = $q->row()) ? (int) $row->total : 0;
                $max = (int) ($tenant->max_users ?: 2);
                $label = 'akun pengguna / staf';
                break;

            case 'warehouses':
                $q = $ci->db->query("SELECT COUNT(*) AS total FROM `tiktok_warehouses` WHERE `tenant_id` = ?", [(int) $tenant_id]);
                $current = ($q && $row = $q->row()) ? (int) $row->total : 0;
                $max = (int) ($tenant->max_warehouses ?: 1);
                $label = 'gudang';
                break;

            default:
                return ['allowed' => true, 'current' => 0, 'max' => 999, 'message' => 'OK'];
        }

        $allowed = ($current < $max);
        $message = $allowed 
            ? 'Kuota mencukupi.' 
            : "Batas paket Anda ({$tenant->plan_name}) telah tercapai: {$current}/{$max} {$label}. Tingkatkan paket Anda untuk menambah lebih banyak.";

        return [
            'allowed' => $allowed,
            'current' => $current,
            'max'     => $max,
            'message' => $message
        ];
    }
}
