# 🎁 VENDIO ORDER PRIZES (VENDIO REWARDS)
> **Engine Gamifikasi & Loyalty Undian Pesanan E-Commerce Berbasis Multi-Tenant**  
> Didesain untuk ekosistem omnichannel Vendio (TikTok Shop, Shopee, Tokopedia, Lazada, & Pesanan Mandiri).

---

## 📌 DAFTAR ISI
1. [Latar Belakang & Konsep Bisnis](#1-latar-belakang--konsep-bisnis)
2. [Arsitektur Multi-Tenant (Isolasi Antar-Seller)](#2-arsitektur-multi-tenant-isolasi-antar-seller)
3. [Mekanisme Undian: Threshold Pengaman vs Bobot Peluang](#3-mekanisme-undian-threshold-pengaman-vs-bobot-peluang)
4. [Master Hadiah & Relasi Many-to-Many](#4-master-hadiah--relasi-many-to-many)
5. [Workflow Pelanggan: Zero Claim Friction (Spin = Claim)](#5-workflow-pelanggan-zero-claim-friction-spin--claim)
6. [Batas Waktu Partisipasi (Claim Days Window)](#6-batas-waktu-partisipasi-claim-days-window)
7. [Integrasi Marketplace & Input Pesanan](#7-integrasi-marketplace--input-pesanan)
8. [Struktur Database & Skema Tabel](#8-struktur-database--skema-tabel)
9. [Panduan Operasional & API Reference](#9-panduan-operasional--api-reference)
10. [Troubleshooting & Catatan Arsitektur Developer](#10-troubleshooting--catatan-arsitektur-developer)

---

## 1. LATAR BELAKANG & KONSEP BISNIS

Modul **Order Prizes** mengubah pembeli pasif e-commerce menjadi pelanggan setia yang antusias melalui pengalaman interaktif **Wheel of Fortune (Roda Keberuntungan)**.

### Cara Kerja Sederhana:
1. Pembeli memesan barang di toko seller (misal via TikTok Shop atau Shopee).
2. Di dalam paket pengiriman atau via chat broadcast, pembeli menerima link undian:  
   `https://vendio.id/order_prizes?campaign=promo-oktober`
3. Pembeli memasukkan **Nomor Pesanan** dan **Nomor WhatsApp**.
4. Sistem memverifikasi keabsahan pesanan, status pesanan (*Completed/Paid*), dan sisa batas hari klaim.
5. Pembeli memutar roda undian, memenangkan hadiah, dan hadiah **langsung otomatis ter-klaim** ke sistem seller untuk diproses pengirimannya.

---

## 2. ARSITEKTUR MULTI-TENANT (ISOLASI ANTAR-SELLER)

Vendio digunakan oleh banyak seller e-commerce independen. Modul Order Prizes menerapkan **isolasi data seller secara ketat (Multi-Tenant Autofilter)** di seluruh layer backend:

```
[ Seller Login di Vendio ]
       │
       ├──► Model & Controller Scope: WHERE created_by = $seller_id
       │       ├── Campaigns (Hanya campaign miliknya)
       │       ├── Master Prizes (Hanya hadiah yang dibuatnya)
       │       ├── Connected Shops (Hanya toko TikTok miliknya)
       │       ├── Verified Orders (Hanya pesanan campaign miliknya)
       │       └── Spin History & Fulfillment (Hanya klaim pelanggannya)
       │
[ Superadmin Login ]
       └──► Full Oversight Scope: Dapat melihat & mengelola semua data
```

### Mekanisme Isolasi Data:
1. **Kepemilikan Record (`created_by`)**:
   - Setiap campaign dan master hadiah menyimpan ID seller pembuatnya (`created_by`).
   - Query listing, dropdown, statistik KPI, dan export secara otomatis membatasi data hanya pada `created_by = $userId` (dengan pengecualian untuk Superadmin).
2. **Koneksi Marketplace Terisolasi**:
   - Saat membuat campaign, opsi dropdown **Toko Penjual (TikTok Shop)** hanya menampilkan toko-toko yang terhubung dengan akun Vendio seller tersebut (dicek silang via `tiktok_oauth_states.created_by` dan `tiktok_shops.created_by`).
3. **Pencegahan Akses Ilegal (IDOR Prevention)**:
   - Endpoint edit, hapus, sinkronisasi, import CSV, dan pemenuhan hadiah (*fulfillment*) melakukan validasi kepemilikan. Jika seller mencoba mengedit ID milik seller lain, sistem menolak dengan `HTTP 403 / Error`.
4. **Auto-Migration (`ensure_schema`)**:
   - Skema database melakukan penyesuaian kolom dan indeks `created_by` secara otomatis saat aplikasi berjalan, tanpa memerlukan migrasi terminal manual.

---

## 3. MEKANISME UNDIAN: THRESHOLD PENGAMAN VS BOBOT PELUANG

Sistem undian Vendio memadukan **Gating Margin Finansial (Threshold)** dengan **Pengundian Berbobot Relatif (Weighted Random)** agar seller tidak pernah merugi saat membagikan hadiah mahal.

```
                  ┌──────────────────────────────────────────────┐
                  │          Pesanan Masuk Memutar Roda          │
                  └──────────────────────┬───────────────────────┘
                                         │
                    Apakah Hadiah memenuhi SEMUA Threshold?
                       • Total Omset Campaign >= Threshold Rp
                       • Total Laba Campaign >= Threshold Rp
                       • Total Putaran >= Threshold Spin
                                         │
                   ┌─────────────────────┴─────────────────────┐
                   ▼ (TIDAK)                                   ▼ (YA)
           [ GATING AKTIF ]                            [ MASUK ROSTER UNDIAN ]
         Hadiah TIDAK MASUK                             Bobot Peluang (Weight)
          ke dalam undian!                              dihitung secara relatif:
    (Emas/HP tidak akan keluar)                        P_i = Weight_i / Total_Weight
```

### 1. Threshold Pengaman Finansial (Safety Gating)
Seller dapat mengatur batas keamanan pada setiap hadiah:
- **Threshold Omset (Rp)**: Minimal akumulasi nilai penjualan pesanan pada campaign sebelum hadiah berhak keluar.
- **Threshold Laba (Rp)**: Minimal estimasi laba kotor toko sebelum hadiah bernilai tinggi dilepas.
- **Threshold Minimal Putaran (Spins)**: Minimal banyaknya partisipasi pembeli sebelum hadiah dapat dimenangkan.

> **Contoh Kasus**:  
> Hadiah *Logam Mulia 1 Gram* (Biaya Rp 1.400.000) diberi syarat `Threshold Omset = Rp 15.000.000`.  
> Jika total transaksi pesanan yang masuk baru mencapai Rp 8.000.000, maka Logam Mulia **100% TIDAK BISA KELUAR**, berapapun besarnya nilai Bobot Peluang yang dimasukkan. Toko terbebas dari risiko boncos!

### 2. Bobot Peluang Relatif (Weight)
Setelah hadiah dinyatakan lolos syarat (*eligible*), probabilitas keluarnya dihitung menggunakan bobot relatif terhadap hadiah lain yang juga lolos:

$$\text{Peluang Hadiah } i = \frac{\text{Weight}_i}{\sum_{j \in \text{Eligible}} \text{Weight}_j} \times 100\%$$

*Contoh Konfigurasi Roster:*
| Nama Hadiah | Biaya Toko | Threshold Omset | Weight | Status Omset Rp 5jt | Peluang Nyata |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **Voucher Diskon Rp 10rb** | Rp 0 | Rp 0 | 70 | Lolos | $70 / 95 = 73.7\%$ |
| **Kaos Merchandise** | Rp 35.000 | Rp 2.000.000 | 25 | Lolos | $25 / 95 = 26.3\%$ |
| **Smartwatch** | Rp 350.000 | Rp 10.000.000 | 5 | **Terkunci** | **0% (Threshold belum capai)** |

---

## 4. MASTER HADIAH & RELASI MANY-TO-MANY

1. **Master Hadiah Independen**:
   - Hadiah dibuat sekali di Master Hadiah (`order_prize_items`) dengan jenis fisik, voucher digital, saldo e-wallet, atau zonk (*none*).
   - Form input nominal biaya dan threshold dilengkapi formatting titik ribuan otomatis (*realtime per keystroke*) dengan prepend simbol mata uang `Rp`.
2. **Katalog Terhubung Lintas Campaign (`order_prize_campaign_items`)**:
   - Satu master hadiah dapat didistribusikan ke banyak campaign sekaligus.
   - Seller dapat memilih hadiah mana saja yang aktif di campaign tertentu dengan satu klik tombol centang.

---

## 5. WORKFLOW PELANGGAN: ZERO CLAIM FRICTION (SPIN = CLAIM)

Modul ini mengusung alur **Zero Claim Friction**. Pembeli tidak perlu menekan tombol konfirmasi tambahan setelah memutar roda:

```
[ Buka Link Campaign ] ──► [ Input Order & HP ] ──► [ Putar Roda Hadiah ]
                                                            │
                                                            ▼
                                                   [ OTOMATIS TERCATAT ]
                                                  Status: CLAIMED (Langsung)
                                                            │
                                                            ▼
                                                 [ Masuk Antrean Seller ]
                                                 Toko tinggal kirim hadiah!
```

### Keunggulan:
- **Tingkat Konversi 100%**: Tidak ada hadiah yang hangus sia-sia hanya karena pelanggan lupa mengklik tombol "Klaim Sekarang".
- **Transparansi Hasil**: Algoritma RNG (*Random Number Generation*) dijalankan secara aman di sisi server. Roda grafis di sisi pelanggan berputar sinkron ke sudut segmen hadiah yang telah ditetapkan server.
- **Efek Audio-Visual Premium**: Suara putaran dinamis via Web Audio API, efek kembang api confetti (*particle canvas*), dan animasi kemenangan tanpa beban library eksternal.

---

## 6. BATAS WAKTU PARTISIPASI (CLAIM DAYS WINDOW)

Setiap campaign memiliki pengaturan **Masa Berlaku Klaim (`claim_days`)**, misalnya `7 hari`:
- Sistem menghitung selisih hari antara **Tanggal Selesai Pesanan (`ordered_at`)** dengan **Waktu Pembeli Membuka Undian**.
- Jika pesanan selesai pada tanggal 1 Oktober dan `claim_days = 7`, kesempatan spin berlaku hingga 8 Oktober pukul 23:59.
- Setelah batas hari terlewati, sistem menolak verifikasi dengan notifikasi:  
  *"Batas waktu kesempatan spin untuk pesanan ini telah berakhir."*

---

## 7. INTEGRASI MARKETPLACE & INPUT PESANAN

Tersedia 3 jalur input data pesanan ke dalam campaign:

### 1. Sinkronisasi Otomatis TikTok Shop
- Tombol **"Sync TikTok Orders"** pada tab Campaign.
- Sistem menarik pesanan dengan status `COMPLETED`, `DELIVERED`, atau `SHIPPED` yang berasal dari toko TikTok milik seller dalam rentang periode campaign.
- Nomor handphone dan nomor pesanan dienkripsi dan dipetakan secara otomatis.

### 2. Import Massal via CSV
- Cocok untuk Shopee, Tokopedia, Lazada, atau toko offline.
- File CSV template disediakan di dashboard: `template_order_prizes.csv`.
- Format kolom:
  ```csv
  order_number,phone,status,revenue,profit,ordered_at
  261014ABC123,081234567890,completed,150000,35000,2026-10-15 10:00:00
  ```

### 3. Input Manual Pesanan
- Formulir tambah pesanan terverifikasi langsung dari backend dengan formatting ribuan realtime.

---

## 8. STRUKTUR DATABASE & SKEMA TABEL

```
order_prize_campaigns (Campaign Promosi)
  ├── id (PK)
  ├── created_by (FK User / Seller)
  ├── name, slug, channel, shop_ref
  ├── starts_at, ends_at, claim_days, status
  └── terms

order_prize_items (Master Hadiah)
  ├── id (PK)
  ├── created_by (FK User / Seller)
  ├── name, kind, cost, stock, weight
  └── threshold_revenue, threshold_profit, threshold_spins

order_prize_campaign_items (Pivot Hadiah <-> Campaign)
  ├── campaign_id (FK)
  └── prize_id (FK)

order_prize_orders (Pesanan Berhak Undian)
  ├── id (PK)
  ├── campaign_id (FK)
  ├── order_number, phone, status
  └── revenue, profit, ordered_at

order_prize_spins (Hasil Putaran & Pemenuhan)
  ├── id (PK)
  ├── campaign_id, order_id, prize_id
  ├── claim_status (claimed, expired, rejected, not_required)
  ├── prize_status (reserved, processing, sent, delivered, void)
  └── tracking_number, courier, claimed_at

order_prize_audits (Audit Log Mutasi & Aktivitas)
  ├── id (PK)
  ├── user_id, action, entity, entity_id, payload
  └── created_at
```

---

## 9. PANDUAN OPERASIONAL & API REFERENCE

### Akses Admin & Seller
- **Daftar Campaign & Undian**: `/admin/order_prizes`
- **Tab Hadiah & Threshold**: `/admin/order_prizes/tab/prizes`
- **Tab Pesanan Terverifikasi**: `/admin/order_prizes/tab/orders`
- **Tab Riwayat Spin & Fulfillment**: `/admin/order_prizes/tab/spins`
- **Tab Audit Trail**: `/admin/order_prizes/tab/audit`

### Akses Pelanggan (Public)
- **Halaman Roda Undian**:  
  `/order_prizes?campaign={slug-campaign}`  
  *(Contoh: `/order_prizes?campaign=promo-tiktok-oktober`)*

### Endpoint API Public
| Endpoint | Method | Parameter | Keterangan |
| :--- | :---: | :--- | :--- |
| `/order_prizes/campaign` | GET | `slug` | Mengambil info publik campaign & daftar segmen hadiah |
| `/order_prizes/verify` | POST | `slug`, `order_number`, `phone`, `accept_terms`, `marketing_consent` | Verifikasi hak putar pesanan |
| `/order_prizes/spin` | POST | `token` | Memutar roda & mencatat hadiah di server |
| `/order_prizes/result` | POST | `token` | Mengambil detail hasil hadiah tersimpan |

---

## 10. TROUBLESHOOTING & CATATAN ARSITEKTUR DEVELOPER

Bagian ini wajib dibaca oleh semua developer dan kolaborator sebelum memodifikasi query database, helper multi-tenancy, atau routing admin.

### A. Isolasi Active Record / Query Builder (Aturan Mutlak)
* **Masalah Masa Lalu**: CodeIgniter menggunakan instance database singleton (`$this->db`). Ketika sebuah model sedang menyusun query (misal `join_avaiable()` memanggil `$this->db->select('tiktok_shops.*')`) lalu memanggil helper `get_active_tenant_id()` yang di dalamnya menggunakan `$ci->db->select()->get_where()`, Active Record CodeIgniter akan mencampurkan klausa SELECT tersebut ke dalam query `aauth_users`. Hal ini menyebabkan MySQL melempar error:
  `Error 1051: Unknown table 'vendio.tiktok_shops' in query SELECT tiktok_shops.*, tenant_id FROM aauth_users`.
* **Solusi Baku**:
  Di seluruh helper (`tenant_helper.php`, dll), **DILARANG KERAS** menggunakan Query Builder (`select()`, `where()`, `get_where()`). Wajib menggunakan raw query terisolasi dengan parameterized binding:
  ```php
  // BENAR: Terisolasi 100%, tidak mencemari Active Record yang sedang berjalan
  $query = $ci->db->query("SELECT `tenant_id` FROM `aauth_users` WHERE `id` = ? LIMIT 1", [(int) $user_id]);
  ```

---

### B. SaaS Multi-Tenancy & Error `1054 Unknown column 'tenant_id'`
* **Mengapa Terjadi**:
  Model marketplace seperti `Model_tiktok_orders`, `Model_tiktok_products`, `Model_tiktok_shops`, dll memiliki method `filter_avaiable()` yang memfilter berdasarkan `tenant_id`. Namun, pada database lokal developer yang berasal dari dump versi lama, kolom `tenant_id` belum ada di tabel tersebut.
* **Aturan Implementasi**:
  Semua model yang menambahkan filter `tenant_id` **WAJIB** mengecek keberadaan kolom terlebih dahulu menggunakan `field_exists`:
  ```php
  // Pola yang benar di setiap Model:
  public function filter_avaiable() {
      if (function_exists('get_active_tenant_id')) {
          if ($this->db->field_exists('tenant_id', $this->table_name)) {
              $this->db->where($this->table_name . '.tenant_id', get_active_tenant_id());
          }
      }
      return $this;
  }
  ```
* **Self-Healing Migration**:
  Fungsi `ensure_multi_tenancy_schema()` di `tenant_helper.php` secara otomatis mendeteksi dan membuat tabel `tenants` & `plans` serta menambahkan kolom `tenant_id` ke tabel `aauth_users`, `tiktok_orders`, dan `tiktok_shops` jika belum ada di database lokal Anda.

---

### C. Typo Routing Global 4-Parameter di `routes.php`
* **Masalah Masa Lalu**:
  Di file `application/config/routes.php`, rule generic 4 parameter bawaan framework:
  `$route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)/(:any)/(:any)'] = '$1/backend/$1/$2/$3/$3';`
  memiliki typo di mana parameter ke-4 diduplikasi dari `$3` (alih-alih `$4`).
* **Dampak**:
  Setiap pemanggilan URL 4 parameter seperti `/delete/prizes/5` menyebabkan parameter kedua (`$id`) bernilai string `'prizes'` sehingga memicu validasi error:
  `"ID harus bilangan bulat 1–4294967295."`
* **Solusi Baku**:
  1. Typo pada `routes.php` telah diperbaiki menjadi `$1/backend/$1/$2/$3/$4`.
  2. Route eksplisit telah didaftarkan:
     `$route[ADMIN_NAMESPACE_URL.'/order_prizes/delete/(:any)/(:num)'] = 'order_prizes/backend/order_prizes/delete/$1/$2';`
  3. Controller `Order_prizes::delete` juga dilengkapi fallback membaca `$_POST['id']`.

---

### D. Fitur Seeding 10 Hadiah Sample
* Jika tabel `order_prize_items` kosong (atau hanya berisi zonk/fallback), sistem otomatis mengeksekusi `seed_default_prizes()` saat membuka halaman admin.
* Developer juga dapat melakukan re-seed sewaktu-waktu dengan menekan tombol **`⚡ Seed 10 Hadiah Sample`** di Tab Hadiah & Threshold atau melalui AJAX endpoint `POST /order_prizes/seed_prizes`.

---
*Dikembangkan dengan standar arsitektur aman, efisien, dan siap pakai untuk pertumbuhan omset seller Vendio.*
