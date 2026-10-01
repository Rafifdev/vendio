<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= htmlspecialchars($page_title ?? 'Status Otorisasi TikTok Shop - Vendio'); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Core Vendio & AdminLTE Stylesheets -->
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="<?= BASE_ASSET; ?>/css/custom.css">

  <style>
    body {
      font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      background-color: #f4f6f9;
      color: #334155;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      margin: 0;
    }

    .auth-status-container {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
    }

    .auth-logo-header {
      text-align: center;
      margin-bottom: 22px;
    }

    .auth-logo-header img {
      max-height: 40px;
      object-fit: contain;
    }

    .auth-logo-header .auth-app-badge {
      display: inline-block;
      margin-top: 8px;
      font-size: 11.5px;
      font-weight: 600;
      color: #64748b;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    /* Box Card matching .box-tiktok-shops & Vendio modules */
    .box-auth-status {
      background: #ffffff;
      border-radius: 8px;
      border: 1px solid #e5e9f0;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      text-align: center;
      padding: 36px 30px 28px 30px;
      position: relative;
    }

    /* Accent top borders matching AdminLTE / Vendio */
    .border-top-success {
      border-top: 4px solid #00a65a !important;
    }
    .border-top-warning {
      border-top: 4px solid #f39c12 !important;
    }
    .border-top-danger {
      border-top: 4px solid #dd4b39 !important;
    }

    /* Circular Status Icon Wrapper */
    .status-icon-wrapper {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px auto;
      font-size: 26px;
    }

    .icon-success-wrap {
      background: #dcfce7;
      color: #00a65a;
      border: 1px solid #bbf7d0;
    }

    .icon-warning-wrap {
      background: #fef3c7;
      color: #d97706;
      border: 1px solid #fde68a;
    }

    .icon-danger-wrap {
      background: #fee2e2;
      color: #dc2626;
      border: 1px solid #fecaca;
    }

    /* Text & Headings */
    .auth-title {
      font-size: 20px;
      font-weight: 700;
      color: #1e293b;
      margin-top: 0;
      margin-bottom: 8px;
      line-height: 1.25;
    }

    .auth-desc {
      font-size: 13.5px;
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 22px;
    }

    /* Info Table / Summary Box matching Vendio module chips */
    .summary-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 12px 16px;
      margin-bottom: 22px;
      text-align: left;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 7px 0;
      font-size: 13px;
    }

    .summary-row:not(:last-child) {
      border-bottom: 1px dashed #e2e8f0;
    }

    .summary-label {
      color: #64748b;
      font-weight: 500;
      font-size: 12.5px;
    }

    .summary-value {
      color: #1e293b;
      font-weight: 600;
      font-size: 13px;
    }

    .chip-code {
      font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
      font-size: 12px;
      color: #475569;
      background: #f1f5f9;
      padding: 3px 8px;
      border-radius: 4px;
      border: 1px solid #e2e8f0;
      display: inline-block;
    }

    /* Badges matching Vendio .label */
    .label-badge {
      font-size: 11px !important;
      padding: 3px 9px !important;
      border-radius: 12px !important;
      font-weight: 600 !important;
      display: inline-block;
      text-transform: uppercase;
      letter-spacing: 0.03em;
    }

    /* Buttons matching Vendio modules */
    .btn-action-wrap {
      margin-top: 6px;
    }

    .btn-vendio {
      height: 36px;
      padding: 0 18px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 4px !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      transition: all 0.15s ease;
      cursor: pointer;
      width: 100%;
      border: 1px solid #d2d6de;
      background-color: #ffffff;
      color: #334155;
      text-decoration: none;
    }

    .btn-vendio:hover {
      background-color: #f1f5f9;
      color: #0f172a;
      border-color: #cbd5e1;
      text-decoration: none;
    }

    .btn-vendio-success {
      background-color: #00a65a;
      border-color: #008d4c;
      color: #ffffff;
    }

    .btn-vendio-success:hover {
      background-color: #008d4c;
      border-color: #00733e;
      color: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
    }

    .notice-note {
      font-size: 12.5px;
      color: #64748b;
      margin-top: -6px;
      margin-bottom: 20px;
      line-height: 1.5;
    }

    .footer-auth {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #94a3b8;
    }
  </style>
</head>
<body>

  <div class="auth-status-container">

    <!-- Top Logo Branding -->
    <div class="auth-logo-header">
      <?php 
        $logo = get_option('logo');
        $logo_url = ($logo && is_file(FCPATH . 'uploads/setting/' . $logo)) 
                    ? base_url('uploads/setting/' . $logo) 
                    : base_url('asset/img/icon-wide.png');
      ?>
      <img src="<?= $logo_url; ?>" alt="Vendio">
      <br>
      <span class="auth-app-badge"><i class="fa fa-shopping-bag text-primary"></i> TikTok Shop Integration</span>
    </div>

    <!-- Main Card Body -->
    <?php if ($status == 'success'): ?>
      <div class="box-auth-status border-top-success">
        <div class="status-icon-wrapper icon-success-wrap">
          <i class="fa fa-check"></i>
        </div>
        <h2 class="auth-title">Otorisasi Berhasil!</h2>
        <p class="auth-desc">
          Toko TikTok Shop Anda telah berhasil terhubung dengan platform Vendio. Integrasi sekarang aktif dan siap melakukan sinkronisasi data.
        </p>

        <div class="summary-card">
          <?php if (!empty($shop_name)): ?>
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-shopping-bag" style="color: #64748b; margin-right: 6px;"></i>Nama Toko</span>
            <span class="summary-value"><?= htmlspecialchars($shop_name); ?></span>
          </div>
          <?php endif; ?>
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-shield" style="color: #64748b; margin-right: 6px;"></i>Status Otorisasi</span>
            <span class="summary-value">
              <span class="label label-success label-badge">Terhubung Aktif</span>
            </span>
          </div>
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-calendar" style="color: #64748b; margin-right: 6px;"></i>Waktu Otorisasi</span>
            <span class="summary-value"><?= date('d M Y, H:i'); ?> WIB</span>
          </div>
        </div>

        <div class="btn-action-wrap">
          <button type="button" class="btn btn-vendio btn-vendio-success" onclick="handleClosePage(this);">
            <i class="fa fa-check"></i> Selesai & Tutup Halaman
          </button>
          <div class="close-hint-box" style="display: none; margin-top: 14px; padding: 12px 14px; background-color: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #475569; line-height: 1.5; text-align: center;">
            <i class="fa fa-info-circle text-primary" style="margin-right: 4px;"></i>
            Keamanan browser membatasi penutupan tab otomatis. Anda dapat langsung menutup tab ini secara manual melalui tanda silang (<b>&times;</b>) di browser Anda.
          </div>
        </div>
      </div>

    <?php elseif ($status == 'already_used'): ?>
      <div class="box-auth-status border-top-warning">
        <div class="status-icon-wrapper icon-warning-wrap">
          <i class="fa fa-lock"></i>
        </div>
        <h2 class="auth-title">Tautan Sudah Digunakan</h2>
        <p class="auth-desc">
          Tautan otorisasi ini bersifat <strong>sekali pakai (one-time link)</strong> dan sudah pernah digunakan sebelumnya untuk menghubungkan toko.
        </p>

        <div class="summary-card">
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-info-circle" style="color: #64748b; margin-right: 6px;"></i>Status Tautan</span>
            <span class="summary-value">
              <span class="label label-warning label-badge">Sudah Digunakan</span>
            </span>
          </div>
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-shield" style="color: #64748b; margin-right: 6px;"></i>Proteksi Sistem</span>
            <span class="summary-value"><span class="chip-code">1 Tautan = 1 Toko</span></span>
          </div>
        </div>

        <p class="notice-note">
          Jika Anda adalah pemilik toko lain yang ingin menghubungkan toko ke Vendio, silakan hubungi administrator untuk meminta tautan baru.
        </p>

        <div class="btn-action-wrap">
          <button type="button" class="btn btn-vendio" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
          <div class="close-hint-box" style="display: none; margin-top: 14px; padding: 12px 14px; background-color: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #475569; line-height: 1.5; text-align: center;">
            <i class="fa fa-info-circle text-primary" style="margin-right: 4px;"></i>
            Keamanan browser membatasi penutupan tab otomatis. Anda dapat langsung menutup tab ini secara manual melalui tanda silang (<b>&times;</b>) di browser Anda.
          </div>
        </div>
      </div>

    <?php elseif ($status == 'expired'): ?>
      <div class="box-auth-status border-top-danger">
        <div class="status-icon-wrapper icon-danger-wrap">
          <i class="fa fa-clock-o"></i>
        </div>
        <h2 class="auth-title">Tautan Kedaluwarsa</h2>
        <p class="auth-desc">
          Masa berlaku tautan otorisasi ini telah berakhir. Demi keamanan akun, setiap tautan hanya dapat diakses dalam jangka waktu tertentu.
        </p>

        <div class="summary-card">
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-exclamation-circle" style="color: #64748b; margin-right: 6px;"></i>Status Tautan</span>
            <span class="summary-value">
              <span class="label label-danger label-badge">Kedaluwarsa (Expired)</span>
            </span>
          </div>
        </div>

        <p class="notice-note">
          Silakan hubungi administrator Vendio untuk membuatkan tautan otorisasi baru.
        </p>

        <div class="btn-action-wrap">
          <button type="button" class="btn btn-vendio" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
          <div class="close-hint-box" style="display: none; margin-top: 14px; padding: 12px 14px; background-color: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #475569; line-height: 1.5; text-align: center;">
            <i class="fa fa-info-circle text-primary" style="margin-right: 4px;"></i>
            Keamanan browser membatasi penutupan tab otomatis. Anda dapat langsung menutup tab ini secara manual melalui tanda silang (<b>&times;</b>) di browser Anda.
          </div>
        </div>
      </div>

    <?php else: ?>
      <div class="box-auth-status border-top-danger">
        <div class="status-icon-wrapper icon-danger-wrap">
          <i class="fa fa-times-circle"></i>
        </div>
        <h2 class="auth-title">Otorisasi Gagal</h2>
        <p class="auth-desc">
          <?= !empty($error_message) ? htmlspecialchars($error_message) : 'Tautan otorisasi tidak valid atau parameter keamanan tidak sesuai.'; ?>
        </p>

        <div class="summary-card">
          <div class="summary-row">
            <span class="summary-label"><i class="fa fa-warning" style="color: #64748b; margin-right: 6px;"></i>Status</span>
            <span class="summary-value">
              <span class="label label-danger label-badge">Gagal Validasi</span>
            </span>
          </div>
        </div>

        <p class="notice-note">
          Pastikan Anda menggunakan tautan resmi yang diberikan langsung oleh administrator Vendio.
        </p>

        <div class="btn-action-wrap">
          <button type="button" class="btn btn-vendio" onclick="handleClosePage(this);">
            <i class="fa fa-times"></i> Tutup Halaman Ini
          </button>
          <div class="close-hint-box" style="display: none; margin-top: 14px; padding: 12px 14px; background-color: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 6px; font-size: 12.5px; color: #475569; line-height: 1.5; text-align: center;">
            <i class="fa fa-info-circle text-primary" style="margin-right: 4px;"></i>
            Keamanan browser membatasi penutupan tab otomatis. Anda dapat langsung menutup tab ini secara manual melalui tanda silang (<b>&times;</b>) di browser Anda.
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Footer Copyright -->
    <div class="footer-auth">
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
        var hints = document.querySelectorAll('.close-hint-box');
        hints.forEach(function(el) {
          el.style.display = 'block';
        });
        if (btn) {
          btn.innerHTML = '<i class="fa fa-check"></i> Selesai (Silakan Tutup Tab)';
          btn.style.opacity = '0.75';
          btn.style.cursor = 'default';
        }
      }, 150);
    }
  </script>
</body>
</html>
