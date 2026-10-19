<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

$selected_duration = (int)($this->input->get('duration') ?: 12);
if (!in_array($selected_duration, [1, 3, 6, 12])) {
    $selected_duration = 12;
}

$plan_count = !empty($plans) ? count($plans) : 0;
$col_class = 'col-md-4 col-sm-6 col-xs-12';
if ($plan_count == 1) {
    $col_class = 'col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12';
} elseif ($plan_count == 2) {
    $col_class = 'col-md-6 col-sm-6 col-xs-12';
} elseif ($plan_count == 4) {
    $col_class = 'col-md-3 col-sm-6 col-xs-12';
}

$current_plan_id = (int)($tenant->plan_id ?? 0);
$current_plan_order = 0;
if (!empty($plans)) {
    foreach ($plans as $p_item) {
        if ((int)$p_item->id === $current_plan_id) {
            $current_plan_order = (int)($p_item->sort_order ?: $p_item->id);
            break;
        }
    }
}

// Persiapkan data konfigurasi paket untuk JavaScript agar tidak bergantung pada $.data() yang rawan NaN
$plans_json_data = [];
if (!empty($plans)) {
    foreach ($plans as $p) {
        $p_id = (int)$p->id;
        $p_1 = (float)$p->price_monthly;

        // 3 Bulan
        $p_3 = (float)$p->price_3_months;
        $d_3 = (float)$p->discount_3_months;
        if ($p_3 <= 0 && $p_1 > 0 && $d_3 > 0) {
            $p_3 = round(($p_1 * 3) * (1 - ($d_3 / 100)));
        } elseif ($d_3 <= 0 && $p_1 > 0 && $p_3 > 0 && $p_3 < ($p_1 * 3)) {
            $d_3 = round((( ($p_1 * 3) - $p_3 ) / ($p_1 * 3)) * 100);
        }
        if ($p_3 <= 0) $p_3 = $p_1 * 3;

        // 6 Bulan
        $p_6 = (float)$p->price_6_months;
        $d_6 = (float)$p->discount_6_months;
        if ($p_6 <= 0 && $p_1 > 0 && $d_6 > 0) {
            $p_6 = round(($p_1 * 6) * (1 - ($d_6 / 100)));
        } elseif ($d_6 <= 0 && $p_1 > 0 && $p_6 > 0 && $p_6 < ($p_1 * 6)) {
            $d_6 = round((( ($p_1 * 6) - $p_6 ) / ($p_1 * 6)) * 100);
        }
        if ($p_6 <= 0) $p_6 = $p_1 * 6;

        // 12 Bulan
        $p_12 = (float)$p->price_12_months;
        $d_12 = (float)$p->discount_12_months;
        if ($p_12 <= 0 && $p_1 > 0 && $d_12 > 0) {
            $p_12 = round(($p_1 * 12) * (1 - ($d_12 / 100)));
        } elseif ($d_12 <= 0 && $p_1 > 0 && $p_12 > 0 && $p_12 < ($p_1 * 12)) {
            $d_12 = round((( ($p_1 * 12) - $p_12 ) / ($p_1 * 12)) * 100);
        }
        if ($p_12 <= 0) $p_12 = $p_1 * 12;

        $plans_json_data[$p_id] = [
            'id' => $p_id,
            'name' => $p->name,
            'special_badge' => !empty($p->special_badge) ? $p->special_badge : ((!empty($p->is_special) || strtolower($p->code) == 'growth-pro') ? 'Paling Populer' : ''),
            'price_1' => $p_1,
            'price_3' => $p_3,
            'discount_3' => $d_3,
            'price_6' => $p_6,
            'discount_6' => $d_6,
            'price_12' => $p_12,
            'discount_12' => $d_12,
            'max_shops' => (int)$p->max_shops,
            'max_users' => (int)$p->max_users,
            'max_warehouses' => (int)$p->max_warehouses,
            'sort_order' => (int)($p->sort_order ?: $p->id),
        ];
    }
}
?>

<!-- Refined Minimalist Styling (Tasteful, Balanced & Clean - Persis Modul Lainnya) -->
<style>
/* Main Box Wrapper */
.box-pricing {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

/* Header with Generous & Balanced Spacing */
.box-pricing .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-pricing .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-pricing .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-pricing .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-pricing .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-pricing .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-pricing .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-pricing .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Right - Persis Posisi Filter Toko */
.box-pricing .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

/* 3 Card Container inside Box Body */
.pricing-cards-area {
   padding: 25px 25px 35px 25px;
}

/* Simple Clean Card Styling */
.pricing-card-simple {
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   padding: 24px 20px;
   display: flex;
   flex-direction: column;
   justify-content: space-between;
   min-height: 100%;
   position: relative;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
   transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
}

/* Hover Simple untuk Card Paket */
.pricing-card-simple:hover {
   border-color: #94a3b8;
   box-shadow: 0 8px 20px rgba(15, 23, 42, 0.07);
   transform: translateY(-3px);
}

.pricing-card-simple.is-featured {
   border: 2px solid #00a65a;
   box-shadow: 0 2px 8px rgba(0, 166, 90, 0.08);
}

.pricing-card-simple.is-featured:hover {
   border-color: #008d4c;
   box-shadow: 0 8px 20px rgba(0, 166, 90, 0.18);
   transform: translateY(-3px);
}

.pricing-card-simple.is-current-plan {
   border: 2px solid #0284c7;
   box-shadow: 0 2px 8px rgba(2, 132, 199, 0.08);
}

.pricing-card-simple.is-current-plan:hover {
   border-color: #0369a1;
   box-shadow: 0 8px 20px rgba(2, 132, 199, 0.18);
   transform: translateY(-3px);
}

.plan-badge-pill {
   font-size: 11px;
   font-weight: 600;
   padding: 3px 8px;
   border-radius: 4px;
   background: #e0f2fe;
   color: #0369a1;
   white-space: nowrap;
}

.pricing-card-simple.is-featured .plan-badge-pill {
   background: #dcfce7;
   color: #15803d;
}

.plan-current-tag {
   background: #0284c7;
   color: #ffffff;
   font-size: 10px;
   font-weight: 700;
   padding: 2px 7px;
   border-radius: 4px;
   text-transform: uppercase;
   letter-spacing: 0.3px;
   margin-left: 6px;
   display: inline-block;
}

/* Action Button Styles - Hover konsisten dan transisi warna cepat */
.btn-plan-action {
   height: 38px !important;
   padding: 0 16px !important;
   font-size: 13px !important;
   font-weight: 600 !important;
   border-radius: 4px !important;
   display: flex !important;
   align-items: center !important;
   justify-content: center !important;
   gap: 6px !important;
   width: 100% !important;
   text-decoration: none !important;
   cursor: pointer;
   transition: all 0.14s ease-in-out !important;
}

/* Efek hover yang sama untuk semua button */
.btn-plan-action:hover {
   transform: translateY(-1px) !important;
}

/* 1. Button Paket Pilihan / Aktif: Berwarna biru dengan hover */
.btn-plan-action.btn-current-active {
   background-color: #0284c7 !important;
   border: 1px solid #0284c7 !important;
   color: #ffffff !important;
   cursor: pointer !important;
   opacity: 1 !important;
   box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25) !important;
}

.btn-plan-action.btn-current-active:hover {
   background-color: #0369a1 !important;
   border-color: #0284c7 !important;
   color: #ffffff !important;
   box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35) !important;
   transform: translateY(-1px) !important;
}

.btn-plan-action.btn-current-active i {
   color: #ffffff !important;
   font-size: 13px !important;
}

/* 2. Button Paket Rekomendasi / Populer */
.btn-plan-action.btn-featured {
   background-color: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.2) !important;
}

.btn-plan-action.btn-featured:hover {
   background-color: #008d4c !important;
   border-color: #00733e !important;
   color: #ffffff !important;
   box-shadow: 0 4px 12px rgba(0, 166, 90, 0.35) !important;
   transform: translateY(-1px) !important;
}

/* 3. Button Paket Biasa: Berubah warna ke hijau sama persis dengan transisi lebih cepat */
.btn-plan-action.btn-standard {
   background-color: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #334155 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
}

.btn-plan-action.btn-standard:hover {
   background-color: #008d4c !important;
   border-color: #00733e !important;
   color: #ffffff !important;
   box-shadow: 0 4px 12px rgba(0, 166, 90, 0.35) !important;
   transform: translateY(-1px) !important;
}

/* Action Dropdown 3-Dots Component: Ultra-Smooth, Clean & Refined (Persis Modul Katalog Produk) */
.action-dropdown {
   position: relative;
   display: inline-block;
}

.btn-action-dots,
.btn-action-dropdown {
   display: inline-flex !important;
   align-items: center !important;
   justify-content: center !important;
   width: 32px !important;
   height: 32px !important;
   min-width: 32px !important;
   padding: 0 !important;
   font-size: 15px !important;
   color: #475569 !important;
   background-color: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   border-radius: 6px !important;
   cursor: pointer !important;
   outline: none !important;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
   transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.btn-action-dots:hover,
.btn-action-dots:focus,
.btn-action-dropdown:hover,
.btn-action-dropdown:focus {
   background-color: #f8fafc !important;
   border-color: #94a3b8 !important;
   color: #0f172a !important;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08) !important;
}

.action-dropdown.open .btn-action-dots,
.action-dropdown.open .btn-action-dropdown {
   background-color: #ffffff !important;
   border-color: #00a65a !important;
   color: #00a65a !important;
   box-shadow: 0 0 0 2.5px rgba(0, 166, 90, 0.15) !important;
}

.btn-action-dots i,
.btn-action-dropdown i {
   line-height: 1 !important;
   pointer-events: none;
}

.action-dropdown .action-dropdown-menu {
   position: absolute !important;
   top: calc(100% + 5px) !important;
   right: 0 !important;
   left: auto !important;
   min-width: 180px !important;
   padding: 6px 0 !important;
   margin: 0 !important;
   background: #ffffff !important;
   border: 1px solid #e2e8f0 !important;
   border-radius: 8px !important;
   box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.06) !important;
   list-style: none !important;
   z-index: 1050 !important;
   text-align: left !important;
   
   display: block !important;
   opacity: 0;
   visibility: hidden;
   transform: translateY(-8px) scale(0.97);
   transform-origin: top right;
   pointer-events: none;
   transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1),
               transform 0.2s cubic-bezier(0.16, 1, 0.3, 1),
               visibility 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.action-dropdown.open .action-dropdown-menu {
   opacity: 1 !important;
   visibility: visible !important;
   transform: translateY(0) scale(1) !important;
   pointer-events: auto !important;
}

.action-dropdown-menu li {
   margin: 0 !important;
   padding: 0 !important;
}

.action-dropdown-menu .dropdown-item-action {
   display: flex !important;
   align-items: center !important;
   gap: 9px !important;
   padding: 7px 14px !important;
   font-size: 12.5px !important;
   font-weight: 500 !important;
   color: #334155 !important;
   text-decoration: none !important;
   line-height: 1.4 !important;
   transition: background-color 0.15s ease, color 0.15s ease, padding-left 0.15s ease !important;
   clear: both;
   white-space: nowrap;
}

.action-dropdown-menu .dropdown-item-action i {
   width: 16px;
   text-align: center;
   font-size: 13px;
   flex-shrink: 0;
   transition: transform 0.15s ease;
}

.action-dropdown-menu .dropdown-item-action:hover {
   background-color: #f1f5f9 !important;
   color: #0f172a !important;
   padding-left: 17px !important;
}

.action-dropdown-menu .divider {
   height: 1px !important;
   margin: 4px 0 !important;
   overflow: hidden;
   background-color: #f1f5f9 !important;
   border: none !important;
}

.action-dropdown-menu .dropdown-item-action.item-danger {
   color: #e11d48 !important;
}

.action-dropdown-menu .dropdown-item-action.item-danger:hover {
   background-color: #fef2f2 !important;
   color: #be123c !important;
   padding-left: 17px !important;
}

/* Clean Table Styling (Identik dengan Modul Lainnya) */
.box-pricing .table-responsive {
   min-height: 160px;
   border: none;
   margin: 0;
   overflow: visible !important;
}

.table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.table-minimal thead th {
   background-color: #f8fafc;
   color: #64748b;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.04em;
   border-top: none;
   border-bottom: 2px solid #e2e8f0;
   border-left: none;
   border-right: none;
   padding: 12px 14px;
   vertical-align: middle;
}

.table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 12px 14px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Pilihan Paket<small style="margin-left: 6px;"><?= cclang('list_all', ['Pilihan Paket']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pilihan Paket</li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-pricing">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment (Persis Modul Lainnya) -->
                  <div class="widget-user-header">
                     <div class="header-left">
                        <div class="widget-user-image">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                        </div>
                        <div class="header-titles">
                           <h3 class="widget-user-username">Pilihan Paket</h3>
                           <h5 class="widget-user-desc">
                              <?= cclang('list_all', ['Pilihan Paket']); ?>
                              <span class="label bg-yellow"><?= $plan_count; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <!-- Dropdown Pilihan Durasi di posisi persis filter toko -->
                     <div class="header-right">
                        <div style="width: 200px; text-align: left;">
                           <select class="form-control chosen chosen-select" name="duration_filter" id="duration_filter">
                              <option value="1" <?= $selected_duration == 1 ? 'selected' : ''; ?>>1 Bulan</option>
                              <option value="3" <?= $selected_duration == 3 ? 'selected' : ''; ?>>3 Bulan</option>
                              <option value="6" <?= $selected_duration == 6 ? 'selected' : ''; ?>>6 Bulan</option>
                              <option value="12" <?= $selected_duration == 12 ? 'selected' : ''; ?>>12 Bulan</option>
                           </select>
                        </div>
                     </div>
                  </div>

                  <!-- 3 Card Container inside Box Body (Menggantikan Kolom Tabel) -->
                  <div class="pricing-cards-area">
                     <div class="row">
                        <?php if (empty($plans)): ?>
                           <div class="col-md-12 text-center" style="padding: 50px 20px;">
                              <i class="fa fa-diamond text-muted" style="font-size: 40px; margin-bottom: 12px; display: block; color: #94a3b8;"></i>
                              <h4 style="font-weight: 700; color: #475569;">Belum Ada Paket Langganan Aktif</h4>
                              <p style="color: #64748b; font-size: 13px;">
                                 Silakan aktifkan paket langganan melalui menu <a href="<?= site_url('administrator/plans'); ?>">Paket Langganan</a> di panel admin.
                              </p>
                           </div>
                        <?php else: ?>
                           <?php 
                           $current_plan_id = (int)($tenant->plan_id ?? 0);
                           foreach ($plans as $index => $plan): 
                              $p_id = (int)$plan->id;
                              $cfg = $plans_json_data[$p_id] ?? [];

                              $is_featured = (!empty($plan->is_special) || strtolower($plan->code) == 'growth-pro');
                              $is_current = ($p_id === $current_plan_id);

                              $price_1 = (float)($cfg['price_1'] ?? $plan->price_monthly);
                              $price_3 = (float)($cfg['price_3'] ?? 0);
                              $disc_3  = (float)($cfg['discount_3'] ?? 0);
                              $price_6 = (float)($cfg['price_6'] ?? 0);
                              $disc_6  = (float)($cfg['discount_6'] ?? 0);
                              $price_12 = (float)($cfg['price_12'] ?? 0);
                              $disc_12  = (float)($cfg['discount_12'] ?? 0);

                              // Inisialisasi tampilan awal sesuai selected_duration
                              $init_total = $price_12;
                              $init_disc = $disc_12;
                              if ($selected_duration == 1) {
                                  $init_total = $price_1;
                                  $init_disc = 0;
                              } elseif ($selected_duration == 3) {
                                  $init_total = $price_3;
                                  $init_disc = $disc_3;
                              } elseif ($selected_duration == 6) {
                                  $init_total = $price_6;
                                  $init_disc = $disc_6;
                              }

                              $init_effective = ($selected_duration > 0) ? round($init_total / $selected_duration) : $price_1;
                              $special_badge = $cfg['special_badge'] ?? '';
                              $badge_text = ($init_disc > 0) ? 'Diskon ' . (float)$init_disc . '%' : $special_badge;

                              // Parse Fitur
                              $features_list = [];
                              if (!empty($plan->features)) {
                                 $decoded = json_decode($plan->features, true);
                                 if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $features_list = array_values(array_filter($decoded));
                                 } else {
                                    $lines = explode("\n", str_replace("\r", "", $plan->features));
                                    $features_list = array_values(array_filter(array_map('trim', $lines)));
                                 }
                              }

                              if (empty($features_list)) {
                                 $features_list[] = ($plan->max_shops > 0) ? $plan->max_shops . ' Akun Toko Terhubung' : 'Unlimited Toko Terhubung';
                                 $features_list[] = ($plan->max_users > 0) ? $plan->max_users . ' User / Staf Operasional' : 'Unlimited User / Staf';
                                 $features_list[] = ($plan->max_warehouses > 0) ? $plan->max_warehouses . ' Lokasi Gudang' : 'Unlimited Lokasi Gudang';
                                 $features_list[] = ($plan->max_products > 0) ? number_format($plan->max_products, 0, ',', '.') . ' Katalog Produk SKU' : 'Unlimited Produk SKU';
                                 $features_list[] = ($plan->max_orders_per_month > 0) ? number_format($plan->max_orders_per_month, 0, ',', '.') . ' Pesanan / Bulan' : 'Unlimited Pesanan / Bulan';
                                 $features_list[] = 'Sinkronisasi Stok & Order Otomatis';
                              }
                           ?>
                              <div class="<?= $col_class; ?>" style="margin-bottom: 20px;">
                                 <div class="pricing-card-simple <?= $is_featured ? 'is-featured' : ''; ?> <?= $is_current ? 'is-current-plan' : ''; ?>"
                                      id="plan-card-<?= $p_id; ?>"
                                      data-plan-id="<?= $p_id; ?>">

                                    <div>
                                       <!-- Baris Header Card: Nama Paket & Badge -->
                                       <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                          <div>
                                             <h4 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 2px 0;">
                                                <?= htmlspecialchars($plan->name); ?>
                                                <?php if ($is_current): ?>
                                                   <span class="plan-current-tag">Paket Aktif</span>
                                                <?php endif; ?>
                                             </h4>
                                          </div>
                                          <span class="plan-badge-pill" style="<?= empty($badge_text) ? 'display: none;' : ''; ?>">
                                             <?= htmlspecialchars($badge_text); ?>
                                          </span>
                                       </div>

                                       <!-- Deskripsi Singkat -->
                                       <p style="font-size: 13px; color: #64748b; line-height: 1.45; margin-bottom: 16px; min-height: 38px;">
                                          <?= htmlspecialchars($plan->description); ?>
                                       </p>

                                       <!-- Bagian Harga -->
                                       <div style="margin-bottom: 16px;">
                                          <div class="price-strike-val" style="font-size: 12px; color: #94a3b8; text-decoration: line-through; height: 16px; margin-bottom: 2px; <?= ($selected_duration == 1 || $init_disc <= 0) ? 'visibility: hidden;' : ''; ?>">
                                             Rp <?= number_format($price_1, 0, ',', '.'); ?>
                                          </div>
                                          <div style="display: flex; align-items: baseline; gap: 4px;">
                                             <span style="font-size: 16px; font-weight: 700; color: #1e293b;">Rp</span>
                                             <span class="price-amount-val" style="font-size: 28px; font-weight: 800; color: #1e293b; letter-spacing: -0.5px;">
                                                <?= number_format($init_effective, 0, ',', '.'); ?>
                                             </span>
                                             <span style="font-size: 13px; color: #64748b; font-weight: 500;">/bulan</span>
                                          </div>
                                          <div class="price-billing-subtext" style="font-size: 12px; color: #64748b; margin-top: 4px; min-height: 18px;">
                                             <?php if ($selected_duration == 1): ?>
                                                Ditagih bulanan Rp <?= number_format($price_1, 0, ',', '.'); ?>.
                                             <?php else: ?>
                                                Total Rp <?= number_format($init_total, 0, ',', '.'); ?> untuk <?= $selected_duration; ?> bulan (hemat <?= (float)$init_disc; ?>%).
                                             <?php endif; ?>
                                          </div>
                                       </div>

                                       <!-- Tombol Aksi -->
                                       <div style="margin-bottom: 16px;">
                                          <?php 
                                          $plan_order = (int)($plan->sort_order ?: $p_id);
                                          $btn_action_type = 'UPGRADE';
                                          $btn_text = !empty($plan->cta_text) ? htmlspecialchars($plan->cta_text) : 'Upgrade Paket';
                                          $btn_class = $is_featured ? 'btn-featured' : 'btn-standard';
                                          $btn_icon = 'fa-arrow-up';

                                          if ($is_current) {
                                              $btn_action_type = 'RENEWAL';
                                              $btn_text = 'Perpanjang Paket Ini';
                                              $btn_class = 'btn-current-active';
                                              $btn_icon = 'fa-refresh';
                                          } elseif ($current_plan_order > 0 && $plan_order < $current_plan_order) {
                                              $btn_action_type = 'DOWNGRADE';
                                              $btn_text = 'Downgrade Paket';
                                              $btn_class = 'btn-standard';
                                              $btn_icon = 'fa-arrow-down';
                                          } else {
                                              $btn_action_type = 'UPGRADE';
                                              $btn_text = !empty($plan->cta_text) ? htmlspecialchars($plan->cta_text) : 'Upgrade Paket';
                                              $btn_class = $is_featured ? 'btn-featured' : 'btn-standard';
                                              $btn_icon = 'fa-arrow-up';
                                          }
                                          ?>
                                          <button type="button" class="btn btn-plan-action <?= $btn_class; ?> btn-choose-plan" data-plan-id="<?= $p_id; ?>" data-action-type="<?= $btn_action_type; ?>">
                                             <i class="fa <?= $btn_icon; ?>" style="margin-right: 5px;"></i> <?= $btn_text; ?>
                                          </button>
                                       </div>

                                       <!-- Garis Pembatas -->
                                       <hr style="margin: 0 0 16px 0; border: 0; border-top: 1px solid #f1f5f9;">

                                       <!-- Fitur Checklist (Dinamis dari Admin) -->
                                       <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                                          <?php foreach ($features_list as $feat): ?>
                                             <li style="font-size: 12.5px; color: #334155; display: flex; align-items: flex-start; gap: 8px; line-height: 1.4;">
                                                <i class="fa fa-check" style="color: #00a65a; margin-top: 3px; font-size: 11px; flex-shrink: 0;"></i>
                                                <span><?= htmlspecialchars($feat); ?></span>
                                             </li>
                                          <?php endforeach; ?>
                                       </ul>
                                    </div>

                                 </div>
                              </div>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </div>
                  </div>

               </div>
            </div>
         </div>

         <!-- Box Riwayat Transaksi Langganan -->
         <div class="box box-pricing">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment (Persis Modul Lainnya) -->
                  <div class="widget-user-header">
                     <div class="header-left">
                        <div class="header-titles">
                           <h3 class="widget-user-username">Riwayat Transaksi Langganan</h3>
                           <h5 class="widget-user-desc">
                              <?= cclang('list_all', ['Riwayat Transaksi']); ?>
                              <span class="label bg-yellow"><?= !empty($transactions) ? count($transactions) : 0; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-minimal">
                        <thead>
                           <tr>
                              <th style="min-width: 140px;">No. Invoice</th>
                              <th style="min-width: 150px;">Paket</th>
                              <th style="width: 100px;">Durasi</th>
                              <th style="width: 140px;">Total Tagihan</th>
                              <th style="width: 160px;">Tanggal</th>
                              <th style="width: 100px; text-align: center;">Status</th>
                              <th style="width: 48px; text-align: center;">Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if (empty($transactions)): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                    <i class="fa fa-file-text-o" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                    Belum ada riwayat transaksi paket langganan.
                                 </td>
                              </tr>
                           <?php else: ?>
                              <?php foreach ($transactions as $tx): 
                                 $tx_status = strtoupper($tx->payment_status);
                                 $badge_class = 'label-warning';
                                 $status_label = 'Menunggu';
                                 if (in_array($tx_status, ['PAID', 'SETTLED'])) {
                                    $badge_class = 'label-success';
                                    $status_label = 'Lunas';
                                 } elseif (in_array($tx_status, ['EXPIRED', 'FAILED'])) {
                                    $badge_class = 'label-danger';
                                    $status_label = 'Kedaluwarsa';
                                 }
                              ?>
                                 <tr data-tx-id="<?= $tx->id; ?>">
                                    <td>
                                       <span style="font-family: monospace; font-weight: 600; color: #1e293b;">
                                          <?= html_escape($tx->invoice_number); ?>
                                       </span>
                                    </td>
                                    <td>
                                       <strong style="color: #0f172a;"><?= html_escape($tx->plan_name); ?></strong>
                                    </td>
                                    <td>
                                       <?= (int)$tx->duration_months; ?> Bulan
                                    </td>
                                    <td>
                                       <span style="font-weight: 600; color: #00a65a;">Rp <?= number_format($tx->total_amount, 0, ',', '.'); ?></span>
                                    </td>
                                    <td>
                                       <?= date('d M Y, H:i', strtotime($tx->created_at)); ?>
                                    </td>
                                    <td style="text-align: center;">
                                       <a href="<?= site_url('administrator/pricing/payment_status/' . $tx->xendit_external_id . '?popup=show'); ?>" class="popup-view" style="text-decoration: none;" title="Lihat Status Transaksi">
                                          <span class="label <?= $badge_class; ?>" style="cursor: pointer;">
                                             <?= $status_label; ?>
                                          </span>
                                       </a>
                                    </td>
                                    <td style="text-align: center; white-space: nowrap;">
                                       <?php
                                       $row_actions = [
                                          'view' => [
                                             'label'      => 'Detail Status',
                                             'url'        => site_url('administrator/pricing/payment_status/' . $tx->xendit_external_id . '?popup=show'),
                                             'class'      => 'popup-view',
                                          ]
                                       ];

                                       if ($tx_status === 'PENDING' && !empty($tx->invoice_url)) {
                                          $row_actions[] = [
                                             'label'      => 'Bayar Tagihan',
                                             'icon'       => 'fa fa-credit-card',
                                             'icon_color' => '#059669',
                                             'url'        => $tx->invoice_url,
                                             'attrs'      => ['target' => '_blank'],
                                          ];
                                       }

                                       if (!empty($tx->invoice_url)) {
                                          $row_actions[] = [
                                             'label'      => 'Buka Invoice Xendit',
                                             'icon'       => 'fa fa-external-link',
                                             'icon_color' => '#0284c7',
                                             'url'        => $tx->invoice_url,
                                             'attrs'      => ['target' => '_blank'],
                                          ];
                                       }

                                       echo render_table_action($row_actions, ['force_dropdown' => true]);
                                       ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           <?php endif; ?>
                        </tbody>
                     </table>
                  </div>

               </div>
            </div>
         </div>

      </div>
   </div>
</section>

<script>
$(document).ready(function() {
   var currentMonths = <?= (int)$selected_duration; ?>;
   var WA_NUMBER = '<?= $whatsapp_number; ?>';
   var TENANT_NAME = '<?= addslashes($tenant->tenant_name ?? 'Tenant'); ?>';
   var PLANS_CONFIG = <?= json_encode($plans_json_data); ?>;
   var CSRF_NAME = '<?= $csrf_name; ?>';
   var CSRF_HASH = '<?= $csrf_hash; ?>';
   var CHECKOUT_URL = '<?= site_url(ADMIN_NAMESPACE_URL . "/pricing/checkout"); ?>';

   // Auto-open modal popup jika user baru saja menyelesaikan pembayaran (?paid=...)
   <?php $paid_tx = $this->input->get('paid'); if (!empty($paid_tx)): ?>
      var paidExternalId = '<?= html_escape($paid_tx); ?>';
      if (window.history && window.history.replaceState) {
         try {
            var urlObj = new URL(window.location.href);
            urlObj.searchParams.delete('paid');
            window.history.replaceState({}, document.title, urlObj.toString());
         } catch(e) {
            var cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
         }
      }
      showPopup('<?= site_url("administrator/pricing/payment_status/" . html_escape($paid_tx) . "?popup=show"); ?>', function() {
         $('#modalPopUp').find('#btn_edit, #btn_back').hide();
         $('#modalPopUp').find('.col-md-7').removeClass('col-md-7');
      });
   <?php endif; ?>

   // Pastikan dropdown baris aktif tidak tertimpa baris lain
   $(document).on('show.bs.dropdown', '.action-dropdown', function () {
      $(this).closest('tr').addClass('dropdown-open').css('z-index', 50);
   });

   $(document).on('hide.bs.dropdown', '.action-dropdown', function () {
      $(this).closest('tr').removeClass('dropdown-open').css('z-index', '');
   });

   // Delegated click handler untuk popup-view (Komponen Modal PopUp bawaan Vendio)
   $(document).on('click', '.popup-view', function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      showPopup(url, function() {
         $('#modalPopUp').find('#btn_edit, #btn_back').hide();
         $('#modalPopUp').find('.col-md-7').removeClass('col-md-7');
      });
   });

   var CURRENT_PLAN_ID = <?= (int)($tenant->plan_id ?? 0); ?>;
   var CURRENT_USAGE = <?= json_encode($current_usage ?? ['shops' => 0, 'users' => 0, 'warehouses' => 0]); ?>;
   var selectedPlanId = null;

   // Inisialisasi plugin Chosen jika tersedia
   if ($.fn.chosen) {
      $('#duration_filter').chosen({
         width: '100%',
         disable_search: true
      });
   }

   function formatRupiah(num) {
      if (isNaN(num)) return '0';
      return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
   }

   function updateCards(months) {
      currentMonths = parseInt(months, 10) || 12;

      $('.pricing-card-simple').each(function() {
         var $card = $(this);
         var planId = $card.attr('data-plan-id');
         var plan = PLANS_CONFIG[planId];
         if (!plan) return;

         var basePrice1 = parseFloat(plan.price_1) || 0;
         var totalPrice = 0;
         var discountPct = 0;

         if (currentMonths === 1) {
            totalPrice = basePrice1;
            discountPct = 0;
         } else if (currentMonths === 3) {
            totalPrice = parseFloat(plan.price_3) || (basePrice1 * 3);
            discountPct = parseFloat(plan.discount_3) || 0;
         } else if (currentMonths === 6) {
            totalPrice = parseFloat(plan.price_6) || (basePrice1 * 6);
            discountPct = parseFloat(plan.discount_6) || 0;
         } else if (currentMonths === 12) {
            totalPrice = parseFloat(plan.price_12) || (basePrice1 * 12);
            discountPct = parseFloat(plan.discount_12) || 0;
         }

         var monthlyEffective = (currentMonths > 0) ? Math.round(totalPrice / currentMonths) : basePrice1;

         // 1. Strike-through normal price
         var $strike = $card.find('.price-strike-val');
         if (currentMonths === 1 || discountPct <= 0) {
            $strike.css('visibility', 'hidden');
         } else {
            $strike.text('Rp ' + formatRupiah(basePrice1)).css('visibility', 'visible');
         }

         // 2. Main price amount
         $card.find('.price-amount-val').text(formatRupiah(monthlyEffective));

         // 3. Badge Text
         var $badge = $card.find('.plan-badge-pill');
         if (currentMonths === 1) {
            if (plan.special_badge) {
               $badge.text(plan.special_badge).show();
            } else {
               $badge.hide();
            }
         } else {
            if (discountPct > 0) {
               $badge.text('Diskon ' + discountPct + '%').show();
            } else if (plan.special_badge) {
               $badge.text(plan.special_badge).show();
            } else {
               $badge.hide();
            }
         }

         // 4. Billing detail note
         var noteText = '';
         if (currentMonths === 1) {
            noteText = 'Ditagih bulanan Rp ' + formatRupiah(totalPrice) + '.';
         } else {
            noteText = 'Total Rp ' + formatRupiah(totalPrice) + ' untuk ' + currentMonths + ' bulan (hemat ' + discountPct + '%).';
         }
         $card.find('.price-billing-subtext').text(noteText);
      });
   }

   // Handle dropdown change (Persis posisi & perilaku filter toko)
   $('#duration_filter').on('change', function() {
      var m = parseInt($(this).val(), 10) || 12;
      updateCards(m);
   });

      function showAlert(title, text, type) {
      if (typeof swal === 'function') {
         swal({
            title: title,
            text: text,
            type: type || 'warning',
            confirmButtonColor: '#00a65a'
         });
      } else if (typeof toastr !== 'undefined') {
         if (type === 'error') {
            toastr.error(text, title);
         } else {
            toastr.warning(text, title);
         }
      } else {
         alert(title + ': ' + text);
      }
   }

   // Select plan button directly initiates Xendit checkout (tanpa modal)
   $(document).on('click', '.btn-choose-plan', function(e) {
      e.preventDefault();
      var $btn = $(this);
      var $card = $btn.closest('.pricing-card-simple');
      var planId = $card.attr('data-plan-id') || $btn.attr('data-plan-id');
      var plan = PLANS_CONFIG[planId];
      if (!plan) return;

      var currPlan = PLANS_CONFIG[CURRENT_PLAN_ID];
      var currOrder = currPlan ? (parseInt(currPlan.sort_order, 10) || CURRENT_PLAN_ID) : 0;
      var planOrder = parseInt(plan.sort_order, 10) || parseInt(planId, 10);
      var actionType = 'UPGRADE';

      if (parseInt(planId, 10) === CURRENT_PLAN_ID) {
         actionType = 'RENEWAL';
      } else if (currOrder > 0 && planOrder < currOrder) {
         actionType = 'DOWNGRADE';
      }

      // Validasi kuota toko & user jika downgrade
      if (actionType === 'DOWNGRADE') {
         var maxShops = parseInt(plan.max_shops, 10) || 0;
         var maxUsers = parseInt(plan.max_users, 10) || 0;
         var shopExceeded = (maxShops > 0 && CURRENT_USAGE.shops > maxShops);
         var userExceeded = (maxUsers > 0 && CURRENT_USAGE.users > maxUsers);

         if (shopExceeded || userExceeded) {
            var warnMsg = [];
            if (shopExceeded) warnMsg.push('Toko terhubung (' + CURRENT_USAGE.shops + ') melebihi batas (' + maxShops + ' toko)');
            if (userExceeded) warnMsg.push('User (' + CURRENT_USAGE.users + ') melebihi batas (' + maxUsers + ' user)');
            var fullMsg = 'Tidak dapat menurunkan paket: ' + warnMsg.join(', ') + '. Harap putuskan atau nonaktifkan data berlebih terlebih dahulu sebelum downgrade.';
            showAlert('Tidak Dapat Downgrade', fullMsg, 'warning');
            return;
         }
      }

      var originalHtml = $btn.html();
      // Disable tombol agar tidak double click
      $('.btn-choose-plan').prop('disabled', true);
      $btn.html('<i class="fa fa-spinner fa-spin"></i> Menyiapkan Xendit...');

      var postData = {
         plan_id: planId,
         duration: currentMonths
      };
      postData[CSRF_NAME] = CSRF_HASH;

      $.ajax({
         url: CHECKOUT_URL,
         type: 'POST',
         dataType: 'json',
         data: postData,
         success: function(res) {
            if (res.csrf) {
               CSRF_HASH = res.csrf.hash;
            }
            if (res.success && res.invoice_url) {
               $btn.html('<i class="fa fa-check"></i> Mengalihkan ke Xendit...');
               // Langsung redirect ke hosted invoice Xendit
               window.location.href = res.invoice_url;
            } else {
               $('.btn-choose-plan').prop('disabled', false);
               $btn.html(originalHtml);
               showAlert('Perhatian', res.message || 'Terjadi kesalahan saat memproses tagihan.', 'warning');
            }
         },
         error: function(xhr) {
            $('.btn-choose-plan').prop('disabled', false);
            $btn.html(originalHtml);
            var msg = 'Gagal menghubungi server. Silakan coba kembali atau muat ulang halaman.';
            if (xhr.status === 403) {
               msg = 'Sesi keamanan Anda telah berakhir. Silakan refresh halaman (F5) dan coba kembali.';
            }
            showAlert('Kesalahan Koneksi', msg, 'error');
         }
      });
   });

   // Initialize on default selected
   updateCards(currentMonths);
});
</script>
