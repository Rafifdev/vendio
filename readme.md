# 🚀 Vendio Omnichannel Platform

Aplikasi omnichannel e-commerce management (TikTok Shop, Shopee, Tokopedia, Lazada, dll) berbasis **CodeIgniter 3 HMVC**, **PHP**, dan **MySQL**, dilengkapi dengan **SaaS Multi-Tenancy** dan **Order Loyalty Engine (Vendio Rewards / Spin Wheel)**.

---

## 📌 Daftar Isi
1. [Akses & Kredensial Default](#-akses--kredensial-default)
2. [Instalasi & Menjalankan Lokal (Quick Start)](#-instalasi--menjalankan-lokal-quick-start)
3. [Modul Order Prizes (Vendio Rewards)](#-modul-order-prizes-vendio-rewards)
4. [Arsitektur Multi-Tenancy & Database](#-arsitektur-multi-tenancy--database)
5. [Troubleshooting & Developer Caveats (WAJIB DIBACA)](#-troubleshooting--developer-caveats-wajib-dibaca)
6. [Git Workflow (Dual-Remote Setup)](#-git-workflow-dual-remote-setup)

---

## 🔑 Akses & Kredensial Default

Setelah server lokal berjalan, buka browser ke:
- **URL Login Admin**: [http://localhost:8000/administrator/login](http://localhost:8000/administrator/login)
- **Email**: `developer@gmail.com`
- **Password**: `developer`

> Akun di atas memiliki hak akses Superadmin (`group_id = 1`) yang dapat mengakses semua menu, modul multi-tenant, dan sistem konfigurasi.

---

## 💻 Instalasi & Menjalankan Lokal (Quick Start)

### 1. Kebutuhan Sistem
- **PHP**: Versi 7.4 s/d 8.1 dengan ekstensi `mysqli`, `pdo_mysql`, `curl`, `mbstring`, `json`, `gd`, `zip`.
- **Database**: MySQL 5.7+ atau MariaDB 10.3+.
- **Web Server**: Apache/Nginx atau PHP Built-in Server.

### 2. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env` di root direktori jika belum ada:
```ini
ENVIRONMENT=development
BASE_URL=http://localhost:8000/
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=vendio
```

### 3. Setup Database & Migrasi
1. Buat database baru bernama `vendio` di MySQL/MariaDB:
   ```sql
   CREATE DATABASE vendio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Import file SQL base:
   - Import `vendio.sql` (atau `ci3.sql`) ke database `vendio`.
3. Jalankan migrasi modul **Order Prizes**:
   - Jalankan query dari file `database/create_order_prizes.sql` untuk membuat tabel-tabel reward loyalty dan mendaftarkan menu/permission admin.

### 4. Menjalankan Server Lokal
Jalankan server PHP built-in langsung dari root project:
```bash
php -S localhost:8000 router.php
```
Buka browser di `http://localhost:8000/administrator/login`.

---

## 🎁 Modul Order Prizes (Vendio Rewards)

Modul **Order Prizes** adalah gamifikasi loyalty konsumen e-commerce (Spin Wheel / Lucky Draw) yang terintegrasi dengan pesanan marketplace.

- **Akses Admin**: Buka menu sidebar **Order Prizes** (`/administrator/order_prizes`).
- **Halaman Konsumen**: Buka `/spinwheel` untuk tampilan putaran roda hadiah pelanggan.
- **Dokumentasi Lengkap**: Baca panduan teknis mendalam di **[README_ORDER_PRIZES.md](README_ORDER_PRIZES.md)**.

### ⚡ Fitur Cepat: Seeding 10 Hadiah Sample
Jika baru pertama kali menjalankan modul dan tabel hadiah masih kosong:
1. Buka halaman admin **Order Prizes** (`/administrator/order_prizes`).
2. Masuk ke tab **Daftar Hadiah**.
3. Klik tombol hijau **`⚡ Seed 10 Hadiah Sample`** di sudut kanan atas atau di dalam tabel kosong.
4. Atau buka langsung via URL: `http://localhost:8000/administrator/order_prizes/seed_prizes`.
5. Sistem akan otomatis mengisi 10 item hadiah e-commerce realistis (Grand Prize, Gadget, Voucher Diskon, Merchandise, s/d Zonk) lengkap dengan setting bobot peluang dan threshold finansial.

---

## 🏢 Arsitektur Multi-Tenancy & Database

Aplikasi Vendio dirancang mendukung multi-tenancy SaaS:
- Tabel utama: `tenants`, `plans`, dan kolom `tenant_id` pada tabel data pengguna (`aauth_users`), pesanan (`tiktok_orders`), toko (`tiktok_shops`), produk, dll.
- **Helper Global**: `application/helpers/tenant_helper.php` menyediakan fungsi:
  - `get_active_tenant_id()`: Mengambil ID tenant aktif dari session / user profile.
  - `get_active_tenant()`: Mengambil data tenant beserta batasan paket (`max_shops`, `max_users`, `max_warehouses`).
  - `tenant_quota_check($feature)`: Validasi kuota tenant sebelum membuat resource baru.

---

## ⚠️ Troubleshooting & Developer Caveats (WAJIB DIBACA)

Bagian ini mendokumentasikan bug-bug krusial yang pernah terjadi beserta solusinya agar developer tidak mengulang kesalahan yang sama:

### 1. Error 1051: Unknown table 'vendio.tiktok_shops' (Query Builder Contamination)
- **Gejala**:
  ```text
  Error Number: 1051
  Unknown table 'vendio.tiktok_shops'
  SELECT `tiktok_shops`.*, `tenant_id` FROM `aauth_users` WHERE `id` = '22'
  ```
- **Penyebab**:
  Di CodeIgniter 3, objek `$this->db` adalah **singleton global**. Jika helper (seperti `tenant_helper.php`) dipanggil dari dalam layout/view sementara sebuah model (misalnya `Model_tiktok_orders` di method `join_avaiable()`) sedang membangun query dan belum melakukan `$this->db->get()`, pemanggilan `$ci->db->select(...)` di helper akan mengontaminasi (bleeding) query builder yang sedang aktif. Hasilnya, klausul `SELECT tiktok_shops.*` ikut terbawa ke query user!
- **Aturan Developer**:
  > ❌ **JANGAN PERNAH** menggunakan Query Builder active record (`$ci->db->select()`, `$ci->db->get()`, `$ci->db->where()`) di dalam file helper global atau layout view.
  >
  > ✅ **SELALU GUNAKAN** raw query terisolasi dengan parameter binding:
  > ```php
  > $query = $ci->db->query("SELECT tenant_id FROM aauth_users WHERE id = ? LIMIT 1", [(int)$userId]);
  > ```

---

### 2. Error 1054: Unknown column 'tiktok_orders.tenant_id' in 'where clause'
- **Gejala**:
  ```text
  Error Number: 1054
  Unknown column 'tenant_id' in 'where clause' / 'field list'
  - SELECT `tiktok_orders`.* WHERE `tiktok_orders`.`tenant_id` = 1 ...
  - UPDATE `tiktok_order_price_details` SET `tenant_id` = '1' ...
  ```
- **Penyebab**:
  Database lokal pengembang merupakan database lama yang belum memiliki kolom `tenant_id` di tabel utama maupun tabel relasi/rincian (`tiktok_orders`, `tiktok_order_items`, `tiktok_order_price_details`, `tiktok_order_status_logs`, `tiktok_product_skus`, dll). Ketika sinkronisasi TikTok API atau query model dijalankan, database menolak kolom `tenant_id`.
- **Solusi Arsitektur (Dua Lapis Pengaman)**:
  1. **Self-Healing Otomatis**: Fungsi `ensure_multi_tenancy_schema()` di `tenant_helper.php` secara otomatis mendeteksi seluruh tabel yang belum memiliki kolom `tenant_id` dan mengeksekusi `ALTER TABLE ... ADD COLUMN tenant_id` secara idempotent saat aplikasi diakses.
  2. **Field-Exists Guarding**: Controller sinkronisasi (`Tiktok_orders.php`, `Tiktok_products.php`) dan Model core selalu mengecek `$this->db->field_exists('tenant_id', ...)` sebelum menambahkan filter `WHERE` atau menyertakan field `tenant_id` pada payload `INSERT`/`UPDATE`.

---

### 3. Error 1146: Table 'vendio.tenants' doesn't exist
- **Gejala**:
  ```text
  Error Number: 1146
  Table 'vendio.tenants' doesn't exist
  ```
- **Penyebab**:
  Database lokal belum mengeksekusi skema multi-tenancy.
- **Solusi**:
  File `application/helpers/tenant_helper.php` telah dilengkapi fungsi `ensure_multi_tenancy_schema()` yang otomatis membuat tabel minimal `plans` dan `tenants` serta record default jika tabel belum tersedia. Namun pastikan database Anda sudah disinkronkan dengan `vendio.sql`.

---

### 4. Bug Hapus Data: "ID harus bilangan bulat 1–4294967295"
- **Gejala**:
  Gagal menghapus campaign/hadiah di Order Prizes dan muncul pesan validasi ID bukan integer.
- **Penyebab**:
  Terdapat **typo routing bawaan CiCOOL** pada file `application/config/routes.php`:
  ```php
  // SEBELUM (SALAH - Parameter ke-4 menduplikasi $3):
  $route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)/(:any)/(:any)'] = '$1/backend/$1/$2/$3/$3';

  // SESUDAH (BENAR):
  $route[ADMIN_NAMESPACE_URL.'/(:any)/(:any)/(:any)/(:any)'] = '$1/backend/$1/$2/$3/$4';
  ```
  Typo ini menyebabkan method `delete($entity, $id)` menerima argumen `$entity` dua kali (misal: `delete('prize', 'prize')`), sehingga parameter `$id` bernilai string dan memicu validasi error.
  Perbaikan telah diterapkan baik di routing umum maupun route eksplisit modul `order_prizes`.

---

## 🔀 Git Workflow (Dual-Remote Setup)

Repositori ini menggunakan konfigurasi dual-remote (Fork/Upstream pattern):

- **`origin`**: `https://github.com/maszaen/vendio_omnichannel.git`
  - Repo personal milik Mas Zaen untuk staging, backup, dan testing.
- **`upstream`**: `https://github.com/Rafifdev/vendio.git`
  - Repo utama kolaborasi tim.

### Sinkronisasi dengan Upstream (Pekerjaan Teman)
```bash
git fetch upstream
git pull upstream develop
```

### Push ke Personal Repo (Origin)
```bash
git push origin <nama-branch>
```

---

*Dokumentasi ini dirawat bersama oleh tim pengembang Vendio. Jika menemukan error atau perubahan arsitektur, harap perbarui README ini.*
