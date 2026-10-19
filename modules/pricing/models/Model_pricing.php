<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pricing extends MY_Model {

    private $primary_key = 'id';
    private $table_name  = 'plans';
    private $table_transactions = 'subscription_transactions';

    public function __construct()
    {
        $config = [
            'primary_key'  => $this->primary_key,
            'table_name'   => $this->table_name,
            'field_search' => ['name', 'code', 'description'],
        ];
        parent::__construct($config);
        $this->ensure_subscription_transactions_table();
    }

    /**
     * Ensure subscription_transactions table exists idempotently
     */
    public function ensure_subscription_transactions_table()
    {
        static $ensured = false;
        if ($ensured) {
            return;
        }
        $ensured = true;

        $check = $this->db->query("SHOW TABLES LIKE '{$this->table_transactions}'");
        if (!$check || $check->num_rows() == 0) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table_transactions}` (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `invoice_number` varchar(100) NOT NULL,
                `tenant_id` int(10) UNSIGNED NOT NULL,
                `user_id` int(10) UNSIGNED NOT NULL,
                `plan_id` int(10) UNSIGNED NOT NULL,
                `plan_name` varchar(100) NOT NULL,
                `duration_months` int(11) NOT NULL DEFAULT 1,
                `original_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
                `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
                `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
                `xendit_invoice_id` varchar(100) DEFAULT NULL,
                `xendit_external_id` varchar(100) NOT NULL,
                `action_type` varchar(20) NOT NULL DEFAULT 'UPGRADE',
                `payment_status` enum('PENDING','PAID','EXPIRED','FAILED') NOT NULL DEFAULT 'PENDING',
                `payment_method` varchar(50) DEFAULT NULL,
                `payment_channel` varchar(50) DEFAULT NULL,
                `invoice_url` text DEFAULT NULL,
                `paid_at` datetime DEFAULT NULL,
                `expiry_date` datetime DEFAULT NULL,
                `raw_response` mediumtext DEFAULT NULL,
                `created_at` datetime NOT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_invoice_number` (`invoice_number`),
                KEY `idx_xendit_external_id` (`xendit_external_id`),
                KEY `idx_xendit_invoice_id` (`xendit_invoice_id`),
                KEY `idx_tenant_id` (`tenant_id`),
                KEY `idx_payment_status` (`payment_status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            // Pastikan kolom action_type ada
            $check_col = $this->db->query("SHOW COLUMNS FROM `{$this->table_transactions}` LIKE 'action_type'");
            if (!$check_col || $check_col->num_rows() == 0) {
                $this->db->query("ALTER TABLE `{$this->table_transactions}` ADD COLUMN `action_type` VARCHAR(20) NOT NULL DEFAULT 'UPGRADE' AFTER `duration_months`");
            }
        }
    }

    /**
     * Get all active subscription plans ordered by sort_order
     *
     * @return array
     */
    public function get_active_plans()
    {
        return $this->db
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('id', 'ASC')
            ->get($this->table_name)
            ->result();
    }

    /**
     * Get plan by ID
     *
     * @param int $plan_id
     * @return object|null
     */
    public function get_plan_by_id($plan_id)
    {
        return $this->db
            ->where('id', (int)$plan_id)
            ->get($this->table_name)
            ->row();
    }

    /**
     * Get current tenant information and active plan details for logged in user
     *
     * @param int|null $userId
     * @return object|null
     */
    public function get_current_tenant_plan($userId = null)
    {
        $tenantId = null;
        if (function_exists('get_active_tenant_id')) {
            $tenantId = get_active_tenant_id();
        }

        if (empty($tenantId) && !empty($userId) && $this->db->field_exists('tenant_id', 'aauth_users')) {
            $user = $this->db->select('tenant_id')->where('id', (int)$userId)->get('aauth_users')->row();
            if ($user && !empty($user->tenant_id)) {
                $tenantId = (int)$user->tenant_id;
            }
        }

        if (empty($tenantId)) {
            $tenantId = 1;
        }

        $tenant = $this->db
            ->select('tenants.*, plans.name as plan_name, plans.code as plan_code')
            ->from('tenants')
            ->join('plans', 'plans.id = tenants.plan_id', 'left')
            ->where('tenants.id', (int)$tenantId)
            ->get()
            ->row();

        return $tenant;
    }

    /**
     * Get current metric usage for a tenant (shops, users, warehouses)
     *
     * @param int $tenant_id
     * @return array
     */
    public function get_tenant_current_usage($tenant_id)
    {
        $shops = 0;
        $users = 0;
        $warehouses = 0;

        $check_shops = $this->db->query("SHOW TABLES LIKE 'tiktok_shops'");
        if ($check_shops && $check_shops->num_rows() > 0) {
            $q = $this->db->query("SELECT COUNT(*) AS total FROM `tiktok_shops` WHERE `tenant_id` = ?", [(int)$tenant_id]);
            if ($q && $r = $q->row()) $shops = (int)$r->total;
        }

        $check_users = $this->db->query("SHOW TABLES LIKE 'aauth_users'");
        if ($check_users && $check_users->num_rows() > 0) {
            $q = $this->db->query("SELECT COUNT(*) AS total FROM `aauth_users` WHERE `tenant_id` = ?", [(int)$tenant_id]);
            if ($q && $r = $q->row()) $users = (int)$r->total;
        }

        $check_wh = $this->db->query("SHOW TABLES LIKE 'tiktok_warehouses'");
        if ($check_wh && $check_wh->num_rows() > 0) {
            $q = $this->db->query("SELECT COUNT(*) AS total FROM `tiktok_warehouses` WHERE `tenant_id` = ?", [(int)$tenant_id]);
            if ($q && $r = $q->row()) $warehouses = (int)$r->total;
        }

        return [
            'shops'      => $shops,
            'users'      => $users,
            'warehouses' => $warehouses
        ];
    }

    /**
     * Determine subscription action type: RENEWAL, UPGRADE, or DOWNGRADE
     *
     * @param int $current_plan_id
     * @param int $target_plan_id
     * @return string 'RENEWAL'|'UPGRADE'|'DOWNGRADE'
     */
    public function get_subscription_action_type($current_plan_id, $target_plan_id)
    {
        $current_plan_id = (int)$current_plan_id;
        $target_plan_id  = (int)$target_plan_id;

        if ($current_plan_id === $target_plan_id) {
            return 'RENEWAL';
        }

        $current_plan = $this->get_plan_by_id($current_plan_id);
        $target_plan  = $this->get_plan_by_id($target_plan_id);

        if (!$current_plan || !$target_plan) {
            return ($target_plan_id > $current_plan_id) ? 'UPGRADE' : 'DOWNGRADE';
        }

        $curr_weight = (int)($current_plan->sort_order ?: $current_plan->id);
        $target_weight = (int)($target_plan->sort_order ?: $target_plan->id);

        if ($target_weight > $curr_weight) {
            return 'UPGRADE';
        } elseif ($target_weight < $curr_weight) {
            return 'DOWNGRADE';
        }

        return ((float)$target_plan->price_monthly >= (float)$current_plan->price_monthly) ? 'UPGRADE' : 'DOWNGRADE';
    }

    /**
     * Check if a tenant is eligible to downgrade to a target plan based on current usage
     *
     * @param int $tenant_id
     * @param object $target_plan
     * @return array ['eligible' => bool, 'message' => string, 'usage' => array]
     */
    public function check_downgrade_eligibility($tenant_id, $target_plan)
    {
        $usage = $this->get_tenant_current_usage($tenant_id);

        $max_shops = (int)($target_plan->max_shops ?: 0);
        $max_users = (int)($target_plan->max_users ?: 0);
        $max_wh    = (int)($target_plan->max_warehouses ?: 0);

        $reasons = [];

        if ($max_shops > 0 && $usage['shops'] > $max_shops) {
            $reasons[] = "Toko terhubung saat ini ({$usage['shops']}) melebihi kuota paket tujuan (maksimal {$max_shops} toko)";
        }
        if ($max_users > 0 && $usage['users'] > $max_users) {
            $reasons[] = "Jumlah user/staf saat ini ({$usage['users']}) melebihi kuota paket tujuan (maksimal {$max_users} user)";
        }
        if ($max_wh > 0 && $usage['warehouses'] > $max_wh) {
            $reasons[] = "Jumlah gudang saat ini ({$usage['warehouses']}) melebihi kuota paket tujuan (maksimal {$max_wh} gudang)";
        }

        if (!empty($reasons)) {
            return [
                'eligible' => false,
                'message'  => "Tidak dapat melakukan downgrade: " . implode(', ', $reasons) . ". Silakan nonaktifkan atau hapus data berlebih terlebih dahulu.",
                'usage'    => $usage
            ];
        }

        return [
            'eligible' => true,
            'message'  => "Memenuhi syarat downgrade.",
            'usage'    => $usage
        ];
    }

    /**
     * Calculate exact price, discount, and total for a plan and duration
     *
     * @param object $plan
     * @param int $duration_months
     * @return array
     */
    public function calculate_plan_price($plan, $duration_months)
    {
        $duration = in_array((int)$duration_months, [1, 3, 6, 12]) ? (int)$duration_months : 1;
        $price_1 = (float)$plan->price_monthly;

        $original_price = $price_1 * $duration;
        $total_price = $original_price;
        $discount_pct = 0.0;

        if ($duration == 3) {
            $price_3 = (float)$plan->price_3_months;
            $disc_3  = (float)$plan->discount_3_months;
            if ($price_3 <= 0 && $price_1 > 0 && $disc_3 > 0) {
                $price_3 = round(($price_1 * 3) * (1 - ($disc_3 / 100)));
            } elseif ($disc_3 <= 0 && $price_1 > 0 && $price_3 > 0 && $price_3 < ($price_1 * 3)) {
                $disc_3 = round((( ($price_1 * 3) - $price_3 ) / ($price_1 * 3)) * 100);
            }
            if ($price_3 <= 0) $price_3 = $price_1 * 3;
            $total_price = $price_3;
            $discount_pct = $disc_3;
        } elseif ($duration == 6) {
            $price_6 = (float)$plan->price_6_months;
            $disc_6  = (float)$plan->discount_6_months;
            if ($price_6 <= 0 && $price_1 > 0 && $disc_6 > 0) {
                $price_6 = round(($price_1 * 6) * (1 - ($disc_6 / 100)));
            } elseif ($disc_6 <= 0 && $price_1 > 0 && $price_6 > 0 && $price_6 < ($price_1 * 6)) {
                $disc_6 = round((( ($price_1 * 6) - $price_6 ) / ($price_1 * 6)) * 100);
            }
            if ($price_6 <= 0) $price_6 = $price_1 * 6;
            $total_price = $price_6;
            $discount_pct = $disc_6;
        } elseif ($duration == 12) {
            $price_12 = (float)$plan->price_12_months;
            $disc_12  = (float)$plan->discount_12_months;
            if ($price_12 <= 0 && $price_1 > 0 && $disc_12 > 0) {
                $price_12 = round(($price_1 * 12) * (1 - ($disc_12 / 100)));
            } elseif ($disc_12 <= 0 && $price_1 > 0 && $price_12 > 0 && $price_12 < ($price_1 * 12)) {
                $disc_12 = round((( ($price_1 * 12) - $price_12 ) / ($price_1 * 12)) * 100);
            }
            if ($price_12 <= 0) $price_12 = $price_1 * 12;
            $total_price = $price_12;
            $discount_pct = $disc_12;
        }

        return [
            'original_price'    => $original_price,
            'discount_percent'  => (float)$discount_pct,
            'total_price'       => (float)$total_price,
            'monthly_effective' => ($duration > 0) ? round($total_price / $duration) : $price_1
        ];
    }

    /**
     * Create a new subscription transaction
     *
     * @param array $data
     * @return int Insert ID
     */
    public function create_subscription_transaction(array $data)
    {
        $this->ensure_subscription_transactions_table();
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table_transactions, $data);
        return $this->db->insert_id();
    }

    /**
     * Update transaction by external ID
     *
     * @param string $external_id
     * @param array $data
     * @return bool
     */
    public function update_transaction_by_external_id($external_id, array $data)
    {
        $this->ensure_subscription_transactions_table();
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('xendit_external_id', $external_id)
            ->update($this->table_transactions, $data);
    }

    /**
     * Update transaction by ID
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_transaction_by_id($id, array $data)
    {
        $this->ensure_subscription_transactions_table();
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('id', (int)$id)
            ->update($this->table_transactions, $data);
    }

    /**
     * Get transaction by external ID
     *
     * @param string $external_id
     * @return object|null
     */
    public function get_transaction_by_external_id($external_id)
    {
        $this->ensure_subscription_transactions_table();
        return $this->db
            ->where('xendit_external_id', $external_id)
            ->get($this->table_transactions)
            ->row();
    }

    /**
     * Get transaction by Xendit Invoice ID
     *
     * @param string $xendit_invoice_id
     * @return object|null
     */
    public function get_transaction_by_xendit_id($xendit_invoice_id)
    {
        $this->ensure_subscription_transactions_table();
        return $this->db
            ->where('xendit_invoice_id', $xendit_invoice_id)
            ->get($this->table_transactions)
            ->row();
    }

    /**
     * Get all transactions for a tenant
     *
     * @param int $tenant_id
     * @param int $limit
     * @return array
     */
    public function get_tenant_transactions($tenant_id, $limit = 20)
    {
        $this->ensure_subscription_transactions_table();
        return $this->db
            ->where('tenant_id', (int)$tenant_id)
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get($this->table_transactions)
            ->result();
    }

    /**
     * Activate / extend subscription for a tenant after successful payment
     *
     * @param object|int $transaction
     * @param array $payment_meta
     * @return bool
     */
    public function activate_subscription_for_tenant($transaction, array $payment_meta = [])
    {
        if (is_numeric($transaction)) {
            $transaction = $this->db->where('id', (int)$transaction)->get($this->table_transactions)->row();
        }

        if (!$transaction) {
            return false;
        }

        $tenant_id = (int)$transaction->tenant_id;
        $tenant = $this->db->where('id', $tenant_id)->get('tenants')->row();
        if (!$tenant) {
            return false;
        }

        // 1. Hitung perpanjangan tanggal subscription_ends_at
        $now = time();
        $current_end = !empty($tenant->subscription_ends_at) ? strtotime($tenant->subscription_ends_at) : 0;

        // Jika langganan saat ini masih aktif dan di masa depan, tambahkan dari tanggal tersebut
        if ($current_end > $now && $tenant->status === 'active') {
            $base_time = $current_end;
        } else {
            // Jika sudah expired atau masih trial, hitung dari sekarang
            $base_time = $now;
        }

        $duration = (int)$transaction->duration_months;
        if ($duration <= 0) $duration = 1;
        $new_subscription_ends_at = date('Y-m-d H:i:s', strtotime("+{$duration} months", $base_time));

        // 2. Update status transaksi menjadi PAID jika belum
        $update_tx = [
            'payment_status' => 'PAID',
            'paid_at'        => !empty($payment_meta['paid_at']) ? date('Y-m-d H:i:s', strtotime($payment_meta['paid_at'])) : date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        if (!empty($payment_meta['payment_method'])) {
            $update_tx['payment_method'] = $payment_meta['payment_method'];
        }
        if (!empty($payment_meta['payment_channel'])) {
            $update_tx['payment_channel'] = $payment_meta['payment_channel'];
        }
        if (!empty($payment_meta['raw_response'])) {
            $update_tx['raw_response'] = is_array($payment_meta['raw_response']) ? json_encode($payment_meta['raw_response']) : $payment_meta['raw_response'];
        }

        $this->db->where('id', $transaction->id)->update($this->table_transactions, $update_tx);

        // 3. Update data tenant
        $update_tenant = [
            'plan_id'              => (int)$transaction->plan_id,
            'status'               => 'active',
            'subscription_ends_at' => $new_subscription_ends_at,
            'updated_at'           => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $tenant_id)->update('tenants', $update_tenant);

        log_message('info', "[Xendit] Tenant #{$tenant_id} subscription upgraded to Plan #{$transaction->plan_id} ({$transaction->plan_name}) until {$new_subscription_ends_at}");

        return true;
    }
}
