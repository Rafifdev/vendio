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
                            <select name="channel" id="campaign-channel" class="form-control" required>
                                <option value="tiktok" <?= $campaign['channel'] === 'tiktok' ? 'selected' : ''; ?>>TikTok Shop</option>
                                <option value="shopee" <?= $campaign['channel'] === 'shopee' ? 'selected' : ''; ?>>Shopee</option>
                                <option value="tokopedia" <?= $campaign['channel'] === 'tokopedia' ? 'selected' : ''; ?>>Tokopedia</option>
                                <option value="lazada" <?= $campaign['channel'] === 'lazada' ? 'selected' : ''; ?>>Lazada</option>
                                <option value="other" <?= $campaign['channel'] === 'other' ? 'selected' : ''; ?>>Website / Offline / Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Referensi Toko (Toko Penjual) <span class="text-danger">*</span></label>
                            <!-- Dropdown for TikTok shops -->
                            <div id="shop-ref-select-wrapper" style="<?= $campaign['channel'] === 'tiktok' ? '' : 'display: none;'; ?>">
                                <select name="shop_ref_select" id="shop-ref-select" class="form-control">
                                    <option value="all" <?= $campaign['shop_ref'] === 'all' ? 'selected' : ''; ?>>Semua Toko TikTok Terhubung</option>
                                    <?php if (!empty($tiktok_shops)): foreach ($tiktok_shops as $ts): ?>
                                        <option value="<?= html_escape($ts['shop_name']); ?>" <?= $campaign['shop_ref'] === $ts['shop_name'] ? 'selected' : ''; ?>>
                                            <?= html_escape($ts['shop_name']); ?> (<?= html_escape($ts['shop_code'] ?: $ts['shop_id']); ?>)
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <!-- Text input for Shopee/other -->
                            <div id="shop-ref-text-wrapper" style="<?= $campaign['channel'] !== 'tiktok' ? '' : 'display: none;'; ?>">
                                <input type="text" name="shop_ref_text" id="shop-ref-text" class="form-control" placeholder="Nama toko kamu (misal: Toko Berkah)" value="<?= html_escape($campaign['shop_ref'] ?: 'SHOPEE_STORE'); ?>" maxlength="80">
                            </div>
                            <input type="hidden" name="shop_ref" id="campaign-shop-ref" value="<?= html_escape($campaign['shop_ref']); ?>">
                            <span class="help-block" id="shop-ref-hint" style="font-size: 11.5px;">Pilih toko TikTok yang terhubung di Vendio.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Campaign <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="active" <?= ($campaign['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Active (Menerima Spin)</option>
                                <option value="draft" <?= ($campaign['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>Draft (Belum Dipublikasikan)</option>
                                <option value="paused" <?= ($campaign['status'] ?? '') === 'paused' ? 'selected' : ''; ?>>Paused (Dijeda Sementara)</option>
                                <option value="ended" <?= ($campaign['status'] ?? '') === 'ended' ? 'selected' : ''; ?>>Ended (Selesai)</option>
                            </select>
                            <span class="help-block" style="font-size: 11.5px;">Status aktif langsung dapat menerima putaran spin.</span>
                        </div>
                    </div>
                    <input type="hidden" name="verification_mode" value="auto">
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
                            <label>Batas Waktu Spin (Hari Setelah Pesanan Selesai) <span class="text-danger">*</span></label>
                            <input type="number" name="claim_days" class="form-control" min="1" max="90" value="<?= $campaign['claim_days'] ?: 7; ?>" required>
                            <span class="help-block">Maksimal N hari sejak pesanan selesai untuk memutar spin. Lewat dari waktu ini kesempatan spin hangus.</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="budget_profit_percent" value="">

                <!-- Daftar Hadiah untuk Campaign Ini -->
                <div class="form-group" style="margin-top: 25px; margin-bottom: 25px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <div>
                            <label style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 2px;">
                                <i class="fa fa-gift text-green"></i> Daftar Hadiah untuk Campaign Ini
                            </label>
                            <div style="font-size: 12px; color: #64748b;">Pilih hadiah-hadiah yang akan dimasukkan ke dalam roda undian campaign ini. 1 hadiah bisa dipakai di beberapa campaign.</div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-xs btn-default" id="btn-toggle-all-prizes">
                                <i class="fa fa-check-square-o"></i> Pilih Semua
                            </button>
                            <a href="<?= site_url(ADMIN_NAMESPACE_URL . '/order_prizes/prize_add'); ?>" target="_blank" class="btn btn-xs btn-primary" style="margin-left: 6px;">
                                <i class="fa fa-plus"></i> Buat Master Hadiah Baru
                            </a>
                        </div>
                    </div>

                    <?php if (empty($all_prizes)): ?>
                        <div style="padding: 15px; background: #fff; border: 1px dashed #cbd5e1; border-radius: 6px; text-align: center; color: #64748b; font-size: 13px;">
                            Belum ada master hadiah di sistem. Hadiah fallback "Belum Beruntung" akan otomatis dibuatkan oleh sistem.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive" style="background: #fff; border-radius: 6px; border: 1px solid #e2e8f0; max-height: 250px; overflow-y: auto;">
                            <table class="table table-hover" style="margin-bottom: 0; font-size: 13px;">
                                <thead>
                                    <tr style="background: #f1f5f9; color: #475569;">
                                        <th width="50" class="text-center">Pakai</th>
                                        <th>Nama Hadiah</th>
                                        <th>Jenis</th>
                                        <th>Peluang (Bobot)</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_prizes as $pz): ?>
                                        <?php $checked = in_array((int)$pz['id'], $selected_prize_ids ?? []); ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="prize_ids[]" value="<?= $pz['id']; ?>" class="prize-item-checkbox" <?= $checked ? 'checked' : ''; ?>>
                                            </td>
                                            <td>
                                                <strong style="color: #0f172a;"><?= html_escape($pz['name']); ?></strong>
                                                <?php if (!empty($pz['description'])): ?>
                                                    <div style="font-size: 11px; color: #94a3b8;"><?= html_escape($pz['description']); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11px;">
                                                    <?= html_escape($pz['kind']); ?>
                                                </span>
                                            </td>
                                            <td>Bobot: <?= number_format($pz['weight']); ?></td>
                                            <td>
                                                <?= $pz['stock'] === null ? '<span class="text-info"><i class="fa fa-infinity"></i> Unlimited</span>' : ($pz['stock'] <= 0 ? '<span class="text-danger">Habis</span>' : number_format($pz['stock']) . ' pcs'); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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

// Dynamic Shop Ref switching between TikTok dropdown and marketplace text
function syncShopRef() {
    var channel = $('#campaign-channel').val();
    if (channel === 'tiktok') {
        $('#shop-ref-select-wrapper').show();
        $('#shop-ref-text-wrapper').hide();
        var selectedShop = $('#shop-ref-select').val();
        $('#campaign-shop-ref').val(selectedShop || 'all');
        $('#shop-ref-hint').text('Pilih toko TikTok yang terhubung di sistem Vendio.');
    } else {
        $('#shop-ref-select-wrapper').hide();
        $('#shop-ref-text-wrapper').show();
        var txt = $('#shop-ref-text').val().trim();
        if (!txt) {
            txt = channel.toUpperCase() + '_STORE';
            $('#shop-ref-text').val(txt);
        }
        $('#campaign-shop-ref').val(txt);
        $('#shop-ref-hint').text('Ketik nama toko di marketplace ' + channel.toUpperCase() + '.');
    }
}

$('#campaign-channel').on('change', syncShopRef);
$('#shop-ref-select').on('change', function() {
    $('#campaign-shop-ref').val($(this).val());
});
$('#shop-ref-text').on('input', function() {
    $('#campaign-shop-ref').val($(this).val());
});
syncShopRef();

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

$('#btn-toggle-all-prizes').on('click', function() {
    var checkboxes = $('.prize-item-checkbox');
    var allChecked = checkboxes.length === checkboxes.filter(':checked').length;
    checkboxes.prop('checked', !allChecked);
});

$('#btn-default-terms').on('click', function() {
    var defaultTerms = "1. Berlaku untuk nomor pesanan terverifikasi yang berstatus Completed/Paid.\n" +
        "2. Setiap pesanan berhak memutar roda undian sebanyak 1 (satu) kali.\n" +
        "3. Kesempatan spin berlaku sesuai batas waktu (hari) sejak pesanan selesai.\n" +
        "4. Hadiah yang didapat saat spin otomatis tercatat & langsung diklaim untuk diproses toko.\n" +
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
