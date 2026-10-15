<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Plans Controller
*| --------------------------------------------------------------------------
*| Subscription plans management controller
*|
*/
class Plans extends Admin	
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_plans');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* Show all Plans
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('plans_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['planss'] = $this->model_plans->get($filter, $field, $this->limit_page, $offset);
		$this->data['plans_counts'] = $this->model_plans->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/plans/index/',
			'total_rows'   => $this->model_plans->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Paket Langganan');
		$this->render('backend/standart/administrator/plans/plans_list', $this->data);
	}
	
	/**
	* Add new plan view
	*/
	public function add()
	{
		$this->is_allowed('plans_add');

		$this->template->title('Tambah Paket Langganan Baru');
		$this->render('backend/standart/administrator/plans/plans_add', $this->data);
	}

	/**
	* Add New Plan Save
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('plans_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
			]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Nama Paket', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('price_monthly', 'Harga 1 Bulan', 'trim|required|numeric');

		if ($this->form_validation->run()) {
			$price_monthly = (float)$this->input->post('price_monthly');

			// 3 months
			$discount_3 = (float)$this->input->post('discount_3_months');
			$price_3 = (float)$this->input->post('price_3_months');
			if ($price_3 <= 0 && $price_monthly > 0) {
				$price_3 = ($price_monthly * 3) * (1 - ($discount_3 / 100));
			}

			// 6 months
			$discount_6 = (float)$this->input->post('discount_6_months');
			$price_6 = (float)$this->input->post('price_6_months');
			if ($price_6 <= 0 && $price_monthly > 0) {
				$price_6 = ($price_monthly * 6) * (1 - ($discount_6 / 100));
			}

			// 12 months
			$discount_12 = (float)$this->input->post('discount_12_months');
			$price_12 = (float)$this->input->post('price_12_months');
			if ($price_12 <= 0 && $price_monthly > 0) {
				$price_12 = ($price_monthly * 12) * (1 - ($discount_12 / 100));
			}

			$is_special = $this->input->post('is_special') ? 1 : 0;
			$special_badge = $is_special ? ($this->input->post('special_badge') ?: 'Paling Populer') : '';

			// Process features list
			$features_input = $this->input->post('features');
			$features_json = '[]';
			if (is_array($features_input)) {
				$clean_features = array_values(array_filter(array_map('trim', $features_input)));
				$features_json = json_encode($clean_features);
			} elseif (is_string($features_input) && !empty($features_input)) {
				// Check if already json
				$decoded = json_decode($features_input, true);
				if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
					$features_json = json_encode(array_values(array_filter($decoded)));
				} else {
					// Split by line
					$lines = explode("\n", str_replace("\r", "", $features_input));
					$clean_lines = array_values(array_filter(array_map('trim', $lines)));
					$features_json = json_encode($clean_lines);
				}
			}

			$save_data = [
				'name' => $this->input->post('name'),
				'code' => url_title($this->input->post('name'), '-', true),
				'description' => $this->input->post('description'),
				'price_monthly' => $price_monthly,
				'discount_3_months' => $discount_3,
				'price_3_months' => $price_3,
				'discount_6_months' => $discount_6,
				'price_6_months' => $price_6,
				'discount_12_months' => $discount_12,
				'price_12_months' => $price_12,
				'price_yearly' => $price_12,
				'is_special' => $is_special,
				'special_badge' => $special_badge,
				'max_shops' => (int)$this->input->post('max_shops'),
				'max_users' => (int)$this->input->post('max_users'),
				'max_warehouses' => (int)$this->input->post('max_warehouses'),
				'max_products' => (int)$this->input->post('max_products'),
				'max_orders_per_month' => (int)$this->input->post('max_orders_per_month'),
				'features' => $features_json,
				'status' => in_array($this->input->post('status'), ['active', 'inactive']) ? $this->input->post('status') : 'active',
				'sort_order' => (int)$this->input->post('sort_order'),
				'cta_text' => $this->input->post('cta_text') ?: 'Pilih Paket Ini',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$save_plans = $this->model_plans->store($save_data);

			if ($save_plans) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_plans;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/plans/edit/' . $save_plans, 'Edit Paket'),
						anchor('administrator/plans', 'Kembali ke Daftar')
					]);
				} else {
					set_message(cclang('success_save_data_redirect', [
						anchor('administrator/plans/edit/' . $save_plans, 'Edit Paket')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/plans');
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* Update view Plans
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('plans_update');

		$this->data['plans'] = $this->model_plans->find($id);

		if (!$this->data['plans']) {
			set_message('Paket langganan tidak ditemukan.', 'error');
			redirect('administrator/plans');
		}

		$this->template->title('Edit Paket Langganan');
		$this->render('backend/standart/administrator/plans/plans_update', $this->data);
	}

	/**
	* Update Plans Save
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('plans_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
			]);
			exit;
		}

		$plan = $this->model_plans->find($id);
		if (!$plan) {
			echo json_encode([
				'success' => false,
				'message' => 'Paket langganan tidak ditemukan.'
			]);
			exit;
		}

		$this->form_validation->set_rules('name', 'Nama Paket', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('price_monthly', 'Harga 1 Bulan', 'trim|required|numeric');

		if ($this->form_validation->run()) {
			$price_monthly = (float)$this->input->post('price_monthly');

			// 3 months
			$discount_3 = (float)$this->input->post('discount_3_months');
			$price_3 = (float)$this->input->post('price_3_months');
			if ($price_3 <= 0 && $price_monthly > 0) {
				$price_3 = ($price_monthly * 3) * (1 - ($discount_3 / 100));
			}

			// 6 months
			$discount_6 = (float)$this->input->post('discount_6_months');
			$price_6 = (float)$this->input->post('price_6_months');
			if ($price_6 <= 0 && $price_monthly > 0) {
				$price_6 = ($price_monthly * 6) * (1 - ($discount_6 / 100));
			}

			// 12 months
			$discount_12 = (float)$this->input->post('discount_12_months');
			$price_12 = (float)$this->input->post('price_12_months');
			if ($price_12 <= 0 && $price_monthly > 0) {
				$price_12 = ($price_monthly * 12) * (1 - ($discount_12 / 100));
			}

			$is_special = $this->input->post('is_special') ? 1 : 0;
			$special_badge = $is_special ? ($this->input->post('special_badge') ?: 'Paling Populer') : '';

			// Process features list
			$features_input = $this->input->post('features');
			$features_json = '[]';
			if (is_array($features_input)) {
				$clean_features = array_values(array_filter(array_map('trim', $features_input)));
				$features_json = json_encode($clean_features);
			} elseif (is_string($features_input) && !empty($features_input)) {
				$decoded = json_decode($features_input, true);
				if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
					$features_json = json_encode(array_values(array_filter($decoded)));
				} else {
					$lines = explode("\n", str_replace("\r", "", $features_input));
					$clean_lines = array_values(array_filter(array_map('trim', $lines)));
					$features_json = json_encode($clean_lines);
				}
			}

			$save_data = [
				'name' => $this->input->post('name'),
				'code' => url_title($this->input->post('name'), '-', true),
				'description' => $this->input->post('description'),
				'price_monthly' => $price_monthly,
				'discount_3_months' => $discount_3,
				'price_3_months' => $price_3,
				'discount_6_months' => $discount_6,
				'price_6_months' => $price_6,
				'discount_12_months' => $discount_12,
				'price_12_months' => $price_12,
				'price_yearly' => $price_12,
				'is_special' => $is_special,
				'special_badge' => $special_badge,
				'max_shops' => (int)$this->input->post('max_shops'),
				'max_users' => (int)$this->input->post('max_users'),
				'max_warehouses' => (int)$this->input->post('max_warehouses'),
				'max_products' => (int)$this->input->post('max_products'),
				'max_orders_per_month' => (int)$this->input->post('max_orders_per_month'),
				'features' => $features_json,
				'status' => in_array($this->input->post('status'), ['active', 'inactive']) ? $this->input->post('status') : 'active',
				'sort_order' => (int)$this->input->post('sort_order'),
				'cta_text' => $this->input->post('cta_text') ?: 'Pilih Paket Ini',
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$save_plans = $this->model_plans->change($id, $save_data);

			if ($save_plans) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/plans', 'Kembali ke Daftar')
					]);
				} else {
					set_message(cclang('success_update_data_redirect', []), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/plans');
				}
			} else {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* Delete Plans
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('plans_delete');

		$arr_id = $this->input->get('id');
		$success_count = 0;
		$in_use_names = [];

		if (!empty($id)) {
			$ids = [$id];
		} elseif (is_array($arr_id) && count($arr_id) > 0) {
			$ids = $arr_id;
		} else {
			$ids = [];
		}

		foreach ($ids as $item_id) {
			// Check if used by any tenants
			$plan = $this->model_plans->find($item_id);
			if (!$plan) continue;

			$tenant_count = $this->db->where('plan_id', $item_id)->count_all_results('tenants');
			if ($tenant_count > 0) {
				$in_use_names[] = $plan->name . " ({$tenant_count} tenant)";
				continue;
			}

			if ($this->_remove($item_id)) {
				$success_count++;
			}
		}

		if ($success_count > 0) {
			set_message("Berhasil menghapus {$success_count} paket langganan.", 'success');
		}

		if (count($in_use_names) > 0) {
			$list_str = implode(', ', $in_use_names);
			set_message("Paket berikut tidak dapat dihapus karena masih digunakan oleh tenant: {$list_str}. Silakan nonaktifkan paket jika tidak ingin ditawarkan lagi.", 'error');
		}

		if ($success_count === 0 && count($in_use_names) === 0) {
			set_message(cclang('error_delete', 'plans'), 'error');
		}

		redirect_back();
	}

	/**
	* View plan detail
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('plans_view');

		$this->data['plans'] = $this->model_plans->find($id);

		if (!$this->data['plans']) {
			set_message('Paket langganan tidak ditemukan.', 'error');
			redirect('administrator/plans');
		}

		$this->template->title('Detail Paket Langganan');
		$this->render('backend/standart/administrator/plans/plans_view', $this->data);
	}

	/**
	* Toggle Status via AJAX
	*/
	public function set_status()
	{
		if (!$this->is_allowed('plans_update', false)) {
			echo json_encode(['success' => false, 'message' => cclang('sorry_you_do_not_have_permission_to_access')]);
			exit;
		}

		$id = $this->input->post('id');
		$status = $this->input->post('status') == 'active' ? 'active' : 'inactive';

		$plan = $this->model_plans->find($id);
		if (!$plan) {
			echo json_encode(['success' => false, 'message' => 'Paket tidak ditemukan']);
			exit;
		}

		$updated = $this->model_plans->change($id, ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
		if ($updated) {
			echo json_encode(['success' => true, 'status' => $status, 'message' => 'Status berhasil diperbarui']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);
		}
	}
	
	/**
	* Helper to delete plan
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		return $this->model_plans->remove($id);
	}
	
	/**
	* Export to excel
	*/
	public function export()
	{
		$this->is_allowed('plans_export');
		$this->model_plans->export('plans', 'plans');
	}

	/**
	* Export to PDF
	*/
	public function export_pdf()
	{
		$this->is_allowed('plans_export');
		$this->model_plans->pdf('plans', 'plans');
	}
}

/* End of file Plans.php */
/* Location: ./modules/plans/controllers/backend/Plans.php */