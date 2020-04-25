/*
 Navicat Premium Data Transfer

 Source Server         : oeong
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : cqcq

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 25/04/2020 12:19:59
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
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `block` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `room` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dormNumber` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `student_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dorm
-- ----------------------------
INSERT INTO `dorm` VALUES ('1', '中二', '103', '中二#103', '211706001');
INSERT INTO `dorm` VALUES ('2', '中二', '104', '中二#104', '211706002');
INSERT INTO `dorm` VALUES ('3', '中二', '105', '中二#105', '211706003');
INSERT INTO `dorm` VALUES ('4', '中二', '106', '中二#106', '211706004');
INSERT INTO `dorm` VALUES ('5', '中二', '107', '中二#107', '211706005');
INSERT INTO `dorm` VALUES ('6', '中二', '108', '中二#108', '211706006');
INSERT INTO `dorm` VALUES ('7', '中二', '111', '中二#111', '211706007');
INSERT INTO `dorm` VALUES ('8', '中二', '112', '中二#112', '211706008');
INSERT INTO `dorm` VALUES ('9', '中二', '113', '中二#113', '211706009');
INSERT INTO `dorm` VALUES ('10', '中二', '114', '中二#114', '211706010');
INSERT INTO `dorm` VALUES ('11', '中二', '115', '中二#115', '211706011');
INSERT INTO `dorm` VALUES ('12', '中二', '116', '中二#116', '211706012');
INSERT INTO `dorm` VALUES ('13', '中二', '117', '中二#117', '211706013');
INSERT INTO `dorm` VALUES ('14', '中二', '118', '中二#118', '211706014');
INSERT INTO `dorm` VALUES ('15', '中二', '119', '中二#119', '211706015');
INSERT INTO `dorm` VALUES ('16', '中二', '120', '中二#120', '211706016');
INSERT INTO `dorm` VALUES ('17', '中二', '121', '中二#121', '211706017');
INSERT INTO `dorm` VALUES ('18', '中二', '122', '中二#122', '211706018');
INSERT INTO `dorm` VALUES ('19', '中二', '123', '中二#123', '211706019');
INSERT INTO `dorm` VALUES ('20', '中二', '201', '中二#201', '211706020');
INSERT INTO `dorm` VALUES ('21', '中二', '202', '中二#202', '211706021');
INSERT INTO `dorm` VALUES ('22', '中二', '203', '中二#203', '211706022');
INSERT INTO `dorm` VALUES ('23', '中二', '204', '中二#204', '211706023');
INSERT INTO `dorm` VALUES ('24', '中二', '205', '中二#205', '211706024');
INSERT INTO `dorm` VALUES ('25', '中二', '206', '中二#206', '211706025');
INSERT INTO `dorm` VALUES ('26', '中二', '207', '中二#207', '211706026');
INSERT INTO `dorm` VALUES ('27', '中二', '208', '中二#208', '211706027');
INSERT INTO `dorm` VALUES ('28', '中二', '209', '中二#209', '211706028');
INSERT INTO `dorm` VALUES ('29', '中二', '210', '中二#210', '211706029');
INSERT INTO `dorm` VALUES ('30', '中二', '213', '中二#213', '211706030');
INSERT INTO `dorm` VALUES ('31', '中二', '214', '中二#214', '211706031');
INSERT INTO `dorm` VALUES ('32', '中二', '215', '中二#215', '211706032');
INSERT INTO `dorm` VALUES ('33', '中二', '216', '中二#216', '211706033');
INSERT INTO `dorm` VALUES ('34', '中二', '217', '中二#217', '211706034');
INSERT INTO `dorm` VALUES ('35', '中二', '218', '中二#218', '211706035');
INSERT INTO `dorm` VALUES ('36', '中二', '219', '中二#219', '211706036');
INSERT INTO `dorm` VALUES ('37', '中二', '220', '中二#220', '211706037');
INSERT INTO `dorm` VALUES ('38', '中二', '221', '中二#221', '211706038');
INSERT INTO `dorm` VALUES ('39', '中二', '222', '中二#222', '211706039');
INSERT INTO `dorm` VALUES ('40', '中二', '223', '中二#223', '211706040');
INSERT INTO `dorm` VALUES ('41', '中二', '224', '中二#224', '211706041');
INSERT INTO `dorm` VALUES ('42', '中二', '225', '中二#225', '211706042');
INSERT INTO `dorm` VALUES ('43', '中二', '301', '中二#301', '211706043');
INSERT INTO `dorm` VALUES ('44', '中二', '302', '中二#302', '211706044');
INSERT INTO `dorm` VALUES ('45', '中二', '303', '中二#303', '211706045');
INSERT INTO `dorm` VALUES ('46', '中二', '304', '中二#304', '211706046');
INSERT INTO `dorm` VALUES ('47', '中二', '305', '中二#305', '211706047');
INSERT INTO `dorm` VALUES ('48', '中二', '306', '中二#306', '211706048');
INSERT INTO `dorm` VALUES ('49', '中二', '307', '中二#307', '211706049');
INSERT INTO `dorm` VALUES ('50', '中二', '308', '中二#308', '211706050');
INSERT INTO `dorm` VALUES ('51', '中二', '309', '中二#309', '211706051');
INSERT INTO `dorm` VALUES ('52', '中二', '310', '中二#310', '211706052');
INSERT INTO `dorm` VALUES ('53', '中二', '313', '中二#313', '211706053');
INSERT INTO `dorm` VALUES ('54', '中二', '314', '中二#314', '211706054');
INSERT INTO `dorm` VALUES ('55', '中二', '325', '中二#325', '211706055');
INSERT INTO `dorm` VALUES ('56', '中二', '411', '中二#411', '211706056');
INSERT INTO `dorm` VALUES ('57', '东二', '410', '东二#410', '211706057');
INSERT INTO `dorm` VALUES ('58', '东二', '411', '东二#411', '211706058');
INSERT INTO `dorm` VALUES ('59', '东二', '412', '东二#412', '211706059');
INSERT INTO `dorm` VALUES ('60', '东二', '413', '东二#413', '211706060');
INSERT INTO `dorm` VALUES ('61', '东二', '414', '东二#414', '211706061');
INSERT INTO `dorm` VALUES ('62', '东二', '415', '东二#415', '211706062');
INSERT INTO `dorm` VALUES ('63', '东二', '416', '东二#416', '211706063');
INSERT INTO `dorm` VALUES ('64', '东二', '417', '东二#417', '211706064');
INSERT INTO `dorm` VALUES ('65', '东二', '418', '东二#418', '211706065');
INSERT INTO `dorm` VALUES ('66', '东二', '419', '东二#419', '211706066');
INSERT INTO `dorm` VALUES ('67', '东二', '421', '东二#421', '211706067');
INSERT INTO `dorm` VALUES ('68', '东二', '422', '东二#422', '211706068');
INSERT INTO `dorm` VALUES ('69', '东二', '423', '东二#423', '211706069');
INSERT INTO `dorm` VALUES ('70', '东二', '424', '东二#424', '211706070');
INSERT INTO `dorm` VALUES ('71', '东二', '425', '东二#425', '211706071');
INSERT INTO `dorm` VALUES ('72', '东二', '426', '东二#426', '211706072');

-- ----------------------------
-- Table structure for record
-- ----------------------------
DROP TABLE IF EXISTS `record`;
CREATE TABLE `record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '照片地址',
  `dorm_id` int(11) NOT NULL COMMENT '宿舍号',
  `randNumber` int(11) NOT NULL COMMENT '随机号码',
  `startTime` datetime(0) NOT NULL COMMENT '开始时间',
  `uploadTime` datetime(0) NOT NULL COMMENT '上传时间',
  `endTime` datetime(0) NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `id` int(11) NOT NULL COMMENT '学号',
  `sex` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `username` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生填宿舍号，辅导员填姓名',
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
INSERT INTO `student` VALUES (211706001, '男', '中二#103', '202cb962ac59075b964b07152d234b70', '123450001@mail.com', '17720760001', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706002, '男', '中二#104', '202cb962ac59075b964b07152d234b70', '123450002@mail.com', '17720760002', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706003, '男', '中二#105', '202cb962ac59075b964b07152d234b70', '123450003@mail.com', '17720760003', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706004, '男', '中二#106', '202cb962ac59075b964b07152d234b70', '123450004@mail.com', '17720760004', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706005, '男', '中二#107', '202cb962ac59075b964b07152d234b70', '123450005@mail.com', '17720760005', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706006, '男', '中二#108', '202cb962ac59075b964b07152d234b70', '123450006@mail.com', '17720760006', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706007, '男', '中二#111', '202cb962ac59075b964b07152d234b70', '123450007@mail.com', '17720760007', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706008, '男', '中二#112', '202cb962ac59075b964b07152d234b70', '123450008@mail.com', '17720760008', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706009, '男', '中二#113', '202cb962ac59075b964b07152d234b70', '123450009@mail.com', '17720760009', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706010, '男', '中二#114', '202cb962ac59075b964b07152d234b70', '123450010@mail.com', '17720760010', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706011, '男', '中二#115', '202cb962ac59075b964b07152d234b70', '123450011@mail.com', '17720760011', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706012, '男', '中二#116', '202cb962ac59075b964b07152d234b70', '123450012@mail.com', '17720760012', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706013, '男', '中二#117', '202cb962ac59075b964b07152d234b70', '123450013@mail.com', '17720760013', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706014, '男', '中二#118', '202cb962ac59075b964b07152d234b70', '123450014@mail.com', '17720760014', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706015, '男', '中二#119', '202cb962ac59075b964b07152d234b70', '123450015@mail.com', '17720760015', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706016, '男', '中二#120', '202cb962ac59075b964b07152d234b70', '123450016@mail.com', '17720760016', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706017, '男', '中二#121', '202cb962ac59075b964b07152d234b70', '123450017@mail.com', '17720760017', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706018, '男', '中二#122', '202cb962ac59075b964b07152d234b70', '123450018@mail.com', '17720760018', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706019, '男', '中二#123', '202cb962ac59075b964b07152d234b70', '123450019@mail.com', '17720760019', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706020, '男', '中二#201', '202cb962ac59075b964b07152d234b70', '123450020@mail.com', '17720760020', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706021, '男', '中二#202', '202cb962ac59075b964b07152d234b70', '123450021@mail.com', '17720760021', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706022, '男', '中二#203', '202cb962ac59075b964b07152d234b70', '123450022@mail.com', '17720760022', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706023, '男', '中二#204', '202cb962ac59075b964b07152d234b70', '123450023@mail.com', '17720760023', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706024, '男', '中二#205', '202cb962ac59075b964b07152d234b70', '123450024@mail.com', '17720760024', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706025, '男', '中二#206', '202cb962ac59075b964b07152d234b70', '123450025@mail.com', '17720760025', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706026, '男', '中二#207', '202cb962ac59075b964b07152d234b70', '123450026@mail.com', '17720760026', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706027, '男', '中二#208', '202cb962ac59075b964b07152d234b70', '123450027@mail.com', '17720760027', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706028, '男', '中二#209', '202cb962ac59075b964b07152d234b70', '123450028@mail.com', '17720760028', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706029, '男', '中二#210', '202cb962ac59075b964b07152d234b70', '123450029@mail.com', '17720760029', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706030, '男', '中二#213', '202cb962ac59075b964b07152d234b70', '123450030@mail.com', '17720760030', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706031, '男', '中二#214', '202cb962ac59075b964b07152d234b70', '123450031@mail.com', '17720760031', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706032, '男', '中二#215', '202cb962ac59075b964b07152d234b70', '123450032@mail.com', '17720760032', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706033, '男', '中二#216', '202cb962ac59075b964b07152d234b70', '123450033@mail.com', '17720760033', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706034, '男', '中二#217', '202cb962ac59075b964b07152d234b70', '123450034@mail.com', '17720760034', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706035, '男', '中二#218', '202cb962ac59075b964b07152d234b70', '123450035@mail.com', '17720760035', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706036, '男', '中二#219', '202cb962ac59075b964b07152d234b70', '123450036@mail.com', '17720760036', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706037, '男', '中二#220', '202cb962ac59075b964b07152d234b70', '123450037@mail.com', '17720760037', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706038, '男', '中二#221', '202cb962ac59075b964b07152d234b70', '123450038@mail.com', '17720760038', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706039, '男', '中二#222', '202cb962ac59075b964b07152d234b70', '123450039@mail.com', '17720760039', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706040, '男', '中二#223', '202cb962ac59075b964b07152d234b70', '123450040@mail.com', '17720760040', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706041, '男', '中二#224', '202cb962ac59075b964b07152d234b70', '123450041@mail.com', '17720760041', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706042, '男', '中二#225', '202cb962ac59075b964b07152d234b70', '123450042@mail.com', '17720760042', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706043, '男', '中二#301', '202cb962ac59075b964b07152d234b70', '123450043@mail.com', '17720760043', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706044, '男', '中二#302', '202cb962ac59075b964b07152d234b70', '123450044@mail.com', '17720760044', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706045, '男', '中二#303', '202cb962ac59075b964b07152d234b70', '123450045@mail.com', '17720760045', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706046, '男', '中二#304', '202cb962ac59075b964b07152d234b70', '123450046@mail.com', '17720760046', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706047, '男', '中二#305', '202cb962ac59075b964b07152d234b70', '123450047@mail.com', '17720760047', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706048, '男', '中二#306', '202cb962ac59075b964b07152d234b70', '123450048@mail.com', '17720760048', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706049, '男', '中二#307', '202cb962ac59075b964b07152d234b70', '123450049@mail.com', '17720760049', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706050, '男', '中二#308', '202cb962ac59075b964b07152d234b70', '123450050@mail.com', '17720760050', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706051, '男', '中二#309', '202cb962ac59075b964b07152d234b70', '123450051@mail.com', '17720760051', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706052, '男', '中二#310', '202cb962ac59075b964b07152d234b70', '123450052@mail.com', '17720760052', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706053, '男', '中二#313', '202cb962ac59075b964b07152d234b70', '123450053@mail.com', '17720760053', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706054, '男', '中二#314', '202cb962ac59075b964b07152d234b70', '123450054@mail.com', '17720760054', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706055, '男', '中二#325', '202cb962ac59075b964b07152d234b70', '123450055@mail.com', '17720760055', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706056, '男', '中二#411', '202cb962ac59075b964b07152d234b70', '123450056@mail.com', '17720760056', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706057, '女', '东二#410', '202cb962ac59075b964b07152d234b70', '123450057@mail.com', '17720760057', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706058, '女', '东二#411', '202cb962ac59075b964b07152d234b70', '123450058@mail.com', '17720760058', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706059, '女', '东二#412', '202cb962ac59075b964b07152d234b70', '123450059@mail.com', '17720760059', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706060, '女', '东二#413', '202cb962ac59075b964b07152d234b70', '123450060@mail.com', '17720760060', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706061, '女', '东二#414', '202cb962ac59075b964b07152d234b70', '123450061@mail.com', '17720760061', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706062, '女', '东二#415', '202cb962ac59075b964b07152d234b70', '123450062@mail.com', '17720760062', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706063, '女', '东二#416', '202cb962ac59075b964b07152d234b70', '123450063@mail.com', '17720760063', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706064, '女', '东二#417', '202cb962ac59075b964b07152d234b70', '123450064@mail.com', '17720760064', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706065, '女', '东二#418', '202cb962ac59075b964b07152d234b70', '123450065@mail.com', '17720760065', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706066, '女', '东二#419', '202cb962ac59075b964b07152d234b70', '123450066@mail.com', '17720760066', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706067, '女', '东二#421', '202cb962ac59075b964b07152d234b70', '123450067@mail.com', '17720760067', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706068, '女', '东二#422', '202cb962ac59075b964b07152d234b70', '123450068@mail.com', '17720760068', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706069, '女', '东二#423', '202cb962ac59075b964b07152d234b70', '123450069@mail.com', '17720760069', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706070, '女', '东二#424', '202cb962ac59075b964b07152d234b70', '123450070@mail.com', '17720760070', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706071, '女', '东二#425', '202cb962ac59075b964b07152d234b70', '123450071@mail.com', '17720760071', NULL, 2017, '计算机工程系');
INSERT INTO `student` VALUES (211706072, '女', '东二#426', '202cb962ac59075b964b07152d234b70', '123450072@mail.com', '17720760072', NULL, 2017, '计算机工程系');

SET FOREIGN_KEY_CHECKS = 1;
