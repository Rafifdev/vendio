# 🚀 Daftar Sesi & Roadmap Implementasi Integrasi TikTok Shop
**Berdasarkan PRD:** [`PRD_Integrasi_TikTok_Shop.md`](./PRD_Integrasi_TikTok_Shop.md)  
**Platform:** CodeIgniter 3 + Cicool Builder (HMVC)  
**Status Tracker:** Sesi 1 s/d Sesi 8

---

## 📊 Ringkasan Status Progres

| Sesi | Topik Utama | Target Modul / Komponen | Status |
|:---:|---|---|:---:|
| **Sesi 1** | Fondasi Database & API Client Logging | Migration DB, `Tiktok_api.php`, `tiktok_api_logs` | ✅ Selesai |
| **Sesi 2** | Master Data Logistik (Gudang, Kategori, Brand) | `tiktok_warehouses`, `tiktok_categories`, `tiktok_brands` | ⏳ Siap Dikerjakan |
| **Sesi 3** | Penyempurnaan Siklus Hidup Produk (Product Lifecycle) | `tiktok_products`, `tiktok_product_skus`, sync logs | ⏸️ Menunggu |
| **Sesi 4** | Standardisasi Order & Rincian Harga (Price Detail) | `tiktok_orders`, `tiktok_order_price_details`, status logs | ⏸️ Menunggu |
| **Sesi 5** | Manajemen Fulfillment & Paket (Packages) | `tiktok_packages`, label AWB PDF, tracking kurir | ⏸️ Menunggu |
| **Sesi 6** | Retur, Komplain & Pembatalan Resmi | `tiktok_returns`, `tiktok_cancellations`, SLA 48 jam | ⏸️ Menunggu |
| **Sesi 7** | Modul Keuangan & Rekonsiliasi (Finance) | `tiktok_statements`, `tiktok_withdrawals`, unsettled | ⏸️ Menunggu |
| **Sesi 8** | Otomatisasi & Penjadwalan Terpadu (Cron Job) | CLI Runner, Task Scheduler Windows / Linux Crontab | ⏸️ Menunggu |

---

## 📌 Rincian Task per Sesi

---

### 🔹 Sesi 1: Fondasi Database & API Client Logging
> **Tujuan:** Menyiapkan struktur tabel database pelengkap sesuai Bab 7 PRD dan memastikan seluruh aktivitas request/response ke API TikTok tercatat otomatis untuk audit trail.

- [x] **Task 1.1: Eksekusi DDL Migration Database**
  - Membuat tabel `tiktok_api_logs` (pencatatan payload, HTTP status, execution time).
  - Membuat tabel `tiktok_warehouses`, `tiktok_delivery_options`, `tiktok_shipping_providers`.
  - Membuat tabel `tiktok_categories`, `tiktok_category_attributes`, `tiktok_brands`.
  - Membuat tabel `tiktok_reject_reasons`.
- [x] **Task 1.2: Upgrade Library `Tiktok_api.php`**
  - Pasang auto-logging ke tabel `tiktok_api_logs` pada setiap pemanggilan method `request()`.
  - Simpan durasi eksekusi request (benchmark time) dan status error response.
- [x] **Task 1.3: Uji Coba Logging**
  - Verifikasi data log tersimpan di database saat request dijalankan.

---

### 🔹 Sesi 2: Master Data Logistik & Katalog (Gudang, Kategori, Brand)
> **Tujuan:** Menarik data gudang toko dan memetakannya ke cabang fisik ERP, serta mencache data pohon kategori & brand TikTok Shop.

- [ ] **Task 2.1: Modul & Penarikan Gudang (Warehouse)**
  - Sinkronisasi daftar gudang dari TikTok (`Get Warehouse List`).
  - Ambil opsi pengiriman gudang (`Get Warehouse Delivery Options`) dan kurir (`Get Shipping Providers`).
  - Fitur pemetaan (mapping) 1 warehouse TikTok ke cabang fisik di ERP.
- [ ] **Task 2.2: Modul & Cache Kategori & Atribut**
  - Penarikan kategori pohon/hierarki TikTok (`Get Categories`) sampai level leaf.
  - Penarikan atribut wajib per kategori (`Get Categories Attributes`).
- [ ] **Task 2.3: Modul & Penarikan Brand**
  - Penarikan daftar brand terautorisasi (`Get Brands`).

---

### 🔹 Sesi 3: Penyempurnaan Modul Produk (Product Lifecycle & Status Resmi)
> **Tujuan:** Menyelaraskan status produk dan aksi seller dengan Seller Center resmi TikTok Shop.

- [ ] **Task 3.1: Standardisasi Status Produk Resmi**
  - Menerapkan status: `DRAFT`, `PENDING`, `ACTIVATE`, `FAILED`, `DEACTIVATED`, `FREEZE`, `DELETED`.
  - Badge warna resmi di tabel list dan halaman detail produk.
- [ ] **Task 3.2: Tombol Aksi Kontekstual**
  - Tombol Aktifkan (hanya muncul jika status `DEACTIVATED` dan stok > 0).
  - Tombol Nonaktifkan (hanya muncul jika status `ACTIVATE`).
  - Tombol Hapus (hanya jika bukan `FREEZE`).
- [ ] **Task 3.3: Penanganan Produk Gagal Review (`FAILED`)**
  - Menampilkan alasan penolakan (`reject_reason`) di halaman view produk.
- [ ] **Task 3.4: Audit Trail Log Perubahan Produk**
  - Pencatatan aksi create, edit, aktifkan, stok, harga ke `tiktok_product_sync_logs`.

---

### 🔹 Sesi 4: Standardisasi Order & Rincian Harga (Price Detail Breakdown)
> **Tujuan:** Menampilkan status alur order resmi dan rincian harga lengkap dari TikTok Shop tanpa kalkulasi manual.

- [ ] **Task 4.1: Standardisasi Status Order Resmi**
  - Status resmi: `UNPAID`, `ON_HOLD`, `AWAITING_SHIPMENT`, `AWAITING_COLLECTION`, `PARTIALLY_SHIPPING`, `IN_TRANSIT`, `DELIVERED`, `COMPLETED`, `CANCELLED`.
  - Keterangan & badge warna sesuai panduan Seller Center.
- [ ] **Task 4.2: Rincian Harga Lengkap (`order_price_details`)**
  - Integrasi API `Price Detail` ke sub-tabel di halaman view order.
  - Rincian: Subtotal, Ongkir Buyer, Subsidi Ongkir Platform, Diskon Seller, Diskon Platform, Pajak, Total Diterima Seller.
- [ ] **Task 4.3: Riwayat Perubahan Status Order**
  - Pencatatan perubahan status ke `tiktok_order_status_logs` (timeline riwayat di view order).

---

### 🔹 Sesi 5: Manajemen Fulfillment & Paket (Packages Management)
> **Tujuan:** Memproses pengiriman pesanan mengikuti alur gudang resmi TikTok Shop (paket, cetak label AWB, dan pelacakan kurir).

- [ ] **Task 5.1: Skema & Modul Paket (`tiktok_packages`)**
  - Pembuatan tabel `tiktok_packages`, `tiktok_package_items`, `tiktok_shipping_documents`.
  - Penarikan dan pembentukan paket dari order berstatus `AWAITING_SHIPMENT`.
- [ ] **Task 5.2: Dokumen Pengiriman & Label Resi (AWB PDF)**
  - Cetak label pengiriman ukuran A6 PDF resmi dari endpoint `Package Shipping Document`.
- [ ] **Task 5.3: Alur Ship & Serah Terima Kurir**
  - Aksi `Confirm Package Shipment` dan `Ship Package` (mengubah status paket ke `AWAITING_COLLECTION`).
- [ ] **Task 5.4: Pelacakan Pengiriman (Tracking Kurir)**
  - Integrasi endpoint `Tracking Order` untuk menampilkan riwayat checkpoint scan kurir di halaman paket.

---

### 🔹 Sesi 6: Retur, Komplain & Pembatalan Resmi
> **Tujuan:** Mengelola komplain pembeli, menjaga SLA respon 48 jam, dan pembatalan pesanan terstruktur.

- [ ] **Task 6.1: Master Alasan Penolakan (`tiktok_reject_reasons`)**
  - Sinkronisasi daftar alasan penolakan resmi dari endpoint `Get Reject Reasons`.
- [ ] **Task 6.2: Indikator SLA 48 Jam & Aksi Retur**
  - Tampilan batas waktu respon mundur (countdown SLA 48 jam) dengan highlight warna merah jika sisa waktu < 6 jam.
  - Aksi Setujui / Tolak dengan modal pilihan alasan penolakan resmi.
- [ ] **Task 6.3: Modul Pengajuan Pembatalan (`tiktok_cancellations`)**
  - Pembuatan tabel dan modul pembatalan (`tiktok_cancellations` & line items).
  - Alur persetujuan/penolakan pembatalan pesanan.

---

### 🔹 Sesi 7: Modul Keuangan & Rekonsiliasi (Finance)
> **Tujuan:** Monitoring pencairan dana, rekonsiliasi per transaksi, dan pemantauan dana belum settle.

- [ ] **Task 7.1: Statement Keuangan Periodik**
  - Skema dan tampilan rekap pencairan dana (`tiktok_statements`).
  - Rincian transaksi per statement dari `Get Transactions by Statement`.
- [ ] **Task 7.2: Penarikan Dana (Withdrawal)**
  - Tampilan daftar penarikan dana ke rekening bank (`tiktok_withdrawals`).
- [ ] **Task 7.3: Transaksi Belum Settle (Unsettled Transactions)**
  - Halaman pemantauan order yang dananya masih tertahan / belum masuk statement pencairan (`Get Unsettled Transactions`).

---

### 🔹 Sesi 8: Otomatisasi & Penjadwalan Terpadu (Cron Job)
> **Tujuan:** Memastikan sinkronisasi background berjalan tanpa intervensi manual dengan interval optimal.

- [ ] **Task 8.1: Konfigurasi Scheduler Modular**
  - Job `pull_orders`: Setiap 2–5 menit.
  - Job `pull_returns_cancellations`: Setiap 5–10 menit (menjaga SLA 48 jam).
  - Job `pull_packages` & tracking: Setiap 5 menit.
  - Job `refresh_token`: Setiap 12 jam (sebelum token expired).
  - Job `pull_statements`: Harian (rekap settlement baru).
- [ ] **Task 8.2: File Eksekutor Windows & Linux**
  - Script batch Windows (`cron_sync.bat`) untuk Windows Task Scheduler.
  - Command line crontab untuk server Linux.
- [ ] **Task 8.3: Panduan Operasional & Dokumentasi Akhir**
  - Dokumentasi instruksi setup scheduler dan monitoring log sinkronisasi.

---

## 🛠️ Catatan Aturan Pengembangan
1. **Pola Desain:** Menggunakan komponen, form, dan tabel bawaan Cicool standar (`table-bordered`, `form-group`, dll) — tidak membuat styling CSS custom yang berlebihan.
2. **Label Tombol:** Semua tombol aksi sinkronisasi/penarikan data wajib diawali teks **Tarik Data** (kecuali Kelola Toko).
3. **Data Authenticity:** Status yang ditampilkan selalu merujuk pada status resmi TikTok Shop untuk mencegah selisih pemahaman antara admin ERP dan Seller Center.
