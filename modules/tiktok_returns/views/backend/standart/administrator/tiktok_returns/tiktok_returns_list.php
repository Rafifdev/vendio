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
.box-tiktok-returns {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-returns .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-returns .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-returns .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-returns .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-returns .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-returns .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-returns .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-returns .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-returns .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-returns .btn-top-action {
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

.box-tiktok-returns .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-returns .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}



.box-tiktok-returns .table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-returns .table-minimal thead th {
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

.box-tiktok-returns .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-returns .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-tiktok-returns .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

.box-tiktok-returns .table-minimal tbody tr.dropdown-open {
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
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 5px 11px;
   font-size: 12px;
   font-weight: 500;
   color: #3b82f6;
   background-color: #eff6ff;
   border: 1px solid #bfdbfe;
   border-radius: 4px;
   text-decoration: none !important;
   transition: all 0.15s ease;
}

.action-link:hover {
   background-color: #dbeafe;
   color: #1d4ed8;
   border-color: #93c5fd;
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

.action-dropdown-menu .dropdown-item-action:hover i {
   transform: scale(1.15);
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
      <?= cclang('tiktok_returns') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_returns') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-returns">
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
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_returns') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              <?= cclang('list_all', [cclang('tiktok_returns')]); ?> 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_returns_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <a class="btn btn-top-action btn_add_new" id="btn_sync" title="Tarik Data Retur dari TikTok Shop" href="<?= site_url('administrator/tiktok_returns/sync'); ?>">
                           <i class="fa fa-refresh"></i> Tarik Data Retur
                        </a>
                        <?php is_allowed('tiktok_returns_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_returns/export'); ?>">
                           <i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS
                        </a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_returns_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/tiktok_returns/export_pdf'); ?>">
                           <i class="fa fa-file-pdf-o"></i> <?= cclang('export'); ?> PDF
                        </a>
                        <?php }) ?>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_returns" id="form_tiktok_returns" action="<?= base_url('administrator/tiktok_returns/index'); ?>">
                  
                  <?php
                  if (!function_exists('format_tiktok_return_status')) {
                     function format_tiktok_return_status($status) {
                        switch ($status) {
                           case 'RETURN_OR_REFUND_REQUEST_PENDING':
                              return '<span class="label label-warning">Menunggu Respon Penjual</span>';
                           case 'AWAITING_BUYER_SHIP':
                              return '<span class="label label-warning">Menunggu Pembeli Kirim</span>';
                           case 'BUYER_SHIPPED':
                              return '<span class="label label-info">Sedang Dikembalikan</span>';
                           case 'SELLER_RECEIVE_PACKAGE':
                           case 'RETURN_AND_REFUND_PACKAGE_DELIVERED':
                              return '<span class="label label-primary">Barang Diterima</span>';
                           case 'REFUND_PROCESSING':
                           case 'PROCESSING':
                              return '<span class="label label-info">Proses Refund</span>';
                           case 'COMPLETE':
                           case 'COMPLETED':
                           case 'REFUND_SUCCESS':
                           case 'SUCCESS':
                              return '<span class="label label-success">Selesai</span>';
                           case 'REJECT':
                           case 'REJECTED':
                              return '<span class="label label-danger">Ditolak</span>';
                           case 'CANCEL':
                           case 'CANCELLED':
                              return '<span class="label label-danger">Dibatalkan</span>';
                           default:
                              return '<span class="label label-info">' . ($status ? ucwords(str_replace('_', ' ', strtolower($status))) : '-') . '</span>';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_return_type')) {
                     function format_tiktok_return_type($type) {
                        switch ($type) {
                           case 'RETURN_AND_REFUND':
                              return 'Retur Barang & Dana';
                           case 'REFUND':
                           case 'REFUND_ONLY':
                              return 'Pengembalian Dana';
                           default:
                              return $type ? ucwords(str_replace('_', ' ', strtolower($type))) : '-';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_return_reason')) {
                     function format_tiktok_return_reason($reason) {
                        if (empty($reason)) return '-';
                        $r = strtolower(trim($reason));
                        if (strpos($r, 'damaged') !== false || strpos($r, 'rusak') !== false) {
                           return 'Paket/produk rusak';
                        } elseif (strpos($r, 'does not match') !== false || strpos($r, 'not_match') !== false || strpos($r, 'tidak sesuai') !== false) {
                           return 'Tidak sesuai deskripsi';
                        } elseif (strpos($r, 'wrong') !== false || strpos($r, 'salah') !== false) {
                           return 'Salah kirim produk';
                        } elseif (strpos($r, 'missing') !== false || strpos($r, 'kurang') !== false || strpos($r, 'hilang') !== false) {
                           return 'Komponen/produk kurang';
                        } elseif (strpos($r, 'defective') !== false || strpos($r, 'cacat') !== false) {
                           return 'Produk cacat/tidak berfungsi';
                        } elseif (strpos($r, 'counterfeit') !== false || strpos($r, 'palsu') !== false) {
                           return 'Produk tiruan/palsu';
                        } elseif (strpos($r, 'not received') !== false || strpos($r, 'not_received') !== false || strpos($r, 'belum terima') !== false) {
                           return 'Pesanan belum diterima';
                        } elseif (strpos($r, 'no longer needed') !== false || strpos($r, 'tidak butuh') !== false) {
                           return 'Tidak dibutuhkan lagi';
                        } elseif (strpos($r, 'cheaper') !== false || strpos($r, 'murah') !== false) {
                           return 'Ada harga lebih murah';
                        } elseif (strpos($r, 'late') !== false || strpos($r, 'terlambat') !== false) {
                           return 'Pengiriman terlambat';
                        } elseif (strpos($r, 'mutual') !== false || strpos($r, 'sepakat') !== false) {
                           return 'Kesepakatan bersama';
                        }
                        return _ent($reason);
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
                                 <th style="width: 95px;">Nama Toko</th>
                                 <th style="width: 115px;">ID Pesanan</th>
                                 <th style="width: 110px;">Batas SLA Respon</th>
                                 <th style="width: 220px;">Produk</th>
                                 <th style="width: 95px;">Tipe Retur</th>
                                 <th style="width: 95px; text-align: center;">Status Retur</th>
                                 <th style="width: 110px;">Alasan Retur</th>
                                 <th style="width: 90px; text-align: right;">Nominal Refund</th>
                                 <th style="width: 95px;">Nomor Resi</th>
                                 <th style="width: 95px;">Tgl Pengajuan</th>
                                 <th style="width: 45px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_returns">
                              <?php foreach ($tiktok_returnss as $tiktok_returns): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_returns->id; ?>">
                                 </td>
                                 <td>
                                    <?php if ($tiktok_returns->tiktok_shop_id) {
                                       echo anchor('administrator/tiktok_shops/view/' . $tiktok_returns->tiktok_shop_id . '?popup=show', $tiktok_returns->tiktok_shops_shop_name, ['class' => 'popup-view', 'style' => 'font-weight: 500; color: #0284c7;']);
                                    } else {
                                       echo '-';
                                    } ?>
                                 </td>
                                 <td>
                                    <?php 
                                    $order_row = !empty($tiktok_returns->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_returns->order_id])->row() : null;
                                    if ($order_row): ?>
                                       <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-link">
                                          <?= _ent($tiktok_returns->order_id); ?>
                                       </a>
                                    <?php else: ?>
                                       <span style="font-weight: 500; color: #475569;"><?= _ent($tiktok_returns->order_id ?: '-'); ?></span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php
                                    if (!empty($tiktok_returns->return_created_time) && in_array($tiktok_returns->return_status, ['RETURN_OR_REFUND_REQUEST_PENDING', 'PROCESSING', 'AWAITING_SELLER_REVIEW'])) {
                                       $diff = (strtotime($tiktok_returns->return_created_time) + 172800) - time();
                                       if ($diff <= 0) {
                                          echo '<span class="label label-danger">SLA Lewat (Auto-Approve)</span>';
                                       } elseif ($diff < 21600) {
                                          $hours = floor($diff / 3600);
                                          $mins = floor(($diff % 3600) / 60);
                                          echo '<span class="label label-danger">' . $hours . 'j ' . $mins . 'm tersisa (Kritis)</span>';
                                       } elseif ($diff < 43200) {
                                          $hours = floor($diff / 3600);
                                          $mins = floor(($diff % 3600) / 60);
                                          echo '<span class="label label-warning">' . $hours . 'j ' . $mins . 'm tersisa</span>';
                                       } else {
                                          $hours = floor($diff / 3600);
                                          $mins = floor(($diff % 3600) / 60);
                                          echo '<span class="label label-info">' . $hours . 'j ' . $mins . 'm tersisa</span>';
                                       }
                                    } elseif (in_array($tiktok_returns->return_status, ['AWAITING_BUYER_SHIP', 'BUYER_SHIPPED', 'SELLER_RECEIVE_PACKAGE', 'RETURN_AND_REFUND_PACKAGE_DELIVERED'])) {
                                       echo '<span class="label label-primary">Sudah Direspon</span>';
                                    } elseif (in_array($tiktok_returns->return_status, ['COMPLETE', 'COMPLETED', 'REFUND_SUCCESS', 'SUCCESS'])) {
                                       echo '<span class="label label-success">Selesai Diproses</span>';
                                    } elseif (in_array($tiktok_returns->return_status, ['REJECT', 'REJECTED'])) {
                                       echo '<span class="label label-danger">Ditolak</span>';
                                    } elseif (in_array($tiktok_returns->return_status, ['CANCEL', 'CANCELLED'])) {
                                       echo '<span class="label label-danger">Dibatalkan</span>';
                                    } else {
                                       echo '<span class="label label-info">Tidak Ada SLA</span>';
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <?php 
                                    $items = json_decode($tiktok_returns->items);
                                    if (!empty($items)): 
                                       foreach ($items as $item): 
                                          $img_url = $item->product_image->url ?? ($item->sku_image ?? "");
                                    ?>
                                       <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                          <?php if (!empty($img_url)): ?>
                                             <img src="<?= $img_url; ?>" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0; flex-shrink: 0;" alt="item">
                                          <?php endif; ?>
                                          <div style="flex-grow: 1; min-width: 0;">
                                             <div style="font-size: 12.5px; font-weight: 500; color: #334155; line-height: 1.3;"><?= _ent($item->product_name ?? "-"); ?></div>
                                             <?php if (!empty($item->seller_sku)): ?>
                                                <small class="text-muted" style="font-size: 11px;">(SKU: <?= _ent($item->seller_sku); ?>)</small>
                                             <?php endif; ?>
                                          </div>
                                       </div>
                                    <?php endforeach; 
                                    else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td style="font-weight: 500; color: #334155;">
                                    <?= format_tiktok_return_type($tiktok_returns->return_type); ?>
                                 </td>
                                 <td style="text-align: center;">
                                    <?= format_tiktok_return_status($tiktok_returns->return_status); ?>
                                 </td>
                                 <td style="font-size: 12.5px; color: #475569;">
                                    <?= format_tiktok_return_reason($tiktok_returns->return_reason); ?>
                                 </td>
                                 <td style="text-align: right; font-weight: 600; color: #1e293b;">
                                    Rp <?= number_format($tiktok_returns->refund_amount, 0, ',', '.'); ?>
                                 </td>
                                 <td>
                                    <span style="font-family: monospace; font-size: 12px;"><?= _ent($tiktok_returns->tracking_number ?: '-'); ?></span>
                                 </td>
                                 <td style="font-size: 12px; color: #64748b;">
                                    <?= $tiktok_returns->return_created_time ? date('d/m/Y H:i', strtotime($tiktok_returns->return_created_time)) : '-'; ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                    <?php 
                                    $is_pending = ($tiktok_returns->return_status == 'RETURN_OR_REFUND_REQUEST_PENDING');
                                    ?>
                                    <?php if ($is_pending): ?>
                                       <!-- > 1 actions: Render 3-dots Dropdown -->
                                       <div class="dropdown action-dropdown">
                                          <button type="button" class="btn btn-action-dots dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Menu Aksi">
                                             <i class="fa fa-ellipsis-v"></i>
                                          </button>
                                          <ul class="dropdown-menu dropdown-menu-right action-dropdown-menu">
                                             <li>
                                                <a href="<?= site_url('administrator/tiktok_returns/approve/' . $tiktok_returns->id); ?>" class="dropdown-item-action btn-approve-return" data-return-id="<?= $tiktok_returns->return_id; ?>" title="Setujui pengembalian">
                                                   <i class="fa fa-check" style="color: #059669;"></i> Setujui Retur
                                                </a>
                                             </li>
                                             <li>
                                                <a href="javascript:void(0);" data-id="<?= $tiktok_returns->id; ?>" data-action="<?= site_url('administrator/tiktok_returns/reject/' . $tiktok_returns->id); ?>" data-return-id="<?= $tiktok_returns->return_id; ?>" class="dropdown-item-action item-danger btn-reject-modal" title="Tolak pengembalian">
                                                   <i class="fa fa-times" style="color: #ef4444;"></i> Tolak Retur
                                                </a>
                                             </li>
                                             <li class="divider"></li>
                                             <?php is_allowed('tiktok_returns_view', function () use ($tiktok_returns) { ?>
                                             <li>
                                                <a href="<?= site_url('administrator/tiktok_returns/view/' . $tiktok_returns->id); ?>" class="dropdown-item-action" title="Lihat Rincian">
                                                   <i class="fa fa-newspaper-o" style="color: #64748b;"></i> <?= cclang('view_button'); ?>
                                                </a>
                                             </li>
                                             <?php }) ?>
                                          </ul>
                                       </div>
                                    <?php else: ?>
                                       <!-- 1 action: Clean Single Action Link -->
                                       <?php is_allowed('tiktok_returns_view', function () use ($tiktok_returns) { ?>
                                          <a href="<?= site_url('administrator/tiktok_returns/view/' . $tiktok_returns->id); ?>" class="action-link" title="Lihat Rincian">
                                             <i class="fa fa-newspaper-o"></i> Detail
                                          </a>
                                       <?php }) ?>
                                    <?php endif; ?>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_returns_counts == 0): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Data Retur Penjualan tidak ditemukan. Silakan klik tombol "Tarik Data Retur".
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
                              <button type="button" class="btn btn-apply" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>">
                                 <?= cclang('apply_button'); ?>
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>

                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>..." value="<?= $this->input->get('q'); ?>" style="width: 170px;">
                              
                              <select class="form-control" name="f" id="field" style="width: 165px;">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'tiktok_shop_id' ? 'selected' : ''; ?> value="tiktok_shop_id">Nama Toko</option>
                                 <option <?= $this->input->get('f') == 'return_id' ? 'selected' : ''; ?> value="return_id">ID Retur</option>
                                 <option <?= $this->input->get('f') == 'order_id' ? 'selected' : ''; ?> value="order_id">ID Pesanan</option>
                                 <option <?= $this->input->get('f') == 'return_type' ? 'selected' : ''; ?> value="return_type">Tipe Retur</option>
                                 <option <?= $this->input->get('f') == 'return_status' ? 'selected' : ''; ?> value="return_status">Status Retur</option>
                                 <option <?= $this->input->get('f') == 'return_reason' ? 'selected' : ''; ?> value="return_reason">Alasan Retur</option>
                                 <option <?= $this->input->get('f') == 'refund_amount' ? 'selected' : ''; ?> value="refund_amount">Nominal Refund</option>
                                 <option <?= $this->input->get('f') == 'tracking_number' ? 'selected' : ''; ?> value="tracking_number">Nomor Resi</option>
                                 <option <?= $this->input->get('f') == 'return_created_time' ? 'selected' : ''; ?> value="return_created_time">Tgl Pengajuan</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_returns'); ?>" title="<?= cclang('reset_filter'); ?>">
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

   <!-- Modal Tolak Pengajuan Retur -->
   <div class="modal fade" id="modal-reject-return" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <form id="form-reject-return" method="POST" action="">
               <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 20px;">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="modalRejectLabel" style="font-weight: 700; color: #1e293b;">Tolak Pengajuan Retur</h4>
               </div>
               <div class="modal-body" style="padding: 20px;">
                  <p class="text-muted" style="margin-bottom: 15px; font-size: 13px;">Pilih alasan resmi penolakan untuk pengajuan retur <span id="modal-return-id-label" style="color: #0284c7; font-weight: 600;"></span> sesuai ketentuan TikTok Shop:</p>
                  <div class="form-group">
                     <label style="font-weight: 600; color: #334155; font-size: 13px;">Alasan Penolakan Resmi <span class="text-danger">*</span></label>
                     <select name="reject_reason" id="select-reject-reason" class="form-control" required style="border-radius: 4px; height: 38px;">
                        <option value="">-- Pilih Alasan Penolakan --</option>
                        <?php if (!empty($reject_reasons)): ?>
                           <?php foreach ($reject_reasons as $reason): ?>
                              <option value="<?= _ent($reason->reason_code); ?>"><?= _ent($reason->reason_text); ?></option>
                           <?php endforeach; ?>
                        <?php else: ?>
                           <option value="seller_reject_reason_buyer_reason_not_valid">Alasan pembeli tidak valid atau tidak sesuai kondisi sebenarnya</option>
                           <option value="seller_reject_reason_package_delivered_in_good_condition">Paket dan produk telah terkirim dalam kondisi baik dan lengkap</option>
                           <option value="seller_reject_reason_insufficient_evidence">Bukti foto atau video unboxing yang dilampirkan pembeli tidak memadai</option>
                           <option value="seller_reject_reason_mutual_agreement">Telah tercapai kesepakatan solusi alternatif bersama pembeli</option>
                        <?php endif; ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label style="font-weight: 600; color: #334155; font-size: 13px;">Catatan / Keterangan untuk Pembeli (Opsional)</label>
                     <textarea name="comments" class="form-control" rows="3" placeholder="Tuliskan penjelasan tambahan jika diperlukan..." style="border-radius: 4px;"></textarea>
                  </div>
               </div>
               <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 20px;">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 4px; font-weight: 500;">Batal</button>
                  <button type="submit" class="btn btn-danger" style="border-radius: 4px; font-weight: 600;"><i class="fa fa-times"></i> Konfirmasi Tolak Retur</button>
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

      // Konfirmasi Setujui Retur (Approve)
      $(document).on('click', '.btn-approve-return', function (e) {
         e.preventDefault();
         var url = $(this).attr('href');
         var returnId = $(this).data('return-id');
         swal({
            title: "Setujui Retur?",
            text: "Anda akan menyetujui pengajuan pengembalian (ID: " + returnId + "). Pembeli akan diinstruksikan untuk mengirimkan barang ke alamat toko Anda.",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "Ya, Setujui",
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

      // Buka Modal Tolak Retur dengan Alasan Resmi
      $(document).on('click', '.btn-reject-modal', function (e) {
         e.preventDefault();
         var actionUrl = $(this).data('action');
         var returnId = $(this).data('return-id');
         $('#form-reject-return').attr('action', actionUrl);
         $('#modal-return-id-label').text('ID: ' + returnId);
         $('#modal-reject-return').modal('show');
      });

      $(document).on('click', '.remove-data', function (e) {
         e.preventDefault();
         var url = $(this).attr('data-href');
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
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
         var serialize_bulk = $('#form_tiktok_returns').serialize();

         if (bulk.val() == 'delete') {
            swal({
               title: "<?= cclang('are_you_sure'); ?>",
               text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
               cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
               closeOnConfirm: true,
               closeOnCancel: true
            },
            function (isConfirm) {
               if (isConfirm) {
                  document.location.href = BASE_URL + '/administrator/tiktok_returns/delete?' + serialize_bulk;
               }
            });
            return false;
         } else if (bulk.val() == '') {
            swal({
               title: "Upss",
               text: "<?= cclang('please_choose_bulk_action_first'); ?>",
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

   });
</script>
