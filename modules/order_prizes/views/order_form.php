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
        <small><?= $mode === 'edit' ? 'Edit Order #' . $order['id'] : 'Tambah Order Terverifikasi'; ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/orders'); ?>">Order Prizes</a></li>
        <li class="active"><?= $mode === 'edit' ? 'Edit' : 'Tambah'; ?> Order</li>
    </ol>
</section>

<section class="content">
    <div class="box-form-modern">
        <div class="form-header">
            <div>
                <h3 class="form-title"><?= $mode === 'edit' ? 'Edit Order: #' . html_escape($order['order_number']) : 'Tambah Order Terverifikasi Manual'; ?></h3>
                <p class="form-desc">Masukkan data pesanan pembeli agar nomor pesanan dan HP tersebut berhak melakukan spin di web hadiah.</p>
            </div>
            <div>
                <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/orders'); ?>" class="btn btn-default" style="border-radius: 6px;">
                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

        <form id="form-order">
            <input type="hidden" name="id" value="<?= $order['id']; ?>">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Target Campaign <span class="text-danger">*</span></label>
                            <select name="campaign_id" id="order-campaign-id" class="form-control" required <?= $mode === 'edit' ? 'disabled' : ''; ?>>
                                <?php foreach ($campaigns_dropdown as $c): ?>
                                    <option value="<?= $c['id']; ?>" <?= $order['campaign_id'] == $c['id'] ? 'selected' : ''; ?>>
                                        #<?= $c['id']; ?> - <?= html_escape($c['name']); ?> (<?= strtoupper($c['channel']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($mode === 'edit'): ?>
                                <input type="hidden" name="campaign_id" value="<?= $order['campaign_id']; ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Pesanan <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed (Selesai)</option>
                                <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : ''; ?>>Paid (Sudah Dibayar)</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled (Dibatalkan)</option>
                                <option value="refunded" <?= $order['status'] === 'refunded' ? 'selected' : ''; ?>>Refunded (Pengembalian Dana)</option>
                            </select>
                            <span class="help-block">Hanya status Completed / Paid yang diizinkan untuk memutar roda spin.</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Pesanan (Order ID) <span class="text-danger">*</span></label>
                            <input type="text" name="order_number" id="order-number" class="form-control" placeholder="Contoh: 261014ABC123" value="<?= html_escape($order['order_number']); ?>" required maxlength="80">
                            <span class="help-block">Nomor pesanan yang tertera di Shopee / TikTok Shop (otomatis kapital).</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor HP Pembeli <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="order-phone" class="form-control" placeholder="Contoh: 08123456789 atau 628123456789" value="<?= html_escape($order['phone']); ?>" required maxlength="25">
                            <span class="help-block">Format standar otomatis dinormalisasi ke: <strong id="phone-preview" style="color: #059669;"><?= $order['phone'] ?: '628...'; ?></strong></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Omset / Belanja (IDR) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text" inputmode="numeric" name="revenue" id="order-revenue" class="form-control input-nominal" placeholder="Contoh: 150.000" value="<?= !empty($order['revenue']) ? number_format((int)$order['revenue'], 0, ',', '.') : ''; ?>" required>
                            </div>
                            <span class="help-block">Total pembayaran pesanan ini.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Estimasi Profit Bersih (IDR)</label>
                            <div class="input-group">
                                <span class="input-group-addon">Rp</span>
                                <input type="text" inputmode="numeric" name="profit" id="order-profit" class="form-control input-nominal" placeholder="Contoh: 25.000 (Kosongkan jika belum ada)" value="<?= !empty($order['profit']) ? number_format((int)$order['profit'], 0, ',', '.') : ''; ?>">
                            </div>
                            <span class="help-block">Opsional. Digunakan jika ada hadiah dengan threshold minimum profit.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Waktu Pemesanan <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="ordered_at" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($order['ordered_at'])); ?>" required>
                            <span class="help-block">Harus berada dalam periode tanggal campaign.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <div>
                    <span class="text-muted" style="font-size: 12px;"><i class="fa fa-keyboard-o"></i> Pintasan: <strong>Ctrl + S</strong> (Simpan), <strong>Ctrl + X</strong> (Batal)</span>
                </div>
                <div>
                    <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/tab/orders'); ?>" class="btn btn-default" style="border-radius: 6px; margin-right: 6px;">Batal</a>
                    <button type="submit" class="btn btn-success" id="btn-save-order" style="border-radius: 6px; padding: 7px 20px; font-weight: 600;">
                        <i class="fa fa-check"></i> Simpan Data Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash(); ?>';
var ORDER_ID = <?= (int)$order['id']; ?>;
var BASE_ADMIN = '<?= site_url(ADMIN_NAMESPACE_URL . "/order_prizes"); ?>';

// Auto uppercase order number
$('#order-number').on('input', function() {
    $(this).val($(this).val().toUpperCase().replace(/[^\w-]/g, ''));
});

// Phone normalizer preview
$('#order-phone').on('input', function() {
    var raw = $(this).val().replace(/[^\d+]/g, '');
    var norm = raw;
    if (norm.indexOf('+') === 0) norm = norm.substring(1);
    if (norm.indexOf('08') === 0) norm = '628' + norm.substring(2);
    $('#phone-preview').text(norm || '628...');
});

// Realtime Rupiah / Nominal formatting per type
$(document).on('input', '.input-nominal', function() {
    var input = this;
    var cursorPosition = input.selectionStart;
    var originalLength = input.value.length;
    var rawDigits = input.value.replace(/\D/g, '');

    if (rawDigits === '') {
        input.value = '';
        return;
    }

    var formatted = rawDigits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    input.value = formatted;

    var newLength = formatted.length;
    var diff = newLength - originalLength;
    var newPos = Math.max(0, cursorPosition + diff);
    input.setSelectionRange(newPos, newPos);
});

// Save via AJAX
$('#form-order').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.set(CSRF_NAME, CSRF_HASH);

    // Bersihkan titik pemisah ribuan agar terkirim sebagai angka integer murni
    formData.set('revenue', ($('#order-revenue').val() || '').replace(/\D/g, '') || '0');
    var profitVal = $('#order-profit').val();
    formData.set('profit', profitVal ? profitVal.replace(/\D/g, '') : '');

    $('#btn-save-order').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: BASE_ADMIN + '/save/orders/' + ORDER_ID,
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
                    text: 'Data order berhasil disimpan.',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = BASE_ADMIN + '/tab/orders';
                }, 1200);
            } else {
                swal('Perhatian', res.message || 'Gagal menyimpan data order.', 'warning');
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
            $('#btn-save-order').prop('disabled', false).html('<i class="fa fa-check"></i> Simpan Data Order');
        }
    });
});

// Keyboard shortcuts
$(document).on('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        $('#form-order').submit();
    }
    if ((e.ctrlKey || e.metaKey) && e.key === 'x') {
        e.preventDefault();
        window.location.href = BASE_ADMIN + '/tab/orders';
    }
});
</script>
