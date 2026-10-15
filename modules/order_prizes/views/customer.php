<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="referrer" content="no-referrer">
  <title>Vendio Rewards · Putar Roda Hadiah Pesanan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('asset/order_prizes/customer.css'); ?>">
</head>
<body>
<div class="glow-bg"></div>

<main>
  <header class="app-header">
    <div class="brand">
      <div class="brand-logo">V</div>
      <div class="brand-text">
        <strong>VENDIO</strong>
        <span>REWARDS</span>
      </div>
    </div>
    <div class="header-tag">
      <span class="status-dot"></span>
      <span id="op-channel-badge">Hadiah Pembeli Terverifikasi</span>
    </div>
  </header>

  <div class="app-layout">
    <!-- Left Hero Information -->
    <section class="hero-section">
      <div class="pill-badge">
        <span class="sparkle">✨</span> PROMO SPESIAL PEMBELI
      </div>
      <h1 class="hero-title">
        Terima kasih sudah belanja.<br>
        Saatnya <em>bawa pulang hadiah!</em>
      </h1>
      <p class="hero-desc">
        Masukkan nomor pesanan dari marketplace favoritmu dan putar roda keberuntungan untuk memenangkan hadiah langsung.
      </p>

      <div class="steps-flow">
        <div class="step-card">
          <div class="step-num">01</div>
          <div class="step-info">
            <strong>Input Pesanan & HP</strong>
            <span>Nomor pesanan & HP yang terdaftar di marketplace.</span>
          </div>
        </div>
        <div class="step-card">
          <div class="step-num">02</div>
          <div class="step-info">
            <strong>Putar Roda Keberuntungan</strong>
            <span>Satu pesanan mendapatkan 1 kali kesempatan spin.</span>
          </div>
        </div>
        <div class="step-card">
          <div class="step-num">03</div>
          <div class="step-info">
            <strong>Klaim Hadiahmu</strong>
            <span>Konfirmasi klaim sebelum batas masa penukaran habis.</span>
          </div>
        </div>
      </div>

      <div class="terms-card">
        <details>
          <summary>Syarat & Ketentuan Campaign</summary>
          <div id="op-terms" class="terms-content">
            Memuat syarat & ketentuan campaign...
          </div>
        </details>
      </div>

      <p class="disclaimer-text">
        * Hadiah dipilih transparan oleh sistem berdasarkan ketersediaan kuota stok dan aturan promo yang sah. Keputusan undian bersifat final.
      </p>
    </section>

    <!-- Right Interaction Card -->
    <section class="action-card">
      <div class="card-header-inner">
        <span class="eyebrow" id="op-campaign-badge">LUCKY DRAW</span>
        <h2 id="op-title" class="card-title">Cek Hadiah Pesanan</h2>
        <p id="op-subtitle" class="card-subtitle">Gunakan nomor HP yang terdaftar pada pesananmu.</p>
      </div>


      <!-- Verification Form -->
      <form id="op-verify" class="verify-form">
        <input type="hidden" name="slug" id="op-slug" value="<?= html_escape($slug); ?>">
        
        <div class="form-item">
          <label for="op-order-number">Nomor Pesanan</label>
          <div class="input-wrapper">
            <span class="input-icon">#</span>
            <input type="text" name="order_number" id="op-order-number" autocomplete="off" placeholder="Contoh: 261014ABC123" maxlength="80" required>
          </div>
          <span class="field-hint">Dapat dilihat di rincian pesanan marketplace kamu.</span>
        </div>

        <div class="form-item">
          <label for="op-phone">Nomor WhatsApp / HP</label>
          <div class="input-wrapper">
            <span class="input-icon">📞</span>
            <input type="tel" name="phone" id="op-phone" autocomplete="tel" placeholder="08xxxxxxxxxx / 628xxxxxxxxxx" maxlength="25" required>
          </div>
          <span class="field-hint">Nomor telepon penerima yang tertera pada pesanan.</span>
        </div>

        <div class="consent-group">
          <label class="custom-checkbox">
            <input type="checkbox" name="accept_terms" value="1" required checked>
            <span class="checkmark"></span>
            <span class="label-text">Saya menyetujui syarat & ketentuan campaign undian serta verifikasi data pesanan.</span>
          </label>
          <label class="custom-checkbox">
            <input type="checkbox" name="marketing_consent" value="1" checked>
            <span class="checkmark"></span>
            <span class="label-text">Bersedia menerima info voucher diskon & update promo menarik via WhatsApp.</span>
          </label>
        </div>

        <button type="submit" id="op-verify-button" class="btn-primary-action" disabled>
          <span>Verifikasi Pesanan Saya</span> →
        </button>
      </form>

      <!-- Wheel Playground Box -->
      <div id="op-play" class="wheel-box" hidden>
        <div class="wheel-container">
          <div class="pointer-wrapper">
            <div class="wheel-pointer">▼</div>
          </div>
          <canvas id="op-wheel" width="600" height="600" aria-label="Roda Undian Berhadiah"></canvas>
          <div class="wheel-hub">
            <span class="hub-icon">★</span>
          </div>
        </div>

        <button id="op-spin" type="button" class="btn-spin-action">
          <span class="spin-text">PUTAR RODA SEKARANG!</span>
        </button>

        <!-- Result Box -->
        <div id="op-result" class="winner-card" hidden>
          <div class="win-crown">👑</div>
          <p class="win-eyebrow">SELAMAT! KAMU MEMENANGKAN</p>
          <h3 id="op-prize" class="prize-title"></h3>
          <p id="op-status" class="prize-status-note"></p>
        </div>

        <button class="btn-reset-action" id="op-reset" type="button">
          ← Cek Pesanan Lain / Verifikasi Ulang
        </button>
      </div>

      <div id="op-message" class="system-message" role="status" aria-live="polite"></div>
    </section>
  </div>

  <footer class="app-footer">
    <div>&copy; <?= date('Y'); ?> Vendio Rewards. Program loyalty & hadiah pembeli terpercaya.</div>
  </footer>
</main>

<!-- Confetti Canvas for Celebrations -->
<canvas id="confetti-canvas"></canvas>

<script>
window.orderPrizesCustomer = <?= json_encode([
    'base' => site_url('order_prizes'),
    'slug' => $slug,
    'csrf' => ['name' => $this->security->get_csrf_token_name(), 'hash' => $this->security->get_csrf_hash()],
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>
<script src="<?= base_url('asset/order_prizes/customer.js'); ?>" defer></script>
</body>
</html>
