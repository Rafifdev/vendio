<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
   // Binding keyboard shortcuts
   function domo() {
      $('*').bind('keydown', 'Ctrl+a', function assets() {
         window.location.href = BASE_URL + '/administrator/plans/add';
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

<style>
   /* Action Dropdown 3-Dots Component */
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

   .action-dropdown .action-dropdown-menu {
      position: absolute !important;
      top: calc(100% + 5px) !important;
      right: 0 !important;
      left: auto !important;
      min-width: 170px !important;
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
   }

   .action-dropdown-menu .dropdown-item-action:hover {
      background-color: #f1f5f9 !important;
      color: #0f172a !important;
      padding-left: 17px !important;
   }

   .action-dropdown-menu .dropdown-item-action.item-danger {
      color: #e11d48 !important;
   }

   .action-dropdown-menu .dropdown-item-action.item-danger:hover {
      background-color: #fef2f2 !important;
      color: #be123c !important;
      padding-left: 17px !important;
   }

   /* Main Card Wrapper */
   .box-blog {
      border-radius: 8px;
      border: 1px solid #e5e9f0 !important;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
      background: #ffffff;
      margin-top: 14px;
      margin-bottom: 25px;
   }

   /* Header with Generous & Balanced Spacing */
   .box-blog .widget-user-header {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      padding: 22px 25px !important;
      border-bottom: 1px solid #edf2f7 !important;
      background: #ffffff !important;
      flex-wrap: wrap !important;
      gap: 16px !important;
   }

   .box-blog .header-left {
      display: flex !important;
      align-items: center !important;
      gap: 20px !important;
   }

   .box-blog .widget-user-image {
      width: 52px !important;
      height: 52px !important;
      flex-shrink: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
      float: none !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
   }

   .box-blog .widget-user-image img {
      width: 52px !important;
      height: 52px !important;
      border-radius: 50% !important;
      display: block !important;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
      float: none !important;
      margin: 0 !important;
   }

   .box-blog .header-titles {
      display: flex !important;
      flex-direction: column !important;
      justify-content: center !important;
      margin-left: 0 !important;
   }

   .box-blog .widget-user-username {
      font-size: 20px !important;
      font-weight: 700 !important;
      color: #1e293b !important;
      margin: 0 0 5px 0 !important;
      line-height: 1.2 !important;
   }

   .box-blog .widget-user-desc {
      font-size: 13px !important;
      color: #64748b !important;
      margin: 0 !important;
      display: flex !important;
      align-items: center !important;
      gap: 10px !important;
   }

   .box-blog .widget-user-desc .label {
      font-size: 11px !important;
      padding: 3px 9px !important;
      border-radius: 12px !important;
      font-weight: 600 !important;
      margin-left: 2px !important;
   }

   /* Header Top Action Buttons */
   .box-blog .header-right {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
   }

   .box-blog .btn-top-action {
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

   .box-blog .btn-top-action:hover {
      background-color: #008d4c !important;
      box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
      color: #ffffff !important;
   }

   /* Clean Table Styling */
   .box-blog .table-responsive {
      border: none;
      margin: 0;
      overflow: visible !important;
   }

   .box-blog .table-minimal {
      table-layout: auto;
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 0;
   }

   .box-blog .table-minimal thead th {
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

   .box-blog .table-minimal tbody td {
      border-top: 1px solid #f1f5f9;
      border-bottom: none;
      border-left: none;
      border-right: none;
      padding: 12px 14px;
      font-size: 13px;
      color: #334155;
      vertical-align: middle;
   }

   .box-blog .table-minimal tbody tr {
      position: relative;
      transition: background-color 0.15s ease;
   }

   .box-blog .table-minimal tbody tr:hover {
      background-color: #fbfcfd;
   }

   /* Pricing Badges & Limit Tags */
   .duration-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11.5px;
      padding: 2px 7px;
      border-radius: 4px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      margin: 2px 0;
      white-space: nowrap;
   }

   .discount-tag {
      font-size: 10px;
      font-weight: 700;
      padding: 1px 4px;
      border-radius: 3px;
   }

   .quota-spec {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 11.5px;
      color: #475569;
      margin-right: 8px;
      white-space: nowrap;
   }

   /* Bottom Toolbar & Pagination with Clean Modern Styling */
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

   .toolbar-controls-right .pagination>li>a,
   .toolbar-controls-right .pagination>li>span {
      border-radius: 4px !important;
      margin-left: 3px !important;
      border: 1px solid #cbd5e1 !important;
      color: #475569 !important;
      font-size: 12.5px !important;
      font-weight: 500 !important;
      padding: 5px 11px !important;
   }

   .toolbar-controls-right .pagination>.active>a,
   .toolbar-controls-right .pagination>.active>span {
      background-color: #00a65a !important;
      border-color: #00a65a !important;
      color: #ffffff !important;
      font-weight: 600 !important;
   }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('plans') ?> <small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('plans') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-blog">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <!-- Header -->
                  <div class="widget-user-header">
                     <div class="header-left">
                        <div class="widget-user-image">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                        </div>
                        <div class="header-titles">
                           <h3 class="widget-user-username"><?= cclang('plans') ?></h3>
                           <h5 class="widget-user-desc">
                              <?= cclang('list_all', [cclang('plans')]); ?>
                              <span class="label bg-yellow"><?= $plans_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <?php is_allowed('plans_add', function () { ?>
                           <a class="btn btn-top-action btn_add_new" id="btn_add_new"
                              title="<?= cclang('add_new_button', [cclang('plans')]); ?> (Ctrl+a)"
                              href="<?= site_url('administrator/plans/add'); ?>">
                              <i class="fa fa-plus-square-o"></i> <?= cclang('add_new_button', [cclang('plans')]); ?>
                           </a>
                        <?php }) ?>
                        <?php is_allowed('plans_export', function () { ?>
                           <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS"
                              href="<?= site_url('administrator/plans/export'); ?>">
                              <i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS
                           </a>
                        <?php }) ?>
                        <?php is_allowed('plans_export', function () { ?>
                           <a class="btn btn-top-action" title="<?= cclang('export'); ?> PDF"
                              href="<?= site_url('administrator/plans/export_pdf'); ?>">
                              <i class="fa fa-file-pdf-o"></i> <?= cclang('export'); ?> PDF
                           </a>
                        <?php }) ?>
                     </div>
                  </div>

                  <!-- Table -->
                  <form name="form_plans" id="form_plans" action="<?= base_url('administrator/plans/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all"
                                       title="<?= cclang('check_all'); ?>">
                                 </th>
                                 <th style="min-width: 220px;">Paket & Penawaran</th>
                                 <th style="width: 140px;">Harga Dasar</th>
                                 <th style="min-width: 200px;">Opsi Durasi & Diskon</th>
                                 <th style="min-width: 220px;">Batasan Kuota / Limits</th>
                                 <th style="width: 70px; text-align: center;">Urutan</th>
                                 <th style="width: 90px; text-align: center;">Status</th>
                                 <th style="width: 48px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_plans">
                              <?php if (empty($planss)): ?>
                                 <tr>
                                    <td colspan="100" style="text-align: center; padding: 35px 20px; color: #94a3b8;">
                                       <i class="fa fa-cubes"
                                          style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                       Belum ada data paket langganan yang tersedia
                                    </td>
                                 </tr>
                              <?php else: ?>
                                 <?php foreach ($planss as $plans): ?>
                                    <tr>
                                       <td style="text-align: center; width: 40px;">
                                          <input type="checkbox" class="flat-red check" name="id[]"
                                             value="<?= $plans->id; ?>">
                                       </td>
                                       <td>
                                          <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                             <strong
                                                style="color: #1e293b; font-size: 13.5px;"><?= _ent($plans->name); ?></strong>
                                             <?php if (!empty($plans->is_special)): ?>
                                                <span class="badge"
                                                   style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-weight: 700; font-size: 11px; padding: 3px 10px; border-radius: 12px;">
                                                   <i class="fa fa-star text-yellow" style="color: #d97706 !important;"></i>
                                                   <?= _ent($plans->special_badge ?: 'Paling Populer'); ?>
                                                </span>
                                             <?php endif; ?>
                                          </div>
                                          <?php if (!empty($plans->description)): ?>
                                             <div class="text-muted"
                                                style="font-size: 12px; margin-top: 3px; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?= _ent($plans->description); ?>
                                             </div>
                                          <?php endif; ?>
                                       </td>
                                       <td>
                                          <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                             Rp <?= number_format($plans->price_monthly, 0, ',', '.'); ?>
                                          </div>
                                          <span class="text-muted" style="font-size: 11px;">/ bulan</span>
                                       </td>
                                       <td>
                                          <ul style="list-style: none; padding-left: 0; margin-bottom: 0; color: #1e293b; font-size: 13px; line-height: 1.6;">
                                             <li>- 3 Bulan: Rp <?= number_format($plans->price_3_months, 0, ',', '.'); ?><?= ((float) $plans->discount_3_months > 0) ? ' -' . (float) $plans->discount_3_months . '%' : ''; ?></li>
                                             <li>- 6 Bulan: Rp <?= number_format($plans->price_6_months, 0, ',', '.'); ?><?= ((float) $plans->discount_6_months > 0) ? ' -' . (float) $plans->discount_6_months . '%' : ''; ?></li>
                                             <li>- 12 Bulan: Rp <?= number_format($plans->price_12_months, 0, ',', '.'); ?><?= ((float) $plans->discount_12_months > 0) ? ' -' . (float) $plans->discount_12_months . '%' : ''; ?></li>
                                          </ul>
                                       </td>
                                       <td>
                                          <ul style="list-style: none; padding-left: 0; margin-bottom: 0; color: #1e293b; font-size: 13px; line-height: 1.6;">
                                             <li>- <?= $plans->max_shops > 0 ? $plans->max_shops . ' Toko' : 'Unlimited Toko'; ?></li>
                                             <li>- <?= $plans->max_users > 0 ? $plans->max_users . ' Staf' : 'Unlimited Staf'; ?></li>
                                             <li>- <?= $plans->max_warehouses > 0 ? $plans->max_warehouses . ' Gudang' : 'Unlimited Gudang'; ?></li>
                                             <li>- <?= $plans->max_products > 0 ? number_format($plans->max_products, 0, ',', '.') . ' Produk' : 'Unlimited Produk'; ?></li>
                                          </ul>
                                       </td>
                                       <td style="text-align: center;">
                                          <span class="badge"
                                             style="background: #f1f5f9; color: #475569; font-weight: 600; font-size: 12px;">#<?= $plans->sort_order; ?></span>
                                       </td>
                                       <td style="text-align: center;">
                                          <?php if ($plans->status == 'active'): ?>
                                             <span class="label bg-green"
                                                style="border-radius: 12px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Active</span>
                                          <?php else: ?>
                                             <span class="label bg-gray"
                                                style="border-radius: 12px; padding: 3px 10px; font-size: 11px; font-weight: 600;">Inactive</span>
                                          <?php endif; ?>
                                       </td>
                                       <td style="text-align: center; white-space: nowrap;">
                                          <?= render_table_action([
                                             'view' => [
                                                'url' => site_url('administrator/plans/view/' . $plans->id),
                                                'permission' => 'plans_view',
                                             ],
                                             'edit' => [
                                                'url' => site_url('administrator/plans/edit/' . $plans->id),
                                                'permission' => 'plans_update',
                                             ],
                                             'delete' => [
                                                'data_href' => site_url('administrator/plans/delete/' . $plans->id),
                                                'permission' => 'plans_delete',
                                             ]
                                          ]); ?>
                                       </td>
                                    </tr>
                                 <?php endforeach; ?>
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
                              <button type="button" class="btn btn-apply" name="apply" id="apply"
                                 title="<?= cclang('apply_bulk_action'); ?>">
                                 <?= cclang('apply_button'); ?>
                              </button>
                           </div>

                           <div class="toolbar-divider"></div>

                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter"
                                 placeholder="<?= cclang('filter'); ?>..." value="<?= $this->input->get('q'); ?>"
                                 style="width: 170px;">

                              <select class="form-control" name="f" id="field" style="width: 160px;">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Nama Paket
                                 </option>
                                 <option <?= $this->input->get('f') == 'code' ? 'selected' : ''; ?> value="code">Kode
                                 </option>
                                 <option <?= $this->input->get('f') == 'status' ? 'selected' : ''; ?> value="status">Status
                                 </option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply"
                                 title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply"
                                 href="<?= base_url('administrator/plans'); ?>" title="<?= cclang('reset_filter'); ?>">
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
            <!--/box body -->
         </div>
         <!--/box -->
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
   $(document).ready(function () {

      $('.remove-data').click(function () {

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
         var serialize_bulk = $('#form_plans').serialize();

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
                     document.location.href = BASE_URL + '/administrator/plans/delete?' + serialize_bulk;
                  }
               });

            return false;

         } else if (bulk.val() == '') {
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

   }); /*end doc ready*/
</script>