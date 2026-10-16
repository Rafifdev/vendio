<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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

<style>
/* Main Card Wrapper - Matching Pesanan Penjualan */
.box-order-prizes {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

/* Header with Generous & Balanced Spacing */
.box-order-prizes .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-order-prizes .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-order-prizes .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-order-prizes .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-order-prizes .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-order-prizes .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-order-prizes .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-order-prizes .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-order-prizes .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-order-prizes .btn-top-action {
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
   text-decoration: none !important;
}

.box-order-prizes .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Horizontal Status Navigation Tabs (Matching Pesanan Penjualan) */
.order-status-tabs {
   padding: 12px 25px 0 25px;
   background: #ffffff;
   border-bottom: 1px solid #edf2f7;
   display: flex;
   gap: 8px;
   overflow-x: auto;
}

.order-status-tab-item {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   padding: 10px 16px;
   font-size: 13px;
   text-decoration: none !important;
   white-space: nowrap;
   transition: all 0.15s ease;
}

/* KPI Summary Cards */
.op-kpi-row {
   display: flex;
   gap: 12px;
   padding: 14px 25px;
   background: #fafbfc;
   border-bottom: 1px solid #edf2f7;
   flex-wrap: wrap;
}

.op-kpi-card {
   flex: 1;
   min-width: 160px;
   background: #ffffff;
   border: 1px solid #e2e8f0;
   border-radius: 6px;
   padding: 10px 14px;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}

.op-kpi-title {
   font-size: 11px;
   font-weight: 600;
   text-transform: uppercase;
   color: #64748b;
   letter-spacing: 0.5px;
}

.op-kpi-value {
   font-size: 17px;
   font-weight: 700;
   color: #0f172a;
   margin-top: 3px;
}

/* Clean Minimal Table Styling: Contained within card */
.box-order-prizes .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}

.box-order-prizes .table-minimal {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
   table-layout: auto;
}

.box-order-prizes .table-minimal thead th {
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
   padding: 10px 12px;
   vertical-align: middle;
}

.box-order-prizes .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 11px 12px;
   font-size: 12.5px;
   color: #334155;
   vertical-align: middle;
}

.box-order-prizes .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-order-prizes .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

.box-order-prizes .table-minimal tbody tr.dropdown-open {
   z-index: 50;
}

/* Column Chips & Tags */
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

.op-mono {
   font-family: Menlo, Monaco, Consolas, monospace;
   font-size: 12px;
   background: #f1f5f9;
   padding: 2px 6px;
   border-radius: 4px;
   color: #0f172a;
}

/* Status Badges */
.badge-status {
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 3px 8px;
   border-radius: 12px;
   font-size: 11.5px;
   font-weight: 600;
   line-height: 1;
}
.badge-active { background: #dcfce7; color: #166534; }
.badge-draft { background: #fef3c7; color: #92400e; }
.badge-paused { background: #fee2e2; color: #991b1b; }
.badge-ended { background: #f1f5f9; color: #475569; }
.badge-claimed { background: #dcfce7; color: #166534; }
.badge-pending { background: #fef3c7; color: #92400e; }
.badge-expired { background: #fee2e2; color: #991b1b; }
.badge-rejected { background: #f1f5f9; color: #475569; }

.badge-kind {
   font-size: 11px;
   font-weight: 600;
   padding: 3px 8px;
   border-radius: 4px;
   display: inline-block;
}
.badge-kind-physical { background: #e0f2fe; color: #0369a1; }
.badge-kind-voucher { background: #f3e8ff; color: #7e22ce; }
.badge-kind-none { background: #f1f5f9; color: #64748b; }

/* Action Dropdown 3-Dots Component (Matching Pesanan Penjualan) */
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

/* Fixed Bottom Toolbar (Clean Footer Container matching Pesanan Penjualan) */
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

.toolbar-divider {
   width: 1px;
   height: 22px;
   background-color: #e2e8f0;
   margin: 0 4px;
}

.filter-group {
   display: flex;
   align-items: center;
   gap: 6px;
   flex-wrap: wrap;
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
      Hadiah Pesanan <small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Hadiah Pesanan</li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-order-prizes">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment -->
                  <div class="widget-user-header">
                     <div class="header-left">
                        <div class="widget-user-image">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                        </div>
                        <div class="header-titles">
                           <h3 class="widget-user-username">Hadiah Pesanan</h3>
                           <h5 class="widget-user-desc">
                              <?= cclang('list_all', ['Hadiah Pesanan']); ?>
                              <span class="label bg-yellow"><?= number_format($records['total']); ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <?php if ($can_manage): ?>
                           <?php if ($active_tab === 'campaigns'): ?>
                              <a class="btn btn-top-action" href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_add'); ?>" title="Tambah Campaign Baru">
                                 <i class="fa fa-plus-square-o"></i> Tambah Campaign Baru
                              </a>
                           <?php elseif ($active_tab === 'prizes'): ?>
                              <a class="btn btn-top-action" href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_add'); ?>" title="Tambah Hadiah Baru">
                                 <i class="fa fa-plus-square-o"></i> Tambah Hadiah Baru
                              </a>
                           <?php elseif ($active_tab === 'orders'): ?>
                              <button type="button" class="btn btn-top-action" data-toggle="modal" data-target="#modal-import-csv" title="Import Order dari File CSV">
                                 <i class="fa fa-file-excel-o"></i> Import CSV
                              </button>
                              <a class="btn btn-top-action" href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/order_add'); ?>" title="Tambah Order Manual">
                                 <i class="fa fa-plus-square-o"></i> Tambah Order Manual
                              </a>
                              <a class="btn btn-top-action" id="btn_sync" style="width: 34px !important; padding: 0 !important; justify-content: center !important;" title="Tarik Data Pesanan dari TikTok Shop" href="<?= site_url('administrator/tiktok_orders/sync?redirect=' . urlencode('administrator/order_prizes/tab/orders')); ?>">
                                 <i class="fa fa-refresh"></i>
                              </a>
                           <?php endif; ?>
                        <?php endif; ?>
                     </div>
                  </div>

                  <!-- KPI Metrics Summary Bar -->
                  <div class="op-kpi-row">
                     <div class="op-kpi-card">
                        <div class="op-kpi-title">Total Campaign Aktif</div>
                        <div class="op-kpi-value"><?= number_format($stats['active_campaigns']); ?></div>
                     </div>
                     <div class="op-kpi-card">
                        <div class="op-kpi-title">Total Varian Hadiah</div>
                        <div class="op-kpi-value"><?= number_format($stats['total_prizes']); ?></div>
                     </div>
                     <div class="op-kpi-card">
                        <div class="op-kpi-title">Pesanan Terverifikasi</div>
                        <div class="op-kpi-value"><?= number_format($stats['total_orders']); ?></div>
                     </div>
                     <div class="op-kpi-card">
                        <div class="op-kpi-title">Total Spin Selesai</div>
                        <div class="op-kpi-value"><?= number_format($stats['total_spins']); ?></div>
                     </div>
                     <div class="op-kpi-card">
                        <div class="op-kpi-title">Omset Masuk (Spin)</div>
                        <div class="op-kpi-value" style="color: #059669;">Rp <?= number_format($stats['total_revenue'], 0, ',', '.'); ?></div>
                     </div>
                  </div>

                  <!-- Horizontal Status Navigation Tabs (Sesuai Modul Pesanan Penjualan) -->
                  <div class="order-status-tabs" style="padding: 12px 25px 0 25px; background: #ffffff; border-bottom: 1px solid #edf2f7; display: flex; gap: 8px; overflow-x: auto;">
                     <?php
                     $tabs_config = [
                        'campaigns' => [
                           'label' => 'Campaigns',
                           'count' => $stats['total_campaigns'],
                        ],
                        'prizes' => [
                           'label' => 'Hadiah & Threshold',
                           'count' => $stats['total_prizes'],
                        ],
                        'orders' => [
                           'label' => 'Order Terverifikasi',
                           'count' => $stats['total_orders'],
                        ],
                        'spins' => [
                           'label' => 'Riwayat Spin & Klaim',
                           'count' => $stats['total_spins'],
                        ],
                        'audit' => [
                           'label' => 'Audit Log',
                           'count' => null,
                        ],
                     ];

                     foreach ($tabs_config as $t_key => $t_info):
                        $is_active = ($active_tab === $t_key);
                        $tab_url = site_url('administrator/order_prizes/tab/' . $t_key);
                     ?>
                        <a href="<?= $tab_url; ?>" style="display: inline-flex; align-items: center; gap: 4px; padding: 10px 16px; font-size: 13px; font-weight: <?= $is_active ? '700' : '500'; ?>; color: <?= $is_active ? '#00a65a' : '#64748b'; ?>; border-bottom: 2.5px solid <?= $is_active ? '#00a65a' : 'transparent'; ?>; text-decoration: none !important; white-space: nowrap; transition: all 0.15s ease;">
                           <?= $t_info['label']; ?><?= $t_info['count'] !== null ? ' (' . number_format($t_info['count']) . ')' : ''; ?>
                        </a>
                     <?php endforeach; ?>
                  </div>

                  <!-- Form & Table Content -->
                  <form name="form_order_prizes" id="form_order_prizes" action="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/' . $active_tab); ?>" method="GET">
                     <div class="table-responsive">
                        
                        <?php if ($active_tab === 'campaigns'): ?>
                           <!-- 1. CAMPAIGNS TABLE -->
                           <table class="table table-minimal">
                              <thead>
                                 <tr>
                                    <th style="width: 40px; text-align: center;">
                                       <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="<?= cclang('check_all'); ?>">
                                    </th>
                                    <th style="width: 60px; text-align: center;">ID</th>
                                    <th style="min-width: 200px;">Nama Campaign</th>
                                    <th style="width: 140px;">Channel & Toko</th>
                                    <th style="width: 160px; text-align: center;">Periode</th>
                                    <th style="width: 90px; text-align: center;">Status</th>
                                    <th style="width: 110px; text-align: center;">Total Spin</th>
                                    <th style="width: 140px; text-align: right;">Omset / Profit</th>
                                    <th style="width: 48px; text-align: center; white-space: nowrap;">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($records['items'])): ?>
                                    <tr>
                                       <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                          Belum ada campaign. Silakan klik tombol "Tambah Campaign Baru" di atas.
                                       </td>
                                    </tr>
                                 <?php else: foreach ($records['items'] as $item): ?>
                                    <tr>
                                       <td style="text-align: center;">
                                          <input type="checkbox" class="flat-red check" name="id[]" value="<?= $item['id']; ?>">
                                       </td>
                                       <td style="text-align: center;"><span class="chip-id">#<?= $item['id']; ?></span></td>
                                       <td>
                                          <strong style="color: #1e293b; font-size: 13.5px;"><?= html_escape($item['name']); ?></strong>
                                          <div style="margin-top: 3px;">
                                             <a href="<?= site_url('order_prizes?campaign=' . urlencode($item['slug'])); ?>" target="_blank" style="color: #0284c7; font-size: 11.5px; text-decoration: none;">
                                                <i class="fa fa-external-link"></i> /order_prizes?campaign=<?= html_escape($item['slug']); ?>
                                             </a>
                                          </div>
                                       </td>
                                       <td>
                                          <span class="badge" style="background: #f1f5f9; color: #334155; text-transform: uppercase; font-size: 11px;"><?= html_escape($item['channel']); ?></span>
                                          <div style="font-size: 12px; color: #64748b; margin-top: 2px;"><?= html_escape($item['shop_ref']); ?></div>
                                       </td>
                                       <td style="font-size: 12px; color: #475569; text-align: center;">
                                          <div><?= date('d M Y H:i', strtotime($item['starts_at'])); ?></div>
                                          <div style="color: #94a3b8; font-size: 11px;">s/d <?= date('d M Y H:i', strtotime($item['ends_at'])); ?></div>
                                          <div style="color: #64748b; font-size: 10.5px;">Batas: <?= $item['claim_days']; ?> hari</div>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['status'] === 'active'): ?>
                                             <span class="label label-success">Aktif</span>
                                          <?php elseif ($item['status'] === 'draft'): ?>
                                             <span class="label label-warning">Draft</span>
                                          <?php elseif ($item['status'] === 'paused'): ?>
                                             <span class="label label-warning">Paused</span>
                                          <?php else: ?>
                                             <span class="label label-default">Ended</span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <div style="font-weight: 600; color: #1e293b;"><?= number_format($item['spin_count']); ?> <small class="text-muted">spin</small></div>
                                          <div style="font-size: 11px; color: #64748b;">Biaya: Rp <?= number_format($item['awarded_cost'], 0, ',', '.'); ?></div>
                                       </td>
                                       <td style="text-align: right;">
                                          <div style="color: #059669; font-weight: 600;">Rp <?= number_format($item['revenue_total'], 0, ',', '.'); ?></div>
                                          <div style="font-size: 11px; color: #64748b;">Profit: Rp <?= number_format($item['profit_total'], 0, ',', '.'); ?></div>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             [
                                                'label' => 'Buka Landing Wheel',
                                                'url' => site_url('order_prizes?campaign=' . urlencode($item['slug'])),
                                                'icon' => 'fa fa-external-link',
                                                'icon_color' => '#0284c7',
                                                'attrs' => ['target' => '_blank'],
                                                'permission' => 'order_prizes_view',
                                             ],
                                             [
                                                'label' => 'Tambah Hadiah',
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_add?campaign_id=' . $item['id']),
                                                'icon' => 'fa fa-gift',
                                                'icon_color' => '#059669',
                                                'permission' => 'order_prizes_manage',
                                             ],
                                             'update' => [
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/campaign_edit/' . $item['id']),
                                                'permission' => 'order_prizes_manage',
                                                'label' => 'Ubah Campaign',
                                             ],
                                             [
                                                'label' => 'Hapus / Nonaktifkan',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-trash-o',
                                                'class' => 'item-danger',
                                                'onclick' => "deleteRecord('campaigns', {$item['id']}, '" . html_escape($item['name']) . "')",
                                                'divider' => true,
                                                'permission' => 'order_prizes_manage',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; endif; ?>
                              </tbody>
                           </table>

                        <?php elseif ($active_tab === 'prizes'): ?>
                           <!-- 2. PRIZES TABLE -->
                           <table class="table table-minimal">
                              <thead>
                                 <tr>
                                    <th style="width: 40px; text-align: center;">
                                       <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="<?= cclang('check_all'); ?>">
                                    </th>
                                    <th style="width: 60px; text-align: center;">ID</th>
                                    <th style="min-width: 170px;">Nama Hadiah</th>
                                    <th style="width: 140px;">Campaign</th>
                                    <th style="width: 80px; text-align: center;">Tipe</th>
                                    <th style="width: 80px; text-align: center;">Peluang</th>
                                    <th style="width: 90px; text-align: center;">Sisa Stok</th>
                                    <th style="width: 110px; text-align: right;">Biaya</th>
                                    <th style="width: 170px;">Syarat Terbuka</th>
                                    <th style="width: 90px; text-align: center;">Dikeluarkan</th>
                                    <th style="width: 80px; text-align: center;">Status</th>
                                    <th style="width: 48px; text-align: center; white-space: nowrap;">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($records['items'])): ?>
                                    <tr>
                                       <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                          Belum ada varian hadiah. Silakan klik "Tambah Hadiah Baru" di atas.
                                       </td>
                                    </tr>
                                 <?php else: foreach ($records['items'] as $item): ?>
                                    <tr>
                                       <td style="text-align: center;">
                                          <input type="checkbox" class="flat-red check" name="id[]" value="<?= $item['id']; ?>">
                                       </td>
                                       <td style="text-align: center;"><span class="chip-id">#<?= $item['id']; ?></span></td>
                                       <td>
                                          <strong style="color: #1e293b; font-size: 13.5px;"><?= html_escape($item['name']); ?></strong>
                                          <?php if (!empty($item['description'])): ?>
                                             <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;"><?= html_escape($item['description']); ?></div>
                                          <?php endif; ?>
                                       </td>
                                       <td>
                                          <?php if (!empty($item['campaigns'])): ?>
                                             <div style="display: flex; flex-direction: column; gap: 3px;">
                                                <?php foreach ($item['campaigns'] as $c): ?>
                                                   <span class="badge" style="background: #f1f5f9; color: #334155; text-align: left; white-space: normal; font-size: 11px;">
                                                      #<?= $c['id']; ?> <?= html_escape($c['name']); ?>
                                                   </span>
                                                <?php endforeach; ?>
                                             </div>
                                          <?php elseif (!empty($item['campaign_id'])): ?>
                                             <span class="badge" style="background: #f1f5f9; color: #334155;">#<?= $item['campaign_id']; ?></span>
                                          <?php else: ?>
                                             <span class="text-muted" style="font-size: 11px;">Belum Terhubung</span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['kind'] === 'physical'): ?>
                                             <span class="label label-info">Fisik</span>
                                          <?php elseif ($item['kind'] === 'voucher'): ?>
                                             <span class="label label-primary">Voucher</span>
                                          <?php else: ?>
                                             <span class="label label-default">Zonk</span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <span style="font-weight: 600; color: #1e293b;"><?= number_format($item['weight']); ?></span>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['stock'] === null): ?>
                                             <span class="label label-info">Unlimited</span>
                                          <?php elseif ($item['stock'] <= 0): ?>
                                             <span class="label label-danger">Habis (0)</span>
                                          <?php else: ?>
                                             <strong style="color: #059669;"><?= number_format($item['stock']); ?></strong> <small class="text-muted">pcs</small>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: right; font-weight: 600; color: #1e293b;">
                                          Rp <?= number_format($item['cost'], 0, ',', '.'); ?>
                                       </td>
                                       <td style="font-size: 11.5px; color: #475569;">
                                          <?php if ($item['threshold_spins'] == 0 && $item['threshold_revenue'] == 0 && $item['threshold_profit'] == 0): ?>
                                             <span class="text-muted"><i class="fa fa-check text-green"></i> Terbuka (Tanpa Syarat)</span>
                                          <?php else: ?>
                                             <?php if ($item['threshold_spins'] > 0): ?><div>• Min. Spin: <?= number_format($item['threshold_spins']); ?></div><?php endif; ?>
                                             <?php if ($item['threshold_revenue'] > 0): ?><div>• Min. Omset: Rp <?= number_format($item['threshold_revenue'], 0, ',', '.'); ?></div><?php endif; ?>
                                             <?php if ($item['threshold_profit'] > 0): ?><div>• Min. Profit: Rp <?= number_format($item['threshold_profit'], 0, ',', '.'); ?></div><?php endif; ?>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <strong><?= number_format($item['awarded_count']); ?></strong> <small class="text-muted">kali</small>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['active']): ?>
                                             <span class="label label-success">Aktif</span>
                                          <?php else: ?>
                                             <span class="label label-default">Nonaktif</span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             'update' => [
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_edit/' . $item['id']),
                                                'permission' => 'order_prizes_manage',
                                                'label' => 'Ubah Hadiah',
                                             ],
                                             [
                                                'label' => 'Hapus Hadiah',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-trash-o',
                                                'class' => 'item-danger',
                                                'onclick' => "deleteRecord('prizes', {$item['id']}, '" . html_escape($item['name']) . "')",
                                                'divider' => true,
                                                'permission' => 'order_prizes_manage',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; endif; ?>
                              </tbody>
                           </table>

                        <?php elseif ($active_tab === 'orders'): ?>
                           <!-- 3. ORDERS TABLE -->
                           <table class="table table-minimal">
                              <thead>
                                 <tr>
                                    <th style="width: 40px; text-align: center;">
                                       <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="<?= cclang('check_all'); ?>">
                                    </th>
                                    <th style="width: 170px;">ID Pesanan</th>
                                    <th style="width: 130px;">Campaign</th>
                                    <th style="width: 140px;">Nomor Telepon</th>
                                    <th style="width: 105px; text-align: center; white-space: nowrap;">Status Pesanan</th>
                                    <th style="width: 110px; text-align: right; white-space: nowrap;">Nilai Belanja</th>
                                    <th style="width: 110px; text-align: right; white-space: nowrap;">Estimasi Profit</th>
                                    <th style="width: 130px; text-align: center;">Waktu Order</th>
                                    <th style="width: 48px; text-align: center; white-space: nowrap;">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($records['items'])): ?>
                                    <tr>
                                       <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                          Belum ada pesanan terverifikasi. Klik "Tarik Pesanan TikTok", "Import CSV", atau "Tambah Order Manual".
                                       </td>
                                    </tr>
                                 <?php else: foreach ($records['items'] as $item): ?>
                                    <tr>
                                       <td style="text-align: center;">
                                          <input type="checkbox" class="flat-red check" name="id[]" value="<?= $item['id']; ?>">
                                       </td>
                                       <td style="white-space: nowrap;">
                                          <span class="chip-id btn-copy-order-id" data-id="<?= html_escape($item['order_number']); ?>" title="Klik untuk menyalin ID Pesanan" role="button">
                                             <?= html_escape($item['order_number']); ?>
                                             <i class="fa fa-copy copy-icon"></i>
                                          </span>
                                          <div style="font-size: 11px; color: #64748b; margin-top: 3px;">
                                             <span class="label label-default" style="font-size: 10px; padding: 1px 5px;"><?= strtoupper($item['channel']); ?></span>
                                             <?= html_escape($item['shop_ref']); ?>
                                          </div>
                                       </td>
                                       <td><span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11.5px;">#<?= $item['campaign_id']; ?></span></td>
                                       <td>
                                          <span style="font-family: Menlo, Monaco, monospace; font-size: 12.5px; font-weight: 600; color: #1e293b;"><?= html_escape($item['phone']); ?></span>
                                          <a href="https://wa.me/<?= preg_replace('/^0/', '62', $item['phone']); ?>" target="_blank" style="margin-left: 5px; color: #16a34a; font-size: 13px;" title="Chat WhatsApp Customer">
                                             <i class="fa fa-whatsapp"></i>
                                          </a>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?php
                                          $st = strtolower($item['status']);
                                          if (in_array($st, ['completed', 'selesai', 'paid', 'success'])): ?>
                                             <span class="label label-success"><?= ucfirst($item['status']); ?></span>
                                          <?php elseif (in_array($st, ['pending', 'unpaid', 'processing'])): ?>
                                             <span class="label label-warning"><?= ucfirst($item['status']); ?></span>
                                          <?php elseif (in_array($st, ['cancelled', 'batal', 'failed'])): ?>
                                             <span class="label label-danger"><?= ucfirst($item['status']); ?></span>
                                          <?php else: ?>
                                             <span class="label label-default"><?= ucfirst($item['status']); ?></span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: right; font-weight: 600; color: #16a34a; white-space: nowrap;">
                                          Rp <?= number_format($item['revenue'], 0, ',', '.'); ?>
                                       </td>
                                       <td style="text-align: right; color: #64748b; white-space: nowrap;">
                                          <?= $item['profit'] !== null ? 'Rp ' . number_format($item['profit'], 0, ',', '.') : '—'; ?>
                                       </td>
                                       <td style="font-size: 12px; color: #475569; text-align: center;">
                                          <?= date('d/m/Y H:i', strtotime($item['ordered_at'])); ?>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             'view' => [
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/view/' . $item['id']),
                                                'permission' => 'order_prizes_view',
                                                'label' => 'Lihat Detail',
                                             ],
                                             'update' => [
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/order_edit/' . $item['id']),
                                                'permission' => 'order_prizes_manage',
                                                'label' => 'Ubah Order',
                                             ],
                                             [
                                                'label' => 'Chat WhatsApp',
                                                'url' => 'https://wa.me/' . preg_replace('/^0/', '62', $item['phone']),
                                                'icon' => 'fa fa-whatsapp',
                                                'icon_color' => '#16a34a',
                                                'attrs' => ['target' => '_blank'],
                                                'permission' => 'order_prizes_view',
                                             ],
                                             [
                                                'label' => 'Hapus Order',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-trash-o',
                                                'class' => 'item-danger',
                                                'onclick' => "deleteRecord('orders', {$item['id']}, '" . html_escape($item['order_number']) . "')",
                                                'divider' => true,
                                                'permission' => 'order_prizes_manage',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; endif; ?>
                              </tbody>
                           </table>

                        <?php elseif ($active_tab === 'spins'): ?>
                           <!-- 4. SPINS & CLAIMS TABLE -->
                           <table class="table table-minimal">
                              <thead>
                                 <tr>
                                    <th style="width: 40px; text-align: center;">
                                       <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="<?= cclang('check_all'); ?>">
                                    </th>
                                    <th style="width: 60px; text-align: center;">ID</th>
                                    <th style="width: 180px;">No. Pesanan & HP</th>
                                    <th style="min-width: 170px;">Hadiah Dimenangkan</th>
                                    <th style="width: 100px; text-align: center;">Status Klaim</th>
                                    <th style="width: 110px; text-align: center;">Pengiriman</th>
                                    <th style="width: 95px; text-align: center;">Follow-up</th>
                                    <th style="width: 130px; text-align: center;">Waktu Spin</th>
                                    <th style="width: 48px; text-align: center; white-space: nowrap;">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($records['items'])): ?>
                                    <tr>
                                       <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                          Belum ada customer yang melakukan spin hadiah.
                                       </td>
                                    </tr>
                                 <?php else: foreach ($records['items'] as $item): ?>
                                    <tr>
                                       <td style="text-align: center;">
                                          <input type="checkbox" class="flat-red check" name="id[]" value="<?= $item['id']; ?>">
                                       </td>
                                       <td style="text-align: center;"><span class="chip-id">#<?= $item['id']; ?></span></td>
                                       <td>
                                          <span class="chip-id btn-copy-order-id" data-id="<?= html_escape($item['order_number']); ?>" title="Klik untuk menyalin ID Pesanan" role="button">
                                             <?= html_escape($item['order_number']); ?>
                                             <i class="fa fa-copy copy-icon"></i>
                                          </span>
                                          <div style="margin-top: 3px; font-size: 12px; color: #475569;">
                                             <?= html_escape($item['phone']); ?>
                                             <a href="https://wa.me/<?= preg_replace('/^0/', '62', $item['phone']); ?>" target="_blank" style="margin-left: 5px; color: #16a34a;" title="Chat WhatsApp Customer">
                                                <i class="fa fa-whatsapp"></i> Chat
                                             </a>
                                          </div>
                                       </td>
                                       <td>
                                          <strong style="color: #0f172a; font-size: 13.5px;"><?= html_escape($item['prize_name']); ?></strong>
                                          <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Biaya: Rp <?= number_format($item['prize_cost'], 0, ',', '.'); ?></div>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['claim_status'] === 'claimed'): ?>
                                             <span class="label label-success">Diklaim</span>
                                          <?php elseif ($item['claim_status'] === 'pending'): ?>
                                             <span class="label label-warning">Menunggu</span>
                                          <?php elseif ($item['claim_status'] === 'expired'): ?>
                                             <span class="label label-danger">Kadaluarsa</span>
                                          <?php else: ?>
                                             <span class="label label-default"><?= ucfirst($item['claim_status']); ?></span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($item['prize_status'] === 'shipped'): ?>
                                             <span class="label label-info">Dikirim</span>
                                          <?php elseif (in_array($item['prize_status'], ['completed', 'delivered'])): ?>
                                             <span class="label label-success">Terkirim</span>
                                          <?php elseif ($item['prize_status'] === 'cancelled'): ?>
                                             <span class="label label-danger">Dibatalkan</span>
                                          <?php elseif ($item['prize_status'] === 'reserved'): ?>
                                             <span class="label label-warning">Reserved</span>
                                          <?php else: ?>
                                             <span class="label label-default"><?= ucfirst($item['prize_status']); ?></span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                          <span class="label label-<?= $item['follow_up_status'] === 'closed' ? 'success' : 'default'; ?>">
                                             <?= ucfirst($item['follow_up_status']); ?>
                                          </span>
                                       </td>
                                       <td style="font-size: 12px; color: #475569; text-align: center;">
                                          <div><?= date('d/m/Y H:i', strtotime($item['spun_at'])); ?></div>
                                          <div style="font-size: 10.5px; color: #94a3b8;">Batas: <?= date('d/m H:i', strtotime($item['claim_deadline'])); ?></div>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             [
                                                'label' => 'Kelola Hadiah / Resi',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-truck',
                                                'icon_color' => '#059669',
                                                'onclick' => "openFulfillmentModal(" . html_escape(json_encode($item)) . ")",
                                                'permission' => 'order_prizes_fulfill',
                                             ],
                                             'view' => [
                                                'url' => site_url(ADMIN_NAMESPACE_URL . '/order_prizes/view/' . $item['order_id']),
                                                'permission' => 'order_prizes_view',
                                                'label' => 'Lihat Detail Order',
                                             ],
                                             [
                                                'label' => 'Chat WhatsApp Pemenang',
                                                'url' => 'https://wa.me/' . preg_replace('/^0/', '62', $item['phone']),
                                                'icon' => 'fa fa-whatsapp',
                                                'icon_color' => '#16a34a',
                                                'attrs' => ['target' => '_blank'],
                                                'permission' => 'order_prizes_view',
                                             ],
                                             [
                                                'label' => 'Reset Spin (Testing)',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-refresh',
                                                'icon_color' => '#ef4444',
                                                'class' => 'item-danger',
                                                'onclick' => "deleteRecord('spins', {$item['id']}, 'Spin #{$item['id']} (Pesanan: " . html_escape($item['order_number']) . ")')",
                                                'divider' => true,
                                                'permission' => 'order_prizes_manage',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; endif; ?>
                              </tbody>
                           </table>

                        <?php elseif ($active_tab === 'audit'): ?>
                           <!-- 5. AUDIT LOG TABLE -->
                           <table class="table table-minimal">
                              <thead>
                                 <tr>
                                    <th style="width: 40px; text-align: center;">
                                       <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="<?= cclang('check_all'); ?>">
                                    </th>
                                    <th style="width: 60px; text-align: center;">ID</th>
                                    <th style="width: 140px; text-align: center;">Waktu</th>
                                    <th style="width: 130px;">Aktor</th>
                                    <th style="width: 140px; text-align: center;">Aksi</th>
                                    <th style="width: 110px; text-align: center;">Entitas</th>
                                    <th style="width: 85px; text-align: center;">ID Target</th>
                                    <th style="width: 48px; text-align: center; white-space: nowrap;">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if (empty($records['items'])): ?>
                                    <tr>
                                       <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                          Belum ada log audit aktivitas.
                                       </td>
                                    </tr>
                                 <?php else: foreach ($records['items'] as $item): ?>
                                    <tr>
                                       <td style="text-align: center;">
                                          <input type="checkbox" class="flat-red check" name="id[]" value="<?= $item['id']; ?>">
                                       </td>
                                       <td style="text-align: center;"><span class="chip-id">#<?= $item['id']; ?></span></td>
                                       <td style="font-size: 12px; color: #475569; text-align: center; white-space: nowrap;">
                                          <?= date('d/m/Y H:i:s', strtotime($item['created_at'])); ?>
                                       </td>
                                       <td><?= $item['actor_id'] ? 'User #' . $item['actor_id'] : '<span class="text-muted">System / Public</span>'; ?></td>
                                       <td style="text-align: center;"><span class="op-mono" style="font-weight: 600; color: #0369a1;"><?= html_escape($item['action']); ?></span></td>
                                       <td style="text-align: center;"><span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11px;"><?= html_escape($item['entity']); ?></span></td>
                                       <td style="text-align: center;"><span class="chip-id">#<?= $item['entity_id']; ?></span></td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             [
                                                'label' => 'Lihat Snapshot JSON',
                                                'url' => 'javascript:void(0);',
                                                'icon' => 'fa fa-eye',
                                                'icon_color' => '#0284c7',
                                                'onclick' => "showAuditDetail(" . html_escape(json_encode($item['detail_json'])) . ")",
                                                'permission' => 'order_prizes_view',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; endif; ?>
                              </tbody>
                           </table>
                        <?php endif; ?>

                     </div>

                     <!-- Bottom Toolbar Matching Pesanan Penjualan -->
                     <div class="box-footer-toolbar">
                        <div class="toolbar-controls-left">
                           <?php if ($active_tab !== 'audit'): ?>
                           <!-- Bulk Action (Matching Mayoritas Modul) -->
                           <div class="bulk-group">
                              <select class="form-control" name="bulk" id="bulk" style="width: 130px;">
                                 <option value=""><?= cclang('bulk'); ?></option>
                                 <option value="delete"><?= cclang('delete'); ?></option>
                              </select>
                              <button type="button" class="btn btn-apply" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>">
                                 <?= cclang('apply_button'); ?>
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>
                           <?php endif; ?>

                           <!-- Search & Filter Controls -->
                            <div class="filter-group">
                               <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>..." value="<?= html_escape($this->input->get('q')); ?>" style="width: 170px;">
                               
                               <select class="form-control" name="f" id="field" style="width: 165px;">
                                  <option value=""><?= cclang('all'); ?></option>
                                  <?php if ($active_tab === 'campaigns'): ?>
                                     <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Nama Campaign</option>
                                     <option <?= $this->input->get('f') == 'slug' ? 'selected' : ''; ?> value="slug">Slug</option>
                                     <option <?= $this->input->get('f') == 'channel' ? 'selected' : ''; ?> value="channel">Channel</option>
                                  <?php elseif ($active_tab === 'prizes'): ?>
                                     <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Nama Hadiah</option>
                                     <option <?= $this->input->get('f') == 'kind' ? 'selected' : ''; ?> value="kind">Tipe Hadiah</option>
                                  <?php elseif ($active_tab === 'orders'): ?>
                                     <option <?= $this->input->get('f') == 'order_number' ? 'selected' : ''; ?> value="order_number">No. Pesanan</option>
                                     <option <?= $this->input->get('f') == 'phone' ? 'selected' : ''; ?> value="phone">No. HP</option>
                                  <?php elseif ($active_tab === 'spins'): ?>
                                     <option <?= $this->input->get('f') == 'order_number' ? 'selected' : ''; ?> value="order_number">No. Pesanan</option>
                                     <option <?= $this->input->get('f') == 'phone' ? 'selected' : ''; ?> value="phone">No. HP</option>
                                     <option <?= $this->input->get('f') == 'prize_name' ? 'selected' : ''; ?> value="prize_name">Nama Hadiah</option>
                                  <?php elseif ($active_tab === 'audit'): ?>
                                     <option <?= $this->input->get('f') == 'action' ? 'selected' : ''; ?> value="action">Aksi</option>
                                  <?php endif; ?>
                               </select>

                               <?php if (in_array($active_tab, ['prizes', 'orders', 'spins'], true) && !empty($campaigns_dropdown)): ?>
                                  <select class="form-control" name="campaign_id" id="campaign_id" style="width: 165px;">
                                     <option value="">Semua Campaign</option>
                                     <?php foreach ($campaigns_dropdown as $c): ?>
                                        <option <?= ($this->input->get('campaign_id') == $c['id']) ? 'selected' : ''; ?> value="<?= $c['id']; ?>">
                                           <?= html_escape($c['name']); ?>
                                        </option>
                                     <?php endforeach; ?>
                                  </select>
                               <?php endif; ?>

                               <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                  Filter
                               </button>
                               <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= site_url('administrator/order_prizes/tab/' . $active_tab); ?>" title="<?= cclang('reset_filter'); ?>">
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

<!-- ========================================== -->
<!-- MODAL KELOLA FULFILLMENT & RESI            -->
<!-- ========================================== -->
<div class="modal fade" id="modal-fulfillment" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 8px;">
         <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-truck text-green"></i> Kelola Hadiah & Pengiriman Pemenang</h4>
         </div>
         <form id="form-fulfillment">
            <input type="hidden" name="spin_id" id="ful-spin-id">
            <div class="modal-body" style="padding: 24px;">
               <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px; margin-bottom: 18px;">
                  <div style="font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700;">Data Pemenang</div>
                  <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 4px;" id="ful-prize-name"></div>
                  <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                     No. Pesanan: <strong class="op-mono" id="ful-order-number"></strong> | HP: <span id="ful-phone"></span>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6 form-group">
                     <label>Status Klaim Customer</label>
                     <select name="claim_status" id="ful-claim-status" class="form-control" style="border-radius: 6px;">
                        <option value="pending">Pending</option>
                        <option value="claimed">Claimed (Sudah Diklaim)</option>
                        <option value="expired">Expired (Lewat Batas)</option>
                        <option value="rejected">Rejected (Ditolak)</option>
                        <option value="not_required">Not Required (Zonk)</option>
                     </select>
                  </div>
                  <div class="col-md-6 form-group">
                     <label>Status Pengiriman Hadiah</label>
                     <select name="prize_status" id="ful-prize-status" class="form-control" style="border-radius: 6px;">
                        <option value="reserved">Reserved (Disiapkan)</option>
                        <option value="processing">Processing (Diproses)</option>
                        <option value="sent">Sent (Terkirim)</option>
                        <option value="delivered">Delivered (Diterima)</option>
                        <option value="void">Void (Dibatalkan)</option>
                        <option value="not_required">Not Required</option>
                     </select>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-6 form-group">
                     <label>Status Follow-up CS</label>
                     <select name="follow_up_status" id="ful-followup-status" class="form-control" style="border-radius: 6px;">
                        <option value="pending">Pending</option>
                        <option value="contacted">Contacted (Sudah Dihubungi)</option>
                        <option value="closed">Closed (Selesai)</option>
                     </select>
                  </div>
                  <div class="col-md-6 form-group">
                     <label>Status Broadcast</label>
                     <select name="broadcast_status" id="ful-broadcast-status" class="form-control" style="border-radius: 6px;">
                        <option value="not_sent">Not Sent</option>
                        <option value="queued">Queued</option>
                        <option value="sent">Sent</option>
                        <option value="failed">Failed</option>
                     </select>
                  </div>
               </div>

               <div class="form-group">
                  <label>Catatan / Nomor Resi / Kode Voucher</label>
                  <textarea name="notes" id="ful-notes" class="form-control" rows="3" placeholder="Masukkan nomor resi ekspedisi, kode kupon, atau catatan fulfillment..." style="border-radius: 6px;"></textarea>
               </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 16px 24px;">
               <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
               <button type="submit" class="btn btn-primary" id="btn-save-fulfillment">Simpan Perubahan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- ========================================== -->
<!-- MODAL IMPORT ORDER CSV                     -->
<!-- ========================================== -->
<div class="modal fade" id="modal-import-csv" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 8px;">
         <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-file-excel-o text-green"></i> Import Order Terverifikasi (CSV)</h4>
         </div>
         <form id="form-import-csv" enctype="multipart/form-data">
            <div class="modal-body" style="padding: 24px;">
               <p style="font-size: 13px; color: #475569; line-height: 1.6;">
                  Unggah file CSV berisi data pesanan pembeli yang berhak melakukan spin. Format file harus memiliki header berikut:
               </p>
               <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px;">
                  <code style="font-size: 12px; color: #0f172a;">order_number,phone,status,revenue,profit,ordered_at</code>
                  <div style="margin-top: 6px;">
                     <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/download_csv_template'); ?>" class="btn btn-xs btn-default">
                        <i class="fa fa-download text-green"></i> Unduh File Template CSV Siap Pakai
                     </a>
                  </div>
               </div>

               <div class="form-group">
                  <label>Pilih Target Campaign <span class="text-danger">*</span></label>
                  <select name="campaign_id" class="form-control" required style="border-radius: 6px;">
                     <option value="">-- Pilih Campaign --</option>
                     <?php foreach ($campaigns_dropdown as $c): ?>
                        <option value="<?= $c['id']; ?>">#<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?>)</option>
                     <?php endforeach; ?>
                  </select>
               </div>

               <div class="form-group">
                  <label>Pilih File CSV (.csv) <span class="text-danger">*</span></label>
                  <input type="file" name="file" accept=".csv,text/csv" class="form-control" required style="border-radius: 6px;">
                  <small class="text-muted">Maksimal 1000 baris / 2 MB. Duplicate nomor pesanan akan menolak seluruh batch.</small>
               </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 16px 24px;">
               <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary" id="btn-submit-csv">Mulai Import</button>
            </div>
         </form>
      </div>
   </div>
</div>



<!-- ========================================== -->
<!-- MODAL AUDIT DETAIL JSON                    -->
<!-- ========================================== -->
<div class="modal fade" id="modal-audit-json" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 8px;">
         <div class="modal-header" style="border-bottom: 1px solid #edf2f7; padding: 18px 24px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="font-weight: 700; color: #0f172a;"><i class="fa fa-code text-blue"></i> Detail Keputusan & Audit Snapshot</h4>
         </div>
         <div class="modal-body" style="padding: 20px;">
            <pre id="audit-json-content" style="background: #0f172a; color: #38bdf8; padding: 16px; border-radius: 6px; max-height: 450px; overflow: auto; font-size: 12px;"></pre>
         </div>
         <div class="modal-footer" style="border-top: 1px solid #edf2f7; padding: 14px 20px;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>

<script>
<?php $ci =& get_instance(); ?>
var CSRF_NAME = '<?= $ci->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $ci->security->get_csrf_hash(); ?>';
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

$(document).ready(function() {
   // iCheck initialization (matching Mayoritas Modul)
   $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
   });

   // check all (matching Mayoritas Modul)
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
      if (checkboxes.filter(':checked').length == checkboxes.length && checkboxes.length > 0) {
         checkAll.prop('checked', 'checked');
      } else {
         checkAll.removeProp('checked');
      }
      checkAll.iCheck('update');
   });

   // Bulk Action Apply (matching Mayoritas Modul)
   $('#apply').click(function () {
      var bulk = $('#bulk');
      var serialize_bulk = $('#form_order_prizes').serialize();
      var checked_ids = [];
      $('input.check:checked').each(function () {
         checked_ids.push($(this).val());
      });

      if (bulk.val() == 'delete') {
         if (checked_ids.length == 0) {
            swal('Peringatan', 'Silakan pilih minimal 1 data!', 'warning');
            return false;
         }
         swal({
            title: "Hapus Data Terpilih?",
            text: "Anda akan menghapus " + checked_ids.length + " data yang dipilih. Tindakan ini tidak dapat dibatalkan.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
         },
         function (isConfirm) {
            if (isConfirm) {
               $.ajax({
                  url: BASE_ADMIN + '/bulk_delete/<?= $active_tab; ?>',
                  type: 'POST',
                  data: serialize_bulk + '&' + CSRF_NAME + '=' + CSRF_HASH,
                  dataType: 'json',
                  success: function(res) {
                     if (res.csrf) CSRF_HASH = res.csrf.hash;
                     if (res.success) {
                        swal({
                           title: 'Berhasil!',
                           text: res.data.message || 'Data terpilih berhasil diproses.',
                           type: 'success',
                           timer: 1500,
                           showConfirmButton: false
                        });
                        setTimeout(function() { location.reload(); }, 1200);
                     } else {
                        swal('Gagal', res.message || 'Tidak dapat memproses data.', 'error');
                     }
                  },
                  error: function() {
                     swal('Error', 'Gagal memproses aksi massal.', 'error');
                  }
               });
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
   });

   // Ensure active dropdown row stays above sibling rows (matching Pesanan Penjualan)
   $(document).on('show.bs.dropdown', '.action-dropdown', function () {
      $(this).closest('tr').addClass('dropdown-open').css('z-index', 50);
   });

   $(document).on('hide.bs.dropdown', '.action-dropdown', function () {
      $(this).closest('tr').removeClass('dropdown-open').css('z-index', '');
   });

   // Copy ID Pesanan satu-klik
   function copyOrderId(text, callback) {
      if (navigator.clipboard && window.isSecureContext) {
         navigator.clipboard.writeText(text).then(function () {
            if (typeof callback === 'function') callback();
         }).catch(function () {
            fallbackCopy(text, callback);
         });
      } else {
         fallbackCopy(text, callback);
      }
   }

   function fallbackCopy(text, callback) {
      var textArea = document.createElement('textarea');
      textArea.value = text;
      textArea.style.position = 'fixed';
      textArea.style.left = '-9999px';
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      try {
         document.execCommand('copy');
         if (typeof callback === 'function') callback();
      } catch (err) {}
      document.body.removeChild(textArea);
   }

   $(document).on('click', '.btn-copy-order-id', function (e) {
      e.preventDefault();
      var orderId = $(this).attr('data-id');
      var $el = $(this);
      copyOrderId(orderId, function () {
         var originalHtml = $el.html();
         $el.html(orderId + ' <i class="fa fa-check text-green copy-icon" style="color: #10b981 !important;"></i>');
         setTimeout(function () {
            $el.html(originalHtml);
         }, 1500);
      });
   });
});

function showAuditDetail(jsonStr) {
   try {
      var parsed = typeof jsonStr === 'string' ? JSON.parse(jsonStr) : jsonStr;
      $('#audit-json-content').text(JSON.stringify(parsed, null, 2));
   } catch(e) {
      $('#audit-json-content').text(jsonStr);
   }
   $('#modal-audit-json').modal('show');
}

function openFulfillmentModal(spin) {
   $('#ful-spin-id').val(spin.id);
   $('#ful-prize-name').text(spin.prize_name);
   $('#ful-order-number').text(spin.order_number);
   $('#ful-phone').text(spin.phone);
   $('#ful-claim-status').val(spin.claim_status);
   $('#ful-prize-status').val(spin.prize_status);
   $('#ful-followup-status').val(spin.follow_up_status);
   $('#ful-broadcast-status').val(spin.broadcast_status);
   $('#ful-notes').val(spin.notes || '');
   $('#modal-fulfillment').modal('show');
}

$('#form-fulfillment').on('submit', function(e) {
   e.preventDefault();
   var spinId = $('#ful-spin-id').val();
   var formData = new FormData(this);
   formData.append(CSRF_NAME, CSRF_HASH);

   $('#btn-save-fulfillment').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

   $.ajax({
      url: BASE_ADMIN + '/fulfill/' + spinId,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) {
         if (res.csrf) CSRF_HASH = res.csrf.hash;
         if (res.success) {
            $('#modal-fulfillment').modal('hide');
            swal({
               title: 'Berhasil!',
               text: 'Status fulfillment berhasil diperbarui.',
               type: 'success',
               timer: 1500,
               showConfirmButton: false
            });
            setTimeout(function() { location.reload(); }, 1200);
         } else {
            swal('Perhatian', res.message || 'Gagal menyimpan.', 'warning');
         }
      },
      error: function(xhr) {
         var msg = 'Terjadi kesalahan sistem.';
         if (xhr.status === 403) {
            msg = 'Sesi atau token keamanan (CSRF) kedaluwarsa. Silakan refresh halaman (F5).';
         } else if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
         }
         swal('Error', msg, 'error');
      },
      complete: function() {
         $('#btn-save-fulfillment').prop('disabled', false).html('Simpan Perubahan');
      }
   });
});

$('#form-import-csv').on('submit', function(e) {
   e.preventDefault();
   var formData = new FormData(this);
   formData.append(CSRF_NAME, CSRF_HASH);

   $('#btn-submit-csv').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Mengimpor...');

   $.ajax({
      url: BASE_ADMIN + '/import_orders',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) {
         if (res.csrf) CSRF_HASH = res.csrf.hash;
         if (res.success) {
            $('#modal-import-csv').modal('hide');
            swal({
               title: 'Sukses!',
               text: (res.data.imported || 0) + ' order berhasil diimpor.',
               type: 'success'
            }, function() {
               location.reload();
            });
         } else {
            swal('Gagal Import', res.message || 'File tidak valid.', 'error');
         }
      },
      error: function(xhr) {
         var msg = 'Terjadi kesalahan saat mengimpor.';
         if (xhr.status === 403) msg = 'Sesi atau token keamanan kedaluwarsa. Silakan refresh.';
         else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
         swal('Gagal Import', msg, 'error');
      },
      complete: function() {
         $('#btn-submit-csv').prop('disabled', false).html('Mulai Import');
      }
   });
});



function deleteRecord(entity, id, title) {
   swal({
      title: 'Hapus / Nonaktifkan?',
      text: 'Anda akan menghapus data "' + title + '" (#' + id + ').',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
   }, function(isConfirm) {
      if (!isConfirm) return;

      var data = { id: id };
      data[CSRF_NAME] = CSRF_HASH;

      $.ajax({
         url: BASE_ADMIN + '/delete/' + entity + '/' + id,
         type: 'POST',
         data: data,
         dataType: 'json',
         success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
               swal({
                  title: 'Berhasil',
                  text: res.data.message || 'Data berhasil diproses.',
                  type: 'success',
                  timer: 1500,
                  showConfirmButton: false
               });
               setTimeout(function() { location.reload(); }, 1200);
            } else {
               swal('Gagal', res.message || 'Tidak dapat menghapus.', 'error');
            }
         },
         error: function(xhr) {
            var msg = 'Gagal memproses data.';
            if (xhr.status === 403) msg = 'Sesi CSRF kedaluwarsa. Silakan refresh.';
            else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            swal('Error', msg, 'error');
         }
      });
   });
}
</script>
