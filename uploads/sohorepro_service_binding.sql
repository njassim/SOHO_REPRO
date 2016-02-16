-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2016 at 12:51 PM
-- Server version: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `supply.sohorepro.com`
--

-- --------------------------------------------------------

--
-- Table structure for table `sohorepro_service_binding`
--

CREATE TABLE IF NOT EXISTS `sohorepro_service_binding` (
  `id` int(124) NOT NULL AUTO_INCREMENT,
  `comp_id` int(124) NOT NULL,
  `user_id` int(124) NOT NULL,
  `reference` varchar(514) NOT NULL,
  `binding` varchar(514) NOT NULL,
  `binding_option` varchar(514) NOT NULL,
  `front_cover` varchar(514) NOT NULL,
  `front_cover_option` varchar(514) NOT NULL,
  `back_cover` varchar(514) NOT NULL,
  `back_cover_option` varchar(514) NOT NULL,
  `number_of_book_bind` varchar(124) NOT NULL,
  `cutting` varchar(514) NOT NULL,
  `cutting_instruction` varchar(514) NOT NULL,
  `size` varchar(514) NOT NULL,
  `size_custome` varchar(514) NOT NULL,
  `special_instruction` varchar(514) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
