-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2015 at 04:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teasedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `registrants`
--

CREATE TABLE IF NOT EXISTS `registrants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `date_of_birth` int(11) unsigned NOT NULL,
  `country` varchar(250) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `token` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `registrants`
--

INSERT INTO `registrants` (`id`, `first_name`, `last_name`, `date_of_birth`, `country`, `ip`, `username`, `password`, `email`, `token`) VALUES
(29, 'milos', 'jovic', 573174000, 'serbia', '127.0.0.1', 'pera', '76d11b122320bc5f9bc7e5f889a76e13bbed8e2aab0418d4a6b82f319b6e2bd3', 'a@a.a', NULL),
(31, 'milos', 'jovic', 573174000, 'serbia', '127.0.0.1', 'jovica', '76d11b122320bc5f9bc7e5f889a76e13bbed8e2aab0418d4a6b82f319b6e2bd3', 'a@a.a', NULL),
(32, 'milos', 'jovic', 573174000, 'serbia', '127.0.0.1', 'bkii', 'd79c49e267f487a64fb30349f2f53ccdf54e7a0aa60b79c7fb959410fece8ab9', 'a@a.a', NULL),
(33, 'milos', 'jovic', 539218800, 'serbia', '127.0.0.1', 'djogani', '76d11b122320bc5f9bc7e5f889a76e13bbed8e2aab0418d4a6b82f319b6e2bd3', 'a@a.a', NULL),
(34, 'milos', 'jovic', 539218800, 'serbia', '127.0.0.1', 'logovanje', 'ea2f7e24eac9b8d278e005555e1a609e43a65b124fe810f7e06ef40e56f70f2c', 'a@a.a', 'nWXelp5L');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
