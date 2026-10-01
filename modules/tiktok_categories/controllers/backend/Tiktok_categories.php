<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Categories Controller
*| --------------------------------------------------------------------------
*| Tiktok Categories site
*|
*/
class Tiktok_categories extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_categories');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Categoriess
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_categories_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_categoriess'] = $this->model_tiktok_categories->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_categories_counts'] = $this->model_tiktok_categories->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_categories/index/',
			'total_rows'   => $this->model_tiktok_categories->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Kategori Produk List');
		$this->render('backend/standart/administrator/tiktok_categories/tiktok_categories_list', $this->data);
	}
	
	/**
	* Tarik Data Kategori dari TikTok Shop API
	*/
	public function sync()
	{
		$this->is_allowed('tiktok_categories_list');
		$this->load->library('tiktok_api');

		$shop = $this->db->get_where('tiktok_shops', ['is_active' => 1])->row();
		if (!$shop) {
			$shop = $this->db->get('tiktok_shops')->row();
		}
		if (!$shop) {
			set_message('Toko TikTok belum aktif atau belum terhubung.', 'error');
			redirect('administrator/tiktok_categories');
			return;
		}

		$response = $this->tiktok_api->get_categories(['category_version' => 'v2'], $shop->id);
		if (empty($response['success']) && (!isset($response['code']) || $response['code'] !== 0)) {
			set_message('Gagal menarik kategori dari TikTok Shop: ' . ($response['message'] ?? 'Error API'), 'error');
			redirect('administrator/tiktok_categories');
			return;
		}

		$categories = $response['data']['categories'] ?? [];
		if (empty($categories)) {
			set_message('Tidak ada data kategori ditemukan dari TikTok Shop.', 'warning');
			redirect('administrator/tiktok_categories');
			return;
		}

		// Optimasi Database: Pre-fetch seluruh ID kategori yang sudah tersimpan dalam 1 query
		$existing_cats = array_column(
			$this->db->select('id, tiktok_category_id')->get('tiktok_categories')->result(),
			'id',
			'tiktok_category_id'
		);

		$this->db->trans_start();
		$synced_count = 0;

		foreach ($categories as $cat) {
			$cat_id = $cat['id'] ?? '';
			if (empty($cat_id)) continue;

			$data_cat = [
				'tiktok_category_id' => $cat_id,
				'parent_category_id' => $cat['parent_id'] ?? $cat['parent_category_id'] ?? '0',
				'local_name'         => $cat['local_name'] ?? $cat['name'] ?? '',
				'category_version'   => 'v2',
				'is_leaf'            => !empty($cat['is_leaf']) ? 1 : 0,
				'level'              => $cat['level'] ?? 1,
				'permission_status'  => $cat['permission_status'] ?? 'AVAILABLE',
				'synced_at'          => date('Y-m-d H:i:s'),
			];

			$existing_id = $existing_cats[$cat_id] ?? null;

			if ($existing_id) {
				$this->db->where('id', $existing_id)->update('tiktok_categories', $data_cat);
			} else {
				$this->db->insert('tiktok_categories', $data_cat);
			}

			$synced_count++;
		}

		$this->db->trans_complete();

		set_message("Berhasil menarik {$synced_count} kategori resmi TikTok Shop.", 'success');
		redirect('administrator/tiktok_categories');
	}
	
	/**
	* delete Tiktok Categoriess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_categories_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_categories'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_categories'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Categoriess
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_categories_view');

		$category = $this->model_tiktok_categories->join_avaiable()->filter_avaiable()->find($id);
		if ($category) {
			$category->attributes = $this->db->get_where('tiktok_category_attributes', ['category_id' => $category->id])->result();
			if (empty($category->attributes) && $category->is_leaf) {
				$this->load->library('tiktok_api');
				$attr_res = $this->tiktok_api->get_category_attributes($category->tiktok_category_id);
				if (!empty($attr_res['data']['attributes'])) {
					foreach ($attr_res['data']['attributes'] as $attr) {
						$attr_id = $attr['id'] ?? '';
						if (empty($attr_id)) continue;
						$attr_data = [
							'category_id'         => $category->id,
							'tiktok_attribute_id' => $attr_id,
							'attribute_name'      => $attr['name'] ?? '',
							'attribute_type'      => $attr['type'] ?? '',
							'is_required'         => (!empty($attr['is_requried']) || !empty($attr['is_required'])) ? 1 : 0,
							'values_json'         => !empty($attr['values']) ? json_encode($attr['values'], JSON_UNESCAPED_UNICODE) : null,
							'created_at'          => date('Y-m-d H:i:s')
						];
						$this->db->insert('tiktok_category_attributes', $attr_data);
					}
					$category->attributes = $this->db->get_where('tiktok_category_attributes', ['category_id' => $category->id])->result();
				}
			}
		}

		$this->data['tiktok_categories'] = $category;

		$this->template->title('Kategori Produk Detail');
		$this->render('backend/standart/administrator/tiktok_categories/tiktok_categories_view', $this->data);
	}
	
	/**
	* delete Tiktok Categoriess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_categories = $this->model_tiktok_categories->find($id);

		
		
		return $this->model_tiktok_categories->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_categories_export');

		$this->model_tiktok_categories->export('tiktok_categories', 'tiktok_categories');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_categories_export');

		$this->model_tiktok_categories->pdf('tiktok_categories', 'tiktok_categories');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_categories_export');

		$table = $title = 'tiktok_categories';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_categories->find($id);
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


/* End of file tiktok_categories.php */
/* Location: ./application/controllers/administrator/Tiktok Categories.php */