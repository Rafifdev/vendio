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
      Penghasilan Toko <small><?= cclang('detail', ['Penghasilan Toko']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_finance'); ?>">Penghasilan Toko</a></li>
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
                     <h3 class="widget-user-username">Rincian Statement Penghasilan Toko</h3>
                     <h5 class="widget-user-desc">ID Statement: <?= _ent($tiktok_finance->statement_id); ?></h5>
                     <hr>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_finance" id="form_tiktok_finance" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Toko TikTok </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_finance->tiktok_shops_shop_name ?: '-'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">ID Statement </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_finance->statement_id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Waktu Statement </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_finance->statement_time ? date('d F Y - H:i:s', strtotime($tiktok_finance->statement_time)) : '-'; ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">ID Pencairan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_finance->payout_id ?: '-'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Status Pembayaran </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php 
                           $status = strtoupper($tiktok_finance->payment_status);
                           if ($status == 'PAID' || $status == 'COMPLETED' || $status == 'SUCCESS') {
                              echo '<span class="label label-success">' . $status . '</span>';
                           } elseif ($status == 'FAILED' || $status == 'CANCELLED') {
                              echo '<span class="label label-danger">' . $status . '</span>';
                           } else {
                              echo '<span class="label label-warning">' . $status . '</span>';
                           }
                           ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Total Dana Dicairkan </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           Rp <?= number_format($tiktok_finance->settlement_amount, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Omzet Kotor </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           Rp <?= number_format($tiktok_finance->revenue_amount, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Biaya Pengiriman </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           Rp <?= number_format($tiktok_finance->shipping_fee_amount, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Biaya Komisi Platform </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           Rp <?= number_format($tiktok_finance->fee_amount, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Penyesuaian </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           Rp <?= number_format($tiktok_finance->adjustment_amount, 0, ',', '.'); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Mata Uang </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_finance->currency ?: 'IDR'); ?>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="content" class="col-sm-3 control-label">Terakhir Diperbarui </label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= $tiktok_finance->updated_at ? date('d F Y - H:i:s', strtotime($tiktok_finance->updated_at)) : '-'; ?>
                        </div>
                    </div>
                     <div class="form-group">
                         <label class="col-sm-3 control-label">Rincian Transaksi Pesanan </label>
                         <div class="col-sm-8">
                             <table class="table table-bordered table-striped" style="margin-top: 5px;">
                                 <thead>
                                     <tr class="bg-gray">
                                         <th width="40" class="text-center">No</th>
                                         <th>ID Pesanan</th>
                                         <th>Tipe Transaksi</th>
                                         <th>Nilai Pesanan</th>
                                         <th>Biaya Ongkir</th>
                                         <th>Komisi Platform</th>
                                         <th>Dana Bersih Cair</th>
                                         <th>Waktu Pembayaran</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php if (!empty($statement_transactions)): ?>
                                         <?php $no = 1; foreach ($statement_transactions as $tx): ?>
                                             <tr>
                                                 <td class="text-center" style="vertical-align: middle;"><?= $no++; ?></td>
                                                 <td style="vertical-align: middle;">
                                                     <?php 
                                                     $ord = !empty($tx->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tx->order_id])->row() : null;
                                                     if ($ord): ?>
                                                         <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" style="color: #3c8dbc;"><?= _ent($tx->order_id); ?></a>
                                                     <?php else: ?>
                                                         <span style="color: #3c8dbc;"><?= _ent($tx->order_id ?: '-'); ?></span>
                                                     <?php endif; ?>
                                                 </td>
                                                 <td style="vertical-align: middle;">
                                                     <?php
                                                     $type = strtoupper($tx->transaction_type);
                                                     if ($type == 'ORDER' || $type == 'PAYMENT') {
                                                         echo '<span class=\"label label-success\">Pesanan</span>';
                                                     } elseif ($type == 'REFUND') {
                                                         echo '<span class=\"label label-danger\">Pengembalian / Refund</span>';
                                                     } elseif ($type == 'ADJUSTMENT') {
                                                         echo '<span class=\"label label-warning\">Penyesuaian</span>';
                                                     } else {
                                                         echo '<span class=\"label label-info\">' . _ent($tx->transaction_type ?: '-') . '</span>';
                                                     }
                                                     ?>
                                                 </td>
                                                 <td style="vertical-align: middle;">Rp <?= number_format($tx->order_amount, 0, ',', '.'); ?></td>
                                                 <td style="vertical-align: middle;">Rp <?= number_format($tx->shipping_fee, 0, ',', '.'); ?></td>
                                                 <td style="vertical-align: middle;">Rp <?= number_format($tx->platform_fee, 0, ',', '.'); ?></td>
                                                 <td style="vertical-align: middle; font-weight: bold;">Rp <?= number_format($tx->settlement_amount, 0, ',', '.'); ?></td>
                                                 <td style="vertical-align: middle;"><?= $tx->paid_time ? date('d/m/Y H:i', strtotime($tx->paid_time)) : '-'; ?></td>
                                             </tr>
                                         <?php endforeach; ?>
                                     <?php else: ?>
                                         <tr>
                                             <td colspan="8" class="text-center text-muted">Belum ada rincian transaksi untuk statement ini.</td>
                                         </tr>
                                     <?php endif; ?>
                                 </tbody>
                             </table>
                         </div>
                     </div>

                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_finance/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_list_button', ['Penghasilan Toko']); ?></a>
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
