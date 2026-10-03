<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
function domo(){
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
.box-blog-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-blog-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-blog-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-blog-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-blog-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-blog-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-blog-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-blog-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 14px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-blog-view .form-group:last-child {
   border-bottom: none;
}

.box-blog-view .form-group:hover {
   background-color: #fafbfc;
}

.box-blog-view .form-group .control-label {
   width: 190px !important;
   min-width: 190px !important;
   flex-shrink: 0 !important;
   text-align: left !important;
   color: #64748b !important;
   font-weight: 600 !important;
   font-size: 13px !important;
   padding: 0 !important;
   margin: 0 !important;
   line-height: 1.6 !important;
}

.box-blog-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for Slug & ID */
.box-blog-view .chip-slug {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   font-family: 'SF Mono', SFMono-Regular, ui-monospace, Menlo, Monaco, Consolas, monospace;
   font-size: 12px;
   font-weight: 600;
   color: #0284c7;
   background-color: #f0f9ff;
   border: 1px solid #bae6fd;
   border-radius: 6px;
   padding: 3px 10px;
   text-decoration: none;
   transition: all 0.15s ease;
}

.box-blog-view .chip-slug:hover {
   background-color: #e0f2fe;
   color: #0369a1;
   border-color: #7dd3fc;
}

.box-blog-view .chip-id {
   display: inline-block;
   font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
   font-size: 12px;
   font-weight: 600;
   color: #475569;
   background-color: #f1f5f9;
   border: 1px solid #e2e8f0;
   border-radius: 6px;
   padding: 2px 8px;
}

.box-blog-view .badge-category {
   background-color: #f1f5f9;
   color: #475569;
   font-size: 11.5px;
   font-weight: 600;
   padding: 4px 10px;
   border-radius: 6px;
   display: inline-block;
}

/* Blog Thumbnail */
.box-blog-view .blog-thumb-view {
   width: 90px;
   height: 90px;
   object-fit: cover;
   border-radius: 8px;
   border: 1px solid #e2e8f0;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
   display: inline-block;
   margin-right: 8px;
   margin-bottom: 8px;
}

.box-blog-view .blog-content-preview {
   max-width: 850px;
   padding: 16px 20px;
   background-color: #f8fafc;
   border: 1px solid #edf2f7;
   border-radius: 8px;
   line-height: 1.7;
   color: #334155;
   font-size: 13.5px;
}

/* Footer Action Buttons Container */
.box-blog-view .view-nav {
   display: flex;
   align-items: center;
   gap: 10px;
   padding: 18px 25px;
   background-color: #fafbfc;
   border-top: 1px solid #edf2f7;
   border-bottom-left-radius: 8px;
   border-bottom-right-radius: 8px;
   margin-top: 15px;
}

.box-blog-view .view-nav .btn {
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
      Blog <small><?= cclang('detail', ['Blog']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/blog'); ?>">Blog</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-blog-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Blog</h3>
                        <h5 class="widget-user-desc">Detail Blog</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_blog" id="form_blog">
                   
                     <div class="form-group">
                        <label class="control-label">ID Artikel</label>
                        <div class="col-sm-8">
                           <span class="chip-id">#<?= _ent($blog->id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label class="control-label">Judul Artikel</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 700; color: #0f172a; font-size: 14.5px;"><?= _ent($blog->title); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label class="control-label">Slug URL</label>
                        <div class="col-sm-8">
                           <a href="<?= site_url('blog/' . $blog->slug); ?>" target="_blank" class="chip-slug" title="<?= site_url('blog/' . $blog->slug); ?>">
                              /<?= _ent($blog->slug); ?>
                              <i class="fa fa-external-link" style="font-size: 11px;"></i>
                           </a>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label class="control-label">Kategori</label>
                        <div class="col-sm-8">
                           <span class="badge-category"><?= _ent(!empty($blog->category_name) ? $blog->category_name : 'Uncategorized'); ?></span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Status</label>
                        <div class="col-sm-8">
                           <?php 
                           $status = strtolower(trim((string)$blog->status));
                           if ($status == 'publish' || $status == 'published'): ?>
                              <span class="label label-success">Publish</span>
                           <?php elseif ($status == 'draft'): ?>
                              <span class="label label-info">Draft</span>
                           <?php elseif ($status == 'archive' || $status == 'archived'): ?>
                              <span class="label label-default">Archive</span>
                           <?php else: ?>
                              <span class="label label-default"><?= _ent(ucfirst($status)); ?></span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Tag</label>
                        <div class="col-sm-8">
                           <?php if (!empty($blog->tags)): ?>
                              <?php foreach (explode(',', $blog->tags) as $tag): if(trim($tag)): ?>
                                 <span style="display: inline-block; background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-right: 4px;">#<?= _ent(trim($tag)); ?></span>
                              <?php endif; endforeach; ?>
                           <?php else: ?>
                              <span class="text-muted">-</span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Gambar Sampul</label>
                        <div class="col-sm-8">
                           <?php if (!empty($blog->image)): ?>
                              <?php foreach (explode(',', $blog->image) as $filename): if(trim($filename)): ?>
                                 <?php if (is_image(trim($filename))): ?>
                                    <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/blog/' . trim($filename); ?>">
                                       <img src="<?= BASE_URL . 'uploads/blog/' . trim($filename); ?>" class="blog-thumb-view" alt="image blog" title="Klik untuk memperbesar">
                                    </a>
                                 <?php else: ?>
                                    <a href="<?= BASE_URL . 'administrator/file/download/blog/' . trim($filename); ?>" style="display: inline-flex; align-items: center; gap: 8px; margin-right: 8px;">
                                       <img src="<?= get_icon_file(trim($filename)); ?>" width="32px" alt="file"> 
                                       <span><?= trim($filename) ?></span>
                                    </a>
                                 <?php endif; ?>
                              <?php endif; endforeach; ?>
                           <?php else: ?>
                              <span class="text-muted" style="font-style: italic;">Tidak ada gambar</span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Konten Artikel</label>
                        <div class="col-sm-8">
                           <div class="blog-content-preview">
                              <?= $blog->content; ?>
                           </div>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Penulis</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 500; color: #334155;">
                              <i class="fa fa-user-circle-o text-muted" style="margin-right: 6px;"></i><?= _ent($blog->author ?: '-'); ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Waktu Dibuat</label>
                        <div class="col-sm-8">
                           <span class="text-muted"><i class="fa fa-clock-o" style="margin-right: 6px;"></i><?= !empty($blog->created_at) ? date('d M Y H:i', strtotime($blog->created_at)) : '-'; ?></span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label class="control-label">Terakhir Diperbarui</label>
                        <div class="col-sm-8">
                           <span class="text-muted"><i class="fa fa-clock-o" style="margin-right: 6px;"></i><?= !empty($blog->updated_at) ? date('d M Y H:i', strtotime($blog->updated_at)) : '-'; ?></span>
                        </div>
                     </div>

                     <div class="view-nav">
                        <?php is_allowed('blog_update', function() use ($blog){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="Edit Blog (Ctrl+e)" href="<?= site_url('administrator/blog/edit/'.$blog->id); ?>">
                           <i class="fa fa-edit"></i> <?= cclang('update', ['Blog']); ?>
                        </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar (Ctrl+x)" href="<?= site_url('administrator/blog'); ?>">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Blog']); ?>
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
