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
      Pesanan Penjualan <small><?= cclang('detail', ['Pesanan Penjualan']); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= site_url('administrator/tiktok_orders'); ?>">Pesanan Penjualan</a></li>
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
                        <h3 class="widget-user-username">Pesanan Penjualan</h3>
                        <h5 class="widget-user-desc">Detail Pesanan Penjualan</h5>
                     </div>
                  </div>

                  <div class="form-horizontal" name="form_tiktok_orders" id="form_tiktok_orders">
                   
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600; color: #475569;"><?= _ent($tiktok_orders->id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nama Toko</label>
                        <div class="col-sm-8">
                           <?php if ($tiktok_orders->tiktok_shop_id): ?>
                              <span style="font-weight: 600; color: #0284c7;">
                                 <i class="fa fa-shopping-bag" style="color: #64748b; font-size: 12px; margin-right: 6px;"></i><?= _ent($tiktok_orders->tiktok_shops_shop_name ?: 'Toko #' . $tiktok_orders->tiktok_shop_id); ?>
                              </span>
                           <?php else: ?>
                              <span class="text-muted">-</span>
                           <?php endif; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID Pesanan</label>
                        <div class="col-sm-8">
                           <span class="chip-id"><?= _ent($tiktok_orders->order_id); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Status Pesanan</label>
                        <div class="col-sm-8">
                           <?= render_order_status_badge($tiktok_orders->order_status); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Metode Pembayaran</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->payment_method_name ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Catatan Pembeli</label>
                        <div class="col-sm-8">
                           <?= !empty($tiktok_orders->buyer_message) ? _ent($tiktok_orders->buyer_message) : '<span class="text-muted" style="font-style: italic;">Tidak ada catatan</span>'; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Alasan Pembatalan</label>
                        <div class="col-sm-8">
                           <?= !empty($tiktok_orders->cancel_reason) ? _ent($tiktok_orders->cancel_reason) : '<span class="text-muted">-</span>'; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nama Penerima</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 600; color: #0f172a;"><?= _ent($tiktok_orders->recipient_name ?: '-'); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nomor Telepon Penerima</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->recipient_phone ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Alamat Penerima</label>
                        <div class="col-sm-8" style="max-width: 750px; line-height: 1.6; color: #475569;">
                           <?= _ent($tiktok_orders->recipient_address ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Kurir Pengiriman</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->shipping_provider ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Tipe Pengiriman</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->shipping_type ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Opsi Layanan Pengiriman</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->delivery_option_name ?: '-'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Nomor Resi</label>
                        <div class="col-sm-8">
                           <?php if (!empty($tiktok_orders->tracking_number)): ?>
                              <span style="font-family: monospace; font-size: 13px; font-weight: 600; color: #1e293b;"><?= _ent($tiktok_orders->tracking_number); ?></span>
                           <?php else: ?>
                              <span class="text-muted">-</span>
                           <?php endif; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">ID Paket</label>
                        <div class="col-sm-8" style="display: flex; align-items: center; gap: 8px;">
                           <?php if (!empty($tiktok_orders->package_id)): 
                              $pkg_row = $this->db->get_where('tiktok_packages', ['package_id' => $tiktok_orders->package_id])->row();
                           ?>
                              <span class="chip-id" style="color: #db2777; background-color: #fdf2f8; border-color: #fce7f3; font-weight: 600;"><?= _ent($tiktok_orders->package_id); ?></span>
                              <?php if ($pkg_row): ?>
                                 <a href="<?= site_url('administrator/tiktok_packages/view/' . $pkg_row->id); ?>" class="btn btn-xs btn-flat btn-info" style="border-radius: 4px; padding: 3px 9px; font-weight: 600;">
                                    <i class="fa fa-cube"></i> Lihat Pengiriman Paket
                                 </a>
                              <?php endif; ?>
                           <?php else: ?>
                              <span class="text-muted">-</span>
                           <?php endif; ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Total Pembayaran</label>
                        <div class="col-sm-8">
                           <span style="font-weight: 700; color: #0f172a; font-size: 14.5px;">Rp <?= number_format($tiktok_orders->total_amount, 0, ',', '.'); ?></span>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Biaya Pengiriman</label>
                        <div class="col-sm-8">
                           Rp <?= number_format($tiktok_orders->shipping_fee, 0, ',', '.'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Diskon Penjual</label>
                        <div class="col-sm-8">
                           Rp <?= number_format($tiktok_orders->seller_discount, 0, ',', '.'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Diskon TikTok</label>
                        <div class="col-sm-8">
                           Rp <?= number_format($tiktok_orders->tiktok_discount, 0, ',', '.'); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Waktu Pesanan Dibuat</label>
                        <div class="col-sm-8">
                           <?= _ent($tiktok_orders->order_created_time); ?>
                        </div>
                     </div>
                                         
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Waktu Pembayaran</label>
                        <div class="col-sm-8">
                           <?= !empty($tiktok_orders->order_paid_time) ? _ent($tiktok_orders->order_paid_time) : '<span class="text-muted">-</span>'; ?>
                        </div>
                     </div>

                     <!-- Sub-tabel Produk Dipesan -->
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Produk Dipesan</label>
                        <div class="col-sm-8">
                           <div class="sub-table-wrapper">
                              <table class="table sub-table">
                                 <thead>
                                    <tr>
                                       <th style="width: 70px; text-align: center;">Gambar</th>
                                       <th>Nama Produk</th>
                                       <th style="width: 130px;">Harga Satuan</th>
                                       <th style="width: 70px; text-align: center;">Qty</th>
                                       <th style="width: 140px; text-align: right;">Subtotal</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!empty($order_items)): ?>
                                       <?php foreach ($order_items as $item): ?>
                                       <tr>
                                          <td style="text-align: center; vertical-align: middle;">
                                             <?php if (!empty($item->sku_image)): ?>
                                                <a class="fancybox" rel="group" href="<?= $item->sku_image; ?>">
                                                   <img src="<?= $item->sku_image; ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;" alt="item">
                                                </a>
                                             <?php else: ?>
                                                <span class="text-muted">-</span>
                                             <?php endif; ?>
                                          </td>
                                          <td style="vertical-align: middle;">
                                             <div style="font-weight: 600; color: #1e293b;"><?= _ent($item->product_name); ?></div>
                                             <?php if (!empty($item->seller_sku)): ?>
                                                <small class="text-muted">(SKU: <?= _ent($item->seller_sku); ?>)</small>
                                             <?php endif; ?>
                                          </td>
                                          <td style="vertical-align: middle;">Rp <?= number_format($item->item_price, 0, ',', '.'); ?></td>
                                          <td style="text-align: center; vertical-align: middle; font-weight: 600;"><?= $item->quantity; ?></td>
                                          <td style="text-align: right; vertical-align: middle; font-weight: 600; color: #1e293b;">
                                             Rp <?= number_format($item->item_price * $item->quantity, 0, ',', '.'); ?>
                                          </td>
                                       </tr>
                                       <?php endforeach; ?>
                                    <?php else: ?>
                                       <tr>
                                          <td colspan="5" class="text-center text-muted" style="padding: 20px;">Tidak ada rincian produk.</td>
                                       </tr>
                                    <?php endif; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <!-- Rincian Finansial Pesanan (Price Detail Breakdown) -->
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Rincian Finansial Pesanan</label>
                        <div class="col-sm-8">
                           <div class="sub-table-wrapper">
                              <table class="table sub-table">
                                 <thead>
                                    <tr>
                                       <th>Komponen Finansial</th>
                                       <th style="width: 220px; text-align: right;">Jumlah (IDR)</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!empty($price_details)): ?>
                                       <tr>
                                          <td>Harga Asli Produk (Subtotal Kotor)</td>
                                          <td style="text-align: right;">Rp <?= number_format($price_details->original_product_price, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php if ($price_details->seller_discount > 0): ?>
                                       <tr>
                                          <td>Diskon Penjual</td>
                                          <td style="text-align: right; color: #dd4b39;">- Rp <?= number_format($price_details->seller_discount, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php endif; ?>
                                       <?php if ($price_details->platform_discount > 0): ?>
                                       <tr>
                                          <td>Diskon Platform TikTok</td>
                                          <td style="text-align: right; color: #0073b7;">- Rp <?= number_format($price_details->platform_discount, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php endif; ?>
                                       <tr>
                                          <td><strong>Subtotal Produk Bersih</strong></td>
                                          <td style="text-align: right;"><strong>Rp <?= number_format($price_details->subtotal, 0, ',', '.'); ?></strong></td>
                                       </tr>
                                       <tr>
                                          <td>Ongkos Kirim Asli</td>
                                          <td style="text-align: right;">Rp <?= number_format($price_details->original_shipping_fee, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php if ($price_details->shipping_fee_platform_discount > 0): ?>
                                       <tr>
                                          <td>Subsidi Ongkir Platform TikTok</td>
                                          <td style="text-align: right; color: #00a65a;">- Rp <?= number_format($price_details->shipping_fee_platform_discount, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php endif; ?>
                                       <?php if ($price_details->shipping_fee_seller_discount > 0): ?>
                                       <tr>
                                          <td>Diskon Ongkir Penjual</td>
                                          <td style="text-align: right; color: #dd4b39;">- Rp <?= number_format($price_details->shipping_fee_seller_discount, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php endif; ?>
                                       <tr>
                                          <td>Ongkos Kirim Dibayar Pembeli</td>
                                          <td style="text-align: right;">Rp <?= number_format($price_details->buyer_shipping_fee, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php if ($price_details->tax > 0): ?>
                                       <tr>
                                          <td>Pajak</td>
                                          <td style="text-align: right;">Rp <?= number_format($price_details->tax, 0, ',', '.'); ?></td>
                                       </tr>
                                       <?php endif; ?>
                                       <tr style="background-color: #f8fafc;">
                                          <td><strong>Total Pembayaran Pembeli</strong></td>
                                          <td style="text-align: right; font-weight: 700; color: #0f172a;">Rp <?= number_format($price_details->total_buyer_payment, 0, ',', '.'); ?></td>
                                       </tr>
                                       <tr style="background-color: #f0fdf4;">
                                          <td style="color: #166534;"><strong>Estimasi Pendapatan Penjual</strong></td>
                                          <td style="text-align: right; color: #166534; font-weight: 700;">Rp <?= number_format($price_details->seller_revenue, 0, ',', '.'); ?></td>
                                       </tr>
                                    <?php else: ?>
                                       <tr>
                                          <td>Subtotal Produk</td>
                                          <td style="text-align: right;">Rp <?= number_format($tiktok_orders->total_amount - $tiktok_orders->shipping_fee, 0, ',', '.'); ?></td>
                                       </tr>
                                       <tr>
                                          <td>Ongkos Kirim</td>
                                          <td style="text-align: right;">Rp <?= number_format($tiktok_orders->shipping_fee, 0, ',', '.'); ?></td>
                                       </tr>
                                       <tr style="background-color: #f8fafc;">
                                          <td><strong>Total Pembayaran Pembeli</strong></td>
                                          <td style="text-align: right; font-weight: 700; color: #0f172a;">Rp <?= number_format($tiktok_orders->total_amount, 0, ',', '.'); ?></td>
                                       </tr>
                                    <?php endif; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <!-- Riwayat Perubahan Status (Status Logs) -->
                     <div class="form-group">
                        <label for="content" class="col-sm-2 control-label">Riwayat Status Pesanan</label>
                        <div class="col-sm-8">
                           <div class="sub-table-wrapper">
                              <table class="table sub-table">
                                 <thead>
                                    <tr>
                                       <th style="width: 170px;">Waktu</th>
                                       <th style="width: 150px;">Status Sebelumnya</th>
                                       <th style="width: 150px;">Status Baru</th>
                                       <th>Keterangan / Alasan</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php if (!empty($status_logs)): ?>
                                       <?php foreach ($status_logs as $log): ?>
                                       <tr>
                                          <td style="color: #64748b; font-size: 12.5px; white-space: nowrap; vertical-align: middle;">
                                             <?= date('d/m/Y H:i:s', strtotime($log->created_at)); ?>
                                          </td>
                                          <td style="vertical-align: middle;"><?= render_order_status_badge($log->previous_status); ?></td>
                                          <td style="vertical-align: middle;"><?= render_order_status_badge($log->new_status); ?></td>
                                          <td style="vertical-align: middle; color: #475569;"><?= _ent($log->reason ?: '-'); ?></td>
                                       </tr>
                                       <?php endforeach; ?>
                                    <?php else: ?>
                                       <tr>
                                          <td colspan="4" class="text-center text-muted" style="padding: 20px;">Belum ada riwayat perubahan status tercatat.</td>
                                       </tr>
                                    <?php endif; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>

                     <!-- Footer Action Buttons (Same Colors, Clean Layout) -->
                     <div class="view-nav">
                        <?php if ($tiktok_orders->order_status == 'AWAITING_SHIPMENT'): ?>
                           <a class="btn btn-flat btn-default btn_action" title="Atur Pengiriman (Drop-off ke gerai)" href="<?= site_url('administrator/tiktok_orders/ship/'.$tiktok_orders->id); ?>">
                              <i class="fa fa-truck"></i> Atur Pengiriman
                           </a>
                        <?php elseif (in_array($tiktok_orders->order_status, ['AWAITING_COLLECTION', 'IN_TRANSIT', 'DELIVERED', 'COMPLETED'])): ?>
                           <a class="btn btn-flat btn-default btn_action" target="_blank" title="Cetak Label Resi (AWB PDF)" href="<?= site_url('administrator/tiktok_orders/print_label/'.$tiktok_orders->id); ?>">
                              <i class="fa fa-barcode"></i> Cetak Label Resi
                           </a>
                           <a class="btn btn-flat btn-default btn_action" target="_blank" title="Cetak Daftar Pengemasan (Packing List PDF)" href="<?= site_url('administrator/tiktok_orders/print_packing_slip/' . $tiktok_orders->id); ?>">
                              <i class="fa fa-archive"></i> Cetak Daftar Pengemasan
                           </a>
                        <?php endif; ?>
                        
                        <a class="btn btn-flat btn-default btn_action" target="_blank" title="Cetak Daftar Pengambilan Barang (Pick List)" href="<?= site_url('administrator/tiktok_orders/print_pick_list/' . $tiktok_orders->id); ?>">
                           <i class="fa fa-clipboard"></i> Cetak Pengambilan Barang
                        </a>

                        <?php if ($tiktok_orders->order_status != 'CANCELLED'): ?>
                           <a class="btn btn-flat btn-default btn_action cancel-data" href="javascript:void(0);" data-href="<?= site_url('administrator/tiktok_orders/cancel/' . $tiktok_orders->id); ?>" title="Batalkan Pesanan">
                              <i class="fa fa-ban"></i> Batalkan Pesanan
                           </a>
                        <?php endif; ?>

                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/tiktok_orders/'); ?>">
                           <i class="fa fa-undo"></i> <?= cclang('go_list_button', ['Tiktok Orders']); ?>
                        </a>
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

<script>
$(document).on('click', '.cancel-data', function(){
  var url = $(this).attr('data-href');
  swal({
      title: 'Batalkan Pesanan?',
      text: 'Pesanan ini akan dibatalkan di TikTok Shop dan Vendio. Apakah Anda yakin?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Ya, Batalkan!',
      cancelButtonText: 'Batal',
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
</script>
