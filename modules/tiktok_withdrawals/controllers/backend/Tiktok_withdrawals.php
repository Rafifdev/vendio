<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Tiktok Withdrawals Controller
*| --------------------------------------------------------------------------
*| Riwayat Penarikan Dana ke Rekening Bank
*|
*/
class Tiktok_withdrawals extends Admin	
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_withdrawals');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* Menampilkan semua data Penarikan Dana
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_withdrawals_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_withdrawalss'] = $this->model_tiktok_withdrawals->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_withdrawals_counts'] = $this->model_tiktok_withdrawals->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_withdrawals/index/',
			'total_rows'   => $this->model_tiktok_withdrawals->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Riwayat Penarikan Dana');
		$this->render('backend/standart/administrator/tiktok_withdrawals/tiktok_withdrawals_list', $this->data);
	}

	/**
	* Sinkronisasi data Penarikan Dana (Withdrawals) dari TikTok Shop API
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_withdrawals_list');

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
			redirect('administrator/tiktok_withdrawals');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$res = $this->tiktok_api->get_withdrawals(['page_size' => 50, 'types' => 'WITHDRAW'], $shop->id);

			if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
				$error_messages[] = $shop->shop_name . ': ' . ($res['message'] ?? 'Gagal mengambil data penarikan');
				continue;
			}

			$withdrawals = $res['data']['withdrawals'] ?? ($res['data']['withdrawal_list'] ?? []);

			foreach ($withdrawals as $w) {
				$withdrawal_id = $w['id'] ?? ($w['withdrawal_id'] ?? null);
				if (empty($withdrawal_id)) {
					continue;
				}

				$transfer_time = null;
				$time_val = $w['transfer_time'] ?? ($w['paid_time'] ?? ($w['create_time'] ?? null));
				if (!empty($time_val)) {
					$ts = intval($time_val);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$transfer_time = date('Y-m-d H:i:s', $ts);
				}

				$amount = floatval($w['amount'] ?? 0);
				$currency = $w['currency'] ?? 'IDR';
				$bank_name = $w['bank_name'] ?? ($w['bank_account_info']['bank_name'] ?? '-');
				$bank_account = $w['bank_account'] ?? ($w['bank_account_info']['bank_account'] ?? ($w['bank_account_info']['account_number'] ?? '-'));
				$status = strtoupper($w['status'] ?? 'SUCCESS');

				$save_data = [
					'tiktok_shop_id' => $shop->id,
					'withdrawal_id'  => $withdrawal_id,
					'amount'         => $amount,
					'currency'       => $currency,
					'bank_name'      => $bank_name,
					'bank_account'   => $bank_account,
					'status'         => $status,
					'transfer_time'  => $transfer_time,
					'updated_at'     => date('Y-m-d H:i:s')
				];

				$existing = $this->db->get_where('tiktok_withdrawals', ['withdrawal_id' => $withdrawal_id])->row();
				if ($existing) {
					$this->db->where('id', $existing->id)->update('tiktok_withdrawals', $save_data);
				} else {
					$save_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_withdrawals', $save_data);
				}

				$total_synced++;
			}
		}

		if (!empty($error_messages)) {
			set_message('Sinkronisasi selesai dengan catatan: ' . implode('; ', $error_messages) . '. Total data penarikan tersinkron: ' . $total_synced, 'warning');
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' data penarikan dana dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_withdrawals');
	}

	/**
	* Detail Penarikan Dana
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_withdrawals_view');

		$this->data['tiktok_withdrawals'] = $this->model_tiktok_withdrawals->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Detail Penarikan Dana');
		$this->render('backend/standart/administrator/tiktok_withdrawals/tiktok_withdrawals_view', $this->data);
	}

	/**
	* Hapus Penarikan Dana dicegah untuk audit trail
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_withdrawals_delete');

		set_message('Data penarikan dana tidak dapat dihapus untuk menjaga riwayat keuangan / audit trail.', 'warning');
		redirect_back();
	}

	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_withdrawals_export');

		$this->model_tiktok_withdrawals->export('tiktok_withdrawals', 'tiktok_withdrawals');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_withdrawals_export');

		$this->model_tiktok_withdrawals->pdf('tiktok_withdrawals', 'tiktok_withdrawals');
	}

	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_withdrawals_export');

		$table = $title = 'tiktok_withdrawals';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_withdrawals->find($id);
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

/* End of file Tiktok_withdrawals.php */
/* Location: ./modules/tiktok_withdrawals/controllers/backend/Tiktok_withdrawals.php */