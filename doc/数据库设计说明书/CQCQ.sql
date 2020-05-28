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

 Date: 09/05/2020 23:44:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for counselor
-- ----------------------------
DROP TABLE IF EXISTS `counselor`;
CREATE TABLE `counselor`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生填宿舍号，辅导员填姓名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号码',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for dorm
-- ----------------------------
DROP TABLE IF EXISTS `dorm`;
CREATE TABLE `dorm`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `room` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dorm_num` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 71 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for record
-- ----------------------------
DROP TABLE IF EXISTS `record`;
CREATE TABLE `record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '照片地址',
  `dorm_id` int(11) NOT NULL COMMENT '宿舍号',
  `rand_num` int(11) NOT NULL COMMENT '随机号码',
  `start_time` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `upload_time` datetime(0) NULL DEFAULT NULL COMMENT '上传时间',
  `end_time` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `deleted` int(1) NULL DEFAULT 0 COMMENT '0：未删除，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `sex` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生填宿舍号，辅导员填姓名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
