<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   // Binding keys
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Tiktok_shops/add';
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
.box-tiktok-shops {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-shops .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-shops .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-shops .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-shops .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-shops .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-shops .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-shops .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-shops .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-shops .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-shops .btn-top-action {
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

.box-tiktok-shops .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-shops .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}

.box-tiktok-shops .table-minimal tbody tr {
   position: relative;
}

.box-tiktok-shops .table-minimal tbody tr.dropdown-open {
   z-index: 50;
}

.box-tiktok-shops .table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-shops .table-minimal thead th {
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

.box-tiktok-shops .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-shops .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

/* Subtle Column Chips & Tags */
.chip-id {
   font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
   font-size: 12px;
   color: #475569;
   background: #f1f5f9;
   padding: 3px 8px;
   border-radius: 4px;
   border: 1px solid #e2e8f0;
   display: inline-block;
}

.chip-region {
   display: inline-block;
   padding: 2px 8px;
   border-radius: 4px;
   font-weight: 600;
   font-size: 11px;
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   color: #334155;
}

/* Perfect Vertical Alignment for Token Expiry Clock Icon */
.token-expiry-wrap {
   display: inline-flex !important;
   align-items: center !important;
   gap: 6px !important;
   color: #475569 !important;
   font-size: 13px !important;
   line-height: 1 !important;
   vertical-align: middle !important;
}

.token-expiry-wrap i.fa-clock-o {
   color: #94a3b8 !important;
   font-size: 13px !important;
   line-height: 1 !important;
   display: inline-block !important;
   position: relative !important;
   top: 0.5px !important;
}

.token-expiry-wrap .expiry-date-text {
   line-height: 1 !important;
   display: inline-block !important;
   font-size: 13px !important;
}

/* Soft Modern Status Badges */
.badge-status-pill {
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 3px 10px;
   border-radius: 12px;
   font-size: 11px;
   font-weight: 600;
}

.badge-status-active {
   background-color: #ecfdf5;
   color: #059669;
   border: 1px solid #a7f3d0;
}

.badge-status-inactive {
   background-color: #fef2f2;
   color: #dc2626;
   border: 1px solid #fecaca;
}

.status-dot {
   width: 6px;
   height: 6px;
   border-radius: 50%;
   display: inline-block;
}

.badge-status-active .status-dot {
   background-color: #10b981;
}

.badge-status-inactive .status-dot {
   background-color: #ef4444;
}

.badge-minimal-danger {
   background-color: #dd4b39;
   color: #fff;
   padding: 2px 7px;
   border-radius: 4px;
   font-size: 11px;
   font-weight: 600;
   display: inline-block;
}

/* Action Dropdown: Ultra-Smooth, Elegant & Refined */
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

/* Dropdown Menu Container with Smooth Motion */
.action-dropdown .action-dropdown-menu {
   position: absolute !important;
   top: calc(100% + 5px) !important;
   right: 0 !important;
   left: auto !important;
   min-width: 175px !important;
   padding: 6px 0 !important;
   margin: 0 !important;
   background: #ffffff !important;
   border: 1px solid #e2e8f0 !important;
   border-radius: 8px !important;
   box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.06) !important;
   list-style: none !important;
   z-index: 1050 !important;
   text-align: left !important;
   
   /* Smooth Entrance/Exit Animations */
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

/* Consistent Control Heights & Borders */
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

/* Pagination container */
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
      <?= cclang('tiktok_shops') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_shops') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-shops">
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
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_shops') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              <?= cclang('list_all', [cclang('tiktok_shops')]); ?> 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_shops_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <?php is_allowed('tiktok_shops_add', function(){?>
                        <a class="btn btn-top-action btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('tiktok_shops')]); ?> (Ctrl+a)" href="<?= site_url('administrator/tiktok_shops/add'); ?>">
                           <i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', [cclang('tiktok_shops')]); ?>
                        </a>
                        <?php if (!empty($active_remaining_seconds) && $active_remaining_seconds > 0): ?>
                        <a class="btn btn-top-action" id="btn_connect_tiktok" href="javascript:void(0);" title="Link otorisasi aktif. Klik jika ingin membuat baru (link lama akan hangus)">
                           <i class="fa fa-clock-o"></i> Link Aktif (<?= sprintf('%02d:%02d', floor($active_remaining_seconds / 60), $active_remaining_seconds % 60); ?>)
                        </a>
                        <?php else: ?>
                        <a class="btn btn-top-action" id="btn_connect_tiktok" href="javascript:void(0);" title="Buat & Salin Authorize Link">
                           <i class="fa fa-key"></i> Buat Authorize Link
                        </a>
                        <?php endif; ?>
                        <?php }) ?>
                        <a class="btn btn-top-action" id="btn_sync" style="width: 34px !important; padding: 0 !important; justify-content: center !important;" title="Tarik Data Akun Toko dari TikTok Shop" href="<?= site_url('administrator/tiktok_shops/sync'); ?>">
                           <i class="fa fa-refresh"></i>
                        </a>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_shops" id="form_tiktok_shops" action="<?= base_url('administrator/tiktok_shops/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="min-width: 180px;">Nama Toko</th>
                                 <th style="min-width: 180px;">ID Toko</th>
                                 <th style="width: 120px; text-align: center;">Region Toko</th>
                                 <th style="min-width: 160px;">Masa Aktif Token</th>
                                 <th style="width: 120px; text-align: center;">Status Toko</th>
                                 <th style="width: 80px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_shops">
                              <?php foreach($tiktok_shopss as $tiktok_shops): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_shops->id; ?>">
                                 </td>
                                 <td>
                                    <span style="font-weight: 600; color: #1e293b; font-size: 13.5px;">
                                       <i class="fa fa-shopping-bag" style="color: #64748b; font-size: 13px; margin-right: 8px;"></i><?= _ent($tiktok_shops->shop_name); ?>
                                    </span>
                                 </td>
                                 <td>
                                    <span class="chip-id"><?= _ent($tiktok_shops->shop_id); ?></span>
                                 </td>
                                 <td style="text-align: center;">
                                    <span class="chip-region"><?= _ent($tiktok_shops->seller_base_region ?: 'ID'); ?></span>
                                 </td>
                                 <td>
                                    <?php
                                    $expire_ts = (int) $tiktok_shops->access_token_expire_in;
                                    if ($expire_ts > 0) {
                                        echo '<span class="token-expiry-wrap" style="display: inline-flex; align-items: center; gap: 6px; color: #475569; font-size: 13px; line-height: 1; vertical-align: middle;"><i class="fa fa-clock-o" style="color: #94a3b8; font-size: 13px; line-height: 1; position: relative; top: 0.5px;"></i> <span class="expiry-date-text" style="line-height: 1; font-size: 13px;">' . date('d/m/Y H:i', $expire_ts) . '</span></span>';
                                        if ($expire_ts < time()) {
                                            echo ' <span class="badge-minimal-danger">Expired</span>';
                                        }
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                 </td>
                                 <td style="text-align: center;">
                                     <?php if ($tiktok_shops->is_active == 1): ?>
                                        <span class="label label-success">Aktif</span>
                                     <?php else: ?>
                                        <span class="label label-danger">Nonaktif</span>
                                     <?php endif; ?>
                                  </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                     <?= render_table_action([
                                        'view' => [
                                           'url' => site_url('administrator/tiktok_shops/view/' . $tiktok_shops->id),
                                           'permission' => 'tiktok_shops_view',
                                        ],
                                        'edit' => [
                                           'url' => site_url('administrator/tiktok_shops/edit/' . $tiktok_shops->id),
                                           'permission' => 'tiktok_shops_update',
                                        ],
                                        [
                                           'label' => 'Refresh Token',
                                           'url' => site_url('administrator/tiktok_shops/refresh_token/' . $tiktok_shops->id),
                                           'icon' => 'fa fa-refresh',
                                           'icon_color' => '#059669',
                                           'permission' => 'tiktok_shops_update',
                                        ],
                                        [
                                           'label' => 'Sync Cipher',
                                           'url' => site_url('administrator/tiktok_shops/sync_cipher/' . $tiktok_shops->id),
                                           'icon' => 'fa fa-exchange',
                                           'icon_color' => '#0284c7',
                                           'permission' => 'tiktok_shops_update',
                                        ],
                                        'delete' => [
                                           'data_href' => site_url('administrator/tiktok_shops/delete/' . $tiktok_shops->id),
                                           'permission' => 'tiktok_shops_delete',
                                        ]
                                     ]); ?>
                                  </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_shops_counts == 0) :?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Akun Toko data is not available
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
                              <select class="form-control" name="bulk" id="bulk" style="width: 115px;">
                                 <option value="">Bulk</option>
                                 <option value="delete">Delete</option>
                              </select>
                              <button type="button" class="btn btn-apply" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>">
                                 <?= cclang('apply_button'); ?>
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>

                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>..." value="<?= $this->input->get('q'); ?>" style="width: 170px;">
                              
                              <select class="form-control" name="f" id="field" style="width: 150px;">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'shop_name' ? 'selected' :''; ?> value="shop_name">Shop Name</option>
                                 <option <?= $this->input->get('f') == 'shop_id' ? 'selected' :''; ?> value="shop_id">Shop Id</option>
                                 <option <?= $this->input->get('f') == 'seller_base_region' ? 'selected' :''; ?> value="seller_base_region">Seller Base Region</option>
                                 <option <?= $this->input->get('f') == 'is_active' ? 'selected' :''; ?> value="is_active">Is Active</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_shops');?>" title="<?= cclang('reset_filter'); ?>">
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
  $(document).ready(function(){
      // Ensure active dropdown row stays above sibling rows
      $(document).on('show.bs.dropdown', '.action-dropdown', function () {
         $(this).closest('tr').addClass('dropdown-open').css('z-index', 50);
      });

      $(document).on('hide.bs.dropdown', '.action-dropdown', function () {
         $(this).closest('tr').removeClass('dropdown-open').css('z-index', '');
      });

    $(document).on('click', '.remove-data', function(e){
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
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_tiktok_shops').serialize();

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
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/tiktok_shops/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end apply click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });
    // Timer & Authorize Link State Management
    var authTimerInterval = null;
    var authRemainingSeconds = <?= (int)($active_remaining_seconds ?? 0); ?>;

    function formatTimerMMSS(totalSeconds) {
        var m = Math.floor(totalSeconds / 60);
        var s = totalSeconds % 60;
        return (m < 10 ? '0' + m : m) + ':' + (s < 10 ? '0' + s : s);
    }

    function startAuthCountdown(seconds) {
        clearInterval(authTimerInterval);
        authRemainingSeconds = seconds;
        var btn = $('#btn_connect_tiktok');

        function updateBtnDisplay() {
            if (authRemainingSeconds > 0) {
                btn.html('<i class="fa fa-clock-o"></i> Link Aktif (' + formatTimerMMSS(authRemainingSeconds) + ')')
                   .attr('title', 'Link otorisasi aktif (' + formatTimerMMSS(authRemainingSeconds) + '). Klik untuk membuat baru (link lama akan hangus).')
                   .css('pointer-events', '');
            } else {
                clearInterval(authTimerInterval);
                authRemainingSeconds = 0;
                btn.html('<i class="fa fa-key"></i> Buat Authorize Link')
                   .attr('title', 'Buat & Salin Authorize Link')
                   .css('pointer-events', '');
            }
        }

        updateBtnDisplay();
        authTimerInterval = setInterval(function() {
            authRemainingSeconds--;
            updateBtnDisplay();
        }, 1000);
    }

    // Inisialisasi timer countdown saat halaman dibuka jika ada link aktif
    if (authRemainingSeconds > 0) {
        startAuthCountdown(authRemainingSeconds);
    }

    function requestNewAuthLink() {
        var btn = $('#btn_connect_tiktok');
        btn.html('<i class="fa fa-spin fa-refresh"></i> Membuat link...').css('pointer-events', 'none');

        $.ajax({
            url: BASE_URL + 'administrator/tiktok_shops/generate_auth_link',
            type: 'POST',
            dataType: 'json',
            data: {
                '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
            },
            success: function(res) {
                if (res.status && res.auth_url) {
                    copyToClipboard(res.auth_url, function() {
                        btn.html('<i class="fa fa-check" style="color: #ffffff !important;"></i> Link Tersalin!');
                        toastr.success('Link otorisasi berhasil disalin ke clipboard! (Masa berlaku 10 menit)');
                        setTimeout(function() {
                            startAuthCountdown(res.remaining_seconds || 600);
                        }, 1200);
                    });
                } else {
                    btn.html('<i class="fa fa-key"></i> Buat Authorize Link').css('pointer-events', '');
                    toastr.error(res.message || 'Gagal membuat link otorisasi.');
                }
            },
            error: function() {
                btn.html('<i class="fa fa-key"></i> Buat Authorize Link').css('pointer-events', '');
                toastr.error('Terjadi kesalahan koneksi saat membuat link.');
            }
        });
    }

    // Klik tombol: Jika link sebelumnya masih aktif, tampilkan validasi konfirmasi bahwa link lama akan hangus
    $('#btn_connect_tiktok').on('click', function(e) {
        e.preventDefault();

        if (authRemainingSeconds > 0) {
            swal({
                title: "Buat Link Baru?",
                text: "Link sebelumnya masih aktif dan akan otomatis hangus jika Anda membuat link baru.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00a65a",
                confirmButtonText: "Ya, Buat Baru",
                cancelButtonText: "Batal",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    requestNewAuthLink();
                }
            });
        } else {
            requestNewAuthLink();
        }
    });

    function copyToClipboard(text, successCallback) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                if (typeof successCallback === 'function') successCallback();
            }).catch(function() {
                fallbackCopy(text, successCallback);
            });
        } else {
            fallbackCopy(text, successCallback);
        }
    }

    function fallbackCopy(text, successCallback) {
        var tempInput = document.createElement("textarea");
        tempInput.style.position = "fixed";
        tempInput.style.left = "-9999px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        try {
            var successful = document.execCommand('copy');
            if (successful && typeof successCallback === 'function') {
                successCallback();
            }
        } catch (err) {}
        document.body.removeChild(tempInput);
    }



  }); /*end doc ready*/
</script>