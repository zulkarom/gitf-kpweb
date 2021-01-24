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
-- Table structure for table `adu_aduan_progress`
--

CREATE TABLE `adu_aduan_progress` (
  `id` int(11) NOT NULL,
  `progress` varchar(30) NOT NULL,
  `admin_action` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adu_aduan_progress`
--

INSERT INTO `adu_aduan_progress` (`id`, `progress`, `admin_action`) VALUES
(1, 'Draft', 0),
(20, 'Submit', 0),
(30, 'Review', 0),
(40, 'In Progress', 1),
(50, 'Pending', 1),
(60, 'Action Taken', 1),
(100, 'Complete', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adu_aduan_progress`
--
ALTER TABLE `adu_aduan_progress`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
