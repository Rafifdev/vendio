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
.box-product-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-product-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-product-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-product-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-product-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-product-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-product-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-product-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-product-view .form-group:last-child {
   border-bottom: none;
}

.box-product-view .form-group:hover {
   background-color: #fafbfc;
}

.box-product-view .form-group .control-label {
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

.box-product-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-product-view .chip-id {
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

/* Product Thumbnail */
.box-product-view .product-thumb-view {
   width: 80px;
   height: 80px;
   object-fit: cover;
   border-radius: 8px;
   border: 1px solid #e2e8f0;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
   display: inline-block;
}

/* Modern Sub Tables for Variants & Logs */
.box-product-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 850px;
}

.box-product-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-product-view .sub-table thead th {
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

.box-product-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-product-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-product-view .view-nav {
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

.box-product-view .view-nav .btn {
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
      Katalog Produk <small><?= cclang('detail', ['Katalog Produk']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_products'); ?>">Katalog Produk</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-product-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Katalog Produk</h3>
                        <h5 class="widget-user-desc">Detail Katalog Produk</h5>
                     </div>
                  </div>

                  <?php
                  $skus = $this->db->group_start()
                              ->where('tiktok_product_id', $tiktok_products->id)
                              ->or_where('product_id', $tiktok_products->product_id)
                              ->group_end()
                              ->get('tiktok_product_skus')
                              ->result();
                  $has_variant = !empty($skus);
                  ?>

                  <div class="form-horizontal" name="form_tiktok_products" id="form_tiktok_products">
                   
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600; color: #475569;"><?= _ent($tiktok_products->id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Toko</label>
                        <div class="col-sm-8">
                           <?php if ($tiktok_products->tiktok_shop_id): ?>
                              <span style="font-weight: 600; color: #0284c7;">
                                 <i class="fa fa-shopping-bag" style="color: #64748b; font-size: 12px; margin-right: 6px;"></i><?= _ent($tiktok_products->tiktok_shops_shop_name ?: 'Toko #' . $tiktok_products->tiktok_shop_id); ?>
                              </span>
                           <?php else: ?>
                              <span class="text-muted">-</span>
                           <?php endif; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID Produk TikTok</label>
                        <div class="col-sm-8">
                           <span class="chip-id"><?= _ent($tiktok_products->product_id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nama Produk</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600; color: #0f172a; font-size: 14px;"><?= _ent($tiktok_products->title); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Foto Utama Produk</label>
                        <div class="col-sm-8">
                           <?php if (!empty($tiktok_products->main_image)): ?>
                              <?php if (strpos($tiktok_products->main_image, 'http://') === 0 || strpos($tiktok_products->main_image, 'https://') === 0): ?>
                                 <a class="fancybox" rel="group" href="<?= $tiktok_products->main_image; ?>">
                                    <img src="<?= $tiktok_products->main_image; ?>" class="product-thumb-view" alt="image tiktok_products">
                                 </a>
                              <?php elseif (is_image($tiktok_products->main_image)): ?>
                                 <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/tiktok_products/' . $tiktok_products->main_image; ?>">
                                    <img src="<?= BASE_URL . 'uploads/tiktok_products/' . $tiktok_products->main_image; ?>" class="product-thumb-view" alt="image tiktok_products">
                                 </a>
                              <?php else: ?>
                                 <a href="<?= BASE_URL . 'administrator/file/download/tiktok_products/' . $tiktok_products->main_image; ?>" style="display: inline-flex; align-items: center; gap: 8px;">
                                    <img src="<?= get_icon_file($tiktok_products->main_image); ?>" width="32px" alt="file">
                                    <span><?= $tiktok_products->main_image ?></span>
                                 </a>
                              <?php endif; ?>
                           <?php else: ?>
                              <span class="text-muted" style="font-style: italic;">Tidak ada foto</span>
                           <?php endif; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Status Produk</label>
                        <div class="col-sm-8">
                           <?php
                           $status = strtoupper(trim((string)$tiktok_products->status));
                           switch ($status) {
                              case 'ACTIVATE':
                              case 'LIVE':
                                 echo '<span class="label label-success">Aktif</span>';
                                 break;
                              case 'PENDING':
                                 echo '<span class="label label-warning">Menunggu Review</span>';
                                 break;
                              case 'DRAFT':
                                 echo '<span class="label label-info">Draft</span>';
                                 break;
                              case 'DEACTIVATED':
                              case 'SELLER_DEACTIVATED':
                                 echo '<span class="label label-warning">Nonaktif</span>';
                                 break;
                              case 'FAILED':
                              case 'PLATFORM_DEACTIVATED':
                                 echo '<span class="label label-danger">Ditolak</span>';
                                 break;
                              case 'FREEZE':
                                 echo '<span class="label label-danger">Dibekukan</span>';
                                 break;
                              case 'DELETED':
                                 echo '<span class="label label-danger">Dihapus</span>';
                                 break;
                              default:
                                 echo '<span class="label label-info">' . _ent($tiktok_products->status) . '</span>';
                           }
                           ?>
                        </div>
                     </div>

                     <?php if ($status == 'FAILED' && !empty($tiktok_products->reject_reason)): ?>
                     <div class="form-group">
                        <label class="col-sm-2 control-label text-danger">Alasan Penolakan</label>
                        <div class="col-sm-8">
                           <div class="callout callout-danger" style="margin-bottom: 0;">
                              <h4><i class="icon fa fa-ban"></i> Produk Ditolak oleh Audit TikTok Shop</h4>
                              <p><?= nl2br(_ent($tiktok_products->reject_reason)); ?></p>
                           </div>
                        </div>
                     </div>
                     <?php endif; ?>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Kategori Produk</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->category_name ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Merek / Brand</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->brand_name ?: '-'); ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Total Stok</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600;"><?= number_format($tiktok_products->total_stock, 0, ',', '.'); ?></span>
                        </div>
                     </div>

                     <?php if (!$has_variant): ?>
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">SKU Penjual</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->seller_sku ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Harga</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600; color: #1e293b;">Rp <?= number_format($tiktok_products->price, 0, ',', '.'); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Mata Uang</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->currency ?: 'IDR'); ?>
                        </div>
                     </div>
                     <?php endif; ?>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Berat Paket</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->package_weight ?: '0'); ?> gram
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Deskripsi Produk</label>
                        <div class="col-sm-8" style="color: #475569; line-height: 1.6; max-width: 800px;">
                           <?= nl2br(_ent($tiktok_products->description ?: '-')); ?>
                        </div>
                     </div>

                     <?php if ($has_variant): ?>
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Varian SKU</label>
                        <div class="col-sm-8">
                           <div class="sub-table-wrapper">
                              <table class="table sub-table">
                                 <thead>
                                    <tr>
                                       <th style="width: 170px;">ID SKU</th>
                                       <th style="width: 140px;">SKU Penjual</th>
                                       <th>Nama Varian</th>
                                       <th style="width: 80px; text-align: center;">Stok</th>
                                       <th style="width: 130px; text-align: right;">Harga</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php foreach ($skus as $s): ?>
                                    <tr>
                                       <td><span class="chip-id"><?= $s->sku_id; ?></span></td>
                                       <td><?= _ent($s->seller_sku ?: '-'); ?></td>
                                       <td><strong style="color: #1e293b;"><?= _ent($s->sku_name ?: '-'); ?></strong></td>
                                       <td style="text-align: center; font-weight: 600;"><?= number_format($s->stock, 0, ',', '.'); ?></td>
                                       <td style="text-align: right; font-weight: 600; color: #1e293b;">Rp <?= number_format($s->price, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     <?php endif; ?>

                     <!-- Sub-tabel Log Riwayat Sinkronisasi -->
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Log Sinkronisasi</label>
                        <div class="col-sm-8">
                           <div class="sub-table-wrapper">
                              <table class="table sub-table">
                                 <thead>
                                    <tr>
                                       <th style="width: 160px;">Waktu</th>
                                       <th style="width: 120px;">Aksi</th>
                                       <th style="width: 90px; text-align: center;">Status</th>
                                       <th>Keterangan</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!empty($sync_logs)): ?>
                                       <?php foreach ($sync_logs as $log): ?>
                                       <tr>
                                          <td style="color: #64748b; font-size: 12.5px;"><?= date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                          <td><strong style="color: #1e293b;"><?= _ent($log->action); ?></strong></td>
                                          <td style="text-align: center;">
                                             <?= $log->status == 'SUCCESS' 
                                                ? '<span class="label label-success">Sukses</span>' 
                                                : '<span class="label label-danger">Gagal</span>'; ?>
                                          </td>
                                          <td style="color: #475569;"><?= _ent($log->response_message ?: '-'); ?></td>
                                       </tr>
                                       <?php endforeach; ?>
                                    <?php else: ?>
                                       <tr>
                                          <td colspan="4" class="text-center text-muted" style="padding: 20px; color: #94a3b8;">
                                             Belum ada riwayat aktivitas sinkronisasi untuk produk ini
                                          </td>
                                       </tr>
                                    <?php endif; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <!-- Footer Action Buttons (Same Colors, Clean Layout) -->
                     <div class="view-nav">
                        <?php if (in_array($status, ['DEACTIVATED', 'SELLER_DEACTIVATED']) && intval($tiktok_products->total_stock) > 0): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-success btn_action" title="Aktifkan Produk di TikTok" href="<?= site_url('administrator/tiktok_products/activate/'.$tiktok_products->id); ?>">
                              <i class="fa fa-play"></i> Aktifkan Produk
                           </a>
                           <?php }) ?>
                        <?php elseif (in_array($status, ['ACTIVATE', 'LIVE'])): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-warning btn_action" title="Nonaktifkan Produk dari TikTok" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan produk ini dari etalase TikTok?');" href="<?= site_url('administrator/tiktok_products/deactivate/'.$tiktok_products->id); ?>">
                              <i class="fa fa-pause"></i> Nonaktifkan Produk
                           </a>
                           <?php }) ?>
                        <?php endif; ?>

                        <?php if ($status != 'FREEZE'): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit tiktok_products (Ctrl+e)" href="<?= site_url('administrator/tiktok_products/edit/'.$tiktok_products->id); ?>">
                              <i class="fa fa-edit"></i> <?= cclang('update', ['Tiktok Products']); ?>
                           </a>
                           <?php }) ?>
                        <?php endif; ?>

                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_products/'); ?>">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Tiktok Products']); ?>
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
