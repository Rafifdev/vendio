<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= htmlspecialchars($page_title ?? 'Status Otorisasi TikTok Shop - Vendio'); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: #0f172a;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      color: #334155;
    }
    .auth-card {
      background: #ffffff;
      width: 100%;
      max-width: 480px;
      border-radius: 16px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
      overflow: hidden;
      text-align: center;
      padding: 40px 32px 32px 32px;
      position: relative;
    }
    .logo-container {
      margin-bottom: 24px;
    }
    .logo-container img {
      max-height: 38px;
      object-fit: contain;
    }
    .icon-wrapper {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px auto;
      font-size: 32px;
    }
    .icon-success {
      background: #dcfce7;
      color: #16a34a;
    }
    .icon-warning {
      background: #fef3c7;
      color: #d97706;
    }
    .icon-danger {
      background: #fee2e2;
      color: #dc2626;
    }
    h2.auth-title {
      font-size: 22px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 12px;
      line-height: 1.3;
    }
    p.auth-desc {
      font-size: 14px;
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 24px;
    }
    .info-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 16px;
      margin-bottom: 24px;
      text-align: left;
      font-size: 13px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px 0;
    }
    .info-row:not(:last-child) {
      border-bottom: 1px dashed #e2e8f0;
    }
    .info-label {
      color: #64748b;
      font-weight: 500;
    }
    .info-value {
      color: #0f172a;
      font-weight: 600;
    }
    .badge-status {
      display: inline-block;
      padding: 3px 8px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 600;
    }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-warning { background: #fef3c7; color: #b45309; }
    .badge-danger { background: #fee2e2; color: #b91c1c; }
    
    .btn-action {
      display: inline-block;
      width: 100%;
      background: #0f172a;
      color: #ffffff;
      padding: 12px 20px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      cursor: pointer;
      border: none;
    }
    .btn-action:hover {
      background: #1e293b;
      color: #ffffff;
      text-decoration: none;
    }
    .footer-note {
      margin-top: 24px;
      font-size: 12px;
      color: #94a3b8;
    }
  </style>
</head>
<body>

  <div class="auth-card">
    <div class="logo-container">
      <?php 
        $logo = get_option('logo');
        $logo_url = ($logo && is_file(FCPATH . 'uploads/setting/' . $logo)) 
                    ? base_url('uploads/setting/' . $logo) 
                    : base_url('asset/img/icon-wide.png');
      ?>
      <img src="<?= $logo_url; ?>" alt="Vendio Logo">
    </div>

    <?php if ($status == 'success'): ?>
      <div class="icon-wrapper icon-success">
        <i class="fa fa-check"></i>
      </div>
      <h2 class="auth-title">Otorisasi Berhasil!</h2>
      <p class="auth-desc">
        Toko TikTok Shop Anda telah berhasil terhubung dengan platform Vendio. Sistem kini siap melakukan sinkronisasi produk, pesanan, dan katalog toko.
      </p>
      
      <div class="info-box">
        <?php if (!empty($shop_name)): ?>
        <div class="info-row">
          <span class="info-label">Nama Toko</span>
          <span class="info-value"><?= htmlspecialchars($shop_name); ?></span>
        </div>
        <?php endif; ?>
        <div class="info-row">
          <span class="info-label">Status Koneksi</span>
          <span class="info-value"><span class="badge-status badge-success">Terhubung Aktif</span></span>
        </div>
        <div class="info-row">
          <span class="info-label">Waktu Otorisasi</span>
          <span class="info-value"><?= date('d M Y, H:i'); ?> WIB</span>
        </div>
      </div>

      <button type="button" class="btn-action" onclick="window.close();">Tutup Halaman Ini</button>

    <?php elseif ($status == 'already_used'): ?>
      <div class="icon-wrapper icon-warning">
        <i class="fa fa-lock"></i>
      </div>
      <h2 class="auth-title">Tautan Sudah Digunakan</h2>
      <p class="auth-desc">
        Tautan otorisasi ini bersifat <strong>sekali pakai (one-time link)</strong> dan sudah pernah digunakan sebelumnya untuk menghubungkan toko.
      </p>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Status Tautan</span>
          <span class="info-value"><span class="badge-status badge-warning">Sudah Digunakan</span></span>
        </div>
        <div class="info-row">
          <span class="info-label">Proteksi Keamanan</span>
          <span class="info-value">1 Tautan = 1 Toko</span>
        </div>
      </div>

      <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
        Jika Anda adalah pemilik toko lain yang ingin menghubungkan toko ke Vendio, silakan hubungi tim administrator kami untuk mendapatkan tautan baru.
      </p>

      <button type="button" class="btn-action" onclick="window.close();">Tutup Halaman Ini</button>

    <?php elseif ($status == 'expired'): ?>
      <div class="icon-wrapper icon-danger">
        <i class="fa fa-clock-o"></i>
      </div>
      <h2 class="auth-title">Tautan Kedaluwarsa</h2>
      <p class="auth-desc">
        Masa berlaku tautan otorisasi ini telah berakhir. Demi keamanan data toko Anda, tautan hanya dapat diakses dalam jangka waktu tertentu setelah dibuat.
      </p>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Status Tautan</span>
          <span class="info-value"><span class="badge-status badge-danger">Kedaluwarsa (Expired)</span></span>
        </div>
      </div>

      <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
        Silakan hubungi administrator Vendio untuk membuatkan tautan otorisasi yang baru.
      </p>

      <button type="button" class="btn-action" onclick="window.close();">Tutup Halaman Ini</button>

    <?php else: ?>
      <div class="icon-wrapper icon-danger">
        <i class="fa fa-times"></i>
      </div>
      <h2 class="auth-title">Otorisasi Gagal</h2>
      <p class="auth-desc">
        <?= !empty($error_message) ? htmlspecialchars($error_message) : 'Tautan otorisasi tidak valid atau parameter keamanan tidak sesuai.'; ?>
      </p>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Status</span>
          <span class="info-value"><span class="badge-status badge-danger">Gagal Validasi</span></span>
        </div>
      </div>

      <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
        Silakan pastikan Anda menggunakan tautan resmi yang diberikan langsung oleh administrator Vendio.
      </p>

      <button type="button" class="btn-action" onclick="window.close();">Tutup Halaman Ini</button>
    <?php endif; ?>

    <div class="footer-note">
      &copy; <?= date('Y'); ?> Vendio &bull; TikTok Shop Partner App
    </div>
  </div>

</body>
</html>
