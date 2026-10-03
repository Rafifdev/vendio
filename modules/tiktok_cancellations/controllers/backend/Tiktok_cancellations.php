<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tiktok Cancellations Controller
*| --------------------------------------------------------------------------
*| Modul Pembatalan Pesanan TikTok Shop
*|
*/
class Tiktok_cancellations extends Admin	
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_cancellations');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* Menampilkan daftar pembatalan pesanan
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_cancellations_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$this->data['tiktok_cancellationss'] = $this->model_tiktok_cancellations->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		$this->data['tiktok_cancellations_counts'] = $this->model_tiktok_cancellations->count_all($filter, $field, $shop_id);
		$this->data['reject_reasons'] = $this->db->get_where('tiktok_reject_reasons', ['applies_to' => 'CANCELLATION'])->result();

		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$config = [
			'base_url'     => 'administrator/tiktok_cancellations/index/',
			'total_rows'   => $this->model_tiktok_cancellations->count_all($filter, $field, $shop_id),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Pembatalan Pesanan');
		$this->render('backend/standart/administrator/tiktok_cancellations/tiktok_cancellations_list', $this->data);
	}

	/**
	 * Tarik Data Pembatalan Pesanan dari TikTok Shop
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_cancellations_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung atau aktif. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_cancellations');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			// Tarik juga reject reasons jika tersedia dari API
			try {
				$rr_res = $this->tiktok_api->get_reject_reasons(['locale' => 'id-ID'], $shop->id);
				if (!empty($rr_res['data']['reject_reasons'])) {
					foreach ($rr_res['data']['reject_reasons'] as $item) {
						$code = $item['name'] ?? ($item['key'] ?? '');
						$text = $item['description'] ?? ($item['text'] ?? $code);
						if (!empty($code)) {
							$exist = $this->db->get_where('tiktok_reject_reasons', ['reason_code' => $code, 'applies_to' => 'CANCELLATION'])->row();
							if (!$exist) {
								$this->db->insert('tiktok_reject_reasons', [
									'reason_code' => $code,
									'reason_text' => $text,
									'locale'      => 'id-ID',
									'applies_to'  => 'CANCELLATION',
									'synced_at'   => date('Y-m-d H:i:s'),
								]);
							}
						}
					}
				}
			} catch (\Exception $e) {}

			// Tarik data pembatalan pesanan
			$res = $this->tiktok_api->search_cancellations([], ['page_size' => 50], $shop->id);

			if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($res['message'] ?? 'Gagal mengambil data pembatalan');
				continue;
			}

			$cancellations = $res['data']['cancellations'] ?? ($res['data']['cancel_orders'] ?? []);
			if (empty($cancellations)) {
				continue;
			}

			// Optimasi: Pre-fetch cancel_id yang sudah ada di database
			$cancel_ids = [];
			foreach ($cancellations as $co) {
				$cid = $co['cancel_id'] ?? ($co['id'] ?? null);
				if (!empty($cid)) {
					$cancel_ids[] = $cid;
				}
			}

			$existing_cancels = [];
			if (!empty($cancel_ids)) {
				$ex_rows = $this->db->select('id, cancel_id')->where_in('cancel_id', $cancel_ids)->get('tiktok_cancellations')->result();
				foreach ($ex_rows as $er) {
					$existing_cancels[$er->cancel_id] = $er->id;
				}
			}

			$this->db->trans_start();

			foreach ($cancellations as $co) {
				$cancel_id = $co['cancel_id'] ?? ($co['id'] ?? null);
				if (empty($cancel_id)) {
					continue;
				}

				$created_time = null;
				if (!empty($co['create_time'])) {
					$ts = intval($co['create_time']);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$created_time = date('Y-m-d H:i:s', $ts);
				}

				$order_id = $co['order_id'] ?? '';
				$status = $co['cancel_status'] ?? ($co['status'] ?? 'AWAITING_SELLER_REVIEW');
				$reason = $co['cancel_reason'] ?? ($co['reason'] ?? '');
				$reason_key = $co['cancel_reason_key'] ?? ($co['reason_key'] ?? '');
				$initiator = $co['cancel_initiator'] ?? ($co['initiator'] ?? 'BUYER');
				$items = !empty($co['cancel_line_items']) ? json_encode($co['cancel_line_items']) : (!empty($co['items']) ? json_encode($co['items']) : null);

				$save_data = [
					'tiktok_shop_id'     => $shop->id,
					'cancel_id'          => $cancel_id,
					'order_id'           => $order_id,
					'cancel_status'      => $status,
					'cancel_reason'      => $reason,
					'cancel_reason_key'  => $reason_key,
					'cancel_initiator'   => $initiator,
					'items'              => $items,
					'cancel_created_time'=> $created_time,
					'updated_at'         => date('Y-m-d H:i:s'),
				];

				$existing_id = $existing_cancels[$cancel_id] ?? null;
				if ($existing_id) {
					$this->db->where('id', $existing_id)->update('tiktok_cancellations', $save_data);
				} else {
					$save_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_cancellations', $save_data);
				}

				// Jika status pembatalan disetujui / completed, sesuaikan status di tiktok_orders
				if (in_array(strtoupper($status), ['APPROVED', 'COMPLETED', 'CANCELLED']) && !empty($order_id)) {
					$this->db->where('order_id', $order_id)->update('tiktok_orders', [
						'order_status'  => 'CANCELLED',
						'cancel_reason' => $reason ?: 'Dibatalkan oleh pembeli',
						'updated_at'    => date('Y-m-d H:i:s')
					]);
				}

				$total_synced++;
			}

			$this->db->trans_complete();
		}

		if (!empty($error_messages)) {
			if ($total_synced === 0) {
				set_message('Gagal menyinkronkan pembatalan pesanan: ' . implode('; ', $error_messages), 'error');
			} else {
				set_message("Sebagian data pembatalan gagal ditarik ({$total_synced} data berhasil): " . implode('; ', $error_messages), 'warning');
			}
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' data pembatalan pesanan dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_cancellations');
	}

	/**
	 * Setujui Pengajuan Pembatalan Pesanan dari Pembeli
	 *
	 * @param int $id
	 */
	public function approve($id)
	{
		$this->is_allowed('tiktok_cancellations_update');
		$this->load->library('tiktok_api');

		$cancellation = $this->model_tiktok_cancellations->find($id);
		if (!$cancellation) {
			set_message('Data pengajuan pembatalan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_cancellations');
			return;
		}

		$res = $this->tiktok_api->approve_cancellation($cancellation->cancel_id, $cancellation->tiktok_shop_id);
		if ($res['success'] || (isset($res['code']) && $res['code'] === 0)) {
			$this->db->where('id', $cancellation->id)->update('tiktok_cancellations', [
				'cancel_status' => 'APPROVED',
				'updated_at'    => date('Y-m-d H:i:s')
			]);

			// Perbarui juga status order di tabel tiktok_orders
			if (!empty($cancellation->order_id)) {
				$this->db->where('order_id', $cancellation->order_id)->update('tiktok_orders', [
					'order_status'  => 'CANCELLED',
					'cancel_reason' => $cancellation->cancel_reason ?: 'Pembatalan disetujui penjual',
					'updated_at'    => date('Y-m-d H:i:s')
				]);
			}

			set_message('Pengajuan pembatalan pesanan (ID: ' . $cancellation->cancel_id . ') berhasil disetujui. Pesanan telah dibatalkan.', 'success');
		} else {
			set_message('Gagal menyetujui pembatalan: ' . ($res['message'] ?? 'Terjadi kesalahan sistem TikTok Shop.'), 'error');
		}

		redirect('administrator/tiktok_cancellations');
	}

	/**
	 * Tolak Pengajuan Pembatalan Pesanan dari Pembeli
	 *
	 * @param int $id
	 */
	public function reject($id)
	{
		$this->is_allowed('tiktok_cancellations_update');
		$this->load->library('tiktok_api');

		$cancellation = $this->model_tiktok_cancellations->find($id);
		if (!$cancellation) {
			set_message('Data pengajuan pembatalan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_cancellations');
			return;
		}

		$reject_reason = $this->input->post('reject_reason');
		$comments = $this->input->post('comments') ?: 'Pesanan sedang diproses dan tidak dapat dibatalkan.';

		if (empty($reject_reason)) {
			set_message('Silakan pilih alasan resmi penolakan pembatalan.', 'error');
			redirect('administrator/tiktok_cancellations');
			return;
		}

		$res = $this->tiktok_api->reject_cancellation($cancellation->cancel_id, $reject_reason, ['comments' => $comments], $cancellation->tiktok_shop_id);
		if ($res['success'] || (isset($res['code']) && $res['code'] === 0)) {
			$this->db->where('id', $cancellation->id)->update('tiktok_cancellations', [
				'cancel_status' => 'REJECTED',
				'updated_at'    => date('Y-m-d H:i:s')
			]);
			set_message('Pengajuan pembatalan pesanan telah ditolak. Pesanan dilanjutkan.', 'success');
		} else {
			set_message('Gagal menolak pembatalan: ' . ($res['message'] ?? 'Terjadi kesalahan sistem TikTok Shop.'), 'error');
		}

		redirect('administrator/tiktok_cancellations');
	}

	/**
	* Tampilkan rincian pembatalan pesanan
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_cancellations_view');

		$this->data['tiktok_cancellations'] = $this->model_tiktok_cancellations->join_avaiable()->filter_avaiable()->find($id);
		$this->data['reject_reasons'] = $this->db->get_where('tiktok_reject_reasons', ['applies_to' => 'CANCELLATION'])->result();

		$this->template->title('Pembatalan Pesanan');
		$this->render('backend/standart/administrator/tiktok_cancellations/tiktok_cancellations_view', $this->data);
	}
	
	/**
	* Hapus data pembatalan pesanan
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_cancellations_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_cancellations'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_cancellations'), 'error');
        }

		redirect_back();
	}

	private function _remove($id)
	{
		return $this->model_tiktok_cancellations->remove($id);
	}
	
	public function export()
	{
		$this->is_allowed('tiktok_cancellations_export');
		$this->model_tiktok_cancellations->export('tiktok_cancellations', 'tiktok_cancellations');
	}

	public function export_pdf()
	{
		$this->is_allowed('tiktok_cancellations_export');
		$this->model_tiktok_cancellations->pdf('tiktok_cancellations', 'tiktok_cancellations');
	}
}

/* End of file tiktok_cancellations.php */
/* Location: ./application/controllers/administrator/Tiktok Cancellations.php */