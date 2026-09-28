<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
      return false;
   });
}

jQuery(document).ready(domo);
</script>

<style>
/* Clean & Refined Card Container */
.box-brand-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-brand-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-brand-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-brand-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-brand-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-brand-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-brand-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-brand-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-brand-view .form-group:last-child {
   border-bottom: none;
}

.box-brand-view .form-group:hover {
   background-color: #fafbfc;
}

.box-brand-view .form-group .control-label {
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

.box-brand-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-brand-view .chip-id {
   display: inline-block;
   font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
   font-size: 12.5px;
   font-weight: 500;
   color: #475569;
   background-color: #f1f5f9;
   border: 1px solid #e2e8f0;
   border-radius: 6px;
   padding: 3px 10px;
   letter-spacing: 0.02em;
}

/* Footer Action Buttons Container */
.box-brand-view .view-nav {
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

.box-brand-view .view-nav .btn {
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
      Merek Produk <small><?= cclang('detail', ['Merek Produk']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_brands'); ?>">Merek Produk</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-brand-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Merek Produk</h3>
                        <h5 class="widget-user-desc">Detail Merek Produk</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_brands" id="form_tiktok_brands">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">ID</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_brands->id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Merek (Brand)</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_brands->name); ?></strong>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Merek TikTok</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_brands->tiktok_brand_id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Kategori</label>
                         <div class="col-sm-8">
                            <?php if (!empty($tiktok_brands->category_id) && $tiktok_brands->category_id != '0'): ?>
                               <span class="chip-id"><?= _ent($tiktok_brands->category_id); ?></span>
                            <?php else: ?>
                               <span class="text-muted">-</span>
                            <?php endif; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Status Otorisasi</label>
                         <div class="col-sm-8">
                            <?= $tiktok_brands->is_authorized ? '<span class="label label-success">Terotorisasi</span>' : '<span class="label label-danger">Belum Terotorisasi</span>'; ?>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar Merek (Ctrl+x)" href="<?= site_url('administrator/tiktok_brands/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Merek']); ?></a>
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
