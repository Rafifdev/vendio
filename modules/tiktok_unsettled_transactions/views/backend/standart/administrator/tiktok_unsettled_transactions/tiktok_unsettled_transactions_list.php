<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+f', function assets() {
      $('#sbtn').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#reset').trigger('click');
      return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {
      $('#reset').trigger('click');
      return false;
   });
}

jQuery(document).ready(domo);
</script>

<!-- Refined Minimalist Styling (Tasteful, Balanced & Clean) -->
<style>
/* Main Card Wrapper */
.box-tiktok-unsettled {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
   }

/* Header with Generous & Balanced Spacing */
.box-tiktok-unsettled .widget-user-header {
   display: flex !important;
   align-items: center !important;
   justify-content: space-between !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   flex-wrap: wrap !important;
   gap: 16px !important;
}

.box-tiktok-unsettled .header-left {
   display: flex !important;
   align-items: center !important;
   gap: 20px !important;
}

.box-tiktok-unsettled .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-tiktok-unsettled .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-tiktok-unsettled .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-tiktok-unsettled .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-tiktok-unsettled .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
   display: flex !important;
   align-items: center !important;
   gap: 10px !important;
}

.box-tiktok-unsettled .widget-user-desc .label {
   font-size: 11px !important;
   padding: 3px 9px !important;
   border-radius: 12px !important;
   font-weight: 600 !important;
   margin-left: 2px !important;
}

/* Header Top Action Buttons */
.box-tiktok-unsettled .header-right {
   display: flex;
   align-items: center;
   gap: 8px;
   flex-wrap: wrap;
}

.box-tiktok-unsettled .btn-top-action {
   height: 34px !important;
   padding: 0 14px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   border-radius: 4px !important;
   background-color: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
   display: inline-flex !important;
   align-items: center !important;
   gap: 6px !important;
   transition: all 0.15s ease;
}

.box-tiktok-unsettled .btn-top-action:hover {
   background-color: #008d4c !important;
   box-shadow: 0 2px 6px rgba(0, 166, 90, 0.25);
}

/* Clean Table Styling */
.box-tiktok-unsettled .table-responsive {
   border: none;
   margin: 0;
   overflow: visible !important;
}



.box-tiktok-unsettled .table-minimal {
   table-layout: auto;
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-tiktok-unsettled .table-minimal thead th {
   background-color: #f8fafc;
   color: #64748b;
   font-size: 11px;
   font-weight: 700;
   text-transform: uppercase;
   letter-spacing: 0.04em;
   border-top: none;
   border-bottom: 2px solid #e2e8f0;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   vertical-align: middle;
}

.box-tiktok-unsettled .table-minimal tbody td {
   border-top: 1px solid #f1f5f9;
   border-bottom: none;
   border-left: none;
   border-right: none;
   padding: 10px 8px;
   font-size: 13px;
   color: #334155;
   vertical-align: middle;
}

.box-tiktok-unsettled .table-minimal tbody tr {
   position: relative;
   transition: background-color 0.15s ease;
}

.box-tiktok-unsettled .table-minimal tbody tr:hover {
   background-color: #fbfcfd;
}

/* Chips & Badges */
.chip-link {
   font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
   font-size: 12px;
   color: #0284c7;
   background-color: #f0f9ff;
   border: 1px solid #bae6fd;
   padding: 3px 8px;
   border-radius: 4px;
   display: inline-block;
   text-decoration: none !important;
   font-weight: 600;
}

.chip-link:hover {
   background-color: #e0f2fe;
   color: #0369a1;
}

/* Single Action Link */
.action-link {
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 5px 11px;
   font-size: 12px;
   font-weight: 500;
   color: #3b82f6;
   background-color: #eff6ff;
   border: 1px solid #bfdbfe;
   border-radius: 4px;
   text-decoration: none !important;
   transition: all 0.15s ease;
}

.action-link:hover {
   background-color: #dbeafe;
   color: #1d4ed8;
   border-color: #93c5fd;
}

/* Fixed Bottom Toolbar (Clean Footer Container) */
.box-footer-toolbar {
   display: flex;
   align-items: center;
   justify-content: space-between;
   padding: 14px 22px;
   background: #fafbfc;
   border-top: 1px solid #e9edf2;
   border-bottom-left-radius: 8px;
   border-bottom-right-radius: 8px;
   flex-wrap: wrap;
   gap: 12px;
}

.toolbar-controls-left {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 10px;
}

.filter-group {
   display: flex;
   align-items: center;
   gap: 6px;
   flex-wrap: wrap;
}

.box-footer-toolbar .form-control {
   height: 34px !important;
   border-radius: 4px !important;
   font-size: 13px !important;
   border: 1px solid #cbd5e1 !important;
   background-color: #ffffff !important;
   box-shadow: none !important;
   padding: 6px 10px !important;
}

.box-footer-toolbar .form-control:focus {
   border-color: #00a65a !important;
}

.box-footer-toolbar select.form-control,
.box-footer-toolbar select {
   -webkit-appearance: none !important;
   -moz-appearance: none !important;
   appearance: none !important;
   background-color: #ffffff !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
   background-repeat: no-repeat !important;
   background-position: right 14px center !important;
   background-size: 11px !important;
   padding-right: 34px !important;
   padding-left: 12px !important;
   cursor: pointer !important;
}

.box-footer-toolbar select.form-control:focus,
.box-footer-toolbar select:focus {
   border-color: #00a65a !important;
   background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2300a65a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") !important;
}

.box-footer-toolbar .btn-filter-submit {
   height: 34px !important;
   padding: 0 14px !important;
   border-radius: 4px !important;
   font-size: 12px !important;
   font-weight: 600 !important;
   background: #00a65a !important;
   border: 1px solid #008d4c !important;
   color: #ffffff !important;
}

.box-footer-toolbar .btn-filter-submit:hover {
   background: #008d4c !important;
}

.box-footer-toolbar .btn-reset {
   height: 34px !important;
   width: 34px !important;
   padding: 0 !important;
   display: inline-flex !important;
   align-items: center !important;
   justify-content: center !important;
   border-radius: 4px !important;
   background: #ffffff !important;
   border: 1px solid #cbd5e1 !important;
   color: #64748b !important;
}

.box-footer-toolbar .btn-reset:hover {
   background: #f1f5f9 !important;
   color: #334155 !important;
}

.toolbar-controls-right {
   display: flex;
   align-items: center;
}

.toolbar-controls-right .pagination {
   margin: 0 !important;
}

.toolbar-controls-right .pagination > li > a,
.toolbar-controls-right .pagination > li > span {
   border-radius: 4px !important;
   margin: 0 2px !important;
   padding: 6px 12px !important;
   font-size: 12px !important;
   border: 1px solid #e2e8f0 !important;
}

.toolbar-controls-right .pagination > .active > a,
.toolbar-controls-right .pagination > .active > span {
   background-color: #00a65a !important;
   border-color: #00a65a !important;
   color: #fff !important;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <?= cclang('tiktok_unsettled_transactions') ?><small style="margin-left: 6px;"><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_unsettled_transactions') ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-tiktok-unsettled">
            <div class="box-body" style="padding: 0;">
               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <!-- Header with proper gap and flex alignment -->
                  <div class="widget-user-header" style="padding: 22px 25px;">
                     <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
                        <div class="widget-user-image" style="width: 52px; height: 52px; margin-right: 18px; float: none; display: flex; align-items: center;">
                           <img src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar" style="width: 52px; height: 52px; border-radius: 50%; float: none; display: block;">
                        </div>
                        <div class="header-titles" style="margin-left: 0;">
                           <h3 class="widget-user-username" style="margin: 0 0 5px 0; margin-left: 0;"><?= cclang('tiktok_unsettled_transactions') ?></h3>
                           <h5 class="widget-user-desc" style="margin: 0; margin-left: 0; display: flex; align-items: center; gap: 10px;">
                              Pesanan Belum Settle / Dana Tertahan 
                              <span class="label bg-yellow" style="margin-left: 4px;"><?= $tiktok_unsettled_transactions_counts; ?> <?= cclang('items'); ?></span>
                           </h5>
                        </div>
                     </div>

                     <div class="header-right">
                        <a class="btn btn-top-action" id="btn_sync" title="Tarik Dana Tertahan dari TikTok Shop" href="<?= site_url('administrator/tiktok_unsettled_transactions/sync'); ?>">
                           <i class="fa fa-refresh"></i> Tarik Dana Belum Settle
                        </a>
                        <?php is_allowed('tiktok_unsettled_transactions_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_unsettled_transactions/export'); ?>">
                           <i class="fa fa-file-excel-o"></i> XLS
                        </a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_unsettled_transactions_export', function () { ?>
                        <a class="btn btn-top-action" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/tiktok_unsettled_transactions/export_pdf'); ?>">
                           <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <?php }) ?>
                     </div>
                  </div>

                  <!-- Form & Table -->
                  <form name="form_tiktok_unsettled_transactions" id="form_tiktok_unsettled_transactions" action="<?= base_url('administrator/tiktok_unsettled_transactions/index'); ?>">
                     <div class="table-responsive">
                        <table class="table table-minimal">
                           <thead>
                              <tr>
                                 <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                                 </th>
                                 <th style="width: 110px;">Nama Toko</th>
                                 <th style="width: 120px;">ID Pesanan</th>
                                 <th style="width: 105px; text-align: center;">Status Settlement</th>
                                 <th style="width: 115px; text-align: right;">Estimasi Dana Bersih</th>
                                 <th style="width: 105px;">Waktu Pesanan</th>
                                 <th style="width: 105px;">Waktu Sinkronisasi</th>
                                 <th style="width: 48px; text-align: center;">Aksi</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_tiktok_unsettled_transactions">
                              <?php foreach ($tiktok_unsettled_transactionss as $tiktok_unsettled_transactions): ?>
                              <tr>
                                 <td style="text-align: center;">
                                    <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_unsettled_transactions->id; ?>">
                                 </td>
                                 <td>
                                    <?php if ($tiktok_unsettled_transactions->tiktok_shop_id): ?>
                                       <?= anchor('administrator/tiktok_shops/view/' . $tiktok_unsettled_transactions->tiktok_shop_id . '?popup=show', $tiktok_unsettled_transactions->tiktok_shops_shop_name ?: 'Toko #' . $tiktok_unsettled_transactions->tiktok_shop_id, ['class' => 'popup-view', 'style' => 'font-weight: 500; color: #0284c7;']); ?>
                                    <?php else: ?>
                                       <span class="text-muted">-</span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php 
                                    $ord = !empty($tiktok_unsettled_transactions->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_unsettled_transactions->order_id])->row() : null;
                                    if ($ord): ?>
                                       <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" class="chip-link">
                                          <?= _ent($tiktok_unsettled_transactions->order_id); ?>
                                       </a>
                                    <?php else: ?>
                                       <a href="<?= site_url('administrator/tiktok_orders?f=order_id&q=' . $tiktok_unsettled_transactions->order_id); ?>" class="chip-link">
                                          <?= _ent($tiktok_unsettled_transactions->order_id ?: '-'); ?>
                                       </a>
                                    <?php endif; ?>
                                 </td>
                                 <td style="text-align: center;">
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
                                 </td>
                                 <td style="text-align: right; font-weight: 600; color: #1e293b;">
                                    <?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?> <?= number_format($tiktok_unsettled_transactions->estimated_settlement_amount, 0, ',', '.'); ?>
                                 </td>
                                 <td style="font-size: 12px; color: #64748b;">
                                    <?= $tiktok_unsettled_transactions->order_created_time ? date('d/m/Y H:i', strtotime($tiktok_unsettled_transactions->order_created_time)) : '-'; ?>
                                 </td>
                                 <td style="font-size: 12px; color: #64748b;">
                                    <?= $tiktok_unsettled_transactions->synced_at ? date('d/m/Y H:i', strtotime($tiktok_unsettled_transactions->synced_at)) : '-'; ?>
                                 </td>
                                 <td style="text-align: center; white-space: nowrap;">
                                    <!-- Only 1 action -> Single clean action link -->
                                    <?php is_allowed('tiktok_unsettled_transactions_view', function () use ($tiktok_unsettled_transactions) { ?>
                                       <a href="<?= site_url('administrator/tiktok_unsettled_transactions/view/' . $tiktok_unsettled_transactions->id); ?>" class="action-link" title="Lihat Rincian">
                                          <i class="fa fa-newspaper-o"></i> Detail
                                       </a>
                                    <?php }) ?>
                                 </td>
                              </tr>
                              <?php endforeach; ?>
                              <?php if ($tiktok_unsettled_transactions_counts == 0): ?>
                              <tr>
                                 <td colspan="100" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    Data Transaksi Belum Settle tidak ditemukan. Silakan klik tombol "Tarik Dana Belum Settle".
                                 </td>
                              </tr>
                              <?php endif; ?>
                           </tbody>
                        </table>
                     </div>

                     <!-- Bottom Toolbar with Precise Compact Gaps -->
                     <div class="box-footer-toolbar">
                        <div class="toolbar-controls-left">
                           <!-- Search & Filter Controls -->
                           <div class="filter-group">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>..." value="<?= $this->input->get('q'); ?>" style="width: 170px;">
                              
                              <select class="form-control" name="f" id="field" style="width: 160px;">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'order_id' ? 'selected' : ''; ?> value="order_id">ID Pesanan</option>
                                 <option <?= $this->input->get('f') == 'settlement_status' ? 'selected' : ''; ?> value="settlement_status">Status Settlement</option>
                              </select>

                              <button type="submit" class="btn btn-filter-submit" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                              <a class="btn btn-reset" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_unsettled_transactions'); ?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>

                        <!-- Pagination on Right -->
                        <div class="toolbar-controls-right">
                           <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                              <?= $pagination; ?>
                           </div>
                        </div>
                     </div>

                  </form>
               </div>
               <!-- /.widget-user -->
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box -->
      </div>
   </div>
</section>
<!-- /.content -->

<!-- Page script -->
<script>
   $(document).ready(function () {
      //check all
      var checkAll = $('#check_all');
      var checkboxes = $('input.check');

      checkAll.on('ifChecked ifUnchecked', function (event) {
         if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
         } else {
            checkboxes.iCheck('uncheck');
         }
      });

      checkboxes.on('ifChanged', function (event) {
         if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
         } else {
            checkAll.removeProp('checked');
         }
         checkAll.iCheck('update');
      });

   });
</script>
