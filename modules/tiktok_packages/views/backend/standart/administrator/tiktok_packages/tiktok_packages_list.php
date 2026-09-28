<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+a', function assets() {
      window.location.href = BASE_URL + '/administrator/tiktok_packages/add';
      return false;
   });

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
.box-tiktok-packages {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-packages .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-packages .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-packages .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-packages .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-packages .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-packages .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-packages .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-packages .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-packages .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-packages .btn-top-action {
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

.box-tiktok-packages .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-packages .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}



.box-tiktok-packages .table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-packages .table-minimal thead th {
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

.box-tiktok-packages .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-packages .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-tiktok-packages .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

.box-tiktok-packages .table-minimal tbody tr.dropdown-open {
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
      <?= cclang('tiktok_packages') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_packages') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-packages">
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
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_packages') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              <?= cclang('list_all', [cclang('tiktok_packages')]); ?> 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_packages_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <a class="btn btn-top-action" id="btn_sync" href="<?= site_url('administrator/tiktok_packages/sync'); ?>" title="Tarik Data Paket dari TikTok Shop">
                           <i class="fa fa-refresh"></i> Tarik Data Paket
                        </a>
                        <?php is_allowed('tiktok_packages_add', function () { ?>
                        <a class="btn btn-top-action btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('tiktok_packages')]); ?> (Ctrl+a)" href="<?= site_url('administrator/tiktok_packages/add'); ?>">
                           <i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', [cclang('tiktok_packages')]); ?>
                        </a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_packages_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_packages/export'); ?>">
                           <i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS
                        </a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_packages_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/tiktok_packages/export_pdf'); ?>">
                           <i class="fa fa-file-pdf-o"></i> <?= cclang('export'); ?> PDF
                        </a>
                        <?php }) ?>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_packages" id="form_tiktok_packages" action="<?= base_url('administrator/tiktok_packages/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="width: 130px;">ID Paket</th>
                                 <th style="width: 130px;">ID Pesanan</th>
                                 <th style="width: 130px;">Kurir Logistik</th>
                                 <th style="width: 120px;">Nomor Resi</th>
                                 <th style="width: 115px; text-align: center;">Metode Serah Terima</th>
                                 <th style="width: 95px; text-align: center;">Status Paket</th>
                                 <th style="width: 115px;">Waktu Dibuat</th>
                                 <th style="width: 48px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_packages">
                              <?php foreach ($tiktok_packagess as $tiktok_packages): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_packages->id; ?>">
                                 </td>
                                 <td>
                                    <span class="chip-id"><?= _ent($tiktok_packages->package_id); ?></span>
                                 </td>
                                 <td>
                                    <?php 
                                    $order_row = !empty($tiktok_packages->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_packages->order_id])->row() : null;
                                    if ($order_row): ?>
                                       <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-link">
                                          <?= _ent($tiktok_packages->order_id); ?>
                                       </a>
                                    <?php else: ?>
                                       <span style="font-weight: 500; color: #475569;"><?= _ent($tiktok_packages->order_id ?: '-'); ?></span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <div style="font-weight: 500; color: #1e293b;"><?= _ent($tiktok_packages->shipping_provider_name ?: '-'); ?></div>
                                    <?php if (!empty($tiktok_packages->delivery_option_name)): ?>
                                       <small class="text-muted" style="font-size: 11px;"><?= _ent($tiktok_packages->delivery_option_name); ?></small>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <span style="font-family: monospace; font-size: 12.5px;"><?= _ent($tiktok_packages->tracking_number ?: '-'); ?></span>
                                 </td>
                                 <td style="text-align: center;">
                                    <?php
                                    $hm = strtoupper($tiktok_packages->handover_method);
                                    if ($hm === 'PICKUP') {
                                       echo '<span class="label label-info">Penjemputan</span>';
                                    } elseif ($hm === 'DROP_OFF') {
                                       echo '<span class="label label-warning">Antar ke Gerai</span>';
                                    } else {
                                       echo '<span class="label label-primary">' . _ent($tiktok_packages->handover_method ?: '-') . '</span>';
                                    }
                                    ?>
                                 </td>
                                 <td style="text-align: center;">
                                    <?php
                                    $st = strtoupper($tiktok_packages->package_status);
                                    if ($st === 'COMPLETED' || $st === 'DELIVERED') {
                                       echo '<span class="label label-success">Selesai</span>';
                                    } elseif ($st === 'FULFILLING') {
                                       echo '<span class="label label-warning">Sedang Diproses</span>';
                                    } elseif ($st === 'AWAITING_SHIPMENT') {
                                       echo '<span class="label label-warning">Perlu Dikirim</span>';
                                    } elseif ($st === 'AWAITING_COLLECTION') {
                                       echo '<span class="label label-info">Menunggu Penjemputan</span>';
                                    } elseif ($st === 'IN_TRANSIT') {
                                       echo '<span class="label label-info">Dalam Perjalanan</span>';
                                    } elseif ($st === 'CANCELLED') {
                                       echo '<span class="label label-danger">Dibatalkan</span>';
                                    } else {
                                       echo '<span class="label label-primary">' . _ent($st ?: '-') . '</span>';
                                    }
                                    ?>
                                 </td>
                                 <td style="font-size: 12px; color: #64748b;">
                                    <?= _ent($tiktok_packages->package_create_time ?: '-'); ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                    <div class="dropdown action-dropdown">
                                       <button type="button" class="btn btn-action-dots dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Menu Aksi">
                                          <i class="fa fa-ellipsis-v"></i>
                                       </button>
                                       <ul class="dropdown-menu dropdown-menu-right action-dropdown-menu">
                                          <?php is_allowed('tiktok_packages_view', function () use ($tiktok_packages) { ?>
                                          <li>
                                             <a href="<?= site_url('administrator/tiktok_packages/view/' . $tiktok_packages->id); ?>" class="dropdown-item-action">
                                                <i class="fa fa-newspaper-o" style="color: #64748b;"></i> <?= cclang('view_button'); ?>
                                             </a>
                                          </li>
                                          <li>
                                             <a href="<?= site_url('administrator/tiktok_packages/print_label/' . $tiktok_packages->id); ?>" target="_blank" class="dropdown-item-action" title="Cetak Label Resi Pengiriman">
                                                <i class="fa fa-print" style="color: #0284c7;"></i> Cetak Label
                                             </a>
                                          </li>
                                          <?php }) ?>
                                          <?php if (in_array(strtoupper($tiktok_packages->package_status), ['FULFILLING', 'AWAITING_SHIPMENT'])): ?>
                                          <li>
                                             <a href="<?= site_url('administrator/tiktok_packages/ship/' . $tiktok_packages->id); ?>" onclick="return confirm('Konfirmasi serah terima pengiriman paket ini ke kurir?');" class="dropdown-item-action" title="Kirim Paket">
                                                <i class="fa fa-truck" style="color: #059669;"></i> Kirim Paket
                                             </a>
                                          </li>
                                          <?php endif; ?>
                                          <?php is_allowed('tiktok_packages_delete', function () use ($tiktok_packages) { ?>
                                          <li class="divider"></li>
                                          <li>
                                             <a href="javascript:void(0);" data-href="<?= site_url('administrator/tiktok_packages/delete/' . $tiktok_packages->id); ?>" class="dropdown-item-action item-danger remove-data">
                                                <i class="fa fa-trash-o" style="color: #ef4444;"></i> <?= cclang('remove_button'); ?>
                                             </a>
                                          </li>
                                          <?php }) ?>
                                       </ul>
                                    </div>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_packages_counts == 0): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Belum ada data paket pengiriman. Silakan klik tombol "Tarik Data Paket".
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
                                 <option <?= $this->input->get('f') == 'package_id' ? 'selected' : ''; ?> value="package_id">ID Paket</option>
                                 <option <?= $this->input->get('f') == 'order_id' ? 'selected' : ''; ?> value="order_id">ID Pesanan</option>
                                 <option <?= $this->input->get('f') == 'tracking_number' ? 'selected' : ''; ?> value="tracking_number">Nomor Resi</option>
                                 <option <?= $this->input->get('f') == 'shipping_provider_name' ? 'selected' : ''; ?> value="shipping_provider_name">Kurir</option>
                                 <option <?= $this->input->get('f') == 'package_status' ? 'selected' : ''; ?> value="package_status">Status</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="Filter Pencarian">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_packages'); ?>" title="Reset Filter">
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
         var serialize_bulk = $('#form_tiktok_packages').serialize();

         if (bulk.val() == 'delete') {
            swal({
               title: "Apakah Anda Yakin?",
               text: "Data yang dipilih akan dihapus secara permanen!",
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
                  document.location.href = BASE_URL + '/administrator/tiktok_packages/delete?' + serialize_bulk;
               }
            });

            return false;
         } else if (bulk.val() == '') {
            swal({
               title: "Perhatian",
               text: "Silakan pilih tindakan massal terlebih dahulu.",
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
