<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Shops Controller
*| --------------------------------------------------------------------------
*| Tiktok Shops site
*|
*/
class Tiktok_shops extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_shops');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Shopss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_shops_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_shopss'] = $this->model_tiktok_shops->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_shops_counts'] = $this->model_tiktok_shops->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_shops/index/',
			'total_rows'   => $this->model_tiktok_shops->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Akun Toko List');
		$this->render('backend/standart/administrator/tiktok_shops/tiktok_shops_list', $this->data);
	}
	
	/**
	* Add new tiktok_shopss
	*
	*/
	public function add()
	{
		$this->is_allowed('tiktok_shops_add');

		$this->template->title('Akun Toko New');
		$this->render('backend/standart/administrator/tiktok_shops/tiktok_shops_add', $this->data);
	}

	/**
	* Add New Tiktok Shopss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_shops_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('app_key', 'App Key', 'trim|required');
		$this->form_validation->set_rules('app_secret', 'App Secret', 'trim|required');
		$this->form_validation->set_rules('is_active', 'Is Active', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'app_key' => $this->input->post('app_key'),
				'app_secret' => $this->input->post('app_secret'),
				'auth_code' => $this->input->post('auth_code'),
				'is_active' => $this->input->post('is_active'),
			];

			
			$save_tiktok_shops = $this->model_tiktok_shops->store($save_data);
            

			if ($save_tiktok_shops) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_shops;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_shops/edit/' . $save_tiktok_shops, 'Edit Tiktok Shops'),
						anchor('administrator/tiktok_shops', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_shops/edit/' . $save_tiktok_shops, 'Edit Tiktok Shops')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_shops');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_shops');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Tiktok Shopss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('tiktok_shops_update');

		$this->data['tiktok_shops'] = $this->model_tiktok_shops->find($id);

		$this->template->title('Akun Toko Update');
		$this->render('backend/standart/administrator/tiktok_shops/tiktok_shops_update', $this->data);
	}

	/**
	* Update Tiktok Shopss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_shops_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('shop_name', 'Nama Toko', 'trim|required');
		$this->form_validation->set_rules('app_key', 'App Key', 'trim|required');
		$this->form_validation->set_rules('app_secret', 'App Secret', 'trim|required');
		$this->form_validation->set_rules('is_active', 'Status Toko', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'shop_name'  => $this->input->post('shop_name'),
				'app_key'    => $this->input->post('app_key'),
				'app_secret' => $this->input->post('app_secret'),
				'is_active'  => $this->input->post('is_active'),
			];
			if ($this->input->post('auth_code') !== null && $this->input->post('auth_code') !== '') {
				$save_data['auth_code'] = $this->input->post('auth_code');
			}

			
			$save_tiktok_shops = $this->model_tiktok_shops->change($id, $save_data);

			if ($save_tiktok_shops) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_shops', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_shops');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_shops');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	/**
	* Refresh Access Token TikTok Shop
	*
	* @param int $id
	*/
	public function refresh_token($id = null)
	{
		$this->is_allowed('tiktok_shops_update');

		$shop = $this->model_tiktok_shops->find($id);
		if (!$shop) {
			set_message('Data toko tidak ditemukan.', 'error');
			redirect_back();
		}

		if (empty($shop->refresh_token)) {
			set_message('Refresh token tidak tersedia untuk toko ini. Silakan lakukan otorisasi ulang.', 'error');
			redirect_back();
		}

		$this->load->library('tiktok_api');
		$ref_res = $this->tiktok_api->refresh_access_token($shop->refresh_token, $shop->app_key, $shop->app_secret);

		if (isset($ref_res['code']) && $ref_res['code'] === 0 && !empty($ref_res['data']['access_token'])) {
			$new_data = $ref_res['data'];
			$this->db->where('id', $shop->id)->update('tiktok_shops', [
				'access_token'            => $new_data['access_token'],
				'access_token_expire_in'  => $new_data['access_token_expire_in'],
				'refresh_token'           => $new_data['refresh_token'],
				'refresh_token_expire_in' => $new_data['refresh_token_expire_in'],
				'updated_at'              => date('Y-m-d H:i:s'),
			]);

			$hours = round(($new_data['access_token_expire_in'] - time()) / 3600, 1);
			set_message("Berhasil memperbarui access token toko {$shop->shop_name}! Token aktif untuk {$hours} jam ke depan.", 'success');
		} else {
			$err_msg = $ref_res['message'] ?? 'Terjadi kesalahan saat refresh token ke TikTok Shop API.';
			set_message("Gagal memperbarui token toko {$shop->shop_name}: {$err_msg}", 'error');
		}

		redirect_back();
	}
	
	/**
	* delete Tiktok Shopss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_shops_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_shops'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_shops'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Shopss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_shops_view');

		$this->data['tiktok_shops'] = $this->model_tiktok_shops->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Akun Toko Detail');
		$this->render('backend/standart/administrator/tiktok_shops/tiktok_shops_view', $this->data);
	}
	
	/**
	* delete Tiktok Shopss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_shops = $this->model_tiktok_shops->find($id);

		
		
		return $this->model_tiktok_shops->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_shops_export');

		$this->model_tiktok_shops->export('tiktok_shops', 'tiktok_shops');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_shops_export');

		$this->model_tiktok_shops->pdf('tiktok_shops', 'tiktok_shops');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_shops_export');

		$table = $title = 'tiktok_shops';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_shops->find($id);
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


/* End of file tiktok_shops.php */
/* Location: ./application/controllers/administrator/Tiktok Shops.php */