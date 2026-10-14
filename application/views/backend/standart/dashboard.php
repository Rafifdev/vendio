<style type="text/css">
  /* Medium rounded & modern aesthetic */
  .small-box {
    border-radius: 8px !important;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    margin-bottom: 20px;
    border: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .small-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  }
  .small-box .inner {
    padding: 16px 18px 12px 18px;
  }
  .small-box .icon {
    top: 10px;
    right: 15px;
    font-size: 68px;
    opacity: 0.25;
    transition: all 0.3s ease;
  }
  .small-box:hover .icon {
    font-size: 74px;
    opacity: 0.35;
  }
  .small-box-footer {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    background: rgba(0, 0, 0, 0.12) !important;
    font-weight: 600;
    font-size: 12px;
    padding: 7px 0 !important;
  }
  .badge {
    border-radius: 4px !important;
    font-weight: 600;
  }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Ringkasan Performa & Operasional Bisnis</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- 4 CARDS UTAMA -->
  <div class="row">
    <!-- Card 1: Total Omzet -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3 style="font-size: 24px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="Rp <?= number_format($total_revenue, 0, ',', '.'); ?>">
            Rp <?= number_format($total_revenue, 0, ',', '.'); ?>
          </h3>
          <p style="margin-bottom: 0;">Total Omzet Penjualan</p>
        </div>
        <div class="icon">
          <i class="ion ion-cash"></i>
        </div>
        <a href="<?= site_url('administrator/tiktok_orders'); ?>" class="small-box-footer">
          Lihat Data Pesanan <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <!-- Card 2: Total Pesanan -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3 style="font-size: 24px; font-weight: 700;">
            <?= number_format($total_orders); ?>
          </h3>
          <p style="margin-bottom: 0;">
            Total Pesanan 
            <?php if ($pending_shipment > 0): ?>
              <span class="badge bg-yellow" style="font-size: 10px; margin-left: 4px;" title="Pesanan perlu dikirim"><?= $pending_shipment; ?> Perlu Kirim</span>
            <?php endif; ?>
          </p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="<?= site_url('administrator/tiktok_orders'); ?>" class="small-box-footer">
          Kelola Pesanan <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <!-- Card 3: Katalog Produk Aktif -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3 style="font-size: 24px; font-weight: 700;">
            <?= number_format($active_products); ?>
          </h3>
          <p style="margin-bottom: 0;">
            Produk Aktif Dijual
            <?php if ($low_stock > 0): ?>
              <span class="badge bg-red" style="font-size: 10px; margin-left: 4px;" title="Produk dengan stok <= 5"><?= $low_stock; ?> Menipis</span>
            <?php endif; ?>
          </p>
        </div>
        <div class="icon">
          <i class="ion ion-cube"></i>
        </div>
        <a href="<?= site_url('administrator/tiktok_products'); ?>" class="small-box-footer">
          Lihat Katalog Produk <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>

    <!-- Card 4: Toko Terhubung -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3 style="font-size: 24px; font-weight: 700;">
            <?= number_format($active_shops); ?>
          </h3>
          <p style="margin-bottom: 0;">Toko Terhubung Aktif</p>
        </div>
        <div class="icon">
          <i class="ion ion-ios-home"></i>
        </div>
        <a href="<?= site_url('administrator/tiktok_shops'); ?>" class="small-box-footer">
          Kelola Toko TikTok <i class="fa fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->