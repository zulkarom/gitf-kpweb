-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 10:14 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkp_portal_yfv`
--

-- --------------------------------------------------------

--
-- Table structure for table `adu_aduan`
--

CREATE TABLE `adu_aduan` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(225) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `topic_id` varchar(100) NOT NULL,
  `title` varchar(225) NOT NULL,
  `aduan` text NOT NULL,
  `declaration` tinyint(1) NOT NULL,
  `upload_url` text NOT NULL,
  `captcha` varchar(225) NOT NULL,
  `progress_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adu_aduan`
--
ALTER TABLE `adu_aduan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adu_aduan`
--
ALTER TABLE `adu_aduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
