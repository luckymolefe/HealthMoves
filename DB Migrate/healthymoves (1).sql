-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2019 at 06:45 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `healthymoves`
--
CREATE DATABASE IF NOT EXISTS `healthymoves`;
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(155) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `status`, `created`) VALUES
(1, 'admin@healthymoves.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2018-12-19 20:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(55) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created`) VALUES
(1, 'Nutritions', '2018-12-20 00:11:18'),
(2, 'Vitamins', '2018-12-20 00:11:26'),
(3, 'Supplements', '2018-12-20 00:11:33'),
(4, 'All Supplements', '2018-12-20 00:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `cell_no` varchar(15) NOT NULL,
  `subject` varchar(55) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `cell_no`, `subject`, `message`, `status`, `created`, `modified`) VALUES
(1, 'Lucky Molefe', 'luckmolf@company.com', '0821234567', 'Test', 'Hello world', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'John Doe', 'johndoe@email.com', '0113426934', 'Testing', 'Hello World', 1, '2019-01-10 19:08:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(155) NOT NULL,
  `address` varchar(155) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `firstname`, `lastname`, `phone`, `email`, `password`, `address`, `created`) VALUES
(1, 'Lucky', 'Molefe', '0821234567', 'luckmolf@company.com', '771669382ce0300b963293ddabd9aef9e8e36c6b', '123 Soshanguve, Pretoria, 0192', '2018-12-27 21:59:03'),
(2, 'John', 'Doe', '0834452225', 'johndoe@company.com', '6c074fa94c98638dfe3e3b74240573eb128b3d16', '2288 Street, Pretoria, 0192', '2019-01-10 18:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `product_id` int(11) NOT NULL,
  `image_url` varchar(155) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`product_id`, `image_url`, `created`, `modified`) VALUES
(1, 'IMG_20181220_2146.jpg', '2018-12-20 01:55:53', '0000-00-00 00:00:00'),
(2, 'IMG_20181220_31971.jpg', '2018-12-20 02:20:11', '0000-00-00 00:00:00'),
(3, 'IMG_20181220_1760.jpg', '2018-12-20 02:21:23', '0000-00-00 00:00:00'),
(4, 'IMG_20181220_23961.jpg', '2018-12-20 02:21:54', '0000-00-00 00:00:00'),
(5, 'IMG_20181220_10334.jpg', '2018-12-20 02:25:49', '0000-00-00 00:00:00'),
(6, 'IMG_20181220_1087.jpg', '2018-12-20 02:26:41', '0000-00-00 00:00:00'),
(7, 'IMG_20181220_12556.jpg', '2018-12-20 02:28:14', '0000-00-00 00:00:00'),
(8, 'IMG_20181220_14933.jpg', '2018-12-20 02:28:58', '0000-00-00 00:00:00'),
(9, 'IMG_20190117_9098.jpg', '2019-01-18 00:30:23', NULL),
(10, 'IMG_20190117_24059.jpg', '2019-01-18 00:34:24', NULL),
(11, 'IMG_20190124_5437.jpg', '2019-01-24 01:19:11', NULL),
(12, 'IMG_20190124_20786.jpg', '2019-01-24 01:42:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_quantity` tinyint(2) NOT NULL,
  `order_total` float(6,2) NOT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT '0',
  `payment_type` varchar(55) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`customer_id`, `order_id`, `order_quantity`, `order_total`, `order_status`, `payment_type`, `created`, `modified`) VALUES
(1, 1056, 1, 418.60, 0, 'eft', '2019-01-08 02:35:44', NULL),
(1, 15998, 1, 241.50, 1, 'bankdeposit', '2019-01-07 18:41:43', '2019-01-10 13:27:56'),
(1, 26729, 4, 540.50, 1, 'creditcard', '2019-01-08 14:29:48', '2019-01-08 14:29:48'),
(2, 37209, 3, 368.00, 1, 'bankdeposit', '2019-01-10 18:57:57', '2019-01-10 19:02:29'),
(1, 41524, 1, 241.50, 1, 'eft', '2019-01-08 02:30:27', '2019-01-10 13:21:23'),
(1, 42051, 1, 241.50, 0, 'eft', '2019-01-08 02:33:13', NULL),
(2, 50517, 2, 545.10, 1, 'creditcard', '2019-01-10 19:07:32', '2019-01-10 19:07:33'),
(1, 64236, 3, 368.00, 1, 'creditcard', '2019-01-07 18:36:32', '2019-01-07 18:36:32'),
(1, 72194, 3, 253.00, 0, 'eft', '2019-01-08 02:24:05', NULL),
(1, 78666, 2, 189.75, 1, 'creditcard', '2018-12-28 04:00:32', '2018-12-30 15:46:27'),
(1, 85695, 3, 485.88, 0, 'bankdeposit', '2019-01-08 02:26:37', NULL),
(1, 89639, 1, 241.50, 0, 'eft', '2019-01-08 02:31:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `card_type` varchar(55) NOT NULL,
  `exp_month` tinyint(2) NOT NULL,
  `exp_year` tinyint(4) NOT NULL,
  `card_value` varchar(4) NOT NULL,
  `holder_name` varchar(60) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `card_number`, `card_type`, `exp_month`, `exp_year`, `card_value`, `holder_name`, `created`, `modified`) VALUES
(2, '0113-4293-9203-2902', 'visa', 10, 20, '038', 'J. Doe', '2019-01-10 19:06:45', '0000-00-00 00:00:00'),
(2, '1234-5678-6677-4231', 'mastercard', 5, 19, '123', 'J. Doe', '2019-01-10 18:59:31', '2019-01-10 18:59:44'),
(1, '5010-1112-5955-8494', 'visa', 7, 19, '235', 'L Molefe', '2018-12-29 00:02:44', '2019-01-08 00:44:32'),
(1, '9273-2003-3495-3010', 'mastercard', 3, 19, '045', 'Lucky Molefe', '2018-12-27 21:34:36', '2019-01-03 01:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `price` float(5,2) NOT NULL,
  `description` tinytext,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `description`, `category_id`, `created`, `modified`) VALUES
(1, 'Life Gain', 125.00, NULL, 1, '2018-12-20 01:55:53', '2019-01-10 19:01:22'),
(2, 'Gummy Vites', 122.50, NULL, 2, '2018-12-20 02:20:11', '2018-12-20 02:20:37'),
(3, 'Lavax', 210.00, NULL, 3, '2018-12-20 02:21:23', '0000-00-00 00:00:00'),
(4, 'Herbex Fat Burn', 85.00, NULL, 4, '2018-12-20 02:21:54', '0000-00-00 00:00:00'),
(5, 'Life Gain Junior', 110.00, NULL, 1, '2018-12-20 02:25:49', '0000-00-00 00:00:00'),
(6, 'Herbex Weightloss', 55.00, NULL, 4, '2018-12-20 02:26:41', '0000-00-00 00:00:00'),
(7, 'Green Powder', 364.00, NULL, 3, '2018-12-20 02:28:13', '0000-00-00 00:00:00'),
(8, 'Multivitamin 5in1', 261.00, NULL, 2, '2018-12-20 02:28:58', '0000-00-00 00:00:00'),
(9, 'Nutrision Boost', 237.50, '', 1, '2019-01-18 00:30:23', '0000-00-00 00:00:00'),
(10, 'Vitamin B Complex', 128.99, 'For the reduction of tiredness and fatigue', 2, '2019-01-18 00:34:24', '0000-00-00 00:00:00'),
(11, 'Centrum Silver', 153.60, 'centrum silver discription', 4, '2019-01-24 01:19:11', '2019-01-24 01:39:45'),
(12, 'Super B-Complex', 128.99, 'May help support energy and metabolism', 2, '2019-01-24 01:42:30', '2019-01-24 01:44:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`card_number`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
