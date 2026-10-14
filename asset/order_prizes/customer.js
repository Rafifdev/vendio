(function () {
  'use strict';
  const cfg=window.orderPrizesCustomer, el=id=>document.getElementById('op-' + id);
  let token=null, campaign=null, busy=false, rotation=0;
  function message(text, error=false) { el('message').textContent=text; el('message').classList.toggle('error',error); }
  async function api(path, data) {
    const options={credentials:'same-origin',headers:{Accept:'application/json'}};
    if (data) { const body=data instanceof FormData ? data : new FormData(); if (!(data instanceof FormData)) Object.entries(data).forEach(([k,v])=>body.set(k,v)); body.set(cfg.csrf.name,cfg.csrf.hash); options.method='POST'; options.body=body; }
    const res=await fetch(cfg.base + '/' + path, options);
    let json;
    try { json=await res.json(); } catch (_) { throw new Error('Sesi tidak valid atau server belum tersedia. Muat ulang halaman.'); }
    if (json.csrf) cfg.csrf=json.csrf;
    if (!res.ok || !json.success) throw new Error(json.message || 'Permintaan gagal.');
    return json.data;
  }
  async function task(work) {
    if (busy) return;
    busy=true; document.querySelectorAll('button').forEach(b=>b.disabled=true); message('Sedang diproses…');
    try { await work(); } catch (err) { message(err.message,true); }
    finally { busy=false; document.querySelectorAll('button').forEach(b=>b.disabled=false); el('verify-button').disabled=!campaign; }
  }
  function draw() {
    const canvas=el('wheel'), ctx=canvas.getContext('2d'), prizes=campaign.prizes;
    ctx.clearRect(0,0,600,600);
    const angle=2*Math.PI/Math.max(prizes.length,1), colors=['#265d42','#e6edc2','#91b692','#f6d881','#c5d6c0','#628770'];
    prizes.forEach((p,i)=>{
      const start=i*angle-Math.PI/2;
      ctx.beginPath(); ctx.moveTo(300,300); ctx.arc(300,300,298,start,start+angle); ctx.closePath(); ctx.fillStyle=colors[i%colors.length]; ctx.fill();
      ctx.save(); ctx.translate(300,300); ctx.rotate(start+angle/2); ctx.fillStyle=i%colors.length===0 || i%colors.length===5 ? '#fff' : '#173c2b'; ctx.font='bold 20px sans-serif'; ctx.textAlign='right';
      const name=p.name.length>19 ? p.name.slice(0,17)+'…' : p.name; ctx.fillText(name,265,7,195); ctx.restore();
    });
  }
  function showResult(result) {
    el('spin').hidden=true; el('result').hidden=false; el('prize').textContent=result.prize_name;
    const text={pending:'Hadiah menunggumu. Klik klaim sebelum ',claimed:'Klaim sudah diterima. Tim toko akan menindaklanjuti.',expired:'Batas klaim sudah lewat. Hubungi toko jika perlu bantuan.',rejected:'Klaim ditolak. Hubungi toko untuk informasi.',not_required:'Terima kasih sudah ikut. Coba lagi dengan pesanan berikutnya.'};
    el('status').textContent=(text[result.claim_status] || result.claim_status)+(result.claim_status==='pending' ? result.claim_deadline+' WIB.' : '')+' Status hadiah: '+result.prize_status+'.';
    el('claim').hidden=result.claim_status!=='pending';
  }
  async function loadCampaign() {
    campaign=null; el('verify-button').disabled=true;
    const data=await api('campaign?slug='+encodeURIComponent(el('slug').value.trim()));
    campaign=data; el('title').textContent=data.name; el('terms').textContent=data.terms; draw(); message(data.is_open ? 'Campaign siap. Masukkan nomor pesanan dan HP.' : 'Campaign belum/tidak aktif. Pesanan yang sudah spin tetap bisa diverifikasi untuk melihat hasil dan mengurus klaim.');
  }
  el('load').onclick=()=>task(loadCampaign);
  el('slug').addEventListener('input',()=>{ campaign=null; el('verify-button').disabled=true; el('terms').textContent='Klik Lihat campaign untuk memuat syarat terbaru.'; });
  el('verify').addEventListener('submit',e=>{ e.preventDefault(); task(async()=>{
    if (!campaign || el('slug').value.trim()!==campaign.slug) throw new Error('Muat campaign terlebih dahulu.');
    const data=await api('verify',new FormData(e.target)); token=data.token;
    el('verify').hidden=true; el('play').hidden=false; el('result').hidden=true; el('spin').hidden=false;
    if (data.already_spun) showResult(data.result);
    message(data.already_spun ? 'Pesanan ini sudah spin. Ini hasil yang tersimpan.' : 'Pesanan terverifikasi. Saatnya putar roda!');
  }); });
  el('spin').onclick=()=>task(async()=>{
    const result=await api('spin',{token}); // Award is persisted BEFORE the animation, never inferred from angle.
    if (!campaign.prizes.some(p=>String(p.id)===String(result.prize_id))) { campaign.prizes.push({id:result.prize_id,name:result.prize_name}); draw(); }
    const index=campaign.prizes.findIndex(p=>String(p.id)===String(result.prize_id));
    const target=(360-(index+0.5)*(360/campaign.prizes.length))%360;
    rotation+=1800+((target-(rotation%360)+360)%360);
    el('wheel').style.transform='rotate('+rotation+'deg)';
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) await new Promise(resolve=>setTimeout(resolve,3500));
    showResult(result); message('Hasil tersimpan. Memuat ulang atau mengulang request tidak memberi spin baru.');
  });
  el('claim').onclick=()=>task(async()=>{ showResult(await api('claim',{token})); message('Klaim berhasil dicatat. Tim toko akan menghubungimu untuk pemenuhan hadiah.'); });
  el('reset').onclick=()=>{ token=null; el('verify').hidden=false; el('play').hidden=true; message('Verifikasi ulang untuk mengambil hasil yang sama, atau masukkan pesanan lain.'); };
  const slug=new URLSearchParams(location.search).get('campaign');
  if (slug) { el('slug').value=slug; task(loadCampaign); }
})();
