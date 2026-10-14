<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="referrer" content="no-referrer"><title>Klaim Hadiah Pesanan · Vendio</title>
  <link rel="stylesheet" href="<?= base_url('asset/order_prizes/customer.css') ?>">
</head>
<body>
<main>
  <header><a class="brand" href="<?= site_url('order_prizes') ?>">VENDIO <span>REWARDS</span></a><span class="tag">Hadiah untuk pesananmu</span></header>
  <div class="layout">
    <section class="intro"><p class="eyebrow">BELANJA. PUTAR. DAPAT HADIAH.</p><h1>Pesanan sampai.<br>Kejutan <em>menanti.</em></h1><p class="lead">Cek nomor pesananmu, putar roda, dan temukan hadiah dari toko favoritmu.</p>
      <ol class="steps"><li><b>01</b><span>Verifikasi nomor pesanan & HP</span></li><li><b>02</b><span>Putar satu kali untuk setiap pesanan</span></li><li><b>03</b><span>Klaim hadiah sebelum batas waktunya</span></li></ol>
      <details><summary>Syarat & ketentuan campaign</summary><p id="op-terms">Buka link campaign dari toko untuk melihat ketentuan.</p></details>
      <p class="fine">Hasil dipilih oleh server berdasarkan peluang, ketersediaan, dan threshold campaign. Ukuran bagian roda tidak menggambarkan peluang menang. Tidak semua spin harus mendapat hadiah.</p>
    </section>
    <section class="card" aria-labelledby="op-title">
      <p class="eyebrow">ORDER PRIZES</p><h2 id="op-title">Cek pesananmu</h2><p id="op-subtitle">Gunakan nomor HP yang terdaftar pada pesanan.</p>
      <form id="op-verify">
        <label>Campaign <input name="slug" id="op-slug" autocomplete="off" placeholder="Kode campaign dari toko" maxlength="80" required></label>
        <button class="secondary" id="op-load" type="button">Lihat campaign</button>
        <label>Nomor pesanan <input name="order_number" autocomplete="off" placeholder="Contoh: 261014ABC123" maxlength="80" required></label>
        <label>Nomor HP <input name="phone" type="tel" autocomplete="tel" placeholder="08xxxxxxxxxx" maxlength="32" required></label>
        <label class="check"><input type="checkbox" name="accept_terms" value="1" required><span>Saya menyetujui syarat campaign dan penggunaan data untuk verifikasi serta pengurusan hadiah.</span></label>
        <label class="check"><input type="checkbox" name="marketing_consent" value="1"><span>Saya bersedia menerima promo/broadcast. <small>Opsional, tidak memengaruhi peluang.</small></span></label>
        <button type="submit" id="op-verify-button" disabled>Verifikasi pesanan →</button>
      </form>
      <div id="op-play" hidden>
        <div class="wheel-wrap"><span class="pointer" aria-hidden="true">▼</span><canvas id="op-wheel" width="600" height="600" aria-label="Roda hadiah, hasil akan diumumkan di bawah"></canvas><span class="wheel-center" aria-hidden="true">V</span></div>
        <button id="op-spin" type="button">Putar roda hadiah</button>
        <div id="op-result" hidden><p class="eyebrow">HASIL PESANANMU</p><h3 id="op-prize"></h3><p id="op-status"></p><button id="op-claim" type="button" hidden>Klaim hadiah</button></div>
        <button class="secondary" id="op-reset" type="button">Cek pesanan lain / verifikasi ulang</button>
      </div>
      <p id="op-message" class="message" role="status" aria-live="polite"></p>
      <p class="fine">Data pesanan tidak cocok? Hubungi toko. Nomor HP tersamarkan perlu diverifikasi terlebih dahulu oleh admin toko.</p>
    </section>
  </div>
  <footer>Vendio Rewards · Satu pesanan, satu kesempatan.</footer>
</main>
<script>
window.orderPrizesCustomer = <?= json_encode([
    'base'=>site_url('order_prizes'),
    'csrf'=>['name'=>$this->security->get_csrf_token_name(), 'hash'=>$this->security->get_csrf_hash()],
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>
<script src="<?= base_url('asset/order_prizes/customer.js') ?>" defer></script>
</body></html>
