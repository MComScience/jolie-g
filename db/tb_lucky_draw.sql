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

 Date: 24/12/2018 12:42:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_lucky_draw
-- ----------------------------
DROP TABLE IF EXISTS `tb_lucky_draw`;
CREATE TABLE `tb_lucky_draw`  (
  `lucky_draw_id` int(11) NOT NULL AUTO_INCREMENT,
  `lucky_draw_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่องวดที่จับฉลาก',
  `rewards_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสชุดรางวัล',
  `created_at` date NOT NULL DEFAULT 'current_timestamp()' COMMENT 'วันที่บันทึก',
  `updated_at` timestamp(0) NULL DEFAULT NULL COMMENT 'วันที่แก้ไข',
  `created_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้บันทึก',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT 'ผู้แก้ไข',
  `item_id` int(11) NOT NULL COMMENT 'ชื่อสินค้า',
  `product_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'กลุ่มคิวอาร์โค้ด',
  `lucky_draw_condition` int(11) NOT NULL COMMENT 'เงื่อนไขการจับฉลาก',
  `begin_date` date NULL DEFAULT NULL COMMENT 'วันเริ่ม',
  `end_date` date NULL DEFAULT NULL COMMENT 'วันสิ้นสุด',
  PRIMARY KEY (`lucky_draw_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
