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
.box-finance-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-finance-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-finance-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-finance-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-finance-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-finance-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-finance-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-finance-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-finance-view .form-group:last-child {
   border-bottom: none;
}

.box-finance-view .form-group:hover {
   background-color: #fafbfc;
}

.box-finance-view .form-group .control-label {
   width: 200px !important;
   min-width: 200px !important;
   flex-shrink: 0 !important;
   text-align: left !important;
   color: #64748b !important;
   font-weight: 600 !important;
   font-size: 13px !important;
   padding: 0 !important;
   margin: 0 !important;
   line-height: 1.6 !important;
}

.box-finance-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-finance-view .chip-id {
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
.box-finance-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 950px;
}

.box-finance-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-finance-view .sub-table thead th {
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

.box-finance-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-finance-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-finance-view .view-nav {
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

.box-finance-view .view-nav .btn {
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
      Penghasilan Toko <small><?= cclang('detail', ['Penghasilan Toko']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_finance'); ?>">Penghasilan Toko</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-finance-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Rincian Statement Penghasilan Toko</h3>
                        <h5 class="widget-user-desc">ID Statement: <?= _ent($tiktok_finance->statement_id); ?></h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_finance" id="form_tiktok_finance">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">Toko TikTok</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_finance->tiktok_shops_shop_name ?: '-'); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Statement</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_finance->statement_id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Waktu Statement</label>
                         <div class="col-sm-8">
                            <?= $tiktok_finance->statement_time ? date('d F Y - H:i:s', strtotime($tiktok_finance->statement_time)) : '-'; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Pencairan</label>
                         <div class="col-sm-8">
                            <?php if (!empty($tiktok_finance->payout_id)): ?>
                               <span class="chip-id"><?= _ent($tiktok_finance->payout_id); ?></span>
                            <?php else: ?>
                               <span class="text-muted">-</span>
                            <?php endif; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Status Pembayaran</label>
                         <div class="col-sm-8">
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
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Total Dana Dicairkan</label>
                         <div class="col-sm-8">
                            <strong style="color: #059669; font-size: 15px;">Rp <?= number_format($tiktok_finance->settlement_amount, 0, ',', '.'); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Omzet Kotor</label>
                         <div class="col-sm-8">
                            Rp <?= number_format($tiktok_finance->revenue_amount, 0, ',', '.'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Biaya Pengiriman</label>
                         <div class="col-sm-8">
                            Rp <?= number_format($tiktok_finance->shipping_fee_amount, 0, ',', '.'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Biaya Komisi Platform</label>
                         <div class="col-sm-8">
                            Rp <?= number_format($tiktok_finance->fee_amount, 0, ',', '.'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Penyesuaian</label>
                         <div class="col-sm-8">
                            Rp <?= number_format($tiktok_finance->adjustment_amount, 0, ',', '.'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Mata Uang</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_finance->currency ?: 'IDR'); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Terakhir Diperbarui</label>
                         <div class="col-sm-8">
                            <?= $tiktok_finance->updated_at ? date('d F Y - H:i:s', strtotime($tiktok_finance->updated_at)) : '-'; ?>
                         </div>
                     </div>

                     <!-- Sub-tabel Rincian Transaksi Pesanan -->
                     <div class="form-group">
                         <label class="control-label">Rincian Transaksi Pesanan</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th style="width: 40px; text-align: center;">No</th>
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
                                                     <td style="text-align: center; vertical-align: middle; color: #64748b; font-size: 12px;"><?= $no++; ?></td>
                                                     <td style="vertical-align: middle;">
                                                         <?php 
                                                         $ord = !empty($tx->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tx->order_id])->row() : null;
                                                         if ($ord): ?>
                                                             <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" class="chip-id" style="color: #0284c7; text-decoration: none;"><i class="fa fa-external-link"></i> <?= _ent($tx->order_id); ?></a>
                                                         <?php else: ?>
                                                             <span class="chip-id"><?= _ent($tx->order_id ?: '-'); ?></span>
                                                         <?php endif; ?>
                                                     </td>
                                                     <td style="vertical-align: middle;">
                                                         <?php
                                                         $type = strtoupper($tx->transaction_type);
                                                         if ($type == 'ORDER' || $type == 'PAYMENT') {
                                                             echo '<span class="label label-success">Pesanan</span>';
                                                         } elseif ($type == 'REFUND') {
                                                             echo '<span class="label label-danger">Pengembalian / Refund</span>';
                                                         } elseif ($type == 'ADJUSTMENT') {
                                                             echo '<span class="label label-warning">Penyesuaian</span>';
                                                         } else {
                                                             echo '<span class="label label-info">' . _ent($tx->transaction_type ?: '-') . '</span>';
                                                         }
                                                         ?>
                                                     </td>
                                                     <td style="vertical-align: middle;">Rp <?= number_format($tx->order_amount, 0, ',', '.'); ?></td>
                                                     <td style="vertical-align: middle;">Rp <?= number_format($tx->shipping_fee, 0, ',', '.'); ?></td>
                                                     <td style="vertical-align: middle;">Rp <?= number_format($tx->platform_fee, 0, ',', '.'); ?></td>
                                                     <td style="vertical-align: middle; font-weight: 600; color: #059669;">Rp <?= number_format($tx->settlement_amount, 0, ',', '.'); ?></td>
                                                     <td style="vertical-align: middle; font-size: 12px; color: #64748b;"><?= $tx->paid_time ? date('d/m/Y H:i', strtotime($tx->paid_time)) : '-'; ?></td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         <?php else: ?>
                                             <tr>
                                                 <td colspan="8" class="text-center text-muted" style="padding: 16px;">Belum ada rincian transaksi untuk statement ini.</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali (Ctrl+x)" href="<?= site_url('administrator/tiktok_finance/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Penghasilan Toko']); ?></a>
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
