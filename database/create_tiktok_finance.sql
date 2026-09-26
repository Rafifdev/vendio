-- =========================================================================
-- Tabel Modul Keuangan & Retur TikTok (Developer 3: Finance, Returns & Analytics)
-- =========================================================================

-- 1. Tabel Rekap Pencairan Dana (Settlement Statements)
CREATE TABLE IF NOT EXISTS `tiktok_finance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tiktok_shop_id` INT(11) DEFAULT NULL COMMENT 'Relasi ke tabel tiktok_shops.id',
  `statement_id` VARCHAR(64) NOT NULL COMMENT 'ID Statement unik dari TikTok Shop',
  `statement_time` DATETIME DEFAULT NULL COMMENT 'Waktu / Periode Statement',
  `payout_id` VARCHAR(64) DEFAULT NULL COMMENT 'ID Transaksi Pencairan ke Rekening Bank',
  `payment_status` VARCHAR(50) NOT NULL DEFAULT 'PAID' COMMENT 'Status Pembayaran: PAID, PROCESSING, FAILED, PENDING',
  `settlement_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total Dana Bersih yang Diterima/Dicairkan',
  `revenue_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Penjualan / Omzet Kotor',
  `shipping_fee_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Biaya Pengiriman',
  `fee_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Potongan Komisi / Biaya Platform TikTok',
  `adjustment_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Penyesuaian / Adjustment',
  `currency` VARCHAR(10) NOT NULL DEFAULT 'IDR' COMMENT 'Mata Uang (IDR, USD, dll)',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_statement_id` (`statement_id`),
  KEY `idx_tiktok_shop_id` (`tiktok_shop_id`),
  KEY `idx_statement_time` (`statement_time`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_payout_id` (`payout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Retur / Komplain Pelanggan (Returns & Refunds)
CREATE TABLE IF NOT EXISTS `tiktok_returns` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tiktok_shop_id` INT(11) DEFAULT NULL COMMENT 'Relasi ke tabel tiktok_shops.id',
  `return_id` VARCHAR(64) NOT NULL COMMENT 'ID Retur / Refund unik dari TikTok',
  `order_id` VARCHAR(64) NOT NULL COMMENT 'ID Pesanan yang diretur',
  `return_type` VARCHAR(50) NOT NULL DEFAULT 'REFUND' COMMENT 'Tipe: REFUND (Pengembalian Dana) atau RETURN_AND_REFUND (Kembali Barang & Dana)',
  `return_status` VARCHAR(50) NOT NULL DEFAULT 'PROCESSING' COMMENT 'Status: PROCESSING, APPROVED, REJECTED, COMPLETED, CANCELLED',
  `return_reason` TEXT DEFAULT NULL COMMENT 'Alasan pengajuan retur/komplain dari pembeli',
  `refund_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Nominal dana yang dikembalikan',
  `tracking_number` VARCHAR(100) DEFAULT NULL COMMENT 'Nomor resi pengembalian barang dari pembeli',
  `return_created_time` DATETIME DEFAULT NULL COMMENT 'Waktu pengajuan retur dibuat di TikTok',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_return_id` (`return_id`),
  KEY `idx_tiktok_shop_id` (`tiktok_shop_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_return_status` (`return_status`),
  KEY `idx_return_created_time` (`return_created_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
