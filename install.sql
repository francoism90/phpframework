-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `mailing`;
CREATE TABLE `mailing` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `profile` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noreply',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sendto` longtext COLLATE utf8_unicode_ci,
  `cc` longtext COLLATE utf8_unicode_ci,
  `bcc` longtext COLLATE utf8_unicode_ci,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `posted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) unsigned DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `groups` text COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apikey` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actionkey` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `born` datetime DEFAULT '0000-00-00 00:00:00',
  `sex` tinyint(1) unsigned DEFAULT '0',
  `address` longtext COLLATE utf8_unicode_ci,
  `company` longtext COLLATE utf8_unicode_ci,
  `locale` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `regip` varbinary(16) DEFAULT NULL,
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `apikey` (`apikey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-01-25 18:51:32
 
