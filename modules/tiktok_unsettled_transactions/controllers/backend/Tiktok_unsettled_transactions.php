<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tiktok Unsettled Transactions Controller
*| --------------------------------------------------------------------------
*| Dana Tertahan / Pesanan Belum Settle
*|
*/
class Tiktok_unsettled_transactions extends Admin	
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_unsettled_transactions');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* Menampilkan daftar Dana Tertahan / Pesanan Belum Settle
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_unsettled_transactions_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$this->data['tiktok_unsettled_transactionss'] = $this->model_tiktok_unsettled_transactions->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		$this->data['tiktok_unsettled_transactions_counts'] = $this->model_tiktok_unsettled_transactions->count_all($filter, $field, $shop_id);

		$config = [
			'base_url'     => 'administrator/tiktok_unsettled_transactions/index/',
			'total_rows'   => $this->model_tiktok_unsettled_transactions->count_all($filter, $field, $shop_id),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$this->template->title('Dana Tertahan');
		$this->render('backend/standart/administrator/tiktok_unsettled_transactions/tiktok_unsettled_transactions_list', $this->data);
	}

	/**
	* Sinkronisasi data Dana Tertahan / Pesanan Belum Settle dari TikTok Shop API
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_unsettled_transactions_list');

		$this->load->library('tiktok_api');
		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			$shops = $this->db->get('tiktok_shops')->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_unsettled_transactions');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		$existing_rows = $this->db->select('id, order_id')->get('tiktok_unsettled_transactions')->result();
		$existing_map = [];
		foreach ($existing_rows as $er) {
			$existing_map[$er->order_id] = $er->id;
		}

		$this->db->trans_start();

		foreach ($shops as $shop) {
			$res = $this->tiktok_api->get_unsettled_transactions(['page_size' => 50], $shop->id);

			if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($res['message'] ?? 'Gagal mengambil data dana tertahan');
				continue;
			}

			$orders = $res['data']['transactions'] ?? ($res['data']['orders'] ?? ($res['data']['unsettled_orders'] ?? []));

			foreach ($orders as $ord) {
				$order_id = $ord['order_id'] ?? ($ord['transaction_id'] ?? ($ord['id'] ?? null));
				if (empty($order_id)) {
					continue;
				}

				$settlement_status = $ord['settlement_status'] ?? ($ord['status'] ?? 'UNSETTLED');
				$amount = floatval($ord['estimated_settlement_amount'] ?? ($ord['est_settlement_amount'] ?? ($ord['settlement_amount'] ?? ($ord['amount'] ?? 0))));
				$currency = $ord['currency'] ?? 'IDR';

				$order_created_time = null;
				$time_val = $ord['order_create_time'] ?? ($ord['order_created_time'] ?? ($ord['create_time'] ?? null));
				if (!empty($time_val)) {
					$ts = intval($time_val);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$order_created_time = date('Y-m-d H:i:s', $ts);
				}

				$save_data = [
					'tiktok_shop_id'              => $shop->id,
					'order_id'                    => $order_id,
					'settlement_status'           => $settlement_status,
					'estimated_settlement_amount' => $amount,
					'currency'                    => $currency,
					'order_created_time'          => $order_created_time,
					'synced_at'                   => date('Y-m-d H:i:s')
				];

				if (isset($existing_map[$order_id])) {
					$this->db->where('id', $existing_map[$order_id])->update('tiktok_unsettled_transactions', $save_data);
				} else {
					$this->db->insert('tiktok_unsettled_transactions', $save_data);
					$existing_map[$order_id] = $this->db->insert_id();
				}

				$total_synced++;
			}
		}

		$this->db->trans_complete();

		if (!empty($error_messages)) {
			if ($total_synced === 0) {
				set_message('Gagal menyinkronkan transaksi belum settle: ' . implode('; ', $error_messages), 'error');
			} else {
				set_message("Sebagian data transaksi belum settle gagal ditarik ({$total_synced} data berhasil): " . implode('; ', $error_messages), 'warning');
			}
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' data transaksi belum settle dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_unsettled_transactions');
	}

	/**
	* Detail Dana Tertahan
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_unsettled_transactions_view');

		$this->data['tiktok_unsettled_transactions'] = $this->model_tiktok_unsettled_transactions->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Detail Dana Tertahan');
		$this->render('backend/standart/administrator/tiktok_unsettled_transactions/tiktok_unsettled_transactions_view', $this->data);
	}

	/**
	* Hapus Dana Tertahan dicegah untuk audit trail
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_unsettled_transactions_delete');

		set_message('Data transaksi belum settle tidak dapat dihapus untuk menjaga riwayat transaksi.', 'warning');
		redirect_back();
	}

	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_unsettled_transactions_export');

		$this->model_tiktok_unsettled_transactions->export('tiktok_unsettled_transactions', 'tiktok_unsettled_transactions');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_unsettled_transactions_export');

		$this->model_tiktok_unsettled_transactions->pdf('tiktok_unsettled_transactions', 'tiktok_unsettled_transactions');
	}

	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_unsettled_transactions_export');

		$table = $title = 'tiktok_unsettled_transactions';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_unsettled_transactions->find($id);
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

/* End of file Tiktok_unsettled_transactions.php */
/* Location: ./modules/tiktok_unsettled_transactions/controllers/backend/Tiktok_unsettled_transactions.php */