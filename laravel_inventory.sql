-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 10, 2022 at 11:40 AM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Application Home Page Slider', 1, '2022-01-08 10:16:15', '2022-01-08 04:46:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banner_image`
--

CREATE TABLE `banner_image` (
  `id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner_image`
--

INSERT INTO `banner_image` (`id`, `banner_id`, `language_id`, `title`, `link`, `image`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, '50% off', '435', '16472862101.jpg', 1, '2022-03-14 19:30:10', '2022-03-14 18:30:10', NULL),
(2, 1, NULL, '10% OFF', '432', '16472862102.jpg', 2, '2022-03-14 19:30:10', '2022-03-14 18:30:10', NULL),
(3, 1, NULL, 'Banner', '44', '16472862103.jpg', 3, '2022-03-14 19:30:10', '2022-03-14 18:30:10', NULL),
(4, 1, NULL, 'Banner', '3', '16472862104.jpg', 4, '2022-03-14 19:30:10', '2022-03-14 18:30:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `option` text,
  `quantity` int(5) NOT NULL,
  `date_added` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `seller_id`, `option`, `quantity`, `date_added`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 3, 38, NULL, '{\"optionColorSelected\":0,\"optionSizeSelected\":0,\"optionSelectSelected\":0}', 1, '2022-06-16 18:13:32', '2022-06-16 18:13:32', NULL, NULL),
(23, 3, 37, NULL, '{\"optionColorSelected\":0,\"optionSizeSelected\":0,\"optionSelectSelected\":0}', 1, '2022-06-16 18:13:36', '2022-06-16 18:13:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) DEFAULT NULL,
  `column` int(3) DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `seller_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(17, '1640170108Product_02.png', 0, NULL, NULL, NULL, 1, NULL, '2022-06-16 18:46:34', '2022-06-17 01:46:34', '2022-06-17 01:46:34'),
(16, '1640170093Product_14.jpg', 14, NULL, NULL, NULL, 1, NULL, '2022-06-16 18:46:26', '2022-06-17 01:46:26', '2022-06-17 01:46:26'),
(15, '1640170082Product_14.jpg', 14, NULL, NULL, NULL, 1, NULL, '2022-03-14 19:24:44', '2022-03-14 18:24:44', '2022-03-14 18:24:44'),
(14, '1640170069Product_04.png', 0, NULL, NULL, NULL, 1, NULL, '2022-06-16 18:46:26', '2022-06-17 01:46:26', '2022-06-17 01:46:26'),
(18, '1647285869Category_03.jpg', 0, NULL, NULL, 3, 1, NULL, '2022-06-21 17:27:41', '2022-06-22 00:27:41', '2022-06-22 00:27:41'),
(19, '1647285860Category_06.jpg', 0, NULL, NULL, 4, 1, NULL, '2022-06-21 17:34:30', '2022-06-22 00:34:30', '2022-06-22 00:34:30'),
(20, '1647285850Category_02.jpg', 0, NULL, NULL, 5, 1, NULL, '2022-06-21 17:34:38', '2022-06-22 00:34:38', '2022-06-22 00:34:38'),
(21, '1647285840Category_05.jpg', 0, NULL, NULL, 6, 1, NULL, '2022-06-21 17:34:44', '2022-06-22 00:34:44', '2022-06-22 00:34:44'),
(22, '1647285826Category_07.jpg', 0, NULL, NULL, 7, 1, NULL, '2022-06-21 17:34:50', '2022-06-22 00:34:50', '2022-06-22 00:34:50'),
(23, '1655832812ethjpg.jpg', 0, NULL, NULL, 6, 1, NULL, '2022-06-21 17:33:32', '2022-06-22 00:33:32', NULL),
(24, '1641986758Category_08.jpg', 17, NULL, NULL, NULL, 1, NULL, '2022-01-12 11:26:11', '2022-01-12 05:56:11', '2022-01-12 05:56:11'),
(25, '1647285788hardik-sharma-CrPAvN29Nhs-unsplash.jpg', 0, NULL, NULL, NULL, 1, NULL, '2022-06-21 17:34:56', '2022-06-22 00:34:56', '2022-06-22 00:34:56'),
(26, '1647285756fabio-scaletta-cYSRncVxE44-unsplash-removebg-preview.png', 0, NULL, NULL, NULL, 1, NULL, '2022-06-21 17:35:01', '2022-06-22 00:35:01', '2022-06-22 00:35:01'),
(27, '1655832859cast iron.png', 0, NULL, NULL, NULL, 1, NULL, '2022-06-21 17:34:19', '2022-06-22 00:34:19', NULL),
(28, '1655832218characterjpg.jpg', 0, NULL, NULL, 11111, 1, NULL, '2022-06-21 17:23:38', '2022-06-22 00:23:38', NULL),
(29, '1656215727coal.jpeg', 0, NULL, NULL, NULL, 1, NULL, '2022-06-26 10:55:27', '2022-06-26 10:55:27', NULL),
(30, '1656225391Waldmann-Blue-Ink-Bottle.jpg', 0, NULL, NULL, 50, 1, NULL, '2022-06-26 06:38:35', '2022-06-26 13:38:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_description`
--

CREATE TABLE `category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_description`
--

INSERT INTO `category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`, `created_at`, `updated_at`, `deleted_at`) VALUES
(14, NULL, 'Cloths', NULL, NULL, NULL, NULL, '2021-12-22 05:17:49', '2022-06-17 01:46:26', '2022-06-17 01:46:26'),
(15, NULL, 'Shirts', NULL, NULL, NULL, NULL, '2021-12-22 05:18:02', '2022-03-14 18:24:44', '2022-03-14 18:24:44'),
(16, NULL, 'T-shirts', NULL, NULL, NULL, NULL, '2021-12-22 05:18:13', '2022-06-17 01:46:26', '2022-06-17 01:46:26'),
(17, NULL, 'Shoes', NULL, NULL, NULL, NULL, '2021-12-22 05:18:28', '2022-06-17 01:46:34', '2022-06-17 01:46:34'),
(18, NULL, 'Grocery', NULL, 'groc', 'sdf', 'groc', '2022-01-12 04:59:41', '2022-06-22 00:27:41', '2022-06-22 00:27:41'),
(19, NULL, 'Kids Wear', NULL, 'kids', 'DSAD', 'kids', '2022-01-12 05:00:13', '2022-06-22 00:34:30', '2022-06-22 00:34:30'),
(20, NULL, 'Travel', NULL, 'travel', 'travel', 'travel', '2022-01-12 05:00:51', '2022-06-22 00:34:38', '2022-06-22 00:34:38'),
(21, NULL, 'Fashion', NULL, 'fashion', 'fashion', 'fashion', '2022-01-12 05:01:28', '2022-06-22 00:34:44', '2022-06-22 00:34:44'),
(22, NULL, 'Ladies Dress', NULL, 'dress', 'dress', 'dress', '2022-01-12 05:14:05', '2022-06-22 00:34:50', '2022-06-22 00:34:50'),
(23, NULL, 'Coins', NULL, 'Coins', 'Coins', 'Coins', '2022-01-12 05:14:32', '2022-06-22 00:33:32', NULL),
(24, NULL, 'Ladies Sandal', NULL, NULL, NULL, NULL, '2022-01-12 05:55:58', '2022-01-12 05:56:11', '2022-01-12 05:56:11'),
(25, NULL, 'Electronics', NULL, 'Mobile', NULL, NULL, '2022-01-15 23:59:58', '2022-06-22 00:34:56', '2022-06-22 00:34:56'),
(26, NULL, 'Men', NULL, 'men', NULL, NULL, '2022-01-16 00:01:25', '2022-06-22 00:35:01', '2022-06-22 00:35:01'),
(27, NULL, 'Alloy', NULL, 'Alloy', 'alloy', 'alloy', '2022-01-16 00:02:33', '2022-06-22 00:34:19', NULL),
(28, NULL, 'Troops', NULL, 'Troops', 'Troops', 'Troops', '2022-06-21 16:52:07', '2022-06-22 00:23:38', NULL),
(29, NULL, 'Resources', NULL, 'Resources', 'Resources', 'Resources', '2022-06-26 10:55:27', '2022-06-26 10:55:27', NULL),
(30, NULL, 'more items', NULL, 'more items', 'more items', 'more items', '2022-06-26 13:36:31', '2022-06-26 13:38:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cost_price_table`
--

CREATE TABLE `cost_price_table` (
  `cost_price_table_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `cost_price` decimal(15,4) NOT NULL,
  `pp` decimal(15,4) NOT NULL,
  `shipping_value` decimal(15,4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'India', 'IN', 'IN', '', 91, 1, '2021-12-30 05:33:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=percentage,2=fixed',
  `discount` decimal(15,4) NOT NULL,
  `uses_total` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `name`, `code`, `type`, `discount`, `uses_total`, `status`, `date_added`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '10% OFF', 'otrixweb', 1, 10.0000, NULL, 1, NULL, '2022-03-13', '2022-04-30', '2022-03-16 04:52:04', '2022-03-16 04:52:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_history`
--

CREATE TABLE `coupon_history` (
  `coupon_history_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cron`
--

CREATE TABLE `cron` (
  `id` int(11) NOT NULL,
  `success` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cart` text,
  `wishlist` text,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `custom_field` text,
  `ip` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `code` varchar(40) DEFAULT NULL,
  `image` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `creation` enum('D','G','F','A') DEFAULT NULL,
  `social_id` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `language_id`, `firstname`, `lastname`, `email`, `telephone`, `password`, `cart`, `wishlist`, `newsletter`, `custom_field`, `ip`, `status`, `code`, `image`, `created_at`, `updated_at`, `deleted_at`, `creation`, `social_id`) VALUES
(2, NULL, 'Ai', 'ZhenZhong', 'univgalaxy1112@gmail.com', '+15555215554', '$2y$10$W1o6HZFauDQ6rfI16WoOH.uvT8J6JfvEP5ffV8viv/OhbrJDb0xgS', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, '2022-06-09 00:59:34', '2022-06-09 00:59:34', NULL, 'D', NULL),
(3, NULL, 'asd', 'asd', 'asd@asd.com', '123456', '$2y$10$B.s3Gv6Ll963V3R.cHpuNuqJ5YklNSqxZN0W0qw.KLW9bfVDGlo9G', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, '2022-06-26 01:39:29', '2022-06-26 08:39:29', '2022-06-26 08:39:29', NULL, NULL),
(4, NULL, 'Fija', 'Islam', 'fija@coinnow.com', '11001100', '$2y$10$qA.S44KuLvtNYznmQLHwwe/mOYB0aj6qM9b2ciGcIL0lP7mrk22hG', NULL, NULL, 0, NULL, NULL, 1, NULL, NULL, '2022-06-26 01:39:32', '2022-06-26 08:39:32', '2022-06-26 08:39:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) DEFAULT NULL,
  `city` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`id`, `customer_id`, `name`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `created_at`) VALUES
(1, 2, 'Tests', '123', '123', 'test', '1234', 1, '2022-06-10 15:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `customer_transaction`
--

CREATE TABLE `customer_transaction` (
  `customer_transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer_wishlist`
--

CREATE TABLE `customer_wishlist` (
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dod`
--

CREATE TABLE `dod` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dod`
--

INSERT INTO `dod` (`id`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, '2022-03-15 13:57:13', NULL, NULL),
(2, 26, '2022-03-15 13:57:13', NULL, NULL),
(3, 22, '2022-03-15 13:57:13', NULL, NULL),
(4, 21, '2022-03-15 13:57:13', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `length_class`
--

CREATE TABLE `length_class` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `unit` varchar(4) NOT NULL,
  `value` decimal(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `name`, `image`, `sort_order`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Zara', '1647324128appstore.png', 5, 1, '2021-08-01 02:23:57', '2022-03-15 05:02:08', NULL),
(2, 'Nike', '1647324121appstore.png', 2, 1, '2022-01-09 13:43:47', '2022-03-15 05:02:01', NULL),
(3, 'Puma', '1647324112appstore.png', 8, 1, '2022-01-13 04:11:15', '2022-03-15 05:01:52', NULL),
(4, 'Samsung', '1647324104appstore.png', 4, 1, '2022-01-13 04:11:37', '2022-03-15 05:01:44', NULL),
(5, 'Big Basket', '1647324095appstore.png', 5, 1, '2022-01-13 04:12:35', '2022-03-15 05:01:35', NULL),
(6, 'Urban Touch', '1647324086appstore.png', 6, 1, '2022-01-13 04:14:31', '2022-03-15 05:05:13', NULL),
(7, 'Apple', '1647324147appstore.png', 2, 1, '2022-03-15 05:02:27', '2022-03-15 05:02:27', NULL),
(8, 'Dell', '1647324163appstore.png', 5, 1, '2022-03-15 05:02:43', '2022-03-15 05:02:43', NULL),
(9, 'London Britches', '1647324175appstore.png', 5, 1, '2022-03-15 05:02:55', '2022-03-15 05:04:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(15) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(15) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(9, 'App\\Models\\User', 627),
(9, 'App\\User', 627),
(12, 'App\\User', 629),
(9, 'App\\User', 630),
(14, 'App\\Models\\User', 631);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `seller_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `amount` bigint(20) DEFAULT NULL,
  `balance` bigint(20) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `seen` int(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `invoice_no` int(11) DEFAULT NULL,
  `invoice_prefix` varchar(26) DEFAULT 'INV',
  `seller_id` bigint(20) DEFAULT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) DEFAULT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `shipping_name` varchar(32) NOT NULL,
  `shipping_address_1` varchar(128) DEFAULT NULL,
  `shipping_address_2` varchar(128) DEFAULT NULL,
  `shipping_city` varchar(128) NOT NULL,
  `shipping_postcode` varchar(10) DEFAULT NULL,
  `shipping_country_id` int(11) DEFAULT NULL,
  `comment` text,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `order_status_id` int(11) DEFAULT NULL,
  `commission` decimal(15,4) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT '0.00',
  `discount` decimal(15,2) DEFAULT '0.00',
  `shipping_charge` decimal(15,2) DEFAULT '0.00',
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(150) DEFAULT '',
  `grand_total` decimal(15,2) NOT NULL,
  `tracking` varchar(64) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `forwarded_ip` varchar(40) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `accept_language` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `invoice_no`, `invoice_prefix`, `seller_id`, `customer_id`, `customer_group_id`, `firstname`, `lastname`, `email`, `telephone`, `shipping_name`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_postcode`, `shipping_country_id`, `comment`, `total`, `order_status_id`, `commission`, `tax_amount`, `discount`, `shipping_charge`, `payment_method`, `transaction_id`, `grand_total`, `tracking`, `language_id`, `ip`, `order_date`, `forwarded_ip`, `user_agent`, `accept_language`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, NULL, 'INV', 1, 2, NULL, 'Ai', 'ZhenZhong', 'univgalaxy1112@gmail.com', '+15555215554', 'Free  (10 - 15 Days)', '123', '123', 'test', '1234', 1, 'null', 90.00, 1, NULL, 0.00, 0.00, 0.00, 'Cash On Delivery', '0', 90.00, NULL, NULL, NULL, '2022-06-10', NULL, NULL, NULL, '2022-06-10 17:20:37', '2022-06-10 09:20:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_additional_field`
--

CREATE TABLE `order_additional_field` (
  `order_additional_field_id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `cost` decimal(15,4) NOT NULL,
  `pp` decimal(15,4) NOT NULL,
  `ship` decimal(15,4) NOT NULL,
  `delivery` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `tracking` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order_custom` int(11) NOT NULL,
  `tracknum` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_expected` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`id`, `order_id`, `order_status_id`, `notify`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 3, 4, 0, 'Test', '2022-06-10 09:18:21', '2022-06-10 09:18:21', NULL),
(3, 3, 1, 0, 'Initial Order', '2022-06-10 07:44:55', '2022-06-10 07:44:55', NULL),
(5, 3, 1, 0, 'test', '2022-06-10 09:20:37', '2022-06-10 09:20:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `special` decimal(15,2) DEFAULT '0.00',
  `image` varchar(150) DEFAULT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `reward` int(8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `name`, `quantity`, `price`, `special`, `image`, `total`, `reward`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 3, 36, 'Essential Cap', 1, 90.0000, 0.00, '1647352336Product_05.png', 90.0000, NULL, '2022-06-10 15:44:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_shipment`
--

CREATE TABLE `order_shipment` (
  `order_shipment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `shipping_courier_id` varchar(255) NOT NULL DEFAULT '',
  `tracking_number` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `language_id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Pending', 1, '2022-03-10 14:02:46', '2021-12-30 00:40:13', NULL),
(5, NULL, 'Shipped', 1, '2021-12-30 00:40:45', '2021-12-30 00:40:45', NULL),
(6, NULL, 'Denied', 1, '2021-12-30 00:41:36', '2021-12-30 00:41:36', NULL),
(9, NULL, 'Canceled', 1, '2021-12-30 00:42:08', '2021-12-30 00:42:08', NULL),
(10, NULL, 'Delayed', 1, '2022-06-10 09:22:13', '2022-06-10 09:22:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_total`
--

CREATE TABLE `order_total` (
  `id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `heading`, `image`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Privacy Policy', 'Privacy Policy', NULL, '<p><strong>Privacy Policy</strong></p>\r\n\r\n<p><strong>It is hereby informed to every individuals who are using Otrixweb E-commerce Business platform, Otrixweb Business shall not be responsible for any lost delivery, false delivery, false delivery of product, broken delivery, permanent or temporary loss of product, only delivery partners are answerable for above terms. We at (original ecommerce) respect the trust you place in us and recognize the importance of secure transactions and information privacy. here our Privacy Policy illustrate that how Otrixweb E-commerce business Private Limited and its affiliates (collectively &ldquo;Otrixweb business, we, our, us&rdquo;) collect, use, share or otherwise process your personal information through Otrixweb website www.Otrixwebbusiness.com, its mobile application, and m-site (hereinafter referred to as the &ldquo;Platform&rdquo;).</strong></p>\r\n\r\n<p><strong>By visiting our Platform, you agree in providing your information or availing our product/service, you agree to be bound by the terms and conditions of this Privacy Policy, the Terms of Use and the applicable service/product terms and conditions. If you do not agree, please do not access or use our Platform.</strong></p>\r\n\r\n<p><strong>1. Collection and storage of Your Information</strong></p>\r\n\r\n<p><strong>&nbsp;Except making our platform easy, user friendly, interactive and transparent, &nbsp;we outsource most of the operations (like payments, delivery, buying, selling, advertising, etc. ) to third party vendors hence we are not responsible for any kind of conflicts, disputes, disagreement, any kind of visible or invisible issue or loss faced by anyone. When you chose to use our Platform, we collect and store your information which is provided by you from time to time. In general, you can browse the Platform without telling us who you are or revealing any personal information about yourself. Once you give us your personal information, you are the part of family to us. we indicate which fields are required and which fields are optional. You always have the option not to provide information by choosing not to use a particular service, product or feature on the Platform.</strong></p>\r\n\r\n<p><strong>at Otrixweb service we may track your buying habits, preferences, and other information that you choose to provide on our Platform. We use this information to do internal research on our users- interests, and habits to better understand, protect and serve you better. This information is compiled and analyzed on an aggregated basis. This information may include the URL that you just came from (whether this URL is on our Platform or not), which URL you next go to (whether this URL is on our Platform or not), your computer browser information, and your IP address. our service also &nbsp;collects personal information (such as email address, delivery address, name, phone number, credit card/debit card and other payment instrument details) from you when you set up an account or transact with us. While you can browse some sections of our Platform without being a registered member, certain activities (such as placing an order or consuming our online content &nbsp;or services) do require registration. We do use your contact information to send you offers based on your previous orders and your interests.</strong></p>\r\n\r\n<p><strong>If you choose to post messages on our message boards, chat rooms or other message areas or leave feedback or if you use voice commands to shop on the Platform, we will collect that information you provide to us. We retain this information as necessary to resolve disputes, provide customer support and troubleshoot problems as permitted by law.</strong></p>\r\n\r\n<p><strong>If you send us personal correspondence, such as emails or letters, or if other users or third parties send us correspondence about your activities or postings on the Platform, we may collect such information into a file specific to you.</strong></p>\r\n\r\n<p><strong>If you are eligible into our O-Coins Loyalty Program, we will collect and store your personal information such as name, contact number, email address, communication address, date of birth, gender, zip code, lifestyle information, demographic and work details etc. which is provided by you to Otrixweb E- commerce business private ltd &nbsp;or a third-party business partner that operates online/offline establishments or platforms where you can earns O-Coins for purchase of goods and services, and redeem O-Coins. We will also collect your information related to your transactions on Otrixweb business platform and such third-party business partner platforms. When such a third-party business partner collects your personal information directly from you, you will be governed by their privacy policies. Otrixweb e-commerce shall not be responsible for the third-party business partner&rsquo;s privacy practices or the content of their privacy policies, and we request you to read their privacy policies prior to disclosing any information.</strong></p>\r\n\r\n<p><strong>Otrixweb has onboarded certain third-party business partners on the Platform who specialize in the categories like travel ticket reservations, booking online movie tickets, paying online bills and more (Ultra-Partners). If you use the services of Ultra-Partners, you will be redirected to Ultra-Partners websites/applications and your entry to Ultra-Partners websites/applications will be based on your Otrixweb login credentials after seeking your permissions to share the data further. Otrixweb shall not be responsible for the Ultra-Partner&rsquo;s privacy practices or the content of their privacy policies, and we request you to read their privacy policies prior to disclosing any information.</strong></p>\r\n\r\n<p><strong>2. Use of Demographic / Profile Data / Your Information</strong></p>\r\n\r\n<p><strong>We at Otrixweb business E- commerce private limited uses your personal information to provide the product and services you request. To the extent we use your personal information to market to you, we will provide you the ability to opt-out of such uses. We use your personal information to assist sellers and business partners in handling and fulfilling orders; enhancing customer experience; resolve disputes; troubleshoot problems; help promote a safe service; collect money; measure consumer interest in our products and services; inform you about online and offline offers, products, services, and updates; customize and enhance your experience; detect and protect us against error, fraud and other criminal activity; enforce our terms and conditions; and as otherwise described to you at the time of collection of information.</strong></p>\r\n\r\n<p><strong>With your consent, we will have access to your SMS, contacts in your directory, location and device information. We may also request you to provide your PAN, GST Number, Government issued ID cards/number and Know-Your-Customer (KYC) details to:</strong></p>\r\n\r\n<p><strong>&nbsp;(1.) check your eligibility for certain products and services including but not limited to credit and payment products;</strong></p>\r\n\r\n<p><strong>&nbsp;(2.) issue GST invoice for the products and services purchased for your business requirements;&nbsp;</strong></p>\r\n\r\n<p><strong>(3.) enhance your experience on the Platform and provide you access to the products and services being offered by us, sellers, affiliates or lending partners. You understand that your access to these products/services may be affected in the event consent is not provided to us.</strong></p>\r\n\r\n<p><strong>In our efforts to continually improve our product and service offerings, we and our affiliates collect and analyze demographic and profile data about our users&#39; activity on our Platform. We identify and use your IP address to help diagnose problems with our server, and to administer our Platform. Your IP address is also used to help identify you and to gather broad demographic information.</strong></p>\r\n\r\n<p><strong>&nbsp;</strong></p>\r\n\r\n<p><strong>We will occasionally ask you to participate in optional surveys conducted either by us or through a third party market research agency. These surveys may ask you for personal information, contact information, date of birth, demographic information (like zip code, age, or income level), attributes such as your interests, household or lifestyle information, your purchasing habits or history, preferences, and other such information that you may choose to provide. The surveys may involve collection of voice data or video recordings, the participation of which would purely be voluntary in nature. We use this data to tailor your experience at our Platform, providing you with content that we think you might be interested in and to display content according to your preferences.</strong></p>\r\n\r\n<p><strong>3. Cookies</strong></p>\r\n\r\n<p><strong>We use data collection devices such as &quot;cookies&quot; on certain pages of the Platform to help analyze our web page flow, measure promotional effectiveness, and promote trust and safety. &quot;Cookies&quot; are small files placed on your hard drive that assist us in providing our services. Cookies do not contain any of your personal information. We offer certain features that are only available through the use of a &quot;cookie&quot;. We also use cookies to allow you to enter your password less frequently during a session. Cookies can also help us provide information that is targeted to your interests. Most cookies are &quot;session cookies,&quot; meaning that they are automatically deleted from your hard drive at the end of a session. You are always free to decline/delete our cookies if your browser permits, although in that case you may not be able to use certain features on the Platform and you may be required to re-enter your password more frequently during a session. Additionally, you may encounter &quot;cookies&quot; or other similar devices on certain pages of the Platform that are placed by third parties. We do not control the use of cookies by third parties. We use cookies from third-party partners such as Google Analytics for marketing and analytical purposes. Google Analytics help us understand how our customers use the site. You can read more about how Google uses your Personal Information. You can also opt-out of Google Analytics.</strong></p>\r\n\r\n<p><strong>4. Sharing of personal information</strong></p>\r\n\r\n<p><strong>We may share personal information with our other corporate entities and affiliates for purposes of providing products and services offered by them, such as, the deferred payment options at Otrixweb through its lending partners. These entities and affiliates may share such information with their affiliates, business partners and other third parties for the purpose of providing you their products and services, and may market to you as a result of such sharing unless you explicitly opt-out.</strong></p>\r\n\r\n<p><strong>We may disclose your personal information to third parties, such as sellers, business partners. This disclosure may be required for us to provide you access to our products and services; for fulfilment of your orders; for enhancing your experience; for providing feedback on products; to collect payments from you; to comply with our legal obligations; to conduct market research or surveys; to enforce our Terms of Use; to facilitate our marketing and advertising activities; to analyze data; for customer service assistance; to prevent, detect, mitigate, and investigate fraudulent or illegal activities related to our product and services. We do not disclose your personal information to third parties for their marketing and advertising purposes without your explicit consent.</strong></p>\r\n\r\n<p><strong>We may disclose personal information if required to do so by law or in the good faith belief that such disclosure is reasonably necessary to respond to subpoenas, court orders, or other legal process. We may disclose personal information to law enforcement agencies, third party rights owners, or others in the good faith belief that such disclosure is reasonably necessary to: enforce our Terms of Use or Privacy Policy; respond to claims that an advertisement, posting or other content violates the rights of a third party; or protect the rights, property or personal safety of our users or the general public.</strong></p>\r\n\r\n<p><strong>We and our affiliates will share / sell some or all of your personal information with another business entity should we (or our assets) plan to merge with, or be acquired by that business entity, or re-organization, amalgamation, restructuring of business. Should such a transaction occur that other business entity (or the new combined entity) will be required to follow this Privacy Policy with respect to your personal information.</strong></p>\r\n\r\n<p><strong>5. Links to Other Sites</strong></p>\r\n\r\n<p><strong>Our Platform may provide links to other websites or application that may collect personal information about you. We are not responsible for the privacy practices or the content of those linked websites.</strong></p>\r\n\r\n<p><strong>6. Security Precautions</strong></p>\r\n\r\n<p><strong>We maintain reasonable physical, electronic and procedural safeguards to protect your information. Whenever you access your account information, we offer the use of a secure server. Once your information is in our possession we adhere to our security guidelines to protect it against unauthorized access. However, by using the Platform, the users accept the inherent security implications of data transmission over the internet and the World Wide Web which cannot always be guaranteed as completely secure, and therefore, there would always remain certain inherent risks regarding use of the Platform. Users are responsible for ensuring the protection of login and password records for their account.</strong></p>\r\n\r\n<p><strong>7. Choice/Opt-Out</strong></p>\r\n\r\n<p><strong>We provide all users with the opportunity to opt-out of receiving non-essential (promotional, marketing-related) communications after setting up an account with us. If you do not wish to receive promotional communications from us then please login into the Notification Preference page of Platform to unsubscribe/opt-out.</strong></p>\r\n\r\n<p><strong>8. Advertisements on Platform</strong></p>\r\n\r\n<p><strong>We use third-party advertising companies to serve ads when you visit our Platform. These companies may use information (not including your name, address, email address, or telephone number) about your visits to this and other websites in order to provide advertisements about goods and services of interest to you.</strong></p>\r\n\r\n<p><strong>9. Children Information</strong></p>\r\n\r\n<p><strong>We do not knowingly solicit or collect personal information from children under the age of 18 and use of our Platform is available only to persons who can form a legally binding contract under the Indian Contract Act, 1872. If you are under the age of 18 years then you must use the Platform, application or services under the supervision of your parent, legal guardian, or any responsible adult.</strong></p>\r\n\r\n<p><strong>10. Data Retention</strong></p>\r\n\r\n<p><strong>We retain your personal information in accordance with applicable laws, for a period no longer than is required for the purpose for which it was collected or as required under any applicable law. However, we may retain data related to you if we believe it may be necessary to prevent fraud or future abuse or if required by law or for other legitimate purposes. We may continue to retain your data in anonymized form for analytical and research purposes.</strong></p>\r\n\r\n<p><strong>11. Your Consent</strong></p>\r\n\r\n<p><strong>By visiting our Platform or by providing your information, you consent to the collection, use, storage, disclosure and otherwise processing of your information (including sensitive personal information) on the Platform in accordance with this Privacy Policy. If you disclose to us any personal information relating to other people, you represent that you have the authority to do so and to permit us to use the information in accordance with this Privacy Policy.</strong></p>\r\n\r\n<p><strong>You, while providing your personal information over the Platform or any partner platforms or establishments, consent to us (including our other corporate entities, affiliates, lending partners, technology partners, marketing channels, business partners and other third parties) to contact you through SMS, instant messaging apps, call and/or e-mail for the purposes specified in this Privacy Policy.</strong></p>\r\n\r\n<p><strong>12. Changes to this Privacy Policy</strong></p>\r\n\r\n<p><strong>Please check our Privacy Policy periodically for changes. We may update this Privacy Policy to reflect changes to our information practices. We will alert you to significant changes by posting the date our policy got last updated, placing a notice on our Platform, or by sending you an email when we are required to do so by applicable law.</strong></p>\r\n\r\n<p><strong>14. Queries</strong></p>\r\n\r\n<p><strong>If you have any query, issue, concern, or complaint in relation to collection or usage of your personal information under this Privacy Policy, please contact us at the contact information provided above.</strong></p>', '2021-12-14 01:38:01', '2022-03-09 02:09:35', NULL),
(2, 'Terms and Conditions', 'Terms and Conditions', NULL, '<p><strong>Terms &amp; Conditions</strong></p>\r\n\r\n<p><strong>1. It is hereby informed to every individuals who are using Otrixweb E-commerce Business platform, Otrixweb Business shall not be responsible for any lost delivery, false delivery, false delivery of product, broken delivery, permanent or temporary loss of product, only delivery partners are answerable for above terms.</strong></p>\r\n\r\n<p><strong>2. It is hereby informed that neither we at Otrixweb E-commerce Business are manufacturer nor we are trader we are only providing the platform from where anyone globally make a purchasing request for their wished product manufacturer and we are a bridge between seller and customer.</strong></p>\r\n\r\n<p><strong>3. Here at Otrixweb E-commerce Business we try our best to establish a transparent relation between customers and sellers in order to maintain the dignity of original products deliver to you.</strong></p>\r\n\r\n<p><strong>4. Except making our platform easy, user friendly, interactive and transparent, &nbsp;we outsource most of the operations (like payments, delivery, buying, selling, advertising, etc. ) to third party vendors hence we are not responsible for any kind of conflicts, disputes, disagreement, any kind of visible or invisible issue or loss faced by anyone.</strong></p>\r\n\r\n<p><strong>5. We reserve all direct and indirect rights related to Otrixweb E-commerce Business with us, hence we emphasis on policy i.e. at Otrixweb E-commerce Business we can modify or discontinue any privacy policy, any agreements, contracts, terms and conditions with any partner, collaborations with any third party vendor, partner or costumers without any prior notice, in case of misuse noticed. It is entirely the responsibility of our partners, collaborations, and our customers to follow our terms and condition, privacy policies and contract update regularly.</strong></p>\r\n\r\n<p><strong>6. Sharing of personal information</strong></p>\r\n\r\n<p><strong>We may share personal information with our other corporate entities and affiliates for purposes of providing products and services offered by them, such as, the deferred payment options at Otrixweb through its lending partners. These entities and affiliates may share such information with their affiliates, business partners and other third parties for the purpose of providing you their products and services, and may market to you as a result of such sharing unless you explicitly opt-out.</strong></p>\r\n\r\n<p><strong>7.We may disclose your personal information to third parties, such as sellers, business partners. This disclosure may be required for us to provide you access to our products and services; for fulfilment of your orders; for enhancing your experience; for providing feedback on products; to collect payments from you; to comply with our legal obligations; to conduct market research or surveys; to enforce our Terms of Use; to facilitate our marketing and advertising activities; to analyze data; for customer service assistance; to prevent, detect, mitigate, and investigate fraudulent or illegal activities related to our product and services. We do not disclose your personal information to third parties for their marketing and advertising purposes without your explicit consent.</strong></p>\r\n\r\n<p><strong>8. We respect, follow and adhere the law and order of all the states, territories and nationwide but &nbsp;we shall not be responsible for any legal actions or allegation taking against Otrixweb E-commerce Business Private LTD, in or at the spot of allegation or difficulty faced by any company, partners, or customers in their home town. We respond each and every legal queries or complaint filled against us and will be entertained only in law and order body operational in capital of India &nbsp;at origin of our headquarters, only in the case when our customer handling team unable to solve the allegations or any difficulties faced by anyone across.</strong></p>', '2021-12-14 01:46:43', '2022-03-09 02:08:41', NULL);
INSERT INTO `pages` (`id`, `title`, `heading`, `image`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Return & Refund Policy', 'Return & Refund Policy', NULL, '<div class=\"content\"><p>Return policy Otrixweb</p><p><br></p><h1 dir=\"ltr\" style=\"line-height:1.7999999999999998;text-align: center;background-color:#ffffff;margin-top:15pt;margin-bottom:0pt;padding:0pt 0pt 4pt 0pt;\"><span style=\"font-size:16.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Returns Policy</span></h1><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:7pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Returns is a scheme provided by respective sellers directly under this policy in terms of which the option of exchange, replacement and/ or refund is offered by the respective sellers to you. All products listed under a particular category may not have the same returns policy. For all products, the returns/replacement policy provided on the product page shall prevail over the general returns policy. Do refer the respective item\'s applicable return/replacement policy on the product page for any exceptions to this returns policy and the table below</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">The return policy is divided into three parts; Do read all sections carefully to understand the conditions and cases under which returns will be accepted.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Part 1 Ã¢â‚¬â€œ Category, Return Window and Actions possible</span></p><div dir=\"ltr\" style=\"margin-left:0pt;\" align=\"left\"><table style=\"border:none;border-collapse:collapse;\"><colgroup><col width=\"168\"><col width=\"423\"></colgroup><tbody><tr style=\"height:39.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Category</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Returns Window, Actions Possible and Conditions (if any)</span></p></td></tr><tr style=\"height:213pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Lifestyle: KidÃ¢â‚¬â„¢s (Capri, Shorts &amp; Tops), MenÃ¢â‚¬â„¢s (Ethnic Wear, Shirt, Formals, Jeans, Clothing Accessory), WomenÃ¢â‚¬â„¢s (Ethnic Wear, Fabric, Blouse, Jean, Skirt, Trousers, Bra), Bags, Raincoat, Sunglass, Belt, Frame, Backpack, Suitcase, Luggage</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund, replacement or exchange</span></p></td></tr><tr style=\"height:287.25pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Lifestyle: Jewelry, Footwear Accessories, Travel Accessories, Watch Accessories, Winter Wear (Blazer, Sweatshirt, Scarf, Shawl, Jacket, Coat, Sweater, Thermal, KidÃ¢â‚¬â„¢s Thermal, Track Pant, Shrugs)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Home: Pet Supplies &amp; Rest of Home. (Except Home dÃƒÂ©cor, Furnishing, Home Improvement Tools, Household Items)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund or replacement</span></p></td></tr><tr style=\"height:66.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Watch, Footwear and Rest of Lifestyle</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund, replacement or exchange</span></p></td></tr><tr style=\"height:66.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Medicine (Allopathy &amp; Homeopathy)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">2 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund</span></p></td></tr><tr style=\"height:87pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Home: Home Improvement Tools, Household Items, Home dÃƒÂ©cor, Furnishing</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund or replacement</span></p></td></tr><tr style=\"height:246.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Books (All books)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Sports Equipment (Racquet, ball, support, gloves, bags etc.)&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Exercise &amp; Fitness Equipment (Home Gym combos, dumbbell etc.)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Auto Accessories - Car and Bike accessories (helmets, car kit, media players etc.)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days Replacement only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Free replacement will be provided within 3 days if the product is delivered in defective/damaged condition or different from the ordered item.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Please keep the product intact, with original accessories, user manual and warranty cards in the original packaging at the time of returning the product.&nbsp;</span></p></td></tr><tr style=\"height:246.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Toys (Remote controlled toys, Learning toys, Stuffed toys etc.)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Stationary (Pens, Diary notebooks, Calculators etc.)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Musical Instruments (Microphones &amp; Accessories, Guitars, Violins etc.)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3&nbsp; days Replacement only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Free replacement will be provided within 10 days if the product is delivered in defective/damaged condition or different from the ordered item.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Please keep the product intact, with original accessories, user manual and warranty cards in the original packaging at the time of returning the product.&nbsp;</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Non Returnable- All Wind Instruments (Harmonicas, Flutes etc.) This item is non-returnable due to hygiene and personal wellness. In case these products are delivered in damaged/defective condition or different from the ordered item, we will provide a free replacement.</span></p></td></tr><tr style=\"height:267pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">All Mobiles (except Apple / Google phones),</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Electronics - (except Apple / Beats, Google, Realme, Samsung, JBL or Infinity, Epson, HP, Dell, Canon, MI Products (Tablets, Laptops, Smart Watches)</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">All Small Home Appliances (Except Chimney, Water Purifier, Fan, Geyser)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Replacement only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In order to help you resolve issues with your product, we may troubleshoot your product either through online tools, over the phone, and/or through an in-person technical visit.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">If a defect is determined within the Returns Window, a replacement of the same model will be provided at no additional cost. If no defect is confirmed or the issue is not diagnosed within 3 days of delivery, you will be directed to a brand service centre to resolve any subsequent issues.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In any case, only one replacement shall be provided.</span></p></td></tr><tr style=\"height:935.25pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Mobile - Apple &amp; Google.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Electronics - Apple / Beats, Google, Realme, Samsung, JBL &amp; Infinity, Epson, HP, Dell, Canon &amp; MI Products (Tablets, Laptops, Smart Watches)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">For any other issues with the product you may contact the concerned brandÃ¢â‚¬â„¢s support.</span></p></td></tr><tr style=\"height:316.5pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Furniture, Large appliances</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Rest of Small Home Appliances - Chimney, Water Purifier, Fan, Geyser only</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Replacement only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">For products requiring installation, returns shall be eligible only when such products are installed by the brand\'s authorized personnel.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In order to help you resolve issues with your product, we may troubleshoot your product either through online tools, over the phone, and/or through an in-person technical visit.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">If a defect is determined within the Returns Window, a replacement of the same model will be provided at no additional cost. If no defect is confirmed or the issue is not diagnosed within 3 days of delivery or Installation wherever applicable, you will be directed to a brand service centre to resolve any subsequent issues.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In any case, only one replacement shall be provided.</span></p></td></tr><tr style=\"height:71.25pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Grocery - (Dairy, Bakery, Fruits and Vegetables)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">2 Days Refund Only</span></p></td></tr><tr style=\"height:172.5pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Grocery - (Remaining items under grocery)</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Fruits and Vegetables ordered would be delivered only in the first attempt. In order to ensure that you get fresh fruits and vegetables, we will not be making reattempts to deliver your fruits and veggies in case you miss your slot. Rest of grocery items from Supermarket would be delivered through reattempt in case you miss your slot.</span></p></td></tr><tr style=\"height:183.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Try &amp; Buy</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">3 days</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Refund only</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">This policy shall be applicable selectively (geographical coverage, product, customer and time periods).</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Try &amp; Buy benefits shall be applicable only if the product was bought when the item was on Try &amp; Buy. Else normal category policy shall apply on the order. In any case, only one replacement shall be provided.</span></p></td></tr><tr style=\"height:98.25pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">No Returns categories</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Some products in the above categories are not returnable due to their nature or other reasons. For all products, the policy on the product page shall prevail.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">You can view the complete list of non-returnable products.</span></p></td></tr></tbody></table></div><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Part 2 - Returns Pick-Up and Processing</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In case of returns where you would like item(s) to be picked up from a different address, the address can only be changed if pick-up service is available at the new address</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">During pick-up, your product will be checked for the following conditions:</span></p><div dir=\"ltr\" style=\"margin-left:0pt;\" align=\"left\"><table style=\"border:none;border-collapse:collapse;\"><colgroup><col width=\"94\"><col width=\"497\"></colgroup><tbody><tr style=\"height:39.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Category</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Conditions</span></p></td></tr><tr style=\"height:55.5pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Correct Product</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">IMEI/ name/ image/ brand/ serial number/ article number/ bar code should match and the MRP tag should be undetached and clearly visible.</span></p></td></tr><tr style=\"height:71.25pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Complete Product</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">All in-the-box accessories (like remote control, starter kits, instruction manuals, chargers, headphones, etc.), freebies and combos (if any) should be present.</span></p></td></tr><tr style=\"height:102.75pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Unused Product</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">The product should be unused, unwashed, unsoiled, without any stains and with non-tampered quality check seals/return tags/warranty seals (wherever applicable). Before returning a Mobile/ Laptop/ Tablet, the device should be formatted and Screen Lock (Pin, Pattern or Fingerprint) must be disabled. iCloud lock must be disabled for Apple devices.</span></p></td></tr><tr style=\"height:55.5pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Undamaged Product</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">The product (including SIM trays/ charging port/ headphone port, back-panel etc.) should be undamaged and without any scratches, dents, tears or holes.</span></p></td></tr><tr style=\"height:55.5pt\"><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Undamaged Packaging</span></p></td><td style=\"border-left:solid #000000 0.75pt;border-right:solid #000000 0.75pt;border-bottom:solid #000000 0.75pt;border-top:solid #000000 0.75pt;vertical-align:top;background-color:#ffffff;padding:6pt 6pt 6pt 6pt;overflow:hidden;overflow-wrap:break-word;\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Product\'s original packaging/ box should be undamaged.</span></p></td></tr></tbody></table></div><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">The field executive will refuse to accept the return if any of the above conditions are not met.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">For any products for which a refund is to be given, the refund will be processed once the returned product has been received by the seller.</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Part 3 - General Rules for a successful Return</span></p><ol style=\"margin-top:0;margin-bottom:0;padding-inline-start:48px;\"><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">In certain cases where the seller is unable to process a replacement for any reason whatsoever, a refund will be given.</span></p></li><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">During open box deliveries, while accepting your order, if you received a different or a damaged product, you will be given a refund (on the spot refunds for cash-on-delivery orders). Once you have accepted an open box delivery, no return request will be processed, except for manufacturing defects. In such cases, this category-specific replacement/return general conditions will be applicable.</span></p></li><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\" role=\"presentation\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">For products where installation is provided by Otrixweb Ecommerce\'s service partners, do not open the product packaging by yourself. Otrixweb Ecommerce authorized personnel shall help in unboxing and installation of the product.</span></p></li><li dir=\"ltr\" style=\"list-style-type:decimal;font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;\" aria-level=\"1\"><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:0pt 0pt 6pt 0pt;\" role=\"presentation\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">For Furniture, any product related issues will be checked by an authorized service personnel (free of cost) and attempted to be resolved by replacing the faulty/ defective part of the product. Full replacement will be provided only in cases where the service personnel opines that replacing the faulty/defective part will not resolve the issue.</span></p></li></ol><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:11pt;margin-bottom:0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">Wrong Delivery - (Customer received delivery message, product not delivered):</span></p><p dir=\"ltr\" style=\"line-height:1.7999999999999998;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;padding:11pt 0pt 0pt 0pt;\"><span style=\"font-size:10.5pt;font-family:Roboto,sans-serif;color:#212121;background-color:transparent;font-weight:400;font-style:normal;font-variant:normal;text-decoration:none;vertical-align:baseline;white-space:pre;white-space:pre-wrap;\">\'In case the product was not delivered and you received a delivery confirmation email/SMS, report the issue within 3 days from the date of delivery confirmation for the seller to investigate.\'</span></p><p><span id=\"docs-internal-guid-4e0e88e7-7fff-71a6-1506-f50041705a39\"></span></p><p dir=\"ltr\" style=\"line-height:1.656;background-color:#ffffff;margin-top:0pt;margin-bottom:0pt;\">&nbsp;</p></div>', '2022-03-09 00:48:07', '2022-03-09 03:26:03', NULL);
INSERT INTO `pages` (`id`, `title`, `heading`, `image`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Shipping & Delivery Policy', 'Shipping & Delivery Policy', NULL, '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '2022-03-09 00:48:36', '2022-03-09 01:59:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'customer.add', 'Add', 'web', '2021-07-07 03:37:38', '2021-07-07 05:27:28'),
(2, 'customer.edit', 'Edit', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(3, 'customer', 'List', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(4, 'customer.delete', 'Delete', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(5, 'category.add', 'Add', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(6, 'category.edit', 'Edit', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(7, 'category', 'List', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(8, 'category.delete', 'Delete', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(9, 'banner.add', 'Add', 'web', '2021-07-07 05:47:44', '2021-07-07 05:47:44'),
(10, 'banner.edit', 'Edit', 'web', '2021-07-07 05:47:44', '2021-07-07 05:47:44'),
(11, 'banner', 'List', 'web', '2021-07-07 05:47:44', '2021-07-07 05:47:44'),
(12, 'banner.delete', 'Delete', 'web', '2021-07-07 05:47:44', '2021-07-07 05:47:44'),
(15, 'permission', 'List', 'web', '2021-07-07 06:03:37', '2021-07-07 06:03:37'),
(17, 'role.add', 'Add', 'web', '2021-07-07 06:03:37', '2021-07-07 06:03:37'),
(19, 'role', 'List', 'web', '2021-07-07 06:03:37', '2021-07-07 06:03:37'),
(20, 'role.delete', 'Delete', 'web', '2021-07-07 06:03:37', '2021-07-07 06:03:37'),
(21, 'product.add', 'Add', 'web', '2021-07-07 14:49:34', '2021-07-07 14:49:34'),
(22, 'product.edit', 'Edit', 'web', '2021-07-07 14:49:34', '2021-07-07 14:49:34'),
(23, 'product', 'List', 'web', '2021-07-07 14:49:34', '2021-07-07 14:49:34'),
(24, 'product.delete', 'Delete', 'web', '2021-07-07 14:49:34', '2021-07-07 14:49:34'),
(25, 'length-class.add', 'Add', 'web', '2021-07-07 15:23:07', '2021-07-07 15:23:07'),
(26, 'length-class.edit', 'Edit', 'web', '2021-07-07 15:23:07', '2021-07-07 15:23:07'),
(27, 'length-class', 'List', 'web', '2021-07-07 15:23:07', '2021-07-07 15:23:07'),
(28, 'length-class.delete', 'Delete', 'web', '2021-07-07 15:23:07', '2021-07-07 15:23:07'),
(29, 'role.edit', 'Edit', 'web', '2021-07-07 16:02:26', '2021-07-07 16:02:26'),
(30, 'country.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(31, 'country.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(32, 'country', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(33, 'country.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(34, 'tax-rate.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(35, 'tax-rate.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(36, 'tax-rate', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(37, 'tax-rate.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(38, 'stock-status.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(39, 'stock-status.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(40, 'stock-status', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(41, 'stock-status.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(42, 'weight-class.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(43, 'weight-class.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(44, 'weight-class', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(45, 'weight-class.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(46, 'review', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(47, 'manufacturer.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(48, 'manufacturer.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(49, 'manufacturer.review', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(50, 'manufacturer.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(51, 'order-status.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(52, 'order-status.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(53, 'order-status', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(54, 'order-status.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(55, 'order.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(56, 'order.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(57, 'order', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(58, 'order.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(59, 'coupon.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(60, 'coupon.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(61, 'coupon', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(62, 'coupon.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(63, 'product-option.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(64, 'product-option.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(65, 'product-option', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(66, 'product-option.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(67, 'setting.add', 'Add', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(68, 'setting.edit', 'Edit', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(69, 'setting', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(70, 'setting.delete', 'Delete', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(71, 'user.add', 'Add', 'web', '2021-07-08 08:29:04', '2021-07-08 08:29:04'),
(72, 'user.edit', 'Edit', 'web', '2021-07-08 08:29:04', '2021-07-08 08:29:04'),
(73, 'user', 'List', 'web', '2021-07-08 08:29:04', '2021-07-08 08:29:04'),
(74, 'user.delete', 'Delete', 'web', '2021-07-08 08:29:04', '2021-07-08 08:29:04'),
(75, 'product-attribute-group.add', 'Add', 'web', '2021-07-10 02:29:04', '2021-07-10 02:29:04'),
(76, 'product-attribute-group.edit', 'Edit', 'web', '2021-07-10 02:29:04', '2021-07-10 02:29:04'),
(77, 'product-attribute-group', 'List', 'web', '2021-07-10 02:29:04', '2021-07-10 02:29:04'),
(78, 'product-attribute-group.delete', 'Delete', 'web', '2021-07-10 02:29:04', '2021-07-10 02:29:04'),
(79, 'product-attribute.add', 'Add', 'web', '2021-07-10 03:51:59', '2021-07-10 03:51:59'),
(80, 'product-attribute.edit', 'Edit', 'web', '2021-07-10 03:51:59', '2021-07-10 03:51:59'),
(81, 'product-attribute', 'List', 'web', '2021-07-10 03:51:59', '2021-07-10 03:51:59'),
(82, 'product-attribute.delete', 'Delete', 'web', '2021-07-10 03:51:59', '2021-07-10 03:51:59'),
(85, 'seller', 'List', 'web', NULL, NULL),
(86, 'permission.add', 'Add', 'web', '2021-07-07 06:03:37', '2021-07-07 06:03:37'),
(87, 'manufacturer', 'List', 'web', '2021-07-07 16:19:02', '2021-07-07 16:19:02'),
(88, 'pages.add', 'Add', 'web', '2021-07-07 03:37:38', '2021-07-07 05:27:28'),
(89, 'pages.edit', 'Edit', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(90, 'pages', 'List', 'web', '2021-07-07 05:27:28', '2021-07-07 05:27:28'),
(91, 'trending_dod', 'Trending And DOD  List Permissions', 'web', NULL, NULL),
(92, 'trending_dod.add', 'Trending And DOD Add', 'web', NULL, NULL),
(93, 'trending_dod.edit', 'Trending And DOD Update', 'web', NULL, NULL),
(94, 'shipping', 'List Shipping', 'web', NULL, NULL),
(95, 'shipping.add', 'Add Shipping', 'web', NULL, NULL),
(96, 'shipping.edit', 'Edit Shipping', 'web', NULL, NULL),
(97, 'shipping.delete', 'Shipping Delete', 'web', NULL, NULL),
(98, 'order.view', 'Order View', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `sale` int(1) DEFAULT '0',
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `model` varchar(64) NOT NULL,
  `jan` varchar(13) DEFAULT NULL,
  `isbn` varchar(17) DEFAULT NULL,
  `mpn` varchar(64) DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `quantity` int(6) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `shipping` enum('Yes','No') DEFAULT 'No',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `min_price` int(255) DEFAULT '0',
  `max_price` int(255) DEFAULT '1000',
  `points` int(8) DEFAULT '0',
  `tax_rate_id` int(11) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `weight` decimal(15,4) DEFAULT '0.0000',
  `weight_class_id` int(11) DEFAULT '0',
  `length` decimal(15,4) DEFAULT '0.0000',
  `width` decimal(15,4) DEFAULT '0.0000',
  `height` decimal(15,4) DEFAULT '0.0000',
  `length_class_id` int(11) DEFAULT '0',
  `subtract` tinyint(1) DEFAULT '1',
  `minimum` int(11) DEFAULT '1',
  `sort_order` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `viewed` int(5) DEFAULT '0',
  `sell_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `group_id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'In The Box', 1, '2022-03-15 06:41:04', '2022-03-15 06:41:04', NULL),
(2, 1, 'Model Number', 1, '2022-03-15 06:41:14', '2022-03-15 06:41:14', NULL),
(3, 1, 'Model Name', 1, '2022-03-15 06:41:28', '2022-03-15 06:41:28', NULL),
(4, 1, 'Color', 1, '2022-03-15 06:41:36', '2022-03-15 06:41:36', NULL),
(5, 1, 'Browse Type', 1, '2022-03-15 06:41:52', '2022-03-15 06:41:52', NULL),
(6, 1, 'SIM Type', 1, '2022-03-15 06:42:01', '2022-03-15 06:42:01', NULL),
(7, 1, 'Touchscreen', 1, '2022-03-15 06:42:13', '2022-03-15 06:42:13', NULL),
(8, 2, 'Display Size', 1, '2022-03-15 06:43:24', '2022-03-15 06:43:24', NULL),
(9, 2, 'Resolution', 1, '2022-03-15 06:43:35', '2022-03-15 06:46:13', NULL),
(10, 2, 'Resolution Type', 1, '2022-03-15 06:43:43', '2022-03-15 06:46:21', NULL),
(11, 2, 'GPU', 1, '2022-03-15 06:43:54', '2022-03-15 06:44:38', NULL),
(12, 2, 'Display Type', 1, '2022-03-15 06:44:07', '2022-03-15 06:45:23', NULL),
(13, 2, 'Display Colors', 1, '2022-03-15 06:44:14', '2022-03-15 06:45:39', NULL),
(14, 3, 'Operating System', 1, '2022-03-15 06:44:25', '2022-03-15 06:46:01', NULL),
(15, 4, 'Internal Storage', 1, '2022-03-15 06:46:36', '2022-03-15 06:46:36', NULL),
(16, 4, 'RAM', 1, '2022-03-15 06:46:49', '2022-03-15 06:46:49', NULL),
(17, 4, 'Expandable Storage', 1, '2022-03-15 06:47:04', '2022-03-15 06:47:04', NULL),
(18, 4, 'Supported Memory Card Type', 1, '2022-03-15 06:47:14', '2022-03-15 06:47:34', NULL),
(19, 4, 'Memory Card Slot Type', 1, '2022-03-15 06:47:23', '2022-03-15 06:47:45', NULL),
(20, 3, 'Processor Type', 1, '2022-03-15 06:48:12', '2022-03-15 06:48:12', NULL),
(21, 3, 'Processor Core', 1, '2022-03-15 06:48:25', '2022-03-15 06:48:25', NULL),
(22, 3, 'Primary Clock Speed', 1, '2022-03-15 06:48:38', '2022-03-15 06:48:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_groups`
--

CREATE TABLE `product_attribute_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_attribute_groups`
--

INSERT INTO `product_attribute_groups` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'General', 1, '2022-03-15 06:39:03', '2022-03-15 06:39:03', NULL),
(2, 'Display Features', 1, '2022-03-15 06:39:16', '2022-03-15 06:39:16', NULL),
(3, 'Os & Processor Features', 1, '2022-03-15 06:39:31', '2022-03-15 06:39:31', NULL),
(4, 'Memory & Storage Features', 1, '2022-03-15 06:39:46', '2022-03-15 06:39:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_description`
--

CREATE TABLE `product_description` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `tag` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_description`
--

INSERT INTO `product_description` (`id`, `product_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(42, 46, NULL, 'Guard', '<p>A guard protects you at marketplace.</p>', NULL, NULL, NULL, NULL),
(69, 75, NULL, 'Bitcoin', '<p>bitcoin</p>', NULL, NULL, NULL, NULL),
(67, 73, NULL, 'Iron', '<p>Iron</p>', NULL, NULL, NULL, NULL),
(66, 72, NULL, 'Steel', '<p>Steel</p>', NULL, NULL, NULL, NULL),
(65, 71, NULL, 'Aluminum', '<p>Aluminum</p>', NULL, NULL, NULL, NULL),
(64, 70, NULL, 'Bronze', '<p>Bronze</p>', NULL, NULL, NULL, NULL),
(62, 68, NULL, 'copper', '<p>copper</p>', NULL, NULL, NULL, NULL),
(63, 69, NULL, 'Brass', '<p>brass</p>', NULL, NULL, NULL, NULL),
(50, 54, NULL, 'Ethereum', '<p>Ethereum</p>', NULL, NULL, NULL, NULL),
(61, 67, NULL, 'test', '<p>test14</p>', NULL, NULL, NULL, NULL),
(56, 60, NULL, 'Ethereum', '<p>Ethereum</p>', NULL, NULL, NULL, NULL),
(53, 57, NULL, 'test', '<p>test</p>', NULL, NULL, NULL, NULL),
(58, 64, NULL, 'test', '<p>test14</p>', NULL, NULL, NULL, NULL),
(59, 65, NULL, 'test', '<p>test14</p>', NULL, NULL, NULL, NULL),
(60, 66, NULL, 'test', '<p>test14</p>', NULL, NULL, NULL, NULL),
(70, 76, NULL, 'Ethereum', '<p>Ethereum</p>', NULL, NULL, NULL, NULL),
(71, 77, NULL, 'Guard', '<p>Guard</p>', NULL, NULL, NULL, NULL),
(72, 78, NULL, 'Coal', '<p>coal</p>', NULL, NULL, NULL, NULL),
(73, 79, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(75, 81, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(76, 82, NULL, 'Blue ink', '<p>Blue ink</p>', NULL, NULL, NULL, NULL),
(77, 83, NULL, 'Black ink', '<p>Black ink</p>', NULL, NULL, NULL, NULL),
(78, 84, NULL, 'Nickel', '<p>Nickel</p>', NULL, NULL, NULL, NULL),
(79, 85, NULL, 'Pine Pollen Powder', '<p>Pine Pollen Powder</p>', NULL, NULL, NULL, NULL),
(83, 89, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(84, 90, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(85, 91, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(87, 93, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(89, 95, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(90, 96, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(93, 99, NULL, 'Sea weed', '<p>Sea weed</p>', NULL, NULL, NULL, NULL),
(94, 100, NULL, 'Cotton', '<p>Cotton</p>', NULL, NULL, NULL, NULL),
(95, 101, NULL, 'indigo', '<p>indigo</p>', NULL, NULL, NULL, NULL),
(96, 102, NULL, 'Rubber', '<p>Rubber&nbsp;</p>', NULL, NULL, NULL, NULL),
(122, 128, NULL, 'Cotton', '<p>Cotton</p>', NULL, NULL, NULL, NULL),
(123, 129, NULL, 'Sea weed', '<p>Sea weed</p>', NULL, NULL, NULL, NULL),
(247, 253, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(326, 332, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(327, 333, NULL, 'Rubber', '<p>Rubber&nbsp;</p>', NULL, NULL, NULL, NULL),
(559, 565, NULL, 'Porcelain clay', '<p>Porcelain clay</p>', NULL, NULL, NULL, NULL),
(560, 566, NULL, 'Rubber', '<p>Rubber&nbsp;</p>', NULL, NULL, NULL, NULL),
(561, 567, NULL, 'Rubber', '<p>Rubber&nbsp;</p>', NULL, NULL, NULL, NULL),
(566, 572, NULL, 'Cotton', '<p>Cotton</p>', NULL, NULL, NULL, NULL),
(563, 569, NULL, 'Test', '<p>test</p>', NULL, NULL, NULL, NULL),
(564, 570, NULL, 'Test', '<p>test</p>', NULL, NULL, NULL, NULL),
(10431, 10437, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10432, 10438, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10429, 10435, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10421, 10427, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10422, 10428, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10423, 10429, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10424, 10430, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10427, 10433, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10428, 10434, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10420, 10426, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10419, 10425, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10418, 10424, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10400, 10406, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10401, 10407, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10402, 10408, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10403, 10409, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10404, 10410, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10405, 10411, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10406, 10412, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10407, 10413, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10408, 10414, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10409, 10415, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10410, 10416, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10411, 10417, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10412, 10418, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10413, 10419, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10414, 10420, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10415, 10421, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10416, 10422, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10417, 10423, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10425, 10431, NULL, 'Sulfur', '<p>sulfur</p>', NULL, NULL, NULL, NULL),
(10426, 10432, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL),
(10430, 10436, NULL, 'Kaolin clay', '<p>kaolin, also called china clay, soft white clay that is an essential ingredient in the manufacture of china and porcelain and is widely used in the making of paper, rubber, paint, and many other products. Kaolin is named after the hill in China (Kao-ling) from which it was mined for centuries.</p>', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_discount`
--

CREATE TABLE `product_discount` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `sort_order_discount` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_filter`
--

CREATE TABLE `product_filter` (
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order_image` int(3) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image`, `sort_order_image`) VALUES
(28, 58, '1647352557fabio-scaletta-cYSRncVxE44-unsplash.jpg', NULL),
(29, 85, '1656233120scotchpinemale2.jpg', NULL),
(11, 9, '1647349441Product_05.png', 1),
(12, 10, '1647349482Product_05.png', 1),
(37, 101, '16563968432.jpg', 2),
(38, 101, '16563968434.jpg', 3),
(21, 34, '1647352336Product_11.jpg', 1),
(22, 35, '1647352557fabio-scaletta-cYSRncVxE44-unsplash.jpg', NULL),
(23, 36, '1647352336Product_11.jpg', 1),
(24, 37, '1647352557fabio-scaletta-cYSRncVxE44-unsplash.jpg', NULL),
(25, 40, '1647352438tamara-bellis-Brl7bqld05E-unsplash-removebg-preview.png', 1),
(27, 45, '1647352336Product_11.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `name`, `type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Color', 'Color', 1, '2022-03-15 04:54:49', '2022-03-15 04:54:49', NULL),
(2, 'Size', 'Checkbox', 1, '2022-03-15 04:55:08', '2022-03-15 04:55:08', NULL),
(3, 'Hardware', 'Select', 1, '2022-03-15 04:55:43', '2022-03-15 04:55:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_related`
--

CREATE TABLE `product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_related_attributes`
--

CREATE TABLE `product_related_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_related_attributes`
--

INSERT INTO `product_related_attributes` (`id`, `product_id`, `attribute_id`, `text`) VALUES
(77, 3, 2, 'SM-F127GZGGINR'),
(78, 3, 3, 'Galaxy F12'),
(79, 3, 4, 'Sea Green'),
(80, 3, 5, 'Smartphones'),
(81, 3, 6, 'Dual Sim'),
(82, 3, 7, 'Yes'),
(83, 3, 8, '16.55 cm (6.515 inch)'),
(84, 3, 9, '1600 x 720 Pixels'),
(85, 3, 11, 'ARM Mali G52'),
(86, 3, 12, 'HD+ Display'),
(87, 3, 13, '16M'),
(88, 3, 14, 'Android 11'),
(89, 3, 20, 'Exynos 850'),
(90, 3, 21, 'Octa Core'),
(91, 3, 15, '64GB'),
(92, 3, 16, '4GB'),
(93, 3, 17, '128GB'),
(94, 3, 1, 'Handset, Data Cable and Travel Adaptor, Ejection Pin, Manual');

-- --------------------------------------------------------

--
-- Table structure for table `product_special`
--

CREATE TABLE `product_special` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `product_id`, `customer_id`, `author`, `text`, `rating`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 3, 'admin', 'Gpod', 4.5, 1, '2022-03-17 17:29:20', NULL, NULL),
(2, 22, 3, 'admin', 'Oood', 3.5, 1, '2022-03-17 17:26:57', NULL, NULL),
(3, 4, 3, 'admin', 'Very good', 4.5, 1, '2022-03-17 17:27:21', NULL, NULL),
(4, 26, 3, 'admin', 'Good', 4.5, 1, '2022-03-17 17:27:32', NULL, NULL),
(5, 24, 3, 'admin', 'Poor', 2.5, 1, '2022-03-17 17:27:46', NULL, NULL),
(6, 27, 3, 'admin', 'Good', 4.5, 1, '2022-03-17 17:27:57', NULL, NULL),
(7, 6, 3, 'admin', 'Good', 3.5, 1, '2022-03-17 17:28:05', NULL, NULL),
(8, 21, 3, 'admin', 'Excellent', 4.5, 1, '2022-03-17 17:28:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(9, 'Admin', 'web', '2021-07-15 01:27:06', '2021-07-15 01:27:06'),
(12, 'Demo User', 'web', '2022-03-14 13:26:23', '2022-03-14 13:26:23'),
(13, 'customer', 'web', '2022-06-08 18:12:19', '2022-06-08 18:12:19'),
(14, 'seller', 'web', '2022-06-08 18:12:40', '2022-06-08 18:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(15, 1),
(17, 1),
(19, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(3, 2),
(4, 2),
(5, 2),
(10, 2),
(15, 2),
(19, 2),
(75, 2),
(79, 2),
(5, 3),
(1, 6),
(6, 6),
(11, 6),
(15, 6),
(20, 6),
(25, 6),
(26, 6),
(27, 6),
(28, 6),
(2, 7),
(6, 7),
(10, 7),
(19, 7),
(26, 7),
(2, 8),
(6, 8),
(10, 8),
(19, 8),
(26, 8),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(5, 9),
(6, 9),
(7, 9),
(8, 9),
(9, 9),
(10, 9),
(11, 9),
(12, 9),
(15, 9),
(17, 9),
(19, 9),
(21, 9),
(22, 9),
(23, 9),
(24, 9),
(25, 9),
(26, 9),
(27, 9),
(28, 9),
(29, 9),
(30, 9),
(31, 9),
(32, 9),
(33, 9),
(34, 9),
(35, 9),
(36, 9),
(37, 9),
(38, 9),
(39, 9),
(40, 9),
(41, 9),
(42, 9),
(43, 9),
(44, 9),
(45, 9),
(46, 9),
(47, 9),
(48, 9),
(50, 9),
(51, 9),
(52, 9),
(53, 9),
(54, 9),
(55, 9),
(56, 9),
(57, 9),
(58, 9),
(59, 9),
(60, 9),
(61, 9),
(62, 9),
(63, 9),
(64, 9),
(65, 9),
(66, 9),
(67, 9),
(68, 9),
(69, 9),
(71, 9),
(72, 9),
(73, 9),
(74, 9),
(75, 9),
(76, 9),
(77, 9),
(78, 9),
(79, 9),
(80, 9),
(81, 9),
(82, 9),
(86, 9),
(87, 9),
(88, 9),
(89, 9),
(90, 9),
(91, 9),
(92, 9),
(93, 9),
(94, 9),
(95, 9),
(96, 9),
(97, 9),
(98, 9),
(21, 10),
(22, 10),
(23, 10),
(25, 10),
(26, 10),
(27, 10),
(42, 10),
(43, 10),
(44, 10),
(47, 10),
(48, 10),
(49, 10),
(3, 12),
(6, 12),
(7, 12),
(11, 12),
(15, 12),
(19, 12),
(23, 12),
(27, 12),
(32, 12),
(36, 12),
(40, 12),
(44, 12),
(46, 12),
(53, 12),
(57, 12),
(61, 12),
(65, 12),
(69, 12),
(73, 12),
(77, 12),
(81, 12),
(87, 12),
(90, 12),
(91, 12),
(94, 12),
(1, 14),
(2, 14),
(3, 14),
(4, 14),
(5, 14),
(6, 14),
(7, 14),
(8, 14),
(9, 14),
(10, 14),
(11, 14),
(12, 14),
(17, 14),
(19, 14),
(20, 14),
(21, 14),
(22, 14),
(23, 14),
(24, 14),
(25, 14),
(29, 14),
(30, 14),
(31, 14),
(32, 14),
(33, 14),
(34, 14),
(35, 14),
(36, 14),
(37, 14),
(38, 14),
(39, 14),
(40, 14),
(41, 14),
(42, 14),
(43, 14),
(44, 14),
(45, 14),
(47, 14),
(48, 14),
(50, 14),
(51, 14),
(52, 14),
(53, 14),
(54, 14),
(55, 14),
(56, 14),
(57, 14),
(58, 14),
(59, 14),
(60, 14),
(61, 14),
(62, 14),
(63, 14),
(64, 14),
(65, 14),
(66, 14),
(67, 14),
(68, 14),
(69, 14),
(71, 14),
(72, 14),
(73, 14),
(74, 14),
(75, 14),
(76, 14),
(77, 14),
(78, 14),
(79, 14),
(80, 14),
(81, 14),
(82, 14),
(87, 14),
(88, 14),
(89, 14),
(90, 14),
(91, 14),
(92, 14),
(93, 14),
(94, 14),
(95, 14),
(96, 14),
(97, 14),
(98, 14);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `user_id` bigint(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `balance` bigint(20) DEFAULT NULL,
  `power` bigint(20) DEFAULT '0',
  `profit` bigint(20) DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `user_id`, `firstname`, `lastname`, `email`, `store_name`, `telephone`, `balance`, `power`, `profit`, `password`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 631, 'A', 'B', 'univgalaxy1112@gmail.com', 'Store 2', '123', 100000, 1000, 32237, '$2y$10$CTjr6d4HiWhiH.9ln0sxgu7IFPKtYvyaV5j/7raz9c2t084LJZOW6', 1, NULL, '2022-06-08 20:07:14', '2022-08-10 21:05:03', NULL),
(4, NULL, 'anik', 'islam', '13@gmail.com', 'asd', '1230', 44376, 500, 50621, '$2y$10$DJAvjJF2HUYCiN5mWFlU7uvIQfHZtxUT.8GRu.RjAsPxQ.IgqJz6e', 1, NULL, '2022-06-17 00:47:03', '2022-08-10 22:28:02', NULL),
(5, NULL, 'safat', 'hossain', '14@gmail.com', 'test14', '1234123', 604, 972, 6640, '$2y$10$aJMOphyz9nf9/J2OMWsVZexbZkwVFM4GZu/L3PvoBFoL.EXaedPrq', 1, NULL, '2022-06-22 05:27:17', '2022-08-10 22:08:06', NULL),
(7, NULL, 'fahim', 'huq', '15@gmail.com', 'asd', '74645545', 1964, 764, 2144, '$2y$10$aJMOphyz9nf9/J2OMWsVZexbZkwVFM4GZu/L3PvoBFoL.EXaedPrq', 1, NULL, '2022-06-22 05:35:33', '2022-07-16 09:00:28', NULL),
(8, NULL, 'seller 2', 'Test', 'agorartc@gmail.com', 'Store 3', '123123123123', 512, 0, 0, '$2y$10$CTjr6d4HiWhiH.9ln0sxgu7IFPKtYvyaV5j/7raz9c2t084LJZOW6', 1, NULL, '2022-06-23 22:17:06', '2022-08-10 22:03:11', NULL),
(9, NULL, 'Thomas', 'grace', 'sani', 'sani store', '01818562886', 873047, 200, 13945, '$2y$10$PSPFBK4.457G2TZweBK92u3w/fpL6ccFxQfdDEHwLZkzB6BaOby.K', 1, NULL, '2022-06-25 22:42:56', '2022-08-10 22:57:13', NULL),
(10, NULL, 'aradhiya', 'islam', 'fija', 'Fija store', '110011', 30836, 61, 27753, '$2y$10$DJAvjJF2HUYCiN5mWFlU7uvIQfHZtxUT.8GRu.RjAsPxQ.IgqJz6e', 1, NULL, '2022-06-26 08:40:22', '2022-07-29 07:05:01', NULL),
(11, NULL, 'nails', '& colors', 'keya', 'nails & colors', '443355666', 866, 100, 3003, '$2y$10$DJAvjJF2HUYCiN5mWFlU7uvIQfHZtxUT.8GRu.RjAsPxQ.IgqJz6e', 1, NULL, '2022-06-28 15:17:00', '2022-07-18 23:46:59', NULL),
(12, NULL, 'Salman', 'khan', 'salman3', 'salman\'s store', '01314718112', 800, 0, 0, '$2y$10$J6/bHcHC5Amtkldu7G4uruijjsbDYxlxTYIMA5NRsiBoB6Tv.0QkW', 1, NULL, '2022-06-29 23:04:45', '2022-07-29 11:07:21', NULL),
(13, NULL, 'Farhad', 'Hossain', 'Farhad02', 'farhad\'s store', '01700584960', 24832, 200, 19327, '$2y$10$P2r158xuyfA1DhVDANzv9ehDhlCUnNVVRonziduhZ0WF3J.Ml6Axa', 1, NULL, '2022-06-29 23:07:36', '2022-08-01 23:08:08', NULL),
(14, NULL, 'Afroza', 'Hossain', 'afroza33', 'afroza\'s store', '01631796060', 51400, 300, 201619, '$2y$10$wWRrWg5nxyrtkBKPa2c87.KppSeGpfUAZxmeb34wpsBsPsDH/VTYa', 1, NULL, '2022-06-29 23:09:48', '2022-08-02 09:43:47', NULL),
(15, NULL, 'BM', 'arif', 'arif56', 'arif\'s store', '01772798760', 460, 0, 0, '$2y$10$eUmTJkws8dAdkl2HCTRu2O3lEWZEeqxHovPWBdqs8B0wHyspWEXpG', 1, NULL, '2022-06-29 23:11:54', '2022-07-29 01:17:39', NULL),
(16, NULL, 'Sagor', 'Munsi', 'Sagor12', 'sagor\'s store', '01610426282', 8361, 500, 67001, '$2y$10$0jKrHAqRYyrx3AjQAV.N5OeyOu3EYMRcd0YCbbY1.2kN/9dd4Vvjq', 1, NULL, '2022-06-29 23:14:23', '2022-08-03 02:44:20', NULL),
(17, NULL, 'Jahid', 'hasan', 'Jahid44', 'Jahid\'s store', '01408098045', 4644, 200, 0, '$2y$10$QcAryoR1uEQ4xTFt14d1FuPo22h7xku1TQmzv.WmwXFQ0pisNWKQW', 1, NULL, '2022-06-29 23:16:02', '2022-07-29 01:17:32', NULL),
(18, NULL, 'Imran', 'Kazi', 'imran66', 'Imran\'s store', '01642367388', 342, 200, 866, '$2y$10$LqJrZ2kBvzLOAi9P.IrGEOJFMF6i8jAYpf2hZQNMCc3/waU/b1z3.', 1, NULL, '2022-06-29 23:17:24', '2022-07-29 01:16:47', NULL),
(19, NULL, 'Dipu', 'miah', 'dipu34', 'Dipu\'s store', '01703213097', 288, 200, 90, '$2y$10$e.NS5dFbVbgccE44PVrKjOgmNvIKPPrSIufo9wU8jc43ZrLtwc0NW', 1, NULL, '2022-06-29 23:19:09', '2022-07-29 01:16:16', NULL),
(20, NULL, 'B.F', 'Prince', 'prince77', 'bf prince\'s store', '01757000174', 230242, 300, 186386, '$2y$10$Zaqp9OprWp7cY2GIEVRJ9O5uiWci9nMrsOKFm58LCcDNDKWJPxhDe', 1, NULL, '2022-06-29 23:20:50', '2022-08-02 20:33:12', NULL),
(21, NULL, 'Mahibur', 'Rahman', 'Mahibur77', 'Mahibur\'s store', '01719560357', 13378, 100, 52920, '$2y$10$nuuTIpSzexOk07jBDpn0O.dzU90Qu6jQsc3lX9yXOvI27nYcJ9vuO', 1, NULL, '2022-06-29 23:23:00', '2022-08-02 09:35:32', NULL),
(22, NULL, 'RUBEL', 'BEPARI', 'RUBEL17', 'rubel\'s store', '01905050589', 750, 0, 0, '$2y$10$ZiwGSv2HaRNDHJFrkl.YI.9uWdNcRrEjXAXdAC.CTPmtae0xyo8Se', 1, NULL, '2022-07-02 10:16:12', '2022-07-02 10:16:12', NULL),
(23, NULL, 'Sohel', 'molla', 'Sohel15', 'sohel\'s store', '01822254094', 2171, 200, 164294, '$2y$10$QPBCYv0nc95PkotyY5uLnOGy6lv8vxlgd741TrgDFcxauZclEmY7e', 1, NULL, '2022-07-02 10:17:26', '2022-08-11 01:02:42', NULL),
(24, NULL, 'RAJON', 'HAWLADER', 'RAJON1914', 'RAJON\'s store', '1713541313', 500, 0, 0, '$2y$10$o1SaFSJHDfKv5Pg.vhIVF.kRX1Igu4aTs0BwvClRIBLHnJv/dIcWO', 1, NULL, '2022-07-02 10:18:36', '2022-07-02 10:18:36', NULL),
(25, NULL, 'Nasir', 'Uddin', 'Nasir07', 'nasir\'s store', '01733110335', 45198, 300, 5774413, '$2y$10$ssRDmN6Be4xkO4OYJAoi2O.nTFPZQziDdFom3HKrj9fTNBN52HQj.', 1, NULL, '2022-07-02 10:20:02', '2022-08-10 11:23:10', NULL),
(26, NULL, 'Sojib', 'Mia', 'sojib1747', 'sojib\'s store', '01759776293', 4318, 200, 1810994, '$2y$10$rhjWXvNUCWW5AJPJwIRX7uoTOgOsR1/TrA46JCisHEWfYgLShw5A.', 1, NULL, '2022-07-02 10:21:27', '2022-08-10 21:21:17', NULL),
(27, NULL, 'Charlene', 'Mauck', 'Charlene1', 'charlene', '124152511112', 590, 100, 452, '$2y$10$wQcSCgI4VFQClKkjlvce6OC2jJn.RtLuHy8PThXn56DD3nvX7xyr2', 1, NULL, '2022-07-03 00:54:01', '2022-07-16 11:31:36', NULL),
(28, NULL, 'Robert J.', 'Overbay', 'Robert1', 'Robert store', '334343', 324, 200, 134, '$2y$10$G5RxJ1/tphgKNIzoCjBtGeGqTvU2ymzLta0z.8yn19kkHDZFqQAsK', 1, NULL, '2022-07-03 00:55:51', '2022-07-29 01:16:14', NULL),
(29, NULL, 'Julia', 'Bandy', 'Julia1', 'Julia store', '355551', 500, 0, 0, '$2y$10$Y.0ZZV0JroXgVHkjCYW7AubERmPIeH8yCqYiwMin6va/aVrx73rNG', 1, NULL, '2022-07-03 00:58:07', '2022-07-03 00:58:07', NULL),
(30, NULL, 'Ruth', 'Vaughn', 'Ruth1', 'Ruth', '4124124', 949, 100, 882, '$2y$10$2dF8CxxWJ6ro8SrKfObZrOh4bSFBTn2TWiI5unS4iHLF6wkOWXGtG', 1, NULL, '2022-07-03 01:00:05', '2022-07-16 13:33:21', NULL),
(31, NULL, 'Nathan', 'Tyler', 'nathan1', 'Nathan', '673433434', 1138, 100, 1173, '$2y$10$nTkUDl1OzqhN4NnpWpxwRuIE/Z/dICNYozyqh2NBf2unhNSdMYyhq', 1, NULL, '2022-07-03 01:01:32', '2022-07-29 01:17:36', NULL),
(32, NULL, 'Leah', 'Cuellar', 'Leah1', 'Leah', '23423511', 392, 100, 255, '$2y$10$e1GYFeMbZFVg9eAdezd5EefcQrmLcHA6pDCOcxCj/AmHdIUk.lnRS', 1, NULL, '2022-07-03 01:02:47', '2022-07-29 01:16:14', NULL),
(33, NULL, 'Sohel', 'Rana', 'Sohel56', 'Sohel\'s store', '01762082781', 228, 200, 90, '$2y$10$.i2PrItfzdUFXNh.NQQlFOOmDflzjLgMZJe5gj7x7cWnL1JsLPulm', 1, NULL, '2022-07-05 12:33:16', '2022-07-09 19:40:36', NULL),
(34, NULL, 'Nashir', 'khan', 'Nashir23', 'Nashir\'s store', '01611460401', 500, 0, 0, '$2y$10$7wHkVQHRIFWV0fLjoyJLAO3tM9HdIn55oGIz4vdkBIpzeA0Bai80W', 1, NULL, '2022-07-05 12:34:14', '2022-07-05 12:34:14', NULL),
(35, NULL, 'Sajib', 'Hasan', 'Sajib44', 'Sajib\'s store', '01402462874', 22971, 300, 15905, '$2y$10$tC6N3NCmDaFPuQoxo1sr0uZ8/.cYOhz7crVDZ/tEJZPZ0yOYJfLtK', 1, NULL, '2022-07-05 12:35:41', '2022-07-31 08:40:44', NULL),
(36, NULL, 'Beauty', 'Babul', 'Beauty12', 'Beauty\'s store', '01720081484', 11066, 500, 35752, '$2y$10$bTbN8PLYeLD.axDELssiE.hmOVlyiHbUAtrhh.mfu3wYDhrGUz2Cm', 1, NULL, '2022-07-05 12:37:03', '2022-08-04 17:49:03', NULL),
(37, NULL, 'Sohel', 'mia', 'Sohel43', 'Sohel\'s store', '01719151087', 21505, 200, 2783689, '$2y$10$1aVT1ea43SofomBCtrRXMuL01Tqd.glpvewvhxiHfu0/FvZIdSJA.', 1, NULL, '2022-07-05 12:38:10', '2022-08-04 12:13:06', NULL),
(38, NULL, 'Sojib', 'day', 'Sojib88', 'Sojib\'s store', '1978487101', 121, 400, 240, '$2y$10$9pvNVcik0jPob7ZenxkZ/.ZTJ3INEjsSi5zXRn1eZjb3JMeXCfm3a', 1, NULL, '2022-07-05 12:39:14', '2022-07-09 11:29:13', NULL),
(39, NULL, 'MD Ruhul', 'Amin', 'Ruhul76', 'Ruhul\'s store', '01914654111', 300, 200, 59733, '$2y$10$2WKuRdAwwt7ikOma8R8PDeSAzlm7Hi1muUGllA3LcyHret8iOi402', 1, NULL, '2022-07-07 07:40:20', '2022-08-06 11:56:03', NULL),
(40, NULL, 'Mehedi', 'Hasan', 'Mehedi76', 'Mehedi\'s store', '01724816786', 500, 0, 0, '$2y$10$3y6Qe8T9lQXFVm55soU3y.SfyZFiTcV1tsIiRjnT7DnDi/9qCRyOe', 1, NULL, '2022-07-07 07:41:39', '2022-07-07 07:41:39', NULL),
(41, NULL, 'Jannatul', 'Ferdous', 'Jannatul23', 'Jannatul\'s store', '01878532751', 102230, 300, 5866, '$2y$10$mnLhLSQcgS7MkyHULBIiS.zRF4D7JChMd2UQxNszCMRX7yP2JahfO', 1, NULL, '2022-07-07 07:43:02', '2022-07-29 01:17:39', NULL),
(42, NULL, 'Saddam', 'munshi', 'Saddam47', 'Saddam\'s store', '01321910323', 11668, 400, 61564, '$2y$10$m1k6mR18LNRjUIm6SU0k7O4c46NkXVzttU6jpNQVgX4x0ZoOJoxrO', 1, NULL, '2022-07-08 14:14:23', '2022-08-11 01:03:26', NULL),
(43, NULL, 'Sujon', 'Bepari', 'Sujon47', 'Sujon\'s store', '01720403695', 71822, 100, 36762, '$2y$10$lyxJRqCQsPHPALmDhnGSEu8xPPrewQNNWbVKws2uGonpI4SC/t35a', 1, NULL, '2022-07-08 14:15:54', '2022-08-10 13:14:55', NULL),
(44, NULL, 'Rohan', 'Khoka', 'Rohan74', 'Rohan', '01749956139', 160449, 600, 368, '$2y$10$SrnxTqgRgRK.dWBkpLyTPO1B4Udk0nSgyVy3z3QnKnyyjs7FGFGCO', 1, NULL, '2022-07-09 07:52:16', '2022-07-29 01:17:31', NULL),
(45, NULL, 'MD Jamil', 'Hossain', 'Jamil77', 'Jamil\'s store', '01713929872', 1759, 300, 51151, '$2y$10$zA6mZNsh.Za6rRWaXRV2Kub0hHFVan4O1u8bEPQFJBWwKgFVzd.Uu', 1, NULL, '2022-07-09 07:53:36', '2022-08-10 21:38:47', NULL),
(47, NULL, 'MD Jahid', 'Hasan', 'Jahid36', 'Jahid\'s store', '01750335773', 10643, 100, 43547, '$2y$10$epmTXLL.Yevh33Kl/XdfGuAPNzdb6NKVLlN1X.CKP87U7fYMlUXtS', 1, NULL, '2022-07-09 07:55:22', '2022-07-30 09:15:28', NULL),
(48, NULL, 'Christopher', 'Calvert', 'Christopher22', 'Christopher\'s store', '662353412114', 500, 0, 0, '$2y$10$b.ZrB2HxpEGP9H38.FmjweZeycG6dclStBkNxJTs9WCCdIFW6.GZa', 1, NULL, '2022-07-09 08:02:29', '2022-07-09 08:02:29', NULL),
(49, NULL, 'Charmaine Rhyne', 'Rhyne', 'Charmaine11', 'Charmaine\'s store', '4441124124124', 500, 0, 0, '$2y$10$ttNfUJpT7/9OAyMnwHWayeMudiP..VNV7Rh.l6k1Vm0NVhQU.ASru', 1, NULL, '2022-07-09 08:03:49', '2022-07-09 08:03:49', NULL),
(50, NULL, 'Janice', 'Lounsbury', 'Janice11', 'Janice', '4634634634634', 500, 0, 0, '$2y$10$ttNfUJpT7/9OAyMnwHWayeMudiP..VNV7Rh.l6k1Vm0NVhQU.ASru', 1, NULL, '2022-07-09 08:04:51', '2022-07-09 08:04:51', NULL),
(51, NULL, 'Carolyn', 'Eakin', 'Carolyn47', 'Carolyn', '12412412', 500, 0, 0, '$2y$10$u5KlyyL7m8LYrcSb2cScsea76rjRp2TwIR3K.brv21gVz6uJc5t3S', 1, NULL, '2022-07-09 08:09:32', '2022-07-09 08:09:32', NULL),
(52, NULL, 'Rubel', 'Skder', 'Rubel12', 'Rubel', '01712470554', 330, 100, 0, '$2y$10$y8oU2X0JF5U.PlW.u7PD8.vfZVb6fppbo9ej1yu25ByMeEoZrGIV.', 1, NULL, '2022-07-10 01:44:06', '2022-07-29 01:17:27', NULL),
(53, NULL, 'Md Minhajul', 'Islam', 'Minhajul44', 'Minhajul', '01683372237', 607, 200, 3296, '$2y$10$QRwWBTFJUF/sLA37OZQ1PuOO8Ei4Ql9lOXxvWwiV2aMOqj9h9BnFS', 1, NULL, '2022-07-10 01:45:51', '2022-08-02 15:18:05', NULL),
(54, NULL, 'Md Kuwser', 'Ahmed', 'Kuwser47', 'Kuwser', '01650290290', 4488, 200, 1949, '$2y$10$sIZHdJ3ELs2I/urPrLEyd.YoQkaVsZyRdx/8UZS7rHoGbGJYYEhdO', 1, NULL, '2022-07-10 01:47:56', '2022-08-01 15:43:10', NULL),
(55, NULL, 'R.R', 'Business', 'rr47', 'rr store', '01797547388', 43795, 500, 42643, '$2y$10$quqKT95w/ZrVPs0oTHf5re00JeR1iq3Mx.RoYpPN9r34w6IvwHlLC', 1, NULL, '2022-07-12 09:57:07', '2022-08-11 01:03:26', NULL),
(56, NULL, 'Himel', 'Das', 'Himel43', 'himel\'s store', '01936087052', 4861, 100, 0, '$2y$10$Q6bCDtKTgxuG2nxzmb/FEumUkHG/W3wvzcal5lNKHEXYngpHvZwwy', 1, NULL, '2022-07-12 09:58:17', '2022-07-29 01:17:34', NULL),
(57, NULL, 'Rana', 'Rari', 'Rana77', 'rana\'s store', '1893419341', 378, 100, 0, '$2y$10$zIMORSokY7QU81Nd8pl9r.O6RyaAbkIaWaa3seKXgICl2.EvQthS.', 1, NULL, '2022-07-16 02:36:25', '2022-07-30 22:50:52', NULL),
(58, NULL, 'Abdul', 'Hakim', 'Abdul99', 'Abdul\'s store', '01309385249', 315, 0, 0, '$2y$10$iTeXoYakcgCATn1ojQwrhOoTnZYLGx5aT2hJ4EBOpDkV0U9SYY2kO', 1, NULL, '2022-07-16 02:38:44', '2022-07-29 01:16:40', NULL),
(59, NULL, 'M.S.', 'Invitore', 'ms47', 'ms\' store', '01778207302', 500, 0, 0, '$2y$10$fcp.3e/ZBkuAadpFhfY1ROwvr0nwMbPaYaLlEYaoa/.JWfAaoiyrK', 1, NULL, '2022-07-16 16:56:56', '2022-07-16 16:56:56', NULL),
(60, NULL, 'Sihab', 'hasan', 'sihab47', 'Sihab\'s store', '01614707750', 35, 300, 0, '$2y$10$00MZ3iQvu7.bUmFRdsCawuMqXDbKve1rU21ORGabXqyFbTrKJn3wq', 1, NULL, '2022-07-19 01:26:12', '2022-07-20 00:01:22', NULL),
(61, NULL, 'Ali', 'Mia', 'Ali77', 'Ali\'s store', '01733102926', 3543, 200, 0, '$2y$10$P5x9FAPTa4FFWJgW./P8puxfs8Nr34ntREO7D7pmZa/M0ed2OXEHK', 1, NULL, '2022-07-20 12:58:41', '2022-07-29 01:17:39', NULL),
(62, NULL, 'coinnow', 'official', 'coinnow', 'coinnow', '112233', 0, 0, 0, '$2y$10$hn9z2sRHUluuUso9Mku43.UQYtbTCoFNciED9L6wSLql.eKP6dCBG', 1, NULL, '2022-07-29 03:11:23', '2022-07-29 03:17:47', NULL),
(63, NULL, 'Md.Sojib', 'Hossain', 'Sojib47', 'md sojib\'s store', '1791017259', NULL, 0, 0, '$2y$10$NWnRv33ccThxZFI.Xe.vq.WOgbpWquX1ZrIB6JClqKfrizWQFn3H6', 1, NULL, '2022-07-29 10:45:53', '2022-07-29 10:45:53', NULL),
(64, NULL, 'Liza', 'islam', 'liza77', 'liza\'s store', '01312848779', 9756, 200, 5564, '$2y$10$PhvvHp02wh4veXskhlU4fOaLy5zfba3Wcbh1v85hJOsr/kG86v7IO', 1, NULL, '2022-07-29 10:47:27', '2022-08-11 01:00:15', NULL),
(65, NULL, 'Imran', 'khalasi', 'Imran78', 'Imran\'s store', '01723225747', NULL, 0, 0, '$2y$10$mHk/HTdx4QIyG4gjbEp9Ee.JafOYsQxUm8rxpz62lCSLt48rHJ93i', 1, NULL, '2022-07-29 10:48:23', '2022-07-29 10:48:23', NULL),
(66, NULL, 'MD Kayum', 'Sardar', 'Kayum33', 'kayum\'s store', '01782612599', NULL, 0, 0, '$2y$10$dkHzfgURzCSfJH8zwAqDP.eTCVjKBoodbjbD27jLsHjXZRw3dgLjq', 1, NULL, '2022-07-29 10:49:38', '2022-07-29 10:49:48', NULL),
(67, NULL, 'MD Sahalom', 'islam', 'Sahalom47', 'sahalom\'s store', '01788812439', NULL, 0, 0, '$2y$10$fWsNALBLEEnWqwjvB8YrXulzVv.rdLJVDzOwI7q5yLZB7o.WBBQn.', 1, NULL, '2022-07-29 10:51:05', '2022-07-29 10:51:05', NULL),
(68, NULL, 'Alex', 'shakil', 'Alex77', 'alex\'s store', '01999125282', 17756, 200, 458, '$2y$10$BR0amtJBfKLkeWZ18Y1F4.l1thWQHF1Rsn2KXntPkCEXBxAjRy8Gy', 1, NULL, '2022-08-01 03:03:24', '2022-08-05 03:05:02', NULL),
(69, NULL, 'Jafor', 'Sikder', 'Jafor12', 'jafor\'s store', '01734909401', 8306, 200, 483066, '$2y$10$ts0wHjl.scaKWJuCLJR/guHJGV1cxt3iSEsR7UB0GEPHRXTFByD1O', 1, NULL, '2022-08-02 13:18:22', '2022-08-10 23:01:54', NULL),
(70, NULL, 'Simon', 'mia', 'Simon12', 'simon', '01721859993', 6450, 200, 2578330, '$2y$10$n.TGKAith3fhjNpCxeaKIO4c/vpI4A8lX/Oz1qPOl6YlG5133xlVe', 1, NULL, '2022-08-02 13:19:26', '2022-08-08 11:40:33', NULL),
(73, NULL, 'univ', 'galaxy', 'univgalaxy1112', 'store', '123456123', 3, 0, 0, '$2y$10$GQ3fHoBZBN0FWyu3ZeJwE.xwfCboqSxG3m..T8Zc3xjlK8uohPP66', 1, NULL, '2022-08-10 02:07:37', '2022-08-10 21:00:12', NULL),
(74, NULL, 'Sonia', 'Islam', 'Soniaislam', 'store', '987654321', NULL, 0, 0, '$2y$10$o2o86iDAVmoWUkmVLO20GO/ZvumSTNf/FoIYUIZNn9qEGf1VJePMu', 1, NULL, '2022-08-10 03:35:41', '2022-08-10 03:35:41', NULL),
(75, NULL, 'Shsh', 'Hggv', 'Fija3', 'store', '123123123', NULL, 0, 0, '$2y$10$5vRKjfZMU6qG6gp5Pqm5JOzrPN68cUEFKv1OqRQHYeOTLzf3FV3da', 1, NULL, '2022-08-10 22:44:02', '2022-08-10 22:44:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seo_url`
--

CREATE TABLE `seo_url` (
  `seo_url_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `shipping_charge` decimal(15,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `name`, `shipping_charge`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Free  (10 - 15 Days)', 0.00, 1, '2022-03-16 04:29:45', '2022-03-16 04:29:45', NULL),
(2, 'Fast Shipping', 10.00, 1, '2022-03-16 04:30:09', '2022-03-16 04:30:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `special`
--

CREATE TABLE `special` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `special`
--

INSERT INTO `special` (`id`, `product_id`, `seller_id`, `quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(13, 51, 4, 0, '2022-06-24 13:43:55', '2022-07-07 16:22:12', NULL),
(14, 77, 10, 2, '2022-06-26 08:41:30', '2022-06-26 08:41:36', NULL),
(15, 77, 9, 2, '2022-06-26 11:09:19', '2022-06-26 11:09:21', NULL),
(16, 77, 4, 4, '2022-06-28 00:33:42', '2022-07-07 16:22:57', NULL),
(17, 77, 7, 1, '2022-06-28 15:13:29', '2022-06-28 15:13:29', NULL),
(18, 77, 11, 1, '2022-06-28 15:19:01', '2022-06-28 15:19:01', NULL),
(19, 77, 16, 5, '2022-06-30 15:22:43', '2022-07-08 23:50:44', NULL),
(20, 77, 17, 2, '2022-06-30 17:42:20', '2022-06-30 17:42:25', NULL),
(21, 77, 13, 4, '2022-07-01 23:26:35', '2022-07-08 16:12:03', NULL),
(22, 77, 18, 3, '2022-07-02 16:58:46', '2022-07-08 00:08:59', NULL),
(23, 77, 25, 3, '2022-07-03 12:05:37', '2022-07-09 12:30:10', NULL),
(24, 77, 38, 4, '2022-07-05 13:07:12', '2022-07-09 11:29:13', NULL),
(25, 77, 37, 2, '2022-07-05 13:09:16', '2022-07-05 13:09:18', NULL),
(26, 77, 36, 5, '2022-07-05 21:22:39', '2022-07-12 17:37:48', NULL),
(27, 77, 1, 5, '2022-07-05 23:11:10', '2022-07-12 09:13:23', NULL),
(28, 77, 20, 4, '2022-07-06 14:42:32', '2022-07-08 13:07:50', NULL),
(29, 77, 14, 4, '2022-07-07 10:22:15', '2022-07-08 00:38:05', NULL),
(30, 77, 35, 3, '2022-07-08 02:04:18', '2022-07-16 19:52:27', NULL),
(31, 77, 23, 2, '2022-07-08 02:43:56', '2022-07-08 02:43:57', NULL),
(32, 77, 41, 3, '2022-07-08 13:11:53', '2022-07-09 18:22:46', NULL),
(33, 77, 43, 1, '2022-07-08 20:25:41', '2022-07-08 20:25:41', NULL),
(34, 77, 27, 1, '2022-07-09 02:05:06', '2022-07-09 02:05:06', NULL),
(35, 77, 28, 2, '2022-07-09 02:14:48', '2022-07-09 02:14:52', NULL),
(36, 77, 30, 1, '2022-07-09 02:21:54', '2022-07-09 02:21:54', NULL),
(37, 77, 32, 1, '2022-07-09 02:28:08', '2022-07-09 02:28:08', NULL),
(38, 77, 31, 1, '2022-07-09 02:33:02', '2022-07-09 02:33:02', NULL),
(39, 77, 19, 2, '2022-07-09 10:50:52', '2022-07-09 10:50:53', NULL),
(40, 77, 47, 1, '2022-07-09 10:55:39', '2022-07-09 10:55:39', NULL),
(41, 77, 45, 3, '2022-07-09 11:37:08', '2022-07-09 16:36:30', NULL),
(42, 77, 33, 2, '2022-07-09 19:25:02', '2022-07-09 19:25:03', NULL),
(43, 77, 26, 2, '2022-07-09 21:16:14', '2022-07-29 19:46:10', NULL),
(44, 77, 44, 6, '2022-07-12 02:27:54', '2022-07-17 13:27:16', NULL),
(45, 77, 53, 2, '2022-07-12 16:51:11', '2022-07-12 16:51:14', NULL),
(46, 77, 54, 2, '2022-07-12 19:49:43', '2022-07-12 19:49:49', NULL),
(47, 77, 55, 5, '2022-07-13 01:18:35', '2022-07-29 04:00:05', NULL),
(48, 77, 56, 1, '2022-07-15 16:14:56', '2022-07-15 16:14:56', NULL),
(49, 77, 21, 1, '2022-07-16 13:53:54', '2022-07-16 13:53:54', NULL),
(50, 77, 52, 1, '2022-07-16 21:16:58', '2022-07-16 21:16:58', NULL),
(51, 77, 42, 4, '2022-07-16 21:33:16', '2022-07-22 19:25:41', NULL),
(52, 77, 60, 3, '2022-07-19 19:22:50', '2022-07-19 19:23:32', NULL),
(53, 77, 39, 2, '2022-07-19 21:45:16', '2022-07-19 21:45:18', NULL),
(54, 77, 61, 2, '2022-07-21 12:23:47', '2022-07-21 12:24:05', NULL),
(55, 77, 57, 1, '2022-07-30 22:50:52', '2022-07-30 22:50:52', NULL),
(56, 77, 64, 2, '2022-08-02 20:37:45', '2022-08-02 20:37:53', NULL),
(57, 77, 69, 2, '2022-08-03 16:39:55', '2022-08-03 16:39:57', NULL),
(58, 77, 70, 2, '2022-08-03 21:17:38', '2022-08-03 21:18:41', NULL),
(59, 77, 68, 2, '2022-08-04 17:19:28', '2022-08-04 17:19:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_status`
--

CREATE TABLE `stock_status` (
  `id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_status`
--

INSERT INTO `stock_status` (`id`, `language_id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Pending', 1, '2021-08-01 02:17:33', '2021-08-01 02:17:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_product_option`
--

CREATE TABLE `store_product_option` (
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `price` decimal(15,2) DEFAULT '0.00',
  `color_code` varchar(25) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_product_option`
--

INSERT INTO `store_product_option` (`product_option_id`, `product_id`, `option_id`, `label`, `price`, `color_code`, `required`) VALUES
(1, 1, 2, '6', NULL, '', NULL),
(2, 1, 2, '7', 50.00, '', NULL),
(3, 1, 2, '8', 100.00, '', NULL),
(4, 2, 2, '5', NULL, '', NULL),
(5, 2, 2, '6', NULL, '', NULL),
(6, 2, 2, '7', NULL, '', NULL),
(24, 3, 2, '256GB', 100.00, '', NULL),
(23, 3, 2, '128GB', 50.00, '', NULL),
(22, 3, 2, '64GB', NULL, '', NULL),
(32, 24, 1, 'White', NULL, '#ffffff', NULL),
(31, 24, 1, 'Black', 10.00, '#000000', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tax_class`
--

CREATE TABLE `tax_class` (
  `tax_class_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rate`
--

CREATE TABLE `tax_rate` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `type` tinyint(1) NOT NULL COMMENT '1=percentage,2=fixed',
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tax_rate`
--

INSERT INTO `tax_rate` (`id`, `name`, `rate`, `type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GST 18%', 18.0000, 1, 1, '2021-08-01 02:16:12', '2021-08-01 02:16:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `opening_amount` int(11) NOT NULL DEFAULT '0',
  `current_amount` int(11) NOT NULL DEFAULT '0',
  `opening_date` date DEFAULT NULL,
  `daily_amount` int(11) DEFAULT NULL,
  `amount_type` varchar(20) DEFAULT NULL,
  `last_sms_date` date DEFAULT NULL,
  `village_name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `loan_only` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `mobile`, `is_admin`, `opening_amount`, `current_amount`, `opening_date`, `daily_amount`, `amount_type`, `last_sms_date`, `village_name`, `status`, `loan_only`, `created_at`, `updated_at`, `deleted_at`) VALUES
(627, 'Super Admin', 'superadmin@mail.com', NULL, '$2y$10$.F73AKKOVkrUhqNk.sdhfOTA92iw6qgkwWF9I2RIM9iVT1gvG06YS', 'BSxh0uXvqvcUTdFCiqSF9daYgOidAPFtYMLj2g9sCYGfAh0Jkwp6Z0ZuhnOM', '9898252599', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2022-06-17 00:04:52', NULL),
(631, 'Seller', 'seller@mail.com', NULL, '$2y$10$IKY2RBu.TPi6qWO7aFWmXO5b0KKA52U7DV1mBhsWupvDll30Lho2u', NULL, '1234567890', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, '2022-06-10 08:14:53', '2022-06-10 08:14:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weight_class`
--

CREATE TABLE `weight_class` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL,
  `value` decimal(15,8) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weight_class`
--

INSERT INTO `weight_class` (`id`, `name`, `unit`, `value`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'asd', '34', 34.00000000, 1, '2021-08-01 02:17:16', '2021-08-01 02:17:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `customer_id`, `product_id`) VALUES
(1, 4, 27),
(2, 3, 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_image`
--
ALTER TABLE `banner_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_id` (`customer_id`,`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `category_description`
--
ALTER TABLE `category_description`
  ADD KEY `name` (`name`);

--
-- Indexes for table `cost_price_table`
--
ALTER TABLE `cost_price_table`
  ADD PRIMARY KEY (`cost_price_table_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_history`
--
ALTER TABLE `coupon_history`
  ADD PRIMARY KEY (`coupon_history_id`);

--
-- Indexes for table `cron`
--
ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer_transaction`
--
ALTER TABLE `customer_transaction`
  ADD PRIMARY KEY (`customer_transaction_id`);

--
-- Indexes for table `customer_wishlist`
--
ALTER TABLE `customer_wishlist`
  ADD PRIMARY KEY (`customer_id`,`product_id`);

--
-- Indexes for table `dod`
--
ALTER TABLE `dod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `length_class`
--
ALTER TABLE `length_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`) USING BTREE,
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `deleted_at` (`deleted_at`),
  ADD KEY `total` (`total`);

--
-- Indexes for table `order_additional_field`
--
ALTER TABLE `order_additional_field`
  ADD PRIMARY KEY (`order_additional_field_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_shipment`
--
ALTER TABLE `order_shipment`
  ADD PRIMARY KEY (`order_shipment_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_total`
--
ALTER TABLE `order_total`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute_groups`
--
ALTER TABLE `product_attribute_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_description`
--
ALTER TABLE `product_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `product_discount`
--
ALTER TABLE `product_discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_filter`
--
ALTER TABLE `product_filter`
  ADD PRIMARY KEY (`product_id`,`filter_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_related`
--
ALTER TABLE `product_related`
  ADD PRIMARY KEY (`product_id`,`related_id`);

--
-- Indexes for table `product_related_attributes`
--
ALTER TABLE `product_related_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_special`
--
ALTER TABLE `product_special`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sellers_email_unique` (`email`),
  ADD UNIQUE KEY `sellers_telephone_unique` (`telephone`);

--
-- Indexes for table `seo_url`
--
ALTER TABLE `seo_url`
  ADD PRIMARY KEY (`seo_url_id`),
  ADD KEY `query` (`query`),
  ADD KEY `keyword` (`keyword`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special`
--
ALTER TABLE `special`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_status`
--
ALTER TABLE `stock_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_product_option`
--
ALTER TABLE `store_product_option`
  ADD PRIMARY KEY (`product_option_id`);

--
-- Indexes for table `tax_class`
--
ALTER TABLE `tax_class`
  ADD PRIMARY KEY (`tax_class_id`);

--
-- Indexes for table `tax_rate`
--
ALTER TABLE `tax_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `weight_class`
--
ALTER TABLE `weight_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CUSTOMER` (`customer_id`),
  ADD KEY `PRODUCTS` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner_image`
--
ALTER TABLE `banner_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cost_price_table`
--
ALTER TABLE `cost_price_table`
  MODIFY `cost_price_table_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_history`
--
ALTER TABLE `coupon_history`
  MODIFY `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron`
--
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3837;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_transaction`
--
ALTER TABLE `customer_transaction`
  MODIFY `customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dod`
--
ALTER TABLE `dod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `length_class`
--
ALTER TABLE `length_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35574;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_additional_field`
--
ALTER TABLE `order_additional_field`
  MODIFY `order_additional_field_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_shipment`
--
ALTER TABLE `order_shipment`
  MODIFY `order_shipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_total`
--
ALTER TABLE `order_total`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10439;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_attribute_groups`
--
ALTER TABLE `product_attribute_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_description`
--
ALTER TABLE `product_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10433;

--
-- AUTO_INCREMENT for table `product_discount`
--
ALTER TABLE `product_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705;

--
-- AUTO_INCREMENT for table `product_related_attributes`
--
ALTER TABLE `product_related_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `product_special`
--
ALTER TABLE `product_special`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `seo_url`
--
ALTER TABLE `seo_url`
  MODIFY `seo_url_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `special`
--
ALTER TABLE `special`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `stock_status`
--
ALTER TABLE `stock_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_product_option`
--
ALTER TABLE `store_product_option`
  MODIFY `product_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tax_class`
--
ALTER TABLE `tax_class`
  MODIFY `tax_class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rate`
--
ALTER TABLE `tax_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=632;

--
-- AUTO_INCREMENT for table `weight_class`
--
ALTER TABLE `weight_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
