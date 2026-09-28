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

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Pembatalan Pesanan <small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pembatalan Pesanan</li>
   </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body">
               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <div class="widget-user-header">
                     <div class="row pull-right" style="margin-right: 0px;">
                        <div style="display: inline-block; vertical-align: top; width: 220px; margin-right: 5px; text-align: left;">
                           <select class="form-control chosen chosen-select" name="shop_id_filter" id="shop_id_filter">
                              <option value="">Semua Toko</option>
                              <?php foreach ($shops as $shop): ?>
                                 <option <?= ($selected_shop_id == $shop->id) ? 'selected' : ''; ?> value="<?= $shop->id; ?>">
                                    <?= _ent($shop->shop_name); ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                        
                        <?php is_allowed('tiktok_cancellations_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_cancellations/export'); ?>"><i class="fa fa-file-excel-o"></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                         <a class="btn btn-flat btn-success btn_add_new" id="btn_sync" title="Tarik Data Pembatalan dari TikTok Shop" href="<?= site_url('administrator/tiktok_cancellations/sync' . (!empty($selected_shop_id) ? '?shop_id=' . $selected_shop_id : '')); ?>"><i class="fa fa-refresh"></i></a>
                      </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Pembatalan Pesanan</h3>
                     <h5 class="widget-user-desc">Daftar Pengajuan Pembatalan Pesanan <i class="label bg-yellow"><?= $tiktok_cancellations_counts; ?> Data</i></h5>
                  </div>

                  <form name="form_tiktok_cancellations" id="form_tiktok_cancellations" action="<?= base_url('administrator/tiktok_cancellations/index'); ?>">
                     <?php if (!empty($selected_shop_id)): ?>
                        <input type="hidden" name="shop_id" value="<?= $selected_shop_id; ?>">
                     <?php endif; ?>

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

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
                        <tr>
                           <th width="5">
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                           </th>
                           <th>Nama Toko</th>
                           <th>ID Pesanan</th>
                           <th>Inisiator</th>
                           <th>Status Pembatalan</th>
                           <th>Alasan Pembatalan</th>
                           <th>Waktu Pengajuan</th>
                           <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_tiktok_cancellations">
                     <?php foreach($tiktok_cancellationss as $tiktok_cancellations): ?>
                        <tr>
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_cancellations->id; ?>">
                           </td>
                           <td>
                              <?php if (!empty($tiktok_cancellations->tiktok_shop_id)): ?>
                                 <?= anchor('administrator/tiktok_shops/view/'.$tiktok_cancellations->tiktok_shop_id.'?popup=show', $tiktok_cancellations->tiktok_shops_shop_name ?: 'Toko TikTok', ['class' => 'popup-view', 'style' => 'font-weight: bold; color: #3c8dbc;']); ?>
                              <?php else: ?>
                                 <span class="text-muted">-</span>
                              <?php endif; ?>
                           </td>
                           <td>
                              <?php 
                              $order_row = !empty($tiktok_cancellations->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_cancellations->order_id])->row() : null;
                              if ($order_row): ?>
                                 <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" style="color: #3c8dbc;"><?= _ent($tiktok_cancellations->order_id); ?></a>
                              <?php else: ?>
                                 <span style="color: #3c8dbc;"><?= _ent($tiktok_cancellations->order_id ?: '-'); ?></span>
                              <?php endif; ?>
                           </td>
                           <td>
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
                           </td>
                           <td>
                               <?= format_tiktok_cancel_status($tiktok_cancellations->cancel_status); ?>
                            </td>
                            <td><?= format_tiktok_cancel_reason($tiktok_cancellations->cancel_reason); ?></td>
                           <td><?= $tiktok_cancellations->cancel_created_time ? date('d/m/Y H:i', strtotime($tiktok_cancellations->cancel_created_time)) : '-'; ?></td>
                           <td style="width: 100px; text-align: center; white-space: nowrap;">
                              <?php if (in_array(strtoupper($tiktok_cancellations->cancel_status), ['AWAITING_SELLER_REVIEW', 'PENDING', 'CANCELLATION_REQUEST_PENDING', 'REVIEWING'])): ?>
                                 <a href="<?= site_url('administrator/tiktok_cancellations/approve/' . $tiktok_cancellations->id); ?>" class="label-default btn-approve-cancel" data-cancel-id="<?= $tiktok_cancellations->cancel_id; ?>" title="Setujui pembatalan"><i class="fa fa-check"></i> Setujui</a>
                                 <a href="javascript:void(0);" data-action="<?= site_url('administrator/tiktok_cancellations/reject/' . $tiktok_cancellations->id); ?>" data-cancel-id="<?= $tiktok_cancellations->cancel_id; ?>" class="label-default btn-reject-cancel-modal" title="Tolak pembatalan"><i class="fa fa-times"></i> Tolak</a>
                              <?php endif; ?>

                              <?php is_allowed('tiktok_cancellations_view', function() use ($tiktok_cancellations){?>
                                 <a href="<?= site_url('administrator/tiktok_cancellations/view/' . $tiktok_cancellations->id); ?>" class="label-default" title="Lihat Rincian"><i class="fa fa-newspaper-o"></i> Lihat</a>
                              <?php }) ?>
                           </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php if ($tiktok_cancellations_counts == 0) :?>
                         <tr>
                           <td colspan="100" class="text-center text-muted">
                           Data Pembatalan Pesanan tidak ditemukan
                           </td>
                         </tr>
                      <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
               <!-- /.widget-user -->
               <div class="row">
                  <div class="col-md-8">
                     <div class="col-sm-2 padd-left-0">
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Aksi Massal">
                           <option value="">Aksi Massal</option>
                           <option value="delete">Hapus</option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="Terapkan Aksi Massal">Terapkan</button>
                     </div>
                     <div class="col-sm-3 padd-left-0">
                        <input type="text" class="form-control" name="q" id="filter" placeholder="Cari data..." value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0">
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                           <option value="">Semua Kolom</option>
                           <option <?= $this->input->get('f') == 'cancel_id' ? 'selected' :''; ?> value="cancel_id">ID Pembatalan</option>
                           <option <?= $this->input->get('f') == 'order_id' ? 'selected' :''; ?> value="order_id">ID Pesanan</option>
                           <option <?= $this->input->get('f') == 'cancel_status' ? 'selected' :''; ?> value="cancel_status">Status</option>
                           <option <?= $this->input->get('f') == 'cancel_reason' ? 'selected' :''; ?> value="cancel_reason">Alasan</option>
                           <option <?= $this->input->get('f') == 'cancel_initiator' ? 'selected' :''; ?> value="cancel_initiator">Inisiator</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="Filter Pencarian">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_cancellations');?>" title="Reset Filter">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>
                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                        <?= $pagination; ?>
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
         <form id="form-reject-cancel" method="POST" action="">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h4 class="modal-title" id="modalRejectCancelLabel">Tolak Pengajuan Pembatalan Pesanan</h4>
           </div>
           <div class="modal-body">
             <p class="text-muted">Pilih alasan resmi penolakan pembatalan untuk <span id="modal-cancel-id-label" style="color: #3c8dbc;"></span> sesuai ketentuan TikTok Shop:</p>
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

<!-- Page script -->
<script>
  $(document).ready(function(){
   
    // Konfirmasi Setujui Pembatalan (Approve)
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

    // Buka Modal Tolak Pembatalan dengan Alasan Resmi
    $('.btn-reject-cancel-modal').click(function(e){
      e.preventDefault();
      var actionUrl = $(this).data('action');
      var cancelId = $(this).data('cancel-id');
      $('#form-reject-cancel').attr('action', actionUrl);
      $('#modal-cancel-id-label').text('ID: ' + cancelId);
      $('#modal-reject-cancel').modal('show');
    });

    $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
          title: "Apakah Anda Yakin?",
          text: "Data yang dihapus tidak dapat dikembalikan!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });
      return false;
    });

    $('#apply').click(function(){
      var bulk = $('#bulk');
      var serialize_bulk = $('#form_tiktok_cancellations').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "Apakah Anda Yakin?",
            text: "Data yang dipilih akan dihapus permanen!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/tiktok_cancellations/delete?' + serialize_bulk;      
            }
          });
        return false;
      } else if (bulk.val() == '') {
          swal({
            title: "Perhatian",
            text: "Silakan pilih aksi massal terlebih dahulu.",
            type: "warning"
          });
        return false;
      }
      return false;
    });

    // Filter toko
    $('#shop_id_filter').on('change', function () {
       var shop_id = $(this).val();
       var url = '<?= site_url("administrator/tiktok_cancellations"); ?>';
       var params = [];
       if (shop_id) {
          params.push('shop_id=' + encodeURIComponent(shop_id));
       }
       <?php if ($this->input->get('q')): ?>
          params.push('q=<?= urlencode($this->input->get('q')); ?>');
       <?php endif; ?>
       <?php if ($this->input->get('f')): ?>
          params.push('f=<?= urlencode($this->input->get('f')); ?>');
       <?php endif; ?>
       if (params.length > 0) {
          url += '?' + params.join('&');
       }
       window.location.href = url;
    });

  });
</script>