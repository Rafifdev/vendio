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
.box-warehouse-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-warehouse-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-warehouse-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-warehouse-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-warehouse-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-warehouse-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-warehouse-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-warehouse-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-warehouse-view .form-group:last-child {
   border-bottom: none;
}

.box-warehouse-view .form-group:hover {
   background-color: #fafbfc;
}

.box-warehouse-view .form-group .control-label {
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

.box-warehouse-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-warehouse-view .chip-id {
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
.box-warehouse-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 850px;
}

.box-warehouse-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-warehouse-view .sub-table thead th {
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

.box-warehouse-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-warehouse-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-warehouse-view .view-nav {
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

.box-warehouse-view .view-nav .btn {
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
      Daftar Gudang <small><?= cclang('detail', ['Daftar Gudang']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_warehouses'); ?>">Daftar Gudang</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-warehouse-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Daftar Gudang</h3>
                        <h5 class="widget-user-desc">Detail Daftar Gudang</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_warehouses" id="form_tiktok_warehouses">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">ID</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_warehouses->id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Gudang</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_warehouses->name); ?></strong>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Gudang TikTok</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_warehouses->tiktok_warehouse_id); ?></span>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Tipe Gudang</label>
                         <div class="col-sm-8">
                            <?php 
                               if ($tiktok_warehouses->warehouse_type == "SALES_WAREHOUSE") {
                                  echo "Gudang Penjualan";
                               } elseif ($tiktok_warehouses->warehouse_type == "RETURN_WAREHOUSE") {
                                  echo "Gudang Retur";
                               } else {
                                  echo _ent($tiktok_warehouses->warehouse_type);
                               }
                            ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Alamat Gudang</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_warehouses->address ?: "-"); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Gudang Utama</label>
                         <div class="col-sm-8">
                            <?= $tiktok_warehouses->is_default ? '<span class="label label-primary">Ya (Utama)</span>' : 'Tidak'; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Status</label>
                         <div class="col-sm-8">
                            <?= in_array(strtoupper($tiktok_warehouses->effect_status), ["ENABLED", "EFFECTIVE"]) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Non-Aktif</span>'; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Toko</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_warehouses->shop_id); ?></span>
                         </div>
                     </div>

                     <div class="form-group">
                         <label class="control-label">Opsi Pengiriman</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th>Opsi Pengiriman</th>
                                             <th>Cakupan</th>
                                             <th>Kurir Logistik</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php if (!empty($tiktok_warehouses->delivery_options)): ?>
                                             <?php foreach ($tiktok_warehouses->delivery_options as $dopt): ?>
                                                 <tr>
                                                     <td>
                                                         <strong><?= _ent($dopt->name); ?></strong><br>
                                                         <small class="text-muted">ID: <?= _ent($dopt->tiktok_delivery_option_id); ?></small>
                                                     </td>
                                                     <td><?= _ent($dopt->scope ?: "-"); ?></td>
                                                     <td>
                                                         <?php if (!empty($dopt->shipping_providers)): ?>
                                                             <ul style="padding-left: 18px; margin-bottom: 0;">
                                                                 <?php foreach ($dopt->shipping_providers as $sp): ?>
                                                                     <li><?= _ent($sp->name); ?> <small class="text-muted">(ID: <?= _ent($sp->tiktok_provider_id); ?>)</small></li>
                                                                 <?php endforeach; ?>
                                                             </ul>
                                                         <?php else: ?>
                                                             <em class="text-muted">Tidak ada kurir terdaftar</em>
                                                         <?php endif; ?>
                                                     </td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         <?php else: ?>
                                             <tr>
                                                 <td colspan="3" class="text-center text-muted">Belum ada data opsi pengiriman. Klik "Tarik Data Gudang" untuk memperbarui.</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar Gudang (Ctrl+x)" href="<?= site_url('administrator/tiktok_warehouses/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Gudang']); ?></a>
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
