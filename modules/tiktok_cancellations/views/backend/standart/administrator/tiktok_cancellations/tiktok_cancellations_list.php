<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+f', function assets() {
      $('#sbtn').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#reset').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {
      $('#reset').trigger('click');
      return false;
   });
}

jQuery(document).ready(domo);
</script>

<!-- Refined Minimalist Styling (Tasteful, Balanced & Clean) -->
<style>
/* Main Card Wrapper */
.box-tiktok-cancellations {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-cancellations .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-cancellations .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-cancellations .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-cancellations .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-cancellations .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-cancellations .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-cancellations .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-cancellations .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-cancellations .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-cancellations .btn-top-action {
   height: 34px !important;
   padding: 0 14px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   border-radius: 4px !important;
   background-color: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
   display: inline-flex !important;
   align-items: center !important;
   gap: 6px !important;
   transition: all 0.15s ease;
}

.box-tiktok-cancellations .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-cancellations .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}



.box-tiktok-cancellations .table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-cancellations .table-minimal thead th {
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
   padding: 10px 8px;
   vertical-align: middle;
}

.box-tiktok-cancellations .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-cancellations .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-tiktok-cancellations .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

.box-tiktok-cancellations .table-minimal tbody tr.dropdown-open {
   z-index: 50;
}

/* Chips & Badges */
.chip-id {
   font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
   font-size: 12px;
   color: #475569;
   background-color: #f1f5f9;
   padding: 3px 8px;
   border-radius: 4px;
   display: inline-block;
}

.chip-link {
   font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
   font-size: 12px;
   color: #0284c7;
   background-color: #f0f9ff;
   border: 1px solid #bae6fd;
   padding: 3px 8px;
   border-radius: 4px;
   display: inline-block;
   text-decoration: none !important;
   font-weight: 600;
}

.chip-link:hover {
   background-color: #e0f2fe;
   color: #0369a1;
}

/* Single Action Link (Used when only 1 action exists) */
.action-link {
   display: inline-flex !important;
   align-items: center !important;
   gap: 5px !important;
   padding: 4px 10px !important;
   height: 28px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 500 !important;
   color: #334155 !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   text-decoration: none !important;
   transition: all 0.15s ease !important;
   white-space: nowrap !important;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
}

.action-link i {
   font-size: 12px !important;
   color: #64748b !important;
   transition: color 0.15s ease !important;
}

.action-link:hover {
   background: #f8fafc !important;
   color: #0f172a !important;
   border-color: #94a3b8 !important;
   box-shadow: 0 2px 4px rgba(15, 23, 42, 0.08) !important;
}

.action-link:hover i {
   color: #0f172a !important;
}

.action-link.remove-data:hover,
.action-link.item-danger:hover {
   background: #fef2f2 !important;
   color: #dc2626 !important;
   border-color: #fca5a5 !important;
}

.action-link.remove-data:hover i,
.action-link.item-danger:hover i {
   color: #dc2626 !important;
}

/* Action Dropdown 3-Dots Component */
.action-dropdown {
   position: relative;
   display: inline-block;
}

.btn-action-dots {
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
.btn-action-dots:focus {
   background-color: #f8fafc !important;
   border-color: #94a3b8 !important;
   color: #0f172a !important;
   box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08) !important;
}

.action-dropdown.open .btn-action-dots {
   background-color: #ffffff !important;
   border-color: #00a65a !important;
   color: #00a65a !important;
   box-shadow: 0 0 0 2.5px rgba(0, 166, 90, 0.15) !important;
}

.btn-action-dots i {
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

/* Fixed Bottom Toolbar (Clean Footer Container) */
.box-footer-toolbar {
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding: 14px 22px;
   background: #fafbfc;
   border-top: 1px solid #e9edf2;
   border-bottom-left-radius: 8px;
   border-bottom-right-radius: 8px;
   flex-wrap: wrap;
   gap: 12px;
}

.toolbar-controls-left {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 10px;
}

.bulk-group {
   display: flex;
   align-items: center;
   gap: 6px;
}

.filter-group {
   display: flex;
   align-items: center;
   gap: 6px;
   flex-wrap: wrap;
}

.toolbar-divider {
   width: 1px;
   height: 22px;
   background-color: #e2e8f0;
   margin: 0 4px;
}

.box-footer-toolbar .form-control {
   height: 34px !important;
   border-radius: 4px !important;
   font-size: 13px !important;
   border: 1px solid #cbd5e1 !important;
   background-color: #ffffff !important;
   box-shadow: none !important;
   padding: 6px 10px !important;
}

.box-footer-toolbar .form-control:focus {
   border-color: #00a65a !important;
}

.box-footer-toolbar select.form-control,
.box-footer-toolbar select {
   -webkit-appearance: none !important;
   -moz-appearance: none !important;
   appearance: none !important;
   background-color: #ffffff !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
   background-repeat: no-repeat !important;
   background-position: right 14px center !important;
   background-size: 11px !important;
   padding-right: 34px !important;
   padding-left: 12px !important;
   cursor: pointer !important;
}

.box-footer-toolbar select.form-control:focus,
.box-footer-toolbar select:focus {
   border-color: #00a65a !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2300a65a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
}

.box-footer-toolbar .btn-apply {
   height: 34px !important;
   padding: 0 14px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #334155 !important;
}

.box-footer-toolbar .btn-apply:hover {
   background: #f1f5f9 !important;
}

.box-footer-toolbar .btn-filter-submit {
   height: 34px !important;
   padding: 0 14px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   background: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
}

.box-footer-toolbar .btn-filter-submit:hover {
   background: #008d4c !important;
}

.box-footer-toolbar .btn-reset {
   height: 34px !important;
   width: 34px !important;
   padding: 0 !important;
   display: inline-flex !important;
   align-items: center !important;
   justify-content: center !important;
   border-radius: 4px !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #64748b !important;
}

.box-footer-toolbar .btn-reset:hover {
   background: #f1f5f9 !important;
   color: #334155 !important;
}

.toolbar-controls-right {
   display: flex;
   align-items: center;
}

.toolbar-controls-right .pagination {
   margin: 0 !important;
}

.toolbar-controls-right .pagination > li > a,
.toolbar-controls-right .pagination > li > span {
   border-radius: 4px !important;
   margin: 0 2px !important;
   padding: 6px 12px !important;
   font-size: 12px !important;
   border: 1px solid #e2e8f0 !important;
}

.toolbar-controls-right .pagination > .active > a,
.toolbar-controls-right .pagination > .active > span {
   background-color: #00a65a !important;
   border-color: #00a65a !important;
   color: #fff !important;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('tiktok_cancellations') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_cancellations') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-cancellations">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment -->
                  <div class="widget-user-header" style="padding: 22px 25px;">
                     <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
                        <div class="widget-user-image" style="width: 52px; height: 52px; margin-right: 18px; float: none; display: flex; align-items: center;">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar" style="width: 52px; height: 52px; border-radius: 50%; float: none; display: block;">
                        </div>
                        <div class="header-titles" style="margin-left: 0;">
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;">Pembatalan Pesanan</h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              Daftar Pengajuan Pembatalan Pesanan 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_cancellations_counts; ?> Data</span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <div style="width: 200px; text-align: left;">
                           <select class="form-control chosen chosen-select" name="shop_id_filter" id="shop_id_filter">
                              <option value="">Semua Toko</option>
                              <?php foreach ($shops as $shop): ?>
                                 <option <?= ($selected_shop_id == $shop->id) ? 'selected' : ''; ?> value="<?= $shop->id; ?>">
                                    <?= _ent($shop->shop_name); ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        <?php is_allowed('tiktok_cancellations_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_cancellations/export'); ?>">
                           <i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS
                        </a>
                        <?php }) ?>
                        
                        <a class="btn btn-top-action" id="btn_sync" style="width: 34px !important; padding: 0 !important; justify-content: center !important;" title="Tarik Data Pembatalan dari TikTok Shop" href="<?= site_url('administrator/tiktok_cancellations/sync' . (!empty($selected_shop_id) ? '?shop_id=' . $selected_shop_id : '')); ?>">
                           <i class="fa fa-refresh"></i>
                        </a>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_cancellations" id="form_tiktok_cancellations" action="<?= base_url('administrator/tiktok_cancellations/index'); ?>
                     <?php if (!empty($selected_shop_id)): ?>
                        <input type="hidden" name="shop_id" value="<?= $selected_shop_id; ?>">
                     <?php endif; ?>">

                  <?php
                  if (!function_exists('format_tiktok_cancel_status')) {
                     function format_tiktok_cancel_status($status) {
                        if (empty($status)) return '-';
                        $st = strtoupper(trim($status));
                        switch ($st) {
                           case 'AWAITING_SELLER_REVIEW':
                           case 'PENDING':
                           case 'CANCELLATION_REQUEST_PENDING':
                           case 'REVIEWING':
                              return '<span class="label label-warning">Menunggu Respon</span>';
                           case 'APPROVED':
                           case 'CANCELLATION_REQUEST_APPROVED':
                              return '<span class="label label-success">Disetujui</span>';
                           case 'COMPLETE':
                           case 'COMPLETED':
                           case 'SUCCESS':
                           case 'CANCELLATION_REQUEST_COMPLETE':
                              return '<span class="label label-success">Selesai</span>';
                           case 'REJECT':
                           case 'REJECTED':
                           case 'CANCELLATION_REQUEST_REJECT':
                           case 'CANCELLATION_REQUEST_REJECTED':
                              return '<span class="label label-danger">Ditolak</span>';
                           case 'CANCEL':
                           case 'CANCELLED':
                           case 'CANCELLATION_REQUEST_CANCEL':
                           case 'CANCELLATION_REQUEST_CANCELLED':
                              return '<span class="label label-danger">Dibatalkan</span>';
                           default:
                              $clean = ucwords(str_replace(['cancellation_request_', '_'], ['', ' '], strtolower($st)));
                              return '<span class="label label-info">' . _ent($clean) . '</span>';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_cancel_reason')) {
                     function format_tiktok_cancel_reason($reason) {
                        if (empty($reason)) return '-';
                        $r = strtolower(trim($reason));
                        if (strpos($r, 'out_of_stock') !== false || strpos($r, 'stok') !== false) {
                           return 'Stok Habis';
                        } elseif (strpos($r, 'pricing_error') !== false || strpos($r, 'wrong_price') !== false || strpos($r, 'harga') !== false) {
                           return 'Kesalahan Harga';
                        } elseif (strpos($r, 'changed_mind') !== false || strpos($r, 'change_of_mind') !== false || strpos($r, 'berubah pikiran') !== false) {
                           return 'Berubah Pikiran';
                        } elseif (strpos($r, 'wrong_item') !== false || strpos($r, 'wrong_product') !== false || strpos($r, 'salah beli') !== false || strpos($r, 'salah varian') !== false) {
                           return 'Salah Produk/Varian';
                        } elseif (strpos($r, 'address_wrong') !== false || strpos($r, 'wrong_address') !== false || strpos($r, 'ganti alamat') !== false) {
                           return 'Alamat Salah';
                        } elseif (strpos($r, 'shipping_delayed') !== false || strpos($r, 'delayed') !== false || strpos($r, 'terlambat') !== false) {
                           return 'Pengiriman Terlambat';
                        } elseif (strpos($r, 'found_cheaper') !== false || strpos($r, 'cheaper') !== false || strpos($r, 'lebih murah') !== false) {
                           return 'Menemukan Harga Lebih Murah';
                        } elseif (strpos($r, 'timeout') !== false || strpos($r, 'unpaid') !== false) {
                           return 'Waktu Pembayaran Habis';
                        } elseif (strpos($r, 'duplicate') !== false || strpos($r, 'ganda') !== false) {
                           return 'Pesanan Ganda';
                        } elseif (strpos($r, 'risk_control') !== false || strpos($r, 'risk') !== false) {
                           return 'Kontrol Risiko Sistem';
                        } elseif (strpos($r, 'payment') !== false || strpos($r, 'bayar') !== false) {
                           return 'Kendala Pembayaran';
                        } elseif (strpos($r, 'mutual') !== false || strpos($r, 'sepakat') !== false) {
                           return 'Kesepakatan Bersama';
                        } elseif (strpos($r, 'not_delivered') !== false || strpos($r, 'undeliverable') !== false) {
                           return 'Gagal Kirim';
                        }

                        $clean = str_replace(['seller_cancel_reason_', 'buyer_cancel_reason_', 'system_cancel_reason_', 'cancel_reason_', '_'], ['', '', '', '', ' '], $r);
                        return ucwords(trim($clean));
                     }
                  }
                  ?>

                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="width: 110px;">Nama Toko</th>
                                 <th style="width: 120px;">ID Pesanan</th>
                                 <th style="width: 95px; text-align: center;">Inisiator</th>
                                 <th style="width: 105px; text-align: center;">Status Pembatalan</th>
                                 <th style="width: 130px;">Alasan Pembatalan</th>
                                 <th style="width: 115px;">Waktu Pengajuan</th>
                                 <th style="width: 48px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_cancellations">
                              <?php foreach ($tiktok_cancellationss as $tiktok_cancellations): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_cancellations->id; ?>">
                                 </td>
                                 <td>
                                    <?php if (!empty($tiktok_cancellations->tiktok_shop_id)): ?>
                                       <?= anchor('administrator/tiktok_shops/view/' . $tiktok_cancellations->tiktok_shop_id . '?popup=show', $tiktok_cancellations->tiktok_shops_shop_name ?: 'Toko TikTok', ['class' => 'popup-view', 'style' => 'font-weight: 500; color: #0284c7;']); ?>
                                    <?php else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php 
                                    $order_row = !empty($tiktok_cancellations->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_cancellations->order_id])->row() : null;
                                    if ($order_row): ?>
                                       <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-link">
                                          <?= _ent($tiktok_cancellations->order_id); ?>
                                       </a>
                                    <?php else: ?>
                                       <span style="font-weight: 500; color: #475569;"><?= _ent($tiktok_cancellations->order_id ?: '-'); ?></span>
                                    <?php endif; ?>
                                 </td>
                                 <td style="text-align: center;">
                                    <?php
                                    $ini = strtoupper($tiktok_cancellations->cancel_initiator);
                                    if ($ini === 'BUYER') {
                                       echo '<span class="label label-info">Pembeli</span>';
                                    } elseif ($ini === 'SELLER') {
                                       echo '<span class="label label-primary">Penjual</span>';
                                    } elseif ($ini === 'SYSTEM') {
                                       echo '<span class="label label-warning">Sistem</span>';
                                    } else {
                                       echo '<span class="label label-info">' . _ent($tiktok_cancellations->cancel_initiator ?: '-') . '</span>';
                                    }
                                    ?>
                                 </td>
                                 <td style="text-align: center;">
                                    <?= format_tiktok_cancel_status($tiktok_cancellations->cancel_status); ?>
                                 </td>
                                 <td style="font-size: 12.5px; color: #475569;">
                                    <?= format_tiktok_cancel_reason($tiktok_cancellations->cancel_reason); ?>
                                 </td>
                                 <td style="font-size: 12px; color: #64748b;">
                                    <?= $tiktok_cancellations->cancel_created_time ? date('d/m/Y H:i', strtotime($tiktok_cancellations->cancel_created_time)) : '-'; ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                     <?= render_table_action([
                                        [
                                           'label' => 'Setujui Batal',
                                           'url' => site_url('administrator/tiktok_cancellations/approve/' . $tiktok_cancellations->id),
                                           'icon' => 'fa fa-check',
                                           'icon_color' => '#059669',
                                           'class' => 'btn-approve-cancel',
                                           'attrs' => ['data-cancel-id' => $tiktok_cancellations->cancel_id],
                                           'visible' => in_array(strtoupper($tiktok_cancellations->cancel_status), ['AWAITING_SELLER_REVIEW', 'PENDING', 'CANCELLATION_REQUEST_PENDING', 'REVIEWING']),
                                        ],
                                        [
                                           'label' => 'Tolak Batal',
                                           'url' => 'javascript:void(0);',
                                           'icon' => 'fa fa-times',
                                           'icon_color' => '#ef4444',
                                           'class' => 'item-danger btn-reject-cancel-modal',
                                           'attrs' => [
                                              'data-action' => site_url('administrator/tiktok_cancellations/reject/' . $tiktok_cancellations->id),
                                              'data-cancel-id' => $tiktok_cancellations->cancel_id
                                           ],
                                           'visible' => in_array(strtoupper($tiktok_cancellations->cancel_status), ['AWAITING_SELLER_REVIEW', 'PENDING', 'CANCELLATION_REQUEST_PENDING', 'REVIEWING']),
                                        ],
                                        'view' => [
                                           'url' => site_url('administrator/tiktok_cancellations/view/' . $tiktok_cancellations->id),
                                           'divider' => in_array(strtoupper($tiktok_cancellations->cancel_status), ['AWAITING_SELLER_REVIEW', 'PENDING', 'CANCELLATION_REQUEST_PENDING', 'REVIEWING']),
                                           'permission' => 'tiktok_cancellations_view',
                                        ]
                                     ]); ?>
                                  </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_cancellations_counts == 0): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Data Pembatalan Pesanan tidak ditemukan. Silakan klik tombol "Tarik Data Pembatalan".
                                 </td>
                              </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>

                     <!-- Bottom Toolbar with Precise Compact Gaps -->
                     <div class="box-footer-toolbar">
                        <div class="toolbar-controls-left">
                           <!-- Bulk Action -->
                           <div class="bulk-group">
                              <select class="form-control" name="bulk" id="bulk" style="width: 125px;">
                                 <option value="">Aksi Massal</option>
                                 <option value="delete">Hapus</option>
                              </select>
                              <button type="button" class="btn btn-apply" name="apply" id="apply" title="Terapkan Aksi Massal">
                                 Terapkan
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>

                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="Cari data..." value="<?= $this->input->get('q'); ?>" style="width: 170px;">
                              
                              <select class="form-control" name="f" id="field" style="width: 160px;">
                                 <option value="">Semua Kolom</option>
                                 <option <?= $this->input->get('f') == 'cancel_id' ? 'selected' : ''; ?> value="cancel_id">ID Pembatalan</option>
                                 <option <?= $this->input->get('f') == 'order_id' ? 'selected' : ''; ?> value="order_id">ID Pesanan</option>
                                 <option <?= $this->input->get('f') == 'cancel_status' ? 'selected' : ''; ?> value="cancel_status">Status</option>
                                 <option <?= $this->input->get('f') == 'cancel_reason' ? 'selected' : ''; ?> value="cancel_reason">Alasan</option>
                                 <option <?= $this->input->get('f') == 'cancel_initiator' ? 'selected' : ''; ?> value="cancel_initiator">Inisiator</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="Filter Pencarian">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_cancellations'); ?>" title="Reset Filter">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>

                        <!-- Pagination on Right -->
                        <div class="toolbar-controls-right">
                           <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                              <?= $pagination; ?>
                           </div>
                        </div>
                     </div>

                  </form>
               </div>
               <!-- /.widget-user -->
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
   </div>

   <!-- Modal Tolak Pengajuan Pembatalan -->
   <div class="modal fade" id="modal-reject-cancel" tabindex="-1" role="dialog" aria-labelledby="modalRejectCancelLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <form id="form-reject-cancel" method="POST" action="">
               <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="modalRejectCancelLabel" style="font-weight: 700; color: #1e293b;">Tolak Pengajuan Pembatalan Pesanan</h4>
               </div>
               <div class="modal-body" style="padding: 20px;">
                  <p class="text-muted" style="margin-bottom: 15px; font-size: 13px;">Pilih alasan resmi penolakan pembatalan untuk <span id="modal-cancel-id-label" style="color: #0284c7; font-weight: 600;"></span> sesuai ketentuan TikTok Shop:</p>
                  <div class="form-group">
                     <label style="font-weight: 600; color: #334155; font-size: 13px;">Alasan Penolakan Resmi <span class="text-danger">*</span></label>
                     <select name="reject_reason" id="select-cancel-reject-reason" class="form-control" required style="border-radius: 4px; height: 38px;">
                        <option value="">-- Pilih Alasan Penolakan --</option>
                        <?php if (!empty($reject_reasons)): ?>
                           <?php foreach ($reject_reasons as $reason): ?>
                              <option value="<?= _ent($reason->reason_code); ?>"><?= _ent($reason->reason_text); ?></option>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <option value="seller_reject_cancel_package_shipped">Paket pesanan sudah selesai dipacking dan diserahkan ke pihak kurir</option>
                           <option value="seller_reject_cancel_in_transit">Paket pesanan sedang dalam proses pengiriman oleh kurir logistik</option>
                           <option value="seller_reject_cancel_mutual_agreement">Telah tercapai kesepakatan dengan pembeli untuk tetap melanjutkan pesanan</option>
                           <option value="seller_reject_cancel_out_of_policy">Permintaan pembatalan tidak memenuhi ketentuan syarat dan kebijakan toko</option>
                        <?php endif; ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label style="font-weight: 600; color: #334155; font-size: 13px;">Catatan / Keterangan untuk Pembeli (Opsional)</label>
                     <textarea name="comments" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika diperlukan..." style="border-radius: 4px;"></textarea>
                  </div>
               </div>
               <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 20px;">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 4px; font-weight: 500;">Batal</button>
                  <button type="submit" class="btn btn-danger" style="border-radius: 4px; font-weight: 600;"><i class="fa fa-times"></i> Konfirmasi Tolak Pembatalan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
   $(document).ready(function () {
      // Ensure active dropdown row stays above sibling rows
      $(document).on('show.bs.dropdown', '.action-dropdown', function () {
         $(this).closest('tr').addClass('dropdown-open').css('z-index', 50);
      });

      $(document).on('hide.bs.dropdown', '.action-dropdown', function () {
         $(this).closest('tr').removeClass('dropdown-open').css('z-index', '');
      });

      // Konfirmasi Setujui Pembatalan (Approve)
      $(document).on('click', '.btn-approve-cancel', function (e) {
         e.preventDefault();
         var url = $(this).attr('href');
         var cancelId = $(this).data('cancel-id');
         swal({
            title: "Setujui Pembatalan Pesanan?",
            text: "Anda akan menyetujui pembatalan pesanan (ID: " + cancelId + "). Pesanan akan otomatis dibatalkan di TikTok Shop dan dana dikembalikan ke pembeli.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "Ya, Setujui Pembatalan",
            cancelButtonText: "Batal",
            closeOnConfirm: true
         },
         function (isConfirm) {
            if (isConfirm) {
               document.location.href = url;
            }
         });
         return false;
      });

      // Buka Modal Tolak Pembatalan dengan Alasan Resmi
      $(document).on('click', '.btn-reject-cancel-modal', function (e) {
         e.preventDefault();
         var actionUrl = $(this).data('action');
         var cancelId = $(this).data('cancel-id');
         $('#form-reject-cancel').attr('action', actionUrl);
         $('#modal-cancel-id-label').text('ID: ' + cancelId);
         $('#modal-reject-cancel').modal('show');
      });

      $(document).on('click', '.remove-data', function (e) {
         e.preventDefault();
         var url = $(this).attr('data-href');
         swal({
            title: "Apakah Anda Yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            closeOnCancel: true
         },
         function (isConfirm) {
            if (isConfirm) {
               document.location.href = url;
            }
         });
         return false;
      });

      $('#apply').click(function () {
         var bulk = $('#bulk');
         var serialize_bulk = $('#form_tiktok_cancellations').serialize();

         if (bulk.val() == 'delete') {
            swal({
               title: "Apakah Anda Yakin?",
               text: "Data yang dipilih akan dihapus permanen!",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Ya, Hapus!",
               cancelButtonText: "Batal",
               closeOnConfirm: true,
               closeOnCancel: true
            },
            function (isConfirm) {
               if (isConfirm) {
                  document.location.href = BASE_URL + '/administrator/tiktok_cancellations/delete?' + serialize_bulk;
               }
            });
            return false;
         } else if (bulk.val() == '') {
            swal({
               title: "Perhatian",
               text: "Silakan pilih aksi massal terlebih dahulu.",
               type: "warning"
            });
            return false;
         }
         return false;
      });

      //check all
      var checkAll = $('#check_all');
      var checkboxes = $('input.check');

      checkAll.on('ifChecked ifUnchecked', function (event) {
         if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
         } else {
            checkboxes.iCheck('uncheck');
         }
      });

      checkboxes.on('ifChanged', function (event) {
         if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
         } else {
            checkAll.removeProp('checked');
         }
         checkAll.iCheck('update');
      });
      // Filter toko
      $('#shop_id_filter').on('change', function () {
         var shop_id = $(this).val();
         var url = '<?= site_url("administrator/tiktok_cancellations"); ?>';
         var params = [];
         if (shop_id) {
            params.push('shop_id=' + encodeURIComponent(shop_id));
         }
         <?php if ($this->input->get('q')): ?>
            params.push('q=<?= urlencode($this->input->get('q')); ?>');
         <?php endif; ?>
         <?php if ($this->input->get('f')): ?>
            params.push('f=<?= urlencode($this->input->get('f')); ?>');
         <?php endif; ?>
         if (params.length > 0) {
            url += '?' + params.join('&');
         }
         window.location.href = url;
      });

   });
</script>
