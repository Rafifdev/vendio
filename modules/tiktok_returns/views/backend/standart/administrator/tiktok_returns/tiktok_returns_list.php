
<style>
.table-action-col {
   width: 250px !important;
   min-width: 250px !important;
   text-align: left !important;
   vertical-align: middle !important;
}
.table-action-col a.label-default {
   display: inline-block;
   margin: 2px 2px;
   white-space: nowrap;
}
</style>
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
      <?= cclang('tiktok_returns') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_returns') ?></li>
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
                  <div class="widget-user-header ">
                     <div class="row pull-right">
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_sync" title="Tarik Data Retur dari TikTok Shop" href="<?= site_url('administrator/tiktok_returns/sync'); ?>"><i class="fa fa-refresh"></i> Tarik Data Retur</a>
                        <?php is_allowed('tiktok_returns_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> <?= cclang('tiktok_returns'); ?>" href="<?= site_url('administrator/tiktok_returns/export'); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_returns_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> PDF <?= cclang('tiktok_returns'); ?>" href="<?= site_url('administrator/tiktok_returns/export_pdf'); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username"><?= cclang('tiktok_returns') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('tiktok_returns')]); ?>  <i class="label bg-yellow"><?= $tiktok_returns_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_tiktok_returns" id="form_tiktok_returns" action="<?= base_url('administrator/tiktok_returns/index'); ?>">
                  
                  <?php
                  // Helper function mapping status & tipe retur agar mudah dipahami
                  if (!function_exists('format_tiktok_return_status')) {
                     function format_tiktok_return_status($status) {
                        switch ($status) {
                           case 'RETURN_OR_REFUND_REQUEST_PENDING':
                              return 'Menunggu Respon Penjual';
                           case 'AWAITING_BUYER_SHIP':
                              return 'Menunggu Pembeli Mengirim Barang';
                           case 'BUYER_SHIPPED':
                              return 'Barang Sedang Dikembalikan';
                           case 'SELLER_RECEIVE_PACKAGE':
                           case 'RETURN_AND_REFUND_PACKAGE_DELIVERED':
                              return 'Barang Diterima Penjual';
                           case 'REFUND_PROCESSING':
                           case 'PROCESSING':
                              return 'Proses Pengembalian Dana';
                           case 'COMPLETE':
                           case 'COMPLETED':
                           case 'REFUND_SUCCESS':
                           case 'SUCCESS':
                              return 'Selesai';
                           case 'REJECT':
                           case 'REJECTED':
                              return 'Ditolak';
                           case 'CANCEL':
                           case 'CANCELLED':
                              return 'Dibatalkan';
                           default:
                              return $status ? ucwords(str_replace('_', ' ', strtolower($status))) : '-';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_return_type')) {
                     function format_tiktok_return_type($type) {
                        switch ($type) {
                           case 'RETURN_AND_REFUND':
                              return 'Pengembalian Barang & Dana';
                           case 'REFUND':
                           case 'REFUND_ONLY':
                              return 'Pengembalian Dana Saja';
                           default:
                              return $type ? ucwords(str_replace('_', ' ', strtolower($type))) : '-';
                        }
                     }
                  }

                  if (!function_exists('format_tiktok_return_reason')) {
                     function format_tiktok_return_reason($reason) {
                        if (empty($reason)) return '-';
                        $r = strtolower(trim($reason));
                        if (strpos($r, 'damaged') !== false || strpos($r, 'rusak') !== false) {
                           return 'Paket atau produk rusak';
                        } elseif (strpos($r, 'does not match') !== false || strpos($r, 'not_match') !== false || strpos($r, 'tidak sesuai') !== false) {
                           return 'Produk tidak sesuai deskripsi';
                        } elseif (strpos($r, 'wrong') !== false || strpos($r, 'salah') !== false) {
                           return 'Salah kirim barang / produk';
                        } elseif (strpos($r, 'missing') !== false || strpos($r, 'kurang') !== false || strpos($r, 'hilang') !== false) {
                           return 'Komponen atau produk kurang';
                        } elseif (strpos($r, 'defective') !== false || strpos($r, 'cacat') !== false) {
                           return 'Produk cacat / tidak berfungsi';
                        } elseif (strpos($r, 'counterfeit') !== false || strpos($r, 'palsu') !== false) {
                           return 'Produk tiruan / tidak original';
                        } elseif (strpos($r, 'not received') !== false || strpos($r, 'not_received') !== false || strpos($r, 'belum terima') !== false) {
                           return 'Paket pesanan belum diterima';
                        } elseif (strpos($r, 'no longer needed') !== false || strpos($r, 'tidak butuh') !== false) {
                           return 'Tidak membutuhkannya lagi';
                        } elseif (strpos($r, 'cheaper') !== false || strpos($r, 'murah') !== false) {
                           return 'Menemukan harga lebih murah';
                        } elseif (strpos($r, 'late') !== false || strpos($r, 'terlambat') !== false) {
                           return 'Pengiriman barang terlambat';
                        } elseif (strpos($r, 'mutual') !== false || strpos($r, 'sepakat') !== false) {
                           return 'Kesepakatan pembeli dan penjual';
                        }
                        return _ent($reason);
                     }
                  }
                  ?>

                  <div class="table-responsive" style="overflow-x: auto; width: 100%;"> 
                  <table class="table table-bordered table-striped dataTable" style="min-width: 1250px; width: 100%;">
                     <thead>
                        <tr style="white-space: nowrap;">
                           <th width="5">
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                           </th>
                           <th> <?= cclang('tiktok_shop_id') ?></th>
                           <th> <?= cclang('return_id') ?></th>
                           <th> <?= cclang('order_id') ?></th>
                            <th> Produk</th>
                           <th> <?= cclang('return_type') ?></th>
                           <th> <?= cclang('return_status') ?></th>
                           <th> <?= cclang('return_reason') ?></th>
                           <th> <?= cclang('refund_amount') ?></th>
                           <th> <?= cclang('tracking_number') ?></th>
                           <th> <?= cclang('return_created_time') ?></th>
                           <th class="table-action-col">Action</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_tiktok_returns">
                     <?php foreach($tiktok_returnss as $tiktok_returns): ?>
                        <tr style="white-space: nowrap;">
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_returns->id; ?>">
                           </td>
                           <td>
                              <?php if ($tiktok_returns->tiktok_shop_id) {
                                 echo anchor('administrator/tiktok_shops/view/'.$tiktok_returns->tiktok_shop_id.'?popup=show', $tiktok_returns->tiktok_shops_shop_name, ['class' => 'popup-view']); 
                              } ?>
                           </td>
                           <td><?= _ent($tiktok_returns->return_id); ?></td>
                           <td>
                              <a href="<?= site_url('administrator/tiktok_orders?q=' . $tiktok_returns->order_id); ?>">
                                 <?= _ent($tiktok_returns->order_id); ?>
                              </a>
                           </td>
                            <td>
                               <?php 
                               $items = json_decode($tiktok_returns->items);
                               if (!empty($items)): 
                                  foreach ($items as $item): ?>
                                     <div><?= _ent($item->product_name ?? '-'); ?></div>
                                     <?php if (!empty($item->seller_sku)): ?>
                                        <small class="text-muted">SKU: <?= _ent($item->seller_sku); ?></small>
                                     <?php endif; ?>
                                  <?php endforeach; 
                               else: ?>
                                  -
                               <?php endif; ?>
                            </td>
                           <td><?= format_tiktok_return_type($tiktok_returns->return_type); ?></td>
                           <td><?= format_tiktok_return_status($tiktok_returns->return_status); ?></td>
                           <td><?= format_tiktok_return_reason($tiktok_returns->return_reason); ?></td>
                           <td>Rp <?= number_format($tiktok_returns->refund_amount, 0, ',', '.'); ?></td>
                           <td><?= _ent($tiktok_returns->tracking_number ?: '-'); ?></td>
                           <td><?= $tiktok_returns->return_created_time ? date('d/m/Y H:i', strtotime($tiktok_returns->return_created_time)) : '-'; ?></td>
                           <td class="table-action-col">
                              <?php if ($tiktok_returns->return_status == 'RETURN_OR_REFUND_REQUEST_PENDING'): ?>
                                 <!-- Aksi Seller Center saat Menunggu Respon Penjual -->
                                 <a href="<?= site_url('administrator/tiktok_returns/approve/' . $tiktok_returns->id); ?>" class="label-default btn-approve-return" data-return-id="<?= $tiktok_returns->return_id; ?>" title="Setujui pengembalian"><i class="fa fa-check"></i> Setujui</a>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/tiktok_returns/reject/' . $tiktok_returns->id); ?>" class="label-default btn-reject-return" data-return-id="<?= $tiktok_returns->return_id; ?>" title="Tolak pengembalian"><i class="fa fa-times"></i> Tolak</a>
                              <?php endif; ?>

                              <?php is_allowed('tiktok_returns_view', function() use ($tiktok_returns){?>
                              <a href="<?= site_url('administrator/tiktok_returns/view/' . $tiktok_returns->id); ?>" class="label-default" title="Lihat Rincian"><i class="fa fa-newspaper-o"></i> Lihat</a>
                              <?php }) ?>
                           </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php if ($tiktok_returns_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Return Order data is not available
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
                     <div class="col-sm-2 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <option value="">Bulk</option>
                           <option value="delete">Delete</option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
                     </div>
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'tiktok_shop_id' ? 'selected' :''; ?> value="tiktok_shop_id"><?= cclang('tiktok_shop_id') ?></option>
                           <option <?= $this->input->get('f') == 'return_id' ? 'selected' :''; ?> value="return_id"><?= cclang('return_id') ?></option>
                           <option <?= $this->input->get('f') == 'order_id' ? 'selected' :''; ?> value="order_id"><?= cclang('order_id') ?></option>
                           <option <?= $this->input->get('f') == 'return_type' ? 'selected' :''; ?> value="return_type"><?= cclang('return_type') ?></option>
                           <option <?= $this->input->get('f') == 'return_status' ? 'selected' :''; ?> value="return_status"><?= cclang('return_status') ?></option>
                           <option <?= $this->input->get('f') == 'return_reason' ? 'selected' :''; ?> value="return_reason"><?= cclang('return_reason') ?></option>
                           <option <?= $this->input->get('f') == 'refund_amount' ? 'selected' :''; ?> value="refund_amount"><?= cclang('refund_amount') ?></option>
                           <option <?= $this->input->get('f') == 'tracking_number' ? 'selected' :''; ?> value="tracking_number"><?= cclang('tracking_number') ?></option>
                           <option <?= $this->input->get('f') == 'return_created_time' ? 'selected' :''; ?> value="return_created_time"><?= cclang('return_created_time') ?></option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_returns');?>" title="<?= cclang('reset_filter'); ?>">
                        <i class="fa fa-undo"></i>
                        </a>
                     </div>
                  </div>
                  </form>                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
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
</section>
<!-- /.content -->

<!-- Page script -->
<script>
  $(document).ready(function(){
   
    // Konfirmasi Setujui Retur (Approve)
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

    // Konfirmasi Tolak Retur (Reject)
    $('.btn-reject-return').click(function(e){
      e.preventDefault();
      var url = $(this).data('href');
      var returnId = $(this).data('return-id');
      swal({
          title: "Tolak Pengajuan Retur?",
          text: "Apakah Anda yakin ingin menolak pengajuan pengembalian ID: " + returnId + "?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Tolak Retur",
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

    $('.remove-data').click(function(){
      var url = $(this).attr('data-href');
      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
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
      var serialize_bulk = $('#form_tiktok_returns').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/tiktok_returns/delete?' + serialize_bulk;      
            }
          });
        return false;
      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning"
          });
        return false;
      }
      return false;
    });
  });
</script>
