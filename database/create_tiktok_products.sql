-- Tabel Utama Produk TikTok
CREATE TABLE IF NOT EXISTS `tiktok_products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tiktok_shop_id` INT UNSIGNED DEFAULT NULL COMMENT 'Relasi ke tabel tiktok_shops',
  `product_id` VARCHAR(100) NOT NULL COMMENT 'Product ID resmi dari TikTok Shop',
  `title` VARCHAR(255) NOT NULL COMMENT 'Judul / Nama Produk',
  `main_image` TEXT DEFAULT NULL COMMENT 'URL Gambar Utama Produk',
  `status` VARCHAR(50) DEFAULT 'LIVE' COMMENT 'Status: LIVE, DRAFT, FAILED, SELLER_DEACTIVATED, PLATFORM_DEACTIVATED, FREEZE, DELETED',
  `category_name` VARCHAR(255) DEFAULT NULL COMMENT 'Kategori Produk',
  `brand_name` VARCHAR(100) DEFAULT NULL COMMENT 'Brand Produk',
  `seller_sku` VARCHAR(100) DEFAULT NULL COMMENT 'SKU Induk / Seller SKU',
  `price` DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Harga Produk',
  `currency` VARCHAR(10) DEFAULT 'IDR' COMMENT 'Mata Uang',
  `total_stock` INT DEFAULT 0 COMMENT 'Total Stok Tersedia',
  `package_weight` VARCHAR(50) DEFAULT NULL COMMENT 'Berat Paket (kg)',
  `description` TEXT DEFAULT NULL COMMENT 'Deskripsi Produk (HTML)',
  `raw_data` LONGTEXT DEFAULT NULL COMMENT 'JSON payload lengkap dari TikTok API',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_product_id` (`product_id`),
  KEY `idx_tiktok_shop_id` (`tiktok_shop_id`),
  KEY `idx_status` (`status`),
  KEY `idx_seller_sku` (`seller_sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Varian SKU Produk TikTok (untuk multi-varian dan sync stok/harga)
CREATE TABLE IF NOT EXISTS `tiktok_product_skus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tiktok_product_id` INT UNSIGNED DEFAULT NULL COMMENT 'Relasi ke tabel tiktok_products',
  `product_id` VARCHAR(100) NOT NULL COMMENT 'Product ID TikTok',
  `sku_id` VARCHAR(100) NOT NULL COMMENT 'SKU ID unik TikTok untuk update stok/harga',
  `seller_sku` VARCHAR(100) DEFAULT NULL COMMENT 'Kode SKU Varian',
  `sku_name` VARCHAR(255) DEFAULT NULL COMMENT 'Nama Varian (contoh: Merah, XL)',
  `price` DECIMAL(15,2) DEFAULT 0.00 COMMENT 'Harga Varian',
  `currency` VARCHAR(10) DEFAULT 'IDR' COMMENT 'Mata Uang',
  `stock` INT DEFAULT 0 COMMENT 'Jumlah Stok',
  `warehouse_id` VARCHAR(100) DEFAULT NULL COMMENT 'Warehouse ID TikTok',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_sku_id` (`sku_id`),
  KEY `idx_tiktok_product_id` (`tiktok_product_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_seller_sku` (`seller_sku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
