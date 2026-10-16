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

.box-form-modern .help-block {
   margin-top: 6px !important;
   margin-bottom: 0 !important;
   font-size: 12.5px !important;
   color: #64748b !important;
   line-height: 1.5 !important;
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
      Hadiah Pesanan <small><?= $mode === 'edit' ? cclang('update', ['Campaign']) : cclang('new', ['Campaign']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/order_prizes/tab/campaigns'); ?>">Hadiah Pesanan</a></li>
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
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Hadiah Pesanan - Campaign Promosi</h3>
                        <h5 class="widget-user-desc"><?= $mode === 'edit' ? 'Perbarui Aturan & Data Campaign Hadiah' : 'Tambah Campaign Promosi Undian Hadiah Baru'; ?></h5>
                     </div>
                  </div>

                  <form class="form-horizontal" id="form-campaign" method="POST">
                     <input type="hidden" name="id" value="<?= $campaign['id']; ?>">
                     <input type="hidden" name="verification_mode" value="auto">
                     <input type="hidden" name="budget_profit_percent" value="">

                     <!-- Nama Campaign -->
                     <div class="form-group">
                        <label for="campaign-name" class="control-label">Nama Campaign <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="name" id="campaign-name" placeholder="Contoh: Promo Belanja Berhadiah Emas & Smartphone" value="<?= html_escape($campaign['name']); ?>" required maxlength="160">
                           <small class="info help-block">Nama event undian yang ditampilkan kepada pembeli pada landing page spin wheel.</small>
                        </div>
                     </div>

                     <!-- Slug URL -->
                     <div class="form-group">
                        <label for="campaign-slug" class="control-label">Slug URL (Link Undian) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="slug" id="campaign-slug" placeholder="contoh: belanja-berhadiah" value="<?= html_escape($campaign['slug']); ?>" required maxlength="80">
                           <small class="info help-block">
                              Alamat link publik untuk customer: <code><?= site_url('order_prizes?campaign='); ?><span id="slug-preview" style="font-weight: 700; color: #0284c7;"><?= $campaign['slug'] ?: '...'; ?></span></code>
                           </small>
                        </div>
                     </div>

                     <!-- Channel Marketplace -->
                     <div class="form-group">
                        <label for="campaign-channel" class="control-label">Channel Marketplace <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select class="form-control" name="channel" id="campaign-channel" required>
                              <option value="tiktok" <?= $campaign['channel'] === 'tiktok' ? 'selected' : ''; ?>>TikTok Shop</option>
                              <option value="shopee" <?= $campaign['channel'] === 'shopee' ? 'selected' : ''; ?>>Shopee</option>
                              <option value="tokopedia" <?= $campaign['channel'] === 'tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
                              <option value="lazada" <?= $campaign['channel'] === 'lazada' ? 'selected' : ''; ?>>Lazada</option>
                              <option value="other" <?= $campaign['channel'] === 'other' ? 'selected' : ''; ?>>Website / Offline / Lainnya</option>
                           </select>
                           <small class="info help-block">Pilih kanal penjualan sumber pesanan pembeli.</small>
                        </div>
                     </div>

                     <!-- Referensi Toko -->
                     <div class="form-group">
                        <label for="campaign-shop-ref" class="control-label">Toko Penjual (Shop) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <!-- Dropdown for TikTok shops -->
                           <div id="shop-ref-select-wrapper" style="<?= $campaign['channel'] === 'tiktok' ? '' : 'display: none;'; ?>">
                              <?php if (!empty($tiktok_shops)): ?>
                                 <select class="form-control" name="shop_ref_select" id="shop-ref-select">
                                    <option value="all" <?= $campaign['shop_ref'] === 'all' ? 'selected' : ''; ?>>Semua Toko TikTok Terhubung (<?= count($tiktok_shops); ?> Toko)</option>
                                    <?php foreach ($tiktok_shops as $ts): ?>
                                       <option value="<?= html_escape($ts['shop_name']); ?>" <?= $campaign['shop_ref'] === $ts['shop_name'] ? 'selected' : ''; ?>>
                                          <?= html_escape($ts['shop_name']); ?> (<?= html_escape($ts['shop_code'] ?: $ts['shop_id']); ?>)
                                       </option>
                                    <?php endforeach; ?>
                                 </select>
                              <?php else: ?>
                                 <div class="alert alert-warning" style="margin-bottom: 8px; padding: 10px 14px; font-size: 13px; border-radius: 4px; background-color: #fffbeb; border: 1px solid #fef3c7; color: #92400e;">
                                    <i class="fa fa-info-circle"></i> Belum ada akun toko TikTok yang terhubung pada akun ini. Silakan hubungkan toko terlebih dahulu di menu <a href="<?= site_url('administrator/tiktok_shops'); ?>" target="_blank" style="font-weight: 600; text-decoration: underline; color: #b45309;">Akun Toko</a> atau pilih channel marketplace lain (Shopee, Tokopedia, dll).
                                 </div>
                                 <input type="text" class="form-control" disabled value="Belum ada toko TikTok terhubung" style="background: #f8fafc; color: #94a3b8;">
                              <?php endif; ?>
                           </div>
                           <!-- Text input for Shopee/other -->
                           <div id="shop-ref-text-wrapper" style="<?= $campaign['channel'] !== 'tiktok' ? '' : 'display: none;'; ?>">
                              <input type="text" class="form-control" name="shop_ref_text" id="shop-ref-text" placeholder="Nama toko penjual di marketplace" value="<?= html_escape($campaign['shop_ref'] ?: 'SHOPEE_STORE'); ?>" maxlength="80">
                           </div>
                           <input type="hidden" name="shop_ref" id="campaign-shop-ref" value="<?= html_escape($campaign['shop_ref']); ?>">
                           <small class="info help-block" id="shop-ref-hint">
                              <?= $campaign['channel'] === 'tiktok' ? (!empty($tiktok_shops) ? 'Pilih toko TikTok yang terhubung di sistem Vendio.' : 'Hubungkan akun toko TikTok di menu Akun Toko.') : 'Ketik nama toko di marketplace ' . strtoupper($campaign['channel']) . '.'; ?>
                           </small>
                        </div>
                     </div>

                     <!-- Status Campaign -->
                     <div class="form-group">
                        <label for="campaign-status" class="control-label">Status Campaign <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select class="form-control" name="status" id="campaign-status" required>
                              <option value="active" <?= ($campaign['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active (Menerima Putaran Spin)</option>
                              <option value="draft" <?= ($campaign['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>Draft (Belum Dipublikasikan)</option>
                              <option value="paused" <?= ($campaign['status'] ?? '') === 'paused' ? 'selected' : ''; ?>>Paused (Dijeda Sementara)</option>
                              <option value="ended" <?= ($campaign['status'] ?? '') === 'ended' ? 'selected' : ''; ?>>Ended (Selesai)</option>
                           </select>
                           <small class="info help-block">Status aktif mengizinkan pembeli untuk memutar roda hadiah dan melakukan klaim.</small>
                        </div>
                     </div>

                     <!-- Periode Tanggal -->
                     <div class="form-group">
                        <label class="control-label">Periode Campaign <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <div class="row">
                              <div class="col-sm-6" style="padding-left: 0;">
                                 <label style="font-size: 12px; font-weight: 500; color: #64748b; margin-bottom: 4px;">Tanggal Mulai</label>
                                 <input type="datetime-local" class="form-control" name="starts_at" value="<?= date('Y-m-d\TH:i', strtotime($campaign['starts_at'])); ?>" required>
                              </div>
                              <div class="col-sm-6" style="padding-right: 0;">
                                 <label style="font-size: 12px; font-weight: 500; color: #64748b; margin-bottom: 4px;">Tanggal Berakhir</label>
                                 <input type="datetime-local" class="form-control" name="ends_at" value="<?= date('Y-m-d\TH:i', strtotime($campaign['ends_at'])); ?>" required>
                              </div>
                           </div>
                           <small class="info help-block">Pesanan yang dibuat dalam rentang tanggal ini berhak mengikuti undian.</small>
                        </div>
                     </div>

                     <!-- Batas Hari Spin -->
                     <div class="form-group">
                        <label for="campaign-claim-days" class="control-label">Batas Waktu Spin (Hari) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="number" class="form-control" name="claim_days" id="campaign-claim-days" min="1" max="90" value="<?= $campaign['claim_days'] ?: 7; ?>" required style="max-width: 140px;">
                           <small class="info help-block">Batas maksimal (dalam hari) sejak tanggal pesanan selesai untuk memutar spin. Setelah batas ini, kesempatan spin hangus.</small>
                        </div>
                     </div>

                     <!-- Daftar Hadiah -->
                     <div class="form-group">
                        <label class="control-label">Daftar Hadiah Undian</label>
                        <div class="col-sm-8">
                           <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                              <div style="padding: 10px 15px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                                 <span style="font-size: 12.5px; font-weight: 600; color: #334155;">Pilih Hadiah yang Muncul di Roda Undian</span>
                                 <div>
                                    <button type="button" class="btn btn-xs btn-default" id="btn-toggle-all-prizes">
                                       <i class="fa fa-check-square-o"></i> Pilih Semua
                                    </button>
                                    <a href="<?= site_url('administrator/order_prizes/prize_add'); ?>" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 4px;">
                                       <i class="fa fa-plus"></i> Master Hadiah Baru
                                    </a>
                                 </div>
                              </div>
                              <?php if (empty($all_prizes)): ?>
                                 <div style="padding: 18px; text-align: center; color: #94a3b8; font-size: 12.5px;">
                                    Belum ada master hadiah di sistem. Hadiah fallback "Belum Beruntung" akan otomatis digunakan.
                                 </div>
                              <?php else: ?>
                                 <div class="table-responsive" style="max-height: 240px; overflow-y: auto;">
                                    <table class="table table-hover" style="margin-bottom: 0; font-size: 12.5px;">
                                       <thead>
                                          <tr style="background: #f8fafc; color: #64748b; font-size: 11px; text-transform: uppercase;">
                                             <th width="45" style="text-align: center;">Pilih</th>
                                             <th>Nama Hadiah</th>
                                             <th>Jenis</th>
                                             <th>Bobot Peluang</th>
                                             <th>Sisa Stok</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($all_prizes as $pz): ?>
                                             <?php $checked = in_array((int)$pz['id'], $selected_prize_ids ?? []); ?>
                                             <tr>
                                                <td style="text-align: center;">
                                                   <input type="checkbox" name="prize_ids[]" value="<?= $pz['id']; ?>" class="prize-item-checkbox" <?= $checked ? 'checked' : ''; ?>>
                                                </td>
                                                <td>
                                                   <strong style="color: #1e293b;"><?= html_escape($pz['name']); ?></strong>
                                                   <?php if (!empty($pz['description'])): ?>
                                                      <div style="font-size: 11px; color: #94a3b8;"><?= html_escape($pz['description']); ?></div>
                                                   <?php endif; ?>
                                                </td>
                                                <td>
                                                   <span class="badge" style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 10.5px;">
                                                      <?= html_escape($pz['kind']); ?>
                                                   </span>
                                                </td>
                                                <td>Bobot: <?= number_format($pz['weight']); ?></td>
                                                <td>
                                                   <?= $pz['stock'] === null ? '<span class="text-info"><i class="fa fa-infinity"></i> Unlimited</span>' : ($pz['stock'] <= 0 ? '<span class="text-danger">Habis (0)</span>' : number_format($pz['stock']) . ' pcs'); ?>
                                                </td>
                                             </tr>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                 </div>
                              <?php endif; ?>
                           </div>
                           <small class="info help-block">Hadiah yang dicentang akan otomatis diacak pada roda spin undian sesuai bobot masing-masing.</small>
                        </div>
                     </div>

                     <!-- Syarat & Ketentuan -->
                     <div class="form-group">
                        <label for="campaign-terms" class="control-label">Syarat & Ketentuan <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <div style="display: flex; justify-content: flex-end; margin-bottom: 6px;">
                              <button type="button" class="btn btn-xs btn-default" id="btn-default-terms">
                                 <i class="fa fa-magic"></i> Template S&K Standar
                              </button>
                           </div>
                           <textarea class="form-control" name="terms" id="campaign-terms" rows="5" placeholder="Tuliskan syarat dan ketentuan untuk memutar roda hadiah dan batas waktu klaim..." required><?= html_escape($campaign['terms']); ?></textarea>
                           <small class="info help-block">Ditampilkan kepada pembeli pada halaman spin sebelum melakukan putaran undian.</small>
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
                        <a class="btn btn-flat btn-default btn_action" id="btn_cancel" href="<?= site_url('administrator/order_prizes/tab/campaigns'); ?>" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
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
var CAMPAIGN_ID = <?= (int)$campaign['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

$(document).ready(function() {
   // Dynamic Shop Ref switching between TikTok dropdown and marketplace text
   function syncShopRef() {
      var channel = $('#campaign-channel').val();
      var hasConnectedTikTok = <?= !empty($tiktok_shops) ? 'true' : 'false'; ?>;
      if (channel === 'tiktok') {
         $('#shop-ref-select-wrapper').show();
         $('#shop-ref-text-wrapper').hide();
         if (hasConnectedTikTok) {
            var selectedShop = $('#shop-ref-select').val();
            $('#campaign-shop-ref').val(selectedShop || 'all');
            $('#shop-ref-hint').text('Pilih toko TikTok yang terhubung di sistem Vendio.');
         } else {
            $('#campaign-shop-ref').val('');
            $('#shop-ref-hint').html('<span class="text-danger"><i class="fa fa-warning"></i> Hubungkan toko TikTok terlebih dahulu di menu <a href="<?= site_url("administrator/tiktok_shops"); ?>" target="_blank" style="text-decoration: underline; font-weight: 600;">Akun Toko</a>.</span>');
         }
      } else {
         $('#shop-ref-select-wrapper').hide();
         $('#shop-ref-text-wrapper').show();
         var txt = $('#shop-ref-text').val().trim();
         if (!txt) {
            txt = channel.toUpperCase() + '_STORE';
            $('#shop-ref-text').val(txt);
         }
         $('#campaign-shop-ref').val(txt);
         $('#shop-ref-hint').text('Ketik nama toko di marketplace ' + channel.toUpperCase() + '.');
      }
   }

   $('#campaign-channel').on('change', syncShopRef);
   $('#shop-ref-select').on('change', function() {
      $('#campaign-shop-ref').val($(this).val());
   });
   $('#shop-ref-text').on('input', function() {
      $('#campaign-shop-ref').val($(this).val());
   });
   syncShopRef();

   // Auto slug generator
   $('#campaign-name').on('input', function() {
      <?php if ($mode === 'add'): ?>
      var val = $(this).val().toLowerCase()
         .replace(/[^\w\s-]/g, '')
         .trim()
         .replace(/[\s_-]+/g, '-');
      $('#campaign-slug').val(val);
      $('#slug-preview').text(val || '...');
      <?php endif; ?>
   });

   $('#campaign-slug').on('input', function() {
      var val = $(this).val().toLowerCase().replace(/[^\w-]/g, '');
      $(this).val(val);
      $('#slug-preview').text(val || '...');
   });

   $('#btn-toggle-all-prizes').on('click', function() {
      var checkboxes = $('.prize-item-checkbox');
      var allChecked = checkboxes.length === checkboxes.filter(':checked').length;
      checkboxes.prop('checked', !allChecked);
   });

   $('#btn-default-terms').on('click', function() {
      var defaultTerms = "1. Berlaku untuk nomor pesanan terverifikasi yang berstatus Completed/Paid.\n" +
         "2. Setiap pesanan berhak memutar roda undian sebanyak 1 (satu) kali.\n" +
         "3. Kesempatan spin berlaku sesuai batas waktu (hari) sejak pesanan selesai.\n" +
         "4. Hadiah yang didapat saat spin otomatis tercatat & langsung diklaim untuk diproses toko.\n" +
         "5. Pihak penyelenggara berhak membatalkan hadiah jika ditemukan indikasi kecurangan atau manipulasi pesanan.";
      $('#campaign-terms').val(defaultTerms);
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
            window.location.href = BASE_ADMIN + '/tab/campaigns';
         }
      });
      return false;
   });

   // Save action (both Ctrl+s stay and Ctrl+d back)
   $('.btn_save').click(function(e) {
      e.preventDefault();
      $('.message').fadeOut();

      var form = $('#form-campaign');
      if (!form[0].checkValidity()) {
         form[0].reportValidity();
         return false;
      }

      var channel = $('#campaign-channel').val();
      var hasConnectedTikTok = <?= !empty($tiktok_shops) ? 'true' : 'false'; ?>;
      if (channel === 'tiktok' && !hasConnectedTikTok) {
         toastr['error']('Belum ada akun toko TikTok yang terhubung. Silakan hubungkan akun toko terlebih dahulu di menu Akun Toko atau pilih channel lain.');
         return false;
      }

      var save_type = $(this).attr('data-stype');
      var formData = new FormData(form[0]);
      formData.set(CSRF_NAME, CSRF_HASH);

      $('.loading').show();
      $('.btn_save').prop('disabled', true);

      $.ajax({
         url: BASE_ADMIN + '/save/campaigns/' + CAMPAIGN_ID,
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
                  text: CAMPAIGN_ID > 0 ? "Data campaign berhasil diperbarui." : "Campaign baru berhasil ditambahkan.",
                  type: "success",
                  timer: 1500,
                  showConfirmButton: false
               });

               if (save_type === 'back') {
                  setTimeout(function() {
                     window.location.href = BASE_ADMIN + '/tab/campaigns';
                  }, 1200);
               } else {
                  if (CAMPAIGN_ID === 0 && res.data && res.data.id) {
                     setTimeout(function() {
                        window.location.href = BASE_ADMIN + '/campaign_edit/' + res.data.id;
                     }, 1200);
                  }
               }
            } else {
               swal("Perhatian", res.message || "Gagal menyimpan campaign.", "warning");
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
