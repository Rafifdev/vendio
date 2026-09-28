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
.box-category-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-category-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-category-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-category-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-category-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-category-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-category-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-category-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-category-view .form-group:last-child {
   border-bottom: none;
}

.box-category-view .form-group:hover {
   background-color: #fafbfc;
}

.box-category-view .form-group .control-label {
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

.box-category-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-category-view .chip-id {
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

/* Modern Sub Tables */
.box-category-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 900px;
}

.box-category-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-category-view .sub-table thead th {
   background-color: #f8fafc !important;
   color: #64748b !important;
   font-size: 11px !important;
   font-weight: 700 !important;
   text-transform: uppercase !important;
   letter-spacing: 0.04em !important;
   border-top: none !important;
   border-bottom: 1px solid #e2e8f0 !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   vertical-align: middle !important;
}

.box-category-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-category-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-category-view .view-nav {
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

.box-category-view .view-nav .btn {
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
      Kategori Produk <small><?= cclang('detail', ['Kategori Produk']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_categories'); ?>">Kategori Produk</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-category-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Kategori Produk</h3>
                        <h5 class="widget-user-desc">Detail Kategori Produk</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_categories" id="form_tiktok_categories">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">ID</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_categories->id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Kategori</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_categories->local_name); ?></strong>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Kategori TikTok</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_categories->tiktok_category_id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Induk Kategori</label>
                         <div class="col-sm-8">
                            <?php if (!empty($tiktok_categories->parent_category_id) && $tiktok_categories->parent_category_id != '0'): ?>
                               <span class="chip-id"><?= _ent($tiktok_categories->parent_category_id); ?></span>
                            <?php else: ?>
                               <span class="text-muted">-</span>
                            <?php endif; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Tingkat</label>
                         <div class="col-sm-8">
                            Level <?= _ent($tiktok_categories->level); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Tipe Kategori</label>
                         <div class="col-sm-8">
                            <?= $tiktok_categories->is_leaf ? '<span class="label label-info">Leaf Kategori</span>' : 'Induk Kategori'; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Status Izin</label>
                         <div class="col-sm-8">
                            <?= strtoupper($tiktok_categories->permission_status) == "AVAILABLE" ? '<span class="label label-success">Tersedia</span>' : '<span class="label label-warning">Dibatasi</span>'; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Versi Kategori</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_categories->category_version ?: "-"); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Atribut Kategori</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th>Nama Atribut</th>
                                             <th style="width: 140px;">ID Atribut</th>
                                             <th style="width: 120px;">Tipe Input</th>
                                             <th style="width: 110px; text-align: center;">Wajib Diisi</th>
                                             <th>Pilihan Nilai</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php if (!empty($tiktok_categories->attributes)): ?>
                                             <?php foreach ($tiktok_categories->attributes as $attr): ?>
                                                 <?php 
                                                     $vals = [];
                                                     if (!empty($attr->values_json)) {
                                                         $decoded = json_decode($attr->values_json, true);
                                                         if (is_array($decoded)) {
                                                             foreach ($decoded as $val_item) {
                                                                 $vals[] = $val_item['name'] ?? $val_item['id'] ?? '';
                                                             }
                                                         }
                                                     }
                                                 ?>
                                                 <tr>
                                                     <td style="vertical-align: middle;"><strong><?= _ent($attr->attribute_name); ?></strong></td>
                                                     <td style="vertical-align: middle;"><span class="chip-id"><?= _ent($attr->tiktok_attribute_id); ?></span></td>
                                                     <td style="vertical-align: middle;"><?= _ent($attr->attribute_type ?: 'TEXT'); ?></td>
                                                     <td class="text-center" style="vertical-align: middle;"><?= $attr->is_required ? '<span class="label label-danger">Wajib</span>' : '<span class="label label-info">Opsional</span>'; ?></td>
                                                     <td style="vertical-align: middle;">
                                                         <?php if (!empty($vals)): ?>
                                                             <small style="color: #64748b;"><?= _ent(implode(', ', array_slice($vals, 0, 8))); ?><?= count($vals) > 8 ? ' ... (total ' . count($vals) . ')' : ''; ?></small>
                                                         <?php else: ?>
                                                             <span class="text-muted">Input bebas / dinamis</span>
                                                         <?php endif; ?>
                                                     </td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         <?php else: ?>
                                             <tr>
                                                 <td colspan="5" class="text-center text-muted" style="padding: 16px;">
                                                     <?php if (!empty($tiktok_categories->is_leaf)): ?>
                                                         Belum ada atribut tercatat untuk leaf kategori ini.
                                                     <?php else: ?>
                                                         Kategori ini bukan level <em>leaf</em> (memiliki sub-kategori). Atribut produk hanya tersedia pada level leaf kategori.
                                                     <?php endif; ?>
                                                 </td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar Kategori (Ctrl+x)" href="<?= site_url('administrator/tiktok_categories/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Kategori']); ?></a>
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
