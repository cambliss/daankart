DROP TABLE IF EXISTS `daan_campaigns`;
CREATE TABLE `daan_campaigns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `campaigner_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `beneficiary_type` varchar(100) DEFAULT NULL,
  `beneficiary_name` varchar(255) DEFAULT NULL,
  `beneficiary_mobile` varchar(255) DEFAULT NULL,
  `beneficiary_location` varchar(255) DEFAULT NULL,
  `campaign_title` varchar(255) NOT NULL,
  `campaign_description` text,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Completed') DEFAULT 'Active',
  `tab` enum('1','2','3','4','5') DEFAULT NULL,
  `is_kyc_varified` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `daan_campaigns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `daan_campaigns_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
);


DROP TABLE IF EXISTS `daan_products`;
CREATE TABLE `daan_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `required_quantity` int NOT NULL,
  `sold_quantity` int NOT NULL DEFAULT '0',
  `remaining_quantity` int GENERATED ALWAYS AS ((`required_quantity` - `sold_quantity`)) STORED,
  `price_per_unit` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) GENERATED ALWAYS AS ((`required_quantity` * `price_per_unit`)) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`),
  CONSTRAINT `daan_products_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `daan_campaigns` (`id`) ON DELETE CASCADE
);


DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint unsigned NOT NULL,
  `targetable_id` bigint unsigned NOT NULL,
  `targetable_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_ext` varchar(50) NOT NULL,
  `file_size` bigint unsigned NOT NULL,
  `uploaded_by` bigint unsigned NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `expiry_date` date DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
