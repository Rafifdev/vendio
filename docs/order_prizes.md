# Order Prizes — backend & frontend handoff

## Cakupan

Modul HMVC CodeIgniter 3, tanpa dependency PHP baru. Lima bagian di admin:

1. **Campaigns**: toko/channel, periode, syarat, batas klaim, budget profit, ringkasan akumulasi.
2. **Hadiah & threshold**: jenis, deskripsi, stok, bobot peluang, gate berulang dan otomatis.
3. **Order terverifikasi**: input admin / CSV atomik. Sumber kebenaran untuk HP dan nilai finansial.
4. **Spin & klaim**: order, HP, hadiah snapshot, jenis spin, ID token, waktu, deadline, klaim, fulfillment, follow-up, broadcast, persetujuan marketing, catatan.
5. **Audit log**: perubahan pengaturan, import, verifikasi/consent, award dan fulfillment. Keputusan undian lengkap di `spins.decision_json`.

Halaman customer: `/order_prizes?campaign=<slug>`. Admin: `/administrator/order_prizes`.
Asset JS/CSS lokal, tidak perlu build. UI dasar bisa diganti tim frontend tanpa memindahkan logika undian ke browser.

## Instalasi

- PHP **7.4+ 64-bit** dengan `mysqli`, MySQL **5.7+** / MariaDB **10.2+**, InnoDB. Ikuti kompatibilitas runtime aplikasi legacy secara keseluruhan; versi minimum composer lama bukan minimum modul ini.
- Backup database lalu jalankan `database/create_order_prizes.sql` pada database aplikasi. Script membuat tujuh tabel, permission, dan menu; aman dijalankan ulang untuk skema v1 yang sama. Tidak mengubah data order TikTok. Ini bukan auto-upgrader untuk versi skema mendatang.
- Beri group operator izin lewat modul Access yang sudah ada:
  - `menu_order_prizes` untuk menu;
  - `order_prizes_view` untuk baca admin, termasuk **PII dan audit**;
  - `order_prizes_manage` untuk campaign, hadiah, dan sumber order;
  - `order_prizes_fulfill` untuk klaim/follow-up/fulfillment.
  - Permission tidak otomatis diberikan ke seluruh group. Super-admin mengikuti aturan Aauth existing.
- Buat campaign **draft**, isi tanggal dan identitas toko, tambahkan hadiah, import order, baru aktifkan.
- Wajib ada minimal satu **fallback**: aktif, stok `NULL` (kosong di UI), cost `0`, seluruh threshold `0`, auto_metric `none`. Bisa voucher tanpa biaya atau `kind=none` (belum beruntung). Fallback tidak boleh dinonaktifkan saat campaign aktif.
- Pasang HTTPS dan pastikan `base_url` / cookie domain cocok dengan deployment. Jangan expose database. Pertahankan CSRF global.
- Waktu seluruh modul **Asia/Jakarta**; nilai uang **rupiah bulat**, tidak mendukung pecahan atau multi-currency. Customer mendapat timezone pada metadata campaign.

Tidak ada seed campaign aktif atau hadiah mahal secara otomatis. Tidak ada perubahan/push data ke Shopee atau TikTok.

### Batas integrasi yang sengaja eksplisit

Repo belum punya konektor order Shopee. V1 memakai order terpercaya yang dimasukkan/import oleh admin; **bukan** validasi nomor pesanan langsung ke Shopee. Data TikTok yang masked tidak dianggap bukti kepemilikan. Sinkronisasi marketplace berikutnya harus lewat adapter backend terpercaya yang mengisi tabel/order service ini, bukan melalui input customer.

Customer harus memasukkan nomor HP lengkap yang **cocok dengan order terverifikasi**. Format `08…`, `628…`, dan `+628…` dinormalisasi ke `628…`. Nomor tersamarkan ditolak. Matching ini bukan OTP dan tidak membuktikan kepemilikan SIM. Untuk hadiah bernilai tinggi, verifikasi kepemilikan tambahan via chat marketplace / OTP / proses admin sebelum mengirim hadiah. Jangan mengimpor nomor tebakan.

Broadcast hanya **pencatatan status**; tidak ada integrasi WhatsApp/SMS atau pengiriman otomatis. Consent marketing opsional, tidak memengaruhi chance. Worker broadcast mendatang wajib mengecek consent terbaru lagi sebelum mengirim, termasuk jika sebelumnya sudah queued.

## Aturan bisnis

### Eligibility dan satu kali spin

- Campaign aktif, waktu server di antara `starts_at` dan `ends_at`, order `paid`/`completed`, `ordered_at` di periode campaign.
- Satu order dikenali global oleh `(channel, shop_ref, order_number)`. Satu order hanya terhubung ke satu campaign; tidak bisa ikut campaign lain lagi.
- `shop_ref` harus ID/kode toko stabil dan konsisten, bukan display name yang berubah-ubah.
- Nomor order ASCII, case-insensitive secara bisnis (disimpan uppercase); karakter yang diizinkan huruf, angka, `_`, `-`, panjang 4–80.
- Tidak ada spin bonus/manual di v1. `spin_type=order`; field disimpan untuk perluasan tanpa menjanjikan bonus endpoint.
- Verifikasi menghasilkan bearer token acak 256-bit, disimpan hanya **SHA-256 hash**, berlaku **30 menit**. ID token yang tampil di admin bukan token rahasia.
- Verifikasi ulang merotasi token lama. Kalau order sudah spin, mengembalikan hasil yang sama, bukan kesempatan baru. Bisa dilakukan setelah campaign berakhir/paused untuk mengurus klaim. Campaign draft tidak ditampilkan di halaman customer.
- Spin dengan token yang sama atau token hasil verifikasi ulang selalu mengambil hasil yang tersimpan. Retry setelah response terputus aman. Token kedaluwarsa perlu verifikasi ulang.
- Hasil, stok, biaya, counter dan audit ditulis dalam **satu transaksi**. Lock campaign menserialisasi spin dan perubahan konfigurasi campaign yang sama; unique key order/token adalah pertahanan tambahan. Campaign berbeda bisa berjalan paralel.
- Sumber order boleh diperbaiki sebelum spin (token lama dibatalkan). Setelah spin, identitas/nominal/waktu order dibekukan; status pembatalan/refund tetap bisa diperbarui.

### Peluang dan threshold berulang

Semua threshold memakai akumulasi **order yang telah melakukan spin di campaign tersebut**, bukan seluruh omzet toko. Nilai order yang sedang spin termasuk dalam evaluasi saat itu, tetapi hanya dicatat bila transaksi berhasil. Verifikasi, import, claim, dan retry tidak menambah metrik.

- `revenue_total += order.revenue`
- `profit_total += order.profit`; `NULL` = belum diketahui, kontribusi `0`, **tidak diestimasi**. Kerugian/profit negatif tetap mengurangi total.
- `spin_count += 1`
- Gate per prize untuk unit berikutnya memakai `n = awarded_count + 1`:
  - `spin_count >= threshold_spins × n`
  - `revenue_total >= threshold_revenue × n`
  - `profit_total >= threshold_profit × n`
  - Gate `0` tidak membatasi. Semua gate yang diisi harus terpenuhi (**AND**).
- Threshold otomatis:
  - `auto_metric=profit` atau `revenue`
  - `auto_gate = ceil(cost × 100 / allocation_percent)`
  - Dipakai sebagai minimum gate metrik tersebut: `max(manual_gate, auto_gate) × n`.
  - `cost` adalah biaya internal hadiah, bukan harga retail. Auto gate perlu `cost > 0`.
- Contoh: hadiah cost Rp100.000, auto profit, alokasi 10% → unit pertama eligible pada profit Rp1.000.000, unit kedua Rp2.000.000, dst. Jika gate spin juga 100, unit pertama butuh minimal spin ke-100, kedua ke-200, dst.
- Eligible **tidak berarti pasti menang**. Server mengambil `random_int(1, jumlah_bobot)` di antara hadiah aktif, stok tersedia dan gate terpenuhi. Peluang relatif = `weight / total weight hadiah eligible pada saat itu`.
- Fallback/common biasanya diberi bobot lebih tinggi daripada hadiah mahal. Tidak ada hardcoded persentase diam-diam.
- Jika metrik melampaui beberapa milestone sebelum hadiah menang, unit yang sudah terbuka bisa keluar pada spin berurutan. Threshold bukan cooldown.
- `budget_profit_percent` opsional, 1–100. Hadiah berbiaya hanya boleh menang bila `awarded_cost + cost <= floor(max(0, profit_total) × budget_profit_percent / 100)`. Ini batas **gabungan semua hadiah**; alokasi auto per hadiah saja bukan batas gabungan.
- Hadiah cost 0 tetap eligible walaupun profit negatif/budget habis, sehingga fallback tetap berjalan.
- `stock=NULL`: unlimited; `0`: habis. Stok dikurangi pada saat award, bukan saat claim. `awarded_count` tidak dapat diedit lewat API.
- Biaya dan counter tidak dilepas ulang ketika claim expired/rejected/void, dan refund setelah spin **tidak mengurangi** total historis. Ini desain konservatif agar gate/budget tidak dipakai ulang. Jangan menganggap metrik ini laporan profit bisnis final.
- Saat menerima refund, admin harus menolak/void hadiah yang belum dikirim dengan alasan. Tidak ada refund webhook atau pembatalan hadiah otomatis. Hadiah yang sudah terkirim tidak bisa dibatalkan lewat transisi mundur.
- Edit nama/cost/rules hadiah berlaku untuk spin berikutnya; nama/cost/keputusan spin lama tetap snapshot. Identitas campaign dikunci setelah ada order.
- Batas: 100 hadiah/campaign, weight 1–1.000.000, stok 0–1.000.000, nominal per order/biaya hadiah maksimal Rp1 miliar, akumulasi metrik maksimum absolut 10^14. Tidak ada hard delete: gunakan paused/ended, nonaktif hadiah, atau status order.

### Klaim dan operasional

- Hadiah fisik/voucher: `claim_status=pending`, `prize_status=reserved` saat menang.
- `kind=none`: `not_required` untuk klaim/hadiah dan follow-up `closed`.
- Deadline snapshot = waktu spin + `claim_days` (1–90). Klaim harus masuk **sebelum** deadline; campaign berakhir tidak otomatis membatalkan periode klaim.
- `pending` yang lewat deadline ditampilkan/filter sebagai `expired` tanpa cron. Penyimpanan status material bisa masih pending sampai ada update; gunakan endpoint, bukan query mentah untuk workflow.
- Endpoint claim idempotent mencatat `claimed_at`; alamat/resi/kode voucher dikelola operator lewat notes, bukan di response public.
- Transisi admin:
  - claim: pending → claimed/rejected; claimed → rejected; expired → rejected.
  - hadiah: reserved → processing/void; processing → sent/delivered/void; sent → delivered.
  - follow-up: pending → contacted/closed; contacted → pending/closed; closed → pending.
  - broadcast: not_sent → queued; queued → sent/failed/not_sent; failed → queued/not_sent.
- Claim harus `claimed` sebelum processing/sent/delivered. Klaim rejected wajib hadiah void; void wajib rejected/expired, dengan alasan notes. Transisi yang sama bersifat idempotent.
- Order cancelled/refunded tidak bisa diklaim baru atau dilanjutkan fulfillment. Status delivered tidak bisa diputar balik.
- Tidak ada release stok otomatis setelah expiry/void. Restock harus keputusan admin yang diaudit.

## API untuk frontend

URL di bawah relatif terhadap `site_url()`, termasuk `index.php` jika deployment memakainya. Tidak memakai `/api/...` legacy karena jalur itu melewati CSRF di aplikasi existing.

### Format request dan CSRF

- Semua mutation dan akses berbasis token memakai **POST form-urlencoded / multipart FormData**, **bukan JSON body**.
- Sertakan cookie same-origin (`credentials: 'same-origin'`). GET campaign memberi `csrf.name/hash`; tambahkan pasangan ini ke POST. Admin mendapatkan nilai CSRF dari halaman admin/GET records.
- Token spin ada di **body**, jangan URL, log, analytics, atau localStorage. Contoh UI menyimpan token hanya di memori; reload → verifikasi ulang.
- Jangan kirim prize_id, chance, revenue, profit, atau hasil random dari customer; tidak digunakan server.
- Pertahankan URL backend same-origin. Jika frontend dipisah domain, tim deployment perlu menyiapkan proxy same-origin; modul ini tidak menambah credentialed CORS lintas-domain.

Envelope semua endpoint JSON modul:

```json
{
  "success": true,
  "data": {},
  "csrf": {"name": "<nama-token-dari-server>", "hash": "<nilai-token>"}
}
```

Error: `{"success":false,"message":"...","csrf":{...}}`. Status HTTP: 400/422 invalid input, 401 token/login tidak valid, 403 izin/CSRF, 404 tidak ditemukan, 405 method, 409 konflik/state, 429 rate limit, 500 kegagalan tidak terduga. Rejection CSRF oleh core CI **sebelum controller** dapat berupa HTML 403; frontend perlu menanganinya (contoh UI sudah menangani respons bukan JSON).

### Public endpoints

| Method | Path | Input | Hasil |
|---|---|---|---|
| GET | `/order_prizes/campaign?slug=...` | slug | name, terms, status, is_open, ends_at, claim_days, timezone, prizes: id/name/description/kind |
| POST | `/order_prizes/verify` | slug, order_number, phone, accept_terms=1, marketing_consent=0/1 (default 0) | token, expires_at, already_spun, result (nullable) |
| POST | `/order_prizes/spin` | token | hasil tersimpan; retry mengembalikan hasil yang sama |
| POST | `/order_prizes/result` | token | hasil + status klaim terbaru, tanpa melakukan spin |
| POST | `/order_prizes/claim` | token | hasil dengan claimed/claimed_at |

`result` hanya memuat `id, prize_id, prize_name, prize_kind, spin_type, claim_status, prize_status, spun_at, claim_deadline, claimed_at`. Tidak membocorkan nomor order/HP, total finansial, aturan internal, notes, atau token hash.

Metadata campaign aktif/paused/ended tetap bisa dibaca; `is_open=false` berarti tidak menerima spin baru. Katalog roda menampilkan semua hadiah aktif, **bukan janji setiap hadiah eligible saat itu**. Disclosure peluang/threshold harus tetap ada. Tim frontend harus memakai `prize_id` yang dikembalikan server untuk animasi.

```js
const meta = await fetch('/order_prizes/campaign?slug=oktober', {
  credentials: 'same-origin'
}).then(r => r.json());
let csrf = meta.csrf;
async function post(action, values) {
  const body = new URLSearchParams(values);
  body.set(csrf.name, csrf.hash);
  const res = await fetch('/order_prizes/' + action, {
    method: 'POST', body, credentials: 'same-origin'
  });
  const json = await res.json();
  if (json.csrf) csrf = json.csrf;
  if (!res.ok || !json.success) throw new Error(json.message);
  return json.data;
}
// Pastikan customer benar-benar memberi persetujuan melalui UI.
const verified = await post('verify', {
  slug: 'oktober', order_number: '261014ABC123', phone: '081234567890',
  accept_terms: '1', marketing_consent: '0'
});
const result = verified.already_spun ? verified.result : await post('spin', {token: verified.token});
// Animasi roda mengikuti result.prize_id. Claim adalah aksi terpisah customer.
```

Verifikasi ulang memperbarui consent marketing terbaru. Audit menyimpan timestamp dan hash terms yang diterima; tidak mengubah consent secara diam-diam saat spin.

### Admin endpoints (session Aauth + CSRF)

| Method | Path | Permission |
|---|---|---|
| GET | `/administrator/order_prizes/records/{entity}` | order_prizes_view |
| POST | `/administrator/order_prizes/save/{entity}/{id}` | order_prizes_manage |
| POST | `/administrator/order_prizes/import_orders` | order_prizes_manage |
| POST | `/administrator/order_prizes/fulfill/{spin_id}` | order_prizes_fulfill |

- entity read: `campaigns`, `prizes`, `orders`, `spins`, `audit`.
- entity save: `campaigns`, `prizes`, `orders`; `id=0` create, existing ID update. Update parsial didukung; field internal (counter/hash/result/actor) diabaikan.
- records response: `{items: [...], total, page, limit}`; default page=1, limit=25, maksimum limit=100.
- `q`: nama/slug campaign, nama hadiah, order/HP pada orders, order/HP/hadiah pada spins, action pada audit. Parameterized SQL + literal wildcard escaping.
- filter: campaigns `status`; prizes `campaign_id,active`; orders `campaign_id,status`; spins `campaign_id,claim_status,prize_status,follow_up_status,broadcast_status,marketing_consent`; audit `entity,entity_id`.
- Nama/status/filter harus memakai nilai enum di bawah. Invalid sort/table/field tidak dapat dipilih caller.
- `save campaigns`: `slug,name,channel,shop_ref,starts_at,ends_at` wajib create. Default `status=draft`, `claim_days=7`, `budget_profit_percent=NULL`, `terms=''`. `channel=shopee|tiktok|other`, status `draft|active|paused|ended`. Terms wajib saat active.
- `save prizes`: `campaign_id,name` wajib create. Default `kind=physical`, `active=1`, `weight=1`, `stock=NULL`, `cost=0`, seluruh threshold=0, `auto_metric=none`, `allocation_percent=10`, `description=''`. Kind `physical|voucher|none`.
- `save orders`: `campaign_id,order_number,phone,revenue,ordered_at` wajib create. Default `status=completed`, `profit=NULL`. Status `paid|completed|cancelled|refunded`. Channel/shop selalu diturunkan server dari campaign. `profit` boleh negatif, tidak boleh lebih tinggi dari revenue.
- `fulfill`: field opsional `claim_status,prize_status,follow_up_status,broadcast_status,notes` (max 5000 bytes). Idempotent bila status sama.

### CSV import

POST multipart `campaign_id` dan file field `file`, UTF-8 CSV koma. Tidak menyimpan upload di webroot. Header harus persis:

```csv
order_number,phone,status,revenue,profit,ordered_at
261014ABC123,081234567890,completed,200000,40000,2026-10-14 09:00:00
261014DEF456,6281234567891,paid,100000,,2026-10-14 09:30:00
```

Maksimal 1000 data / 2 MB. Semua baris divalidasi, termasuk nomor HP lengkap, tanggal bukan masa depan dan di periode campaign. Profit kosong berarti tidak diketahui. Duplicate (termasuk duplicate dalam file yang sama) **menolak seluruh import**, bukan overwrite data finansial secara diam-diam. Response error menyebut nomor baris, sukses `{imported:N}`. Edit existing order melalui endpoint save, jangan upsert CSV.

## Keamanan & operasi

- SQL parameterized; CSPRNG; seluruh hasil di server; InnoDB transaction + lock + unique key.
- Permission checked server-side di semua admin endpoint, termasuk direct HMVC URL. CSRF check tambahan di trait HTTP mencegah bypass lewat jalur legacy `/api/*`.
- Semua endpoint no-store. Tidak ada public endpoint untuk lookup order/PII/list pemenang; nomor order/HP yang tidak cocok menggunakan pesan eligibility generik.
- Rate limit DB fixed window 15 menit: metadata 120/IP, verify 30/IP + 10/order/campaign, spin 60/IP, result 120/IP, claim 30/IP. HTTP 429 + Retry-After 900. Bucket lama dibersihkan bertahap, hash-only identity. Shared NAT bisa berbagi limit; konfigurasikan trusted reverse proxy dengan benar, jangan percaya arbitrary X-Forwarded-For. Gunakan edge/WAF untuk volumetric abuse; limit modul bukan pengganti itu.
- Hanya plaintext bearer token dikembalikan saat verify. Jangan menampilkan hash/token aktif ke staff; `token_id` cukup untuk investigasi.
- Session secret/cookie configuration aplikasi existing tetap tanggung jawab deployment. Modul tidak mengganti autentikasi global.
- Audit bukan immutable cryptographic ledger; DBA masih bisa mengubahnya. Batasi akses dan tetapkan retensi PII/audit sesuai kebijakan. Modul tidak otomatis menghapus bukti hasil.
- Jika DB deadlock/timeout/gagal setelah award, API gagal dan transaksi rollback. Retry token yang sama aman, termasuk kasus commit berhasil tetapi respons jaringan hilang. Untuk traffic sangat besar per campaign, lock campaign merupakan batas throughput yang disengaja demi konsistensi.

## Pengujian

```sh
find modules/order_prizes tests/order_prizes -name '*.php' -print0 | xargs -0 -n1 php -l
php tests/order_prizes/rules_test.php
php tests/order_prizes/http_test.php
node --check asset/order_prizes/admin.js
node --check asset/order_prizes/customer.js
```

MySQL integration suite **destruktif hanya pada database test**. Script menolak DB selain `order_prizes_test`:

```sh
# Buat database terisolasi terlebih dahulu. Jangan isi data production di database ini.
OP_TEST_DSN='mysql:host=127.0.0.1;dbname=order_prizes_test;charset=utf8mb4' \
OP_TEST_USER=root OP_TEST_PASSWORD='<password-db-test>' \
php tests/order_prizes/integration_test.php
```

Suite menguji SQL/service asli lewat adapter PDO untuk interface DB CI: migration rerun, fallback, ownership, duplicate, token rotation/expiry, idempotency, snapshot, claim, consent, import rollback, search, pagination, transaction rollback dengan forced SQL failure, serta parallel request/last stock bila `pcntl` tersedia. `.github/workflows/order-prizes.yml` menjalankan suite pada PHP 7.4/8.2 + MySQL 8 ketika perubahan dipush/PR. Tests ini tidak menggantikan smoke test full aplikasi (HMVC, Aauth, session, cookie).

Checklist staging sebelum campaign dipublikasikan:

- [ ] SQL diterapkan, permission/menu terbaca; unauthenticated/read-only staff tidak bisa mutate.
- [ ] HTTP POST tanpa/invalid CSRF ditolak; GET ke spin tidak mengubah data.
- [ ] Campaign draft/paused/ended/tanggal di luar periode menolak spin baru.
- [ ] Import invalid/duplicate tidak meninggalkan baris parsial; masked HP ditolak.
- [ ] Wrong HP, cancelled/refunded, order beda toko/campaign ditolak.
- [ ] Double-click/retry/parallel token tidak mengubah hasil atau menghitung order dua kali.
- [ ] Stok terakhir tidak minus; threshold sebelum/pada batas & budget negatif bekerja.
- [ ] Refresh customer → verifikasi ulang → hasil sama, termasuk setelah campaign selesai.
- [ ] Claim lewat deadline ditolak; tidak bisa fulfillment tanpa claim; no-consent tidak bisa broadcast.
- [ ] Respons public dan browser logs tidak mengandung HP/order/biaya/token hash selain input customer sendiri.
- [ ] UI mobile, animasi result-driven, reduced motion dan disclosure peluang berfungsi.
