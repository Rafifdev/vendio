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

   .box-blog .btn-top-action-secondary {
      height: 34px !important;
      padding: 0 12px !important;
      font-size: 12px !important;
      font-weight: 600 !important;
      border-radius: 4px !important;
      background-color: #ffffff !important;
      border: 1px solid #cbd5e1 !important;
      color: #475569 !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      transition: all 0.15s ease;
      text-decoration: none !important;
   }

   .box-blog .btn-top-action-secondary:hover {
      background-color: #f8fafc !important;
      border-color: #94a3b8 !important;
      color: #0f172a !important;
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

   /* Bottom Toolbar & Pagination */
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

   .box-footer-toolbar select.form-control,
   .box-footer-toolbar input.form-control {
      height: 33px !important;
      border-radius: 4px !important;
      border: 1px solid #cbd5e1 !important;
      font-size: 12.5px !important;
      padding: 4px 10px !important;
      box-shadow: none !important;
   }

   .box-footer-toolbar .btn-apply {
      height: 33px !important;
      padding: 0 13px !important;
      font-size: 12.5px !important;
      font-weight: 600 !important;
      border-radius: 4px !important;
      background-color: #f1f5f9 !important;
      border: 1px solid #cbd5e1 !important;
      color: #334155 !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      transition: all 0.15s ease;
   }

   .box-footer-toolbar .btn-apply:hover {
      background-color: #e2e8f0 !important;
      color: #0f172a !important;
   }

   .box-footer-toolbar .btn-search {
      height: 33px !important;
      padding: 0 13px !important;
      font-size: 12.5px !important;
      font-weight: 600 !important;
      border-radius: 4px !important;
      background-color: #00a65a !important;
      border: 1px solid #008d4c !important;
      color: #ffffff !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 5px !important;
   }

   .box-footer-toolbar .btn-search:hover {
      background-color: #008d4c !important;
   }

   .box-footer-toolbar .btn-reset {
      height: 33px !important;
      padding: 0 10px !important;
      font-size: 12px !important;
      border-radius: 4px !important;
      background-color: #ffffff !important;
      border: 1px solid #cbd5e1 !important;
      color: #64748b !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
   }

   .box-footer-toolbar .btn-reset:hover {
      background-color: #f8fafc !important;
      color: #0f172a !important;
   }

   .pagination-minimal {
      margin: 0;
   }

   .pagination-minimal .pagination {
      margin: 0;
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
         <div class="box-blog">
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
                  <?php is_allowed('plans_add', function(){ ?>
                     <a class="btn-top-action" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('plans')]); ?> (Ctrl+a)" href="<?= site_url('administrator/plans/add'); ?>">
                        <i class="fa fa-plus-circle"></i> Tambah Paket Baru
                     </a>
                  <?php }) ?>
                  <?php is_allowed('plans_export', function(){ ?>
                     <a class="btn-top-action-secondary" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/plans/export'); ?>">
                        <i class="fa fa-file-excel-o text-success"></i> XLS
                     </a>
                     <a class="btn-top-action-secondary" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/plans/export_pdf'); ?>">
                        <i class="fa fa-file-pdf-o text-danger"></i> PDF
                     </a>
                  <?php }) ?>
               </div>
            </div>

            <!-- Table -->
            <form name="form_plans" id="form_plans" action="<?= base_url('administrator/plans/index'); ?>">
               <div class="table-responsive">
                  <table class="table-minimal">
                     <thead>
                        <tr>
                           <th width="35" style="text-align:center;">
                              <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Check All">
                           </th>
                           <th width="240">Paket & Penawaran</th>
                           <th width="140">Harga 1 Bulan (Base)</th>
                           <th>Opsi Durasi & Diskon</th>
                           <th width="220">Batasan Kuota / Limits</th>
                           <th width="70" style="text-align:center;">Urutan</th>
                           <th width="90" style="text-align:center;">Status</th>
                           <th width="60" style="text-align:center;">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_plans">
                        <?php if (empty($planss)): ?>
                           <tr>
                              <td colspan="8" class="text-center" style="padding:40px 20px; color:#94a3b8;">
                                 <i class="fa fa-cubes" style="font-size:36px; margin-bottom:10px; display:block; opacity:0.4;"></i>
                                 Belum ada data paket langganan. Klik <b>Tambah Paket Baru</b> untuk membuat paket pertama.
                              </td>
                           </tr>
                        <?php else: ?>
                           <?php foreach ($planss as $plans): ?>
                              <tr>
                                 <td style="text-align:center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $plans->id; ?>">
                                 </td>
                                 <td>
                                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                                       <span style="font-weight:700; color:#0f172a; font-size:14px;"><?= html_escape($plans->name); ?></span>
                                       <code style="font-size:11px; background:#f1f5f9; color:#475569; padding:2px 6px; border-radius:4px; font-weight:600;"><?= html_escape($plans->code); ?></code>
                                       <?php if (!empty($plans->is_special)): ?>
                                          <span class="badge" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a; font-weight:700; font-size:11px; padding:3px 7px;">
                                             <i class="fa fa-star text-yellow" style="color:#d97706 !important;"></i> <?= html_escape($plans->special_badge ?: 'Paling Populer'); ?>
                                          </span>
                                       <?php endif; ?>
                                    </div>
                                    <?php if (!empty($plans->description)): ?>
                                       <div class="text-muted" style="font-size:12px; margin-top:3px; max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                          <?= html_escape($plans->description); ?>
                                       </div>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <div style="font-weight:700; color:#0f172a; font-size:14px;">
                                       Rp <?= number_format($plans->price_monthly, 0, ',', '.'); ?>
                                    </div>
                                    <span class="text-muted" style="font-size:11px;">/ bulan</span>
                                 </td>
                                 <td>
                                    <div style="display:flex; flex-direction:column; gap:3px;">
                                       <div class="duration-pill">
                                          <span style="font-weight:600; color:#334155; width:45px;">3 Bulan:</span>
                                          <span>Rp <?= number_format($plans->price_3_months, 0, ',', '.'); ?></span>
                                          <?php if ((float)$plans->discount_3_months > 0): ?>
                                             <span class="discount-tag" style="background:#e0f2fe; color:#0369a1;">-<?= (float)$plans->discount_3_months; ?>%</span>
                                          <?php endif; ?>
                                       </div>
                                       <div class="duration-pill">
                                          <span style="font-weight:600; color:#334155; width:45px;">6 Bulan:</span>
                                          <span>Rp <?= number_format($plans->price_6_months, 0, ',', '.'); ?></span>
                                          <?php if ((float)$plans->discount_6_months > 0): ?>
                                             <span class="discount-tag" style="background:#dbeafe; color:#1d4ed8;">-<?= (float)$plans->discount_6_months; ?>%</span>
                                          <?php endif; ?>
                                       </div>
                                       <div class="duration-pill">
                                          <span style="font-weight:600; color:#334155; width:45px;">12 Bulan:</span>
                                          <span>Rp <?= number_format($plans->price_12_months, 0, ',', '.'); ?></span>
                                          <?php if ((float)$plans->discount_12_months > 0): ?>
                                             <span class="discount-tag" style="background:#fef3c7; color:#b45309;">-<?= (float)$plans->discount_12_months; ?>%</span>
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    <div style="display:flex; flex-wrap:wrap; gap:4px 10px;">
                                       <span class="quota-spec" title="Maksimal Toko Terhubung">
                                          <i class="fa fa-shopping-bag text-muted"></i>
                                          <?= $plans->max_shops > 0 ? '<b>' . $plans->max_shops . '</b> Toko' : '<span style="color:#059669; font-weight:600;">Unlimited Toko</span>'; ?>
                                       </span>
                                       <span class="quota-spec" title="Maksimal Pengguna / Staf">
                                          <i class="fa fa-users text-muted"></i>
                                          <?= $plans->max_users > 0 ? '<b>' . $plans->max_users . '</b> Staf' : '<span style="color:#059669; font-weight:600;">Unlimited Staf</span>'; ?>
                                       </span>
                                       <span class="quota-spec" title="Maksimal Gudang">
                                          <i class="fa fa-cubes text-muted"></i>
                                          <?= $plans->max_warehouses > 0 ? '<b>' . $plans->max_warehouses . '</b> Gudang' : '<span style="color:#059669; font-weight:600;">Unlimited Gudang</span>'; ?>
                                       </span>
                                       <span class="quota-spec" title="Maksimal Produk">
                                          <i class="fa fa-tags text-muted"></i>
                                          <?= $plans->max_products > 0 ? '<b>' . number_format($plans->max_products, 0, ',', '.') . '</b> Prod' : '<span style="color:#059669; font-weight:600;">Unlimited Prod</span>'; ?>
                                       </span>
                                    </div>
                                 </td>
                                 <td style="text-align:center;">
                                    <span class="badge" style="background:#f1f5f9; color:#475569; font-weight:600; font-size:12px;">#<?= $plans->sort_order; ?></span>
                                 </td>
                                 <td style="text-align:center;">
                                    <?php if ($plans->status == 'active'): ?>
                                       <span class="label bg-green" style="border-radius:12px; padding:3px 10px; font-size:11px; font-weight:600;">Active</span>
                                    <?php else: ?>
                                       <span class="label bg-gray" style="border-radius:12px; padding:3px 10px; font-size:11px; font-weight:600;">Inactive</span>
                                    <?php endif; ?>
                                 </td>
                                 <td style="text-align:center;">
                                    <div class="action-dropdown">
                                       <button type="button" class="btn-action-dots" title="Aksi">
                                          <i class="fa fa-ellipsis-v"></i>
                                       </button>
                                       <ul class="action-dropdown-menu">
                                          <?php is_allowed('plans_view', function() use ($plans){ ?>
                                             <li>
                                                <a class="dropdown-item-action" href="<?= site_url('administrator/plans/view/' . $plans->id); ?>">
                                                   <i class="fa fa-eye text-primary"></i> Detail
                                                </a>
                                             </li>
                                          <?php }) ?>
                                          <?php is_allowed('plans_update', function() use ($plans){ ?>
                                             <li>
                                                <a class="dropdown-item-action" href="<?= site_url('administrator/plans/edit/' . $plans->id); ?>">
                                                   <i class="fa fa-edit text-success"></i> Edit
                                                </a>
                                             </li>
                                          <?php }) ?>
                                          <?php is_allowed('plans_delete', function() use ($plans){ ?>
                                             <li>
                                                <a class="dropdown-item-action item-danger remove-data" href="javascript:void(0)" data-href="<?= site_url('administrator/plans/delete/' . $plans->id); ?>">
                                                   <i class="fa fa-trash"></i> Hapus
                                                </a>
                                             </li>
                                          <?php }) ?>
                                       </ul>
                                    </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        <?php endif; ?>
                     </tbody>
                  </table>
               </div>

               <!-- Bottom Toolbar -->
               <div class="box-footer-toolbar">
                  <div class="toolbar-controls-left">
                     <!-- Bulk Actions -->
                     <div class="bulk-group">
                        <select name="apply" class="form-control" id="apply" style="width:130px;">
                           <option value="">Pilih Aksi</option>
                           <option value="delete">Hapus Terpilih</option>
                        </select>
                        <button type="button" class="btn-apply" id="apply_btn" title="Terapkan aksi masal">
                           Terapkan
                        </button>
                     </div>

                     <div class="toolbar-divider"></div>

                     <!-- Filter & Search -->
                     <div class="filter-group">
                        <select name="f" class="form-control" id="field" style="width:140px;">
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'name' ? 'selected' :''; ?> value="name">Nama Paket</option>
                           <option <?= $this->input->get('f') == 'code' ? 'selected' :''; ?> value="code">Kode</option>
                           <option <?= $this->input->get('f') == 'status' ? 'selected' :''; ?> value="status">Status</option>
                        </select>

                        <input type="text" class="form-control" name="q" id="filter" placeholder="Cari paket..." value="<?= $this->input->get('q'); ?>" style="width:170px;">

                        <button type="submit" class="btn-search" id="sbtn" title="Cari (Ctrl+f)">
                           <i class="fa fa-search"></i> Cari
                        </button>

                        <a class="btn-reset" id="reset" href="<?= site_url('administrator/plans'); ?>" title="Reset Filter (Ctrl+x)">
                           <i class="fa fa-refresh"></i>
                        </a>
                     </div>
                  </div>

                  <!-- Pagination -->
                  <div class="pagination-minimal">
                     <?= $pagination; ?>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>

<!-- Page script -->
<script>
   $(document).ready(function() {
      // 3-Dots Dropdown Trigger
      $(document).on('click', '.action-dropdown .btn-action-dots', function(e) {
         e.stopPropagation();
         var parent = $(this).closest('.action-dropdown');
         $('.action-dropdown').not(parent).removeClass('open');
         parent.toggleClass('open');
      });

      // Close dropdowns on click outside
      $(document).on('click', function() {
         $('.action-dropdown').removeClass('open');
      });

      // Check all checkbox
      $('#check_all').click(function() {
         var c = this.checked;
         $('.check').prop('checked', c);
      });

      // SweetAlert Single Delete Confirmation
      $('.remove-data').click(function() {
         var url = $(this).attr('data-href');

         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            closeOnCancel: true
         },
         function(isConfirm) {
            if (isConfirm) {
               document.location.href = url;
            }
         });

         return false;
      });

      // Bulk Action Button
      $('#apply_btn').click(function() {
         var bulkAction = $('#apply').val();

         if (bulkAction == 'delete') {
            var checkedCount = $('input[name="id[]"]:checked').length;
            if (checkedCount == 0) {
               swal({
                  title: "Peringatan",
                  text: "Silakan pilih setidaknya satu paket untuk dihapus.",
                  type: "warning"
               });
               return false;
            }

            swal({
               title: "<?= cclang('are_you_sure'); ?>",
               text: "Apakah Anda yakin ingin menghapus " + checkedCount + " paket yang dipilih?",
               type: "warning",
               showCancelButton: true,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Ya, Hapus Semua!",
               cancelButtonText: "Batal",
               closeOnConfirm: true,
               closeOnCancel: true
            },
            function(isConfirm) {
               if (isConfirm) {
                  $('#form_plans').attr('action', BASE_URL + 'administrator/plans/delete');
                  $('#form_plans').submit();
               }
            });
         } else {
            swal({
               title: "Peringatan",
               text: "Silakan pilih jenis aksi masal terlebih dahulu.",
               type: "info"
            });
         }
      });
   });
</script>