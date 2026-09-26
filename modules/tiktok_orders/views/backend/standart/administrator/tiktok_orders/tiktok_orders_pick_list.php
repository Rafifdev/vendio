<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Daftar Pengambilan Barang (Pick List)'; ?></title>
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>/admin-lte/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_ASSET; ?>/font-awesome/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .picklist-container {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        .header-section {
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .header-title {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .meta-box {
            background: #fafafa;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .table-picklist {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table-picklist th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 8px 10px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .table-picklist td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 13px;
            vertical-align: middle;
        }
        .check-box-square {
            width: 20px;
            height: 20px;
            border: 2px solid #333;
            display: inline-block;
            border-radius: 3px;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .sig-box {
            width: 45%;
            text-align: center;
        }
        .sig-line {
            border-bottom: 1px solid #333;
            height: 60px;
            margin-bottom: 5px;
        }
        .action-bar {
            margin-bottom: 15px;
            text-align: right;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .picklist-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .action-bar {
                display: none !important;
            }
            .table-picklist th {
                background-color: #eee !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div class="picklist-container">
    <div class="action-bar">
        <button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Dokumen</button>
        <button onclick="window.close()" class="btn btn-default btn-sm"><i class="fa fa-times"></i> Tutup</button>
    </div>

    <div class="header-section">
        <div class="row">
            <div class="col-xs-8">
                <h1 class="header-title"><i class="fa fa-clipboard"></i> DAFTAR PENGAMBILAN BARANG (PICK LIST)</h1>
                <small class="text-muted">Gudang / Order Fulfillment TikTok Shop</small>
            </div>
            <div class="col-xs-4 text-right">
                <strong>Tanggal Cetak:</strong><br>
                <span><?= date('d/m/Y H:i'); ?></span>
            </div>
        </div>
    </div>

    <?php if (!empty($is_bulk)): ?>
        <!-- Mode Rekap / Bulk Pick List -->
        <div class="meta-box">
            <div class="row">
                <div class="col-xs-6">
                    <strong>Tipe:</strong> Rekap Pengambilan Massal (Batch Picking)<br>
                    <strong>Total Pesanan:</strong> <?= count($orders); ?> Pesanan
                </div>
                <div class="col-xs-6 text-right">
                    <strong>Daftar No. Pesanan:</strong><br>
                    <small><?= implode(', ', array_column($orders, 'order_id')); ?></small>
                </div>
            </div>
        </div>

        <h4 style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">REKAP PRODUK YANG HARUS DIAMBIL:</h4>
        <table class="table-picklist">
            <thead>
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th width="60" class="text-center">Foto</th>
                    <th width="120">SKU / Kode</th>
                    <th>Nama Produk & Varian</th>
                    <th width="80" class="text-center">Total Qty</th>
                    <th width="60" class="text-center">Ambil</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($aggregated_items as $item): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center">
                            <?php if (!empty($item['sku_image'])): ?>
                                <img src="<?= $item['sku_image']; ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 3px;" alt="item">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><strong><?= _ent($item['seller_sku'] ?: '-'); ?></strong></td>
                        <td>
                            <?= _ent($item['product_name']); ?>
                            <?php if (!empty($item['sku_name']) && $item['sku_name'] != 'Default'): ?>
                                <br><small class="text-muted">Varian: <?= _ent($item['sku_name']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="font-size: 15px; font-weight: bold;"><?= $item['total_quantity']; ?></td>
                        <td class="text-center"><span class="check-box-square"></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <!-- Mode Single Order Pick List -->
        <?php $order = $orders[0]; ?>
        <div class="meta-box">
            <div class="row">
                <div class="col-xs-6">
                    <strong>No. Pesanan:</strong> #<?= _ent($order->order_id); ?><br>
                    <strong>Toko:</strong> <?= _ent($shop_name ?? 'TikTok Shop'); ?><br>
                    <strong>Status:</strong> <?= _ent($order->order_status); ?>
                </div>
                <div class="col-xs-6 text-right">
                    <strong>Kurir:</strong> <?= _ent($order->shipping_provider ?: '-'); ?><br>
                    <strong>No. Resi:</strong> <?= _ent($order->tracking_number ?: '-'); ?><br>
                    <strong>Pembeli:</strong> <?= _ent($order->recipient_name ?: '-'); ?>
                </div>
            </div>
            <?php if (!empty($order->buyer_message)): ?>
                <div style="margin-top: 8px; border-top: 1px dashed #ddd; padding-top: 6px;">
                    <strong>Catatan Pembeli:</strong> <em>"<?= _ent($order->buyer_message); ?>"</em>
                </div>
            <?php endif; ?>
        </div>

        <h4 style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">DAFTAR BARANG YANG DIAMBIL:</h4>
        <table class="table-picklist">
            <thead>
                <tr>
                    <th width="40" class="text-center">No</th>
                    <th width="60" class="text-center">Foto</th>
                    <th width="130">SKU / Kode</th>
                    <th>Nama Produk & Varian</th>
                    <th width="70" class="text-center">Jumlah</th>
                    <th width="60" class="text-center">Cek</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($order->items as $item): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center">
                            <?php if (!empty($item->sku_image)): ?>
                                <img src="<?= $item->sku_image; ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 3px;" alt="item">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><strong><?= _ent($item->seller_sku ?: '-'); ?></strong></td>
                        <td>
                            <?= _ent($item->product_name); ?>
                            <?php if (!empty($item->sku_name) && $item->sku_name != 'Default'): ?>
                                <br><small class="text-muted">Varian: <?= _ent($item->sku_name); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="font-size: 15px; font-weight: bold;"><?= $item->quantity; ?></td>
                        <td class="text-center"><span class="check-box-square"></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="signature-section row">
        <div class="col-xs-6 text-center">
            <div class="sig-line"></div>
            <strong>Petugas Pengambil (Picker)</strong>
        </div>
        <div class="col-xs-6 text-center">
            <div class="sig-line"></div>
            <strong>Pemeriksa Kemasan (Packer / Checker)</strong>
        </div>
    </div>
</div>

</body>
</html>
