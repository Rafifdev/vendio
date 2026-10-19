<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Xendit Library for Vendio SaaS
 *
 * Lightweight, PHP 7.2-compatible client for Xendit Invoices (Hosted Checkout) API.
 */
class Xendit_lib
{
    /**
     * @var object
     */
    protected $ci;
    protected $secret_key;
    protected $public_key;
    protected $webhook_token;
    protected $is_production;
    protected $api_base_url;
    protected $default_duration;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('xendit', TRUE);

        $cfg = $this->ci->config->item('xendit');
        $this->secret_key       = !empty($cfg['xendit_secret_key']) ? trim($cfg['xendit_secret_key']) : '';
        $this->public_key       = !empty($cfg['xendit_public_key']) ? trim($cfg['xendit_public_key']) : '';
        $this->webhook_token    = !empty($cfg['xendit_webhook_token']) ? trim($cfg['xendit_webhook_token']) : '';
        $this->is_production    = !empty($cfg['xendit_is_production']);
        $this->api_base_url     = !empty($cfg['xendit_api_base_url']) ? rtrim($cfg['xendit_api_base_url'], '/') : 'https://api.xendit.co';
        $this->default_duration = !empty($cfg['xendit_invoice_duration']) ? (int)$cfg['xendit_invoice_duration'] : 86400;
    }

    /**
     * Get configured Secret Key
     *
     * @return string
     */
    public function get_secret_key()
    {
        return $this->secret_key;
    }

    /**
     * Check if Secret Key is configured
     *
     * @return bool
     */
    public function is_configured()
    {
        return !empty($this->secret_key);
    }

    /**
     * Verify incoming webhook verification token
     *
     * @param string $incoming_token
     * @return bool
     */
    public function verify_webhook_token($incoming_token)
    {
        // Jika token belum di-set di .env, kita izinkan (terutama saat masa testing sandbox)
        if (empty($this->webhook_token)) {
            return true;
        }

        return hash_equals($this->webhook_token, trim((string)$incoming_token));
    }

    /**
     * Create an Invoice (Xendit Hosted Checkout)
     *
     * @param array $params
     * @return array ['success' => bool, 'data' => array|null, 'message' => string, 'raw' => string]
     */
    public function create_invoice(array $params)
    {
        if (!$this->is_configured()) {
            return [
                'success' => false,
                'message' => 'Xendit Secret Key belum dikonfigurasi di file .env.',
                'data'    => null,
                'raw'     => ''
            ];
        }

        if (empty($params['external_id']) || empty($params['amount'])) {
            return [
                'success' => false,
                'message' => 'Parameter external_id dan amount wajib diisi.',
                'data'    => null,
                'raw'     => ''
            ];
        }

        if (empty($params['invoice_duration'])) {
            $params['invoice_duration'] = $this->default_duration;
        }

        if (empty($params['currency'])) {
            $params['currency'] = 'IDR';
        }

        $endpoint = '/v2/invoices';
        return $this->request('POST', $endpoint, $params);
    }

    /**
     * Get Invoice details by Xendit Invoice ID
     *
     * @param string $invoice_id
     * @return array
     */
    public function get_invoice($invoice_id)
    {
        if (!$this->is_configured()) {
            return [
                'success' => false,
                'message' => 'Xendit Secret Key belum dikonfigurasi.',
                'data'    => null,
                'raw'     => ''
            ];
        }

        $endpoint = '/v2/invoices/' . rawurlencode($invoice_id);
        return $this->request('GET', $endpoint);
    }

    /**
     * Expire an active invoice
     *
     * @param string $invoice_id
     * @return array
     */
    public function expire_invoice($invoice_id)
    {
        if (!$this->is_configured()) {
            return [
                'success' => false,
                'message' => 'Xendit Secret Key belum dikonfigurasi.',
                'data'    => null,
                'raw'     => ''
            ];
        }

        $endpoint = '/invoices/' . rawurlencode($invoice_id) . '/expire!';
        return $this->request('POST', $endpoint);
    }

    /**
     * Perform HTTP request to Xendit API using cURL
     *
     * @param string $method GET|POST
     * @param string $endpoint API path
     * @param array $payload Request body
     * @return array
     */
    protected function request($method, $endpoint, array $payload = [])
    {
        $url = $this->api_base_url . $endpoint;
        $ch = curl_init();

        $headers = [
            'Authorization: Basic ' . base64_encode($this->secret_key . ':'),
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($payload)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            }
        } elseif (strtoupper($method) === 'GET' && !empty($payload)) {
            $url .= '?' . http_build_query($payload);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            log_message('error', '[Xendit] cURL error: ' . $curl_error);
            return [
                'success' => false,
                'message' => 'Gagal menghubungi server Xendit: ' . $curl_error,
                'data'    => null,
                'http_code' => 0,
                'raw'     => ''
            ];
        }

        $decoded = json_decode($response, true);

        if ($http_code >= 200 && $http_code < 300) {
            return [
                'success'   => true,
                'message'   => 'Berhasil',
                'data'      => $decoded,
                'http_code' => $http_code,
                'raw'       => $response
            ];
        }

        $err_msg = $decoded['message'] ?? ($decoded['error_code'] ?? 'Terjadi kesalahan dari Xendit (HTTP ' . $http_code . ')');
        if (!empty($decoded['errors']) && is_array($decoded['errors'])) {
            $details = [];
            foreach ($decoded['errors'] as $err_item) {
                if (!empty($err_item['messages'])) {
                    $details[] = implode(', ', (array)$err_item['messages']);
                }
            }
            if (!empty($details)) {
                $err_msg .= ' (' . implode('; ', $details) . ')';
            }
        }
        log_message('error', '[Xendit] API error: ' . $err_msg . ' | Response: ' . $response);

        return [
            'success'   => false,
            'message'   => $err_msg,
            'data'      => $decoded,
            'http_code' => $http_code,
            'raw'       => $response
        ];
    }
}
