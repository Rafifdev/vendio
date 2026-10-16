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
/* Clean & Refined Card Container - Matching Pesanan Penjualan */
.box-order-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-order-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-order-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-order-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-order-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-order-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-order-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-order-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-order-view .form-group:last-child {
   border-bottom: none;
}

.box-order-view .form-group:hover {
   background-color: #fafbfc;
}

.box-order-view .form-group .control-label {
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

.box-order-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-order-view .chip-id {
   display: inline-flex;
   align-items: center;
   gap: 6px;
   font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
   font-size: 12px;
   font-weight: 600;
   color: #0284c7;
   background-color: #f0f9ff;
   border: 1px solid #bae6fd;
   border-radius: 4px;
   padding: 3px 8px;
   letter-spacing: 0.02em;
   cursor: pointer;
   user-select: none;
   transition: all 0.15s ease;
}

.box-order-view .chip-id:hover {
   background-color: #e0f2fe;
   color: #0369a1;
   border-color: #7dd3fc;
}

.box-order-view .chip-id .copy-icon {
   font-size: 11px;
   color: #0284c7;
   opacity: 0.7;
   transition: all 0.15s ease;
}

.box-order-view .chip-id:hover .copy-icon {
   opacity: 1;
   color: #0369a1;
}

/* Status Badges */
.badge-status {
   display: inline-flex;
   align-items: center;
   gap: 5px;
   padding: 4px 10px;
   border-radius: 12px;
   font-size: 12px;
   font-weight: 600;
   line-height: 1;
}
.badge-active { background: #dcfce7; color: #166534; }
.badge-ended { background: #f1f5f9; color: #475569; }
.badge-claimed { background: #dcfce7; color: #166534; }
.badge-pending { background: #fef3c7; color: #92400e; }
.badge-expired { background: #fee2e2; color: #991b1b; }
.badge-rejected { background: #f1f5f9; color: #475569; }

/* Modern Sub Tables */
.box-order-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 900px;
}

.box-order-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-order-view .sub-table thead th {
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

.box-order-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-order-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-order-view .view-nav {
   display: flex;
   align-items: center;
   flex-wrap: wrap;
   gap: 8px;
   padding: 18px 25px;
   background-color: #fafbfc;
   border-top: 1px solid #edf2f7;
   border-bottom-left-radius: 8px;
   border-bottom-right-radius: 8px;
   margin-top: 15px;
}

.box-order-view .view-nav .btn {
   height: 36px !important;
   padding: 0 15px !important;
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
      Hadiah Pesanan <small><?= cclang('detail', ['Hadiah Pesanan']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/order_prizes/tab/orders'); ?>">Hadiah Pesanan</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-order-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Hadiah Pesanan</h3>
                        <h5 class="widget-user-desc">Detail Data Pesanan & Riwayat Undian Hadiah</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_order_prizes" id="form_order_prizes">
                     
                     <div class="form-group">
                        <label for="order_number" class="col-sm-2 control-label">ID Pesanan (Order ID)</label>
                        <div class="col-sm-8">
                           <span class="chip-id btn-copy-order-id" data-id="<?= html_escape($order['order_number']); ?>" title="Klik untuk menyalin Nomor Pesanan" role="button">
                              <?= html_escape($order['order_number']); ?>
                              <i class="fa fa-copy copy-icon"></i>
                           </span>
                           <small class="text-muted" style="margin-left: 10px; font-size: 12px;">ID Record: #<?= $order['id']; ?></small>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="campaign" class="col-sm-2 control-label">Campaign Terkait</label>
                        <div class="col-sm-8">
                           <?php if (!empty($campaign)): ?>
                              <strong style="color: #0f172a; font-size: 14px;"><?= html_escape($campaign['name']); ?></strong>
                              <span class="badge" style="background: #f1f5f9; color: #334155; margin-left: 6px; text-transform: uppercase;">
                                 <?= html_escape($campaign['channel']); ?>
                              </span>
                              <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                 Toko: <strong><?= html_escape($campaign['shop_ref'] ?: '-'); ?></strong> | 
                                 Status: <span class="badge-status badge-<?= $campaign['status']; ?>"><?= ucfirst($campaign['status']); ?></span>
                              </div>
                              <div style="margin-top: 5px;">
                                 <a href="<?= site_url('order_prizes?campaign=' . urlencode($campaign['slug'])); ?>" target="_blank" style="font-size: 12px; color: #0284c7; text-decoration: none;">
                                    <i class="fa fa-external-link"></i> Buka Landing Wheel Promosi
                                 </a>
                              </div>
                           <?php else: ?>
                              <span class="text-muted">- (ID #<?= $order['campaign_id']; ?>)</span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Nomor HP Pembeli</label>
                        <div class="col-sm-8">
                           <strong style="font-size: 14px; font-family: monospace; color: #0f172a;"><?= html_escape($order['phone']); ?></strong>
                           <a href="https://wa.me/<?= preg_replace('/^0/', '62', $order['phone']); ?>" target="_blank" class="btn btn-xs btn-default" style="margin-left: 8px; color: #16a34a; border-color: #bbf7d0; background: #f0fdf4;" title="Kirim Pesan WhatsApp">
                              <i class="fa fa-whatsapp"></i> Chat WhatsApp
                           </a>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status Pesanan</label>
                        <div class="col-sm-8">
                           <span class="badge-status <?= in_array($order['status'], ['completed', 'paid']) ? 'badge-active' : 'badge-ended'; ?>">
                              <i class="fa fa-circle" style="font-size: 8px;"></i> <?= ucfirst($order['status']); ?>
                           </span>
                           <small class="text-muted" style="margin-left: 8px; font-size: 12px;">
                              <?= in_array($order['status'], ['completed', 'paid']) ? 'Memenuhi syarat verifikasi spin roda hadiah.' : 'Pesanan belum berstatus Completed / Paid.'; ?>
                           </small>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="revenue" class="col-sm-2 control-label">Nilai Belanja (Omset)</label>
                        <div class="col-sm-8">
                           <strong style="font-size: 15px; color: #059669;">Rp <?= number_format($order['revenue'], 0, ',', '.'); ?></strong>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="profit" class="col-sm-2 control-label">Estimasi Profit Bersih</label>
                        <div class="col-sm-8">
                           <span style="font-size: 14px; color: #475569;">
                              <?= $order['profit'] !== null ? 'Rp ' . number_format($order['profit'], 0, ',', '.') : '<span class="text-muted">Tidak dicatat</span>'; ?>
                           </span>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="ordered_at" class="col-sm-2 control-label">Waktu Pemesanan</label>
                        <div class="col-sm-8">
                           <span><?= !empty($order['ordered_at']) ? date('d M Y, H:i', strtotime($order['ordered_at'])) : '-'; ?> WIB</span>
                           <?php if (!empty($order['created_at'])): ?>
                              <span class="text-muted" style="margin-left: 8px; font-size: 12px;">(Terdaftar di sistem: <?= date('d M Y, H:i', strtotime($order['created_at'])); ?>)</span>
                           <?php endif; ?>
                        </div>
                     </div>

                     <!-- Data Hasil Spin & Hadiah -->
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Riwayat & Hasil Undian</label>
                        <div class="col-sm-8">
                           <?php if (!empty($spin)): ?>
                              <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                    <thead>
                                       <tr>
                                          <th>Hadiah Dimenangkan</th>
                                          <th>Jenis</th>
                                          <th>Nilai / Biaya</th>
                                          <th>Waktu Spin</th>
                                          <th>Status Klaim</th>
                                          <th>Pengiriman</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td>
                                             <strong style="color: #0f172a; font-size: 13.5px;"><?= html_escape($spin['prize_name']); ?></strong>
                                             <?php if (!empty($spin['notes'])): ?>
                                                <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                                                   Catatan: <?= html_escape($spin['notes']); ?>
                                                </div>
                                             <?php endif; ?>
                                          </td>
                                          <td>
                                             <span class="badge" style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 11px;">
                                                <?= html_escape($spin['prize_kind']); ?>
                                             </span>
                                          </td>
                                          <td>
                                             Rp <?= number_format($spin['prize_cost'], 0, ',', '.'); ?>
                                          </td>
                                          <td style="font-size: 12px; color: #475569;">
                                             <?= date('d M Y H:i', strtotime($spin['spun_at'])); ?>
                                             <div style="font-size: 11px; color: #94a3b8;">Batas: <?= date('d M H:i', strtotime($spin['claim_deadline'])); ?></div>
                                          </td>
                                          <td>
                                             <span class="badge-status badge-<?= $spin['claim_status']; ?>">
                                                <?= ucfirst($spin['claim_status']); ?>
                                             </span>
                                          </td>
                                          <td>
                                             <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11.5px;">
                                                <?= ucfirst($spin['prize_status']); ?>
                                             </span>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           <?php else: ?>
                              <div style="padding: 14px 18px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px; max-width: 600px;">
                                 <div style="display: flex; align-items: center; gap: 8px; color: #64748b;">
                                    <i class="fa fa-info-circle text-blue" style="font-size: 16px;"></i>
                                    <span>Nomor pesanan ini belum memutar roda hadiah.</span>
                                 </div>
                                 <div style="margin-top: 8px; font-size: 12px; color: #64748b;">
                                    Pembeli dapat mengakses halaman spin menggunakan nomor pesanan <strong><?= html_escape($order['order_number']); ?></strong> dan 4 digit terakhir nomor HP.
                                 </div>
                              </div>
                           <?php endif; ?>
                        </div>
                     </div>

                     <!-- Footer Actions -->
                     <div class="view-nav">
                        <?php if ($can_manage): ?>
                           <a class="btn btn-flat btn-primary btn_action" href="<?= site_url('administrator/order_prizes/order_edit/' . $order['id']); ?>" title="Edit Data Order">
                              <i class="fa fa-edit"></i> Ubah Data Order
                           </a>
                        <?php endif; ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" href="<?= site_url('administrator/order_prizes/tab/orders'); ?>" title="Kembali ke Daftar (Ctrl+x)">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Hadiah Pesanan']); ?>
                        </a>
                     </div>

                  </div>
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

<script>
$(document).ready(function() {
   // Copy ID Pesanan satu-klik
   function copyOrderId(text, callback) {
      if (navigator.clipboard && window.isSecureContext) {
         navigator.clipboard.writeText(text).then(function() {
            if (typeof callback === 'function') callback();
         }).catch(function() {
            fallbackCopy(text, callback);
         });
      } else {
         fallbackCopy(text, callback);
      }
   }

   function fallbackCopy(text, callback) {
      var textArea = document.createElement('textarea');
      textArea.value = text;
      textArea.style.position = 'fixed';
      textArea.style.left = '-9999px';
      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();
      try {
         document.execCommand('copy');
         if (typeof callback === 'function') callback();
      } catch (err) {}
      document.body.removeChild(textArea);
   }

   $(document).on('click', '.btn-copy-order-id', function(e) {
      e.preventDefault();
      var orderId = $(this).attr('data-id');
      var $el = $(this);
      copyOrderId(orderId, function() {
         var originalHtml = $el.html();
         $el.html(orderId + ' <i class="fa fa-check text-green copy-icon" style="color: #10b981 !important;"></i>');
         setTimeout(function() {
            $el.html(originalHtml);
         }, 1500);
      });
   });
});
</script>
