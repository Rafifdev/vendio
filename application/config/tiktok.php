<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| TikTok Shop Partner API Configuration
|--------------------------------------------------------------------------
| Membaca konfigurasi dari file .env di root project jika tersedia,
| atau menggunakan fallback nilai di bawah ini.
*/

$env_vars = [];
$env_file = FCPATH . '.env';
if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, '#') === 0 || strpos($line, '=') === false) {
            continue;
        }
        list($key, $val) = explode('=', $line, 2);
        $key = trim($key);
        $val = trim(trim($val), "\"'");
        $env_vars[$key] = $val;
    }
}

$config['tiktok_app_key']          = $env_vars['APP_KEY_TIKTOK'] ?? getenv('APP_KEY_TIKTOK') ?: '';
$config['tiktok_app_secret']       = $env_vars['APP_SECRET_TIKTOK'] ?? getenv('APP_SECRET_TIKTOK') ?: '';
$config['tiktok_service_id']       = $env_vars['SERVICE_ID_TIKTOK'] ?? getenv('SERVICE_ID_TIKTOK') ?: '7680742124664948500';
$config['tiktok_custom_auth_url']  = $env_vars['AUTH_URL_TIKTOK'] ?? getenv('AUTH_URL_TIKTOK') ?: 'https://services.tiktokshop.com/open/authorize?service_id=7680742124664948500';

// Endpoint URL
$config['tiktok_auth_base_url']    = 'https://auth.tiktok-shops.com';
$config['tiktok_api_base_url']     = 'https://open-api.tiktokglobalshop.com';
$config['tiktok_auth_url']         = 'https://services.tiktokshop.com/open/authorize';
$config['tiktok_redirect_uri']     = function_exists('site_url') ? site_url('administrator/tiktok_shops/callback') : 'http://localhost/vendio/administrator/tiktok_shops/callback';

// Default Region
$config['tiktok_default_region']   = 'ID';
