<?php
$ci =& get_instance();
$shop = null;
if (!empty($shop_name)) {
  $shop = $ci->db->get_where('tiktok_shops', ['shop_name' => $shop_name])->row();
}
if (!$shop) {
  $shop = $ci->db->order_by('id', 'DESC')->get('tiktok_shops')->row();
}

$display_shop_name = !empty($shop_name) ? $shop_name : ($shop ? $shop->shop_name : 'sandbox idmetafora');
$display_shop_id   = $shop ? $shop->shop_id : '7494874560718407506';
$display_region    = ($shop && !empty($shop->seller_base_region)) ? $shop->seller_base_region : 'ID';

$expire_ts = ($shop && !empty($shop->access_token_expire_in)) ? (int)$shop->access_token_expire_in : (time() + 86400 * 7);
$display_expire    = date('d M Y, H:i');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= htmlspecialchars($page_title ?? 'Status Otorisasi TikTok Shop - Vendio'); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Core Vendio & Font Stylesheets -->
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/css/custom.css">

  <style>
    body {
      background-color: #f1f5f9;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      color: #334155;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }

    .auth-card-wrapper {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
    }

    /* Main Card with Cicool/AdminLTE Gray Border Accents */
    .auth-main-card {
      background: #ffffff;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      position: relative;
    }

    .auth-card-body {
      padding: 32px 28px 24px 28px;
      text-align: center;
    }

    /* Circular Status Icon */
    .auth-circle-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      margin-bottom: 18px;
      line-height: 1;
    }

    .icon-success-theme {
      background-color: #d1fae5;
      color: #059669;
    }

    .icon-warning-theme {
      background-color: #fef3c7;
      color: #d97706;
    }

    .icon-danger-theme {
      background-color: #fee2e2;
      color: #dc2626;
    }

    /* Headings & Descriptions */
    .auth-heading {
      font-size: 21px;
      font-weight: 700;
      color: #1e293b;
      margin: 0 0 10px 0;
      line-height: 1.25;
      letter-spacing: -0.01em;
    }

    .auth-subtext {
      font-size: 13px;
      color: #64748b;
      line-height: 1.6;
      margin: 0 auto 22px auto;
      max-width: 380px;
    }

    /* Info Box with Gray Border Accent */
    .auth-info-box {
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 4px 18px;
      margin-bottom: 0;
      text-align: left;
    }

    .auth-info-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 0;
      font-size: 13px;
    }

    .auth-info-row:not(:last-child) {
      border-bottom: 1px solid #eef2f6;
    }

    .auth-info-label {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      color: #64748b;
      font-weight: 500;
      font-size: 12.5px;
    }

    .auth-info-label i {
      width: 16px;
      text-align: center;
      color: #64748b;
      font-size: 13.5px;
    }

    .auth-info-value {
      color: #334155;
      font-weight: 600;
      font-size: 13px;
      text-align: right;
    }

    /* ID Toko Chip matching Image 2 */
    .chip-id {
      font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
      font-size: 12px;
      color: #475569;
      background: #f1f5f9;
      padding: 2px 8px;
      border-radius: 4px;
      border: 1px solid #cbd5e1;
      display: inline-block;
      font-weight: 600;
    }

    /* Status Badges */
    .badge-terhubung {
      background-color: #00a65a;
      color: #ffffff;
      font-size: 11px;
      font-weight: 600;
      padding: 3px 9px;
      border-radius: 4px;
      display: inline-block;
      letter-spacing: 0.02em;
    }

    .badge-terhubung.badge-warning {
      background-color: #f39c12;
    }

    .badge-terhubung.badge-danger {
      background-color: #dd4b39;
    }

    /* Footer Toolbar with Top Gray Border Accent matching Image 2 */
    .auth-card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 14px 24px;
      background-color: #fafbfc;
      border-top: 1px solid #e2e8f0;
    }

    .auth-secure-tag {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      color: #00a65a;
      font-weight: 600;
      font-size: 12.5px;
    }

    .auth-secure-tag.tag-warning {
      color: #d97706;
    }

    .auth-secure-tag.tag-danger {
      color: #dc2626;
    }

    .btn-selesai {
      height: 35px;
      padding: 0 16px;
      background-color: #00a65a;
      color: #ffffff;
      font-size: 12.5px;
      font-weight: 600;
      border-radius: 4px;
      border: 1px solid #008d4c;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      cursor: pointer;
      transition: all 0.15s ease;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
      text-decoration: none;
    }

    .btn-selesai:hover {
      background-color: #008d4c;
      color: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
      text-decoration: none;
    }

    .btn-selesai-default {
      background-color: #ffffff;
      border: 1px solid #cbd5e1;
      color: #334155;
    }

    .btn-selesai-default:hover {
      background-color: #f1f5f9;
      color: #1e293b;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    /* Close Hint */
    .hint-alert-box {
      display: none;
      margin-top: 14px;
      padding: 10px 14px;
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      font-size: 12px;
      color: #475569;
      text-align: center;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .auth-copyright {
      text-align: center;
      margin-top: 16px;
      font-size: 12px;
      color: #94a3b8;
    }
  </style>
</head>
<body>

  <div class="auth-card-wrapper">

    <!-- Main Card Body matching user mockup -->
    <?php if ($status == 'success'): ?>
      <div class="auth-main-card">
        
        <div class="auth-card-body">
          <!-- Top Icon -->
          <div class="auth-circle-icon icon-success-theme">
            <i class="fa fa-check"></i>
          </div>

          <!-- Heading & Description -->
          <h2 class="auth-heading">Otorisasi Berhasil!</h2>
          <p class="auth-subtext">
            Toko TikTok Shop Anda telah berhasil terhubung dengan platform Vendio. Integrasi sekarang aktif dan siap melakukan sinkronisasi data.
          </p>

          <!-- 4 Rows Info Box -->
          <div class="auth-info-box">
            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-shield"></i> Status Otorisasi
              </span>
              <span class="auth-info-value">
                <span class="badge-terhubung">Terhubung Aktif</span>
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-calendar"></i> Waktu Otorisasi
              </span>
              <span class="auth-info-value">
                <?= $display_expire; ?> WIB
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-shopping-bag"></i> Nama Toko
              </span>
              <span class="auth-info-value">
                <?= htmlspecialchars($display_shop_name); ?>
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-id-card-o"></i> ID Toko
              </span>
              <span class="auth-info-value">
                <span class="chip-id"><?= htmlspecialchars($display_shop_id); ?></span>
              </span>
            </div>
          </div>
        </div>

        <!-- Footer Row -->
        <div class="auth-card-footer">
          <div class="auth-secure-tag">
            <i class="fa fa-shield"></i> Terkoneksi Resmi
          </div>
          <button type="button" class="btn-selesai" onclick="handleClosePage(this);">
            <i class="fa fa-check"></i> Selesai & Tutup Halaman
          </button>
        </div>

      </div>

    <?php elseif ($status == 'already_used'): ?>
      <div class="auth-main-card">
        
        <div class="auth-card-body">
          <div class="auth-circle-icon icon-warning-theme">
            <i class="fa fa-lock"></i>
          </div>

          <h2 class="auth-heading">Tautan Sudah Digunakan</h2>
          <p class="auth-subtext">
            Tautan otorisasi ini bersifat sekali pakai (one-time link) dan sudah pernah digunakan sebelumnya untuk menghubungkan toko.
          </p>

          <div class="auth-info-box">
            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-info-circle"></i> Status Tautan
              </span>
              <span class="auth-info-value">
                <span class="badge-terhubung badge-warning">Sudah Digunakan</span>
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-calendar"></i> Waktu Akses
              </span>
              <span class="auth-info-value">
                <?= date('d M Y, H:i'); ?> WIB
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-shield"></i> Proteksi Sistem
              </span>
              <span class="auth-info-value">
                1 Tautan = 1 Toko
              </span>
            </div>
          </div>
        </div>

        <div class="auth-card-footer">
          <div class="auth-secure-tag tag-warning">
            <i class="fa fa-info-circle"></i> Link Expired
          </div>
          <button type="button" class="btn-selesai btn-selesai-default" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
        </div>

      </div>

    <?php elseif ($status == 'expired'): ?>
      <div class="auth-main-card">
        
        <div class="auth-card-body">
          <div class="auth-circle-icon icon-danger-theme">
            <i class="fa fa-clock-o"></i>
          </div>

          <h2 class="auth-heading">Tautan Kedaluwarsa</h2>
          <p class="auth-subtext">
            Masa berlaku tautan otorisasi ini telah berakhir. Demi keamanan akun, setiap tautan hanya dapat diakses dalam jangka waktu tertentu.
          </p>

          <div class="auth-info-box">
            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-exclamation-circle"></i> Status Tautan
              </span>
              <span class="auth-info-value">
                <span class="badge-terhubung badge-danger">Kedaluwarsa</span>
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-calendar"></i> Waktu Akses
              </span>
              <span class="auth-info-value">
                <?= date('d M Y, H:i'); ?> WIB
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-info-circle"></i> Keterangan
              </span>
              <span class="auth-info-value" style="font-size: 12px; color: #64748b;">
                Hubungi Administrator
              </span>
            </div>
          </div>
        </div>

        <div class="auth-card-footer">
          <div class="auth-secure-tag tag-danger">
            <i class="fa fa-clock-o"></i> Link Expired
          </div>
          <button type="button" class="btn-selesai btn-selesai-default" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
        </div>

      </div>

    <?php else: ?>
      <div class="auth-main-card">
        
        <div class="auth-card-body">
          <div class="auth-circle-icon icon-danger-theme">
            <i class="fa fa-times"></i>
          </div>

          <h2 class="auth-heading">Otorisasi Gagal</h2>
          <p class="auth-subtext">
            <?= !empty($error_message) ? htmlspecialchars($error_message) : 'Tautan otorisasi tidak valid atau parameter keamanan tidak sesuai.'; ?>
          </p>

          <div class="auth-info-box">
            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-exclamation-triangle"></i> Status
              </span>
              <span class="auth-info-value">
                <span class="badge-terhubung badge-danger">Gagal Validasi</span>
              </span>
            </div>

            <div class="auth-info-row">
              <span class="auth-info-label">
                <i class="fa fa-calendar"></i> Waktu
              </span>
              <span class="auth-info-value">
                <?= date('d M Y, H:i'); ?> WIB
              </span>
            </div>
          </div>
        </div>

        <div class="auth-card-footer">
          <div class="auth-secure-tag tag-danger">
            <i class="fa fa-times-circle"></i> Gagal
          </div>
          <button type="button" class="btn-selesai btn-selesai-default" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
        </div>

      </div>
    <?php endif; ?>

    <!-- Fallback hint if browser blocks window.close() -->
    <div id="close-hint-box" class="hint-alert-box">
      <i class="fa fa-info-circle text-primary" style="margin-right: 4px;"></i>
      Keamanan browser membatasi penutupan tab otomatis. Silakan tutup tab ini secara manual melalui tanda silang (<b>&times;</b>) pada tab browser Anda.
    </div>

    <!-- Footer Copyright -->
    <div class="auth-copyright">
      &copy; <?= date('Y'); ?> <?= get_option('site_name', 'Vendio'); ?> &bull; TikTok Shop Partner
    </div>

  </div>

  <script>
    function handleClosePage(btn) {
      try {
        window.open('', '_self', '');
        window.close();
      } catch (e) {}

      setTimeout(function() {
        var hint = document.getElementById('close-hint-box');
        if (hint) {
          hint.style.display = 'block';
        }
        if (btn) {
          btn.innerHTML = '<i class="fa fa-check"></i> Selesai (Silakan Tutup Tab)';
          btn.style.opacity = '0.8';
        }
      }, 150);
    }
  </script>
</body>
</html>
