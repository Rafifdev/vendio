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
.box-package-view {
   border-radius: 8px;
   border: 1px solid #e5e9f0 !important;
   box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
   background: #ffffff;
   margin-top: 14px;
   margin-bottom: 25px;
}

.box-package-view .widget-user-header {
   display: flex !important;
   align-items: center !important;
   padding: 22px 25px !important;
   border-bottom: 1px solid #edf2f7 !important;
   background: #ffffff !important;
   gap: 20px !important;
}

.box-package-view .widget-user-image {
   width: 52px !important;
   height: 52px !important;
   flex-shrink: 0 !important;
   margin: 0 !important;
   padding: 0 !important;
   float: none !important;
}

.box-package-view .widget-user-image img {
   width: 52px !important;
   height: 52px !important;
   border-radius: 50% !important;
   display: block !important;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08) !important;
   float: none !important;
   margin: 0 !important;
}

.box-package-view .header-titles {
   display: flex !important;
   flex-direction: column !important;
   justify-content: center !important;
   margin-left: 0 !important;
}

.box-package-view .widget-user-username {
   font-size: 20px !important;
   font-weight: 700 !important;
   color: #1e293b !important;
   margin: 0 0 5px 0 !important;
   line-height: 1.2 !important;
}

.box-package-view .widget-user-desc {
   font-size: 13px !important;
   color: #64748b !important;
   margin: 0 !important;
}

/* Detail Form Group Rows Alignment */
.box-package-view .form-group {
   margin-left: 0 !important;
   margin-right: 0 !important;
   margin-bottom: 0 !important;
   padding: 12px 25px !important;
   border-bottom: 1px solid #f8fafc;
   display: flex !important;
   align-items: flex-start !important;
   transition: background-color 0.15s ease;
}

.box-package-view .form-group:last-child {
   border-bottom: none;
}

.box-package-view .form-group:hover {
   background-color: #fafbfc;
}

.box-package-view .form-group .control-label {
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

.box-package-view .form-group .col-sm-8 {
   width: auto !important;
   flex-grow: 1 !important;
   padding: 0 !important;
   color: #1e293b !important;
   font-size: 13.5px !important;
   line-height: 1.6 !important;
}

/* Chip Badge for IDs */
.box-package-view .chip-id {
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
.box-package-view .sub-table-wrapper {
   border: 1px solid #e2e8f0;
   border-radius: 8px;
   overflow: hidden;
   background: #ffffff;
   margin-top: 4px;
   width: 100%;
   max-width: 900px;
}

.box-package-view .sub-table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 0;
}

.box-package-view .sub-table thead th {
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

.box-package-view .sub-table tbody td {
   border-top: 1px solid #f1f5f9 !important;
   border-bottom: none !important;
   border-left: none !important;
   border-right: none !important;
   padding: 10px 14px !important;
   font-size: 13px !important;
   color: #334155 !important;
   vertical-align: middle !important;
}

.box-package-view .sub-table tbody tr:hover {
   background-color: #fafbfc !important;
}

/* Footer Action Buttons Container */
.box-package-view .view-nav {
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

.box-package-view .view-nav .btn {
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
   <div class="row">
      <div class="col-md-12">
         <div class="box box-package-view">
            <div class="box-body" style="padding: 0;">

               <!-- Widget: user widget style 1 -->
               <div class="box-widget widget-user-2" style="margin-bottom: 0;">
                  <div class="widget-user-header">
                     <div class="widget-user-image">
                        <img src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <div class="header-titles">
                        <h3 class="widget-user-username">Pengiriman Paket</h3>
                        <h5 class="widget-user-desc">Detail Pengiriman Paket</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_packages" id="form_tiktok_packages">
                    
                     <div class="form-group">
                         <label for="content" class="control-label">ID Paket</label>
                         <div class="col-sm-8">
                            <span class="chip-id"><?= _ent($tiktok_packages->package_id); ?></span>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">ID Pesanan</label>
                         <div class="col-sm-8">
                            <?php 
                            $order_row = !empty($tiktok_packages->order_id) ? $this->db->get_where('tiktok_orders', ['order_id' => $tiktok_packages->order_id])->row() : null;
                            if ($order_row): ?>
                               <a href="<?= site_url('administrator/tiktok_orders/view/' . $order_row->id); ?>" class="chip-link"><?= _ent($tiktok_packages->order_id); ?></a>
                            <?php else: ?>
                               <span class="chip-id"><?= _ent($tiktok_packages->order_id ?: '-'); ?></span>
                            <?php endif; ?>
                         </div>
                     </div>

                     <div class="form-group">
                          <label for="content" class="control-label">Status Paket</label>
                          <div class="col-sm-8">
                             <?= render_package_status_badge($tiktok_packages->package_status); ?>
                             <?php if (!empty($tiktok_packages->package_sub_status)): ?>
                                <span class="text-muted" style="margin-left: 8px; font-size: 12px;">(Sub-status: <?= _ent($tiktok_packages->package_sub_status); ?>)</span>
                             <?php endif; ?>
                          </div>
                      </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Kurir Logistik</label>
                         <div class="col-sm-8">
                            <strong style="color: #1e293b;"><?= _ent($tiktok_packages->shipping_provider_name ?: '-'); ?></strong>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Opsi Pengiriman</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_packages->delivery_option_name ?: '-'); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Nomor Resi</label>
                         <div class="col-sm-8">
                            <span style="font-family: monospace; font-size: 13px; font-weight: 600; color: #1e293b;"><?= _ent($tiktok_packages->tracking_number ?: '-'); ?></span>
                         </div>
                     </div>

                     <div class="form-group">
                          <label for="content" class="control-label">Metode Serah Terima</label>
                          <div class="col-sm-8">
                             <?= render_handover_method_badge($tiktok_packages->handover_method); ?>
                          </div>
                      </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Dimensi Paket</label>
                         <div class="col-sm-8">
                            <?= (float)$tiktok_packages->dimension_length; ?> x <?= (float)$tiktok_packages->dimension_width; ?> x <?= (float)$tiktok_packages->dimension_height; ?> <?= _ent($tiktok_packages->dimension_unit ?: 'CM'); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Berat Paket</label>
                         <div class="col-sm-8">
                            <?= number_format($tiktok_packages->weight_val, 0); ?> <?= _ent($tiktok_packages->weight_unit ?: 'GRAM'); ?>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Pengirim</label>
                         <div class="col-sm-8">
                            <strong><?= _ent($tiktok_packages->sender_name ?: 'TikTok Shop Partner Seller'); ?></strong>
                            <?php if (!empty($tiktok_packages->sender_phone)): ?>
                               <span class="text-muted">(<?= _ent($tiktok_packages->sender_phone); ?>)</span>
                            <?php endif; ?>
                            <div style="color: #64748b; font-size: 13px; margin-top: 2px;"><?= nl2br(_ent($tiktok_packages->sender_address ?: '-')); ?></div>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Penerima</label>
                         <div class="col-sm-8">
                            <strong><?= _ent($tiktok_packages->recipient_name ?: '-'); ?></strong>
                            <?php if (!empty($tiktok_packages->recipient_phone)): ?>
                               <span class="text-muted">(<?= _ent($tiktok_packages->recipient_phone); ?>)</span>
                            <?php endif; ?>
                            <div style="color: #64748b; font-size: 13px; margin-top: 2px;"><?= nl2br(_ent($tiktok_packages->recipient_address ?: '-')); ?></div>
                         </div>
                     </div>

                     <div class="form-group">
                         <label for="content" class="control-label">Waktu Dibuat</label>
                         <div class="col-sm-8">
                            <?= _ent($tiktok_packages->package_create_time ?: '-'); ?>
                         </div>
                     </div>

                     <!-- Sub-tabel Daftar Barang Paket -->
                     <div class="form-group">
                         <label class="control-label">Daftar Barang</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
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
                                                                 <img src="<?= _ent($img); ?>" alt="Gambar" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                                                             </a>
                                                         <?php else: ?>
                                                             <span class="text-muted">-</span>
                                                         <?php endif; ?>
                                                     </td>
                                                     <td style="vertical-align: middle;">
                                                         <strong style="color: #1e293b;"><?= _ent($prod_name); ?></strong>
                                                         <?php if (!empty($item->seller_sku)): ?>
                                                             <div class="text-muted" style="font-size: 12px;">SKU: <?= _ent($item->seller_sku); ?></div>
                                                         <?php endif; ?>
                                                     </td>
                                                     <td style="vertical-align: middle;"><span class="chip-id"><?= _ent($item->sku_id); ?></span></td>
                                                     <td style="text-align: center; vertical-align: middle; font-weight: 600;"><?= (int)$item->quantity; ?></td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         <?php else: ?>
                                             <tr>
                                                 <td colspan="4" style="text-align: center; color: #888; padding: 16px;">Tidak ada rincian barang yang tercatat pada paket ini.</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <!-- Sub-tabel Timeline Pelacakan Kurir -->
                     <div class="form-group">
                         <label class="control-label">Pelacakan Kurir</label>
                         <div class="col-sm-8">
                             <div class="sub-table-wrapper">
                                 <table class="sub-table">
                                     <thead>
                                         <tr>
                                             <th style="width: 170px;">Waktu Checkpoint</th>
                                             <th>Status Aktivitas Logistik</th>
                                             <th style="width: 120px; text-align: center;">Kode Status</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php if (!empty($tracking_events)): ?>
                                             <?php foreach ($tracking_events as $track): ?>
                                                 <tr>
                                                     <td style="vertical-align: middle;"><small style="color: #64748b; font-weight: 500;"><?= !empty($track['update_time_millis']) ? date('d-m-Y H:i:s', round($track['update_time_millis'] / 1000)) : '-'; ?></small></td>
                                                     <td style="vertical-align: middle;"><?= _ent($track['description'] ?? '-'); ?></td>
                                                     <td style="text-align: center; vertical-align: middle;"><span class="label label-info"><?= _ent($track['action_code'] ?? '-'); ?></span></td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         <?php else: ?>
                                             <tr>
                                                 <td colspan="3" style="text-align: center; color: #888; padding: 16px;">Belum ada aktivitas checkpoint scan kurir yang tercatat dari TikTok Shop API.</td>
                                             </tr>
                                         <?php endif; ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                     <div class="view-nav">
                         <a class="btn btn-flat btn-info" target="_blank" href="<?= site_url('administrator/tiktok_packages/print_label/' . $tiktok_packages->id); ?>"><i class="fa fa-print"></i> Cetak Label Resi</a>
                         <?php if (in_array(strtoupper($tiktok_packages->package_status), ['FULFILLING', 'AWAITING_SHIPMENT', 'READY_FOR_SHIPMENT'])): ?>
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
