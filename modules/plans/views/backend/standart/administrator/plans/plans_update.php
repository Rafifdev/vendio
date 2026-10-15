<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
   function domo() {
      // Binding hotkeys
      $('*').bind('keydown', 'Ctrl+s', function assets() {
         $('#btn_save').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+x', function assets() {
         $('#btn_cancel').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+d', function assets() {
         $('.btn_save_back').trigger('click');
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

/* Section Header Dividers inside Form */
.form-section-title {
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

.form-section-title i {
   color: #00a65a;
   font-size: 16px;
}

.form-section-title .section-hint {
   font-size: 12px;
   font-weight: 400;
   color: #64748b;
   margin-left: auto;
}

/* Form Group Rows Alignment & Proximity */
.box-form-modern .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 16px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-form-modern .form-group:hover {
   background-color: #fafbfc;
}

.box-form-modern .form-group .control-label {
   width: 210px !important;
   min-width: 210px !important;
   flex-shrink: 0 !important;
   text-align: left !important;
   color: #334155 !important;
   font-weight: 600 !important;
   font-size: 13.5px !important;
   padding: 8px 0 0 0 !important;
   margin: 0 !important;
   line-height: 1.5 !important;
}

.box-form-modern .form-group .control-label .required {
   color: #ef4444;
   font-style: normal;
   font-weight: 700;
   margin-left: 3px;
}

.box-form-modern .form-group .col-sm-8 {
   width: 100% !important;
   max-width: 680px !important;
   flex-grow: 1 !important;
   padding: 0 !important;
}

/* Modern Input Styling */
.box-form-modern .form-control {
   border-radius: 6px !important;
   border: 1px solid #d1d5db !important;
   height: 38px !important;
   box-shadow: none !important;
   font-size: 13.5px !important;
   padding: 8px 12px !important;
   color: #1e293b !important;
   transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
}

.box-form-modern textarea.form-control {
   height: auto !important;
   line-height: 1.6 !important;
}

.box-form-modern .form-control:focus {
   border-color: #3b82f6 !important;
   box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
}

.box-form-modern .help-block {
   margin-top: 6px !important;
   margin-bottom: 0 !important;
   font-size: 12.5px !important;
   color: #64748b !important;
   line-height: 1.5 !important;
}

/* Duration Calculator Card */
.duration-card {
   border: 1px solid #e2e8f0;
   border-radius: 6px;
   padding: 12px 14px;
   background: #ffffff;
   margin-bottom: 10px;
   transition: all 0.2s ease;
}

.duration-card:hover {
   border-color: #cbd5e1;
   background: #fbfcfd;
}

.duration-card-header {
   display: flex;
   align-items: center;
   justify-content: space-between;
   font-weight: 600;
   font-size: 13px;
   color: #1e293b;
   margin-bottom: 8px;
}

.duration-calc-note {
   font-size: 11.5px;
   color: #059669;
   font-weight: 500;
   margin-top: 4px;
}

/* Feature Repeater Row */
.feature-item {
   display: flex;
   align-items: center;
   gap: 8px;
   margin-bottom: 8px;
}

.feature-item .btn-remove-feature {
   height: 38px;
   width: 38px;
   padding: 0;
   display: inline-flex;
   align-items: center;
   justify-content: center;
   border-radius: 6px;
   border: 1px solid #fecaca;
   background: #fff;
   color: #ef4444;
   transition: all 0.15s ease;
}

.feature-item .btn-remove-feature:hover {
   background: #fee2e2;
   color: #dc2626;
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

.box-form-modern .loading {
   margin-left: 10px;
   display: inline-flex;
   align-items: center;
   gap: 6px;
}

.box-form-modern .loading i {
   color: #64748b;
   font-size: 12.5px;
   font-style: normal;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('plans') ?> <small><?= cclang('update', [cclang('plans')]); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/plans'); ?>"><?= cclang('plans') ?></a></li>
      <li class="active"><?= cclang('update'); ?></li>
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
                        <img src="<?= BASE_ASSET; ?>/img/edit.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username"><?= cclang('plans') ?></h3>
                        <h5 class="widget-user-desc">Edit: <?= html_escape($plans->name); ?></h5>
                     </div>
                  </div>

                  <?= form_open(base_url('administrator/plans/edit_save/' . $this->uri->segment(4)), [
                     'name'    => 'form_plans',
                     'class'   => 'form-horizontal',
                     'id'      => 'form_plans',
                     'enctype' => 'multipart/form-data',
                     'method'  => 'POST'
                  ]); ?>

                  <!-- SECTION 1: INFORMASI DASAR -->
                  <div class="form-section-title">
                     <span>Informasi Dasar Paket</span>
                  </div>

                  <div class="form-group">
                     <label for="name" class="control-label">Nama Paket <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Contoh: Starter, Growth Pro, Enterprise..." value="<?= set_value('name', $plans->name); ?>">
                        <small class="info help-block">Nama paket langganan yang akan ditampilkan kepada tenant.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="description" class="control-label">Deskripsi Ringkas</label>
                     <div class="col-sm-8">
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Jelaskan secara ringkas peruntukan paket ini..."><?= set_value('description', $plans->description); ?></textarea>
                        <small class="info help-block">Penjelasan singkat target pengguna paket (misal: "Cocok untuk UMKM pemula dengan 1 cabang toko").</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="status" class="control-label">Status Paket <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <select class="form-control chosen chosen-select" name="status" id="status">
                           <option value="active" <?= set_value('status', $plans->status) == 'active' ? 'selected' : ''; ?>>Active (Tersedia untuk Langganan)</option>
                           <option value="inactive" <?= set_value('status', $plans->status) == 'inactive' ? 'selected' : ''; ?>>Inactive (Disembunyikan / Tidak Ditawarkan)</option>
                        </select>
                        <small class="info help-block">Jika Inactive, paket tidak akan muncul di daftar pilihan pendaftaran tenant baru.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="sort_order" class="control-label">Urutan Tampil</label>
                     <div class="col-sm-8">
                        <input type="number" class="form-control" name="sort_order" id="sort_order" placeholder="1" value="<?= set_value('sort_order', $plans->sort_order); ?>" style="max-width:140px;">
                        <small class="info help-block">Urutan tampilan pada halaman pricing kartu langganan (misal: 1 paling kiri/awal).</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="cta_text" class="control-label">Teks Tombol CTA</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="cta_text" id="cta_text" placeholder="Pilih Paket Ini" value="<?= set_value('cta_text', $plans->cta_text); ?>">
                        <small class="info help-block">Label teks pada tombol pembelian / pendaftaran (contoh: "Pilih Paket Ini", "Mulai Uji Coba Gratis", "Hubungi Sales").</small>
                     </div>
                  </div>

                  <!-- SECTION 2: PENAWARAN SPESIAL -->
                  <div class="form-section-title">
                     <span>Penawaran Spesial (Highlight Card)</span>
                  </div>

                  <div class="form-group">
                     <label for="is_special" class="control-label">Penawaran Spesial?</label>
                     <div class="col-sm-8">
                        <div class="checkbox" style="padding-top:7px; margin-top:0;">
                           <label style="font-weight:600; color:#1e293b; cursor:pointer;">
                              <input type="checkbox" name="is_special" id="is_special" value="1" <?= set_value('is_special', $plans->is_special) ? 'checked' : ''; ?>>
                              Tandai sebagai Penawaran Spesial / Paling Populer
                           </label>
                        </div>
                        <small class="info help-block">Paket ini akan diberi visual highlight khusus (border emas, badge bintang) di tabel harga.</small>
                     </div>
                  </div>

                  <div class="form-group" id="group_special_badge">
                     <label for="special_badge" class="control-label">Label Badge Spesial</label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="special_badge" id="special_badge" placeholder="Paling Populer" value="<?= set_value('special_badge', $plans->special_badge); ?>">
                        <small class="info help-block">Teks pada badge pita highlight (misal: "Paling Populer", "Rekomendasi", "Best Value").</small>
                     </div>
                  </div>

                  <!-- SECTION 3: KALKULATOR HARGA & DISKON BERTINGKAT -->
                  <div class="form-section-title">
                     <span>Kalkulator Harga & Opsi Durasi Langganan (1, 3, 6, 12 Bulan)</span>
                  </div>

                  <div class="form-group">
                     <label for="price_monthly" class="control-label">Harga Dasar (1 Bulan) <i class="required">*</i></label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:320px;">
                           <span class="input-group-addon" style="font-weight:600; background:#f8fafc; border-color:#cbd5e1;">Rp</span>
                           <input type="number" step="1000" class="form-control" name="price_monthly" id="price_monthly" placeholder="149000" value="<?= set_value('price_monthly', (float)$plans->price_monthly); ?>">
                        </div>
                        <small class="info help-block">Harga per bulan normal tanpa diskon. Semua durasi lain dapat dihitung otomatis dari nilai ini.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="control-label">Opsi Durasi Bertingkat</label>
                     <div class="col-sm-8">
                        <!-- 3 Months Card -->
                        <div class="duration-card">
                           <div class="duration-card-header">
                              <span><i class="fa fa-calendar-check-o text-primary"></i> Durasi 3 Bulan</span>
                              <span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:600;">Diskon Kuartal</span>
                           </div>
                           <div class="row">
                              <div class="col-xs-5">
                                 <div class="input-group">
                                    <input type="number" step="0.5" class="form-control duration-discount" name="discount_3_months" id="discount_3_months" data-months="3" placeholder="10" value="<?= set_value('discount_3_months', (float)$plans->discount_3_months); ?>">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">%</span>
                                 </div>
                              </div>
                              <div class="col-xs-7">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">Rp</span>
                                    <input type="number" step="100" class="form-control duration-price" name="price_3_months" id="price_3_months" data-months="3" placeholder="Total 3 Bulan" value="<?= set_value('price_3_months', (float)$plans->price_3_months); ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="duration-calc-note" id="note_3_months"></div>
                        </div>

                        <!-- 6 Months Card -->
                        <div class="duration-card">
                           <div class="duration-card-header">
                              <span><i class="fa fa-calendar-check-o text-info"></i> Durasi 6 Bulan</span>
                              <span class="badge" style="background:#dbeafe; color:#1d4ed8; font-weight:600;">Diskon Semester</span>
                           </div>
                           <div class="row">
                              <div class="col-xs-5">
                                 <div class="input-group">
                                    <input type="number" step="0.5" class="form-control duration-discount" name="discount_6_months" id="discount_6_months" data-months="6" placeholder="15" value="<?= set_value('discount_6_months', (float)$plans->discount_6_months); ?>">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">%</span>
                                 </div>
                              </div>
                              <div class="col-xs-7">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">Rp</span>
                                    <input type="number" step="100" class="form-control duration-price" name="price_6_months" id="price_6_months" data-months="6" placeholder="Total 6 Bulan" value="<?= set_value('price_6_months', (float)$plans->price_6_months); ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="duration-calc-note" id="note_6_months"></div>
                        </div>

                        <!-- 12 Months Card -->
                        <div class="duration-card">
                           <div class="duration-card-header">
                              <span><i class="fa fa-calendar-check-o text-success"></i> Durasi 12 Bulan (1 Tahun)</span>
                              <span class="badge" style="background:#fef3c7; color:#b45309; font-weight:700;">Diskon Tahunan Maksimal</span>
                           </div>
                           <div class="row">
                              <div class="col-xs-5">
                                 <div class="input-group">
                                    <input type="number" step="0.5" class="form-control duration-discount" name="discount_12_months" id="discount_12_months" data-months="12" placeholder="25" value="<?= set_value('discount_12_months', (float)$plans->discount_12_months); ?>">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">%</span>
                                 </div>
                              </div>
                              <div class="col-xs-7">
                                 <div class="input-group">
                                    <span class="input-group-addon" style="background:#f8fafc; border-color:#cbd5e1;">Rp</span>
                                    <input type="number" step="100" class="form-control duration-price" name="price_12_months" id="price_12_months" data-months="12" placeholder="Total 12 Bulan" value="<?= set_value('price_12_months', (float)$plans->price_12_months); ?>">
                                 </div>
                              </div>
                           </div>
                           <div class="duration-calc-note" id="note_12_months"></div>
                        </div>

                        <small class="info help-block">
                           Ketik persentase diskon atau masukkan nominal harga total langsung. Sistem akan menghitung penghematan dan harga per bulan secara otomatis.
                        </small>
                     </div>
                  </div>

                  <!-- SECTION 4: BATASAN KUOTA & LIMITS -->
                  <div class="form-section-title">
                     <span>Batasan Kuota / Limits Paket</span>
                  </div>

                  <div class="form-group">
                     <label for="max_shops" class="control-label">Maks. Toko Terhubung</label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:240px;">
                           <input type="number" class="form-control" name="max_shops" id="max_shops" placeholder="1" value="<?= set_value('max_shops', $plans->max_shops); ?>">
                           <span class="input-group-addon" style="background:#f8fafc;">Toko / Cabang</span>
                        </div>
                        <small class="info help-block">Jumlah maksimal toko/marketplace terhubung. Isi <code>0</code> untuk Unlimited.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="max_users" class="control-label">Maks. Staf / Pengguna</label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:240px;">
                           <input type="number" class="form-control" name="max_users" id="max_users" placeholder="2" value="<?= set_value('max_users', $plans->max_users); ?>">
                           <span class="input-group-addon" style="background:#f8fafc;">Akun Staf</span>
                        </div>
                        <small class="info help-block">Jumlah akun staf/karyawan yang dapat ditambahkan tenant. Isi <code>0</code> untuk Unlimited.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="max_warehouses" class="control-label">Maks. Gudang</label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:240px;">
                           <input type="number" class="form-control" name="max_warehouses" id="max_warehouses" placeholder="1" value="<?= set_value('max_warehouses', $plans->max_warehouses); ?>">
                           <span class="input-group-addon" style="background:#f8fafc;">Lokasi Gudang</span>
                        </div>
                        <small class="info help-block">Jumlah lokasi gudang penyimpanan barang. Isi <code>0</code> untuk Unlimited.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="max_products" class="control-label">Maks. Produk</label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:240px;">
                           <input type="number" class="form-control" name="max_products" id="max_products" placeholder="500" value="<?= set_value('max_products', $plans->max_products); ?>">
                           <span class="input-group-addon" style="background:#f8fafc;">Item SKU</span>
                        </div>
                        <small class="info help-block">Batas total katalog produk SKU yang diunggah. Isi <code>0</code> untuk Unlimited.</small>
                     </div>
                  </div>

                  <div class="form-group">
                     <label for="max_orders_per_month" class="control-label">Maks. Order / Bulan</label>
                     <div class="col-sm-8">
                        <div class="input-group" style="max-width:240px;">
                           <input type="number" class="form-control" name="max_orders_per_month" id="max_orders_per_month" placeholder="1000" value="<?= set_value('max_orders_per_month', $plans->max_orders_per_month); ?>">
                           <span class="input-group-addon" style="background:#f8fafc;">Transaksi / Bln</span>
                        </div>
                        <small class="info help-block">Batas transaksi pesanan per bulan. Isi <code>0</code> untuk Unlimited.</small>
                     </div>
                  </div>

                  <!-- SECTION 5: DAFTAR FITUR -->
                  <div class="form-section-title">
                     <span>Daftar Fitur Unggulan Paket</span>
                  </div>

                  <div class="form-group">
                     <label class="control-label">Daftar Fitur</label>
                     <div class="col-sm-8">
                        <div id="features_container">
                           <?php
                           $features_list = [];
                           if (!empty($plans->features)) {
                              $decoded = json_decode($plans->features, true);
                              if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                 $features_list = $decoded;
                              }
                           }
                           if (empty($features_list)) {
                              $features_list = [''];
                           }
                           ?>
                           <?php foreach ($features_list as $feat): ?>
                              <div class="feature-item">
                                 <i class="fa fa-check text-green" style="font-size:14px; width:18px; text-align:center;"></i>
                                 <input type="text" name="features[]" class="form-control" placeholder="Tuliskan nama fitur..." value="<?= html_escape($feat); ?>">
                                 <button type="button" class="btn btn-remove-feature" title="Hapus"><i class="fa fa-trash"></i></button>
                              </div>
                           <?php endforeach; ?>
                        </div>

                        <div style="margin-top:10px;">
                           <button type="button" class="btn btn-default btn-sm" id="btn_add_feature" style="border-radius:6px; font-weight:600;">
                              <i class="fa fa-plus text-success"></i> Tambah Baris Fitur
                           </button>
                        </div>
                        <small class="info help-block">Fitur ini akan muncul sebagai daftar checklist keunggulan paket bagi calon tenant.</small>
                     </div>
                  </div>

                  <div class="message" style="display:none; margin: 15px 25px 0 25px;"></div>

                  <!-- Footer Buttons -->
                  <div class="view-nav">
                     <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype="stay" title="<?= cclang('save_button'); ?> (Ctrl+s)">
                        <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                     </button>
                     <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype="back" title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                        <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
                     </a>
                     <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                        <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
                     </a>
                     <span class="loading loading-hide" style="display:none;">
                        <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg">
                        <i><?= cclang('loading_saving_data'); ?></i>
                     </span>
                  </div>

                  <?= form_close(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Page script -->
<script>
   function formatRupiah(num) {
      return new Intl.NumberFormat('id-ID').format(Math.round(num));
   }

   function updateDurationCalculations() {
      var base = parseFloat($('#price_monthly').val()) || 0;

      [3, 6, 12].forEach(function(m) {
         var discInput = $('#discount_' + m + '_months');
         var priceInput = $('#price_' + m + '_months');
         var noteElem = $('#note_' + m + '_months');

         var disc = parseFloat(discInput.val()) || 0;
         var curPrice = parseFloat(priceInput.val()) || 0;

         if (base > 0) {
            var rawTotal = base * m;
            var finalPrice = curPrice > 0 ? curPrice : Math.round(rawTotal * (1 - (disc / 100)));
            if (curPrice <= 0) {
               priceInput.val(finalPrice);
            }

            var savings = rawTotal - finalPrice;
            var perMonth = Math.round(finalPrice / m);
            noteElem.html('Normal: Rp ' + formatRupiah(rawTotal) + ' &bull; Hemat: Rp ' + formatRupiah(savings) + ' (<b>Rp ' + formatRupiah(perMonth) + ' / bln</b>)');
         } else {
            noteElem.html('');
         }
      });
   }

   $(document).ready(function() {
      // Interactive Price Monthly calculation
      $('#price_monthly').on('input change', function() {
         var base = parseFloat($(this).val()) || 0;
         [3, 6, 12].forEach(function(m) {
            var discInput = $('#discount_' + m + '_months');
            var priceInput = $('#price_' + m + '_months');
            var noteElem = $('#note_' + m + '_months');
            var disc = parseFloat(discInput.val()) || 0;

            if (base > 0) {
               var rawTotal = base * m;
               var finalPrice = Math.round(rawTotal * (1 - (disc / 100)));
               priceInput.val(finalPrice);

               var savings = rawTotal - finalPrice;
               var perMonth = Math.round(finalPrice / m);
               noteElem.html('Normal: Rp ' + formatRupiah(rawTotal) + ' &bull; Hemat: Rp ' + formatRupiah(savings) + ' (<b>Rp ' + formatRupiah(perMonth) + ' / bln</b>)');
            }
         });
      });

      // When discount percent is typed
      $('.duration-discount').on('input change', function() {
         var m = $(this).data('months');
         var base = parseFloat($('#price_monthly').val()) || 0;
         var disc = parseFloat($(this).val()) || 0;
         var priceInput = $('#price_' + m + '_months');
         var noteElem = $('#note_' + m + '_months');

         if (base > 0) {
            var rawTotal = base * m;
            var finalPrice = Math.round(rawTotal * (1 - (disc / 100)));
            priceInput.val(finalPrice);

            var savings = rawTotal - finalPrice;
            var perMonth = Math.round(finalPrice / m);
            noteElem.html('Normal: Rp ' + formatRupiah(rawTotal) + ' &bull; Hemat: Rp ' + formatRupiah(savings) + ' (<b>Rp ' + formatRupiah(perMonth) + ' / bln</b>)');
         }
      });

      // When total price is typed directly (reverse calculate discount)
      $('.duration-price').on('input change', function() {
         var m = $(this).data('months');
         var base = parseFloat($('#price_monthly').val()) || 0;
         var userPrice = parseFloat($(this).val()) || 0;
         var discInput = $('#discount_' + m + '_months');
         var noteElem = $('#note_' + m + '_months');

         if (base > 0 && userPrice > 0) {
            var rawTotal = base * m;
            var disc = ((1 - (userPrice / rawTotal)) * 100);
            disc = Math.max(0, parseFloat(disc.toFixed(2)));
            discInput.val(disc);

            var savings = rawTotal - userPrice;
            var perMonth = Math.round(userPrice / m);
            noteElem.html('Normal: Rp ' + formatRupiah(rawTotal) + ' &bull; Hemat: Rp ' + formatRupiah(savings) + ' (<b>Rp ' + formatRupiah(perMonth) + ' / bln</b>)');
         }
      });

      // Special offer toggle
      function toggleSpecialBadge() {
         if ($('#is_special').is(':checked')) {
            $('#group_special_badge').show();
         } else {
            $('#group_special_badge').hide();
         }
      }
      $('#is_special').on('change', toggleSpecialBadge);
      toggleSpecialBadge();

      // Feature Repeater
      $('#btn_add_feature').click(function() {
         var html = '<div class="feature-item">' +
            '<i class="fa fa-check text-green" style="font-size:14px; width:18px; text-align:center;"></i>' +
            '<input type="text" name="features[]" class="form-control" placeholder="Tuliskan nama fitur...">' +
            '<button type="button" class="btn btn-remove-feature" title="Hapus"><i class="fa fa-trash"></i></button>' +
         '</div>';
         $('#features_container').append(html);
      });

      $(document).on('click', '.btn-remove-feature', function() {
         if ($('#features_container .feature-item').length > 1) {
            $(this).closest('.feature-item').remove();
         } else {
            $(this).closest('.feature-item').find('input').val('');
         }
      });

      // Run initial calculation display
      updateDurationCalculations();

      // Cancel button
      $('#btn_cancel').click(function() {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "Perubahan yang belum disimpan akan hilang.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Keluar!",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            closeOnCancel: true
         },
         function(isConfirm) {
            if (isConfirm) {
               window.location.href = BASE_URL + 'administrator/plans';
            }
         });

         return false;
      });

      // Save button AJAX
      $('.btn_save').click(function() {
         $('.message').fadeOut();

         var form_plans = $('#form_plans');
         var data_post = form_plans.serializeArray();
         var save_type = $(this).attr('data-stype');

         data_post.push({ name: 'save_type', value: save_type });

         $('.loading').show();

         $.ajax({
            url: form_plans.attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data_post,
         })
         .done(function(res) {
            if (res.success) {
               if (save_type == 'back') {
                  window.location.href = res.redirect;
                  return;
               }

               $('.message').printMessage({ message: res.message });
               $('.message').fadeIn();
               updateDurationCalculations();
            } else {
               $('.message').printMessage({ message: res.message, type: 'warning' });
            }
         })
         .fail(function() {
            $('.message').printMessage({ message: 'Terjadi kesalahan saat menyimpan data.', type: 'warning' });
         })
         .always(function() {
            $('.loading').hide();
            $('html, body').animate({ scrollTop: $(document).height() }, 1000);
         });

         return false;
      });
   });
</script>