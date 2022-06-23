-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2022 at 07:01 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkpportalumkedu_fkpapps2021`
--

-- --------------------------------------------------------

--
-- Table structure for table `conf_scope`
--

CREATE TABLE `conf_scope` (
  `id` int(2) NOT NULL,
  `conf_id` int(11) DEFAULT NULL,
  `scope_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conf_scope`
--

INSERT INTO `conf_scope` (`id`, `conf_id`, `scope_name`) VALUES
(1, 1, 'Management'),
(2, 1, ' Finance'),
(3, 1, ' Accounting'),
(4, 1, ' Retailing'),
(5, 1, ' Commerce'),
(6, 1, ' Entrepreneurship'),
(7, 1, ' Islamic Banking and Finance'),
(8, 1, ' Logistics Management and Operation'),
(9, 1, ' Human Resource Management'),
(10, 1, ' Marketing'),
(11, 1, ' Management Information Systems'),
(12, 1, ' Economics'),
(13, 1, ' Corporate Governance and Law'),
(14, 1, ' Public Administration'),
(15, 1, 'Others'),
(16, 2, 'Entrepreneurship'),
(17, 2, 'Technopreneurship'),
(18, 2, 'Digital Entrepreneurship'),
(19, 2, 'Creativity and Innovation'),
(20, 2, 'Information Technology'),
(21, 2, 'Information system'),
(22, 2, 'IR 4.0'),
(23, 2, 'IoT'),
(24, 2, 'Engineering Technology'),
(25, 2, 'Innovation Management'),
(26, 2, 'Opportunity and Risk'),
(27, 2, 'Finance (including Fintech'),
(28, 2, 'Retailing'),
(29, 2, 'Family Business'),
(30, 2, 'Economics and Development'),
(31, 2, 'Logistics and Supply Chain'),
(32, 2, 'Social Entrepreneurship'),
(33, 2, 'Entrepreneurship Education'),
(34, 2, 'Business Start-up'),
(35, 2, 'Business and Management'),
(36, 2, 'Digital Marketing'),
(37, 2, 'Financial Management '),
(38, 2, 'Accounting'),
(39, 2, 'Multimedia'),
(40, 2, 'Human Resource'),
(41, 2, 'Tourism and Hospitality '),
(42, 2, 'Environmental Management'),
(43, 2, 'Islamic Banking'),
(44, 2, 'Communication'),
(45, 2, 'Animation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conf_scope`
--
ALTER TABLE `conf_scope`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
