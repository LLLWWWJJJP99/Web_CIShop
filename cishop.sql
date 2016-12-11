-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2016 at 05:17 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cishop`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_admin_user`
--

CREATE TABLE `ci_admin_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_admin_user`
--

INSERT INTO `ci_admin_user` (`user_id`, `user_name`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `ci_attribute`
--

CREATE TABLE `ci_attribute` (
  `attr_id` int(10) UNSIGNED NOT NULL,
  `attr_name` varchar(50) NOT NULL DEFAULT '',
  `type_id` int(11) NOT NULL DEFAULT '0',
  `attr_type` tinyint(4) NOT NULL DEFAULT '1',
  `attr_input_type` int(11) NOT NULL DEFAULT '1',
  `attr_value` text,
  `sort_order` int(11) NOT NULL DEFAULT '50',
  `deleted` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_attribute`
--

INSERT INTO `ci_attribute` (`attr_id`, `attr_name`, `type_id`, `attr_type`, `attr_input_type`, `attr_value`, `sort_order`, `deleted`) VALUES
(8, 'Color', 1, 0, 1, 'Red\r\nGreen\r\nBlue', 50, NULL),
(9, 'Height', 1, 0, 1, 'tall\r\nshort\r\nnormal', 50, NULL),
(11, 'Size', 2, 0, 0, NULL, 50, NULL),
(12, 'Price', 0, 0, 0, NULL, 50, NULL),
(13, 'Price', 2, 0, 0, NULL, 50, NULL),
(14, 'Series', 2, 0, 1, 'PS3\r\nPS4\r\nBest', 50, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_brand`
--

CREATE TABLE `ci_brand` (
  `brand_id` smallint(5) UNSIGNED NOT NULL,
  `brand_name` varchar(30) NOT NULL DEFAULT '',
  `brand_desc` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(50) NOT NULL DEFAULT '',
  `sort_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '50',
  `is_show` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_brand`
--

INSERT INTO `ci_brand` (`brand_id`, `brand_name`, `brand_desc`, `url`, `logo`, `sort_order`, `is_show`) VALUES
(6, 'Blackberry', '', 'www.Blackberry.com', 'BB.png', 50, 1),
(2, 'Lenovo', 'Lenovo', 'Lenovo', 'L.png', 50, 1),
(3, 'Apple', 'descr', 'www.Apple.com', 'Apple1.png', 50, 1),
(4, 'Samsung', 'www', 'www.Samsung.com', 'SS.png', 50, 1),
(7, 'Nokia', 'Nokia', 'www.Nokia.com', 'N.jpg', 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_category`
--

CREATE TABLE `ci_category` (
  `cat_id` smallint(5) UNSIGNED NOT NULL,
  `cat_name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `cat_desc` varchar(255) NOT NULL DEFAULT '',
  `sort_order` tinyint(4) NOT NULL DEFAULT '50',
  `unit` varchar(15) NOT NULL DEFAULT '',
  `is_show` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category`
--

INSERT INTO `ci_category` (`cat_id`, `cat_name`, `parent_id`, `cat_desc`, `sort_order`, `unit`, `is_show`) VALUES
(21, 'SmartPhone', 0, 'SmartPhone', 25, '10', 1),
(22, 'NormalPhone', 0, 'NormalPhone', 50, '20', 1),
(23, 'Nokia', 21, 'Nokia', 50, '35', 1),
(24, 'NokiaTSeries', 23, 'NokiaTSeries', 50, '10', 0),
(25, 'Samsung', 21, 'Samsung', 50, '11', 1),
(35, 'Galaxy', 25, 'Galaxy', 50, '11', 1),
(27, 'Apple', 21, '', 50, '14', 1),
(28, 'Iphone', 27, '', 50, '21', 1),
(29, 'Lenovo', 21, '', 50, '43', 1),
(30, 'LenovoRTSeries', 29, '', 50, '33', 1),
(31, 'Blackberry', 22, '', 50, '21', 1),
(32, 'BlackberrySeries', 31, '', 50, '77', 0),
(33, 'LenovoPro', 22, '', 50, '2', 1),
(34, 'LenovoCSeries', 33, '', 50, '31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_goods`
--

CREATE TABLE `ci_goods` (
  `goods_id` int(10) UNSIGNED NOT NULL,
  `goods_sn` varchar(30) NOT NULL DEFAULT '',
  `goods_name` varchar(100) NOT NULL DEFAULT '',
  `goods_brief` varchar(255) NOT NULL DEFAULT '',
  `goods_desc` text,
  `cat_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `brand_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `promote_start_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `promote_end_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `goods_img` varchar(50) NOT NULL DEFAULT '',
  `goods_thumb` varchar(50) NOT NULL DEFAULT '',
  `goods_number` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `click_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `is_promote` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_best` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_new` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_hot` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_onsale` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `add_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_goods`
--

INSERT INTO `ci_goods` (`goods_id`, `goods_sn`, `goods_name`, `goods_brief`, `goods_desc`, `cat_id`, `brand_id`, `market_price`, `shop_price`, `promote_price`, `promote_start_time`, `promote_end_time`, `goods_img`, `goods_thumb`, `goods_number`, `click_count`, `type_id`, `is_promote`, `is_best`, `is_new`, `is_hot`, `is_onsale`, `add_time`, `deleted`) VALUES
(28, '', 'Nokia09', '', NULL, 21, 7, '0.00', '900.00', '0.00', 0, 0, 'Nokia092.jpg', 'Nokia092_thumb.jpg', 3, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(29, '', 'Nokia100', '', NULL, 21, 7, '0.00', '909.00', '0.00', 0, 0, 'Nokia1001.jpg', 'Nokia1001_thumb.jpg', 2, 0, 0, 0, 1, 1, 1, 0, 0, 0),
(30, '', 'Nokia200', '', NULL, 21, 7, '0.00', '800.00', '0.00', 0, 0, 'Nokia2001.jpg', 'Nokia2001_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(31, '', 'Nokia300', '', NULL, 24, 7, '0.00', '900.00', '0.00', 0, 0, 'Nokia300.jpg', 'Nokia300_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(32, '', 'Samsung2', '', NULL, 35, 7, '0.00', '900.00', '0.00', 0, 0, 'Samsung21.jpg', 'Samsung21_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(33, '', 'SamsungGalaxy', '', NULL, 35, 4, '0.00', '777.00', '0.00', 0, 0, 'SamsungGalaxy1.jpg', 'SamsungGalaxy1_thumb.jpg', 2, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(34, '', 'SamsungSliver', '', NULL, 35, 4, '0.00', '900.00', '0.00', 0, 0, 'SamsungSliver1.jpg', 'SamsungSliver1_thumb.jpg', 2, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(35, '', 'Galaxy3', '', NULL, 35, 4, '0.00', '900.00', '0.00', 0, 0, 'Galaxy31.jpg', 'Galaxy31_thumb.jpg', 10, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(36, '', 'Lenovo999', '', NULL, 30, 2, '0.00', '900.00', '0.00', 0, 0, 'Lenovo999.jpg', 'Lenovo999_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(37, '', 'LenovoZTT', '', NULL, 34, 2, '0.00', '900.00', '0.00', 0, 0, 'LenovoZTT.jpg', 'LenovoZTT_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(38, '', 'Lenovo090', '', NULL, 34, 2, '0.00', '900.00', '0.00', 0, 0, 'Lenovo090.jpg', 'Lenovo090_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(39, '', 'Iphone5', '', NULL, 21, 3, '0.00', '666.00', '0.00', 0, 0, 'Iphone51.jpg', 'Iphone51_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(40, '', 'Iphone5S', '', NULL, 28, 7, '0.00', '567.00', '0.00', 0, 0, 'Iphone5S.jpg', 'Iphone5S_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(41, '', 'Iphone6', '', NULL, 28, 3, '0.00', '888.00', '0.00', 0, 0, 'Iphone6.jpg', 'Iphone6_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(42, '', 'Iphone6S', '', NULL, 28, 3, '0.00', '900.00', '0.00', 0, 0, 'Iphone6S.jpg', 'Iphone6S_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(43, '', 'Iphone7S', '', NULL, 28, 3, '0.00', '790.00', '0.00', 0, 0, 'Iphone7S.jpg', 'Iphone7S_thumb.jpg', 3, 0, 0, 0, 1, 1, 1, 0, 0, 0),
(44, '', 'Blackberry20', '', NULL, 32, 6, '0.00', '500.00', '0.00', 0, 0, 'Blackberry20.jpg', 'Blackberry20_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(45, '', 'BlackberryPPO', '', NULL, 32, 6, '0.00', '444.00', '0.00', 0, 0, 'BlackberryPPO.jpg', 'BlackberryPPO_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(46, '', 'BlackberryY20', '', NULL, 32, 6, '0.00', '650.00', '0.00', 0, 0, 'BlackberryY20.jpg', 'BlackberryY20_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(47, '', 'BlackBerryZ10', '', NULL, 32, 6, '0.00', '567.00', '0.00', 0, 0, 'BlackBerryZ10.png', 'BlackBerryZ10_thumb.png', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0),
(48, '', 'blackberryZ20', '', NULL, 32, 6, '0.00', '555.00', '0.00', 0, 0, 'blackberryZ20.jpg', 'blackberryZ20_thumb.jpg', 4, 0, 0, 0, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_goods_attr`
--

CREATE TABLE `ci_goods_attr` (
  `goods_attr_id` int(10) UNSIGNED NOT NULL,
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `attr_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `attr_value` varchar(255) NOT NULL DEFAULT '',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_goods_attr`
--

INSERT INTO `ci_goods_attr` (`goods_attr_id`, `goods_id`, `attr_id`, `attr_value`, `attr_price`) VALUES
(1, 4, 11, '1', '0.00'),
(2, 4, 13, '1', '0.00'),
(3, 4, 14, 'PS3', '0.00'),
(4, 5, 8, 'Red', '0.00'),
(5, 5, 9, '100', '0.00'),
(6, 5, 10, '10', '0.00'),
(7, 10, 8, 'Red', '0.00'),
(8, 10, 9, 'tall', '0.00'),
(9, 12, 11, '10', '0.00'),
(10, 12, 13, '10', '0.00'),
(11, 12, 14, 'PS3', '0.00'),
(12, 13, 8, 'Red', '0.00'),
(13, 13, 9, 'short', '0.00'),
(14, 14, 8, 'Green', '0.00'),
(15, 14, 9, 'tall', '0.00'),
(16, 15, 8, 'Green', '0.00'),
(17, 15, 9, 'tall', '0.00'),
(18, 20, 8, 'Red', '0.00'),
(19, 20, 9, 'short', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_goods_type`
--

CREATE TABLE `ci_goods_type` (
  `type_id` smallint(5) UNSIGNED NOT NULL,
  `type_name` varchar(50) NOT NULL DEFAULT '',
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_goods_type`
--

INSERT INTO `ci_goods_type` (`type_id`, `type_name`, `deleted`) VALUES
(1, 'SmartPhone', 1),
(2, 'NormalPhone', 0),
(3, 'FrontProduct', 0),
(5, 'ToyPhone', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_order`
--

CREATE TABLE `ci_order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_order`
--

INSERT INTO `ci_order` (`order_id`, `user_id`, `goods_id`, `quantity`) VALUES
(50, 39, 24, 1),
(51, 39, 23, 2),
(52, 39, 24, 1),
(53, 39, 23, 2),
(54, 39, 23, 1),
(55, 39, 24, 2),
(56, 39, 24, 2),
(57, 39, 24, 2),
(58, 39, 25, 2),
(59, 39, 27, 1),
(60, 39, 25, 4),
(61, 39, 27, 1),
(62, 39, 25, 4),
(63, 39, 25, 4),
(64, 39, 29, 1),
(66, 39, 29, 1),
(67, 39, 43, 1),
(68, 39, 34, 2),
(69, 39, 33, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user`
--

CREATE TABLE `ci_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `reg_time` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user`
--

INSERT INTO `ci_user` (`user_id`, `user_name`, `email`, `password`, `reg_time`) VALUES
(33, 'DavidLi210', 'wenjieli2015@sina.com', '0192023a7bbd73250516f069df18b500', 1480389442),
(37, 'admin', 'wenjieli2016@sina.com', '0192023a7bbd73250516f069df18b500', 1480487536),
(39, 'wenjie', 'wenjieli2015@ssina.com', '6b4fbebaabede0b4a3004c9834c4bbe7', 1480534295);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_admin_user`
--
ALTER TABLE `ci_admin_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ci_attribute`
--
ALTER TABLE `ci_attribute`
  ADD PRIMARY KEY (`attr_id`);

--
-- Indexes for table `ci_brand`
--
ALTER TABLE `ci_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `ci_category`
--
ALTER TABLE `ci_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `pid` (`parent_id`);

--
-- Indexes for table `ci_goods`
--
ALTER TABLE `ci_goods`
  ADD PRIMARY KEY (`goods_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `ci_goods_attr`
--
ALTER TABLE `ci_goods_attr`
  ADD PRIMARY KEY (`goods_attr_id`),
  ADD KEY `goods_id` (`goods_id`),
  ADD KEY `attr_id` (`attr_id`);

--
-- Indexes for table `ci_goods_type`
--
ALTER TABLE `ci_goods_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `ci_order`
--
ALTER TABLE `ci_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_3` (`goods_id`);

--
-- Indexes for table `ci_user`
--
ALTER TABLE `ci_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_admin_user`
--
ALTER TABLE `ci_admin_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ci_attribute`
--
ALTER TABLE `ci_attribute`
  MODIFY `attr_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ci_brand`
--
ALTER TABLE `ci_brand`
  MODIFY `brand_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `cat_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `ci_goods`
--
ALTER TABLE `ci_goods`
  MODIFY `goods_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `ci_goods_attr`
--
ALTER TABLE `ci_goods_attr`
  MODIFY `goods_attr_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `ci_goods_type`
--
ALTER TABLE `ci_goods_type`
  MODIFY `type_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ci_order`
--
ALTER TABLE `ci_order`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
