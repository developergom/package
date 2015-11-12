-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2015 at 04:06 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `package`
--

-- --------------------------------------------------------

--
-- Table structure for table `cfg`
--

CREATE TABLE IF NOT EXISTS `cfg` (
  `key` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cfg`
--

INSERT INTO `cfg` (`key`, `value`, `description`) VALUES
('APPLICATION_NAME', 'Package', ''),
('ACCESS_KEY', '{"c":"Create","r":"Read","u":"Update","d":"Delete"}', ''),
('ROW_PERPAGE', '5', ''),
('COUNT_WRONG_PASSWORD', '3', ''),
('SESSION_UNLOCK', '15', ''),
('SESSION_EXPIRED', '15', ''),
('PASSWORD_HISTORY', '8', ''),
('PASSWORD_LENGTH', '6', ''),
('PASSWORD_COMPLEXCITY', '1', ''),
('PASSWORD_AGE', '90', ''),
('LOG_STATUS', '1', ''),
('LDAP_AUTH', '0', ''),
('FORGOT_PASSWORD', '60', '');

-- --------------------------------------------------------

--
-- Table structure for table `mn`
--

CREATE TABLE IF NOT EXISTS `mn` (
  `mid` int(15) unsigned NOT NULL,
  `mpar` int(15) NOT NULL,
  `mnme` varchar(127) NOT NULL,
  `mlnk` varchar(63) NOT NULL,
  `mico` varchar(63) NOT NULL,
  `mstat` tinyint(1) DEFAULT '1',
  `cu` varchar(15) NOT NULL,
  `cd` datetime NOT NULL,
  `uu` varchar(15) NOT NULL,
  `ud` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mn`
--

INSERT INTO `mn` (`mid`, `mpar`, `mnme`, `mlnk`, `mico`, `mstat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1, 0, 'Package menu (root)', '', '', 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
(7, 1, 'SSO Management', '#', 'fa-wrench', 1, '', '0000-00-00 00:00:00', '1', '2015-02-11 22:07:01'),
(15, 7, 'User Administration', 'sso/users', 'fa-user', 1, '', '2015-02-10 16:41:21', '1', '2015-02-24 19:39:27'),
(16, 7, 'Role Authentication', 'sso/roles', 'fa-group', 1, '', '2015-02-10 16:42:55', '1', '2015-02-24 19:39:35'),
(17, 7, 'Menu Registration', 'sso/menus', 'fa-th-list', 1, '', '2015-02-10 16:44:22', '1', '2015-02-24 19:39:42'),
(19, 1, 'Multilevel Menu', '#', ' fa-tasks', 1, '1', '2015-02-16 17:53:15', '1', '2015-02-24 21:53:15'),
(21, 19, 'Test 1', '#', ' fa-check-circle-o', 1, '1', '2015-02-16 20:06:04', '1', '2015-02-24 19:18:57'),
(22, 21, 'Test 1 1', '#', ' fa-check-circle-o', 1, '1', '2015-02-16 20:06:23', '1', '2015-02-24 19:19:14'),
(23, 21, 'Test 1 2', '#', ' fa-anchor', 1, '1', '2015-02-16 20:48:07', '1', '2015-02-24 19:22:37'),
(24, 19, 'Test 2', '#', ' fa-check-circle-o', 1, '1', '2015-02-16 22:37:49', '1', '2015-04-09 18:59:49');

-- --------------------------------------------------------

--
-- Table structure for table `rl`
--

CREATE TABLE IF NOT EXISTS `rl` (
  `rid` int(15) unsigned NOT NULL,
  `rnme` varchar(127) NOT NULL,
  `rstat` tinyint(1) NOT NULL DEFAULT '1',
  `cu` varchar(15) NOT NULL,
  `cd` datetime NOT NULL,
  `uu` varchar(15) NOT NULL,
  `ud` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rl`
--

INSERT INTO `rl` (`rid`, `rnme`, `rstat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1, 'Root', 1, '1', '2015-04-08 21:14:42', '1', '2015-11-11 09:14:08'),
(3, 'Board Of Director', 1, '1', '2015-04-08 21:11:48', '1', '2015-04-08 21:11:48'),
(5, 'Managements', 0, '1', '2015-04-08 21:13:23', '1', '2015-04-08 21:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `rm`
--

CREATE TABLE IF NOT EXISTS `rm` (
  `rid` int(15) unsigned NOT NULL,
  `mid` int(15) unsigned NOT NULL,
  `rmk` varchar(63) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rm`
--

INSERT INTO `rm` (`rid`, `mid`, `rmk`) VALUES
(3, 19, '["c","r","u","d"]'),
(3, 21, '["c","r","u","d"]'),
(3, 22, '["c","r","u","d"]'),
(3, 23, '["c","r","u","d"]'),
(3, 24, '["c","r","u","d"]'),
(5, 7, '["r"]'),
(5, 15, '["r"]'),
(5, 16, '["r"]'),
(5, 17, '["r"]'),
(5, 19, '["r"]'),
(5, 21, '["r"]'),
(5, 22, '["r"]'),
(5, 23, '["r"]'),
(5, 24, '["r"]'),
(1, 7, '["c","r","u","d"]'),
(1, 15, '["c","r","u","d"]'),
(1, 16, '["c","r","u","d"]'),
(1, 17, '["c","r","u","d"]');

-- --------------------------------------------------------

--
-- Table structure for table `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `uid` int(15) unsigned NOT NULL,
  `rid` int(15) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `url`
--

INSERT INTO `url` (`uid`, `rid`) VALUES
(5, 3),
(1, 1),
(1, 3),
(6, 1),
(6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

CREATE TABLE IF NOT EXISTS `usr` (
  `uid` int(15) unsigned NOT NULL,
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
  `ud` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`uid`, `unme`, `ufnme`, `upass`, `umail`, `uwpas`, `upp`, `ustat`, `cu`, `cd`, `uu`, `ud`) VALUES
(1, 'nanank', 'Akhmad Nafi''', 'jMZ9csy2f8xKxOMMPM6i2gdRi2dk4zyoGcFywAXt40lwTHT3mHIrdLtsADZb6Oh/3EWCPXt4CizTfsP1EcOLZg==', 'akhmad.nafi@yahoo.com', 2, '', 1, '', '0000-00-00 00:00:00', '', '2015-11-11 11:37:58'),
(5, 'ucup', 'Mahmud', 'jM8XOmp9ikaIkxmo04iwdanrOdd7Ef+QqtdARG6+YYKgOrpl3xMCnR6p4wFaXcC1H2K/52TYd3p9/UK4wOyryw==', 'mahmud@ucup.cc', 0, '', 1, '1', '2015-02-11 21:31:00', '1', '2015-02-12 14:33:22'),
(6, 'soni', 'Soni', 'lEh3rBxN/KmIKj0K3d924KEOqpfTGqjsEEG1y32tpWqyoQ8Uyb6srklPu3iywlO7MlsBCngtc+5CbmNBZP5cZg==', 'so@a.co', 1, '', 1, '1', '2015-11-11 09:13:15', '', '2015-11-11 11:37:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mn`
--
ALTER TABLE `mn`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `rl`
--
ALTER TABLE `rl`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `rm`
--
ALTER TABLE `rm`
  ADD KEY `rid` (`rid`), ADD KEY `mid` (`mid`);

--
-- Indexes for table `url`
--
ALTER TABLE `url`
  ADD KEY `uid` (`uid`), ADD KEY `rid` (`rid`);

--
-- Indexes for table `usr`
--
ALTER TABLE `usr`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mn`
--
ALTER TABLE `mn`
  MODIFY `mid` int(15) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `rl`
--
ALTER TABLE `rl`
  MODIFY `rid` int(15) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usr`
--
ALTER TABLE `usr`
  MODIFY `uid` int(15) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `rm`
--
ALTER TABLE `rm`
ADD CONSTRAINT `rm_ibfk_3` FOREIGN KEY (`rid`) REFERENCES `rl` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `rm_ibfk_4` FOREIGN KEY (`mid`) REFERENCES `mn` (`mid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `url`
--
ALTER TABLE `url`
ADD CONSTRAINT `url_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `usr` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `url_ibfk_4` FOREIGN KEY (`rid`) REFERENCES `rl` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
