/*
 Navicat Premium Data Transfer

 Source Server         : localhost_wamp
 Source Server Type    : MariaDB
 Source Server Version : 100309
 Source Host           : localhost:3307
 Source Schema         : jolie-g

 Target Server Type    : MariaDB
 Target Server Version : 100309
 File Encoding         : 65001

 Date: 24/12/2018 12:42:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_qr_item
-- ----------------------------
DROP TABLE IF EXISTS `tb_qr_item`;
CREATE TABLE `tb_qr_item`  (
  `qrcode_id` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่ QR Code',
  `product_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'เลขที่สินค้า',
  `created_at` timestamp(0) NULL DEFAULT NULL COMMENT 'วันที่บันทึก',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `print_status` int(11) NULL DEFAULT NULL COMMENT 'สถานะการพิมพ์',
  PRIMARY KEY (`qrcode_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
