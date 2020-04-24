/*
 Navicat Premium Data Transfer

 Source Server         : oeong.xyz
 Source Server Type    : MySQL
 Source Server Version : 50624
 Source Host           : 123.56.93.164:3306
 Source Schema         : CQCQ

 Target Server Type    : MySQL
 Target Server Version : 50624
 File Encoding         : 65001

 Date: 24/04/2020 17:52:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for counselor
-- ----------------------------
DROP TABLE IF EXISTS `counselor`;
CREATE TABLE `counselor`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号码',
  `face_url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像地址',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of counselor
-- ----------------------------
INSERT INTO `counselor` VALUES (666, '辅导员', '202cb962ac59075b964b07152d234b70', '123', '123', NULL, 2017, '计算机工程系');

-- ----------------------------
-- Table structure for dorm
-- ----------------------------
DROP TABLE IF EXISTS `dorm`;
CREATE TABLE `dorm`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dormNumber` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍号',
  `student_id` int(11) NOT NULL COMMENT '舍长学号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dorm
-- ----------------------------
INSERT INTO `dorm` VALUES (1, '中二#103', 0);
INSERT INTO `dorm` VALUES (2, '中二#104', 0);
INSERT INTO `dorm` VALUES (3, '中二#105', 0);
INSERT INTO `dorm` VALUES (4, '中二#106', 0);
INSERT INTO `dorm` VALUES (5, '中二#107', 0);
INSERT INTO `dorm` VALUES (6, '中二#108', 0);
INSERT INTO `dorm` VALUES (7, '中二#111', 0);
INSERT INTO `dorm` VALUES (8, '中二#112', 0);
INSERT INTO `dorm` VALUES (9, '中二#113', 0);
INSERT INTO `dorm` VALUES (10, '中二#114', 0);
INSERT INTO `dorm` VALUES (11, '中二#115', 0);
INSERT INTO `dorm` VALUES (12, '中二#116', 0);
INSERT INTO `dorm` VALUES (13, '中二#117', 0);
INSERT INTO `dorm` VALUES (14, '中二#118', 0);
INSERT INTO `dorm` VALUES (15, '中二#119', 0);
INSERT INTO `dorm` VALUES (16, '中二#120', 0);
INSERT INTO `dorm` VALUES (17, '中二#121', 0);
INSERT INTO `dorm` VALUES (18, '中二#122', 0);
INSERT INTO `dorm` VALUES (19, '中二#123', 0);
INSERT INTO `dorm` VALUES (20, '中二#201', 0);
INSERT INTO `dorm` VALUES (21, '中二#202', 0);
INSERT INTO `dorm` VALUES (22, '中二#203', 0);
INSERT INTO `dorm` VALUES (23, '中二#204', 0);
INSERT INTO `dorm` VALUES (24, '中二#205', 0);
INSERT INTO `dorm` VALUES (25, '中二#206', 0);
INSERT INTO `dorm` VALUES (26, '中二#207', 0);
INSERT INTO `dorm` VALUES (27, '中二#208', 0);
INSERT INTO `dorm` VALUES (28, '中二#209', 0);
INSERT INTO `dorm` VALUES (29, '中二#210', 0);
INSERT INTO `dorm` VALUES (30, '中二#213', 0);
INSERT INTO `dorm` VALUES (31, '中二#214', 0);
INSERT INTO `dorm` VALUES (32, '中二#215', 0);
INSERT INTO `dorm` VALUES (33, '中二#216', 0);
INSERT INTO `dorm` VALUES (34, '中二#217', 0);
INSERT INTO `dorm` VALUES (35, '中二#218', 0);
INSERT INTO `dorm` VALUES (36, '中二#219', 0);
INSERT INTO `dorm` VALUES (37, '中二#220', 0);
INSERT INTO `dorm` VALUES (38, '中二#221', 0);
INSERT INTO `dorm` VALUES (39, '中二#222', 0);
INSERT INTO `dorm` VALUES (40, '中二#223', 0);
INSERT INTO `dorm` VALUES (41, '中二#224', 0);
INSERT INTO `dorm` VALUES (42, '中二#225', 0);
INSERT INTO `dorm` VALUES (43, '中二#301', 0);
INSERT INTO `dorm` VALUES (44, '中二#302', 0);
INSERT INTO `dorm` VALUES (45, '中二#303', 0);
INSERT INTO `dorm` VALUES (46, '中二#304', 0);
INSERT INTO `dorm` VALUES (47, '中二#305', 0);
INSERT INTO `dorm` VALUES (48, '中二#306', 0);
INSERT INTO `dorm` VALUES (49, '中二#307', 0);
INSERT INTO `dorm` VALUES (50, '中二#308', 0);
INSERT INTO `dorm` VALUES (51, '中二#309', 0);
INSERT INTO `dorm` VALUES (52, '中二#310', 0);
INSERT INTO `dorm` VALUES (53, '中二#313', 0);
INSERT INTO `dorm` VALUES (54, '中二#314', 0);
INSERT INTO `dorm` VALUES (55, '中二#325', 0);
INSERT INTO `dorm` VALUES (56, '中二#411', 0);
INSERT INTO `dorm` VALUES (57, '东二#410', 0);
INSERT INTO `dorm` VALUES (58, '东二#411', 0);
INSERT INTO `dorm` VALUES (59, '东二#412', 0);
INSERT INTO `dorm` VALUES (60, '东二#413', 0);
INSERT INTO `dorm` VALUES (61, '东二#414', 0);
INSERT INTO `dorm` VALUES (62, '东二#415', 0);
INSERT INTO `dorm` VALUES (63, '东二#416', 0);
INSERT INTO `dorm` VALUES (64, '东二#417', 0);
INSERT INTO `dorm` VALUES (65, '东二#418', 0);
INSERT INTO `dorm` VALUES (66, '东二#419', 0);
INSERT INTO `dorm` VALUES (67, '东二#421', 0);
INSERT INTO `dorm` VALUES (68, '东二#422', 0);
INSERT INTO `dorm` VALUES (69, '东二#423', 0);
INSERT INTO `dorm` VALUES (70, '东二#424', 0);
INSERT INTO `dorm` VALUES (71, '东二#425', 0);
INSERT INTO `dorm` VALUES (72, '东二#426', 0);

-- ----------------------------
-- Table structure for record
-- ----------------------------
DROP TABLE IF EXISTS `record`;
CREATE TABLE `record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '照片地址',
  `dormNumber` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍号',
  `randNumber` int(11) NOT NULL COMMENT '随机号码',
  `startTime` datetime(0) NOT NULL COMMENT '开始时间',
  `uploadTime` datetime(0) NOT NULL COMMENT '上传时间',
  `endTime` datetime(0) NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of record
-- ----------------------------
INSERT INTO `record` VALUES (1, '123.jpg', '中二#203', 203, '2020-04-18 01:01:10', '2020-04-18 12:00:29', '2020-04-18 12:00:29');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `sex` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号码',
  `face_url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像地址',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES (211706174, '男', '中二#203', '202cb962ac59075b964b07152d234b70', '123', '123', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706173, '女', '东二#203', '202cb962ac59075b964b07152d234b70', '123', '123', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (666, '男', '辅导员', '202cb962ac59075b964b07152d234b70', '123', '123', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211707173, '女', '西二#203', '202cb962ac59075b964b07152d234b70', '123', '123', NULL, 2017, '经济管理系');

SET FOREIGN_KEY_CHECKS = 1;
