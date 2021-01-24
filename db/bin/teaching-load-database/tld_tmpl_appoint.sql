-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2020 at 10:09 AM
-- Server version: 10.4.10-MariaDB
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
-- Table structure for table `tld_tmpl_appoint`
--

CREATE TABLE `tld_tmpl_appoint` (
  `id` int(11) NOT NULL,
  `template_name` varchar(200) NOT NULL,
  `dekan` varchar(100) NOT NULL,
  `yg_benar` text NOT NULL,
  `tema` text NOT NULL,
  `per1` text NOT NULL,
  `signiture_file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tld_tmpl_appoint`
--

INSERT INTO `tld_tmpl_appoint` (`id`, `template_name`, `dekan`, `yg_benar`, `tema`, `per1`, `signiture_file`, `created_at`, `updated_at`) VALUES
(1, 'Template Pertama', 'YBHG. PROF. DATO\' TS. DR. NOOR AZIZI ISMAIL', 'Saya yang menjalankan amanah', '\"RAJA BERDAULAT, RAKYAT MUAFAKAT, NEGERI BERKAT\"\r\n\"BERKHIDMAT UNTUK NEGARA\"', 'Sehubungan dengan itu, pihak fakulti berharap agar Tuan akan melaksanakan tugas dan tanggungjawab ini dengan telus, cekap dan berkesan demi memastikan kecemerlangan akademik pelajar Universiti Malaysia Kelantan secara amnya dan Fakulti Keusahawanan dan Perniagaan secara khasnya. Kerjasama dan perhatian Tuan dalam hal ini amatlah dihargai dan didahului dengan ucapan ribuan terima kasih.', 'signiture/01619A/signiture_16081867345fdafb6ecfd013.20065474.png', '2020-12-17 14:32:17', '2020-12-17 14:32:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tld_tmpl_appoint`
--
ALTER TABLE `tld_tmpl_appoint`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tld_tmpl_appoint`
--
ALTER TABLE `tld_tmpl_appoint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
