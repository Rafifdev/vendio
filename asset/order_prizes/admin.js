(function () {
  'use strict';
  const cfg = window.orderPrizesAdmin;
  const el = id => document.getElementById('op-' + id);
  const labels = {campaigns:'Campaigns', prizes:'Hadiah & threshold', orders:'Order terverifikasi', spins:'Spin & klaim', audit:'Audit log'};
  const fields = {
    campaigns:[['slug','Slug URL'],['name','Nama'],['channel','Channel',['shopee','tiktok','other']],['shop_ref','Referensi toko (ID/kode internal)'],['status','Status',['draft','active','paused','ended']],['starts_at','Mulai','datetime-local'],['ends_at','Selesai','datetime-local'],['claim_days','Batas klaim (hari)','number',7],['budget_profit_percent','Batas total biaya hadiah (% profit), kosong = tanpa batas','number'],['terms','Syarat & ketentuan','textarea']],
    prizes:[['campaign_id','Campaign ID','number'],['name','Nama hadiah'],['description','Deskripsi','textarea'],['kind','Jenis',['physical','voucher','none']],['active','Aktif',['1','0']],['weight','Bobot peluang relatif (bukan persen)','number',1],['stock','Sisa stok (kosong = unlimited)','number'],['cost','Biaya hadiah IDR','number',0],['threshold_spins','Setiap N spin (0 = tanpa gate)','number',0],['threshold_revenue','Setiap X omset IDR','number',0],['threshold_profit','Setiap X profit IDR','number',0],['auto_metric','Threshold otomatis',['none','revenue','profit']],['allocation_percent','Alokasi % untuk threshold otomatis','number',10]],
    orders:[['campaign_id','Campaign ID','number'],['order_number','Nomor pesanan'],['phone','Nomor HP yang terverifikasi'],['status','Status',['completed','paid','cancelled','refunded']],['revenue','Omset IDR','number'],['profit','Profit IDR (kosong = belum diketahui)','number'],['ordered_at','Waktu order','datetime-local']],
    spins:[['claim_status','Status klaim',['pending','claimed','expired','rejected','not_required']],['prize_status','Status hadiah',['reserved','processing','sent','delivered','void','not_required']],['follow_up_status','Follow-up',['pending','contacted','closed']],['broadcast_status','Broadcast',['not_sent','queued','sent','failed']],['notes','Catatan / resi / kode voucher / alasan','textarea']]
  };
  const columns = {
    campaigns:['id','name','slug','status','spin_count','revenue_total','profit_total','awarded_cost'],
    prizes:['id','campaign_id','name','kind','active','weight','stock','awarded_count','auto_metric'],
    orders:['id','campaign_id','order_number','phone','status','revenue','profit'],
    spins:['id','order_number','phone','prize_name','claim_status','prize_status','follow_up_status','broadcast_status','marketing_consent','spin_type','token_id','spun_at'],
    audit:['id','actor_id','action','entity','entity_id','created_at']
  };
  let entity = 'campaigns', page = 1, editingId = 0, loading = false;
  function message(text, bad = false) { el('message').className = 'alert alert-' + (bad ? 'danger' : 'success'); el('message').textContent = text; }
  async function request(path, data) {
    const options = {credentials:'same-origin', headers:{Accept:'application/json'}};
    if (data) { data.set(cfg.csrf.name, cfg.csrf.hash); options.method = 'POST'; options.body = data; }
    const res = await fetch(cfg.base + '/' + path, options);
    let json;
    try { json = await res.json(); } catch (_) { throw new Error('Respons bukan JSON. Sesi mungkin berakhir; muat ulang halaman.'); }
    if (json.csrf) cfg.csrf = json.csrf;
    if (!res.ok || !json.success) throw new Error(json.message || 'Permintaan gagal.');
    return json.data;
  }
  function button(label, action, cls = 'btn-default') { const b = document.createElement('button'); b.type='button'; b.className='btn btn-xs ' + cls; b.textContent=label; b.addEventListener('click', action); return b; }
  function editable() { return entity === 'spins' ? cfg.fulfill : entity !== 'audit' && cfg.manage; }
  async function load() {
    if (loading) return;
    loading = true;
    el('prev').disabled = el('next').disabled = true;
    try {
      const query = new URLSearchParams(new FormData(el('filter')));
      if (entity !== 'spins') query.delete('claim_status');
      if (entity === 'campaigns' || entity === 'audit') query.delete('campaign_id');
      query.set('page', page);
      const result = await request('records/' + entity + '?' + query);
      el('head').replaceChildren(); el('body').replaceChildren();
      const tr = document.createElement('tr');
      columns[entity].concat(['Aksi']).forEach(name => { const th=document.createElement('th'); th.textContent=name; tr.appendChild(th); });
      el('head').appendChild(tr);
      result.items.forEach(row => {
        const tr=document.createElement('tr');
        columns[entity].forEach(name => { const td=document.createElement('td'); td.textContent=row[name] === null ? '—' : row[name]; tr.appendChild(td); });
        const td=document.createElement('td');
        td.appendChild(button('Detail', () => { el('json').textContent=JSON.stringify(row, null, 2); el('detail').hidden=false; el('detail').scrollIntoView({behavior:'smooth'}); }));
        if (editable()) td.appendChild(button('Edit', () => editor(row), 'btn-primary'));
        if (entity === 'campaigns') { const a=document.createElement('a'); a.href=cfg.publicUrl + '?campaign=' + encodeURIComponent(row.slug); a.target='_blank'; a.rel='noopener'; a.textContent=' Link customer'; td.appendChild(a); }
        tr.appendChild(td); el('body').appendChild(tr);
      });
      el('count').textContent = result.total + ' data · Halaman ' + page;
      el('prev').disabled = page <= 1; el('next').disabled = page * result.limit >= result.total;
      el('new').hidden = !cfg.manage || !['campaigns','prizes','orders'].includes(entity);
      el('import').hidden = entity !== 'orders' || !cfg.manage;
      el('status-filter').hidden = entity !== 'spins';
      el('campaign-filter').hidden = ['campaigns','audit'].includes(entity);
    } catch (err) { message(err.message, true); } finally { loading = false; }
  }
  function editor(row = {}) {
    editingId = row.id || 0; el('fields').replaceChildren();
    el('editor-title').textContent = (editingId ? 'Edit #' + editingId : 'Tambah') + ' · ' + labels[entity];
    fields[entity].forEach(([name,label,type,defaultValue]) => {
      const div=document.createElement('div'); div.className='col-md-6 form-group';
      const lab=document.createElement('label'); lab.htmlFor='op-field-' + name; lab.textContent=label;
      let input;
      if (Array.isArray(type)) { input=document.createElement('select'); type.forEach(v => { const o=document.createElement('option'); o.value=v; o.textContent=v; input.appendChild(o); }); }
      else if (type === 'textarea') { input=document.createElement('textarea'); input.rows=3; }
      else { input=document.createElement('input'); input.type=type || 'text'; if (input.type === 'number') input.step='1'; }
      input.name=name; input.id=lab.htmlFor; input.className='form-control';
      if (row[name] !== undefined) input.value=row[name] === null ? '' : row[name];
      else if (defaultValue !== undefined) input.value=defaultValue;
      if (type === 'datetime-local' && row[name]) input.value=row[name].replace(' ', 'T');
      div.append(lab,input); el('fields').appendChild(div);
    });
    el('editor').hidden=false; el('editor').scrollIntoView({behavior:'smooth'});
  }
  Object.keys(labels).forEach(key => el('tabs').appendChild(button(labels[key], () => {
    if (loading) return;
    entity=key; page=1; el('editor').hidden=true; el('detail').hidden=true;
    [...el('tabs').children].forEach((b,i) => b.classList.toggle('btn-primary', Object.keys(labels)[i] === key));
    load();
  })));
  el('tabs').firstChild.classList.add('btn-primary');
  el('filter').addEventListener('submit', e => { e.preventDefault(); if (!loading) { page=1; load(); } });
  el('prev').onclick=() => { if (!loading) { page--; load(); } }; el('next').onclick=() => { if (!loading) { page++; load(); } };
  el('new').onclick=() => editor(); el('cancel').onclick=() => { el('editor').hidden=true; };
  el('detail-close').onclick=() => { el('detail').hidden=true; };
  el('form').addEventListener('submit', async e => {
    e.preventDefault(); const submit=e.target.querySelector('[type=submit]'); submit.disabled=true;
    try { await request(entity === 'spins' ? 'fulfill/' + editingId : 'save/' + entity + '/' + editingId, new FormData(e.target)); el('editor').hidden=true; message('Data tersimpan.'); await load(); }
    catch (err) { message(err.message, true); } finally { submit.disabled=false; }
  });
  el('import-form').addEventListener('submit', async e => {
    e.preventDefault(); const submit=e.target.querySelector('[type=submit]'); submit.disabled=true;
    try { const data=await request('import_orders', new FormData(e.target)); message(data.imported + ' order berhasil diimpor.'); await load(); }
    catch (err) { message(err.message, true); } finally { submit.disabled=false; }
  });
  load();
})();
