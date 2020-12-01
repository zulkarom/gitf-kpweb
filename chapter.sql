-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2020 at 05:05 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkpportalumkedu_fkpapps2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `proceeding`
--

CREATE TABLE `cp_chapterinbook` (
  `id` int(11) NOT NULL,
  `chap_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `image_file` text COLLATE utf8_unicode_ci NOT NULL,
  `chap_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proc_paper`
--

CREATE TABLE `cp_chapter_paper` (
  `id` int(11) NOT NULL,
  `chap_id` int(11) NOT NULL,
  `paper_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paper_no` int(11) NOT NULL,
  `paper_page` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paper_file` text COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `proceeding`
--
ALTER TABLE `cp_chapterinbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proc_paper`
--
ALTER TABLE `cp_chapter_paper`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `proceeding`
--
ALTER TABLE `cp_chapterinbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proc_paper`
--
ALTER TABLE `cp_chapter_paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
