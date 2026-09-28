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
      <?= cclang('tiktok_unsettled_transactions') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_unsettled_transactions') ?></li>
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
                     <div class="row pull-right" style="display: flex; align-items: center; justify-content: flex-end;">
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
                        
                        <?php is_allowed('tiktok_unsettled_transactions_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_unsettled_transactions/export'); ?>"><i class="fa fa-file-excel-o" ></i> XLS</a>
                        <?php }) ?>
                         <a class="btn btn-flat btn-success" id="btn_sync" title="Tarik Dana Tertahan dari TikTok Shop" href="<?= site_url('administrator/tiktok_unsettled_transactions/sync' . (!empty($selected_shop_id) ? '?shop_id=' . $selected_shop_id : '')); ?>"><i class="fa fa-refresh"></i></a>
                      </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username"><?= cclang('tiktok_unsettled_transactions') ?></h3>
                     <h5 class="widget-user-desc">Pesanan Belum Settle / Dana Tertahan <i class="label bg-yellow"><?= $tiktok_unsettled_transactions_counts; ?> <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_tiktok_unsettled_transactions" id="form_tiktok_unsettled_transactions" action="<?= base_url('administrator/tiktok_unsettled_transactions/index'); ?>">
                   <?php if (!empty($selected_shop_id)): ?>
                      <input type="hidden" name="shop_id" value="<?= $selected_shop_id; ?>">
                   <?php endif; ?>
                  

                  <div class="table-responsive" style="overflow-x: auto; width: 100%;"> 
                  <table class="table table-bordered table-striped dataTable" style="min-width: 1000px; width: 100%;">
                     <thead>
                        <tr style="white-space: nowrap;">
                           <th width="20">
                              <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                           </th>
                           <th>Nama Toko</th>
                           <th>ID Pesanan</th>
                           <th>Status Settlement</th>
                           <th>Estimasi Dana Bersih</th>
                           <th>Waktu Pesanan</th>
                           <th>Waktu Sinkronisasi</th>
                           <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_tiktok_unsettled_transactions">
                     <?php foreach($tiktok_unsettled_transactionss as $tiktok_unsettled_transactions): ?>
                        <tr style="white-space: nowrap;">
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_unsettled_transactions->id; ?>">
                           </td>
                           <td>
                              <?php if ($tiktok_unsettled_transactions->tiktok_shop_id): ?>
                                 <?= anchor('administrator/tiktok_shops/view/'.$tiktok_unsettled_transactions->tiktok_shop_id.'?popup=show', $tiktok_unsettled_transactions->tiktok_shops_shop_name ?: 'Toko #'.$tiktok_unsettled_transactions->tiktok_shop_id, ['class' => 'popup-view', 'style' => 'font-weight: bold; color: #3c8dbc;']); ?>
                              <?php else: ?>
                                 -
                              <?php endif; ?>
                           </td>
                           <td>
                              <?php 
                              $ord = !empty($tiktok_unsettled_transactions->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_unsettled_transactions->order_id])->row() : null;
                              if ($ord): ?>
                                 <a href="<?= site_url('administrator/tiktok_orders/view/' . $ord->id); ?>" style="color: #3c8dbc;"><?= _ent($tiktok_unsettled_transactions->order_id); ?></a>
                              <?php else: ?>
                                 <a href="<?= site_url('administrator/tiktok_orders?f=order_id&q=' . $tiktok_unsettled_transactions->order_id); ?>" style="color: #3c8dbc;"><?= _ent($tiktok_unsettled_transactions->order_id ?: '-'); ?></a>
                              <?php endif; ?>
                           </td> 
                           <td>
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
                           <td><?= _ent($tiktok_unsettled_transactions->currency ?: 'IDR'); ?> <?= number_format($tiktok_unsettled_transactions->estimated_settlement_amount, 0, ',', '.'); ?></td> 
                           <td><?= $tiktok_unsettled_transactions->order_created_time ? date('d/m/Y H:i', strtotime($tiktok_unsettled_transactions->order_created_time)) : '-'; ?></td> 
                           <td><?= $tiktok_unsettled_transactions->synced_at ? date('d/m/Y H:i', strtotime($tiktok_unsettled_transactions->synced_at)) : '-'; ?></td> 
                           <td style="width: 100px; text-align: center;">
                              <?php is_allowed('tiktok_unsettled_transactions_view', function() use ($tiktok_unsettled_transactions){?>
                                 <a href="<?= site_url('administrator/tiktok_unsettled_transactions/view/' . $tiktok_unsettled_transactions->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> Lihat</a>
                              <?php }) ?>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                     <?php if ($tiktok_unsettled_transactions_counts == 0) :?>
                        <tr>
                           <td colspan="100">
                           Data Transaksi Belum Settle tidak ditemukan
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
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value=""><?= cclang('all'); ?></option>
                           <option <?= $this->input->get('f') == 'order_id' ? 'selected' :''; ?> value="order_id">ID Pesanan</option>
                           <option <?= $this->input->get('f') == 'settlement_status' ? 'selected' :''; ?> value="settlement_status">Status Settlement</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_unsettled_transactions');?>" title="<?= cclang('reset_filter'); ?>">
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
      var serialize_bulk = $('#form_tiktok_unsettled_transactions').serialize();

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
               document.location.href = BASE_URL + '/administrator/tiktok_unsettled_transactions/delete?' + serialize_bulk;      
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

    });/*end appliy click*/


    $('#shop_id_filter').on('change', function () {
        var shop_id = $(this).val();
        var url = '<?= site_url("administrator/tiktok_unsettled_transactions"); ?>';
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

    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

  }); /*end doc ready*/
</script>