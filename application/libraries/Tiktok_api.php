<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * TikTok Shop Partner API Client Library
 * 
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Config $config
 */
class Tiktok_api
{
    protected $CI;
    protected $auth_base_url;
    protected $api_base_url;
    protected $default_app_key;
    protected $default_app_secret;
    protected $redirect_uri;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->config('tiktok', TRUE);
        $this->CI->load->database();

        $config = $this->CI->config->item('tiktok');
        $this->auth_base_url      = $config['tiktok_auth_base_url'] ?? 'https://auth.tiktok-shops.com';
        $this->api_base_url       = $config['tiktok_api_base_url'] ?? 'https://auth.tiktok-shops.com';
        $this->default_app_key    = $config['tiktok_app_key'] ?? '';
        $this->default_app_secret = $config['tiktok_app_secret'] ?? '';
        $this->redirect_uri       = $config['tiktok_redirect_uri'] ?? site_url('administrator/tiktok/callback');
    }

    /**
     * Ambil data kredensial toko dari database
     * @param int|string|null $shop_identifier ID toko atau shop_cipher
     * @return object|null
     */
    public function get_shop($shop_identifier = null)
    {
        if ($shop_identifier) {
            $this->CI->db->group_start();
            $this->CI->db->where('id', $shop_identifier);
            $this->CI->db->or_where('shop_id', $shop_identifier);
            $this->CI->db->or_where('shop_cipher', $shop_identifier);
            $this->CI->db->group_end();
        } else {
            $this->CI->db->where('is_active', 1);
            $this->CI->db->order_by('id', 'DESC');
        }

        return $this->CI->db->get('tiktok_shops')->row();
    }

    /**
     * Generate URL Otorisasi Seller (OAuth)
     */
    public function get_auth_url($service_id = null, $state = '')
    {
        $config = $this->CI->config->item('tiktok');
        if (!empty($config['tiktok_custom_auth_url'])) {
            return $config['tiktok_custom_auth_url'];
        }

        $auth_url = $config['tiktok_auth_url'] ?? 'https://services.tiktokshop.com/open/authorize';
        $service_id = $service_id ?: ($config['tiktok_service_id'] ?? '');

        $params = [
            'service_id' => $service_id,
            'state'      => $state ?: md5(uniqid(rand(), true)),
        ];

        return $auth_url . '?' . http_build_query($params);
    }

    /**
     * Exchange auth_code untuk mendapatkan access_token & refresh_token
     * Endpoint: GET /api/v2/token/get
     */
    public function get_access_token($auth_code, $app_key = null, $app_secret = null)
    {
        $app_key    = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $url = rtrim($this->auth_base_url, '/') . '/api/v2/token/get';
        $params = [
            'app_key'    => $app_key,
            'app_secret' => $app_secret,
            'auth_code'  => $auth_code,
            'grant_type' => 'authorized_code',
        ];

        return $this->http_request('GET', $url . '?' . http_build_query($params));
    }

    /**
     * Refresh access_token yang kadaluarsa menggunakan refresh_token
     * Endpoint: GET /api/v2/token/refresh
     */
    public function refresh_access_token($refresh_token, $app_key = null, $app_secret = null)
    {
        $app_key    = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $url = rtrim($this->auth_base_url, '/') . '/api/v2/token/refresh';
        $params = [
            'app_key'       => $app_key,
            'app_secret'    => $app_secret,
            'refresh_token' => $refresh_token,
            'grant_type'    => 'refresh_token',
        ];

        return $this->http_request('GET', $url . '?' . http_build_query($params));
    }

    /**
     * Ambil daftar toko terotorisasi dan shop_cipher
     * Endpoint: GET /authorization/202309/shops
     */
    public function get_authorized_shops($access_token, $app_key = null, $app_secret = null)
    {
        $app_key    = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $path = '/authorization/202309/shops';
        $url = rtrim($this->api_base_url, '/') . $path;

        $params = [
            'app_key'   => $app_key,
            'timestamp' => time(),
        ];

        // Hitung signature jika dibutuhkan
        if (!empty($app_secret)) {
            $params['sign'] = $this->generate_signature($path, $params, null, $app_secret);
        }

        $headers = [
            'Content-Type: application/json',
            'x-tts-access-token: ' . $access_token,
        ];

        return $this->http_request('GET', $url . '?' . http_build_query($params), null, $headers);
    }

    /**
     * Generate HMAC-SHA256 signature sesuai spesifikasi TikTok Partner API
     */
    public function generate_signature($path, array $params = [], $body = null, $app_secret = '')
    {
        // 1. Keluarkan parameter 'sign' dan 'access_token' jika ada
        unset($params['sign'], $params['access_token']);

        // 2. Urutkan parameter berdasarkan key secara ascending (alfabetis)
        ksort($params);

        // 3. Susun string untuk di-hash: app_secret + path + key1val1key2val2... + [body] + app_secret
        $string_to_sign = $app_secret . $path;

        foreach ($params as $k => $v) {
            if ($v !== null && $v !== '') {
                $string_to_sign .= $k . $v;
            }
        }

        if (!empty($body)) {
            $body_string = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string)$body;
            $string_to_sign .= $body_string;
        }

        $string_to_sign .= $app_secret;

        // 4. Hitung HMAC-SHA256
        return hash_hmac('sha256', $string_to_sign, $app_secret);
    }

    /**
     * Generic API caller dengan token checking, auto-refresh token, signing, dan handling respon
     *
     * @param string $path Endpoint path (contoh: '/order/202309/orders/search')
     * @param string $method GET, POST, PUT, DELETE
     * @param array $params Query parameters
     * @param array|null $body Request Body (JSON)
     * @param int|string|null $shop_identifier ID toko atau shop_cipher
     * @return array
     */
    public function request($path, $method = 'GET', array $params = [], $body = null, $shop_identifier = null)
    {
        $shop = $this->get_shop($shop_identifier);

        if (!$shop) {
            return [
                'success' => false,
                'code'    => -1,
                'message' => 'Toko TikTok belum terhubung atau tidak ditemukan.',
                'data'    => null
            ];
        }

        $app_key    = $shop->app_key ?: $this->default_app_key;
        $app_secret = $shop->app_secret ?: $this->default_app_secret;

        // Cek jika token sudah kadaluarsa (atau tersisa < 5 menit), lakukan auto-refresh
        if ($shop->access_token_expire_in && ($shop->access_token_expire_in - 300) < time()) {
            if (!empty($shop->refresh_token)) {
                $refresh_result = $this->refresh_access_token($shop->refresh_token, $app_key, $app_secret);
                if (isset($refresh_result['code']) && $refresh_result['code'] === 0 && !empty($refresh_result['data']['access_token'])) {
                    $new_data = $refresh_result['data'];
                    $this->CI->db->where('id', $shop->id)->update('tiktok_shops', [
                        'access_token'            => $new_data['access_token'],
                        'access_token_expire_in'  => $new_data['access_token_expire_in'],
                        'refresh_token'           => $new_data['refresh_token'],
                        'refresh_token_expire_in' => $new_data['refresh_token_expire_in'],
                        'updated_at'              => date('Y-m-d H:i:s'),
                    ]);
                    $shop->access_token = $new_data['access_token'];
                }
            }
        }

        // Susun parameter standar
        $params['app_key']   = $app_key;
        $params['timestamp'] = time();

        if (!empty($shop->shop_cipher) && !isset($params['shop_cipher'])) {
            $params['shop_cipher'] = $shop->shop_cipher;
        }

        // Generate Signature
        $params['sign'] = $this->generate_signature($path, $params, $body, $app_secret);

        $url = rtrim($this->api_base_url, '/') . $path . '?' . http_build_query($params);

        $headers = [
            'Content-Type: application/json',
            'x-tts-access-token: ' . $shop->access_token,
        ];

        return $this->http_request($method, $url, $body, $headers);
    }

    /**
     * Simpan atau update data token toko ke database
     */
    public function save_token_response(array $token_data, $app_key = null, $app_secret = null, $auth_code = null)
    {
        $app_key    = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $existing = null;
        if (!empty($token_data['open_id'])) {
            $existing = $this->CI->db->get_where('tiktok_shops', ['open_id' => $token_data['open_id']])->row();
        }

        $shop_info = [
            'app_key'                 => $app_key,
            'app_secret'              => $app_secret,
            'auth_code'               => $auth_code,
            'access_token'            => $token_data['access_token'] ?? '',
            'access_token_expire_in'  => $token_data['access_token_expire_in'] ?? null,
            'refresh_token'           => $token_data['refresh_token'] ?? '',
            'refresh_token_expire_in' => $token_data['refresh_token_expire_in'] ?? null,
            'open_id'                 => $token_data['open_id'] ?? null,
            'seller_name'             => $token_data['seller_name'] ?? null,
            'seller_base_region'      => $token_data['seller_base_region'] ?? 'ID',
            'is_active'               => 1,
            'updated_at'              => date('Y-m-d H:i:s'),
        ];

        // Ambil info toko dan shop_cipher
        $shops_resp = $this->get_authorized_shops($shop_info['access_token'], $app_key, $app_secret);
        if (!empty($shops_resp['data']['shops'][0])) {
            $first_shop = $shops_resp['data']['shops'][0];
            $shop_info['shop_id']     = $first_shop['id'] ?? null;
            $shop_info['shop_name']   = $first_shop['name'] ?? $shop_info['seller_name'];
            $shop_info['shop_code']   = $first_shop['code'] ?? null;
            $shop_info['shop_cipher'] = $first_shop['cipher'] ?? null;
            $shop_info['seller_type'] = $first_shop['seller_type'] ?? 'LOCAL';
        }

        if ($existing) {
            $this->CI->db->where('id', $existing->id)->update('tiktok_shops', $shop_info);
            return $existing->id;
        } else {
            $shop_info['created_at'] = date('Y-m-d H:i:s');
            $this->CI->db->insert('tiktok_shops', $shop_info);
            return $this->CI->db->insert_id();
        }
    }

    /**
     * HTTP Request executor menggunakan cURL
     */
    protected function http_request($method, $url, $body = null, array $headers = [])
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
        ];

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if (!empty($body)) {
            $payload = is_array($body) ? json_encode($body) : $body;
            $options[CURLOPT_POSTFIELDS] = $payload;
        }

        curl_setopt_array($ch, $options);

        $response   = curl_exec($ch);
        $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            return [
                'success' => false,
                'code'    => -1,
                'message' => 'cURL Error: ' . $curl_error,
                'data'    => null,
                'raw'     => null
            ];
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'code'    => $http_code,
                'message' => 'Invalid JSON response from server',
                'data'    => null,
                'raw'     => $response
            ];
        }

        $is_success = isset($decoded['code']) && $decoded['code'] === 0;

        return [
            'success' => $is_success,
            'code'    => $decoded['code'] ?? $http_code,
            'message' => $decoded['message'] ?? 'OK',
            'data'    => $decoded['data'] ?? null,
            'request_id' => $decoded['request_id'] ?? null,
            'raw'     => $response
        ];
    }
}
