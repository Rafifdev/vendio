<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__DIR__, 2) . '/libraries/Order_prize_http.php';

class Order_prizes extends Admin
{
    use Order_prize_http;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_prizes/model_order_prizes', 'prizes');
        date_default_timezone_set('Asia/Jakarta');
        $this->output->enable_profiler(false);
    }

    private function authorize($permission)
    {
        if (!$this->is_allowed($permission, false)) {
            throw new Order_prize_error('Tidak memiliki izin.', $this->aauth->is_loggedin() ? 403 : 401);
        }
    }

    /**
     * Main Index: Unified management dashboard with tabs
     */
    public function index($tab = 'campaigns')
    {
        $this->is_allowed('order_prizes_view');
        
        $valid_tabs = ['campaigns', 'prizes', 'orders', 'spins', 'audit'];
        if (!in_array($tab, $valid_tabs, true)) {
            $tab = 'campaigns';
        }

        $filters = $this->input->get(null, true) ?: [];
        $page = max(1, (int)($filters['page'] ?? 1));
        $filters['page'] = $page;
        $filters['limit'] = 20;

        $records = $this->prizes->listing($tab, $filters);
        $stats = $this->prizes->get_summary_stats();
        $campaigns_dropdown = $this->prizes->get_campaigns_dropdown();

        $this->template->title('Order Prizes · Hadiah Pesanan');
        $this->render('order_prizes/admin_list', [
            'active_tab' => $tab,
            'records' => $records,
            'stats' => $stats,
            'campaigns_dropdown' => $campaigns_dropdown,
            'filters' => $filters,
            'can_manage' => $this->is_allowed('order_prizes_manage', false),
            'can_fulfill' => $this->is_allowed('order_prizes_fulfill', false),
        ]);
    }

    public function tab($tab = 'campaigns')
    {
        $this->index($tab);
    }

    // ==========================================
    // CAMPAIGN DEDICATED PAGES
    // ==========================================

    public function campaign_add()
    {
        $this->is_allowed('order_prizes_manage');
        $this->template->title('Tambah Campaign Baru · Order Prizes');
        $this->render('order_prizes/campaign_form', [
            'mode' => 'add',
            'campaign' => [
                'id' => 0,
                'name' => '',
                'slug' => '',
                'channel' => 'shopee',
                'shop_ref' => '',
                'status' => 'draft',
                'starts_at' => date('Y-m-d H:i:s'),
                'ends_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
                'claim_days' => 7,
                'budget_profit_percent' => '',
                'terms' => "1. Khusus pesanan terverifikasi yang telah berstatus Selesai/Paid.\n2. Satu nomor pesanan hanya berhak memutar 1 kali spin.\n3. Hadiah yang didapat wajib diklaim sebelum batas masa klaim berakhir.\n4. Keputusan hasil pengundian bersifat mutlak dan ditentukan secara transparan oleh sistem.",
            ],
        ]);
    }

    public function campaign_edit($id = 0)
    {
        $this->is_allowed('order_prizes_manage');
        $id = (int)$id;
        try {
            $campaign = $this->prizes->get_row('campaigns', $id);
        } catch (Throwable $e) {
            set_message('Campaign tidak ditemukan.', 'error');
            redirect(ADMIN_NAMESPACE_URL . '/order_prizes/tab/campaigns');
        }

        $this->template->title('Edit Campaign: ' . html_escape($campaign['name']));
        $this->render('order_prizes/campaign_form', [
            'mode' => 'edit',
            'campaign' => $campaign,
        ]);
    }

    // ==========================================
    // PRIZE DEDICATED PAGES
    // ==========================================

    public function prize_add()
    {
        $this->is_allowed('order_prizes_manage');
        $campaign_id = (int)$this->input->get('campaign_id');
        $campaigns_dropdown = $this->prizes->get_campaigns_dropdown();

        if (empty($campaigns_dropdown)) {
            set_message('Buat campaign terlebih dahulu sebelum menambahkan hadiah.', 'warning');
            redirect(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_add');
        }

        $this->template->title('Tambah Hadiah & Threshold · Order Prizes');
        $this->render('order_prizes/prize_form', [
            'mode' => 'add',
            'campaigns_dropdown' => $campaigns_dropdown,
            'default_campaign_id' => $campaign_id ?: ($campaigns_dropdown[0]['id'] ?? 0),
            'prize' => [
                'id' => 0,
                'campaign_id' => $campaign_id ?: ($campaigns_dropdown[0]['id'] ?? 0),
                'name' => '',
                'description' => '',
                'kind' => 'physical',
                'active' => 1,
                'weight' => 10,
                'stock' => '',
                'cost' => 0,
                'threshold_spins' => 0,
                'threshold_revenue' => 0,
                'threshold_profit' => 0,
                'auto_metric' => 'none',
                'allocation_percent' => 10,
            ],
        ]);
    }

    public function prize_edit($id = 0)
    {
        $this->is_allowed('order_prizes_manage');
        $id = (int)$id;
        try {
            $prize = $this->prizes->get_row('prizes', $id);
        } catch (Throwable $e) {
            set_message('Hadiah tidak ditemukan.', 'error');
            redirect(ADMIN_NAMESPACE_URL . '/order_prizes/tab/prizes');
        }

        $campaigns_dropdown = $this->prizes->get_campaigns_dropdown();

        $this->template->title('Edit Hadiah: ' . html_escape($prize['name']));
        $this->render('order_prizes/prize_form', [
            'mode' => 'edit',
            'campaigns_dropdown' => $campaigns_dropdown,
            'default_campaign_id' => $prize['campaign_id'],
            'prize' => $prize,
        ]);
    }

    // ==========================================
    // ORDER DEDICATED PAGES
    // ==========================================

    public function order_add()
    {
        $this->is_allowed('order_prizes_manage');
        $campaign_id = (int)$this->input->get('campaign_id');
        $campaigns_dropdown = $this->prizes->get_campaigns_dropdown();

        if (empty($campaigns_dropdown)) {
            set_message('Buat campaign terlebih dahulu sebelum menambahkan pesanan.', 'warning');
            redirect(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_add');
        }

        $this->template->title('Tambah Order Terverifikasi · Order Prizes');
        $this->render('order_prizes/order_form', [
            'mode' => 'add',
            'campaigns_dropdown' => $campaigns_dropdown,
            'default_campaign_id' => $campaign_id ?: ($campaigns_dropdown[0]['id'] ?? 0),
            'order' => [
                'id' => 0,
                'campaign_id' => $campaign_id ?: ($campaigns_dropdown[0]['id'] ?? 0),
                'order_number' => '',
                'phone' => '',
                'status' => 'completed',
                'revenue' => '',
                'profit' => '',
                'ordered_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function order_edit($id = 0)
    {
        $this->is_allowed('order_prizes_manage');
        $id = (int)$id;
        try {
            $order = $this->prizes->get_row('orders', $id);
        } catch (Throwable $e) {
            set_message('Order tidak ditemukan.', 'error');
            redirect(ADMIN_NAMESPACE_URL . '/order_prizes/tab/orders');
        }

        $campaigns_dropdown = $this->prizes->get_campaigns_dropdown();

        $this->template->title('Edit Order #' . html_escape($order['order_number']));
        $this->render('order_prizes/order_form', [
            'mode' => 'edit',
            'campaigns_dropdown' => $campaigns_dropdown,
            'default_campaign_id' => $order['campaign_id'],
            'order' => $order,
        ]);
    }

    // ==========================================
    // FORM SAVE ACTIONS (AJAX + Standard Submit)
    // ==========================================

    public function save($entity = '', $id = 0)
    {
        $this->prize_json(function () use ($entity, $id) {
            $this->authorize('order_prizes_manage');
            $id = Order_prize_rules::integer($id, 'ID', 0, 4294967295);
            $actor = (int)$this->aauth->get_user()->id;
            $input = $this->prize_input();
            switch ($entity) {
                case 'campaigns': return $this->prizes->save_campaign($input, $id, $actor);
                case 'prizes': return $this->prizes->save_prize($input, $id, $actor);
                case 'orders': return $this->prizes->save_order($input, $id, $actor);
                default: throw new Order_prize_error('Modul tidak ditemukan.', 404);
            }
        }, 'POST');
    }

    public function delete($entity = '', $id = 0)
    {
        $this->prize_json(function () use ($entity, $id) {
            $this->authorize('order_prizes_manage');
            $id = Order_prize_rules::integer($id, 'ID', 1, 4294967295);
            $actor = (int)$this->aauth->get_user()->id;
            return $this->prizes->delete_record($entity, $id, $actor);
        }, 'POST');
    }

    public function records($entity = 'campaigns')
    {
        $this->prize_json(function () use ($entity) {
            $this->authorize('order_prizes_view');
            $filters = $this->input->get(null, false);
            return $this->prizes->listing($entity, is_array($filters) ? $filters : []);
        });
    }

    public function fulfill($id = 0)
    {
        $this->prize_json(function () use ($id) {
            $this->authorize('order_prizes_fulfill');
            return $this->prizes->fulfill(
                Order_prize_rules::integer($id, 'ID', 1, 4294967295),
                $this->prize_input(),
                (int)$this->aauth->get_user()->id
            );
        }, 'POST');
    }

    public function import_orders()
    {
        $this->prize_json(function () {
            $this->authorize('order_prizes_manage');
            $id = Order_prize_rules::integer($this->input->post('campaign_id'), 'Campaign', 1, 4294967295);
            $file = $_FILES['file'] ?? null;
            if (!$file || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > 2097152 || !is_uploaded_file($file['tmp_name'])) {
                throw new Order_prize_error('Upload CSV maksimal 2 MB.');
            }
            $handle = fopen($file['tmp_name'], 'r');
            if (!$handle) throw new Order_prize_error('CSV tidak dapat dibaca.');
            try {
                $header = fgetcsv($handle, 10000, ',', '"', '\\');
                if (!$header) throw new Order_prize_error('CSV kosong.');
                $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
                $expected = ['order_number','phone','status','revenue','profit','ordered_at'];
                if ($header !== $expected) {
                    throw new Order_prize_error('Header CSV harus: ' . implode(',', $expected));
                }
                $rows = [];
                while (($row = fgetcsv($handle, 10000, ',', '"', '\\')) !== false) {
                    if (count($row) !== count($header)) {
                        throw new Order_prize_error('Jumlah kolom CSV salah pada baris ' . (count($rows) + 2));
                    }
                    $rows[] = array_combine($header, $row);
                    if (count($rows) > 1000) {
                        throw new Order_prize_error('Maksimal 1000 baris per import.');
                    }
                }
                return $this->prizes->import_orders($id, $rows, (int)$this->aauth->get_user()->id);
            } finally {
                fclose($handle);
            }
        }, 'POST');
    }
}
