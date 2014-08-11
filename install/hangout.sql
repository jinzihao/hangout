-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2014 at 08:02 AM
-- Server version: 5.5.32
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hangout`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `model_timetable` tinyint(1) NOT NULL,
  `model_chatroom` tinyint(1) NOT NULL,
  `model_location` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `title`, `slug`, `password`, `model_timetable`, `model_chatroom`, `model_location`) VALUES
(11, '测试活动', 'ceshi', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_info`
--

CREATE TABLE IF NOT EXISTS `model_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `model_info`
--

INSERT INTO `model_info` (`id`, `description`) VALUES
(1, '测试活动的描述');

-- --------------------------------------------------------

--
-- Table structure for table `model_users`
--

CREATE TABLE IF NOT EXISTS `model_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userdata` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `model_users`
--

INSERT INTO `model_users` (`id`, `userdata`) VALUES
(1, '测试用户1\r\b444ac06613fc8d63795be9ad0beaf55011936ac\r\n测试用户2\r\109f4b3c50d7b0df729d299bc6f8e9ef9066971f\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
