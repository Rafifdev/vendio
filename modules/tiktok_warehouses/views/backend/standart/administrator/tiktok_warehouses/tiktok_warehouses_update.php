
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
        Daftar Gudang        <small>Edit Daftar Gudang</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_warehouses'); ?>">Daftar Gudang</a></li>
        <li class="active">Edit</li>
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
                                <h3 class="widget-user-username">Daftar Gudang</h3>
                                <h5 class="widget-user-desc">Edit Daftar Gudang</h5>
                            </div>
                        </div>
                                                <?= form_open(base_url('administrator/tiktok_warehouses/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_tiktok_warehouses', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_warehouses', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="name" class="control-label">Nama Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Gudang" value="<?= set_value('name', $tiktok_warehouses->name); ?>" readonly>
                                <small class="info help-block">Nama gudang disinkronisasi dari TikTok Shop.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="tiktok_warehouse_id" class="control-label">ID Gudang TikTok 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tiktok_warehouse_id" id="tiktok_warehouse_id" placeholder="ID Gudang TikTok" value="<?= set_value('tiktok_warehouse_id', $tiktok_warehouses->tiktok_warehouse_id); ?>" readonly>
                                <small class="info help-block">ID unik gudang dari sistem TikTok Shop.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="warehouse_type" class="control-label">Tipe Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="warehouse_type" id="warehouse_type" placeholder="Tipe Gudang" value="<?= set_value('warehouse_type', $tiktok_warehouses->warehouse_type); ?>" readonly>
                                <small class="info help-block">SALES_WAREHOUSE (Gudang Penjualan) atau RETURN_WAREHOUSE (Gudang Retur).</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="address" class="control-label">Alamat Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="address" name="address" rows="4" class="form-control" readonly><?= set_value('address', $tiktok_warehouses->address); ?></textarea>
                                <small class="info help-block">Alamat fisik gudang terdaftar di TikTok.</small>
                            </div>
                        </div>



                        <div class="form-group ">
                            <label for="is_default" class="control-label">Gudang Utama 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="is_default" id="is_default" placeholder="Gudang Utama" value="<?= $tiktok_warehouses->is_default ? 'Ya' : 'Tidak'; ?>" readonly>
                                <small class="info help-block">Status gudang utama penjual di TikTok Shop.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="effect_status" class="control-label">Status 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="effect_status" id="effect_status" placeholder="Status" value="<?= $tiktok_warehouses->effect_status == 'EFFECTIVE' ? 'Aktif' : 'Tidak Aktif'; ?>" readonly>
                                <small class="info help-block">Status keaktifan gudang di TikTok Shop.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="shop_id" class="control-label">ID Toko 
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="shop_id" id="shop_id" placeholder="ID Toko" value="<?= set_value('shop_id', $tiktok_warehouses->shop_id); ?>" readonly>
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
<script src="<?= BASE_ASSET; ?>ckeditor/ckeditor.js"></script>
<!-- Page script -->
<script>
    $(document).ready(function(){
      
      CKEDITOR.replace('address'); 
      var address = CKEDITOR.instances.address;
                   
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
              window.location.href = BASE_URL + 'administrator/tiktok_warehouses';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
        $('#address').val(address.getData());
                    
        var form_tiktok_warehouses = $('#form_tiktok_warehouses');
        var data_post = form_tiktok_warehouses.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_tiktok_warehouses.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#tiktok_warehouses_image_galery').find('li').attr('qq-file-id');
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