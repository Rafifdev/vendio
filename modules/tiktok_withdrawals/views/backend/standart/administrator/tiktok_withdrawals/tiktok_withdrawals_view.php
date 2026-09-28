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
      Penarikan Dana <small>Detail Penarikan Dana</small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_withdrawals'); ?>">Penarikan Dana</a></li>
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
                     <h3 class="widget-user-username">Penarikan Dana</h3>
                     <h5 class="widget-user-desc">Detail Penarikan Dana ke Rekening Bank</h5>
                     <hr>
                  </div>

                 
                  <div class="form-horizontal" name="form_tiktok_withdrawals" id="form_tiktok_withdrawals" >
                   
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Nama Toko </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php if ($tiktok_withdrawals->tiktok_shop_id): ?>
                              <?= anchor('administrator/tiktok_shops/view/'.$tiktok_withdrawals->tiktok_shop_id.'?popup=show', $tiktok_withdrawals->tiktok_shops_shop_name ?: 'Toko #'.$tiktok_withdrawals->tiktok_shop_id, ['class' => 'popup-view']); ?>
                           <?php else: ?>
                              -
                           <?php endif; ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">ID Penarikan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_withdrawals->withdrawal_id); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Nominal Penarikan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_withdrawals->currency ?: 'IDR'); ?> <?= number_format($tiktok_withdrawals->amount, 0, ',', '.'); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Bank Tujuan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_withdrawals->bank_name ?: '-'); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Nomor Rekening </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_withdrawals->bank_account ?: '-'); ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Status </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php 
                           $status = strtoupper($tiktok_withdrawals->status);
                           if ($status == 'SUCCESS' || $status == 'PAID' || $status == 'SETTLED' || $status == 'COMPLETED') {
                              echo '<span class="label label-success">Selesai / Cair</span>';
                           } elseif ($status == 'FAILED' || $status == 'REJECTED' || $status == 'CANCELLED') {
                              echo '<span class="label label-danger">Gagal</span>';
                           } else {
                              echo '<span class="label label-warning">Diproses</span>';
                           }
                           ?>
                        </div>
                     </div>
                                          
                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Waktu Transfer </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_withdrawals->transfer_time ? date('d F Y - H:i:s', strtotime($tiktok_withdrawals->transfer_time)) : '-'; ?>
                        </div>
                     </div>

                     <div class="form-group ">
                        <label for="content" class="col-sm-2 control-label">Terakhir Diperbarui </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_withdrawals->updated_at ? date('d F Y - H:i:s', strtotime($tiktok_withdrawals->updated_at)) : '-'; ?>
                        </div>
                     </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_withdrawals/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Penarikan Dana']); ?></a>
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
