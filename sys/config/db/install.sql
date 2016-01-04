-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `outbox`;
CREATE TABLE `outbox` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `profile` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noreply',
  `html` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sendto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `bcc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `posted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) unsigned DEFAULT '0',
  `ukey` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passhash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `groups` longtext COLLATE utf8_unicode_ci,
  `regip` varbinary(16) DEFAULT NULL,
  `registered` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `custom` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-01-04 13:53:57
 
