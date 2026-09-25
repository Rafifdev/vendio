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
		$field = $this->input->get('f');

		$this->data['tiktok_shopss'] = $this->model_tiktok_shops->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_shops_counts'] = $this->model_tiktok_shops->count_all($filter, $field);

		$config = [
			'base_url' => 'administrator/tiktok_shops/index/',
			'total_rows' => $this->model_tiktok_shops->count_all($filter, $field),
			'per_page' => $this->limit_page,
			'uri_segment' => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Kelola Toko List');
		$this->render('backend/standart/administrator/tiktok_shops/tiktok_shops_list', $this->data);
	}

	/**
	 * Add new tiktok_shopss
	 *
	 */
	public function add()
	{
		$this->is_allowed('tiktok_shops_add');

		$this->template->title('Kelola Toko New');
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

		$this->form_validation->set_rules('auth_code', 'Auth Code', 'trim|required');

		if ($this->form_validation->run()) {
			$this->load->library('tiktok_api');
			$cfg = $this->config->item('tiktok');

			$app_key    = !empty($this->input->post('app_key')) ? trim($this->input->post('app_key')) : (!empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : getenv('APP_KEY_TIKTOK'));
			$app_secret = !empty($this->input->post('app_secret')) ? trim($this->input->post('app_secret')) : (!empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : getenv('APP_SECRET_TIKTOK'));
			$auth_code  = trim($this->input->post('auth_code'));
			$is_active  = 1;

			$token_res = $this->tiktok_api->get_access_token($auth_code, $app_key, $app_secret);

			if ($token_res['success'] && !empty($token_res['data']['access_token'])) {
				$save_tiktok_shops = $this->tiktok_api->save_token_response($token_res['data'], $app_key, $app_secret, $auth_code);
				if ($save_tiktok_shops) {
					$this->db->where('id', $save_tiktok_shops)->update('tiktok_shops', ['is_active' => $is_active]);
				}
			} else {
				$err_msg = $token_res['message'] ?? 'Gagal menukarkan Auth Code ke TikTok API. Pastikan kode masih berlaku (maks 5 menit) dan belum pernah digunakan.';
				echo json_encode([
					'success' => false,
					'message' => 'Gagal verifikasi TikTok: ' . $err_msg
				]);
				exit;
			}


			if ($save_tiktok_shops) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] = $save_tiktok_shops;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_shops/edit/' . $save_tiktok_shops, 'Edit Tiktok Shops'),
						anchor('administrator/tiktok_shops', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
							anchor('administrator/tiktok_shops/edit/' . $save_tiktok_shops, 'Edit Tiktok Shops')
						]),
						'success'
					);

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

		$this->template->title('Kelola Toko Update');
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

		$this->form_validation->set_rules('is_active', 'Is Active', 'trim|required');

		if ($this->form_validation->run()) {
			$cfg = $this->config->item('tiktok');
			$existing_shop = $this->model_tiktok_shops->find($id);

			$app_key    = !empty($this->input->post('app_key')) ? trim($this->input->post('app_key')) : (!empty($existing_shop->app_key) ? $existing_shop->app_key : ($cfg['tiktok_app_key'] ?? getenv('APP_KEY_TIKTOK')));
			$app_secret = !empty($this->input->post('app_secret')) ? trim($this->input->post('app_secret')) : (!empty($existing_shop->app_secret) ? $existing_shop->app_secret : ($cfg['tiktok_app_secret'] ?? getenv('APP_SECRET_TIKTOK')));
			$auth_code  = trim($this->input->post('auth_code'));
			$is_active  = $this->input->post('is_active');

			if (!empty($auth_code) && ($existing_shop && $existing_shop->auth_code !== $auth_code)) {
				$this->load->library('tiktok_api');
				$token_res = $this->tiktok_api->get_access_token($auth_code, $app_key, $app_secret);

				if ($token_res['success'] && !empty($token_res['data']['access_token'])) {
					$save_tiktok_shops = $this->tiktok_api->save_token_response($token_res['data'], $app_key, $app_secret, $auth_code);
					if ($save_tiktok_shops) {
						$this->db->where('id', $save_tiktok_shops)->update('tiktok_shops', ['is_active' => $is_active]);
					}
				} else {
					$err_msg = $token_res['message'] ?? 'Gagal menukarkan Auth Code ke TikTok API. Pastikan kode masih berlaku (maks 5 menit) dan belum pernah digunakan.';
					echo json_encode([
						'success' => false,
						'message' => 'Gagal verifikasi TikTok: ' . $err_msg
					]);
					exit;
				}
			} else {
				$save_data = [
					'is_active'  => $is_active,
				];
				if (!empty($auth_code)) {
					$save_data['auth_code'] = $auth_code;
				}

				$save_tiktok_shops = $this->model_tiktok_shops->change($id, $save_data);
			}

			if ($save_tiktok_shops) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_shops', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
						]),
						'success'
					);

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
		} elseif (count($arr_id) > 0) {
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

		$this->template->title('Kelola Toko Detail');
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
		$this->pdf->Output($table . '.pdf', 'H');
	}

	/**
	 * Redirect ke halaman otorisasi TikTok Partner OAuth
	 */
	public function connect()
	{
		$this->is_allowed('tiktok_shops_add');
		$this->load->library('tiktok_api');

		$auth_url = $this->tiktok_api->get_auth_url();
		redirect($auth_url);
	}

	/**
	 * Callback URL dari TikTok setelah seller authorize
	 */
	public function callback()
	{
		$this->load->library('tiktok_api');
		$cfg = $this->config->item('tiktok');

		$auth_code = $this->input->get('auth_code') ?: $this->input->get('code');
		$app_key   = !empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : $this->config->item('tiktok_app_key');
		$app_secret = !empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : $this->config->item('tiktok_app_secret');

		if (empty($auth_code)) {
			set_message('Gagal menghubungkan toko: Parameter auth_code/code tidak ditemukan di URL.', 'error');
			redirect('administrator/tiktok_shops');
			return;
		}

		$res = $this->tiktok_api->get_access_token($auth_code, $app_key, $app_secret);

		if ($res['success'] && !empty($res['data']['access_token'])) {
			$this->tiktok_api->save_token_response($res['data'], $app_key, $app_secret, $auth_code);
			set_message('Berhasil menghubungkan Toko TikTok Shop!', 'success');
		} else {
			$err = $res['message'] ?? 'Terjadi kesalahan saat memproses token.';
			set_message('Gagal menukarkan token dari TikTok: ' . $err, 'error');
		}

		redirect('administrator/tiktok_shops');
	}

	/**
	 * Manual Refresh Access Token Toko TikTok
	 */
	public function refresh_token($id = null)
	{
		$this->is_allowed('tiktok_shops_update');
		$this->load->library('tiktok_api');

		$shop = $this->model_tiktok_shops->find($id);

		if (!$shop) {
			set_message('Data toko tidak ditemukan.', 'error');
			redirect('administrator/tiktok_shops');
			return;
		}

		if (empty($shop->refresh_token)) {
			set_message('Refresh token tidak tersedia untuk toko ini. Silakan hubungkan ulang akun TikTok.', 'error');
			redirect('administrator/tiktok_shops');
			return;
		}

		$cfg = $this->config->item('tiktok');
		$app_key = !empty($shop->app_key) ? $shop->app_key : (!empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : $this->config->item('tiktok_app_key'));
		$app_secret = !empty($shop->app_secret) ? $shop->app_secret : (!empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : $this->config->item('tiktok_app_secret'));

		$res = $this->tiktok_api->refresh_access_token($shop->refresh_token, $app_key, $app_secret);

		if ($res['success'] && !empty($res['data']['access_token'])) {
			$token_data = $res['data'];
			$update_data = [
				'access_token'            => $token_data['access_token'],
				'access_token_expire_in'  => $token_data['access_token_expire_in'] ?? null,
				'refresh_token'           => !empty($token_data['refresh_token']) ? $token_data['refresh_token'] : $shop->refresh_token,
				'refresh_token_expire_in' => $token_data['refresh_token_expire_in'] ?? null,
				'updated_at'              => date('Y-m-d H:i:s'),
			];
			$this->db->where('id', $id)->update('tiktok_shops', $update_data);
			set_message('Berhasil me-refresh Access Token Toko TikTok!', 'success');
		} else {
			$err = $res['message'] ?? 'Terjadi kesalahan saat me-refresh token.';
			set_message('Gagal me-refresh token: ' . $err, 'error');
		}

		$ref = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('administrator/tiktok_shops');
		redirect($ref);
	}
}


/* End of file tiktok_shops.php */
/* Location: ./application/controllers/administrator/Tiktok Shops.php */