# 🚀 Panduan Roadmap Integrasi TikTok Shop API - Vendio

Dokumen ini merupakan panduan langkah demi langkah (*step-by-step roadmap*) setelah pembuatan modul CRUD **`tiktok_shops`**, mencakup integrasi token, pembagian tugas 3 orang tim developer, hingga otomatisasi sistem.

---

## 📌 Status Terkini (Fondasi Siap)
- [x] Database `vendio` aktif dan tabel `tiktok_shops` telah dibuat.
- [x] Central API Client Library [application/libraries/Tiktok_api.php](file:///c:/xampp/htdocs/vendio/application/libraries/Tiktok_api.php) sudah siap.
- [x] Config [application/config/tiktok.php](file:///c:/xampp/htdocs/vendio/application/config/tiktok.php) sudah tersedia.
- [x] Modul CRUD & Menu **TikTok Shops** sudah selesai di-generate via Cicool CRUD Builder.

---

## 🗺️ Tahapan Langkah Selanjutnya (Step-by-Step)

```
[Tahap 1] Testing & Otorisasi Toko Pertama (Ambil Token & Cipher)
    ↓
[Tahap 2] Tambah Tombol Aksi di Modul Toko (Sync Cipher & Refresh Token)
    ↓
[Tahap 3] Commit & Push ke GitHub untuk Dibagikan ke Tim
    ↓
[Tahap 4] Eksekusi Pengembangan Paralel (Dev 1, Dev 2, Dev 3)
    ↓
[Tahap 5] Otomatisasi Sinkronisasi & Cron Job
```

---

### Tahap 1: Menghubungkan Toko TikTok (Mendapatkan `shop_cipher` & Token)

Semua endpoint operasional TikTok Shop (Produk, Pesanan, Keuangan) **wajib menyertakan `shop_cipher`** dan **`access_token`**. Ada dua cara untuk menambahkan toko:

#### Cara A: Menggunakan Tombol "Hubungkan Akun TikTok" (Otomatis & Direkomendasikan)
1. Buka menu **Kelola Toko** di admin panel Vendio.
2. Klik tombol hijau **"Hubungkan Akun TikTok"** (akan membuka tab baru ke halaman otorisasi TikTok Shop).
3. Login dan klik **Authorize**.
4. Toko, token, masa berlaku, nama toko, dan `shop_cipher` akan tersimpan otomatis.

#### Cara B: Menambahkan Manual via Tombol "Add Kelola Toko" (Antisipasi)
1. Buka menu **Kelola Toko**, lalu klik tombol **"Add Kelola Toko"** (`administrator/tiktok_shops/add`).
2. Masukkan **Auth Code** (kode dari parameter URL `?code=xxxx` setelah login otorisasi TikTok). Form hanya membutuhkan 1 kolom ini saja (`App Key`, `App Secret`, dan status aktif `1` ditangani otomatis dari `.env`).
3. Klik **Save**.
4. Sistem backend otomatis menukarkan Auth Code ke TikTok Partner API, mengambil `access_token`, `refresh_token`, serta menarik `shop_cipher` dan data toko secara lengkap.

---

### Tahap 2: Menghubungkan Controller Toko dengan Library `Tiktok_api`

Di controller hasil generate CRUD Anda (biasanya `modules/tiktok_shops/controllers/backend/Tiktok_shops.php`), tambahkan fungsi bantuan untuk menukar token atau refresh token otomatis:

```php
// Tambahkan method ini di controller Tiktok_shops.php:
public function sync_token($id)
{
    $this->load->library('tiktok_api');
    $shop = $this->db->get_where('tiktok_shops', ['id' => $id])->row();

    if ($shop && !empty($shop->auth_code)) {
        // 1. Dapatkan Access Token & Refresh Token
        $token_res = $this->tiktok_api->get_access_token($shop->auth_code, $shop->app_key, $shop->app_secret);
        
        if ($token_res['success']) {
            $data = $token_res['data'];
            
            // 2. Ambil Shop Cipher
            $shops_res = $this->tiktok_api->get_authorized_shops($data['access_token'], $shop->app_key, $shop->app_secret);
            $first_shop = $shops_res['data']['shops'][0] ?? [];

            $this->db->where('id', $id)->update('tiktok_shops', [
                'access_token'            => $data['access_token'],
                'access_token_expire_in'  => $data['access_token_expire_in'],
                'refresh_token'           => $data['refresh_token'],
                'refresh_token_expire_in' => $data['refresh_token_expire_in'],
                'shop_id'                 => $first_shop['id'] ?? null,
                'shop_name'               => $first_shop['name'] ?? $data['seller_name'],
                'shop_cipher'             => $first_shop['cipher'] ?? null,
                'seller_base_region'      => $first_shop['region'] ?? 'ID',
            ]);

            set_message('Berhasil mensinkronisasi token dan shop_cipher!');
        } else {
            set_message('Gagal: ' . ($token_res['message'] ?? 'Error'), 'error');
        }
    }
    redirect('administrator/tiktok_shops');
}
```

---

### Tahap 3: Simpan & Push ke GitHub

Simpan semua perkembangan dan bagikan ke repositori GitHub:

```bash
git add .
git commit -m "feat: complete tiktok foundation, library, and shops crud module"
git push origin main
```

---

### Tahap 4: Pembagian Tugas Tim (3 Orang Developer)

Setiap anggota tim melakukan clone/pull dari branch `main` dan membuat branch kerja masing-masing:

```bash
# Developer 1
git checkout -b feat/tiktok-products

# Developer 2
git checkout -b feat/tiktok-orders

# Developer 3
git checkout -b feat/tiktok-finance
```

#### 📦 Developer 1: Modul Produk & Sinkronisasi Stok
* **Tugas**:
  1. Buat controller `modules/tiktok_produk/controllers/backend/Tiktok_produk.php`.
  2. Implementasikan fitur tarik list produk:
     ```php
     $response = $this->tiktok_api->request('/product/202309/products/search', 'POST', [
         'page_size' => 20
     ]);
     ```
  3. Implementasikan fungsi update stok barang ke TikTok:
     ```php
     $update_stock = $this->tiktok_api->request('/product/202309/products/{product_id}/inventory/update', 'POST', [], [
         'skus' => [
             ['id' => $sku_id, 'available_stock' => $stok_baru]
         ]
     ]);
     ```

#### 📑 Developer 2: Modul Pesanan & Pengiriman (Fulfillment)
* **Tugas**:
  1. Buat controller `modules/tiktok_pesanan/controllers/backend/Tiktok_pesanan.php`.
  2. Buat tabel database `tiktok_orders` untuk menampung pesanan lokal.
  3. Tarik pesanan masuk berstatus `AWAITING_SHIPMENT`:
     ```php
     $orders = $this->tiktok_api->request('/order/202309/orders/search', 'POST', [
         'page_size' => 50
     ], [
         'order_status' => 'AWAITING_SHIPMENT'
     ]);
     ```
  4. Fitur proses pengiriman & cetak label resi (AWB PDF):
     ```php
     $shipping_doc = $this->tiktok_api->request('/fulfillment/202309/packages/{package_id}/shipping_documents', 'GET', [
         'document_type' => 'SHIPPING_LABEL'
     ]);
     ```

#### 💰 Developer 3: Modul Keuangan, Retur & Dashboard Analitik
* **Tugas**:
  1. Buat controller `modules/tiktok_finance/controllers/backend/Tiktok_finance.php`.
  2. Tarik rekap pencairan dana (Settlement Statements):
     ```php
     $statements = $this->tiktok_api->request('/finance/202309/statements', 'GET', [
         'page_size' => 20
     ]);
     ```
  3. Tarik data retur/komplain customer:
     ```php
     $returns = $this->tiktok_api->request('/return_refund/202309/returns/search', 'POST', [
         'page_size' => 20
     ]);
     ```
  4. Tampilkan widget ringkasan omzet dan jumlah pesanan di Dashboard utama Vendio.

---

### Tahap 5: Otomatisasi (Cron Job / Auto Sync)

Buat satu controller CLI untuk background cron job di `application/controllers/Cron.php`:

```php
<?php
class Cron extends CI_Controller 
{
    public function sync_all()
    {
        if (!$this->input->is_cli_request()) {
            exit('Akses hanya diperbolehkan via CLI');
        }

        $this->load->library('tiktok_api');
        
        // 1. Auto Refresh Token jika mendekati expired
        // (Otomatis ditangani oleh library Tiktok_api saat memanggil request)

        // 2. Tarik Pesanan Baru Otomatis tiap 15 menit
        // ... panggil logic sync order
    }
}
```

Jalankan di crontab Linux / Task Scheduler Windows:
```bash
# Setiap 15 menit
*/15 * * * * php /xampp/htdocs/vendio/index.php cron sync_all
```

---

### 📚 Referensi API Lengkap
* Dokumentasi API Resmi: [https://idmetafora-tiktok-api.docs.buildwithfern.com](https://idmetafora-tiktok-api.docs.buildwithfern.com)
* Base Client Library: [application/libraries/Tiktok_api.php](file:///c:/xampp/htdocs/vendio/application/libraries/Tiktok_api.php)
