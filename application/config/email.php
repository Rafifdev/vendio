<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Email & SMTP Configuration (Brevo)
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

$config['useragent']        = 'Vendio';
$config['protocol']         = 'smtp';
$config['smtp_host']        = $env_vars['SMTP_HOST'] ?? getenv('SMTP_HOST') ?: 'smtp-relay.brevo.com';
$config['smtp_port']        = (int)($env_vars['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: 587);
$config['smtp_crypto']      = $env_vars['SMTP_CRYPTO'] ?? getenv('SMTP_CRYPTO') ?: 'tls';
$config['smtp_user']        = $env_vars['SMTP_USER'] ?? getenv('SMTP_USER') ?: '';
$config['smtp_pass']        = $env_vars['SMTP_PASS'] ?? getenv('SMTP_PASS') ?: '';
$config['smtp_timeout']     = 15;
$config['smtp_keepalive']   = FALSE;
$config['mailtype']         = 'html';
$config['charset']          = 'utf-8';
$config['validate']         = FALSE;
$config['priority']         = 3;
$config['newline']          = "\r\n";
$config['crlf']             = "\r\n";
$config['wordwrap']         = TRUE;

// Pengirim default
$config['from_email']       = $env_vars['SMTP_FROM_EMAIL'] ?? getenv('SMTP_FROM_EMAIL') ?: 'no-reply@vendio.id';
$config['from_name']        = $env_vars['SMTP_FROM_NAME'] ?? getenv('SMTP_FROM_NAME') ?: 'Vendio';
