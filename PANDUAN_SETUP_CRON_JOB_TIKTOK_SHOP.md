# 🕒 Panduan Operasional Penjadwalan & Otomatisasi (Cron Job) TikTok Shop Vendio

Dokumen ini memuat panduan lengkap konfigurasi dan operasional otomatisasi background sync integrasi TikTok Shop pada Vendio ERP.

---

## 📌 Daftar Modular Job & Rekomendasi Interval

Sistem cron job telah dirancang modular sehingga setiap jenis data dapat dijalankan dengan interval yang disesuaikan dengan kebutuhan bisnis dan batas kuota rate-limit API TikTok:

| Nama Job | Fungsi | Rekomendasi Interval | Prioritas Bisnis |
| :--- | :--- | :--- | :--- |
| **`pull_orders`** | Menarik pesanan baru (`UNPAID`, `AWAITING_SHIPMENT`, dll) beserta detail item produk pesanan. | **Setiap 2 - 5 menit** | 🔴 Kritis (Pesanan baru masuk) |
| **`pull_packages`** | Menarik paket pengiriman, AWB/nomor resi, status kurir, dan tracking real-time. | **Setiap 5 menit** | 🔴 Kritis (Fulfillment & Resi) |
| **`pull_returns_cancellations`** | Menarik komplain retur, refund, dan pembatalan pesanan dari pembeli. | **Setiap 5 - 10 menit** | 🔴 Kritis (SLA Respon 48 Jam) |
| **`refresh_token`** | Memeriksa sisa masa aktif token seluruh toko & memperbarui token jika sisa < 24 jam. | **Setiap 12 jam** | 🟡 Penting (Cegah Auth Expired) |
| **`pull_statements`** | Menarik rekap keuangan harian: statement saldo, penarikan dana (withdrawals), dan dana tertahan (unsettled). | **1x sehari (misal: 02:00 Pagi)** | 🟢 Rutin Harian |
| **`sync_products`** | Menarik katalog produk aktif, harga, dan stok varian di etalase toko. | **Setiap 1 - 2 jam / Sesuai Kebutuhan** | 🟢 Rutin Katalog |
| **`sync_all`** | Menjalankan seluruh 6 job di atas secara berurutan dalam satu kali eksekusi. | **Fleksibel / Manual / Dev** | ⚪ Maintenance |

---

## 🚀 Pengujian & Eksekusi Manual

### 1. Melalui Command Prompt / Terminal (CLI)
Buka terminal/CMD di folder root Vendio (`c:\xampp\htdocs\vendio`):
```bash
# Menjalankan job tertentu
php cron.php pull_orders
php cron.php pull_packages
php cron.php pull_returns_cancellations
php cron.php refresh_token
php cron.php pull_statements
php cron.php sync_products

# Menjalankan seluruh sinkronisasi sekaligus
php cron.php sync_all
```

Atau menggunakan runner batch Windows:
```cmd
cron_sync.bat pull_orders
cron_sync.bat sync_all
```

### 2. Melalui Browser (Web URL)
Jika tidak memiliki akses terminal (misal shared hosting tanpa CLI):
```
http://localhost/vendio/cron/pull_orders
http://localhost/vendio/cron/pull_packages
http://localhost/vendio/cron/pull_returns_cancellations
http://localhost/vendio/cron/refresh_token
http://localhost/vendio/cron/pull_statements
http://localhost/vendio/cron/sync_products
http://localhost/vendio/cron/sync_all
```

---

## 💻 Panduan Konfigurasi di Windows (Task Scheduler)

Untuk komputer server lokal berbasis Windows atau laptop kasir/admin:

### Langkah-langkah:
1. Tekan tombol **Win + R**, ketik `taskschd.msc`, lalu tekan **Enter**.
2. Di panel kanan, klik **Create Task...** (bukan Create Basic Task).
3. **Tab General:**
   - **Name**: `Vendio - TikTok Shop Sync Orders`
   - Beri centang pada **Run whether user is logged on or not** (atau *Run only when user is logged on* jika testing).
   - Beri centang **Run with highest privileges**.
4. **Tab Triggers:**
   - Klik **New...**
   - **Begin the task**: `On a schedule`
   - Pilih `Daily`, lalu pada bagian **Advanced settings**, centang **Repeat task every**: `5 minutes` for a duration of: `Indefinitely`.
   - Klik **OK**.
5. **Tab Actions:**
   - Klik **New...**
   - **Action**: `Start a program`
   - **Program/script**: `C:\xampp\htdocs\vendio\cron_sync.bat`
   - **Add arguments (optional)**: `pull_orders`
   - **Start in (optional)**: `C:\xampp\htdocs\vendio` *(Sangat penting diisi!)*
   - Klik **OK**.
6. **Tab Settings:**
   - Centang **Allow task to be run on demand**.
   - Centang **Stop the task if it runs longer than**: `10 minutes`.
   - Klik **OK** untuk menyimpan task.

> 💡 **Rekomendasi Pembuatan Task di Windows:**
> Ulangi langkah di atas untuk membuat task terjadwal terpisah:
> - `Vendio - TikTok Shop Orders` ➔ Arguments: `pull_orders` (Trigger: tiap 3 menit)
> - `Vendio - TikTok Shop Packages` ➔ Arguments: `pull_packages` (Trigger: tiap 5 menit)
> - `Vendio - TikTok Shop Returns` ➔ Arguments: `pull_returns_cancellations` (Trigger: tiap 10 menit)
> - `Vendio - TikTok Shop Token` ➔ Arguments: `refresh_token` (Trigger: tiap 12 jam)
> - `Vendio - TikTok Shop Finance` ➔ Arguments: `pull_statements` (Trigger: harian jam 02:00)

---

## 🐧 Panduan Konfigurasi di Linux (Crontab)

Untuk server VPS / Cloud berbasis Linux (Ubuntu, Debian, AlmaLinux, CentOS):

1. Buka konfigurasi crontab user web server:
   ```bash
   crontab -e
   ```
2. Salin isi dari template [`crontab.txt`](crontab.txt) ke dalam editor crontab:
   ```cron
   # ============================================================================
   # Vendio - TikTok Shop Background Sync Crontab Schedules
   # ============================================================================

   # 1. Tarik Pesanan Baru & Detail Items (Tiap 3 Menit)
   */3 * * * * /usr/bin/php /var/www/html/vendio/cron.php pull_orders > /dev/null 2>&1

   # 2. Tarik Paket Pengiriman & Resi Kurir (Tiap 5 Menit)
   */5 * * * * /usr/bin/php /var/www/html/vendio/cron.php pull_packages > /dev/null 2>&1

   # 3. Tarik Retur, Refund & Pembatalan Pesanan - SLA 48 Jam (Tiap 10 Menit)
   */10 * * * * /usr/bin/php /var/www/html/vendio/cron.php pull_returns_cancellations > /dev/null 2>&1

   # 4. Refresh Token Toko Sebelum Kadaluarsa (Tiap 12 Jam pada Menit ke-0)
   0 */12 * * * /usr/bin/php /var/www/html/vendio/cron.php refresh_token > /dev/null 2>&1

   # 5. Tarik Rekap Keuangan & Settlement Harian (Setiap Hari Pukul 02:00 Pagi)
   0 2 * * * /usr/bin/php /var/www/html/vendio/cron.php pull_statements > /dev/null 2>&1

   # 6. Tarik Katalog Produk & Sinkronisasi Varian (Tiap Jam pada Menit ke-15)
   15 * * * * /usr/bin/php /var/www/html/vendio/cron.php sync_products > /dev/null 2>&1
   ```
3. Simpan dan keluar dari editor (`Ctrl + O`, `Ctrl + X` pada nano).

---

## 📊 Monitoring & File Log

Setiap kali job scheduler dijalankan, sistem secara otomatis:
1. Menampilkan progress real-time ke terminal/output console.
2. Menyimpan log terstruktur dengan timestamp ke file log harian:
   ```
   application/logs/cron_YYYY-MM-DD.log
   ```
   *(Contoh: `application/logs/cron_2026-09-27.log`)*

### Memeriksa Log di Terminal:
- **Windows (PowerShell):**
  ```powershell
  Get-Content -Tail 50 -Wait .\application\logs\cron_2026-09-27.log
  ```
- **Linux:**
  ```bash
  tail -f /var/www/html/vendio/application/logs/cron_$(date +%Y-%m-%d).log
  ```

---

## 🛡️ Pencegahan Error & Keandalan Sistem

1. **Auto Refresh Token:**
   - Token TikTok Shop berlaku selama 7 hari, dan refresh token berlaku 365 hari.
   - Job `refresh_token` secara proaktif mendeteksi token yang mendekati kadaluarsa (< 24 jam) dan langsung memperbaruinya ke TikTok API, sehingga toko tidak akan pernah terputus otorisasi.
2. **Memory Limit & Timeout Safeguard:**
   - Setiap job telah dikonfigurasi dengan `memory_limit = 512M` dan `set_time_limit = 600` (10 menit) untuk mencegah skrip terhenti di tengah jalan saat memproses ribuan data.
3. **Database Integrity & Idempotency:**
   - Semua operasi database menggunakan pola *check-and-update* (idempotent), sehingga jika job dijalankan ulang berkali-kali tidak akan menimbulkan duplikasi record pada data pesanan, paket, retur, ataupun transaksi keuangan.
