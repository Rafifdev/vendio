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
.box-unsettled-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-unsettled-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-unsettled-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-unsettled-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-unsettled-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-unsettled-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-unsettled-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-unsettled-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-unsettled-view .form-group:last-child {
   border-bottom: none;
}

.box-unsettled-view .form-group:hover {
   background-color: #fafbfc;
}

.box-unsettled-view .form-group .control-label {
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

.box-unsettled-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-unsettled-view .chip-id {
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
.box-unsettled-view .view-nav {
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

.box-unsettled-view .view-nav .btn {
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
   <div class="row">
      <div class="col-md-12">
         <div class="box box-unsettled-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Dana Tertahan</h3>
                        <h5 class="widget-user-desc">Detail Pesanan Belum Settle / Dana Tertahan</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_unsettled_transactions" id="form_tiktok_unsettled_transactions">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Toko</label>
                         <div class="col-sm-8">
                            <?php if ($tiktok_unsettled_transactions->tiktok_shop_id): ?>
                               <strong style="color: #1e293b;"><?= _ent($tiktok_unsettled_transactions->tiktok_shops_shop_name ?: 'Toko #'.$tiktok_unsettled_transactions->tiktok_shop_id); ?></strong>
                            <?php else: ?>
                               <span class="text-muted">-</span>
                            <?php endif; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Pesanan</label>
                         <div class="col-sm-8">
                            <?php 
                            $ord = !empty($tiktok_unsettled_transactions->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_unsettled_transactions->order_id])->row() : null;
                            if ($ord): ?>
                               <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" class="chip-id" style="color: #0284c7; text-decoration: none;"><i class="fa fa-external-link"></i> <?= _ent($tiktok_unsettled_transactions->order_id); ?></a>
                            <?php else: ?>
                               <a href="<?= site_url('administrator/tiktok_orders?f=order_id&q=' . $tiktok_unsettled_transactions->order_id); ?>" class="chip-id" style="color: #0284c7; text-decoration: none;"><i class="fa fa-search"></i> <?= _ent($tiktok_unsettled_transactions->order_id ?: '-'); ?></a>
                            <?php endif; ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Status Settlement</label>
                         <div class="col-sm-8">
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
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Estimasi Dana Bersih Cair</label>
                         <div class="col-sm-8">
                            <strong style="color: #059669; font-size: 15px;"><?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?> <?= number_format($tiktok_unsettled_transactions->estimated_settlement_amount, 0, ',', '.'); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Mata Uang</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Waktu Pesanan Dibuat</label>
                         <div class="col-sm-8">
                            <?= $tiktok_unsettled_transactions->order_created_time ? date('d F Y - H:i:s', strtotime($tiktok_unsettled_transactions->order_created_time)) : '-'; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Terakhir Disinkron</label>
                         <div class="col-sm-8">
                            <?= $tiktok_unsettled_transactions->synced_at ? date('d F Y - H:i:s', strtotime($tiktok_unsettled_transactions->synced_at)) : '-'; ?>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali (Ctrl+x)" href="<?= site_url('administrator/tiktok_unsettled_transactions/'); ?>"><i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Dana Tertahan']); ?></a>
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
