-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2022 at 10:25 AM
-- Server version: 5.7.38
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkpportalumkedu_fkpapps2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `pg_external`
--

CREATE TABLE `pg_external` (
  `id` int(11) NOT NULL,
  `ex_name` varchar(200) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_field`
--

CREATE TABLE `pg_field` (
  `id` int(11) NOT NULL,
  `field_name` varchar(200) NOT NULL,
  `is_main` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_field`
--

INSERT INTO `pg_field` (`id`, `field_name`, `is_main`) VALUES
(1, 'Pengurusan', 1),
(2, 'Kewangan', 1),
(3, 'Perakaunan', 1),
(4, 'Peruncitan', 1),
(5, 'Perdagangan', 1),
(6, 'Keusahawanan', 1),
(7, 'Perbankan dan Kewangan Islam', 1),
(8, 'Pengurusan Logistik dan Operasi', 1),
(9, 'Pengurusan Sumber Manusia', 1),
(10, 'Pemasaran', 1);

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
  `kursus_name` varchar(225) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `location` varchar(225) DEFAULT NULL,
  `description` text,
  `kategori_id` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `pg_res_stage`
--

CREATE TABLE `pg_res_stage` (
  `id` int(11) NOT NULL,
  `stage_name` varchar(100) DEFAULT NULL,
  `stage_abbr` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_res_stage`
--

INSERT INTO `pg_res_stage` (`id`, `stage_name`, `stage_abbr`) VALUES
(1, 'Proposal Defense', 'PD'),
(2, 'Candidature Defense', 'CD'),
(3, 'VIVA', 'VIVA');

-- --------------------------------------------------------

--
-- Table structure for table `pg_semester_module`
--

CREATE TABLE `pg_semester_module` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `result` tinyint(4) DEFAULT NULL,
  `student_sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_stage_examiner`
--

CREATE TABLE `pg_stage_examiner` (
  `id` int(11) NOT NULL,
  `examiner_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `appoint_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_student`
--

CREATE TABLE `pg_student` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `nric` varchar(20) DEFAULT NULL,
  `date_birth` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `marital_status` tinyint(1) DEFAULT NULL,
  `nationality` int(11) NOT NULL DEFAULT '158',
  `citizenship` tinyint(1) NOT NULL DEFAULT '1',
  `program_id` int(10) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `study_mode` tinyint(1) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `city` varchar(225) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `personal_email` varchar(225) DEFAULT NULL,
  `religion` tinyint(2) NOT NULL DEFAULT '1',
  `race` tinyint(2) DEFAULT '1',
  `bachelor_name` varchar(225) DEFAULT NULL,
  `bachelor_university` varchar(225) DEFAULT NULL,
  `bachelor_cgpa` varchar(10) DEFAULT NULL,
  `bachelor_year` varchar(4) DEFAULT NULL,
  `admission_semester` int(11) DEFAULT NULL,
  `admission_year` varchar(4) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `sponsor` varchar(255) DEFAULT NULL,
  `current_sem` int(11) DEFAULT NULL,
  `campus_id` tinyint(4) NOT NULL DEFAULT '2',
  `status` tinyint(4) NOT NULL DEFAULT '10',
  `remark` text,
  `outstanding_fee` decimal(11,2) DEFAULT NULL,
  `related_university_id` int(11) DEFAULT NULL,
  `master_name` varchar(255) DEFAULT NULL,
  `master_university` varchar(255) DEFAULT NULL,
  `master_cgpa` varchar(10) DEFAULT NULL,
  `master_year` varchar(4) DEFAULT NULL,
  `program_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_student`
--

INSERT INTO `pg_student` (`id`, `user_id`, `matric_no`, `nric`, `date_birth`, `gender`, `marital_status`, `nationality`, `citizenship`, `program_id`, `field_id`, `study_mode`, `address`, `city`, `phone_no`, `personal_email`, `religion`, `race`, `bachelor_name`, `bachelor_university`, `bachelor_cgpa`, `bachelor_year`, `admission_semester`, `admission_year`, `admission_date`, `sponsor`, `current_sem`, `campus_id`, `status`, `remark`, `outstanding_fee`, `related_university_id`, `master_name`, `master_university`, `master_cgpa`, `master_year`, `program_code`) VALUES
(1, 2645, 'A19D018P', '950210-06-5208', '1995-06-02', 0, 2, 158, 1, 81, NULL, 1, 'No.3, Lorong Kempadang Makmur 2/1\nTaman Kempadang Makmur\n25150 Kuantan\nPahang\n', 'Pahang', '011-17899590', 'aniszulhisam95@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan (Hospitaliti)\n', 'UMK', '2.72', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2646, 'A19D022F', '950702-03-6358', '1995-07-02', 0, 2, 158, 1, 81, NULL, 1, '4151 B Kampung Paya Senang\n15150 Jalan Telipot\nKota Bharu\nKelantan\n', 'Kota Bharu', '013-9206766', 'aifadinie@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan (Hospitaliti)\n', 'UMK', '3.07', '2019', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2647, 'A19D003F', '921005-10-5685', '1992-10-05', 1, 2, 158, 1, 82, NULL, 1, 'No 25 Jalan TPS 3/9\nTaman Pelangi Semenyih\n43500 Semenyih\nSelangor\n', 'Selangor', '013-4234013', 'arifabdulkhalik@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-04', 'Pembiayaan Sendiri', 5, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2648, 'A19D008F', '920322-03-6084', '1992-03-22', 0, 2, 158, 1, 82, NULL, 1, 'Lot 4129 Jalan Mahsuri\n17500 Tanah Merah\nKelantan\n', 'Tanah Merah', '019-9084590', 'fatin92shah56@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam) dengan Kepujian\n', 'UMK', '2.88', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2649, 'A19D016P', '880321-62-5078', '1988-03-21', 0, 2, 158, 1, 82, NULL, 2, '680-C Jalan Pengkalan Chepa\nTanjung Mas\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '013-9235683', 'sitinayusof@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Perakaunan\n\n', 'USIM', '2.86', '2016', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2650, 'A19D002F', '961019-03-5602', '1996-10-19', 0, 2, 158, 1, 82, NULL, 1, 'Lot 1994-A Jalan Puteri Saadong\nKampung Kota\n15100 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-9659811', 'idaazlan1910@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 2651, 'A19D014F', '951102-03-6172', '1995-11-02', 0, 2, 158, 1, 82, NULL, 1, 'Lot 910, Jalan Sabak\nKampung Tebing\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-7446609', 'amileenyusoff@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)\n', 'UMK', '', '2019', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2652, 'A19D024F', '930804-03-5518', '1993-08-04', 0, 2, 158, 1, 82, NULL, 1, 'Lot 1738 Lorong Hidayah\nKampung Huda Kubang Kerian\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-14962085', 'nurulaidasahira93@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran dan Hubungan Korporat dengan Kepujian\n', 'USIM', '3.25', '2016', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 2653, 'A19D007F', '950605-03-5046', '1995-06-05', 0, 2, 158, 1, 82, NULL, 1, 'PT 3622 Lorong Pondok Polis Labok\nKampung Kenanga Labok\n18500 Machang\nKelantan\n', 'Machang', '010-9286585', 'sitinurhananiabdulhamid@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Perbankan dan Kewangan Islam\n\n', 'UUM', '3.12', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 2654, 'A19D033P', '950107-10-5101', '1995-01-07', 1, 2, 158, 1, 81, NULL, 2, 'Pt 723 Lorong Masjid Taqwa\nPaya Bemban\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9444223', 'azimabuhassan@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-15', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 2655, 'A19D032P', '970814-03-5980', '1997-08-14', 0, 2, 158, 1, 82, NULL, 2, 'Lot 1342 Lorong Masjid Ar-Rahman\nBandar Banchok\n16300 Bachok\nKelantan\n', 'Bachok', '011-10977357', 'ufatihah@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Fiqh Usul', 'Universiti Mu’tah, Jordan', '3.67', '2019', 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 2656, 'A19D027F', '951016-03-6053', '1995-10-16', 1, 2, 158, 1, 82, NULL, 1, '5156 A Kg. Sireh Bawah Lembah\n15050 Kota Bharu\nKelantan\n', 'Kota Bharu', '0111-6856768', 'luqmanhakim700@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 2657, 'A19D036F', '940710-06-5010', '1994-07-10', 0, 1, 158, 1, 82, NULL, 1, 'Lot 1890 Lorong Dato’\nKampung Dusun Raja\nJalan Hospital\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-3003780', 'nurkhairina94@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-10-01', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 2658, 'A19D035F', '961023-03-5576', '1996-10-23', 0, 2, 158, 1, 81, NULL, 1, 'No 339 Seksyen 61\nBunut Payong\n15150 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9153389', 'aimisolehah23@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Kejuruteraan Teknologi Kimia Bioproses\n', 'Universiti Kuala Lumpur', '2.79', '2019', 201920201, '2019', '2019-10-01', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 2659, 'A19D066P', '840513-11-5164', '1984-05-13', 0, 1, 158, 1, 81, NULL, 2, 'Lot 15012 Taman Impian Murni\nBukit Datu\n21200 Kuala Terengganu\nTerengganu\n', 'Terengganu', '013-9201788', 'norihah_abdullah@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan', 'USM', '2.72', '2007', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 2660, 'A19D064P', '800304-11-5276', '1980-03-04', 0, 1, 158, 1, 81, NULL, 2, 'Lot 2705 Kampung Tok Kaya\n21000 Kuala Terengganu\nTerengganu\n', 'Terengganu', '019-3824148', 'mentari1980@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Pengurusan)', 'UKM', '2.97', '2004', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 2661, 'A19D065P', '760301-14-5935', '1976-03-01', 1, 1, 158, 1, 81, NULL, 2, 'No 3418 Lorong Seri Budiman\nKampung Mengabang Tengah\n20400 Kuala terengganu', 'Terengganu', '013-9303415', 'kerryzuedy@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UPM', '3.15', '2004', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 2662, 'A19D062F', '950203-03-5908', '1995-02-03', 0, 2, 158, 1, 82, NULL, 1, 'No.2 Depan Sekolah Kebangsaan Peria\n18000 Kuala Krai\nKelantan\n', 'Kuala Krai', '017-9246893', 'sitiaisahahmadkamal31@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.15', '2019', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 2663, 'A19D061F', '960813-03-5250', '1996-08-13', 0, 2, 158, 1, 82, NULL, 1, 'No 72 Kampung Bukit Merbau\n16810 Pasir Puteh\nKelantan\n', 'Pasir Puteh', '012-8422300', 'nuratie9604@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.3', '2019', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 3, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 2664, 'A19D054F', '940204-03-5142', '1994-02-04', 0, 2, 158, 1, 81, NULL, 1, 'Kampung Guar Gajah\nJalan Dewan Tok Bidan\n02600 Arau\nPerlis\n', 'Perlis', '011-21548914', 'nikaishah07@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Korporat', 'UMK', '2.66', '2017', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 2665, 'A19D055P', '831224-03-5390', '1983-12-24', 0, 1, 158, 1, 81, NULL, 2, 'Lot 1911 Kampung Chekok\n16600 Pulai Chondong\nKelantan\n', 'Pulai Chondong', '019-2989322', 'izzati@umk.edu.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Sains Pengajian Maklumat', 'UiTM', '3.47', '2006', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 2666, 'A19D053P', '891020-03-5246', '1989-10-20', 0, 1, 158, 1, 82, NULL, 2, 'Lot 1005 Kampung Chempaka\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-10898912', 'widad_sakura@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan)', 'UiTM', '2.67', '2017', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 2667, 'A19D067P', '800702-08-5623', '1980-07-02', 1, 1, 158, 1, 81, NULL, 2, 'E-532 (No.1921) Kampung Wakaf Peruas\nJalan Kuala Berang\n20500 Kuala Terengganu\nTerengganu', 'Kuala Terengganu', '012-4603753', 'nasir_kda@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Sains (Matematik)\n\nKelulusan Penilaian Rapi Kertas Kerja Edaran JPPSU', 'USM', '2.26', '2004', 201920202, '2020', '2020-03-02', 'Pembiayaan Sendiri', 4, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 2668, 'A20D025P', '950813-03-6350', '1995-08-13', 0, 2, 158, 1, 82, NULL, 1, 'Lot 4144, Jalan Dusun Pinang, Kampung Banggol Kemunting, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '0177310053', 'nurulfathiyahzakaria@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.26', '2018', 202020211, '2020', '2020-10-06', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 2669, 'A20D019F', '950213-03-6269', '1995-02-13', 1, 2, 158, 1, 81, NULL, 2, 'Lot 812, Jalan Masjid Baung Bayam, 15200 Kota Bharu, Kelantan', 'Kota Bharu', '0192454169', 'salihanzak13@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan dengan Kepujian', 'UMK', '2.89', '2020', 202020211, '2020', '2020-10-06', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 2670, 'A20D024F', '970917-03-5692', '1997-09-17', 0, 2, 158, 1, 82, NULL, 2, 'No. 4176-H, Lorong Che Majid, 15050 Kota Bharu, Kelantan', 'Kota Bharu', '01128324284', 'izaty970917@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan dan Perbankan Islam)', 'UMK', '3.39', '2020', 202020211, '2020', '2020-10-08', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 2671, 'A20D004F', '950513-03-5102', '1995-05-13', 0, 2, 158, 1, 81, NULL, 1, 'Lot 2387, Taman Paduka, Kubang Kerian, 16150 Kota Bharu, Kelantan', 'Kota Bharu', '01115656486', 'nurainabasyira@gmail.com', 1, 1, 'Sarjana Muda:\nBachelor of Aircraft Engineering Technology (Hons) in Avionics', 'UniKL', '3.66', '2019', 202020211, '2020', '2020-10-08', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 2672, 'A20D026P', '761217-02-5548', '1976-12-17', 0, 1, 158, 1, 81, NULL, 2, 'PT 3806, Lorong 3C, Seksyen C, Taman Merbau Utama, 16810 Selising, Pasir Puteh, Kelantan', 'Pasir Puteh', '0192004809', 'amirah17.mohammad@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.06', '2002', 202020211, '2020', '2020-10-09', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 2673, 'A20D012F', '930503-03-6509', '1993-05-03', 1, 2, 158, 1, 81, NULL, 1, 'Lot 3182, Kg. Wakaf Zain Tawang, 16020 Bachok, Kelantan', 'Bachok', '0137002779', 'nikshukri7777@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan', 'UMK', '3.29', '2018', 202020211, '2020', '2020-10-19', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 2674, 'A20D017F', '970826-03-5509', '1997-08-26', 1, 2, 158, 1, 82, NULL, 1, 'No. 627, Lorong Kota Kenari 3/5, Taman Kota Kenari, 09000 Kulim, Kedah', 'Kulim', '0139330826', 'syahirnizam.sn@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.46', '2020', 202020211, '2020', '2020-10-19', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 2675, 'A20D031F', '880807-03-5443', '1988-08-07', 1, 2, 158, 1, 81, NULL, 1, 'PT 1508 Taman Bendahara\nBaung Seksyen 36\nJalan Pengkalan Chepa\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '017-9074074', 'niknaim@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UMK', '3.06', '2019', 202020211, '2020', '1970-01-01', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 2676, 'A20D030F', '961107-11-5266', '1996-11-07', 0, 2, 158, 1, 82, NULL, 1, 'No 27 Felda Kerteh 4,\nBandar Ketengah Jaya,\n23300 Dungun, Terengganu', 'Dungun', '014-8159327', 'cwhni.nurlisa@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.6', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 2677, 'A20D018F', '970329-07-5460', '1997-03-29', 0, 2, 158, 1, 82, NULL, 1, '210 Pokok Tampang, 13300 Tasek Gelugor, Pulau Pinang', 'Tasek Gelugor', '011-14682695', 'aisyahmad293@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.22', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 2678, 'A20D034P', '960702-10-5463', '1996-07-02', 0, 2, 158, 1, 81, NULL, 1, 'No 31 Jalan Langat Murni, 6/A Taman Langa Murni, Bukit Changgang, 42700 Banting, Selangor', 'Banting', '0126047100', 'taufiq.a16a0364@siswa.umk.edu.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keushawanan', 'UMK', '3.11', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 2679, 'A20D033F', '810812-11-5079', '1981-08-12', 0, 1, 158, 1, 82, NULL, 1, '161 Kg Lak Lok, 22000 Jerteh, Terengganu', 'Jerteh', '0139287343', 'mdrazi5088@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Undang-Undang', 'IIUM', '2.83', '2005', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 2680, 'A20D016F', '961007-02-5474', '1996-10-07', 0, 2, 158, 1, 82, NULL, 1, 'No. 63 Jalan Kedidi,\nTaman Sempadan,\n14300 Nibong Tebal,\nPulau Pinang', 'Nibong Tebal', '0183604574', 'amirahamni7@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.54', '2020', 202020211, '2020', '2020-10-22', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 2681, 'A20D032F', '970530-02-5035', '1997-05-30', 0, 2, 158, 1, 82, NULL, 1, '47 Villa Nasibah, Jalan Indah 6, Taman Jitra Indah, 06000 Jitra, Kedah', 'Jitra', '013-5829885', 'ayyubabrahman97@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.32', '2020', 202020211, '2020', '2020-11-02', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 2682, 'A20D037F', '890209-03-5149', '1989-02-09', 0, 2, 158, 1, 82, NULL, 1, 'A-1 Taman Sri Pauh,\n18400 Temangan, Kelantan', 'Temangan', '0145150187', 'zulfaris99@gmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Sains Komputer (Kejuruteraan Perisian)', 'UMP', '3.17', '2012', 202020211, '2020', '2020-11-03', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 2683, 'A20D035P', '760829-71-5051', '1976-08-29', 0, 1, 158, 1, 82, NULL, 2, 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0124083344', 'ashrof.shamsuddin@lth.gov.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan Perniagaan', 'UUM', '3.06', '2009', 202020211, '2020', '2020-11-05', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 2684, 'A20D038P', '891027-14-5720', '1989-10-27', 0, 1, 158, 1, 82, NULL, 2, 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0193747197', 'zatierahman@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda (Kepujian) Perakaunan', 'UiTM', '2.82', '2012', 202020211, '2020', '2020-11-05', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 2685, 'A20D040F', '750802-03-5823', '1975-08-02', 0, 1, 158, 1, 82, NULL, 1, 'Pondok Pengkalan Machang To\' Uban, 17050 Pasir Mas, Kelantan', 'Pasir Mas', '0193803804', 'haszlihisham@jkptg.gov.my', 1, 1, 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UKM', '2.4', '1999', 202020211, '2020', '2020-11-10', 'Pembiayaan Sendiri', 2, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 2686, 'A20D041P', '770818-02-5660', '1977-08-18', 0, 1, 158, 1, 82, NULL, 1, 'No 1. Taman Sri Pelangi , 06000 Jitra, Kedah', 'Jitra', '0194171177', 'nhhasnita@hotmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Pengurusan Perniagaan', 'UUM', '2.67', '2009', 202020211, '2020', '2020-11-10', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 2687, 'A20D043P', '961203-08-5562', '1996-12-03', 0, 2, 158, 1, 81, NULL, 2, 'No. 15, Jalan JH 2, Taman Jana Harmoni,\n34600 Kamunting, \nPerak', 'Kamunting, Perak', '017-7164136', 'tharshini5562@gmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Keusahawanan (Peruncitan)', 'UMK', '2.93', '2020', 202020211, '2020', '2020-11-29', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 2688, 'A20D042F', '950416-14-5684', '1995-04-16', 0, 2, 158, 1, 82, NULL, 1, 'Lot 1005 Kampung Chempaka, \n Jalan Panji \n 16100 Kota Bharu,\n Kelantan', 'Kota Bharu', '014-5281445', 'lcr_13@yahoo.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.09', '2020', 202020211, '2020', '2020-12-13', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 2689, 'A20D036F', '940716-02-5001', '1994-07-16', 0, 1, 158, 1, 82, NULL, 1, 'Hadapan Sek. keb. Padang Perahu,\nJalan Kodiang,\n06000 Jitra,\nKedah', 'Jitra, Kedah', '013-4667690', 'fadzlul94@gmail.com', 1, 1, 'Sarjana Muda:\nBachelor of Business Administration (Islamic Banking and Finance)', 'UMK', '3.61', '2017', 202020211, '2020', '2021-02-02', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 2690, 'A20D049F', '911007-11-5810', '1991-10-07', 0, 2, 158, 1, 81, NULL, 1, 'Lot PT 794 435A Kampung Kubang Kura 20050, Kuala Terengganu', 'Kuala Terengganu', '010-4425800', 'majidatulkamalia@yahoo.com', 1, 1, 'Sarjana Muda: Undang-Undang dengan Kepujian', 'UUM', '2.8', '2015', 202020212, '2020', '2021-03-14', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 2691, 'A20D051F\n', '950603-03-6192', '1995-06-03', 0, 2, 158, 1, 82, NULL, 1, 'PT 2050, Jalan Wira 1 KM40 Jalan Kuala Krai, 18500 Machang Kelantan ', 'Machang', '019-9445267', 'farahnabila950603@gmail.com\n', 1, 1, 'Iajazah Sarjana Muda Pentadbiran Perniagaan (Perbangkan dan Kewangan Islam) Dengan Kepujian', '', '3.81', '2020', 202020212, '2020', '2021-03-16', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 2692, 'A20D047F', 'BK4855272', '1993-09-19', 0, 2, 178, 2, 81, NULL, 1, 'House: 11 Street: 20, MVHS, B17', 'Islamabad', '9.23336E+11', 'm_kasim@hotmail.com', 1, 1, 'Bachelor Of Entrepreneurship (Hospitality) With Honours', '', '3.17', '2017', 202020212, '2020', '2021-03-25', 'Pembiayaan Sendiri', 1, 2, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 2702, 'A10E006P', '771020-03-6314', '1977-10-20', 0, 2, 158, 1, 85, NULL, 2, 'Lot 2795, Kg Wakaf Kuchelong, Jelawat, 16070 Bachok, Kelantan.', 'Bachok', '012-9621481 ', 'su_achik@yahoo.com', 1, 4, ' Universiti Tun Abdul Razak', ' Bachelor of Business Adm', NULL, NULL, 201020112, '2011', '1970-01-01', '1. Tajaan MyPhD. 3 Jan 2011 hingga 2 Jan 2014 (37 bulan). , 2. Pembiayaan sendiri.', 18, 2, 1, NULL, NULL, NULL, ' Sarjana Pentadbiran', 'Universiti Teknologi Mara', '3.28', NULL, 'DOK'),
(50, 2703, 'A12E005F', '730223-03-5409', '1973-02-23', 1, 2, 158, 1, 85, NULL, 2, 'PT 381 Taman Jaya Setia, Badang Pantai Cahaya Bulan, 15350 Kota Bharu, Kelantan.', 'Kota Bharu', '017-9003685 ', 'akram@skm.gov.my', 1, 4, '', '', NULL, NULL, 201220131, '2012', '1970-01-01', '1. Tajaan JPA 9 Sept 2012 - 8 Sept 2015 ( 36 Bln), 2. Pembiayaan sendiri', 18, 2, 1, NULL, NULL, NULL, ' MBA ', 'Universiti Kebangsaan Malaysia ', '3.33', NULL, 'DOK'),
(51, 2582, 'A12E014F', '870128-03-5384', '1987-01-28', 0, 2, 158, 1, 85, NULL, 2, 'B-573 Jalan Kubor, 17500 Tanah Merah, Kelantan.', 'Tanah Merah', '014-2229447', 'nickfatiha@gmail.com', 1, 4, ' Universiti Putra Malaysia ', ' Sarjana Muda ', NULL, NULL, 201220131, '2012', '1970-01-01', '1. Tajaan MYpHd. 1 Feb 2013 hingga 31 Julai 2015 (30 bulan) , 2. Pembiayaan sendiri', 18, 2, 1, NULL, NULL, NULL, 'Master Of economics', 'Universiti Putra Malaysia', '3.36', NULL, 'DOK'),
(52, 2704, 'A12E021F', '871215-03-5416', '1987-12-15', 0, 2, 158, 1, 85, NULL, 2, 'Lot 3148 Taman Sri Setia, Jalan Padang Tembak,16100 Kota Bharu Kelantan', 'Kota Bharu', '013-2927321', 'ctaini87@gmail.com', 1, 4, '', '', NULL, NULL, 201220132, '2013', '1970-01-01', '1. Tajaan MyPhD. 1 Mac 2013 hingga 29 Feb 2016 (36 bulan), 2. Pembiayaan sendiri', 16, 2, 1, NULL, NULL, NULL, 'MBA', 'Universii Putra Malaysia', '3.27', NULL, 'DOK'),
(53, 2705, 'A12E019F', '700617-03-5287', '1970-06-17', 1, 2, 158, 1, 85, NULL, 2, '4483-F Lorong Nyior, Chabang Jalan Hospital, 15400 Kota Bharu, Kelantan', 'Kota Bharu', '013-9909779', 'mosi9779@gmail.com', 1, 4, '', '', NULL, NULL, 201220132, '2013', '1970-01-01', '1. Biasiswaz HLP (3 Mac 2013 - 2 Sept 2016), 2. Pembiayaan sendiri', 17, 2, 1, NULL, NULL, NULL, 'MBA', 'Universiti Utara Malaysia', '3.36', NULL, 'DOK'),
(54, 2706, 'A13E002F', '850429-03-5806', '1985-04-29', 0, 2, 158, 1, 85, NULL, 2, 'F-61 Perumahan Kusial Bharu, 17500 Tanah Merah, Kelantan.', 'Tanah Merah', '017-7711282', 'tinizaini@ymail.com', 1, 4, '', '', NULL, NULL, 201320141, '2013', '1970-01-01', '1. Tajaan MyPhD 3/2/2014 - 2/8/2016 (30bln), 2. Pembiayaan sendiri', 15, 2, 1, NULL, NULL, NULL, ' Master of Science (Human Resource Development ) ', 'UNIVERSITI TEKNOLOGI MALAYSIA ', '3.57', '2010', 'DOK'),
(55, 2707, 'A14E010F', '871207-03-5256', '1987-12-07', 0, 2, 158, 1, 85, NULL, 2, 'Teratak Impian, Depan SK Kandis, 16310 Bachok, Kelantan.', 'Bachok', '017-3534877', 'shuhadashaupi@gmail.com', 1, 4, '', '', NULL, NULL, 201420151, '2014', '1970-01-01', '1. Yuran tajaan MYPHD 2 Feb 2015-1 Ogos 2017 (30 bln), 2. Pembiayaan sendiri', 12, 2, 1, NULL, NULL, NULL, ' Master of Economics ', 'Universiti Malaya ', '3.25', '2013', 'DOK'),
(56, 2708, 'A14E017F', '831114-03-5242', '1983-11-14', 0, 2, 158, 1, 85, NULL, 2, 'Lot 852, Lrg Surau Kg. Banggol, 15350 Jln PCB, Kota Bharu, Kelantan.', 'Kota Bharu', '013-3077641', 'nik_waniey@yahoo.com', 1, 4, '', '', NULL, NULL, 201420152, '2015', '1970-01-01', '1. TAJAAN MYPHD 1 SEPT 2015- 28 FEB 2018 (30 BULAN), 2. Pembiayaan sendiri', 14, 2, 1, NULL, NULL, NULL, ' Master of Quantitative Sciences ', 'UiTM Shah Alam ', '3.42', '2011', 'DOK'),
(57, 2709, 'A14E019F', '850426-03-5210', '1985-04-26', 0, 2, 158, 1, 85, NULL, 2, 'Lot 213, Kampung Kijang, Jalan PCB, 15350 Kota Bharu, Kelantan.', 'Kota Bharu', '010-9313987', 'azianis1309@gmail.com', 1, 4, ' Bachelor of Arts (Hons) in Administrative Management ', 'KLMUC ', NULL, NULL, 201420152, '2015', '1970-01-01', '1. TAJAAN MYPHD 2 MAC 2015-1 MAC 2018(36 BULAN), 2. PEMBIAYAAN SENDIRI', 14, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(58, 2710, 'A14E025F', '730921-03-5211', '1973-09-21', 1, 2, 158, 1, 85, NULL, 2, 'PT 1249, Kg. Anak Sungai, Jalan Pengkalan Chepa, 16100 Kota Bharu, Kelantan.', 'Kota Bharu', '013-9321087', '9088sham@gmail.com', 1, 4, '', '', NULL, NULL, 201420152, '2015', '1970-01-01', '1. TAJAAN MYPHD 2 MAC 2015-1 MAC 2018 (36 BULAN), 2. Pembiayaan sendiri', 12, 2, 1, NULL, NULL, NULL, ' Master Pengurusan (Pengurusan Am) ', 'UPM ', '3.292', '2001', 'DOK'),
(59, 2711, 'A15E007P', '760606-03-5235', '1976-06-06', 1, 2, 158, 1, 85, NULL, 2, 'PT 506\nKg Gong Tengah\nBatu 6, Sabak\n16100 Kota Bharu\nKelantan\n(019-9646459)', 'PT 506\nKg Gong T', '019-9646459', 'kelisakuning@yahoo.com', 1, 4, '', '', NULL, NULL, 201520161, '2015', '1970-01-01', 'Pembiayaan Sendiri', 13, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(60, 2712, 'A15E009P', '700319-03-5107', '1970-03-19', 1, 2, 158, 1, 85, NULL, 2, '195 Belakang SBJ Putra\nPasir Pekan\n16250 Wakaf Bharu\nKelantan\n(013-9201597)', '195 Belakang SBJ', '013-9201597', 'wmfarid@iab.edu.my', 1, 4, ' BBA', 'UUM', NULL, NULL, 201520161, '2015', '1970-01-01', 'Hadiah Latihan Persekutuan 13.9.2015 hingga 12.9.2020 (60 bulan)', 13, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(61, 2713, 'A15E010P', '800719-05-5279', '1980-07-19', 1, 2, 158, 1, 85, NULL, 2, 'PT200 Lorong Masjid Mustaqim\nOff Jln Long Yunus\n15000 Kota Bharu\nKelantan\n(019-9571007)', 'PT200 Lorong Mas', '019-9571007', 'mhilal@pnb.com.my', 1, 4, '', '3.84', NULL, NULL, 201520161, '2015', '1970-01-01', 'Pembiayaan Sendiri', 13, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(62, 2714, 'A15D023F', '921007-03-6230', '1992-10-07', 0, 2, 158, 1, 84, NULL, 2, 'Siti Nadiah binti Abdul Mutalib \nKg Bechah Kelubi\nChetok\n17060 Pasir Mas \nKelantan\n014-53', 'Siti Nadiah bint', '014-5398768', 'sitinadiah710@gmail.com', 1, 4, 'Sarjana Muda Pentadbiran Muamalat', '', NULL, NULL, 201520162, '2016', '1970-01-01', 'Pembiayaan sendiri', 9, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(63, 2715, 'C14E008P', '800412-03-5644', '1980-04-12', 0, 2, 158, 1, 85, NULL, 2, 'PT 267, Lorong SK Bunut Payung, 15100 Kota Bharu, Kelantan.', 'PT 267, Lorong S', '019-2111980', 'aryani.a@umk.edu.my', 1, 4, ' Sarjana Pendidikan Sains dengan Teknologi Komunikasi dan Maklumat ', 'Universiti Malaya ', NULL, NULL, 201420152, '2015', '1970-01-01', 'TAJAAN MYPHD 2 MAC 2015- 1 MAC 2019 (48 BULAN)', 13, 2, 1, NULL, NULL, NULL, '', '', '', '2011', 'DOK'),
(64, 2716, 'A16D025P', '800719-03-5286', '1980-07-19', 0, 2, 158, 1, 84, NULL, 2, 'Salini Aina binti Mamat\nLot 6307 Taman Hj Ali\nTelong Mukim Kandis\n16300 Bachok\nKelantan\n0', 'Salini Aina bint', '019-2488697', 'aina800719@gmail.com', 5, 4, 'Sarjana Muda Teknologi Maklumat', '', NULL, NULL, 201620171, '2016', '1970-01-01', 'pembiayaan sendiri', 10, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(65, 2717, 'A16E004P', '820509-02-5387', '1982-05-09', 1, 2, 158, 1, 85, NULL, 2, 'Hasannuddiin bin Hassan\nPT 824 Lorong 27\nTaman Kurnia Jaya\nPengkalan Chepa\n16100 Kota Bha', 'Hasannuddiin bin', '019-5748259', 'hasann@umk.edu.my', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', '', 11, 2, 1, NULL, NULL, NULL, 'Sarjana Pengurusan', '', '', NULL, 'DOK'),
(66, 2718, 'A16E030F', '900910-03-6787', '1990-09-10', 1, 2, 158, 1, 85, NULL, 1, 'Muhamad Nikmatullah Ajwad bin Adnan\nLot 1279 Taman Kobena\n16800 Pasir Puteh\nKelantan\n014-', 'Muhamad Nikmatul', '014-5442608', 'nikmatullah_182@yahoo.com', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', '', 10, 2, 1, NULL, NULL, NULL, 'Sarjana Keusahawanan', 'UKM', '', '2016', 'DOK'),
(67, 2719, 'A16E001F', '870326-29-5224', '1987-03-26', 0, 2, 158, 1, 85, NULL, 2, 'Nur Ain binti Mohd Yusoff\nLot 1674 Kampung Pauh Lima\n16390 Bachok\nKelantan\n013-9282687', 'Nur Ain binti Mo', '013-9282687', 'nurain2687@gmail.com', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', 'pembiayaan sendiri', 8, 2, 1, NULL, NULL, NULL, 'MBA', '', '', NULL, 'DOK'),
(68, 2720, 'A16E026F', '810502-10-5270', '1981-05-02', 0, 2, 158, 1, 85, NULL, 2, 'Shahaliza binti Muhammad\nNo. 506 Kg Bukit Tanah\nPeringat\n16400 Kota Bharu\nKelantan\n011-39', 'Shahaliza binti ', '011-39150705', 'lisha676@gmail.com', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', 'pembiayaan sendiri', 9, 2, 1, NULL, NULL, NULL, 'Sarjana Sains Pengurusan Maklumat', '', '', NULL, 'DOK'),
(69, 2721, 'A16E038F', '900906-11-5378', '1990-09-06', 0, 2, 158, 1, 85, NULL, 1, 'Siti Norasyikin binti Abdul Rahman\nNo. 76 Felda Jerangau Barat\n21820 Ajil\nTerengganu\n013-', 'Siti Norasyikin ', '013-9078371', 'umk_syikin90@yahoo.com', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', 'pembiayaan sendiri', 11, 2, 1, NULL, NULL, NULL, 'MBA ', '', '', NULL, 'DOK'),
(70, 2722, 'A16E037F', '901007-07-5186', '1990-10-07', 0, 2, 158, 1, 85, NULL, 1, 'Thuraisyah binti Jaafar\n485 Lorong Meranti \nTaman Bersatu\n09000 Kulim\nKedah\n019-5160311', 'Thuraisyah binti', '019-5160311', 'aisyah_green90@yahoo.com', 5, 4, '', '', NULL, NULL, 201620171, '2016', '1970-01-01', 'pembiayaan sendiri', 10, 2, 1, NULL, NULL, NULL, 'MBA ', '', '', NULL, 'DOK'),
(71, 2723, 'A15E029F', '830720-03-5643', '1983-07-20', 1, 2, 158, 1, 85, NULL, 2, 'Zul Karami bin Che Musa\nLot 1068 Kg Telok Kemunting\nPauh Sembilan\n16020 Bachok\nKelantan\n0', 'Zul Karami bin C', '013-3671531\n', 'zul@umk.edu.my', 5, 4, '', '', NULL, NULL, 201520162, '2016', '1970-01-01', 'pembiayaan sendiri', 10, 2, 1, NULL, NULL, NULL, 'Master Of Accounting', '', '', NULL, 'DOK'),
(72, 2724, 'A16E069P', '740530-03-6128', '1974-05-30', 0, 2, 158, 1, 85, NULL, 2, 'Mimi Zazira binti Hashim@Hussein\nBahagian Akademik\nUiTM Kampus Machang\n18500 Machang\nKela', 'Mimi Zazira bint', '010-9146682', 'mihas7292@gmail.com', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'pembiayaan sendiri', 9, 2, 1, NULL, NULL, NULL, 'M Sc (IT) ', '', '', NULL, 'DOK'),
(73, 2725, 'A16E081P', '821120-03-5282', '1982-11-20', 0, 2, 158, 1, 85, NULL, 2, 'Norrini binti Muhammad\nLot 585 Kg Banggol\nJalan PCB\n15350 Kota Bharu\nKelantan', 'Norrini binti Mu', '012-2952994', 'norri5282@uitm.edu.my', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'pembiayaan Sendiri', 9, 2, 1, NULL, NULL, NULL, 'Master In Office System Management', '', '', NULL, 'DOK'),
(74, 2726, 'A16E043F', '860128-29-5822', '1986-01-28', 0, 2, 158, 1, 85, NULL, 1, 'Siti Salwani binti Abdullah\nLot 251 Kg Tok Mekong\n16100 Kota Bharu\nKelantan\n013-9812801', 'Siti Salwani bin', '013-9812801', 'salwani.a@umk.edu.my', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'TAJAAN SLAB,  (01 SEPT 2017 - 31 OGOS 2020) 36 BULAN', 9, 2, 1, NULL, NULL, NULL, 'Msc. Finance ', '', '', NULL, 'DOK'),
(75, 2727, 'A16E050F', '850903-14-5114', '1985-09-03', 0, 2, 158, 1, 85, NULL, 2, 'Syaida Fauziatul Hana Binti Yahya\n1-5-3 Pangsapuri Perdana\nJalan Lompat Pagar 13/37\n40100', 'Syaida Fauziatul', '012-3529838', 'syaida.fh@gmail.com', 5, 4, 'Bachelor In E-Commerce (Hons)', ' Universiti Malaysia Saba', NULL, NULL, 201620172, '2017', '1970-01-01', 'pembiayaan sendiri', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(76, 2728, 'A16E032P', '760821-03-5764', '1976-08-21', 0, 2, 158, 1, 85, NULL, 1, 'Siti Arnizan binti Mat Rifim\nNo 139, Jln TKC 3/10, FASA 4, Taman Kota Cheras, 43200 Chera', 'Siti Arnizan bin', '019-3102378', 'sitiarnizan@gmail.com', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'pembiayaan sendiri', 9, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(77, 2729, 'A16E033P', '870529-06-5752', '1987-05-29', 0, 2, 158, 1, 85, NULL, 1, 'Norhayati Wahib\nVilla Sri Tanjung\nPaloh Hinai, Mukim Lepar\n26650 Pekan \nPahang\n013-358457', 'Norhayati Wahib\n', '013-3584575', 'hayati_w@gapps.kptm.edu.my', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'Pembiayaan Sendiri', 9, 2, 1, NULL, NULL, NULL, 'MBA ', '', '', NULL, 'DOK'),
(78, 2730, 'A16E045F', '850815-03-5556', '1985-08-15', 0, 2, 158, 1, 85, NULL, 2, 'Nik Noor Leeyana binti Kamaruddin PT1705 Kg Tasik,\nSelinsing\n16800 Pasir Puteh\nKelantan\n0', 'Nik Noor Leeyana', '017-9719985', 'niknoorleeyanakamaruddin@gmail.co', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'Pembiayaan sendiri', 7, 2, 1, NULL, NULL, NULL, 'MBA', '', '', NULL, 'DOK'),
(79, 2731, 'A16E062F', '870414-08-5681', '1987-04-14', 1, 2, 158, 1, 85, NULL, 2, 'Rajennd S/O Muniandy\nNo. 51 Taman Zahari Zabidi\n36000 Teluk Intan \nPerak', 'Rajennd S/O Muni', '016-5465517', 'rajennd_57@yahoo.com', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, 'Master Of Ent', '', '', NULL, 'DOK'),
(80, 2569, 'A16D100F', '920703-12-6374', '1992-07-03', 0, 2, 158, 1, 84, NULL, 2, 'Graceshealde Rechard\nLadang Mills Sdn. Bhd. \nP.O Box 112\n90701 Sandakan \nSabah', 'Graceshealde Rec', '014-8573877', 'graceshealdarechard@yahoo.com', 5, 4, '', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'Pembiayaan Sendiri/ PTPTN', 9, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(81, 2732, 'A16D076F', '920419-03-5870', '1992-04-19', 0, 2, 158, 1, 84, NULL, 1, 'Pt 531, Batu 13, Jln Kuala Krai, Ketereh, 16450 Kota Bharu, Kelantan', 'Pt 531, Batu 13,', '014-5165026', 'nurulnajida@gmail.com', 5, 4, 'Sarjana Muda Pengurusan Muamalat', '', NULL, NULL, 201620172, '2017', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(82, 2576, 'P15F002F', '780831-04-5366', '1978-08-31', 0, 2, 158, 1, 85, NULL, 2, '02-02-09 BLOK 2 VISTA ANGKASA KAMPUNG KERINCHI 59200 KUALA LUMPUR', '02-02-09 BLOK 2 ', '013-3810130', 'nurz318@yahoo.com', 1, 4, 'BACHELOR OF BUSINESS ADMINISTRATION MARKETING ', 'UITM', NULL, NULL, 201420152, '2015', '1970-01-01', 'Pembiayaan sendiri', 11, 2, 1, NULL, NULL, NULL, 'MASTER OF BUSINESS ADMINISTRATION', 'UUM', '3.5', NULL, 'DOK'),
(83, 2733, 'P14E011P', '690320-01-6222', '2069-03-20', 0, 2, 158, 1, 85, NULL, 2, 'NO 13 JALAN SERI MUKA 36/27B TAMAN MENEGON INDAH SEK 36 40470 SHAH ALAM SELANGOR', 'NO 13 JALAN SERI', '012-3761722', 'gni.mktg@gmail.com', 1, 4, 'EXECUTIVE MASTER IN MANAGEMENT (MBA)', ' ASIA E UNIVERSITY KL', NULL, NULL, 201520161, '2015', '1970-01-01', 'Pembiayaan sendiri', 12, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(84, 2562, 'P14E018P', '781109-11-5130', '1978-11-09', 0, 2, 158, 1, 85, NULL, 2, 'NO 32 JLN USJ 4/1L SUBANG JAYA 47620 SELANGOR', 'NO 32 JLN USJ 4/', '017-6951820', 'misslilianty@live.com', 1, 4, 'BBA FINANCE', ' MULTIMEDIA UNIVERSITY', NULL, NULL, 201520162, '2016', '1970-01-01', '1. Mybrain , (MYPHD 02/09/2014-01/03/2018), 2. PEMBIAYAAN SENDIRI', 9, 2, 1, NULL, NULL, NULL, 'MASTER CHARTERED ISLAMIC FINANCE PROFESSIONAL (CIFP)', '', '2.9', NULL, 'DOK'),
(85, 2734, 'P15F103F', '650227-05-5394', '2065-02-27', 0, 2, 158, 1, 85, NULL, 2, '475-J JLN KENANGA 1/14, TMN KENANGA SEKSYEN 1,LORONG PANDAN, 75200 MELAKA.', '475-J JLN KENANG', '019-6657334', 'kamaryatikamaruddin@gmail.com', 1, 4, 'BACHELOR IN INTERNATIONAL BUSINESS', 'MULTIMEDIA UNIVERSITY', NULL, NULL, 201520161, '2015', '1970-01-01', 'Mybrain , (Data MGSEB Pembiayaan Sendiri), MyPhD (2 Feb 2015 - 1 Aug 2017)', 11, 2, 1, NULL, NULL, NULL, 'MBA ', 'MULTIMEDIA UNIVERSITY', '3.04', NULL, 'DOK'),
(86, 2577, 'P15F120F', '770517-03-6788', '1977-05-17', 0, 2, 158, 1, 85, NULL, 2, '22, PERSIARAN MAKMUR, DESA MAKMUR SG. MERAB, 43000 KAJANG SELANGOR', '22, PERSIARAN MA', '012- 919 381', 'samihah.ahmed@mtdc.com.my', 1, 4, 'BACHELOR SCIENCE BIOINDUSTRI', ' UPM', NULL, NULL, 201520161, '2015', '1970-01-01', 'TAJAAN MTDC', 11, 2, 1, NULL, NULL, NULL, 'MBA', 'UMK', '3.92', NULL, 'DOK'),
(87, 2735, 'P15F125F', '850317-03-5510', '1985-03-17', 0, 2, 158, 1, 85, NULL, 1, 'LOT 143, SEC 65, BT 41/4 LORONG WAKAF ZAIN, KG KOTA,JALAN SALOR,15100 KOTA BHARU,KELANTAN', 'LOT 143, SEC 65,', '013-3728033', 'nfadiahmz@gmail.com', 1, 4, 'BACHELOR OF MECHANICAL-AUTOMOTIVE ENGINEERING', '', NULL, NULL, 201520162, '2016', '1970-01-01', '1. MYPHD (2 FEB 2016 - 1 OGOS 2018) 30 BULAN, 2. Pembiayaan sendiri', 10, 2, 1, NULL, NULL, NULL, 'SARJANA KEUSAHAWANAN BIDANG PENGURUSAN', ' UMK', '', NULL, 'DOK'),
(88, 2736, 'P15F124F', '860902-29-5574', '1986-09-02', 0, 2, 158, 1, 85, NULL, 2, 'Alamat pd 26022020: \nLot 657-A, Kampung Tapang\nJalan Tapang\n15200 Kota Bharu, Kelantan.\n\n', 'Alamat pd 260220', '019-4423236', 'honestgirlz_86@yahoo.com.my', 1, 4, 'BACHELOR OF ECONOMICS ', 'UUM', NULL, NULL, 201520162, '2016', '1970-01-01', 'Tajaan Myphd (2 Feb 2016 - 1 Feb 2019) 36 bulan', 11, 2, 1, NULL, NULL, NULL, 'MASTER OF BUSINESS ADMINISTRATION ', 'UMK', '3.65', NULL, 'DOK'),
(89, 2737, 'P14E019P', '510913-13-5533', '2051-09-13', 1, 1, 158, 1, 85, NULL, 2, 'NO. 7A TAMAN SRI SENA, JALAN SEMARING PETRA JAYA, 93060 KUCHING, SARAWAK.', 'NO. 7A TAMAN SRI', '012-8983366', 'talibzu@gmail.co', 1, 4, '', 'MASTER OF COMMERCE & ADMI', NULL, NULL, 201420152, '2015', '1970-01-01', 'Pembiayaan sendiri', 12, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(90, 2738, 'A17E003F', '901118-03-5742', '1990-11-18', 0, 2, 158, 1, 85, NULL, 1, 'Lot 524-G Lorong Langgar Muda\nJalan Long Yunus\n15200 Kota Bharu\nKelantan', 'Lot 524-G Lorong', '014-5221622', 'apelathzhyrahz@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, 'Sarjana Pentadbiran Perniagaan', 'Universiti Malaysia Terengganu', '3.78', '2016', 'DOK'),
(91, 2739, 'A17E013P', '880608-29-5176', '1988-06-08', 0, 2, 158, 1, 85, NULL, 2, 'PT391 Seksyen 1\nKg. Penambang\n15350 Kota Bharu\nKelantan', 'PT391 Seksyen 1\n', '013-9973524', 'hazninaainihassan@yahoo.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, 'Sarjana Pentadbiran Perniagaan (MBA)', 'UMK', '3.85', '2016', 'DOK'),
(92, 2740, 'A17E014F', '920914-03-5982', '1992-09-14', 0, 2, 158, 1, 85, NULL, 1, 'No 22 Sri Tualang Bunut Susu\n17020 Pasir Mas\nKelantan', 'No 22 Sri Tualan', '013-3788925', 'nursairazi@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', 'Pembiayaan Sendiri', 9, 2, 1, NULL, NULL, NULL, 'Sarjana Perakuanan', 'UiTM', '3.64', '2016', 'DOK'),
(93, 2741, 'P15E051P', '811012-01-5904', '1981-10-12', 0, 2, 158, 1, 85, NULL, 2, 'NO.8 JALAN P11 F/3 PRESINT 11 62300 PUTRAJAYA SELANGOR', 'NO.8 JALAN P11 F', '012-6229588', 'umiekawe12@yahoo.com.my', 1, 4, ' DEGREE BBA', 'UNIVERSITI MALAYA', NULL, NULL, 201520161, '2015', '1970-01-01', 'Mybrain , (Data MGSEB Pembiayaan Sendiri), MyPhD (1 Sept 2015 - 28 Feb 2019)', 11, 2, 1, NULL, NULL, NULL, 'MBA', 'UITM', '3.13', NULL, 'DOK'),
(94, 2742, 'A16E042F', '870607-03-5082', '1987-06-07', 0, 2, 158, 1, 85, NULL, 1, 'Siti Zamanira binti Mat Zaib\nLot 789 Lorong Klinik Bidan\nKg Pauh Sembilan\n16150 Kota Bhar', 'Siti Zamanira bi', '014-8443018', 'zamanira@umk.edu.my', 1, 4, ' USIM', 'Sarjana Pentadbiran Muama', NULL, NULL, 201720181, '2017', '1970-01-01', 'SLAB (19 Sept 2017 - 18 Mac 2020) 42 Bulan', 9, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(95, 2743, 'A17E012F', '850512-03-5348', '1985-05-12', 0, 2, 158, 1, 85, NULL, 2, 'LOT 1556, KG BANIR BELIKONG\nSELISING\n16810 PASIR PUTEH\nKELANTAN', 'LOT 1556, KG BAN', '013-3671183', 'tarmidahsoni@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, 'MBA', 'UMK', '3.8', '2016', 'DOK'),
(96, 2744, 'A17E016F', '760728-02-6134', '1976-07-28', 0, 2, 158, 1, 85, NULL, 1, 'No 40 Jalan Desa 2/10\nBandar Country Home 48000 Rawang\nSelangor', 'No 40 Jalan Desa', '019-3898600', 'salwatihassan76@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, 'SARJANA PENDIDIKAN PERNIAGAAN DAN KEUSAHAWANAN', 'UKM', '3.67', '2008', 'DOK'),
(97, 2745, 'A17E018F', '901103-43-5444', '1990-11-03', 0, 2, 158, 1, 85, NULL, 1, 'PT 1427, Jalan Guchil Bayam\nTeluk Bharu\n15200 Kota Bharu\nKelantan', 'PT 1427, Jalan G', '012-9842000', 'erfanatasha@umk.edu.my', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', '', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(98, 2746, 'A17E021P', '820807-03-5225', '1982-08-07', 1, 2, 158, 1, 85, NULL, 2, 'Lot 531-A Teratak Damai\nKampung Telosan\n16800 Pasir Puteh\nKelantan', 'Lot 531-A Terata', '012-9892447', 'mahathir.m@umk.edu.my', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', '', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(99, 2747, 'A17D022F', '940521-03-5752', '1994-05-21', 0, 2, 158, 1, 84, NULL, 2, 'Depan Pondok Darul Hanan\nKg. Selehor Palekbang\n16040 Tumpat\nKelantan', 'Depan Pondok Dar', '016-9222105', 'syiramarzuki@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', '', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(100, 2748, 'A18E017F', '821223-03-5656', '1982-12-23', 0, 2, 158, 1, 85, NULL, 2, 'Lot 30 Kampung Paloh, Peringat, 16400 Kota Bharu, Kelantan', 'Kota Bharu', '011-32763978', 'nanizzah@yahoo.com', 1, 4, '', 'Bachelor of Economics (In', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(101, 2749, 'A17E023P', '820223-01-5044', '1982-02-23', 0, 2, 158, 1, 85, NULL, 2, 'No 1 Lot 1 KM12\nKg Paya Rumput\n76450 Melaka Tengah\nMelaka', 'No 1 Lot 1 KM12\n', '010-3148401', 'emellia.ma@gmail.com', 1, 4, '', '', NULL, NULL, 201720181, '2017', '1970-01-01', '', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(102, 2750, 'A17D049F', '940626-06-5413', '1994-06-26', 1, 2, 158, 1, 84, NULL, 2, 'PT 754 Taman Lagenda Paradise\nKampung Paya Pasir \n16250 Wakaf Bharu\nKelantan', 'PT 754 Taman Lag', '017-9703157', 'shafiq.zaki38@gmail.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(103, 2566, 'A17E055F', '891204-03-5240', '1989-12-04', 0, 2, 158, 1, 85, NULL, 2, 'PT135 Desa Guru\nKampung Bechah, Tendong\n17030 Pasir Mas, Kelantan', 'PT135 Desa Guru\n', '019-5493817', 'faten_akmal@yahoo.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(104, 2751, 'A17E056P', '850813-03-5878', '1985-08-13', 0, 2, 158, 1, 85, NULL, 2, 'PT2632 Jalan Firdaus 3/45\nTaman Firdaus\n16150 Kota Bharu\nKelantan', 'PT2632 Jalan Fir', '012-9498446', 'leogirl1308@yahoo.com', 5, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(105, 2752, 'A17E036F', '860507-35-5442', '1986-05-07', 0, 2, 158, 1, 85, NULL, 1, 'PT2045, Taman Pinggiran Universiti, Mukim Repek, 16310 Bachok, Kelantan', 'PT2045, Taman Pi', '019-4750586', 'afifah7586@gmail.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'TAJAAN SLAB 1 April 2018 - 28 Feb 2021 (35 Bln)', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(106, 2753, 'A17E057F', '581020-03-5779', '2058-10-20', 1, 2, 158, 1, 85, NULL, 1, 'Lot 502 Kg. Chenderong Batu\n16250 wakaf Bharu\nKelantan', 'Lot 502 Kg. Chen', '019-9104111', 'abdsuki@gmail.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(107, 2754, 'A17E063F', '910108-03-5188', '1991-01-08', 0, 2, 158, 1, 85, NULL, 2, 'No 361 Jalan Melor, Taman Wangi, 18300 Gua Musang, Kelantan', 'No 361 Jalan Mel', '014-9668027', 'marini.razali@yahoo.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(108, 2755, 'A17E064P', '870511-29-5306', '1987-05-11', 0, 2, 158, 1, 85, NULL, 1, 'Lot 2667A Jalan Kujid 7\nPerumahan Kastam Desa Kujid II\n16100 Panji, Kota Bharu\nKelantan', 'Lot 2667A Jalan ', '014-9679600', 'lydiahidayu87@yahoo.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(109, 2589, 'A17E005F', 'BT0218085', '1985-01-01', 0, 2, 19, 2, 85, NULL, 1, 'DAG-665 Adarshaw Nagar\nMiddle Badda Gulshan Badda\n1212 Dhaka, Bangladesh', 'DAG-665 Adarshaw', '017-7673290', 'sultanaabeda@ymail.com', 1, 4, '', '', NULL, NULL, 201720182, '2018', '1970-01-01', 'Pembiayaan Sendiri', 8, 2, 1, NULL, NULL, NULL, 'Master of Business Studies, ', 'National University Gazipur, Bangladesh', '', '2006', 'DOK'),
(110, 2756, 'A17E052F', 'A02130072', '1986-11-10', 1, 1, 205, 2, 85, NULL, 1, 'Lot 2013 Taman Mutiara, Belakang Kedai Ikhwan, Jalan Pengkalan Chepa, 15400 Kota Bharu, K', 'Kota Bharu', '016-5961274', 'shamsoudine.aidara@gmail.com', 1, 4, '', 'Bachelor Degree in Applie', NULL, NULL, 201820191, '2018', '1970-01-01', 'Malaysian International Scholarship (MIS), Duration: 36 months, 26 Feb 2018 - 25 Feb 2021)', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(111, 2568, 'A18E001F', '880712-03-5948', '1988-07-12', 0, 2, 158, 1, 85, NULL, 2, '868-D Kweng Hitam, 18500 Machang, Kelantan', 'Machang', '017-9838872', 'wee88fong@gmail.com', 2, 4, '', 'Bachelor of Business Admi', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(112, 2757, 'A18E004F', '830715-14-5960', '1983-07-15', 0, 1, 158, 1, 85, NULL, 1, 'Alamat Baru: LOT 533,KG POHON BULOH, JALAN MERANTI, 17000, PASIR MAS KELANTAN.\n\nNo. 33 Ja', 'Kota Bharu', '014-3612100', 'sitisomhusin@yahoo.com.my', 1, 4, '', 'Bachelor Science (Hons) A', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(113, 2758, 'A18E014F', '741122-12-5505', '1974-11-22', 1, 1, 158, 1, 85, NULL, 1, '2093 Jalan Gedung Lalang, Batu 8, Bukit Rambai, 75250 Melaka, Melaka', 'Melaka', '011-20499895', 'syedahmadomar@gmail.com', 1, 4, '', 'Bachelor of Laws', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(114, 2759, 'A18E003F', '790406-03-5393', '1979-04-06', 1, 1, 158, 1, 85, NULL, 2, 'PT 1793, Jln Kurnia Jaya, Taman Kurnia Jaya, 1610 Kota Bharu, Kelantan', 'Kota Bharu', '019-9499704', 'farid@pkb.net.my', 1, 4, '', '2.55', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(115, 2760, 'A18E021P', '790809-08-5424', '1979-08-09', 0, 1, 158, 1, 85, NULL, 2, 'No. 19, Jalan Balakong Jaya 15, Taman Balakong Jaya, 43300 Seri Kembangan, Selangor', 'Hulu Langat', '012-6111979', 'nuzulakhtar@kuis.edu.my', 1, 4, '', 'BBA (Hons) Finance', NULL, NULL, 201820191, '2018', '1970-01-01', '', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(116, 2584, 'A18E025F', '820610-14-5906', '1982-06-10', 0, 2, 158, 1, 85, NULL, 2, 'No. 3, Jalan 3/3B, Bandar Baru Bangi, 43650 Bandar Baru Bangi, Selangor', 'Hulu Langat', '012-3768870', 'nzyusoff@gmail.com', 1, 4, '', 'Sarjana Muda Ekonomi', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(117, 2761, 'A18E024P', '840203-03-6102', '1984-02-03', 0, 1, 158, 1, 85, NULL, 2, 'Lot 4661 Kampung Hutan Rebana, 18500 Machang, Kelantan', 'Machang', '012-9852282', 'ayudiana84@gmail.com', 1, 4, '', 'Sarjana Muda Pentadbiran ', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(118, 2762, 'A17E001F', '900502-03-6032', '1990-05-02', 0, 2, 158, 1, 85, NULL, 1, 'Lot 1779 Kg. Dusun Raja\n Cempaka Panji\n 15300 Kota Bharu\n Kelantan', 'Lot 1779 Kg. Dus', '018-2594070', 'wanadiah@gmail.com', 1, 4, 'Bachelor of Islamic Finance & Banking', 'UUM', NULL, NULL, 201720181, '2017', '1970-01-01', 'Skim Zamalah (Yuran Ditanggung UMK)', 8, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(119, 2763, 'A18E022F', '760611-06-5391', '1976-06-11', 1, 1, 158, 1, 85, NULL, 1, 'No. 52, Jalan 8/27C Section 8, Bandar Baru Bangi, 43650 Selangor', 'Bangi', '010-2456300', 'syarizal.ar@umk.edu.my', 1, 4, '', 'Ijazah Sarjana Muda', NULL, NULL, 201820191, '2018', '1970-01-01', '', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(120, 2764, 'A18E002F', '870628-29-5350', '1987-06-28', 0, 1, 158, 1, 85, NULL, 1, 'Lot 1860 Jalan Baru, Kampung Wakaf Lanas, 16800 Pasir Puteh, Kelantan', 'Pasir Puteh', '014-5095388', 'eina_9330@yahoo.com', 1, 4, '', 'Sarjana Muda Perbankan Is', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(121, 2765, 'A18D020F', '950223-02-5520', '1995-02-23', 0, 2, 158, 1, 84, NULL, 1, 'Blok B7-07 APT Desa Aman 2, \nJalan PantaiMurni 6, 59200 Pantai Dalam,\n Wilayah Persekutua', 'Wilayah Persekut', '013-5269066', 'fatinkamis.fk@gmail.com', 1, 4, '', 'Ijazah Sarjana Muda Keusa', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(122, 2766, 'A18E029P', '840406-03-6196', '1984-04-06', 0, 1, 158, 1, 85, NULL, 2, 'Lot 332, Kampung Padang Taman, 16400 Melor, Kota Bharu, Kelantan', 'Kota Bharu', '019-2161918', 'hazrina.h@umk.edu.my', 1, 4, '', 'Bachelor in Business Admi', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(123, 2767, 'A18E028P', '880511-05-5272', '1988-05-11', 0, 1, 158, 1, 85, NULL, 2, 'PT 9468, Lorong Hidayah 1, Kampung Chawas, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '013-9471986', 'munirah@umk.edu.my', 1, 4, '', 'Ijazah Sarjana Muda Pengu', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK');
INSERT INTO `pg_student` (`id`, `user_id`, `matric_no`, `nric`, `date_birth`, `gender`, `marital_status`, `nationality`, `citizenship`, `program_id`, `field_id`, `study_mode`, `address`, `city`, `phone_no`, `personal_email`, `religion`, `race`, `bachelor_name`, `bachelor_university`, `bachelor_cgpa`, `bachelor_year`, `admission_semester`, `admission_year`, `admission_date`, `sponsor`, `current_sem`, `campus_id`, `status`, `remark`, `outstanding_fee`, `related_university_id`, `master_name`, `master_university`, `master_cgpa`, `master_year`, `program_code`) VALUES
(124, 2768, 'A18E023P', '870901-11-5462', '1987-09-01', 0, 1, 158, 1, 85, NULL, 2, 'Lot 1493 Belakang Masjid Tok Kenali\nKg. Pondok Tok Kenali \n16150 Kota Bharu\nKelantan', 'Kubang Kerian', '017-9796405', 'sarah804@uitm.edu.my', 1, 4, '', '', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(125, 2769, 'A18E026F', '861206-29-5962', '1986-12-06', 0, 2, 158, 1, 85, NULL, 2, 'No 404 Kampung Kelong\n16200 Tumpat Kelantan', 'Tumpat', '018-7780040', 'masitah.afandi@gmail.com', 1, 4, '', 'Sarjana Pentadbiran Perni', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(126, 2770, 'A18E027P', '841006-03-6060', '1984-10-06', 0, 1, 158, 1, 85, NULL, 2, 'No 8, Kampung Jalar, Bukit Bunga, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '011-19312962', 'rajaros6060@gmail.com', 1, 4, '', 'Sarjana Muda Pentadburan ', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(127, 2771, 'A18E032F', '911008-03-6268', '1991-10-08', 0, 2, 158, 1, 85, NULL, 1, 'No. 30 Jalan Tali Air\nKampung Lubuk Kuin\n16450 Ketereh\nKelantan', 'Ketereh', '014-8217665', 'yusmawatie55@gmail.com', 1, 4, '', 'Sarjana Pentadbiran Perni', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(128, 2772, 'A18E031F', '920909-06-5271', '1992-09-09', 1, 2, 158, 1, 85, NULL, 2, 'No. 6 Lorong 30\nPerumahan Bukit Rangin\nPermatang Badak Baru\n25150 Kuantan, Pahang', 'Kuantan', '014-7936269', 'hazeemsidik92@gmail.com', 1, 4, '', 'Master of Science in Stat', NULL, NULL, 201820191, '2018', '1970-01-01', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(129, 2773, 'A18E030F', '890104-14-5165', '1989-01-04', 1, 1, 158, 1, 85, NULL, 1, 'PT 1700 Jalan Kurnia Jaya 37\nTaman Kurnia Jaya\nPengkalan Chepa\n16100 Kota Bharu', 'Pengkalan Chepa', '010-2610296', 'fahimisofian7@gmail.com', 1, 4, '', 'Sarjana Keusahawanan dan ', NULL, NULL, 201820191, '2018', '1970-01-01', 'Tajaan SLAB, (01.09.2019 - 31.01.2022)', 7, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(130, 2774, 'A18D041F', '951130-13-5362', '1994-06-27', 0, 2, 158, 1, 84, NULL, 1, 'Lot 1972 Kg Raja Alor Bakat, Mahligai, Melor\n16400 Kota Bharu, Kelantan', 'Kota Bharu', '013-6142462', 'nurfairushamid@gmail.com', 1, 4, '', '', NULL, NULL, 201820192, '2019', '2019-02-17', 'Pembiayaan Sendiri', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(131, 2775, 'A18E010F', '930614-03-6448', '1983-03-26', 0, 2, 158, 1, 85, NULL, 1, 'Lot 638 Sek 47, Tanjung Mas\nJalan Pengkalan Chepa\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '0111-9456560', 'amnie_adnan@yahoo.com', 1, 4, '', '', NULL, NULL, 201820192, '2019', '2019-02-17', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(132, 2564, 'A18E034F', '900924-14-6194', '1985-09-27', 0, 1, 158, 1, 85, NULL, 1, 'A04-1-15 Taman Samudera Jalan Timur 7\n68100 Batu Caves, Selangor', 'Selangor', '013-4767505', 'azimahahmad24@gmail.com', 1, 4, '', '', NULL, NULL, 201820192, '2019', '2019-02-25', 'TAJAAN SLAB, (01.09.2016 - 31.01.2020)', 6, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(133, 2776, 'A18E045P', '840715-03-5488', '1992-04-27', 0, 2, 158, 1, 85, NULL, 2, '5249 A Kg. Dusun, Jalan Bayam\n15200 Kota Bharu\nKelantan', 'Kota Bharu', '013-9950325', 'farah865@uitm.edu.my', 1, 4, '', '', NULL, NULL, 201820192, '2019', '2019-02-28', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(134, 2777, 'A18E046F', '641021-07-5467', '2064-10-21', 1, 1, 158, 1, 85, NULL, 1, '85 Desa Manjung Point\n32040 Manjung\nPerak', 'Perak', '019-5774674', 'choongchinaun@gmail.com', 1, 4, '', '', NULL, NULL, 201820192, '2019', '2019-03-25', '', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(135, 2778, 'A19E009P', '791220-03-5111', '1988-03-03', 1, 1, 158, 1, 85, NULL, 1, '856 Jalan Yaakubiah\n15200 Kota Bharu\nKelantan', 'Kota Bharu', '013-9104774', 'afifie.alwi@umk.edu.my', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-03', 'TAJAAN SLAB, (1/9/2019 - 31/8/2022)', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(136, 2779, 'A19E010F', '880313-03-5772', '1988-03-03', 0, 1, 158, 1, 85, NULL, 1, 'No.4 Kampung Pak Puchuk, Ulu Sat\n18500 Machang\nKelantan', 'Machang', '012-3426773', 'hasliana.sani@gmail.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-03', 'TAJAAN SLAB, (1/9/19 - 31/8/2022)', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(137, 2780, 'A19E001F', '860716-29-5220', '1977-07-20', 0, 1, 158, 1, 85, NULL, 1, 'PT 3316 Taman Desa Kemumin\nJalan Kemumin 3, Padang Tembak\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '016-2328479', 'aiminadia.ibrahim@gmail.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-03', 'TAJAAN SLAB, (1/9/19 - 31/8/2022)', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(138, 2538, 'A19E026F', '770720-11-5473', '1995-04-15', 1, 1, 158, 1, 85, NULL, 1, 'Lot PT 1150\nKampung Batu Tiong\nKampung Pulau Serai\n23000 Dungun\nTerengganu', 'Terengganu', '019-9224512', 'wanrizal_77@yahoo.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 4, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(139, 2781, 'A19D025F', '950415-05-5310', '1989-09-16', 0, 2, 158, 1, 84, NULL, 1, 'No 4472 Jalan SJ 4/2D\nTaman Seremban Jaya\n70450 Seremban\nNegeri Sembilan', 'Negeri Sembilan', '018-9002905', 'nur.shadira@yahoo.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 4, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(140, 2782, 'A19D028F', '950623-04-5280', '1983-01-17', 0, 2, 158, 1, 84, NULL, 1, 'Lot 2052 Kampung Wakaf Jela\nJalan Sungai Rengas\n20050 Kuala Terengganu', 'Kuala Terengganu', '014-5383807', 'asymzn@gmail.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 4, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(141, 2783, 'A19E029P', '830117-03-6000', '1997-08-14', 0, 1, 158, 1, 85, NULL, 2, 'No 96 Spg 3 Sek. Keb. Kadok\n16450 Kota Bharu\nKelantan', 'Kota Bharu', '017-9780657', 'fazlirda.h@umk.edu.my', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 4, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK'),
(142, 2575, 'A19D030F', '920328-14-5900', '1994-07-10', 0, 2, 158, 1, 84, NULL, 1, 'Lot 1167 Belakang Jabatan Haiwan Batu 18\n43100 Hulu Langat\nSelangor', 'Selangor', '012-6903597', 'izzatul.a15b0681@siswa.umk.edu.my', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-09-23', 'Pembiayaan Sendiri', 4, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'SAR'),
(143, 2549, 'A19E050F', '870824-29-5294', '1987-08-24', 0, 1, 158, 1, 85, NULL, 1, 'PT 933 Kepulau\n16040 Wakaf Bharu\nKelantan', 'Wakaf Bharu', '010-4069954', 'marinarazaki@gmail.com', 1, 4, '', '', NULL, NULL, 201920201, '2019', '2019-10-31', 'Pembiayaan Sendiri', 5, 2, 1, NULL, NULL, NULL, '', '', '', NULL, 'DOK');

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_data`
--

CREATE TABLE `pg_student_data` (
  `id` int(11) NOT NULL,
  `NO_MATRIK` varchar(9) DEFAULT NULL,
  `NAMA_PELAJAR` varchar(53) DEFAULT NULL,
  `NO_IC` varchar(14) DEFAULT NULL,
  `TARIKH_LAHIR` varchar(12) DEFAULT NULL,
  `JANTINA` varchar(9) DEFAULT NULL,
  `TARAF_PERKAHWINAN` varchar(9) DEFAULT NULL,
  `NEGARA_ASAL` varchar(8) DEFAULT NULL,
  `KEWARGANEGARAAN` varchar(12) DEFAULT NULL,
  `KOD_PROGRAM` varchar(3) DEFAULT NULL,
  `TARAF_PENGAJIAN` varchar(12) DEFAULT NULL,
  `ALAMAT` varchar(89) DEFAULT NULL,
  `DAERAH` varchar(16) DEFAULT NULL,
  `NO_TELEFON` varchar(12) DEFAULT NULL,
  `EMEL_PERSONAL` varchar(33) DEFAULT NULL,
  `EMEL_PELAJAR` varchar(34) DEFAULT NULL,
  `AGAMA` varchar(5) DEFAULT NULL,
  `BANGSA` varchar(6) DEFAULT NULL,
  `NAMA_SARJANA_MUDA` varchar(104) DEFAULT NULL,
  `UNIVERSITI_SARJANA_MUDA` varchar(25) DEFAULT NULL,
  `CGPA_SARJANA_MUDA` varchar(4) DEFAULT NULL,
  `TAHUN_SARJANA_MUDA` varchar(4) DEFAULT NULL,
  `SESI_MASUK` varchar(42) DEFAULT NULL,
  `TAHUN_KEMASUKAN` varchar(4) DEFAULT NULL,
  `TARIKH_KEMASUKAN` varchar(16) DEFAULT NULL,
  `PEMBIAYAAN` varchar(18) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `SEMESTER` varchar(1) DEFAULT NULL,
  `KAMPUS` varchar(11) DEFAULT NULL,
  `STATUS` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pg_student_data`
--

INSERT INTO `pg_student_data` (`id`, `NO_MATRIK`, `NAMA_PELAJAR`, `NO_IC`, `TARIKH_LAHIR`, `JANTINA`, `TARAF_PERKAHWINAN`, `NEGARA_ASAL`, `KEWARGANEGARAAN`, `KOD_PROGRAM`, `TARAF_PENGAJIAN`, `ALAMAT`, `DAERAH`, `NO_TELEFON`, `EMEL_PERSONAL`, `EMEL_PELAJAR`, `AGAMA`, `BANGSA`, `NAMA_SARJANA_MUDA`, `UNIVERSITI_SARJANA_MUDA`, `CGPA_SARJANA_MUDA`, `TAHUN_SARJANA_MUDA`, `SESI_MASUK`, `TAHUN_KEMASUKAN`, `TARIKH_KEMASUKAN`, `PEMBIAYAAN`, `admission_date`, `SEMESTER`, `KAMPUS`, `STATUS`) VALUES
(1, 'A19D018P', 'Anis binti Zulhisam', '950210-06-5208', '2-Jun-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'No.3, Lorong Kempadang Makmur 2/1\nTaman Kempadang Makmur\n25150 Kuantan\nPahang\n', 'Pahang', '011-17899590', 'aniszulhisam95@gmail.com', 'anis.a19d018p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan (Hospitaliti)\n', 'UMK', '2.72', '2018', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(2, 'A19D022F', 'Nur Aifa Dinie Binti Mohammad Najiab @ Mohammad Najib', '950702-03-6358', '2-Jul-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', '4151 B Kampung Paya Senang\n15150 Jalan Telipot\nKota Bharu\nKelantan\n', 'Kota Bharu', '013-9206766', 'aifadinie@yahoo.com', 'dinie.a19d022f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan (Hospitaliti)\n', 'UMK', '3.07', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(3, 'A19D003F', 'Arif bin Abdul Khalik', '921005-10-5685', '5-Oct-92', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No 25 Jalan TPS 3/9\nTaman Pelangi Semenyih\n43500 Semenyih\nSelangor\n', 'Selangor', '013-4234013', 'arifabdulkhalik@gmail.com', 'arif.a19d003f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '4-Sep-19', 'Pembiayaan Sendiri', NULL, '5', 'KAMPUS KOTA', 'AKTIF'),
(4, 'A19D008F', 'Fatin Afiqah binti Mohd Shah', '920322-03-6084', '22-Mar-92', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 4129 Jalan Mahsuri\n17500 Tanah Merah\nKelantan\n', 'Tanah Merah', '019-9084590', 'fatin92shah56@gmail.com', 'afiqah.a19d008f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam) dengan Kepujian\n', 'UMK', '2.88', '2018', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(5, 'A19D016P', 'Sitina binti Yusof', '880321-62-5078', '21-Mar-88', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Separuh Masa', '680-C Jalan Pengkalan Chepa\nTanjung Mas\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '013-9235683', 'sitinayusof@gmail.com', 'sitina.a19d016p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Perakaunan\n\n', 'USIM', '2.86', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(6, 'A19D002F', 'Siti Zubaidah binti Wan Azlan', '961019-03-5602', '19-Oct-96', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 1994-A Jalan Puteri Saadong\nKampung Kota\n15100 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-9659811', 'idaazlan1910@gmail.com', 'zubaidah.a19d002f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(7, 'A19D014F', 'Siti Amileen binti Mohd Yusoff', '951102-03-6172', '2-Nov-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 910, Jalan Sabak\nKampung Tebing\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-7446609', 'amileenyusoff@gmail.com', 'amileen.a19d014f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)\n', 'UMK', '', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(8, 'A19D024F', 'Nurul Aida Sahira binti Seman', '930804-03-5518', '4-Aug-93', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 1738 Lorong Hidayah\nKampung Huda Kubang Kerian\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-14962085', 'nurulaidasahira93@gmail.com', 'aida.a19d024f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran dan Hubungan Korporat dengan Kepujian\n', 'USIM', '3.25', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(9, 'A19D007F', 'Siti Nurhanani binti Abdul Hamid', '950605-03-5046', '5-Jun-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'PT 3622 Lorong Pondok Polis Labok\nKampung Kenanga Labok\n18500 Machang\nKelantan\n', 'Machang', '010-9286585', 'sitinurhananiabdulhamid@gmail.com', 'hanani.a19d007f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Perbankan dan Kewangan Islam\n\n', 'UUM', '3.12', '2018', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '3-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(10, 'A19D033P', 'Muhammad Azim bin Abu Hassan Sha\'ari', '950107-10-5101', '7-Jan-95', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Separuh Masa', 'Pt 723 Lorong Masjid Taqwa\nPaya Bemban\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9444223', 'azimabuhassan@gmail.com', 'azim.a19d033p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '15-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(11, 'A19D032P', 'Ummu Fatihah binti Azhar', '970814-03-5980', '14-Aug-97', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Separuh Masa', 'Lot 1342 Lorong Masjid Ar-Rahman\nBandar Banchok\n16300 Bachok\nKelantan\n', 'Bachok', '011-10977357', 'ufatihah@gmail.com', 'fatihah.a19d032p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Fiqh Usul', 'Universiti Mu’tah, Jordan', '3.67', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '18-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(12, 'A19D027F', 'Mohamad Luqman Al Hakim bin Kamarul Zaman', '951016-03-6053', '16-Oct-95', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', '5156 A Kg. Sireh Bawah Lembah\n15050 Kota Bharu\nKelantan\n', 'Kota Bharu', '0111-6856768', 'luqmanhakim700@gmail.com', 'luqman.a19d027f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '18-Sep-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(13, 'A19D036F', 'Nur Khairina binti Othaman', '940710-06-5010', '10-Jul-94', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 1890 Lorong Dato’\nKampung Dusun Raja\nJalan Hospital\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-3003780', 'nurkhairina94@gmail.com', 'khairina.a19d036f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '1-Oct-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(14, 'A19D035F', 'Aimi Solehah binti Shamsul Amri', '961023-03-5576', '23-Oct-96', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'No 339 Seksyen 61\nBunut Payong\n15150 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9153389', 'aimisolehah23@gmail.com', 'solehah.a19d035f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Kejuruteraan Teknologi Kimia Bioproses\n', 'Universiti Kuala Lumpur', '2.79', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '1-Oct-19', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(15, 'A19D066P', 'Norihah binti Abdullah', '840513-11-5164', '13-May-84', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'separuh Masa', 'Lot 15012 Taman Impian Murni\nBukit Datu\n21200 Kuala Terengganu\nTerengganu\n', 'Terengganu', '013-9201788', 'norihah_abdullah@yahoo.com', 'norihah.a19d066p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan', 'USM', '2.72', '2007', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(16, 'A19D064P', 'Sharifah Fatimatuzzahra\' binti Syed Hassim', '800304-11-5276', '4-Mar-80', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'separuh Masa', 'Lot 2705 Kampung Tok Kaya\n21000 Kuala Terengganu\nTerengganu\n', 'Terengganu', '019-3824148', 'mentari1980@gmail.com', 'zahra.a19d064p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Pengurusan)', 'UKM', '2.97', '2004', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(17, 'A19D065P', 'Khairil Zuhdi bin Khairuddin', '760301-14-5935', '1-Mar-76', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'separuh Masa', 'No 3418 Lorong Seri Budiman\nKampung Mengabang Tengah\n20400 Kuala terengganu', 'Terengganu', '013-9303415', 'kerryzuedy@gmail.com', 'zuhdi.a19d065p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UPM', '3.15', '2004', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(18, 'A19D062F', 'Siti Aisah binti Ahmad Kamal', '950203-03-5908', '3-Feb-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No.2 Depan Sekolah Kebangsaan Peria\n18000 Kuala Krai\nKelantan\n', 'Kuala Krai', '017-9246893', 'sitiaisahahmadkamal31@gmail.com', 'aisah.a19d062f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.15', '2019', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(19, 'A19D061F', 'Wan Nur Atillah binti Wan Yusoff ', '960813-03-5250', '13-Aug-96', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No 72 Kampung Bukit Merbau\n16810 Pasir Puteh\nKelantan\n', 'Pasir Puteh', '012-8422300', 'nuratie9604@gmail.com', 'atillah.a19d061f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.3', '2019', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '3', 'KAMPUS KOTA', 'AKTIF'),
(20, 'A19D054F', 'Nik Nur Aishah binti Nik Abdul Aziz', '940204-03-5142', '4-Feb-94', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'Kampung Guar Gajah\nJalan Dewan Tok Bidan\n02600 Arau\nPerlis\n', 'Perlis', '011-21548914', 'nikaishah07@gmail.com', 'aishah.a19d054f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Korporat', 'UMK', '2.66', '2017', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(21, 'A19D055P', 'Noor Izzati binti Mat Nuri', '831224-03-5390', '24-Dec-83', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'Separuh Masa', 'Lot 1911 Kampung Chekok\n16600 Pulai Chondong\nKelantan\n', 'Pulai Chondong', '019-2989322', 'izzati@umk.edu.my', 'izzati.a19d055p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Sains Pengajian Maklumat', 'UiTM', '3.47', '2006', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(22, 'A19D053P', 'Nurwidad binti Azly', '891020-03-5246', '20-Oct-89', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Separuh Masa', 'Lot 1005 Kampung Chempaka\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-10898912', 'widad_sakura@yahoo.com', 'nurwidad.a19d053p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan)', 'UiTM', '2.67', '2017', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(23, 'A19D067P', 'Mohamad Nasir bin Kareem', '800702-08-5623', '2-Jul-80', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'Separuh Masa', 'E-532 (No.1921) Kampung Wakaf Peruas\nJalan Kuala Berang\n20500 Kuala Terengganu\nTerengganu', 'Kuala Terengganu', '012-4603753', 'nasir_kda@yahoo.com', 'nasir.a19d067p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Sains (Matematik)\n\nKelulusan Penilaian Rapi Kertas Kerja Edaran JPPSU', 'USM', '2.26', '2004', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '2-Mar-20', 'Pembiayaan Sendiri', NULL, '4', 'KAMPUS KOTA', 'AKTIF'),
(24, 'A20D025P', 'Nurul Fathiyah binti Zakaria', '950813-03-6350', '13-Aug-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 4144, Jalan Dusun Pinang, Kampung Banggol Kemunting, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '0177310053', 'nurulfathiyahzakaria@yahoo.com', 'fathiyah.a20d025p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.26', '2018', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '6-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(25, 'A20D019F', 'Wan Ahmad Salihan bin Wan Mohd Zaki', '950213-03-6269', '13-Feb-95', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'penuh Masa', 'Lot 812, Jalan Masjid Baung Bayam, 15200 Kota Bharu, Kelantan', 'Kota Bharu', '0192454169', 'salihanzak13@gmail.com', 'salihan.a20d019f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan dengan Kepujian', 'UMK', '2.89', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '6-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(26, 'A20D024F', 'Nur Izaty binti Ibrahim', '970917-03-5692', '17-Sept-97', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'penuh Masa', 'No. 4176-H, Lorong Che Majid, 15050 Kota Bharu, Kelantan', 'Kota Bharu', '01128324284', 'izaty970917@gmail.com', 'izzaty.a20d024f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan dan Perbankan Islam)', 'UMK', '3.39', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '8-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(27, 'A20D004F', 'Nur Aina Basyira binti Zakaria', '950513-03-5102', '13-May-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'Lot 2387, Taman Paduka, Kubang Kerian, 16150 Kota Bharu, Kelantan', 'Kota Bharu', '01115656486', 'nurainabasyira@gmail.com', 'basyira.a20d004f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nBachelor of Aircraft Engineering Technology (Hons) in Avionics', 'UniKL', '3.66', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '8-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(28, 'A20D026P', 'Amirah binti Mohammad', '761217-02-5548', '17-Dec-76', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIE', 'Separuh Masa', 'PT 3806, Lorong 3C, Seksyen C, Taman Merbau Utama, 16810 Selising, Pasir Puteh, Kelantan', 'Pasir Puteh', '0192004809', 'amirah17.mohammad@gmail.com', 'amirah.a20d026p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.06', '2002', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '9-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(29, 'A20D012F', 'Nik Mohd Shukri bin Nik Ismail', '930503-03-6509', '3-May-93', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'Lot 3182, Kg. Wakaf Zain Tawang, 16020 Bachok, Kelantan', 'Bachok', '0137002779', 'nikshukri7777@gmail.com', 'nmshukri.a20d012f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan', 'UMK', '3.29', '2018', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '19-Oct-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(30, 'A20D017F', 'Muhammad Syahir bin Noor Shahruall Nizam', '970826-03-5509', '26-Aug-97', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No. 627, Lorong Kota Kenari 3/5, Taman Kota Kenari, 09000 Kulim, Kedah', 'Kulim', '0139330826', 'syahirnizam.sn@gmail.com', 'syahir.a20d017f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.46', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '19-Oct-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(31, 'A20D031F', 'Nik Muhammad Na\'im bin Abdul Rahim', '880807-03-5443', '7-Aug-88', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'PT 1508 Taman Bendahara\nBaung Seksyen 36\nJalan Pengkalan Chepa\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '017-9074074', 'niknaim@gmail.com', 'a20d031f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UMK', '3.06', '2019', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '20-OKT-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(32, 'A20D030F', 'CHE WAN HALIMATUL NURLISA IDAYU BINTI CHE WAN EMBONG', '961107-11-5266', '07-Nov-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No 27 Felda Kerteh 4,\nBandar Ketengah Jaya,\n23300 Dungun, Terengganu', 'Dungun', '014-8159327', 'cwhni.nurlisa@gmail.com', 'a20d030f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.6', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '20-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(33, 'A20D018F', 'SITI AISYAH BINTI AHMAD', '970329-07-5460', '29-Mar-97', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', '210 Pokok Tampang, 13300 Tasek Gelugor, Pulau Pinang', 'Tasek Gelugor', '011-14682695', 'aisyahmad293@yahoo.com', 'aisyah.a20d018f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.22', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '20-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(34, 'A20D034P', 'MOHAMAD TAUFIQ BIN MOHAMAD JAMIL', '960702-10-5463', '02-July-96', 'Lelaki', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'No 31 Jalan Langat Murni, 6/A Taman Langa Murni, Bukit Changgang, 42700 Banting, Selangor', 'Banting', '0126047100', 'taufiq.a16a0364@siswa.umk.edu.my', 'a20d034p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Keushawanan', 'UMK', '3.11', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '20-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(35, 'A20D033F', 'MD RAZI BIN MD LAZIM', '810812-11-5079', '12-Aug-81', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', '161 Kg Lak Lok, 22000 Jerteh, Terengganu', 'Jerteh', '0139287343', 'mdrazi5088@gmail.com', 'a20d033f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Undang-Undang', 'IIUM', '2.83', '2005', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '20-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(36, 'A20D016F', 'AMIRAH AMNI MADIHAH BINTI \nAHMAD MUZAMMAL', '961007-02-5474', '7-Oct-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No. 63 Jalan Kedidi,\nTaman Sempadan,\n14300 Nibong Tebal,\nPulau Pinang', 'Nibong Tebal', '0183604574', 'amirahamni7@gmail.com', 'madihah.a20d016f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.54', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '22-Oct-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(37, 'A20D032F', 'SYED MUHAMMAD AYYUB BIN SYD ABDUL RAHMAN', '970530-02-5035', '30-May-97', 'Lelaki', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', '47 Villa Nasibah, Jalan Indah 6, Taman Jitra Indah, 06000 Jitra, Kedah', 'Jitra', '013-5829885', 'ayyubabrahman97@gmail.com', 'a20e032f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.32', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '2-Nov-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(38, 'A20D037F', 'MUHAMMAD ZULFARIS BIN MOHD SALLEH', '890209-03-5149', '9-Feb-89', 'Lelaki', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'A-1 Taman Sri Pauh,\n18400 Temangan, Kelantan', 'Temangan', '0145150187', 'zulfaris99@gmail.com', 'a20d037f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nSarjana Muda Sains Komputer (Kejuruteraan Perisian)', 'UMP', '3.17', '2012', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '3-Nov-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(39, 'A20D035P', 'ASHROF BIN SHAMSUDDIN', '760829-71-5051', '29-Aug-1976', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Separuh Masa', 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0124083344', 'ashrof.shamsuddin@lth.gov.my', 'a20d035p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan Perniagaan', 'UUM', '3.06', '2009', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '5-Nov-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(40, 'A20D038P', 'NUR \'IZZATI BINTI ABDUL RAHMAN', '891027-14-5720', '27-Oct-89', 'Perempuan', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Separuh Masa', 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0193747197', 'zatierahman@gmail.com', 'a20d038p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nIjazah Sarjana Muda (Kepujian) Perakaunan', 'UiTM', '2.82', '2012', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '5-Nov-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(41, 'A20D040F', 'HASZLIHISHAM BIN ABDULLAH', '750802-03-5823', '02-August-75', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Pondok Pengkalan Machang To\' Uban, 17050 Pasir Mas, Kelantan', 'Pasir Mas', '0193803804', 'haszlihisham@jkptg.gov.my', 'a20d040f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UKM', '2.4', '1999', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '10-Nov-20', 'Pembiayaan Sendiri', NULL, '2', 'KAMPUS KOTA', 'AKTIF'),
(42, 'A20D041P', 'Nani Hasnita binti Hashim', '770818-02-5660', '18-August-77', 'Perempuan', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'No 1. Taman Sri Pelangi , 06000 Jitra, Kedah', 'Jitra', '0194171177', 'nhhasnita@hotmail.com', 'a20d041p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nSarjana Muda Pengurusan Perniagaan', 'UUM', '2.67', '2009', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '10-Nov-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(43, 'A20D043P', 'Tharshini A/P Arumugam', '961203-08-5562', '3-Dec-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Separuh Masa', 'No. 15, Jalan JH 2, Taman Jana Harmoni,\n34600 Kamunting, \nPerak', 'Kamunting, Perak', '017-7164136', 'tharshini5562@gmail.com', 'a20d043p@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nSarjana Muda Keusahawanan (Peruncitan)', 'UMK', '2.93', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '29-Nov-20', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(44, 'A20D042F', 'Nur Zahraa binti Azly', '950416-14-5684', '16-April-95', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Lot 1005 Kampung Chempaka, \n Jalan Panji \n 16100 Kota Bharu,\n Kelantan', 'Kota Bharu', '014-5281445', 'lcr_13@yahoo.com', 'a20d042f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.09', '2020', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '13 December 2020', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(45, 'A20D036F', 'Mohd Fadzlul Karim bin Mohamad Naser', '940716-02-5001', '16 July 1994', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'Hadapan Sek. keb. Padang Perahu,\nJalan Kodiang,\n06000 Jitra,\nKedah', 'Jitra, Kedah', '013-4667690', 'fadzlul94@gmail.com', 'a20d036f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda:\nBachelor of Business Administration (Islamic Banking and Finance)', 'UMK', '3.61', '2017', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '2 February 2021', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(46, 'A20D049F', 'MAJIDATUL KAMALIA BINTI NOOR ADZMEE', '911007-11-5810', '7 Oct 1991', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIE', 'Penuh Masa', 'Lot PT 794 435A Kampung Kubang Kura 20050, Kuala Terengganu', 'Kuala Terengganu', '010-4425800', 'majidatulkamalia@yahoo.com', 'a20d049f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda: Undang-Undang dengan Kepujian', 'UUM', '2.8', '2015', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2020', '14 MAR 2021', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(47, 'A20D051F\n', 'SITI FARAH NABILA BINTI MOHD SUHAIMI\n', '950603-03-6192', '3 June 1995', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'MIF', 'Penuh Masa', 'PT 2050, Jalan Wira 1 KM40 Jalan Kuala Krai, 18500 Machang Kelantan ', 'Machang', '019-9445267', 'farahnabila950603@gmail.com\n', 'a20d051f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Iajazah Sarjana Muda Pentadbiran Perniagaan (Perbangkan dan Kewangan Islam) Dengan Kepujian', '', '3.81', '2020', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2020', '16 MAR 2021', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF'),
(48, 'A20D047F', 'MUHAMMAD QASIM', 'BK4855272', '19-09-1993', 'Lelaki', 'Bujang', 'Pakistan', 'Antarabangsa', 'MIE', 'Penuh Masa', 'House: 11 Street: 20, MVHS, B17', 'Islamabad', '9.23336E+11', 'm_kasim@hotmail.com', 'a20d047f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Bachelor Of Entrepreneurship (Hospitality) With Honours', '', '3.17', '2017', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2020', '25 MAR 2021', 'Pembiayaan Sendiri', NULL, '1', 'KAMPUS KOTA', 'AKTIF');

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_data2`
--

CREATE TABLE `pg_student_data2` (
  `id` int(11) NOT NULL,
  `NO_MATRIK` varchar(9) DEFAULT NULL,
  `NAMA_PELAJAR` varchar(53) DEFAULT NULL,
  `NO_IC` varchar(14) DEFAULT NULL,
  `TARIKH_LAHIR` varchar(12) DEFAULT NULL,
  `JANTINA` varchar(9) DEFAULT NULL,
  `TARAF_PERKAHWINAN` varchar(9) DEFAULT NULL,
  `NEGARA_ASAL` varchar(8) DEFAULT NULL,
  `KEWARGANEGARAAN` varchar(12) DEFAULT NULL,
  `KOD_PROGRAM` varchar(3) DEFAULT NULL,
  `PROGRAM_PENGAJIAN` varchar(200) DEFAULT NULL,
  `TARAF_PENGAJIAN` varchar(12) DEFAULT NULL,
  `ALAMAT` varchar(89) DEFAULT NULL,
  `DAERAH` varchar(16) DEFAULT NULL,
  `NO_TELEFON` varchar(50) DEFAULT NULL,
  `EMEL_PERSONAL` varchar(100) DEFAULT NULL,
  `EMEL_PELAJAR` varchar(100) DEFAULT NULL,
  `AGAMA` varchar(5) DEFAULT NULL,
  `BANGSA` varchar(6) DEFAULT NULL,
  `NAMA_SARJANA_MUDA` varchar(104) DEFAULT NULL,
  `UNIVERSITI_SARJANA_MUDA` varchar(25) DEFAULT NULL,
  `CGPA_SARJANA_MUDA` varchar(4) DEFAULT NULL,
  `TAHUN_SARJANA_MUDA` varchar(10) DEFAULT NULL,
  `NAMA_SARJANA` varchar(200) DEFAULT NULL,
  `UNIVERSITI_SARJANA` varchar(200) DEFAULT NULL,
  `CGPA_SARJANA` varchar(10) DEFAULT NULL,
  `TAHUN_SARJANA` varchar(50) DEFAULT NULL,
  `SESI_MASUK` varchar(42) DEFAULT NULL,
  `TAHUN_KEMASUKAN` varchar(100) DEFAULT NULL,
  `TARIKH_KEMASUKAN` varchar(16) DEFAULT NULL,
  `PEMBIAYAAN` varchar(200) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `SEMESTER` varchar(10) DEFAULT NULL,
  `KAMPUS` varchar(11) DEFAULT NULL,
  `STATUS` varchar(5) DEFAULT NULL,
  `done_import` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pg_student_data2`
--

INSERT INTO `pg_student_data2` (`id`, `NO_MATRIK`, `NAMA_PELAJAR`, `NO_IC`, `TARIKH_LAHIR`, `JANTINA`, `TARAF_PERKAHWINAN`, `NEGARA_ASAL`, `KEWARGANEGARAAN`, `KOD_PROGRAM`, `PROGRAM_PENGAJIAN`, `TARAF_PENGAJIAN`, `ALAMAT`, `DAERAH`, `NO_TELEFON`, `EMEL_PERSONAL`, `EMEL_PELAJAR`, `AGAMA`, `BANGSA`, `NAMA_SARJANA_MUDA`, `UNIVERSITI_SARJANA_MUDA`, `CGPA_SARJANA_MUDA`, `TAHUN_SARJANA_MUDA`, `NAMA_SARJANA`, `UNIVERSITI_SARJANA`, `CGPA_SARJANA`, `TAHUN_SARJANA`, `SESI_MASUK`, `TAHUN_KEMASUKAN`, `TARIKH_KEMASUKAN`, `PEMBIAYAAN`, `admission_date`, `SEMESTER`, `KAMPUS`, `STATUS`, `done_import`) VALUES
(1, 'A10E006P', 'Suraini binti Saufi', '771020-03-6314', '20-Oct-77', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 2795, Kg Wakaf Kuchelong, Jelawat, 16070 Bachok, Kelantan.', 'Bachok', '012-9621481 ', 'su_achik@yahoo.com', 'a10e006p@siswa.umk.edu.my', 'Islam', 'Melayu', ' Universiti Tun Abdul Razak', ' Bachelor of Business Adm', '2.9', '', ' Sarjana Pentadbiran', 'Universiti Teknologi Mara', '3.28', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2010/2011', '2011', '', '1. Tajaan MyPhD. 3 Jan 2011 hingga 2 Jan 2014 (37 bulan). , 2. Pembiayaan sendiri.', '0000-00-00', '18', 'KAMPUS KOTA', 'AKTIF', 1),
(2, 'A12E005F', 'Akram Bin Hasan', '730223-03-5409', '23-Feb-73', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh masa', 'PT 381 Taman Jaya Setia, Badang Pantai Cahaya Bulan, 15350 Kota Bharu, Kelantan.', 'Kota Bharu', '017-9003685 ', 'akram@skm.gov.my', 'a12e005f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', ' MBA ', 'Universiti Kebangsaan Malaysia ', '3.33', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2012/2013', '2012', '', '1. Tajaan JPA 9 Sept 2012 - 8 Sept 2015 ( 36 Bln), 2. Pembiayaan sendiri', '0000-00-00', '18', 'KAMPUS KOTA', 'AKTIF', 1),
(3, 'A12E014F', 'Nik Zirwatul Fatihah Binti Ismail', '870128-03-5384', '28-Jan-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'B-573 Jalan Kubor, 17500 Tanah Merah, Kelantan.', 'Tanah Merah', '014-2229447', 'nickfatiha@gmail.com', 'a12e014f@siswa.umk.edu.my', 'Islam', 'Melayu', ' Universiti Putra Malaysia ', ' Sarjana Muda ', '2.97', '', 'Master Of economics', 'Universiti Putra Malaysia', '3.36', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2012/2013', '2012', '', '1. Tajaan MYpHd. 1 Feb 2013 hingga 31 Julai 2015 (30 bulan) , 2. Pembiayaan sendiri', '0000-00-00', '18', 'KAMPUS KOTA', 'AKTIF', 1),
(4, 'A12E021F', 'Siti Nurulaini Binti Azmi', '871215-03-5416', '15-Dec-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 3148 Taman Sri Setia, Jalan Padang Tembak,16100 Kota Bharu Kelantan', 'Kota Bharu', '013-2927321', 'ctaini87@gmail.com', 'nurulaini.a12e021f@siswa.umk.edu.m', 'Islam', 'Melayu', '', '', '', '', 'MBA', 'Universii Putra Malaysia', '3.27', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2012/2013', '2013', '', '1. Tajaan MyPhD. 1 Mac 2013 hingga 29 Feb 2016 (36 bulan), 2. Pembiayaan sendiri', '0000-00-00', '16', 'KAMPUS KOTA', 'AKTIF', 1),
(5, 'A12E019F', 'Mohamed Safaruddin Bin Ismail', '700617-03-5287', '17-Jun-70', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '4483-F Lorong Nyior, Chabang Jalan Hospital, 15400 Kota Bharu, Kelantan', 'Kota Bharu', '013-9909779', 'mosi9779@gmail.com', 'a12e019f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'MBA', 'Universiti Utara Malaysia', '3.36', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2012/2013', '2013', '', '1. Biasiswaz HLP (3 Mac 2013 - 2 Sept 2016), 2. Pembiayaan sendiri', '0000-00-00', '17', 'KAMPUS KOTA', 'AKTIF', 1),
(6, 'A13E002F', 'Kartini Binti Kadir', '850429-03-5806', '29-Apr-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'F-61 Perumahan Kusial Bharu, 17500 Tanah Merah, Kelantan.', 'Tanah Merah', '017-7711282', 'tinizaini@ymail.com', 'kartini.a13e002f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', ' Master of Science (Human Resource Development ) ', 'UNIVERSITI TEKNOLOGI MALAYSIA ', '3.57', '2010', 'SEMESTER SEPTEMBER SESI AKADEMIK 2013/2014', '2013', '', '1. Tajaan MyPhD 3/2/2014 - 2/8/2016 (30bln), 2. Pembiayaan sendiri', '0000-00-00', '15', 'KAMPUS KOTA', 'AKTIF', 1),
(7, 'A14E010F', 'Nor Shuhada Binti Ahmad Shaupi', '871207-03-5256', '07-Dec-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Teratak Impian, Depan SK Kandis, 16310 Bachok, Kelantan.', 'Bachok', '017-3534877', 'shuhadashaupi@gmail.com', 'shuhada.a14e010f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', ' Master of Economics ', 'Universiti Malaya ', '3.25', '2013', 'SEMESTER SEPTEMBER SESI AKADEMIK 2014/2015', '2014', '', '1. Yuran tajaan MYPHD 2 Feb 2015-1 Ogos 2017 (30 bln), 2. Pembiayaan sendiri', '0000-00-00', '12', 'KAMPUS KOTA', 'AKTIF', 1),
(8, 'A14E017F', 'Nik Zati Hulwani Binti Nik Idris', '831114-03-5242', '14-Nov-83', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 852, Lrg Surau Kg. Banggol, 15350 Jln PCB, Kota Bharu, Kelantan.', 'Kota Bharu', '013-3077641', 'nik_waniey@yahoo.com', 'zati.a14e017f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', ' Master of Quantitative Sciences ', 'UiTM Shah Alam ', '3.42', '2011', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', '1. TAJAAN MYPHD 1 SEPT 2015- 28 FEB 2018 (30 BULAN), 2. Pembiayaan sendiri', '0000-00-00', '14', 'KAMPUS KOTA', 'AKTIF', 1),
(9, 'A14E019F', 'Azianis Binti Mohd Noor', '850426-03-5210', '26-Apr-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 213, Kampung Kijang, Jalan PCB, 15350 Kota Bharu, Kelantan.', 'Kota Bharu', '010-9313987', 'azianis1309@gmail.com', 'azianis.a14e019f@siswa.umk.edu.my', 'Islam', 'Melayu', ' Bachelor of Arts (Hons) in Administrative Management ', 'KLMUC ', '3.02', '2010', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', '1. TAJAAN MYPHD 2 MAC 2015-1 MAC 2018(36 BULAN), 2. PEMBIAYAAN SENDIRI', '0000-00-00', '14', 'KAMPUS KOTA', 'AKTIF', 1),
(10, 'A14E025F', 'Shamsudin Bin Sahaimin', '730921-03-5211', '21-Sep-73', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 1249, Kg. Anak Sungai, Jalan Pengkalan Chepa, 16100 Kota Bharu, Kelantan.', 'Kota Bharu', '013-9321087', '9088sham@gmail.com', 'shamsudin.a14e025f@siswa.umk.edu.m', 'Islam', 'Melayu', '', '', '', '', ' Master Pengurusan (Pengurusan Am) ', 'UPM ', '3.292', '2001', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', '1. TAJAAN MYPHD 2 MAC 2015-1 MAC 2018 (36 BULAN), 2. Pembiayaan sendiri', '0000-00-00', '12', 'KAMPUS KOTA', 'AKTIF', 1),
(11, 'A15E007P', 'Jefri Bin Mustapha', '760606-03-5235', '06-Jun-76', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 506\nKg Gong Tengah\nBatu 6, Sabak\n16100 Kota Bharu\nKelantan\n(019-9646459)', 'PT 506\nKg Gong T', '019-9646459', 'kelisakuning@yahoo.com', 'jefri.a15e007p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '3.68', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Pembiayaan Sendiri', '0000-00-00', '13', 'KAMPUS KOTA', 'AKTIF', 1),
(12, 'A15E009P', 'Wan Mohd Farid Bin Wan Yusof', '700319-03-5107', '19-Mar-70', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '195 Belakang SBJ Putra\nPasir Pekan\n16250 Wakaf Bharu\nKelantan\n(013-9201597)', '195 Belakang SBJ', '013-9201597', 'wmfarid@iab.edu.my', 'farid.a15e009p@siswa.umk.edu.my', 'Islam', 'Melayu', ' BBA', 'UUM', '3.5', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Hadiah Latihan Persekutuan 13.9.2015 hingga 12.9.2020 (60 bulan)', '0000-00-00', '13', 'KAMPUS KOTA', 'AKTIF', 1),
(13, 'A15E010P', 'Muhammad Hilal Bin Abdul Karim', '800719-05-5279', '19-Jul-80', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT200 Lorong Masjid Mustaqim\nOff Jln Long Yunus\n15000 Kota Bharu\nKelantan\n(019-9571007)', 'PT200 Lorong Mas', '019-9571007', 'mhilal@pnb.com.my', 'hilal.a15e010p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '3.84', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Pembiayaan Sendiri', '0000-00-00', '13', 'KAMPUS KOTA', 'AKTIF', 1),
(14, 'A15D023F', 'Siti Nadiah binti Abdul Mutalib', '921007-03-6230', '07-Oct-92', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'Siti Nadiah binti Abdul Mutalib \nKg Bechah Kelubi\nChetok\n17060 Pasir Mas \nKelantan\n014-53', 'Siti Nadiah bint', '014-5398768', 'sitinadiah710@gmail.com', 'nadiah.a15d023f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Sarjana Muda Pentadbiran Muamalat', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016', '2016', '', 'Pembiayaan sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(15, 'C14E008P', 'Fadhilahanim Aryani Binti Abdullah', '800412-03-5644', '12-Apr-80', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 267, Lorong SK Bunut Payung, 15100 Kota Bharu, Kelantan.', 'PT 267, Lorong S', '019-2111980', 'aryani.a@umk.edu.my', 'aryani.c14e008p@siswa.umk.edu.my', 'Islam', 'Melayu', ' Sarjana Pendidikan Sains dengan Teknologi Komunikasi dan Maklumat ', 'Universiti Malaya ', '3.31', '', '', '', '', '2011', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', 'TAJAAN MYPHD 2 MAC 2015- 1 MAC 2019 (48 BULAN)', '0000-00-00', '13', 'KAMPUS KOTA', 'AKTIF', 1),
(16, 'A16D025P', 'Salini Aina binti Mamat', '800719-03-5286', '19-Jul-80', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'Salini Aina binti Mamat\nLot 6307 Taman Hj Ali\nTelong Mukim Kandis\n16300 Bachok\nKelantan\n0', 'Salini Aina bint', '019-2488697', 'aina800719@gmail.com', 'salini.a16d025p@siswa.umk.edu.my', '', '', 'Sarjana Muda Teknologi Maklumat', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', 'pembiayaan sendiri', '0000-00-00', '10', 'KAMPUS KOTA', 'AKTIF', 1),
(17, 'A16E004P', 'Hasannuddiin Hassan', '820509-02-5387', '09-May-82', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Hasannuddiin bin Hassan\nPT 824 Lorong 27\nTaman Kurnia Jaya\nPengkalan Chepa\n16100 Kota Bha', 'Hasannuddiin bin', '019-5748259', 'hasann@umk.edu.my', 'hasanuddiin.a16e004p@siswa.umk.edu', '', '', '', '', '', '', 'Sarjana Pengurusan', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', '', '0000-00-00', '11', 'KAMPUS KOTA', 'AKTIF', 1),
(18, 'A16E030F', 'Muhamad Nikmatullah Ajwad bin Adnan', '900910-03-6787', '10-Sep-90', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Muhamad Nikmatullah Ajwad bin Adnan\nLot 1279 Taman Kobena\n16800 Pasir Puteh\nKelantan\n014-', 'Muhamad Nikmatul', '014-5442608', 'nikmatullah_182@yahoo.com', 'nikmatullah.a16e030f@siswa.umk.edu', '', '', '', '', '', '', 'Sarjana Keusahawanan', 'UKM', '', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', '', '0000-00-00', '10', 'KAMPUS KOTA', 'AKTIF', 1),
(19, 'A16E001F', 'Nur Ain binti Mohd Yusoff', '870326-29-5224', '26-Mar-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Nur Ain binti Mohd Yusoff\nLot 1674 Kampung Pauh Lima\n16390 Bachok\nKelantan\n013-9282687', 'Nur Ain binti Mo', '013-9282687', 'nurain2687@gmail.com', 'ain.a16e001f@siswa.umk.edu.my', '', '', '', '', '', '', 'MBA', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', 'pembiayaan sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(20, 'A16E026F', 'Shahaliza binti Muhammad', '810502-10-5270', '02-May-81', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Shahaliza binti Muhammad\nNo. 506 Kg Bukit Tanah\nPeringat\n16400 Kota Bharu\nKelantan\n011-39', 'Shahaliza binti ', '011-39150705', 'lisha676@gmail.com', 'shahaliza.a16e026f@siswa.umk.edu.m', '', '', '', '', '', '', 'Sarjana Sains Pengurusan Maklumat', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', 'pembiayaan sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(21, 'A16E038F', 'Siti Norasyikin binti Abdul Rahman', '900906-11-5378', '06-Sep-90', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Siti Norasyikin binti Abdul Rahman\nNo. 76 Felda Jerangau Barat\n21820 Ajil\nTerengganu\n013-', 'Siti Norasyikin ', '013-9078371', 'umk_syikin90@yahoo.com', 'norasyikin.a16e038f@siswa.umk.edu.my', '', '', '', '', '', '', 'MBA ', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', 'pembiayaan sendiri', '0000-00-00', '11', 'KAMPUS KOTA', 'AKTIF', 0),
(22, 'A16E037F', 'Thuraisyah binti Jaaffar', '901007-07-5186', '07-Oct-90', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Thuraisyah binti Jaafar\n485 Lorong Meranti \nTaman Bersatu\n09000 Kulim\nKedah\n019-5160311', 'Thuraisyah binti', '019-5160311', 'aisyah_green90@yahoo.com', 'thuraisyah.a16e037f@siswa.umk.edu.my', '', '', '', '', '', '', 'MBA ', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017', '2016', '', 'pembiayaan sendiri', '0000-00-00', '10', 'KAMPUS KOTA', 'AKTIF', 0),
(23, 'A15E029F', 'Zul Karami bin Che Musa', '830720-03-5643', '20-Jul-83', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Zul Karami bin Che Musa\nLot 1068 Kg Telok Kemunting\nPauh Sembilan\n16020 Bachok\nKelantan\n0', 'Zul Karami bin C', '013-3671531\n', 'zul@umk.edu.my', 'zulkarami.a15e029f@siswa.umk.edu.m', '', '', '', '', '', '', 'Master Of Accounting', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016', '2016', '', 'pembiayaan sendiri', '0000-00-00', '10', 'KAMPUS KOTA', 'AKTIF', 1),
(24, 'A16E069P', 'Mimi Zazira binti Hashim', '740530-03-6128', '30-May-74', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Mimi Zazira binti Hashim@Hussein\nBahagian Akademik\nUiTM Kampus Machang\n18500 Machang\nKela', 'Mimi Zazira bint', '010-9146682', 'mihas7292@gmail.com', 'zazira.a16e069p@siswa.umk.edu.my', '', '', '', '', '', '', 'M Sc (IT) ', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'pembiayaan sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(25, 'A16E081P', 'Norrini binti Muhammad', '821120-03-5282', '20-Nov-82', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Norrini binti Muhammad\nLot 585 Kg Banggol\nJalan PCB\n15350 Kota Bharu\nKelantan', 'Norrini binti Mu', '012-2952994', 'norri5282@uitm.edu.my', 'norrini.a16e081p@siswa.umk.edu.my', '', '', '', '', '', '', 'Master In Office System Management', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'pembiayaan Sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(26, 'A16E043F', 'Siti Salwani binti Abdullah', '860128-29-5822', '28-Jan-86', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Siti Salwani binti Abdullah\nLot 251 Kg Tok Mekong\n16100 Kota Bharu\nKelantan\n013-9812801', 'Siti Salwani bin', '013-9812801', 'salwani.a@umk.edu.my', 'salwani.a16e043f@siswa.umk.edu.my', '', '', '', '', '', '', 'Msc. Finance ', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'TAJAAN SLAB,  (01 SEPT 2017 - 31 OGOS 2020) 36 BULAN', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(27, 'A16E050F', 'Syaida Fauziatul Hana Binti Yahya', '850903-14-5114', '03-Sep-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Syaida Fauziatul Hana Binti Yahya\n1-5-3 Pangsapuri Perdana\nJalan Lompat Pagar 13/37\n40100', 'Syaida Fauziatul', '012-3529838', 'syaida.fh@gmail.com', 'fauziatul.a16e050f@siswa.umk.edu.m', '', '', 'Bachelor In E-Commerce (Hons)', ' Universiti Malaysia Saba', '2.67', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'pembiayaan sendiri', '0000-00-00', '8', 'KL', 'AKTIF', 1),
(28, 'A16E032P', 'Siti Arnizan binti Mat Rifim', '760821-03-5764', '21-Aug-76', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Siti Arnizan binti Mat Rifim\nNo 139, Jln TKC 3/10, FASA 4, Taman Kota Cheras, 43200 Chera', 'Siti Arnizan bin', '019-3102378', 'sitiarnizan@gmail.com', 'arnizan.a16e032p@siswa.umk.edu.my', '', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'pembiayaan sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(29, 'A16E033P', 'Norhayati Binti Wahib', '870529-06-5752', '29-May-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Norhayati Wahib\nVilla Sri Tanjung\nPaloh Hinai, Mukim Lepar\n26650 Pekan \nPahang\n013-358457', 'Norhayati Wahib\n', '013-3584575', 'hayati_w@gapps.kptm.edu.my', 'norhayati.a16e033p@siswa.umk.edu.m', '', '', '', '', '', '', 'MBA ', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '9', 'KL', 'AKTIF', 1),
(30, 'A16E045F', 'Nik Noor Leeyana binti Kamaruddin', '850815-03-5556', '15-Aug-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Nik Noor Leeyana binti Kamaruddin PT1705 Kg Tasik,\nSelinsing\n16800 Pasir Puteh\nKelantan\n0', 'Nik Noor Leeyana', '017-9719985', 'niknoorleeyanakamaruddin@gmail.co', 'leeyana.a16e045f@siswa.umk.edu.my', '', '', '', '', '', '', 'MBA', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'Pembiayaan sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(31, 'A16E062F', 'Rajennd A/L Muniandy', '870414-08-5681', '14-Apr-87', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Rajennd S/O Muniandy\nNo. 51 Taman Zahari Zabidi\n36000 Teluk Intan \nPerak', 'Rajennd S/O Muni', '016-5465517', 'rajennd_57@yahoo.com', 'rajennd.a16e062f@siswa.umk.edu.my', '', '', '', '', '', '', 'Master Of Ent', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(32, 'A16D100F', 'Graceshealde Rechard', '920703-12-6374', '03-Jul-92', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'Graceshealde Rechard\nLadang Mills Sdn. Bhd. \nP.O Box 112\n90701 Sandakan \nSabah', 'Graceshealde Rec', '014-8573877', 'graceshealdarechard@yahoo.com', 'grace.a16d100f@siswa.umk.edu.my', '', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'Pembiayaan Sendiri/ PTPTN', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(33, 'A16D076F', 'Nurul Najida Binti Ab Rahim', '920419-03-5870', '19-Apr-92', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Pt 531, Batu 13, Jln Kuala Krai, Ketereh, 16450 Kota Bharu, Kelantan', 'Pt 531, Batu 13,', '014-5165026', 'nurulnajida@gmail.com', 'najida.a16d076f@siswa.umk.edu.my', '', '', 'Sarjana Muda Pengurusan Muamalat', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(34, 'P15F002F', 'NOORRAHA BT ABDUL RAZAK', '780831-04-5366', '31-Aug-78', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '02-02-09 BLOK 2 VISTA ANGKASA KAMPUNG KERINCHI 59200 KUALA LUMPUR', '02-02-09 BLOK 2 ', '013-3810130', 'nurz318@yahoo.com', 'nooraha.p15f002f@siswa.umk.edu.my', 'Islam', 'Melayu', 'BACHELOR OF BUSINESS ADMINISTRATION MARKETING ', 'UITM', '2.85', '', 'MASTER OF BUSINESS ADMINISTRATION', 'UUM', '3.5', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', 'Pembiayaan sendiri', '0000-00-00', '11', 'KL', 'AKTIF', 1),
(35, 'P14E011P', 'FAUZIAH BT SHAMSUDIN', '690320-01-6222', '20-Mar-69', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'separuh Masa', 'NO 13 JALAN SERI MUKA 36/27B TAMAN MENEGON INDAH SEK 36 40470 SHAH ALAM SELANGOR', 'NO 13 JALAN SERI', '012-3761722', 'gni.mktg@gmail.com', 'fauziah.p14e011p@siswa.umk.edu.my', 'Islam', 'Melayu', 'EXECUTIVE MASTER IN MANAGEMENT (MBA)', ' ASIA E UNIVERSITY KL', '3.77', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Pembiayaan sendiri', '0000-00-00', '12', 'KL', 'AKTIF', 1),
(36, 'P14E018P', 'LILIANTY BT NADZERI', '781109-11-5130', '09-Nov-78', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'NO 32 JLN USJ 4/1L SUBANG JAYA 47620 SELANGOR', 'NO 32 JLN USJ 4/', '017-6951820', 'misslilianty@live.com', 'lilianty.p14e018p@siswa.umk.edu.my', 'Islam', 'Melayu', 'BBA FINANCE', ' MULTIMEDIA UNIVERSITY', '', '', 'MASTER CHARTERED ISLAMIC FINANCE PROFESSIONAL (CIFP)', '', '2.9', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016', '2016', '', '1. Mybrain , (MYPHD 02/09/2014-01/03/2018), 2. PEMBIAYAAN SENDIRI', '0000-00-00', '9', 'KL', 'AKTIF', 1),
(37, 'P15F103F', 'KAMARYATI BT KAMARUDDIN', '650227-05-5394', '27-Feb-65', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '475-J JLN KENANGA 1/14, TMN KENANGA SEKSYEN 1,LORONG PANDAN, 75200 MELAKA.', '475-J JLN KENANG', '019-6657334', 'kamaryatikamaruddin@gmail.com', 'kamaryati.p15f103f@siswa.umk.edu.m', 'Islam', 'Melayu', 'BACHELOR IN INTERNATIONAL BUSINESS', 'MULTIMEDIA UNIVERSITY', '2.62', '', 'MBA ', 'MULTIMEDIA UNIVERSITY', '3.04', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Mybrain , (Data MGSEB Pembiayaan Sendiri), MyPhD (2 Feb 2015 - 1 Aug 2017)', '0000-00-00', '11', 'KL', 'AKTIF', 1),
(38, 'P15F120F', 'SAMIHAH BINTI AHMED', '770517-03-6788', '17-May-77', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '22, PERSIARAN MAKMUR, DESA MAKMUR SG. MERAB, 43000 KAJANG SELANGOR', '22, PERSIARAN MA', '012- 919 381', 'samihah.ahmed@mtdc.com.my', 'samihah.p15f120f@siswa.umk.edu.my', 'Islam', 'Melayu', 'BACHELOR SCIENCE BIOINDUSTRI', ' UPM', '2.67', '', 'MBA', 'UMK', '3.92', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'TAJAAN MTDC', '0000-00-00', '11', 'KL', 'AKTIF', 1),
(39, 'P15F125F', 'NUR FADIAH MOHD ZAWAWI', '850317-03-5510', '17-Mar-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'LOT 143, SEC 65, BT 41/4 LORONG WAKAF ZAIN, KG KOTA,JALAN SALOR,15100 KOTA BHARU,KELANTAN', 'LOT 143, SEC 65,', '013-3728033', 'nfadiahmz@gmail.com', 'fadiah.p15f125f@siswa.umk.edu.my', 'Islam', 'Melayu', 'BACHELOR OF MECHANICAL-AUTOMOTIVE ENGINEERING', '', ' ', '', 'SARJANA KEUSAHAWANAN BIDANG PENGURUSAN', ' UMK', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016', '2016', '', '1. MYPHD (2 FEB 2016 - 1 OGOS 2018) 30 BULAN, 2. Pembiayaan sendiri', '0000-00-00', '10', 'KL', 'AKTIF', 1),
(40, 'P15F124F', 'NUR AZIAH BT MOHD AROF', '860902-29-5574', '02-Sep-86', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Alamat pd 26022020: \nLot 657-A, Kampung Tapang\nJalan Tapang\n15200 Kota Bharu, Kelantan.\n\n', 'Alamat pd 260220', '019-4423236', 'honestgirlz_86@yahoo.com.my', 'aziah.p15f124f@siswa.umk.edu.my', 'Islam', 'Melayu', 'BACHELOR OF ECONOMICS ', 'UUM', '2.88', '', 'MASTER OF BUSINESS ADMINISTRATION ', 'UMK', '3.65', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016', '2016', '', 'Tajaan Myphd (2 Feb 2016 - 1 Feb 2019) 36 bulan', '0000-00-00', '11', 'KL', 'AKTIF', 1),
(41, 'P14E019P', 'YB DATUK HAJI TALIB BIN ZULPILIP', '510913-13-5533', '13-Sep-51', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'NO. 7A TAMAN SRI SENA, JALAN SEMARING PETRA JAYA, 93060 KUCHING, SARAWAK.', 'NO. 7A TAMAN SRI', '012-8983366', 'talibzu@gmail.co', 'talib.p14e019p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'MASTER OF COMMERCE & ADMI', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015', '2015', '', 'Pembiayaan sendiri', '0000-00-00', '12', 'KUCHING', 'AKTIF', 1),
(42, 'A17E003F', 'Nur Athirah Bt Yusoff', '901118-03-5742', '18-Nov-90', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 524-G Lorong Langgar Muda\nJalan Long Yunus\n15200 Kota Bharu\nKelantan', 'Lot 524-G Lorong', '014-5221622', 'apelathzhyrahz@gmail.com', 'athirah.a17e003f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'Sarjana Pentadbiran Perniagaan', 'Universiti Malaysia Terengganu', '3.78', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(43, 'A17E013P', 'Haznina Aini Binti Hassan', '880608-29-5176', '08-Jun-88', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'separuh Masa', 'PT391 Seksyen 1\nKg. Penambang\n15350 Kota Bharu\nKelantan', 'PT391 Seksyen 1\n', '013-9973524', 'hazninaainihassan@yahoo.com', 'haznina.a17e013p@umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'Sarjana Pentadbiran Perniagaan (MBA)', 'UMK', '3.85', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(44, 'A17E014F', 'Nur Shahirah Adilah Binti Mohd Sairazi', '920914-03-5982', '14-Sep-92', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No 22 Sri Tualang Bunut Susu\n17020 Pasir Mas\nKelantan', 'No 22 Sri Tualan', '013-3788925', 'nursairazi@gmail.com', 'adilah.a17e014f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'Sarjana Perakuanan', 'UiTM', '3.64', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(45, 'P15E051P', 'NOOR ZANARIAH BT MARDI', '811012-01-5904', '12-Oct-81', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'NO.8 JALAN P11 F/3 PRESINT 11 62300 PUTRAJAYA SELANGOR', 'NO.8 JALAN P11 F', '012-6229588', 'umiekawe12@yahoo.com.my', 'p15e051p@siswa.umk.edu.my', 'Islam', 'Melayu', ' DEGREE BBA', 'UNIVERSITI MALAYA', '2.94', '2004', 'MBA', 'UITM', '3.13', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016', '2015', '', 'Mybrain , (Data MGSEB Pembiayaan Sendiri), MyPhD (1 Sept 2015 - 28 Feb 2019)', '0000-00-00', '11', 'KL', 'AKTIF', 1),
(46, 'A16E042F', 'Siti Zamanira binti Mat Zaib', '870607-03-5082', '07-Jun-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Siti Zamanira binti Mat Zaib\nLot 789 Lorong Klinik Bidan\nKg Pauh Sembilan\n16150 Kota Bhar', 'Siti Zamanira bi', '014-8443018', 'zamanira@umk.edu.my', 'zamanira.a16e042f@siswa.umk.edu.my', 'Islam', 'Melayu', ' USIM', 'Sarjana Pentadbiran Muama', ' CGP', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'SLAB (19 Sept 2017 - 18 Mac 2020) 42 Bulan', '0000-00-00', '9', 'KAMPUS KOTA', 'AKTIF', 1),
(47, 'A17E012F', 'Rufaidah Binti Mat Nawi', '850512-03-5348', '12-May-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'LOT 1556, KG BANIR BELIKONG\nSELISING\n16810 PASIR PUTEH\nKELANTAN', 'LOT 1556, KG BAN', '013-3671183', 'tarmidahsoni@gmail.com', 'rufaidah.a17e012f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'MBA', 'UMK', '3.8', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(48, 'A17E016F', 'Salwati binti Su @ Hassan', '760728-02-6134', '28-Jul-76', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No 40 Jalan Desa 2/10\nBandar Country Home 48000 Rawang\nSelangor', 'No 40 Jalan Desa', '019-3898600', 'salwatihassan76@gmail.com', 'salwati.a17e016f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'SARJANA PENDIDIKAN PERNIAGAAN DAN KEUSAHAWANAN', 'UKM', '3.67', '2008', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(49, 'A17E018F', 'Nur Erfa Natasha Aida Binti Roslan', '901103-43-5444', '03-Nov-90', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 1427, Jalan Guchil Bayam\nTeluk Bharu\n15200 Kota Bharu\nKelantan', 'PT 1427, Jalan G', '012-9842000', 'erfanatasha@umk.edu.my', 'erfa.a17e018f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', '', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(50, 'A17E021P', 'Mahathir Bin Muhamad', '820807-03-5225', '07-Aug-82', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 531-A Teratak Damai\nKampung Telosan\n16800 Pasir Puteh\nKelantan', 'Lot 531-A Terata', '012-9892447', 'mahathir.m@umk.edu.my', 'mahathir.a17e021p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', '', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(51, 'A17D022F', 'Nur Hasyirah Binti Mohd Marzuki', '940521-03-5752', '21-May-94', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'Depan Pondok Darul Hanan\nKg. Selehor Palekbang\n16040 Tumpat\nKelantan', 'Depan Pondok Dar', '016-9222105', 'syiramarzuki@gmail.com', 'hasyirah.a17d022f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', '', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(52, 'A18E017F', 'Hanani Izzah binti Abdul Ghani', '821223-03-5656', '23-Dec-82', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 30 Kampung Paloh, Peringat, 16400 Kota Bharu, Kelantan', 'Kota Bharu', '011-32763978', 'nanizzah@yahoo.com', 'izzah.a18e017f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Bachelor of Economics (In', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(53, 'A17E023P', 'Noorizda Emellia Binti Mohd Aziz', '820223-01-5044', '23-Feb-82', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 1 Lot 1 KM12\nKg Paya Rumput\n76450 Melaka Tengah\nMelaka', 'No 1 Lot 1 KM12\n', '010-3148401', 'emellia.ma@gmail.com', 'emellia.a17e023p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', '', '0000-00-00', '7', 'KL', 'AKTIF', 1),
(54, 'A17D049F', 'Mohamad Shafiq bin Mohd Zaki', '940626-06-5413', '26-Jun-94', 'LELAKI', '', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'SEPARUH MASA', 'PT 754 Taman Lagenda Paradise\nKampung Paya Pasir \n16250 Wakaf Bharu\nKelantan', 'PT 754 Taman Lag', '017-9703157', 'shafiq.zaki38@gmail.com', 'shafiq.a17d049f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(55, 'A17E055F', 'Faten Nur Akmal binti Ismail', '891204-03-5240', '04-Dec-89', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT135 Desa Guru\nKampung Bechah, Tendong\n17030 Pasir Mas, Kelantan', 'PT135 Desa Guru\n', '019-5493817', 'faten_akmal@yahoo.com', 'faten.a17e055f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(56, 'A17E056P', 'Lim Wan Yi', '850813-03-5878', '13-Aug-85', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT2632 Jalan Firdaus 3/45\nTaman Firdaus\n16150 Kota Bharu\nKelantan', 'PT2632 Jalan Fir', '012-9498446', 'leogirl1308@yahoo.com', 'lmyi.a17e056p@siswa.umk.edu.my', '', 'Cina', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(57, 'A17E036F', 'Afifah Hanim binti Md Pazil', '860507-35-5442', '07-May-86', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT2045, Taman Pinggiran Universiti, Mukim Repek, 16310 Bachok, Kelantan', 'PT2045, Taman Pi', '019-4750586', 'afifah7586@gmail.com', 'afifah.a17e036f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'TAJAAN SLAB 1 April 2018 - 28 Feb 2021 (35 Bln)', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(58, 'A17E057F', 'Abdull Suki bin Hamat', '581020-03-5779', '20-Oct-58', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 502 Kg. Chenderong Batu\n16250 wakaf Bharu\nKelantan', 'Lot 502 Kg. Chen', '019-9104111', 'abdsuki@gmail.com', 'abdull.a17e057f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(59, 'A17E063F', 'Nur Akmarini binti Che Mat Razali', '910108-03-5188', '08-Jan-91', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 361 Jalan Melor, Taman Wangi, 18300 Gua Musang, Kelantan', 'No 361 Jalan Mel', '014-9668027', 'marini.razali@yahoo.com', 'akmarini.a17e063f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(60, 'A17E064P', 'Lydia Hidayu binti Lily Suhairi', '870511-29-5306', '11-May-87', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 2667A Jalan Kujid 7\nPerumahan Kastam Desa Kujid II\n16100 Panji, Kota Bharu\nKelantan', 'Lot 2667A Jalan ', '014-9679600', 'lydiahidayu87@yahoo.com', 'lydia.a17e064p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(61, 'A17E005F', 'Abeda Sultana', 'BT0218085', '01-Jan-85', 'PEREMPUAN', '', 'Banglade', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'DAG-665 Adarshaw Nagar\nMiddle Badda Gulshan Badda\n1212 Dhaka, Bangladesh', 'DAG-665 Adarshaw', '017-7673290', 'sultanaabeda@ymail.com', 'abeda.a17e005f@siswa.umk.edu.my', 'Islam', 'Bangla', '', '', '', '', 'Master of Business Studies, ', 'National University Gazipur, Bangladesh', '', '2006', 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '8', 'KL', 'AKTIF', 1),
(62, 'A17E052F', 'Samsidine Aidara', 'A02130072', '10-Nov-86', 'LELAKI', 'Berkahwin', 'Senegal', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 2013 Taman Mutiara, Belakang Kedai Ikhwan, Jalan Pengkalan Chepa, 15400 Kota Bharu, K', 'Kota Bharu', '016-5961274', 'shamsoudine.aidara@gmail.com', 'samsidine.a17e052f@siswa.umk.edu.m', 'Islam', 'Shuraf', '', 'Bachelor Degree in Applie', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Malaysian International Scholarship (MIS), Duration: 36 months, 26 Feb 2018 - 25 Feb 2021)', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(63, 'A18E001F', 'Wee Bee Fong', '880712-03-5948', '12-Jul-88', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '868-D Kweng Hitam, 18500 Machang, Kelantan', 'Machang', '017-9838872', 'wee88fong@gmail.com', 'wbfong.a18e001f@siswa.umk.edu.my', 'Buddh', 'Cina', '', 'Bachelor of Business Admi', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(64, 'A18E004F', 'Siti Som binti Husin', '830715-14-5960', '15-Jul-83', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Alamat Baru: LOT 533,KG POHON BULOH, JALAN MERANTI, 17000, PASIR MAS KELANTAN.\n\nNo. 33 Ja', 'Kota Bharu', '014-3612100', 'sitisomhusin@yahoo.com.my', 'som.a18e004f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Bachelor Science (Hons) A', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(65, 'A18E014F', 'Syed Ahmad Omar bin Syed Satri', '741122-12-5505', '22-Nov-74', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '2093 Jalan Gedung Lalang, Batu 8, Bukit Rambai, 75250 Melaka, Melaka', 'Melaka', '011-20499895', 'syedahmadomar@gmail.com', 'omar.a18e014f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Bachelor of Laws', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(66, 'A18E003F', 'Mohd Farid bin Ibrahim', '790406-03-5393', '06-Apr-79', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 1793, Jln Kurnia Jaya, Taman Kurnia Jaya, 1610 Kota Bharu, Kelantan', 'Kota Bharu', '019-9499704', 'farid@pkb.net.my', 'farid.a18e003f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '2.55', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(67, 'A18E021P', 'Nuzul Akhtar binti Baharudin', '790809-08-5424', '09-Aug-79', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No. 19, Jalan Balakong Jaya 15, Taman Balakong Jaya, 43300 Seri Kembangan, Selangor', 'Hulu Langat', '012-6111979', 'nuzulakhtar@kuis.edu.my', 'akhtar.a18e021p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'BBA (Hons) Finance', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', '', '0000-00-00', '5', 'KL', 'AKTIF', 1),
(68, 'A18E025F', 'Nurza binti Mohamed Yusoff', '820610-14-5906', '10-Jun-82', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No. 3, Jalan 3/3B, Bandar Baru Bangi, 43650 Bandar Baru Bangi, Selangor', 'Hulu Langat', '012-3768870', 'nzyusoff@gmail.com', 'nurza.a18e025f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Muda Ekonomi', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KL', 'AKTIF', 1),
(69, 'A18E024P', 'Mas Ayu Diana binti Mohd Fauzi', '840203-03-6102', '03-Feb-84', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 4661 Kampung Hutan Rebana, 18500 Machang, Kelantan', 'Machang', '012-9852282', 'ayudiana84@gmail.com', 'diana.a18e024p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Muda Pentadbiran ', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(70, 'A17E001F', 'Wan Nadiah Binti Wan Mohd Nasir', '900502-03-6032', '02-May-90', 'PEREMPUAN', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 1779 Kg. Dusun Raja\n Cempaka Panji\n 15300 Kota Bharu\n Kelantan', 'Lot 1779 Kg. Dus', '018-2594070', 'wanadiah@gmail.com', 'nadiah.a17e001f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Bachelor of Islamic Finance & Banking', 'UUM', '3.73', '2012', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018', '2017', '', 'Skim Zamalah (Yuran Ditanggung UMK)', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 1),
(71, 'A18E022F', 'Syarizal bin Abdul Rahim', '760611-06-5391', '11-Jun-76', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 52, Jalan 8/27C Section 8, Bandar Baru Bangi, 43650 Selangor', 'Bangi', '010-2456300', 'syarizal.ar@umk.edu.my', 'syarizal.a18e022f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Ijazah Sarjana Muda', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', '', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(72, 'A18E002F', 'Siti Maslina binti Hamzah', '870628-29-5350', '28-Jun-87', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 1860 Jalan Baru, Kampung Wakaf Lanas, 16800 Pasir Puteh, Kelantan', 'Pasir Puteh', '014-5095388', 'eina_9330@yahoo.com', 'maslina.a18e002f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Muda Perbankan Is', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(73, 'A18D020F', 'Fatin Farhana binti Kamis', '950223-02-5520', '23-Feb-95', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Blok B7-07 APT Desa Aman 2, \nJalan PantaiMurni 6, 59200 Pantai Dalam,\n Wilayah Persekutua', 'Wilayah Persekut', '013-5269066', 'fatinkamis.fk@gmail.com', 'farhana.a18d020f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Ijazah Sarjana Muda Keusa', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(74, 'A18E029P', 'Hazrina binti Hasbolah', '840406-03-6196', '06-Apr-84', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 332, Kampung Padang Taman, 16400 Melor, Kota Bharu, Kelantan', 'Kota Bharu', '019-2161918', 'hazrina.h@umk.edu.my', 'hazrina.a18e029p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Bachelor in Business Admi', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(75, 'A18E028P', 'Munirah binti Mahshar', '880511-05-5272', '11-May-88', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 9468, Lorong Hidayah 1, Kampung Chawas, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '013-9471986', 'munirah@umk.edu.my', 'munirah.a18e028p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Ijazah Sarjana Muda Pengu', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(76, 'A18E023P', 'Siti Sarah binti Mohamad', '870901-11-5462', '01-Sep-87', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot 1493 Belakang Masjid Tok Kenali\nKg. Pondok Tok Kenali \n16150 Kota Bharu\nKelantan', 'Kubang Kerian', '017-9796405', 'sarah804@uitm.edu.my', 'sarah.a18e023p@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(77, 'A18E026F', 'Masitah binti Afandi', '861206-29-5962', '06-Dec-86', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 404 Kampung Kelong\n16200 Tumpat Kelantan', 'Tumpat', '018-7780040', 'masitah.afandi@gmail.com', 'masitah.a18e026f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Pentadbiran Perni', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(78, 'A18E027P', 'Raja Rosnah binti Raja Daud', '841006-03-6060', '06-Oct-84', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 8, Kampung Jalar, Bukit Bunga, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '011-19312962', 'rajaros6060@gmail.com', 'rosnah.a18e027p@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Muda Pentadburan ', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(79, 'A18E032F', 'Yusmawati binti Hussain', '911008-03-6268', '08-Oct-91', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 30 Jalan Tali Air\nKampung Lubuk Kuin\n16450 Ketereh\nKelantan', 'Ketereh', '014-8217665', 'yusmawatie55@gmail.com', 'yusmawati.a18e032f@siswa.umk.edu.m', 'Islam', '', '', 'Sarjana Pentadbiran Perni', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(80, 'A18E031F', 'Mohamad Hazeem bin Mohmad Sidek', '920909-06-5271', '09-Sep-92', 'LELAKI', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'penuh Masa', 'No. 6 Lorong 30\nPerumahan Bukit Rangin\nPermatang Badak Baru\n25150 Kuantan, Pahang', 'Kuantan', '014-7936269', 'hazeemsidik92@gmail.com', 'hazeem.a18e031f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Master of Science in Stat', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(81, 'A18E030F', 'Muhammad Fahimi bin Sofian', '890104-14-5165', '04-Jan-89', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 1700 Jalan Kurnia Jaya 37\nTaman Kurnia Jaya\nPengkalan Chepa\n16100 Kota Bharu', 'Pengkalan Chepa', '010-2610296', 'fahimisofian7@gmail.com', 'fahimi.a18e030f@siswa.umk.edu.my', 'Islam', 'Melayu', '', 'Sarjana Keusahawanan dan ', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019', '2018', '', 'Tajaan SLAB, (01.09.2019 - 31.01.2022)', '0000-00-00', '7', 'KAMPUS KOTA', 'AKTIF', 1),
(82, 'A18D041F', 'Nur Fairus binti Abd Hamid', '951130-13-5362', '27-Jun-94', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 1972 Kg Raja Alor Bakat, Mahligai, Melor\n16400 Kota Bharu, Kelantan', 'Kota Bharu', '013-6142462', 'nurfairushamid@gmail.com', 'fairus.a18d041f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019', '2019', '17-Feb-19', 'Pembiayaan Sendiri', '2019-02-17', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(83, 'A18E010F', 'Amni binti Mohd Adnan', '930614-03-6448', '26-Mar-83', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 638 Sek 47, Tanjung Mas\nJalan Pengkalan Chepa\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '0111-9456560', 'amnie_adnan@yahoo.com', 'amni.a18e010f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019', '2019', '17-Feb-19', 'Pembiayaan Sendiri', '2019-02-17', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(84, 'A18E034F', 'Azimah binti Ahmad', '900924-14-6194', '27-Sep-85', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'A04-1-15 Taman Samudera Jalan Timur 7\n68100 Batu Caves, Selangor', 'Selangor', '013-4767505', 'azimahahmad24@gmail.com', 'azimah.a18e034f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019', '2019', '25-Feb-19', 'TAJAAN SLAB, (01.09.2016 - 31.01.2020)', '2019-02-25', '6', 'KAMPUS KOTA', 'AKTIF', 1),
(85, 'A18E045P', 'Farah Ahlami binti Mansor', '840715-03-5488', '27-Apr-92', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '5249 A Kg. Dusun, Jalan Bayam\n15200 Kota Bharu\nKelantan', 'Kota Bharu', '013-9950325', 'farah865@uitm.edu.my', 'farah.a18e045p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019', '2019', '28-Feb-19', 'Pembiayaan Sendiri', '2019-02-28', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(86, 'A18E046F', 'Choong Chin Aun', '641021-07-5467', '21-Oct-64', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '85 Desa Manjung Point\n32040 Manjung\nPerak', 'Perak', '019-5774674', 'choongchinaun@gmail.com', 'ccaun.a18e046f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019', '2019', '25-Mar-19', '', '2019-03-25', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(87, 'A19E009P', 'Mohd Afifie bin Mohd Alwi', '791220-03-5111', '03-Mar-88', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '856 Jalan Yaakubiah\n15200 Kota Bharu\nKelantan', 'Kota Bharu', '013-9104774', 'afifie.alwi@umk.edu.my', 'afifie.a18e044f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '03-Sep-19', 'TAJAAN SLAB, (1/9/2019 - 31/8/2022)', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(88, 'A19E010F', 'Nurul Hasliana binti Hamsani', '880313-03-5772', '03-Mar-88', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No.4 Kampung Pak Puchuk, Ulu Sat\n18500 Machang\nKelantan', 'Machang', '012-3426773', 'hasliana.sani@gmail.com', 'hasliana.a18e049f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '03-Sep-19', 'TAJAAN SLAB, (1/9/19 - 31/8/2022)', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(89, 'A19E001F', 'Aimi Nadia binti Ibrahim @ Zakaria', '860716-29-5220', '20-Jul-77', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 3316 Taman Desa Kemumin\nJalan Kemumin 3, Padang Tembak\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '016-2328479', 'aiminadia.ibrahim@gmail.com', 'aimi.a19e001f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '03-Sep-19', 'TAJAAN SLAB, (1/9/19 - 31/8/2022)', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(90, 'A19E026F', 'Wan Ahmad Rizal bin Mohd Yusoff', '770720-11-5473', '15-Apr-95', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot PT 1150\nKampung Batu Tiong\nKampung Pulau Serai\n23000 Dungun\nTerengganu', 'Terengganu', '019-9224512', 'wanrizal_77@yahoo.com', 'rizal.a19e026f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '03-Sep-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 1),
(91, 'A19D025F', 'Nurshadira binti Mohd Raof', '950415-05-5310', '16-Sep-89', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'No 4472 Jalan SJ 4/2D\nTaman Seremban Jaya\n70450 Seremban\nNegeri Sembilan', 'Negeri Sembilan', '018-9002905', 'nur.shadira@yahoo.com', 'shadira.a19d025f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '03-Sep-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 1);
INSERT INTO `pg_student_data2` (`id`, `NO_MATRIK`, `NAMA_PELAJAR`, `NO_IC`, `TARIKH_LAHIR`, `JANTINA`, `TARAF_PERKAHWINAN`, `NEGARA_ASAL`, `KEWARGANEGARAAN`, `KOD_PROGRAM`, `PROGRAM_PENGAJIAN`, `TARAF_PENGAJIAN`, `ALAMAT`, `DAERAH`, `NO_TELEFON`, `EMEL_PERSONAL`, `EMEL_PELAJAR`, `AGAMA`, `BANGSA`, `NAMA_SARJANA_MUDA`, `UNIVERSITI_SARJANA_MUDA`, `CGPA_SARJANA_MUDA`, `TAHUN_SARJANA_MUDA`, `NAMA_SARJANA`, `UNIVERSITI_SARJANA`, `CGPA_SARJANA`, `TAHUN_SARJANA`, `SESI_MASUK`, `TAHUN_KEMASUKAN`, `TARIKH_KEMASUKAN`, `PEMBIAYAAN`, `admission_date`, `SEMESTER`, `KAMPUS`, `STATUS`, `done_import`) VALUES
(92, 'A19D028F', 'Siti Noor Asyikin binti Mazlan', '950623-04-5280', '17-Jan-83', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 2052 Kampung Wakaf Jela\nJalan Sungai Rengas\n20050 Kuala Terengganu', 'Kuala Terengganu', '014-5383807', 'asymzn@gmail.com', 'asyikin.a19d028f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '18-Sep-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 1),
(93, 'A19E029P', 'Norfazlirda binti Hairani', '830117-03-6000', '14-Aug-97', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 96 Spg 3 Sek. Keb. Kadok\n16450 Kota Bharu\nKelantan', 'Kota Bharu', '017-9780657', 'fazlirda.h@umk.edu.my', 'irda.a19e029p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '18-Sep-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 1),
(94, 'A19D030F', 'Nur Izzatul Adibah binti Mohd Shahrizan', '920328-14-5900', '10-Jul-94', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 1167 Belakang Jabatan Haiwan Batu 18\n43100 Hulu Langat\nSelangor', 'Selangor', '012-6903597', 'izzatul.a15b0681@siswa.umk.edu.my', 'adibah.a19d030f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '23-Sep-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 1),
(95, 'A19E050F', 'Marina binti Muhammad Razaki', '870824-29-5294', '24-Aug-87', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 933 Kepulau\n16040 Wakaf Bharu\nKelantan', 'Wakaf Bharu', '010-4069954', 'marinarazaki@gmail.com', 'marina.a19e050f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '31-Oct-19', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 1),
(96, 'A19E038P', 'Mohd Nor bin Ismail', '640910-03-6623', '10-Sep-64', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'PT 2/3 Jalan Dua Desa Darulnaim\nPasir Tumboh\n16150 Kota Bharu\nKelantan', 'Kota Bharu', '013-9283838', 'mohdnor6623@gmail.com', 'nor.a19e038p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '31-Oct-19', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 0),
(97, 'A19E047F', 'Hallieyana binti Sha\'ari', '851108-03-5498', '08-Nov-85', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '341-N Jalan Sultan Yahya Petra\n15150 Kota Bharu\nKelantan', 'Kota Bharu', '011-14971685', 'yanna811@yahoo.com', 'hallieyana.a19e047f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '04-Nov-19', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(98, 'A19E013F', 'Zaato Solomon Gbene', 'G2520171', '10-Mar-78', 'LELAKI', 'Berkahwin', 'Ghana', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Post Office Box 9419\nAhinsan Kumasi\n? Ghana West Africa', 'Ghana', '017-2948754', 'zagso2012@gmail.com', 'zaato.a19e013f@siswa.umk.edu.my', 'Krist', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 0),
(99, 'A19E044F', 'Izzat Syazwan bin Mustafa Kamal', '860216-12-5399', '16-Feb-86', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 421 Jalan Bayam\n15200 Kota Bharu\nKelantan', 'Kota Bharu', '011-26069225', 'izzatsyazwan86@gmail.com', 'izzat.a19e044f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '05-Nov-19', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(100, 'A19E051F', 'Hayda Farhana Nini binti Abu Hasan', '930214-02-5440', '14-Feb-93', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '9-14-3 Block Chengal\nDesaminium Rimba Condominium\n43300 Seri Kembangan\nSelangor', 'Selangor', '010-4033445', 'haydahasan.work@gmail.com', 'hayda.a19e051f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '06-Nov-19', 'Pembiayaan Sendiri', '0000-00-00', '5', 'KAMPUS KOTA', 'AKTIF', 0),
(101, 'A19D012F', 'Zahraddeen Kwaccido', 'A07539688', '25-Nov-84', 'LELAKI', 'Berkahwin', 'Nigeria', 'Antarabangsa', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'No.6 Mike Innegbesen Close\nOff Amobu Ojikutu Street\nVictoria Islana Lagos\n101241, Lagos\nN', 'Nigeria', '? 0809548005', 'quacchido@gmail.com', 'zahraddeen.a19d012f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '2019', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(102, 'A19E057P', 'Wadiwatty binti Sumanteri', '780207-14-6358', '07-Feb-78', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No12A Jalan Putra Indah 9/25\n47650 Subang Jaya\nSelangor', 'Selangor', '012-6559499', 'wadiesumanteri@gmail.com', 'watty.a19e057p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(103, 'A19E058P', 'Rahmah binti Kassim', '560814-10-5692', '14-Aug-56', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 50 Jalan Gobek 11-9\n40000 Shah Alam\nSelangor', 'Selangor', '012-3098885', 'drkrahmah@gmail.com', 'rahmah.a19e058p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2021', '17-Feb-20', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(104, 'A16E007P', 'Mohd Anuar bin Yahaya', '750218-02-6135', '18-Feb-75', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Mohd Anuar bin Yahaya\n SMK Bandar Machang\n 18500 Machang\n Kelantan\n 013-9959174', 'Mohd Anuar bin Y', '013-9959174\n', 'may14717@gmail.com', 'anuar.a16e007p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', 'Master Pendidikan ', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017', '2017', '', 'pembiayaan sendiri', '0000-00-00', '8', 'KAMPUS KOTA', 'AKTIF', 0),
(105, 'A19D0056P', 'Erie Alia binti Awang', '880401-11-5676', '01-Apr-88', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'D220, Blok D, tingkat 2, Taman kajang utama seksyen 1/1,\n43300 Selangor', 'Selangor', '017-9175321', 'eriealia88@gmail.com', 'alia.a19d0056p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 0),
(106, 'A19E0059F', 'Nurul Hasnie Hassiza binti W Hassan', '840109-03-5904', '09-Jan-84', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'penuh Masa', 'Lot 1284 Cabang Tiga Telok Off \nJalan Hospital, Kota Bharu\n15200 Kelantan', 'Kota Bharu', '019-3668325', 'hasniehassiza@gmail.com', 'hasnie.a19e0059f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(107, 'A19E059P', 'Tee Chun Wee', '720207-05-5195', '07-Feb-72', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '19, SS23/6A\nTaman Petaling Jaya\n47400 Selangor', 'Selangor', '012-6043043', 'teechunwee@yahoo.com', 'tcwee.a19e059p@siswa.umk.edu.my', 'Krist', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '02-Mar-20', 'Pembiayaan Sendiri', '0000-00-00', '4', 'KAMPUS KOTA', 'AKTIF', 0),
(108, 'A20E0100F', 'Lu Man Hong', '920829-14-6063', '29-Aug-92', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 6?Jln Gu 2/11?Taman Garing Utama, 48000 Rawang, Selangor.', 'Rawang', '012-3084113', 'vicklumanhong@gmail.com', 'a20e0100f@siswa.umk.edu.my', 'Buddh', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '05-Oct-20', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(109, 'A19E0008F', 'Wan Laura Hardilawati', 'C5898521', '26-Feb-90', 'PEREMPUAN', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan Delima, Komplek Delima Puri Blok U No. 1, Panam Kacamatan Tampan, Pekan Baru, Riau ', 'Pekanbaru', '85271239966', 'wanlaura@umri.ac.id', 'a20e0008f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(110, 'A19E0011F', 'Agustiawan', 'C4418023', '17-Aug-88', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Tuanku Tambusai Ujung NO. 01, Kel. Delima, Kec. Tampan, Pekanbaru-Riau-Indonesia', 'Pekanbaru, Indon', '6.28229E', 'agustiawan@umri.ac.id', 'a19e0011f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(111, 'A20D0143F', 'Emy Filzah binti Zulkifli', '821006-14-5162', '06-Oct-82', 'PEREMPUAN', 'Berkahwin', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 2882, Kampung Tempoyak, 16070 Bekelam, Bachok, Kelantan', 'Bachok', '017-5533858', 'emyfilzah82@gmail.com', 'a20d0143f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '05-Oct-20', 'Tajaan HLP', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(112, 'A19E0031F', 'Wira Ramashar', 'B6416232', '07-May-84', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jlan Ababil No.7 Manyar Sakti, Kelurahan Simpang Baru, Kacamatan Tampan, Pekanbaru', 'Pekanbaru', '6.28536E', 'wiraramashar@umri.ac.id', 'a19e0031f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(113, 'A19E0029F', 'Siti Hanifa Sandri', 'B3069620', '05-Feb-89', 'PEREMPUAN', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan M.H Thamrin No.76 RT.001 RW.005 Kelurahan Sukamaju Kecamatan Sail, Pekan Baru, Riau', 'Pekanbaru', '62811759989', 'sitihanifa@umri.ac.id', 'a19e0029f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(114, 'A20E0106F', 'Mohd Sumardi bin Ismail', '811020-03-5753', '20-Oct-81', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Lot 703, Kampung Sungai Perupok, 16300 Bachok, Kelantan', 'Bachok', '019-9261100', 'mohdsumardiismail@gmail.com', 'a20e0106f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(115, 'A20D022F', 'Nur Ilyana Amiiraa binti Nordin', '961228-03-5430', '28-Dec-96', 'PEREMPUAN', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 856 Kampung Telok Jering,\n16210 Tumpat,\nKelantan', 'Tumpat', '1119316769', 'ilyana.amiiraa@gmail.com', 'ilyana.a20d022f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(116, 'A19E056F', 'Muhammad Nizam bin Zainuddin', '780203-08-5041', '03-Feb-78', 'LELAKI', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Faculty of Management Multimedia University Persiaran Multimedia\n63100 Cyberjaya\nSelangor', 'Selangor', '013-2007457', 'muhammad.nizam@mmu.edu.my', 'nizam.a19e056f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '2020', '17-Feb-20', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(117, 'A20E0065F', 'ABDURRAHMAN FARIS INDRIYA HIMAWAN', 'C7103601', '24-Mar-89', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Sumatera No.101 GKB-Gresik, 61121 Gresik, Indonesia', 'Gresik, Indonesi', '6.28223E', 'faris@umg.ac.id', 'a20e0065f@siswa.umk.edu.my', 'Jawa', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(118, 'A20D0107F', 'WANG QIJING', 'EF4947093', '12-Jul-95', 'PEREMPUAN', 'Tidak Din', 'China', 'Antarabangsa', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', '51-18-E, Menara Bhl,?Jalan Sultan Ahmad Shah,?10050 Georgetown,Pulau Pinang', 'Georgetown', '60184618530', 'wangqijing36@gmail.com', 'a20d010f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(119, 'A19E0027F', 'HAMMAM ZAKI', 'C4813949', '08-Oct-88', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan Aster Indah No. 16/24, Kelurahan Tangkerang Timur, Kecamatan Bukit Raya, Pekanbaru,', 'Pekanbaru, Indon', '6.28126E', 'hammamzaki2@gmail.com', 'a19e0027f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(120, 'A19E0025F', 'Wahyi Busyro', 'C5898443', '24-Mar-86', 'PEREMPUAN', 'Berkahwin', 'Indonesi', 'antarabangsa', 'DOK', 'doktor Falsafah', 'penuh Masa', 'Jl. Sukakarya Gang Damai Perumahan Taman Pujangga Blok C No 1 Kelurahan Sialang Munggu Ke', 'Pekanbaru, Indon', '81365769813', 'wahyi.busyro@umri.ac.id', 'a19e0025f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(121, 'A19E0030F', 'Rika Septianingsih', 'X812660', '18-Sep-82', 'PEREMPUAN', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Bandung No. 4 Tangkerang Selatan, 28288 Pekanbaru Riau - Indonesia', 'Pekanbaru, Indon', '? 6856 3111', 'rikaseptianingsih@umri.ac.id', 'a19e0030f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(122, 'A19E0019F', 'Muhammad Ahyaruddin', 'C5072354', '07-Sep-89', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Kutilang Sakti No.27, Simpang Baru, Tampan, 28293 Pekanbaru, Riau, Indonesia', 'Pekanbaru, Indon', '????', 'ahyaruddin@umri.ac.id', 'a19e0019f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(123, 'A20E0067F', 'Bayu Wijayantini', 'C6521192', '17-Feb-79', 'PEREMPUAN', 'BERKAHWIN', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Anggur V no 14, Jember-68111, Jawa Timur, Indonesia', 'Jawa Timur, Indo', '6.28534E', 'bayu@unmuhjember.ac.id', 'a20e0067f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(124, 'A19E0042F', 'Putri Jamilah', 'C5899975', '23-Sept-93', 'PEREMPUAN', 'Bujang', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan Kutilang Sakti, Perumahan Adhiyaksa, No.3 Kecamatan Tampan, Pekanbaru, Indonesia', 'Pekanbaru, Indon', '6.28239E', 'putrijamilah61@yahoo.co.id', 'a19e0042f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(125, 'A19E0035F', 'SITI SAMSIAH', 'C4415293', '13-Nov-87', 'PEREMPUAN', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan : Naga Sakti, Perumahan Griya Kenari Indah Blok D.45, Pekanbaru, Riau, Indonesia', 'Pekanbaru, Indon', '6.28537E', 'siti.samsiah@umri.ac.id', 'a19e0035f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(126, 'A20E0110F', 'HAN YUE', 'EJ3922337', '01-Apr-80', 'Lelaki', 'Bujang', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '51-18-E, Menara Bhl,?Jalan Sultan Ahmad Shah,?10050 Georgetown,Pulau Pinang', 'Georgetown', '60184618530', 'hanyueya@yahoo.com', 'a20e0110f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(127, 'A19D037F', 'HE YUQIONG', 'ED9996837', '24-Jun-87', 'PEREMPUAN', 'Bujang', 'China', 'Antarabangsa', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Room 2502 Block 6 Wenjing \n Residential Weiyang,\n District Xi\'an\n 71016 Lian, Shamxi, Chi', 'Lian, China', '18691297877', 'yuqiong624@outlook.com', 'hyqiong.a19d037f@siswa.umk.edu.my', 'China', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(128, 'A19E0039F', 'Syukry Hadi', 'B8355413', '23-Mar-70', 'LELAKI', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Villa Bunga Raya, Jl, Merak D28, Tangkerang Labuai, Pekanbaru, Riau, Indonesia', 'Pekanbaru, Indon', '6.28128E', 'syukri.hadi@yahoo.com', 'a19e0039f@siswa.umk.edu.my', '', 'Minang', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(129, 'A20E002F', 'ZHANG HAIDONG', 'EJ5060757', '30-May-88', 'LELAKI', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '4B1001, Baolixiangyi Garden\nNan Cheng Road\nPanyu District\n51140 Guangzhou\nChina', 'Penyu District, ', '8.61502E', '63777561@QQ.COM', 'a20e002f@siswa.umk.edu.my', 'China', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(130, 'A19E042F', 'WEERASAK SOJIPUN', 'AA8033216', '23-Jun-83', 'Lelaki', 'Bujang', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '6/10 Adultanoon 1 Road, Bangnak Muang, Narathiwat, 96000 Thailand', 'Thailand', '66924153265', 'vcool99@hotmail.com', 'weerasak.a19e042f@siswa.umk.edu.my', 'Buddh', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(131, 'A19E040F', 'SOFIA SAMAALEE', 'AB3579015', '14-Jul-85', 'Perempuan', 'Berkahwin', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '91 Moo.1 Yala-Kota\nRD. Kota Bharu,\n95140 Raman, Yala,\nThailand', 'Yala, Thailand', '????', 'sososofia02@gmail.com', 'sofia.a19e0410f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(132, 'A19E0009F', 'RISNAL DIANSYAH', 'C5899214', '25-Okt-86', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jln Utama No 15A Kelurahan Rejosari Kecamatan Tenayan Raya Kota, 28281 Pekanbaru, Riau, I', 'Pekanbaru, Indon', '????', 'risnal@umri.ac.id', 'a19e0009f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(133, 'A20E0138P', 'Amzari Jihadi bin Ghazali', '800122-03-5291', '22-Jan-80', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'No 20, Lorong Im12/1,?Taman Astana Permai,?Bandar Indera Mahkota, 25200 Kuantan, Pahang', 'Kuantan', '192025468', 'amzarighazali@gmail.com', 'a20e0138p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(134, 'A19E0074P', 'Zamakhshari Bin Muhamad', '710105-03-6533', '05-Jan-71', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', '233A, Kampung Repek, 17070 Pasir Mas, Kelantan', 'Pasir Mas', '199168899', 'zamakhshari99@gmail.com', 'a19e0074p@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(135, 'A19E0040F', 'Andi Chandra', 'C6507270', '14-Apr-64', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Klinik Medika Salsabila, Jl. Melur No. 57B, Sukajadi, 28156, Pekanbaru, Indonesia', 'Pekanbaru, Indon', '????', 'andi_rsja@yahoo.com', 'a19e0040f@siswa.umk.edu.my', 'Indon', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(136, 'A20D028F', 'NOOR INANI BINTI CHE AZIZ', '961215-03-5044', '15-Dec-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 830 Kampung Gong Datuk,\n16800 Pasir Puteh\nKelantan', 'Pasir Puteh', '1117983459', 'noorinanicheaziz@yahoo.com', 'a20d028f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(137, 'A19E0069F', 'WAN FARIZA AZIMA BINTI CHE AZMAN', '941022-03-5824', '22-Oct-94', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No 70, Kampung Dusun Langgar, ?16250 Wakaf Bharu, ?Kelantan.', 'Wakaf Bharu', '011-17892145', 'fariza.p17d021f@siswa.umk.edu.my', 'e19e0069f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(138, 'A19E0044F', 'ARYANTO', 'C4417289', '28-Feb-73', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. T Tambusai (Kampus Muhammadiyah Riau)?Jl. Kemuning Gg. Mesjid No 4B Pekanbaru - Riau ', 'Pekanbaru, Indon', '????', 'aryanto@umri.ac.id', 'a19e0044f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(139, 'A19E0034F', 'RUDY ASRIANTO', 'C3407475', '24-Jul-93', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl Suka Karya Gang Iman No 46 (pagar biru lambang A), Pekanbaru, Riau 28293, Indonesia', 'Pekanbaru, Indon', '6.28528E', 'rudiasrianto@umri.ac.id', 'a19e0034f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(140, 'A19E0045F', 'Mizan Asnawi', 'C5900734', '07-Sept-80', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan Sei Mintan Ujung, Perumahan Griya Tika Utama, Blok H2 No. 9 Air Dingin Kota Pekanba', 'Pekanbaru, Indon', '62 852634024', 'mizan.asnawi@umri.ac.id', 'a19e0045f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(141, 'A19E0018F', 'Evans Fuad', 'C5900715', '14-Feb-86', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Alhamra No.101 RT 005 RW 004 Kel. Duri Timur, Kec. Mandau', 'Indonesia', '????', 'evansfuad@umri.ac.id', 'a19e0018f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(142, 'A20E0163F', 'Khaulah binti Hilaluddin', '941114-03-5506', '14-Nov-94', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 282, Taman Al-Qari, Kubang Kerian, 16150 Kota Bharu, Kelantan', 'Kota Bharu', '174143667', 'khaulah_hilaluddin@yahoo.com', 'a20e0163f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(143, 'A19E0023F', 'MUHAMMAD FIKRY HADI', 'C6381559', '10-Jan-81', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'Dok', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Darma No.16 RT007/RW 005, Labuh Baru Barat Payung Sekaki,Pekanbaru, Indonesia', 'Pekanbaru, Indon', '????', 'fikrihadi@umri.ac.id', 'a19e0023f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(144, 'A20E0166F', 'Nusaibah Binti Hilaluddin', '920224-03-5846', '24-Feb-92', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'PT 282, Taman Al-Qari, Kubang Kerian, 16150 Kota Bharu, Kelantan', 'Kota Bharu', '139194382', 'nusaibah92@yahoo.com', 'a20e0166f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(145, 'A20E0165F', 'Lu Qi', 'E95221080', '19-Dec-88', 'Lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 51-18-E Menara Bhl Jalan Sultan Ahmad Shah , 10050 Georgetown, Pulau Pinang', 'Georgetown', '184618530', 'liuqi3417@gmail.com', 'a20e0165f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(146, 'A11E003F', 'Mohd Azian bin Husin@Che Hamat', '800416-03-5465', '16-Apr-80', 'LELAKI', '', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Separuh Masa', 'Lot PT 2966, Kg. Kubang Panjang, 17000 Pasir Mas, Kelantan.', 'Pasir Mas', '09-788400 / ', 'zian_160480@yahoo.com', 'a11e003f@siswa.umk.edu.my', 'Islam', 'Melayu', ' Sarjana Muda Perakaunan', ' Universiti Utara Malaysi', '2.62', '', 'Sarjana pendidikan Vokasional ', ' Universiti Tun Hussien On Malaysia ', '3.72', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2011/2012', '2011', '', 'Pembiayaan sendiri', '0000-00-00', '19', 'KAMPUS KOTA', 'AKTIF', 0),
(147, 'A20D0177F', 'NUR FATIHAH NABILAH BINTI AHMAD JELANI', '960901-11-5752', '1-Sept-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 3307, Lorong 3 Kiri,?Jalan Gong Pasir, Kg. Balai Besar,23000 Terengganu', 'Kuala Terengganu', '139474039', 'nabilajelani1996@gmail.com', 'a20d0177f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Tajaan Yayasan Terengganu, (2 Tahun), Sept 2020/2021 - Feb 2021/2022', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(148, 'A19E0038F', 'Edo Arribe', 'C4417290', '23-Sept-88', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jalan Kapau Sari Perumahan Bukit Malay Asri B.11 Kelurahan Pematang Kapau - 28289 Pekanba', 'Pekanbaru, Indon', '6.28228E', 'edoarribe@umri.ac.id', 'a19e0038f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(149, 'E20E0155F', 'LI CHUANWEI', 'EB5624092', '02-Jun-84', 'Lelaki', 'Bujang', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 51-18-E Menara Bhl Jalan Sultan Ahmad Shah , 10050 Georgetown, Pulau Pinang', 'Georgetown', '184618530', 'lichuanwei31@gmail.com', 'e20e0155f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS BACH', 'AKTIF', 0),
(150, 'A19E043F', 'NIFATEEHAH PATTANAWONG', 'AA6245116', '25-Mar-81', 'Perempuan', 'Berkahwin', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '2 Sol3 Yakang 1, RD.Bangnak, 96000 Muang,\nNarathiwat, Thailand', 'Narathiwat, Thai', '66 73709030', 'nifapat@hotmail.com', 'nifateehah.a19e043f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(151, 'A20E0102F', 'FAN JINCHAO', 'EH4053718', '07-Jul-89', 'Lelaki', 'Bujang', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 204,Guangchang Road, Xinan Town, Sanshui District, Guangdon Province, China', 'Guangdon, China', '13679713131', 'fanjinchao@protonmail.com', 'a20e0102f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(152, 'A19E052F', 'Manthana Krahomwong', 'AC2087854', '14-Feb-74', 'Perempuan', 'Berkahwin', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '99, Faculty of Management, Princess of Naradhiwas University, Khokkhian, 96000 Muang, Nar', 'Thailand', '66812417061', 'manthana.saisuwan@gmail.com', 'manthana.a19e052f@siswa.umk.edu.my', 'Thai', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(153, 'A19E041F', 'Natewadee Petradub', 'AA7799374', '16-Dec-81', 'Perempuan', 'Berkahwin', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '119/3 Mooi Lumphusub,\nDistrict Muangdistrict,\n96000 Muang, Narathiwat, Thailand', 'Muang, Thailand', '66887906381', 'pimmada.kc@gmail.com', 'natawadee.a19e041f@siswa.umk.edu.m', 'Buddh', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(154, 'A20E0164F', 'Li Defu', 'E02985702', '15-Mar-74', 'Lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 51-18-E Menara Bhl Jalan Sultan Ahmad Shah , 10050 Georgetown, Pulau Pinang', 'Georgetown', '184618530', 'lidefu393@gmail.com', 'a20e0164f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(155, 'A19E039F', 'Tippavan Rattanaprom', 'AB3587846', '21-Oct-84', 'Perempuan', 'Berkahwin', 'Thailand', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '99 Knok Knian, Muang, Narathiwat 96000 Thailand', 'Thailand', '6.68711E', 'tippavan.rom@gmail.com', 'tippavan.a19e039f@siswa.umk.edu.my', 'Thai', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(156, 'A20D0198F', 'Muhammad Ikmalul Iktimam bin Mahadhir', '961129-03-5849', '29-Nov-96', 'Lelaki', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 1297, Kampung Badak, 16300 Bachok, Kelantan', 'Bachok', '182174414', 'muhd.ikmalul@gmail.com', 'a20d0198f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(157, 'A20E029F', 'Zheng Qingbo', 'E35365154', '25-Nov-80', 'lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Room 102, No. 12 Lane 226,\nBaiyun Street,\n315000 Ningbo,\nZhejiang, China', 'Ningbo, China', '86-138066609', 'kingbo@g-linklogistics.com', 'a20e029f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(158, 'A20E045F', 'Ma Jiqiang', 'E84453198', '07-Jun-78', 'Lelaki', 'Duda', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Room 203 Unit 4 Block 1\nNo. 6 ChongQin Nanlu Qindao City\n266000 Shandong, China', 'Shandong, China', '8.61337E', 'majiqiang@myumk.cn', 'a20e045f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(159, 'A20D0212F', 'Ng Pei Jun', '960622-08-5124', '22-Jun-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', '14 Hala Chemor 2?\nTaman Chemor Mutiara ?\n31200 Chemor , Perak', 'Chemor', '102268726', 'jxjun96@gmail.com', 'a20d0212f@siswa.umk.edu.my', 'Buddh', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(160, 'A20E0179F', 'Reni Mutiarani Saraswati', 'X1009578', '17-Oct-73', 'Perempuan', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Pulomas Barat No.Kav. 88, RT.4/RW.9, Kayu Putih, Pulo Gadung, Jakarta Timur, DKI Jaka', 'Jakarta', '06281271069265', 'reni.saraswati@i3l.ac.id', 'a20e0179f@siswa.umk.edu.my', 'Melay', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(161, 'A20E0175F', 'Anjar Dwi Astono', 'C7315650', '09-Nov-79', 'Lelaki', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jl. Dukuh 1 No.2, KP Kebantenan, RT 3 RW 6, Bekasi, Indonesia', 'West Jawa, Indon', '()8121979775', 'anjar.astono@kalbis.ac.id', 'a20e0175f@siswa.umk.edu.my', 'Katol', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS bACH', 'AKTIF', 0),
(162, 'A20E0139F', 'Liu Liming', 'EH1716948', '19-Oct-77', 'Lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Jiangxi University of Science and Technology NO.86 Hongqidadao, Zhanggong District, 34100', 'China', '8.61348E', 'limingl2020@yeah.net', 'a20e0139f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(163, 'A20E046F', 'Sundas Kashmeeri', 'BF4845623', '03-Jan-79', 'Perempuan', 'Berkahwin', 'Pakistan', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'House No. 24, Sector F, iqbal Bouluad DHA 2, Islamabad, Pakistan', 'Pakistan', '3225151715', 'sundas.kashmeeri@gmail.com', 'a20e046f@siswa.umk.edu.my', 'Islam', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '3', 'KAMPUS KOTA', 'AKTIF', 0),
(164, 'A20D0239F', 'NURUL AZREEN BINTI SALLEH', '950712-01-6158', '12-Jul-95', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'NO 24, JALAN KRISTAL 1, TAMAN KRISTAL, SIMPANG RENGGAM 86200, JOHOR', 'KUBANG PASU', '019-7586612', 'azreensalleh95@gmail.com', 'a20d0239f@siswa.umk.edu.my', 'ISLAM', '', 'BACHELOR OF BUSINESS ADMINISTRATION (ISLAMIC BANKING AND FINANCE) WITH HONOURS', '', '3.2', '2018', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(165, 'A20E0184F', 'ZHU LILI', 'EJ3354893', '07-Jun-82', 'Perempuan', 'Bujang', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'ROOM 1604, BUILDING 18, RONGQIAO YUECHENG COMMUNITY, ZHUYU ROAD, JIN\' AN DISTRICT, FUZHOU', 'JIN\' AN DISTRICT', '13685008282', '12637024@qq.com', 'a20e0184f@siswa.umk.edu.my', NULL, '', 'LITERATURE BACHOLER', '', '', '2005', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(166, 'A20D0211F', 'NUR ATHIRAH BINTI MOHD ALUWI', '960111-01-6020', '11-Jan-96', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'PT. 679, (Seb. Pej. FAMA), Jalan Pondok, Pasir Puteh 16800, kelantan', 'Pasir Puteh', '011-29208350', 'tiyrah29@gmail.com', 'a20d0211f@siswa.umk.edu.my', 'Islam', '', 'Bachelor Of Economic', ' UIAM', '3.44', '2020', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(167, 'A20E0199F', 'MENG XIANGFU', 'EB6158627', '24-Aug-85', 'Lelaki', 'Tidak Din', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No 51-81 Menara BHL Sultan Ahmad Shah 10050 Georgetown Pulau Pinang', 'Georgetown', '011-22948344', '?xiangfumeng@yahoo.com', 'a20e0199f@siswa.umk.edu.my', 'Chine', '', 'Bachelor Degree Of Engineering', ' Jiangsu University', '2.8', '2009', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(168, 'A20E0183F', 'LINDA HETRI SURIYANTI', 'C7193265', '28 Sept 1984', 'Perempuan', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'JL. Rawa Mangun No 63 Tangkerang Labuah Pekanbaru Riau Indonesia', 'Pekanbaru', '82169456666', 'lindahetri@umri.ac.id', 'a20e0183f@siswa.umk.edu.my', 'Islam', 'Jawa', '', '', '', '', 'Sarjana Ekonomi (S.E)', ' Universitas Muhammadiyah Jember', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(169, 'A20D0279F', 'NURFAIZ BIN NORDIN', '901216-03-6693', '16/12/1990', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'No 1055, Jalan Tengku Maheran 22, Taman Tengku Maheran, mukim Naga Jitra Kedah, 06000, Ke', 'Jitra', '013-7191303', 'nurfaiznordin.424@gmail.com', 'a20d0279f@siswa.umk.edu.my', 'Islam', '', 'Ijazah Sarjana Muda Kejuruteraan Mekanikal', ' UTHM', '3.09', '2014', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(170, 'A20E0141F', 'Zeng Chunlong', 'EB5928148', '17-Jun-76', 'Lelaki', 'Bujang', 'China', 'Antarabangsa', 'Dok', 'Doktor Falsafah', 'Penuh Masa', 'No. 51-18-E Menara Bhl Jalan Sultan Ahmad Shah , 10050 Georgetown, Pulau Pinang', 'Georgetown', '184618530', 'zengzhunlong@gmail.com', 'a20e0141f@siswa.umk.edu.my', 'Bebas', '', '', '', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '2020', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(171, 'A20E0213F', 'ZHEN XIAOQING', 'EH7549524', '1983-06-02', 'Perempuan', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'NO. 166 EAST ROAD GUANGZHOU CITY,\nGUANGDONG PROVINCE, CHINA 510900 CHINA', '', '', '973017140@qq.com', 'a20e0213f@siswa.umk.edu.my', 'CHINA', '', 'BACHELOR OF MANAGEMENT', ' SOUTH CHINA UNIVERSITY O', '78', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(172, 'A20E0214F', 'CHEN LI', 'EC2438150', '13-12-1979', 'Perempuan', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No. 336, Dongfeng South Road Zhuhui District Hengyang City, Hunan Province 421005 China', 'Zhuhui District', '8.61897E', '2935929422@qq.com', 'a20e0214f@siswa.umk.edu.my', 'Chine', '', 'Bachelor of Medicine', ' Central South University', '7.5', '2006', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(173, 'A20D058F', 'FATIN NAJIHAH BINTI NIK MUHAMMAD', '950927-03-5786', '27-09-1995', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 1594 Kampung Tanjung Stan 16150 Kota Bharu Kelantan', 'Kota Bharu', '011-10902795', 'najihah.a16a0174@siswa.umk.edu.my', 'a20d058f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Ijazah Sarjana Muda Keusahawanan (Perdagangan)', ' UMK', '3.14', '2020', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(174, 'A20D061F', 'SITI NORJANNAH BINTI MOHD JAMIL', '950922-10-5124', '22-09-1995', 'Perempuan', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'No.3, Jalan Dato Ghani Batu 6 Kampung Asahan 45600 Bestari Jaya Selangor', 'Kuala Selangor', '019-3261643', 'nurjannahmohdjamil@gmail.com', 'a20d061f@siswa.umk.edu.my', 'Islam', '', 'Bachelor Degree Of Health Entrepreneurship (SAW', ' UMK', '3.72', '2019', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(175, 'A20E0276F', 'WU RUIHUI', 'EJ4015750', '1980-09-02', 'Perempuan', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '51-18-E Menara BHL Jalan Sultan Ahmad Shah Georgetown 10050 Pulau Pinang', 'Georgetown', '011-33948344', '12583953@qq.com', 'a20e0276f@siswa.umk.edu.my', 'Chine', '', 'Bachelor of Arts', ' Central South University', '2.77', '2008', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(176, 'A20E048F', 'MUHAMMED ALHAJI ABUBAKAR', 'A11737853', '1989-10-03', 'Lelaki', 'Berkahwin', 'Nigeria', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Department of Business Administration Bayero University Kano Nigeria, Kano, Nigeria', 'Kano', '2.34704E', 'abumuhammed89@yahoo.com', 'a20e048f@siswa.umk.edu.my', 'Islam', '', 'Bachelor of Business Administration', ' Bayero University', '4.58', '', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(177, 'A20D070P', 'ANTONY BARUBUI', '700519-12-5131', '19-05-1970', 'Lelaki', 'Berkahwin', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Separuh Masa', 'C25-33 Lorong 14 Taman Indah Permai 88450 Kota Kinabalu Sabah', 'Tuaran', '013-5551010', 'antonyb.angkasa@gmail.com', 'a20d070p@siswa.umk.edu.my', 'Krist', 'Dusun', 'Ijazah Sarjana Muda Ekonomi dengan kepujian', ' UKM', '3.13', '1996', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(178, 'A20E0275F', 'JIANG NI', 'EJ4015634', '23-03-1985', 'Perempuan', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '51-18-E Menara BHL Jalan Sultan Ahmad Shah Georgetown 10050 Pulau Pinang', 'Georgetown', '011-33948344', 'jiangni.jni1@outlook.com', 'a20e0275f@siswa.umk.edu.my', 'Chine', '', 'Bachelor?s Degree Of Management', ' Taiyuan University Of Te', '2.99', '2007', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(179, 'A20E071F', 'NALINE A/P LOKANATHAN', '861202-56-5558', '1986-02-12', 'Perempuan', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'No 167 Jalan Jasmin 9, Taman Jasmin 43000 Kajang Selangor', 'Hulu Langat', '010-2255194', 'naline02@gmail.com', 'a20e071f@siswa.umk.edu.my', 'Hindu', '', 'Bachelor?s Degree Of Bioinformatics', ' UNISEL', '3.35', '2009', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(180, 'A20E0277F', 'LIU HAIHONG', 'EJ4015510', '21-04-1978', 'lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', '51-18-E Menara BHL Jalan Sultan Ahmad Shah Georgetown 10050 Pulau Pinang', 'Georgetown', '011-33948344', 'liuhaihong53@gmail.com', 'a20e0277f@siswa.umk.edu.my', 'Chine', '', 'Bachelor Of Literature', ' Hunan Normal University', '2.76', '2001', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(181, 'A20E009F', 'XIA FANG', 'EE7181223', '18-04-1992', 'lelaki', 'Berkahwin', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Room 407, Building 3, No. 120, Heping West Road, Liwan Ditrict, Guangzhou City, Guangdong', 'Guangzhou City', '8.61356E', 'xiaf1218@163.com', 'a20e009f@siswa.umk.edu.my', 'Chine', '', 'Bachelor Of Management', ' Hubei University Of Econ', '82.2', '2014', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(182, 'A20E056F', 'MUBASHIR NAVID AHMAD', 'SZ1151113', '26-09-1978', 'Lelaki', 'Berkahwin', 'Pakistan', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Union Insurance Co. Single Business Tower 13th Floor 119227 Dubai', 'Kasur', '9.71552E', 'mubashirnavid@gmail.com', 'a20e056f@siswa.umk.edu.my', 'Islam', 'Asiani', 'B.Com', ' University of the Punjab', '58%', '2000', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(183, 'A20D0222F', 'MUHAMMAD FAZLAN BIN MOHD HUSAIN', '911203-03-6343', '1991-03-12', 'Lelaki', 'Bujang', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'PT 14320 Taman Desa Sejati Jalan Padang Siam 17500 Tanah Merah Kelantan', 'Tanah Merah', '018-9710900', 'fazlanhusain911203@gmail.com', 'a20d0222f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'Sarjana Muda Keusahawanan (Peruncitan)', ' UMK', '3.15', '2019', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(184, 'A20E075F', 'CITRA RAMAYANI', 'C6307891', '1984-10-02', 'Perempuan', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Griya Pesona C1 RT004 RW001 Kelurahn, Bungo Pasang 25171, Padang Sumatera Barat Indonesia', 'Padang', '6.28136E', 'ramayanicitra@gmail.com', 'a20e075f@siswa.umk.edu.my', 'Islam', 'Melayu', '', '', '', '', 'Sarjana Sains', ' Universitas Negeri Padang', '3.45', '2006', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(185, 'A20E074F', 'RIKA VERAWATI', 'B6080630', '17-12-1987', 'Perempuan', 'Berkahwin', 'Indonesi', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'STKIP PGRI Sumbar JL Gunung Panggilun, Padang Utara 25111 Padang Sumbar Indonesia', 'Padang', '6.28526E', 'rika.pekonstkip@gmail.com', 'a20e074f@siswa.umk.edu.my', 'Islam', 'Promel', '', '', '', '', 'Sarjana Pendidikan', ' Universitas Negeri Padang', '3.17', '2009', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(186, 'A20D0290F', 'Ezatty Ariefah Binti Che Pa', '960703-03-6180', '1996-03-07', 'Perempuan', 'Berkahwin', 'Malaysia', 'Tempatan', 'SAR', 'Sarjana Keusahawanan', 'Penuh Masa', 'Lot 479 Dekat Masjid Padang Enggang Wakaf Che Yeh Kota Bharu 15100 kelantan', 'Kota Bharu', '018-3888098', 'ezattyariefah@yahoo.com', 'a20d0290f@siswa.umk.edu.my', 'Islam', 'Melayu', 'Bachelor Of Islamic Finance (Bangking) (Hons)', ' KUIS', '3.17', '2019', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(187, 'A20E053F', 'IEEQAN ALI QURESHI', 'AG4918404', '1972-02-02', 'Lelaki', 'Berkahwin', 'Pakistan', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'Bait Ul Marsoos, E 310, Kausar Town, Malir, Karachi - 75080, Pakistan', 'Karachi', '9.23142E', 'ieeqan@gmail.com', 'a20e053f@siswa.umk.edu.my', 'Islam', 'Asian', '', '', '', '', ' M. Sc. (MASTER OF SCIENCE MBA BUSINESS SCHOOL)', ' INSTITUTE OF BUSINESS MANAGEMENT', '3', '2000', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(188, 'A20E055F', 'WINIFRED ADDOBEA', 'G3103214', '1976-08-07', 'Perempuan', 'Berkahwin', 'Ghana', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'P.O.BOX AY 350, ASWOYEBOQB, KUMASI, GHANA', 'KUMASI', '246046001', 'winkaydd@yahoo.com', 'a20e055f@siswa.umk.edu.my', 'Krist', '', 'BACHELOR OF EDUCATION', ' UNIVERSITY OF EDUCATION ', '3.07', '2001', '', '', '', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0);
INSERT INTO `pg_student_data2` (`id`, `NO_MATRIK`, `NAMA_PELAJAR`, `NO_IC`, `TARIKH_LAHIR`, `JANTINA`, `TARAF_PERKAHWINAN`, `NEGARA_ASAL`, `KEWARGANEGARAAN`, `KOD_PROGRAM`, `PROGRAM_PENGAJIAN`, `TARAF_PENGAJIAN`, `ALAMAT`, `DAERAH`, `NO_TELEFON`, `EMEL_PERSONAL`, `EMEL_PELAJAR`, `AGAMA`, `BANGSA`, `NAMA_SARJANA_MUDA`, `UNIVERSITI_SARJANA_MUDA`, `CGPA_SARJANA_MUDA`, `TAHUN_SARJANA_MUDA`, `NAMA_SARJANA`, `UNIVERSITI_SARJANA`, `CGPA_SARJANA`, `TAHUN_SARJANA`, `SESI_MASUK`, `TAHUN_KEMASUKAN`, `TARIKH_KEMASUKAN`, `PEMBIAYAAN`, `admission_date`, `SEMESTER`, `KAMPUS`, `STATUS`, `done_import`) VALUES
(189, 'A20E0300F', 'NORILAKASMANIRA BINTI NOOR', '701212-03-5232', '1970-12-12', 'Perempuan', 'Berkahwin', 'Malaysia', 'Tempatan', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'JABATAN PERHUBUNGAN PERUSAHAAN KELANTAN, ARAS 3, WISMA PERSEKUTUAN JLN BAYAM 15530, KOTA ', 'KOTA BHARU', '012-9888063', 'norilakasmanira@gmail.com', 'a20e0300f@siswa.umk.edu.my', 'Islam', 'Melayu', 'SARJANA MUDA PENTADBIRAN PERNIAGAAN', ' UiTM', '', '2007', 'SARJANA PENGURUSAN PERNIAGAAN', ' UiTM', '2.49', '', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(190, 'A20E054F', 'CHEN ZAI DIE', 'E02187466', '11-Nov-81', 'lelaki', 'tidak Din', 'China', 'Antarabangsa', 'DOK', 'Doktor Falsafah', 'Penuh Masa', 'ROOM 602 UNIT 1 BUILDING WANJIA GARDEN, WANHEYUAN JIANGUAN DISTRICT, HANGZHUON CITY, 3100', 'HANGZHUON CITY', '8.61861E', 'chenzaidie@myumk.cn', 'a20e054f@siswa.umk.edu.my', 'CHINE', '', '', '', '', '', 'COMPUTER INFORMATIONS MANAGEMENT', ' HANGZHOU DIANZI UNIVERSITY', '', '2009', 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '2', 'KAMPUS KOTA', 'AKTIF', 0),
(191, 'A20E0293F', 'HUANG KENG', 'EJ4016398', '06-Jan-85', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'Doktor Falsafah', 'PENUH MASA', '51-18-E MENARA BHL JALAN SULTAN AHMAD SHAH GEORGETOWN,10050 PULAU PINANG', 'CHINA', '6.01134E', '407941920@qq.com', 'a20e0293f@siswa.umk.edu.my', 'Tiada', '', 'BACHELOR OF MANAGEMENT', ' ZHONGKAI UNIVERSITY OF A', '2.5', '2007', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(192, 'A20E0217F', 'IKLIMA HUSNA BINTI ABDUL RAHIM', '890903-03-5042', '03-SEPT-1989', 'PEREMPUAN', 'BUJANG', 'Malaysia', 'TEMPATAN', 'DOK', 'Doktor Falsafah', 'PENUH MASA', 'PT 561 BELAKANG TAMAN KOPERATIF JALAN TOK GURU, 15400 KOTA BHARU, KELANTAN', 'KOTA BHARU', '012-9880887', 'iklimahusna@gmail.com', 'a20e0217f@siswa.umk.edu.my', 'Islam', 'melayu', 'SARJANA MUDA TEKNOLOGI MAKLUMAT', ' UKM', '3.31', '2012', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'SKIM LATIHAH AKADEMIK BUMIPUTERA (SLAB), (01.10.2021 - 30.09.2024)', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(193, 'A20D066F', 'CHEN XU', 'EC5196052', '08-Feb-92', 'LELAKI', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'SAR', 'SARJANA KEUSAHAWANAN', 'PENUH MASA', 'Room 2203, Building B, Tianzuo International Center No. 12, South Zhongguancun Street, Ha', 'BEIJING', '()1827916319', '371376861@qq.com', 'a20d066f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR OF PNEUMATIC TECHNOLOGY', ' CHINA WESTERN AVIATION V', '', '2010', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(194, 'A20E052F', 'RIFFAT SHAHZADY', 'BH5124444', '01-Feb-79', 'PEREMPUAN', 'BERKAHWIN', 'Pakistan', 'ANTARABANGSA', 'DOK', 'Doktor Falsafah', 'PENUH MASA', 'WARDON HOUSE FTZ HOSTLE WOMEN, UNIVERSITY SIALKOT, PUNJAB, PAKISTAN', 'PUNJAB', '????', 'riffatchaudharypu@gmail.com', 'a20e052f@siswa.umk.edu.my', 'ISLAM', '', 'BACHELOR OF ART (BUSINESS)', ' PUNJAB UNIVERSITY LAHHOR', '1ST ', '2000', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(195, 'A20E0238F', 'GONI KUWATA MOHAMMED', 'B50074407', '22-Dec-59', 'LELAKI', 'BERKAHWIN', 'Nigeria', 'ANTARABANGSA', 'DOK', 'Doktor Falsafah', 'PENUH MASA', 'HOUSE NO 398 CEDER STREET, MAB GLOBAL, ESTATE, EFAB ABUJA, FEDERAL CAPITAL, TERRITORY, 21', 'ABUJA', '????', 'kuwatagoni@gmail.com', 'a20e0238f@siswa.umk.edu.my', 'ISLAM', '', 'BACHELOR OF SCIENCE (BUSINESS MANAGEMENT)', ' UNIVERSITY OF MAIDUGURI', '2.5', '1985', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(196, 'A20E0162P', 'GNANA PRABHA A/P KRISHNAMURTI @ KRISHNAN', '870414-56-5300', '14-Apr-87', 'PEREMPUAN', 'BERKAHWIN', 'Malaysia', 'TEMPATAN', 'DOK', 'Doktor Falsafah', 'SEPARUH MASA', 'NO 5-1 JALAN AMANSIARA 3/2\nTAMAN AMANSIARA\n48000 SELANGOR', 'SELANGOR', '012-8055514', 'prabhakrish14@yahoo.com', 'a20e0162p@siswa.umk.edu.my', 'Krist', '', 'BACHELOR OF BUSINESS ADMINISTRATION', ' CITY UNIVERSITY MALAYSIA', '3.89', '2016', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS BACH', 'AKTIF', 0),
(197, 'A20D077P', 'THIIRUCHELVI A/P GUNASAGARAN', '840321-09-5082', '21-Mar-84', 'PEREMPUAN', 'BERKAHWIN', 'Malaysia', 'TEMPATAN', 'SAR', 'SARJANA KEUSAHAWANAN', 'SEPARUH MASA', 'PEJABAT PENDIDIKAN DAERAH KUALA KRAI, 18000 KUALA KRAI, KELANTAN', 'KUALA KRAI', '011-12896981', 'thiiruchelvi.gsm@gmail.com', 'a20d077p@siswa.umk.edu.my', 'HINDU', '', 'IJAZAH SARJANA MUDA KOMPUTERAN INDUSTRI', ' UKM', '2.76', '2007', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'TAJAAN HADIAH LATIHAN PERSEKUTUAN SAMBILAN (HLPS)', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(198, 'A21E006F', 'JIN LILI', 'EJ5034975', '03-Apr-81', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang No.3, Jalan Larut Georgetown, 10050 Penang', 'Georgetown', '011-33948344', 'jinlili.jl81@outlook.com', 'a21e006f@siswa.umk.edu.my', 'Tiada', '', 'BACHELOR OF MANAGEMENT', ' TIANJIN UNIVERSITY OF CO', '3.34', '2005', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS BACH', 'AKTIF', 0),
(199, 'A20E073F', 'ONUKWUBE TOBENNA', 'A09627527', '10-Oct-88', 'LELAKI', 'BERKAHWIN', 'Nigeria', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', 'PLOT 1300 FUNILAYO, RANSOME KUTI STREET, GARKI 11 ABUJA, 500 FCT - ABUJA, NIGERIA', 'ABUJA', '????', 'tobennaonukwube@gmail.com', 'a20e073f@siswa.umk.edu.my', 'Krist', '', 'BACHELOR OF ENGINEERING (COMPUTER ENGINEERING)', ' MICHEAL OKPARA UNIVERSIT', '', ' ', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS BACH', 'AKTIF', 0),
(200, 'A21E028P', 'ERDY IZWAN BIN ASLI', '820622-11-5675', '22-Jun-82', 'LELAKI', 'BERKAHWIN', 'Malaysia', 'TEMPATAN', 'DOK', 'DOKTOR FALSAFAH', 'Separuh Masa', 'NO. 7 JALAN 6/7 BANDAR TASIK PUTRI 48020 RAWANG, SELANGOR', 'RAWANG', '019-2729627', 'erdy.angkasa@gmail.com', 'a21e028p@siswa.umk.edu.my', 'ISLAM', '', '', '', '', '', 'SARJANA MUDA KEWANGAN', ' UUM', '2.3', '2016', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', '', '0000-00-00', '1', 'KAMPUS', 'AKTIF', 0),
(201, 'A21E027P', 'ABU BAKAR BIN BUSMAH', '770411-13-5817', '11-Apr-77', 'LELAKI', 'BERKAHWIN', 'Malaysia', 'TEMPATAN', 'DOK', 'DOKTOR FALSAFAH', 'Separuh Masa', 'NO 203 BLOK C8 SEKSYEN 1 BANDAR BARU WANGSA MAJU SETAPAK 53300 KUALA LUMPUR', 'SETAPAK', '019-3399389', 'abubakarbusmah.angkasa@gmail.com', 'a1e027p@siswa.umk.edu.my', 'ISLAM', '', '', '', '', '', 'SARJANA MUDA PENGURUSAN AWAM', ' UUM', '2.92', '2001', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', '', '0000-00-00', '1', 'KAMPUS', 'AKTIF', 0),
(202, 'A21D031F', 'SITI HANIS BINTI MOHD SHAMMA', '971103-43-5114', '03-Nov-97', 'PEREMPUAN', 'BUJANG', 'Malaysia', 'TEMPATAN', 'SAR', 'SARJANA KEUSAHAWANAN', 'SEPENUH MASA', 'NO. 18 JALAN 5A/8, TAMAN LANGAT JAYA, SEKSYEN 5, 43650 BANDAR BARU BANGI, SELANGOR', 'SELANGOR', '016-3521351', 'hanisshamma504@gmail.com', 'a21d031f@siswa.umk.edu.my', 'ISLAM', '', 'BACHELOR DEGREE IN BUSINESS ADMINISTRATION (ISLAMIC BANKING AND FINANCE)', ' UMK', '3.42', '2020', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS JELI', 'AKTIF', 0),
(203, 'A21E014F', 'MO HUANAN', 'E21252598', '21-10-1981', 'LELAKI', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15TH FLOOR OFFICE TOWER, HOTEL ROYAL PENANG, NO 3, JALAN LARUT, 10050, PULAU PINANG', 'Penang', '011-22948344', 'ad.hkgs2018@gmail.com', 'a21e014f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR?S DEGREE IN MANGEMENT (MARKETING)', ' SHANXI NORMAL UNIVERSITY', '3.12', '2005', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(204, 'A21E030P', 'NURUL FAIZAH BINTI HALIM', '8.4012E', '20-Jan-84', 'PEREMPUAN', 'BERKAHWIN', 'Malaysia', 'TEMPATAN', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', 'NO.415 KG PULAU NYIOR, 06000 JITRA, KEDAH', 'KEDAH', '011-26593090', 'nurulfaizahhalim@gmail.com', 'a21e030p@siswa.umk.edu.my', 'ISLAM', '', 'IJAZAH SARJANA MUDA EKONOMI', ' UUM', '3.54', '2007', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(205, 'A21E016F', 'SONG CHEN', 'E29927389', '01-Jun-87', 'PEREMPUAN', 'BUJANG', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', 'NO.23 CHUNRONG STREET, CHENGGONGDI STRICT, KUNMING CITY, 65000 KUNMINGM YUNNAN, CHINA', 'CHINA', '8.61869E', '1793355385@qq.com', 'a21e016f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR OF BUSINEES ADINISTRATION', ' BEIJING NORMAL UNIVERSIT', '3', '2009', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS JELI', 'AKTIF', 0),
(206, 'A21E013F', 'MA JIANMEI', 'EJ3309605', '06-May-80', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang No.3, Jalan Larut Georgetown, 10050 Penang', 'PENANG', '011-33948344', 'ma.jianmei80@outlook.com', 'a21e013f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR?S DEGREE OF ECONOMICS (INTERNATIONAL TRADE)', ' LIAONING UNIVERSITY', '3.34', '2003', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(207, 'A21D029F', 'TANG JIT YANG', '970325-10-5343', '25-Mar-97', 'LELAKI', 'BUJANG', 'Malaysia', 'TEMPATAN', 'SAR', 'SARJANA KEUSAHAWANAN', 'SEPENUH MASA', 'F-3A-10 Pangsapuri Palma, Jalan Palma Raja\n3/KS6 Bandar Botanic\n41200 Klang, Selangor', 'SELANGOR', '017-3223808', 'jackytang250397@gmail.com', 'a21d029f@siswa.umk.edu.my', 'BUDDH', '', 'SARJANA MUDA KEUSAHAWANAN (LOGISTIK DAN PERNIAGAAN PENGEDARAN)', ' UMK', '3.39', '2021', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(208, 'A21E032F', 'MOHAMAD SYARIF BIN SAUFI', '900117-03-5367', '17-Jan-90', 'LELAKI', 'BUJANG', 'Malaysia', 'TEMPATAN', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', 'Lot 1349 Jalan Bypass\n16800 Pasir Puteh, Kelantan', 'PASIR PUTIH', '010-8015422', 'syarifsaufi@yahoo.com', 'a21e032f@siswa.umk.edu.my', 'ISLAM', '', 'BBA (HONS) IN HRM (HUMAN RESOURSE MANAGEMENT', ' UNIVERSITI TENAGA NASION', '3.22', '2013', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(209, 'A21E015F', 'GU YINHUA', 'EJ4048547', '20-Aug-84', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang\nNo.3 Jalan Larut Georgetown\n10050 Penang', 'PENANG', '011-33948344', 'ad.hkgs2018@gmail.com', 'a21e015f@siswa.umk.edu.my', 'TIADA', '', 'Bachelor?s Degree in Management (Logistics Management)', ' Guangdong Polytechnic No', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(210, 'A21E005F', 'THAMMANYANTEE PHAYOONPUN', 'AB1493829', '20-Jul-76', 'PEREMPUAN', 'BUJANG', 'Thailand', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '57/5 Suriyapradid Rd Bangnak\n96000 Muang, Narathiwat\nThailand', 'THAILAND', NULL, 'thammayantee92860@gmail.com', 'a21e005f@siswa.umk.edu.my', 'BUDDH', '', 'BACHELOR OF ENGENEERING', ' MAHANAKORN UNIVERSITY OF', '2.35', '1999', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(211, 'A21E019F', 'Wang Xinyu', 'EA5163867', '08-May-94', 'LELAKI', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang\nNo.3 Jalan Larut Georgetown\n10050 Penang', 'PENANG', '011-33948344', 'wang.xinyu94@outlook.com', 'a21e019f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR?S DEGREE IN ARTS (DIGITAL MEDIA ART (NETWORK MULTIMEDIA DIRECTION)', ' COMMUNICATION UNIVE', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(212, 'A21E039F', 'Yu Xiaoqin', 'E63039975', '17-May-82', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang\nNo.3 Jalan Larut Georgetown\n10050 Penang', 'PENANG', '011-33948344', 'yuxiaoqin.82@outlook.com', 'a21e039f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR?S DEGREE IN MANAGEMENT (BUSINESS ADMINISTRATION (INTERNATIONAL ACCOUNTING))', ' SHANTOU UN', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(213, 'A21E038F', 'WANG PEIJING', 'E89573516', '01-April-198', 'PEREMPUAN', 'BERKAHWIN', 'China', 'ANTARABANGSA', 'DOK', 'DOKTOR FALSAFAH', 'SEPENUH MASA', '15th Floor Office Tower, Hotel Royal Penang No.3 Jalan Larut Geogetown, 10050 Penang', 'PENANG', '011-33948344', '529771995@qq.com', 'a21e038f@siswa.umk.edu.my', 'TIADA', '', 'BACHELOR DEGREE OF MANAGEMENT (MARKETING)', ' POLYTECHNIC INSTITUTE TA', '', '', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0),
(214, 'A21D046F', 'NOR SYAZLEEN BINTI AZAHAR', '980324-03-5928', '24-Mar-98', 'PEREMPUAN', 'BUJANG', 'Malaysia', 'TEMPATAN', 'SAR', 'SARJANA KEUSAHAWANAN', 'SEPENUH MASA', 'PT74 LORONG MASJID AL-JUNNAH\nKAMPUNG KUKANG PEROL\n16010 KOTA BHARU, KELANTAN', 'KOTA BHARU', '014-2904656', 'syazleenazahar98@gmail.com', 'a21d046f@siswa.umk.edu.my', 'ISLAM', '', 'IJAZAH SARJANA MUDA KEUSAHAWANAN (KEUSAHAWANAN KESIHATAN)', ' UMK', '3.26', '2021', '', '', '', '', 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022', '2021', '', 'Pembiayaan Sendiri', '0000-00-00', '1', 'KAMPUS KOTA', 'AKTIF', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_sem`
--

CREATE TABLE `pg_student_sem` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `date_register` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `fee_amount` decimal(11,2) DEFAULT NULL,
  `fee_paid_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_stage`
--

CREATE TABLE `pg_student_stage` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `remark` text NOT NULL,
  `chairman_id` text,
  `semester_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `stage_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_sv`
--

CREATE TABLE `pg_student_sv` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `appoint_at` date DEFAULT NULL,
  `sv_role` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_supervisor`
--

CREATE TABLE `pg_supervisor` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `external_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_supervisor`
--

INSERT INTO `pg_supervisor` (`id`, `staff_id`, `external_id`, `created_at`, `updated_at`, `is_internal`) VALUES
(1, 3, NULL, 1647850363, 1647850363, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pg_sv_field`
--

CREATE TABLE `pg_sv_field` (
  `id` int(11) NOT NULL,
  `sv_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_sv_field`
--

INSERT INTO `pg_sv_field` (`id`, `sv_id`, `field_id`) VALUES
(1, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pg_external`
--
ALTER TABLE `pg_external`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_field`
--
ALTER TABLE `pg_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_kursus`
--
ALTER TABLE `pg_kursus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

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
-- Indexes for table `pg_res_stage`
--
ALTER TABLE `pg_res_stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_semester_module`
--
ALTER TABLE `pg_semester_module`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_sem_id` (`student_sem_id`);

--
-- Indexes for table `pg_stage_examiner`
--
ALTER TABLE `pg_stage_examiner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stage_id` (`stage_id`),
  ADD KEY `examiner_id` (`examiner_id`);

--
-- Indexes for table `pg_student`
--
ALTER TABLE `pg_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_no` (`matric_no`);

--
-- Indexes for table `pg_student_data`
--
ALTER TABLE `pg_student_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_student_data2`
--
ALTER TABLE `pg_student_data2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_student_sem`
--
ALTER TABLE `pg_student_sem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `pg_student_stage`
--
ALTER TABLE `pg_student_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `pg_student_sv`
--
ALTER TABLE `pg_student_sv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `pg_supervisor`
--
ALTER TABLE `pg_supervisor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`),
  ADD UNIQUE KEY `external_id` (`external_id`);

--
-- Indexes for table `pg_sv_field`
--
ALTER TABLE `pg_sv_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sv_id` (`sv_id`),
  ADD KEY `field_id` (`field_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pg_external`
--
ALTER TABLE `pg_external`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_field`
--
ALTER TABLE `pg_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pg_kursus`
--
ALTER TABLE `pg_kursus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_kursus_anjur`
--
ALTER TABLE `pg_kursus_anjur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_kursus_kategori`
--
ALTER TABLE `pg_kursus_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_kursus_peserta`
--
ALTER TABLE `pg_kursus_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_res_stage`
--
ALTER TABLE `pg_res_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pg_semester_module`
--
ALTER TABLE `pg_semester_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_stage_examiner`
--
ALTER TABLE `pg_stage_examiner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_student`
--
ALTER TABLE `pg_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `pg_student_data`
--
ALTER TABLE `pg_student_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `pg_student_data2`
--
ALTER TABLE `pg_student_data2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `pg_student_sem`
--
ALTER TABLE `pg_student_sem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_student_stage`
--
ALTER TABLE `pg_student_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_student_sv`
--
ALTER TABLE `pg_student_sv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_supervisor`
--
ALTER TABLE `pg_supervisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pg_sv_field`
--
ALTER TABLE `pg_sv_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pg_kursus`
--
ALTER TABLE `pg_kursus`
  ADD CONSTRAINT `pg_kursus_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `pg_kursus_kategori` (`id`);

--
-- Constraints for table `pg_semester_module`
--
ALTER TABLE `pg_semester_module`
  ADD CONSTRAINT `pg_semester_module_ibfk_1` FOREIGN KEY (`student_sem_id`) REFERENCES `pg_student_sem` (`id`);

--
-- Constraints for table `pg_stage_examiner`
--
ALTER TABLE `pg_stage_examiner`
  ADD CONSTRAINT `pg_stage_examiner_ibfk_1` FOREIGN KEY (`stage_id`) REFERENCES `pg_student_stage` (`id`),
  ADD CONSTRAINT `pg_stage_examiner_ibfk_2` FOREIGN KEY (`examiner_id`) REFERENCES `pg_supervisor` (`id`);

--
-- Constraints for table `pg_student_sem`
--
ALTER TABLE `pg_student_sem`
  ADD CONSTRAINT `pg_student_sem_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `pg_student` (`id`);

--
-- Constraints for table `pg_student_stage`
--
ALTER TABLE `pg_student_stage`
  ADD CONSTRAINT `pg_student_stage_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `pg_student` (`id`);

--
-- Constraints for table `pg_student_sv`
--
ALTER TABLE `pg_student_sv`
  ADD CONSTRAINT `pg_student_sv_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `pg_student` (`id`),
  ADD CONSTRAINT `pg_student_sv_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `pg_supervisor` (`id`);

--
-- Constraints for table `pg_supervisor`
--
ALTER TABLE `pg_supervisor`
  ADD CONSTRAINT `pg_supervisor_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `pg_supervisor_ibfk_2` FOREIGN KEY (`external_id`) REFERENCES `pg_external` (`id`);

--
-- Constraints for table `pg_sv_field`
--
ALTER TABLE `pg_sv_field`
  ADD CONSTRAINT `pg_sv_field_ibfk_1` FOREIGN KEY (`sv_id`) REFERENCES `pg_supervisor` (`id`),
  ADD CONSTRAINT `pg_sv_field_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `pg_field` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
