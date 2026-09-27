# PRD — Modul Integrasi TikTok Shop (TikTok Partner API) pada ERP/POS
**Platform:** CodeIgniter 3 + Cicool Builder (modular CRUD generator/HMVC)
**Sumber API:** TikTok Partner API (Shop) — 10 grup endpoint (Auth, Warehouse & Logistics, Product Metadata, Product Management, Product Status Control, Inventory & Price Sync, Order, Fulfillment, Finance, Return & Refund)
**Status dokumen:** Draft v1.0

---

## 1. Ringkasan & Tujuan

Modul ini menambahkan channel penjualan **TikTok Shop** ke dalam ERP/POS yang sudah ada (multi-cabang, dengan modul stok/bahan baku). Tujuannya:

1. Owner/admin bisa menghubungkan satu atau lebih toko TikTok Shop ke sistem.
2. Produk, stok, dan harga bisa dikelola dari ERP lalu disinkronkan ke TikTok, tanpa harus buka Seller Center.
3. Order dari TikTok masuk ke ERP, diproses (pack, kirim, tracking) mengikuti alur resmi TikTok Shop — **bukan alur custom buatan sendiri**.
4. Retur, pembatalan, dan keuangan (settlement) TikTok bisa dipantau dari satu tempat, dengan status yang identik dengan yang tampil di Seller Center, supaya tidak ada selisih pemahaman antara tim CS/keuangan dengan apa yang buyer lihat di TikTok.

## 2. Asumsi & Catatan Teknis Penting

Karena Cicool adalah builder internal (CRUD generator di atas CI3 + HMVC/Modular Extensions, dengan folder `modules/<nama_modul>/{controllers,models,views}` dan tema di `cc-content/themes/`), PRD ini **tidak membuat layout/komponen UI baru**. Setiap menu di bawah dirancang mengikuti pola bawaan Cicool yang sudah baku di ERP ini:

- **Halaman List** = template grid/datatable bawaan Cicool (search box, filter dropdown per kolom, pagination, tombol aksi per baris, bulk action di atas tabel).
- **Halaman Detail (View)** = template detail bawaan Cicool (header ringkasan + beberapa section/tab berisi tabel key-value dan sub-tabel relasi).
- **Halaman Create/Edit** = form builder bawaan Cicool (field mengikuti tipe kolom di database: text, select, datetime, textarea, repeater untuk relasi one-to-many).
- Semua tabel di bawah didesain **collation & tipe data siap dipakai wizard CRUD Cicool** (primary key `id` auto increment lokal + kolom `*_id` dari TikTok disimpan terpisah sebagai reference id eksternal, sesuai konvensi Cicool yang butuh PK integer lokal untuk generate CRUD).
- **Tidak ada endpoint webhook** di collection yang diberikan — seluruhnya REST pull-based. Maka arsitektur sync di PRD ini pakai **cron/scheduler polling**, bukan webhook listener. Kalau nanti tersedia webhook resmi TikTok, tinggal tambah 1 controller listener tanpa mengubah skema tabel ini.
- Status-status di setiap modul di bawah adalah **status resmi milik TikTok** (dipakai sebagai `enum`/lookup, ditampilkan apa adanya dengan label Indonesia sebagai terjemahan tampilan saja, value asli tetap disimpan). Tim dev **wajib cross-check ke dokumen resmi `partner.tiktokshop.com/docv2`** sebelum go-live untuk memastikan tidak ada status baru yang ditambahkan TikTok setelah PRD ini dibuat.
- Semua request ke API butuh parameter standar: `app_key`, `timestamp`, `sign` (HMAC), dan `shop_cipher` (kecuali endpoint auth). Ini ditangani oleh 1 **library terpusat** (`Tiktok_api.php`), bukan diulang-ulang di tiap controller modul.

### 2.1 Alur Pengembangan per Modul

Setiap tabel di Bab 7 **wajib digenerate dulu lewat wizard CRUD Cicool oleh Owner**, baru kemudian disesuaikan (custom flow, status badge, aksi kontekstual, sub-tabel relasi, dsb) oleh developer. Urutannya per modul:

1. **Generate awal (manual oleh Owner)** — Owner membuat tabel di database sesuai DDL Bab 7, lalu menjalankan wizard/CRUD builder Cicool di atas tabel tersebut untuk menghasilkan modul dasar (`modules/<nama_modul>/{controllers,models,views}`) dengan halaman List, Detail, dan Form bawaan Cicool apa adanya (belum ada logic status/flow TikTok).
2. **Penyesuaian oleh developer (setelah hasil generate tersedia)** — di atas modul hasil generate itu, developer baru menambahkan: badge status sesuai tabel status resmi di tiap sub-bab 6.x, tombol aksi kontekstual (yang hanya muncul di status tertentu), pemanggilan API TikTok (create/update/approve/reject/dll via `Tiktok_api.php`), sub-tabel relasi (item, tracking, log) di halaman Detail, serta validasi flow (mis. tombol Batalkan hanya muncul di status `ON_HOLD`/`AWAITING_SHIPMENT`/`AWAITING_COLLECTION`).
3. Modul yang murni read-only/log (`tiktok_api_logs`, `tiktok_order_status_logs`, `tiktok_return_status_logs`, `tiktok_product_sync_logs`) cukup sampai tahap 1 (hasil generate Cicool apa adanya sudah cukup untuk keperluan audit trail), tidak perlu tahap 2.

Urutan generate disarankan mengikuti urutan dependency tabel (parent dulu baru child), supaya relasi FK di form generate Cicool langsung terbaca: `tiktok_shops` → `tiktok_warehouses`/`tiktok_categories`/`tiktok_brands` → `tiktok_products` (+`tiktok_product_images`, `tiktok_product_skus`) → `tiktok_orders` (+`tiktok_order_line_items`, `tiktok_order_price_details`) → `tiktok_packages` (+turunannya) → `tiktok_returns`/`tiktok_cancellations` (+turunannya) → `tiktok_statements`/`tiktok_withdrawals`/`tiktok_statement_transactions`.

## 3. Aktor & Hak Akses

| Role | Akses |
|---|---|
| Owner / Super Admin | Full akses semua menu TikTok, termasuk connect/disconnect toko, lihat keuangan |
| Admin Cabang / Manager | Kelola produk, order, fulfillment untuk toko yang di-assign ke cabangnya |
| Staff Gudang | Akses menu Fulfillment (proses paket, cetak label) — read-only di menu lain |
| Finance | Akses menu Keuangan (statement, withdrawal, transaksi) — read-only di menu lain |
| CS / Admin Retur | Akses menu Retur & Pembatalan (approve/reject) |

Hak akses per menu mengikuti modul **ACL bawaan Cicool** (role-permission per module/action), tidak dibuat sistem permission baru.

## 4. Struktur Menu (Information Architecture)

```
TikTok Shop (parent menu)
├── Toko Terhubung            (Shop Connect)
├── Gudang & Pengiriman        (Warehouse, Delivery Option, Shipping Provider)
├── Kategori & Brand           (Master data dari TikTok — read only, sync)
├── Produk TikTok
│   ├── Daftar Produk          (List + Detail + Create/Edit + Aktivasi/Nonaktifkan/Hapus)
│   └── Log Sinkronisasi Produk
├── Order TikTok
│   ├── Daftar Order           (List + Detail, termasuk price detail)
│   └── Pembatalan Order
├── Fulfillment
│   ├── Paket (Packages)       (List + Detail + aksi kirim/gabung/pisah)
│   └── Dokumen Pengiriman
├── Retur & Refund
│   ├── Pengajuan Retur
│   └── Pengajuan Pembatalan
└── Keuangan TikTok
    ├── Statement
    ├── Penarikan Dana (Withdrawal)
    └── Transaksi (per Order / per Statement / Belum Settle)
```

## 5. Arsitektur Integrasi & Sinkronisasi

### 5.1 Library Pusat
- `application/libraries/Tiktok_api.php` — wrapper HTTP client: auto-attach `app_key`, `timestamp`, `sign`, refresh token otomatis kalau expired (401), retry 1x, logging ke `tiktok_api_logs`.

### 5.2 Cron Job (CodeIgniter CLI, dijadwalkan via crontab)
| Job | Interval | Fungsi |
|---|---|---|
| `refresh_token` | Setiap 12 jam | Refresh access token semua shop aktif sebelum expired |
| `pull_orders` | Setiap 2–5 menit | Tarik order baru/berubah status (Order List, sort by update_time) |
| `pull_order_detail` | Trigger setelah pull_orders | Ambil Order Detail + Price Detail untuk order baru |
| `pull_packages` | Setiap 5 menit | Search Package → update status paket & tracking |
| `push_inventory_price` | Setiap ada perubahan stok/harga di POS (queue-based) | Update Inventory & Update Prices ke TikTok |
| `pull_returns_cancellations` | Setiap 5–10 menit | Search Return & Search Cancellations (SLA respon 48 jam harus terkejar) |
| `pull_statements` | Harian | Get Statements, Get Withdrawals |
| `pull_product_status` | Setiap 30 menit | Cek status produk PENDING → ACTIVATE/FAILED hasil audit TikTok |

### 5.3 Prinsip Sinkronisasi
- **Produk & stok**: arah utama ERP → TikTok (ERP sebagai source of truth stok karena juga dipakai POS offline).
- **Order & status order/paket/retur**: arah utama TikTok → ERP (TikTok source of truth, ERP hanya mengikuti & melakukan aksi balik lewat API).
- Semua perubahan status yang berasal dari TikTok dicatat di tabel log (`*_status_logs`) agar histori status bisa ditelusuri di halaman Detail.

---

## 6. Modul & Flow Detail

### 6.1 Toko Terhubung (Shop Connect)

**Endpoint API:** Get Seller Access Token, Refresh Access Token, Get Authorized Shops

**Flow (mengikuti alur resmi TikTok Partner authorization):**
1. Admin klik "Connect Toko Baru" → redirect ke halaman otorisasi TikTok Seller Center.
2. Seller login & approve di TikTok → TikTok redirect balik ke ERP dengan `auth_code`.
3. ERP tukar `auth_code` → `access_token` + `refresh_token` (Get Seller Access Token).
4. ERP panggil Get Authorized Shops → dapat daftar shop (`shop_id`, `shop_cipher`, `shop_name`, `region`) yang diotorisasi akun tsb → tampilkan sebagai pilihan, admin pilih shop mana yang mau dipakai di ERP ini.
5. Simpan ke tabel `tiktok_shops`, status = `CONNECTED`.
6. Token direfresh otomatis oleh cron sebelum expired; kalau refresh gagal (revoked) status shop otomatis jadi `DISCONNECTED` dan admin diminta connect ulang.

**Halaman List** (`shop/index`)
Kolom: Nama Toko, Shop ID, Region, Status Koneksi (badge: Connected/Disconnected/Token Expired), Terakhir Sync, Aksi.
Filter: Status Koneksi.
Aksi per baris: Lihat Detail, Reconnect, Putuskan Koneksi.
Aksi atas: "+ Connect Toko Baru".

**Halaman Detail** (`shop/view/{id}`)
Section 1 — Info Toko: shop_id, shop_cipher (masked), shop_name, region, seller_type, connected_at.
Section 2 — Token Info (untuk keperluan debug admin teknis, akses dibatasi role Owner): access_token (masked), expire_in, refresh_token (masked), refresh_expire_in.
Section 3 — Log Sinkronisasi Terakhir: tabel mini dari `tiktok_api_logs` yang difilter shop ini (endpoint, waktu, status HTTP).

---

### 6.2 Gudang & Pengiriman

**Endpoint API:** Get Warehouse List, Get Warehouse Delivery Options, Get Shipping Providers, Confirm Package Shipment

**Flow:** Gudang di TikTok Shop **tidak dibuat dari ERP** — gudang sudah didaftarkan seller di Seller Center. ERP hanya menarik (pull, read-only) daftar warehouse & opsi pengirimannya, lalu memetakan (mapping) 1 warehouse TikTok ke 1 cabang/gudang fisik di ERP supaya saat produk dibuat, sistem tahu warehouse mana yang dipakai.

**Halaman List — Gudang** (`warehouse/index`)
Kolom: Nama Warehouse (dari TikTok), Warehouse ID, Tipe (Domestic/Cross-border), Default (Ya/Tidak), Cabang ERP yang Dipetakan, Aksi.
Aksi per baris: Lihat Detail, Petakan ke Cabang (dropdown pilih cabang ERP existing).

**Halaman Detail** (`warehouse/view/{id}`)
Section 1 — Info Warehouse: warehouse_id, name, address, effect_status, region.
Section 2 — Opsi Pengiriman (sub-tabel dari Get Warehouse Delivery Options): delivery_option_id, nama opsi, scope (Warehouse), aktif/tidak.
Section 3 — Shipping Provider per opsi pengiriman terpilih (sub-tabel dari Get Shipping Providers): provider_id, nama kurir.

---

### 6.3 Kategori & Brand (Master Data Produk)

**Endpoint API:** Get Categories, Get Categories Attributes, Get Brands, Upload Product Image

**Flow:** Kategori TikTok berbentuk tree (parent-child) dan **wajib** dipilih sampai level leaf saat membuat produk (mengikuti aturan TikTok, bukan bebas pilih level manapun). Attribute per kategori juga berbeda-beda (ada yang wajib diisi). Karena itu kategori & atribut ditarik & disimpan lokal (cache), supaya form Create Produk tidak perlu call API tiap kali user ketik.

**Halaman List — Kategori** (`category/index`)
Tampilan tree/nested (mengikuti template list-hierarki bawaan Cicool kalau tersedia; kalau tidak, tabel flat dengan kolom "Path Kategori" hasil gabungan parent → child).
Kolom: Nama Kategori, Path Lengkap, Level, Leaf (Ya/Tidak), Jumlah Atribut, Terakhir Sync.
Aksi atas: "Sync Ulang dari TikTok".

**Halaman Detail** (`category/view/{id}`)
Section 1 — Info Kategori.
Section 2 — Daftar Atribut (sub-tabel dari Get Categories Attributes): nama atribut, tipe (text/enum/dsb), wajib diisi (Ya/Tidak), daftar value (kalau enum).

**Halaman List — Brand** (`brand/index`)
Kolom: Nama Brand, Brand ID, Terautorisasi (Ya/Tidak), Kategori terkait.
Filter: Terautorisasi.

---

### 6.4 Manajemen Produk

**Endpoint API:** Search Products, Product Detail, Create Product, Edit Product, Partial Edit Product, Activate Products, Deactivate Products, Delete Products, Upload Product Image

**Status resmi TikTok (product status) — dipakai persis, dengan badge warna:**

| Status (value API) | Label tampilan | Badge | Keterangan (sesuai perilaku Seller Center) |
|---|---|---|---|
| `DRAFT` | Draft | Abu-abu | Produk disimpan tapi belum diajukan review |
| `PENDING` | Menunggu Review | Kuning | Sedang diaudit tim TikTok (baik produk baru maupun hasil edit/reaktivasi) |
| `ACTIVATE` | Aktif | Hijau | Live, bisa dibeli buyer |
| `FAILED` | Ditolak | Merah | Review gagal — ada `reason` yang wajib ditampilkan |
| `DEACTIVATED` | Nonaktif (Seller) | Abu-abu tua | Dinonaktifkan sendiri oleh seller lewat Deactivate Products |
| `FREEZE` | Dibekukan | Merah tua | Dibekukan sepihak oleh TikTok (pelanggaran) — **tidak bisa diaktifkan/nonaktifkan dari ERP**, hanya read-only sampai TikTok cabut freeze |
| `DELETED` | Dihapus | Hitam/strip | Dihapus via Delete Products — tidak bisa dikembalikan, harus buat produk baru |

**Flow status produk (mengikuti Seller Center, bukan alur custom):**
```
DRAFT ──(submit)──► PENDING ──(lolos review)──► ACTIVATE
                        │                           │
                        └──(gagal review)──► FAILED  │
                                                      ├──(seller Deactivate)──► DEACTIVATED
                                                      │                            │
                                                      │      (seller Activate, wajib stok > 0)
                                                      │                            ▼
                                                      │                        PENDING (diaudit ulang)
                                                      │
                                                      └──(TikTok freeze karena pelanggaran)──► FREEZE

(status manapun kecuali FREEZE) ──(Delete)──► DELETED
```
Catatan penting sesuai perilaku resmi: Activate **hanya valid** dari status DEACTIVATED dan **stok varian wajib > 0**; produk DRAFT/FREEZE/DELETED tidak bisa di-deactivate langsung dari tombol Deactivate.

**Halaman List — Produk** (`product/index`)
Kolom: Gambar (thumbnail utama), Nama Produk, SKU Induk, Kategori, Harga (range dari–sampai varian), Total Stok, Status (badge sesuai tabel di atas), Terakhir Update.
Filter: Status, Kategori, Toko (kalau multi-shop).
Search: Nama produk / SKU.
Bulk action (checkbox multi-select, sesuai tombol yang ada di API): Aktifkan, Nonaktifkan, Hapus.
Aksi per baris: Lihat Detail, Edit, Aktifkan/Nonaktifkan (kontekstual sesuai status saat ini), Hapus.
Tombol atas: "+ Tambah Produk".

**Halaman Detail** (`product/view/{id}`)
Header: Nama produk + badge status besar + tombol aksi kontekstual (Aktifkan/Nonaktifkan/Hapus/Edit) sesuai status saat ini (tombol yang tidak valid untuk status tsb disembunyikan, bukan cuma di-disable, supaya tidak menyesatkan user).
Section 1 — Info Umum: product_id (TikTok), kategori (full path), brand, deskripsi, berat & dimensi paket.
Section 2 — Galeri Gambar (grid thumbnail dari `product_images`).
Section 3 — Varian/SKU (sub-tabel `product_skus`): seller_sku, kombinasi atribut (mis. Warna/Ukuran), harga asli, harga jual, stok per warehouse, status masing-masing SKU (kalau TikTok mengizinkan status per-SKU).
Section 4 — Riwayat Review (kalau status `FAILED`, tampilkan alasan penolakan dari response API apa adanya).
Section 5 — Log Sinkronisasi (tabel dari `tiktok_product_sync_logs`: aksi, waktu, hasil sukses/gagal, pesan error).

**Halaman Create/Edit** (`product/create`, `product/edit/{id}`)
Form mengikuti field wajib Create Product API: pilih kategori (cascading dropdown sampai leaf) → form otomatis menampilkan atribut wajib kategori tsb (dari cache `product_category_attributes`) → nama produk, deskripsi, upload gambar (pakai Upload Product Image dulu baru attach url-nya), berat/dimensi, lalu repeater varian (kombinasi atribut jual seperti warna/ukuran + harga + stok + seller_sku per varian).
Tombol submit: "Simpan sebagai Draft" (Create Product tanpa submit review) vs "Simpan & Ajukan Review" — mengikuti opsi resmi TikTok. Edit produk yang sudah `ACTIVATE` otomatis mengirim ulang ke status `PENDING` (mengikuti perilaku resmi: edit produk live wajib direview ulang) — ini **wajib** ditampilkan sebagai peringatan sebelum submit.

---

### 6.5 Stok & Harga (Inventory & Price Sync)

**Endpoint API:** Update Inventory, Update Prices

**Flow:** Ini bukan menu manual terpisah — perubahan stok terjadi otomatis tiap kali stok produk (yang sudah dipetakan ke SKU TikTok) berubah di modul Inventory ERP (baik karena penjualan POS offline, retur, maupun stok opname). Perubahan masuk **queue** (`tiktok_sync_queue`), diproses job `push_inventory_price`, hasilnya dicatat di `tiktok_product_sync_logs`.

**Halaman monitoring** (`inventory_sync/index`) — bukan CRUD produk, tapi log antrian sinkronisasi.
Kolom: Produk/SKU, Jenis Perubahan (Stok/Harga), Nilai Lama → Nilai Baru, Status Kirim (Menunggu/Berhasil/Gagal), Waktu.
Filter: Status Kirim.
Aksi: "Kirim Ulang" untuk baris yang Gagal (retry manual).

---

### 6.6 Order TikTok

**Endpoint API:** Order List, Order Detail, Price Detail, Cancel Order

**Status resmi TikTok (order status):**

| Status | Label | Badge | Keterangan |
|---|---|---|---|
| `UNPAID` | Belum Dibayar | Abu-abu | Order dibuat, buyer belum bayar |
| `ON_HOLD` | Ditahan | Kuning | Jeda "buyer remorse window" (±1 jam, atau aturan khusus UK) sebelum masuk proses kirim; **stok belum dipotong TikTok di status ini** |
| `AWAITING_SHIPMENT` | Menunggu Dikirim | Oranye | Sudah lolos hold, siap diproses gudang (pack & buat label) |
| `AWAITING_COLLECTION` | Menunggu Diambil Kurir | Biru | Paket sudah di-ship dari sistem, menunggu kurir pickup; buyer **tidak bisa** ajukan cancel lagi mulai status ini |
| `PARTIALLY_SHIPPING` | Sebagian Dikirim | Biru muda | Order dengan multi-item, sebagian sudah dikirim sebagian belum (hasil Split Order) |
| `IN_TRANSIT` | Dalam Pengiriman | Biru tua | Sudah diambil kurir, dalam perjalanan |
| `DELIVERED` | Terkirim | Hijau muda | Sampai ke buyer, masih dalam window klaim/retur |
| `COMPLETED` | Selesai | Hijau | Window retur habis, dana settle ke seller |
| `CANCELLED` | Dibatalkan | Merah | Dibatalkan (buyer/seller/sistem), tidak ada pengiriman, dana buyer dikembalikan |

**Flow (resmi, sesuai Seller Center):**
```
UNPAID → (bayar) → ON_HOLD → (lolos hold window) → AWAITING_SHIPMENT
   → (seller confirm/ship package) → AWAITING_COLLECTION (atau PARTIALLY_SHIPPING kalau di-split)
   → (kurir pickup) → IN_TRANSIT → DELIVERED → (window retur habis) → COMPLETED

Cancel hanya valid dari: ON_HOLD, AWAITING_SHIPMENT, AWAITING_COLLECTION → CANCELLED
```
Catatan resmi yang wajib diikuti sistem (bukan asumsi): seller **hanya boleh** cancel order dengan status `ON_HOLD`, `AWAITING_SHIPMENT`, atau `AWAITING_COLLECTION` — tombol Batalkan Order di ERP **disembunyikan otomatis** di luar 3 status ini.

**Halaman List — Order** (`order/index`)
Kolom: No. Order (order_id), Tanggal Order, Nama Buyer, Jumlah Item, Total Bayar, Status (badge di atas), Toko, Aksi.
Filter: Status Order, Rentang Tanggal, Toko.
Search: No. Order / Nama Buyer.
Sort default: Terbaru dulu (mengikuti `sort_field=create_time&sort_order=DESC` di API).
Aksi per baris: Lihat Detail, Batalkan (kontekstual, hanya muncul di 3 status yang diizinkan).

**Halaman Detail** (`order/view/{id}`)
Header: No. Order + badge status besar + tombol Batalkan (kontekstual).
Section 1 — Info Buyer & Pengiriman: nama penerima, no. telp (masked sesuai kebijakan privasi TikTok), alamat, catatan buyer.
Section 2 — Daftar Item (sub-tabel `order_line_items`): gambar SKU, nama produk, seller_sku, qty, harga satuan, subtotal, status pengiriman per item (relevan untuk order yang di-split).
Section 3 — Rincian Harga (dari Price Detail API, sub-tabel `order_price_details`): subtotal produk, ongkir dibayar buyer, ongkir ditanggung platform, diskon seller, diskon platform, pajak, total diterima seller — ditampilkan persis breakdown resmi TikTok, bukan dihitung ulang manual di ERP.
Section 4 — Riwayat Status (`order_status_logs`): timeline perubahan status beserta waktu.
Section 5 — Paket Terkait (kalau order sudah diproses fulfillment): link ke Detail Paket.

---

### 6.7 Fulfillment (Paket)

**Endpoint API:** Tracking Order, Order Split Attributes, Split Orders, Search Package, Package Detail, Search Combinable Package, Combine Package, Ship Package, Batch Ship Packages, Package Shipping Document, Create First Mile Bundle (V2), Package Handover Time Slots, Confirm Package Shipment

**Flow (resmi, sesuai proses gudang di Seller Center):**
1. Order berstatus `AWAITING_SHIPMENT` → sistem/gudang cek **Order Split Attributes** untuk tahu apakah order ini boleh/harus dipecah (misal beda gudang asal per item).
2. Kalau perlu dipecah → **Split Orders** → menghasilkan lebih dari satu package.
3. Kalau sebaliknya ada beberapa order kecil yang bisa digabung 1 pengiriman → cek **Search Combinable Package** → **Combine Package**.
4. Cetak label: **Package Shipping Document** (pilih tipe dokumen: SHIPPING_LABEL, ukuran A6, format PDF — sesuai default resmi).
5. **Confirm Package Shipment** (mengonfirmasi paket siap sebelum di-ship) → **Ship Package** (satuan) atau **Batch Ship Packages** (banyak sekaligus) → status paket & order berubah ke `AWAITING_COLLECTION`.
6. Atur jadwal serah terima ke kurir: **Package Handover Time Slots**, atau untuk cross-border: **Create First Mile Bundle**.
7. **Tracking Order** dipanggil berkala (via cron `pull_packages`) untuk update posisi kurir sampai `DELIVERED`.

**Status Paket (package status)** mengikuti status pengiriman yang sama dengan status order level pengiriman (`AWAITING_SHIPMENT` → `AWAITING_COLLECTION` → `IN_TRANSIT` → `DELIVERED`), ditambah state internal proses:

| Status | Label | Keterangan |
|---|---|---|
| `TO_FULFILL` | Perlu Diproses | Package terbentuk, label belum dicetak/dikonfirmasi |
| `AWAITING_COLLECTION` | Menunggu Kurir | Sudah di-ship, menunggu pickup |
| `IN_TRANSIT` | Dalam Pengiriman | Sudah diambil kurir |
| `DELIVERED` | Terkirim | Sudah sampai |

**Halaman List — Paket** (`package/index`)
Kolom: No. Paket (package_id), No. Order terkait, Jumlah Item, Kurir, No. Resi, Status (badge), Terakhir Update.
Filter: Status, Kurir.
Bulk action: Kirim Sekaligus (Batch Ship — untuk paket berstatus TO_FULFILL yang sudah dicetak labelnya).
Aksi per baris: Lihat Detail, Cetak Label, Kirim (Ship), Gabung Paket (kalau eligible).

**Halaman Detail** (`package/view/{id}`)
Section 1 — Info Paket: package_id, status, warehouse asal, berat total, dibuat pada.
Section 2 — Item dalam Paket (sub-tabel `package_items`, link ke order_line_item).
Section 3 — Info Pengiriman: kurir/shipping_provider, no. resi, jadwal handover (kalau sudah diatur).
Section 4 — Tracking (timeline dari Tracking Order API): tiap checkpoint scan kurir dengan waktu & lokasi apa adanya dari response TikTok.
Section 5 — Dokumen: link/preview PDF label dari `shipping_documents`.
Aksi di halaman: Cetak Ulang Label, Kirim (kalau status masih TO_FULFILL), Lacak Ulang (force refresh tracking).

---

### 6.8 Keuangan TikTok

**Endpoint API:** Get Statements, Get Withdrawals, Get Transactions by Order, Get Transactions by Statement, Get Unsettled Transactions

**Flow:** Read-only monitoring — ERP **tidak** mengubah data keuangan, hanya menampilkan apa adanya dari TikTok untuk keperluan rekonsiliasi dengan pembukuan internal.

**Status Statement (`payment_status`):** `PROCESSING`, `PAID` — statement adalah "tagihan periodik" berisi kumpulan transaksi yang sudah/akan dibayarkan TikTok ke seller.

**Halaman List — Statement** (`statement/index`)
Kolom: Statement ID, Periode (statement_time), Total Pendapatan, Status Bayar (badge), Tanggal Bayar.
Filter: Status Bayar, Rentang Tanggal.
Aksi: Lihat Detail (→ daftar transaksi di statement itu, dari Get Transactions by Statement).

**Halaman Detail Statement** (`statement/view/{id}`)
Section 1 — Ringkasan: total revenue, mata uang, status.
Section 2 — Daftar Transaksi (sub-tabel dari Get Transactions by Statement): order terkait, jenis transaksi (Penjualan/Komisi/Ongkir/dll — apa adanya dari field `transaction_type` TikTok), jumlah.

**Halaman List — Withdrawal** (`withdrawal/index`)
Kolom: Withdrawal ID, Tipe (mis. REVERSE/normal — sesuai enum resmi `types`), Jumlah, Status, Tanggal.
Filter: Tipe, Rentang Tanggal.

**Halaman List — Transaksi Belum Settle** (`unsettled_transaction/index`)
Kolom: No. Order, Tanggal Order Dibuat, Estimasi Jumlah, Status. Ini menu penting buat finance memantau dana yang masih "mengambang" (belum masuk statement manapun).

**Halaman Detail Order (tab Transaksi)** — di halaman Detail Order (6.6) ditambahkan tab "Transaksi Keuangan" yang menarik dari Get Transactions by Order, supaya CS/finance tidak perlu pindah menu untuk cek 1 order.

---

### 6.9 Retur & Pembatalan

**Endpoint API — Retur:** Search Return, Create Return, Approve Returns, Reject Return, Get Reject Reasons
**Endpoint API — Pembatalan:** Search Cancellations, Approve Cancellation, Reject Cancellation

#### A. Status Retur/Refund resmi TikTok

| Status | Label | Badge | Keterangan |
|---|---|---|---|
| `RETURN_OR_REFUND_REQUEST_PENDING` | Menunggu Persetujuan Seller | Kuning | Buyer baru mengajukan — **SLA seller wajib respon dalam 48 jam**, lewat itu otomatis di-approve TikTok |
| `RETURN_OR_REFUND_REQUEST_REJECTED` | Ditolak Seller | Merah | Seller reject dengan alasan (wajib pilih dari Get Reject Reasons) — buyer masih bisa banding ke TikTok |
| `AWAITING_BUYER_SHIP` | Menunggu Buyer Kirim Barang | Oranye | Khusus tipe RETURN_AND_REFUND — seller sudah approve, menunggu buyer kirim balik barang |
| `BUYER_SHIPPED_ITEM` | Barang Dikirim Buyer | Biru | Buyer sudah kirim, menunggu diterima seller/gudang |
| `REJECT_RECEIVE_PACKAGE` | Seller Tolak Terima Paket | Merah | Seller menolak paket retur yang diterima (barang tidak sesuai kondisi) — bisa berujung sengketa |
| `RETURN_OR_REFUND_REQUEST_CANCEL` | Dibatalkan Buyer | Abu-abu | Buyer membatalkan sendiri pengajuan retur |
| `RETURN_OR_REFUND_REQUEST_SUCCESS` | Disetujui | Hijau muda | Retur/refund disetujui, dana dalam proses ke buyer |
| `RETURN_OR_REFUND_REQUEST_COMPLETE` | Selesai | Hijau | Dana sudah selesai dikembalikan ke buyer |

Tipe retur (`type`): `RETURN_AND_REFUND` (barang dikirim balik + uang kembali) vs `REFUND` (uang kembali saja, tanpa kirim balik barang — biasa untuk barang rusak/tidak sampai).

**Flow Retur (resmi):**
```
RETURN_OR_REFUND_REQUEST_PENDING
   ├─(seller Approve)─┬─ tipe REFUND ───────────────► RETURN_OR_REFUND_REQUEST_SUCCESS → ...COMPLETE
   │                   └─ tipe RETURN_AND_REFUND ──► AWAITING_BUYER_SHIP → BUYER_SHIPPED_ITEM
   │                                                        ├─(seller terima & cocok)─► RETURN_OR_REFUND_REQUEST_SUCCESS → ...COMPLETE
   │                                                        └─(seller tolak terima)──► REJECT_RECEIVE_PACKAGE (lanjut ke sengketa/appeal)
   ├─(seller Reject, wajib isi reason)──► RETURN_OR_REFUND_REQUEST_REJECTED
   └─(buyer batal sendiri)──► RETURN_OR_REFUND_REQUEST_CANCEL

Tidak direspon 48 jam ──► otomatis SUCCESS (auto-approve oleh sistem TikTok, dicatat di ERP sebagai perubahan status hasil sync, bukan aksi manual)
```

**Halaman List — Retur** (`return/index`)
Kolom: Return ID, No. Order, Buyer, Tipe (Return&Refund/Refund saja), Alasan, Jumlah Refund, Status (badge), Batas Waktu Respon (dihitung mundur dari SLA 48 jam, **highlight merah** kalau < 6 jam tersisa), Tanggal Pengajuan.
Filter: Status, Tipe.
Sort default: Batas Waktu Respon terdekat dulu (supaya SLA tidak kelewat).
Aksi per baris: Lihat Detail, Setujui, Tolak (kontekstual — hanya muncul saat status `..._PENDING`).

**Halaman Detail Retur** (`return/view/{id}`)
Section 1 — Info Pengajuan: return_id, order terkait, buyer, tipe, alasan, deskripsi buyer, foto bukti (kalau ada, dari field images response).
Section 2 — Item yang Diretur (sub-tabel): sku, qty, jumlah refund per item.
Section 3 — Riwayat Status (timeline, sama pola dengan order).
Aksi kontekstual sesuai status saat ini:
- Status `..._PENDING` → tombol **Setujui** / **Tolak** (Tolak wajib pilih alasan dari dropdown Get Reject Reasons, bukan free text, sesuai TikTok).
- Status `BUYER_SHIPPED_ITEM` → tombol **Terima Paket** / **Tolak Terima Paket**.
- Status lain → read only, tombol aksi disembunyikan.

#### B. Status Pembatalan (Cancellation) resmi TikTok

| Status | Label | Badge |
|---|---|---|
| `CANCELLATION_REQUEST_PENDING` | Menunggu Persetujuan | Kuning |
| `CANCELLATION_REQUEST_SUCCESS` | Disetujui | Hijau muda |
| `CANCELLATION_REQUEST_COMPLETE` | Selesai (Order Cancelled) | Hijau |
| `CANCELLATION_REQUEST_REJECTED` | Ditolak Seller | Merah |

**Flow Pembatalan (resmi):** buyer atau seller mengajukan cancel (dari sisi ERP juga bisa lewat tombol Batalkan di Detail Order, memanggil endpoint yang sama) selama order masih `ON_HOLD`/`AWAITING_SHIPMENT`/`AWAITING_COLLECTION` → masuk `CANCELLATION_REQUEST_PENDING` → seller Approve/Reject → kalau Approve, status order otomatis berubah jadi `CANCELLED` (lihat 6.6).
Catatan khusus resmi: untuk toko region **UK**, status order `ON_HOLD` = window "buyer remorse" — pengajuan cancel di window ini **otomatis di-approve sistem TikTok**, tidak butuh aksi seller.

**Halaman List — Pembatalan** (`cancellation/index`)
Kolom: Cancel ID, No. Order, Diajukan Oleh (Buyer/Seller/Sistem), Alasan, Status (badge), Tanggal.
Filter: Status.
Aksi per baris: Lihat Detail, Setujui, Tolak (kontekstual, hanya di status Pending).

**Halaman Detail Pembatalan** (`cancellation/view/{id}`)
Section 1 — Info: cancel_id, order terkait, alasan, item & qty yang dibatalkan (bisa parsial per line item).
Section 2 — Riwayat Status.

---

## 7. Skema Database

Penamaan tabel pakai prefix `tiktok_` supaya terpisah jelas dari tabel ERP/POS inti. Semua tabel punya kolom lokal standar Cicool: `id` (PK auto increment), `created_at`, `updated_at`, `created_by`, `updated_by`. Kolom ID milik TikTok disimpan sebagai `varchar` (bukan asumsi integer, karena TikTok mengirim ID sebagai string besar) dengan index unique per shop.

### 7.1 Toko & Autentikasi

```sql
CREATE TABLE tiktok_shops (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  branch_id INT UNSIGNED NULL,                 -- FK ke tabel cabang ERP (opsional, kalau 1 shop = 1 cabang)
  tiktok_shop_id VARCHAR(64) NOT NULL,
  shop_cipher VARCHAR(255) NOT NULL,
  shop_name VARCHAR(150) NOT NULL,
  region VARCHAR(10) NOT NULL,
  seller_type VARCHAR(50) NULL,
  app_key VARCHAR(100) NOT NULL,
  app_secret VARCHAR(255) NOT NULL,             -- disimpan terenkripsi
  access_token TEXT NOT NULL,                   -- terenkripsi
  access_token_expire_at DATETIME NOT NULL,
  refresh_token TEXT NOT NULL,                  -- terenkripsi
  refresh_token_expire_at DATETIME NOT NULL,
  status ENUM('CONNECTED','DISCONNECTED','TOKEN_EXPIRED') NOT NULL DEFAULT 'CONNECTED',
  connected_at DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_shop (tiktok_shop_id)
);

CREATE TABLE tiktok_api_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NULL,
  endpoint VARCHAR(255) NOT NULL,
  method VARCHAR(10) NOT NULL,
  request_payload LONGTEXT NULL,
  response_payload LONGTEXT NULL,
  http_status INT NULL,
  is_success TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  INDEX idx_shop_time (shop_id, created_at)
);
```

### 7.2 Gudang & Logistik

```sql
CREATE TABLE tiktok_warehouses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  tiktok_warehouse_id VARCHAR(64) NOT NULL,
  branch_mapping_id INT UNSIGNED NULL,          -- FK ke tabel gudang/cabang ERP
  name VARCHAR(150) NOT NULL,
  address TEXT NULL,
  warehouse_type VARCHAR(50) NULL,
  effect_status VARCHAR(50) NULL,
  is_default TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_wh (shop_id, tiktok_warehouse_id)
);

CREATE TABLE tiktok_delivery_options (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  warehouse_id INT UNSIGNED NOT NULL,
  tiktok_delivery_option_id VARCHAR(64) NOT NULL,
  name VARCHAR(150) NULL,
  scope VARCHAR(50) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_shipping_providers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  delivery_option_id INT UNSIGNED NOT NULL,
  tiktok_provider_id VARCHAR(64) NOT NULL,
  name VARCHAR(150) NULL,
  created_at DATETIME NOT NULL
);
```

### 7.3 Kategori, Atribut, Brand

```sql
CREATE TABLE tiktok_categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tiktok_category_id VARCHAR(64) NOT NULL,
  parent_category_id VARCHAR(64) NULL,
  local_name VARCHAR(150) NOT NULL,
  category_version VARCHAR(10) NULL,
  is_leaf TINYINT(1) NOT NULL DEFAULT 0,
  level INT NULL,
  permission_status VARCHAR(50) NULL,
  synced_at DATETIME NULL,
  UNIQUE KEY uq_cat (tiktok_category_id)
);

CREATE TABLE tiktok_category_attributes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  tiktok_attribute_id VARCHAR(64) NOT NULL,
  attribute_name VARCHAR(150) NOT NULL,
  attribute_type VARCHAR(50) NULL,
  is_required TINYINT(1) NOT NULL DEFAULT 0,
  values_json LONGTEXT NULL,               -- daftar value enum jika ada
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_brands (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tiktok_brand_id VARCHAR(64) NOT NULL,
  category_id INT UNSIGNED NULL,
  name VARCHAR(150) NOT NULL,
  is_authorized TINYINT(1) NOT NULL DEFAULT 0,
  synced_at DATETIME NULL,
  UNIQUE KEY uq_brand (tiktok_brand_id)
);
```

### 7.4 Produk

```sql
CREATE TABLE tiktok_products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  local_product_id INT UNSIGNED NULL,       -- FK ke tabel produk master ERP (mapping produk POS <-> TikTok)
  tiktok_product_id VARCHAR(64) NULL,       -- null selama masih draft belum pernah create ke TikTok
  category_id INT UNSIGNED NULL,
  brand_id INT UNSIGNED NULL,
  title VARCHAR(255) NOT NULL,
  description LONGTEXT NULL,
  package_weight DECIMAL(10,2) NULL,
  package_length DECIMAL(10,2) NULL,
  package_width DECIMAL(10,2) NULL,
  package_height DECIMAL(10,2) NULL,
  is_cod_allowed TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('DRAFT','PENDING','ACTIVATE','FAILED','DEACTIVATED','FREEZE','DELETED') NOT NULL DEFAULT 'DRAFT',
  reject_reason TEXT NULL,
  tiktok_create_time DATETIME NULL,
  tiktok_update_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_prod (shop_id, tiktok_product_id)
);

CREATE TABLE tiktok_product_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  tiktok_image_id VARCHAR(100) NULL,
  image_url VARCHAR(500) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_product_skus (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  tiktok_sku_id VARCHAR(64) NULL,
  local_sku_id INT UNSIGNED NULL,           -- FK ke tabel varian produk POS
  seller_sku VARCHAR(100) NULL,
  sales_attributes_json LONGTEXT NULL,      -- kombinasi atribut jual, mis. {"Warna":"Merah","Ukuran":"XL"}
  price_original DECIMAL(15,2) NULL,
  price_sale DECIMAL(15,2) NULL,
  currency VARCHAR(10) NULL,
  warehouse_id INT UNSIGNED NULL,
  stock_quantity INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL
);

CREATE TABLE tiktok_product_sync_logs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  action VARCHAR(50) NOT NULL,              -- CREATE/EDIT/ACTIVATE/DEACTIVATE/DELETE/STOCK/PRICE
  request_payload LONGTEXT NULL,
  response_payload LONGTEXT NULL,
  is_success TINYINT(1) NOT NULL DEFAULT 0,
  error_message TEXT NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_sync_queue (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_sku_id INT UNSIGNED NOT NULL,
  change_type ENUM('STOCK','PRICE') NOT NULL,
  old_value VARCHAR(50) NULL,
  new_value VARCHAR(50) NULL,
  status ENUM('PENDING','SUCCESS','FAILED') NOT NULL DEFAULT 'PENDING',
  attempt_count INT NOT NULL DEFAULT 0,
  last_error TEXT NULL,
  created_at DATETIME NOT NULL,
  processed_at DATETIME NULL
);
```

### 7.5 Order

```sql
CREATE TABLE tiktok_orders (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  tiktok_order_id VARCHAR(64) NOT NULL,
  order_status ENUM('UNPAID','ON_HOLD','AWAITING_SHIPMENT','AWAITING_COLLECTION',
                     'PARTIALLY_SHIPPING','IN_TRANSIT','DELIVERED','COMPLETED','CANCELLED') NOT NULL,
  buyer_message TEXT NULL,
  recipient_name VARCHAR(150) NULL,
  recipient_phone VARCHAR(50) NULL,
  shipping_address TEXT NULL,
  currency VARCHAR(10) NULL,
  total_amount DECIMAL(15,2) NULL,
  sub_total DECIMAL(15,2) NULL,
  shipping_fee DECIMAL(15,2) NULL,
  seller_discount DECIMAL(15,2) NULL,
  platform_discount DECIMAL(15,2) NULL,
  tax_amount DECIMAL(15,2) NULL,
  warehouse_id INT UNSIGNED NULL,
  cancel_reason VARCHAR(255) NULL,
  tiktok_create_time DATETIME NULL,
  tiktok_paid_time DATETIME NULL,
  tiktok_update_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_order (shop_id, tiktok_order_id),
  INDEX idx_status (order_status)
);

CREATE TABLE tiktok_order_line_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  tiktok_line_item_id VARCHAR(64) NOT NULL,
  product_sku_id INT UNSIGNED NULL,
  product_name VARCHAR(255) NULL,
  sku_name VARCHAR(255) NULL,
  seller_sku VARCHAR(100) NULL,
  sku_image VARCHAR(500) NULL,
  quantity INT NOT NULL DEFAULT 1,
  original_price DECIMAL(15,2) NULL,
  sale_price DECIMAL(15,2) NULL,
  package_id VARCHAR(64) NULL,
  display_status VARCHAR(50) NULL,
  is_gift TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE tiktok_order_price_details (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  fee_type VARCHAR(100) NOT NULL,          -- mis. SHIPPING_FEE, TAX, SELLER_DISCOUNT, dst — apa adanya dari API
  amount DECIMAL(15,2) NOT NULL,
  currency VARCHAR(10) NULL
);

CREATE TABLE tiktok_order_status_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  old_status VARCHAR(50) NULL,
  new_status VARCHAR(50) NOT NULL,
  source ENUM('SYNC_TIKTOK','ACTION_ERP') NOT NULL DEFAULT 'SYNC_TIKTOK',
  changed_at DATETIME NOT NULL
);
```

### 7.6 Fulfillment / Paket

```sql
CREATE TABLE tiktok_packages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  order_id INT UNSIGNED NOT NULL,
  tiktok_package_id VARCHAR(64) NOT NULL,
  status ENUM('TO_FULFILL','AWAITING_COLLECTION','IN_TRANSIT','DELIVERED') NOT NULL DEFAULT 'TO_FULFILL',
  shipping_provider_id INT UNSIGNED NULL,
  tracking_number VARCHAR(100) NULL,
  total_weight DECIMAL(10,2) NULL,
  tiktok_create_time DATETIME NULL,
  tiktok_update_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_pkg (shop_id, tiktok_package_id)
);

CREATE TABLE tiktok_package_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  package_id INT UNSIGNED NOT NULL,
  order_line_item_id INT UNSIGNED NOT NULL,
  quantity INT NOT NULL DEFAULT 1
);

CREATE TABLE tiktok_package_tracking (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  package_id INT UNSIGNED NOT NULL,
  checkpoint_status VARCHAR(100) NULL,
  checkpoint_description TEXT NULL,
  checkpoint_time DATETIME NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_shipping_documents (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  package_id INT UNSIGNED NOT NULL,
  document_type VARCHAR(50) NULL,          -- SHIPPING_LABEL, dst.
  document_format VARCHAR(20) NULL,        -- PDF
  document_url VARCHAR(500) NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE tiktok_handover_time_slots (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  package_id INT UNSIGNED NOT NULL,
  slot_start DATETIME NULL,
  slot_end DATETIME NULL,
  is_selected TINYINT(1) NOT NULL DEFAULT 0
);
```

### 7.7 Keuangan

```sql
CREATE TABLE tiktok_statements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  tiktok_statement_id VARCHAR(64) NOT NULL,
  statement_time DATETIME NULL,
  payment_status VARCHAR(30) NULL,          -- PROCESSING / PAID
  revenue_amount DECIMAL(15,2) NULL,
  currency VARCHAR(10) NULL,
  paid_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  UNIQUE KEY uq_stmt (shop_id, tiktok_statement_id)
);

CREATE TABLE tiktok_withdrawals (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  tiktok_withdrawal_id VARCHAR(64) NOT NULL,
  type VARCHAR(30) NULL,
  amount DECIMAL(15,2) NULL,
  currency VARCHAR(10) NULL,
  status VARCHAR(30) NULL,
  tiktok_create_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  UNIQUE KEY uq_wd (shop_id, tiktok_withdrawal_id)
);

CREATE TABLE tiktok_statement_transactions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  statement_id INT UNSIGNED NULL,           -- null jika masih unsettled
  order_id INT UNSIGNED NULL,
  transaction_type VARCHAR(50) NULL,
  amount DECIMAL(15,2) NULL,
  currency VARCHAR(10) NULL,
  settlement_status ENUM('SETTLED','UNSETTLED') NOT NULL DEFAULT 'UNSETTLED',
  tiktok_create_time DATETIME NULL,
  created_at DATETIME NOT NULL
);
```

### 7.8 Retur & Pembatalan

```sql
CREATE TABLE tiktok_returns (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  order_id INT UNSIGNED NOT NULL,
  tiktok_return_id VARCHAR(64) NOT NULL,
  return_type ENUM('RETURN_AND_REFUND','REFUND') NOT NULL,
  status ENUM('RETURN_OR_REFUND_REQUEST_PENDING','RETURN_OR_REFUND_REQUEST_REJECTED',
              'AWAITING_BUYER_SHIP','BUYER_SHIPPED_ITEM','REJECT_RECEIVE_PACKAGE',
              'RETURN_OR_REFUND_REQUEST_CANCEL','RETURN_OR_REFUND_REQUEST_SUCCESS',
              'RETURN_OR_REFUND_REQUEST_COMPLETE') NOT NULL,
  reason_code VARCHAR(100) NULL,
  reason_text TEXT NULL,
  refund_amount DECIMAL(15,2) NULL,
  currency VARCHAR(10) NULL,
  response_deadline DATETIME NULL,          -- create_time + 48 jam, dipakai buat sort & highlight SLA
  tiktok_create_time DATETIME NULL,
  tiktok_update_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_ret (shop_id, tiktok_return_id)
);

CREATE TABLE tiktok_return_line_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  return_id INT UNSIGNED NOT NULL,
  order_line_item_id INT UNSIGNED NULL,
  sku_name VARCHAR(255) NULL,
  quantity INT NOT NULL DEFAULT 1,
  refund_amount DECIMAL(15,2) NULL
);

CREATE TABLE tiktok_return_evidence_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  return_id INT UNSIGNED NOT NULL,
  image_url VARCHAR(500) NOT NULL
);

CREATE TABLE tiktok_return_status_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  return_id INT UNSIGNED NOT NULL,
  old_status VARCHAR(60) NULL,
  new_status VARCHAR(60) NOT NULL,
  source ENUM('SYNC_TIKTOK','ACTION_ERP') NOT NULL DEFAULT 'SYNC_TIKTOK',
  changed_at DATETIME NOT NULL
);

CREATE TABLE tiktok_reject_reasons (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reason_code VARCHAR(100) NOT NULL,
  reason_text VARCHAR(255) NOT NULL,
  locale VARCHAR(10) NOT NULL DEFAULT 'id-ID',
  applies_to ENUM('RETURN','CANCELLATION') NOT NULL,
  synced_at DATETIME NULL
);

CREATE TABLE tiktok_cancellations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  shop_id INT UNSIGNED NOT NULL,
  order_id INT UNSIGNED NOT NULL,
  tiktok_cancel_id VARCHAR(64) NOT NULL,
  status ENUM('CANCELLATION_REQUEST_PENDING','CANCELLATION_REQUEST_SUCCESS',
              'CANCELLATION_REQUEST_COMPLETE','CANCELLATION_REQUEST_REJECTED') NOT NULL,
  requested_by ENUM('BUYER','SELLER','SYSTEM') NULL,
  cancel_reason VARCHAR(255) NULL,
  tiktok_create_time DATETIME NULL,
  tiktok_update_time DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NULL,
  UNIQUE KEY uq_cancel (shop_id, tiktok_cancel_id)
);

CREATE TABLE tiktok_cancellation_line_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cancellation_id INT UNSIGNED NOT NULL,
  order_line_item_id INT UNSIGNED NULL,
  quantity INT NOT NULL DEFAULT 1
);
```

---

## 8. Non-Functional Requirements

1. **Keamanan token**: `app_secret`, `access_token`, `refresh_token` disimpan terenkripsi (mis. AES-256 via CI3 encryption library), tidak pernah ditampilkan full di UI — hanya masked (`****1234`).
2. **Idempotency**: endpoint yang butuh `idempotency_key` (Create Return, Approve/Reject Return, Approve/Reject Cancellation) — ERP generate key unik per aksi user (mis. `UUID`) dan simpan supaya klik ganda tidak mengirim request duplikat ke TikTok.
3. **Rate limit**: semua call API dibatasi lewat queue/throttle di `Tiktok_api.php` supaya tidak kena limit dari TikTok; kalau limit tercapai, job cron mundur otomatis (exponential backoff) dan dicatat di `tiktok_api_logs`.
4. **Konsistensi status**: status yang ditampilkan di ERP **selalu berasal dari hasil sync terakhir API TikTok**, bukan hasil kalkulasi lokal — supaya tidak pernah berbeda dengan apa yang seller lihat langsung di Seller Center.
5. **Audit trail**: setiap aksi tulis (Approve/Reject/Cancel/Activate/dll) yang dilakukan user ERP dicatat siapa (`created_by`/`updated_by`) dan kapan, sesuai standar Cicool.
6. **Multi-shop**: struktur tabel sudah mendukung 1 ERP menghubungkan banyak `tiktok_shops`; semua query List wajib difilter berdasarkan shop yang jadi akses user (kecuali Owner yang bisa lihat semua).

---

## 9. Lampiran — Mapping Endpoint API → Menu → Tabel DB

| Endpoint API | Menu ERP | Tabel Utama |
|---|---|---|
| Get Seller Access Token / Refresh Access Token | Toko Terhubung | `tiktok_shops` |
| Get Authorized Shops | Toko Terhubung | `tiktok_shops` |
| Get Warehouse List | Gudang & Pengiriman | `tiktok_warehouses` |
| Get Warehouse Delivery Options | Gudang & Pengiriman (Detail) | `tiktok_delivery_options` |
| Get Shipping Providers | Gudang & Pengiriman (Detail) | `tiktok_shipping_providers` |
| Confirm Package Shipment | Fulfillment | `tiktok_packages` |
| Upload Product Image | Produk (Form) | `tiktok_product_images` |
| Get Categories / Get Categories Attributes | Kategori & Brand | `tiktok_categories`, `tiktok_category_attributes` |
| Get Brands | Kategori & Brand | `tiktok_brands` |
| Search Products / Product Detail | Daftar Produk (List/Detail) | `tiktok_products`, `tiktok_product_skus` |
| Create/Edit/Partial Edit Product | Daftar Produk (Form) | `tiktok_products`, `tiktok_product_sync_logs` |
| Activate/Deactivate/Delete Products | Daftar Produk (Aksi) | `tiktok_products`, `tiktok_product_sync_logs` |
| Update Inventory / Update Prices | Stok & Harga Sync | `tiktok_sync_queue`, `tiktok_product_skus` |
| Order List / Order Detail / Price Detail | Order TikTok | `tiktok_orders`, `tiktok_order_line_items`, `tiktok_order_price_details` |
| Cancel Order | Order TikTok (Aksi) | `tiktok_orders`, `tiktok_cancellations` |
| Tracking Order | Paket (Detail) | `tiktok_package_tracking` |
| Order Split Attributes / Split Orders | Fulfillment | `tiktok_packages`, `tiktok_package_items` |
| Search/Combine Package | Fulfillment | `tiktok_packages` |
| Ship/Batch Ship Package | Fulfillment (Aksi) | `tiktok_packages` |
| Package Shipping Document | Fulfillment (Detail) | `tiktok_shipping_documents` |
| First Mile Bundle / Handover Time Slots | Fulfillment (Aksi) | `tiktok_handover_time_slots` |
| Get Statements | Keuangan | `tiktok_statements` |
| Get Withdrawals | Keuangan | `tiktok_withdrawals` |
| Get Transactions by Order/Statement/Unsettled | Keuangan | `tiktok_statement_transactions` |
| Search/Create Return, Approve/Reject Return | Retur & Refund | `tiktok_returns`, `tiktok_return_line_items` |
| Get Reject Reasons | Retur & Refund (master) | `tiktok_reject_reasons` |
| Search Cancellations, Approve/Reject Cancellation | Retur & Refund | `tiktok_cancellations` |

---

**Catatan penutup untuk tim dev:** dokumen ini memetakan 1:1 dari collection endpoint yang tersedia. Belum tercakup: webhook real-time (belum ada di collection), multi-currency conversion, dan manajemen promo/voucher TikTok — kalau modul-modul ini dibutuhkan, perlu PRD tambahan setelah endpoint terkait tersedia.
