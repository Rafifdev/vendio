<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/Order_prize_rules.php';

/** Do not use MY_Controller::response(): it discards HTTP status codes. */
trait Order_prize_http
{
    protected function prize_json(callable $work, $method = 'GET')
    {
        $this->output->enable_profiler(false);
        $this->output->set_header('Cache-Control: no-store');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        try {
            if ($this->input->method(true) !== $method) {
                $this->output->set_header('Allow: ' . $method);
                throw new Order_prize_error('Metode HTTP tidak diizinkan.', 405);
            }
            if ($method === 'POST') {
                // Defense in depth: the application's MY_Security skips /api/*.
                // Even a direct/alternate HMVC route must retain CSRF protection.
                $posted = $this->input->post($this->security->get_csrf_token_name());
                $cookie = $this->input->cookie($this->config->item('csrf_cookie_name'));
                if (!is_string($posted) || !is_string($cookie) || !hash_equals($this->security->get_csrf_hash(), $posted) || !hash_equals($cookie, $posted)) {
                    throw new Order_prize_error('CSRF tidak valid. Muat ulang halaman.', 403);
                }
            }
            $data = ['success'=>true, 'data'=>$work()];
            $status = 200;
        } catch (Order_prize_error $e) {
            $status = $e->http_status;
            $data = ['success'=>false, 'message'=>$e->getMessage()];
            if ($status === 429) $this->output->set_header('Retry-After: 900');
        } catch (Throwable $e) {
            log_message('error', 'Order Prizes request failed: ' . get_class($e));
            $status = 500;
            $data = ['success'=>false, 'message'=>'Proses belum berhasil. Coba ulang; hasil spin yang tersimpan tidak akan berubah.'];
        }
        $data['csrf'] = ['name'=>$this->security->get_csrf_token_name(), 'hash'=>$this->security->get_csrf_hash()];
        $this->output->set_status_header($status)->set_content_type('application/json', 'utf-8')->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    protected function prize_input()
    {
        $input = $this->input->post(null, false);
        return is_array($input) ? $input : [];
    }
}
