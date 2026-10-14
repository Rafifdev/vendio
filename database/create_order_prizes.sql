-- Order Prizes v1. MySQL 5.7+/MariaDB 10.2+, InnoDB required.
-- Apply once before enabling the module. No live marketplace data is modified.
CREATE TABLE IF NOT EXISTS order_prize_campaigns (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 slug VARCHAR(80) CHARACTER SET ascii COLLATE ascii_bin NOT NULL UNIQUE,
 name VARCHAR(160) NOT NULL,
 channel VARCHAR(20) NOT NULL DEFAULT 'shopee',
 shop_ref VARCHAR(80) NOT NULL,
 status VARCHAR(12) NOT NULL DEFAULT 'draft',
 starts_at DATETIME NOT NULL,
 ends_at DATETIME NOT NULL,
 claim_days INT UNSIGNED NOT NULL DEFAULT 7,
 budget_profit_percent INT UNSIGNED DEFAULT NULL,
 terms TEXT NOT NULL,
 spin_count BIGINT UNSIGNED NOT NULL DEFAULT 0,
 revenue_total BIGINT UNSIGNED NOT NULL DEFAULT 0,
 profit_total BIGINT NOT NULL DEFAULT 0,
 awarded_cost BIGINT UNSIGNED NOT NULL DEFAULT 0,
 created_at DATETIME NOT NULL,
 updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_items (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 campaign_id INT UNSIGNED NOT NULL,
 name VARCHAR(160) NOT NULL,
 description TEXT NOT NULL,
 kind VARCHAR(16) NOT NULL DEFAULT 'physical',
 active TINYINT UNSIGNED NOT NULL DEFAULT 1,
 weight INT UNSIGNED NOT NULL DEFAULT 1,
 stock INT UNSIGNED DEFAULT NULL COMMENT 'NULL means unlimited; remaining stock',
 cost BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Whole IDR, internal cost',
 threshold_spins BIGINT UNSIGNED NOT NULL DEFAULT 0,
 threshold_revenue BIGINT UNSIGNED NOT NULL DEFAULT 0,
 threshold_profit BIGINT UNSIGNED NOT NULL DEFAULT 0,
 auto_metric VARCHAR(12) NOT NULL DEFAULT 'none',
 allocation_percent INT UNSIGNED NOT NULL DEFAULT 10,
 awarded_count BIGINT UNSIGNED NOT NULL DEFAULT 0,
 created_at DATETIME NOT NULL,
 updated_at DATETIME NOT NULL,
 KEY campaign_active (campaign_id, active),
 FOREIGN KEY (campaign_id) REFERENCES order_prize_campaigns(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_orders (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 campaign_id INT UNSIGNED NOT NULL,
 channel VARCHAR(20) NOT NULL,
 shop_ref VARCHAR(80) NOT NULL,
 order_number VARCHAR(80) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
 phone VARCHAR(20) CHARACTER SET ascii NOT NULL,
 status VARCHAR(16) NOT NULL DEFAULT 'completed',
 revenue BIGINT UNSIGNED NOT NULL,
 profit BIGINT DEFAULT NULL COMMENT 'NULL = unknown; contributes zero, never estimated',
 ordered_at DATETIME NOT NULL,
 source VARCHAR(20) NOT NULL DEFAULT 'manual',
 created_at DATETIME NOT NULL,
 updated_at DATETIME NOT NULL,
 UNIQUE KEY marketplace_order (channel, shop_ref, order_number),
 KEY campaign_status (campaign_id, status),
 FOREIGN KEY (campaign_id) REFERENCES order_prize_campaigns(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_tokens (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_id INT UNSIGNED NOT NULL UNIQUE,
 token_hash CHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL UNIQUE,
 expires_at DATETIME NOT NULL,
 marketing_consent TINYINT UNSIGNED NOT NULL DEFAULT 0,
 consent_at DATETIME DEFAULT NULL,
 created_at DATETIME NOT NULL,
 FOREIGN KEY (order_id) REFERENCES order_prize_orders(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_spins (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 campaign_id INT UNSIGNED NOT NULL,
 order_id INT UNSIGNED NOT NULL UNIQUE,
 token_id INT UNSIGNED NOT NULL UNIQUE,
 prize_id INT UNSIGNED NOT NULL,
 order_number VARCHAR(80) NOT NULL,
 phone VARCHAR(20) NOT NULL,
 prize_name VARCHAR(160) NOT NULL,
 prize_kind VARCHAR(16) NOT NULL,
 prize_cost BIGINT UNSIGNED NOT NULL,
 spin_type VARCHAR(16) NOT NULL DEFAULT 'order',
 claim_status VARCHAR(16) NOT NULL DEFAULT 'pending',
 prize_status VARCHAR(16) NOT NULL DEFAULT 'reserved',
 follow_up_status VARCHAR(16) NOT NULL DEFAULT 'pending',
 broadcast_status VARCHAR(16) NOT NULL DEFAULT 'not_sent',
 marketing_consent TINYINT UNSIGNED NOT NULL DEFAULT 0,
 notes TEXT NOT NULL,
 decision_json MEDIUMTEXT NOT NULL,
 spun_at DATETIME NOT NULL,
 claim_deadline DATETIME NOT NULL,
 claimed_at DATETIME DEFAULT NULL,
 updated_at DATETIME NOT NULL,
 KEY campaign_time (campaign_id, spun_at),
 KEY workflow (claim_status, follow_up_status, broadcast_status),
 FOREIGN KEY (campaign_id) REFERENCES order_prize_campaigns(id),
 FOREIGN KEY (order_id) REFERENCES order_prize_orders(id),
 FOREIGN KEY (token_id) REFERENCES order_prize_tokens(id),
 FOREIGN KEY (prize_id) REFERENCES order_prize_items(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_audit (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 actor_id INT UNSIGNED DEFAULT NULL,
 action VARCHAR(48) NOT NULL,
 entity VARCHAR(20) NOT NULL,
 entity_id INT UNSIGNED NOT NULL,
 detail_json MEDIUMTEXT NOT NULL,
 created_at DATETIME NOT NULL,
 KEY entity_history (entity, entity_id, id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS order_prize_rate_limits (
 bucket CHAR(64) CHARACTER SET ascii COLLATE ascii_bin PRIMARY KEY,
 hits INT UNSIGNED NOT NULL,
 expires_at DATETIME NOT NULL,
 KEY expiry (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Permissions are intentionally NOT granted to every group.
INSERT INTO aauth_perms (name, definition)
SELECT 'menu_order_prizes', 'Show the Order Prizes menu'
WHERE NOT EXISTS (SELECT 1 FROM aauth_perms WHERE name = 'menu_order_prizes');
INSERT INTO aauth_perms (name, definition)
SELECT 'order_prizes_view', 'View Order Prizes, customer PII and audit log'
WHERE NOT EXISTS (SELECT 1 FROM aauth_perms WHERE name = 'order_prizes_view');
INSERT INTO aauth_perms (name, definition)
SELECT 'order_prizes_manage', 'Manage campaigns, prizes and trusted order imports'
WHERE NOT EXISTS (SELECT 1 FROM aauth_perms WHERE name = 'order_prizes_manage');
INSERT INTO aauth_perms (name, definition)
SELECT 'order_prizes_fulfill', 'Update claims, fulfillment and follow-up'
WHERE NOT EXISTS (SELECT 1 FROM aauth_perms WHERE name = 'order_prizes_fulfill');
INSERT INTO menu (label, type, icon_color, link, sort, parent, icon, menu_type_id, active)
SELECT 'Order Prizes', 'menu', 'default', '{admin_url}/order_prizes', 30, 0, 'fa-gift', 1, 1
WHERE NOT EXISTS (SELECT 1 FROM menu WHERE link = '{admin_url}/order_prizes');
