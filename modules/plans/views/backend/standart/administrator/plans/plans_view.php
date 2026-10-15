<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
   function domo() {
      // Binding keys
      $('*').bind('keydown', 'Ctrl+e', function assets() {
         $('#btn_edit').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+x', function assets() {
         $('#btn_back').trigger('click');
         return false;
      });
   }

   jQuery(document).ready(domo);
</script>

<style>
   /* Clean & Refined Card Container */
   .box-form-modern {
      border-radius: 8px;
      border: 1px solid #e5e9f0 !important;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
      background: #ffffff;
      margin-top: 14px;
      margin-bottom: 25px;
   }

   .box-form-modern .widget-user-header {
      display: flex !important;
      align-items: center !important;
      padding: 22px 25px !important;
      border-bottom: 1px solid #edf2f7 !important;
      background: #ffffff !important;
      gap: 20px !important;
   }

   .box-form-modern .widget-user-image {
      width: 52px !important;
      height: 52px !important;
      flex-shrink: 0 !important;
      margin: 0 !important;
      padding: 0 !important;
      float: none !important;
   }

   .box-form-modern .widget-user-image img {
      width: 52px !important;
      height: 52px !important;
      border-radius: 50% !important;
      display: block !important;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
      float: none !important;
      margin: 0 !important;
   }

   .box-form-modern .header-titles {
      display: flex !important;
      flex-direction: column !important;
      justify-content: center !important;
      margin-left: 0 !important;
   }

   .box-form-modern .widget-user-username {
      font-size: 20px !important;
      font-weight: 700 !important;
      color: #1e293b !important;
      margin: 0 0 5px 0 !important;
      line-height: 1.2 !important;
   }

   .box-form-modern .widget-user-desc {
      font-size: 13px !important;
      color: #64748b !important;
      margin: 0 !important;
   }

   /* Detail Form Group Rows */
   .box-form-modern .form-group {
      margin-left: 0 !important;
      margin-right: 0 !important;
      margin-bottom: 0 !important;
      padding: 16px 25px !important;
      border-bottom: 1px solid #f8fafc;
      display: flex !important;
      align-items: flex-start !important;
   }

   .box-form-modern .form-group:hover {
      background-color: #fafbfc;
   }

   .box-form-modern .form-group .control-label {
      width: 210px !important;
      min-width: 210px !important;
      flex-shrink: 0 !important;
      text-align: left !important;
      color: #64748b !important;
      font-weight: 600 !important;
      font-size: 13.5px !important;
      padding: 0 !important;
      margin: 0 !important;
      line-height: 1.5 !important;
   }

   .box-form-modern .form-group .col-sm-8 {
      width: 100% !important;
      max-width: 680px !important;
      flex-grow: 1 !important;
      padding: 0 !important;
      color: #1e293b;
      font-size: 13.5px;
      line-height: 1.5;
   }

   /* Section Header Dividers inside View */
   .view-section-title {
      font-size: 14.5px;
      font-weight: 700;
      color: #0f172a;
      padding: 18px 25px 10px 25px;
      background-color: #f8fafc;
      border-top: 1px solid #edf2f7;
      border-bottom: 1px solid #edf2f7;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
   }

   .view-section-title i {
      color: #00a65a;
      font-size: 16px;
   }

   /* Duration Grid Cards */
   .pricing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 12px;
      margin-top: 5px;
   }

   .pricing-box {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 14px;
      background: #ffffff;
      text-align: left;
   }

   .pricing-box.highlight {
      border-color: #f59e0b;
      background: #fffbeb;
   }

   .pricing-box-label {
      font-size: 12px;
      font-weight: 600;
      color: #64748b;
      margin-bottom: 6px;
   }

   .pricing-box-amount {
      font-size: 18px;
      font-weight: 700;
      color: #0f172a;
   }

   .pricing-box-sub {
      font-size: 11.5px;
      color: #059669;
      margin-top: 4px;
      font-weight: 500;
   }

   /* Quota Grid */
   .quota-table {
      width: 100%;
      border-collapse: collapse;
   }

   .quota-table td {
      padding: 8px 12px;
      border: 1px solid #e2e8f0;
      font-size: 13px;
   }

   .quota-table td.header-col {
      background: #f8fafc;
      font-weight: 600;
      color: #475569;
      width: 200px;
   }

   /* Features checklist */
   .feature-checklist {
      list-style: none;
      padding: 0;
      margin: 0;
   }

   .feature-checklist li {
      padding: 6px 0;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13.5px;
      color: #334155;
      border-bottom: 1px dashed #f1f5f9;
   }

   .feature-checklist li:last-child {
      border-bottom: none;
   }

   /* Footer Action Buttons Container */
   .box-form-modern .view-nav {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      padding: 18px 25px;
      background-color: #fafbfc;
      border-top: 1px solid #edf2f7;
      border-bottom-left-radius: 8px;
      border-bottom-right-radius: 8px;
      margin-top: 15px;
   }

   .box-form-modern .view-nav .btn {
      height: 36px !important;
      padding: 0 16px !important;
      border-radius: 4px !important;
      font-size: 12.5px !important;
      font-weight: 600 !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      transition: all 0.15s ease !important;
   }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('plans') ?> <small><?= cclang('detail', [cclang('plans')]); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/plans'); ?>"><?= cclang('plans') ?></a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-form-modern">
            <div class="box-body" style="padding: 0;">
               <!-- Header -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username"><?= html_escape($plans->name); ?></h3>
                        <h5 class="widget-user-desc">
                           <?php if (!empty($plans->is_special)): ?>
                              <span class="label bg-yellow"><i class="fa fa-star" style="margin-right: 3px;"></i>
                                 <?= html_escape($plans->special_badge ?: 'Paling Populer'); ?></span>
                           <?php else: ?>
                              Detail Paket Langganan
                           <?php endif; ?>
                        </h5>
                     </div>
                  </div>

                  <div class="form-horizontal">
                     <!-- SECTION 1: IKHTISAR PAKET -->
                     <div class="view-section-title">
                        <span>Ikhtisar & Informasi Paket</span>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Nama Paket</label>
                        <div class="col-sm-8" style="font-weight:700; font-size:15px;">
                           <?= html_escape($plans->name); ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Deskripsi</label>
                        <div class="col-sm-8 text-muted">
                           <?= !empty($plans->description) ? nl2br(html_escape($plans->description)) : '<em>(Tidak ada deskripsi)</em>'; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Status</label>
                        <div class="col-sm-8">
                           <?php if ($plans->status == 'active'): ?>
                              <span class="label bg-green"
                                 style="border-radius:12px; padding:3px 10px; font-weight:600;">Active (Tersedia)</span>
                           <?php else: ?>
                              <span class="label bg-gray"
                                 style="border-radius:12px; padding:3px 10px; font-weight:600;">Inactive (Tidak
                                 Aktif)</span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Urutan Tampil</label>
                        <div class="col-sm-8">
                           <span class="badge"
                              style="background:#f1f5f9; color:#475569; font-weight:600;">#<?= $plans->sort_order; ?></span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Teks Tombol CTA</label>
                        <div class="col-sm-8">
                           <span class="btn btn-sm btn-success"
                              style="cursor:default;"><?= html_escape($plans->cta_text ?: 'Pilih Paket Ini'); ?></span>
                        </div>
                     </div>

                     <!-- SECTION 2: HARGA & OPSI DURASI -->
                     <div class="view-section-title">
                        <span>Harga & Opsi Durasi Langganan</span>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Struktur Harga</label>
                        <div class="col-sm-8">
                           <div class="pricing-grid">
                              <!-- 1 Month -->
                              <div class="pricing-box">
                                 <div class="pricing-box-label">1 Bulan (Base)</div>
                                 <div class="pricing-box-amount">Rp
                                    <?= number_format($plans->price_monthly, 0, ',', '.'); ?></div>
                                 <div class="pricing-box-sub" style="color:#64748b;">Harga normal per bulan</div>
                              </div>

                              <!-- 3 Months -->
                              <div class="pricing-box">
                                 <div class="pricing-box-label">
                                    3 Bulan
                                    <?php if ((float) $plans->discount_3_months > 0): ?>
                                       <span class="badge"
                                          style="background:#e0f2fe; color:#0369a1; font-size:10px; padding:2px 5px;">Diskon
                                          <?= (float) $plans->discount_3_months; ?>%</span>
                                    <?php endif; ?>
                                 </div>
                                 <div class="pricing-box-amount">Rp
                                    <?= number_format($plans->price_3_months, 0, ',', '.'); ?></div>
                                 <div class="pricing-box-sub">
                                    Rp <?= number_format(round($plans->price_3_months / 3), 0, ',', '.'); ?> / bulan
                                 </div>
                              </div>

                              <!-- 6 Months -->
                              <div class="pricing-box">
                                 <div class="pricing-box-label">
                                    6 Bulan
                                    <?php if ((float) $plans->discount_6_months > 0): ?>
                                       <span class="badge"
                                          style="background:#dbeafe; color:#1d4ed8; font-size:10px; padding:2px 5px;">Diskon
                                          <?= (float) $plans->discount_6_months; ?>%</span>
                                    <?php endif; ?>
                                 </div>
                                 <div class="pricing-box-amount">Rp
                                    <?= number_format($plans->price_6_months, 0, ',', '.'); ?></div>
                                 <div class="pricing-box-sub">
                                    Rp <?= number_format(round($plans->price_6_months / 6), 0, ',', '.'); ?> / bulan
                                 </div>
                              </div>

                              <!-- 12 Months -->
                              <div class="pricing-box <?= !empty($plans->is_special) ? 'highlight' : ''; ?>">
                                 <div class="pricing-box-label">
                                    12 Bulan
                                    <?php if ((float) $plans->discount_12_months > 0): ?>
                                       <span class="badge"
                                          style="background:#fef3c7; color:#b45309; font-size:10px; padding:2px 5px; font-weight:700;">Diskon
                                          <?= (float) $plans->discount_12_months; ?>%</span>
                                    <?php endif; ?>
                                 </div>
                                 <div class="pricing-box-amount">Rp
                                    <?= number_format($plans->price_12_months, 0, ',', '.'); ?></div>
                                 <div class="pricing-box-sub">
                                    Rp <?= number_format(round($plans->price_12_months / 12), 0, ',', '.'); ?> / bulan
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- SECTION 3: BATASAN KUOTA -->
                     <div class="view-section-title">
                        <span>Batasan Kuota / Limits Paket</span>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Spesifikasi Kuota</label>
                        <div class="col-sm-8">
                           <table class="quota-table">
                              <tr>
                                 <td class="header-col"><i class="fa fa-shopping-bag text-muted"></i> Maks. Toko
                                    Terhubung</td>
                                 <td>
                                    <?= $plans->max_shops > 0 ? '<b>' . $plans->max_shops . '</b> Toko / Cabang' : '<span class="text-success font-bold"><i class="fa fa-infinity"></i> Unlimited (Tidak Terbatas)</span>'; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="header-col"><i class="fa fa-users text-muted"></i> Maks. Pengguna / Staf
                                 </td>
                                 <td>
                                    <?= $plans->max_users > 0 ? '<b>' . $plans->max_users . '</b> Akun Staf' : '<span class="text-success font-bold"><i class="fa fa-infinity"></i> Unlimited (Tidak Terbatas)</span>'; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="header-col"><i class="fa fa-cubes text-muted"></i> Maks. Gudang</td>
                                 <td>
                                    <?= $plans->max_warehouses > 0 ? '<b>' . $plans->max_warehouses . '</b> Gudang' : '<span class="text-success font-bold"><i class="fa fa-infinity"></i> Unlimited (Tidak Terbatas)</span>'; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="header-col"><i class="fa fa-tags text-muted"></i> Maks. Produk Katalog</td>
                                 <td>
                                    <?= $plans->max_products > 0 ? '<b>' . number_format($plans->max_products, 0, ',', '.') . '</b> Produk SKU' : '<span class="text-success font-bold"><i class="fa fa-infinity"></i> Unlimited (Tidak Terbatas)</span>'; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="header-col"><i class="fa fa-file-text-o text-muted"></i> Maks. Order / Bulan
                                 </td>
                                 <td>
                                    <?= $plans->max_orders_per_month > 0 ? '<b>' . number_format($plans->max_orders_per_month, 0, ',', '.') . '</b> Transaksi Pesanan' : '<span class="text-success font-bold"><i class="fa fa-infinity"></i> Unlimited (Tidak Terbatas)</span>'; ?>
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>

                     <!-- SECTION 4: DAFTAR FITUR -->
                     <div class="view-section-title">
                        <span>Daftar Fitur Unggulan</span>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Fitur Paket</label>
                        <div class="col-sm-8">
                           <?php
                           $features_list = [];
                           if (!empty($plans->features)) {
                              $decoded = json_decode($plans->features, true);
                              if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                 $features_list = $decoded;
                              }
                           }
                           ?>
                           <?php if (empty($features_list)): ?>
                              <span class="text-muted"><em>(Belum ada rincian fitur untuk paket ini)</em></span>
                           <?php else: ?>
                              <ul class="feature-checklist">
                                 <?php foreach ($features_list as $feat): ?>
                                    <li>
                                       <i class="fa fa-check-circle text-success" style="font-size:16px;"></i>
                                       <span><?= html_escape($feat); ?></span>
                                    </li>
                                 <?php endforeach; ?>
                              </ul>
                           <?php endif; ?>
                        </div>
                     </div>

                     <!-- SECTION 5: METADATA -->
                     <div class="view-section-title">
                        <i class="fa fa-clock-o"></i>
                        <span>5. Informasi Waktu</span>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Dibuat Pada</label>
                        <div class="col-sm-8 text-muted">
                           <?= !empty($plans->created_at) ? date('d M Y, H:i', strtotime($plans->created_at)) : '-'; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Terakhir Diperbarui</label>
                        <div class="col-sm-8 text-muted">
                           <?= !empty($plans->updated_at) ? date('d M Y, H:i', strtotime($plans->updated_at)) : '-'; ?>
                        </div>
                     </div>

                     <!-- Footer Action Buttons -->
                     <div class="view-nav">
                        <?php is_allowed('plans_update', function () use ($plans) { ?>
                           <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit"
                              title="<?= cclang('update_button'); ?> (Ctrl+e)"
                              href="<?= site_url('administrator/plans/edit/' . $plans->id); ?>">
                              <i class="fa fa-pencil-square-o"></i> <?= cclang('update_button'); ?>
                           </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back"
                           title="<?= cclang('go_list_button', [cclang('plans')]); ?> (Ctrl+x)"
                           href="<?= site_url('administrator/plans'); ?>">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', [cclang('plans')]); ?>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>