<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Returns Controller
*| --------------------------------------------------------------------------
*| Tiktok Returns site
*|
*/
class Tiktok_returns extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_returns');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Returnss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_returns_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$this->data['tiktok_returnss'] = $this->model_tiktok_returns->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		$this->data['tiktok_returns_counts'] = $this->model_tiktok_returns->count_all($filter, $field, $shop_id);

		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$config = [
			'base_url'     => 'administrator/tiktok_returns/index/',
			'total_rows'   => $this->model_tiktok_returns->count_all($filter, $field, $shop_id),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['reject_reasons'] = $this->db->get_where('tiktok_reject_reasons', ['applies_to' => 'RETURN'])->result();

		$this->template->title('Retur Penjualan');
		$this->render('backend/standart/administrator/tiktok_returns/tiktok_returns_list', $this->data);
	}
	
	/**
	* Add new tiktok_returnss
	*
	*/
	public function add()
	{
		set_message('Data retur / komplain diajukan langsung oleh pembeli di TikTok Shop dan tidak dapat ditambah secara manual.', 'warning');
		redirect('administrator/tiktok_returns');
	}

	/**
	* Add New Tiktok Returnss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_returns_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('tiktok_shop_id', 'Tiktok Shop Id', 'trim|required');
		$this->form_validation->set_rules('return_id', 'Return Id', 'trim|required');
		$this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
		$this->form_validation->set_rules('return_type', 'Return Type', 'trim|required');
		$this->form_validation->set_rules('return_status', 'Return Status', 'trim|required');
		$this->form_validation->set_rules('return_reason', 'Return Reason', 'trim|required');
		$this->form_validation->set_rules('refund_amount', 'Refund Amount', 'trim|required');
		$this->form_validation->set_rules('tracking_number', 'Tracking Number', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'return_id' => $this->input->post('return_id'),
				'order_id' => $this->input->post('order_id'),
				'return_type' => $this->input->post('return_type'),
				'return_status' => $this->input->post('return_status'),
				'return_reason' => $this->input->post('return_reason'),
				'refund_amount' => $this->input->post('refund_amount'),
				'tracking_number' => $this->input->post('tracking_number'),
			];

			
			$save_tiktok_returns = $this->model_tiktok_returns->store($save_data);
            

			if ($save_tiktok_returns) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_returns;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_returns/edit/' . $save_tiktok_returns, 'Edit Tiktok Returns'),
						anchor('administrator/tiktok_returns', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_returns/edit/' . $save_tiktok_returns, 'Edit Tiktok Returns')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_returns');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_returns');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Tiktok Returnss
	*
	* @var $id String
	*/
	public function edit($id = null)
	{
		set_message('Data retur disinkronkan otomatis dari TikTok Shop dan tidak dapat diedit secara manual.', 'warning');
		if ($id) {
			redirect('administrator/tiktok_returns/view/' . $id);
		} else {
			redirect('administrator/tiktok_returns');
		}
	}

	/**
	* Update Tiktok Returnss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_returns_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tiktok_shop_id', 'Tiktok Shop Id', 'trim|required');
		$this->form_validation->set_rules('return_id', 'Return Id', 'trim|required');
		$this->form_validation->set_rules('order_id', 'Order Id', 'trim|required');
		$this->form_validation->set_rules('return_type', 'Return Type', 'trim|required');
		$this->form_validation->set_rules('return_status', 'Return Status', 'trim|required');
		$this->form_validation->set_rules('return_reason', 'Return Reason', 'trim|required');
		$this->form_validation->set_rules('refund_amount', 'Refund Amount', 'trim|required');
		$this->form_validation->set_rules('tracking_number', 'Tracking Number', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'return_id' => $this->input->post('return_id'),
				'order_id' => $this->input->post('order_id'),
				'return_type' => $this->input->post('return_type'),
				'return_status' => $this->input->post('return_status'),
				'return_reason' => $this->input->post('return_reason'),
				'refund_amount' => $this->input->post('refund_amount'),
				'tracking_number' => $this->input->post('tracking_number'),
			];

			
			$save_tiktok_returns = $this->model_tiktok_returns->change($id, $save_data);

			if ($save_tiktok_returns) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_returns', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_returns');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_returns');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Returnss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_returns_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_returns'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_returns'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Returnss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_returns_view');

		$this->data['tiktok_returns'] = $this->model_tiktok_returns->join_avaiable()->filter_avaiable()->find($id);
		$this->data['reject_reasons'] = $this->db->get_where('tiktok_reject_reasons', ['applies_to' => 'RETURN'])->result();

		$this->template->title('Retur Penjualan');
		$this->render('backend/standart/administrator/tiktok_returns/tiktok_returns_view', $this->data);
	}
	
	/**
	* delete Tiktok Returnss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_returns = $this->model_tiktok_returns->find($id);

		
		
		return $this->model_tiktok_returns->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_returns_export');

		$this->model_tiktok_returns->export('tiktok_returns', 'tiktok_returns');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_returns_export');

		$this->model_tiktok_returns->pdf('tiktok_returns', 'tiktok_returns');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_returns_export');

		$table = $title = 'tiktok_returns';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_returns->find($id);
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
	 * Sinkronisasi Pengajuan Retur & Refund dari TikTok Shop
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_returns_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung atau aktif. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_returns');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$res = $this->tiktok_api->search_returns([], ['page_size' => 50], $shop->id);

			if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($res['message'] ?? 'Gagal mengambil data retur');
				continue;
			}

			$return_orders = $res['data']['return_orders'] ?? [];
			if (empty($return_orders)) {
				continue;
			}

			// Optimasi: Pre-fetch data return_id yang sudah tersimpan
			$return_ids = array_filter(array_column($return_orders, 'return_id'));
			$existing_returns = [];
			if (!empty($return_ids)) {
				$ex_rows = $this->db->select('id, return_id')->where_in('return_id', $return_ids)->get('tiktok_returns')->result();
				foreach ($ex_rows as $er) {
					$existing_returns[$er->return_id] = $er->id;
				}
			}

			$this->db->trans_start();

			foreach ($return_orders as $ro) {
				$return_id = $ro['return_id'] ?? null;
				if (empty($return_id)) {
					continue;
				}

				$created_time = null;
				if (!empty($ro['create_time'])) {
					$ts = intval($ro['create_time']);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$created_time = date('Y-m-d H:i:s', $ts);
				}

				$order_id = $ro['order_id'] ?? '';
				$return_type = $ro['return_type'] ?? 'REFUND';
				$return_status = $ro['return_status'] ?? 'PROCESSING';
				$return_reason = $ro['return_reason_text'] ?? ($ro['return_reason'] ?? '');
				$refund_amount = floatval($ro['refund_amount']['refund_total'] ?? 0);
				$tracking_number = $ro['tracking_number'] ?? ($ro['tracking_no'] ?? null);

				$save_data = [
					'tiktok_shop_id'      => $shop->id,
					'return_id'           => $return_id,
					'order_id'            => $order_id,
					'items'               => !empty($ro['return_line_items']) ? json_encode($ro['return_line_items']) : null,
					'return_type'         => $return_type,
					'return_status'       => $return_status,
					'return_reason'       => $return_reason,
					'refund_amount'       => $refund_amount,
					'tracking_number'     => $tracking_number,
					'return_created_time' => $created_time,
					'updated_at'          => date('Y-m-d H:i:s')
				];

				$existing_id = $existing_returns[$return_id] ?? null;
				if ($existing_id) {
					$this->db->where('id', $existing_id)->update('tiktok_returns', $save_data);
				} else {
					$save_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_returns', $save_data);
				}

				$total_synced++;
			}

			$this->db->trans_complete();
		}

		if (!empty($error_messages)) {
			if ($total_synced === 0) {
				set_message('Gagal menyinkronkan retur: ' . implode('; ', $error_messages), 'error');
			} else {
				set_message("Sebagian data retur gagal ditarik ({$total_synced} data berhasil): " . implode('; ', $error_messages), 'warning');
			}
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' data retur / pengembalian dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_returns');
	}

	/**
	 * Setujui Pengajuan Retur dari Pembeli (Seller Center Action)
	 */
	public function approve($id)
	{
		$this->is_allowed('tiktok_returns_update');
		$this->load->library('tiktok_api');

		$return = $this->model_tiktok_returns->find($id);
		if (!$return) {
			set_message('Data retur tidak ditemukan.', 'error');
			redirect('administrator/tiktok_returns');
			return;
		}

		$decision = $return->return_type == 'RETURN_AND_REFUND' ? 'APPROVE_RETURN' : 'APPROVE_REFUND';
		$res = $this->tiktok_api->approve_return($return->return_id, $decision, $return->tiktok_shop_id);
		if ($res['success'] || (isset($res['code']) && $res['code'] === 0)) {
			$new_status = $return->return_type == 'RETURN_AND_REFUND' ? 'AWAITING_BUYER_SHIP' : 'COMPLETED';
			$this->db->where('id', $return->id)->update('tiktok_returns', [
				'return_status' => $new_status,
				'updated_at'    => date('Y-m-d H:i:s')
			]);
			set_message('Pengajuan retur berhasil disetujui! Status: ' . ($new_status == 'AWAITING_BUYER_SHIP' ? 'Menunggu Pembeli Mengirim Barang' : 'Selesai'), 'success');
		} else {
			set_message('Gagal menyetujui retur: ' . ($res['message'] ?? 'Terjadi kesalahan sistem TikTok Shop.'), 'error');
		}

		redirect('administrator/tiktok_returns');
	}

	/**
	 * Tolak Pengajuan Retur dari Pembeli (Seller Center Action)
	 */
	public function reject($id)
	{
		$this->is_allowed('tiktok_returns_update');
		$this->load->library('tiktok_api');

		$return = $this->model_tiktok_returns->find($id);
		if (!$return) {
			set_message('Data retur tidak ditemukan.', 'error');
			redirect('administrator/tiktok_returns');
			return;
		}

		$reject_reason = $this->input->post('reject_reason') ?: 'seller_reject_buyer_reason_not_valid';
		$comments = $this->input->post('comments') ?: 'Permintaan retur tidak memenuhi syarat kebijakan toko.';

		$res = $this->tiktok_api->reject_return($return->return_id, $reject_reason, ['comments' => $comments], $return->tiktok_shop_id);
		if ($res['success'] || (isset($res['code']) && $res['code'] === 0)) {
			$this->db->where('id', $return->id)->update('tiktok_returns', [
				'return_status' => 'REJECTED',
				'updated_at'    => date('Y-m-d H:i:s')
			]);
			set_message('Pengajuan retur telah ditolak.', 'success');
		} else {
			set_message('Gagal menolak retur: ' . ($res['message'] ?? 'Terjadi kesalahan sistem TikTok Shop.'), 'error');
		}

		redirect('administrator/tiktok_returns');
	}
}



/* End of file tiktok_returns.php */
/* Location: ./application/controllers/administrator/Tiktok Returns.php */