-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2021 at 03:18 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `j2_db`
--
CREATE DATABASE IF NOT EXISTS `j2_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `j2_db`;

-- --------------------------------------------------------

--
-- Table structure for table `grab_categories`
--

DROP TABLE IF EXISTS `grab_categories`;
CREATE TABLE IF NOT EXISTS `grab_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grab_categories`
--

INSERT INTO `grab_categories` (`id`, `title`) VALUES
(1, 'Clothing'),
(2, 'Shirt'),
(3, 'Handbags'),
(4, 'Accessories\r\n'),
(5, 'Jewelry'),
(6, 'Boots'),
(7, 'Swimwear');

-- --------------------------------------------------------

--
-- Table structure for table `grab_content`
--

DROP TABLE IF EXISTS `grab_content`;
CREATE TABLE IF NOT EXISTS `grab_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT '0',
  `reviews_count` int(11) NOT NULL DEFAULT '0',
  `original_price` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_price` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `colors` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Male',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grab_content`
--

INSERT INTO `grab_content` (`id`, `cid`, `title`, `img_link`, `rating`, `reviews_count`, `original_price`, `current_price`, `size`, `colors`, `gender`, `description`) VALUES
(1, 1, '2 pack muscle t-shirt in black & white', 'https://enovathemes.com/picart/wp-content/uploads/product_104.jpg', 0, 0, '', 180, 'XS,S,M,L,XL,XXL', 'darkred', 'male', 'Concrete Jungle Pack with logo embroidery. Tailored clothes available as in chain stores. These settings don’t provide big changes but only some small css changes in spaces or borders for example. Because we have many types of elements we created Live Editor for you so you can see live changes.'),
(2, 1, 'Asymmetric puff sleeve knot tuck midi dress in terracotta Asymmetric puff sleeve knot tuck midi dress in terracotta', 'https://enovathemes.com/picart/wp-content/uploads/product_9.jpg', 0, 0, '', 450, 'XS,S,M,L,XL,XXL', 'red,white', 'female', 'Concrete Jungle Pack with logo embroidery. Tailored clothes available as in chain stores.\r\nThese settings don’t provide big changes but only some small css changes in spaces or borders for example.\r\n\r\nBecause we have many types of elements we created Live Editor for you so you can see live changes.'),
(3, 1, 'Beatrice bardot drape wrap wedding dress', 'https://enovathemes.com/picart/wp-content/uploads/product_25.jpg', 0, 0, '121', 111, 'S,M,XL', 'white', 'Lựa chọn', 'Concrete Jungle Pack with logo embroidery. Tailored clothes available as in chain stores.'),
(4, 1, '123', '123', 0, 0, '123', 123, '123', '123', 'male', '123'),
(5, 1, '123', '123', 0, 0, '123', 123, '123', '123', 'male', '123');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
