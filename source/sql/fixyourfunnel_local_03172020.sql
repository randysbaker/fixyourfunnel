/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50617
 Source Host           : localhost:3306
 Source Schema         : fixyourfunnel

 Target Server Type    : MySQL
 Target Server Version : 50617
 File Encoding         : 65001

 Date: 17/03/2020 21:47:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for site_images
-- ----------------------------
DROP TABLE IF EXISTS `site_images`;
CREATE TABLE `site_images`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0,
  `image_title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image_file` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image_thumb` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `date_added` datetime(0) NULL DEFAULT NULL,
  `status` int(5) NULL DEFAULT 0,
  `ts` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `product_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of site_images
-- ----------------------------
INSERT INTO `site_images` VALUES (1, 1, 'Bringing In The Robots', 'gallery-image-1-virus_disinfection_robot_2020-03-17_045627.png', NULL, '2020-03-17 19:06:06', 0, '2020-03-17 20:07:43');
INSERT INTO `site_images` VALUES (2, 1, 'Robot COVID-19-03', 'gallery-image-2-virus_disinfection_robot_2020-03-17_045627.png', NULL, '2020-03-17 19:16:47', 0, '2020-03-17 20:49:50');
INSERT INTO `site_images` VALUES (3, 2, 'Robot Sprayer', 'gallery-image-3-virus_disinfection_robot_2020-03-17_045627.png', NULL, '2020-03-17 19:17:14', 0, '2020-03-17 19:33:03');

-- ----------------------------
-- Table structure for site_images_comments
-- ----------------------------
DROP TABLE IF EXISTS `site_images_comments`;
CREATE TABLE `site_images_comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NULL DEFAULT 0,
  `parent_id` int(11) NULL DEFAULT 0,
  `user_id` int(11) NULL DEFAULT 0,
  `image_comments` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `status` int(5) NULL DEFAULT 0,
  `ts` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE,
  INDEX `image_id`(`image_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of site_images_comments
-- ----------------------------
INSERT INTO `site_images_comments` VALUES (1, 1, 0, 1, 'This is a developer test comment...', 0, '2020-03-17 20:36:25');
INSERT INTO `site_images_comments` VALUES (2, 1, 0, 1, 'Here is another comment...', 0, '2020-03-17 20:47:01');

-- ----------------------------
-- Table structure for site_users
-- ----------------------------
DROP TABLE IF EXISTS `site_users`;
CREATE TABLE `site_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type` int(11) NULL DEFAULT 2,
  `confirmed` int(11) NULL DEFAULT 0,
  `slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(5) NULL DEFAULT 0,
  `ts` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  INDEX `first_name`(`first_name`) USING BTREE,
  INDEX `last_name`(`last_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of site_users
-- ----------------------------
INSERT INTO `site_users` VALUES (1, 2, 1, 'randy-baker', 'randysbaker@gmail.com', 'demo', 'Randy', 'Baker', 0, '2020-03-17 15:44:54');
INSERT INTO `site_users` VALUES (2, 2, 1, 'demo-account', 'demo@demo.com', 'demo', 'Demo', 'Account', 0, '2020-03-17 15:38:58');

SET FOREIGN_KEY_CHECKS = 1;
