<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Background Cron Job Controller untuk Sinkronisasi Otomatis TikTok Shop
 *
 * Penggunaan CLI:
 *   php index.php cron pull_orders
 *   php index.php cron pull_packages
 *   php index.php cron pull_returns_cancellations
 *   php index.php cron refresh_token
 *   php index.php cron pull_statements
 *   php index.php cron sync_products
 *   php index.php cron sync_all
 *
 * Penggunaan via Runner cron.php:
 *   php cron.php pull_orders
 *   php cron.php sync_all
 *
 * Penggunaan Web/HTTP:
 *   http://localhost/vendio/cron/sync_all
 */
class Cron extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler(FALSE);
        $this->load->database();
        $this->load->library('tiktok_api');

        @ini_set('memory_limit', '512M');
        @set_time_limit(600); // 10 menit
    }

    /**
     * Logging output ke CLI/Browser dan simpan ke file log harian
     */
    protected function _log($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $formatted = "[{$timestamp}] {$message}";

        // Tampilkan ke output
        if (is_cli()) {
            echo $formatted . PHP_EOL;
        } else {
            echo nl2br(htmlspecialchars($formatted)) . "<br>" . PHP_EOL;
            if (ob_get_level() > 0) {
                ob_flush();
                flush();
            }
        }

        // Tulis ke file log harian: application/logs/cron_YYYY-MM-DD.log
        $log_file = APPPATH . 'logs/cron_' . date('Y-m-d') . '.log';
        @file_put_contents($log_file, $formatted . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    /**
     * Ambil daftar toko aktif dari database
     */
    protected function _get_active_shops()
    {
        $shops = $this->db->get_where('tiktok_shops', ['is_active' => 1])->result();
        if (empty($shops)) {
            $shops = $this->db->get('tiktok_shops')->result();
        }
        return $shops;
    }

    /**
     * Master Job: Jalankan seluruh proses sinkronisasi secara terpadu
     */
    public function sync_all()
    {
        $this->_log("=================================================");
        $this->_log("CRON JOB MASTER: MULAI SINKRONISASI LENGKAP TIKTOK SHOP");
        $this->_log("=================================================");
        $start_time = microtime(true);

        $shops = $this->_get_active_shops();
        if (empty($shops)) {
            $this->_log("[INFO] Belum ada Toko TikTok yang terhubung atau aktif.");
            return;
        }

        $this->_log("[INFO] Ditemukan " . count($shops) . " toko TikTok Shop terdaftar.");

        // 1. Refresh Access Token (jika mendekati kadaluarsa)
        $this->refresh_token();

        // 2. Tarik Pesanan Terbaru
        $this->pull_orders();


        // 4. Tarik Pengajuan Retur & Pembatalan Pesanan (SLA 48 Jam)
        $this->pull_returns_cancellations();

        // 5. Tarik Keuangan, Penarikan Dana & Transaksi Belum Settle
        $this->pull_statements();

        // 6. Tarik Katalog Produk & SKUs
        $this->sync_products();

        $elapsed = round(microtime(true) - $start_time, 2);
        $this->_log("=================================================");
        $this->_log("CRON JOB MASTER: SELESAI SELURUH SINKRONISASI ({$elapsed} detik)");
        $this->_log("=================================================\n");
    }

    /**
     * Job 1: Tarik Pesanan Baru & Detail Item (Interval 2-5 Menit)
     */
    public function pull_orders()
    {
        $this->_log(">>> [JOB: PESANAN] Memulai sinkronisasi data Pesanan...");
        $shops = $this->_get_active_shops();
        $total_orders = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $search_res = $this->tiktok_api->search_orders([], ['page_size' => 50], $shop->id);

            if (!$search_res['success'] && (!isset($search_res['code']) || $search_res['code'] !== 0)) {
                $this->_log("       [ERROR] Gagal search_orders: " . ($search_res['message'] ?? 'Unknown error'));
                continue;
            }

            $orders = $search_res['data']['orders'] ?? [];
            $this->_log("       Ditemukan " . count($orders) . " pesanan terbaru.");

            foreach ($orders as $order) {
                $order_id = $order['id'] ?? null;
                if (empty($order_id)) continue;

                $detail_res = $this->tiktok_api->get_order_detail($order_id, [], $shop->id);
                if (!empty($detail_res['data']['orders'][0])) {
                    $od = array_merge($order, $detail_res['data']['orders'][0]);
                } elseif (!empty($detail_res['data']['id'])) {
                    $od = array_merge($order, $detail_res['data']);
                } else {
                    $od = $order;
                }

                $order_status = $od['status'] ?? ($order['status'] ?? 'UNPAID');
                $total_amount = $od['payment']['total_amount'] ?? ($order['payment']['total_amount'] ?? 0);
                $tracking_number = $od['tracking_number'] ?? ($order['tracking_number'] ?? '');
                $shipping_provider = $od['shipping_provider'] ?? ($od['shipping_provider_name'] ?? ($order['shipping_provider'] ?? ''));
                $shipping_type = $od['shipping_type'] ?? ($order['shipping_type'] ?? 'TIKTOK');
                $delivery_option_name = $od['delivery_option_name'] ?? ($order['delivery_option_name'] ?? '');

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
                    $order_data['order_created_time'] = date('Y-m-d H:i:s', $od['create_time']);
                }
                if (!empty($od['paid_time'])) {
                    $order_data['order_paid_time'] = date('Y-m-d H:i:s', $od['paid_time']);
                }

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_orders', $order_data);
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
    public function sync_orders() { $this->pull_orders(); }

    /**
     * Job 2: Tarik Paket Pengiriman & Nomor Resi AWB (Interval 5 Menit)
     */
    public function pull_packages()
    {
        $this->_log(">>> [JOB: PAKET] Modul pengiriman paket dinonaktifkan. Data pengiriman dan resi sudah terintegrasi di Pesanan.");
    }
    public function sync_packages() { $this->pull_packages(); }

    /**
     * Job 3: Tarik Retur, Refund, & Pembatalan Pesanan (Interval 5-10 Menit untuk SLA 48 Jam)
     */
    public function pull_returns_cancellations()
    {
        $this->_log(">>> [JOB: RETUR & PEMBATALAN] Memulai sinkronisasi komplain pembeli...");
        $this->sync_returns();
        $this->sync_cancellations();
    }

    /**
     * Sub-task: Tarik Pengajuan Retur & Refund
     */
    public function sync_returns()
    {
        $shops = $this->_get_active_shops();
        $total_returns = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> [Retur] Toko: {$shop->shop_name} (ID: {$shop->id})");
            $res = $this->tiktok_api->search_returns([], ['page_size' => 50], $shop->id);

            if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
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
     * Sub-task: Tarik Pengajuan Pembatalan Pesanan
     */
    public function sync_cancellations()
    {
        $shops = $this->_get_active_shops();
        $total_cancellations = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> [Pembatalan] Toko: {$shop->shop_name} (ID: {$shop->id})");
            $res = $this->tiktok_api->search_cancellations([], ['page_size' => 50], $shop->id);

            if (!$res['success'] && (!isset($res['code']) || $res['code'] !== 0)) {
                $this->_log("       [ERROR] Gagal search_cancellations: " . ($res['message'] ?? 'Unknown error'));
                continue;
            }

            $cancellations = $res['data']['cancellations'] ?? ($res['data']['cancel_orders'] ?? []);
            $this->_log("       Ditemukan " . count($cancellations) . " pengajuan pembatalan.");

            foreach ($cancellations as $co) {
                $cancel_id = $co['cancel_id'] ?? ($co['id'] ?? null);
                if (!$cancel_id) continue;

                $order_id = $co['order_id'] ?? '';
                $status = $co['cancel_status'] ?? ($co['status'] ?? 'AWAITING_SELLER_REVIEW');
                $reason = $co['cancel_reason'] ?? ($co['reason'] ?? '');
                $reason_key = $co['cancel_reason_key'] ?? ($co['reason_key'] ?? '');
                $initiator = $co['cancel_initiator'] ?? ($co['initiator'] ?? 'BUYER');
                $items = !empty($co['cancel_line_items']) ? json_encode($co['cancel_line_items']) : (!empty($co['items']) ? json_encode($co['items']) : null);

                $created_time = null;
                if (!empty($co['create_time'])) {
                    $ts = intval($co['create_time']);
                    if ($ts > 100000000000) {
                        $ts = round($ts / 1000);
                    }
                    $created_time = date('Y-m-d H:i:s', $ts);
                }

                $existing = $this->db->get_where('tiktok_cancellations', ['cancel_id' => $cancel_id])->row();

                $save_data = [
                    'tiktok_shop_id'     => $shop->id,
                    'cancel_id'          => $cancel_id,
                    'order_id'           => $order_id,
                    'cancel_status'      => $status,
                    'cancel_reason'      => $reason,
                    'cancel_reason_key'  => $reason_key,
                    'cancel_initiator'   => $initiator,
                    'items'              => $items,
                    'cancel_created_time'=> $created_time,
                    'updated_at'         => date('Y-m-d H:i:s'),
                ];

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_cancellations', $save_data);
                } else {
                    $save_data['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('tiktok_cancellations', $save_data);
                }

                $total_cancellations++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_cancellations} pengajuan pembatalan.");
    }

    /**
     * Job 4: Refresh Access Token Sebelum Expired (Interval 12 Jam)
     */
    public function refresh_token()
    {
        $this->_log(">>> [JOB: REFRESH TOKEN] Memeriksa masa aktif token seluruh toko...");
        $shops = $this->db->get('tiktok_shops')->result();
        $refreshed_count = 0;

        foreach ($shops as $shop) {
            $expire_in = (int) $shop->access_token_expire_in;
            $now = time();
            $hours_left = round(($expire_in - $now) / 3600, 1);

            $this->_log("    -> Toko: {$shop->shop_name} (Sisa masa aktif token: {$hours_left} jam)");

            // Refresh jika sisa masa aktif < 24 jam atau sudah kadaluarsa
            if (empty($expire_in) || ($expire_in - $now) < 86400) {
                if (empty($shop->refresh_token)) {
                    $this->_log("       [WARNING] Toko {$shop->shop_name} tidak memiliki refresh_token. Silakan hubungkan ulang via OAuth.");
                    continue;
                }

                $this->_log("       Memperbarui token untuk toko {$shop->shop_name}...");
                $app_key = $shop->app_key ?: null;
                $app_secret = $shop->app_secret ?: null;

                $res = $this->tiktok_api->refresh_access_token($shop->refresh_token, $app_key, $app_secret);

                if (isset($res['code']) && $res['code'] === 0 && !empty($res['data']['access_token'])) {
                    $new_data = $res['data'];
                    $this->db->where('id', $shop->id)->update('tiktok_shops', [
                        'access_token'           => $new_data['access_token'],
                        'access_token_expire_in' => $new_data['access_token_expire_in'],
                        'refresh_token'          => $new_data['refresh_token'] ?? $shop->refresh_token,
                        'refresh_token_expire_in'=> $new_data['refresh_token_expire_in'] ?? $shop->refresh_token_expire_in,
                        'updated_at'             => date('Y-m-d H:i:s'),
                    ]);
                    $this->_log("       [SUCCESS] Token berhasil diperbarui! Expired baru: " . date('Y-m-d H:i:s', $new_data['access_token_expire_in']));
                    $refreshed_count++;
                } else {
                    $this->_log("       [ERROR] Gagal refresh token: " . ($res['message'] ?? 'Unknown error'));
                }
            } else {
                $this->_log("       [INFO] Token masih aman (lebih dari 24 jam). Tidak perlu refresh.");
            }
        }

        $this->_log("    [OK] Selesai pengecekan token. Total diperbarui: {$refreshed_count}.");
    }

    /**
     * Job 5: Tarik Keuangan: Statement, Penarikan Dana & Transaksi Belum Settle (Harian)
     */
    public function pull_statements()
    {
        $this->_log(">>> [JOB: KEUANGAN] Memulai sinkronisasi Keuangan & Rekonsiliasi...");
        $shops = $this->_get_active_shops();
        $total_statements = 0;
        $total_withdrawals = 0;
        $total_unsettled = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");

            // A. Statement Settlement
            $res = $this->tiktok_api->get_statements(['page_size' => 50, 'sort_field' => 'statement_time'], $shop->id);
            if ($res['success'] || (isset($res['code']) && $res['code'] === 0)) {
                $statements = $res['data']['statements'] ?? [];
                $this->_log("       [Statement] Ditemukan " . count($statements) . " rekap settlement.");

                foreach ($statements as $st) {
                    $statement_id = $st['id'] ?? ($st['statement_id'] ?? null);
                    if (!$statement_id) continue;

                    $statement_time = null;
                    if (!empty($st['statement_time'])) {
                        $ts = intval($st['statement_time']);
                        if ($ts > 100000000000) $ts = round($ts / 1000);
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
                        $local_finance_id = $existing->id;
                    } else {
                        $save_data['created_at'] = date('Y-m-d H:i:s');
                        $this->db->insert('tiktok_finance', $save_data);
                        $local_finance_id = $this->db->insert_id();
                    }

                    // Sinkronkan rincian transaksi dalam statement
                    $tx_res = $this->tiktok_api->get_statement_transactions($statement_id, ['page_size' => 100], $shop->id);
                    $tx_list = $tx_res['data']['statement_transactions'] ?? ($tx_res['data']['transactions'] ?? []);
                    if (!empty($tx_list)) {
                        $this->db->where('tiktok_finance_id', $local_finance_id)->delete('tiktok_statement_transactions');
                        foreach ($tx_list as $tx) {
                            $p_time = null;
                            if (!empty($tx['paid_time'])) {
                                $ts = intval($tx['paid_time']);
                                if ($ts > 100000000000) $ts = round($ts / 1000);
                                $p_time = date('Y-m-d H:i:s', $ts);
                            }
                            $this->db->insert('tiktok_statement_transactions', [
                                'tiktok_finance_id' => $local_finance_id,
                                'statement_id'      => $statement_id,
                                'order_id'          => $tx['order_id'] ?? null,
                                'transaction_type'  => $tx['type'] ?? ($tx['transaction_type'] ?? 'ORDER'),
                                'order_amount'      => floatval($tx['order_amount'] ?? 0),
                                'shipping_fee'      => floatval($tx['shipping_fee'] ?? ($tx['shipping_fee_amount'] ?? 0)),
                                'platform_fee'      => floatval($tx['platform_fee'] ?? ($tx['fee_amount'] ?? 0)),
                                'settlement_amount' => floatval($tx['settlement_amount'] ?? 0),
                                'paid_time'         => $p_time,
                                'created_at'        => date('Y-m-d H:i:s')
                            ]);
                        }
                    }

                    $total_statements++;
                }
            }

            // B. Penarikan Dana (Withdrawals)
            $w_res = $this->tiktok_api->get_withdrawals(['page_size' => 50, 'types' => 'WITHDRAW'], $shop->id);
            if ($w_res['success'] || (isset($w_res['code']) && $w_res['code'] === 0)) {
                $withdrawals = $w_res['data']['withdrawals'] ?? [];
                $this->_log("       [Penarikan] Ditemukan " . count($withdrawals) . " data penarikan.");

                foreach ($withdrawals as $w) {
                    $withdrawal_id = $w['id'] ?? ($w['withdrawal_id'] ?? null);
                    if (!$withdrawal_id) continue;

                    $transfer_time = null;
                    $time_val = $w['transfer_time'] ?? ($w['paid_time'] ?? ($w['create_time'] ?? null));
                    if (!empty($time_val)) {
                        $ts = intval($time_val);
                        if ($ts > 100000000000) $ts = round($ts / 1000);
                        $transfer_time = date('Y-m-d H:i:s', $ts);
                    }

                    $w_data = [
                        'tiktok_shop_id' => $shop->id,
                        'withdrawal_id'  => $withdrawal_id,
                        'amount'         => floatval($w['amount'] ?? 0),
                        'currency'       => $w['currency'] ?? 'IDR',
                        'bank_name'      => $w['bank_name'] ?? ($w['bank_account_info']['bank_name'] ?? '-'),
                        'bank_account'   => $w['bank_account'] ?? ($w['bank_account_info']['bank_account'] ?? '-'),
                        'status'         => strtoupper($w['status'] ?? 'SUCCESS'),
                        'transfer_time'  => $transfer_time,
                        'updated_at'     => date('Y-m-d H:i:s')
                    ];

                    $existing_w = $this->db->get_where('tiktok_withdrawals', ['withdrawal_id' => $withdrawal_id])->row();
                    if ($existing_w) {
                        $this->db->where('id', $existing_w->id)->update('tiktok_withdrawals', $w_data);
                    } else {
                        $w_data['created_at'] = date('Y-m-d H:i:s');
                        $this->db->insert('tiktok_withdrawals', $w_data);
                    }
                    $total_withdrawals++;
                }
            }

            // C. Dana Tertahan (Unsettled Orders)
            $u_res = $this->tiktok_api->get_unsettled_transactions(['page_size' => 50, 'sort_field' => 'order_create_time'], $shop->id);
            if ($u_res['success'] || (isset($u_res['code']) && $u_res['code'] === 0)) {
                $unsettled = $u_res['data']['transactions'] ?? ($u_res['data']['orders'] ?? []);
                $this->_log("       [Dana Tertahan] Ditemukan " . count($unsettled) . " transaksi belum settle.");

                foreach ($unsettled as $u) {
                    $order_id = $u['order_id'] ?? ($u['transaction_id'] ?? ($u['id'] ?? null));
                    if (!$order_id) continue;

                    $u_time = null;
                    $time_val = $u['order_create_time'] ?? ($u['order_created_time'] ?? ($u['create_time'] ?? null));
                    if (!empty($time_val)) {
                        $ts = intval($time_val);
                        if ($ts > 100000000000) $ts = round($ts / 1000);
                        $u_time = date('Y-m-d H:i:s', $ts);
                    }

                    $u_data = [
                        'tiktok_shop_id'              => $shop->id,
                        'order_id'                    => $order_id,
                        'settlement_status'           => $u['settlement_status'] ?? ($u['status'] ?? 'UNSETTLED'),
                        'estimated_settlement_amount' => floatval($u['estimated_settlement_amount'] ?? ($u['est_settlement_amount'] ?? 0)),
                        'currency'                    => $u['currency'] ?? 'IDR',
                        'order_created_time'          => $u_time,
                        'synced_at'                   => date('Y-m-d H:i:s')
                    ];

                    $existing_u = $this->db->get_where('tiktok_unsettled_transactions', ['order_id' => $order_id])->row();
                    if ($existing_u) {
                        $this->db->where('id', $existing_u->id)->update('tiktok_unsettled_transactions', $u_data);
                    } else {
                        $this->db->insert('tiktok_unsettled_transactions', $u_data);
                    }
                    $total_unsettled++;
                }
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi Keuangan: {$total_statements} statement, {$total_withdrawals} penarikan, {$total_unsettled} dana tertahan.");
    }
    public function sync_finance() { $this->pull_statements(); }

    /**
     * Job 6: Tarik Katalog Produk & SKUs
     */
    public function sync_products()
    {
        $this->_log(">>> [JOB: PRODUK] Memulai penarikan data Produk TikTok...");
        $shops = $this->_get_active_shops();
        $total_products = 0;

        foreach ($shops as $shop) {
            $this->_log("    -> Toko: {$shop->shop_name} (ID: {$shop->id})");
            $search_res = $this->tiktok_api->search_products(['page_size' => 100], [], $shop->id);

            if (!$search_res['success'] && (!isset($search_res['code']) || $search_res['code'] !== 0)) {
                $this->_log("       [ERROR] Gagal search_products: " . ($search_res['message'] ?? 'Unknown error'));
                continue;
            }

            $products = $search_res['data']['products'] ?? [];
            $this->_log("       Ditemukan " . count($products) . " produk di etalase.");

            foreach ($products as $p) {
                $product_id = $p['id'];
                $title = $p['title'] ?? '-';
                $status = $p['status'] ?? 'LIVE';

                if (strtoupper($status) === 'DELETED') {
                    $this->db->where('product_id', $product_id)->delete('tiktok_product_skus');
                    $this->db->where('product_id', $product_id)->delete('tiktok_products');
                    continue;
                }

                // Ambil detail lengkap produk dari API untuk gambar dan atribut lengkap
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
                } elseif (!empty($detail['main_images'][0]['thumb_urls'][0])) {
                    $main_image = $detail['main_images'][0]['thumb_urls'][0];
                } elseif (!empty($p['main_images'][0]['urls'][0])) {
                    $main_image = $p['main_images'][0]['urls'][0];
                }

                $category_name = null;
                if (!empty($detail['category_chains'])) {
                    $cat_names = array_column($detail['category_chains'], 'local_name');
                    $category_name = implode(' > ', $cat_names);
                }

                $brand_name = isset($detail['brand']['name']) ? trim($detail['brand']['name'], " \"'") : null;
                $description = $detail['description'] ?? null;
                $package_weight = isset($detail['package_weight']['value']) ? preg_replace('/[^0-9.]/', '', (string)$detail['package_weight']['value']) : null;

                $total_stock = 0;
                $price = 0;
                $seller_sku = null;

                $skus = $detail['skus'] ?? ($p['skus'] ?? []);
                if (!empty($skus)) {
                    foreach ($skus as $s) {
                        if (!empty($s['inventory'])) {
                            foreach ($s['inventory'] as $inv) {
                                $total_stock += intval($inv['quantity'] ?? 0);
                            }
                        } elseif (isset($s['stock_infos'])) {
                            foreach ($s['stock_infos'] as $stk) {
                                $total_stock += intval($stk['available_stock'] ?? 0);
                            }
                        }
                    }
                    $first_sku = $skus[0];
                    $price = floatval($first_sku['price']['tax_exclusive_price'] ?? ($first_sku['price']['original_price'] ?? 0));
                    $seller_sku = $first_sku['seller_sku'] ?? null;
                }

                $existing = $this->db->get_where('tiktok_products', ['product_id' => $product_id])->row();

                if (empty($main_image) && $existing && !empty($existing->main_image)) {
                    $main_image = $existing->main_image;
                }

                $save_data = [
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

                if ($existing) {
                    $this->db->where('id', $existing->id)->update('tiktok_products', $save_data);
                    $local_product_id = $existing->id;
                } else {
                    $save_data['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('tiktok_products', $save_data);
                    $local_product_id = $this->db->insert_id();
                }

                // Varian SKUs
                if (!empty($skus)) {
                    $this->db->where('tiktok_product_id', $local_product_id)->delete('tiktok_product_skus');
                    foreach ($skus as $s) {
                        $sku_price = 0;
                        if (isset($s['price']['tax_exclusive_price'])) {
                            $sku_price = $s['price']['tax_exclusive_price'];
                        } elseif (isset($s['price']['original_price'])) {
                            $sku_price = $s['price']['original_price'];
                        }

                        $sku_stock = 0;
                        $warehouse_id = null;
                        if (!empty($s['inventory'])) {
                            foreach ($s['inventory'] as $inv) {
                                $sku_stock += (int) ($inv['quantity'] ?? 0);
                                $warehouse_id = $inv['warehouse_id'] ?? $warehouse_id;
                            }
                        } elseif (!empty($s['stock_infos'])) {
                            foreach ($s['stock_infos'] as $stk) {
                                $sku_stock += (int) ($stk['available_stock'] ?? 0);
                            }
                        }

                        $this->db->insert('tiktok_product_skus', [
                            'tiktok_product_id' => $local_product_id,
                            'product_id'        => $product_id,
                            'sku_id'            => $s['id'] ?? '',
                            'seller_sku'        => $s['seller_sku'] ?? '',
                            'sku_name'          => !empty($s['sales_attributes']) ? implode(', ', array_map(function($a) {
                                $attr = !empty($a['name']) ? $a['name'] : ($a['attribute_name'] ?? '');
                                $val = $a['value_name'] ?? '';
                                return ($attr !== '' ? $attr . ': ' : '') . $val;
                            }, $s['sales_attributes'])) : ($s['sku_name'] ?? 'Default'),
                            'price'             => (float) $sku_price,
                            'currency'          => $s['price']['currency'] ?? 'IDR',
                            'stock'             => $sku_stock,
                            'warehouse_id'      => $warehouse_id,
                            'created_at'        => date('Y-m-d H:i:s'),
                            'updated_at'        => date('Y-m-d H:i:s'),
                        ]);
                    }
                }

                $total_products++;
            }
        }

        $this->_log("    [OK] Selesai sinkronisasi {$total_products} produk.");
    }
}

/* End of file Cron.php */
/* Location: ./modules/cron/controllers/Cron.php */
