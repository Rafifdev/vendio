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

        // Generate Signature dengan payload body yang konsisten
        $body_string = null;
        if ($body !== null) {
            $body_string = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string)$body;
        }

        $params['sign'] = $this->generate_signature($path, $params, $body_string, $app_secret);

        $url = rtrim($this->api_base_url, '/') . $path . '?' . http_build_query($params);

        $headers = [
            'Content-Type: application/json',
            'x-tts-access-token: ' . $shop->access_token,
        ];

        return $this->http_request($method, $url, $body_string, $headers);
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
            $payload = is_array($body) ? json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $body;
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

        $app_key    = $shop->app_key ?: $this->default_app_key;
        $app_secret = $shop->app_secret ?: $this->default_app_secret;

        $path   = '/product/202309/images/upload';
        $params = [
            'app_key'   => $app_key,
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
     * Ambil daftar kategori produk TikTok
     * GET /product/202309/categories
     */
    public function get_categories(array $params = [], $shop_identifier = null)
    {
        $params['category_version'] = $params['category_version'] ?? 'v2';
        return $this->request('/product/202309/categories', 'GET', $params, null, $shop_identifier);
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
}

