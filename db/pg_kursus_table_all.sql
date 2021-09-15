-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2021 at 12:16 AM
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
-- Table structure for table `pg_kursus`
--

CREATE TABLE `pg_kursus` (
  `id` int(11) NOT NULL,
  `kursus_name` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_kursus_anjur`
--

CREATE TABLE `pg_kursus_anjur` (
  `id` int(11) NOT NULL,
  `kursus_siri` varchar(225) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(225) NOT NULL,
  `description` text NOT NULL,
  `kursus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_kursus_kategori`
--

CREATE TABLE `pg_kursus_kategori` (
  `id` int(11) NOT NULL,
  `kategori_name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_kursus_peserta`
--

CREATE TABLE `pg_kursus_peserta` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `anjur_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `submitted_at` datetime NOT NULL,
  `paid_at` datetime NOT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `user_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pg_kursus`
--
ALTER TABLE `pg_kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_kursus_anjur`
--
ALTER TABLE `pg_kursus_anjur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_kursus_kategori`
--
ALTER TABLE `pg_kursus_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_kursus_peserta`
--
ALTER TABLE `pg_kursus_peserta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pg_kursus`
--
ALTER TABLE `pg_kursus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pg_kursus_anjur`
--
ALTER TABLE `pg_kursus_anjur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pg_kursus_kategori`
--
ALTER TABLE `pg_kursus_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pg_kursus_peserta`
--
ALTER TABLE `pg_kursus_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
