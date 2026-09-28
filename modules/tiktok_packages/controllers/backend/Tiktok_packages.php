<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tiktok Packages Controller
*| --------------------------------------------------------------------------
*| Manajemen Pengiriman Paket TikTok Shop
*|
*/
class Tiktok_packages extends Admin	
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_packages');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* Menampilkan daftar semua Paket Pengiriman
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_packages_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_packagess'] = $this->model_tiktok_packages->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_packages_counts'] = $this->model_tiktok_packages->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_packages/index/',
			'total_rows'   => $this->model_tiktok_packages->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Pengiriman Paket');
		$this->render('backend/standart/administrator/tiktok_packages/tiktok_packages_list', $this->data);
	}

	/**
	* Tarik Data Paket dari TikTok Shop API (Sync)
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_packages_list');
		$this->load->library('tiktok_api');

		$shop = $this->db->get_where('tiktok_shops', ['is_active' => 1])->row();
		if (!$shop) {
			$shop = $this->db->get('tiktok_shops')->row();
		}
		if (!$shop) {
			set_message('Toko TikTok belum aktif atau belum terhubung.', 'error');
			redirect('administrator/tiktok_packages');
			return;
		}

		$response = $this->tiktok_api->search_packages([], ['page_size' => 50], $shop->id);
		if (empty($response['success']) && (!isset($response['code']) || $response['code'] !== 0)) {
			set_message('Gagal menarik data paket dari TikTok Shop: ' . ($response['message'] ?? 'Error API'), 'error');
			redirect('administrator/tiktok_packages');
			return;
		}

		$packages = $response['data']['packages'] ?? [];
		$synced_count = 0;

		foreach ($packages as $pkg) {
			$pkg_id = $pkg['id'] ?? '';
			if (empty($pkg_id)) continue;

			$detail_res = $this->tiktok_api->get_package_detail($pkg_id, [], $shop->id);
			$pkg_detail = $detail_res['data'] ?? [];

			$first_order = $pkg['orders'][0] ?? ($pkg_detail['orders'][0] ?? []);
			$order_id = $first_order['id'] ?? '';

			$sender_addr = $pkg_detail['sender_address']['full_address'] ?? ($pkg_detail['sender_address']['address_detail'] ?? '');
			$recipient_addr = $pkg_detail['recipient_address']['full_address'] ?? ($pkg_detail['recipient_address']['address_detail'] ?? '');

			$create_time = !empty($pkg['create_time']) ? date('Y-m-d H:i:s', $pkg['create_time']) : (!empty($pkg_detail['create_time']) ? date('Y-m-d H:i:s', $pkg_detail['create_time']) : date('Y-m-d H:i:s'));
			$update_time = !empty($pkg['update_time']) ? date('Y-m-d H:i:s', $pkg['update_time']) : (!empty($pkg_detail['update_time']) ? date('Y-m-d H:i:s', $pkg_detail['update_time']) : date('Y-m-d H:i:s'));

			$pkg_data = [
				'tiktok_shop_id'         => $shop->id,
				'package_id'             => $pkg_id,
				'order_id'               => $order_id,
				'package_status'         => $pkg['status'] ?? ($pkg_detail['package_status'] ?? 'FULFILLING'),
				'package_sub_status'     => $pkg_detail['package_sub_status'] ?? '',
				'shipping_provider_id'   => $pkg['shipping_provider_id'] ?? ($pkg_detail['shipping_provider_id'] ?? ''),
				'shipping_provider_name' => $pkg['shipping_provider_name'] ?? ($pkg_detail['shipping_provider_name'] ?? ''),
				'shipping_type'          => $pkg_detail['shipping_type'] ?? 'TIKTOK',
				'delivery_option_id'     => $pkg_detail['delivery_option_id'] ?? '',
				'delivery_option_name'   => $pkg_detail['delivery_option_name'] ?? '',
				'tracking_number'        => $pkg['tracking_number'] ?? ($pkg_detail['tracking_number'] ?? ''),
				'handover_method'        => $pkg_detail['handover_method'] ?? 'PICKUP',
				'dimension_length'       => (float)($pkg_detail['dimension']['length'] ?? 0),
				'dimension_width'        => (float)($pkg_detail['dimension']['width'] ?? 0),
				'dimension_height'       => (float)($pkg_detail['dimension']['height'] ?? 0),
				'dimension_unit'         => $pkg_detail['dimension']['unit'] ?? 'CM',
				'weight_val'             => (float)($pkg_detail['weight']['value'] ?? 0),
				'weight_unit'            => $pkg_detail['weight']['unit'] ?? 'GRAM',
				'sender_name'            => $pkg_detail['sender_address']['name'] ?? '',
				'sender_phone'           => $pkg_detail['sender_address']['phone_number'] ?? '',
				'sender_address'         => $sender_addr,
				'recipient_name'         => $pkg_detail['recipient_address']['name'] ?? '',
				'recipient_phone'        => $pkg_detail['recipient_address']['phone_number'] ?? '',
				'recipient_address'      => $recipient_addr,
				'package_create_time'    => $create_time,
				'package_update_time'    => $update_time,
				'updated_at'             => date('Y-m-d H:i:s'),
			];

			$exist = $this->db->get_where('tiktok_packages', ['package_id' => $pkg_id])->row();
			if ($exist) {
				$this->db->where('id', $exist->id)->update('tiktok_packages', $pkg_data);
			} else {
				$pkg_data['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('tiktok_packages', $pkg_data);
			}

			// Perbarui juga data di tiktok_orders jika ada order_id yang cocok
			if (!empty($order_id)) {
				$this->db->where('order_id', $order_id)->update('tiktok_orders', [
					'package_id'             => $pkg_id,
					'tracking_number'        => $pkg_data['tracking_number'],
					'shipping_provider'      => $pkg_data['shipping_provider_name'],
					'delivery_option_name'   => $pkg_data['delivery_option_name'],
				]);
			}

			// Sinkronkan barang di dalam paket
			$orders_array = !empty($pkg['orders']) ? $pkg['orders'] : ($pkg_detail['orders'] ?? []);
			$this->db->where('package_id', $pkg_id)->delete('tiktok_package_items');

			foreach ($orders_array as $o) {
				$o_id = $o['id'] ?? $order_id;
				$skus = $o['skus'] ?? [];
				foreach ($skus as $sku) {
					$this->db->insert('tiktok_package_items', [
						'package_id'          => $pkg_id,
						'order_id'            => $o_id,
						'order_line_item_id'  => $pkg['order_line_item_ids'][0] ?? '',
						'sku_id'              => $sku['id'] ?? '',
						'sku_name'            => $sku['name'] ?? '',
						'quantity'            => (int)($sku['quantity'] ?? 1),
						'sku_image'           => $sku['image_url'] ?? '',
						'created_at'          => date('Y-m-d H:i:s'),
					]);
				}
			}

			$synced_count++;
		}

		set_message("Berhasil mensinkronisasi {$synced_count} paket pengiriman dari TikTok Shop.", 'success');
		redirect('administrator/tiktok_packages');
	}

	/**
	* Detail Pengiriman Paket
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_packages_view');

		$package = $this->model_tiktok_packages->find($id);
		if (!$package) {
			set_message('Data paket tidak ditemukan.', 'error');
			redirect('administrator/tiktok_packages');
			return;
		}

		$this->data['tiktok_packages'] = $package;

		// Ambil daftar barang di dalam paket beserta nama produk resmi dari order_items
		$this->data['package_items'] = $this->db->select('pi.*, oi.product_name, oi.sku_name as variant_name, oi.seller_sku, oi.sku_image as order_sku_image')
			->from('tiktok_package_items pi')
			->join('tiktok_order_items oi', 'oi.order_line_id = pi.order_line_item_id', 'left')
			->where('pi.package_id', $package->package_id)
			->get()
			->result();

		// Ambil data tracking kurir secara real-time dari TikTok API
		$this->load->library('tiktok_api');
		$tracking_events = [];
		if (!empty($package->order_id)) {
			$track_res = $this->tiktok_api->get_order_tracking($package->order_id, [], $package->tiktok_shop_id);
			if (!empty($track_res['success']) || (isset($track_res['code']) && $track_res['code'] === 0)) {
				$tracking_events = $track_res['data']['tracking'] ?? [];
			}
		}
		$this->data['tracking_events'] = $tracking_events;

		$this->template->title('Pengiriman Paket');
		$this->render('backend/standart/administrator/tiktok_packages/tiktok_packages_view', $this->data);
	}

	/**
	* Cetak Label Pengiriman (AWB PDF / Thermal A6)
	*
	* @param int $id
	*/
	public function print_label($id)
	{
		$this->is_allowed('tiktok_packages_view');

		$package = $this->model_tiktok_packages->find($id);
		if (!$package) {
			set_message('Data paket tidak ditemukan.', 'error');
			redirect('administrator/tiktok_packages');
			return;
		}

		$this->load->library('tiktok_api');
		$doc_res = $this->tiktok_api->get_shipping_documents($package->package_id, 'SHIPPING_LABEL', ['document_size' => 'A6'], $package->tiktok_shop_id);

		// Catat ke log dokumen pengiriman
		$doc_url = $doc_res['data']['doc_url'] ?? '';
		$this->db->insert('tiktok_shipping_documents', [
			'package_id'    => $package->package_id,
			'document_type' => 'SHIPPING_LABEL',
			'document_size' => 'A6',
			'document_url'  => $doc_url ?: null,
			'printed_at'    => date('Y-m-d H:i:s'),
			'created_at'    => date('Y-m-d H:i:s'),
		]);

		// Jika TikTok mengembalikan URL file PDF langsung
		if (!empty($doc_url)) {
			redirect($doc_url);
			return;
		}

		// Jika dokumen PDF tidak dapat ditarik dari API TikTok (misal paket sudah di-pickup atau batasan sandbox),
		// sistem menyediakan template Cetak Label Thermal A6 standar logistik
		$this->data['package'] = $package;
		$this->data['items'] = $this->db->select('pi.*, oi.product_name, oi.sku_name as variant_name, oi.seller_sku, oi.sku_image as order_sku_image')
			->from('tiktok_package_items pi')
			->join('tiktok_order_items oi', 'oi.order_line_id = pi.order_line_item_id', 'left')
			->where('pi.package_id', $package->package_id)
			->get()
			->result();
		$this->load->view('backend/standart/administrator/tiktok_packages/tiktok_packages_print_label', $this->data);
	}

	/**
	* Konfirmasi Pengiriman Paket ke Kurir (Ship / Handover)
	*
	* @param int $id
	*/
	public function ship($id)
	{
		$this->is_allowed('tiktok_packages_update');

		$package = $this->model_tiktok_packages->find($id);
		if (!$package) {
			set_message('Data paket tidak ditemukan.', 'error');
			redirect('administrator/tiktok_packages');
			return;
		}

		$this->load->library('tiktok_api');
		$body = [
			'handover_method' => $package->handover_method ?: 'DROP_OFF'
		];

		$response = $this->tiktok_api->ship_package($package->package_id, $body, $package->tiktok_shop_id);

		if (!empty($response['success']) || (isset($response['code']) && $response['code'] === 0)) {
			// Update status lokal
			$this->db->where('id', $package->id)->update('tiktok_packages', [
				'package_status' => 'AWAITING_COLLECTION',
				'updated_at'     => date('Y-m-d H:i:s')
			]);

			if (!empty($package->order_id)) {
				$this->db->where('order_id', $package->order_id)->update('tiktok_orders', [
					'order_status' => 'AWAITING_COLLECTION',
					'updated_at'   => date('Y-m-d H:i:s')
				]);
			}

			set_message('Berhasil mengonfirmasi serah terima pengiriman paket ke kurir!', 'success');
		} else {
			set_message('Gagal konfirmasi pengiriman paket: ' . ($response['message'] ?? 'Error API'), 'error');
		}

		redirect('administrator/tiktok_packages');
	}

	/**
	* Add new tiktok_packagess
	*
	*/
	public function add()
	{
		$this->is_allowed('tiktok_packages_add');

		$this->template->title('Pengiriman Paket');
		$this->render('backend/standart/administrator/tiktok_packages/tiktok_packages_add', $this->data);
	}

	/**
	* Add New Tiktok Packagess
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_packages_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('package_id', 'ID Paket', 'trim|required');
		$this->form_validation->set_rules('order_id', 'ID Pesanan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id'         => $this->input->post('tiktok_shop_id') ?: 1,
				'package_id'             => $this->input->post('package_id'),
				'order_id'               => $this->input->post('order_id'),
				'package_status'         => $this->input->post('package_status'),
				'package_sub_status'     => $this->input->post('package_sub_status'),
				'shipping_provider_id'   => $this->input->post('shipping_provider_id'),
				'shipping_provider_name' => $this->input->post('shipping_provider_name'),
				'shipping_type'          => $this->input->post('shipping_type'),
				'delivery_option_id'     => $this->input->post('delivery_option_id'),
				'delivery_option_name'   => $this->input->post('delivery_option_name'),
				'tracking_number'        => $this->input->post('tracking_number'),
				'handover_method'        => $this->input->post('handover_method'),
				'dimension_length'       => $this->input->post('dimension_length') ?: 0,
				'dimension_width'        => $this->input->post('dimension_width') ?: 0,
				'dimension_height'       => $this->input->post('dimension_height') ?: 0,
				'dimension_unit'         => $this->input->post('dimension_unit') ?: 'CM',
				'weight_val'             => $this->input->post('weight_val') ?: 0,
				'weight_unit'            => $this->input->post('weight_unit') ?: 'GRAM',
				'sender_name'            => $this->input->post('sender_name'),
				'sender_phone'           => $this->input->post('sender_phone'),
				'sender_address'         => $this->input->post('sender_address'),
				'recipient_name'         => $this->input->post('recipient_name'),
				'recipient_phone'        => $this->input->post('recipient_phone'),
				'recipient_address'      => $this->input->post('recipient_address'),
				'package_create_time'    => $this->input->post('package_create_time') ?: date('Y-m-d H:i:s'),
				'package_update_time'    => $this->input->post('package_update_time') ?: date('Y-m-d H:i:s'),
				'created_at'             => date('Y-m-d H:i:s'),
				'updated_at'             => date('Y-m-d H:i:s'),
			];

			$save_tiktok_packages = $this->model_tiktok_packages->store($save_data);

			if ($save_tiktok_packages) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_packages;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_packages/edit/' . $save_tiktok_packages, 'Edit Pengiriman Paket'),
						anchor('administrator/tiktok_packages', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_packages/edit/' . $save_tiktok_packages, 'Edit Pengiriman Paket')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_packages');
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* Update view Tiktok Packagess
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('tiktok_packages_update');

		$this->data['tiktok_packages'] = $this->model_tiktok_packages->find($id);

		$this->template->title('Pengiriman Paket');
		$this->render('backend/standart/administrator/tiktok_packages/tiktok_packages_update', $this->data);
	}

	/**
	* Update Tiktok Packagess
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_packages_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('package_id', 'ID Paket', 'trim|required');
		$this->form_validation->set_rules('order_id', 'ID Pesanan', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id'         => $this->input->post('tiktok_shop_id') ?: 1,
				'package_id'             => $this->input->post('package_id'),
				'order_id'               => $this->input->post('order_id'),
				'package_status'         => $this->input->post('package_status'),
				'package_sub_status'     => $this->input->post('package_sub_status'),
				'shipping_provider_id'   => $this->input->post('shipping_provider_id'),
				'shipping_provider_name' => $this->input->post('shipping_provider_name'),
				'shipping_type'          => $this->input->post('shipping_type'),
				'delivery_option_id'     => $this->input->post('delivery_option_id'),
				'delivery_option_name'   => $this->input->post('delivery_option_name'),
				'tracking_number'        => $this->input->post('tracking_number'),
				'handover_method'        => $this->input->post('handover_method'),
				'dimension_length'       => $this->input->post('dimension_length') ?: 0,
				'dimension_width'        => $this->input->post('dimension_width') ?: 0,
				'dimension_height'       => $this->input->post('dimension_height') ?: 0,
				'dimension_unit'         => $this->input->post('dimension_unit') ?: 'CM',
				'weight_val'             => $this->input->post('weight_val') ?: 0,
				'weight_unit'            => $this->input->post('weight_unit') ?: 'GRAM',
				'sender_name'            => $this->input->post('sender_name'),
				'sender_phone'           => $this->input->post('sender_phone'),
				'sender_address'         => $this->input->post('sender_address'),
				'recipient_name'         => $this->input->post('recipient_name'),
				'recipient_phone'        => $this->input->post('recipient_phone'),
				'recipient_address'      => $this->input->post('recipient_address'),
				'package_update_time'    => date('Y-m-d H:i:s'),
				'updated_at'             => date('Y-m-d H:i:s'),
			];

			$save_tiktok_packages = $this->model_tiktok_packages->change($id, $save_data);

			if ($save_tiktok_packages) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_packages', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_packages');
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Packagess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_packages_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
		   $remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($remove) {
            set_message(cclang('has_been_deleted', 'Pengiriman Paket'), 'success');
        } else {
            set_message(cclang('error_delete', 'Pengiriman Paket'), 'error');
        }

		redirect_back();
	}

	/**
	* View single detail
	*
	* @var $id String
	*/
	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_packages_export');

		$table = $title = 'tiktok_packages';
		$this->load->library('HtmlPdf');
      
		$config = array(
			'orientation' => 'p',
			'format' => 'a4',
			'marges' => array(5, 5, 5, 5)
		);

		$this->pdf = new HtmlPdf($config);
		$this->pdf->setDefaultFont('stsongstdlight'); 

		$result = $this->db->get($table);
       
		$data = $this->model_tiktok_packages->find($id);
		$fields = $result->list_fields();

		$content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
			'data' => $data,
			'fields' => $fields,
			'title' => $title
		], TRUE);

		$this->pdf->initialize($config);
		$this->pdf->pdf->SetDisplayMode('fullpage');
		$this->pdf->writeHTML($content);
		$this->pdf->Output($table.'.pdf', 'H');
	}

	/**
	* delete Tiktok Packagess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_packages = $this->model_tiktok_packages->find($id);

		if ($tiktok_packages) {
			$this->db->where('package_id', $tiktok_packages->package_id)->delete('tiktok_package_items');
		}

		return $this->model_tiktok_packages->remove($id);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel : xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_packages_export');

		$this->model_tiktok_packages->export('tiktok_packages', 'tiktok_packages');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF : pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_packages_export');

		$this->model_tiktok_packages->pdf('tiktok_packages', 'tiktok_packages');
	}
}