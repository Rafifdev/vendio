
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

/* Ensure symmetry for all inputs, CKEditor, Fine Uploader, and Chosen select */
.box-form-modern .chosen-container {
   width: 100% !important;
}

.box-form-modern .cke {
   width: 100% !important;
   max-width: 100% !important;
   box-sizing: border-box !important;
}

.box-form-modern .qq-gallery.qq-uploader {
   width: 100% !important;
   max-width: 100% !important;
   box-sizing: border-box !important;
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
        Blog        <small><?= cclang('new', ['Blog']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/blog'); ?>">Blog</a></li>
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
                                <h3 class="widget-user-username">Blog</h3>
                                <h5 class="widget-user-desc"><?= cclang('new', ['Blog']); ?></h5>
                            </div>
                        </div>
                        <?= form_open('', [
                            'name'    => 'form_blog', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_blog', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                        <div class="form-group ">
                            <label for="title" class="control-label">Judul Artikel 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan judul artikel blog..." value="<?= set_value('title'); ?>">
                                <span class="blog-slug" style="display: none;"></span>
                                <small class="info help-block">
                                Judul artikel blog yang informatif dan menarik untuk pembaca.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="category" class="control-label">Kategori 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="category" id="category" data-placeholder="Pilih Kategori Blog">
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('blog_category') as $row): ?>
                                    <option value="<?= $row->category_id ?>"><?= $row->category_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                Pilih kategori yang sesuai untuk artikel blog ini.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="status" class="control-label">Status Publikasi 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select" name="status" id="status" data-placeholder="Pilih Status Publikasi">
                                    <option value="publish" <?= (set_value('status') == 'publish' || !set_value('status')) ? 'selected' : ''; ?>>Publish</option>
                                    <option value="draft" <?= set_value('status') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    <option value="archive" <?= set_value('status') == 'archive' ? 'selected' : ''; ?>>Archive</option>
                                </select>
                                <small class="info help-block">
                                Tentukan status publikasi artikel (Publish, Draft, atau Archive).</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="tags" class="control-label">Tag Artikel 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tags" id="tags" placeholder="Contoh: Ecommerce, Bisnis, Tips" value="<?= set_value('tags'); ?>">
                                <small class="info help-block">
                                Pisahkan dengan tanda koma (,) untuk menambahkan beberapa tag (opsional).</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="blog_image_galery" class="control-label">Gambar Sampul 
                            </label>
                            <div class="col-sm-8">
                                <div id="blog_image_galery"></div>
                                <div id="blog_image_galery_listed"></div>
                                <small class="info help-block">
                                <b>Format file yang diizinkan:</b> JPG, JPEG, PNG.</small>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="content" class="control-label">Konten Artikel 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <textarea id="content" name="content" rows="12" class="textarea form-control" placeholder="Tuliskan isi artikel blog di sini..."><?= set_value('content'); ?></textarea>
                                <small class="info help-block">
                                Tuliskan isi konten artikel secara lengkap dengan teks, format heading, dan media.</small>
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
                            <span class="loading loading-hide" style="display: none;">
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

    $(document).on('keyup', '#title', function(event) {
      var link = $(this).val().replaceAll(/[^0-9a-z]/gi, '-').replaceAll(/-+/g, '-').toLowerCase();
      $('.blog-slug').html(link);
    });

    $(document).on('focusout', '.blog-slug', function(event) {
      var link = $(this).html().replaceAll(/[^0-9a-z]/gi, '-').replaceAll(/-+/g, '-').toLowerCase();

      $('.blog-slug').html(link);
    });
      
    CKEDITOR.replace('content', {
      width: '100%'
    }); 
    var content = CKEDITOR.instances.content;
                   
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
            window.location.href = BASE_URL + 'administrator/blog';
          }
        });

      return false;
    }); /*end btn cancel*/
  
    $('.btn_save').click(function(){
      $('.message').fadeOut();
      $('#content').val(content.getData());
                  
      var form_blog = $('#form_blog');
      var data_post = form_blog.serializeArray();
      var save_type = $(this).attr('data-stype');

      data_post.push({name: 'save_type', value: save_type});
      data_post.push({name: 'slug', value: $('.blog-slug').html()});
  
      $('.loading').show();
  
      $.ajax({
        url: BASE_URL + '/administrator/blog/add_save',
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
          $('#blog_image_galery').find('li').each(function() {
             $('#blog_image_galery').fineUploader('deleteFile', $(this).attr('qq-file-id'));
          });
          $('.chosen option').prop('selected', false).trigger('chosen:updated');
          content.setData('');
              
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
    
    var params = {};
    params[csrf] = token;

    $('#blog_image_galery').fineUploader({
        template: 'qq-template-gallery',
        request: {
            endpoint: BASE_URL + '/administrator/blog/upload_image_file',
            params : params
        },
        deleteFile: {
            enabled: true, 
            endpoint: BASE_URL + '/administrator/blog/delete_image_file',
        },
        thumbnails: {
            placeholders: {
                waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
            }
        },
        validation: {
            allowedExtensions: ["jpg","jpeg","png"],
            sizeLimit : 0,
        },
        showMessage: function(msg) {
            toastr['error'](msg);
        },
        callbacks: {
            onComplete : function(id, name, xhr) {
              if (xhr.success) {
                 var uuid = $('#blog_image_galery').fineUploader('getUuid', id);
                 $('#blog_image_galery_listed').append('<input type="hidden" class="listed_file_uuid" name="blog_image_uuid['+id+']" value="'+uuid+'" /><input type="hidden" class="listed_file_name" name="blog_image_name['+id+']" value="'+xhr.uploadName+'" />');
              } else {
                 toastr['error'](xhr.error);
              }
            },
            onDeleteComplete : function(id, xhr, isError) {
              if (isError == false) {
                $('#blog_image_galery_listed').find('.listed_file_uuid[name="blog_image_uuid['+id+']"]').remove();
                $('#blog_image_galery_listed').find('.listed_file_name[name="blog_image_name['+id+']"]').remove();
              }
            }
        }
    }); /*end image galery*/
            
  }); /*end doc ready*/
</script>