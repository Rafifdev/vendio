<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__DIR__) . '/libraries/Order_prize_http.php';

/** Public customer endpoints. No customer PII in public results. */
class Order_prizes extends MX_Controller
{
    use Order_prize_http;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_prizes/model_order_prizes', 'prizes');
        date_default_timezone_set('Asia/Jakarta');
        $this->output->enable_profiler(false);
        $this->output->set_header('Cache-Control: no-store');
        $this->output->set_header('Referrer-Policy: no-referrer');
    }

    public function index()
    {
        $this->load->view('order_prizes/customer');
    }

    public function campaign()
    {
        $this->prize_json(function () {
            $this->prizes->rate_limit('campaign.ip', $this->input->ip_address(), 120);
            return $this->prizes->public_campaign(Order_prize_rules::text($this->input->get('slug'), 'Campaign slug', 80));
        });
    }

    public function verify()
    {
        $this->prize_json(function () {
            $this->prizes->rate_limit('verify.ip', $this->input->ip_address(), 30);
            $in = $this->prize_input();
            if (($in['accept_terms'] ?? '') !== '1') throw new Order_prize_error('Setujui syarat & ketentuan terlebih dahulu.');
            return $this->prizes->verify(Order_prize_rules::text($in['slug'] ?? '', 'Campaign slug', 80),
                $in['order_number'] ?? '', $in['phone'] ?? '', $in['marketing_consent'] ?? 0);
        }, 'POST');
    }

    public function spin()
    {
        $this->prize_json(function () {
            $this->prizes->rate_limit('spin.ip', $this->input->ip_address(), 60);
            return $this->prizes->spin($this->input->post('token'));
        }, 'POST');
    }

    public function result()
    {
        $this->prize_json(function () {
            $this->prizes->rate_limit('result.ip', $this->input->ip_address(), 120);
            return $this->prizes->result_or_claim($this->input->post('token'));
        }, 'POST');
    }

    public function claim()
    {
        $this->prize_json(function () {
            $this->prizes->rate_limit('claim.ip', $this->input->ip_address(), 30);
            return $this->prizes->result_or_claim($this->input->post('token'), true);
        }, 'POST');
    }
}
