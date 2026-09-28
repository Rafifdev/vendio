<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Tiktok Orders Controller
*| --------------------------------------------------------------------------
*| Tiktok Orders site
*|
*/
class Tiktok_orders extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_tiktok_orders');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Tiktok Orderss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		$this->is_allowed('tiktok_orders_list');

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$shop_id = $this->input->get('shop_id');

		$orders = $this->model_tiktok_orders->get($filter, $field, $this->limit_page, $offset, [], $shop_id);
		foreach ($orders as $order) {
			$order->items = $this->db->get_where('tiktok_order_items', ['tiktok_order_id' => $order->id])->result();
		}
		$this->data['tiktok_orderss'] = $orders;
		$this->data['tiktok_orders_counts'] = $this->model_tiktok_orders->count_all($filter, $field, $shop_id);

		$this->data['shops'] = $this->db->order_by('shop_name', 'ASC')->get('tiktok_shops')->result();
		$this->data['selected_shop_id'] = $shop_id;

		$config = [
			'base_url'     => 'administrator/tiktok_orders/index/',
			'total_rows'   => $this->model_tiktok_orders->count_all($filter, $field, $shop_id),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Pesanan Penjualan List');
		$this->render('backend/standart/administrator/tiktok_orders/tiktok_orders_list', $this->data);
	}
	
	/**
	* Add new tiktok_orderss (Disabled - Auto-synced from TikTok Shop)
	*/
	public function add()
	{
		set_message('Pesanan TikTok disinkronkan otomatis dari TikTok Shop dan tidak dapat ditambah secara manual.', 'warning');
		redirect('administrator/tiktok_orders');
	}

	/**
	* Edit tiktok_orderss (Disabled - Auto-synced from TikTok Shop)
	*/
	public function edit($id = null)
	{
		set_message('Pesanan TikTok disinkronkan otomatis dari TikTok Shop dan tidak dapat diedit secara manual.', 'warning');
		if ($id) {
			redirect('administrator/tiktok_orders/view/' . $id);
		} else {
			redirect('administrator/tiktok_orders');
		}
	}
	
	/**
	* Batalkan Pesanan (Cancel Order di TikTok Shop dan Vendio)
	*
	* @var $id String|int
	*/
	public function cancel($id = null)
	{
		$this->is_allowed('tiktok_orders_delete');
		$this->load->library('tiktok_api');

		$arr_id = $this->input->get('id');
		if (empty($id) && !empty($arr_id)) {
			$ids = is_array($arr_id) ? $arr_id : explode(',', $arr_id);
		} elseif (!empty($id)) {
			$ids = [$id];
		} else {
			set_message('Pilih pesanan yang ingin dibatalkan.', 'warning');
			redirect_back();
			return;
		}

		$success_count = 0;
		$error_messages = [];

		foreach ($ids as $order_id_local) {
			$order = $this->model_tiktok_orders->find($order_id_local);
			if (!$order) {
				continue;
			}

			if ($order->order_status == 'CANCELLED') {
				$success_count++;
				continue;
			}

			// Panggil API Pembatalan Pesanan ke TikTok Shop
			$cancel_res = $this->tiktok_api->cancel_order($order->order_id, 'seller_cancel_reason_out_of_stock', $order->tiktok_shop_id);

			if ($cancel_res['success'] || (isset($cancel_res['code']) && $cancel_res['code'] === 0)) {
				$this->db->where('id', $order->id)->update('tiktok_orders', [
					'order_status'  => 'CANCELLED',
					'cancel_reason' => 'seller_cancel_reason_out_of_stock',
					'updated_at'    => date('Y-m-d H:i:s')
				]);
				$this->db->insert('tiktok_order_status_logs', [
					'tiktok_order_id' => $order->id,
					'order_id'        => $order->order_id,
					'previous_status' => $order->order_status,
					'new_status'      => 'CANCELLED',
					'reason'          => 'Dibatalkan oleh penjual: Stok Habis (Out of stock)',
					'source'          => 'SELLER_MANUAL',
					'created_at'      => date('Y-m-d H:i:s'),
				]);
				$success_count++;
			} else {
				$err_msg = $cancel_res['message'] ?? 'Gagal membatalkan di TikTok Shop.';
				// Jika status di TikTok sudah batal sebelumnya
				if (stripos($err_msg, 'cancel') !== false || stripos($err_msg, 'reverse') !== false) {
					$this->db->where('id', $order->id)->update('tiktok_orders', [
						'order_status'  => 'CANCELLED',
						'updated_at'    => date('Y-m-d H:i:s')
					]);
					$success_count++;
				} else {
					$error_messages[] = 'Pesanan #' . $order->order_id . ': ' . $err_msg;
				}
			}
		}

		if (!empty($error_messages)) {
			set_message('Pembatalan selesai dengan catatan: ' . implode('; ', $error_messages), 'error');
		} else {
			set_message('Berhasil membatalkan ' . $success_count . ' pesanan di TikTok Shop dan Vendio.', 'success');
		}

		redirect_back();
	}

	/**
	* delete Tiktok Orderss (Dialihkan ke cancel agar sinkron dua arah)
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		return $this->cancel($id);
	}

		/**
	* View view Tiktok Orderss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('tiktok_orders_view');

		$this->data['tiktok_orders'] = $this->model_tiktok_orders->join_avaiable()->filter_avaiable()->find($id);

		if (!$this->data['tiktok_orders']) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$this->data['order_items'] = $this->db->get_where('tiktok_order_items', ['tiktok_order_id' => $id])->result();
		$this->data['price_details'] = $this->db->get_where('tiktok_order_price_details', ['tiktok_order_id' => $id])->row();
		$this->data['status_logs'] = $this->db->order_by('id', 'DESC')->get_where('tiktok_order_status_logs', ['tiktok_order_id' => $id])->result();

		$this->template->title('Pesanan Penjualan Detail');
		$this->render('backend/standart/administrator/tiktok_orders/tiktok_orders_view', $this->data);
	}
	
	/**
	* delete Tiktok Orderss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$tiktok_orders = $this->model_tiktok_orders->find($id);

		
		
		return $this->model_tiktok_orders->remove($id);
	}
	
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('tiktok_orders_export');

		$this->model_tiktok_orders->export('tiktok_orders', 'tiktok_orders');
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('tiktok_orders_export');

		$this->model_tiktok_orders->pdf('tiktok_orders', 'tiktok_orders');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('tiktok_orders_export');

		$table = $title = 'tiktok_orders';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_tiktok_orders->find($id);
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
	 * Sinkronisasi daftar pesanan dari TikTok Shop ke database lokal Vendio
	 */
	public function sync()
	{
		$this->is_allowed('tiktok_orders_list');
		$this->load->library('tiktok_api');

		$shop_id = $this->input->get('shop_id');
		if (!empty($shop_id)) {
			$shops = $this->db->get_where('tiktok_shops', ['id' => $shop_id, 'is_active' => 1])->result();
		} else {
			$shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
		}

		if (empty($shops)) {
			set_message('Belum ada Toko TikTok yang terhubung atau aktif. Silakan hubungkan toko terlebih dahulu di menu Kelola Toko.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$total_synced = 0;
		$error_messages = [];

		foreach ($shops as $shop) {
			$search_res = $this->tiktok_api->search_orders([], ['page_size' => 50], $shop->id);

			if (!$search_res['success']) {
				$error_messages[] = $shop->shop_name . ': ' . ($search_res['message'] ?? 'Gagal mengambil pesanan');
				continue;
			}

			$orders = $search_res['data']['orders'] ?? [];

			foreach ($orders as $order) {
				$order_id = $order['id'] ?? '';
				if (empty($order_id)) {
					continue;
				}

				// Ambil detail lengkap pesanan dari API TikTok
				$detail = $order;
				$detail_res = $this->tiktok_api->get_order_detail($order_id, [], $shop->id);
				if (!empty($detail_res['data']['orders'][0])) {
					$detail = array_merge($order, $detail_res['data']['orders'][0]);
				} elseif (!empty($detail_res['data']['id'])) {
					$detail = array_merge($order, $detail_res['data']);
				}

				$status = $detail['status'] ?? 'UNPAID';
				$recipient = $detail['recipient_address'] ?? [];
				$payment = $detail['payment'] ?? [];

				// Susun alamat pengiriman lengkap
				$full_address = $recipient['full_address'] ?? '';
				if (!empty($recipient['district_info']) && is_array($recipient['district_info'])) {
					$dist_names = array_column($recipient['district_info'], 'address_name');
					if (!empty($dist_names)) {
						$full_address .= ', ' . implode(', ', $dist_names);
					}
				}
				if (!empty($recipient['postal_code'])) {
					$full_address .= ' ' . $recipient['postal_code'];
				}

				// Package ID untuk shipping label / AWB
				$package_id = null;
				if (!empty($detail['packages']) && is_array($detail['packages'])) {
					$package_id = $detail['packages'][0]['id'] ?? null;
				}

				// Kurir dan No Resi
				$shipping_provider = $detail['shipping_provider'] ?? ($detail['shipping_provider_name'] ?? null);
				$tracking_number = $detail['tracking_number'] ?? ($detail['line_items'][0]['tracking_number'] ?? null);

				// Parsing waktu pesanan dibuat & dibayar
				$order_created_time = null;
				if (!empty($detail['create_time'])) {
					$ts = intval($detail['create_time']);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$order_created_time = date('Y-m-d H:i:s', $ts);
				}

				$order_paid_time = null;
				if (!empty($detail['paid_time'])) {
					$ts = intval($detail['paid_time']);
					if ($ts > 100000000000) {
						$ts = round($ts / 1000);
					}
					$order_paid_time = date('Y-m-d H:i:s', $ts);
				}

				$order_data = [
					'tiktok_shop_id'      => $shop->id,
					'order_id'            => $order_id,
					'order_status'        => $status,
					'payment_method_name' => $detail['payment_method_name'] ?? ($detail['payment_info']['payment_method_name'] ?? null),
					'buyer_message'       => $detail['buyer_message'] ?? null,
					'cancel_reason'       => $detail['cancel_reason'] ?? null,
					'recipient_name'      => $recipient['name'] ?? null,
					'recipient_phone'     => $recipient['phone_number'] ?? null,
					'recipient_address'   => trim($full_address, ', '),
					'shipping_provider'   => $shipping_provider,
					'shipping_type'       => $detail['shipping_type'] ?? null,
					'delivery_option_name'=> $detail['delivery_option_name'] ?? null,
					'tracking_number'     => $tracking_number,
					'package_id'          => $package_id,
					'total_amount'        => floatval($payment['total_amount'] ?? 0),
					'shipping_fee'        => floatval($payment['shipping_fee'] ?? 0),
					'seller_discount'     => floatval($payment['seller_discount'] ?? 0),
					'tiktok_discount'     => floatval($payment['platform_discount'] ?? 0),
					'order_created_time'  => $order_created_time,
					'order_paid_time'     => $order_paid_time,
					'updated_at'          => date('Y-m-d H:i:s'),
				];

				// Cek apakah data order sudah ada di database lokal
				$existing = $this->db->get_where('tiktok_orders', ['order_id' => $order_id])->row();
				$prev_status = $existing ? $existing->order_status : null;

				if ($existing) {
					$this->db->where('id', $existing->id)->update('tiktok_orders', $order_data);
					$local_order_id = $existing->id;

					if ($prev_status !== $status) {
						$this->db->insert('tiktok_order_status_logs', [
							'tiktok_order_id' => $local_order_id,
							'order_id'        => $order_id,
							'previous_status' => $prev_status,
							'new_status'      => $status,
							'reason'          => 'Perubahan status terdeteksi via sinkronisasi TikTok Shop',
							'source'          => 'API_SYNC',
							'created_at'      => date('Y-m-d H:i:s'),
						]);
					}
				} else {
					$order_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_orders', $order_data);
					$local_order_id = $this->db->insert_id();

					$this->db->insert('tiktok_order_status_logs', [
						'tiktok_order_id' => $local_order_id,
						'order_id'        => $order_id,
						'previous_status' => null,
						'new_status'      => $status,
						'reason'          => 'Pesanan baru ditarik dari TikTok Shop',
						'source'          => 'API_SYNC',
						'created_at'      => date('Y-m-d H:i:s'),
					]);
				}

				// Simpan Rincian Finansial Lengkap (Price Details Breakdown)
				$currency = $payment['currency'] ?? 'IDR';
				$orig_product_price = floatval($payment['original_total_product_price'] ?? 0);
				$seller_discount = floatval($payment['seller_discount'] ?? 0);
				$platform_discount = floatval($payment['platform_discount'] ?? 0);
				$subtotal = floatval($payment['sub_total'] ?? ($orig_product_price - $seller_discount - $platform_discount));
				$orig_shipping_fee = floatval($payment['original_shipping_fee'] ?? 0);
				$shipping_seller_disc = floatval($payment['shipping_fee_seller_discount'] ?? 0);
				$shipping_platform_disc = floatval($payment['shipping_fee_platform_discount'] ?? 0);
				$buyer_shipping_fee = floatval($payment['shipping_fee'] ?? 0);
				$tax = floatval($payment['tax'] ?? 0);
				$total_buyer_payment = floatval($payment['total_amount'] ?? 0);
				$seller_revenue = max(0, $orig_product_price - $seller_discount);

				$price_data = [
					'tiktok_order_id'               => $local_order_id,
					'order_id'                      => $order_id,
					'currency'                      => $currency,
					'original_product_price'        => $orig_product_price,
					'seller_discount'               => $seller_discount,
					'platform_discount'             => $platform_discount,
					'subtotal'                      => $subtotal,
					'original_shipping_fee'         => $orig_shipping_fee,
					'shipping_fee_seller_discount'  => $shipping_seller_disc,
					'shipping_fee_platform_discount'=> $shipping_platform_disc,
					'buyer_shipping_fee'            => $buyer_shipping_fee,
					'tax'                           => $tax,
					'total_buyer_payment'           => $total_buyer_payment,
					'seller_revenue'                => $seller_revenue,
					'updated_at'                    => date('Y-m-d H:i:s'),
				];

				$existing_price = $this->db->get_where('tiktok_order_price_details', ['tiktok_order_id' => $local_order_id])->row();
				if ($existing_price) {
					$this->db->where('id', $existing_price->id)->update('tiktok_order_price_details', $price_data);
				} else {
					$price_data['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('tiktok_order_price_details', $price_data);
				}

				// Sinkronkan Line Items ke tabel tiktok_order_items
				$line_items = $detail['line_items'] ?? [];
				if (!empty($line_items)) {
					foreach ($line_items as $item) {
						$line_id = $item['id'] ?? null;
						$sku_id = $item['sku_id'] ?? null;

						$item_data = [
							'tiktok_order_id' => $local_order_id,
							'order_id'        => $order_id,
							'order_line_id'   => $line_id,
							'product_id'      => $item['product_id'] ?? null,
							'product_name'    => $item['product_name'] ?? null,
							'sku_id'          => $sku_id,
							'sku_name'        => $item['sku_name'] ?? null,
							'seller_sku'      => $item['seller_sku'] ?? null,
							'quantity'        => intval($item['quantity'] ?? 1),
							'item_price'      => floatval($item['sale_price'] ?? ($item['sku_price'] ?? 0)),
							'sku_image'       => $item['sku_image'] ?? null,
						];

						// Cek keberadaan item
						$where_item = ['tiktok_order_id' => $local_order_id];
						if (!empty($line_id)) {
							$where_item['order_line_id'] = $line_id;
						} elseif (!empty($sku_id)) {
							$where_item['sku_id'] = $sku_id;
						}

						$existing_item = $this->db->get_where('tiktok_order_items', $where_item)->row();
						if ($existing_item) {
							$this->db->where('id', $existing_item->id)->update('tiktok_order_items', $item_data);
						} else {
							$item_data['created_at'] = date('Y-m-d H:i:s');
							$this->db->insert('tiktok_order_items', $item_data);
						}
					}
				}

				$total_synced++;
			}
		}

		if (!empty($error_messages)) {
			set_message('Sinkronisasi selesai dengan catatan: ' . implode('; ', $error_messages) . '. Total pesanan tersinkron: ' . $total_synced, 'warning');
		} else {
			set_message('Berhasil menyinkronkan ' . $total_synced . ' pesanan dari TikTok Shop!', 'success');
		}

		redirect('administrator/tiktok_orders');
	}

	/**
	 * Konfirmasi Pengiriman Pesanan (Ship Package / Arrange Shipment Handover)
	 *
	 * @param int $id ID lokal tabel tiktok_orders
	 */
	public function ship($id)
	{
		$this->is_allowed('tiktok_orders_view');
		$this->load->library('tiktok_api');

		$order = $this->model_tiktok_orders->find($id);
		if (!$order) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$package_id = $order->package_id;
		if (empty($package_id)) {
			// Coba ambil dari search API
			$search_res = $this->tiktok_api->search_orders(['order_ids' => [$order->order_id]], ['page_size' => 1], $order->tiktok_shop_id);
			$package_id = $search_res['data']['orders'][0]['packages'][0]['id'] ?? null;
			if ($package_id) {
				$this->db->where('id', $order->id)->update('tiktok_orders', ['package_id' => $package_id]);
			}
		}

		if (empty($package_id)) {
			set_message('Pesanan #' . $order->order_id . ' belum memiliki ID Paket dari TikTok untuk proses pengiriman.', 'warning');
			redirect('administrator/tiktok_orders');
			return;
		}

		// Kirim konfirmasi pengiriman (Drop-off ke counter gerai)
		$ship_res = $this->tiktok_api->ship_package($package_id, ['handover_method' => 'DROP_OFF'], $order->tiktok_shop_id);

		if ($ship_res['success'] || (isset($ship_res['code']) && $ship_res['code'] === 0)) {
			// Ambil nomor resi / dokumen pengiriman terbaru
			$doc_res = $this->tiktok_api->get_shipping_documents($package_id, 'SHIPPING_LABEL', ['document_size' => 'A6'], $order->tiktok_shop_id);
			$tracking = $doc_res['data']['tracking_number'] ?? null;

			$update_data = [
				'order_status' => 'AWAITING_COLLECTION',
				'updated_at'   => date('Y-m-d H:i:s'),
			];
			if (!empty($tracking)) {
				$update_data['tracking_number'] = $tracking;
			}
			$this->db->where('id', $order->id)->update('tiktok_orders', $update_data);

			set_message('Pengiriman pesanan #' . $order->order_id . ' berhasil diatur (Drop-off)! Status kini AWAITING_COLLECTION dan label resi siap dicetak.', 'success');
		} else {
			$err = $ship_res['message'] ?? 'Gagal mengatur pengiriman ke TikTok.';
			set_message('Gagal memproses pengiriman TikTok: ' . $err, 'error');
		}

		redirect('administrator/tiktok_orders');
	}

	/**
	 * Cetak Label Resi Pengiriman (AWB Shipping Label) PDF dari TikTok Shop
	 *
	 * @param int $id ID lokal tabel tiktok_orders
	 */
	public function print_label($id)
	{
		$this->is_allowed('tiktok_orders_view');
		$this->load->library('tiktok_api');

		$order = $this->model_tiktok_orders->find($id);
		if (!$order) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$package_id = $order->package_id;

		// Jika package_id belum ada di database, coba fetch ulang dari TikTok API
		if (empty($package_id)) {
			$search_res = $this->tiktok_api->search_orders(['order_ids' => [$order->order_id]], ['page_size' => 1], $order->tiktok_shop_id);
			$package_id = $search_res['data']['orders'][0]['packages'][0]['id'] ?? null;
			if ($package_id) {
				$this->db->where('id', $order->id)->update('tiktok_orders', ['package_id' => $package_id]);
			}
		}

		if (empty($package_id)) {
			set_message('Pesanan #' . $order->order_id . ' belum memiliki ID Paket (Package ID) untuk cetak resi. Pastikan pesanan sudah diproses dan siap kirim di TikTok Shop.', 'warning');
			redirect('administrator/tiktok_orders');
			return;
		}

		// Request URL Dokumen Label Pengiriman A6 ke TikTok API
		$doc_res = $this->tiktok_api->get_shipping_documents($package_id, 'SHIPPING_LABEL', ['document_size' => 'A6'], $order->tiktok_shop_id);

		if (!empty($doc_res['data']['doc_url'])) {
			if (!empty($doc_res['data']['tracking_number']) && empty($order->tracking_number)) {
				$this->db->where('id', $order->id)->update('tiktok_orders', ['tracking_number' => $doc_res['data']['tracking_number']]);
			}
			redirect($doc_res['data']['doc_url']);
			return;
		}

		$err_msg = $doc_res['message'] ?? 'Tidak dapat mengambil dokumen label pengiriman dari TikTok.';
		set_message('Gagal cetak label resi TikTok: ' . $err_msg, 'error');
		redirect('administrator/tiktok_orders');
	}

	/**
	 * Cetak Daftar Pengemasan (Packing List / Slip) PDF dari TikTok Shop
	 *
	 * @param int $id ID lokal tabel tiktok_orders
	 */
	public function print_packing_slip($id)
	{
		$this->is_allowed('tiktok_orders_view');
		$this->load->library('tiktok_api');

		$order = $this->model_tiktok_orders->find($id);
		if (!$order) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$package_id = $order->package_id;
		if (empty($package_id)) {
			$search_res = $this->tiktok_api->search_orders(['order_ids' => [$order->order_id]], ['page_size' => 1], $order->tiktok_shop_id);
			$package_id = $search_res['data']['orders'][0]['packages'][0]['id'] ?? null;
			if ($package_id) {
				$this->db->where('id', $order->id)->update('tiktok_orders', ['package_id' => $package_id]);
			}
		}

		if (empty($package_id)) {
			set_message('Pesanan #' . $order->order_id . ' belum memiliki ID Paket dari TikTok untuk cetak daftar pengemasan.', 'warning');
			redirect('administrator/tiktok_orders');
			return;
		}

		// Request Dokumen PACKING_SLIP A6 dari TikTok API
		$doc_res = $this->tiktok_api->get_shipping_documents($package_id, 'PACKING_SLIP', ['document_size' => 'A6'], $order->tiktok_shop_id);

		if (!empty($doc_res['data']['doc_url'])) {
			redirect($doc_res['data']['doc_url']);
			return;
		}

		$err_msg = $doc_res['message'] ?? 'Tidak dapat mengambil daftar pengemasan dari TikTok.';
		set_message('Gagal cetak daftar pengemasan: ' . $err_msg, 'error');
		redirect('administrator/tiktok_orders');
	}

	/**
	 * Cetak Label Pengiriman & Daftar Pengemasan Sekaligus (Combined PDF)
	 *
	 * @param int $id ID lokal tabel tiktok_orders
	 */
	public function print_combined($id)
	{
		$this->is_allowed('tiktok_orders_view');
		$this->load->library('tiktok_api');

		$order = $this->model_tiktok_orders->find($id);
		if (!$order) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$package_id = $order->package_id;
		if (empty($package_id)) {
			$search_res = $this->tiktok_api->search_orders(['order_ids' => [$order->order_id]], ['page_size' => 1], $order->tiktok_shop_id);
			$package_id = $search_res['data']['orders'][0]['packages'][0]['id'] ?? null;
			if ($package_id) {
				$this->db->where('id', $order->id)->update('tiktok_orders', ['package_id' => $package_id]);
			}
		}

		if (empty($package_id)) {
			set_message('Pesanan #' . $order->order_id . ' belum memiliki ID Paket dari TikTok.', 'warning');
			redirect('administrator/tiktok_orders');
			return;
		}

		// Request Dokumen Gabungan SHIPPING_LABEL_AND_PACKING_SLIP
		$doc_res = $this->tiktok_api->get_shipping_documents($package_id, 'SHIPPING_LABEL_AND_PACKING_SLIP', ['document_size' => 'A6'], $order->tiktok_shop_id);

		if (!empty($doc_res['data']['doc_url'])) {
			redirect($doc_res['data']['doc_url']);
			return;
		}

		$err_msg = $doc_res['message'] ?? 'Tidak dapat mengambil dokumen dari TikTok.';
		set_message('Gagal cetak dokumen TikTok: ' . $err_msg, 'error');
		redirect('administrator/tiktok_orders');
	}

	/**
	 * Cetak Daftar Pengambilan Barang (Pick List) untuk 1 pesanan
	 *
	 * @param int $id ID lokal tabel tiktok_orders
	 */
	public function print_pick_list($id)
	{
		$this->is_allowed('tiktok_orders_view');

		$order = $this->model_tiktok_orders->find($id);
		if (!$order) {
			set_message('Data pesanan tidak ditemukan.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		$order->items = $this->db->get_where('tiktok_order_items', ['tiktok_order_id' => $order->id])->result();

		$shop = $this->db->get_where('tiktok_shops', ['id' => $order->tiktok_shop_id])->row();

		$data = [
			'page_title' => 'Pick List Pesanan #' . $order->order_id,
			'is_bulk'    => false,
			'orders'     => [$order],
			'shop_name'  => $shop ? $shop->shop_name : 'TikTok Shop'
		];

		$this->load->view('backend/standart/administrator/tiktok_orders/tiktok_orders_pick_list', $data);
	}

	/**
	 * Cetak Daftar Pengambilan Barang Massal (Batch Picking List)
	 */
	public function print_bulk_pick_list()
	{
		$this->is_allowed('tiktok_orders_view');

		$ids = $this->input->get('ids');
		if (empty($ids)) {
			$ids = $this->input->post('check');
		}

		if (is_string($ids)) {
			$ids = explode(',', $ids);
		}

		if (empty($ids) || !is_array($ids)) {
			set_message('Silakan pilih minimal 1 pesanan untuk cetak daftar pengambilan barang.', 'warning');
			redirect('administrator/tiktok_orders');
			return;
		}

		$orders = $this->db->where_in('id', $ids)->get('tiktok_orders')->result();
		if (empty($orders)) {
			set_message('Tidak ada data pesanan yang valid.', 'error');
			redirect('administrator/tiktok_orders');
			return;
		}

		// Ambil semua item dan lakukan agregasi (grouping berdasarkan SKU/Nama Produk)
		$aggregated = [];
		foreach ($orders as $order) {
			$items = $this->db->get_where('tiktok_order_items', ['tiktok_order_id' => $order->id])->result();
			foreach ($items as $item) {
				$key = !empty($item->seller_sku) ? $item->seller_sku : ($item->product_id . '_' . $item->sku_id);
				if (!isset($aggregated[$key])) {
					$aggregated[$key] = [
						'product_name'   => $item->product_name,
						'sku_name'       => $item->sku_name,
						'seller_sku'     => $item->seller_sku,
						'sku_image'      => $item->sku_image,
						'total_quantity' => 0
					];
				}
				$aggregated[$key]['total_quantity'] += intval($item->quantity);
			}
		}

		$data = [
			'page_title'       => 'Daftar Pengambilan Barang Massal (' . count($orders) . ' Pesanan)',
			'is_bulk'          => true,
			'orders'           => $orders,
			'aggregated_items' => array_values($aggregated)
		];

		$this->load->view('backend/standart/administrator/tiktok_orders/tiktok_orders_pick_list', $data);
	}
}


/* End of file tiktok_orders.php */
/* Location: ./application/controllers/administrator/Tiktok Orders.php */