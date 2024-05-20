-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 07:03 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkp_portal2`
--

-- --------------------------------------------------------

--
-- Table structure for table `prtg_company`
--

CREATE TABLE `prtg_company` (
  `id` int(11) NOT NULL,
  `status` int(11) DEFAULT 0,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` int(100) DEFAULT NULL,
  `company_pic` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prtg_company_offer`
--

CREATE TABLE `prtg_company_offer` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `available_slot` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prtg_session`
--

CREATE TABLE `prtg_session` (
  `id` int(11) NOT NULL,
  `session_name` varchar(255) NOT NULL,
  `total_student` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `instruction` text DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prtg_student_reg`
--

CREATE TABLE `prtg_student_reg` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `company_offer_id` int(11) NOT NULL,
  `student_matric` varchar(100) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `program_abbr` varchar(10) DEFAULT NULL,
  `register_at` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prtg_company`
--
ALTER TABLE `prtg_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prtg_company_offer`
--
ALTER TABLE `prtg_company_offer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `prtg_session`
--
ALTER TABLE `prtg_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prtg_student_reg`
--
ALTER TABLE `prtg_student_reg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_offer_id` (`company_offer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prtg_company`
--
ALTER TABLE `prtg_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prtg_company_offer`
--
ALTER TABLE `prtg_company_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prtg_session`
--
ALTER TABLE `prtg_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prtg_student_reg`
--
ALTER TABLE `prtg_student_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prtg_company_offer`
--
ALTER TABLE `prtg_company_offer`
  ADD CONSTRAINT `prtg_company_offer_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `prtg_session` (`id`),
  ADD CONSTRAINT `prtg_company_offer_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `prtg_company` (`id`);

--
-- Constraints for table `prtg_student_reg`
--
ALTER TABLE `prtg_student_reg`
  ADD CONSTRAINT `prtg_student_reg_ibfk_1` FOREIGN KEY (`company_offer_id`) REFERENCES `prtg_company_offer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
