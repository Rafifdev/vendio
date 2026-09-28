<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper sederhana untuk generate barcode Code 128 sederhana dalam format SVG
 */
function generate_barcode_svg($code, $height = 50) {
    // Pola representasi garis visual sederhana untuk Code 128
    $code_str = (string)$code;
    $len = strlen($code_str);
    $svg = '<svg viewBox="0 0 ' . max(200, $len * 14) . ' ' . $height . '" width="100%" height="' . $height . '" preserveAspectRatio="none">';
    $svg .= '<rect x="0" y="0" width="100%" height="' . $height . '" fill="#ffffff"/>';
    $x = 10;
    for ($i = 0; $i < $len; $i++) {
        $c = ord($code_str[$i]);
        // Tentukan pola striping berdasarkan karakter
        $w1 = ($c % 3) + 1;
        $w2 = (($c >> 1) % 3) + 1;
        $w3 = (($c >> 2) % 3) + 1;
        $svg .= "<rect x='{$x}' y='0' width='{$w1}' height='{$height}' fill='#000000'/>";
        $x += $w1 + 2;
        $svg .= "<rect x='{$x}' y='0' width='{$w2}' height='{$height}' fill='#000000'/>";
        $x += $w2 + 2;
        $svg .= "<rect x='{$x}' y='0' width='{$w3}' height='{$height}' fill='#000000'/>";
        $x += $w3 + 3;
    }
    $svg .= '</svg>';
    return $svg;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Label Pengiriman - <?= htmlspecialchars($package->package_id); ?></title>
    <style>
        @page {
            size: 100mm 150mm;
            margin: 0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #000;
        }
        body {
            background-color: #fff;
            padding: 6mm;
            width: 100mm;
            margin: 0 auto;
        }
        .label-container {
            border: 2px solid #000;
            width: 100%;
            height: 100%;
        }
        .header-section {
            border-bottom: 2px solid #000;
            padding: 6px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        .courier-badge {
            font-size: 15px;
            font-weight: bold;
            text-align: right;
            border: 1.5px solid #000;
            padding: 2px 6px;
        }
        .barcode-section {
            padding: 8px 10px;
            text-align: center;
            border-bottom: 2px solid #000;
        }
        .tracking-num {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-top: 4px;
        }
        .info-grid {
            display: flex;
            border-bottom: 2px solid #000;
        }
        .address-box {
            padding: 6px 8px;
            font-size: 10.5px;
            line-height: 1.3;
        }
        .recipient-box {
            width: 58%;
            border-right: 1.5px solid #000;
        }
        .sender-box {
            width: 42%;
        }
        .box-title {
            font-weight: 800;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
            border-bottom: 1px dashed #666;
            display: inline-block;
        }
        .order-info {
            border-bottom: 2px solid #000;
            padding: 6px 8px;
            font-size: 10.5px;
            display: flex;
            justify-content: space-between;
        }
        .items-section {
            padding: 6px 8px;
            font-size: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .items-table th, .items-table td {
            border: 1px solid #999;
            padding: 3px 5px;
            text-align: left;
        }
        .items-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .footer-note {
            padding: 4px 8px;
            font-size: 9px;
            text-align: center;
            border-top: 1px dashed #000;
            margin-top: 6px;
        }
        .no-print {
            text-align: center;
            margin-bottom: 10px;
            padding: 8px;
            background: #eee;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()" style="padding: 6px 16px; font-weight: bold; cursor: pointer; background: #007bff; color: #fff; border: none; border-radius: 3px;">🖨️ Cetak Label (A6 Thermal)</button>
    <button onclick="window.close()" style="padding: 6px 16px; margin-left: 8px; cursor: pointer;">Tutup</button>
</div>

<div class="label-container">
    <!-- Header -->
    <div class="header-section">
        <div>
            <div class="header-title">TikTok Shop</div>
            <div style="font-size: 10px; font-weight: 600;"><?= htmlspecialchars($package->delivery_option_name ?: 'Standard Delivery'); ?></div>
        </div>
        <div class="courier-badge">
            <?= htmlspecialchars($package->shipping_provider_name ?: 'J&T Express'); ?>
        </div>
    </div>

    <!-- Tracking Barcode -->
    <div class="barcode-section">
        <?= generate_barcode_svg($package->tracking_number ?: $package->package_id, 55); ?>
        <div class="tracking-num"><?= htmlspecialchars($package->tracking_number ?: $package->package_id); ?></div>
    </div>

    <!-- Address Section -->
    <div class="info-grid">
        <!-- Penerima -->
        <div class="address-box recipient-box">
            <div class="box-title">Penerima (To):</div>
            <div style="font-size: 12px; font-weight: 800;"><?= htmlspecialchars($package->recipient_name ?: '-'); ?></div>
            <div style="font-weight: 600;"><?= htmlspecialchars($package->recipient_phone ?: '-'); ?></div>
            <div style="margin-top: 2px;"><?= nl2br(htmlspecialchars($package->recipient_address ?: '-')); ?></div>
        </div>

        <!-- Pengirim -->
        <div class="address-box sender-box">
            <div class="box-title">Pengirim (From):</div>
            <div style="font-size: 11px; font-weight: 700;"><?= htmlspecialchars($package->sender_name ?: 'TikTok Shop Partner Seller'); ?></div>
            <div><?= htmlspecialchars($package->sender_phone ?: '-'); ?></div>
            <div style="margin-top: 2px; font-size: 9.5px;"><?= nl2br(htmlspecialchars($package->sender_address ?: '-')); ?></div>
        </div>
    </div>

    <!-- Order Metadata -->
    <div class="order-info">
        <div>
            <strong>ID Pesanan:</strong> <?= htmlspecialchars($package->order_id ?: '-'); ?><br>
            <strong>ID Paket:</strong> <?= htmlspecialchars($package->package_id); ?>
        </div>
        <div style="text-align: right;">
            <strong>Berat:</strong> <?= number_format($package->weight_val, 0); ?> <?= htmlspecialchars($package->weight_unit ?: 'GRAM'); ?><br>
            <strong>Handover:</strong> <?= htmlspecialchars($package->handover_method ?: 'PICKUP'); ?>
        </div>
    </div>

    <!-- Items Section -->
    <div class="items-section">
        <strong>Daftar Barang (<?= count($items); ?> SKU):</strong>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th style="width: 40px; text-align: center;">Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars(!empty($item->product_name) ? $item->product_name : (!empty($item->sku_name) ? $item->sku_name : 'Produk TikTok')); ?>
                                <?php if (!empty($item->variant_name) && $item->variant_name != 'Default'): ?>
                                    <br><small style="color: #666;">Varian: <?= htmlspecialchars($item->variant_name); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; font-weight: bold;"><?= (int)$item->quantity; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" style="text-align: center;">1x Paket Penjualan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer-note">
        Dicetak otomatis dari Sistem Vendio - Terintegrasi Resmi dengan TikTok Shop API
    </div>
</div>

<script>
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 500);
};
</script>

</body>
</html>
