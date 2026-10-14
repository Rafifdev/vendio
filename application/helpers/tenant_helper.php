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
        $ci =& get_instance();
        if (!$ci->load->is_loaded('session')) {
            $ci->load->library('session');
        }

        $session_tenant = $ci->session->userdata('tenant_id');
        if (!empty($session_tenant)) {
            return (int) $session_tenant;
        }

        $user_id = $ci->session->userdata('id');
        if ($user_id) {
            $user = $ci->db->select('tenant_id')->get_where('aauth_users', ['id' => $user_id])->row();
            if ($user && !empty($user->tenant_id)) {
                $ci->session->set_userdata('tenant_id', (int) $user->tenant_id);
                return (int) $user->tenant_id;
            }
        }

        return 1; // Default tenant fallback
    }
}

if (!function_exists('get_active_tenant')) {
    /**
     * Get full active tenant details including plan information
     * 
     * @return object|null
     */
    function get_active_tenant() {
        $ci =& get_instance();
        $tenant_id = get_active_tenant_id();

        $ci->db->select('tenants.*, plans.name AS plan_name, plans.code AS plan_code, plans.max_shops, plans.max_users, plans.max_warehouses');
        $ci->db->from('tenants');
        $ci->db->join('plans', 'plans.id = tenants.plan_id', 'LEFT');
        $ci->db->where('tenants.id', $tenant_id);
        
        return $ci->db->get()->row();
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
                $current = $ci->db->where('tenant_id', $tenant_id)->count_all_results('tiktok_shops');
                $max = (int) ($tenant->max_shops ?: 1);
                $label = 'toko marketplace';
                break;

            case 'users':
                $current = $ci->db->where('tenant_id', $tenant_id)->count_all_results('aauth_users');
                $max = (int) ($tenant->max_users ?: 2);
                $label = 'akun pengguna / staf';
                break;

            case 'warehouses':
                $current = $ci->db->where('tenant_id', $tenant_id)->count_all_results('tiktok_warehouses');
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
