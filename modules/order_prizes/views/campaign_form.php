<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.box-form-modern {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    margin-bottom: 25px;
}
.box-form-modern .form-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #edf2f7;
}
.box-form-modern .form-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.box-form-modern .form-desc {
    font-size: 13px;
    color: #64748b;
    margin: 3px 0 0;
}
.box-form-modern .form-body {
    padding: 24px;
}
.box-form-modern .form-group {
    margin-bottom: 20px;
}
.box-form-modern label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.box-form-modern .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    padding: 8px 12px;
    height: 38px;
}
.box-form-modern textarea.form-control {
    height: auto;
}
.box-form-modern .help-block {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}
.box-form-modern .form-footer {
    padding: 16px 24px;
    background: #f8fafc;
    border-top: 1px solid #edf2f7;
    border-radius: 0 0 8px 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

<section class="content-header">
    <h1>
        Order Prizes
        <small><?= $mode === 'edit' ? 'Edit Campaign #' . $campaign['id'] : 'Tambah Campaign Baru'; ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/campaigns'); ?>">Order Prizes</a></li>
        <li class="active"><?= $mode === 'edit' ? 'Edit' : 'Tambah'; ?> Campaign</li>
    </ol>
</section>

<section class="content">
    <div class="box-form-modern">
        <div class="form-header">
            <div>
                <h3 class="form-title"><?= $mode === 'edit' ? 'Edit Campaign: ' . html_escape($campaign['name']) : 'Formulir Campaign Baru'; ?></h3>
                <p class="form-desc">Atur periode promosi undian, channel marketplace, batas klaim, dan syarat ketentuan.</p>
            </div>
            <div>
                <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/campaigns'); ?>" class="btn btn-default" style="border-radius: 6px;">
                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <form id="form-campaign">
            <input type="hidden" name="id" value="<?= $campaign['id']; ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Nama Campaign <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="campaign-name" class="form-control" placeholder="Contoh: Promo Belanja Hadiah Oktober Shopee" value="<?= html_escape($campaign['name']); ?>" required maxlength="160">
                            <span class="help-block">Nama event promo yang ditampilkan ke customer.</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Slug URL (Link Undian) <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="campaign-slug" class="form-control" placeholder="contoh: belanja-oktober" value="<?= html_escape($campaign['slug']); ?>" required maxlength="80">
                            <span class="help-block">Alamat link public: <code>/order_prizes?campaign=<span id="slug-preview"><?= $campaign['slug'] ?: '...'; ?></span></code></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Channel Marketplace <span class="text-danger">*</span></label>
                            <select name="channel" class="form-control" required>
                                <option value="shopee" <?= $campaign['channel'] === 'shopee' ? 'selected' : ''; ?>>Shopee</option>
                                <option value="tiktok" <?= $campaign['channel'] === 'tiktok' ? 'selected' : ''; ?>>TikTok Shop</option>
                                <option value="tokopedia" <?= $campaign['channel'] === 'tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
                                <option value="lazada" <?= $campaign['channel'] === 'lazada' ? 'selected' : ''; ?>>Lazada</option>
                                <option value="other" <?= $campaign['channel'] === 'other' ? 'selected' : ''; ?>>Website / Offline / Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Referensi Toko (Shop Ref / ID Toko) <span class="text-danger">*</span></label>
                            <input type="text" name="shop_ref" class="form-control" placeholder="Contoh: TOKO_OFFICIAL_1" value="<?= html_escape($campaign['shop_ref']); ?>" required maxlength="80">
                            <span class="help-block">Kode unik toko agar nomor pesanan tidak tertukar.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Campaign <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="draft" <?= $campaign['status'] === 'draft' ? 'selected' : ''; ?>>Draft (Belum Dipublikasikan)</option>
                                <option value="active" <?= $campaign['status'] === 'active' ? 'selected' : ''; ?>>Active (Menerima Spin)</option>
                                <option value="paused" <?= $campaign['status'] === 'paused' ? 'selected' : ''; ?>>Paused (Dijeda Sementara)</option>
                                <option value="ended" <?= $campaign['status'] === 'ended' ? 'selected' : ''; ?>>Ended (Selesai)</option>
                            </select>
                            <span class="help-block">Campaign aktif wajib memiliki minimal 1 hadiah fallback (zonk/voucher tanpa biaya).</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="starts_at" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($campaign['starts_at'])); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="ends_at" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($campaign['ends_at'])); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Batas Klaim Hadiah (Hari) <span class="text-danger">*</span></label>
                            <input type="number" name="claim_days" class="form-control" min="1" max="90" value="<?= $campaign['claim_days'] ?: 7; ?>" required>
                            <span class="help-block">Jumlah hari customer wajib klaim setelah spin.</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Batas Biaya Hadiah (% Profit)</label>
                            <input type="number" name="budget_profit_percent" class="form-control" min="1" max="100" placeholder="Kosongkan jika tanpa batas" value="<?= html_escape($campaign['budget_profit_percent']); ?>">
                            <span class="help-block">Contoh: <code>10</code> berarti total biaya hadiah yang keluar maksimal 10% dari akumulasi profit order yang telah spin.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label style="margin-bottom: 0;">Syarat & Ketentuan Campaign <span class="text-danger">*</span></label>
                        <button type="button" class="btn btn-xs btn-default" id="btn-default-terms">
                            <i class="fa fa-magic"></i> Isi Template S&K Standar
                        </button>
                    </div>
                    <textarea name="terms" id="campaign-terms" class="form-control" rows="5" placeholder="Tuliskan syarat dan ketentuan untuk memutar roda hadiah dan batas waktu klaim..." required><?= html_escape($campaign['terms']); ?></textarea>
                </div>
            </div>

            <div class="form-footer">
                <div>
                    <span class="text-muted" style="font-size: 12px;"><i class="fa fa-keyboard-o"></i> Pintasan: <strong>Ctrl + S</strong> (Simpan), <strong>Ctrl + X</strong> (Batal)</span>
                </div>
                <div>
                    <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/campaigns'); ?>" class="btn btn-default" style="border-radius: 6px; margin-right: 6px;">Batal</a>
                    <button type="submit" class="btn btn-success" id="btn-save-campaign" style="border-radius: 6px; padding: 7px 20px; font-weight: 600;">
                        <i class="fa fa-check"></i> Simpan Data Campaign
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';
var CAMPAIGN_ID = <?= (int)$campaign['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

// Auto slug generator
$('#campaign-name').on('input', function() {
    <?php if ($mode === 'add'): ?>
    var val = $(this).val().toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .trim()
        .replace(/[\s_-]+/g, '-');
    $('#campaign-slug').val(val);
    $('#slug-preview').text(val || '...');
    <?php endif; ?>
});

$('#campaign-slug').on('input', function() {
    var val = $(this).val().toLowerCase().replace(/[^\w-]/g, '');
    $(this).val(val);
    $('#slug-preview').text(val || '...');
});

$('#btn-default-terms').on('click', function() {
    var defaultTerms = "1. Berlaku untuk nomor pesanan terverifikasi yang berstatus Completed/Paid.\n" +
        "2. Setiap pesanan berhak memutar roda undian sebanyak 1 (satu) kali.\n" +
        "3. Pemenang wajib melakukan klaim hadiah sebelum batas waktu klaim berakhir.\n" +
        "4. Hadiah tidak dapat diuangkan atau dipindahtangankan.\n" +
        "5. Pihak penyelenggara berhak membatalkan hadiah jika ditemukan indikasi kecurangan atau manipulasi pesanan.";
    $('#campaign-terms').val(defaultTerms);
});

// Save via AJAX
$('#form-campaign').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.set(CSRF_NAME, CSRF_HASH);

    $('#btn-save-campaign').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: BASE_ADMIN + '/save/campaigns/' + CAMPAIGN_ID,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
            if (res.csrf) CSRF_HASH = res.csrf.hash;
            if (res.success) {
                swal({
                    title: 'Berhasil!',
                    text: 'Data campaign berhasil disimpan.',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = BASE_ADMIN + '/tab/campaigns';
                }, 1200);
            } else {
                swal('Perhatian', res.message || 'Gagal menyimpan campaign.', 'warning');
            }
        },
        error: function(xhr) {
            var msg = 'Terjadi kesalahan sistem.';
            if (xhr.status === 403) {
                msg = 'Sesi atau token keamanan (CSRF) tidak valid / kedaluwarsa. Silakan refresh halaman (F5).';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            swal('Error', msg, 'error');
        },
        complete: function() {
            $('#btn-save-campaign').prop('disabled', false).html('<i class="fa fa-check"></i> Simpan Data Campaign');
        }
    });
});

// Keyboard hotkeys
$(document).on('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        $('#form-campaign').submit();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'x') {
        e.preventDefault();
        window.location.href = BASE_ADMIN + '/tab/campaigns';
    }
});
</script>
