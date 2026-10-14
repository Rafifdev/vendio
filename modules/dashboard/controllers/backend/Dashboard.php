<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *| --------------------------------------------------------------------------
 *| Dashboard Controller
 *| --------------------------------------------------------------------------
 *| Dashboard performa bisnis, penjualan, dan katalog omnichannel
 *|
 */
class Dashboard extends Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['text']);
	}

	public function index()
	{
		if (!$this->aauth->is_allowed('dashboard')) {
			redirect('administrator/user/profile', 'refresh');
		}

		$is_super  = function_exists('is_super_admin') ? is_super_admin() : false;
		$tenant_id = function_exists('get_active_tenant_id') ? get_active_tenant_id() : null;

		// 1. Total Pendapatan / Omzet Penjualan
		$this->db->select_sum('total_amount');
		if (!$is_super && !empty($tenant_id)) {
			$this->db->where('tenant_id', $tenant_id);
		}
		$this->db->where_in('order_status', ['COMPLETED', 'DELIVERED', 'IN_TRANSIT', 'AWAITING_COLLECTION', 'AWAITING_SHIPMENT']);
		$revenue_row = $this->db->get('tiktok_orders')->row();
		$total_revenue = (float) ($revenue_row->total_amount ?? 0);

		// 2. Total Pesanan & Pesanan Perlu Dikirim
		$this->db->select('COUNT(*) as total_orders, 
		                   SUM(CASE WHEN order_status IN ("AWAITING_SHIPMENT", "AWAITING_COLLECTION") THEN 1 ELSE 0 END) as pending_shipment');
		if (!$is_super && !empty($tenant_id)) {
			$this->db->where('tenant_id', $tenant_id);
		}
		$order_row = $this->db->get('tiktok_orders')->row();
		$total_orders     = (int) ($order_row->total_orders ?? 0);
		$pending_shipment = (int) ($order_row->pending_shipment ?? 0);

		// 3. Total Produk Aktif & Stok Menipis (Stok <= 5)
		$this->db->select('COUNT(*) as total_products, 
		                   SUM(CASE WHEN status = "ACTIVATE" THEN 1 ELSE 0 END) as active_products,
		                   SUM(CASE WHEN total_stock <= 5 THEN 1 ELSE 0 END) as low_stock');
		if (!$is_super && !empty($tenant_id)) {
			$this->db->where('tenant_id', $tenant_id);
		}
		$prod_row = $this->db->get('tiktok_products')->row();
		$total_products  = (int) ($prod_row->total_products ?? 0);
		$active_products = (int) ($prod_row->active_products ?? 0);
		$low_stock       = (int) ($prod_row->low_stock ?? 0);

		// 4. Toko Terhubung
		$this->db->select('COUNT(*) as total_shops, 
		                   SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_shops');
		if (!$is_super && !empty($tenant_id)) {
			$this->db->where('tenant_id', $tenant_id);
		}
		$shop_row = $this->db->get('tiktok_shops')->row();
		$total_shops  = (int) ($shop_row->total_shops ?? 0);
		$active_shops = (int) ($shop_row->active_shops ?? 0);

		$data = [
			'total_revenue'    => $total_revenue,
			'total_orders'     => $total_orders,
			'pending_shipment' => $pending_shipment,
			'total_products'   => $total_products,
			'active_products'  => $active_products,
			'low_stock'        => $low_stock,
			'total_shops'      => $total_shops,
			'active_shops'     => $active_shops
		];

		$this->render('backend/standart/dashboard', $data);
	}

	public function chart()
	{
		if (!$this->aauth->is_allowed('dashboard')) {
			redirect('administrator/user/profile', 'refresh');
		}

		$data = [];
		$this->render('backend/standart/chart', $data);
	}
}

/* End of file Dashboard.php */
/* Location: ./modules/dashboard/controllers/backend/Dashboard.php */
