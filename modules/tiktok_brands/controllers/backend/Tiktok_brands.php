<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Brands Controller
*| --------------------------------------------------------------------------
*| Tiktok Brands site
*|
*/
class Tiktok_brands extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_brands');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Brandss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_brands_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_brandss'] = $this->model_tiktok_brands->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_brands_counts'] = $this->model_tiktok_brands->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_brands/index/',
			'total_rows'   => $this->model_tiktok_brands->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Merek Produk List');
		$this->render('backend/standart/administrator/tiktok_brands/tiktok_brands_list', $this->data);
	}
	
	/**
	* Tarik Data Brand dari TikTok Shop API
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_brands_list');
		$this->load->library('tiktok_api');

		$shop = $this->db->get_where('tiktok_shops', ['is_active' => 1])->row();
		if (!$shop) {
			$shop = $this->db->get('tiktok_shops')->row();
		}
		if (!$shop) {
			set_message('Toko TikTok belum aktif atau belum terhubung.', 'error');
			redirect('administrator/tiktok_brands');
			return;
		}

		$response = $this->tiktok_api->get_brands(null, ['page_size' => 100], $shop->id);
		if (empty($response['success']) && (!isset($response['code']) || $response['code'] !== 0)) {
			set_message('Gagal menarik data brand dari TikTok Shop: ' . ($response['message'] ?? 'Error API'), 'error');
			redirect('administrator/tiktok_brands');
			return;
		}

		$brands = $response['data']['brands'] ?? [];
		if (empty($brands)) {
			set_message('Tidak ada data brand ditemukan dari TikTok Shop.', 'warning');
			redirect('administrator/tiktok_brands');
			return;
		}

		// Optimasi Database: Pre-fetch seluruh ID brand yang sudah ada dalam 1 query
		$existing_brands = array_column(
			$this->db->select('id, tiktok_brand_id')->get('tiktok_brands')->result(),
			'id',
			'tiktok_brand_id'
		);

		$this->db->trans_start();
		$synced_count = 0;

		foreach ($brands as $b) {
			$brand_id = $b['id'] ?? '';
			if (empty($brand_id)) continue;

			$data_brand = [
				'tiktok_brand_id' => $brand_id,
				'name'            => $b['name'] ?? '',
				'is_authorized'   => (!empty($b['authorized_status']) && $b['authorized_status'] === 'AUTHORIZED') ? 1 : 1,
				'synced_at'       => date('Y-m-d H:i:s'),
			];

			$existing_id = $existing_brands[$brand_id] ?? null;

			if ($existing_id) {
				$this->db->where('id', $existing_id)->update('tiktok_brands', $data_brand);
			} else {
				$this->db->insert('tiktok_brands', $data_brand);
			}

			$synced_count++;
		}

		$this->db->trans_complete();

		set_message("Berhasil menarik {$synced_count} brand resmi dari TikTok Shop.", 'success');
		redirect('administrator/tiktok_brands');
	}
	
	/**
	* delete Tiktok Brandss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_brands_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_brands'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_brands'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Brandss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_brands_view');

		$this->data['tiktok_brands'] = $this->model_tiktok_brands->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Merek Produk Detail');
		$this->render('backend/standart/administrator/tiktok_brands/tiktok_brands_view', $this->data);
	}
	
	/**
	* delete Tiktok Brandss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_brands = $this->model_tiktok_brands->find($id);

		
		
		return $this->model_tiktok_brands->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_brands_export');

		$this->model_tiktok_brands->export('tiktok_brands', 'tiktok_brands');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_brands_export');

		$this->model_tiktok_brands->pdf('tiktok_brands', 'tiktok_brands');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_brands_export');

		$table = $title = 'tiktok_brands';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_brands->find($id);
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


/* End of file tiktok_brands.php */
/* Location: ./application/controllers/administrator/Tiktok Brands.php */