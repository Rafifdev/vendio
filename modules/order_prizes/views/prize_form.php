<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+s', function assets() {
      $('#btn_save').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_cancel').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+d', function assets() {
      $('#btn_save_back').trigger('click');
      return false;
   });
}

jQuery(document).ready(domo);
</script>

<style>
/* Clean & Refined Card Container - Matching Pesanan Penjualan */
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
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-form-modern .header-left {
   display: flex !important;
   align-items: center !important;
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

/* Form Group Rows Alignment & Proximity */
.box-form-modern .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 14px 25px !important;
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
   max-width: 720px !important;
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
}

.box-form-modern .form-control:focus {
   border-color: #3b82f6 !important;
   box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
}

.box-form-modern .input-group-addon {
   background: #f8fafc !important;
   border: 1px solid #d1d5db !important;
   color: #64748b !important;
   font-weight: 600 !important;
   font-size: 13px !important;
}

.box-form-modern .help-block {
   margin-top: 6px !important;
   margin-bottom: 0 !important;
   font-size: 12.5px !important;
   color: #64748b !important;
   line-height: 1.5 !important;
}

.threshold-card {
   background: #f8fafc;
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   padding: 16px 20px;
   margin-top: 6px;
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
      Hadiah Pesanan <small><?= $mode === 'edit' ? cclang('update', ['Hadiah']) : cclang('new', ['Hadiah']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/order_prizes/tab/prizes'); ?>">Hadiah Pesanan</a></li>
      <li class="active"><?= $mode === 'edit' ? cclang('update') : cclang('new'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-form-modern">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <div class="widget-user-header">
                     <div class="header-left">
                        <div class="widget-user-image">
                           <img src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                        </div>
                        <div class="header-titles">
                           <h3 class="widget-user-username">Hadiah Pesanan - Varian Hadiah & Threshold</h3>
                           <h5 class="widget-user-desc"><?= $mode === 'edit' ? 'Perbarui Data Hadiah & Syarat Peluang Keluar' : 'Tambah Hadiah Baru & Konfigurasi Peluang Undian'; ?></h5>
                        </div>
                     </div>
                     <div>
                        <button type="button" class="btn btn-sm btn-default" id="btn-preset-fallback" style="color: #d97706; border-color: #fde68a; background: #fffbeb; font-weight: 600;">
                           <i class="fa fa-magic"></i> 1-Klik Hadiah Zonk (Fallback)
                        </button>
                     </div>
                  </div>

                  <form class="form-horizontal" id="form-prize" method="POST">
                     <input type="hidden" name="id" value="<?= $prize['id']; ?>">
                     <input type="hidden" name="auto_metric" value="none">
                     <input type="hidden" name="allocation_percent" value="10">

                     <!-- Hubungkan ke Campaign -->
                     <div class="form-group">
                        <label class="control-label">Target Campaign <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; padding: 10px 14px; max-height: 140px; overflow-y: auto;">
                              <div style="display: flex; justify-content: flex-end; margin-bottom: 6px;">
                                 <button type="button" class="btn btn-xs btn-default" id="btn-toggle-campaigns">
                                    <i class="fa fa-check-square-o"></i> Pilih Semua
                                 </button>
                              </div>
                              <?php if (empty($campaigns_dropdown)): ?>
                                 <div class="text-muted" style="font-size: 12px;">Belum ada campaign dibuat. Hadiah tetap bisa disimpan sebagai master hadiah.</div>
                              <?php else: foreach ($campaigns_dropdown as $c): ?>
                                 <?php $isLinked = in_array((int)$c['id'], $linked_campaign_ids ?? [$prize['campaign_id']]); ?>
                                 <div style="margin-bottom: 6px;">
                                    <label style="font-weight: normal; cursor: pointer; margin-bottom: 0; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                                       <input type="checkbox" name="campaign_ids[]" class="campaign-item-checkbox" value="<?= $c['id']; ?>" <?= $isLinked ? 'checked' : ''; ?>>
                                       <span><strong>#<?= $c['id']; ?></strong> - <?= html_escape($c['name']); ?> <span class="badge" style="font-size: 10px; background: #f1f5f9; color: #475569;"><?= strtoupper($c['channel']); ?></span></span>
                                    </label>
                                 </div>
                              <?php endforeach; endif; ?>
                           </div>
                           <small class="info help-block">Pilih campaign-campaign yang mengikutsertakan hadiah ini pada roda undian.</small>
                        </div>
                     </div>

                     <!-- Nama Hadiah -->
                     <div class="form-group">
                        <label for="prize-name" class="control-label">Nama Hadiah <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="name" id="prize-name" placeholder="Contoh: Logam Mulia Emas 1 Gram / Voucher Belanja Rp 100.000" value="<?= html_escape($prize['name']); ?>" required maxlength="160">
                           <small class="info help-block">Nama hadiah yang tertera pada roda putar dan voucher pemenang.</small>
                        </div>
                     </div>

                     <!-- Jenis Hadiah -->
                     <div class="form-group">
                        <label for="prize-kind" class="control-label">Jenis Hadiah <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select class="form-control" name="kind" id="prize-kind" required style="max-width: 320px;">
                              <option value="physical" <?= $prize['kind'] === 'physical' ? 'selected' : ''; ?>>Fisik (Barang / Produk Dikirim)</option>
                              <option value="voucher" <?= $prize['kind'] === 'voucher' ? 'selected' : ''; ?>>Voucher / Kupon Diskon</option>
                              <option value="none" <?= $prize['kind'] === 'none' ? 'selected' : ''; ?>>Belum Beruntung (Zonk Fallback)</option>
                           </select>
                           <small class="info help-block">Format hadiah menentukan proses klaim dan pengiriman pemenang.</small>
                        </div>
                     </div>

                     <!-- Status Hadiah -->
                     <div class="form-group">
                        <label for="prize-active" class="control-label">Status Hadiah <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select class="form-control" name="active" id="prize-active" required style="max-width: 240px;">
                              <option value="1" <?= $prize['active'] == 1 ? 'selected' : ''; ?>>Aktif (Dapat Dimenangkan)</option>
                              <option value="0" <?= $prize['active'] == 0 ? 'selected' : ''; ?>>Non-Aktif (Diarsipkan)</option>
                           </select>
                           <small class="info help-block">Hadiah non-aktif tidak akan pernah keluar saat pembeli memutar undian.</small>
                        </div>
                     </div>

                     <!-- Bobot Peluang Relatif -->
                     <div class="form-group">
                        <label for="prize-weight" class="control-label">Bobot Peluang (Weight) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="number" class="form-control" name="weight" id="prize-weight" min="1" max="1000000" value="<?= $prize['weight'] ?: 10; ?>" required style="max-width: 160px;">
                           <small class="info help-block">Semakin besar angka bobot, semakin tinggi peluang keluar dibanding hadiah lain (misal Zonk = 50, Hadiah Utama = 1).</small>
                        </div>
                     </div>

                     <!-- Deskripsi Singkat -->
                     <div class="form-group">
                        <label for="prize-desc" class="control-label">Deskripsi / Catatan Pemenang</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" name="description" id="prize-desc" rows="2" placeholder="Keterangan tambahan untuk pemenang (misal: syarat penukaran voucher, varian warna produk, dll)..."><?= html_escape($prize['description']); ?></textarea>
                           <small class="info help-block">Informasi singkat yang ditampilkan kepada pemenang saat berhasil memenangkan hadiah ini.</small>
                        </div>
                     </div>

                     <!-- Sisa Kuota Stok -->
                     <div class="form-group">
                        <label for="prize-stock" class="control-label">Sisa Kuota Stok</label>
                        <div class="col-sm-8">
                           <div class="input-group" style="max-width: 420px;">
                              <input type="number" class="form-control" name="stock" id="prize-stock" min="0" max="1000000" placeholder="Kosongkan jika tidak terbatas" value="<?= html_escape($prize['stock']); ?>" <?= $prize['stock'] === null || $prize['stock'] === '' ? 'disabled' : ''; ?>>
                              <span class="input-group-addon" style="border-radius: 0 6px 6px 0; border-left: 1px solid #d1d5db;">
                                 <label style="margin: 0; font-weight: normal; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                                    <input type="checkbox" id="prize-unlimited" <?= $prize['stock'] === null || $prize['stock'] === '' ? 'checked' : ''; ?>>
                                    <span>Tidak Terbatas (Unlimited)</span>
                                 </label>
                              </span>
                           </div>
                           <small class="info help-block">Stok akan berkurang otomatis saat dimenangkan. Jika stok 0, hadiah tidak akan dikeluarkan lagi.</small>
                        </div>
                     </div>

                     <!-- Biaya Internal Hadiah -->
                     <div class="form-group">
                        <label for="prize-cost" class="control-label">Biaya Hadiah (Cost IDR) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <div class="input-group" style="max-width: 320px;">
                              <span class="input-group-addon" style="border-radius: 6px 0 0 6px; border-right: none;">Rp</span>
                              <input type="text" inputmode="numeric" class="form-control input-nominal" name="cost" id="prize-cost" placeholder="0" value="<?= !empty($prize['cost']) ? number_format((int)$prize['cost'], 0, ',', '.') : '0'; ?>" required style="border-radius: 0 6px 6px 0 !important;">
                           </div>
                           <small class="info help-block">Estimasi biaya riil toko untuk menyediakan hadiah ini (untuk Zonk atau kupon tanpa biaya, isi <code>0</code>).</small>
                        </div>
                     </div>

                     <!-- Aturan Threshold -->
                     <div class="form-group">
                        <label class="control-label">Aturan Threshold (Batas Aman)</label>
                        <div class="col-sm-8">
                           <div class="threshold-card">
                              <div style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                 <i class="fa fa-sliders text-green"></i> Kapan Hadiah Ini Boleh Berpeluang Keluar?
                              </div>
                              <div style="font-size: 12px; color: #64748b; margin-bottom: 12px;">
                                 Kosongkan jika hadiah boleh berpeluang keluar kapan saja sejak putaran pertama tanpa syarat.
                              </div>

                              <div class="row">
                                 <div class="col-sm-4">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569;">Min. Total Spin</label>
                                    <input type="number" class="form-control" name="threshold_spins" id="prize-thresh-spins" min="0" placeholder="Cth: 100" value="<?= !empty($prize['threshold_spins']) ? (int)$prize['threshold_spins'] : ''; ?>">
                                    <small class="text-muted" style="font-size: 11px;">Baru keluar setelah N spin.</small>
                                 </div>
                                 <div class="col-sm-4">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569;">Min. Omset Masuk</label>
                                    <div class="input-group">
                                       <span class="input-group-addon" style="border-radius: 6px 0 0 6px; border-right: none; font-size: 11px;">Rp</span>
                                       <input type="text" inputmode="numeric" class="form-control input-nominal" name="threshold_revenue" id="prize-thresh-revenue" placeholder="Cth: 10.000.000" value="<?= !empty($prize['threshold_revenue']) ? number_format((int)$prize['threshold_revenue'], 0, ',', '.') : ''; ?>" style="border-radius: 0 6px 6px 0 !important;">
                                    </div>
                                    <small class="text-muted" style="font-size: 11px;">Batas minimal omset toko.</small>
                                 </div>
                                 <div class="col-sm-4">
                                    <label style="font-size: 12px; font-weight: 500; color: #475569;">Min. Profit Masuk</label>
                                    <div class="input-group">
                                       <span class="input-group-addon" style="border-radius: 6px 0 0 6px; border-right: none; font-size: 11px;">Rp</span>
                                       <input type="text" inputmode="numeric" class="form-control input-nominal" name="threshold_profit" id="prize-thresh-profit" placeholder="Cth: 5.000.000" value="<?= !empty($prize['threshold_profit']) ? number_format((int)$prize['threshold_profit'], 0, ',', '.') : ''; ?>" style="border-radius: 0 6px 6px 0 !important;">
                                    </div>
                                    <small class="text-muted" style="font-size: 11px;">Batas minimal laba toko.</small>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- View Nav Footer Matching Pesanan Penjualan -->
                     <div class="message" style="margin: 15px 25px 0 25px;"></div>
                     <div class="view-nav">
                        <button type="button" class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype="stay" title="<?= cclang('save_button'); ?> (Ctrl+s)">
                           <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                        </button>
                        <button type="button" class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save_back" data-stype="back" title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                           <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
                        </button>
                        <a class="btn btn-flat btn-default btn_action" id="btn_cancel" href="<?= site_url('administrator/order_prizes/tab/prizes'); ?>" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                           <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
                        </a>
                        <span class="loading loading-hide" style="display:none;">
                           <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                           <i><?= cclang('loading_saving_data'); ?></i>
                        </span>
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

<script>
<?php $ci =& get_instance(); ?>
var CSRF_NAME = '<?= $ci->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $ci->security->get_csrf_hash(); ?>';
var PRIZE_ID = <?= (int)$prize['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

$(document).ready(function() {
   // Unlimited stock toggle
   $('#prize-unlimited').on('change', function() {
      if ($(this).is(':checked')) {
         $('#prize-stock').val('').prop('disabled', true);
      } else {
         $('#prize-stock').prop('disabled', false).focus();
      }
   });

   // 1-Click Fallback Preset Button
   $('#btn-preset-fallback').on('click', function() {
      $('#prize-name').val('Belum Beruntung');
      $('#prize-kind').val('none');
      $('#prize-weight').val('50');
      $('#prize-desc').val('Jangan berkecil hati! Masih banyak promo dan penawaran menarik lainnya di toko kami.');
      $('#prize-unlimited').prop('checked', true);
      $('#prize-stock').val('').prop('disabled', true);
      $('#prize-cost').val('0');
      $('#prize-thresh-spins').val('');
      $('#prize-thresh-revenue').val('');
      $('#prize-thresh-profit').val('');

      swal('Preset Diterapkan', 'Formulir hadiah Fallback (Zonk) telah diisi otomatis. Silakan klik Simpan.', 'info');
   });

   // Auto adjust when kind changed to none
   $('#prize-kind').on('change', function() {
      if ($(this).val() === 'none') {
         $('#prize-cost').val('0');
         $('#prize-unlimited').prop('checked', true);
         $('#prize-stock').val('').prop('disabled', true);
      }
   });

   // Format ribuan rupiah
   $(document).on('input', '.input-nominal', function() {
      var val = $(this).val().replace(/[^\d]/g, '');
      if (val) {
         $(this).val(parseInt(val, 10).toLocaleString('id-ID'));
      } else {
         $(this).val('');
      }
   });

   $('#btn-toggle-campaigns').on('click', function() {
      var cbs = $('.campaign-item-checkbox');
      var allChecked = cbs.length === cbs.filter(':checked').length;
      cbs.prop('checked', !allChecked);
   });

   // Cancel button with confirmation
   $('#btn_cancel').click(function(e) {
      e.preventDefault();
      swal({
         title: "<?= cclang('are_you_sure'); ?>",
         text: "Perubahan yang belum disimpan akan dibatalkan.",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Ya, Batalkan",
         cancelButtonText: "Tetap di Sini",
         closeOnConfirm: true
      }, function(isConfirm) {
         if (isConfirm) {
            window.location.href = BASE_ADMIN + '/tab/prizes';
         }
      });
      return false;
   });

   // Save action (both Ctrl+s stay and Ctrl+d back)
   $('.btn_save').click(function(e) {
      e.preventDefault();
      $('.message').fadeOut();

      var form = $('#form-prize');
      if (!form[0].checkValidity()) {
         form[0].reportValidity();
         return false;
      }

      var save_type = $(this).attr('data-stype');
      var formData = new FormData(form[0]);
      formData.set(CSRF_NAME, CSRF_HASH);

      // Clean nominal input to pure integer
      formData.set('cost', ($('#prize-cost').val() || '').replace(/\D/g, '') || '0');
      var threshRev = $('#prize-thresh-revenue').val();
      formData.set('threshold_revenue', threshRev ? threshRev.replace(/\D/g, '') : '0');
      var threshProf = $('#prize-thresh-profit').val();
      formData.set('threshold_profit', threshProf ? threshProf.replace(/\D/g, '') : '0');

      if ($('#prize-unlimited').is(':checked')) {
         formData.set('stock', '');
      }

      $('.loading').show();
      $('.btn_save').prop('disabled', true);

      $.ajax({
         url: BASE_ADMIN + '/save/prizes/' + PRIZE_ID,
         type: 'POST',
         data: formData,
         processData: false,
         contentType: false,
         dataType: 'json',
         success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
               swal({
                  title: "Berhasil!",
                  text: PRIZE_ID > 0 ? "Data hadiah berhasil diperbarui." : "Hadiah baru berhasil ditambahkan.",
                  type: "success",
                  timer: 1500,
                  showConfirmButton: false
               });

               if (save_type === 'back') {
                  setTimeout(function() {
                     window.location.href = BASE_ADMIN + '/tab/prizes';
                  }, 1200);
               } else {
                  if (PRIZE_ID === 0 && res.data && res.data.id) {
                     setTimeout(function() {
                        window.location.href = BASE_ADMIN + '/prize_edit/' + res.data.id;
                     }, 1200);
                  }
               }
            } else {
               swal("Perhatian", res.message || "Gagal menyimpan hadiah.", "warning");
            }
         },
         error: function(xhr) {
            var msg = "Terjadi kesalahan sistem.";
            if (xhr.status === 403) {
               msg = "Sesi atau token keamanan (CSRF) kedaluwarsa. Silakan refresh halaman.";
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
               msg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
               try {
                  var p = JSON.parse(xhr.responseText);
                  if (p && p.message) msg = p.message;
               } catch (_) {}
            }
            swal("Error", msg, "error");
         },
         complete: function() {
            $('.loading').hide();
            $('.btn_save').prop('disabled', false);
         }
      });
   });
});
</script>
