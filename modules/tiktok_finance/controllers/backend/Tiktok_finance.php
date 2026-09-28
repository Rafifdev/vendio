<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Finance Controller
*| --------------------------------------------------------------------------
*| Tiktok Finance site
*|
*/
class Tiktok_finance extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_finance');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Finances
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_finance_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$this->data['tiktok_finances'] = $this->model_tiktok_finance->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		$this->data['tiktok_finance_counts'] = $this->model_tiktok_finance->count_all($filter, $field, $shop_id);

		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$config = [
			'base_url'     => 'administrator/tiktok_finance/index/',
			'total_rows'   => $this->model_tiktok_finance->count_all($filter, $field, $shop_id),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Penghasilan Toko List');
		$this->render('backend/standart/administrator/tiktok_finance/tiktok_finance_list', $this->data);
	}
	
	/**
	* Add new tiktok_finances
	*
	*/
	public function add()
	{
		set_message('Data keuangan disinkronkan otomatis dari TikTok Shop dan tidak dapat ditambah secara manual.', 'warning');
		redirect('administrator/tiktok_finance');
	}

	/**
	* Add New Tiktok Finances
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_finance_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('tiktok_shop_id', 'Tiktok Shop Id', 'trim|required');
		$this->form_validation->set_rules('statement_id', 'Statement Id', 'trim|required');
		$this->form_validation->set_rules('statement_time', 'Statement Time', 'trim|required');
		$this->form_validation->set_rules('settlement_amount', 'Settlement Amount', 'trim|required');
		$this->form_validation->set_rules('revenue_amount', 'Revenue Amount', 'trim|required');
		$this->form_validation->set_rules('shipping_fee_amount', 'Shipping Fee Amount', 'trim|required');
		$this->form_validation->set_rules('fee_amount', 'Fee Amount', 'trim|required');
		$this->form_validation->set_rules('adjustment_amount', 'Adjustment Amount', 'trim|required');
		$this->form_validation->set_rules('currency', 'Currency', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'statement_id' => $this->input->post('statement_id'),
				'statement_time' => $this->input->post('statement_time'),
				'settlement_amount' => $this->input->post('settlement_amount'),
				'revenue_amount' => $this->input->post('revenue_amount'),
				'shipping_fee_amount' => $this->input->post('shipping_fee_amount'),
				'fee_amount' => $this->input->post('fee_amount'),
				'adjustment_amount' => $this->input->post('adjustment_amount'),
				'currency' => $this->input->post('currency'),
			];

			
			$save_tiktok_finance = $this->model_tiktok_finance->store($save_data);
            

			if ($save_tiktok_finance) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_finance;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_finance/edit/' . $save_tiktok_finance, 'Edit Tiktok Finance'),
						anchor('administrator/tiktok_finance', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_finance/edit/' . $save_tiktok_finance, 'Edit Tiktok Finance')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_finance');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_finance');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Tiktok Finances
	*
	* @var $id String
	*/
	public function edit($id = null)
	{
		set_message('Data keuangan disinkronkan otomatis dari TikTok Shop dan tidak dapat diedit secara manual.', 'warning');
		if ($id) {
			redirect('administrator/tiktok_finance/view/' . $id);
		} else {
			redirect('administrator/tiktok_finance');
		}
	}

	/**
	* Update Tiktok Finances
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_finance_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tiktok_shop_id', 'Tiktok Shop Id', 'trim|required');
		$this->form_validation->set_rules('statement_id', 'Statement Id', 'trim|required');
		$this->form_validation->set_rules('statement_time', 'Statement Time', 'trim|required');
		$this->form_validation->set_rules('settlement_amount', 'Settlement Amount', 'trim|required');
		$this->form_validation->set_rules('revenue_amount', 'Revenue Amount', 'trim|required');
		$this->form_validation->set_rules('shipping_fee_amount', 'Shipping Fee Amount', 'trim|required');
		$this->form_validation->set_rules('fee_amount', 'Fee Amount', 'trim|required');
		$this->form_validation->set_rules('adjustment_amount', 'Adjustment Amount', 'trim|required');
		$this->form_validation->set_rules('currency', 'Currency', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'statement_id' => $this->input->post('statement_id'),
				'statement_time' => $this->input->post('statement_time'),
				'settlement_amount' => $this->input->post('settlement_amount'),
				'revenue_amount' => $this->input->post('revenue_amount'),
				'shipping_fee_amount' => $this->input->post('shipping_fee_amount'),
				'fee_amount' => $this->input->post('fee_amount'),
				'adjustment_amount' => $this->input->post('adjustment_amount'),
				'currency' => $this->input->post('currency'),
			];

			
			$save_tiktok_finance = $this->model_tiktok_finance->change($id, $save_data);

			if ($save_tiktok_finance) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_finance', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_finance');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_finance');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Finances
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_finance_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_finance'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_finance'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Finances
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_finance_view');

		$finance = $this->model_tiktok_finance->join_avaiable()->filter_avaiable()->find($id);
		if ($finance) {
			$transactions = $this->db->get_where('tiktok_statement_transactions', ['tiktok_finance_id' => $finance->id])->result();
			if (empty($transactions) && !empty($finance->statement_id) && !empty($finance->tiktok_shop_id)) {
				$this->load->library('tiktok_api');
				$res = $this->tiktok_api->get_statement_transactions($finance->statement_id, ['page_size' => 100], $finance->tiktok_shop_id);
				$tx_list = $res['data']['statement_transactions'] ?? ($res['data']['transactions'] ?? []);
				if (!empty($tx_list)) {
					foreach ($tx_list as $tx) {
						$p_time = null;
						if (!empty($tx['paid_time'])) {
							$ts = intval($tx['paid_time']);
							if ($ts > 100000000000) $ts = round($ts / 1000);
							$p_time = date('Y-m-d H:i:s', $ts);
						}
						$data_tx = [
							'tiktok_finance_id'  => $finance->id,
							'statement_id'       => $finance->statement_id,
							'order_id'           => $tx['order_id'] ?? null,
							'transaction_type'   => $tx['type'] ?? ($tx['transaction_type'] ?? 'ORDER'),
							'order_amount'       => floatval($tx['order_amount'] ?? 0),
							'shipping_fee'       => floatval($tx['shipping_cost_amount'] ?? ($tx['shipping_fee'] ?? 0)),
							'platform_fee'       => floatval($tx['fee_amount'] ?? ($tx['platform_fee'] ?? 0)),
							'settlement_amount'  => floatval($tx['settlement_amount'] ?? 0),
							'paid_time'          => $p_time,
							'created_at'         => date('Y-m-d H:i:s')
						];
						$this->db->insert('tiktok_statement_transactions', $data_tx);
					}
					$transactions = $this->db->get_where('tiktok_statement_transactions', ['tiktok_finance_id' => $finance->id])->result();
				}
			}
			$this->data['statement_transactions'] = $transactions;
		}

		$this->data['tiktok_finance'] = $finance;

		$this->template->title('Penghasilan Toko Detail');
		$this->render('backend/standart/administrator/tiktok_finance/tiktok_finance_view', $this->data);
	}
	
	/**
	* delete Tiktok Finances
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_finance = $this->model_tiktok_finance->find($id);

		
		
		return $this->model_tiktok_finance->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_finance_export');

		$this->model_tiktok_finance->export('tiktok_finance', 'tiktok_finance');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_finance_export');

		$this->model_tiktok_finance->pdf('tiktok_finance', 'tiktok_finance');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_finance_export');

		$table = $title = 'tiktok_finance';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_finance->find($id);
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
	 * Sinkronisasi Rekap Pencairan Dana (Settlement Statements) dari TikTok Shop
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_finance_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung atau aktif. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_finance');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$res = $this->tiktok_api->get_statements(['page_size' => 50], $shop->id);

			if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($res['message'] ?? 'Gagal mengambil data keuangan');
				continue;
			}

			$statements = $res['data']['statements'] ?? [];

			foreach ($statements as $st) {
				$statement_id = $st['id'] ?? null;
				if (empty($statement_id)) {
					continue;
				}

				$statement_time = null;
				if (!empty($st['statement_time'])) {
					$ts = intval($st['statement_time']);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$statement_time = date('Y-m-d H:i:s', $ts);
				}

				$payout_id = $st['payment_id'] ?? ($st['payout_id'] ?? null);
				$payment_status = $st['payment_status'] ?? 'PAID';
				$settlement_amount = floatval($st['settlement_amount'] ?? 0);
				$revenue_amount = floatval($st['revenue_amount'] ?? ($st['net_sales_amount'] ?? 0));
				$shipping_fee = floatval($st['shipping_cost_amount'] ?? ($st['shipping_fee_amount'] ?? 0));
				$fee_amount = floatval($st['fee_amount'] ?? 0);
				$adjustment_amount = floatval($st['adjustment_amount'] ?? 0);
				$currency = $st['currency'] ?? 'IDR';

				$save_data = [
					'tiktok_shop_id'      => $shop->id,
					'statement_id'        => $statement_id,
					'statement_time'      => $statement_time,
					'payout_id'           => $payout_id,
					'payment_status'      => $payment_status,
					'settlement_amount'   => $settlement_amount,
					'revenue_amount'      => $revenue_amount,
					'shipping_fee_amount' => $shipping_fee,
					'fee_amount'          => $fee_amount,
					'adjustment_amount'   => $adjustment_amount,
					'currency'            => $currency,
					'updated_at'          => date('Y-m-d H:i:s')
				];

				$existing = $this->db->get_where('tiktok_finance', ['statement_id' => $statement_id])->row();
				if ($existing) {
					$this->db->where('id', $existing->id)->update('tiktok_finance', $save_data);
				} else {
					$save_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_finance', $save_data);
				}

				$total_synced++;
			}
		}

		if (!empty($error_messages)) {
			set_message('Sinkronisasi selesai dengan catatan: ' . implode('; ', $error_messages) . '. Total data keuangan tersinkron: ' . $total_synced, 'warning');
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' data keuangan (Settlement) dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_finance');
	}
}



/* End of file tiktok_finance.php */
/* Location: ./application/controllers/administrator/Tiktok Finance.php */