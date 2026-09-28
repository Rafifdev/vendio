# 🎨 Cicool UI/UX Standards & Invariants

## Prinsip Utama
1. **Gunakan 100% Template Bawaan Cicool**:
   - Selalu pertahankan struktur view hasil generate dari Cicool CRUD Builder.
   - Jangan pernah merombak layout utama atau menghapus container standar Cicool (`box`, `box-warning`, `box-header`, `box-body`, `widget-user-2`).

2. **Dilarang Membuat UI/UX Sendiri**:
   - **TIDAK BOLEH** menulis custom CSS styling inline atau membuat file CSS eksternal baru untuk mengubah tampilan standar Cicool.
   - **TIDAK BOLEH** mengganti tabel standar dengan card layout modern atau komponen non-AdminLTE.

3. **Komponen & Class yang Diizinkan**:
   - **Tabel List**: Wajib class `table table-bordered table-striped dataTable`.
   - **Tombol**: Wajib class `btn btn-flat` dengan varian AdminLTE (`btn-info`, `btn-success`, `btn-danger`, `btn-default`).
   - **Posisi Tombol Tambahan**: Letakkan di header baris `pull-right` sejajar dengan tombol Export/Add bawaan Cicool.
   - **Kolom Status**: **SELALU gunakan badge label berwarna bawaan AdminLTE** (`<span class="label label-success">`, `label-warning`, `label-danger`, `label-info`, `label-primary`, `label bg-gray`).
   - **DILARANG MENGGUNAKAN BADGE WARNA PUTIH**:
     - **Jangan pernah gunakan warna putih atau class `label-default` untuk badge status/data**. Di Cicool (`asset/css/custom.css`), class `.label-default` di-override menjadi `background: #fff !important;` (putih polos).
     - Untuk status draft, opsi opsional, belum bayar, atau status default/fallback, selalu gunakan `label-info` (Biru Muda), `label-primary` (Biru), atau `label bg-gray` (Abu-abu), bukan putih.
     - Class `.label-default` hanya diperuntukkan bagi tombol link aksi tabel (`<a class="label-default">`), BUKAN untuk badge data/status (`<span>`).
   - **Penamaan Judul Kolom (Header Tabel)**:
     - Wajib menggunakan nama Bahasa Indonesia standar yang bersih, ringkas, dan jelas.
     - **DILARANG menyertakan teks penjelas dalam tanda kurung** seperti `(Delivery Option)`, `(Scope)`, `(Brand)`, atau `(lorem ipsum)`.
     - Contoh Benar: `Opsi Pengiriman`, `Cakupan`, `Nama Merek`, `Tingkat`, `Kurir Logistik`.
     - Contoh Salah: `Opsi Pengiriman (Delivery Option)`, `Cakupan (Scope)`, `Nama Merek (Brand)`.
    - **Ukuran Default Kolom Aksi di Tabel List**:
      - **Jika terdapat multi-aksi (2 aksi atau lebih)**:
        - `th` wajib: `style="width: 260px; min-width: 260px; text-align: center;"`
        - `td` wajib: `style="min-width: 260px; text-align: center;"`
      - **Khusus jika hanya ada 1 aksi** (misalnya hanya tombol "Lihat" saja):
        - Kolom aksi dibuat pas (**fit**) mengikuti tombol:
        - `th` wajib: `style="width: 100px; text-align: center;"`
        - `td` wajib: `style="width: 100px; text-align: center;"` (atau `white-space: nowrap;`)
   - **Warna Icon di Tombol Aksi**:
     - Icon aksi defaultnya **wajib biru bawaan Cicool** (`.label-default .fa`).
     - **DILARANG menambahkan class warna custom** seperti `text-green` atau `text-yellow` pada icon tombol aksi, agar konsisten dengan tema AdminLTE Cicool.
    - **Kesesuaian Judul Modul dengan Menu Sidebar**:
      - Judul modul di seluruh halaman (List, Add/New, Edit/Update, dan View/Detail) **WAJIB SAMA PERSIS dengan label menu sidebar** di database / sidebar navigation.
      - Pastikan entri bahasa di `language/english/web_lang.php` dan `language/indonesian/web_lang.php` (`$lang['{module}']`) serta teks header/breadcrumb di view menggunakan nama resmi sidebar (contoh: `Akun Toko`, `Katalog Produk`, `Pesanan Penjualan`, `Retur Penjualan`, `Penghasilan Toko`, `Daftar Gudang`, `Kategori Produk`, `Merek Produk`). Dilarang menggunakan nama yang berbeda (misal `Kelola Toko`, `Produk TikTok`, `Order TikTok`, `Retur Order`, `Keuangan TikTok`).

4. **Standar Sub-Tabel di Halaman Detail (Pola Varian SKU)**:
   - Ketika menampilkan sub-tabel atau relasi data di halaman detail (`*_view.php`), wajib mengikuti struktur horizontal form Cicool seperti pada bagian **Varian SKU**:
     ```html
     <div class="form-group">
         <label class="col-sm-2 control-label">Nama Sub-Data </label>
         <div class="col-sm-8">
             <table class="table table-bordered table-striped" style="margin-top: 5px;">
                 <thead>
                     <tr class="bg-gray">
                         <th>Kolom 1</th>
                         <th>Kolom 2</th>
                     </tr>
                 </thead>
                 <tbody>
                     ...
                 </tbody>
             </table>
         </div>
     </div>
     ```

5. **Alur Pengembangan Modul Baru**:
   - Modul di-generate terlebih dahulu oleh user melalui **Cicool CRUD Generator**.
   - Penyesuaian developer hanya berupa:
     - Menghubungkan logika API / backend controller.
     - Menambahkan tombol aksi dengan format standar Cicool (diawali teks "Tarik Data").
     - Menampilkan sub-tabel relasi menggunakan class bawaan Cicool sesuai pola Varian SKU.
