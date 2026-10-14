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
        if (!$this->is_allowed($permission, false)) throw new Order_prize_error('Tidak memiliki izin.', $this->aauth->is_loggedin() ? 403 : 401);
    }

    public function index()
    {
        $this->is_allowed('order_prizes_view');
        $this->template->title('Order Prizes');
        $this->render('order_prizes/admin', [
            'can_manage'=>$this->is_allowed('order_prizes_manage', false),
            'can_fulfill'=>$this->is_allowed('order_prizes_fulfill', false),
        ]);
    }

    public function records($entity = 'campaigns')
    {
        $this->prize_json(function () use ($entity) {
            $this->authorize('order_prizes_view');
            $filters = $this->input->get(null, false);
            return $this->prizes->listing($entity, is_array($filters) ? $filters : []);
        });
    }

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

    public function fulfill($id = 0)
    {
        $this->prize_json(function () use ($id) {
            $this->authorize('order_prizes_fulfill');
            return $this->prizes->fulfill(Order_prize_rules::integer($id, 'ID', 1, 4294967295), $this->prize_input(), (int)$this->aauth->get_user()->id);
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
                if ($header !== $expected) throw new Order_prize_error('Header CSV harus: ' . implode(',', $expected));
                $rows = [];
                while (($row = fgetcsv($handle, 10000, ',', '"', '\\')) !== false) {
                    if (count($row) !== count($header)) throw new Order_prize_error('Jumlah kolom CSV salah pada baris ' . (count($rows) + 2));
                    $rows[] = array_combine($header, $row);
                    if (count($rows) > 1000) throw new Order_prize_error('Maksimal 1000 baris per import.');
                }
                return $this->prizes->import_orders($id, $rows, (int)$this->aauth->get_user()->id);
            } finally {
                fclose($handle);
            }
        }, 'POST');
    }
}
