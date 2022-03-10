-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2022 at 06:03 AM
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
-- Table structure for table `mnl_item`
--

CREATE TABLE `mnl_item` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `item_text` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0 = normal, 1 = steps, 3 = bullet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_item`
--

INSERT INTO `mnl_item` (`id`, `title_id`, `item_text`, `type`) VALUES
(1, 1, 'Follow the steps below:', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mnl_module`
--

CREATE TABLE `mnl_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `module_route` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_module`
--

INSERT INTO `mnl_module` (`id`, `module_name`, `module_route`) VALUES
(1, 'Course Management', NULL),
(2, 'Course File', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mnl_section`
--

CREATE TABLE `mnl_section` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_section`
--

INSERT INTO `mnl_section` (`id`, `module_id`, `section_name`) VALUES
(1, 1, 'User Manual'),
(2, 1, 'FAQ'),
(3, 2, 'User Manual'),
(4, 2, 'FAQ');

-- --------------------------------------------------------

--
-- Table structure for table `mnl_step`
--

CREATE TABLE `mnl_step` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `step_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_step`
--

INSERT INTO `mnl_step` (`id`, `item_id`, `step_text`) VALUES
(1, 1, 'Login to https://fkp-portal.umk.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `mnl_title`
--

CREATE TABLE `mnl_title` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `title_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_title`
--

INSERT INTO `mnl_title` (`id`, `section_id`, `title_text`) VALUES
(1, 3, 'How to go the main Course File page?'),
(2, 3, 'Course Section: Uploding Student Evaluation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mnl_item`
--
ALTER TABLE `mnl_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_module`
--
ALTER TABLE `mnl_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_section`
--
ALTER TABLE `mnl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_step`
--
ALTER TABLE `mnl_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_title`
--
ALTER TABLE `mnl_title`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mnl_item`
--
ALTER TABLE `mnl_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mnl_module`
--
ALTER TABLE `mnl_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mnl_section`
--
ALTER TABLE `mnl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mnl_step`
--
ALTER TABLE `mnl_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mnl_title`
--
ALTER TABLE `mnl_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
