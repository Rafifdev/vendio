<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Warehouses Controller
*| --------------------------------------------------------------------------
*| Tiktok Warehouses site
*|
*/
class Tiktok_warehouses extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_warehouses');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Warehousess
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_warehouses_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_warehousess'] = $this->model_tiktok_warehouses->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_warehouses_counts'] = $this->model_tiktok_warehouses->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/tiktok_warehouses/index/',
			'total_rows'   => $this->model_tiktok_warehouses->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Gudang TikTok List');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_list', $this->data);
	}
	
	/**
	* Add new tiktok_warehousess
	*
	*/
	public function add()
	{
		$this->is_allowed('tiktok_warehouses_add');

		$this->template->title('Gudang TikTok New');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_add', $this->data);
	}

	/**
	* Add New Tiktok Warehousess
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_warehouses_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('shop_id', 'Shop Id', 'trim|required');
		$this->form_validation->set_rules('tiktok_warehouse_id', 'Tiktok Warehouse Id', 'trim|required');
		$this->form_validation->set_rules('branch_mapping_id', 'Branch Mapping Id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('warehouse_type', 'Warehouse Type', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('effect_status', 'Effect Status', 'trim|required');
		$this->form_validation->set_rules('is_default', 'Is Default', 'trim|required');
		$this->form_validation->set_rules('created_at', 'Created At', 'trim|required');
		$this->form_validation->set_rules('updated_at', 'Updated At', 'trim|required');
		

		if ($this->form_validation->run()) {
		
			$save_data = [
				'shop_id' => $this->input->post('shop_id'),
				'tiktok_warehouse_id' => $this->input->post('tiktok_warehouse_id'),
				'branch_mapping_id' => $this->input->post('branch_mapping_id'),
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'warehouse_type' => $this->input->post('warehouse_type'),
				'effect_status' => $this->input->post('effect_status'),
				'is_default' => $this->input->post('is_default'),
				'created_at' => $this->input->post('created_at'),
				'updated_at' => $this->input->post('updated_at'),
			];

			
			$save_tiktok_warehouses = $this->model_tiktok_warehouses->store($save_data);
            

			if ($save_tiktok_warehouses) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_warehouses;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_warehouses/edit/' . $save_tiktok_warehouses, 'Edit Tiktok Warehouses'),
						anchor('administrator/tiktok_warehouses', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_warehouses/edit/' . $save_tiktok_warehouses, 'Edit Tiktok Warehouses')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Tiktok Warehousess
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('tiktok_warehouses_update');

		$this->data['tiktok_warehouses'] = $this->model_tiktok_warehouses->find($id);

		$this->template->title('Gudang TikTok Update');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_update', $this->data);
	}

	/**
	* Update Tiktok Warehousess
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_warehouses_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('shop_id', 'Shop Id', 'trim|required');
		$this->form_validation->set_rules('tiktok_warehouse_id', 'Tiktok Warehouse Id', 'trim|required');
		$this->form_validation->set_rules('branch_mapping_id', 'Branch Mapping Id', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('warehouse_type', 'Warehouse Type', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('effect_status', 'Effect Status', 'trim|required');
		$this->form_validation->set_rules('is_default', 'Is Default', 'trim|required');
		$this->form_validation->set_rules('created_at', 'Created At', 'trim|required');
		$this->form_validation->set_rules('updated_at', 'Updated At', 'trim|required');
		
		if ($this->form_validation->run()) {
		
			$save_data = [
				'shop_id' => $this->input->post('shop_id'),
				'tiktok_warehouse_id' => $this->input->post('tiktok_warehouse_id'),
				'branch_mapping_id' => $this->input->post('branch_mapping_id'),
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'warehouse_type' => $this->input->post('warehouse_type'),
				'effect_status' => $this->input->post('effect_status'),
				'is_default' => $this->input->post('is_default'),
				'created_at' => $this->input->post('created_at'),
				'updated_at' => $this->input->post('updated_at'),
			];

			
			$save_tiktok_warehouses = $this->model_tiktok_warehouses->change($id, $save_data);

			if ($save_tiktok_warehouses) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_warehouses', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_warehouses');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Warehousess
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_warehouses_delete');

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
            set_message(cclang('has_been_deleted', 'tiktok_warehouses'), 'success');
        } else {
            set_message(cclang('error_delete', 'tiktok_warehouses'), 'error');
        }

		redirect_back();
	}

		/**
	* View view Tiktok Warehousess
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_warehouses_view');

		$this->data['tiktok_warehouses'] = $this->model_tiktok_warehouses->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Gudang TikTok Detail');
		$this->render('backend/standart/administrator/tiktok_warehouses/tiktok_warehouses_view', $this->data);
	}
	
	/**
	* delete Tiktok Warehousess
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_warehouses = $this->model_tiktok_warehouses->find($id);

		
		
		return $this->model_tiktok_warehouses->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_warehouses_export');

		$this->model_tiktok_warehouses->export('tiktok_warehouses', 'tiktok_warehouses');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_warehouses_export');

		$this->model_tiktok_warehouses->pdf('tiktok_warehouses', 'tiktok_warehouses');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_warehouses_export');

		$table = $title = 'tiktok_warehouses';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_warehouses->find($id);
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


/* End of file tiktok_warehouses.php */
/* Location: ./application/controllers/administrator/Tiktok Warehouses.php */