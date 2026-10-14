<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header"><h1>Order Prizes <small>Campaign, hadiah & layanan pemenang</small></h1></section>
<section class="content" id="op-admin">
  <div class="box box-primary"><div class="box-body">
    <p><strong>Mulai:</strong> buat campaign draft → tambah hadiah fallback (stok kosong/unlimited, cost 0, tanpa threshold) → tambah hadiah lain → import order terverifikasi → aktifkan campaign.</p>
    <p>Nominal dalam rupiah bulat. Waktu Asia/Jakarta. Satu pesanan = satu hasil. Broadcast di sini hanya pencatatan, bukan pengiriman WhatsApp.</p>
    <div class="btn-group" id="op-tabs" role="navigation" aria-label="Modul Order Prizes"></div>
  </div></div>
  <div id="op-message" role="status" aria-live="polite"></div>
  <div class="box"><div class="box-body">
    <form id="op-filter" class="form-inline">
      <label>Pencarian <input class="form-control" name="q" placeholder="Nama / nomor order / HP"></label>
      <label id="op-campaign-filter">Campaign ID <input class="form-control" type="number" name="campaign_id" min="1" style="width:100px"></label>
      <label id="op-status-filter">Status klaim <select class="form-control" name="claim_status"><option value="">Semua</option><option>pending</option><option>claimed</option><option>expired</option><option>rejected</option><option>not_required</option></select></label>
      <button class="btn btn-default" type="submit">Cari</button>
      <button class="btn btn-primary" id="op-new" type="button">Tambah</button>
    </form>
    <p id="op-count" style="margin-top:15px"></p>
    <div class="table-responsive"><table class="table table-striped table-bordered"><thead id="op-head"></thead><tbody id="op-body"></tbody></table></div>
    <button class="btn btn-default" id="op-prev" type="button">← Sebelumnya</button>
    <button class="btn btn-default" id="op-next" type="button">Berikutnya →</button>
  </div></div>
  <div class="box box-info" id="op-editor" hidden><div class="box-header"><h3 class="box-title" id="op-editor-title"></h3></div><div class="box-body">
    <form id="op-form"><div class="row" id="op-fields"></div><button class="btn btn-primary" type="submit">Simpan</button> <button class="btn btn-default" id="op-cancel" type="button">Tutup</button></form>
  </div></div>
  <div class="box" id="op-import" hidden><div class="box-header"><h3 class="box-title">Import order CSV (atomik)</h3></div><div class="box-body">
    <p>Header persis: <code>order_number,phone,status,revenue,profit,ordered_at</code>. Maksimal 1000 baris / 2 MB. Duplicate atau satu baris tidak valid membatalkan seluruh import. Profit boleh kosong, HP tidak boleh masked.</p>
    <form id="op-import-form" class="form-inline"><label>Campaign ID <input class="form-control" name="campaign_id" type="number" min="1" required></label> <input name="file" type="file" accept=".csv,text/csv" required> <button class="btn btn-info" type="submit">Import CSV</button></form>
  </div></div>
  <div class="box" id="op-detail" hidden><div class="box-header"><h3 class="box-title">Detail / audit keputusan</h3></div><div class="box-body"><pre id="op-json" style="max-height:420px;overflow:auto"></pre><button class="btn btn-default" type="button" id="op-detail-close">Tutup</button></div></div>
</section>
<script>
window.orderPrizesAdmin = <?= json_encode([
    'base'=>site_url(ADMIN_NAMESPACE_URL . '/order_prizes'), 'publicUrl'=>site_url('order_prizes'),
    'csrf'=>['name'=>$this->security->get_csrf_token_name(), 'hash'=>$this->security->get_csrf_hash()],
    'manage'=>(bool)$can_manage, 'fulfill'=>(bool)$can_fulfill,
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>
<script src="<?= base_url('asset/order_prizes/admin.js') ?>" defer></script>
