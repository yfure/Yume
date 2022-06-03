-- Adminer 4.8.1 MySQL 5.6.38 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `octancle`;
CREATE DATABASE `octancle` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `octancle`;

DROP TABLE IF EXISTS `_0xlogin`;
CREATE TABLE `_0xlogin` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `node` char(28) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_device` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_address` char(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_browser` char(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_history` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `_0xusers`;
CREATE TABLE `_0xusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node` char(28) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL DEFAULT '0',
  `_fullname` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_fullname_old` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_fullname_time` int(11) NOT NULL DEFAULT '0',
  `_usermail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_usermail_old` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_usermail_true` int(2) NOT NULL DEFAULT '0',
  `_usermail_time` int(11) NOT NULL,
  `_username` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_username_old` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_username_time` int(11) NOT NULL DEFAULT '0',
  `_verified` int(2) NOT NULL DEFAULT '0',
  `_verified_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `_0xemails`;
CREATE TABLE `_0xemails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node` char(28) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `_active` int(2) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `_0xverify`;
CREATE TABLE `_0xverify` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `node` char(28) COLLATE utf8mb4_unicode_ci NOT NULL,
   `_gender` char(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `_account` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `_fullname` char(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `_birthday` int(11) NOT NULL,
   `_location` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `created` int(11) NOT NULL,
   `updated` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2022-05-07 00:20:54