/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : cqcq

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 04/03/2021 00:41:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cq_dorm
-- ----------------------------
DROP TABLE IF EXISTS `cq_dorm`;
CREATE TABLE `cq_dorm`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `room` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dorm_num` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dorm_grade` int(4) NOT NULL,
  `dorm_dep` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 185 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_dorm
-- ----------------------------
INSERT INTO `cq_dorm` VALUES (1, '中二', '104', '中二#104', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (2, '中二', '105', '中二#105', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (3, '中二', '106', '中二#106', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (4, '中二', '107', '中二#107', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (6, '中二', '111', '中二#111', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (7, '中二', '112', '中二#112', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (8, '中二', '113', '中二#113', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (9, '中二', '114', '中二#114', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (10, '中二', '115', '中二#115', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (11, '中二', '116', '中二#116', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (12, '中二', '117', '中二#117', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (13, '中二', '118', '中二#118', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (14, '中二', '119', '中二#119', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (15, '中二', '120', '中二#120', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (16, '中二', '121', '中二#121', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (17, '中二', '122', '中二#122', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (18, '中二', '123', '中二#123', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (19, '中二', '201', '中二#201', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (20, '中二', '202', '中二#202', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (22, '中二', '204', '中二#204', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (23, '中二', '205', '中二#205', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (24, '中二', '206', '中二#206', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (25, '中二', '207', '中二#207', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (26, '中二', '208', '中二#208', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (27, '中二', '209', '中二#209', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (28, '中二', '210', '中二#210', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (29, '中二', '213', '中二#213', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (30, '中二', '214', '中二#214', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (31, '中二', '215', '中二#215', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (32, '中二', '216', '中二#216', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (33, '中二', '217', '中二#217', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (34, '中二', '218', '中二#218', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (35, '中二', '219', '中二#219', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (37, '中二', '221', '中二#221', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (38, '中二', '222', '中二#222', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (39, '中二', '223', '中二#223', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (40, '中二', '224', '中二#224', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (41, '中二', '225', '中二#225', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (42, '中二', '301', '中二#301', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (43, '中二', '302', '中二#302', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (44, '中二', '303', '中二#303', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (45, '中二', '304', '中二#304', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (46, '中二', '305', '中二#305', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (47, '中二', '306', '中二#306', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (48, '中二', '307', '中二#307', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (49, '中二', '308', '中二#308', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (50, '中二', '309', '中二#309', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (51, '中二', '310', '中二#310', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (52, '中二', '313', '中二#313', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (53, '中二', '314', '中二#314', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (54, '中二', '411', '中二#411', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (56, '东二', '411', '东二#411', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (57, '东二', '412', '东二#412', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (58, '东二', '413', '东二#413', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (59, '东二', '414', '东二#414', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (60, '东二', '415', '东二#415', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (61, '东二', '416', '东二#416', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (62, '东二', '417', '东二#417', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (63, '东二', '418', '东二#418', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (64, '东二', '419', '东二#419', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (65, '东二', '421', '东二#421', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (66, '东二', '422', '东二#422', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (67, '东二', '423', '东二#423', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (68, '东二', '424', '东二#424', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (69, '东二', '425', '东二#425', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (70, '东二', '426', '东二#426', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (72, '中二', '103', '中二#103', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (162, '东二', '430', '东二#430', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (160, '中二', '615', '中二#615', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (159, '中二', '614', '中二#614', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (158, '中二', '613', '中二#613', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (157, '中二', '612', '中二#612', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (156, '中二', '611', '中二#611', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (21, '中二', '203', '中二#203', 2017, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (163, '中二', '203', '中二#203', 2016, '计算机工程系');
INSERT INTO `cq_dorm` VALUES (55, '东二', '410', '东二#410', 2017, '计算机工程系');

-- ----------------------------
-- Table structure for cq_instructor
-- ----------------------------
DROP TABLE IF EXISTS `cq_instructor`;
CREATE TABLE `cq_instructor`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_instructor
-- ----------------------------
INSERT INTO `cq_instructor` VALUES (1234, 'instructor', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 2017, '计算机工程系', NULL);

-- ----------------------------
-- Table structure for cq_notice
-- ----------------------------
DROP TABLE IF EXISTS `cq_notice`;
CREATE TABLE `cq_notice`  (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '通知编号',
  `instructor_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '辅导员学工号',
  `start_time` datetime(0) NOT NULL COMMENT '查寝开始时间',
  `end_time` datetime(0) NOT NULL COMMENT '查寝结束时间',
  `send_time` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '邮件发送时间',
  PRIMARY KEY (`notice_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cq_record
-- ----------------------------
DROP TABLE IF EXISTS `cq_record`;
CREATE TABLE `cq_record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '照片地址',
  `dorm_id` int(11) NOT NULL COMMENT '宿舍号',
  `rand_num` int(11) NOT NULL COMMENT '随机号码',
  `start_time` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `upload_time` datetime(0) NULL DEFAULT NULL COMMENT '上传时间',
  `end_time` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `deleted` int(1) NULL DEFAULT 0 COMMENT '0：未删除，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cq_result
-- ----------------------------
DROP TABLE IF EXISTS `cq_result`;
CREATE TABLE `cq_result`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NULL DEFAULT NULL,
  `record_id` int(11) NULL DEFAULT NULL,
  `sign` int(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cq_setting
-- ----------------------------
DROP TABLE IF EXISTS `cq_setting`;
CREATE TABLE `cq_setting`  (
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键字',
  `decribe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述',
  `values` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '以Json形式存储APIKey和secretKey',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_setting
-- ----------------------------
INSERT INTO `cq_setting` VALUES ('face', '百度人脸识别', NULL, '2021-03-03 17:43:51');
INSERT INTO `cq_setting` VALUES ('mail', '阿里云邮件推送', NULL, '2021-03-03 17:45:40');
INSERT INTO `cq_setting` VALUES ('sms', '阿里云短信服务', NULL, '2021-03-03 17:45:23');
INSERT INTO `cq_setting` VALUES ('wxapp', '微信小程序', NULL, '2021-03-02 11:08:35');

-- ----------------------------
-- Table structure for cq_student
-- ----------------------------
DROP TABLE IF EXISTS `cq_student`;
CREATE TABLE `cq_student`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `sex` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电子邮箱',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系别',
  `dorm` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍',
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信用户id',
  `face` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '人脸库照片地址',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cq_student
-- ----------------------------
INSERT INTO `cq_student` VALUES (211706113, '男', '中二#203', '181d4bd3248fcfa67c4df776ad417fb9', NULL, NULL, 2017, '计算机工程系', '中二#203', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706506, '女', '东二#426', '74fd1758e861b3065b2b38f90f198da0', NULL, NULL, 2017, '计算机工程系', '东二#426', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706507, '女', '东二#425', 'e1332cce4879213691905ecb1fdb2c2c', NULL, NULL, 2017, '计算机工程系', '东二#425', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706367, '女', '东二#424', 'af9f739c2e6fe92029b590b0c464fb4b', NULL, NULL, 2017, '计算机工程系', '东二#424', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706510, '女', '东二#423', '3c69d184e837886a9ae4e445f7ad07a1', NULL, NULL, 2017, '计算机工程系', '东二#423', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706540, '女', '东二#422', 'b133f7416aa71bb04bdfe316b83a2009', NULL, NULL, 2017, '计算机工程系', '东二#422', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706524, '女', '东二#421', '5b74addb0a7f16327ccc4604a1381d11', NULL, NULL, 2017, '计算机工程系', '东二#421', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706350, '女', '东二#419', 'c1f08bdfb290ba5af188a6ccd326d6ea', NULL, NULL, 2017, '计算机工程系', '东二#419', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706419, '女', '东二#418', '4de20386c8d2dbaa0546ae954bfd37c6', NULL, NULL, 2017, '计算机工程系', '东二#418', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706334, '女', '东二#417', '093feb164037202d96aef3c4263ebfe1', NULL, NULL, 2017, '计算机工程系', '东二#417', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706377, '女', '东二#416', '92b6bd604e5e778d92a8b2d3a82e242f', NULL, NULL, 2017, '计算机工程系', '东二#416', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706106, '女', '东二#415', 'd25c35e7ce94789fff720413c370ed9c', NULL, NULL, 2017, '计算机工程系', '东二#415', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706153, '女', '东二#414', '802b27c25618f1bc91c4616e360cdde5', NULL, NULL, 2017, '计算机工程系', '东二#414', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706509, '女', '东二#413', '965c10b2379b996cb13ef4dd5f4f66d7', NULL, NULL, 2017, '计算机工程系', '东二#413', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706104, '女', '东二#412', '3cd44670517172444e01b5cc5805150b', NULL, NULL, 2017, '计算机工程系', '东二#412', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706152, '女', '东二#411', 'e2ff8b5d8eff639cc9c2c059eaddb880', NULL, NULL, 2017, '计算机工程系', '东二#411', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706130, '女', '东二#410', '7195780710084252128d88be474e2301', NULL, NULL, 2017, '计算机工程系', '东二#410', NULL, NULL);
INSERT INTO `cq_student` VALUES (211701148, '男', '中二#411', '801589e83f705f4a0cb62e05a8786659', NULL, NULL, 2017, '计算机工程系', '中二#411', NULL, NULL);
INSERT INTO `cq_student` VALUES (211701165, '男', '中二#314', '947001e31da88d9ab232e11dd806c275', NULL, NULL, 2017, '计算机工程系', '中二#314', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706400, '男', '中二#313', '279f4b3311b45d5bdfc33a9a3a98eb95', NULL, NULL, 2017, '计算机工程系', '中二#313', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706307, '男', '中二#310', 'c41f856187616b7cd243081725ad200d', NULL, NULL, 2017, '计算机工程系', '中二#310', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706410, '男', '中二#309', '628de8ce8102ee70cea7b9dba657418e', NULL, NULL, 2017, '计算机工程系', '中二#309', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706333, '男', '中二#308', '55a575ffe8b38f089c5b6ab4fa62f974', NULL, NULL, 2017, '计算机工程系', '中二#308', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706303, '男', '中二#307', 'a9d5e09a9e07ef91313027ae17d34ddd', NULL, NULL, 2017, '计算机工程系', '中二#307', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706325, '男', '中二#306', '1044d2b4571cc1f60b462663ae7dcb03', NULL, NULL, 2017, '计算机工程系', '中二#306', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706316, '男', '中二#305', 'dc80ff23aa860ad0912390fbda9ece81', NULL, NULL, 2017, '计算机工程系', '中二#305', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706343, '男', '中二#304', '9b260f0b4fbad313028bade5e67513aa', NULL, NULL, 2017, '计算机工程系', '中二#304', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706310, '男', '中二#303', '8d78d41477e7515580a9bf2cfb17053d', NULL, NULL, 2017, '计算机工程系', '中二#303', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706346, '男', '中二#302', '3a1f54b665339333156710871b8c642c', NULL, NULL, 2017, '计算机工程系', '中二#302', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706402, '男', '中二#301', 'a448dd9ad907ae21234f2dc685749ec3', NULL, NULL, 2017, '计算机工程系', '中二#301', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706407, '男', '中二#225', '8705355c94d6233b305b53ab814be57b', NULL, NULL, 2017, '计算机工程系', '中二#225', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706345, '男', '中二#224', '742cd9906d8ad0b9470a0e9353b88533', NULL, NULL, 2017, '计算机工程系', '中二#224', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706326, '男', '中二#223', '6571f2cd107e98a56ecdf8cc50e72053', NULL, NULL, 2017, '计算机工程系', '中二#223', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706328, '男', '中二#222', 'f35a4f5ab724b181d24dad9766efe919', NULL, NULL, 2017, '计算机工程系', '中二#222', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706366, '男', '中二#221', '341b23d9abd33924236c6835351c9e9e', NULL, NULL, 2017, '计算机工程系', '中二#221', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706318, '男', '中二#220', '3a0ba37a9c8988350996c250830fb824', NULL, NULL, 2017, '计算机工程系', '中二#220', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706381, '男', '中二#219', 'a587124c9782a0bc99565a91e391c90d', NULL, NULL, 2017, '计算机工程系', '中二#219', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706382, '男', '中二#218', '192700a8611cf8b05104a5694be51bef', NULL, NULL, 2017, '计算机工程系', '中二#218', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706364, '男', '中二#217', '7b1932a6b7d994aa50097250c0f19279', NULL, NULL, 2017, '计算机工程系', '中二#217', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706351, '男', '中二#216', '7f3ac17c519eaf2a7093fc090fff5477', NULL, NULL, 2017, '计算机工程系', '中二#216', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706396, '男', '中二#215', '67cf9599fdc543c2c3342a5d02c3999e', NULL, NULL, 2017, '计算机工程系', '中二#215', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706388, '男', '中二#214', '4cd789d17fdb4719238225fc65ecbb99', NULL, NULL, 2017, '计算机工程系', '中二#214', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706413, '男', '中二#213', '6eb86a78c55602708d86984005cbd43f', NULL, NULL, 2017, '计算机工程系', '中二#213', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706542, '男', '中二#210', '1c9936a66fc64c71f2871495b4c4069b', NULL, NULL, 2017, '计算机工程系', '中二#210', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706541, '男', '中二#209', '76b61781e6ec47258474bb7dd25e2c67', NULL, NULL, 2017, '计算机工程系', '中二#209', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706548, '男', '中二#208', '69416ea78118b24472dc20268aac08e6', NULL, NULL, 2017, '计算机工程系', '中二#208', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706511, '男', '中二#207', '2343d21b6ad6d2f23b63f939468ad445', NULL, NULL, 2017, '计算机工程系', '中二#207', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706543, '男', '中二#206', 'cf36ff5d21366b8a590b94ea0d203cf7', NULL, NULL, 2017, '计算机工程系', '中二#206', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706522, '男', '中二#205', '381d14e08c7c93e9bab90d33933ef3b9', NULL, NULL, 2017, '计算机工程系', '中二#205', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706117, '男', '中二#204', 'd053f1aa35e84a17bc6ddeed958b0921', NULL, NULL, 2017, '计算机工程系', '中二#204', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706174, '男', '中二#203', 'd41d8cd98f00b204e9800998ecf8427e', NULL, NULL, 2017, '计算机工程系', '中二#203', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706144, '男', '中二#202', '36e32b2cc50a844b7c2e4e976539051a', NULL, NULL, 2017, '计算机工程系', '中二#202', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706143, '男', '中二#201', '1ffcfd30982d9b429d7fa9413e64361e', NULL, NULL, 2017, '计算机工程系', '中二#201', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706112, '男', '中二#123', 'fa5cec385222717a0fd1cadfbbb8ca3e', NULL, NULL, 2017, '计算机工程系', '中二#123', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706158, '男', '中二#122', '6832ad7e56b0ac10da684c5e45f33839', NULL, NULL, 2017, '计算机工程系', '中二#122', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706107, '男', '中二#121', '42f177cd4b267b25a3e666b4ab05143d', NULL, NULL, 2017, '计算机工程系', '中二#121', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706220, '男', '中二#120', 'c99adb8d8f9eabffdce95cba809b7cbc', NULL, NULL, 2017, '计算机工程系', '中二#120', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706188, '男', '中二#119', '9cc6ff21be13ac9e5ef9277d4b917d60', NULL, NULL, 2017, '计算机工程系', '中二#119', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706170, '男', '中二#118', 'faa2ff18b3dc93f9bee076e7eea8d741', NULL, NULL, 2017, '计算机工程系', '中二#118', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706217, '男', '中二#117', 'b4db4ef69b5761dca82c05fd2fa9d095', NULL, NULL, 2017, '计算机工程系', '中二#117', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706214, '男', '中二#116', 'b0000dd728c356e2ef96ce8d09fcea09', NULL, NULL, 2017, '计算机工程系', '中二#116', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706190, '男', '中二#113', '80dacf798ff7056242d7573399fd40ea', NULL, NULL, 2017, '计算机工程系', '中二#113', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706124, '男', '中二#114', 'f0c1e84d389bbf6c29511195b0dab0f7', NULL, NULL, 2017, '计算机工程系', '中二#114', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706148, '男', '中二#115', '2f6690dc1bbf591b10eac6c73361dd22', NULL, NULL, 2017, '计算机工程系', '中二#115', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706164, '男', '中二#112', 'a891251a40cc5513dbb0532aab4a749a', NULL, NULL, 2017, '计算机工程系', '中二#112', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706145, '男', '中二#111', '4161034411c142683540734e09658566', NULL, NULL, 2017, '计算机工程系', '中二#111', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706219, '男', '中二#108', 'c160dc62ca9bd990412f00ddb423a371', NULL, NULL, 2017, '计算机工程系', '中二#108', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706154, '男', '中二#107', 'd166876d0ec9e335360b52d3c4cfafda', NULL, NULL, 2017, '计算机工程系', '中二#107', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706168, '男', '中二#104', 'c49497b124be3af1929e40f4fc9dcf75', NULL, NULL, 2017, '计算机工程系', '中二#104', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706216, '男', '中二#105', '8bec4bd987afbd924eb9f06f93c2a354', NULL, NULL, 2017, '计算机工程系', '中二#105', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706191, '男', '中二#106', '41899ad4016c0aebc49ab5605b728a94', NULL, NULL, 2017, '计算机工程系', '中二#106', NULL, NULL);
INSERT INTO `cq_student` VALUES (202006104, '女', '中二#614', 'd41d8cd98f00b204e9800998ecf8427e', NULL, NULL, 2017, '计算机工程系', '中二#614', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706161, '女', '东二#411', 'fc35ec668681a8c025154b88de1decd3', NULL, NULL, 2017, '计算机工程系', '东二#411', NULL, NULL);
INSERT INTO `cq_student` VALUES (211606174, '男', '中二#203', '959befc89cd1f6bb8222de4d3b72cd13', NULL, NULL, 2016, '计算机工程系', '中二#203', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706206, '女', '东二#410', 'd41d8cd98f00b204e9800998ecf8427e', NULL, NULL, 2017, '计算机工程系', '东二#410', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706208, '男', '中二#203', 'd50f279cc4c2266b0a87ad5f192c116d', NULL, NULL, 2017, '计算机工程系', '中二#203', NULL, NULL);
INSERT INTO `cq_student` VALUES (211706187, '男', '中二#203', 'bf5a350fbf3d3e6430831fe72b24f1e4', NULL, NULL, 2017, '计算机工程系', '中二#203', NULL, NULL);
