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
.box-cancellation-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-cancellation-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-cancellation-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-cancellation-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-cancellation-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-cancellation-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-cancellation-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-cancellation-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-cancellation-view .form-group:last-child {
   border-bottom: none;
}

.box-cancellation-view .form-group:hover {
   background-color: #fafbfc;
}

.box-cancellation-view .form-group .control-label {
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

.box-cancellation-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-cancellation-view .chip-id {
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
.box-cancellation-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 900px;
}

.box-cancellation-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-cancellation-view .sub-table thead th {
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

.box-cancellation-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-cancellation-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-cancellation-view .view-nav {
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

.box-cancellation-view .view-nav .btn {
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
      Pembatalan Pesanan <small><?= cclang('detail', ['Pembatalan Pesanan']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_cancellations'); ?>">Pembatalan Pesanan</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-cancellation-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Pembatalan Pesanan</h3>
                        <h5 class="widget-user-desc">Detail Pengajuan Pembatalan Pesanan</h5>
                     </div>
                  </div>

                  <?php
                  // Helper format status dan alasan pembatalan agar ringkas, akurat, dan sesuai makna asli API
                  if (!function_exists('format_tiktok_cancel_status')) {
                     function format_tiktok_cancel_status($status) {
                        if (empty($status)) return '-';
                        $st = strtoupper(trim($status));
                        switch ($st) {
                           case 'AWAITING_SELLER_REVIEW':
                           case 'PENDING':
                           case 'CANCELLATION_REQUEST_PENDING':
                           case 'REVIEWING':
                              return '<span class="label label-warning">Menunggu Respon</span>';
                           case 'APPROVED':
                           case 'CANCELLATION_REQUEST_APPROVED':
                              return '<span class="label label-success">Disetujui</span>';
                           case 'COMPLETE':
                           case 'COMPLETED':
                           case 'SUCCESS':
                           case 'CANCELLATION_REQUEST_COMPLETE':
                              return '<span class="label label-success">Selesai</span>';
                           case 'REJECT':
                           case 'REJECTED':
                           case 'CANCELLATION_REQUEST_REJECT':
                           case 'CANCELLATION_REQUEST_REJECTED':
                              return '<span class="label label-danger">Ditolak</span>';
                           case 'CANCEL':
                           case 'CANCELLED':
                           case 'CANCELLATION_REQUEST_CANCEL':
                           case 'CANCELLATION_REQUEST_CANCELLED':
                              return '<span class="label bg-gray">Dibatalkan</span>';
                           default:
                              $clean = ucwords(str_replace(['cancellation_request_', '_'], ['', ' '], strtolower($st)));
                              return '<span class="label label-info">' . _ent($clean) . '</span>';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_cancel_reason')) {
                     function format_tiktok_cancel_reason($reason) {
                        if (empty($reason)) return '-';
                        $r = strtolower(trim($reason));
                        if (strpos($r, 'out_of_stock') !== false || strpos($r, 'stok') !== false) {
                           return 'Stok Habis';
                        } elseif (strpos($r, 'pricing_error') !== false || strpos($r, 'wrong_price') !== false || strpos($r, 'harga') !== false) {
                           return 'Kesalahan Harga';
                        } elseif (strpos($r, 'changed_mind') !== false || strpos($r, 'change_of_mind') !== false || strpos($r, 'berubah pikiran') !== false) {
                           return 'Berubah Pikiran';
                        } elseif (strpos($r, 'wrong_item') !== false || strpos($r, 'wrong_product') !== false || strpos($r, 'salah beli') !== false || strpos($r, 'salah varian') !== false) {
                           return 'Salah Produk / Varian';
                        } elseif (strpos($r, 'address_wrong') !== false || strpos($r, 'wrong_address') !== false || strpos($r, 'ganti alamat') !== false) {
                           return 'Alamat Salah';
                        } elseif (strpos($r, 'shipping_delayed') !== false || strpos($r, 'delayed') !== false || strpos($r, 'terlambat') !== false) {
                           return 'Pengiriman Terlambat';
                        } elseif (strpos($r, 'found_cheaper') !== false || strpos($r, 'cheaper') !== false || strpos($r, 'lebih murah') !== false) {
                           return 'Menemukan Harga Lebih Murah';
                        } elseif (strpos($r, 'timeout') !== false || strpos($r, 'unpaid') !== false) {
                           return 'Waktu Pembayaran Habis';
                        } elseif (strpos($r, 'duplicate') !== false || strpos($r, 'ganda') !== false) {
                           return 'Pesanan Ganda';
                        } elseif (strpos($r, 'risk_control') !== false || strpos($r, 'risk') !== false) {
                           return 'Kontrol Risiko Sistem';
                        } elseif (strpos($r, 'payment') !== false || strpos($r, 'bayar') !== false) {
                           return 'Kendala Pembayaran';
                        } elseif (strpos($r, 'mutual') !== false || strpos($r, 'sepakat') !== false) {
                           return 'Kesepakatan Bersama';
                        } elseif (strpos($r, 'not_delivered') !== false || strpos($r, 'undeliverable') !== false) {
                           return 'Gagal Kirim';
                        }

                        $clean = str_replace(['seller_cancel_reason_', 'buyer_cancel_reason_', 'system_cancel_reason_', 'cancel_reason_', '_'], ['', '', '', '', ' '], $r);
                        return ucwords(trim($clean));
                     }
                  }
                  ?>

                  <div class="form-horizontal" name="form_tiktok_cancellations" id="form_tiktok_cancellations">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Toko</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_cancellations->tiktok_shops_shop_name ?: 'Toko TikTok'); ?></strong>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Pembatalan</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_cancellations->cancel_id); ?></span>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Pesanan</label>
                         <div class="col-sm-8">
                            <?php 
                            $order_row = !empty($tiktok_cancellations->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_cancellations->order_id])->row() : null;
                            if ($order_row): ?>
                               <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-id" style="color: #0284c7; text-decoration: none;"><i class="fa fa-external-link"></i> <?= _ent($tiktok_cancellations->order_id); ?></a>
                            <?php else: ?>
                               <span class="chip-id"><?= _ent($tiktok_cancellations->order_id ?: '-'); ?></span>
                            <?php endif; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Inisiator</label>
                         <div class="col-sm-8">
                            <?php
                            $ini = strtoupper($tiktok_cancellations->cancel_initiator);
                            if ($ini === 'BUYER') {
                               echo '<span class="label label-info">Pembeli</span>';
                            } elseif ($ini === 'SELLER') {
                               echo '<span class="label label-primary">Penjual</span>';
                            } elseif ($ini === 'SYSTEM') {
                               echo '<span class="label bg-purple">Sistem TikTok</span>';
                            } else {
                               echo '<span class="label bg-gray">' . _ent($tiktok_cancellations->cancel_initiator ?: '-') . '</span>';
                            }
                            ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Status Pembatalan</label>
                         <div class="col-sm-8">
                            <?= format_tiktok_cancel_status($tiktok_cancellations->cancel_status); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Alasan Pembatalan</label>
                         <div class="col-sm-8">
                            <div style="font-weight: 600; color: #1e293b;"><?= format_tiktok_cancel_reason($tiktok_cancellations->cancel_reason); ?></div>
                            <?php if (!empty($tiktok_cancellations->cancel_reason_key)): ?>
                               <div class="text-muted" style="margin-top: 3px; font-size: 12px;">Kode: <?= _ent($tiktok_cancellations->cancel_reason_key); ?></div>
                            <?php endif; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Waktu Pengajuan</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_cancellations->cancel_created_time ?: '-'); ?>
                         </div>
                     </div>

                     <!-- Sub-tabel Daftar Barang yang Dibatalkan -->
                     <div class="form-group">
                         <label class="control-label">Rincian Barang</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th style="width: 70px; text-align: center;">Gambar</th>
                                             <th>Nama Produk</th>
                                             <th style="width: 180px;">ID SKU</th>
                                             <th style="width: 80px; text-align: center;">Jumlah</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php 
                                         $items = !empty($tiktok_cancellations->items) ? json_decode($tiktok_cancellations->items) : null;
                                         if (!empty($items)):
                                             foreach ($items as $item):
                                                 $img_url = $item->product_image->url ?? ($item->sku_image ?? ($item->image ?? ''));
                                                 $prod_name = $item->product_name ?? ($item->sku_name ?? 'Produk Dipesan');
                                                 $sku_name = (!empty($item->sku_name) && $item->sku_name != 'Default') ? $item->sku_name : '';
                                                 $seller_sku = $item->seller_sku ?? '';
                                         ?>
                                             <tr>
                                                 <td style="width: 70px; text-align: center; vertical-align: middle;">
                                                     <?php if (!empty($img_url)): ?>
                                                         <a class="fancybox" rel="group" href="<?= $img_url; ?>">
                                                             <img src="<?= $img_url; ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;" alt="item">
                                                         </a>
                                                     <?php else: ?>
                                                         <span class="text-muted">-</span>
                                                     <?php endif; ?>
                                                 </td>
                                                 <td style="vertical-align: middle;">
                                                     <strong style="color: #1e293b;"><?= _ent($prod_name); ?></strong>
                                                     <?php if (!empty($seller_sku)): ?>
                                                         <div class="text-muted" style="font-size: 12px;">SKU: <?= _ent($seller_sku); ?></div>
                                                     <?php endif; ?>
                                                 </td>
                                                 <td style="vertical-align: middle;"><span class="chip-id"><?= _ent($item->sku_id ?? ($item->id ?? '-')); ?></span></td>
                                                 <td style="text-align: center; vertical-align: middle; font-weight: 600;"><?= (int)($item->quantity ?? 1); ?></td>
                                             </tr>
                                         <?php 
                                             endforeach;
                                         else:
                                         ?>
                                             <tr>
                                                 <td colspan="4" class="text-center text-muted" style="padding: 16px;">Seluruh produk pada pesanan ini diajukan untuk dibatalkan.</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <?php if (strtoupper($tiktok_cancellations->cancel_status) === 'AWAITING_SELLER_REVIEW' || strtoupper($tiktok_cancellations->cancel_status) === 'PENDING'): ?>
                             <a class="btn btn-flat btn-success btn_action btn-approve-cancel" href="<?= site_url('administrator/tiktok_cancellations/approve/' . $tiktok_cancellations->id); ?>" data-cancel-id="<?= $tiktok_cancellations->cancel_id; ?>"><i class="fa fa-check"></i> Setujui Pembatalan</a>
                             <button type="button" class="btn btn-flat btn-danger btn_action" data-toggle="modal" data-target="#modal-reject-cancel"><i class="fa fa-times"></i> Tolak Pembatalan</button>
                         <?php endif; ?>
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar (Ctrl+x)" href="<?= site_url('administrator/tiktok_cancellations'); ?>"><i class="fa fa-undo"></i> Kembali ke Daftar</a>
                     </div>
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->
      </div>
   </div>

   <!-- Modal Tolak Pengajuan Pembatalan -->
   <div class="modal fade" id="modal-reject-cancel" tabindex="-1" role="dialog" aria-labelledby="modalRejectCancelLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form id="form-reject-cancel" method="POST" action="<?= site_url('administrator/tiktok_cancellations/reject/' . $tiktok_cancellations->id); ?>">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title" id="modalRejectCancelLabel">Tolak Pengajuan Pembatalan Pesanan</h4>
           </div>
           <div class="modal-body">
             <p class="text-muted">Pilih alasan resmi penolakan pembatalan untuk <span style="color: #3c8dbc;">ID: <?= _ent($tiktok_cancellations->cancel_id); ?></span> sesuai ketentuan TikTok Shop:</p>
             <div class="form-group">
               <label>Alasan Penolakan Resmi <span class="text-danger">*</span></label>
               <select name="reject_reason" id="select-cancel-reject-reason" class="form-control" required>
                 <option value="">-- Pilih Alasan Penolakan --</option>
                 <?php if (!empty($reject_reasons)): ?>
                   <?php foreach ($reject_reasons as $reason): ?>
                     <option value="<?= _ent($reason->reason_code); ?>"><?= _ent($reason->reason_text); ?></option>
                   <?php endforeach; ?>
                 <?php else: ?>
                   <option value="seller_reject_cancel_package_shipped">Paket pesanan sudah selesai dipacking dan diserahkan ke pihak kurir</option>
                   <option value="seller_reject_cancel_in_transit">Paket pesanan sedang dalam proses pengiriman oleh kurir logistik</option>
                   <option value="seller_reject_cancel_mutual_agreement">Telah tercapai kesepakatan dengan pembeli untuk tetap melanjutkan pesanan</option>
                   <option value="seller_reject_cancel_out_of_policy">Permintaan pembatalan tidak memenuhi ketentuan syarat dan kebijakan toko</option>
                 <?php endif; ?>
               </select>
             </div>
             <div class="form-group">
               <label>Catatan / Keterangan untuk Pembeli (Opsional)</label>
               <textarea name="comments" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika diperlukan..."></textarea>
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
             <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Konfirmasi Tolak Pembatalan</button>
           </div>
         </form>
       </div>
     </div>
   </div>
</section>
<!-- /.content -->

<script>
$(document).ready(function(){
  $('.btn-approve-cancel').click(function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var cancelId = $(this).data('cancel-id');
    swal({
        title: "Setujui Pembatalan Pesanan?",
        text: "Anda akan menyetujui pembatalan pesanan (ID: " + cancelId + "). Pesanan akan otomatis dibatalkan di TikTok Shop dan dana dikembalikan ke pembeli.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "Ya, Setujui Pembatalan",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(isConfirm){
        if (isConfirm) {
          document.location.href = url;            
        }
      });
    return false;
  });
});
</script>
