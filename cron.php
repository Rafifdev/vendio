<?php
/**
 * Vendio TikTok Shop Auto-Sync CLI Runner
 *
 * Jalankan via CLI:
 *   php cron.php [job_name]
 *
 * Pilihan job_name:
 *   - pull_orders               : Tarik pesanan baru & detail order_items (interval 2-5 menit)
 *   - pull_packages             : Tarik paket pengiriman & tracking (interval 5 menit)
 *   - pull_returns_cancellations: Tarik retur & pembatalan pesanan (interval 5-10 menit)
 *   - refresh_token             : Perbarui access token toko (interval 12 jam)
 *   - pull_statements           : Tarik statement, penarikan & dana tertahan (harian)
 *   - sync_products             : Tarik katalog produk & varian
 *   - sync_all                  : Menjalankan semua job di atas (default)
 */

if (php_sapi_name() !== 'cli' && !isset($_GET['run_cron'])) {
    echo "Akses hanya diperbolehkan melalui CLI atau HTTP dengan parameter ?run_cron=1&job=[job_name]\n";
    exit(1);
}

define('CRON_RUNNER', true);
chdir(__DIR__);

// Load Composer Autoloader
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

$job = 'sync_all';
if (php_sapi_name() === 'cli' && isset($argv[1]) && !empty($argv[1])) {
    $job = trim($argv[1]);
} elseif (isset($_GET['job']) && !empty($_GET['job'])) {
    $job = trim($_GET['job']);
}

$valid_jobs = [
    'pull_orders',
    'pull_packages',
    'pull_returns_cancellations',
    'refresh_token',
    'pull_statements',
    'sync_products',
    'sync_all'
];

if (!in_array($job, $valid_jobs)) {
    echo "[ERROR] Job '{$job}' tidak dikenal.\n";
    echo "Pilihan job yang valid:\n";
    foreach ($valid_jobs as $vj) {
        echo " - {$vj}\n";
    }
    exit(1);
}

// Set CLI Environment Variables untuk CodeIgniter URI Routing
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
$_SERVER['argv'] = ['index.php', 'cron', $job];
$_SERVER['argc'] = 3;

require_once __DIR__ . '/index.php';
