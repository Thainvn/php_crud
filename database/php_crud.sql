-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2018 at 09:05 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(252) COLLATE utf8_general_mysql500_ci NOT NULL,
  `description` text COLLATE utf8_general_mysql500_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Motors', 'There are products for your motor needs', '2018-09-15 00:00:00', '2018-09-15 13:25:39'),
(2, 'Electronics', 'This covers products like gadgets and electronic accessories', '2018-09-15 20:18:21', '2018-09-15 13:26:31'),
(3, 'Fashion', 'New fashion trends? We surely have those products ...', '2018-09-15 20:26:00', '2018-09-15 13:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` text,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created`, `modified`) VALUES
(1, 'Basketball', 'A ball used in the NBA.', 49.99, NULL, 2, '2015-08-02 12:04:03', '2018-09-15 12:50:52'),
(3, 'Gatorade', 'This is a very good drink for athletes.', 1.99, NULL, 3, '2015-08-02 12:14:29', '2018-09-15 13:46:11'),
(5, 'Trash Can', 'It will help you maintain cleanliness.', 0, NULL, 1, '2015-08-02 12:16:08', '2018-09-16 09:12:18'),
(6, 'Mouse', 'Very useful if you love your computer.', 11.35, NULL, 1, '2015-08-02 12:17:58', '2018-09-15 12:51:45'),
(7, 'Earphone', 'You need this one if you love music.', 7, NULL, 3, '2015-08-02 12:18:21', '2018-09-15 13:46:20'),
(8, 'Pillow', 'Sleeping well is important.', 0, NULL, 3, '2015-08-02 12:18:56', '2018-09-16 09:12:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
