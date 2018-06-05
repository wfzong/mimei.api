-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-06-05 22:49:11
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limpid`
--

-- --------------------------------------------------------

--
-- 表的结构 `water_access`
--

CREATE TABLE `water_access` (
  `article_id` int(6) UNSIGNED NOT NULL,
  `category_id` int(5) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `water_article`
--

CREATE TABLE `water_article` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'ID',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `artType` varchar(255) NOT NULL DEFAULT 'normal',
  `description` text NOT NULL,
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COMMENT '内容',
  `imgShow` tinytext,
  `imgContent` text,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `user_id` int(6) DEFAULT '0' COMMENT '作者id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章表';

-- --------------------------------------------------------

--
-- 表的结构 `water_category`
--

CREATE TABLE `water_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `water_files`
--

CREATE TABLE `water_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `fname` varchar(512) NOT NULL,
  `fkey` varchar(512) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `description` varchar(1024) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `water_profile`
--

CREATE TABLE `water_profile` (
  `id` int(6) UNSIGNED NOT NULL,
  `truename` varchar(25) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(6) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `water_user`
--

CREATE TABLE `water_user` (
  `id` int(6) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nickname` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  `ip` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `water_article`
--
ALTER TABLE `water_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `water_category`
--
ALTER TABLE `water_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `water_files`
--
ALTER TABLE `water_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `water_profile`
--
ALTER TABLE `water_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `water_user`
--
ALTER TABLE `water_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `water_article`
--
ALTER TABLE `water_article`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `water_category`
--
ALTER TABLE `water_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `water_files`
--
ALTER TABLE `water_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `water_profile`
--
ALTER TABLE `water_profile`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `water_user`
--
ALTER TABLE `water_user`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
