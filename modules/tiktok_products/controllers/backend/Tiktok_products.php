<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Products Controller
*| --------------------------------------------------------------------------
*| Tiktok Products site
*|
*/
class Tiktok_products extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_products');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Productss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_products_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['tiktok_productss'] = $this->model_tiktok_products->get($filter, $field, $this->limit_page, $offset);
		$this->data['tiktok_products_counts'] = $this->model_tiktok_products->count_all($filter, $field);

		// Ambil varian SKU untuk setiap produk di halaman ini
		$product_ids = array_column($this->data['tiktok_productss'], 'id');
		$skus_by_product = [];
		if (!empty($product_ids)) {
			$skus = $this->db->where_in('tiktok_product_id', $product_ids)->get('tiktok_product_skus')->result();
			foreach ($skus as $sku) {
				$skus_by_product[$sku->tiktok_product_id][] = $sku;
			}
		}
		$this->data['skus_by_product'] = $skus_by_product;

		$config = [
			'base_url'     => 'administrator/tiktok_products/index/',
			'total_rows'   => $this->model_tiktok_products->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Produk TikTok List');
		$this->render('backend/standart/administrator/tiktok_products/tiktok_products_list', $this->data);
	}
	
	/**
	* Add new tiktok_productss
	*
	*/
	public function add()
	{
		$this->is_allowed('tiktok_products_add');

		$this->data['categories'] = $this->get_tiktok_categories();
		$this->data['brands'] = $this->get_tiktok_brands('601756');

		$this->template->title('Produk TikTok New');
		$this->render('backend/standart/administrator/tiktok_products/tiktok_products_add', $this->data);
	}

	/**
	 * Ambil daftar kategori riil dari TikTok Shop API (dengan caching lokal)
	 *
	 * @param int|string|null $shop_id
	 * @return array
	 */
	public function get_tiktok_categories($shop_id = null)
	{
		$cache_dir = APPPATH . 'cache';
		if (!is_dir($cache_dir)) {
			@mkdir($cache_dir, 0777, true);
		}
		$cache_file = $cache_dir . '/tiktok_categories_leaf.json';

		// Jika cache masih valid (< 24 jam)
		if (file_exists($cache_file) && (time() - filemtime($cache_file) < 86400)) {
			$cached = @json_decode(file_get_contents($cache_file), true);
			if (!empty($cached) && is_array($cached)) {
				return $cached;
			}
		}

		$this->load->library('tiktok_api');
		$res = $this->tiktok_api->get_categories([], $shop_id);

		if (!empty($res['data']['categories']) && is_array($res['data']['categories'])) {
			$raw_cats = $res['data']['categories'];
			$cat_map = [];
			foreach ($raw_cats as $cat) {
				$cat_map[$cat['id']] = $cat;
			}

			$leaf_categories = [];
			foreach ($raw_cats as $cat) {
				if (!empty($cat['is_leaf'])) {
					// Susun hierarchical path
					$path = [];
					$curr = $cat;
					while (!empty($curr)) {
						array_unshift($path, $curr['local_name'] ?? $curr['id']);
						$parent_id = $curr['parent_id'] ?? '0';
						if ($parent_id !== '0' && isset($cat_map[$parent_id])) {
							$curr = $cat_map[$parent_id];
						} else {
							break;
						}
					}
					$full_name = implode(' > ', $path);
					$leaf_categories[] = [
						'id' => (string)$cat['id'],
						'name' => $full_name
					];
				}
			}

			// Sort berdasarkan nama path secara alfabetis
			usort($leaf_categories, function($a, $b) {
				return strcmp($a['name'], $b['name']);
			});

			if (!empty($leaf_categories)) {
				@file_put_contents($cache_file, json_encode($leaf_categories, JSON_UNESCAPED_UNICODE));
				return $leaf_categories;
			}
		}

		// Fallback jika API belum terhubung atau limit
		return [
			['id' => '601756', 'name' => 'Komputer & Peralatan Kantor > Komputer Desktop, Laptop & Tablet > Laptop'],
			['id' => '601755', 'name' => 'Komputer & Peralatan Kantor > Komputer Desktop, Laptop & Tablet > Komputer Desktop'],
			['id' => '600001', 'name' => 'Pakaian & Perlengkapan Fashion > Atasan & Bawahan'],
			['id' => '601300', 'name' => 'Handphone & Aksesori > Handphone > Smartphone'],
		];
	}

	/**
	 * Ambil daftar brand TikTok riil sesuai category_id (dengan caching lokal per kategori)
	 *
	 * @param string $category_id
	 * @param int|string|null $shop_id
	 * @return array
	 */
	public function get_tiktok_brands($category_id = '601756', $shop_id = null)
	{
		$brands = [
			['id' => '0', 'name' => 'No Brand / Tanpa Merek']
		];

		if (empty($category_id)) {
			return $brands;
		}

		// Jika category_id berupa nama teks, cari numeric ID dari leaf categories
		if (!is_numeric($category_id)) {
			$all_cats = $this->get_tiktok_categories($shop_id);
			foreach ($all_cats as $c) {
				if ($c['name'] === $category_id || strpos($c['name'], $category_id) !== false) {
					$category_id = $c['id'];
					break;
				}
			}
		}

		if (!is_numeric($category_id)) {
			return $brands;
		}

		$cache_dir = APPPATH . 'cache';
		if (!is_dir($cache_dir)) {
			@mkdir($cache_dir, 0777, true);
		}
		$cache_file = $cache_dir . '/tiktok_brands_' . $category_id . '.json';

		if (file_exists($cache_file) && (time() - filemtime($cache_file) < 86400)) {
			$cached = @json_decode(file_get_contents($cache_file), true);
			if (!empty($cached) && is_array($cached)) {
				return $cached;
			}
		}

		$this->load->library('tiktok_api');
		$res = $this->tiktok_api->get_brands($category_id, ['page_size' => 100], $shop_id);

		if (!empty($res['data']['brands']) && is_array($res['data']['brands'])) {
			foreach ($res['data']['brands'] as $b) {
				$brands[] = [
					'id' => (string)$b['id'],
					'name' => (string)$b['name']
				];
			}
			@file_put_contents($cache_file, json_encode($brands, JSON_UNESCAPED_UNICODE));
		}

		return $brands;
	}

	/**
	 * AJAX endpoint untuk mengambil brand TikTok riil sesuai category_id
	 */
	public function ajax_get_brands()
	{
		header('Content-Type: application/json');
		$category_id = $this->input->get('category_id') ?: $this->input->post('category_id');
		$shop_id = $this->input->get('tiktok_shop_id') ?: $this->input->post('tiktok_shop_id');

		$brands = $this->get_tiktok_brands($category_id, $shop_id);

		echo json_encode([
			'success'     => true,
			'category_id' => $category_id,
			'brands'      => $brands
		]);
		exit;
	}

	/**
	 * Parse pesan error detail dari response TikTok Shop Partner API
	 *
	 * @param array $res Response API TikTok
	 * @param string $fallback Pesan default jika tidak ditemukan
	 * @return string
	 */
	private function parse_tiktok_error($res, $fallback = 'Gagal memproses permintaan ke TikTok Shop')
	{
		if (empty($res)) {
			return $fallback;
		}

		$messages = [];

		if (!empty($res['message']) && $res['message'] !== 'Success' && $res['message'] !== 'OK') {
			$messages[] = $res['message'];
		}

		// Cek detail di tingkat utama
		if (!empty($res['detail'])) {
			if (is_array($res['detail'])) {
				foreach ($res['detail'] as $d) {
					if (is_array($d)) {
						if (!empty($d['message'])) $messages[] = $d['message'];
						if (!empty($d['field'])) $messages[] = 'Field: ' . $d['field'];
					} else {
						$messages[] = (string)$d;
					}
				}
			} else {
				$messages[] = (string)$res['detail'];
			}
		}

		// Cek errors di data
		if (!empty($res['data']['errors']) && is_array($res['data']['errors'])) {
			foreach ($res['data']['errors'] as $err) {
				if (!empty($err['message'])) {
					$messages[] = $err['message'];
				}
				if (!empty($err['detail']['extra_errors']) && is_array($err['detail']['extra_errors'])) {
					foreach ($err['detail']['extra_errors'] as $sub_err) {
						if (!empty($sub_err['message'])) {
							$messages[] = $sub_err['message'];
						}
					}
				}
			}
		}

		// Cek sub_errors
		if (!empty($res['errors']) && is_array($res['errors'])) {
			foreach ($res['errors'] as $err) {
				if (is_array($err)) {
					if (!empty($err['message'])) $messages[] = $err['message'];
				} else {
					$messages[] = (string)$err;
				}
			}
		}

		$messages = array_unique(array_filter($messages));

		if (!empty($messages)) {
			return implode(' - ', $messages);
		}

		return $fallback;
	}

	/**
	* Add New Tiktok Productss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!$this->is_allowed('tiktok_products_add', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		$this->form_validation->set_rules('tiktok_shop_id', 'Toko TikTok', 'trim|required', [
			'required' => 'Toko TikTok wajib dipilih sesuai ketentuan.'
		]);
		$this->form_validation->set_rules('title', 'Judul Produk', 'trim|required|min_length[25]|max_length[255]', [
			'required'   => 'Judul produk wajib diisi sesuai ketentuan TikTok.',
			'min_length' => 'Judul produk minimal 25 karakter sesuai ketentuan TikTok.',
			'max_length' => 'Judul produk maksimal 255 karakter sesuai ketentuan TikTok.'
		]);
		$this->form_validation->set_rules('price', 'Harga Produk', 'trim|required|numeric|greater_than[0]', [
			'required'     => 'Harga produk wajib diisi sesuai ketentuan TikTok.',
			'numeric'      => 'Harga produk harus berupa angka.',
			'greater_than' => 'Harga produk minimal Rp 1.000.'
		]);
		$this->form_validation->set_rules('total_stock', 'Total Stok', 'trim|required|integer|greater_than_equal_to[0]', [
			'required'              => 'Total stok produk wajib diisi sesuai ketentuan TikTok.',
			'integer'               => 'Total stok harus berupa bilangan bulat.',
			'greater_than_equal_to' => 'Total stok minimal 0.'
		]);
		$this->form_validation->set_rules('package_weight', 'Berat Paket', 'trim|required|numeric|greater_than[0]', [
			'required'     => 'Berat paket (Package Weight) wajib diisi sesuai ketentuan TikTok.',
			'numeric'      => 'Berat paket harus berupa angka (dalam kg).',
			'greater_than' => 'Berat paket minimal 0.01 kg.'
		]);
		$this->form_validation->set_rules('description', 'Deskripsi Produk', 'trim|required|min_length[10]', [
			'required'   => 'Deskripsi produk wajib diisi sesuai ketentuan TikTok.',
			'min_length' => 'Deskripsi produk minimal 10 karakter sesuai ketentuan TikTok.'
		]);

		if ($this->form_validation->run()) {
			$tiktok_products_main_image_uuid = $this->input->post('tiktok_products_main_image_uuid');
			$tiktok_products_main_image_name = $this->input->post('tiktok_products_main_image_name');

			if (empty($tiktok_products_main_image_name)) {
				echo json_encode([
					'success' => false,
					'message' => 'Gambar utama produk wajib diunggah sesuai ketentuan TikTok (resolusi minimal 300x300 px).'
				]);
				exit;
			}

			$raw_weight = floatval($this->input->post('package_weight'));
			$package_weight = max(0.01, round($raw_weight, 2));

			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'title'          => $this->input->post('title'),
				'status'         => 'ACTIVATE',
				'category_name'  => $this->input->post('category_name'),
				'brand_name'     => $this->input->post('brand_name'),
				'seller_sku'     => $this->input->post('seller_sku') ?: 'SKU-' . time(),
				'price'          => max(1000, intval($this->input->post('price'))),
				'total_stock'    => max(0, intval($this->input->post('total_stock'))),
				'package_weight' => (string)$package_weight,
				'description'    => $this->input->post('description'),
			];

			if (!is_dir(FCPATH . '/uploads/tiktok_products/')) {
				mkdir(FCPATH . '/uploads/tiktok_products/', 0777, true);
			}

			$image_uri = '';
			if (!empty($tiktok_products_main_image_name)) {
				$src_file = FCPATH . 'uploads/tmp/' . $tiktok_products_main_image_uuid . '/' . $tiktok_products_main_image_name;

				if (is_file($src_file)) {
					$tiktok_products_main_image_name_copy = date('YmdHis') . '-' . $tiktok_products_main_image_name;
					@rename($src_file, FCPATH . 'uploads/tiktok_products/' . $tiktok_products_main_image_name_copy);
					if (is_file(FCPATH . 'uploads/tiktok_products/' . $tiktok_products_main_image_name_copy)) {
						$save_data['main_image'] = $tiktok_products_main_image_name_copy;
					}
				} else {
					$existing_files = glob(FCPATH . 'uploads/tiktok_products/*' . $tiktok_products_main_image_name);
					if (!empty($existing_files)) {
						$save_data['main_image'] = basename(end($existing_files));
					}
				}

				if (empty($save_data['main_image']) || !is_file(FCPATH . 'uploads/tiktok_products/' . $save_data['main_image'])) {
					echo json_encode([
						'success' => false,
						'message' => 'File gambar tidak ditemukan. Silakan pilih kembali gambar produk.'
					]);
					exit;
				}
			}

			// Koneksikan langsung ke TikTok Shop API
			$this->load->library('tiktok_api');
			$shop_id = $save_data['tiktok_shop_id'];

			// 1. Upload gambar ke TikTok CDN
			$image_path = FCPATH . 'uploads/tiktok_products/' . $save_data['main_image'];
			$upload_res = $this->tiktok_api->upload_image($image_path, $shop_id);
			if (!empty($upload_res['data']['uri'])) {
				$image_uri = $upload_res['data']['uri'];
			} else {
				$err_msg = $this->parse_tiktok_error($upload_res, 'Format atau resolusi gambar minimal 300x300 px.');
				echo json_encode([
					'success' => false,
					'message' => 'Gagal mengunggah gambar ke TikTok: ' . $err_msg
				]);
				exit;
			}

			// 2. Ambil warehouse ID
			$warehouse_id = '';
			$warehouse_res = $this->tiktok_api->get_warehouses($shop_id);
			if (!empty($warehouse_res['data']['warehouses'])) {
				foreach ($warehouse_res['data']['warehouses'] as $wh) {
					$wh_type = $wh['type'] ?? ($wh['warehouse_type'] ?? '');
					$wh_id = $wh['id'] ?? ($wh['warehouse_id'] ?? '');
					if ($wh_type == 'SALES_WAREHOUSE') {
						$warehouse_id = (string)$wh_id;
						break;
					}
				}
				if (empty($warehouse_id) && !empty($warehouse_res['data']['warehouses'][0])) {
					$first_wh = $warehouse_res['data']['warehouses'][0];
					$warehouse_id = (string)($first_wh['id'] ?? ($first_wh['warehouse_id'] ?? ''));
				}
			}

			if (empty($warehouse_id)) {
				echo json_encode([
					'success' => false,
					'message' => 'Gagal mendapatkan ID Gudang (Sales Warehouse) dari toko TikTok. Pastikan toko memiliki gudang aktif.'
				]);
				exit;
			}

			// 3. Tentukan category dan atribut sesuai ketentuan TikTok
			$category_id = '601756';
			if (is_numeric($this->input->post('category_name')) && !empty($this->input->post('category_name'))) {
				$category_id = (string)$this->input->post('category_name');
			}

			$product_attributes = [
				[
					'id' => '100107',
					'values' => [
						['id' => '1000057', 'name' => 'Tanpa Garansi']
					]
				],
				[
					'id' => '101734',
					'values' => [
						['id' => '1000059', 'name' => 'Tidak']
					]
				]
			];

			if ($category_id !== '601756') {
				$attr_res = $this->tiktok_api->request('/product/202309/categories/' . $category_id . '/attributes', 'GET', ['category_version' => 'v2'], null, $shop_id);
				if (!empty($attr_res['data']['attributes'])) {
					$custom_attrs = [];
					foreach ($attr_res['data']['attributes'] as $attr) {
						if (!empty($attr['is_requried']) && !empty($attr['values'])) {
							$first_val = $attr['values'][0];
							$custom_attrs[] = [
								'id' => (string)$attr['id'],
								'values' => [
									[
										'id' => (string)$first_val['id'],
										'name' => (string)$first_val['name']
									]
								]
							];
						}
					}
					if (!empty($custom_attrs)) {
						$product_attributes = $custom_attrs;
					}
				}
			}

			$brand_id = $this->input->post('brand_id');
			if (empty($brand_id) || $brand_id === 'No Brand' || !is_numeric($brand_id)) {
				$brand_id = '0';
			}

			$tiktok_payload = [
				'save_mode' => 'LISTING',
				'title' => $save_data['title'],
				'description' => $save_data['description'],
				'category_id' => $category_id,
				'brand_id' => (string)$brand_id,
				'main_images' => [['uri' => $image_uri]],
				'package_weight' => [
					'value' => (string)$package_weight,
					'unit' => 'KILOGRAM'
				],
				'package_dimensions' => [
					'length' => '30',
					'width' => '20',
					'height' => '5',
					'unit' => 'CENTIMETER'
				],
				'product_attributes' => $product_attributes,
				'skus' => [
					[
						'price' => [
							'amount' => (string)$save_data['price'],
							'currency' => 'IDR'
						],
						'inventory' => [
							[
								'quantity' => $save_data['total_stock'],
								'warehouse_id' => (string)$warehouse_id
							]
						],
						'seller_sku' => (string)$save_data['seller_sku']
					]
				]
			];

			// 4. Kirim ke TikTok Shop Seller Center
			$create_res = $this->tiktok_api->create_product($tiktok_payload, $shop_id);

			if (empty($create_res['data']['product_id']) || (isset($create_res['code']) && $create_res['code'] !== 0) || !empty($create_res['data']['errors'])) {
				$err_msg = $this->parse_tiktok_error($create_res, 'Gagal membuat produk di TikTok Shop');
				echo json_encode([
					'success' => false,
					'message' => 'Ketentuan TikTok belum terpenuhi: ' . $err_msg
				]);
				exit;
			}

			$product_id = $create_res['data']['product_id'];
			$save_data['product_id'] = $product_id;
			$save_data['status'] = 'ACTIVATE';
			$save_data['currency'] = 'IDR';
			$save_data['raw_data'] = json_encode($create_res['data']);

			// Pastikan aktivasi langsung di TikTok
			@$this->tiktok_api->activate_products([$product_id], $shop_id);

			$save_tiktok_products = $this->model_tiktok_products->store($save_data);

			if ($save_tiktok_products) {
				$skus = $create_res['data']['skus'] ?? [];
				$sku_id = !empty($skus) ? ($skus[0]['id'] ?? '') : '';
				if (!empty($sku_id)) {
					$this->db->insert('tiktok_product_skus', [
						'tiktok_product_id' => $save_tiktok_products,
						'product_id' => $product_id,
						'sku_id' => $sku_id,
						'seller_sku' => $save_data['seller_sku'],
						'sku_name' => $save_data['title'],
						'price' => $save_data['price'],
						'currency' => 'IDR',
						'stock' => $save_data['total_stock'],
						'warehouse_id' => $warehouse_id,
						'created_at' => date('Y-m-d H:i:s')
					]);
				}

				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_tiktok_products;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/tiktok_products/edit/' . $save_tiktok_products, 'Edit Tiktok Products'),
						anchor('administrator/tiktok_products', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
						anchor('administrator/tiktok_products/edit/' . $save_tiktok_products, 'Edit Tiktok Products')
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_products');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_products');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Tiktok Productss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$this->is_allowed('tiktok_products_update');

		$product = $this->model_tiktok_products->find($id);
		$this->data['tiktok_products'] = $product;
		$this->data['categories'] = $this->get_tiktok_categories($product ? $product->tiktok_shop_id : null);

		$cat_id = ($product && !empty($product->category_name)) ? $product->category_name : '601756';
		$this->data['brands'] = $this->get_tiktok_brands($cat_id, $product ? $product->tiktok_shop_id : null);
		$this->data['current_brands'] = $this->data['brands'];

		$this->template->title('Produk TikTok Update');
		$this->render('backend/standart/administrator/tiktok_products/tiktok_products_update', $this->data);
	}

	/**
	* Update Tiktok Productss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!$this->is_allowed('tiktok_products_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}
		
		$this->form_validation->set_rules('tiktok_shop_id', 'Toko TikTok', 'trim|required', [
			'required' => 'Toko TikTok wajib dipilih sesuai ketentuan.'
		]);
		$this->form_validation->set_rules('title', 'Judul Produk', 'trim|required|min_length[25]|max_length[255]', [
			'required'   => 'Judul produk wajib diisi sesuai ketentuan TikTok.',
			'min_length' => 'Judul produk minimal 25 karakter sesuai ketentuan TikTok.',
			'max_length' => 'Judul produk maksimal 255 karakter sesuai ketentuan TikTok.'
		]);
		$this->form_validation->set_rules('price', 'Harga Produk', 'trim|required|numeric|greater_than[0]', [
			'required'     => 'Harga produk wajib diisi sesuai ketentuan TikTok.',
			'numeric'      => 'Harga produk harus berupa angka.',
			'greater_than' => 'Harga produk minimal Rp 1.000.'
		]);
		$this->form_validation->set_rules('total_stock', 'Total Stok', 'trim|required|integer|greater_than_equal_to[0]', [
			'required'              => 'Total stok produk wajib diisi sesuai ketentuan TikTok.',
			'integer'               => 'Total stok harus berupa bilangan bulat.',
			'greater_than_equal_to' => 'Total stok minimal 0.'
		]);
		$this->form_validation->set_rules('package_weight', 'Berat Paket', 'trim|required|numeric|greater_than[0]', [
			'required'     => 'Berat paket (Package Weight) wajib diisi sesuai ketentuan TikTok.',
			'numeric'      => 'Berat paket harus berupa angka (dalam kg).',
			'greater_than' => 'Berat paket minimal 0.01 kg.'
		]);
		$this->form_validation->set_rules('description', 'Deskripsi Produk', 'trim|required|min_length[10]', [
			'required'   => 'Deskripsi produk wajib diisi sesuai ketentuan TikTok.',
			'min_length' => 'Deskripsi produk minimal 10 karakter sesuai ketentuan TikTok.'
		]);
		
		if ($this->form_validation->run()) {
			$tiktok_products_main_image_uuid = $this->input->post('tiktok_products_main_image_uuid');
			$tiktok_products_main_image_name = $this->input->post('tiktok_products_main_image_name');
		
			$existing_product = $this->model_tiktok_products->find($id);
			if (!$existing_product) {
				echo json_encode([
					'success' => false,
					'message' => 'Produk tidak ditemukan.'
				]);
				exit;
			}

			$raw_weight = floatval($this->input->post('package_weight'));
			$package_weight = max(0.01, round($raw_weight, 2));

			$save_data = [
				'tiktok_shop_id' => $this->input->post('tiktok_shop_id'),
				'title'          => $this->input->post('title'),
				'status'         => 'ACTIVATE',
				'category_name'  => $this->input->post('category_name'),
				'brand_name'     => $this->input->post('brand_name'),
				'seller_sku'     => $this->input->post('seller_sku') ?: $existing_product->seller_sku,
				'price'          => max(1000, intval($this->input->post('price'))),
				'total_stock'    => max(0, intval($this->input->post('total_stock'))),
				'package_weight' => (string)$package_weight,
				'description'    => $this->input->post('description'),
			];

			if (!is_dir(FCPATH . '/uploads/tiktok_products/')) {
				mkdir(FCPATH . '/uploads/tiktok_products/', 0777, true);
			}

			$new_image_uri = '';
			if (!empty($tiktok_products_main_image_name)) {
				$src_file = FCPATH . 'uploads/tmp/' . $tiktok_products_main_image_uuid . '/' . $tiktok_products_main_image_name;

				if (is_file($src_file)) {
					$tiktok_products_main_image_name_copy = date('YmdHis') . '-' . $tiktok_products_main_image_name;
					@rename($src_file, FCPATH . 'uploads/tiktok_products/' . $tiktok_products_main_image_name_copy);
					if (is_file(FCPATH . 'uploads/tiktok_products/' . $tiktok_products_main_image_name_copy)) {
						$save_data['main_image'] = $tiktok_products_main_image_name_copy;
					}
				} else {
					$existing_files = glob(FCPATH . 'uploads/tiktok_products/*' . $tiktok_products_main_image_name);
					if (!empty($existing_files)) {
						$save_data['main_image'] = basename(end($existing_files));
					}
				}
			}

			// Sinkronisasi update ke TikTok Shop jika produk terhubung
			if (!empty($existing_product->product_id)) {
				$this->load->library('tiktok_api');
				$shop_id = $save_data['tiktok_shop_id'];

				// Jika ada upload gambar baru, upload ke TikTok CDN
				if (!empty($save_data['main_image']) && $save_data['main_image'] !== $existing_product->main_image) {
					$image_path = FCPATH . 'uploads/tiktok_products/' . $save_data['main_image'];
					$upload_res = $this->tiktok_api->upload_image($image_path, $shop_id);
					if (!empty($upload_res['data']['uri'])) {
						$new_image_uri = $upload_res['data']['uri'];
					} else {
						$err_msg = $this->parse_tiktok_error($upload_res, 'Format/ukuran minimal 300x300 px.');
						echo json_encode([
							'success' => false,
							'message' => 'Gagal mengunggah gambar baru ke TikTok: ' . $err_msg
						]);
						exit;
					}
				}

				// Ambil SKU yang sudah ada untuk update harga & atribut
				$sku_row = $this->db->get_where('tiktok_product_skus', ['tiktok_product_id' => $id])->row();

				$category_id = '601756';
				if (is_numeric($this->input->post('category_name')) && !empty($this->input->post('category_name'))) {
					$category_id = (string)$this->input->post('category_name');
				}

				$product_attributes = [
					[
						'id' => '100107',
						'values' => [
							['id' => '1000057', 'name' => 'Tanpa Garansi']
						]
					],
					[
						'id' => '101734',
						'values' => [
							['id' => '1000059', 'name' => 'Tidak']
						]
					]
				];

				if ($category_id !== '601756') {
					$attr_res = $this->tiktok_api->request('/product/202309/categories/' . $category_id . '/attributes', 'GET', ['category_version' => 'v2'], null, $shop_id);
					if (!empty($attr_res['data']['attributes'])) {
						$custom_attrs = [];
						foreach ($attr_res['data']['attributes'] as $attr) {
							if (!empty($attr['is_requried']) && !empty($attr['values'])) {
								$first_val = $attr['values'][0];
								$custom_attrs[] = [
									'id' => (string)$attr['id'],
									'values' => [
										[
											'id' => (string)$first_val['id'],
											'name' => (string)$first_val['name']
										]
									]
								];
							}
						}
						if (!empty($custom_attrs)) {
							$product_attributes = $custom_attrs;
						}
					}
				}

				$brand_id = $this->input->post('brand_id');
				if (empty($brand_id) || $brand_id === 'No Brand' || !is_numeric($brand_id)) {
					$brand_id = '0';
				}

				$edit_payload = [
					'category_id' => $category_id,
					'brand_id' => (string)$brand_id,
					'title' => $save_data['title'],
					'description' => $save_data['description'],
					'package_weight' => [
						'value' => (string)$package_weight,
						'unit' => 'KILOGRAM'
					],
					'package_dimensions' => [
						'length' => '30',
						'width' => '20',
						'height' => '5',
						'unit' => 'CENTIMETER'
					],
					'product_attributes' => $product_attributes
				];

				if (!empty($new_image_uri)) {
					$edit_payload['main_images'] = [['uri' => $new_image_uri]];
				} else {
					// Jika tidak ada upload gambar baru, pertahankan gambar lama dari TikTok
					$image_uri_to_use = '';
					$prod_detail = $this->tiktok_api->get_product_detail($existing_product->product_id, [], $shop_id);
					if (!empty($prod_detail['data']['main_images'][0]['uri'])) {
						$image_uri_to_use = $prod_detail['data']['main_images'][0]['uri'];
					} elseif (!empty($existing_product->main_image) && is_file(FCPATH . 'uploads/tiktok_products/' . $existing_product->main_image)) {
						$upload_res = $this->tiktok_api->upload_image(FCPATH . 'uploads/tiktok_products/' . $existing_product->main_image, $shop_id);
						if (!empty($upload_res['data']['uri'])) {
							$image_uri_to_use = $upload_res['data']['uri'];
						}
					}

					if (!empty($image_uri_to_use)) {
						$edit_payload['main_images'] = [['uri' => $image_uri_to_use]];
					}
				}

				if ($sku_row && !empty($sku_row->sku_id)) {
					$edit_payload['skus'] = [
						[
							'id' => $sku_row->sku_id,
							'price' => [
								'amount' => (string)$save_data['price'],
								'currency' => 'IDR'
							],
							'seller_sku' => (string)$save_data['seller_sku']
						]
					];
				}

				$put_res = $this->tiktok_api->update_product($existing_product->product_id, $edit_payload, $shop_id);

				if ((isset($put_res['code']) && $put_res['code'] !== 0) || !empty($put_res['data']['errors'])) {
					$err_msg = $this->parse_tiktok_error($put_res, 'Gagal memperbarui produk di TikTok Shop');
					echo json_encode([
						'success' => false,
						'message' => 'Ketentuan TikTok belum terpenuhi saat update: ' . $err_msg
					]);
					exit;
				}

				// Update stok di TikTok Shop jika ada warehouse
				if ($sku_row && !empty($sku_row->sku_id) && !empty($sku_row->warehouse_id)) {
					$inv_res = $this->tiktok_api->update_inventory($existing_product->product_id, [
						[
							'id' => $sku_row->sku_id,
							'inventory' => [
								[
									'quantity' => $save_data['total_stock'],
									'warehouse_id' => (string)$sku_row->warehouse_id
								]
							]
						]
					], $shop_id);

					if ((isset($inv_res['code']) && $inv_res['code'] !== 0) || !empty($inv_res['data']['errors'])) {
						$err_msg = $this->parse_tiktok_error($inv_res, 'Gagal memperbarui stok di TikTok Shop');
						echo json_encode([
							'success' => false,
							'message' => 'Ketentuan TikTok belum terpenuhi pada stok: ' . $err_msg
						]);
						exit;
					}
				}

				// Pastikan status produk tetap aktif di TikTok
				@$this->tiktok_api->activate_products([$existing_product->product_id], $shop_id);

				// Update SKU lokal
				if ($sku_row) {
					$this->db->where('id', $sku_row->id)->update('tiktok_product_skus', [
						'seller_sku' => $save_data['seller_sku'],
						'sku_name'   => $save_data['title'],
						'price'      => $save_data['price'],
						'stock'      => $save_data['total_stock'],
						'updated_at' => date('Y-m-d H:i:s')
					]);
				}
			}

			$save_tiktok_products = $this->model_tiktok_products->change($id, $save_data);

			if ($save_tiktok_products) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/tiktok_products', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/tiktok_products');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/tiktok_products');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
	/**
	* delete Tiktok Productss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('tiktok_products_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$error_messages = [];
		$success_count = 0;

		$ids = [];
		if (!empty($id)) {
			$ids[] = $id;
		} elseif (is_array($arr_id) && count($arr_id) > 0) {
			$ids = $arr_id;
		}

		if (empty($ids)) {
			set_message('Pilih minimal satu data produk untuk dihapus.', 'warning');
			redirect_back();
			return;
		}

		foreach ($ids as $single_id) {
			$res = $this->_remove($single_id);
			if (!empty($res['success'])) {
				$success_count++;
			} else {
				$error_messages[] = $res['message'] ?? 'Gagal menghapus produk ID ' . $single_id;
			}
		}

		if ($success_count > 0 && empty($error_messages)) {
			set_message('Produk berhasil dihapus dari Vendio dan TikTok Shop.', 'success');
		} elseif ($success_count > 0 && !empty($error_messages)) {
			set_message($success_count . ' produk berhasil dihapus. Catatan: ' . implode('; ', $error_messages), 'warning');
		} else {
			$msg = !empty($error_messages) ? implode('; ', $error_messages) : 'Gagal menghapus produk.';
			set_message($msg, 'error');
		}

		redirect_back();
	}

		/**
	* View view Tiktok Productss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_products_view');

		$this->data['tiktok_products'] = $this->model_tiktok_products->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Produk TikTok Detail');
		$this->render('backend/standart/administrator/tiktok_products/tiktok_products_view', $this->data);
	}
	
	/**
	* Remove single Tiktok Product from TikTok Shop and database
	*
	* @var $id String
	* @return array
	*/
	private function _remove($id)
	{
		$tiktok_products = $this->model_tiktok_products->find($id);

		if (!$tiktok_products) {
			return [
				'success' => false,
				'message' => 'Data produk tidak ditemukan.'
			];
		}

		// Hapus dari TikTok Shop via API jika terhubung ke TikTok Shop
		if (!empty($tiktok_products->product_id)) {
			$this->load->library('tiktok_api');
			$shop_id = $tiktok_products->tiktok_shop_id;

			// 1. Nonaktifkan terlebih dahulu di TikTok
			@$this->tiktok_api->deactivate_products([(string)$tiktok_products->product_id], $shop_id);

			// 2. Hapus produk dari TikTok Shop
			$del_res = $this->tiktok_api->delete_products([(string)$tiktok_products->product_id], $shop_id);

			$is_error = false;
			$err_msg = '';

			if (isset($del_res['code']) && $del_res['code'] !== 0) {
				$is_error = true;
				$err_msg = $this->parse_tiktok_error($del_res, 'Gagal menghapus produk di TikTok Shop');
			} elseif (!empty($del_res['data']['errors'])) {
				$actual_errors = [];
				foreach ($del_res['data']['errors'] as $err) {
					$code = $err['code'] ?? 0;
					$msg  = $err['message'] ?? '';
					// 12052032 = "The product does not exist" (sudah terhapus di TikTok)
					if ($code != 12052032 && strpos(strtolower($msg), 'does not exist') === false) {
						$actual_errors[] = $msg;
					}
				}
				if (!empty($actual_errors)) {
					$is_error = true;
					$err_msg = implode(', ', $actual_errors);
				}
			}

			if ($is_error) {
				return [
					'success' => false,
					'message' => 'TikTok menolak penghapusan produk "' . $tiktok_products->title . '": ' . $err_msg
				];
			}

			// Hapus varian SKU terkait dari database
			$this->db->where('product_id', $tiktok_products->product_id)->delete('tiktok_product_skus');
		}

		$this->db->where('tiktok_product_id', $id)->delete('tiktok_product_skus');

		if (!empty($tiktok_products->main_image)) {
			$path = FCPATH . 'uploads/tiktok_products/' . $tiktok_products->main_image;
			if (is_file($path)) {
				@unlink($path);
			}
		}
		
		$deleted = $this->model_tiktok_products->remove($id);

		return [
			'success' => $deleted ? true : false,
			'message' => $deleted ? 'Berhasil dihapus' : 'Gagal menghapus dari database lokal.'
		];
	}
	
	/**
	* Upload Image Tiktok Products	* 
	* @return JSON
	*/
	public function upload_main_image_file()
	{
		if (!$this->is_allowed('tiktok_products_add', false) && !$this->is_allowed('tiktok_products_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		if (!is_dir(FCPATH . 'uploads/tmp/')) {
			mkdir(FCPATH . 'uploads/tmp/', 0777, true);
		}

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'tiktok_products',
		]);
	}

	/**
	* Delete Image Tiktok Products	* 
	* @return JSON
	*/
	public function delete_main_image_file($uuid = '')
	{
		if (empty($uuid)) {
			echo json_encode([
				'success' => true
			]);
			exit;
		}

		if (!$this->is_allowed('tiktok_products_delete', false) && !$this->is_allowed('tiktok_products_add', false) && !$this->is_allowed('tiktok_products_update', false)) {
			echo json_encode([
				'success' => false,
				'error' => cclang('sorry_you_do_not_have_permission_to_access')
				]);
			exit;
		}

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'main_image', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'tiktok_products',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/tiktok_products/'
        ]);
	}

	/**
	* Get Image Tiktok Products	* 
	* @return JSON
	*/
	public function get_main_image_file($id)
	{
		if (!$this->is_allowed('tiktok_products_update', false)) {
			echo json_encode([
				'success' => false,
				'message' => 'Image not loaded, you do not have permission to access'
				]);
			exit;
		}

		$tiktok_products = $this->model_tiktok_products->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'main_image', 
            'table_name'        => 'tiktok_products',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/tiktok_products/',
            'delete_endpoint'   => 'administrator/tiktok_products/delete_main_image_file'
        ]);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_products_export');

		$this->model_tiktok_products->export('tiktok_products', 'tiktok_products');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_products_export');

		$this->model_tiktok_products->pdf('tiktok_products', 'tiktok_products');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_products_export');

		$table = $title = 'tiktok_products';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_products->find($id);
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
	 * Sinkronisasi produk dari TikTok Shop ke database lokal Vendio
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_products_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung atau aktif. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_products');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$search_res = $this->tiktok_api->search_products(['page_size' => 100], [], $shop->id);

			if (!$search_res['success']) {
				$error_messages[] = $shop->shop_name . ': ' . ($search_res['message'] ?? 'Gagal mengambil produk');
				continue;
			}

			$products = $search_res['data']['products'] ?? [];

			foreach ($products as $p) {
				$product_id = $p['id'];
				$title = $p['title'] ?? '-';
				$status = $p['status'] ?? 'LIVE';

				// Jika produk di TikTok berstatus DELETED, hapus dari database lokal agar tidak muncul di daftar produk
				if (strtoupper($status) === 'DELETED') {
					$this->db->where('product_id', $product_id)->delete('tiktok_product_skus');
					$this->db->where('product_id', $product_id)->delete('tiktok_products');
					continue;
				}

				// Hitung total stok dan harga default dari skus
				$total_stock = 0;
				$price = 0;
				$seller_sku = null;

				if (!empty($p['skus'])) {
					foreach ($p['skus'] as $s) {
						if (!empty($s['inventory'])) {
							foreach ($s['inventory'] as $inv) {
								$total_stock += intval($inv['quantity'] ?? 0);
							}
						}
					}
					$first_sku = $p['skus'][0];
					$price = floatval($first_sku['price']['tax_exclusive_price'] ?? 0);
					$seller_sku = $first_sku['seller_sku'] ?? null;
				}

				// Ambil detail lengkap produk
				$detail_res = $this->tiktok_api->get_product_detail($product_id, [], $shop->id);
				$detail = $detail_res['data'] ?? [];

				if (strtoupper($detail['status'] ?? '') === 'DELETED') {
					$this->db->where('product_id', $product_id)->delete('tiktok_product_skus');
					$this->db->where('product_id', $product_id)->delete('tiktok_products');
					continue;
				}

				$main_image = null;
				if (!empty($detail['main_images'][0]['urls'][0])) {
					$main_image = $detail['main_images'][0]['urls'][0];
				}

				$category_name = null;
				if (!empty($detail['category_chains'])) {
					$cat_names = array_column($detail['category_chains'], 'local_name');
					$category_name = implode(' > ', $cat_names);
				}

				$brand_name = $detail['brand']['name'] ?? null;
				$description = $detail['description'] ?? null;
				$package_weight = isset($detail['package_weight']['value']) ? $detail['package_weight']['value'] . ' ' . ($detail['package_weight']['unit'] ?? 'kg') : null;

				$product_data = [
					'tiktok_shop_id' => $shop->id,
					'product_id'     => $product_id,
					'title'          => $title,
					'main_image'     => $main_image,
					'status'         => $status,
					'category_name'  => $category_name,
					'brand_name'     => $brand_name,
					'seller_sku'     => $seller_sku,
					'price'          => $price,
					'currency'       => 'IDR',
					'total_stock'    => $total_stock,
					'package_weight' => $package_weight,
					'description'    => $description,
					'raw_data'       => json_encode($detail, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
					'updated_at'     => date('Y-m-d H:i:s'),
				];

				// Cek apakah produk sudah ada di database
				$existing = $this->db->get_where('tiktok_products', ['product_id' => $product_id])->row();

				if ($existing) {
					$this->db->where('id', $existing->id)->update('tiktok_products', $product_data);
					$local_product_id = $existing->id;
				} else {
					$product_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_products', $product_data);
					$local_product_id = $this->db->insert_id();
				}

				// Sinkronkan Varian SKU ke tabel tiktok_product_skus
				if (!empty($detail['skus'])) {
					foreach ($detail['skus'] as $sku) {
						$sku_stock = 0;
						$warehouse_id = null;
						if (!empty($sku['inventory'])) {
							foreach ($sku['inventory'] as $inv) {
								$sku_stock += intval($inv['quantity'] ?? 0);
								$warehouse_id = $inv['warehouse_id'] ?? $warehouse_id;
							}
						}

						$sku_data = [
							'tiktok_product_id' => $local_product_id,
							'product_id'        => $product_id,
							'sku_id'            => $sku['id'],
							'seller_sku'        => $sku['seller_sku'] ?? null,
							'sku_name'          => !empty($sku['sales_attributes']) ? implode(', ', array_map(function($a) {
								$attr = !empty($a['name']) ? $a['name'] : ($a['attribute_name'] ?? '');
								$val = $a['value_name'] ?? '';
								return ($attr !== '' ? $attr . ': ' : '') . $val;
							}, $sku['sales_attributes'])) : null,
							'price'             => floatval($sku['price']['tax_exclusive_price'] ?? 0),
							'currency'          => $sku['price']['currency'] ?? 'IDR',
							'stock'             => $sku_stock,
							'warehouse_id'      => $warehouse_id,
							'updated_at'        => date('Y-m-d H:i:s'),
						];

						$existing_sku = $this->db->get_where('tiktok_product_skus', ['sku_id' => $sku['id']])->row();
						if ($existing_sku) {
							$this->db->where('id', $existing_sku->id)->update('tiktok_product_skus', $sku_data);
						} else {
							$sku_data['created_at'] = date('Y-m-d H:i:s');
							$this->db->insert('tiktok_product_skus', $sku_data);
						}
					}
				}

				$total_synced++;
			}
		}

		if (!empty($error_messages)) {
			set_message('Sinkronisasi selesai dengan peringatan: ' . implode('; ', $error_messages) . '. Total produk tersinkronisasi: ' . $total_synced, 'warning');
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' produk dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_products');
	}
}


/* End of file tiktok_products.php */
/* Location: ./application/controllers/administrator/Tiktok Products.php */