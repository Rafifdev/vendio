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
.box-tiktok-orders {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-orders .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-orders .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-orders .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-orders .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-orders .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-orders .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-orders .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-orders .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-orders .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-orders .btn-top-action {
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

.box-tiktok-orders .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling: Contained within card, no spilling! */
.box-tiktok-orders .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}

.box-tiktok-orders .table-minimal {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
   table-layout: auto;
}

.box-tiktok-orders .table-minimal thead th {
   background-color: #f8fafc;
   color: #64748b;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.03em;
   border-top: none;
   border-bottom: 2px solid #e2e8f0;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   vertical-align: middle;
}

.box-tiktok-orders .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 12.5px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-orders .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-tiktok-orders .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

.box-tiktok-orders .table-minimal tbody tr.dropdown-open {
   z-index: 50;
}

/* Subtle Column Chips & Tags */
.chip-id {
   font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
   font-size: 12px;
   color: #0284c7;
   background-color: #f0f9ff;
   border: 1px solid #bae6fd;
   padding: 3px 8px;
   border-radius: 4px;
   display: inline-flex;
   align-items: center;
   gap: 6px;
   text-decoration: none !important;
   font-weight: 600;
   white-space: nowrap;
   cursor: pointer;
   user-select: none;
   transition: all 0.15s ease;
}

.chip-id:hover {
   background-color: #e0f2fe;
   color: #0369a1;
}

.chip-id .copy-icon {
   font-size: 11px;
   color: #0284c7;
   opacity: 0.7;
   transition: all 0.15s ease;
}

.chip-id:hover .copy-icon {
   opacity: 1;
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
   width: 30px !important;
   height: 30px !important;
   min-width: 30px !important;
   padding: 0 !important;
   font-size: 14px !important;
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
   top: calc(100% + 4px) !important;
   right: 0 !important;
   left: auto !important;
   min-width: 180px !important;
   padding: 6px 0 !important;
   margin: 0 !important;
   background: #ffffff !important;
   border: 1px solid #e2e8f0 !important;
   border-radius: 8px !important;
   box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.06) !important;
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
      <?= cclang('tiktok_orders') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_orders') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-orders">
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
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_orders') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              <?= cclang('list_all', [cclang('tiktok_orders')]); ?> 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_orders_counts; ?> <?= cclang('items'); ?></span>
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
                        <?php is_allowed('tiktok_orders_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_orders/export'); ?>">
                           <i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS
                        </a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_orders_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/tiktok_orders/export_pdf'); ?>">
                           <i class="fa fa-file-pdf-o"></i> <?= cclang('export'); ?> PDF
                        </a>
                        <?php }) ?>
                        <a class="btn btn-top-action" id="btn_sync" style="width: 34px !important; padding: 0 !important; justify-content: center !important;" title="Tarik Data Pesanan dari TikTok Shop" href="<?= site_url('administrator/tiktok_orders/sync' . (!empty($selected_shop_id) ? '?shop_id=' . $selected_shop_id : '')); ?>">
                           <i class="fa fa-refresh"></i>
                        </a>
                     </div>
                  </div>

                  <!-- Horizontal Status Navigation Tabs (Sesuai Seller Center) -->
                  <div class="order-status-tabs" style="padding: 12px 25px 0 25px; background: #ffffff; border-bottom: 1px solid #edf2f7; display: flex; gap: 8px; overflow-x: auto;">
                     <?php
                     $tabs = [
                        'ALL' => [
                           'label' => 'Semua',
                           'count' => $status_counters['ALL'] ?? 0,
                           'match' => ['ALL'],
                        ],
                        'AWAITING_SHIPMENT' => [
                           'label' => 'Perlu dikirim',
                           'count' => $status_counters['AWAITING_SHIPMENT'] ?? 0,
                           'match' => ['AWAITING_SHIPMENT', 'TO_SHIP', 'AWAITING_COLLECTION'],
                        ],
                        'IN_TRANSIT' => [
                           'label' => 'Dikirim',
                           'count' => $status_counters['IN_TRANSIT'] ?? 0,
                           'match' => ['IN_TRANSIT', 'SHIPPED', 'PARTIALLY_SHIPPING', 'DELIVERED'],
                        ],
                        'COMPLETED' => [
                           'label' => 'Selesai',
                           'count' => $status_counters['COMPLETED'] ?? 0,
                           'match' => ['COMPLETED'],
                        ],
                        'IN_PROCESS' => [
                           'label' => 'Dalam proses',
                           'count' => $status_counters['IN_PROCESS'] ?? 0,
                           'match' => ['IN_PROCESS', 'PROCESSING', 'UNPAID', 'ON_HOLD'],
                        ],
                        'CANCELLED' => [
                           'label' => 'Dibatalkan',
                           'count' => $status_counters['CANCELLED'] ?? 0,
                           'match' => ['CANCELLED'],
                        ],
                        'DELIVERY_FAILED' => [
                           'label' => 'Pengantaran gagal',
                           'count' => $status_counters['DELIVERY_FAILED'] ?? 0,
                           'match' => ['DELIVERY_FAILED', 'UNDELIVERED', 'FAILED'],
                        ],
                     ];

                     $curr_status = strtoupper(trim((string)($selected_status ?? 'AWAITING_SHIPMENT')));
                     foreach ($tabs as $st_key => $tab_data):
                        $is_active = in_array($curr_status, $tab_data['match'], true);
                        $tab_url = site_url('administrator/tiktok_orders') . ($st_key !== 'ALL' ? '?status=' . $st_key : '?status=ALL') . (!empty($selected_shop_id) ? '&shop_id=' . $selected_shop_id : '');
                     ?>
                        <a href="<?= $tab_url; ?>" style="display: inline-flex; align-items: center; gap: 4px; padding: 10px 16px; font-size: 13px; font-weight: <?= $is_active ? '700' : '500'; ?>; color: <?= $is_active ? '#00a65a' : '#64748b'; ?>; border-bottom: 2.5px solid <?= $is_active ? '#00a65a' : 'transparent'; ?>; text-decoration: none !important; white-space: nowrap; transition: all 0.15s ease;">
                           <?= $tab_data['label']; ?> (<?= $tab_data['count']; ?>)
                        </a>
                     <?php endforeach; ?>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_orders" id="form_tiktok_orders" action="<?= base_url('administrator/tiktok_orders/index'); ?>">
                     <?php if (!empty($selected_shop_id)): ?>
                        <input type="hidden" name="shop_id" value="<?= $selected_shop_id; ?>">
                     <?php endif; ?>
                     <?php if (!empty($selected_status)): ?>
                        <input type="hidden" name="status" value="<?= $selected_status; ?>">
                     <?php endif; ?>
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 35px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="width: 110px;">Nama Toko</th>
                                 <th style="width: 135px; white-space: nowrap;">ID Pesanan</th>
                                 <th style="width: 110px;">Nama Pembeli</th>
                                 <th style="width: 280px;">Produk</th>
                                 <th style="width: 105px; text-align: center; white-space: nowrap;">Status Pesanan</th>
                                 <th style="width: 115px;">Metode Kirim</th>
                                 <th style="width: 120px;">Opsi Kirim</th>
                                 <th style="width: 100px; text-align: right; white-space: nowrap;">Total Bayar</th>
                                 <th style="width: 45px; text-align: center; white-space: nowrap;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_orders">
                              <?php foreach ($tiktok_orderss as $tiktok_orders): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_orders->id; ?>">
                                 </td>
                                 <td>
                                    <?php if ($tiktok_orders->tiktok_shop_id): ?>
                                       <?= anchor('administrator/tiktok_shops/view/' . $tiktok_orders->tiktok_shop_id . '?popup=show', $tiktok_orders->tiktok_shops_shop_name, ['class' => 'popup-view', 'style' => 'font-weight: 500; color: #0284c7; font-size: 12.5px;']); ?>
                                    <?php else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td style="white-space: nowrap;">
                                    <span class="chip-id btn-copy-order-id" data-id="<?= _ent($tiktok_orders->order_id); ?>" title="Klik untuk menyalin ID Pesanan" role="button">
                                       <?= _ent($tiktok_orders->order_id); ?>
                                       <i class="fa fa-copy copy-icon"></i>
                                    </span>
                                 </td>
                                 <td>
                                    <div style="font-weight: 600; color: #1e293b; font-size: 12.5px;"><?= _ent($tiktok_orders->recipient_name ?: '-'); ?></div>
                                    <?php if (!empty($tiktok_orders->recipient_phone)): ?>
                                       <small class="text-muted" style="font-size: 11px;"><?= _ent($tiktok_orders->recipient_phone); ?></small>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php if (!empty($tiktok_orders->items)): ?>
                                       <?php foreach ($tiktok_orders->items as $item): ?>
                                          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                             <?php if (!empty($item->sku_image)): ?>
                                                <img src="<?= $item->sku_image; ?>" style="width: 34px; height: 34px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0; flex-shrink: 0;" alt="item">
                                             <?php endif; ?>
                                             <div style="flex-grow: 1; min-width: 0;">
                                                <div style="font-size: 12px; font-weight: 500; color: #334155; line-height: 1.3;"><?= _ent($item->product_name); ?></div>
                                                <?php if (!empty($item->seller_sku)): ?>
                                                   <small class="text-muted" style="font-size: 10.5px;">(SKU: <?= _ent($item->seller_sku); ?>)</small>
                                                <?php endif; ?>
                                             </div>
                                          </div>
                                       <?php endforeach; ?>
                                    <?php else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                    <?= render_order_status_badge($tiktok_orders->order_status); ?>
                                 </td>
                                 <td>
                                    <div style="font-weight: 500; color: #334155; font-size: 12px;"><?= _ent($tiktok_orders->shipping_type ?: '-'); ?></div>
                                    <?php if (!empty($tiktok_orders->shipping_provider)): ?>
                                       <small class="text-muted" style="font-size: 11px;"><?= _ent($tiktok_orders->shipping_provider); ?></small>
                                    <?php endif; ?>
                                 </td>
                                 <td style="font-size: 12px;"><?= _ent($tiktok_orders->delivery_option_name ?: '-'); ?></td>
                                 <td style="text-align: right; font-weight: 600; color: #1e293b; white-space: nowrap;">
                                    Rp <?= number_format($tiktok_orders->total_amount, 0, ',', '.'); ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                     <?= render_table_action([
                                        'view' => [
                                           'url' => site_url('administrator/tiktok_orders/view/' . $tiktok_orders->id),
                                           'permission' => 'tiktok_orders_view',
                                        ],
                                        'pdf' => [
                                           'url' => site_url('administrator/tiktok_orders/single_pdf/' . $tiktok_orders->id),
                                           'permission' => 'tiktok_orders_view',
                                        ],
                                        [
                                           'label' => 'Atur Pengiriman',
                                           'url' => site_url('administrator/tiktok_orders/ship/' . $tiktok_orders->id),
                                           'icon' => 'fa fa-truck',
                                           'icon_color' => '#059669',
                                           'visible' => ($tiktok_orders->order_status == 'AWAITING_SHIPMENT'),
                                           'permission' => 'tiktok_orders_view',
                                           'divider' => true,
                                        ],
                                        [
                                           'label' => 'Label Resi (AWB)',
                                           'url' => site_url('administrator/tiktok_orders/print_label/' . $tiktok_orders->id),
                                           'icon' => 'fa fa-barcode',
                                           'icon_color' => '#0d9488',
                                           'attrs' => ['target' => '_blank'],
                                           'visible' => in_array($tiktok_orders->order_status, ['AWAITING_COLLECTION', 'IN_TRANSIT', 'DELIVERED', 'COMPLETED']),
                                           'permission' => 'tiktok_orders_view',
                                        ],
                                        [
                                           'label' => 'Daftar Pengemasan',
                                           'url' => site_url('administrator/tiktok_orders/print_packing_slip/' . $tiktok_orders->id),
                                           'icon' => 'fa fa-archive',
                                           'icon_color' => '#6366f1',
                                           'attrs' => ['target' => '_blank'],
                                           'visible' => in_array($tiktok_orders->order_status, ['AWAITING_COLLECTION', 'IN_TRANSIT', 'DELIVERED', 'COMPLETED']),
                                           'permission' => 'tiktok_orders_view',
                                        ],
                                        [
                                           'label' => 'Pick List',
                                           'url' => site_url('administrator/tiktok_orders/print_pick_list/' . $tiktok_orders->id),
                                           'icon' => 'fa fa-clipboard',
                                           'icon_color' => '#8b5cf6',
                                           'attrs' => ['target' => '_blank'],
                                           'permission' => 'tiktok_orders_view',
                                        ],
                                        [
                                           'label' => 'Batalkan Pesanan',
                                           'url' => 'javascript:void(0);',
                                           'icon' => 'fa fa-ban',
                                           'icon_color' => '#ef4444',
                                           'class' => 'item-danger cancel-data',
                                           'data_href' => site_url('administrator/tiktok_orders/cancel/' . $tiktok_orders->id),
                                           'divider' => true,
                                           'visible' => ($tiktok_orders->order_status != 'CANCELLED'),
                                           'permission' => 'tiktok_orders_delete',
                                        ]
                                     ]); ?>
                                  </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_orders_counts == 0): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Belum ada data pesanan TikTok. Silakan klik tombol "Tarik Data Pesanan".
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
                              <select class="form-control" name="bulk" id="bulk" style="width: 145px;">
                                 <option value="">Aksi Massal</option>
                                 <option value="cancel">Batalkan</option>
                                 <option value="pick_list">Cetak Pick List</option>
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
                                 <option <?= $this->input->get('f') == 'order_id' ? 'selected' : ''; ?> value="order_id">ID Pesanan</option>
                                 <option <?= $this->input->get('f') == 'tiktok_shop_id' ? 'selected' : ''; ?> value="tiktok_shop_id">Nama Toko</option>
                                 <option <?= $this->input->get('f') == 'recipient_name' ? 'selected' : ''; ?> value="recipient_name">Nama Pembeli</option>
                                 <option <?= $this->input->get('f') == 'order_status' ? 'selected' : ''; ?> value="order_status">Status Pesanan</option>
                                 <option <?= $this->input->get('f') == 'shipping_type' ? 'selected' : ''; ?> value="shipping_type">Metode Pengiriman</option>
                                 <option <?= $this->input->get('f') == 'delivery_option_name' ? 'selected' : ''; ?> value="delivery_option_name">Opsi Pengiriman</option>
                                 <option <?= $this->input->get('f') == 'shipping_provider' ? 'selected' : ''; ?> value="shipping_provider">Kurir Pengiriman</option>
                                 <option <?= $this->input->get('f') == 'tracking_number' ? 'selected' : ''; ?> value="tracking_number">Nomor Resi</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_orders'); ?>" title="<?= cclang('reset_filter'); ?>">
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

      $(document).on('click', '.cancel-data', function (e) {
         e.preventDefault();
         var url = $(this).attr('data-href');

         swal({
            title: "Batalkan Pesanan?",
            text: "Pesanan ini akan dibatalkan di TikTok Shop dan Vendio. Apakah Anda yakin?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Batalkan!",
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
         var serialize_bulk = $('#form_tiktok_orders').serialize();

         if (bulk.val() == 'pick_list') {
            var checked_ids = [];
            $('input.check:checked').each(function () {
               checked_ids.push($(this).val());
            });
            if (checked_ids.length == 0) {
               swal('Peringatan', 'Silakan pilih minimal 1 pesanan untuk dicetak!', 'warning');
               return false;
            }
            window.open(BASE_URL + '/administrator/tiktok_orders/print_bulk_pick_list?ids=' + checked_ids.join(','), '_blank');
            return false;
         } else if (bulk.val() == 'cancel' || bulk.val() == 'delete') {
            swal({
               title: "Batalkan Pesanan Terpilih?",
               text: "Semua pesanan terpilih akan dibatalkan di TikTok Shop dan Vendio. Lanjutkan?",
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
                  document.location.href = BASE_URL + '/administrator/tiktok_orders/cancel?' + serialize_bulk;
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
      // Copy ID Pesanan satu-klik dengan transisi ikon ceklis
      function copyOrderId(text, callback) {
         if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function () {
               if (typeof callback === 'function') callback();
            }).catch(function () {
               fallbackCopyOrderId(text, callback);
            });
         } else {
            fallbackCopyOrderId(text, callback);
         }
      }

      function fallbackCopyOrderId(text, callback) {
         var tempInput = document.createElement("textarea");
         tempInput.style.position = "fixed";
         tempInput.style.left = "-9999px";
         tempInput.value = text;
         document.body.appendChild(tempInput);
         tempInput.select();
         try {
            var successful = document.execCommand('copy');
            if (successful && typeof callback === 'function') {
               callback();
            }
         } catch (err) {}
         document.body.removeChild(tempInput);
      }

      $(document).on('click', '.btn-copy-order-id', function (e) {
         e.preventDefault();
         e.stopPropagation();
         var btn = $(this);
         var id = btn.attr('data-id') || btn.text().trim();
         var icon = btn.find('.copy-icon');

         if (!id) return;

         copyOrderId(id, function () {
            
            icon.removeClass('fa-copy fa-clone').addClass('fa-check');
            toastr.success('ID Pesanan ' + id + ' berhasil disalin!');

            setTimeout(function () {
               
               icon.removeClass('fa-check').addClass('fa-copy');
            }, 1500);
         });
      });

      // Filter toko
      $('#shop_id_filter').on('change', function () {
         var shop_id = $(this).val();
         var url = '<?= site_url("administrator/tiktok_orders"); ?>';
         var params = [];
         if (shop_id) {
            params.push('shop_id=' + encodeURIComponent(shop_id));
         }
         <?php if (!empty($selected_status)): ?>
            params.push('status=<?= urlencode($selected_status); ?>');
         <?php endif; ?>
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
