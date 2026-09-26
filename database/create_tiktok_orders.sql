-- =========================================================================
-- Tabel Modul Pesanan TikTok (Developer 2: Orders & Fulfillment)
-- =========================================================================

CREATE TABLE IF NOT EXISTS `tiktok_orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tiktok_shop_id` INT(11) DEFAULT NULL COMMENT 'Relasi ke tabel tiktok_shops.id',
  `order_id` VARCHAR(64) NOT NULL COMMENT 'ID Pesanan unik dari TikTok',
  `order_status` VARCHAR(50) NOT NULL DEFAULT 'UNPAID' COMMENT 'Status: UNPAID, AWAITING_SHIPMENT, AWAITING_COLLECTION, IN_TRANSIT, DELIVERED, COMPLETED, CANCELLED',
  `payment_method_name` VARCHAR(100) DEFAULT NULL COMMENT 'Metode Pembayaran (COD, Bank Transfer, dll)',
  `buyer_message` TEXT DEFAULT NULL COMMENT 'Pesan / Catatan dari pembeli',
  `cancel_reason` TEXT DEFAULT NULL COMMENT 'Alasan pembatalan jika pesanan dibatalkan',
  `recipient_name` VARCHAR(255) DEFAULT NULL COMMENT 'Nama penerima paket',
  `recipient_phone` VARCHAR(50) DEFAULT NULL COMMENT 'Nomor telepon penerima',
  `recipient_address` TEXT DEFAULT NULL COMMENT 'Alamat lengkap pengiriman',
  `shipping_provider` VARCHAR(100) DEFAULT NULL COMMENT 'Jasa ekspedisi / kurir (J&T, SiCepat, Ninja, dll)',
  `shipping_type` VARCHAR(50) DEFAULT NULL COMMENT 'Metode Pengiriman (TIKTOK atau SELLER)',
  `delivery_option_name` VARCHAR(100) DEFAULT NULL COMMENT 'Opsi Pengiriman (Standard, Express, dll)',
  `tracking_number` VARCHAR(100) DEFAULT NULL COMMENT 'Nomor resi pengiriman / AWB',
  `package_id` VARCHAR(64) DEFAULT NULL COMMENT 'ID Paket dari TikTok untuk shipping label/AWB',
  `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total nominal pembayaran pesanan',
  `shipping_fee` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Biaya ongkos kirim',
  `seller_discount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Potongan diskon dari penjual',
  `tiktok_discount` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Subsidi diskon dari platform TikTok',
  `order_created_time` DATETIME DEFAULT NULL COMMENT 'Waktu pesanan dibuat di TikTok',
  `order_paid_time` DATETIME DEFAULT NULL COMMENT 'Waktu pesanan dibayar',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_id` (`order_id`),
  KEY `idx_tiktok_shop_id` (`tiktok_shop_id`),
  KEY `idx_order_status` (`order_status`),
  KEY `idx_order_created_time` (`order_created_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tiktok_order_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tiktok_order_id` INT(11) NOT NULL COMMENT 'Relasi ke tiktok_orders.id',
  `order_id` VARCHAR(64) NOT NULL COMMENT 'ID Pesanan TikTok',
  `order_line_id` VARCHAR(64) DEFAULT NULL COMMENT 'ID baris item TikTok',
  `product_id` VARCHAR(64) DEFAULT NULL COMMENT 'ID Produk TikTok',
  `product_name` VARCHAR(255) DEFAULT NULL COMMENT 'Nama Produk',
  `sku_id` VARCHAR(64) DEFAULT NULL COMMENT 'ID SKU varian TikTok',
  `sku_name` VARCHAR(255) DEFAULT NULL COMMENT 'Nama varian produk (Warna, Ukuran, dll)',
  `seller_sku` VARCHAR(100) DEFAULT NULL COMMENT 'Kode SKU penjual',
  `quantity` INT(11) NOT NULL DEFAULT 1 COMMENT 'Jumlah kuantitas item yang dibeli',
  `item_price` DECIMAL(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Harga satuan item',
  `sku_image` VARCHAR(255) DEFAULT NULL COMMENT 'URL / Nama file gambar item',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tiktok_order_id` (`tiktok_order_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
