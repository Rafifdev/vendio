<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_popup = ($this->input->get('popup') === 'show');
$status = strtoupper($transaction->payment_status ?? 'PENDING');
$is_paid = in_array($status, ['PAID', 'SETTLED']);
$is_pending = ($status === 'PENDING');
$is_expired = ($status === 'EXPIRED' || $status === 'FAILED');

$status_title = 'Menunggu Pembayaran';
$status_desc  = 'Silakan selesaikan pembayaran tagihan Anda melalui checkout Xendit.';
$status_color = '#d97706';
$status_bg    = '#fef3c7';
$status_icon  = 'fa-clock-o';

if ($is_paid) {
    $status_title = 'Pembayaran Berhasil!';
    $status_desc  = 'Terima kasih, paket langganan akun Anda telah berhasil diaktifkan.';
    $status_color = '#16a34a';
    $status_bg    = '#dcfce7';
    $status_icon  = 'fa-check';
} elseif ($is_expired) {
    $status_title = 'Tagihan Kedaluwarsa';
    $status_desc  = 'Batas waktu pembayaran telah berakhir atau transaksi dibatalkan.';
    $status_color = '#dc2626';
    $status_bg    = '#fee2e2';
    $status_icon  = 'fa-times';
}
?>

<style>
.status-box-wrapper {
    background: #ffffff;
    border: <?= $is_popup ? 'none' : '1px solid #e2e8f0'; ?>;
    border-radius: 12px;
    box-shadow: <?= $is_popup ? 'none' : '0 4px 20px rgba(0, 0, 0, 0.05)'; ?>;
    padding: <?= $is_popup ? '10px 15px' : '35px 30px'; ?>;
    margin: <?= $is_popup ? '0 auto' : '20px auto 40px auto'; ?>;
    max-width: <?= $is_popup ? '100%' : '650px'; ?>;
}
.status-icon-circle {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    margin: 0 auto 18px auto;
}
.status-detail-card {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    padding: 18px 20px;
    margin: 24px 0;
}
.status-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 13.5px;
    border-bottom: 1px dashed #e2e8f0;
}
.status-detail-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.status-detail-label {
    color: #64748b;
    font-weight: 500;
}
.status-detail-value {
    color: #0f172a;
    font-weight: 700;
    text-align: right;
}
</style>

<?php if ($is_popup): ?>
<script>
    $('#modalPopUp .popup-title').text('<?= $is_paid ? "Pembayaran Berhasil" : "Detail Status Transaksi"; ?>');
    $('#modalPopUp .modal-footer').hide();
    $('#modalPopUp').on('hidden.bs.modal', function() {
        $('#modalPopUp .modal-footer').show();
    });
    <?php if ($is_paid): ?>
    $('#modalPopUp').one('hidden.bs.modal', function() {
        var $txRow = $('tr[data-tx-id="<?= $transaction->id; ?>"]');
        if ($txRow.length && $txRow.find('.label-warning').length) {
            window.location.reload();
        }
    });
    <?php endif; ?>
</script>
<?php else: ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Status Pembayaran<small style="margin-left: 6px;">Detail Invoice & Langganan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('administrator/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= site_url('administrator/pricing'); ?>">Pilihan Paket</a></li>
        <li class="active">Status Pembayaran</li>
    </ol>
</section>
<?php endif; ?>

<!-- Main content -->
<section class="content" style="<?= $is_popup ? 'padding: 0;' : ''; ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="status-box-wrapper text-center">
                
                <!-- Status Icon -->
                <div class="status-icon-circle" style="background: <?= $status_bg; ?>; color: <?= $status_color; ?>;">
                    <i class="fa <?= $status_icon; ?>"></i>
                </div>

                <!-- Status Title & Desc -->
                <h3 style="font-size: 22px; font-weight: 800; color: #1e293b; margin: 0 0 8px 0;">
                    <?= $status_title; ?>
                </h3>
                <p style="font-size: 14px; color: #64748b; max-width: 480px; margin: 0 auto; line-height: 1.5;">
                    <?= $status_desc; ?>
                </p>

                <!-- Detail Tagihan & Paket -->
                <div class="status-detail-card text-left">
                    <div class="status-detail-row">
                        <span class="status-detail-label">Nomor Invoice</span>
                        <span class="status-detail-value" style="font-family: monospace; letter-spacing: 0.5px; color: #008d4c;">
                            <?= html_escape($transaction->invoice_number); ?>
                        </span>
                    </div>
                    <div class="status-detail-row">
                        <span class="status-detail-label">Paket Langganan</span>
                        <span class="status-detail-value"><?= html_escape($transaction->plan_name); ?></span>
                    </div>
                    <div class="status-detail-row">
                        <span class="status-detail-label">Durasi Paket</span>
                        <span class="status-detail-value"><?= (int)$transaction->duration_months; ?> Bulan</span>
                    </div>
                    <div class="status-detail-row">
                        <span class="status-detail-label">Total Tagihan</span>
                        <span class="status-detail-value" style="color: #00a65a; font-size: 16px;">
                            Rp <?= number_format($transaction->total_amount, 0, ',', '.'); ?>
                        </span>
                    </div>
                    <div class="status-detail-row">
                        <span class="status-detail-label">Status Transaksi</span>
                        <span class="status-detail-value">
                            <?php if ($is_paid): ?>
                                <span class="label label-success" style="font-size: 12px; padding: 4px 10px; border-radius: 12px;">LUNAS (PAID)</span>
                            <?php elseif ($is_pending): ?>
                                <span class="label label-warning" style="font-size: 12px; padding: 4px 10px; border-radius: 12px;">MENUNGGU PEMBAYARAN</span>
                            <?php else: ?>
                                <span class="label label-danger" style="font-size: 12px; padding: 4px 10px; border-radius: 12px;"><?= html_escape($status); ?></span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <?php if ($is_paid && !empty($transaction->payment_method)): ?>
                        <div class="status-detail-row">
                            <span class="status-detail-label">Metode Pembayaran</span>
                            <span class="status-detail-value">
                                <?= html_escape($transaction->payment_method . (!empty($transaction->payment_channel) ? ' - ' . $transaction->payment_channel : '')); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if ($is_paid && !empty($tenant->subscription_ends_at)): ?>
                        <div class="status-detail-row" style="background: #f0fdf4; margin: 4px -8px -4px -8px; padding: 10px 8px; border-radius: 6px;">
                            <span class="status-detail-label" style="color: #15803d; font-weight: 600;">Masa Aktif Akun Baru</span>
                            <span class="status-detail-value" style="color: #15803d; font-size: 14px;">
                                <i class="fa fa-calendar-check-o" style="margin-right: 4px;"></i>
                                <?= date('d M Y, H:i', strtotime($tenant->subscription_ends_at)); ?> WIB
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-top: <?= $is_popup ? '15px' : '25px'; ?>;">
                    <?php if ($is_pending && !empty($transaction->invoice_url)): ?>
                        <a href="<?= $transaction->invoice_url; ?>" target="_blank" class="btn btn-success" style="border-radius: 6px; font-weight: 700; font-size: 14px; padding: 10px 24px; background: #00a65a; border-color: #008d4c;">
                            <i class="fa fa-external-link" style="margin-right: 6px;"></i> Lanjutkan Bayar di Xendit
                        </a>
                        <?php if ($is_popup): ?>
                            <button type="button" onclick="showPopup('<?= site_url('administrator/pricing/payment_status/' . $transaction->xendit_external_id . '?popup=show'); ?>');" class="btn btn-default" style="border-radius: 6px; font-size: 14px; padding: 10px 20px;">
                                <i class="fa fa-refresh" style="margin-right: 6px;"></i> Cek Ulang Status
                            </button>
                        <?php else: ?>
                            <button type="button" onclick="window.location.reload();" class="btn btn-default btn-lg" style="border-radius: 6px; font-size: 14px; padding: 10px 20px;">
                                <i class="fa fa-refresh" style="margin-right: 6px;"></i> Cek Ulang Status
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($is_paid): ?>
                        <?php if ($is_popup): ?>
                            <button type="button" class="btn btn-success" data-dismiss="modal" style="border-radius: 6px; font-weight: 700; font-size: 14px; padding: 10px 28px; background: #00a65a; border-color: #008d4c;">
                                <i class="fa fa-check" style="margin-right: 6px;"></i> Tutup & Lanjutkan
                            </button>
                        <?php else: ?>
                            <a href="<?= site_url('administrator/pricing'); ?>" class="btn btn-success btn-lg" style="border-radius: 6px; font-weight: 700; font-size: 14px; padding: 10px 24px; background: #00a65a; border-color: #008d4c;">
                                <i class="fa fa-check" style="margin-right: 6px;"></i> Tutup & Lanjutkan
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (!$is_paid): ?>
                        <?php if ($is_popup): ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px; font-size: 14px; padding: 10px 20px;">
                                <i class="fa fa-times" style="margin-right: 6px;"></i> Tutup
                            </button>
                        <?php else: ?>
                            <a href="<?= site_url('administrator/pricing'); ?>" class="btn btn-default btn-lg" style="border-radius: 6px; font-size: 14px; padding: 10px 20px;">
                                <i class="fa fa-arrow-left" style="margin-right: 6px;"></i> Kembali ke Pilihan Paket
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>
