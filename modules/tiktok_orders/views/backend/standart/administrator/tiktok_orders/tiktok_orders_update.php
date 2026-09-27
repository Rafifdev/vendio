
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
        Pesanan Penjualan        <small>Edit Pesanan Penjualan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_orders'); ?>">Pesanan Penjualan</a></li>
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
                            <h3 class="widget-user-username">Pesanan Penjualan</h3>
                            <h5 class="widget-user-desc">Edit Pesanan Penjualan</h5>
                            <hr>
                        </div>
                        <?= form_open(base_url('administrator/tiktok_orders/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_tiktok_orders', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_orders', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="tiktok_shop_id" class="col-sm-2 control-label">Tiktok Shop Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="tiktok_shop_id" id="tiktok_shop_id" data-placeholder="Select Tiktok Shop Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('tiktok_shops') as $row): ?>
                                    <option <?=  $row->id ==  $tiktok_orders->tiktok_shop_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->shop_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="order_id" class="col-sm-2 control-label">Order Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Order Id" value="<?= set_value('order_id', $tiktok_orders->order_id); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="order_status" class="col-sm-2 control-label">Order Status 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select" name="order_status" id="order_status" data-placeholder="Select Order Status" >
                                    <option value=""></option>
                                    <option <?= $tiktok_orders->order_status == "AWAITING_COLLECTION" ? 'selected' :''; ?> value="AWAITING_COLLECTION">Menunggu Pickup</option>
                                    <option <?= $tiktok_orders->order_status == "AWAITING_SHIPMENT" ? 'selected' :''; ?> value="AWAITING_SHIPMENT">Perlu Dikirim</option>
                                    <option <?= $tiktok_orders->order_status == "UNPAID" ? 'selected' :''; ?> value="UNPAID">Belum Dibayar</option>
                                    <option <?= $tiktok_orders->order_status == "IN_TRANSIT" ? 'selected' :''; ?> value="IN_TRANSIT">Sedang Dikirim</option>
                                    <option <?= $tiktok_orders->order_status == "DELIVERED" ? 'selected' :''; ?> value="DELIVERED">Pesanan Sampai</option>
                                    <option <?= $tiktok_orders->order_status == "COMPLETED" ? 'selected' :''; ?> value="COMPLETED">Selesai</option>
                                    </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_name" class="col-sm-2 control-label">Recipient Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" placeholder="Recipient Name" value="<?= set_value('recipient_name', $tiktok_orders->recipient_name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_phone" class="col-sm-2 control-label">Recipient Phone 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_phone" id="recipient_phone" placeholder="Recipient Phone" value="<?= set_value('recipient_phone', $tiktok_orders->recipient_phone); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_address" class="col-sm-2 control-label">Recipient Address 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="recipient_address" name="recipient_address" rows="5" class="textarea form-control"><?= set_value('recipient_address', $tiktok_orders->recipient_address); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_provider" class="col-sm-2 control-label">Shipping Provider 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider" id="shipping_provider" placeholder="Shipping Provider" value="<?= set_value('shipping_provider', $tiktok_orders->shipping_provider); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="tracking_number" class="col-sm-2 control-label">Tracking Number 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Tracking Number" value="<?= set_value('tracking_number', $tiktok_orders->tracking_number); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="total_amount" class="col-sm-2 control-label">Total Amount 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?= set_value('total_amount', $tiktok_orders->total_amount); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_type" class="col-sm-2 control-label">Shipping Type 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_type" id="shipping_type" placeholder="Shipping Type" value="<?= set_value('shipping_type', $tiktok_orders->shipping_type); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="delivery_option_name" class="col-sm-2 control-label">Delivery Option Name 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_name" id="delivery_option_name" placeholder="Delivery Option Name" value="<?= set_value('delivery_option_name', $tiktok_orders->delivery_option_name); ?>">
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
          url: form_tiktok_orders.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#tiktok_orders_image_galery').find('li').attr('qq-file-id');
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