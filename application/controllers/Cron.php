<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Background Cron Job Controller untuk Sinkronisasi Otomatis TikTok Shop
 *
 * Penggunaan CLI:
 *   php index.php cron sync_all
 *   php index.php cron sync_orders
 *   php index.php cron sync_products
 *   php index.php cron sync_returns
 *   php index.php cron sync_finance
 *
 * Penggunaan Web/HTTP:
 *   http://localhost/vendio/cron/sync_all
 */
class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('tiktok_api');

        @ini_set('memory_limit', '512M');
        @set_time_limit(600); // 10 menit
    }

    /**
     * Logging output ke CLI atau Browser
     */
    protected function _log($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $output = "[{$timestamp}] {$message}";
        if (is_cli()) {
            echo $output . PHP_EOL;
        } else {
            echo nl2br(htmlspecialchars($output)) . "<br>" . PHP_EOL;
            if (ob_get_level() > 0) {
                ob_flush();
                flush();
            }
        }
    }

    /**
     * Jalankan penarikan seluruh data TikTok Shop (Pesanan, Retur, Keuangan, Produk)
     * Interval terjadwal: setiap 12 menit sekali
     */
    public function sync_all()
    {
        $this->_log("=================================================");
        $this->_log("CRON JOB: MULAI PENARIKAN DATA TIKTOK SHOP (12 MENIT)");
        $this->_log("=================================================");
        $start_time = microtime(true);

        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        if (empty($shops)) {
            $this->_log("[INFO] Belum ada Toko TikTok yang aktif atau terhubung.");
            return;
        }

        $this->_log("[INFO] Ditemukan " . count($shops) . " toko TikTok Shop aktif.");

        // 1. Tarik Pesanan
        $this->sync_orders();

        // 2. Tarik Retur & Refund
        $this->sync_returns();

        // 3. Tarik Keuangan / Settlement
        $this->sync_finance();

        // 4. Tarik Produk
        $this->sync_products();

        $elapsed = round(microtime(true) - $start_time, 2);
        $this->_log("=================================================");
        $this->_log("CRON JOB: SELESAI SELURUH PENARIKAN DATA ({$elapsed} detik)");
        $this->_log("=================================================\n");
    }

    /**
     * 1. Tarik Data Pesanan dari TikTok Shop
     */
    public function sync_orders()
    {
        $this->_log(">>> [1/4] Memulai penarikan data Pesanan TikTok...");
        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        $total_orders = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $search_res = $this->tiktok_api->search_orders([], ['page_size' => 50], $shop->id);

            if (!$search_res['success']) {
                $this->_log("       [ERROR] Gagal search_orders: " . ($search_res['message'] ?? 'Unknown error'));
                continue;
            }

            $orders = $search_res['data']['orders'] ?? [];
            $this->_log("       Ditemukan " . count($orders) . " pesanan terbaru.");

            foreach ($orders as $order) {
                $order_id = $order['id'];
                $detail_res = $this->tiktok_api->get_order_detail($order_id, [], $shop->id);
                $od = $detail_res['success'] ? ($detail_res['data'] ?? $order) : $order;

                $order_status = $od['status'] ?? ($order['status'] ?? 'UNPAID');
                $total_amount = $od['payment']['total_amount'] ?? ($order['payment']['total_amount'] ?? 0);
                $tracking_number = $od['tracking_number'] ?? ($order['tracking_number'] ?? '');
                $shipping_provider = $od['shipping_provider_name'] ?? ($order['shipping_provider_name'] ?? '');
                $shipping_type = $od['shipping_type'] ?? '';
                $delivery_option_name = $od['delivery_option_name'] ?? '';

                $recipient_address = $od['recipient_address'] ?? [];
                $recipient_name = $recipient_address['name'] ?? '';
                $recipient_phone = $recipient_address['phone_number'] ?? '';
                $full_address = $recipient_address['full_address'] ?? ($recipient_address['address_line1'] ?? '');

                $existing = $this->db->get_where('tiktok_orders', ['order_id' => $order_id])->row();

                $order_data = [
                    'tiktok_shop_id'       => $shop->id,
                    'order_id'             => $order_id,
                    'order_status'         => $order_status,
                    'total_amount'         => (float) $total_amount,
                    'shipping_provider'    => $shipping_provider,
                    'tracking_number'      => $tracking_number,
                    'shipping_type'        => $shipping_type,
                    'delivery_option_name' => $delivery_option_name,
                    'recipient_name'       => $recipient_name,
                    'recipient_phone'      => $recipient_phone,
                    'recipient_address'    => $full_address,
                ];

                if (!empty($od['create_time'])) {
                    $order_data['order_create_time'] = date('Y-m-d H:i:s', $od['create_time']);
                }
                if (!empty($od['paid_time'])) {
                    $order_data['paid_time'] = date('Y-m-d H:i:s', $od['paid_time']);
                }

                if ($existing) {
                    $this->db->where('id', $existing->id);
                    $this->db->update('tiktok_orders', $order_data);
                    $local_order_id = $existing->id;
                } else {
                    $this->db->insert('tiktok_orders', $order_data);
                    $local_order_id = $this->db->insert_id();
                }

                // Line Items
                $line_items = $od['line_items'] ?? ($order['line_items'] ?? []);
                if (!empty($line_items)) {
                    $this->db->where('tiktok_order_id', $local_order_id)->delete('tiktok_order_items');
                    foreach ($line_items as $item) {
                        $this->db->insert('tiktok_order_items', [
                            'tiktok_order_id' => $local_order_id,
                            'order_id'        => $order_id,
                            'product_id'      => $item['product_id'] ?? '',
                            'product_name'    => $item['product_name'] ?? '',
                            'sku_id'          => $item['sku_id'] ?? '',
                            'seller_sku'      => $item['seller_sku'] ?? '',
                            'sku_name'        => $item['sku_name'] ?? '',
                            'sku_image'       => $item['sku_image'] ?? '',
                            'quantity'        => (int) ($item['quantity'] ?? 1),
                            'item_price'      => (float) ($item['sale_price'] ?? 0),
                        ]);
                    }
                }

                $total_orders++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_orders} pesanan.");
    }

    /**
     * 2. Tarik Data Retur & Refund dari TikTok Shop
     */
    public function sync_returns()
    {
        $this->_log(">>> [2/4] Memulai penarikan data Retur & Refund TikTok...");
        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        $total_returns = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $res = $this->tiktok_api->search_returns([], ['page_size' => 50], $shop->id);

            if (!$res['success']) {
                $this->_log("       [ERROR] Gagal search_returns: " . ($res['message'] ?? 'Unknown error'));
                continue;
            }

            $returns = $res['data']['return_orders'] ?? [];
            $this->_log("       Ditemukan " . count($returns) . " pengajuan retur/refund.");

            foreach ($returns as $ro) {
                $return_id = $ro['return_id'] ?? null;
                if (!$return_id) continue;

                $order_id = $ro['order_id'] ?? '';
                $return_type = $ro['return_type'] ?? '';
                $return_status = $ro['return_status'] ?? '';
                $return_reason = $ro['return_reason'] ?? ($ro['return_reason_text'] ?? '');
                $refund_amount = $ro['refund_amount']['refund_total'] ?? ($ro['refund_amount']['refund_subtotal'] ?? 0);
                $tracking_number = $ro['tracking_number'] ?? '';
                $return_created_time = !empty($ro['create_time']) ? date('Y-m-d H:i:s', $ro['create_time']) : null;
                $items_json = !empty($ro['return_line_items']) ? json_encode($ro['return_line_items']) : null;

                $existing = $this->db->get_where('tiktok_returns', ['return_id' => $return_id])->row();

                $save_data = [
                    'tiktok_shop_id'      => $shop->id,
                    'return_id'           => $return_id,
                    'order_id'            => $order_id,
                    'items'               => $items_json,
                    'return_type'         => $return_type,
                    'return_status'       => $return_status,
                    'return_reason'       => $return_reason,
                    'refund_amount'       => (float) $refund_amount,
                    'tracking_number'     => $tracking_number,
                    'return_created_time' => $return_created_time,
                ];

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_returns', $save_data);
                } else {
                    $this->db->insert('tiktok_returns', $save_data);
                }

                $total_returns++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_returns} pengajuan retur.");
    }

    /**
     * 3. Tarik Data Keuangan / Settlement Statements dari TikTok Shop
     */
    public function sync_finance()
    {
        $this->_log(">>> [3/4] Memulai penarikan data Keuangan / Settlement Statements...");
        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        $total_finance = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $res = $this->tiktok_api->get_statements(['page_size' => 50], $shop->id);

            if (!$res['success']) {
                $this->_log("       [ERROR] Gagal get_statements: " . ($res['message'] ?? 'Unknown error'));
                continue;
            }

            $statements = $res['data']['statements'] ?? [];
            $this->_log("       Ditemukan " . count($statements) . " rekap settlement.");

            foreach ($statements as $st) {
                $statement_id = $st['statement_id'] ?? null;
                if (!$statement_id) continue;

                $statement_time = !empty($st['statement_time']) ? date('Y-m-d H:i:s', $st['statement_time']) : null;
                $settlement_amount = $st['settlement_amount'] ?? 0;
                $currency = $st['currency'] ?? 'IDR';
                $payment_status = $st['payment_status'] ?? 'PAID';
                $bank_account = $st['bank_account'] ?? '';

                $existing = $this->db->get_where('tiktok_finance', ['statement_id' => $statement_id])->row();

                $save_data = [
                    'tiktok_shop_id'    => $shop->id,
                    'statement_id'      => $statement_id,
                    'statement_time'    => $statement_time,
                    'settlement_amount' => (float) $settlement_amount,
                    'currency'          => $currency,
                    'payment_status'    => $payment_status,
                    'bank_account'      => $bank_account,
                ];

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_finance', $save_data);
                } else {
                    $this->db->insert('tiktok_finance', $save_data);
                }

                $total_finance++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_finance} data keuangan.");
    }

    /**
     * 4. Tarik Data Produk dari TikTok Shop
     */
    public function sync_products()
    {
        $this->_log(">>> [4/4] Memulai penarikan data Produk TikTok...");
        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        $total_products = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $search_res = $this->tiktok_api->search_products(['page_size' => 100], [], $shop->id);

            if (!$search_res['success']) {
                $this->_log("       [ERROR] Gagal search_products: " . ($search_res['message'] ?? 'Unknown error'));
                continue;
            }

            $products = $search_res['data']['products'] ?? [];
            $this->_log("       Ditemukan " . count($products) . " produk di etalase.");

            foreach ($products as $p) {
                $product_id = $p['id'];
                $title = $p['title'] ?? '-';
                $status = $p['status'] ?? 'LIVE';

                $main_image = '';
                if (!empty($p['main_images'][0]['url_list'][0])) {
                    $main_image = $p['main_images'][0]['url_list'][0];
                } elseif (!empty($p['main_images'][0])) {
                    $main_image = is_string($p['main_images'][0]) ? $p['main_images'][0] : ($p['main_images'][0]['url'] ?? '');
                }

                $category_name = $p['category_chains'][0]['local_name'] ?? ($p['category_name'] ?? '');
                $category_id   = $p['category_chains'][0]['id'] ?? ($p['category_id'] ?? null);

                $existing = $this->db->get_where('tiktok_products', ['product_id' => $product_id])->row();

                $save_data = [
                    'tiktok_shop_id' => $shop->id,
                    'product_id'     => $product_id,
                    'title'          => $title,
                    'main_image'     => $main_image,
                    'status'         => $status,
                    'category_name'  => $category_name,
                    'category_id'    => $category_id,
                ];

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_products', $save_data);
                    $local_product_id = $existing->id;
                } else {
                    $this->db->insert('tiktok_products', $save_data);
                    $local_product_id = $this->db->insert_id();
                }

                // Varian SKUs
                $skus = $p['skus'] ?? [];
                if (!empty($skus)) {
                    $this->db->where('tiktok_product_id', $local_product_id)->delete('tiktok_product_skus');
                    foreach ($skus as $s) {
                        $price = 0;
                        if (isset($s['price']['tax_exclusive_price'])) {
                            $price = $s['price']['tax_exclusive_price'];
                        } elseif (isset($s['price']['original_price'])) {
                            $price = $s['price']['original_price'];
                        }

                        $stock = 0;
                        if (!empty($s['stock_infos'])) {
                            foreach ($s['stock_infos'] as $stk) {
                                $stock += (int) ($stk['available_stock'] ?? 0);
                            }
                        } elseif (isset($s['inventory'][0]['quantity'])) {
                            $stock = (int) $s['inventory'][0]['quantity'];
                        }

                        $this->db->insert('tiktok_product_skus', [
                            'tiktok_product_id' => $local_product_id,
                            'product_id'        => $product_id,
                            'sku_id'            => $s['id'] ?? '',
                            'seller_sku'        => $s['seller_sku'] ?? '',
                            'sku_name'          => $s['sku_name'] ?? ($s['sales_attributes'][0]['value_name'] ?? 'Default'),
                            'price'             => (float) $price,
                            'stock'             => $stock,
                        ]);
                    }
                }

                $total_products++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_products} produk.");
    }
}
