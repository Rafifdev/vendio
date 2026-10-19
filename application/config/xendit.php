<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Xendit Payment Gateway Configuration
|--------------------------------------------------------------------------
| Membaca konfigurasi dari file .env di root project.
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

$config['xendit_secret_key']       = $env_vars['XENDIT_SECRET_KEY'] ?? getenv('XENDIT_SECRET_KEY') ?: '';
$config['xendit_public_key']       = $env_vars['XENDIT_PUBLIC_KEY'] ?? getenv('XENDIT_PUBLIC_KEY') ?: '';
$config['xendit_webhook_token']    = $env_vars['XENDIT_WEBHOOK_TOKEN'] ?? getenv('XENDIT_WEBHOOK_TOKEN') ?: '';
$config['xendit_is_production']    = ($env_vars['XENDIT_IS_PRODUCTION'] ?? getenv('XENDIT_IS_PRODUCTION')) === 'true';
$config['xendit_invoice_duration'] = 86400; // 24 jam dalam detik
$config['xendit_api_base_url']     = 'https://api.xendit.co';
