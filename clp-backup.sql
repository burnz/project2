/*
 Navicat Premium Data Transfer

 Source Server         : LOCALHOST
 Source Server Type    : MySQL
 Source Server Version : 100126
 Source Host           : localhost:3306
 Source Schema         : clp

 Target Server Type    : MySQL
 Target Server Version : 100126
 File Encoding         : 65001

 Date: 30/11/2017 17:50:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bonus_binary
-- ----------------------------
DROP TABLE IF EXISTS `bonus_binary`;
CREATE TABLE `bonus_binary`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `weeked` int(10) NOT NULL,
  `year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT 0,
  `rightOpen` double DEFAULT 0,
  `settled` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `bonus_tmp` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`, `weeked`, `userId`) USING BTREE,
  UNIQUE INDEX `weekYear_uid`(`userId`, `weekYear`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bonus_binary_interest
-- ----------------------------
DROP TABLE IF EXISTS `bonus_binary_interest`;
CREATE TABLE `bonus_binary_interest`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT 0,
  `rightOpen` double DEFAULT 0,
  `bonus` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`, `userId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bonus_faststart
-- ----------------------------
DROP TABLE IF EXISTS `bonus_faststart`;
CREATE TABLE `bonus_faststart`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `generation` smallint(6) NOT NULL,
  `partnerId` int(10) NOT NULL,
  `packageId` int(10) NOT NULL,
  `amount` double DEFAULT NULL,
  PRIMARY KEY (`id`, `partnerId`, `userId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for clp_api_logs
-- ----------------------------
DROP TABLE IF EXISTS `clp_api_logs`;
CREATE TABLE `clp_api_logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `error_msg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime(0) DEFAULT NULL,
  `updated_at` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for clp_wallets
-- ----------------------------
DROP TABLE IF EXISTS `clp_wallets`;
CREATE TABLE `clp_wallets`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `deleted_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cron_binary_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_binary_logs`;
CREATE TABLE `cron_binary_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` datetime(0) DEFAULT NULL,
  `updated_at` datetime(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cron_binary_logs
-- ----------------------------
INSERT INTO `cron_binary_logs` VALUES (1, 1, NULL, '2017-11-09 08:07:28', '2017-11-09 08:07:28');

-- ----------------------------
-- Table structure for cron_leadership_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_leadership_logs`;
CREATE TABLE `cron_leadership_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cron_leadership_logs
-- ----------------------------
INSERT INTO `cron_leadership_logs` VALUES (1, 1, NULL, '2017-11-09 08:07:28', '2017-11-09 08:07:28');

-- ----------------------------
-- Table structure for cron_matching_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_matching_logs`;
CREATE TABLE `cron_matching_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cron_matching_logs
-- ----------------------------
INSERT INTO `cron_matching_logs` VALUES (1, 1, NULL, '2017-11-09 08:07:28', '2017-11-09 08:07:28');

-- ----------------------------
-- Table structure for cron_profit_day_logs
-- ----------------------------
DROP TABLE IF EXISTS `cron_profit_day_logs`;
CREATE TABLE `cron_profit_day_logs`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cron_profit_day_logs
-- ----------------------------
INSERT INTO `cron_profit_day_logs` VALUES (1, 1, NULL, '2017-11-09 08:07:28', '2017-11-09 08:07:28');

-- ----------------------------
-- Table structure for exchange_rates
-- ----------------------------
DROP TABLE IF EXISTS `exchange_rates`;
CREATE TABLE `exchange_rates`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_currency` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `exchrate` double NOT NULL,
  `to_currency` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `deleted_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of exchange_rates
-- ----------------------------
INSERT INTO `exchange_rates` VALUES (1, 'clp', 1, 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', NULL);
INSERT INTO `exchange_rates` VALUES (2, 'btc', 4210, 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', NULL);
INSERT INTO `exchange_rates` VALUES (3, 'clp', 0.00023809524, 'btc', '2017-10-04 17:34:33', '2017-10-04 17:34:33', NULL);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2017_02_20_233057_create_permission_tables', 1);
INSERT INTO `migrations` VALUES (4, '2017_02_22_171712_create_posts_table', 1);

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`, `model_id`) USING BTREE,
  INDEX `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES (1, 1, 'App\\User');

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`, `model_id`) USING BTREE,
  INDEX `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`) USING BTREE,
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES (1, 1, 'App\\User');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` smallint(6) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `public_at` datetime(0) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `priority` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `views` bigint(20) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `deleted_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (1, '123', 1, NULL, '123', '<p>123</p>', NULL, 1, 0, NULL, '2017-11-20 06:20:16', '2017-11-20 06:20:16', NULL);

-- ----------------------------
-- Table structure for notification
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `completed_status` tinyint(1) DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for notification_read_new
-- ----------------------------
DROP TABLE IF EXISTS `notification_read_new`;
CREATE TABLE `notification_read_new`  (
  `new_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read` int(11) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 119 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of order_lists
-- ----------------------------
INSERT INTO `order_lists` VALUES (1, '', 1, 1, 4, 4, 1, '2017-11-23 08:38:55', '2017-11-23 08:38:55', NULL);
INSERT INTO `order_lists` VALUES (2, '', 1, 2, 1, 2, 1, '2017-11-23 08:40:39', '2017-11-23 08:40:39', NULL);
INSERT INTO `order_lists` VALUES (3, '', 1, 3, 3, 9, 1, '2017-11-23 08:50:38', '2017-11-23 08:50:38', NULL);
INSERT INTO `order_lists` VALUES (4, '', 1, 4, 2, 8, 1, '2017-11-23 08:51:43', '2017-11-23 08:51:43', NULL);
INSERT INTO `order_lists` VALUES (5, '', 1, 5, 3, 15, 1, '2017-11-23 08:57:14', '2017-11-23 08:57:14', NULL);
INSERT INTO `order_lists` VALUES (6, '', 1, 6, 4, 24, 1, '2017-11-23 08:57:29', '2017-11-23 08:57:29', NULL);
INSERT INTO `order_lists` VALUES (7, '', 1, 7, 4, 28, 1, '2017-11-23 09:21:10', '2017-11-23 09:21:10', NULL);
INSERT INTO `order_lists` VALUES (8, '', 1, 8, 2, 16, 1, '2017-11-23 09:42:23', '2017-11-23 09:42:23', NULL);
INSERT INTO `order_lists` VALUES (9, '', 1, 0, 0, 0, 1, '2017-11-23 10:25:30', '2017-11-23 10:25:30', NULL);
INSERT INTO `order_lists` VALUES (10, '', 1, 40, 40, 1600, 1, '2017-11-23 10:25:38', '2017-11-23 10:25:38', NULL);
INSERT INTO `order_lists` VALUES (11, '', 1, 0, 0, 0, 0, '2017-11-23 10:26:13', '2017-11-23 10:26:13', NULL);
INSERT INTO `order_lists` VALUES (12, '', 1, 3, 3, 9, 1, '2017-11-23 10:26:30', '2017-11-23 10:26:30', NULL);
INSERT INTO `order_lists` VALUES (13, '', 1, 70, 70, 4900, 1, '2017-11-23 10:26:50', '2017-11-23 10:26:50', NULL);
INSERT INTO `order_lists` VALUES (14, '', 1, 2, 3, 6, 1, '2017-11-23 10:29:07', '2017-11-23 10:29:07', NULL);
INSERT INTO `order_lists` VALUES (15, '', 1, 0, 0, 0, 1, '2017-11-23 10:29:20', '2017-11-23 10:29:20', NULL);
INSERT INTO `order_lists` VALUES (16, '', 1, 90, 90, 8100, 1, '2017-11-23 10:29:52', '2017-11-23 10:29:52', NULL);
INSERT INTO `order_lists` VALUES (17, '', 1, 54, 90, 4860, 1, '2017-11-23 10:31:10', '2017-11-23 10:31:10', NULL);
INSERT INTO `order_lists` VALUES (18, '', 1, 100, 90, 9000, 1, '2017-11-23 10:31:22', '2017-11-23 10:31:22', NULL);
INSERT INTO `order_lists` VALUES (19, '', 1, 123, 123, 15129, 1, '2017-11-23 10:33:59', '2017-11-23 10:33:59', NULL);
INSERT INTO `order_lists` VALUES (20, '', 1, 0, 0, 0, 1, '2017-11-23 10:42:05', '2017-11-23 10:42:05', NULL);
INSERT INTO `order_lists` VALUES (21, '', 1, 0, 0, 0, 1, '2017-11-23 10:42:25', '2017-11-23 10:42:25', NULL);
INSERT INTO `order_lists` VALUES (22, '', 1, 12, 12, 144, 1, '2017-11-23 11:02:20', '2017-11-23 11:02:20', NULL);
INSERT INTO `order_lists` VALUES (23, '', 1, 1233, 1233, 1520289, 2, '2017-11-23 11:02:56', '2017-11-23 11:02:56', NULL);
INSERT INTO `order_lists` VALUES (24, '', 1, 123, 123, 15129, 1, '2017-11-23 11:05:35', '2017-11-23 11:05:35', NULL);
INSERT INTO `order_lists` VALUES (25, '', 1, 12, 1, 12, 1, '2017-11-24 09:45:04', '2017-11-24 09:45:04', NULL);
INSERT INTO `order_lists` VALUES (26, '', 1, 14, 14, 196, 1, '2017-11-24 09:45:32', '2017-11-24 09:45:32', NULL);
INSERT INTO `order_lists` VALUES (27, '', 1, 1, 1, 1, 1, '2017-11-24 09:46:45', '2017-11-24 09:46:45', NULL);
INSERT INTO `order_lists` VALUES (28, '', 1, 1, 14, 14, 1, '2017-11-24 09:47:03', '2017-11-24 09:47:03', NULL);
INSERT INTO `order_lists` VALUES (29, '', 1, 1, 14, 14, 1, '2017-11-24 09:48:19', '2017-11-24 09:48:19', NULL);
INSERT INTO `order_lists` VALUES (30, '', 1, 1, 14, 14, 1, '2017-11-24 09:48:21', '2017-11-24 09:48:21', NULL);
INSERT INTO `order_lists` VALUES (31, '', 1, 2, 2, 4, 1, '2017-11-24 09:48:32', '2017-11-24 09:48:32', NULL);
INSERT INTO `order_lists` VALUES (32, '', 1, 2, 2, 4, 1, '2017-11-24 09:48:34', '2017-11-24 09:48:34', NULL);
INSERT INTO `order_lists` VALUES (33, '', 1, 2, 2, 4, 1, '2017-11-24 09:48:35', '2017-11-24 09:48:35', NULL);
INSERT INTO `order_lists` VALUES (34, '', 1, 2, 2, 4, 1, '2017-11-24 09:48:37', '2017-11-24 09:48:37', NULL);
INSERT INTO `order_lists` VALUES (35, '', 1, 2, 3, 6, 1, '2017-11-24 09:48:45', '2017-11-24 09:48:45', NULL);
INSERT INTO `order_lists` VALUES (36, '', 1, 15, 15, 225, 1, '2017-11-24 09:52:14', '2017-11-24 09:52:14', NULL);
INSERT INTO `order_lists` VALUES (37, '', 1, 123, 123, 15129, 0, '2017-11-24 10:39:28', '2017-11-24 10:39:28', NULL);
INSERT INTO `order_lists` VALUES (38, '', 1, 2, 3, 6, 1, '2017-11-25 08:32:48', '2017-11-25 08:32:48', NULL);
INSERT INTO `order_lists` VALUES (39, '', 1, 4, 3, 12, 1, '2017-11-25 08:33:17', '2017-11-25 08:33:17', NULL);
INSERT INTO `order_lists` VALUES (40, '', 1, 3, 4, 12, 1, '2017-11-25 08:34:23', '2017-11-25 08:34:23', NULL);
INSERT INTO `order_lists` VALUES (41, 'b6bf33817b9c64cdad267d82d05fbb50', 1, 2, 2, 4, 0, '2017-11-25 08:48:20', '2017-11-25 08:53:09', NULL);
INSERT INTO `order_lists` VALUES (42, 'a41f5da8344a67b560dfc0fa1b48da7e', 1, 2, 3, 6, 0, '2017-11-25 08:56:07', '2017-11-25 08:56:22', NULL);
INSERT INTO `order_lists` VALUES (43, '6414bda1e24a8744c764b48ec913ebc2', 1, 7, 7, 49, 0, '2017-11-25 08:58:16', '2017-11-25 08:58:24', NULL);
INSERT INTO `order_lists` VALUES (44, '7855d4adf5c6966f2181408f4d8eb134', 1, 2, 7, 14, 0, '2017-11-25 08:59:36', '2017-11-25 09:00:47', NULL);
INSERT INTO `order_lists` VALUES (45, '36d324f5ef01c9e050be2e2bcf00086b', 1, 3, 6, 18, 0, '2017-11-25 09:06:44', '2017-11-25 09:06:46', NULL);
INSERT INTO `order_lists` VALUES (46, '82129d5164a945a8b91ce80cc2893914', 1, 4, 4, 16, 0, '2017-11-25 09:07:16', '2017-11-25 09:07:18', NULL);
INSERT INTO `order_lists` VALUES (47, 'df4ff0a9452b79e578cd93233c7e4d75', 1, 3, 1, 3, 0, '2017-11-25 09:07:50', '2017-11-25 09:10:25', NULL);
INSERT INTO `order_lists` VALUES (48, '813d400db45f216ccc2a422bbec3f4aa', 1, 5, 5, 25, 0, '2017-11-25 09:09:05', '2017-11-25 09:09:09', NULL);
INSERT INTO `order_lists` VALUES (49, 'a340c1cc8a1f26d7b986102d1186ab15', 1, 7, 7, 49, 0, '2017-11-25 09:11:30', '2017-11-25 09:11:32', NULL);
INSERT INTO `order_lists` VALUES (50, '97cb97d27aa7be0afd011e2904717ebc', 1, 4, 0, 0, 0, '2017-11-25 09:13:20', '2017-11-25 09:13:22', NULL);
INSERT INTO `order_lists` VALUES (51, '7d24ef744e984cc190b2eecb1aae6936', 1, 4, 6, 24, 0, '2017-11-25 09:14:03', '2017-11-25 09:14:05', NULL);
INSERT INTO `order_lists` VALUES (52, '186eba7efed364dd629f9f6f70c7abbc', 1, 1, 1, 1, 0, '2017-11-25 09:16:41', '2017-11-25 09:16:51', NULL);
INSERT INTO `order_lists` VALUES (53, 'ed26f3b5c06b9bb0aa0032ddf5d547b6', 1, 3, 3, 9, 0, '2017-11-25 09:18:56', '2017-11-25 09:18:58', NULL);
INSERT INTO `order_lists` VALUES (54, 'a814c181d6973bfe4e28bcf67094ec2d', 1, 2.1231234, 2.1232134235, 4.50784410262696, 0, '2017-11-25 09:28:44', '2017-11-25 09:43:54', NULL);
INSERT INTO `order_lists` VALUES (55, '6022b3722de168602ae0d517734bb6da', 1, 2.12312341324, 2.1232134235234, 4.507844130787987, 0, '2017-11-25 09:28:53', '2017-11-25 09:43:52', NULL);
INSERT INTO `order_lists` VALUES (56, 'f50e9341c8da1b667d4935613b76f34a', 1, 0, 0, 0, 0, '2017-11-25 09:32:32', '2017-11-25 09:32:47', NULL);
INSERT INTO `order_lists` VALUES (57, 'e0662543c53cde8e8b664f2e43c67acd', 1, 0, 0, 0, 0, '2017-11-25 09:32:36', '2017-11-25 09:32:45', NULL);
INSERT INTO `order_lists` VALUES (58, '7625c9ae94dffdb4c7d647aece8641d2', 1, 0, 0, 0, 0, '2017-11-25 09:32:39', '2017-11-25 09:32:44', NULL);
INSERT INTO `order_lists` VALUES (59, '358ae46dedfddd766ed8a69088eecd7f', 1, 0, 0, 0, 0, '2017-11-25 09:38:20', '2017-11-25 09:43:50', NULL);
INSERT INTO `order_lists` VALUES (60, '1db99020d1c3d37ab607a18171f5b255', 1, 2, 3, 6, 0, '2017-11-25 09:41:16', '2017-11-25 09:43:49', NULL);
INSERT INTO `order_lists` VALUES (61, '7686e3af646c2a984292483d8bb7b4c0', 1, 2, 3, 6, 0, '2017-11-25 09:41:20', '2017-11-25 09:43:47', NULL);
INSERT INTO `order_lists` VALUES (62, 'c2557c73b97a97d7389bbd8f9ca1c131', 1, 1, 2, 2, 0, '2017-11-25 09:50:20', '2017-11-25 09:58:34', NULL);
INSERT INTO `order_lists` VALUES (63, '94370fc1d8cb4479f9729e6ccf50c972', 1, 3, 5, 15, 0, '2017-11-25 09:53:12', '2017-11-25 09:58:32', NULL);
INSERT INTO `order_lists` VALUES (64, 'a7bf983916a464ec174d81333466c038', 1, 1, 0.000001, 0.000001, 1, '2017-11-26 13:39:48', '2017-11-26 13:39:48', NULL);
INSERT INTO `order_lists` VALUES (65, 'c8710506a2df6c6fb025ce56b9eeeb63', 1, 1, 0.00001, 0.00001, 1, '2017-11-26 13:40:11', '2017-11-26 13:40:11', NULL);
INSERT INTO `order_lists` VALUES (66, '992fabd928386f2ffc0a0bd25ac6963b', 1, 1, 0.0001, 0.0001, 1, '2017-11-26 13:41:45', '2017-11-26 13:41:45', NULL);
INSERT INTO `order_lists` VALUES (67, '0fa211dd1d7a0a937f1f47b8b5a96dc4', 1, 7, 2, 14, 1, '2017-11-26 14:05:23', '2017-11-26 14:05:23', NULL);
INSERT INTO `order_lists` VALUES (68, '93b332e083f4ea7008732c0f706be15b', 1, 2, 2, 4, 1, '2017-11-26 14:05:56', '2017-11-26 14:05:56', NULL);
INSERT INTO `order_lists` VALUES (69, 'e8dc4e7ea7d3446a5a87ed254a25a4ce', 1, 3, 3, 9, 1, '2017-11-26 14:06:22', '2017-11-26 14:06:22', NULL);
INSERT INTO `order_lists` VALUES (70, '6970cfb834d9906294fce176835c2625', 1, 3, 3, 9, 1, '2017-11-26 14:07:17', '2017-11-26 14:07:17', NULL);
INSERT INTO `order_lists` VALUES (71, 'eb089bfa145a661ecba5840509c76299', 1, 12, 12, 144, 1, '2017-11-26 14:07:38', '2017-11-26 14:07:38', NULL);
INSERT INTO `order_lists` VALUES (72, '26b5a54d7743e8eedc05692bab02fee2', 1, 11, 11, 121, 1, '2017-11-26 14:08:18', '2017-11-26 14:08:18', NULL);
INSERT INTO `order_lists` VALUES (73, '3dd169cdfffa55965541311336f7521f', 1, 2, 2, 4, 1, '2017-11-26 14:10:21', '2017-11-26 14:10:21', NULL);
INSERT INTO `order_lists` VALUES (74, 'df116060558d76d1a77073f43122fc86', 1, 5, 0.04, 0.2, 1, '2017-11-26 14:11:17', '2017-11-26 14:11:17', NULL);
INSERT INTO `order_lists` VALUES (75, 'f3af8c55109528f97bc4f7d1ec9cacf8', 1, 4, 2, 8, 1, '2017-11-26 14:12:22', '2017-11-26 14:12:22', NULL);
INSERT INTO `order_lists` VALUES (76, 'ffda29110cb6ada1266ee8a5d4dfb923', 1, 100, 100, 10000, 1, '2017-11-26 14:26:35', '2017-11-26 14:26:35', NULL);
INSERT INTO `order_lists` VALUES (77, '3f9d6a63d6a99472b45a2067d642b79b', 1, 100, 100, 10000, 1, '2017-11-26 14:31:31', '2017-11-26 14:31:31', NULL);
INSERT INTO `order_lists` VALUES (78, '138c9b28c4da58f35740809f62193dd4', 1, 14, 14, 196, 1, '2017-11-26 15:22:31', '2017-11-26 15:22:31', NULL);
INSERT INTO `order_lists` VALUES (79, '06398151cf7c6b1de75d7f4060be9a4a', 1, 15, 15, 225, 1, '2017-11-26 15:22:36', '2017-11-26 15:22:36', NULL);
INSERT INTO `order_lists` VALUES (80, '1e5c4699c73bf1cf4628addd178830d7', 1, 19, 19, 361, 1, '2017-11-26 15:29:17', '2017-11-26 15:29:17', NULL);
INSERT INTO `order_lists` VALUES (81, '794c406b452f60a4af3a47d4fa55e77c', 1, 20, 20, 400, 1, '2017-11-26 15:29:54', '2017-11-26 15:29:54', NULL);
INSERT INTO `order_lists` VALUES (82, '040841f63dfbf26f19d63c972aae6963', 1, 21, 21, 441, 1, '2017-11-26 15:30:45', '2017-11-26 15:30:45', NULL);
INSERT INTO `order_lists` VALUES (83, '2a2e3d76eb1d5599d6ee1a172bf9e007', 1, 22, 22, 484, 1, '2017-11-26 15:31:05', '2017-11-26 15:31:05', NULL);
INSERT INTO `order_lists` VALUES (84, '273eba2601c7ab273d7d393c64d2092c', 1, 1, 0.02, 0.02, 1, '2017-11-26 15:33:06', '2017-11-26 15:33:06', NULL);
INSERT INTO `order_lists` VALUES (85, 'c8f2cae7e0043dd97a1ccc95358c8fc1', 1, 4, 0.03, 0.12, 1, '2017-11-26 15:33:25', '2017-11-26 15:33:25', NULL);
INSERT INTO `order_lists` VALUES (86, 'fb92267a31e509175a98db8dbcbbcd32', 1, 5, 0.07, 0.35000000000000003, 1, '2017-11-26 15:33:46', '2017-11-26 15:33:46', NULL);
INSERT INTO `order_lists` VALUES (87, '0dc50390b3fa9b2a7c61abc81de04852', 1, 5, 0.06, 0.3, 1, '2017-11-26 15:34:07', '2017-11-26 15:34:07', NULL);
INSERT INTO `order_lists` VALUES (88, '30dd4c264095310032bece71b81ea4b0', 1, 7, 0.07, 0.49000000000000005, 1, '2017-11-26 15:34:57', '2017-11-26 15:34:57', NULL);
INSERT INTO `order_lists` VALUES (89, '58316b36588bcfb8cf02a66eace3e892', 1, 6, 0.07, 0.42000000000000004, 1, '2017-11-26 15:35:27', '2017-11-26 15:35:27', NULL);
INSERT INTO `order_lists` VALUES (90, 'a8731c7f5c17143b844d5721bd49129b', 1, 22, 22, 484, 1, '2017-11-26 15:35:48', '2017-11-26 15:35:48', NULL);
INSERT INTO `order_lists` VALUES (91, 'dba224708b2bfb77ef4ac5fc793ea889', 1, 23, 23, 529, 1, '2017-11-26 15:37:38', '2017-11-26 15:37:38', NULL);
INSERT INTO `order_lists` VALUES (92, '73c71442de6fa3be2d624f9f728cf319', 1, 24, 24, 576, 1, '2017-11-26 15:39:43', '2017-11-26 15:39:43', NULL);
INSERT INTO `order_lists` VALUES (93, '16def8d1e63298f8ac9db45789007ff5', 1, 25, 25, 625, 1, '2017-11-26 15:39:57', '2017-11-26 15:39:57', NULL);
INSERT INTO `order_lists` VALUES (94, '04802b6397f47acead8a2275eccee699', 1, 26, 26, 676, 1, '2017-11-26 15:40:34', '2017-11-26 15:40:34', NULL);
INSERT INTO `order_lists` VALUES (95, '9e86970030a6dc01861889fff5e3acff', 1, 27, 27, 729, 1, '2017-11-26 15:40:51', '2017-11-26 15:40:51', NULL);
INSERT INTO `order_lists` VALUES (96, 'b720fa2fd76765b4c6a0c72b1beb78c0', 1, 28, 28, 784, 1, '2017-11-26 15:42:33', '2017-11-26 15:42:33', NULL);
INSERT INTO `order_lists` VALUES (97, '4d41c9f4bc0832f506f16a3bc64e6cd8', 1, 1, 28, 28, 1, '2017-11-26 15:43:59', '2017-11-26 15:43:59', NULL);
INSERT INTO `order_lists` VALUES (98, '10c33c8118dfc1808829efd49ce8bccf', 1, 30, 30, 900, 1, '2017-11-26 18:19:31', '2017-11-26 18:19:31', NULL);
INSERT INTO `order_lists` VALUES (99, '7c00e756626714fade96e1b94c3a679b', 1, 202, 202, 40804, 2, '2017-11-26 18:19:42', '2017-11-26 18:19:42', NULL);
INSERT INTO `order_lists` VALUES (100, 'f752e0410ab1c7ece42f368507bac477', 1, 1, 1, 1, 1, '2017-11-27 08:12:09', '2017-11-27 08:12:09', NULL);
INSERT INTO `order_lists` VALUES (101, '6bb77f7dd636c5053d5b7122f1b756aa', 1, 2, 2, 4, 1, '2017-11-27 08:22:55', '2017-11-27 08:22:55', NULL);
INSERT INTO `order_lists` VALUES (102, '4d2d437ef98f00fa3ed97840dd0d1ab0', 1, 3, 3, 9, 1, '2017-11-27 08:28:41', '2017-11-27 08:28:41', NULL);
INSERT INTO `order_lists` VALUES (103, 'f19f547a75cb4f520d311bc833485c08', 1, 4, 4, 16, 1, '2017-11-27 08:29:50', '2017-11-27 08:29:50', NULL);
INSERT INTO `order_lists` VALUES (104, '53ea468307206d62797c988e9835c88e', 1, 5, 5, 25, 1, '2017-11-27 08:29:56', '2017-11-27 08:29:56', NULL);
INSERT INTO `order_lists` VALUES (105, '6c0a416ebfc2c31660c85c7dbab6ab0a', 1, 6, 5, 30, 1, '2017-11-27 08:30:25', '2017-11-27 08:30:25', NULL);
INSERT INTO `order_lists` VALUES (106, 'f4695db6975d86d371b7a447373dc9eb', 1, 6, 5, 30, 1, '2017-11-27 08:30:34', '2017-11-27 08:30:34', NULL);
INSERT INTO `order_lists` VALUES (107, 'a263577a9173538b68a2e007bf857383', 1, 7, 7, 49, 1, '2017-11-27 08:31:42', '2017-11-27 08:31:42', NULL);
INSERT INTO `order_lists` VALUES (108, '20d6285433ea4ce553bb7f679518263f', 1, 8, 8, 64, 1, '2017-11-27 08:31:48', '2017-11-27 08:31:48', NULL);
INSERT INTO `order_lists` VALUES (109, '84918d6d60cc5c52fa2deb55bbc34f32', 1, 2, 2, 4, 1, '2017-11-27 08:32:06', '2017-11-27 08:32:06', NULL);
INSERT INTO `order_lists` VALUES (110, '8b3cb86605b6938883df1a5afeaffacb', 1, 4, 4, 16, 1, '2017-11-27 08:34:39', '2017-11-27 08:34:39', NULL);
INSERT INTO `order_lists` VALUES (111, '5e7a300aaa087e7b585d561ab5a24ab3', 1, 12, 12, 144, 1, '2017-11-29 10:24:06', '2017-11-29 10:24:06', NULL);
INSERT INTO `order_lists` VALUES (112, 'c9efce5dc7cb6645ad400861b324a0a4', 1, 1, 1, 1, 1, '2017-11-29 10:27:22', '2017-11-29 10:27:22', NULL);
INSERT INTO `order_lists` VALUES (113, '89a01ef96469625e933d5b206d3a4e22', 1, 2, 2, 4, 1, '2017-11-29 10:28:25', '2017-11-29 10:28:25', NULL);
INSERT INTO `order_lists` VALUES (114, '8eba97ea50a3e913f07ab3c00e50c967', 1, 3, 3, 9, 1, '2017-11-29 11:26:51', '2017-11-29 11:26:51', NULL);
INSERT INTO `order_lists` VALUES (115, 'afbe1467c572ae05ff031240b139d797', 1, 4, 4, 16, 1, '2017-11-29 11:27:01', '2017-11-29 11:27:01', NULL);
INSERT INTO `order_lists` VALUES (116, 'd26775a16d51fceea5bc0637f8841fa2', 1, 5, 5, 25, 2, '2017-11-29 11:27:35', '2017-11-29 11:27:35', NULL);
INSERT INTO `order_lists` VALUES (117, '6527eaa4e1a19d42d5d4d8024bc5cb9c', 1, 10, 10, 100, 1, '2017-11-29 11:49:37', '2017-11-29 11:49:37', NULL);
INSERT INTO `order_lists` VALUES (118, '28bb1a85a7eaed8d1af1928883b8fa8f', 1, 11, 11, 121, 1, '2017-11-29 11:53:53', '2017-11-29 11:53:53', NULL);

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `min_price` int(10) NOT NULL,
  `max_price` int(10) NOT NULL,
  `capital_release` int(10) NOT NULL,
  `bonus` float DEFAULT 0,
  `pack_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `roles_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `pack_id`(`pack_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES (1, 'TINY', '2017-08-16 07:06:07', '2017-09-18 04:14:07', 200, 1000, 299, 0, 1);
INSERT INTO `packages` VALUES (2, 'SMALL', '2017-08-16 07:06:35', '2017-09-18 04:14:46', 1010, 10000, 239, 0.001, 2);
INSERT INTO `packages` VALUES (3, 'MEDIUM', '2017-08-16 07:58:33', '2017-09-18 04:14:33', 10010, 50000, 179, 0.0015, 3);
INSERT INTO `packages` VALUES (4, 'LARGE', '2017-08-16 07:58:22', '2017-08-16 07:58:22', 50010, 100000, 120, 0.002, 4);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE,
  INDEX `password_resets_token_index`(`token`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'view_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (2, 'add_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (3, 'edit_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (4, 'delete_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (5, 'view_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (6, 'add_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (7, 'edit_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (8, 'delete_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES (21, 'view_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES (22, 'add_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES (23, 'edit_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES (24, 'delete_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES (25, 'view_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES (26, 'add_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES (27, 'edit_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');
INSERT INTO `permissions` VALUES (28, 'delete_news', 'web', '2017-09-27 12:00:44', '2017-09-27 12:00:44');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions`  (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`, `role_id`) USING BTREE,
  INDEX `role_has_permissions_role_id_foreign`(`role_id`) USING BTREE,
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES (1, 1);
INSERT INTO `role_has_permissions` VALUES (2, 1);
INSERT INTO `role_has_permissions` VALUES (3, 1);
INSERT INTO `role_has_permissions` VALUES (4, 1);
INSERT INTO `role_has_permissions` VALUES (5, 1);
INSERT INTO `role_has_permissions` VALUES (6, 1);
INSERT INTO `role_has_permissions` VALUES (7, 1);
INSERT INTO `role_has_permissions` VALUES (8, 1);
INSERT INTO `role_has_permissions` VALUES (21, 1);
INSERT INTO `role_has_permissions` VALUES (22, 1);
INSERT INTO `role_has_permissions` VALUES (23, 1);
INSERT INTO `role_has_permissions` VALUES (24, 1);
INSERT INTO `role_has_permissions` VALUES (25, 1);
INSERT INTO `role_has_permissions` VALUES (26, 1);
INSERT INTO `role_has_permissions` VALUES (27, 1);
INSERT INTO `role_has_permissions` VALUES (28, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Admin', 'web', '2017-09-05 08:55:03', '2017-09-05 08:55:03');
INSERT INTO `roles` VALUES (2, 'User', 'web', '2017-09-05 08:55:04', '2017-09-05 08:55:04');
INSERT INTO `roles` VALUES (3, 'view_abc', 'web', '2017-09-05 09:00:15', '2017-09-05 09:00:15');
INSERT INTO `roles` VALUES (4, 'Member', 'web', '2017-09-08 05:01:29', '2017-09-08 05:01:29');

-- ----------------------------
-- Table structure for total_week_sales
-- ----------------------------
DROP TABLE IF EXISTS `total_week_sales`;
CREATE TABLE `total_week_sales`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `total_interest` double DEFAULT NULL,
  `weekYear` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`, `userId`) USING BTREE,
  UNIQUE INDEX `weekYear_uid`(`userId`, `weekYear`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of total_week_sales
-- ----------------------------
INSERT INTO `total_week_sales` VALUES (1, '2017-11-09 08:07:28', '2017-11-09 08:07:28', 1, NULL, NULL);

-- ----------------------------
-- Table structure for user_coins
-- ----------------------------
DROP TABLE IF EXISTS `user_coins`;
CREATE TABLE `user_coins`  (
  `userId` int(10) UNSIGNED NOT NULL,
  `walletAddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountCoinBase` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btcCoinAmount` double unsigned,
  `clpCoinAmount` double unsigned,
  `usdAmount` double unsigned,
  `reinvestAmount` double unsigned,
  `backupKey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `availableAmount` double DEFAULT 0,
  UNIQUE INDEX `userId`(`userId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES (1, 'admin', 'admin', 0, 0, 0, 0, NULL, 0);
INSERT INTO `user_coins` VALUES (2, 'root', 'root', 0, 0, 0, 0, NULL, 0);

-- ----------------------------
-- Table structure for user_datas
-- ----------------------------
DROP TABLE IF EXISTS `user_datas`;
CREATE TABLE `user_datas`  (
  `userId` int(10) UNSIGNED NOT NULL,
  `refererId` int(10) DEFAULT 0,
  `packageId` smallint(6) DEFAULT 0,
  `packageDate` timestamp(0) DEFAULT NULL,
  `totalBonus` double DEFAULT 0,
  `isBinary` tinyint(1) DEFAULT 0,
  `leftRight` enum('right','left') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalSaleLeft` double DEFAULT 0,
  `totalSaleRight` double DEFAULT 0,
  `saleGenLeft` double DEFAULT 0,
  `saleGenRight` double DEFAULT 0,
  `binaryUserId` int(10) DEFAULT 0,
  `lastUserIdLeft` int(10) DEFAULT 0,
  `lastUserIdRight` int(10) DEFAULT 0,
  `leftMembers` int(10) DEFAULT 0,
  `rightMembers` int(10) DEFAULT 0,
  `totalMembers` int(10) DEFAULT 0,
  `loyaltyId` tinyint(2) DEFAULT 0,
  `status` tinyint(1) DEFAULT 0,
  UNIQUE INDEX `userId`(`userId`) USING BTREE,
  INDEX `referrerId`(`refererId`) USING BTREE,
  INDEX `packageId`(`packageId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_datas
-- ----------------------------
INSERT INTO `user_datas` VALUES (1, 0, 1, '2017-11-09 08:07:28', 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `user_datas` VALUES (2, 0, 6, NULL, 0, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- ----------------------------
-- Table structure for user_packages
-- ----------------------------
DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) UNSIGNED NOT NULL,
  `packageId` int(10) NOT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `amount_increase` int(10) NOT NULL,
  `buy_date` timestamp(0) DEFAULT NULL,
  `release_date` timestamp(0) DEFAULT NULL,
  `withdraw` tinyint(1) DEFAULT 0,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user_packages
-- ----------------------------
INSERT INTO `user_packages` VALUES (1, 1, 1, '2017-11-09 08:07:28', '2017-11-09 08:07:28', 220, '2017-11-09 08:07:28', '2018-09-04 08:07:28', 0, 201745);

-- ----------------------------
-- Table structure for user_tree_permissions
-- ----------------------------
DROP TABLE IF EXISTS `user_tree_permissions`;
CREATE TABLE `user_tree_permissions`  (
  `userId` int(10) UNSIGNED NOT NULL,
  `binary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `genealogy` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `binary_left` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `binary_right` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `genealogy_left` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `genealogy_right` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `binary_total` int(11) DEFAULT 0,
  `genealogy_total` int(11) DEFAULT 0,
  UNIQUE INDEX `userId`(`userId`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is2fa` tinyint(1) DEFAULT 0,
  `refererId` int(10) DEFAULT NULL,
  `google2fa_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `passport` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `photo_verification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approve` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE,
  UNIQUE INDEX `users_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `uid`(`uid`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', 'henry@cryptolending.org', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'kysXHzL4DjJAD0L83Wo4UvPbPPKWq3f684xbmV7q1zjffzPVjtaR2ZXUM1Bb', '2017-08-12 05:47:39', '2017-09-15 08:22:03', 1, 'Henry', 'Ford', '012312423asdasd', 0, NULL, 'RE7S5LKYXTPCOMXF', 1, '', 'Profile', NULL, NULL, NULL, '41', NULL, NULL, NULL, 651965165, '1', 1);
INSERT INTO `users` VALUES (2, 'root', 'giangitman@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'sevDOzuBrkeofbFPyjOb0AD1Qy0HxJSgIZbBVDtcTskjKBxaM8vq1388g83u', '2017-10-05 17:42:21', '2017-10-05 17:42:43', 1, 'root', 'Giang', '0978708981', 0, NULL, '2NZOY6TF4MLVJH2V', 1, NULL, NULL, NULL, NULL, NULL, '41', NULL, NULL, NULL, 99, '1', 1);

-- ----------------------------
-- Table structure for users_loyalty
-- ----------------------------
DROP TABLE IF EXISTS `users_loyalty`;
CREATE TABLE `users_loyalty`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `isSilver` tinyint(1) DEFAULT 0,
  `isGold` tinyint(1) DEFAULT 0,
  `isPear` tinyint(1) DEFAULT 0,
  `isEmerald` tinyint(1) DEFAULT 0,
  `isDiamond` tinyint(1) DEFAULT 0,
  `f1Left` int(10) DEFAULT 0,
  `f1Right` int(10) DEFAULT 0,
  `collectSilver` tinyint(1) DEFAULT 0,
  `refererId` int(10) DEFAULT NULL,
  `leftRight` enum('right','left') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `userId`) USING BTREE,
  INDEX `userId`(`userId`) USING BTREE,
  INDEX `isSilver`(`isSilver`) USING BTREE,
  INDEX `isGold`(`isGold`) USING BTREE,
  INDEX `isPear`(`isPear`) USING BTREE,
  INDEX `isEmerald`(`isEmerald`) USING BTREE,
  INDEX `isDiamond`(`isDiamond`) USING BTREE,
  INDEX `refererId`(`refererId`) USING BTREE,
  INDEX `leftRight`(`leftRight`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for wallets
-- ----------------------------
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `walletType` tinyint(2) NOT NULL DEFAULT 0 COMMENT '1:usd; 2:btc; 3:clp; 4:reinvest;',
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bounus f1;5:bonus week',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned,
  PRIMARY KEY (`id`, `type`, `inOut`, `walletType`, `userId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for withdraw_confirm
-- ----------------------------
DROP TABLE IF EXISTS `withdraw_confirm`;
CREATE TABLE `withdraw_confirm`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `walletAddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdrawAmount` double DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('clp','btc') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`, `userId`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `userId`(`userId`) USING BTREE,
  INDEX `updated_at`(`updated_at`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for withdraws
-- ----------------------------
DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp(0) DEFAULT NULL,
  `updated_at` timestamp(0) DEFAULT NULL,
  `walletAddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) NOT NULL,
  `wallet_id` int(10) DEFAULT NULL,
  `amountCLP` double DEFAULT NULL,
  `amountBTC` double DEFAULT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`, `userId`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
