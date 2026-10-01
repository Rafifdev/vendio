
<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo(){
     
       // Binding keys
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

/* Chosen Select Adjustment */
.box-form-modern .chosen-container-single .chosen-single {
   height: 38px !important;
   line-height: 36px !important;
   border-radius: 6px !important;
   border: 1px solid #d1d5db !important;
   background: #ffffff !important;
   box-shadow: none !important;
   font-size: 13.5px !important;
   padding: 0 12px !important;
   color: #1e293b !important;
}

.box-form-modern .chosen-container-single .chosen-single div b {
   background-position: 0 9px !important;
}

.box-form-modern .help-block {
   margin-top: 6px !important;
   margin-bottom: 0 !important;
   font-size: 12.5px !important;
   color: #64748b !important;
   line-height: 1.5 !important;
}

.box-form-modern .help-block a {
   color: #0284c7 !important;
   text-decoration: none;
}

.box-form-modern .help-block a:hover {
   text-decoration: underline;
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
        Pesanan Penjualan        <small><?= cclang('new', ['Pesanan Penjualan']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_orders'); ?>">Pesanan Penjualan</a></li>
        <li class="active"><?= cclang('new'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-form-modern">
                <div class="box-body" style="padding: 0;">
                    <!-- Widget: user widget style 1 -->
                    <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header">
                            <div class="widget-user-image">
                                <img src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <div class="header-titles">
                                <h3 class="widget-user-username">Pesanan Penjualan</h3>
                                <h5 class="widget-user-desc"><?= cclang('new', ['Pesanan Penjualan']); ?></h5>
                            </div>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_tiktok_orders', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_orders', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="tiktok_shop_id" class="control-label">Toko TikTok 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="tiktok_shop_id" id="tiktok_shop_id" data-placeholder="Pilih Toko TikTok" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('tiktok_shops') as $row): ?>
                                    <option value="<?= $row->id; ?>" <?= set_value('tiktok_shop_id') == $row->id ? 'selected' : ''; ?>><?= _ent($row->shop_name); ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">Toko penerima pesanan.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="order_id" class="control-label">ID Pesanan (Order ID) 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Nomor ID Pesanan TikTok" value="<?= set_value('order_id'); ?>">
                                <small class="info help-block">Nomor referensi pesanan unik dari TikTok Shop.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="order_status" class="control-label">Status Pesanan 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select" name="order_status" id="order_status" data-placeholder="Pilih Status Pesanan">
                                    <option value="UNPAID" <?= set_value('order_status') == 'UNPAID' ? 'selected' : ''; ?>>Belum Dibayar (UNPAID)</option>
                                    <option value="ON_HOLD" <?= set_value('order_status') == 'ON_HOLD' ? 'selected' : ''; ?>>Dalam proses (ON_HOLD)</option>
                                    <option value="AWAITING_SHIPMENT" <?= set_value('order_status') == 'AWAITING_SHIPMENT' || !set_value('order_status') ? 'selected' : ''; ?>>Menunggu Pengiriman (AWAITING_SHIPMENT)</option>
                                    <option value="AWAITING_COLLECTION" <?= set_value('order_status') == 'AWAITING_COLLECTION' ? 'selected' : ''; ?>>Menunggu Pengambilan (AWAITING_COLLECTION)</option>
                                    <option value="IN_TRANSIT" <?= set_value('order_status') == 'IN_TRANSIT' ? 'selected' : ''; ?>>Sedang transit (IN_TRANSIT)</option>
                                    <option value="DELIVERED" <?= set_value('order_status') == 'DELIVERED' ? 'selected' : ''; ?>>Terkirim (DELIVERED)</option>
                                    <option value="COMPLETED" <?= set_value('order_status') == 'COMPLETED' ? 'selected' : ''; ?>>Selesai (COMPLETED)</option>
                                    <option value="CANCELLED" <?= set_value('order_status') == 'CANCELLED' ? 'selected' : ''; ?>>Dibatalkan (CANCELLED)</option>
                                    <option value="DELIVERY_FAILED" <?= set_value('order_status') == 'DELIVERY_FAILED' ? 'selected' : ''; ?>>Pengiriman Gagal (DELIVERY_FAILED)</option>
                                </select>
                                <small class="info help-block">Status terkini transaksi pesanan.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_name" class="control-label">Nama Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" placeholder="Nama lengkap pembeli / penerima" value="<?= set_value('recipient_name'); ?>">
                                <small class="info help-block">Nama penerima paket pesanan.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_phone" class="control-label">Nomor Telepon Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_phone" id="recipient_phone" placeholder="Nomor handphone aktif penerima" value="<?= set_value('recipient_phone'); ?>">
                                <small class="info help-block">Nomor kontak untuk kurir pengiriman.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_address" class="control-label">Alamat Lengkap Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="recipient_address" name="recipient_address" rows="4" class="form-control" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"><?= set_value('recipient_address'); ?></textarea>
                                <small class="info help-block">Alamat tujuan pengantaran paket.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="shipping_provider" class="control-label">Kurir Logistik 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider" id="shipping_provider" placeholder="Contoh: J&T Express, Ninja Van, SiCepat" value="<?= set_value('shipping_provider'); ?>">
                                <small class="info help-block">Ekspedisi yang digunakan untuk pengiriman.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="tracking_number" class="control-label">Nomor Resi (AWB) 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Nomor resi kurir pengiriman" value="<?= set_value('tracking_number'); ?>">
                                <small class="info help-block">Nomor lacak pengiriman dari ekspedisi.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="total_amount" class="control-label">Total Pembayaran 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="font-weight: 600; background: #f8fafc; color: #475569;">Rp</span>
                                    <input type="number" step="any" class="form-control" name="total_amount" id="total_amount" placeholder="0" value="<?= set_value('total_amount'); ?>">
                                </div>
                                <small class="info help-block">Total nominal yang dibayarkan oleh pembeli.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="shipping_type" class="control-label">Tipe Layanan Pengiriman 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_type" id="shipping_type" placeholder="Contoh: Standard, Express, Economy" value="<?= set_value('shipping_type'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="delivery_option_name" class="control-label">Opsi Pengiriman 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_name" id="delivery_option_name" placeholder="Opsi Pengiriman" value="<?= set_value('delivery_option_name'); ?>">
                            </div>
                        </div>
                                                
                        <div class="message" style="margin: 15px 25px 0 25px;"></div>
                        <div class="view-nav">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save_back" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline" ></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo" ></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                            <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
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
    $(document).ready(function(){
                   
      $('#btn_cancel').click(function(){
        swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = BASE_URL + 'administrator/tiktok_orders';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_tiktok_orders = $('#form_tiktok_orders');
        var data_post = form_tiktok_orders.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/tiktok_orders/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
       
 
       
    
    
    }); /*end doc ready*/
</script>