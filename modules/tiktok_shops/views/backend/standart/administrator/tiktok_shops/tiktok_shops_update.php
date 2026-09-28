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
.box-shop-update {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-shop-update .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-shop-update .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-shop-update .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-shop-update .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-shop-update .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-shop-update .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Form Group Rows Alignment & Proximity */
.box-shop-update .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 14px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-shop-update .form-group:hover {
   background-color: #fafbfc;
}

.box-shop-update .form-group .control-label {
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

.box-shop-update .form-group .control-label .required {
   color: #ef4444;
   font-style: normal;
   font-weight: 700;
   margin-left: 3px;
}

.box-shop-update .form-group .col-sm-8 {
   width: 100% !important;
   max-width: 680px !important;
   flex-grow: 1 !important;
   padding: 0 !important;
}

/* Modern Input Styling */
.box-shop-update .form-control {
   border-radius: 6px !important;
   border: 1px solid #d1d5db !important;
   height: 38px !important;
   box-shadow: none !important;
   font-size: 13.5px !important;
   padding: 8px 12px !important;
   color: #1e293b !important;
   transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
}

.box-shop-update .form-control:focus {
   border-color: #3b82f6 !important;
   box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
}

/* Chosen Select Adjustment */
.box-shop-update .chosen-container-single .chosen-single {
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

.box-shop-update .chosen-container-single .chosen-single div b {
   background-position: 0 9px !important;
}

.box-shop-update .help-block {
   margin-top: 6px !important;
   margin-bottom: 0 !important;
   font-size: 12.5px !important;
   color: #64748b !important;
   line-height: 1.5 !important;
}

.box-shop-update .help-block a {
   color: #0284c7 !important;
   text-decoration: none;
}

.box-shop-update .help-block a:hover {
   text-decoration: underline;
}

/* Footer Action Buttons Container */
.box-shop-update .view-nav {
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

.box-shop-update .view-nav .btn {
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

.box-shop-update .loading {
   margin-left: 10px;
   display: inline-flex;
   align-items: center;
   gap: 6px;
}

.box-shop-update .loading i {
   color: #64748b;
   font-size: 12.5px;
   font-style: normal;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Akun Toko <small>Edit Akun Toko</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= site_url('administrator/tiktok_shops'); ?>">Akun Toko</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-shop-update">
                <div class="box-body" style="padding: 0;">
                    <!-- Widget: user widget style 1 -->
                    <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                        <div class="widget-user-header">
                            <div class="widget-user-image">
                                <img src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <div class="header-titles">
                                <h3 class="widget-user-username">Akun Toko</h3>
                                <h5 class="widget-user-desc">Edit Akun Toko</h5>
                            </div>
                        </div>

                        <?= form_open(base_url('administrator/tiktok_shops/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_tiktok_shops', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_shops', 
                            'method'  => 'POST'
                            ]); ?>

                        <div class="form-group">
                            <label for="shop_name" class="control-label">Nama Toko 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Nama Toko" value="<?= set_value('shop_name', $tiktok_shops->shop_name); ?>">
                                <small class="info help-block"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="app_key" class="control-label">App Key Partner 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="app_key" id="app_key" placeholder="App Key" value="<?= set_value('app_key', $tiktok_shops->app_key); ?>">
                                <small class="info help-block"></small>
                            </div>
                        </div>
                                                 
                        <div class="form-group">
                            <label for="app_secret" class="control-label">App Secret Partner 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="app_secret" id="app_secret" placeholder="App Secret" value="<?= set_value('app_secret', $tiktok_shops->app_secret); ?>">
                                <small class="info help-block"></small>
                            </div>
                        </div>
                                                 
                        <div class="form-group">
                            <label for="auth_code" class="control-label">Kode Otorisasi (Auth Code) 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="auth_code" id="auth_code" placeholder="Auth Code" value="<?= set_value('auth_code', $tiktok_shops->auth_code); ?>">
                                <small class="info help-block">
                                   Masukkan kode baru untuk memperbarui token atau klik <a href="<?= site_url('administrator/tiktok_shops/connect'); ?>" target="_blank" class="text-primary"><strong><i class="fa fa-external-link"></i> Hubungkan Akun Toko (TikTok OAuth)</strong></a>.
                                </small>
                            </div>
                        </div>
                                                 
                        <div class="form-group">
                            <label for="is_active" class="control-label">Status Toko 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select" name="is_active" id="is_active" data-placeholder="Pilih Status Toko">
                                    <option value=""></option>
                                    <option <?= $tiktok_shops->is_active == "1" ? 'selected' :''; ?> value="1">Aktif</option>
                                    <option <?= $tiktok_shops->is_active == "0" ? 'selected' :''; ?> value="0">Nonaktif</option>
                                </select>
                                <small class="info help-block"></small>
                            </div>
                        </div>
                                                
                        <div class="message" style="margin: 15px 25px 0 25px;"></div>
                        
                        <div class="view-nav">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save_back" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
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
              window.location.href = BASE_URL + 'administrator/tiktok_shops';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_tiktok_shops = $('#form_tiktok_shops');
        var data_post = form_tiktok_shops.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_tiktok_shops.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#tiktok_shops_image_galery').find('li').attr('qq-file-id');
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