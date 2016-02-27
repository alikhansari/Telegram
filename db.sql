-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2016 at 09:24 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `buttons`
--

CREATE TABLE IF NOT EXISTS `buttons` (
`id` bigint(20) NOT NULL,
  `caption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `img_array` text COLLATE utf8_persian_ci,
  `doc_array` text COLLATE utf8_persian_ci,
  `feed_id` bigint(20) DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:active;0:disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
`id` bigint(20) NOT NULL,
  `doc_id` text COLLATE utf8_persian_ci NOT NULL,
  `title` text COLLATE utf8_persian_ci NOT NULL,
  `mime` text COLLATE utf8_persian_ci NOT NULL,
  `size` int(11) NOT NULL,
  `type` text COLLATE utf8_persian_ci NOT NULL,
  `tag` text COLLATE utf8_persian_ci,
  `regdate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
`id` bigint(20) NOT NULL,
  `url` text COLLATE utf8_persian_ci NOT NULL,
  `cnt` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_options`
--

CREATE TABLE IF NOT EXISTS `general_options` (
`id` bigint(20) NOT NULL,
  `key` text COLLATE utf8_persian_ci NOT NULL,
  `info` text COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `general_options`
--

INSERT INTO `general_options` (`id`, `key`, `info`, `status`) VALUES
(1, 'main_cols', '3', 1),
(2, 'sub_cols', '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` bigint(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_title` text COLLATE utf8_persian_ci,
  `regdate` int(11) NOT NULL,
  `mass_q` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:inactive;1:active - in queue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE IF NOT EXISTS `infos` (
`id` bigint(20) NOT NULL,
  `key_array` text COLLATE utf8_persian_ci NOT NULL,
  `msg` text COLLATE utf8_persian_ci NOT NULL,
  `img_array` text COLLATE utf8_persian_ci NOT NULL,
  `doc_array` text COLLATE utf8_persian_ci,
  `key_desc` text COLLATE utf8_persian_ci NOT NULL,
  `feed_id` bigint(20) DEFAULT '0',
  `regdate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mass_mess`
--

CREATE TABLE IF NOT EXISTS `mass_mess` (
`id` bigint(20) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `img_array` text COLLATE utf8_persian_ci,
  `finished` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:active;1:finished',
  `users_count` bigint(20) NOT NULL,
  `groups_count` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_log`
--

CREATE TABLE IF NOT EXISTS `message_log` (
`id` bigint(20) NOT NULL,
  `update_id` bigint(20) NOT NULL,
  `msg_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `msg_body` text COLLATE utf8_persian_ci NOT NULL,
  `regdate` int(11) NOT NULL,
  `username` text COLLATE utf8_persian_ci NOT NULL,
  `chat_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `static_info`
--

CREATE TABLE IF NOT EXISTS `static_info` (
`id` int(11) NOT NULL,
  `key` text COLLATE utf8_persian_ci NOT NULL,
  `body` text COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `static_info`
--

INSERT INTO `static_info` (`id`, `key`, `body`) VALUES
(1, 'start', 'Welcome to my bot ! Please click on /sub to regsiter'),
(2, 'feed', 'http://alikhansari.com'),
(3, 'button_counter', '2000'),
(4, 'infos_counter', '2000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text COLLATE utf8_persian_ci,
  `sub` tinyint(4) NOT NULL DEFAULT '1',
  `regdate` int(11) NOT NULL,
  `mass_q` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:inactive;1:active - in queue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buttons`
--
ALTER TABLE `buttons`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_options`
--
ALTER TABLE `general_options`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infos`
--
ALTER TABLE `infos`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mass_mess`
--
ALTER TABLE `mass_mess`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_log`
--
ALTER TABLE `message_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `static_info`
--
ALTER TABLE `static_info`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buttons`
--
ALTER TABLE `buttons`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `general_options`
--
ALTER TABLE `general_options`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `infos`
--
ALTER TABLE `infos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mass_mess`
--
ALTER TABLE `mass_mess`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_log`
--
ALTER TABLE `message_log`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `static_info`
--
ALTER TABLE `static_info`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
