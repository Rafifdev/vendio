(function () {
  'use strict';

  const cfg = window.orderPrizesCustomer;
  const el = id => document.getElementById('op-' + id);
  let token = null, campaign = null, busy = false, rotation = 0;

  // Sound Synthesizer via Web Audio API (Zero external assets needed!)
  const audioCtx = window.AudioContext || window.webkitAudioContext ? new (window.AudioContext || window.webkitAudioContext)() : null;

  function playTickSound() {
    if (!audioCtx) return;
    try {
      if (audioCtx.state === 'suspended') audioCtx.resume();
      const osc = audioCtx.createOscillator();
      const gain = audioCtx.createGain();
      osc.type = 'triangle';
      osc.frequency.setValueAtTime(440, audioCtx.currentTime);
      osc.frequency.exponentialRampToValueAtTime(880, audioCtx.currentTime + 0.05);
      gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
      gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.05);
      osc.connect(gain);
      gain.connect(audioCtx.destination);
      osc.start();
      osc.stop(audioCtx.currentTime + 0.05);
    } catch (_) {}
  }

  function playWinFanfare() {
    if (!audioCtx) return;
    try {
      if (audioCtx.state === 'suspended') audioCtx.resume();
      const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
      notes.forEach((freq, idx) => {
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(freq, audioCtx.currentTime + idx * 0.12);
        gain.gain.setValueAtTime(0.12, audioCtx.currentTime + idx * 0.12);
        gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + idx * 0.12 + 0.35);
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.start(audioCtx.currentTime + idx * 0.12);
        osc.stop(audioCtx.currentTime + idx * 0.12 + 0.35);
      });
    } catch (_) {}
  }

  // Lightweight Fullscreen Confetti Particle Engine
  function launchConfetti() {
    const canvas = document.getElementById('confetti-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];
    const colors = ['#10b981', '#f59e0b', '#3b82f6', '#ec4899', '#8b5cf6', '#ffffff'];

    for (let i = 0; i < 90; i++) {
      particles.push({
        x: canvas.width / 2,
        y: canvas.height / 2,
        vx: (Math.random() - 0.5) * 16,
        vy: (Math.random() - 0.7) * 18,
        size: Math.random() * 8 + 4,
        color: colors[Math.floor(Math.random() * colors.length)],
        rotation: Math.random() * 360,
        rSpeed: (Math.random() - 0.5) * 8,
        gravity: 0.35,
        opacity: 1
      });
    }

    let animationId;
    function render() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      let alive = 0;

      particles.forEach(p => {
        p.x += p.vx;
        p.y += p.vy;
        p.vy += p.gravity;
        p.rotation += p.rSpeed;
        p.opacity -= 0.008;

        if (p.opacity > 0) {
          alive++;
          ctx.save();
          ctx.translate(p.x, p.y);
          ctx.rotate((p.rotation * Math.PI) / 180);
          ctx.globalAlpha = Math.max(0, p.opacity);
          ctx.fillStyle = p.color;
          ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size);
          ctx.restore();
        }
      });

      if (alive > 0) {
        animationId = requestAnimationFrame(render);
      } else {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        cancelAnimationFrame(animationId);
      }
    }
    render();
  }

  function message(text, error = false) {
    const msgEl = el('message');
    msgEl.textContent = text;
    msgEl.className = 'system-message ' + (error ? 'error' : 'success');
  }

  async function api(path, data) {
    const options = { credentials: 'same-origin', headers: { Accept: 'application/json' } };
    if (data) {
      const body = data instanceof FormData ? data : new FormData();
      if (!(data instanceof FormData)) {
        Object.entries(data).forEach(([k, v]) => body.set(k, v));
      }
      body.set(cfg.csrf.name, cfg.csrf.hash);
      options.method = 'POST';
      options.body = body;
    }
    const res = await fetch(cfg.base + '/' + path, options);
    let json;
    try {
      json = await res.json();
    } catch (_) {
      throw new Error('Sesi tidak valid atau server belum tersedia. Silakan muat ulang halaman.');
    }
    if (json.csrf) cfg.csrf = json.csrf;
    if (!res.ok || !json.success) throw new Error(json.message || 'Permintaan gagal diproses.');
    return json.data;
  }

  async function task(work) {
    if (busy) return;
    busy = true;
    document.querySelectorAll('button').forEach(b => b.disabled = true);
    message('Sedang memproses data...');
    try {
      await work();
    } catch (err) {
      message(err.message, true);
    } finally {
      busy = false;
      document.querySelectorAll('button').forEach(b => b.disabled = false);
      el('verify-button').disabled = !campaign || !campaign.is_open;
    }
  }

  function drawWheel() {
    const canvas = el('wheel');
    const ctx = canvas.getContext('2d');
    const prizes = campaign.prizes;
    ctx.clearRect(0, 0, 600, 600);

    const count = Math.max(prizes.length, 1);
    const angle = (2 * Math.PI) / count;
    
    // Vibrant modern color palette
    const sliceColors = [
      '#059669', '#10b981', '#047857', '#065f46',
      '#0f766e', '#0d9488', '#14b8a6', '#0284c7'
    ];

    prizes.forEach((p, i) => {
      const start = i * angle - Math.PI / 2;
      ctx.beginPath();
      ctx.moveTo(300, 300);
      ctx.arc(300, 300, 296, start, start + angle);
      ctx.closePath();
      ctx.fillStyle = sliceColors[i % sliceColors.length];
      ctx.fill();

      // Border between slices
      ctx.lineWidth = 3;
      ctx.strokeStyle = '#1e293b';
      ctx.stroke();

      // Text label
      ctx.save();
      ctx.translate(300, 300);
      ctx.rotate(start + angle / 2);
      ctx.fillStyle = '#ffffff';
      ctx.font = 'bold 18px "Plus Jakarta Sans", sans-serif';
      ctx.textAlign = 'right';
      ctx.shadowColor = 'rgba(0,0,0,0.5)';
      ctx.shadowBlur = 4;
      const name = p.name.length > 20 ? p.name.slice(0, 18) + '…' : p.name;
      ctx.fillText(name, 260, 6, 185);
      ctx.restore();
    });
  }

  function showResult(result) {
    el('spin').hidden = true;
    el('result').hidden = false;
    el('prize').textContent = result.prize_name;

    const text = {
      pending: 'Hadiah berhasil didapat! Silakan klik Klaim sebelum ',
      claimed: 'Klaim Anda telah berhasil dicatat. Tim toko akan segera menghubungi Anda.',
      expired: 'Batas waktu klaim hadiah ini telah berakhir.',
      rejected: 'Klaim hadiah ditolak. Silakan hubungi customer service toko.',
      not_required: 'Terima kasih atas partisipasi Anda! Belanja lagi untuk kesempatan berikutnya.'
    };

    var deadlineStr = result.claim_deadline ? ' (' + result.claim_deadline + ' WIB).' : '';
    el('status').textContent = (text[result.claim_status] || result.claim_status) + (result.claim_status === 'pending' ? deadlineStr : '');
    el('claim').hidden = result.claim_status !== 'pending';

    if (result.prize_kind !== 'none') {
      playWinFanfare();
      launchConfetti();
    }
  }

  async function loadCampaign(slug) {
    campaign = null;
    el('verify-button').disabled = true;
    const data = await api('campaign?slug=' + encodeURIComponent(slug));
    campaign = data;
    
    el('title').textContent = data.name;
    el('terms').textContent = data.terms;
    el('slug').value = data.slug;
    
    if (el('op-campaign-badge')) {
      el('op-campaign-badge').textContent = data.name.toUpperCase();
    }

    drawWheel();
    message(data.is_open ? 'Campaign siap dimainkan. Masukkan nomor pesanan & HP Anda.' : 'Event ini sedang ditutup atau belum dimulai. Pesanan yang sudah spin tetap dapat diverifikasi untuk klaim.');
  }

  // Handle Campaign Dropdown Selection (if multiple active)
  const selectCampaign = document.getElementById('select-campaign');
  if (selectCampaign) {
    selectCampaign.addEventListener('change', function () {
      task(async () => {
        await loadCampaign(this.value);
      });
    });
  }

  // Auto uppercase order number
  const orderInput = el('order-number');
  if (orderInput) {
    orderInput.addEventListener('input', function () {
      this.value = this.value.toUpperCase().replace(/[^\w-]/g, '');
    });
  }

  // Verify Form Submission
  el('verify').addEventListener('submit', e => {
    e.preventDefault();
    task(async () => {
      const slugVal = el('slug').value.trim();
      if (!campaign || slugVal !== campaign.slug) {
        throw new Error('Pilih atau muat campaign terlebih dahulu.');
      }

      const data = await api('verify', new FormData(e.target));
      token = data.token;

      el('verify').hidden = true;
      el('play').hidden = false;
      el('result').hidden = true;
      el('spin').hidden = false;

      if (data.already_spun) {
        showResult(data.result);
        message('Pesanan ini sudah pernah memutar roda undian. Berikut adalah hasil tersimpan Anda.');
      } else {
        message('Pesanan berhasil diverifikasi! Klik tombol di bawah untuk memutar roda hadiah.');
      }
    });
  });

  // Spin Wheel Action
  el('spin').onclick = () => task(async () => {
    // 1. Award is calculated and safely persisted on the server FIRST
    const result = await api('spin', { token });

    if (!campaign.prizes.some(p => String(p.id) === String(result.prize_id))) {
      campaign.prizes.push({ id: result.prize_id, name: result.prize_name });
      drawWheel();
    }

    const index = campaign.prizes.findIndex(p => String(p.id) === String(result.prize_id));
    const target = (360 - (index + 0.5) * (360 / campaign.prizes.length)) % 360;
    rotation += 1800 + ((target - (rotation % 360) + 360) % 360);

    el('wheel').style.transform = 'rotate(' + rotation + 'deg)';

    // Play tick sound during spin
    let tickInterval = setInterval(playTickSound, 120);
    setTimeout(() => {
      clearInterval(tickInterval);
      tickInterval = setInterval(playTickSound, 220);
    }, 2000);
    setTimeout(() => {
      clearInterval(tickInterval);
      tickInterval = setInterval(playTickSound, 400);
    }, 3000);
    setTimeout(() => clearInterval(tickInterval), 3600);

    // Wait for wheel animation
    await new Promise(resolve => setTimeout(resolve, 3800));

    showResult(result);
    message('Hasil tersimpan dengan aman.');
  });

  // Claim Prize Action
  el('claim').onclick = () => task(async () => {
    const res = await api('claim', { token });
    showResult(res);
    message('Hadiah Anda berhasil diklaim! Operator toko akan segera menghubungi nomor WhatsApp Anda.');
  });

  // Reset / Check Another Order
  el('reset').onclick = () => {
    token = null;
    el('verify').hidden = false;
    el('play').hidden = true;
    message('Masukkan nomor pesanan lainnya atau verifikasi ulang pesanan yang sama.');
  };

  // Initial Boot
  const initSlug = cfg.slug || new URLSearchParams(location.search).get('campaign');
  if (initSlug) {
    el('slug').value = initSlug;
    task(async () => {
      await loadCampaign(initSlug);
    });
  }
})();
