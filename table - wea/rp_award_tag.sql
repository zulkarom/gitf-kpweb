-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2019 at 12:42 PM
-- Server version: 10.1.42-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkp2018_portal_19_yfv`
--

-- --------------------------------------------------------

--
-- Table structure for table `rp_award_tag`
--

CREATE TABLE `rp_award_tag` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `award_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rp_award_tag`
--

INSERT INTO `rp_award_tag` (`id`, `staff_id`, `award_id`) VALUES
(7, 33, 7),
(8, 29, 8),
(9, 29, 9),
(14, 28, 14),
(15, 28, 15),
(17, 28, 17),
(18, 28, 18),
(19, 28, 19),
(20, 28, 20),
(21, 28, 21),
(22, 28, 22),
(23, 28, 23),
(24, 28, 24),
(26, 17, 26),
(27, 17, 27),
(29, 8, 29),
(30, 8, 30),
(31, 71, 31),
(32, 77, 32),
(33, 77, 33),
(34, 81, 34),
(35, 40, 35),
(36, 63, 36),
(37, 166, 37),
(38, 139, 38),
(39, 64, 39),
(40, 73, 40),
(41, 54, 41),
(43, 45, 43),
(44, 45, 44),
(45, 71, 45),
(46, 63, 46),
(51, 73, 51),
(52, 144, 52),
(53, 144, 53),
(54, 144, 54),
(55, 144, 55),
(56, 80, 56),
(57, 80, 57),
(58, 80, 58),
(59, 80, 59),
(60, 143, 60),
(61, 143, 61),
(62, 190, 62),
(63, 144, 63),
(64, 144, 64),
(65, 144, 65),
(66, 144, 66),
(67, 1, 67),
(68, 40, 68),
(69, 144, 69),
(70, 144, 70),
(71, 144, 71),
(72, 144, 72),
(73, 144, 73),
(74, 144, 74),
(75, 1, 75),
(76, 1, 76),
(77, 1, 77),
(78, 1, 78),
(79, 224, 79);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rp_award_tag`
--
ALTER TABLE `rp_award_tag`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rp_award_tag`
--
ALTER TABLE `rp_award_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
