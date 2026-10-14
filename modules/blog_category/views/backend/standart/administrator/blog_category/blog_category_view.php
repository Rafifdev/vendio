<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
function domo(){
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
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

/* Detail Form Group Rows */
.box-form-modern .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 16px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
}

.box-form-modern .form-group:hover {
   background-color: #fafbfc;
}

.box-form-modern .form-group .control-label {
   width: 210px !important;
   min-width: 210px !important;
   flex-shrink: 0 !important;
   text-align: left !important;
   color: #64748b !important;
   font-weight: 600 !important;
   font-size: 13px !important;
   padding: 0 !important;
   margin: 0 !important;
   line-height: 1.5 !important;
}

.box-form-modern .form-group .col-sm-8 {
   width: 100% !important;
   max-width: 680px !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b;
   font-size: 13.5px;
}

.box-form-modern .chip-id {
   font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
   font-size: 12px;
   color: #475569;
   background: #f1f5f9;
   padding: 3px 8px;
   border-radius: 4px;
   border: 1px solid #e2e8f0;
   display: inline-block;
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
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Kategori Blog <small><?= cclang('detail', ['Kategori Blog']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/blog_category'); ?>">Kategori Blog</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-form-modern">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Kategori Blog</h3>
                        <h5 class="widget-user-desc">Detail Kategori Blog</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_blog_category" id="form_blog_category">
                     <div class="form-group">
                        <label class="control-label">ID Kategori</label>
                        <div class="col-sm-8">
                           <span class="chip-id"><?= _ent($blog_category->category_id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label class="control-label">Nama Kategori</label>
                        <div class="col-sm-8">
                           <div style="font-weight: 700; color: #1e293b; font-size: 14px;">
                              <i class="fa fa-folder-o" style="color: #64748b; margin-right: 8px;"></i><?= _ent($blog_category->category_name); ?>
                           </div>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label class="control-label">Deskripsi Kategori</label>
                        <div class="col-sm-8" style="line-height: 1.6; color: #475569;">
                           <?= nl2br(_ent(!empty($blog_category->category_desc) ? $blog_category->category_desc : '-')); ?>
                        </div>
                     </div>
                                        
                     <div class="view-nav">
                        <?php is_allowed('blog_category_update', function() use ($blog_category){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" title="Edit Kategori (Ctrl+e)" href="<?= site_url('administrator/blog_category/edit/'.$blog_category->category_id); ?>">
                           <i class="fa fa-pencil-square-o"></i> <?= cclang('update_button'); ?>
                        </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar (Ctrl+x)" href="<?= site_url('administrator/blog_category'); ?>">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Kategori Blog']); ?>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->
      </div>
   </div>
</section>
<!-- /.content -->
