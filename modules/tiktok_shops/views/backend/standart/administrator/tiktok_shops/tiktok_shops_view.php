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
.box-shop-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-shop-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-shop-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-shop-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-shop-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-shop-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-shop-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-shop-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-shop-view .form-group:last-child {
   border-bottom: none;
}

.box-shop-view .form-group:hover {
   background-color: #fafbfc;
}

.box-shop-view .form-group .control-label {
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

.box-shop-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-shop-view .chip-id {
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
.box-shop-view .view-nav {
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

.box-shop-view .view-nav .btn {
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
      Akun Toko <small><?= cclang('detail', ['Akun Toko']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_shops'); ?>">Akun Toko</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-shop-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Akun Toko</h3>
                        <h5 class="widget-user-desc">Detail Akun Toko</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_shops" id="form_tiktok_shops">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">ID Toko</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_shops->shop_id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Toko</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_shops->shop_name); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Kode Toko</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->shop_code ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Shop Cipher</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569; word-break: break-all;"><?= _ent($tiktok_shops->shop_cipher ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Tipe Penjual</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->seller_type ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Region Penjual</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->seller_base_region ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Penjual</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->seller_name ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Open ID</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569;"><?= _ent($tiktok_shops->open_id ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">App Key Partner</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569;"><?= _ent($tiktok_shops->app_key ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">App Secret Partner</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569;"><?= _ent($tiktok_shops->app_secret ? substr($tiktok_shops->app_secret, 0, 6) . '*****************' : '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Kode Otorisasi (Auth Code)</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569; word-break: break-all;"><?= _ent($tiktok_shops->auth_code ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Access Token</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569; word-break: break-all;"><?= _ent($tiktok_shops->access_token ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Masa Aktif Token</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->access_token_expire_in ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Refresh Token</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 12px; color: #475569; word-break: break-all;"><?= _ent($tiktok_shops->refresh_token ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Masa Aktif Refresh Token</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_shops->refresh_token_expire_in ?: '-'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Status Toko</label>
                         <div class="col-sm-8">
                            <?= $tiktok_shops->is_active == '1' ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Nonaktif</span>'; ?>
                         </div>
                     </div>

                     <div class="view-nav">
                         <?php is_allowed('tiktok_shops_update', function() use ($tiktok_shops){?>
                         <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="Edit Akun Toko (Ctrl+e)" href="<?= site_url('administrator/tiktok_shops/edit/'.$tiktok_shops->id); ?>"><i class="fa fa-edit"></i> <?= cclang('update', ['Tiktok Shops']); ?></a>
                         <?php }) ?>
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali (Ctrl+x)" href="<?= site_url('administrator/tiktok_shops/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Tiktok Shops']); ?></a>
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
