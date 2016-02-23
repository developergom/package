-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `package`;
CREATE DATABASE `package` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `package`;

DROP TABLE IF EXISTS `cfg`;
CREATE TABLE `cfg` (
  `key` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `cfg`;
INSERT INTO `cfg` (`key`, `value`, `description`) VALUES
('APPLICATION_NAME',	'Package',	''),
('ACCESS_KEY',	'{\"c\":\"Create\",\"r\":\"Read\",\"u\":\"Update\",\"d\":\"Delete\"}',	''),
('ROW_PERPAGE',	'5',	''),
('COUNT_WRONG_PASSWORD',	'3',	''),
('SESSION_UNLOCK',	'15',	''),
('SESSION_EXPIRED',	'15',	''),
('PASSWORD_HISTORY',	'8',	''),
('PASSWORD_LENGTH',	'6',	''),
('PASSWORD_COMPLEXCITY',	'1',	''),
('PASSWORD_AGE',	'90',	''),
('LOG_STATUS',	'1',	''),
('LDAP_AUTH',	'0',	''),
('FORGOT_PASSWORD',	'60',	'');

DROP TABLE IF EXISTS `mn`;
CREATE TABLE `mn` (
  `mid` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `mpar` int(15) NOT NULL,
  `mnme` varchar(127) NOT NULL,
  `mlnk` varchar(63) NOT NULL,
  `mico` varchar(63) NOT NULL,
  `mstat` tinyint(1) DEFAULT '1',
  `cu` varchar(15) NOT NULL,
  `cd` datetime NOT NULL,
  `uu` varchar(15) NOT NULL,
  `ud` datetime NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

TRUNCATE `mn`;
INSERT INTO `mn` (`mid`, `mpar`, `mnme`, `mlnk`, `mico`, `mstat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1,	0,	'Package menu (root)',	'',	'',	1,	'',	'0000-00-00 00:00:00',	'',	'0000-00-00 00:00:00'),
(7,	1,	'SSO Management',	'#',	'fa-wrench',	1,	'',	'0000-00-00 00:00:00',	'1',	'2015-02-11 22:07:01'),
(15,	7,	'User Administration',	'sso/users',	'fa-user',	1,	'',	'2015-02-10 16:41:21',	'1',	'2015-02-24 19:39:27'),
(16,	7,	'Role Authentication',	'sso/roles',	'fa-group',	1,	'',	'2015-02-10 16:42:55',	'1',	'2015-02-24 19:39:35'),
(17,	7,	'Menu Registration',	'sso/menus',	'fa-th-list',	1,	'',	'2015-02-10 16:44:22',	'1',	'2015-02-24 19:39:42'),
(19,	1,	'Multilevel Menu',	'#',	' fa-tasks',	1,	'1',	'2015-02-16 17:53:15',	'1',	'2015-02-24 21:53:15'),
(21,	19,	'Test 1',	'#',	' fa-check-circle-o',	1,	'1',	'2015-02-16 20:06:04',	'1',	'2015-02-24 19:18:57'),
(22,	21,	'Test 1 1',	'#',	' fa-check-circle-o',	1,	'1',	'2015-02-16 20:06:23',	'1',	'2015-02-24 19:19:14'),
(23,	21,	'Test 1 2',	'#',	' fa-anchor',	1,	'1',	'2015-02-16 20:48:07',	'1',	'2015-02-24 19:22:37'),
(24,	19,	'Test 2',	'#',	' fa-check-circle-o',	1,	'1',	'2015-02-16 22:37:49',	'1',	'2015-04-09 18:59:49');

DROP TABLE IF EXISTS `rl`;
CREATE TABLE `rl` (
  `rid` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `rnme` varchar(127) NOT NULL,
  `rstat` tinyint(1) NOT NULL DEFAULT '1',
  `cu` varchar(15) NOT NULL,
  `cd` datetime NOT NULL,
  `uu` varchar(15) NOT NULL,
  `ud` datetime NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

TRUNCATE `rl`;
INSERT INTO `rl` (`rid`, `rnme`, `rstat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1,	'Root',	1,	'1',	'2015-04-08 21:14:42',	'1',	'2015-05-04 14:01:34'),
(3,	'Board Of Director',	1,	'1',	'2015-04-08 21:11:48',	'1',	'2015-04-08 21:11:48'),
(5,	'Managements',	0,	'1',	'2015-04-08 21:13:23',	'1',	'2015-04-08 21:59:30');

DROP TABLE IF EXISTS `rm`;
CREATE TABLE `rm` (
  `rid` int(15) unsigned NOT NULL,
  `mid` int(15) unsigned NOT NULL,
  `rmk` varchar(63) NOT NULL,
  KEY `rid` (`rid`),
  KEY `mid` (`mid`),
  CONSTRAINT `rm_ibfk_3` FOREIGN KEY (`rid`) REFERENCES `rl` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rm_ibfk_4` FOREIGN KEY (`mid`) REFERENCES `mn` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `rm`;
INSERT INTO `rm` (`rid`, `mid`, `rmk`) VALUES
(3,	19,	'[\"c\",\"r\",\"u\",\"d\"]'),
(3,	21,	'[\"c\",\"r\",\"u\",\"d\"]'),
(3,	22,	'[\"c\",\"r\",\"u\",\"d\"]'),
(3,	23,	'[\"c\",\"r\",\"u\",\"d\"]'),
(3,	24,	'[\"c\",\"r\",\"u\",\"d\"]'),
(5,	7,	'[\"r\"]'),
(5,	15,	'[\"r\"]'),
(5,	16,	'[\"r\"]'),
(5,	17,	'[\"r\"]'),
(5,	19,	'[\"r\"]'),
(5,	21,	'[\"r\"]'),
(5,	22,	'[\"r\"]'),
(5,	23,	'[\"r\"]'),
(5,	24,	'[\"r\"]'),
(1,	7,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	15,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	16,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	17,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	21,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	22,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	23,	'[\"c\",\"r\",\"u\",\"d\"]'),
(1,	24,	'[\"c\",\"r\",\"u\",\"d\"]');

DROP TABLE IF EXISTS `url`;
CREATE TABLE `url` (
  `uid` int(15) unsigned NOT NULL,
  `rid` int(15) unsigned NOT NULL,
  KEY `uid` (`uid`),
  KEY `rid` (`rid`),
  CONSTRAINT `url_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `usr` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `url_ibfk_4` FOREIGN KEY (`rid`) REFERENCES `rl` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE `url`;
INSERT INTO `url` (`uid`, `rid`) VALUES
(5,	3),
(1,	1),
(1,	3);

DROP TABLE IF EXISTS `usr`;
CREATE TABLE `usr` (
  `uid` int(15) unsigned NOT NULL AUTO_INCREMENT,
  `unme` varchar(63) NOT NULL,
  `ufnme` varchar(127) NOT NULL,
  `upass` varchar(255) NOT NULL,
  `umail` varchar(127) NOT NULL,
  `uwpas` smallint(1) NOT NULL,
  `upp` varchar(63) NOT NULL,
  `ustat` tinyint(1) NOT NULL DEFAULT '1',
  `cu` varchar(15) NOT NULL,
  `cd` datetime NOT NULL,
  `uu` varchar(15) NOT NULL,
  `ud` datetime NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

TRUNCATE `usr`;
INSERT INTO `usr` (`uid`, `unme`, `ufnme`, `upass`, `umail`, `uwpas`, `upp`, `ustat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1,	'nanank',	'Akhmad Nafi\'',	'jMZ9csy2f8xKxOMMPM6i2gdRi2dk4zyoGcFywAXt40lwTHT3mHIrdLtsADZb6Oh/3EWCPXt4CizTfsP1EcOLZg==',	'akhmad.nafi@yahoo.com',	0,	'',	1,	'',	'0000-00-00 00:00:00',	'1',	'2015-04-09 18:32:00'),
(5,	'ucup',	'Mahmud',	'jM8XOmp9ikaIkxmo04iwdanrOdd7Ef+QqtdARG6+YYKgOrpl3xMCnR6p4wFaXcC1H2K/52TYd3p9/UK4wOyryw==',	'mahmud@ucup.cc',	0,	'',	1,	'1',	'2015-02-11 21:31:00',	'1',	'2015-02-12 14:33:22');

-- 2015-07-30 12:22:48

