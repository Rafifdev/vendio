
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
      Produk TikTok      <small><?= cclang('detail', ['Produk TikTok']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/tiktok_products'); ?>">Produk TikTok</a></li>
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
                     <h3 class="widget-user-username">Produk TikTok</h3>
                     <h5 class="widget-user-desc">Detail Produk TikTok</h5>
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
                        <label for="content" class="col-sm-2 control-label">Id </label>

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
                        <label for="content" class="col-sm-2 control-label">Product Id </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->product_id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Title </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->title); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Main Image </label>

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
                        <label for="content" class="col-sm-2 control-label">Status </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->status); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Category Name </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->category_name); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Brand Name </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->brand_name); ?>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Total Stock </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->total_stock); ?>
                        </div>
                    </div>

                    <?php if (!$has_variant): ?>
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Seller Sku </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->seller_sku); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Price </label>

                        <div class="col-sm-8">
                           Rp <?= number_format($tiktok_products->price, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Currency </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->currency); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Package Weight </label>

                        <div class="col-sm-8">
                           <?= _ent($tiktok_products->package_weight); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Description </label>

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
                                        <th>SKU ID</th>
                                        <th>Seller SKU</th>
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

                    <div class="view-nav">
                        <?php is_allowed('tiktok_products_update', function() use ($tiktok_products){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit tiktok_products (Ctrl+e)" href="<?= site_url('administrator/tiktok_products/edit/'.$tiktok_products->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update', ['Tiktok Products']); ?> </a>
                        <?php }) ?>
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
