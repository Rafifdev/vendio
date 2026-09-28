<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
function domo(){
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/tiktok_packages/add';
       return false;
   });

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
      <?= cclang('tiktok_packages') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('tiktok_packages') ?></li>
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
                     <div class="row pull-right">
                        <a class="btn btn-flat btn-info" id="btn_sync" href="<?= site_url('administrator/tiktok_packages/sync'); ?>"><i class="fa fa-refresh"></i> Tarik Data Paket</a>
                        <?php is_allowed('tiktok_packages_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('tiktok_packages')]); ?>  (Ctrl+a)" href="<?=  site_url('administrator/tiktok_packages/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_new_button', [cclang('tiktok_packages')]); ?></a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_packages_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> XLS" href="<?= site_url('administrator/tiktok_packages/export'); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                        <?php is_allowed('tiktok_packages_export', function(){?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> PDF" href="<?= site_url('administrator/tiktok_packages/export_pdf'); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
                        <?php }) ?>
                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username"><?= cclang('tiktok_packages') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('tiktok_packages')]); ?>  <i class="label bg-yellow"><?= $tiktok_packages_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

                  <form name="form_tiktok_packages" id="form_tiktok_packages" action="<?= base_url('administrator/tiktok_packages/index'); ?>">
                  
                  <div class="table-responsive" style="overflow-x: auto; width: 100%;"> 
                  <table class="table table-bordered table-striped dataTable" style="min-width: 1200px; width: 100%;">
                     <thead>
                        <tr style="white-space: nowrap;">
                           <th width="5">
                              <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="Pilih Semua">
                           </th>
                           <th>ID Paket</th>
                           <th>ID Pesanan</th>
                           <th>Kurir Logistik</th>
                           <th>Nomor Resi</th>
                           <th>Metode Serah Terima</th>
                           <th>Status Paket</th>
                           <th>Waktu Dibuat</th>
                           <th style="width: 260px; min-width: 260px; text-align: center;">Aksi</th>
                        </tr>
                     </thead>
                     <tbody id="tbody_tiktok_packages">
                     <?php if (empty($tiktok_packagess)): ?>
                        <tr>
                           <td colspan="9" style="text-align: center; color: #888;">Belum ada data paket pengiriman. Silakan klik tombol Tarik Data Paket di atas untuk mensinkronisasi dengan TikTok Shop.</td>
                        </tr>
                     <?php endif; ?>
                     <?php foreach($tiktok_packagess as $tiktok_packages): ?>
                        <tr style="white-space: nowrap;">
                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $tiktok_packages->id; ?>">
                           </td>
                           <td><?= _ent($tiktok_packages->package_id); ?></td> 
                           <td>
                               <?php 
                               $order_row = !empty($tiktok_packages->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_packages->order_id])->row() : null;
                               if ($order_row): ?>
                                  <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" style="color: #3c8dbc;"><?= _ent($tiktok_packages->order_id); ?></a>
                               <?php else: ?>
                                  <span style="color: #3c8dbc;"><?= _ent($tiktok_packages->order_id ?: '-'); ?></span>
                               <?php endif; ?>
                            </td> 
                           <td>
                              <?= _ent($tiktok_packages->shipping_provider_name ?: '-'); ?>
                              <?php if (!empty($tiktok_packages->delivery_option_name)): ?>
                                 <br><small class="text-muted"><?= _ent($tiktok_packages->delivery_option_name); ?></small>
                              <?php endif; ?>
                           </td> 
                           <td>
                              <?= _ent($tiktok_packages->tracking_number ?: '-'); ?>
                           </td> 
                           <td>
                              <?php
                              $hm = strtoupper($tiktok_packages->handover_method);
                              if ($hm === 'PICKUP') {
                                 echo '<span class="label label-info">Penjemputan</span>';
                              } elseif ($hm === 'DROP_OFF') {
                                 echo '<span class="label label-warning">Antar ke Gerai</span>';
                              } else {
                                 echo '<span class="label label-primary">' . _ent($tiktok_packages->handover_method ?: '-') . '</span>';
                              }
                              ?>
                           </td> 
                           <td>
                              <?php
                              $st = strtoupper($tiktok_packages->package_status);
                              if ($st === 'COMPLETED') {
                                 echo '<span class="label label-success">Selesai</span>';
                              } elseif ($st === 'DELIVERED') {
                                 echo '<span class="label label-success">Terkirim</span>';
                              } elseif ($st === 'FULFILLING') {
                                 echo '<span class="label label-warning">Sedang Diproses</span>';
                              } elseif ($st === 'AWAITING_SHIPMENT') {
                                 echo '<span class="label label-warning">Perlu Dikirim</span>';
                              } elseif ($st === 'AWAITING_COLLECTION') {
                                 echo '<span class="label label-info">Menunggu Penjemputan</span>';
                              } elseif ($st === 'IN_TRANSIT') {
                                 echo '<span class="label label-info">Dalam Perjalanan</span>';
                              } elseif ($st === 'CANCELLED') {
                                 echo '<span class="label label-danger">Dibatalkan</span>';
                              } else {
                                 echo '<span class="label label-primary">' . _ent($st ?: '-') . '</span>';
                              }
                              ?>
                           </td> 
                           <td><?= _ent($tiktok_packages->package_create_time ?: '-'); ?></td> 
                           <td style="width: 260px; min-width: 260px; text-align: center;">
                              <?php is_allowed('tiktok_packages_view', function() use ($tiktok_packages){?>
                                 <a href="<?= site_url('administrator/tiktok_packages/view/' . $tiktok_packages->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> Lihat</a>
                                 <a href="<?= site_url('administrator/tiktok_packages/print_label/' . $tiktok_packages->id); ?>" target="_blank" class="label-default"><i class="fa fa-print"></i> Cetak Label</a>
                              <?php }) ?>
                              <?php if (strtoupper($tiktok_packages->package_status) === 'FULFILLING' || strtoupper($tiktok_packages->package_status) === 'AWAITING_SHIPMENT'): ?>
                                 <a href="<?= site_url('administrator/tiktok_packages/ship/' . $tiktok_packages->id); ?>" onclick="return confirm('Konfirmasi serah terima pengiriman paket ini ke kurir?');" class="label-default"><i class="fa fa-truck"></i> Kirim</a>
                              <?php endif; ?>
                              <?php is_allowed('tiktok_packages_delete', function() use ($tiktok_packages){?>
                                 <a href="javascript:void(0);" data-href="<?= site_url('administrator/tiktok_packages/delete/' . $tiktok_packages->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> Hapus</a>
                              <?php }) ?>
                           </td>
                        </tr>
                      <?php endforeach; ?>
                      <?php if ($tiktok_packages_counts == 0):?>
                         <tr>
                           <td colspan="9" style="text-align: center; color: #888;">
                           Data Pengiriman Paket tidak ditemukan
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
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Aksi Massal" >
                           <option value="">Aksi Massal</option>
                           <option value="delete">Hapus</option>
                        </select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="btn btn-flat" name="apply" id="apply" title="Terapkan Aksi Massal">Terapkan</button>
                     </div>
                     <div class="col-sm-3 padd-left-0  " >
                        <input type="text" class="form-control" name="q" id="filter" placeholder="Cari data..." value="<?= $this->input->get('q'); ?>">
                     </div>
                     <div class="col-sm-3 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="f" id="field" >
                           <option value="">Semua Kolom</option>
                           <option <?= $this->input->get('f') == 'package_id' ? 'selected' :''; ?> value="package_id">ID Paket</option>
                           <option <?= $this->input->get('f') == 'order_id' ? 'selected' :''; ?> value="order_id">ID Pesanan</option>
                           <option <?= $this->input->get('f') == 'tracking_number' ? 'selected' :''; ?> value="tracking_number">Nomor Resi</option>
                           <option <?= $this->input->get('f') == 'shipping_provider_name' ? 'selected' :''; ?> value="shipping_provider_name">Kurir</option>
                           <option <?= $this->input->get('f') == 'package_status' ? 'selected' :''; ?> value="package_status">Status</option>
                        </select>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="Filter Pencarian">
                        Filter
                        </button>
                     </div>
                     <div class="col-sm-1 padd-left-0 ">
                        <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= base_url('administrator/tiktok_packages');?>" title="Reset Filter">
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
      var serialize_bulk = $('#form_tiktok_packages').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "Apakah Anda Yakin?",
            text: "Data yang dipilih akan dihapus secara permanen!",
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
               document.location.href = BASE_URL + '/administrator/tiktok_packages/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Perhatian",
            text: "Silakan pilih tindakan massal terlebih dahulu.",
            type: "warning"
          });

        return false;
      }

      return false;

    });/*end appliy click*/


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