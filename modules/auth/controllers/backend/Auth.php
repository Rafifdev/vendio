<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Auth Controller
*| --------------------------------------------------------------------------
*| For authentication
*|
*/
class Auth extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Login user
	*
	*/
	public function login()
	{
		if ($this->aauth->is_loggedin()) {
			redirect('administrator/dashboard', 'refresh');
		}
		$data = [];
		$this->config->load('site');

		$this->form_validation->set_rules('username', 'Email atau Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
		$this->form_validation->set_message('required', '%s wajib diisi.');

		if ($this->form_validation->run()) {
			$username_input = trim($this->input->post('username'));
			$password_input = $this->input->post('password');
			$remember = $this->input->post('remember');

			if ($this->aauth->login($username_input, $password_input, $remember)) {
				$ref = $this->session->userdata('redirect');
        
				if ($ref) {
					redirect($ref, 'refresh');
				} else {
					redirect('administrator/dashboard', 'refresh');
				}

			} else {
				// Cek apakah akun belum aktif (menunggu verifikasi OTP)
				$check_user = $this->db->group_start()
					->where('email', $username_input)
					->or_where('username', $username_input)
					->group_end()
					->get('aauth_users')
					->row();

				if ($check_user && $check_user->banned == 1 && !empty($check_user->otp_code)) {
					// Periksa apakah password cocok
					if ($this->aauth->verify_password($password_input, $check_user->pass)) {
						$this->session->set_userdata([
							'pending_otp_user_id' => $check_user->id,
							'pending_otp_email'   => $check_user->email,
							'pending_otp_name'    => $check_user->full_name
						]);
						set_message('Akun Anda belum aktif. Silakan masukkan kode OTP yang telah dikirim ke email Anda untuk mengaktifkan akun.', 'warning');
						redirect('administrator/verify-otp', 'refresh');
					}
				}

				$auth_err = $this->aauth->print_errors(TRUE);
				$data['error'] = !empty($auth_err) ? $auth_err : 'Email/Username atau Kata Sandi yang Anda masukkan salah. Silakan periksa kembali.';
			}
		} else {
			$data['error'] = validation_errors();
		}
		$this->template->build('backend/standart/administrator/login', $data);
	}

	/**
	* Register tenant / member
	*
	*/
	public function register()
	{
		$data = [];

		$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[aauth_users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[aauth_users.email]');
		$this->form_validation->set_rules('phone', 'Nomor WhatsApp', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('company_name', 'Nama Toko / Perusahaan', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('agree', 'Syarat Layanan & Kebijakan Privasi', 'trim|required');

		$this->form_validation->set_message('required', '%s wajib diisi.');
		$this->form_validation->set_message('is_unique', '%s sudah terdaftar. Silakan gunakan yang lain.');
		$this->form_validation->set_message('valid_email', 'Format %s tidak valid.');
		$this->form_validation->set_message('min_length', '%s minimal harus berisi %s karakter.');

		if ($this->form_validation->run()) {
			$company_name = trim($this->input->post('company_name'));
			$phone        = trim($this->input->post('phone'));
			$email        = trim($this->input->post('email'));
			$username     = trim($this->input->post('username'));
			$full_name    = trim($this->input->post('full_name'));
			
			// Buat slug tenant unik
			$base_slug = url_title(strtolower($company_name));
			$slug = $base_slug ?: 'store-' . substr(uniqid(), -4);
			$check_slug = $this->db->get_where('tenants', ['tenant_slug' => $slug])->num_rows();
			if ($check_slug > 0) {
				$slug = $slug . '-' . substr(uniqid(), -4);
			}

			// Simpan user baru dengan image default yang sama
			$save_data = [
				'full_name' => $full_name,
				'avatar'    => '20261001140657-default.png'
			];
			$save_user = $this->aauth->create_user($email, $this->input->post('password'), $username, $save_data);

			if ($save_user) {
				// Simpan tenant baru
				$tenant_data = [
					'tenant_name'          => $company_name,
					'tenant_slug'          => $slug,
					'owner_user_id'        => $save_user,
					'plan_id'              => 1, // Starter (Free Trial)
					'status'               => 'trial',
					'trial_ends_at'        => date('Y-m-d H:i:s', strtotime('+14 days')),
					'subscription_ends_at' => date('Y-m-d H:i:s', strtotime('+14 days')),
					'phone'                => $phone,
					'created_at'           => date('Y-m-d H:i:s'),
				];
				$this->db->insert('tenants', $tenant_data);
				$tenant_id = $this->db->insert_id();

				// Generate 6 digit kode OTP & kedaluwarsa 15 menit
				$otp_code = (string) mt_rand(100000, 999999);
				$otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

				// Update user: tenant_id, banned = 1 (menunggu verifikasi OTP), otp_code, otp_expires_at
				$this->db->where('id', $save_user)->update('aauth_users', [
					'tenant_id'      => $tenant_id,
					'banned'         => 1,
					'otp_code'       => $otp_code,
					'otp_expires_at' => $otp_expires_at
				]);

				// Add to Member group (4)
				$this->aauth->add_member($save_user, 4);

				// Simpan sesi pending OTP
				$this->session->set_userdata([
					'pending_otp_user_id' => $save_user,
					'pending_otp_email'   => $email,
					'pending_otp_name'    => $full_name
				]);

				// Kirim email OTP via Brevo SMTP
				$send_status = $this->_send_otp_email($email, $otp_code, $full_name);

				if ($send_status['success'] && empty($send_status['warning'])) {
					set_message('Pendaftaran berhasil! Kode OTP telah dikirimkan ke email Anda.', 'success');
				} else {
					if (!empty($send_status['warning'])) {
						set_message($send_status['warning'], 'warning');
					} else {
						set_message('Pendaftaran berhasil! Kode OTP telah dikirimkan ke email Anda.', 'success');
					}
				}

				redirect('administrator/verify-otp', 'refresh');
			} else {
				$data['error'] = $this->aauth->print_errors();
			}
		} else {
			$data['error'] = validation_errors();
		}

		$this->template->build('backend/standart/administrator/register_member', $data);
	}

	/**
	* Verifikasi Kode OTP setelah Registrasi
	*
	*/
	public function verify_otp()
	{
		if ($this->aauth->is_loggedin()) {
			redirect('administrator/dashboard', 'refresh');
		}

		$pending_user_id = $this->session->userdata('pending_otp_user_id');

		if (!$pending_user_id) {
			set_message('Sesi verifikasi telah berakhir atau tidak ditemukan. Silakan masuk atau daftar kembali.', 'warning');
			redirect('administrator/login', 'refresh');
		}

		$user = $this->db->get_where('aauth_users', ['id' => $pending_user_id])->row();
		if (!$user) {
			$this->session->unset_userdata(['pending_otp_user_id', 'pending_otp_email', 'pending_otp_name']);
			set_message('Pengguna tidak ditemukan. Silakan lakukan pendaftaran kembali.', 'danger');
			redirect('administrator/register', 'refresh');
		}

		// Jika user sudah berstatus aktif (banned == 0)
		if ($user->banned == 0) {
			$this->session->unset_userdata(['pending_otp_user_id', 'pending_otp_email', 'pending_otp_name']);
			set_message('Akun Anda sudah terverifikasi dan aktif. Silakan masuk.', 'success');
			redirect('administrator/login', 'refresh');
		}

		$data = [
			'email'        => $user->email,
			'masked_email' => $this->_mask_email($user->email),
		];

		$this->form_validation->set_rules('otp', 'Kode OTP', 'trim|required|numeric|min_length[6]|max_length[6]');
		$this->form_validation->set_message('required', '%s wajib diisi.');
		$this->form_validation->set_message('numeric', '%s harus berupa 6 digit angka.');
		$this->form_validation->set_message('min_length', '%s harus 6 digit angka.');
		$this->form_validation->set_message('max_length', '%s harus 6 digit angka.');

		if ($this->form_validation->run()) {
			$input_otp = trim($this->input->post('otp'));

			if ($user->otp_code !== $input_otp) {
				$data['error'] = 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali email Anda.';
			} elseif (!empty($user->otp_expires_at) && strtotime($user->otp_expires_at) < time()) {
				$data['error'] = 'Kode OTP telah kedaluwarsa. Silakan klik "Kirim Ulang Kode OTP".';
			} else {
				// OTP Valid! Aktifkan akun
				$this->db->where('id', $user->id)->update('aauth_users', [
					'banned'         => 0,
					'otp_code'       => NULL,
					'otp_expires_at' => NULL
				]);

				// Bersihkan session pending OTP
				$this->session->unset_userdata(['pending_otp_user_id', 'pending_otp_email', 'pending_otp_name']);

				// Auto-login user langsung ke dashboard
				$session_data = [
					'id'        => $user->id,
					'username'  => $user->username,
					'email'     => $user->email,
					'tenant_id' => !empty($user->tenant_id) ? (int)$user->tenant_id : 1,
					'loggedin'  => TRUE
				];
				$this->session->set_userdata($session_data);
				$this->aauth->update_last_login($user->id);
				$this->aauth->update_activity();

				set_message('Selamat! Akun bisnis Anda berhasil diverifikasi. Selamat datang di Vendio.', 'success');
				redirect('administrator/dashboard', 'refresh');
			}
		} else {
			if ($this->input->method() === 'post') {
				$data['error'] = validation_errors();
			}
		}

		$this->template->build('backend/standart/administrator/verify_otp', $data);
	}

	/**
	* Kirim Ulang Kode OTP
	*
	*/
	public function resend_otp()
	{
		$pending_user_id = $this->session->userdata('pending_otp_user_id');

		if (!$pending_user_id) {
			set_message('Sesi verifikasi telah berakhir. Silakan masuk atau daftar kembali.', 'warning');
			redirect('administrator/login', 'refresh');
		}

		$user = $this->db->get_where('aauth_users', ['id' => $pending_user_id])->row();
		if (!$user) {
			set_message('Pengguna tidak ditemukan.', 'danger');
			redirect('administrator/login', 'refresh');
		}

		// Cooldown rate limit 60 detik
		$last_resend = (int) $this->session->userdata('last_otp_resend_time');
		if ($last_resend > 0 && (time() - $last_resend) < 60) {
			$remaining = 60 - (time() - $last_resend);
			set_message('Mohon tunggu ' . $remaining . ' detik sebelum meminta kode baru.', 'warning');
			redirect('administrator/verify-otp', 'refresh');
		}

		// Buat OTP baru & perpanjang 15 menit
		$otp_code = (string) mt_rand(100000, 999999);
		$otp_expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

		$this->db->where('id', $user->id)->update('aauth_users', [
			'otp_code'       => $otp_code,
			'otp_expires_at' => $otp_expires_at
		]);

		$this->session->set_userdata('last_otp_resend_time', time());

		// Kirim email OTP via Brevo SMTP
		$send_status = $this->_send_otp_email($user->email, $otp_code, $user->full_name);

		if ($send_status['success'] && empty($send_status['warning'])) {
			set_message('Kode OTP baru telah berhasil dikirimkan ke email Anda.', 'success');
		} else {
			if (!empty($send_status['warning'])) {
				set_message($send_status['warning'], 'warning');
			} else {
				set_message('Kode OTP baru telah berhasil dikirimkan ke email Anda.', 'success');
			}
		}

		redirect('administrator/verify-otp', 'refresh');
	}

	/**
	* Helper: Kirim email OTP via Brevo SMTP
	*
	* @param string $to_email
	* @param string $otp_code
	* @param string $full_name
	* @return array
	*/
	private function _send_otp_email($to_email, $otp_code, $full_name = '')
	{
		$this->load->config('email', TRUE);
		$cfg = $this->config->item('email');

		// Jika SMTP_USER atau SMTP_PASS di .env belum diisi
		if (empty($cfg['smtp_user']) || empty($cfg['smtp_pass'])) {
			log_message('error', 'Brevo SMTP belum dikonfigurasi di .env. Kode OTP untuk ' . $to_email . ' adalah: ' . $otp_code);
			return [
				'success' => true,
				'warning' => 'Konfigurasi Brevo SMTP belum diisi di .env. (Mode Demo / Dev: Kode OTP Anda adalah ' . $otp_code . ')'
			];
		}

		$this->load->library('email');
		$this->email->initialize($cfg);

		$from_email = !empty($cfg['from_email']) ? $cfg['from_email'] : $cfg['smtp_user'];
		$from_name  = !empty($cfg['from_name']) ? $cfg['from_name'] : 'Vendio';

		$this->email->from($from_email, $from_name);
		$this->email->to($to_email);
		$this->email->subject('Kode Verifikasi OTP Akun Vendio: ' . $otp_code);

		$email_data = [
			'full_name'  => $full_name,
			'otp_code'   => $otp_code,
			'expires_in' => '15 menit'
		];
		$message = $this->load->view('backend/standart/administrator/email_otp_template', $email_data, TRUE);

		$this->email->message($message);

		if ($this->email->send()) {
			return ['success' => true];
		} else {
			$debugger = $this->email->print_debugger(['headers']);
			log_message('error', 'Gagal kirim email OTP ke ' . $to_email . ': ' . $debugger);
			return [
				'success' => false,
				'warning' => 'Gagal mengirim email OTP ke ' . $to_email . '. Silakan periksa konfigurasi SMTP Brevo Anda.'
			];
		}
	}

	/**
	* Helper: Mask email address for security (contoh: jo****@gmail.com)
	*
	* @param string $email
	* @return string
	*/
	private function _mask_email($email)
	{
		if (empty($email)) return '';
		$parts = explode('@', $email);
		$name = $parts[0];
		$domain = isset($parts[1]) ? $parts[1] : '';

		$len = strlen($name);
		if ($len <= 2) {
			$masked = $name[0] . '*';
		} else {
			$masked = substr($name, 0, 2) . str_repeat('*', max(3, $len - 2));
		}
		return $masked . '@' . $domain;
	}

	/**
	* User forgot password
	*
	* @var String $id 
	*/
	public function forgot_password()
	{
		$data = [];

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_valid_captcha');

		$this->form_validation->set_message('is_unique', 'User already used');

		if ($this->form_validation->run()) {
			//custom your action
			$reset = $this->aauth->remind_password($this->input->post('email'));
			if ($reset) {
				set_message('Your password reset link send to your mail');
			} else {
				set_message('Failed to send password reminder', 'danger');
			}
			redirect('administrator/login', 'refresh');
		} else {
			$data['error'] = validation_errors();
		}

		$this->template->build('backend/standart/administrator/forgot_password', $data);
	}

	/**
	* User session logout
	*
	*/
	public function logout()
	{
		$this->aauth->logout();
		redirect('administrator/login', 'refresh');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/administrator/Auth.php */