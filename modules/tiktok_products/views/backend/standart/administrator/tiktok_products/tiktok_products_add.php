
<!-- Fine Uploader Gallery CSS file
    ====================================================================== -->
<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<!-- Fine Uploader jQuery JS file
    ====================================================================== -->
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
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
        Produk TikTok        <small><?= cclang('new', ['Produk TikTok']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/tiktok_products'); ?>">Produk TikTok</a></li>
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
                            <h3 class="widget-user-username">Produk TikTok</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Produk TikTok']); ?></h5>
                            <hr>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_tiktok_products', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_tiktok_products', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="tiktok_shop_id" class="col-sm-2 control-label">Toko TikTok 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="tiktok_shop_id" id="tiktok_shop_id" data-placeholder="Pilih Toko TikTok" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('tiktok_shops') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->shop_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label">Title 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">
                                <b>Input Title</b> minimal 25 karakter, maksimal 255 karakter sesuai ketentuan TikTok.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="main_image" class="col-sm-2 control-label">Main Image 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="tiktok_products_main_image_galery"></div>
                                <input class="data_file" name="tiktok_products_main_image_uuid" id="tiktok_products_main_image_uuid" type="hidden" value="<?= set_value('tiktok_products_main_image_uuid'); ?>">
                                <input class="data_file" name="tiktok_products_main_image_name" id="tiktok_products_main_image_name" type="hidden" value="<?= set_value('tiktok_products_main_image_name'); ?>">
                                <small class="info help-block">
                                Format JPG/PNG, resolusi minimal 300x300 px sesuai ketentuan TikTok.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="category_name" class="col-sm-2 control-label">Category 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="category_name" id="category_name" data-placeholder="Pilih Kategori TikTok">
                                    <option value=""></option>
                                    <?php if (!empty($categories)): foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id']; ?>" <?= (set_value('category_name') == $cat['id'] || (!set_value('category_name') && $cat['id'] == '601756')) ? 'selected' : ''; ?>><?= $cat['name']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                                <small class="info help-block">
                                Pilih kategori produk TikTok (pilihan brand akan otomatis menyesuaikan kategori).</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="brand_name" class="col-sm-2 control-label">Brand Name 
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="brand_name" id="brand_name" data-placeholder="Pilih Brand TikTok">
                                    <option value=""></option>
                                    <option value="No Brand" data-id="0" selected>No Brand / Tanpa Merek</option>
                                    <?php if (!empty($brands)): foreach ($brands as $b): if ($b['id'] !== '0'): ?>
                                    <option value="<?= $b['name']; ?>" data-id="<?= $b['id']; ?>"><?= $b['name']; ?></option>
                                    <?php endif; endforeach; endif; ?>
                                </select>
                                <input type="hidden" name="brand_id" id="brand_id" value="0">
                                <small class="info help-block" id="brand_info">
                                Brand resmi dari TikTok sesuai kategori (default: No Brand / Tanpa Merek).</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="seller_sku" class="col-sm-2 control-label">Seller Sku 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="seller_sku" id="seller_sku" placeholder="Seller Sku" value="<?= set_value('seller_sku'); ?>">
                                <small class="info help-block">
                                Kode SKU unik penjual (Otomatis dibuat jika kosong).</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="price" class="col-sm-2 control-label">Price 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="price" id="price" placeholder="Price" value="<?= set_value('price'); ?>">
                                <small class="info help-block">
                                Harga produk dalam Rupiah (IDR), minimal Rp 1.000.</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="total_stock" class="col-sm-2 control-label">Total Stock 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="total_stock" id="total_stock" placeholder="Total Stock" value="<?= set_value('total_stock'); ?>">
                                <small class="info help-block">
                                Jumlah stok produk di gudang TikTok (minimal 0).</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="package_weight" class="col-sm-2 control-label">Package Weight (Kg) 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="package_weight" id="package_weight" placeholder="Package Weight (Kg)" value="<?= set_value('package_weight'); ?>">
                                <small class="info help-block">
                                Berat paket dalam kilogram (Contoh: 1 atau 0.5 kg, min 0.01 kg).</small>
                            </div>
                        </div>
                                                 
                        <div class="form-group ">
                            <label for="description" class="col-sm-2 control-label">Description 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="description" name="description" rows="5" class="textarea form-control"><?= set_value('description'); ?></textarea>
                                <small class="info help-block">
                                Deskripsi produk minimal 10 karakter sesuai ketentuan TikTok.</small>
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
              window.location.href = BASE_URL + 'administrator/tiktok_products';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_tiktok_products = $('#form_tiktok_products');
        var data_post = form_tiktok_products.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/tiktok_products/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id_main_image = $('#tiktok_products_main_image_galery').find('li').attr('qq-file-id');
            
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();
            if (typeof id_main_image !== 'undefined') {
                    $('#tiktok_products_main_image_galery').fineUploader('deleteFile', id_main_image);
                }
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
            $('.message').fadeIn();
          }
    
        })
        .fail(function(xhr) {
          var msg = 'Terjadi kesalahan sistem saat menyimpan data.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
          } else if (xhr.responseText) {
            try {
              var parsed = JSON.parse(xhr.responseText);
              if (parsed.message) {
                msg = parsed.message;
              }
            } catch(e) {}
          }
          $('.message').printMessage({message : msg, type : 'warning'});
          $('.message').fadeIn();
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $('.message').offset().top - 120 }, 500);
        });
    
        return false;
      }); /*end btn save*/
      
              var params = {};
       params[csrf] = token;

       $('#tiktok_products_main_image_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/tiktok_products/upload_main_image_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + '/administrator/tiktok_products/delete_main_image_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
          multiple : false,
          validation: {
              allowedExtensions: ["*"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#tiktok_products_main_image_galery').fineUploader('getUuid', id);
                   $('#tiktok_products_main_image_uuid').val(uuid);
                   $('#tiktok_products_main_image_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#tiktok_products_main_image_uuid').val();
                  if (uuid) {
                      $.get(BASE_URL + '/administrator/tiktok_products/delete_main_image_file/' + uuid);
                  }
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#tiktok_products_main_image_uuid').val('');
                  $('#tiktok_products_main_image_name').val('');
                }
              }
          }
      }); /*end main_image galery*/
              
 
       
    
    
      // Load Brand TikTok sesuai kategori terpilih
      $(document).on('change', '#category_name', function() {
          var catId = $(this).val();
          var shopId = $('#tiktok_shop_id').val();
          if (!catId) return;

          $('#brand_info').html('<i>Memuat daftar brand TikTok...</i>');

          $.ajax({
              url: BASE_URL + 'administrator/tiktok_products/ajax_get_brands',
              type: 'GET',
              dataType: 'json',
              data: { category_id: catId, tiktok_shop_id: shopId },
              success: function(res) {
                  $('#brand_name').empty();
                  $('#brand_name').append('<option value=""></option>');
                  $('#brand_name').append('<option value="No Brand" data-id="0" selected>No Brand / Tanpa Merek</option>');
                  if (res.success && res.brands) {
                      $.each(res.brands, function(i, brand) {
                          if (brand.id !== '0') {
                              $('#brand_name').append('<option value="' + brand.name + '" data-id="' + brand.id + '">' + brand.name + '</option>');
                          }
                      });
                  }
                  $('#brand_id').val('0');
                  $('#brand_name').trigger('chosen:updated');
                  $('#brand_info').html('Brand resmi dari TikTok sesuai kategori (default: No Brand / Tanpa Merek).');
              },
              error: function() {
                  $('#brand_info').html('Brand resmi dari TikTok sesuai kategori (default: No Brand / Tanpa Merek).');
              }
          });
      });

      $(document).on('change', '#brand_name', function() {
          var selectedId = $(this).find('option:selected').data('id');
          $('#brand_id').val(selectedId !== undefined ? selectedId : '0');
      });

    }); /*end doc ready*/
</script>