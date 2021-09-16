-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2021 at 06:04 AM
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
-- Database: `fkp_portal_yfv`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_pg`
--

CREATE TABLE `student_pg` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `date_birth` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `marital_status` tinyint(1) NOT NULL,
  `nationality` int(11) NOT NULL,
  `citizenship` tinyint(1) NOT NULL,
  `prog_code` varchar(10) NOT NULL,
  `edu_level` tinyint(1) NOT NULL,
  `address` varchar(225) NOT NULL,
  `city` varchar(225) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `personal_email` varchar(225) NOT NULL,
  `religion` tinyint(2) NOT NULL,
  `race` tinyint(2) NOT NULL,
  `bachelor_name` varchar(225) NOT NULL,
  `university_name` varchar(225) NOT NULL,
  `bachelor_cgpa` varchar(10) NOT NULL,
  `bachelor_year` varchar(4) NOT NULL,
  `session` int(11) NOT NULL,
  `admission_year` varchar(4) NOT NULL,
  `admission_date_sem1` date NOT NULL,
  `sponsor` tinyint(1) NOT NULL,
  `student_current_sem` int(11) NOT NULL,
  `city_campus` tinyint(1) NOT NULL,
  `student_status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_pg`
--
ALTER TABLE `student_pg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_pg`
--
ALTER TABLE `student_pg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
