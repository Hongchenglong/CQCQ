-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-04-10 09:10:09
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
-- 数据库： `cqcq`
--

-- --------------------------------------------------------

--
-- 表的结构 `dorm`
--

CREATE TABLE `dorm` (
  `id` int(11) NOT NULL,
  `sex` varchar(8) NOT NULL,
  `dormNumber` varchar(16) NOT NULL COMMENT '宿舍号',
  `studentId` int(9) NOT NULL COMMENT '舍长学号',
  `grade` int(4) NOT NULL COMMENT '年级',
  `department` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dorm`
--

INSERT INTO `dorm` (`id`, `sex`, `dormNumber`, `studentId`, `grade`, `department`) VALUES
(1, '男', '中二#203', 0, 2017, '计算机工程系'),
(2, '男', '中二#202', 0, 2017, '经济管理系'),
(3, '女', '东二#411', 0, 2017, '计算机工程系'),
(4, '男', '中二#103', 0, 2017, '计算机工程系'),
(5, '男', '中二#104', 0, 2017, '土木系'),
(6, '男', '中二#105', 0, 2017, '计算机工程系'),
(7, '男', '中二#106', 0, 2017, '计算机工程系'),
(8, '女', '东二#410', 0, 2017, '计算机工程系'),
(9, '女', '东二#412', 0, 2017, '计算机工程系');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL COMMENT '学生填宿舍号，辅导员填姓名',
  `password` varchar(32) NOT NULL COMMENT '密码，md5加密',
  `email` varchar(32) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `face_url` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `phone`, `face_url`) VALUES
(1, '中二#203', '202cb962ac59075b964b07152d234b70', '8', '17720762997', NULL),
(2, '中二#203', '202cb962ac59075b964b07152d234b70', '84', '17720762994', NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `dorm`
--
ALTER TABLE `dorm`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dorm`
--
ALTER TABLE `dorm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
