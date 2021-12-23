-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2021 at 06:01 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truyenhay`
--
CREATE DATABASE IF NOT EXISTS `truyenhay` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `truyenhay`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Kiếm hiệp'),
(2, 'Xuyên không'),
(3, 'Ngôn tình'),
(4, 'Tiên hiệp');

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

DROP TABLE IF EXISTS `chapter`;
CREATE TABLE IF NOT EXISTS `chapter` (
  `chap_id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) NOT NULL,
  `chap` int(11) NOT NULL,
  `chapter_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`chap_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `novel_id` int(11) NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_rating` tinyint(4) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `novel`
--

DROP TABLE IF EXISTS `novel`;
CREATE TABLE IF NOT EXISTS `novel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chưa hoàn thành',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_chapters` int(11) NOT NULL DEFAULT '0',
  `pre_view` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `novel`
--

INSERT INTO `novel` (`id`, `user_id`, `category_id`, `title`, `status`, `author`, `img_link`, `total_chapters`, `pre_view`, `view_count`, `create_at`) VALUES
(2, 1, 4, 'dldl', 'Chưa hoàn thành', 'dgtt', '1640141735.jpg', 0, 'Một đại lục không hề yên bình, một cuộc sống đầy hiểm nguy, phiêu lưu nhưng cũng không kém phần lãng mạn. tình yêu, thù hận, trách nhiệm… Tiếp bước những tiền bối đi trước, Hoắc Vũ Hạo và đời sau sử lai khắc thất quái, bằng niềm tin nhiệt huyết tuổi trẻ đ', 0, '2021-12-22 09:55:35'),
(3, 1, 3, 'MÊ VỢ KHÔNG LỐI VỀ', 'Chưa hoàn thành', 'Chiêu Tài Tiến Bảo', '1640143150.jpg', 0, 'Một cuộc giao dịch, cô mang thai con của người lạ, mang bụng bầu gả cho người đàn ông đã đính ước từ nhỏ. Vốn cho rằng chỉ là một cuộc giao dịch, lại dây dưa thứ tình cảm không nên có trong cuộc hôn nhân này. Mười tháng hoài thai sắp sinh, một tờ đơn ly hôn trên đất, cô mới hoàn toàn tình ngộ. Sau này anh ta nói \"Bà xã về đi, người anh yêu luôn là em\"', 0, '2021-12-22 10:19:10'),
(8, 1, 2, 'hi', 'Chưa hoàn thành', 'NNL', '1640228500.jpg', 0, 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbcccccccccccccccccccccccccccccccccccccccccccccccccccc', 0, '2021-12-23 10:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `saved_list`
--

DROP TABLE IF EXISTS `saved_list`;
CREATE TABLE IF NOT EXISTS `saved_list` (
  `user_id` int(11) NOT NULL,
  `novel_id` int(11) NOT NULL,
  `saved_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`novel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` bit(1) NOT NULL DEFAULT b'1',
  `birth_day` date NOT NULL,
  `pass_wd` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` bit(1) NOT NULL DEFAULT b'1',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avt_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `gender`, `email`, `avt_link`) VALUES
(1, 'Nam Long', b'0', 'nnl@gmail.com', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
