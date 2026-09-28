
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
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pengiriman Paket        <small>Edit Pengiriman Paket</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_packages'); ?>">Pengiriman Paket</a></li>
        <li class="active">Edit</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">Pengiriman Paket</h3>
                            <h5 class="widget-user-desc">Edit Pengiriman Paket</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/tiktok_packages/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_tiktok_packages', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_packages', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="tiktok_shop_id" class="col-sm-2 control-label">ID Toko TikTok 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="tiktok_shop_id" id="tiktok_shop_id" placeholder="ID Toko TikTok" value="<?= set_value('tiktok_shop_id', $tiktok_packages->tiktok_shop_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_id" class="col-sm-2 control-label">ID Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_id" id="package_id" placeholder="ID Paket" value="<?= set_value('package_id', $tiktok_packages->package_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="order_id" class="col-sm-2 control-label">ID Pesanan 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="order_id" id="order_id" placeholder="ID Pesanan" value="<?= set_value('order_id', $tiktok_packages->order_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_status" class="col-sm-2 control-label">Status Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_status" id="package_status" placeholder="Status Paket" value="<?= set_value('package_status', $tiktok_packages->package_status); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_sub_status" class="col-sm-2 control-label">Sub Status Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_sub_status" id="package_sub_status" placeholder="Sub Status Paket" value="<?= set_value('package_sub_status', $tiktok_packages->package_sub_status); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_provider_id" class="col-sm-2 control-label">ID Kurir Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider_id" id="shipping_provider_id" placeholder="ID Kurir Pengiriman" value="<?= set_value('shipping_provider_id', $tiktok_packages->shipping_provider_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_provider_name" class="col-sm-2 control-label">Nama Kurir Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider_name" id="shipping_provider_name" placeholder="Nama Kurir Pengiriman" value="<?= set_value('shipping_provider_name', $tiktok_packages->shipping_provider_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_type" class="col-sm-2 control-label">Tipe Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_type" id="shipping_type" placeholder="Tipe Pengiriman" value="<?= set_value('shipping_type', $tiktok_packages->shipping_type); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="delivery_option_id" class="col-sm-2 control-label">ID Opsi Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_id" id="delivery_option_id" placeholder="ID Opsi Pengiriman" value="<?= set_value('delivery_option_id', $tiktok_packages->delivery_option_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="delivery_option_name" class="col-sm-2 control-label">Nama Opsi Pengiriman 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_name" id="delivery_option_name" placeholder="Nama Opsi Pengiriman" value="<?= set_value('delivery_option_name', $tiktok_packages->delivery_option_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="tracking_number" class="col-sm-2 control-label">Nomor Resi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Nomor Resi" value="<?= set_value('tracking_number', $tiktok_packages->tracking_number); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="handover_method" class="col-sm-2 control-label">Metode Penyerahan (Pickup/Dropoff) 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="handover_method" id="handover_method" placeholder="Metode Penyerahan" value="<?= set_value('handover_method', $tiktok_packages->handover_method); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_length" class="col-sm-2 control-label">Panjang Dimensi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_length" id="dimension_length" placeholder="Panjang Dimensi" value="<?= set_value('dimension_length', $tiktok_packages->dimension_length); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_width" class="col-sm-2 control-label">Lebar Dimensi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_width" id="dimension_width" placeholder="Lebar Dimensi" value="<?= set_value('dimension_width', $tiktok_packages->dimension_width); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_height" class="col-sm-2 control-label">Tinggi Dimensi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_height" id="dimension_height" placeholder="Tinggi Dimensi" value="<?= set_value('dimension_height', $tiktok_packages->dimension_height); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_unit" class="col-sm-2 control-label">Satuan Dimensi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_unit" id="dimension_unit" placeholder="Satuan Dimensi (cm)" value="<?= set_value('dimension_unit', $tiktok_packages->dimension_unit); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="weight_val" class="col-sm-2 control-label">Berat Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="weight_val" id="weight_val" placeholder="Berat Paket" value="<?= set_value('weight_val', $tiktok_packages->weight_val); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="weight_unit" class="col-sm-2 control-label">Satuan Berat 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="weight_unit" id="weight_unit" placeholder="Satuan Berat (kg)" value="<?= set_value('weight_unit', $tiktok_packages->weight_unit); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_name" class="col-sm-2 control-label">Nama Pengirim 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder="Nama Pengirim" value="<?= set_value('sender_name', $tiktok_packages->sender_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_phone" class="col-sm-2 control-label">Nomor Telepon Pengirim 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="Nomor Telepon Pengirim" value="<?= set_value('sender_phone', $tiktok_packages->sender_phone); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_address" class="col-sm-2 control-label">Alamat Pengirim 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="sender_address" name="sender_address" rows="5" class="textarea form-control"><?= set_value('sender_address', $tiktok_packages->sender_address); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_name" class="col-sm-2 control-label">Nama Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" placeholder="Nama Penerima" value="<?= set_value('recipient_name', $tiktok_packages->recipient_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_phone" class="col-sm-2 control-label">Nomor Telepon Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_phone" id="recipient_phone" placeholder="Nomor Telepon Penerima" value="<?= set_value('recipient_phone', $tiktok_packages->recipient_phone); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_address" class="col-sm-2 control-label">Alamat Penerima 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="recipient_address" name="recipient_address" rows="5" class="textarea form-control"><?= set_value('recipient_address', $tiktok_packages->recipient_address); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_create_time" class="col-sm-2 control-label">Waktu Dibuatnya Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                            <div class="input-group date col-sm-8">
                              <input type="text" class="form-control pull-right datetimepicker" name="package_create_time"  placeholder="Waktu Dibuatnya Paket" id="package_create_time" value="<?= set_value('package_create_time', $tiktok_packages->package_create_time); ?>">
                            </div>
                            <small class="info help-block">
                            </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_update_time" class="col-sm-2 control-label">Waktu Pembaruan Paket 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                            <div class="input-group date col-sm-8">
                              <input type="text" class="form-control pull-right datetimepicker" name="package_update_time"  placeholder="Waktu Pembaruan Paket" id="package_update_time" value="<?= set_value('package_update_time', $tiktok_packages->package_update_time); ?>">
                            </div>
                            <small class="info help-block">
                            </small>
                            </div>
                        </div>
                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
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
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
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
          url: form_tiktok_packages.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#tiktok_packages_image_galery').find('li').attr('qq-file-id');
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            $('.data_file_uuid').val('');
    
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