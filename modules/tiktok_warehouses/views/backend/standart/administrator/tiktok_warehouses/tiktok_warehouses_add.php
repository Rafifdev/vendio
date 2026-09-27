
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
        Daftar Gudang        <small><?= cclang('new', ['Daftar Gudang']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_warehouses'); ?>">Daftar Gudang</a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                            <h3 class="widget-user-username">Daftar Gudang</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Daftar Gudang']); ?></h5>
                            <hr>
                        </div>
                                                <?= form_open('', [
                            'name'    => 'form_tiktok_warehouses', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_warehouses', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="name" class="col-sm-2 control-label">Nama Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nama Gudang" value="<?= set_value('name'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="tiktok_warehouse_id" class="col-sm-2 control-label">ID Daftar Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tiktok_warehouse_id" id="tiktok_warehouse_id" placeholder="ID Daftar Gudang" value="<?= set_value('tiktok_warehouse_id'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="warehouse_type" class="col-sm-2 control-label">Tipe Gudang 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="warehouse_type" id="warehouse_type" placeholder="Tipe Gudang" value="<?= set_value('warehouse_type'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="address" class="col-sm-2 control-label">Alamat Gudang 
                            </label>
                            <div class="col-sm-8">
                                <textarea id="address" name="address" rows="5" class="form-control"><?= set_value('address'); ?></textarea>
                            </div>
                        </div>



                        <div class="form-group ">
                            <label for="is_default" class="col-sm-2 control-label">Gudang Utama 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="is_default" id="is_default" placeholder="Gudang Utama (1/0)" value="<?= set_value('is_default'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="effect_status" class="col-sm-2 control-label">Status 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="effect_status" id="effect_status" placeholder="Status" value="<?= set_value('effect_status'); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="shop_id" class="col-sm-2 control-label">ID Toko 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="shop_id" id="shop_id" placeholder="ID Toko" value="<?= set_value('shop_id'); ?>">
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
<script src="<?= BASE_ASSET; ?>ckeditor/ckeditor.js"></script>
<!-- Page script -->
<script>
    $(document).ready(function(){
            CKEDITOR.replace('address'); 
      var address = CKEDITOR.instances.address;
                   
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
          url: BASE_URL + '/administrator/tiktok_warehouses/add_save',
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
            address.setData('');
                
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