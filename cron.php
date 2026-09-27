<?php
/**
 * Vendio TikTok Shop Auto-Sync CLI Runner
 *
 * Jalankan via CLI:
 *   php cron.php
 *
 * Interval rekomendasi: Setiap 12 menit sekali
 */

// Pastikan hanya bisa dijalankan via CLI
if (php_sapi_name() !== 'cli' && !isset($_GET['run_cron'])) {
    echo "Akses CLI atau gunakan parameter ?run_cron=1\n";
    exit(1);
}

define('CRON_RUNNER', true);

// Set directory ke root project
chdir(__DIR__);

// Load bootstrap CodeIgniter
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['argv'] = ['index.php', 'cron', 'sync_all'];
$_SERVER['argc'] = 3;

require_once __DIR__ . '/index.php';
$ci =& get_instance();
ob_end_clean();

// Jalankan sync_all melalui instance controller Cron
if (!class_exists('Cron')) {
    if (file_exists(__DIR__ . '/modules/cron/controllers/Cron.php')) {
        require_once __DIR__ . '/modules/cron/controllers/Cron.php';
    } elseif (file_exists(__DIR__ . '/application/controllers/Cron.php')) {
        require_once __DIR__ . '/application/controllers/Cron.php';
    }
}

$cron = new Cron();
$cron->sync_all();
