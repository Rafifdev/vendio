<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
function domo(){
   // Binding keys matching Pesanan Penjualan
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
}

.box-form-modern .form-control:focus {
   border-color: #3b82f6 !important;
   box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
}

.box-form-modern .input-group-addon {
   background: #f8fafc !important;
   border: 1px solid #d1d5db !important;
   border-right: none !important;
   color: #64748b !important;
   font-weight: 600 !important;
   font-size: 13px !important;
   border-radius: 6px 0 0 6px !important;
}

.box-form-modern .input-group .form-control {
   border-radius: 0 6px 6px 0 !important;
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
      Hadiah Pesanan <small><?= $mode === 'edit' ? cclang('update', ['Order']) : cclang('new', ['Order']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= site_url('administrator/order_prizes/tab/orders'); ?>">Hadiah Pesanan</a></li>
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
                        <img src="<?= BASE_ASSET; ?>/img/<?= $mode === 'edit' ? 'add2.png' : 'add2.png'; ?>" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Hadiah Pesanan - Order Terverifikasi</h3>
                        <h5 class="widget-user-desc"><?= $mode === 'edit' ? 'Perbarui Data Pesanan Terverifikasi' : 'Tambah Data Pesanan Terverifikasi Baru'; ?></h5>
                     </div>
                  </div>

                  <form class="form-horizontal" id="form-order" method="POST">
                     <input type="hidden" name="id" value="<?= $order['id']; ?>">

                     <!-- Target Campaign -->
                     <div class="form-group">
                        <label for="order-campaign-id" class="control-label">Target Campaign <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select name="campaign_id" id="order-campaign-id" class="form-control" required <?= $mode === 'edit' ? 'disabled' : ''; ?>>
                              <?php foreach ($campaigns_dropdown as $c): ?>
                                 <option value="<?= $c['id']; ?>" <?= $order['campaign_id'] == $c['id'] ? 'selected' : ''; ?>>
                                    #<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?> - <?= html_escape($c['shop_ref']); ?>)
                                 </option>
                              <?php endforeach; ?>
                           </select>
                           <?php if ($mode === 'edit'): ?>
                              <input type="hidden" name="campaign_id" value="<?= $order['campaign_id']; ?>">
                           <?php endif; ?>
                           <small class="info help-block">Campaign undian hadiah yang akan diikuti oleh nomor pesanan ini.</small>
                        </div>
                     </div>

                     <!-- ID Pesanan -->
                     <div class="form-group">
                        <label for="order-number" class="control-label">ID Pesanan (Order ID) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="order_number" id="order-number" placeholder="Contoh: 261014ABC123" value="<?= html_escape($order['order_number']); ?>" required maxlength="80">
                           <small class="info help-block">Nomor referensi pesanan dari marketplace (TikTok Shop / Shopee). Otomatis huruf kapital.</small>
                        </div>
                     </div>

                     <!-- Nomor HP Pembeli -->
                     <div class="form-group">
                        <label for="order-phone" class="control-label">Nomor Telepon Pembeli <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" name="phone" id="order-phone" placeholder="Contoh: 08123456789 atau 628123456789" value="<?= html_escape($order['phone']); ?>" required maxlength="25">
                           <small class="info help-block">
                              Format otomatis dinormalisasi ke: <strong id="phone-preview" style="color: #059669;"><?= $order['phone'] ?: '628...'; ?></strong> (digunakan pembeli untuk validasi saat spin).
                           </small>
                        </div>
                     </div>

                     <!-- Status Pesanan -->
                     <div class="form-group">
                        <label for="order-status" class="control-label">Status Pesanan <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <select class="form-control" name="status" id="order-status" required>
                              <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Selesai (Completed)</option>
                              <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : ''; ?>>Dibayar (Paid)</option>
                              <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Dibatalkan (Cancelled)</option>
                              <option value="refunded" <?= $order['status'] === 'refunded' ? 'selected' : ''; ?>>Pengembalian Dana (Refunded)</option>
                           </select>
                           <small class="info help-block">Hanya status <strong>Selesai (Completed)</strong> atau <strong>Dibayar (Paid)</strong> yang diizinkan memutar roda hadiah.</small>
                        </div>
                     </div>

                     <!-- Nilai Omset (Revenue) -->
                     <div class="form-group">
                        <label for="order-revenue" class="control-label">Nilai Belanja (Omset) <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <div class="input-group">
                              <span class="input-group-addon">Rp</span>
                              <input type="text" inputmode="numeric" class="form-control input-nominal" name="revenue" id="order-revenue" placeholder="Contoh: 150.000" value="<?= !empty($order['revenue']) ? number_format((int)$order['revenue'], 0, ',', '.') : ''; ?>" required>
                           </div>
                           <small class="info help-block">Total pembayaran pesanan pembeli dalam rupiah.</small>
                        </div>
                     </div>

                     <!-- Estimasi Profit Bersih -->
                     <div class="form-group">
                        <label for="order-profit" class="control-label">Estimasi Profit Bersih</label>
                        <div class="col-sm-8">
                           <div class="input-group">
                              <span class="input-group-addon">Rp</span>
                              <input type="text" inputmode="numeric" class="form-control input-nominal" name="profit" id="order-profit" placeholder="Contoh: 25.000 (Kosongkan jika belum dihitung)" value="<?= !empty($order['profit']) ? number_format((int)$order['profit'], 0, ',', '.') : ''; ?>">
                           </div>
                           <small class="info help-block">Opsional. Digunakan jika campaign memiliki threshold hadiah minimum profit toko.</small>
                        </div>
                     </div>

                     <!-- Waktu Pemesanan -->
                     <div class="form-group">
                        <label for="order-ordered-at" class="control-label">Waktu Pemesanan <i class="required">*</i></label>
                        <div class="col-sm-8">
                           <input type="datetime-local" class="form-control" name="ordered_at" id="order-ordered-at" value="<?= date('Y-m-d\TH:i', strtotime($order['ordered_at'])); ?>" required>
                           <small class="info help-block">Waktu transaksi terjadi. Harus berada dalam periode aktif campaign.</small>
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
                        <a class="btn btn-flat btn-default btn_action" id="btn_cancel" href="<?= site_url('administrator/order_prizes/tab/orders'); ?>" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
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
var ORDER_ID = <?= (int)$order['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

$(document).ready(function() {
   // Auto uppercase order number
   $('#order-number').on('input', function() {
      $(this).val($(this).val().toUpperCase().replace(/[^\w-]/g, ''));
   });

   // Phone normalizer preview
   $('#order-phone').on('input', function() {
      var raw = $(this).val().replace(/[^\d+]/g, '');
      if (raw.startsWith('+62')) raw = '62' + raw.substring(3);
      else if (raw.startsWith('0')) raw = '62' + raw.substring(1);
      else if (raw && !raw.startsWith('62')) raw = '62' + raw;
      $('#phone-preview').text(raw || '628...');
   });

   // Format ribuan rupiah
   $('.input-nominal').on('input', function() {
      var val = $(this).val().replace(/[^\d]/g, '');
      if (val) {
         $(this).val(parseInt(val, 10).toLocaleString('id-ID'));
      } else {
         $(this).val('');
      }
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
            window.location.href = BASE_ADMIN + '/tab/orders';
         }
      });
      return false;
   });

   // Save action (both Ctrl+s stay and Ctrl+d back)
   $('.btn_save').click(function(e) {
      e.preventDefault();
      $('.message').fadeOut();

      var form = $('#form-order');
      if (!form[0].checkValidity()) {
         form[0].reportValidity();
         return false;
      }

      var save_type = $(this).attr('data-stype');
      var postData = {
         id: ORDER_ID,
         campaign_id: $('[name="campaign_id"]').val(),
         order_number: $('#order-number').val(),
         phone: $('#order-phone').val(),
         status: $('#order-status').val(),
         revenue: $('#order-revenue').val().replace(/\./g, ''),
         profit: $('#order-profit').val().replace(/\./g, ''),
         ordered_at: $('#order-ordered-at').val().replace('T', ' ') + ':00'
      };
      postData[CSRF_NAME] = CSRF_HASH;

      $('.loading').show();
      $('.btn_save').prop('disabled', true);

      $.ajax({
         url: BASE_ADMIN + '/save/orders/' + ORDER_ID,
         type: 'POST',
         data: postData,
         dataType: 'json',
         success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
               swal({
                  title: "Berhasil!",
                  text: ORDER_ID > 0 ? "Data order berhasil diperbarui." : "Data order baru berhasil ditambahkan.",
                  type: "success",
                  timer: 1500,
                  showConfirmButton: false
               });

               if (save_type === 'back') {
                  setTimeout(function() {
                     window.location.href = BASE_ADMIN + '/tab/orders';
                  }, 1200);
               } else {
                  if (ORDER_ID === 0 && res.data && res.data.id) {
                     setTimeout(function() {
                        window.location.href = BASE_ADMIN + '/order_edit/' + res.data.id;
                     }, 1200);
                  }
               }
            } else {
               swal("Perhatian", res.message || "Gagal menyimpan data.", "warning");
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
