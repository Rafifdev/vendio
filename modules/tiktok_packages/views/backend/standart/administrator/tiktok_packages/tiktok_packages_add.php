
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
                         
                                                <div class="form-group ">
                            <label for="tiktok_shop_id" class="control-label">Tiktok Shop Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="tiktok_shop_id" id="tiktok_shop_id" placeholder="Tiktok Shop Id" value="<?= set_value('tiktok_shop_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_id" class="control-label">Package Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_id" id="package_id" placeholder="Package Id" value="<?= set_value('package_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="order_id" class="control-label">Order Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Order Id" value="<?= set_value('order_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_status" class="control-label">Package Status 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_status" id="package_status" placeholder="Package Status" value="<?= set_value('package_status'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_sub_status" class="control-label">Package Sub Status 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_sub_status" id="package_sub_status" placeholder="Package Sub Status" value="<?= set_value('package_sub_status'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_provider_id" class="control-label">Shipping Provider Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider_id" id="shipping_provider_id" placeholder="Shipping Provider Id" value="<?= set_value('shipping_provider_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_provider_name" class="control-label">Shipping Provider Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_provider_name" id="shipping_provider_name" placeholder="Shipping Provider Name" value="<?= set_value('shipping_provider_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="shipping_type" class="control-label">Shipping Type 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_type" id="shipping_type" placeholder="Shipping Type" value="<?= set_value('shipping_type'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="delivery_option_id" class="control-label">Delivery Option Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_id" id="delivery_option_id" placeholder="Delivery Option Id" value="<?= set_value('delivery_option_id'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="delivery_option_name" class="control-label">Delivery Option Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="delivery_option_name" id="delivery_option_name" placeholder="Delivery Option Name" value="<?= set_value('delivery_option_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="tracking_number" class="control-label">Tracking Number 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Tracking Number" value="<?= set_value('tracking_number'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="handover_method" class="control-label">Handover Method 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="handover_method" id="handover_method" placeholder="Handover Method" value="<?= set_value('handover_method'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_length" class="control-label">Dimension Length 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_length" id="dimension_length" placeholder="Dimension Length" value="<?= set_value('dimension_length'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_width" class="control-label">Dimension Width 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_width" id="dimension_width" placeholder="Dimension Width" value="<?= set_value('dimension_width'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_height" class="control-label">Dimension Height 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_height" id="dimension_height" placeholder="Dimension Height" value="<?= set_value('dimension_height'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="dimension_unit" class="control-label">Dimension Unit 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="dimension_unit" id="dimension_unit" placeholder="Dimension Unit" value="<?= set_value('dimension_unit'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="weight_val" class="control-label">Weight Val 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="weight_val" id="weight_val" placeholder="Weight Val" value="<?= set_value('weight_val'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="weight_unit" class="control-label">Weight Unit 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="weight_unit" id="weight_unit" placeholder="Weight Unit" value="<?= set_value('weight_unit'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_name" class="control-label">Sender Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder="Sender Name" value="<?= set_value('sender_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_phone" class="control-label">Sender Phone 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sender_phone" id="sender_phone" placeholder="Sender Phone" value="<?= set_value('sender_phone'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sender_address" class="control-label">Sender Address 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="sender_address" name="sender_address" rows="5" class="textarea form-control"><?= set_value('sender_address'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_name" class="control-label">Recipient Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_name" id="recipient_name" placeholder="Recipient Name" value="<?= set_value('recipient_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_phone" class="control-label">Recipient Phone 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="recipient_phone" id="recipient_phone" placeholder="Recipient Phone" value="<?= set_value('recipient_phone'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="recipient_address" class="control-label">Recipient Address 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="recipient_address" name="recipient_address" rows="5" class="textarea form-control"><?= set_value('recipient_address'); ?></textarea>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_create_time" class="control-label">Package Create Time 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                            <div class="input-group date col-sm-8">
                              <input type="text" class="form-control pull-right datetimepicker" name="package_create_time"  id="package_create_time">
                            </div>
                            <small class="info help-block">
                            </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="package_update_time" class="control-label">Package Update Time 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-6">
                            <div class="input-group date col-sm-8">
                              <input type="text" class="form-control pull-right datetimepicker" name="package_update_time"  id="package_update_time">
                            </div>
                            <small class="info help-block">
                            </small>
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