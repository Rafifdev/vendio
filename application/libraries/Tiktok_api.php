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
        $this->auth_base_url = $config['tiktok_auth_base_url'] ?? 'https://auth.tiktok-shops.com';
        $this->api_base_url = $config['tiktok_api_base_url'] ?? 'https://open-api.tiktokglobalshop.com';
        $this->default_app_key = $config['tiktok_app_key'] ?? '';
        $this->default_app_secret = $config['tiktok_app_secret'] ?? '';
        $this->redirect_uri = $config['tiktok_redirect_uri'] ?? site_url('administrator/tiktok/callback');
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
            'state' => $state ?: md5(uniqid(rand(), true)),
        ];

        return $auth_url . '?' . http_build_query($params);
    }

    /**
     * Exchange auth_code untuk mendapatkan access_token & refresh_token
     * Endpoint: GET /api/v2/token/get
     */
    public function get_access_token($auth_code, $app_key = null, $app_secret = null)
    {
        $app_key = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $url = rtrim($this->auth_base_url, '/') . '/api/v2/token/get';
        $params = [
            'app_key' => $app_key,
            'app_secret' => $app_secret,
            'auth_code' => $auth_code,
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
        $app_key = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $url = rtrim($this->auth_base_url, '/') . '/api/v2/token/refresh';
        $params = [
            'app_key' => $app_key,
            'app_secret' => $app_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ];

        return $this->http_request('GET', $url . '?' . http_build_query($params));
    }

    /**
     * Ambil daftar toko terotorisasi dan shop_cipher
     * Endpoint: GET /authorization/202309/shops
     */
    public function get_authorized_shops($access_token, $app_key = null, $app_secret = null)
    {
        $app_key = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $path = '/authorization/202309/shops';
        $url = rtrim($this->api_base_url, '/') . $path;

        $params = [
            'app_key' => $app_key,
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
            $body_string = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string) $body;
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
                'code' => -1,
                'message' => 'Toko TikTok belum terhubung atau tidak ditemukan.',
                'data' => null
            ];
        }

        $app_key = $shop->app_key ?: $this->default_app_key;
        $app_secret = $shop->app_secret ?: $this->default_app_secret;

        // Cek jika token sudah kadaluarsa (atau tersisa < 5 menit), lakukan auto-refresh
        if ($shop->access_token_expire_in && ($shop->access_token_expire_in - 300) < time()) {
            if (!empty($shop->refresh_token)) {
                $refresh_result = $this->refresh_access_token($shop->refresh_token, $app_key, $app_secret);
                if (isset($refresh_result['code']) && $refresh_result['code'] === 0 && !empty($refresh_result['data']['access_token'])) {
                    $new_data = $refresh_result['data'];
                    $this->CI->db->where('id', $shop->id)->update('tiktok_shops', [
                        'access_token' => $new_data['access_token'],
                        'access_token_expire_in' => $new_data['access_token_expire_in'],
                        'refresh_token' => $new_data['refresh_token'],
                        'refresh_token_expire_in' => $new_data['refresh_token_expire_in'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $shop->access_token = $new_data['access_token'];
                }
            }
        }

        // Susun parameter standar
        $params['app_key'] = $app_key;
        $params['timestamp'] = time();

        if (!empty($shop->shop_cipher) && !isset($params['shop_cipher'])) {
            $params['shop_cipher'] = $shop->shop_cipher;
        }

        // Generate Signature dengan payload body yang konsisten
        $body_string = null;
        if ($body !== null) {
            $body_string = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string) $body;
        }

        $params['sign'] = $this->generate_signature($path, $params, $body_string, $app_secret);

        $url = rtrim($this->api_base_url, '/') . $path . '?' . http_build_query($params);

        $headers = [
            'Content-Type: application/json',
            'x-tts-access-token: ' . $shop->access_token,
        ];

        $start_time = microtime(true);
        $result = $this->http_request($method, $url, $body_string, $headers);
        $duration_ms = (int) round((microtime(true) - $start_time) * 1000);

        // Logging ke tabel tiktok_api_logs sesuai PRD Bab 7.1
        $this->log_api_call(
            $shop->id,
            $path,
            $method,
            $body_string ?: json_encode($params),
            $result['raw'] ?? json_encode($result),
            $result['http_status'] ?? ($result['code'] ?? 200),
            $result['success'] ?? false,
            $duration_ms
        );

        return $result;
    }

    /**
     * Simpan atau update data token toko ke database
     */
    public function save_token_response(array $token_data, $app_key = null, $app_secret = null, $auth_code = null)
    {
        $app_key = $app_key ?: $this->default_app_key;
        $app_secret = $app_secret ?: $this->default_app_secret;

        $existing = null;
        if (!empty($token_data['open_id'])) {
            $existing = $this->CI->db->get_where('tiktok_shops', ['open_id' => $token_data['open_id']])->row();
        }

        $shop_info = [
            'app_key' => $app_key,
            'app_secret' => $app_secret,
            'auth_code' => $auth_code,
            'access_token' => $token_data['access_token'] ?? '',
            'access_token_expire_in' => $token_data['access_token_expire_in'] ?? null,
            'refresh_token' => $token_data['refresh_token'] ?? '',
            'refresh_token_expire_in' => $token_data['refresh_token_expire_in'] ?? null,
            'open_id' => $token_data['open_id'] ?? null,
            'seller_name' => $token_data['seller_name'] ?? null,
            'seller_base_region' => $token_data['seller_base_region'] ?? 'ID',
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Ambil info toko dan shop_cipher
        $shops_resp = $this->get_authorized_shops($shop_info['access_token'], $app_key, $app_secret);
        if (!empty($shops_resp['data']['shops'][0])) {
            $first_shop = $shops_resp['data']['shops'][0];
            $shop_info['shop_id'] = $first_shop['id'] ?? null;
            $shop_info['shop_name'] = $first_shop['name'] ?? $shop_info['seller_name'];
            $shop_info['shop_code'] = $first_shop['code'] ?? null;
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
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_TCP_KEEPALIVE => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
        ];

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if (!empty($body)) {
            $payload = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $body;
            $options[CURLOPT_POSTFIELDS] = $payload;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            return [
                'success' => false,
                'code' => -1,
                'message' => 'cURL Error: ' . $curl_error,
                'data' => null,
                'raw' => null
            ];
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'code' => $http_code,
                'message' => 'Invalid JSON response from server',
                'data' => null,
                'raw' => $response
            ];
        }

        $is_success = isset($decoded['code']) && $decoded['code'] === 0;

        return [
            'success' => $is_success,
            'code' => $decoded['code'] ?? $http_code,
            'http_status' => $http_code,
            'message' => $decoded['message'] ?? 'OK',
            'data' => $decoded['data'] ?? null,
            'request_id' => $decoded['request_id'] ?? null,
            'raw' => $response
        ];
    }

    /**
     * Eksekusi request API TikTok secara paralel (Non-blocking cURL Multi)
     * Menghemat waktu tunggu hingga 90% saat sinkronisasi banyak data
     *
     * @param array $requests Array item: [ key => [ 'path' => ..., 'method' => 'GET'/'POST', 'params' => [...], 'body' => [...] ] ]
     * @param mixed $shop_identifier ID Toko
     * @param int $concurrency Batas maksimal koneksi simultan (default 10)
     * @return array [ key => decoded_response_array ]
     */
    public function multi_request(array $requests, $shop_identifier = null, $concurrency = 10)
    {
        if (empty($requests)) {
            return [];
        }

        $shop = $this->get_shop($shop_identifier);
        if (!$shop) {
            return [];
        }

        $app_key = $shop->app_key ?: $this->default_app_key;
        $app_secret = $shop->app_secret ?: $this->default_app_secret;

        // Auto-refresh token jika perlu
        if ($shop->access_token_expire_in && ($shop->access_token_expire_in - 300) < time()) {
            if (!empty($shop->refresh_token)) {
                $refresh_result = $this->refresh_access_token($shop->refresh_token, $app_key, $app_secret);
                if (isset($refresh_result['code']) && $refresh_result['code'] === 0 && !empty($refresh_result['data']['access_token'])) {
                    $new_data = $refresh_result['data'];
                    $this->CI->db->where('id', $shop->id)->update('tiktok_shops', [
                        'access_token' => $new_data['access_token'],
                        'access_token_expire_in' => $new_data['access_token_expire_in'],
                        'refresh_token' => $new_data['refresh_token'],
                        'refresh_token_expire_in' => $new_data['refresh_token_expire_in'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $shop->access_token = $new_data['access_token'];
                }
            }
        }

        $results = [];
        $mh = curl_multi_init();
        $handles = [];
        $queue = array_keys($requests);
        $running = 0;

        $api_base = rtrim($this->api_base_url, '/');
        $headers = [
            'Content-Type: application/json',
            'x-tts-access-token: ' . $shop->access_token,
        ];

        $add_handle = function ($key) use (&$handles, $requests, $shop, $app_key, $app_secret, $api_base, $headers, $mh) {
            $req = $requests[$key];
            $path = $req['path'];
            $method = strtoupper($req['method'] ?? 'GET');
            $params = $req['params'] ?? [];
            $body = $req['body'] ?? null;

            $params['app_key'] = $app_key;
            $params['timestamp'] = time();
            if (!empty($shop->shop_cipher) && !isset($params['shop_cipher'])) {
                $params['shop_cipher'] = $shop->shop_cipher;
            }

            $body_string = null;
            if ($body !== null) {
                $body_string = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string) $body;
            }

            $params['sign'] = $this->generate_signature($path, $params, $body_string, $app_secret);
            $url = $api_base . $path . '?' . http_build_query($params);

            $ch = curl_init();
            $options = [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_CONNECTTIMEOUT => 7,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_ENCODING => 'gzip,deflate',
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                CURLOPT_TCP_KEEPALIVE => 1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            ];

            if (!empty($body_string)) {
                $options[CURLOPT_POSTFIELDS] = $body_string;
            }

            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $handles[(int)$ch] = ['key' => $key, 'ch' => $ch];
        };

        // Mulai koneksi awal sesuai limit $concurrency
        $initial_count = min($concurrency, count($queue));
        for ($i = 0; $i < $initial_count; $i++) {
            $key = array_shift($queue);
            $add_handle($key);
        }

        // Loop multi exec
        do {
            $mrc = curl_multi_exec($mh, $running);
            if ($mrc !== CURLM_OK) {
                break;
            }

            while ($info = curl_multi_info_read($mh)) {
                $ch = $info['handle'];
                $handle_info = $handles[(int)$ch] ?? null;
                if ($handle_info) {
                    $key = $handle_info['key'];
                    $content = curl_multi_getcontent($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $curl_err = curl_error($ch);

                    if ($curl_err) {
                        $results[$key] = [
                            'success' => false,
                            'code' => -1,
                            'message' => 'cURL Error: ' . $curl_err,
                            'data' => null,
                            'raw' => null,
                        ];
                    } else {
                        $decoded = json_decode($content, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $results[$key] = [
                                'success' => (isset($decoded['code']) && $decoded['code'] === 0),
                                'code' => $decoded['code'] ?? $http_code,
                                'http_status' => $http_code,
                                'message' => $decoded['message'] ?? 'OK',
                                'data' => $decoded['data'] ?? null,
                                'request_id' => $decoded['request_id'] ?? null,
                                'raw' => $content,
                            ];
                        } else {
                            $results[$key] = [
                                'success' => false,
                                'code' => $http_code,
                                'message' => 'Invalid JSON',
                                'data' => null,
                                'raw' => $content,
                            ];
                        }
                    }

                    curl_multi_remove_handle($mh, $ch);
                    curl_close($ch);
                    unset($handles[(int)$ch]);

                    if (!empty($queue)) {
                        $next_key = array_shift($queue);
                        $add_handle($next_key);
                    }
                }
            }

            if ($running > 0) {
                curl_multi_select($mh, 0.05);
            }
        } while ($running > 0 || !empty($handles));

        curl_multi_close($mh);
        return $results;
    }

    /**
     * Catat audit log API call ke tabel tiktok_api_logs sesuai PRD Bab 7.1
     */
    protected function log_api_call($shop_id, $endpoint, $method, $request_payload, $response_payload, $http_status, $is_success, $duration_ms)
    {
        try {
            $req = is_string($request_payload) ? $request_payload : json_encode($request_payload);
            $resp = is_string($response_payload) ? $response_payload : json_encode($response_payload);
            // Truncate jika terlalu besar agar database I/O tetap ringan dan cepat
            if (strlen($req) > 10000) {
                $req = substr($req, 0, 10000) . '... [TRUNCATED]';
            }
            if (strlen($resp) > 20000) {
                $resp = substr($resp, 0, 20000) . '... [TRUNCATED]';
            }
            $this->CI->db->insert('tiktok_api_logs', [
                'shop_id' => $shop_id,
                'endpoint' => $endpoint,
                'method' => strtoupper($method),
                'request_payload' => $req,
                'response_payload' => $resp,
                'http_status' => (int) $http_status,
                'is_success' => $is_success ? 1 : 0,
                'execution_time_ms' => (int) $duration_ms,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Exception $e) {
            log_message('error', 'Gagal mencatat log tiktok_api_logs: ' . $e->getMessage());
        }
    }

    /**
     * =========================================================================
     * PRODUCT API HELPERS (Katalog, Stok, Harga, Status)
     * =========================================================================
     */

    /**
     * Ambil / cari daftar produk dari TikTok Shop
     * POST /product/202309/products/search
     */
    public function search_products(array $body = [], array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        return $this->request('/product/202309/products/search', 'POST', $params, $body, $shop_identifier);
    }

    /**
     * Ambil detail lengkap satu produk TikTok
     * GET /product/202309/products/{product_id}
     */
    public function get_product_detail($product_id, array $params = [], $shop_identifier = null)
    {
        return $this->request('/product/202309/products/' . $product_id, 'GET', $params, null, $shop_identifier);
    }

    /**
     * Ambil rincian banyak produk secara paralel via cURL Multi (Super Cepat)
     *
     * @param array $product_ids
     * @param array $params
     * @param mixed $shop_identifier
     * @param int $concurrency
     * @return array [ product_id => response_array ]
     */
    public function get_products_details_parallel(array $product_ids, array $params = [], $shop_identifier = null, $concurrency = 10)
    {
        $product_ids = array_values(array_unique(array_filter($product_ids)));
        if (empty($product_ids)) {
            return [];
        }

        $requests = [];
        foreach ($product_ids as $pid) {
            $requests[$pid] = [
                'path' => '/product/202309/products/' . $pid,
                'method' => 'GET',
                'params' => $params,
            ];
        }

        return $this->multi_request($requests, $shop_identifier, $concurrency);
    }

    /**
     * Update stok varian produk TikTok
     * POST /product/202309/products/{product_id}/inventory/update
     */
    public function update_inventory($product_id, array $skus, $shop_identifier = null)
    {
        return $this->request('/product/202309/products/' . $product_id . '/inventory/update', 'POST', [], ['skus' => $skus], $shop_identifier);
    }

    /**
     * Update harga varian produk TikTok
     * POST /product/202309/products/{product_id}/prices/update
     */
    public function update_prices($product_id, array $skus, $shop_identifier = null)
    {
        return $this->request('/product/202309/products/' . $product_id . '/prices/update', 'POST', [], ['skus' => $skus], $shop_identifier);
    }

    /**
     * Aktifkan produk di etalase TikTok
     * POST /product/202309/products/activate
     */
    public function activate_products(array $product_ids, $shop_identifier = null)
    {
        return $this->request('/product/202309/products/activate', 'POST', [], ['product_ids' => $product_ids], $shop_identifier);
    }

    /**
     * Nonaktifkan produk dari etalase TikTok
     * POST /product/202309/products/deactivate
     */
    public function deactivate_products(array $product_ids, $shop_identifier = null)
    {
        return $this->request('/product/202309/products/deactivate', 'POST', [], ['product_ids' => $product_ids], $shop_identifier);
    }

    /**
     * Hapus produk dari TikTok Shop
     * DELETE /product/202309/products
     */
    public function delete_products(array $product_ids, $shop_identifier = null)
    {
        return $this->request('/product/202309/products', 'DELETE', [], ['product_ids' => $product_ids], $shop_identifier);
    }

    /**
     * Upload gambar produk ke TikTok Shop
     * POST /product/202309/images/upload
     */
    public function upload_image($image_path, $shop_identifier = null)
    {
        $shop = $this->get_shop($shop_identifier);
        if (!$shop) {
            return ['success' => false, 'message' => 'Toko TikTok belum terhubung.'];
        }

        $app_key = $shop->app_key ?: $this->default_app_key;
        $app_secret = $shop->app_secret ?: $this->default_app_secret;

        $path = '/product/202309/images/upload';
        $params = [
            'app_key' => $app_key,
            'timestamp' => time(),
        ];
        $params['sign'] = $this->generate_signature($path, $params, null, $app_secret);
        $url = rtrim($this->api_base_url, '/') . $path . '?' . http_build_query($params);

        $headers = [
            'x-tts-access-token: ' . $shop->access_token,
            'Content-Type: multipart/form-data',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['data' => new CURLFile($image_path)]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($res, true);
        if (isset($data['code']) && $data['code'] === 0) {
            return ['success' => true, 'data' => $data['data']];
        }
        return ['success' => false, 'message' => $data['message'] ?? 'Gagal upload gambar ke TikTok'];
    }

    /**
     * Buat produk baru di TikTok Shop
     * POST /product/202309/products
     */
    public function create_product(array $product_payload, $shop_identifier = null)
    {
        return $this->request('/product/202309/products', 'POST', ['category_version' => 'v2'], $product_payload, $shop_identifier);
    }

    /**
     * Edit / Update produk TikTok
     * PUT /product/202309/products/{product_id}
     */
    public function update_product($product_id, array $product_payload, $shop_identifier = null)
    {
        return $this->request('/product/202309/products/' . $product_id, 'PUT', ['category_version' => 'v2'], $product_payload, $shop_identifier);
    }

    /**
     * Ambil daftar gudang toko TikTok
     * GET /logistics/202309/warehouses
     */
    public function get_warehouses($shop_identifier = null)
    {
        return $this->request('/logistics/202309/warehouses', 'GET', [], null, $shop_identifier);
    }

    /**
     * Ambil opsi pengiriman untuk gudang tertentu
     * GET /logistics/202309/warehouses/{warehouse_id}/delivery_options
     */
    public function get_warehouse_delivery_options($warehouse_id, $shop_identifier = null)
    {
        return $this->request('/logistics/202309/warehouses/' . $warehouse_id . '/delivery_options', 'GET', [], null, $shop_identifier);
    }

    /**
     * Ambil daftar kurir / shipping providers untuk delivery option tertentu
     * GET /logistics/202309/delivery_options/{delivery_option_id}/shipping_providers
     */
    public function get_shipping_providers($delivery_option_id, $shop_identifier = null)
    {
        return $this->request('/logistics/202309/delivery_options/' . $delivery_option_id . '/shipping_providers', 'GET', [], null, $shop_identifier);
    }

    /**
     * Ambil daftar kategori produk TikTok
     * GET /product/202309/categories
     */
    public function get_categories(array $params = [], $shop_identifier = null)
    {
        $params['category_version'] = $params['category_version'] ?? 'v2';
        return $this->request('/product/202309/categories', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Ambil daftar atribut untuk kategori tertentu
     * GET /product/202309/categories/{category_id}/attributes
     */
    public function get_category_attributes($category_id, array $params = [], $shop_identifier = null)
    {
        $params['category_version'] = $params['category_version'] ?? 'v2';
        return $this->request('/product/202309/categories/' . $category_id . '/attributes', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Ambil daftar brand TikTok sesuai kategori
     * GET /product/202309/brands
     */
    public function get_brands($category_id = null, array $params = [], $shop_identifier = null)
    {
        $params['category_version'] = $params['category_version'] ?? 'v2';
        $params['page_size'] = $params['page_size'] ?? 100;
        if (!empty($category_id)) {
            $params['category_id'] = $category_id;
        }
        return $this->request('/product/202309/brands', 'GET', $params, null, $shop_identifier);
    }
    /**
     * =========================================================================
     * ORDER & FULFILLMENT API HELPERS (Pesanan, Pengiriman, Resi AWB)
     * =========================================================================
     */

    /**
     * Ambil / cari daftar pesanan dari TikTok Shop
     * POST /order/202309/orders/search
     */
    public function search_orders(array $body = [], array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        return $this->request('/order/202309/orders/search', 'POST', $params, $body, $shop_identifier);
    }

    /**
     * Ambil detail lengkap satu pesanan TikTok
     * GET /order/202309/orders?ids={order_id}
     */
    public function get_order_detail($order_id, array $params = [], $shop_identifier = null)
    {
        $params['ids'] = (string) $order_id;
        return $this->request('/order/202309/orders', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Ambil detail banyak pesanan sekaligus (Batch Order Details) dari TikTok Shop
     * TikTok Partner API mendukung hingga 50 order IDs dipisahkan koma dalam 1 request: GET /order/202309/orders?ids=id1,id2,id3...
     *
     * @param array $order_ids Array of order IDs
     * @param array $params Query params tambahan
     * @param mixed $shop_identifier ID Toko
     * @return array Associative array [ order_id => order_detail ]
     */
    public function get_order_details_batch(array $order_ids, array $params = [], $shop_identifier = null)
    {
        $order_ids = array_values(array_unique(array_filter($order_ids)));
        if (empty($order_ids)) {
            return [];
        }

        $results = [];
        // Chunk per 50 sesuai batas maksimum endpoint TikTok API
        $chunks = array_chunk($order_ids, 50);

        if (count($chunks) === 1) {
            $id_str = implode(',', $chunks[0]);
            $params['ids'] = $id_str;
            $res = $this->request('/order/202309/orders', 'GET', $params, null, $shop_identifier);
            if (!empty($res['data']['orders']) && is_array($res['data']['orders'])) {
                foreach ($res['data']['orders'] as $ord) {
                    if (!empty($ord['id'])) {
                        $results[$ord['id']] = $ord;
                    }
                }
            }
            return $results;
        }

        // Jika lebih dari 50 pesanan, jalankan chunk secara paralel via multi_request
        $requests = [];
        foreach ($chunks as $idx => $chunk) {
            $requests[$idx] = [
                'path' => '/order/202309/orders',
                'method' => 'GET',
                'params' => array_merge($params, ['ids' => implode(',', $chunk)]),
            ];
        }

        $multi_res = $this->multi_request($requests, $shop_identifier);
        foreach ($multi_res as $res) {
            if (!empty($res['data']['orders']) && is_array($res['data']['orders'])) {
                foreach ($res['data']['orders'] as $ord) {
                    if (!empty($ord['id'])) {
                        $results[$ord['id']] = $ord;
                    }
                }
            }
        }

        return $results;
    }

    /**
     * Ambil / cari daftar paket dari TikTok Shop
     * POST /fulfillment/202309/packages/search
     */
    public function search_packages(array $body = [], array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        return $this->request('/fulfillment/202309/packages/search', 'POST', $params, $body, $shop_identifier);
    }

    /**
     * Ambil rincian lengkap satu paket TikTok
     * GET /fulfillment/202309/packages/{package_id}
     */
    public function get_package_detail($package_id, array $params = [], $shop_identifier = null)
    {
        return $this->request('/fulfillment/202309/packages/' . $package_id, 'GET', $params, null, $shop_identifier);
    }

    /**
     * Ambil rincian banyak paket secara paralel via cURL Multi (Super Cepat)
     *
     * @param array $package_ids
     * @param array $params
     * @param mixed $shop_identifier
     * @param int $concurrency
     * @return array [ package_id => response_array ]
     */
    public function get_packages_details_parallel(array $package_ids, array $params = [], $shop_identifier = null, $concurrency = 10)
    {
        $package_ids = array_values(array_unique(array_filter($package_ids)));
        if (empty($package_ids)) {
            return [];
        }

        $requests = [];
        foreach ($package_ids as $pkg_id) {
            $requests[$pkg_id] = [
                'path' => '/fulfillment/202309/packages/' . $pkg_id,
                'method' => 'GET',
                'params' => $params,
            ];
        }

        return $this->multi_request($requests, $shop_identifier, $concurrency);
    }

    /**
     * Ambil dokumen pengiriman (Label Resi / Shipping Label AWB PDF)
     * GET /fulfillment/202309/packages/{package_id}/shipping_documents
     */
    public function get_shipping_documents($package_id, $document_type = 'SHIPPING_LABEL', array $params = [], $shop_identifier = null)
    {
        $params['document_type'] = $document_type;
        $params['document_size'] = $params['document_size'] ?? 'A6';
        return $this->request('/fulfillment/202309/packages/' . $package_id . '/shipping_documents', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Konfirmasi pengiriman paket / Handover (Drop-off / Pickup)
     * POST /fulfillment/202309/packages/{package_id}/ship
     */
    public function ship_package($package_id, array $body = [], $shop_identifier = null)
    {
        return $this->request('/fulfillment/202309/packages/' . $package_id . '/ship', 'POST', [], $body, $shop_identifier);
    }

    /**
     * Ambil pelacakan logistik kurir pesanan (Tracking Checkpoints)
     * GET /fulfillment/202309/orders/{order_id}/tracking
     */
    public function get_order_tracking($order_id, array $params = [], $shop_identifier = null)
    {
        return $this->request('/fulfillment/202309/orders/' . $order_id . '/tracking', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Batalkan pesanan TikTok Shop dari sisi penjual (Seller Cancel Order)
     * POST /return_refund/202309/cancellations
     *
     * @param string $order_id ID pesanan TikTok Shop
     * @param string $reason Alasan pembatalan (default: seller_cancel_reason_out_of_stock)
     * @param mixed $shop_identifier ID atau objek toko
     * @return array
     */
    public function cancel_order($order_id, $reason = 'seller_cancel_reason_out_of_stock', $shop_identifier = null)
    {
        $body = [
            'order_id' => (string) $order_id,
            'cancel_reason' => $reason
        ];
        return $this->request('/return_refund/202309/cancellations', 'POST', [], $body, $shop_identifier);
    }

    /**
     * =========================================================================
     * FINANCE & RETURN API HELPERS (Keuangan & Retur - Developer 3)
     * =========================================================================
     */

    /**
     * Tarik Rekap Pencairan Dana (Settlement Statements)
     * GET /finance/202309/statements
     */
    public function get_statements(array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        $params['sort_field'] = $params['sort_field'] ?? 'statement_time';
        return $this->request('/finance/202309/statements', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Tarik Rincian Transaksi dalam Statement Keuangan
     * GET /finance/202309/statements/{statement_id}/statement_transactions
     */
    public function get_statement_transactions($statement_id, array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 50;
        return $this->request('/finance/202309/statements/' . $statement_id . '/statement_transactions', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Tarik Riwayat Penarikan Dana (Withdrawals)
     * GET /finance/202309/withdrawals
     */
    public function get_withdrawals(array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 50;
        $params['types'] = $params['types'] ?? 'WITHDRAW';
        return $this->request('/finance/202309/withdrawals', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Tarik Riwayat Pencairan / Pembayaran ke Rekening Bank (Payments)
     * GET /finance/202309/payments
     */
    public function get_payments(array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 50;
        $params['sort_field'] = $params['sort_field'] ?? 'create_time';
        return $this->request('/finance/202309/payments', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Cari Dana Tertahan / Pesanan Belum Settle (Unsettled Orders)
     * GET /finance/202507/orders/unsettled
     */
    public function get_unsettled_transactions(array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 50;
        $params['sort_field'] = $params['sort_field'] ?? 'order_create_time';
        return $this->request('/finance/202507/orders/unsettled', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Tarik data retur / komplain customer
     * POST /return_refund/202309/returns/search
     */
    public function search_returns(array $body = [], array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        return $this->request('/return_refund/202309/returns/search', 'POST', $params, $body, $shop_identifier);
    }

    /**
     * Setujui pengajuan retur / refund dari pembeli
     * POST /return_refund/202309/returns/{return_id}/approve
     */
    public function approve_return($return_id, $decision = 'APPROVE_RETURN', $shop_identifier = null)
    {
        $body = [
            'decision' => $decision
        ];
        return $this->request('/return_refund/202309/returns/' . $return_id . '/approve', 'POST', [], $body, $shop_identifier);
    }

    /**
     * Tolak pengajuan retur / refund dari pembeli
     * POST /return_refund/202309/returns/{return_id}/reject
     */
    public function reject_return($return_id, $reject_reason = '', array $extra = [], $shop_identifier = null)
    {
        $body = array_merge([
            'decision' => 'REJECT',
            'reject_reason' => $reject_reason
        ], $extra);
        return $this->request('/return_refund/202309/returns/' . $return_id . '/reject', 'POST', [], $body, $shop_identifier);
    }

    /**
     * Ambil daftar alasan penolakan resmi (Get Reject Reasons)
     * GET /return_refund/202309/reject_reasons
     */
    public function get_reject_reasons(array $params = [], $shop_identifier = null)
    {
        return $this->request('/return_refund/202309/reject_reasons', 'GET', $params, null, $shop_identifier);
    }

    /**
     * Cari daftar pengajuan pembatalan pesanan (Search Cancellations)
     * POST /return_refund/202309/cancellations/search
     */
    public function search_cancellations(array $body = [], array $params = [], $shop_identifier = null)
    {
        $params['page_size'] = $params['page_size'] ?? 20;
        return $this->request('/return_refund/202309/cancellations/search', 'POST', $params, $body, $shop_identifier);
    }

    /**
     * Setujui pengajuan pembatalan pesanan dari pembeli
     * POST /return_refund/202309/cancellations/{cancel_id}/approve
     */
    public function approve_cancellation($cancel_id, $shop_identifier = null)
    {
        return $this->request('/return_refund/202309/cancellations/' . $cancel_id . '/approve', 'POST', [], [], $shop_identifier);
    }

    /**
     * Tolak pengajuan pembatalan pesanan dari pembeli
     * POST /return_refund/202309/cancellations/{cancel_id}/reject
     */
    public function reject_cancellation($cancel_id, $reject_reason = '', array $extra = [], $shop_identifier = null)
    {
        $body = array_merge([
            'reject_reason' => $reject_reason
        ], $extra);
        return $this->request('/return_refund/202309/cancellations/' . $cancel_id . '/reject', 'POST', [], $body, $shop_identifier);
    }
}

