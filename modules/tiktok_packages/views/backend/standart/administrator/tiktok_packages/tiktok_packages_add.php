
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
        Pengiriman Paket        <small><?= cclang('new', ['Pengiriman Paket']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_packages'); ?>">Pengiriman Paket</a></li>
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
                                <h3 class="widget-user-username">Pengiriman Paket</h3>
                                <h5 class="widget-user-desc"><?= cclang('new', ['Pengiriman Paket']); ?></h5>
                            </div>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_tiktok_packages', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_packages', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <!-- Section 1: Informasi Pesanan -->
                        <div class="box-header with-border" style="padding: 12px 25px; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #334155;">
                                <i class="fa fa-shopping-cart text-primary" style="margin-right: 8px;"></i> 1. Pilih Pesanan yang Akan Dikirim
                            </h4>
                        </div>

                        <div class="form-group ">
                            <label for="tiktok_shop_id" class="control-label">Toko TikTok 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="tiktok_shop_id" id="tiktok_shop_id" data-placeholder="Pilih Toko TikTok">
                                    <option value=""></option>
                                    <?php 
                                    $sel_shop = set_value('tiktok_shop_id', isset($selected_order) ? $selected_order->tiktok_shop_id : '');
                                    foreach (db_get_all_data('tiktok_shops') as $row): 
                                    ?>
                                    <option <?= ($sel_shop == $row->id || (!empty($selected_order) && $selected_order->tiktok_shop_id == $row->id)) ? 'selected' : ''; ?> value="<?= $row->id; ?>"><?= _ent($row->shop_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">Pilih toko TikTok yang memproses pesanan ini.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="order_id" class="control-label">Nomor ID Pesanan 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <?php if (!empty($awaiting_orders)): ?>
                                <select class="form-control chosen chosen-select-deselect" name="order_id_select" id="order_id_select" data-placeholder="-- Pilih Pesanan Siap Kirim (Awaiting Shipment) --">
                                    <option value=""></option>
                                    <?php 
                                    $curr_ord_id = set_value('order_id', isset($selected_order) ? $selected_order->order_id : '');
                                    foreach ($awaiting_orders as $ord): 
                                        $is_ord_sel = ($curr_ord_id == $ord->order_id);
                                    ?>
                                    <option value="<?= $ord->order_id; ?>" 
                                            data-shop="<?= $ord->tiktok_shop_id; ?>"
                                            data-recipient="<?= _ent($ord->recipient_name); ?>"
                                            data-phone="<?= _ent($ord->recipient_phone); ?>"
                                            data-address="<?= _ent($ord->recipient_address); ?>"
                                            data-courier="<?= _ent($ord->shipping_provider); ?>"
                                            data-tracking="<?= _ent($ord->tracking_number); ?>"
                                            <?= $is_ord_sel ? 'selected' : ''; ?>>
                                        Pesanan #<?= $ord->order_id; ?> &mdash; <?= _ent($ord->recipient_name); ?> (Rp <?= number_format($ord->total_amount, 0, ',', '.'); ?>)
                                    </option>
                                    <?php endforeach; ?>
                                    <option value="CUSTOM">-- Ketik Nomor Pesanan Lainnya --</option>
                                </select>
                                <div id="custom_order_wrap" style="margin-top: 8px; <?= (!empty($curr_ord_id) && !isset($selected_order)) ? '' : 'display: none;'; ?>">
                                    <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Masukkan ID Pesanan TikTok (contoh: 578912345678901234)" value="<?= $curr_ord_id; ?>">
                                </div>
                                <?php else: ?>
                                <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Contoh: 578912345678901234" value="<?= set_value('order_id', isset($selected_order) ? $selected_order->order_id : ''); ?>">
                                <small class="text-muted" style="display:block; margin-top: 4px;">Tidak ada pesanan berstatus Perlu Dikirim (Awaiting Shipment) saat ini. Anda dapat mengetikkan nomor ID pesanan secara manual.</small>
                                <?php endif; ?>
                                <small class="info help-block">Nomor pesanan TikTok Shop yang terkait dengan paket pengiriman ini.</small>
                            </div>
                        </div>

                        <!-- Section 2: Jasa Kirim & Penyerahan -->
                        <div class="box-header with-border" style="padding: 12px 25px; background: #f8fafc; border-bottom: 1px solid #edf2f7; margin-top: 10px;">
                            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #334155;">
                                <i class="fa fa-truck text-primary" style="margin-right: 8px;"></i> 2. Kurir & Metode Penyerahan Paket
                            </h4>
                        </div>

                        <div class="form-group ">
                            <label for="shipping_provider_name" class="control-label">Kurir / Ekspedisi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <?php 
                                $curr_courier = set_value('shipping_provider_name', isset($selected_order) ? $selected_order->shipping_provider : 'J&T Express');
                                ?>
                                <select class="form-control chosen chosen-select" name="shipping_provider_name" id="shipping_provider_name" data-placeholder="Pilih Jasa Ekspedisi">
                                    <option value="J&T Express" <?= $curr_courier == 'J&T Express' ? 'selected' : ''; ?>>J&T Express</option>
                                    <option value="JNE Express" <?= $curr_courier == 'JNE Express' ? 'selected' : ''; ?>>JNE Express</option>
                                    <option value="SiCepat Ekspres" <?= $curr_courier == 'SiCepat Ekspres' ? 'selected' : ''; ?>>SiCepat Ekspres</option>
                                    <option value="Ninja Van" <?= $curr_courier == 'Ninja Van' ? 'selected' : ''; ?>>Ninja Van</option>
                                    <option value="Shopee Xpress / SPX" <?= $curr_courier == 'Shopee Xpress / SPX' ? 'selected' : ''; ?>>Shopee Xpress (SPX)</option>
                                    <option value="Anteraja" <?= $curr_courier == 'Anteraja' ? 'selected' : ''; ?>>Anteraja</option>
                                    <option value="Pos Indonesia" <?= $curr_courier == 'Pos Indonesia' ? 'selected' : ''; ?>>Pos Indonesia</option>
                                    <option value="Lainnya" <?= $curr_courier == 'Lainnya' ? 'selected' : ''; ?>>Lainnya / Kurir Toko</option>
                                </select>
                                <small class="info help-block">Jasa ekspedisi yang ditugaskan membawa paket.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="handover_method" class="control-label">Metode Penyerahan 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <?php $curr_handover = set_value('handover_method', 'DROP_OFF'); ?>
                                <div style="display: flex; gap: 15px; margin-top: 6px;">
                                    <label style="font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="handover_method" value="DROP_OFF" <?= $curr_handover == 'DROP_OFF' ? 'checked' : ''; ?>>
                                        <span><strong>Drop-off</strong> (Antar Sendiri ke Gerai / Counter Kurir)</span>
                                    </label>
                                    <label style="font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                        <input type="radio" name="handover_method" value="PICKUP" <?= $curr_handover == 'PICKUP' ? 'checked' : ''; ?>>
                                        <span><strong>Pick-up</strong> (Kurir Menjemput Paket ke Lokasi Toko)</span>
                                    </label>
                                </div>
                                <small class="info help-block">Pilih cara penyerahan paket fisik ke pihak kurir.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="tracking_number" class="control-label">Nomor Resi / AWB 
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background:#f8fafc; font-weight:600; color:#475569;"><i class="fa fa-barcode"></i></span>
                                    <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Nomor Resi (Otomatis dibuat jika kosong)" value="<?= set_value('tracking_number', isset($selected_order) ? $selected_order->tracking_number : ''); ?>">
                                </div>
                                <small class="info help-block">Nomor resi dari kurir. Jika dikosongkan, sistem akan membuatkan nomor AWB otomatis.</small>
                            </div>
                        </div>

                        <!-- Section 3: Detail Fisik Paket -->
                        <div class="box-header with-border" style="padding: 12px 25px; background: #f8fafc; border-bottom: 1px solid #edf2f7; margin-top: 10px;">
                            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #334155;">
                                <i class="fa fa-cube text-primary" style="margin-right: 8px;"></i> 3. Berat & Dimensi Paket
                            </h4>
                        </div>

                        <div class="form-group ">
                            <label for="weight_val" class="control-label">Berat Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group" style="max-width: 250px;">
                                    <input type="number" step="1" class="form-control" name="weight_val" id="weight_val" placeholder="1000" value="<?= set_value('weight_val', '1000'); ?>">
                                    <span class="input-group-addon" style="background:#f8fafc; font-weight:600; color:#475569;">Gram</span>
                                </div>
                                <small class="info help-block">Berat total paket beserta kemasan (1000 gram = 1 kg).</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label">Dimensi Paket (P x L x T) 
                            </label>
                            <div class="col-sm-8">
                                <div style="display: flex; align-items: center; gap: 8px; max-width: 360px;">
                                    <input type="number" step="1" class="form-control" name="dimension_length" id="dimension_length" placeholder="Panjang" value="<?= set_value('dimension_length', '10'); ?>" title="Panjang (cm)">
                                    <span>&times;</span>
                                    <input type="number" step="1" class="form-control" name="dimension_width" id="dimension_width" placeholder="Lebar" value="<?= set_value('dimension_width', '10'); ?>" title="Lebar (cm)">
                                    <span>&times;</span>
                                    <input type="number" step="1" class="form-control" name="dimension_height" id="dimension_height" placeholder="Tinggi" value="<?= set_value('dimension_height', '10'); ?>" title="Tinggi (cm)">
                                    <span style="font-weight: 600; color: #64748b; font-size: 13px;">cm</span>
                                </div>
                                <small class="info help-block">Ukuran fisik kemasan paket dalam centimeter (cm).</small>
                            </div>
                        </div>

                        <!-- Section 4: Data Penerima -->
                        <div class="box-header with-border" style="padding: 12px 25px; background: #f8fafc; border-bottom: 1px solid #edf2f7; margin-top: 10px;">
                            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #334155;">
                                <i class="fa fa-map-marker text-primary" style="margin-right: 8px;"></i> 4. Alamat Tujuan & Data Penerima
                            </h4>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_name" class="control-label">Nama Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" placeholder="Nama Lengkap Penerima" value="<?= set_value('recipient_name', isset($selected_order) ? $selected_order->recipient_name : ''); ?>">
                                <small class="info help-block">Nama pembeli / penerima barang.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_phone" class="control-label">Nomor Telepon Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_phone" id="recipient_phone" placeholder="Contoh: 08123456789" value="<?= set_value('recipient_phone', isset($selected_order) ? $selected_order->recipient_phone : ''); ?>">
                                <small class="info help-block">Nomor kontak aktif penerima paket untuk kurir.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="recipient_address" class="control-label">Alamat Lengkap Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="recipient_address" name="recipient_address" rows="3" class="textarea form-control" placeholder="Alamat jalan, kelurahan, kecamatan, kota, provinsi, kode pos"><?= set_value('recipient_address', isset($selected_order) ? $selected_order->recipient_address : ''); ?></textarea>
                                <small class="info help-block">Alamat lengkap tujuan pengiriman paket.</small>
                            </div>
                        </div>

                        <!-- Parameter Teknis API Tersembunyi (Otomatis) -->
                        <input type="hidden" name="package_id" id="package_id" value="<?= set_value('package_id', 'PKG-' . time()); ?>">
                        <input type="hidden" name="package_status" value="READY_FOR_SHIPMENT">
                        <input type="hidden" name="shipping_type" value="TIKTOK">
                        <input type="hidden" name="dimension_unit" value="CM">
                        <input type="hidden" name="weight_unit" value="GRAM">
                                                
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
      // Handler saat pesanan dipilih dari dropdown
      $('#order_id_select').change(function(){
        var val = $(this).val();
        if (val === 'CUSTOM') {
          $('#custom_order_wrap').slideDown(150);
          $('#order_id').val('').focus();
        } else if (val) {
          $('#custom_order_wrap').slideUp(150);
          $('#order_id').val(val);
          var opt = $(this).find('option:selected');
          var shop = opt.data('shop');
          var recipient = opt.data('recipient');
          var phone = opt.data('phone');
          var address = opt.data('address');
          var courier = opt.data('courier');
          var tracking = opt.data('tracking');

          if (shop) {
            $('#tiktok_shop_id').val(shop).trigger('chosen:updated');
          }
          if (recipient) $('#recipient_name').val(recipient);
          if (phone) $('#recipient_phone').val(phone);
          if (address) $('#recipient_address').val(address);
          if (courier) {
            $('#shipping_provider_name').val(courier).trigger('chosen:updated');
          }
          if (tracking) $('#tracking_number').val(tracking);
        }
      });
                   
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
              window.location.href = BASE_URL + 'administrator/tiktok_packages';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_tiktok_packages = $('#form_tiktok_packages');
        var data_post = form_tiktok_packages.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/tiktok_packages/add_save',
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