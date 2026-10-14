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
.threshold-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    margin-top: 15px;
    margin-bottom: 20px;
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
        <small><?= $mode === 'edit' ? 'Edit Hadiah #' . $prize['id'] : 'Tambah Hadiah & Threshold'; ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/prizes'); ?>">Order Prizes</a></li>
        <li class="active"><?= $mode === 'edit' ? 'Edit' : 'Tambah'; ?> Hadiah</li>
    </ol>
</section>

<section class="content">
    <div class="box-form-modern">
        <div class="form-header">
            <div>
                <h3 class="form-title"><?= $mode === 'edit' ? 'Edit Hadiah: ' . html_escape($prize['name']) : 'Formulir Hadiah & Threshold'; ?></h3>
                <p class="form-desc">Tentukan hadiah, bobot peluang acak, dan aturan threshold omset/profit agar hadiah keluar sesuai target bisnis.</p>
            </div>
            <div>
                <button type="button" class="btn btn-warning" id="btn-preset-fallback" style="border-radius: 6px; margin-right: 6px; font-weight: 600;">
                    <i class="fa fa-magic"></i> 1-Klik Hadiah Zonk (Fallback)
                </button>
                <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/prizes'); ?>" class="btn btn-default" style="border-radius: 6px;">
                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <form id="form-prize">
            <input type="hidden" name="id" value="<?= $prize['id']; ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Target Campaign <span class="text-danger">*</span></label>
                            <select name="campaign_id" id="prize-campaign-id" class="form-control" required <?= $mode === 'edit' ? 'disabled' : ''; ?>>
                                <?php foreach ($campaigns_dropdown as $c): ?>
                                    <option value="<?= $c['id']; ?>" <?= $prize['campaign_id'] == $c['id'] ? 'selected' : ''; ?>>
                                        #<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($mode === 'edit'): ?>
                                <input type="hidden" name="campaign_id" value="<?= $prize['campaign_id']; ?>">
                                <span class="help-block text-muted">Hadiah tidak dapat dipindahkan ke campaign lain setelah dibuat.</span>
                            <?php else: ?>
                                <span class="help-block">Hadiah ini akan dimasukkan ke dalam roda spin campaign yang dipilih.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Jenis Hadiah <span class="text-danger">*</span></label>
                            <select name="kind" id="prize-kind" class="form-control" required>
                                <option value="physical" <?= $prize['kind'] === 'physical' ? 'selected' : ''; ?>>Fisik (Barang / Produk)</option>
                                <option value="voucher" <?= $prize['kind'] === 'voucher' ? 'selected' : ''; ?>>Voucher / Kupon Diskon</option>
                                <option value="none" <?= $prize['kind'] === 'none' ? 'selected' : ''; ?>>Belum Beruntung (Zonk)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Hadiah <span class="text-danger">*</span></label>
                            <select name="active" class="form-control" required>
                                <option value="1" <?= $prize['active'] == 1 ? 'selected' : ''; ?>>Aktif (Bisa Dimainkan)</option>
                                <option value="0" <?= $prize['active'] == 0 ? 'selected' : ''; ?>>Non-Aktif (Diarsipkan)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Hadiah <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="prize-name" class="form-control" placeholder="Contoh: Logam Mulia 1 Gram / Voucher Diskon 50%" value="<?= html_escape($prize['name']); ?>" required maxlength="160">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bobot Peluang Relatif (Weight) <span class="text-danger">*</span></label>
                            <input type="number" name="weight" id="prize-weight" class="form-control" min="1" max="1000000" value="<?= $prize['weight'] ?: 10; ?>" required>
                            <span class="help-block">Semakin besar bobotnya, semakin sering keluar (misal Zonk = 50, Hadiah Utama = 1).</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat Hadiah</label>
                    <textarea name="description" id="prize-desc" class="form-control" rows="2" placeholder="Keterangan tambahan untuk pemenang (misal: syarat penukaran voucher, warna produk, dll)..."><?= html_escape($prize['description']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sisa Kuota Stok</label>
                            <div class="input-group">
                                <input type="number" name="stock" id="prize-stock" class="form-control" min="0" max="1000000" placeholder="Kosongkan jika tidak terbatas" value="<?= html_escape($prize['stock']); ?>" <?= $prize['stock'] === null || $prize['stock'] === '' ? 'disabled' : ''; ?>>
                                <span class="input-group-addon" style="background: #f8fafc;">
                                    <label style="margin: 0; font-weight: normal; cursor: pointer;">
                                        <input type="checkbox" id="prize-unlimited" <?= $prize['stock'] === null || $prize['stock'] === '' ? 'checked' : ''; ?>> Tidak Terbatas (Unlimited)
                                    </label>
                                </span>
                            </div>
                            <span class="help-block">Stok akan otomatis berkurang setiap kali ada customer yang memenangkan hadiah ini.</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Biaya Internal Hadiah (Cost IDR) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="number" name="cost" id="prize-cost" class="form-control" min="0" max="1000000000" placeholder="0" value="<?= html_escape($prize['cost']); ?>" required>
                            </div>
                            <span class="help-block">Biaya riil toko untuk menyediakan hadiah ini (untuk hadiah zonk/voucher tanpa biaya: isi <code>0</code>).</span>
                        </div>
                    </div>
                </div>

                <!-- THRESHOLD RULES BOX -->
                <div class="threshold-card">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                        <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #0f172a;">
                            <i class="fa fa-sliders text-green"></i> Aturan Threshold (Kapan Hadiah Boleh Keluar?)
                        </h4>
                        <span class="text-muted" style="font-size: 12px;">Semua syarat yang diisi harus terpenuhi (AND).</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Threshold Otomatis (Auto Metric)</label>
                                <select name="auto_metric" id="prize-auto-metric" class="form-control">
                                    <option value="none" <?= $prize['auto_metric'] === 'none' ? 'selected' : ''; ?>>None (Gunakan Threshold Manual di bawah)</option>
                                    <option value="profit" <?= $prize['auto_metric'] === 'profit' ? 'selected' : ''; ?>>Auto Profit (Kunci berdasarkan profit terkumpul)</option>
                                    <option value="revenue" <?= $prize['auto_metric'] === 'revenue' ? 'selected' : ''; ?>>Auto Revenue (Kunci berdasarkan omset terkumpul)</option>
                                </select>
                                <span class="help-block">Jika memilih Auto, gate otomatis dihitung dari <code>Biaya × 100 / Alokasi %</code>.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alokasi Biaya (%) untuk Auto Gate</label>
                                <input type="number" name="allocation_percent" id="prize-allocation" class="form-control" min="1" max="100" value="<?= $prize['allocation_percent'] ?: 10; ?>">
                                <span class="help-block">Contoh <code>10%</code>: Hadiah Rp100.000 baru boleh keluar setelah profit mencapai Rp1.000.000.</span>
                            </div>
                        </div>
                    </div>

                    <hr style="margin: 12px 0 18px; border-color: #e2e8f0;">
                    <div style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 12px;">
                        Aturan Manual Tambahan (Isi <code>0</code> jika tidak ingin membatasi):
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Setiap Kelipatan N Spin</label>
                                <input type="number" name="threshold_spins" id="prize-thresh-spins" class="form-control" min="0" value="<?= $prize['threshold_spins'] ?: 0; ?>">
                                <span class="help-block">Contoh <code>100</code>: Hadiah unit ke-1 eligible di spin ke-100, unit ke-2 di spin ke-200.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Setiap Kelipatan Omset (Rp)</label>
                                <input type="number" name="threshold_revenue" id="prize-thresh-revenue" class="form-control" min="0" value="<?= $prize['threshold_revenue'] ?: 0; ?>">
                                <span class="help-block">Omset pesanan yang sudah spin.</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Setiap Kelipatan Profit (Rp)</label>
                                <input type="number" name="threshold_profit" id="prize-thresh-profit" class="form-control" min="0" value="<?= $prize['threshold_profit'] ?: 0; ?>">
                                <span class="help-block">Profit pesanan yang sudah spin.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <div>
                    <span class="text-muted" style="font-size: 12px;"><i class="fa fa-keyboard-o"></i> Pintasan: <strong>Ctrl + S</strong> (Simpan), <strong>Ctrl + X</strong> (Batal)</span>
                </div>
                <div>
                    <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/prizes'); ?>" class="btn btn-default" style="border-radius: 6px; margin-right: 6px;">Batal</a>
                    <button type="submit" class="btn btn-success" id="btn-save-prize" style="border-radius: 6px; padding: 7px 20px; font-weight: 600;">
                        <i class="fa fa-check"></i> Simpan Data Hadiah
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';
var PRIZE_ID = <?= (int)$prize['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

// Unlimited stock checkbox toggle
$('#prize-unlimited').on('change', function() {
    if ($(this).is(':checked')) {
        $('#prize-stock').val('').prop('disabled', true);
    } else {
        $('#prize-stock').prop('disabled', false).focus();
    }
});

// 1-Click Fallback Preset Button
$('#btn-preset-fallback').on('click', function() {
    $('#prize-name').val('Belum Beruntung');
    $('#prize-kind').val('none');
    $('#prize-weight').val('50');
    $('#prize-desc').val('Jangan berkecil hati! Masih banyak promo dan penawaran menarik lainnya di toko kami.');
    $('#prize-unlimited').prop('checked', true);
    $('#prize-stock').val('').prop('disabled', true);
    $('#prize-cost').val('0');
    $('#prize-auto-metric').val('none');
    $('#prize-thresh-spins').val('0');
    $('#prize-thresh-revenue').val('0');
    $('#prize-thresh-profit').val('0');

    swal('Preset Diterapkan', 'Formulir hadiah Fallback (Zonk) telah diisi otomatis. Silakan klik Simpan.', 'info');
});

// Auto-adjust when kind is changed
$('#prize-kind').on('change', function() {
    if ($(this).val() === 'none') {
        $('#prize-cost').val('0');
        $('#prize-auto-metric').val('none');
        $('#prize-unlimited').prop('checked', true);
        $('#prize-stock').val('').prop('disabled', true);
    }
});

// Save via AJAX
$('#form-prize').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.set(CSRF_NAME, CSRF_HASH);

    if ($('#prize-unlimited').is(':checked')) {
        formData.set('stock', '');
    }

    $('#btn-save-prize').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: BASE_ADMIN + '/save/prizes/' + PRIZE_ID,
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
                    text: 'Data hadiah berhasil disimpan.',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = BASE_ADMIN + '/tab/prizes';
                }, 1200);
            } else {
                swal('Perhatian', res.message || 'Gagal menyimpan hadiah.', 'warning');
            }
        },
        error: function(xhr) {
            var msg = 'Terjadi kesalahan sistem.';
            if (xhr.status === 403) {
                msg = 'Sesi atau token keamanan (CSRF) tidak valid / kedaluwarsa. Silakan refresh halaman (F5).';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                try {
                    var parsed = JSON.parse(xhr.responseText);
                    if (parsed && parsed.message) msg = parsed.message;
                } catch (_) {
                    if (xhr.responseText.length < 200 && !xhr.responseText.includes('<html')) msg = xhr.responseText;
                }
            }
            swal('Error', msg, 'error');
        },
        complete: function() {
            $('#btn-save-prize').prop('disabled', false).html('<i class="fa fa-check"></i> Simpan Data Hadiah');
        }
    });
});

// Keyboard shortcuts
$(document).on('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        $('#form-prize').submit();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'x') {
        e.preventDefault();
        window.location.href = BASE_ADMIN + '/tab/prizes';
    }
});
</script>
