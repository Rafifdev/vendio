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

<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Pengiriman Paket <small><?= cclang('detail', ['Pengiriman Paket']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_packages'); ?>">Pengiriman Paket</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
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
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Pengiriman Paket</h3>
                     <h5 class="widget-user-desc">Detail Pengiriman Paket</h5>
                     <hr>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_packages" id="form_tiktok_packages">
                   
                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID Paket</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->package_id); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID Pesanan</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?php 
                           $order_row = !empty($tiktok_packages->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_packages->order_id])->row() : null;
                           if ($order_row): ?>
                              <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" style="color: #3c8dbc;"><?= _ent($tiktok_packages->order_id); ?></a>
                           <?php else: ?>
                              <span style="color: #3c8dbc;"><?= _ent($tiktok_packages->order_id ?: '-'); ?></span>
                           <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Status Paket</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Kurir Logistik</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->shipping_provider_name ?: '-'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Opsi Pengiriman</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->delivery_option_name ?: '-'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nomor Resi</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->tracking_number ?: '-'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Metode Serah Terima</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
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
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Dimensi Paket</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= (float)$tiktok_packages->dimension_length; ?> x <?= (float)$tiktok_packages->dimension_width; ?> x <?= (float)$tiktok_packages->dimension_height; ?> <?= _ent($tiktok_packages->dimension_unit ?: 'CM'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Berat Paket</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= number_format($tiktok_packages->weight_val, 0); ?> <?= _ent($tiktok_packages->weight_unit ?: 'GRAM'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Pengirim</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->sender_name ?: 'TikTok Shop Partner Seller'); ?>
                           <?php if (!empty($tiktok_packages->sender_phone)): ?>
                              <span class="text-muted">(<?= _ent($tiktok_packages->sender_phone); ?>)</span>
                           <?php endif; ?>
                           <br><?= nl2br(_ent($tiktok_packages->sender_address ?: '-')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Penerima</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->recipient_name ?: '-'); ?>
                           <?php if (!empty($tiktok_packages->recipient_phone)): ?>
                              <span class="text-muted">(<?= _ent($tiktok_packages->recipient_phone); ?>)</span>
                           <?php endif; ?>
                           <br><?= nl2br(_ent($tiktok_packages->recipient_address ?: '-')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Waktu Dibuat</label>
                        <div class="col-sm-8" style="padding-top: 7px;">
                           <?= _ent($tiktok_packages->package_create_time ?: '-'); ?>
                        </div>
                    </div>

                    <hr>

                    <!-- Sub-tabel Daftar Barang Paket (Pola Varian SKU Cicool) -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Daftar Barang</label>
                        <div class="col-sm-8">
                            <table class="table table-bordered table-striped" style="margin-top: 5px;">
                                <thead>
                                    <tr class="bg-gray">
                                        <th style="width: 70px; text-align: center;">Gambar</th>
                                        <th>Nama Produk</th>
                                        <th style="width: 200px;">ID SKU</th>
                                        <th style="width: 80px; text-align: center;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($package_items)): ?>
                                        <?php foreach ($package_items as $item): 
                                            $img = !empty($item->sku_image) ? $item->sku_image : (!empty($item->order_sku_image) ? $item->order_sku_image : '');
                                            $prod_name = !empty($item->product_name) ? $item->product_name : (!empty($item->sku_name) ? $item->sku_name : 'Produk TikTok');
                                        ?>
                                            <tr>
                                                <td style="width: 70px; text-align: center; vertical-align: middle;">
                                                    <?php if (!empty($img)): ?>
                                                        <a class="fancybox" rel="group" href="<?= $img; ?>">
                                                            <img src="<?= _ent($img); ?>" alt="Gambar" style="width: 44px; height: 44px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <div><?= _ent($prod_name); ?></div>
                                                    <?php if (!empty($item->seller_sku)): ?>
                                                        <small class="text-muted">(SKU: <?= _ent($item->seller_sku); ?>)</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="vertical-align: middle;"><?= _ent($item->sku_id); ?></td>
                                                <td style="text-align: center; vertical-align: middle;"><?= (int)$item->quantity; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" style="text-align: center; color: #888;">Tidak ada rincian barang yang tercatat pada paket ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Sub-tabel Timeline Pelacakan Kurir (Live Tracking Checkpoints) -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Pelacakan Kurir</label>
                        <div class="col-sm-8">
                            <table class="table table-bordered table-striped" style="margin-top: 5px;">
                                <thead>
                                    <tr class="bg-gray">
                                        <th style="width: 170px;">Waktu Checkpoint</th>
                                        <th>Status Aktivitas Logistik</th>
                                        <th style="width: 110px; text-align: center;">Kode Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tracking_events)): ?>
                                        <?php foreach ($tracking_events as $track): ?>
                                            <tr>
                                                <td><small class="text-muted"><?= !empty($track['update_time_millis']) ? date('d-m-Y H:i:s', round($track['update_time_millis'] / 1000)) : '-'; ?></small></td>
                                                <td><?= _ent($track['description'] ?? '-'); ?></td>
                                                <td style="text-align: center;"><span class="label label-info"><?= _ent($track['action_code'] ?? '-'); ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: #888;">Belum ada aktivitas checkpoint scan kurir yang tercatat dari TikTok Shop API.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="view-nav">
                        <a class="btn btn-flat btn-info" target="_blank" href="<?= site_url('administrator/tiktok_packages/print_label/' . $tiktok_packages->id); ?>"><i class="fa fa-print"></i> Cetak Label Resi</a>
                        <?php if (strtoupper($tiktok_packages->package_status) === 'FULFILLING' || strtoupper($tiktok_packages->package_status) === 'AWAITING_SHIPMENT'): ?>
                            <a class="btn btn-flat btn-success" href="<?= site_url('administrator/tiktok_packages/ship/' . $tiktok_packages->id); ?>" onclick="return confirm('Konfirmasi serah terima pengiriman paket ini ke kurir?');"><i class="fa fa-truck"></i> Konfirmasi Kirim Paket</a>
                        <?php endif; ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="Kembali (Ctrl+x)" href="<?= site_url('administrator/tiktok_packages'); ?>"><i class="fa fa-undo"></i> Kembali ke Daftar</a>
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
