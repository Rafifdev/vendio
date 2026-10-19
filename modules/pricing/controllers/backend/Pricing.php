<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * --------------------------------------------------------------------------
 * Pricing Controller
 * --------------------------------------------------------------------------
 * User-facing Subscription Pricing Plans Showcase & Xendit Payment Gateway
 */
class Pricing extends Admin
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pricing');
        $this->load->library('xendit_lib');
    }

    /**
     * Display the pricing packages showcase and recent transaction history
     */
    public function index()
    {
        $this->is_allowed('pricing_view');

        $user = $this->aauth->get_user();
        $userId = (int)($user->id ?? 0);

        // Sinkronisasi realtime jika baru saja kembali dari pembayaran Xendit (?paid=...)
        $paid_external_id = $this->input->get('paid');
        if (!empty($paid_external_id)) {
            $tx_check = $this->model_pricing->get_transaction_by_external_id($paid_external_id);
            if ($tx_check && $tx_check->payment_status === 'PENDING' && !empty($tx_check->xendit_invoice_id)) {
                $xendit_res = $this->xendit_lib->get_invoice($tx_check->xendit_invoice_id);
                if ($xendit_res['success'] && !empty($xendit_res['data'])) {
                    $xstatus = strtoupper($xendit_res['data']['status'] ?? '');
                    if (in_array($xstatus, ['PAID', 'SETTLED'])) {
                        $this->model_pricing->activate_subscription_for_tenant($tx_check, [
                            'paid_at'          => $xendit_res['data']['paid_at'] ?? null,
                            'payment_method'   => $xendit_res['data']['payment_method'] ?? null,
                            'payment_channel'  => $xendit_res['data']['payment_channel'] ?? null,
                            'raw_response'     => $xendit_res['data']
                        ]);
                    } elseif ($xstatus === 'EXPIRED') {
                        $this->model_pricing->update_transaction_by_id($tx_check->id, [
                            'payment_status' => 'EXPIRED',
                            'raw_response'   => json_encode($xendit_res['data'])
                        ]);
                    }
                }
            }
        }

        $plans = $this->model_pricing->get_active_plans();
        $tenant = $this->model_pricing->get_current_tenant_plan($userId);

        $whatsapp_number = function_exists('get_option') ? get_option('site_whatsapp', '6281234567890') : '6281234567890';
        if (empty($whatsapp_number)) {
            $whatsapp_number = '6281234567890';
        }
        $whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
        if (substr($whatsapp_number, 0, 1) === '0') {
            $whatsapp_number = '62' . substr($whatsapp_number, 1);
        }

        $tenant_id = (int)($tenant->id ?? 1);
        $transactions = $this->model_pricing->get_tenant_transactions($tenant_id, 10);
        $current_usage = $this->model_pricing->get_tenant_current_usage($tenant_id);

        $current_plan_id = (int)($tenant->plan_id ?? 0);
        $current_plan_order = 0;
        if (!empty($plans)) {
            foreach ($plans as $p) {
                if ((int)$p->id === $current_plan_id) {
                    $current_plan_order = (int)($p->sort_order ?: $p->id);
                    break;
                }
            }
        }

        $this->data['plans'] = $plans;
        $this->data['current_plan_order'] = $current_plan_order;
        $this->data['tenant'] = $tenant;
        $this->data['user'] = $user;
        $this->data['whatsapp_number'] = $whatsapp_number ?: '6281234567890';
        $this->data['transactions'] = $transactions;
        $this->data['current_usage'] = $current_usage;
        $this->data['xendit_configured'] = $this->xendit_lib->is_configured();
        $this->data['csrf_name'] = $this->security->get_csrf_token_name();
        $this->data['csrf_hash'] = $this->security->get_csrf_hash();

        $this->template->title('Pilihan Paket Langganan · Vendio');
        $this->render('backend/standart/administrator/pricing/pricing_list', $this->data);
    }

    /**
     * AJAX endpoint to initiate Xendit Invoice checkout
     */
    public function checkout()
    {
        $this->is_allowed('pricing_view');

        // Pastikan format response JSON
        $this->output->set_content_type('application/json');

        if ($this->input->method() !== 'post') {
            echo json_encode([
                'success' => false,
                'message' => 'Metode request tidak valid.'
            ]);
            return;
        }

        $user = $this->aauth->get_user();
        $userId = (int)($user->id ?? 0);
        $tenant = $this->model_pricing->get_current_tenant_plan($userId);

        if (!$tenant) {
            echo json_encode([
                'success' => false,
                'message' => 'Data tenant akun Anda tidak ditemukan.'
            ]);
            return;
        }

        $plan_id  = (int)$this->input->post('plan_id');
        $duration = (int)$this->input->post('duration');
        if (!in_array($duration, [1, 3, 6, 12])) {
            $duration = 1;
        }

        $plan = $this->model_pricing->get_plan_by_id($plan_id);
        if (!$plan || $plan->status !== 'active') {
            echo json_encode([
                'success' => false,
                'message' => 'Paket langganan yang dipilih tidak aktif atau tidak ditemukan.'
            ]);
            return;
        }

        // Tentukan jenis aksi: RENEWAL, UPGRADE, atau DOWNGRADE
        $action_type = $this->model_pricing->get_subscription_action_type($tenant->plan_id, $plan->id);

        // Validasi keamanan Downgrade: pastikan kuota saat ini tidak melanggar batas paket baru
        if ($action_type === 'DOWNGRADE') {
            $downgrade_check = $this->model_pricing->check_downgrade_eligibility($tenant->id, $plan);
            if (!$downgrade_check['eligible']) {
                echo json_encode([
                    'success' => false,
                    'message' => $downgrade_check['message'],
                    'csrf'    => [
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    ]
                ]);
                return;
            }
        }

        // Hitung harga aman dari server side
        $calc = $this->model_pricing->calculate_plan_price($plan, $duration);
        $total_amount = (int)round($calc['total_price']);

        if ($total_amount <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Harga paket tidak valid untuk diproses pembayaran.'
            ]);
            return;
        }

        if (!$this->xendit_lib->is_configured()) {
            echo json_encode([
                'success' => false,
                'message' => 'Xendit Secret Key belum dikonfigurasi pada server (.env).'
            ]);
            return;
        }

        // Format identifier
        $today = date('Ymd');
        $unique_suffix = strtoupper(substr(uniqid(), -5));
        $invoice_number = "VND-INV-{$today}-{$unique_suffix}";
        $external_id = "SUB-T{$tenant->id}-P{$plan->id}-" . time();

        // Redirect URLs (Kembali ke halaman pricing dengan parameter modal ?paid=)
        $success_url = site_url(ADMIN_NAMESPACE_URL . '/pricing?paid=' . $external_id);
        $failure_url = site_url(ADMIN_NAMESPACE_URL . '/pricing?paid=' . $external_id);

        // Pre-insert transaksi dengan status PENDING
        $tx_data = [
            'invoice_number'   => $invoice_number,
            'tenant_id'        => (int)$tenant->id,
            'user_id'          => (int)$userId,
            'plan_id'          => (int)$plan->id,
            'plan_name'        => $plan->name,
            'duration_months'  => $duration,
            'action_type'      => $action_type,
            'original_amount'  => (float)$calc['original_price'],
            'discount_percent' => (float)$calc['discount_percent'],
            'total_amount'     => (float)$total_amount,
            'xendit_external_id' => $external_id,
            'payment_status'   => 'PENDING',
        ];

        $tx_id = $this->model_pricing->create_subscription_transaction($tx_data);

        // Parameter Invoice Xendit
        $payer_email = !empty($user->email) ? trim($user->email) : 'billing@vendio.id';
        $payer_name  = !empty($user->full_name) ? trim($user->full_name) : (!empty($user->username) ? trim($user->username) : 'Pelanggan Vendio');
        $payer_phone = !empty($tenant->phone) ? trim($tenant->phone) : '';

        $customer_data = [
            'given_names' => $payer_name,
            'email'       => $payer_email
        ];

        // Format nomor telepon ke standar E.164 (+62...) hanya jika diisi
        if (!empty($payer_phone)) {
            $clean_phone = preg_replace('/[^0-9]/', '', $payer_phone);
            if (substr($clean_phone, 0, 1) === '0') {
                $clean_phone = '62' . substr($clean_phone, 1);
            }
            if (substr($clean_phone, 0, 2) === '62') {
                $clean_phone = '+' . $clean_phone;
            }
            if (strlen($clean_phone) >= 10) {
                $customer_data['mobile_number'] = $clean_phone;
            }
        }

        $action_title = ($action_type === 'RENEWAL') ? 'Perpanjangan' : (($action_type === 'DOWNGRADE') ? 'Downgrade' : 'Upgrade');
        $xendit_payload = [
            'external_id'      => $external_id,
            'amount'           => $total_amount,
            'description'      => "Langganan Vendio ({$action_title}): {$plan->name} ({$duration} Bulan) - {$tenant->tenant_name}",
            'payer_email'      => $payer_email,
            'customer'         => $customer_data,
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_paid'    => ['email']
            ],
            'success_redirect_url' => $success_url,
            'failure_redirect_url' => $failure_url,
            'currency'             => 'IDR',
            'items'                => [
                [
                    'name'     => "Paket {$plan->name} ({$duration} Bulan)",
                    'quantity' => 1,
                    'price'    => $total_amount,
                    'category' => 'Subscription'
                ]
            ]
        ];

        $res = $this->xendit_lib->create_invoice($xendit_payload);

        if (!$res['success']) {
            $this->model_pricing->update_transaction_by_id($tx_id, [
                'payment_status' => 'FAILED',
                'raw_response'   => $res['raw'] ?? $res['message']
            ]);

            echo json_encode([
                'success' => false,
                'message' => 'Gagal membuat tagihan Xendit: ' . $res['message'],
                'csrf'    => [
                    'name' => $this->security->get_csrf_token_name(),
                    'hash' => $this->security->get_csrf_hash()
                ]
            ]);
            return;
        }

        $inv_data = $res['data'];
        $invoice_url = $inv_data['invoice_url'] ?? '';
        $xendit_inv_id = $inv_data['id'] ?? '';
        $expiry_date = !empty($inv_data['expiry_date']) ? date('Y-m-d H:i:s', strtotime($inv_data['expiry_date'])) : null;

        $this->model_pricing->update_transaction_by_id($tx_id, [
            'xendit_invoice_id' => $xendit_inv_id,
            'invoice_url'       => $invoice_url,
            'expiry_date'       => $expiry_date,
            'raw_response'      => json_encode($inv_data)
        ]);

        echo json_encode([
            'success'      => true,
            'message'      => 'Tagihan berhasil dibuat. Mengarahkan ke halaman pembayaran Xendit...',
            'invoice_url'  => $invoice_url,
            'external_id'  => $external_id,
            'csrf'         => [
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            ]
        ]);
    }

    /**
     * Return page after user completes or returns from Xendit Hosted Checkout
     *
     * @param string $external_id
     */
    public function payment_status($external_id = null)
    {
        $this->is_allowed('pricing_view');

        if (empty($external_id)) {
            if ($this->input->get('format') === 'json' && $this->input->get('popup') !== 'show') {
                echo json_encode(['success' => false, 'message' => 'Identifier transaksi tidak valid.']);
                return;
            }
            redirect(ADMIN_NAMESPACE_URL . '/pricing');
            return;
        }

        // Jangan pernah tampilkan beda page, alihkan ke modal pada halaman pricing
        if ($this->input->get('popup') !== 'show' && $this->input->get('format') !== 'json') {
            redirect(ADMIN_NAMESPACE_URL . '/pricing?paid=' . $external_id);
            return;
        }

        $transaction = $this->model_pricing->get_transaction_by_external_id($external_id);
        if (!$transaction) {
            if ($this->input->get('format') === 'json' && $this->input->get('popup') !== 'show') {
                echo json_encode(['success' => false, 'message' => 'Transaksi tidak ditemukan.']);
                return;
            }
            set_message('Transaksi tidak ditemukan.', 'error');
            redirect(ADMIN_NAMESPACE_URL . '/pricing');
            return;
        }

        $user = $this->aauth->get_user();
        $userId = (int)($user->id ?? 0);
        $tenant = $this->model_pricing->get_current_tenant_plan($userId);

        // Real-time synchronization check directly via Xendit API
        // Sangat berguna untuk pengujian di localhost jika webhook belum sampai
        if ($transaction->payment_status === 'PENDING' && !empty($transaction->xendit_invoice_id)) {
            $xendit_check = $this->xendit_lib->get_invoice($transaction->xendit_invoice_id);
            if ($xendit_check['success'] && !empty($xendit_check['data'])) {
                $status = strtoupper($xendit_check['data']['status'] ?? '');
                if (in_array($status, ['PAID', 'SETTLED'])) {
                    $this->model_pricing->activate_subscription_for_tenant($transaction, [
                        'paid_at'          => $xendit_check['data']['paid_at'] ?? null,
                        'payment_method'   => $xendit_check['data']['payment_method'] ?? null,
                        'payment_channel'  => $xendit_check['data']['payment_channel'] ?? null,
                        'raw_response'     => $xendit_check['data']
                    ]);
                    // Refresh data transaksi dan tenant
                    $transaction = $this->model_pricing->get_transaction_by_external_id($external_id);
                    $tenant = $this->model_pricing->get_current_tenant_plan($userId);
                } elseif ($status === 'EXPIRED') {
                    $this->model_pricing->update_transaction_by_id($transaction->id, [
                        'payment_status' => 'EXPIRED',
                        'raw_response'   => json_encode($xendit_check['data'])
                    ]);
                    $transaction->payment_status = 'EXPIRED';
                }
            }
        }

        // Support JSON response only when explicitly requested format=json without popup
        if ($this->input->get('format') === 'json' && $this->input->get('popup') !== 'show') {
            $status = strtoupper($transaction->payment_status ?? 'PENDING');
            $is_paid = in_array($status, ['PAID', 'SETTLED']);
            $is_pending = ($status === 'PENDING');
            $is_expired = ($status === 'EXPIRED' || $status === 'FAILED');

            $method_str = '-';
            if (!empty($transaction->payment_method)) {
                $method_str = $transaction->payment_method . (!empty($transaction->payment_channel) ? ' (' . $transaction->payment_channel . ')' : '');
            }

            $ends_at_str = '-';
            if ($is_paid && !empty($tenant->subscription_ends_at)) {
                $ends_at_str = date('d M Y, H:i', strtotime($tenant->subscription_ends_at)) . ' WIB';
            }

            echo json_encode([
                'success'     => true,
                'transaction' => [
                    'id'                   => (int)$transaction->id,
                    'invoice_number'       => $transaction->invoice_number,
                    'plan_name'            => $transaction->plan_name,
                    'duration_months'      => (int)$transaction->duration_months,
                    'total_amount'         => (float)$transaction->total_amount,
                    'total_amount_fmt'     => 'Rp ' . number_format($transaction->total_amount, 0, ',', '.'),
                    'payment_status'       => $status,
                    'payment_method'       => $method_str,
                    'created_at_fmt'       => date('d M Y, H:i', strtotime($transaction->created_at)) . ' WIB',
                    'paid_at_fmt'          => !empty($transaction->paid_at) ? date('d M Y, H:i', strtotime($transaction->paid_at)) . ' WIB' : '-',
                    'invoice_url'          => $transaction->invoice_url,
                    'xendit_external_id'   => $transaction->xendit_external_id,
                    'is_paid'              => $is_paid,
                    'is_pending'           => $is_pending,
                    'is_expired'           => $is_expired,
                    'subscription_ends_at' => $ends_at_str
                ]
            ]);
            return;
        }

        $this->data['transaction'] = $transaction;
        $this->data['tenant']      = $tenant;
        $this->data['user']        = $user;

        $this->template->title('Status Pembayaran · Vendio');
        $this->render('backend/standart/administrator/pricing/payment_status', $this->data);
    }

    /**
     * Webhook / Callback endpoint from Xendit
     * NOTE: CSRF protection is excluded for this URL in application/config/config.php
     */
    public function xendit_webhook()
    {
        $this->output->set_content_type('application/json');

        // 1. Verifikasi Token Webhook
        $incoming_token = $this->input->get_request_header('x-callback-token', TRUE);
        if (!$this->xendit_lib->verify_webhook_token($incoming_token)) {
            log_message('error', '[Xendit Webhook] Invalid verification token: ' . $incoming_token);
            $this->output->set_status_header(403);
            echo json_encode(['status' => 'ERROR', 'message' => 'Invalid callback token']);
            return;
        }

        // 2. Ambil raw JSON body
        $raw_input = file_get_contents('php://input');
        $payload = json_decode($raw_input, true);

        if (empty($payload)) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'ERROR', 'message' => 'Empty payload']);
            return;
        }

        $external_id = $payload['external_id'] ?? '';
        $xendit_id   = $payload['id'] ?? '';
        $status      = strtoupper($payload['status'] ?? '');

        log_message('info', "[Xendit Webhook] Received invoice event: ID={$xendit_id}, ExtID={$external_id}, Status={$status}");

        // 3. Cari data transaksi di Vendio
        $transaction = null;
        if (!empty($external_id)) {
            $transaction = $this->model_pricing->get_transaction_by_external_id($external_id);
        }
        if (!$transaction && !empty($xendit_id)) {
            $transaction = $this->model_pricing->get_transaction_by_xendit_id($xendit_id);
        }

        if (!$transaction) {
            log_message('error', "[Xendit Webhook] Transaction not found for ExtID={$external_id} or ID={$xendit_id}");
            // Return 200 agar Xendit tidak terus menerus retry
            echo json_encode(['status' => 'OK', 'message' => 'Transaction not found, skipped']);
            return;
        }

        // 4. Proses status pembayaran
        if (in_array($status, ['PAID', 'SETTLED'])) {
            $this->model_pricing->activate_subscription_for_tenant($transaction, [
                'paid_at'         => $payload['paid_at'] ?? null,
                'payment_method'  => $payload['payment_method'] ?? null,
                'payment_channel' => $payload['payment_channel'] ?? null,
                'raw_response'    => $payload
            ]);
            log_message('info', "[Xendit Webhook] Successfully activated subscription for Transaction #{$transaction->id}");
        } elseif ($status === 'EXPIRED') {
            $this->model_pricing->update_transaction_by_id($transaction->id, [
                'payment_status' => 'EXPIRED',
                'raw_response'   => json_encode($payload)
            ]);
            log_message('info', "[Xendit Webhook] Transaction #{$transaction->id} marked as EXPIRED");
        }

        echo json_encode(['status' => 'SUCCESS', 'message' => 'Webhook processed successfully']);
    }
}
