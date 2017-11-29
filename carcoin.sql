/*
Navicat MySQL Data Transfer

Source Server         :  localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : carcoin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-28 16:58:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bonus_binary
-- ----------------------------
DROP TABLE IF EXISTS `bonus_binary`;
CREATE TABLE `bonus_binary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `weeked` int(10) NOT NULL,
  `year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT '0',
  `rightOpen` double DEFAULT '0',
  `settled` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `bonus_tmp` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`,`weeked`,`userId`),
  UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for bonus_binary_interest
-- ----------------------------
DROP TABLE IF EXISTS `bonus_binary_interest`;
CREATE TABLE `bonus_binary_interest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT '0',
  `rightOpen` double DEFAULT '0',
  `bonus` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for bonus_faststart
-- ----------------------------
DROP TABLE IF EXISTS `bonus_faststart`;
CREATE TABLE `bonus_faststart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `generation` smallint(6) NOT NULL,
  `partnerId` int(10) NOT NULL,
  `packageId` int(10) NOT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`,`partnerId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for clp_api_logs
-- ----------------------------
DROP TABLE IF EXISTS `clp_api_logs`;
CREATE TABLE `clp_api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `error_msg` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for clp_notification
-- ----------------------------
DROP TABLE IF EXISTS `clp_notification`;
CREATE TABLE `clp_notification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `transaction_hash` varchar(255) DEFAULT NULL,
  `completed_status` tinyint(1) DEFAULT NULL,
  `pending_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for clp_wallets
-- ----------------------------
DROP TABLE IF EXISTS `clp_wallets`;
CREATE TABLE `clp_wallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for cron_binary_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_binary_logs`;
CREATE TABLE `cron_binary_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cron_leadership_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_leadership_logs`;
CREATE TABLE `cron_leadership_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cron_matching_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_matching_logs`;
CREATE TABLE `cron_matching_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cron_profit_day_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_profit_day_logs`;
CREATE TABLE `cron_profit_day_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for exchange_rates
-- ----------------------------
DROP TABLE IF EXISTS `exchange_rates`;
CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_currency` char(30) NOT NULL,
  `exchrate` double NOT NULL,
  `to_currency` char(30) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of exchange_rates
-- ----------------------------
INSERT INTO `exchange_rates` VALUES ('1', 'clp', '1', 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);
INSERT INTO `exchange_rates` VALUES ('2', 'btc', '4210', 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);
INSERT INTO `exchange_rates` VALUES ('3', 'clp', '0.00023809524', 'btc', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);

-- ----------------------------
-- Table structure for order_lists
-- ----------------------------
DROP TABLE IF EXISTS `order_lists`;
CREATE TABLE `order_lists`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NOT NULL,
  `deleted_at` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci;

-- ----------------------------
-- Table structure for price_order_list
-- ----------------------------
DROP TABLE IF EXISTS `price_order_list`;
CREATE TABLE `price_order_list`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` timestamp NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci;


-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES ('1', '1', 'App\\User');

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', '1', 'App\\User');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` smallint(6) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `public_at` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `views` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for notification
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `completed_status` tinyint(1) DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `min_price` int(10) NOT NULL,
  `max_price` int(10) NOT NULL,
  `capital_release` int(10) NOT NULL,
  `bonus` float DEFAULT '0',
  `pack_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `pack_id` (`pack_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES ('1', 'TINY', '2017-08-16 07:06:07', '2017-09-18 04:14:07', '200', '1000', '299', '0', '1');
INSERT INTO `packages` VALUES ('2', 'SMALL', '2017-08-16 07:06:35', '2017-09-18 04:14:46', '1010', '10000', '239', '0.001', '2');
INSERT INTO `packages` VALUES ('3', 'MEDIUM', '2017-08-16 07:58:33', '2017-09-18 04:14:33', '10010', '50000', '179', '0.0015', '3');
INSERT INTO `packages` VALUES ('4', 'LARGE', '2017-08-16 07:58:22', '2017-08-16 07:58:22', '50010', '100000', '120', '0.002', '4');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'view_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('2', 'add_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('3', 'edit_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('4', 'delete_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('5', 'view_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('6', 'add_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('7', 'edit_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('8', 'delete_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('21', 'view_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('22', 'add_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('23', 'edit_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('24', 'delete_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('25', 'view_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES ('26', 'add_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES ('27', 'edit_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES ('28', 'delete_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES ('29', 'view_admins', 'web', '2017-11-28 10:50:58', '2017-11-28 10:50:58');
INSERT INTO `permissions` VALUES ('30', 'add_admins', 'web', '2017-11-28 10:50:58', '2017-11-28 10:50:58');
INSERT INTO `permissions` VALUES ('31', 'edit_admins', 'web', '2017-11-28 10:50:58', '2017-11-28 10:50:58');
INSERT INTO `permissions` VALUES ('32', 'delete_admins', 'web', '2017-11-28 10:50:58', '2017-11-28 10:50:58');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Admin', 'web', '2017-09-05 08:55:03', '2017-09-05 08:55:03');
INSERT INTO `roles` VALUES ('2', 'User', 'web', '2017-09-05 08:55:04', '2017-09-05 08:55:04');
INSERT INTO `roles` VALUES ('3', 'view_abc', 'web', '2017-09-05 09:00:15', '2017-09-05 09:00:15');
INSERT INTO `roles` VALUES ('4', 'Member', 'web', '2017-09-08 05:01:29', '2017-09-08 05:01:29');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('3', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('5', '1');
INSERT INTO `role_has_permissions` VALUES ('6', '1');
INSERT INTO `role_has_permissions` VALUES ('7', '1');
INSERT INTO `role_has_permissions` VALUES ('8', '1');
INSERT INTO `role_has_permissions` VALUES ('21', '1');
INSERT INTO `role_has_permissions` VALUES ('22', '1');
INSERT INTO `role_has_permissions` VALUES ('23', '1');
INSERT INTO `role_has_permissions` VALUES ('24', '1');
INSERT INTO `role_has_permissions` VALUES ('25', '1');
INSERT INTO `role_has_permissions` VALUES ('26', '1');
INSERT INTO `role_has_permissions` VALUES ('27', '1');
INSERT INTO `role_has_permissions` VALUES ('28', '1');
INSERT INTO `role_has_permissions` VALUES ('29', '1');
INSERT INTO `role_has_permissions` VALUES ('30', '1');
INSERT INTO `role_has_permissions` VALUES ('31', '1');
INSERT INTO `role_has_permissions` VALUES ('32', '1');

-- ----------------------------
-- Table structure for total_week_sales
-- ----------------------------
DROP TABLE IF EXISTS `total_week_sales`;
CREATE TABLE `total_week_sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `total_interest` double DEFAULT NULL,
  `weekYear` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`,`userId`),
  UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is2fa` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `photo_verification` text COLLATE utf8mb4_unicode_ci,
  `approve` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'henry@cryptolending.org', '$2y$10$vYajYOev0ia64tzJpdmWgu5hVA2aROKElGKrCcWBv6pIQSmm309Fy', '9j1mwxyMShYTbeKCgqXcvhi2E9P8NnAQlj6Viai5GWm6h2IBgDJVZfppL5WY', '2017-08-12 05:47:39', '2017-09-15 08:22:03', '1', 'Henry', 'Ford', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '', 'Profile', null, null, null, '41', null, null, null, null, '1', '1');
INSERT INTO `users` VALUES ('2', 'root', 'giangitman@gmail.com', '$2y$10$vYajYOev0ia64tzJpdmWgu5hVA2aROKElGKrCcWBv6pIQSmm309Fy', 'Z5JdC5ajn3QfWz5TH2BXkx9SV2szgFXLtyM1n7MLrvc3vEjFVmZjMDgW9YcC', '2017-10-05 17:42:21', '2017-10-05 17:42:43', '1', 'root', 'Giang', '0978708981', '0', null, '2NZOY6TF4MLVJH2V', '1', null, null, null, null, null, '41', null, null, null, '99', '1', '1');

-- ----------------------------
-- Table structure for users_loyalty
-- ----------------------------
DROP TABLE IF EXISTS `users_loyalty`;
CREATE TABLE `users_loyalty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `isSilver` tinyint(1) DEFAULT '0',
  `isGold` tinyint(1) DEFAULT '0',
  `isPear` tinyint(1) DEFAULT '0',
  `isEmerald` tinyint(1) DEFAULT '0',
  `isDiamond` tinyint(1) DEFAULT '0',
  `f1Left` int(10) DEFAULT '0',
  `f1Right` int(10) DEFAULT '0',
  `collectSilver` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`userId`),
  KEY `userId` (`userId`),
  KEY `isSilver` (`isSilver`),
  KEY `isGold` (`isGold`),
  KEY `isPear` (`isPear`),
  KEY `isEmerald` (`isEmerald`),
  KEY `isDiamond` (`isDiamond`),
  KEY `refererId` (`refererId`),
  KEY `leftRight` (`leftRight`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for user_coins
-- ----------------------------
DROP TABLE IF EXISTS `user_coins`;
CREATE TABLE `user_coins` (
  `userId` int(10) unsigned NOT NULL,
  `walletAddress` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountCoinBase` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btcCoinAmount` double DEFAULT '0',
  `clpCoinAmount` double DEFAULT '0',
  `usdAmount` double DEFAULT '0',
  `reinvestAmount` double DEFAULT '0',
  `backupKey` text COLLATE utf8mb4_unicode_ci,
  `availableAmount` double DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES ('1', 'admin', 'admin', '0', '0', '0', '0', null, '0', '2017-08-12 05:47:39', '2017-08-12 05:47:39');
INSERT INTO `user_coins` VALUES ('2', 'root', 'root', '0', '0', '0', '0', null, '0', '2017-08-12 05:47:39', '2017-08-12 05:47:39');

-- ----------------------------
-- Table structure for user_datas
-- ----------------------------
DROP TABLE IF EXISTS `user_datas`;
CREATE TABLE `user_datas` (
  `userId` int(10) unsigned NOT NULL,
  `refererId` int(10) DEFAULT '0',
  `packageId` smallint(6) DEFAULT '0',
  `packageDate` timestamp NULL DEFAULT NULL,
  `totalBonus` double DEFAULT '0',
  `isBinary` tinyint(1) DEFAULT '0',
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalSaleLeft` double DEFAULT '0',
  `totalSaleRight` double DEFAULT '0',
  `saleGenLeft` double DEFAULT NULL,
  `saleGenRight` double DEFAULT NULL,
  `binaryUserId` int(10) DEFAULT '0',
  `lastUserIdLeft` int(10) DEFAULT '0',
  `lastUserIdRight` int(10) DEFAULT '0',
  `leftMembers` int(10) DEFAULT '0',
  `rightMembers` int(10) DEFAULT '0',
  `totalMembers` int(10) DEFAULT '0',
  `loyaltyId` tinyint(2) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `userId` (`userId`),
  KEY `referrerId` (`refererId`),
  KEY `packageId` (`packageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_datas
-- ----------------------------
INSERT INTO `user_datas` VALUES ('1', '0', '0', null, '0', '0', null, '0', '0', null, null, '0', '0', '0', '0', '0', '0', '0', '1', '2017-08-12 05:47:39', '2017-08-12 05:47:39');
INSERT INTO `user_datas` VALUES ('2', '0', '6', null, '0', '1', null, '0', '0', '0', '0', '0', '10', '8', '3', '2', '5', '0', '1', '2017-08-12 05:47:39', '2017-08-12 05:47:39');

-- Table structure for user_packages
-- ----------------------------
DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `packageId` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount_increase` int(10) NOT NULL,
  `buy_date` timestamp NULL DEFAULT NULL,
  `release_date` timestamp NULL DEFAULT NULL,
  `withdraw` tinyint(1) DEFAULT '0',
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for user_tree_permissions
-- ----------------------------
DROP TABLE IF EXISTS `user_tree_permissions`;
CREATE TABLE `user_tree_permissions` (
  `userId` int(10) unsigned NOT NULL,
  `binary` text COLLATE utf8mb4_unicode_ci,
  `genealogy` text COLLATE utf8mb4_unicode_ci,
  `binary_left` text COLLATE utf8mb4_unicode_ci,
  `binary_right` text COLLATE utf8mb4_unicode_ci,
  `genealogy_left` text COLLATE utf8mb4_unicode_ci,
  `genealogy_right` text COLLATE utf8mb4_unicode_ci,
  `binary_total` int(11) DEFAULT '0',
  `genealogy_total` int(11) DEFAULT '0',
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for wallets
-- ----------------------------
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1:usd; 2:btc; 3:clp; 4:reinvest;',
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bounus f1;5:bonus week',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned DEFAULT '0',
  PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for withdraws
-- ----------------------------
DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) NOT NULL,
  `at_rate` float DEFAULT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `amountCLP` double DEFAULT NULL,
  `amountBTC` double DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for withdraw_confirm
-- ----------------------------
DROP TABLE IF EXISTS `withdraw_confirm`;
CREATE TABLE `withdraw_confirm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdraw_id` int(10) DEFAULT NULL,
  `withdrawAmount` double DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('clp','btc') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`userId`),
  KEY `type` (`type`),
  KEY `userId` (`userId`),
  KEY `updated_at` (`updated_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
