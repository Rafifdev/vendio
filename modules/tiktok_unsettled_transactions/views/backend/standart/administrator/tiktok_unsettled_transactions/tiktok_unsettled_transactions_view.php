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
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Dana Tertahan <small>Detail Dana Tertahan</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_unsettled_transactions'); ?>">Dana Tertahan</a></li>
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
                     <h3 class="widget-user-username">Dana Tertahan</h3>
                     <h5 class="widget-user-desc">Detail Pesanan Belum Settle / Dana Tertahan</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_tiktok_unsettled_transactions" id="form_tiktok_unsettled_transactions" >
                   
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Nama Toko </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php if ($tiktok_unsettled_transactions->tiktok_shop_id): ?>
                              <?= anchor('administrator/tiktok_shops/view/'.$tiktok_unsettled_transactions->tiktok_shop_id.'?popup=show', $tiktok_unsettled_transactions->tiktok_shops_shop_name ?: 'Toko #'.$tiktok_unsettled_transactions->tiktok_shop_id, ['class' => 'popup-view']); ?>
                           <?php else: ?>
                              -
                           <?php endif; ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">ID Pesanan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php 
                           $ord = !empty($tiktok_unsettled_transactions->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_unsettled_transactions->order_id])->row() : null;
                           if ($ord): ?>
                              <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" style="color: #3c8dbc; font-size: 14px;"><i class="fa fa-external-link"></i> <?= _ent($tiktok_unsettled_transactions->order_id); ?></a>
                           <?php else: ?>
                              <a href="<?= site_url('administrator/tiktok_orders?f=order_id&q=' . $tiktok_unsettled_transactions->order_id); ?>" style="color: #3c8dbc;"><i class="fa fa-search"></i> <?= _ent($tiktok_unsettled_transactions->order_id ?: '-'); ?></a>
                           <?php endif; ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Status Settlement </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php 
                           $status = strtoupper($tiktok_unsettled_transactions->settlement_status);
                           if ($status == 'SETTLED' || $status == 'PAID' || $status == 'SUCCESS') {
                              echo '<span class="label label-success">Selesai / Settle</span>';
                           } elseif ($status == 'CANCELLED' || $status == 'FAILED') {
                              echo '<span class="label label-danger">Dibatalkan</span>';
                           } else {
                              echo '<span class="label label-warning">Belum Settle</span>';
                           }
                           ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Estimasi Dana Bersih Cair </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?> <?= number_format($tiktok_unsettled_transactions->estimated_settlement_amount, 0, ',', '.'); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Mata Uang </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Waktu Pesanan Dibuat </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_unsettled_transactions->order_created_time ? date('d F Y - H:i:s', strtotime($tiktok_unsettled_transactions->order_created_time)) : '-'; ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Terakhir Disinkron </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_unsettled_transactions->synced_at ? date('d F Y - H:i:s', strtotime($tiktok_unsettled_transactions->synced_at)) : '-'; ?>
                        </div>
                     </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_unsettled_transactions/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Dana Tertahan']); ?></a>
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
