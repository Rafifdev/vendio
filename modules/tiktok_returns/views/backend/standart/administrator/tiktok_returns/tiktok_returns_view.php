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
.box-return-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-return-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-return-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-return-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-return-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-return-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-return-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-return-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-return-view .form-group:last-child {
   border-bottom: none;
}

.box-return-view .form-group:hover {
   background-color: #fafbfc;
}

.box-return-view .form-group .control-label {
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

.box-return-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-return-view .chip-id {
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
.box-return-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 900px;
}

.box-return-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-return-view .sub-table thead th {
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

.box-return-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-return-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-return-view .view-nav {
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

.box-return-view .view-nav .btn {
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
      <?= cclang('tiktok_returns'); ?> <small><?= cclang('detail', [cclang('tiktok_returns')]); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_returns'); ?>"><?= cclang('tiktok_returns'); ?></a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-return-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username"><?= cclang('tiktok_returns'); ?></h3>
                        <h5 class="widget-user-desc">Detail <?= cclang('tiktok_returns'); ?></h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_returns" id="form_tiktok_returns">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">Nama Toko</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_returns->tiktok_shops_shop_name ?: '-'); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Retur</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_returns->return_id); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">ID Pesanan</label>
                         <div class="col-sm-8">
                            <?php 
                            $order_row = !empty($tiktok_returns->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_returns->order_id])->row() : null;
                            if ($order_row): ?>
                               <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-id" style="color: #0284c7; text-decoration: none;"><i class="fa fa-external-link"></i> <?= _ent($tiktok_returns->order_id); ?></a>
                            <?php else: ?>
                               <span class="chip-id"><?= _ent($tiktok_returns->order_id ?: '-'); ?></span>
                            <?php endif; ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Batas SLA Respon</label>
                         <div class="col-sm-8">
                            <?php
                            if (!empty($tiktok_returns->return_created_time) && in_array($tiktok_returns->return_status, ['RETURN_OR_REFUND_REQUEST_PENDING', 'PROCESSING', 'AWAITING_SELLER_REVIEW'])) {
                               $diff = (strtotime($tiktok_returns->return_created_time) + 172800) - time();
                               if ($diff <= 0) {
                                  echo '<span class="label label-danger">SLA Lewat (Auto-Approve)</span>';
                               } elseif ($diff < 21600) {
                                  $hours = floor($diff / 3600);
                                  $mins = floor(($diff % 3600) / 60);
                                  echo '<span class="label label-danger">' . $hours . 'j ' . $mins . 'm tersisa (Kritis)</span>';
                               } elseif ($diff < 43200) {
                                  $hours = floor($diff / 3600);
                                  $mins = floor(($diff % 3600) / 60);
                                  echo '<span class="label label-warning">' . $hours . 'j ' . $mins . 'm tersisa</span>';
                               } else {
                                  $hours = floor($diff / 3600);
                                  $mins = floor(($diff % 3600) / 60);
                                  echo '<span class="label label-info">' . $hours . 'j ' . $mins . 'm tersisa</span>';
                               }
                            } elseif (in_array($tiktok_returns->return_status, ['AWAITING_BUYER_SHIP', 'BUYER_SHIPPED', 'SELLER_RECEIVE_PACKAGE', 'RETURN_AND_REFUND_PACKAGE_DELIVERED'])) {
                               echo '<span class="label label-primary">Sudah Direspon Penjual</span>';
                            } elseif (in_array($tiktok_returns->return_status, ['COMPLETE', 'COMPLETED', 'REFUND_SUCCESS', 'SUCCESS'])) {
                               echo '<span class="label label-success">Selesai Diproses</span>';
                            } elseif (in_array($tiktok_returns->return_status, ['REJECT', 'REJECTED'])) {
                               echo '<span class="label label-danger">Pengajuan Ditolak</span>';
                            } elseif (in_array($tiktok_returns->return_status, ['CANCEL', 'CANCELLED'])) {
                               echo '<span class="label bg-gray">Dibatalkan Pembeli</span>';
                            } else {
                               echo '<span class="label bg-gray">Tidak Ada SLA Aktif</span>';
                            }
                            ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Tipe Retur</label>
                         <div class="col-sm-8">
                            <?php 
                            switch ($tiktok_returns->return_type) {
                               case 'RETURN_AND_REFUND':
                                  echo 'Pengembalian Barang & Dana';
                                  break;
                               case 'REFUND':
                               case 'REFUND_ONLY':
                                  echo 'Pengembalian Dana Saja';
                                  break;
                               default:
                                  echo _ent($tiktok_returns->return_type ?: '-');
                            }
                            ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Status Retur</label>
                         <div class="col-sm-8">
                            <?php 
                            switch ($tiktok_returns->return_status) {
                               case 'RETURN_OR_REFUND_REQUEST_PENDING':
                                  echo '<span class="label label-warning">Menunggu Respon Penjual</span>';
                                  break;
                               case 'AWAITING_BUYER_SHIP':
                                  echo '<span class="label label-warning">Menunggu Pembeli Mengirim Barang</span>';
                                  break;
                               case 'BUYER_SHIPPED':
                                  echo '<span class="label label-info">Barang Sedang Dikembalikan</span>';
                                  break;
                               case 'SELLER_RECEIVE_PACKAGE':
                               case 'RETURN_AND_REFUND_PACKAGE_DELIVERED':
                                  echo '<span class="label label-primary">Barang Diterima Penjual</span>';
                                  break;
                               case 'REFUND_PROCESSING':
                               case 'PROCESSING':
                                  echo '<span class="label label-info">Proses Pengembalian Dana</span>';
                                  break;
                               case 'COMPLETE':
                               case 'COMPLETED':
                               case 'REFUND_SUCCESS':
                               case 'SUCCESS':
                                  echo '<span class="label label-success">Selesai</span>';
                                  break;
                               case 'REJECT':
                               case 'REJECTED':
                                  echo '<span class="label label-danger">Ditolak</span>';
                                  break;
                               case 'CANCEL':
                               case 'CANCELLED':
                                  echo '<span class="label label-danger">Dibatalkan</span>';
                                  break;
                               default:
                                  echo '<span class="label label-info">' . _ent($tiktok_returns->return_status ?: '-') . '</span>';
                            }
                            ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Alasan Retur</label>
                         <div class="col-sm-8">
                            <?php 
                            $r = strtolower(trim($tiktok_returns->return_reason ?? ''));
                            if (strpos($r, 'damaged') !== false || strpos($r, 'rusak') !== false) {
                               echo 'Paket atau produk rusak';
                            } elseif (strpos($r, 'does not match') !== false || strpos($r, 'not_match') !== false || strpos($r, 'tidak sesuai') !== false) {
                               echo 'Produk tidak sesuai deskripsi';
                            } elseif (strpos($r, 'wrong') !== false || strpos($r, 'salah') !== false) {
                               echo 'Salah kirim barang / produk';
                            } elseif (strpos($r, 'missing') !== false || strpos($r, 'kurang') !== false || strpos($r, 'hilang') !== false) {
                               echo 'Komponen atau produk kurang';
                            } elseif (strpos($r, 'defective') !== false || strpos($r, 'cacat') !== false) {
                               echo 'Produk cacat / tidak berfungsi';
                            } elseif (strpos($r, 'counterfeit') !== false || strpos($r, 'palsu') !== false) {
                               echo 'Produk tiruan / tidak original';
                            } elseif (strpos($r, 'not received') !== false || strpos($r, 'not_received') !== false || strpos($r, 'belum terima') !== false) {
                               echo 'Paket pesanan belum diterima';
                            } elseif (strpos($r, 'no longer needed') !== false || strpos($r, 'tidak butuh') !== false) {
                               echo 'Tidak membutuhkannya lagi';
                            } elseif (strpos($r, 'cheaper') !== false || strpos($r, 'murah') !== false) {
                               echo 'Menemukan harga lebih murah';
                            } elseif (strpos($r, 'late') !== false || strpos($r, 'terlambat') !== false) {
                               echo 'Pengiriman barang terlambat';
                            } elseif (strpos($r, 'mutual') !== false || strpos($r, 'sepakat') !== false) {
                               echo 'Kesepakatan pembeli dan penjual';
                            } else {
                               echo _ent($tiktok_returns->return_reason ?: '-');
                            }
                            ?>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nominal Pengembalian Dana</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b; font-size: 14px;">Rp <?= number_format($tiktok_returns->refund_amount, 0, ',', '.'); ?></strong>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Nomor Resi</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 13px; font-weight: 600; color: #1e293b;"><?= _ent($tiktok_returns->tracking_number ?: '-'); ?></span>
                         </div>
                     </div>
                                          
                     <div class="form-group">
                         <label for="content" class="control-label">Waktu Pengajuan</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_returns->return_created_time ?: '-'); ?>
                         </div>
                     </div>

                     <!-- Sub-tabel Produk Retur -->
                     <div class="form-group">
                         <label class="control-label">Produk</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th style="width: 70px; text-align: center;">Gambar</th>
                                             <th>Nama Produk</th>
                                             <th>Varian / SKU</th>
                                             <th style="width: 150px;">Nominal Refund</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php 
                                         $items = json_decode($tiktok_returns->items);
                                         if (!empty($items)): 
                                             foreach ($items as $item): 
                                                 $img_url = $item->product_image->url ?? "";
                                                 $prod_name = $item->product_name ?? "-";
                                                 $sku_name = (!empty($item->sku_name) && $item->sku_name != "Default") ? $item->sku_name : "";
                                                 $seller_sku = $item->seller_sku ?? "";
                                                 $refund = $item->refund_amount->refund_subtotal ?? ($item->refund_amount->refund_total ?? null);
                                         ?>
                                             <tr>
                                                 <td style="text-align: center; vertical-align: middle;">
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
                                                 <td style="vertical-align: middle;">
                                                     <?php if (!empty($sku_name)): ?>
                                                         <div><?= _ent($sku_name); ?></div>
                                                     <?php endif; ?>
                                                     <?php if (!empty($seller_sku)): ?>
                                                         <small class="text-muted">SKU: <?= _ent($seller_sku); ?></small>
                                                     <?php endif; ?>
                                                     <?php if (empty($sku_name) && empty($seller_sku)): ?>
                                                         <span class="text-muted">-</span>
                                                     <?php endif; ?>
                                                 </td>
                                                 <td style="vertical-align: middle; font-weight: 600;">
                                                     <?= $refund !== null ? "Rp " . number_format($refund, 0, ",", ".") : "-"; ?>
                                                 </td>
                                             </tr>
                                         <?php 
                                             endforeach; 
                                         else: 
                                         ?>
                                             <tr>
                                                 <td colspan="4" class="text-center text-muted" style="padding: 16px;">Tidak ada data produk</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <?php if ($tiktok_returns->return_status == 'RETURN_OR_REFUND_REQUEST_PENDING'): ?>
                             <a class="btn btn-flat btn-success btn_action btn-approve-return" href="<?= site_url('administrator/tiktok_returns/approve/' . $tiktok_returns->id); ?>" data-return-id="<?= $tiktok_returns->return_id; ?>" title="Setujui Pengajuan Retur"><i class="fa fa-check"></i> Setujui Retur</a>
                             <button type="button" class="btn btn-flat btn-danger btn_action" data-toggle="modal" data-target="#modal-reject-return"><i class="fa fa-times"></i> Tolak Retur</button>
                         <?php endif; ?>
                         <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali ke Daftar (Ctrl+x)" href="<?= site_url('administrator/tiktok_returns/'); ?>"><i class="fa fa-undo"></i> Kembali ke Daftar</a>
                     </div>
                    
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->

      </div>
   </div>

   <!-- Modal Tolak Pengajuan Retur -->
   <div class="modal fade" id="modal-reject-return" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form id="form-reject-return" method="POST" action="<?= site_url('administrator/tiktok_returns/reject/' . $tiktok_returns->id); ?>">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title" id="modalRejectLabel">Tolak Pengajuan Retur</h4>
           </div>
           <div class="modal-body">
             <p class="text-muted">Pilih alasan resmi penolakan untuk pengajuan retur <span style="color: #3c8dbc;">ID: <?= _ent($tiktok_returns->return_id); ?></span> sesuai ketentuan TikTok Shop:</p>
             <div class="form-group">
               <label>Alasan Penolakan Resmi <span class="text-danger">*</span></label>
               <select name="reject_reason" id="select-reject-reason" class="form-control" required>
                 <option value="">-- Pilih Alasan Penolakan --</option>
                 <?php if (!empty($reject_reasons)): ?>
                   <?php foreach ($reject_reasons as $reason): ?>
                     <option value="<?= _ent($reason->reason_code); ?>"><?= _ent($reason->reason_text); ?></option>
                   <?php endforeach; ?>
                 <?php else: ?>
                   <option value="seller_reject_reason_buyer_reason_not_valid">Alasan pembeli tidak valid atau tidak sesuai kondisi sebenarnya</option>
                   <option value="seller_reject_reason_package_delivered_in_good_condition">Paket dan produk telah terkirim dalam kondisi baik dan lengkap</option>
                   <option value="seller_reject_reason_insufficient_evidence">Bukti foto atau video unboxing yang dilampirkan pembeli tidak memadai</option>
                   <option value="seller_reject_reason_mutual_agreement">Telah tercapai kesepakatan solusi alternatif bersama pembeli</option>
                 <?php endif; ?>
               </select>
             </div>
             <div class="form-group">
               <label>Catatan / Keterangan untuk Pembeli (Opsional)</label>
               <textarea name="comments" class="form-control" rows="3" placeholder="Tuliskan penjelasan tambahan jika diperlukan..."></textarea>
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
             <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Konfirmasi Tolak Retur</button>
           </div>
         </form>
       </div>
     </div>
   </div>
</section>
<!-- /.content -->

<script>
$(document).ready(function(){
  $('.btn-approve-return').click(function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var returnId = $(this).data('return-id');
    swal({
        title: "Setujui Retur?",
        text: "Anda akan menyetujui pengajuan pengembalian (ID: " + returnId + "). Pembeli akan diinstruksikan untuk mengirimkan barang ke alamat toko Anda.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#00a65a",
        confirmButtonText: "Ya, Setujui",
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
