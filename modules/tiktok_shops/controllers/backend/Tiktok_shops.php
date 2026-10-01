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

		$this->load->library('tiktok_api');
		$this->data['auth_url'] = $this->tiktok_api->get_auth_url();

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

		$this->form_validation->set_rules('auth_code', 'Auth Code', 'trim|required');
		$this->form_validation->set_rules('is_active', 'Status Toko', 'trim|required');
		$this->form_validation->set_rules('app_key', 'App Key', 'trim');
		$this->form_validation->set_rules('app_secret', 'App Secret', 'trim');
		

		if ($this->form_validation->run()) {
			$this->load->library('tiktok_api');
			$cfg = $this->config->item('tiktok');

			$app_key    = !empty($this->input->post('app_key')) ? trim($this->input->post('app_key')) : (!empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : getenv('APP_KEY_TIKTOK'));
			$app_secret = !empty($this->input->post('app_secret')) ? trim($this->input->post('app_secret')) : (!empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : getenv('APP_SECRET_TIKTOK'));
			$auth_code  = trim($this->input->post('auth_code'));
			$is_active  = $this->input->post('is_active');

			if (!empty($auth_code)) {
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
					'app_key'    => $app_key,
					'app_secret' => $app_secret,
					'auth_code'  => $auth_code,
					'is_active'  => $is_active,
				];
				if ($this->input->post('shop_name')) {
					$save_data['shop_name'] = $this->input->post('shop_name');
				}
				$save_tiktok_shops = $this->model_tiktok_shops->store($save_data);
			}

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

		$this->load->library('tiktok_api');
		$this->data['auth_url'] = $this->tiktok_api->get_auth_url();

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
			$this->load->library('tiktok_api');
			$app_key    = trim($this->input->post('app_key'));
			$app_secret = trim($this->input->post('app_secret'));
			$auth_code  = trim($this->input->post('auth_code'));
			$is_active  = $this->input->post('is_active');
			$shop_name  = $this->input->post('shop_name');

			if (!empty($auth_code)) {
				$token_res = $this->tiktok_api->get_access_token($auth_code, $app_key, $app_secret);

				if ($token_res['success'] && !empty($token_res['data']['access_token'])) {
					$saved_id = $this->tiktok_api->save_token_response($token_res['data'], $app_key, $app_secret, $auth_code);
					if ($saved_id) {
						$this->db->where('id', $id)->update('tiktok_shops', [
							'shop_name'  => $shop_name,
							'app_key'    => $app_key,
							'app_secret' => $app_secret,
							'is_active'  => $is_active,
						]);
					}
					$save_tiktok_shops = true;
				} else {
					$err_msg = $token_res['message'] ?? 'Gagal menukarkan Auth Code ke TikTok API.';
					echo json_encode([
						'success' => false,
						'message' => 'Gagal verifikasi TikTok: ' . $err_msg
					]);
					exit;
				}
			} else {
				$save_data = [
					'shop_name'  => $shop_name,
					'app_key'    => $app_key,
					'app_secret' => $app_secret,
					'is_active'  => $is_active,
				];
				$save_tiktok_shops = $this->model_tiktok_shops->change($id, $save_data);
			}

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

	/**
	 * Memastikan tabel tiktok_oauth_states tersedia di database
	 */
	private function _ensure_oauth_table()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `tiktok_oauth_states` (
		  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
		  `state` VARCHAR(128) NOT NULL,
		  `client_name` VARCHAR(150) DEFAULT NULL,
		  `created_by` INT UNSIGNED DEFAULT NULL,
		  `is_used` TINYINT(1) DEFAULT 0,
		  `shop_id` INT UNSIGNED DEFAULT NULL,
		  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
		  `expires_at` DATETIME NOT NULL,
		  `used_at` DATETIME DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `idx_state` (`state`),
		  KEY `idx_expires` (`expires_at`, `is_used`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
	}

	/**
	 * Halaman status publik hasil otorisasi OAuth TikTok Shop
	 * (Dapat diakses publik tanpa login)
	 */
	public function auth_status()
	{
		$this->output->enable_profiler(FALSE);
		$status = $this->input->get('status') ?: 'success';
		$shop_name = $this->input->get('shop') ?: '';
		$error_message = $this->input->get('msg') ?: '';

		$data = [
			'page_title'    => 'Status Otorisasi TikTok Shop - Vendio',
			'status'        => $status,
			'shop_name'     => $shop_name,
			'error_message' => $error_message,
		];

		$this->load->view('public/auth_status', $data);
	}

	/**
	 * Generate One-Time Authorization Link (Token Sekali Pakai)
	 */
	public function generate_auth_link()
	{
		$this->is_allowed('tiktok_shops_add');
		$this->_ensure_oauth_table();
		$this->load->library('tiktok_api');

		$client_name = trim((string)$this->input->post('client_name') ?: (string)$this->input->get('client_name'));
		$duration = intval($this->input->post('duration') ?: $this->input->get('duration')) ?: 60; // default 60 menit
		if ($duration < 5) $duration = 5;
		if ($duration > 43200) $duration = 43200; // max 30 hari

		$state = bin2hex(random_bytes(16));
		$expires_at = date('Y-m-d H:i:s', time() + ($duration * 60));

		$this->db->insert('tiktok_oauth_states', [
			'state'       => $state,
			'client_name' => !empty($client_name) ? $client_name : null,
			'created_by'  => get_user_data('id') ?: null,
			'is_used'     => 0,
			'expires_at'  => $expires_at,
			'created_at'  => date('Y-m-d H:i:s'),
		]);

		$auth_url = $this->tiktok_api->get_auth_url(null, $state);

		$response = [
			'status'      => true,
			'auth_url'    => $auth_url,
			'state'       => $state,
			'client_name' => $client_name,
			'expires_at'  => date('d M Y, H:i', strtotime($expires_at)) . ' WIB',
			'message'     => 'Link otorisasi sekali pakai berhasil dibuat!'
		];

		if ($this->input->is_ajax_request() || $this->input->get('json')) {
			echo json_encode($response);
			return;
		}

		set_message('Link otorisasi sekali pakai berhasil dibuat!', 'success');
		redirect('administrator/tiktok_shops');
	}

	/**
	 * Redirect ke halaman otorisasi TikTok Partner OAuth
	 */
	public function connect()
	{
		$this->_ensure_oauth_table();
		$this->load->library('tiktok_api');

		$state = $this->input->get('state');

		// Jika state diberikan (misal dari tautan klien)
		if (!empty($state)) {
			$state_row = $this->db->get_where('tiktok_oauth_states', ['state' => $state])->row();
			if (!$state_row) {
				redirect('administrator/tiktok_shops/auth_status?status=invalid');
				return;
			}
			if ($state_row->is_used == 1) {
				redirect('administrator/tiktok_shops/auth_status?status=already_used');
				return;
			}
			if (strtotime($state_row->expires_at) < time()) {
				redirect('administrator/tiktok_shops/auth_status?status=expired');
				return;
			}

			$auth_url = $this->tiktok_api->get_auth_url(null, $state);
			redirect($auth_url);
			return;
		}

		// Jika diakses langsung tanpa state oleh Admin Vendio yang login
		if ($this->aauth->is_loggedin()) {
			$this->is_allowed('tiktok_shops_add');
			$state = bin2hex(random_bytes(16));
			$expires_at = date('Y-m-d H:i:s', time() + 3600);
			$this->db->insert('tiktok_oauth_states', [
				'state'       => $state,
				'client_name' => 'Admin Direct Connect',
				'created_by'  => get_user_data('id') ?: null,
				'is_used'     => 0,
				'expires_at'  => $expires_at,
				'created_at'  => date('Y-m-d H:i:s'),
			]);
			$auth_url = $this->tiktok_api->get_auth_url(null, $state);

			if ($this->input->is_ajax_request() || $this->input->get('json')) {
				echo json_encode(['success' => true, 'auth_url' => $auth_url]);
				return;
			}
			redirect($auth_url);
			return;
		}

		// Jika bukan admin dan tanpa state
		redirect('administrator/tiktok_shops/auth_status?status=invalid');
	}

	/**
	 * Callback URL dari TikTok setelah seller authorize
	 */
	public function callback()
	{
		$this->_ensure_oauth_table();
		$this->load->library('tiktok_api');
		$cfg = $this->config->item('tiktok');

		$auth_code = $this->input->get('auth_code') ?: $this->input->get('code');
		$state     = $this->input->get('state');
		$app_key   = !empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : $this->config->item('tiktok_app_key');
		$app_secret = !empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : $this->config->item('tiktok_app_secret');

		// 1. Validasi keberadaan kode otorisasi
		if (empty($auth_code)) {
			if ($this->aauth->is_loggedin()) {
				set_message('Gagal menghubungkan toko: Parameter auth_code/code tidak ditemukan di URL.', 'error');
				redirect('administrator/tiktok_shops');
			} else {
				redirect('administrator/tiktok_shops/auth_status?status=error&msg=' . urlencode('Parameter auth_code tidak ditemukan dari TikTok.'));
			}
			return;
		}

		// 2. Validasi Parameter State (One-Time Link Protection)
		if (!empty($state)) {
			$state_row = $this->db->get_where('tiktok_oauth_states', ['state' => $state])->row();

			// Jika state tidak ada di database kita
			if (!$state_row) {
				redirect('administrator/tiktok_shops/auth_status?status=invalid');
				return;
			}

			// Jika state SUDAH PERNAH DIGUNAKAN (Anti-Reuse: mencegah link disebar ke teman klien)
			if ($state_row->is_used == 1) {
				redirect('administrator/tiktok_shops/auth_status?status=already_used');
				return;
			}

			// Jika state SUDAH KEDALUWARSA (Expired)
			if (strtotime($state_row->expires_at) < time()) {
				redirect('administrator/tiktok_shops/auth_status?status=expired');
				return;
			}

			// Kunci state seketika (Atomic burn) agar tidak bisa dipakai oleh request lain bersamaan
			$this->db->where('id', $state_row->id)->update('tiktok_oauth_states', [
				'is_used' => 1,
				'used_at' => date('Y-m-d H:i:s'),
			]);
		}

		// 3. Tukar auth_code ke TikTok API untuk mendapatkan access_token & refresh_token
		$res = $this->tiktok_api->get_access_token($auth_code, $app_key, $app_secret);

		if ($res['success'] && !empty($res['data']['access_token'])) {
			$saved_shop_id = $this->tiktok_api->save_token_response($res['data'], $app_key, $app_secret, $auth_code);
			$shop_name = $res['data']['seller_name'] ?? 'TikTok Shop';

			// Update id toko yang berhasil dihubungkan ke record state
			if (!empty($state) && !empty($state_row)) {
				$this->db->where('id', $state_row->id)->update('tiktok_oauth_states', [
					'shop_id' => $saved_shop_id
				]);
			}

			if ($this->aauth->is_loggedin()) {
				set_message('Berhasil menghubungkan Akun Toko TikTok Shop: ' . $shop_name, 'success');
				redirect('administrator/tiktok_shops');
			} else {
				redirect('administrator/tiktok_shops/auth_status?status=success&shop=' . urlencode($shop_name));
			}
		} else {
			$err = $res['message'] ?? 'Terjadi kesalahan saat menukarkan token dengan TikTok.';
			if ($this->aauth->is_loggedin()) {
				set_message('Gagal menukarkan token dari TikTok: ' . $err, 'error');
				redirect('administrator/tiktok_shops');
			} else {
				redirect('administrator/tiktok_shops/auth_status?status=error&msg=' . urlencode($err));
			}
		}
	}

	/**
	 * Tarik / Sinkronisasi Semua Data Toko dari TikTok API
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_shops_list');
		$this->load->library('tiktok_api');

		$shops = $this->db->get('tiktok_shops')->result();
		if (empty($shops)) {
			set_message('Belum ada akun toko yang terdaftar.', 'warning');
			redirect('administrator/tiktok_shops');
			return;
		}

		$total_synced = 0;
		$error_messages = [];
		$cfg = $this->config->item('tiktok');

		foreach ($shops as $shop) {
			if (empty($shop->access_token)) {
				continue;
			}

			// Refresh token jika mendekati expired
			$expire_ts = (int) $shop->access_token_expire_in;
			if ($expire_ts > 0 && ($expire_ts - time()) < 3600 && !empty($shop->refresh_token)) {
				$ref_res = $this->tiktok_api->refresh_access_token($shop->refresh_token, $shop->app_key, $shop->app_secret);
				if (!empty($ref_res['success']) && !empty($ref_res['data']['access_token'])) {
					$shop->access_token = $ref_res['data']['access_token'];
					$this->tiktok_api->save_token_response($ref_res['data'], $shop->app_key, $shop->app_secret);
				}
			}

			$app_key = !empty($shop->app_key) ? $shop->app_key : (!empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : $this->config->item('tiktok_app_key'));
			$app_secret = !empty($shop->app_secret) ? $shop->app_secret : (!empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : $this->config->item('tiktok_app_secret'));

			$shops_resp = $this->tiktok_api->get_authorized_shops($shop->access_token, $app_key, $app_secret);

			if (!empty($shops_resp['data']['shops'][0])) {
				$first_shop = $shops_resp['data']['shops'][0];
				$update_data = [
					'shop_id'     => $first_shop['id'] ?? $shop->shop_id,
					'shop_name'   => $first_shop['name'] ?? $shop->shop_name,
					'shop_code'   => $first_shop['code'] ?? $shop->shop_code,
					'shop_cipher' => $first_shop['cipher'] ?? $shop->shop_cipher,
					'seller_type' => $first_shop['seller_type'] ?? $shop->seller_type,
					'updated_at'  => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $shop->id)->update('tiktok_shops', $update_data);
				$total_synced++;
			} else {
				$err_msg = $shops_resp['message'] ?? 'Gagal mengambil data toko dari TikTok API';
				$error_messages[] = $shop->shop_name . ': ' . $err_msg;
			}
		}

		if ($total_synced > 0) {
			set_message("Berhasil menarik & memperbarui data {$total_synced} akun toko dari TikTok Shop.", 'success');
		} else {
			if (!empty($error_messages)) {
				set_message("Gagal menarik data toko: " . implode('; ', $error_messages), 'error');
			} else {
				set_message("Belum ada akun toko dengan token aktif yang dapat ditarik.", 'warning');
			}
		}

		redirect('administrator/tiktok_shops');
	}

	/**
	 * Sinkronisasi Shop Cipher & Informasi Toko langsung dari TikTok API
	 *
	 * @param int $id
	 */
	public function sync_cipher($id = null)
	{
		$this->is_allowed('tiktok_shops_update');

		$shop = $this->model_tiktok_shops->find($id);
		if (!$shop) {
			set_message('Data toko tidak ditemukan.', 'error');
			redirect_back();
		}

		if (empty($shop->access_token)) {
			set_message('Access token belum tersedia untuk toko ini. Silakan hubungkan ulang akun TikTok.', 'error');
			redirect_back();
		}

		$this->load->library('tiktok_api');
		$cfg = $this->config->item('tiktok');
		$app_key = !empty($shop->app_key) ? $shop->app_key : (!empty($cfg['tiktok_app_key']) ? $cfg['tiktok_app_key'] : $this->config->item('tiktok_app_key'));
		$app_secret = !empty($shop->app_secret) ? $shop->app_secret : (!empty($cfg['tiktok_app_secret']) ? $cfg['tiktok_app_secret'] : $this->config->item('tiktok_app_secret'));

		$shops_resp = $this->tiktok_api->get_authorized_shops($shop->access_token, $app_key, $app_secret);

		if (!empty($shops_resp['data']['shops'][0])) {
			$first_shop = $shops_resp['data']['shops'][0];
			$update_data = [
				'shop_id'     => $first_shop['id'] ?? $shop->shop_id,
				'shop_name'   => $first_shop['name'] ?? $shop->shop_name,
				'shop_code'   => $first_shop['code'] ?? $shop->shop_code,
				'shop_cipher' => $first_shop['cipher'] ?? $shop->shop_cipher,
				'seller_type' => $first_shop['seller_type'] ?? $shop->seller_type,
				'updated_at'  => date('Y-m-d H:i:s'),
			];
			$this->db->where('id', $shop->id)->update('tiktok_shops', $update_data);
			set_message("Berhasil sinkronisasi Shop Cipher toko {$update_data['shop_name']}!", 'success');
		} else {
			$err_msg = $shops_resp['message'] ?? 'Gagal mengambil data toko dari TikTok API.';
			set_message("Gagal sinkronisasi cipher toko {$shop->shop_name}: {$err_msg}", 'error');
		}

		redirect_back();
	}
}


/* End of file tiktok_shops.php */
/* Location: ./application/controllers/administrator/Tiktok Shops.php */