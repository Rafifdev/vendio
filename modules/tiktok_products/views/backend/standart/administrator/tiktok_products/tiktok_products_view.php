
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
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Katalog Produk      <small><?= cclang('detail', ['Katalog Produk']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/tiktok_products'); ?>">Katalog Produk</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Katalog Produk</h3>
                     <h5 class="widget-user-desc">Detail Katalog Produk</h5>
                     <hr>
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

                  <div class="form-horizontal" name="form_tiktok_products" id="form_tiktok_products" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">ID </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Toko </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->tiktok_shops_shop_name); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">ID Produk TikTok </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->product_id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Nama Produk </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->title); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Foto Utama Produk </label>

                        <div class="col-sm-8">
                           <?php if (!empty($tiktok_products->main_image)): ?>
                             <?php if (strpos($tiktok_products->main_image, 'http://') === 0 || strpos($tiktok_products->main_image, 'https://') === 0): ?>
                               <a class="fancybox" rel="group" href="<?= $tiktok_products->main_image; ?>">
                                 <img src="<?= $tiktok_products->main_image; ?>" class="image-responsive" alt="image tiktok_products" title="main_image tiktok_products" width="100px">
                               </a>
                             <?php elseif (is_image($tiktok_products->main_image)): ?>
                               <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/tiktok_products/' . $tiktok_products->main_image; ?>">
                                 <img src="<?= BASE_URL . 'uploads/tiktok_products/' . $tiktok_products->main_image; ?>" class="image-responsive" alt="image tiktok_products" title="main_image tiktok_products" width="100px">
                               </a>
                             <?php else: ?>
                               <label>
                                 <a href="<?= BASE_URL . 'administrator/file/download/tiktok_products/' . $tiktok_products->main_image; ?>">
                                  <img src="<?= get_icon_file($tiktok_products->main_image); ?>" class="image-responsive" alt="image tiktok_products" title="main_image <?= $tiktok_products->main_image; ?>" width="40px"> 
                                <?= $tiktok_products->main_image ?>
                               </a>
                               </label>
                             <?php endif; ?>
                           <?php endif; ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Status Produk </label>

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

                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Platform Penjualan </label>

                        <div class="col-sm-8">
                           <?php
                           $platforms = !empty($tiktok_products->listing_platforms) ? explode(',', $tiktok_products->listing_platforms) : ['TIKTOK_SHOP', 'TOKOPEDIA'];
                           if (in_array('TIKTOK_SHOP', $platforms)) {
                               echo '<span class="label" style="background-color: #000; color: #fff; margin-right: 5px; padding: 4px 8px; font-weight: 500;"><i class="fa fa-music"></i> TikTok Shop</span> ';
                           }
                           if (in_array('TOKOPEDIA', $platforms)) {
                               echo '<span class="label" style="background-color: #42b549; color: #fff; padding: 4px 8px; font-weight: 500;"><i class="fa fa-shopping-bag"></i> Tokopedia</span>';
                           }
                           ?>
                        </div>
                    </div>

                    <?php if ($status == 'FAILED' && !empty($tiktok_products->reject_reason)): ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-danger">Alasan Penolakan </label>
                        <div class="col-sm-8">
                           <div class="callout callout-danger" style="margin-bottom: 0;">
                              <h4><i class="icon fa fa-ban"></i> Produk Ditolak oleh Audit TikTok Shop</h4>
                              <p><?= nl2br(_ent($tiktok_products->reject_reason)); ?></p>
                           </div>
                        </div>
                    </div>
                    <?php endif; ?>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Kategori Produk </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->category_name); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Merek / Brand </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->brand_name); ?>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Total Stok </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->total_stock); ?>
                        </div>
                    </div>

                    <?php if (!$has_variant): ?>
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">SKU Penjual </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->seller_sku); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Harga </label>

                        <div class="col-sm-8">
                           Rp <?= number_format($tiktok_products->price, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Mata Uang </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->currency); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Berat Paket </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->package_weight); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Deskripsi Produk </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->description); ?>
                        </div>
                    </div>

                    <?php if ($has_variant): ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Varian SKU </label>
                        <div class="col-sm-8">
                            <table class="table table-bordered table-striped" style="margin-top: 5px;">
                                <thead>
                                    <tr class="bg-gray">
                                        <th>ID SKU</th>
                                        <th>SKU Penjual</th>
                                        <th>Nama Varian</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($skus as $s): ?>
                                    <tr>
                                        <td><?= $s->sku_id; ?></td>
                                        <td><?= $s->seller_sku ?: '-'; ?></td>
                                        <td><?= $s->sku_name ?: '-'; ?></td>
                                        <td><?= $s->stock; ?></td>
                                        <td>Rp <?= number_format($s->price, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php endif; ?>
                                        
                    <br>
                    <br>

                    <!-- Sub-tabel Log Riwayat Sinkronisasi (Pola Varian SKU) -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Log Sinkronisasi </label>
                        <div class="col-sm-8">
                            <table class="table table-bordered table-striped" style="margin-top: 5px;">
                                <thead>
                                    <tr class="bg-gray">
                                        <th style="width: 170px;">Waktu</th>
                                        <th style="width: 130px;">Aksi</th>
                                        <th style="width: 100px; text-align: center;">Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sync_logs)): ?>
                                        <?php foreach ($sync_logs as $log): ?>
                                        <tr>
                                            <td><?= date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                                            <td><strong><?= _ent($log->action); ?></strong></td>
                                            <td style="text-align: center;">
                                                <?= $log->status == 'SUCCESS' 
                                                    ? '<span class="label label-success">Sukses</span>' 
                                                    : '<span class="label label-danger">Gagal</span>'; ?>
                                            </td>
                                            <td><?= _ent($log->response_message ?: '-'); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada riwayat aktivitas sinkronisasi untuk produk ini</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="view-nav">
                        <?php if (in_array($status, ['DEACTIVATED', 'SELLER_DEACTIVATED']) && intval($tiktok_products->total_stock) > 0): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-success btn_action" title="Aktifkan Produk di TikTok" href="<?= site_url('administrator/tiktok_products/activate/'.$tiktok_products->id); ?>"><i class="fa fa-play"></i> Aktifkan Produk</a>
                           <?php }) ?>
                        <?php elseif (in_array($status, ['ACTIVATE', 'LIVE'])): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-warning btn_action" title="Nonaktifkan Produk dari TikTok" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan produk ini dari etalase TikTok?');" href="<?= site_url('administrator/tiktok_products/deactivate/'.$tiktok_products->id); ?>"><i class="fa fa-pause"></i> Nonaktifkan Produk</a>
                           <?php }) ?>
                        <?php endif; ?>

                        <?php if ($status != 'FREEZE'): ?>
                           <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                           <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit tiktok_products (Ctrl+e)" href="<?= site_url('administrator/tiktok_products/edit/'.$tiktok_products->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Tiktok Products']); ?> </a>
                           <?php }) ?>
                        <?php endif; ?>

                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_products/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Tiktok Products']); ?></a>
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
