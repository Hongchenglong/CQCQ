-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-04-18 13:33:01
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cqtest`
--

-- --------------------------------------------------------

--
-- 表的结构 `dorm`
--

CREATE TABLE `dorm` (
  `dormId` int(11) NOT NULL,
  `dormNumber` varchar(16) NOT NULL COMMENT '宿舍号',
  `studentId` int(11) NOT NULL COMMENT '舍长学号'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `record`
--

CREATE TABLE `record` (
  `recordId` int(11) NOT NULL,
  `photo` varchar(128) NOT NULL COMMENT '照片地址',
  `dormNumber` varchar(16) NOT NULL COMMENT '宿舍号',
  `randNumber` int(11) NOT NULL COMMENT '随机号码',
  `startTime` datetime NOT NULL COMMENT '开始时间',
  `uploadTime` datetime NOT NULL COMMENT '上传时间',
  `endTime` datetime NOT NULL COMMENT '结束时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL COMMENT '学生填学号，辅导员填学工号',
  `role` int(1) NOT NULL COMMENT '0表示学生，1表示辅导员',
  `sex` varchar(2) NOT NULL COMMENT '性别',
  `username` varchar(16) NOT NULL COMMENT '学生填宿舍号，辅导员填姓名',
  `password` varchar(32) NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) NOT NULL COMMENT '电子邮箱',
  `phone` varchar(11) NOT NULL COMMENT '手机号码',
  `face_url` varchar(250) DEFAULT NULL COMMENT '头像地址',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(16) NOT NULL COMMENT '系别'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `dorm`
--
ALTER TABLE `dorm`
  ADD PRIMARY KEY (`dormId`) USING BTREE;

--
-- 表的索引 `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`recordId`) USING BTREE;

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dorm`
--
ALTER TABLE `dorm`
  MODIFY `dormId` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `record`
--
ALTER TABLE `record`
  MODIFY `recordId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
