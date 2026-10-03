<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Warehouses Controller
*| --------------------------------------------------------------------------
*| Tiktok Warehouses site
*|
*/
class Tiktok_warehouses extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_warehouses');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Warehousess
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_warehouses_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$this->data['tiktok_warehousess'] = $this->model_tiktok_warehouses->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		$this->data['tiktok_warehouses_counts'] = $this->model_tiktok_warehouses->count_all($filter, $field, $shop_id);

		$config = [
			'base_url'     => 'administrator/tiktok_warehouses/index/',
			'total_rows'   => $this->data['tiktok_warehouses_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Daftar Gudang List');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_list', $this->data);
	}
	
	/**
	* Tarik Data Gudang dari TikTok Shop API
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_warehouses_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
			if (empty($shops)) {
				$shops = $this->db->get('tiktok_shops')->result();
			}
		}

		if (empty($shops)) {
			set_message('Toko TikTok belum aktif atau belum terhubung.', 'error');
			redirect('administrator/tiktok_warehouses' . (!empty($shop_id) ? '?shop_id=' . $shop_id : ''));
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$response = $this->tiktok_api->get_warehouses($shop->id);
			if (empty($response['success']) && (!isset($response['code']) || $response['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($response['message'] ?? 'Error API');
				continue;
			}

			$warehouses = $response['data']['warehouses'] ?? [];

			$this->db->trans_start();

			foreach ($warehouses as $wh) {
				$wh_id = $wh['id'] ?? '';
				if (empty($wh_id)) continue;

				$address_str = '';
				if (!empty($wh['address'])) {
					$addr = $wh['address'];
					$parts = array_filter([
						$addr['full_address'] ?? '',
						$addr['district_name'] ?? '',
						$addr['city_name'] ?? '',
						$addr['province_name'] ?? '',
						$addr['postal_code'] ?? ''
					]);
					$address_str = implode(', ', $parts);
				}

				$data_warehouse = [
					'shop_id'             => $shop->id,
					'tiktok_warehouse_id' => $wh_id,
					'name'                => $wh['name'] ?? '',
					'warehouse_type'      => $wh['warehouse_type'] ?? 'SALES_WAREHOUSE',
					'effect_status'       => $wh['effect_status'] ?? 'EFFECTIVE',
					'is_default'          => !empty($wh['is_default']) ? 1 : 0,
					'address'             => $address_str,
					'updated_at'          => date('Y-m-d H:i:s'),
				];

				$existing = $this->db->get_where('tiktok_warehouses', [
					'shop_id'             => $shop->id,
					'tiktok_warehouse_id' => $wh_id
				])->row();

				if ($existing) {
					$this->db->where('id', $existing->id)->update('tiktok_warehouses', $data_warehouse);
					$local_wh_id = $existing->id;
				} else {
					$data_warehouse['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_warehouses', $data_warehouse);
					$local_wh_id = $this->db->insert_id();
				}

				// Tarik Opsi Pengiriman Gudang
				$del_res = $this->tiktok_api->get_warehouse_delivery_options($wh_id, $shop->id);
				if (!empty($del_res['data']['delivery_options'])) {
					foreach ($del_res['data']['delivery_options'] as $dopt) {
						$dopt_id = $dopt['id'] ?? '';
						if (empty($dopt_id)) continue;

						$dopt_data = [
							'warehouse_id'              => $local_wh_id,
							'tiktok_delivery_option_id' => $dopt_id,
							'name'                      => $dopt['name'] ?? '',
							'scope'                     => $dopt['scope'] ?? '',
							'is_active'                 => !empty($dopt['is_active']) ? 1 : 1,
						];

						$exist_dopt = $this->db->get_where('tiktok_delivery_options', [
							'warehouse_id'              => $local_wh_id,
							'tiktok_delivery_option_id' => $dopt_id
						])->row();

						if ($exist_dopt) {
							$this->db->where('id', $exist_dopt->id)->update('tiktok_delivery_options', $dopt_data);
							$local_dopt_id = $exist_dopt->id;
						} else {
							$dopt_data['created_at'] = date('Y-m-d H:i:s');
							$this->db->insert('tiktok_delivery_options', $dopt_data);
							$local_dopt_id = $this->db->insert_id();
						}

						// Tarik Kurir / Shipping Providers
						$sp_res = $this->tiktok_api->get_shipping_providers($dopt_id, $shop->id);
						if (!empty($sp_res['data']['shipping_providers'])) {
							foreach ($sp_res['data']['shipping_providers'] as $sp) {
								$sp_id = $sp['id'] ?? '';
								if (empty($sp_id)) continue;

								$sp_data = [
									'delivery_option_id' => $local_dopt_id,
									'tiktok_provider_id' => $sp_id,
									'name'               => $sp['name'] ?? '',
								];

								$exist_sp = $this->db->get_where('tiktok_shipping_providers', [
									'delivery_option_id' => $local_dopt_id,
									'tiktok_provider_id' => $sp_id
								])->row();

								if ($exist_sp) {
									$this->db->where('id', $exist_sp->id)->update('tiktok_shipping_providers', $sp_data);
								} else {
									$sp_data['created_at'] = date('Y-m-d H:i:s');
									$this->db->insert('tiktok_shipping_providers', $sp_data);
								}
							}
						}
					}
				}

				$total_synced++;
			}

			$this->db->trans_complete();
		}

		$redirect_url = 'administrator/tiktok_warehouses' . (!empty($shop_id) ? '?shop_id=' . $shop_id : '');

		if (!empty($error_messages)) {
			if ($total_synced === 0) {
				set_message("Gagal menarik data gudang: " . implode('; ', $error_messages), 'error');
			} else {
				set_message("Sebagian data gudang gagal ditarik ({$total_synced} gudang berhasil): " . implode('; ', $error_messages), 'warning');
			}
		} else {
			set_message("Berhasil menarik {$total_synced} data gudang beserta opsi pengiriman dan kurir logistik.", 'success');
		}

		redirect($redirect_url);
	}
	
	/**
	* Update view Tiktok Warehousess
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('tiktok_warehouses_update');

		$this->data['tiktok_warehouses'] = $this->model_tiktok_warehouses->find($id);

		$this->template->title('Daftar Gudang Update');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_update', $this->data);
	}

	/**
	* Update Tiktok Warehousess
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_warehouses_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('name', 'Nama Gudang TikTok', 'trim|required');
		$this->form_validation->set_rules('address', 'Alamat Gudang', 'trim');
		$this->form_validation->set_rules('warehouse_type', 'Tipe Gudang', 'trim');
		$this->form_validation->set_rules('effect_status', 'Status', 'trim');
		$this->form_validation->set_rules('is_default', 'Gudang Utama', 'trim');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'shop_id' => $this->input->post('shop_id'),
				'tiktok_warehouse_id' => $this->input->post('tiktok_warehouse_id'),
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'warehouse_type' => $this->input->post('warehouse_type'),
				'effect_status' => $this->input->post('effect_status'),
				'is_default' => $this->input->post('is_default'),
			];

			
			$save_tiktok_warehouses = $this->model_tiktok_warehouses->change($id, $save_data);

			if ($save_tiktok_warehouses) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_warehouses', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Warehousess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_warehouses_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_warehouses'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_warehouses'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Warehousess
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_warehouses_view');

		$warehouse = $this->model_tiktok_warehouses->join_avaiable()->filter_avaiable()->find($id);
		if ($warehouse) {
			$delivery_options = $this->db->get_where('tiktok_delivery_options', ['warehouse_id' => $warehouse->id])->result();
			foreach ($delivery_options as $dopt) {
				$dopt->shipping_providers = $this->db->get_where('tiktok_shipping_providers', ['delivery_option_id' => $dopt->id])->result();
			}
			$warehouse->delivery_options = $delivery_options;
		}

		$this->data['tiktok_warehouses'] = $warehouse;

		$this->template->title('Daftar Gudang Detail');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_view', $this->data);
	}
	
	/**
	* delete Tiktok Warehousess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_warehouses = $this->model_tiktok_warehouses->find($id);

		
		
		return $this->model_tiktok_warehouses->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_warehouses_export');

		$this->model_tiktok_warehouses->export('tiktok_warehouses', 'tiktok_warehouses');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_warehouses_export');

		$this->model_tiktok_warehouses->pdf('tiktok_warehouses', 'tiktok_warehouses');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_warehouses_export');

		$table = $title = 'tiktok_warehouses';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_warehouses->find($id);
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
}


/* End of file tiktok_warehouses.php */
/* Location: ./application/controllers/administrator/Tiktok Warehouses.php */