-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2022 at 09:45 AM
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
-- Table structure for table `pg_external`
--

CREATE TABLE `pg_external` (
  `id` int(11) NOT NULL,
  `ex_name` varchar(200) DEFAULT NULL,
  `university_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_external`
--

INSERT INTO `pg_external` (`id`, `ex_name`, `university_id`, `created_at`, `updated_at`) VALUES
(1, 'asdfasdf', 3, 1647324319, 1647324319);

-- --------------------------------------------------------

--
-- Table structure for table `pg_field`
--

CREATE TABLE `pg_field` (
  `id` int(11) NOT NULL,
  `field_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_field`
--

INSERT INTO `pg_field` (`id`, `field_name`) VALUES
(1, 'sadasd');

-- --------------------------------------------------------

--
-- Table structure for table `pg_module`
--

CREATE TABLE `pg_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_module`
--

INSERT INTO `pg_module` (`id`, `module_name`, `created_at`, `updated_at`) VALUES
(1, 'asdf', 1647315387, 1647315387),
(2, 'Module Semester I', 1647315564, 1647315564);

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
  `nationality` int(11) NOT NULL DEFAULT 158,
  `citizenship` tinyint(1) NOT NULL DEFAULT 1,
  `program_code` varchar(10) DEFAULT NULL,
  `study_mode` tinyint(1) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `city` varchar(225) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `personal_email` varchar(225) DEFAULT NULL,
  `religion` tinyint(2) NOT NULL DEFAULT 1,
  `race` tinyint(2) DEFAULT 1,
  `bachelor_name` varchar(225) DEFAULT NULL,
  `bachelor_university` varchar(225) DEFAULT NULL,
  `bachelor_cgpa` varchar(10) DEFAULT NULL,
  `bachelor_year` varchar(4) DEFAULT NULL,
  `admission_semester` int(11) DEFAULT NULL,
  `admission_year` varchar(4) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `sponsor` varchar(255) DEFAULT NULL,
  `current_sem` int(11) DEFAULT NULL,
  `campus_id` tinyint(4) NOT NULL DEFAULT 2,
  `status` tinyint(4) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pg_student`
--

INSERT INTO `pg_student` (`id`, `user_id`, `matric_no`, `nric`, `date_birth`, `gender`, `marital_status`, `nationality`, `citizenship`, `program_code`, `study_mode`, `address`, `city`, `phone_no`, `personal_email`, `religion`, `race`, `bachelor_name`, `bachelor_university`, `bachelor_cgpa`, `bachelor_year`, `admission_semester`, `admission_year`, `admission_date`, `sponsor`, `current_sem`, `campus_id`, `status`) VALUES
(1, 2622, 'A19D018P', '950210-06-5208', '1995-06-02', 0, 2, 158, 1, 'MIE', 1, 'No.3, Lorong Kempadang Makmur 2/1\r\nTaman Kempadang Makmur\r\n25150 Kuantan\r\nPahang\r\n', 'Pahang', '011-17899590', 'aniszulhisam95@gmail.com', 1, 1, 'Sarjana Muda:Ijazah Sarjana Muda Keusahawanan (Hospitaliti)', 'UMK', '2.72', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(2, 2623, 'A19D022F', '950702-03-6358', '1995-07-02', 0, 2, 158, 1, 'MIE', 1, '4151 B Kampung Paya Senang\n15150 Jalan Telipot\nKota Bharu\nKelantan\n', 'Kota Bharu', '013-9206766', 'aifadinie@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan (Hospitaliti)\n', 'UMK', '3.07', '2019', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(3, 2624, 'A19D003F', '921005-10-5685', '1992-10-05', 1, 2, 158, 1, 'MIF', 1, 'No 25 Jalan TPS 3/9\nTaman Pelangi Semenyih\n43500 Semenyih\nSelangor\n', 'Selangor', '013-4234013', 'arifabdulkhalik@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-04', 'Pembiayaan Sendiri', 5, 2, 10),
(4, 2625, 'A19D008F', '920322-03-6084', '1992-03-22', 0, 2, 158, 1, 'MIF', 1, 'Lot 4129 Jalan Mahsuri\n17500 Tanah Merah\nKelantan\n', 'Tanah Merah', '019-9084590', 'fatin92shah56@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam) dengan Kepujian\n', 'UMK', '2.88', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(5, 2626, 'A19D016P', '880321-62-5078', '1988-03-21', 0, 2, 158, 1, 'MIF', 2, '680-C Jalan Pengkalan Chepa\nTanjung Mas\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '013-9235683', 'sitinayusof@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Perakaunan\n\n', 'USIM', '2.86', '2016', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 4, 2, 10),
(6, 2627, 'A19D002F', '961019-03-5602', '1996-10-19', 0, 2, 158, 1, 'MIF', 1, 'Lot 1994-A Jalan Puteri Saadong\nKampung Kota\n15100 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-9659811', 'idaazlan1910@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(7, 2628, 'A19D014F', '951102-03-6172', '1995-11-02', 0, 2, 158, 1, 'MIF', 1, 'Lot 910, Jalan Sabak\nKampung Tebing\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-7446609', 'amileenyusoff@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)\n', 'UMK', '', '2019', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(8, 2629, 'A19D024F', '930804-03-5518', '1993-08-04', 0, 2, 158, 1, 'MIF', 1, 'Lot 1738 Lorong Hidayah\nKampung Huda Kubang Kerian\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-14962085', 'nurulaidasahira93@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran dan Hubungan Korporat dengan Kepujian\n', 'USIM', '3.25', '2016', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(9, 2630, 'A19D007F', '950605-03-5046', '1995-06-05', 0, 2, 158, 1, 'MIF', 1, 'PT 3622 Lorong Pondok Polis Labok\nKampung Kenanga Labok\n18500 Machang\nKelantan\n', 'Machang', '010-9286585', 'sitinurhananiabdulhamid@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Perbankan dan Kewangan Islam\n\n', 'UUM', '3.12', '2018', 201920201, '2019', '2019-09-03', 'Pembiayaan Sendiri', 3, 2, 10),
(10, 2631, 'A19D033P', '950107-10-5101', '1995-01-07', 1, 2, 158, 1, 'MIE', 2, 'Pt 723 Lorong Masjid Taqwa\nPaya Bemban\n15400 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9444223', 'azimabuhassan@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-15', 'Pembiayaan Sendiri', 3, 2, 10),
(11, 2632, 'A19D032P', '970814-03-5980', '1997-08-14', 0, 2, 158, 1, 'MIF', 2, 'Lot 1342 Lorong Masjid Ar-Rahman\nBandar Banchok\n16300 Bachok\nKelantan\n', 'Bachok', '011-10977357', 'ufatihah@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Fiqh Usul', 'Universiti Mu’tah, Jordan', '3.67', '2019', 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 3, 2, 10),
(12, 2633, 'A19D027F', '951016-03-6053', '1995-10-16', 1, 2, 158, 1, 'MIF', 1, '5156 A Kg. Sireh Bawah Lembah\n15050 Kota Bharu\nKelantan\n', 'Kota Bharu', '0111-6856768', 'luqmanhakim700@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-09-18', 'Pembiayaan Sendiri', 3, 2, 10),
(13, 2634, 'A19D036F', '940710-06-5010', '1994-07-10', 0, 1, 158, 1, 'MIF', 1, 'Lot 1890 Lorong Dato’\nKampung Dusun Raja\nJalan Hospital\n15200 Kota Bharu\nKelantan\n', 'Kota Bharu', '017-3003780', 'nurkhairina94@gmail.com', 1, 1, '', '', '', '', 201920201, '2019', '2019-10-01', 'Pembiayaan Sendiri', 3, 2, 10),
(14, 2635, 'A19D035F', '961023-03-5576', '1996-10-23', 0, 2, 158, 1, 'MIE', 1, 'No 339 Seksyen 61\nBunut Payong\n15150 Kota Bharu\nKelantan\n', 'Kota Bharu', '019-9153389', 'aimisolehah23@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Kejuruteraan Teknologi Kimia Bioproses\n', 'Universiti Kuala Lumpur', '2.79', '2019', 201920201, '2019', '2019-10-01', 'Pembiayaan Sendiri', 3, 2, 10),
(15, 2636, 'A19D066P', '840513-11-5164', '1984-05-13', 0, 1, 158, 1, 'MIE', 2, 'Lot 15012 Taman Impian Murni\nBukit Datu\n21200 Kuala Terengganu\nTerengganu\n', 'Terengganu', '013-9201788', 'norihah_abdullah@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan', 'USM', '2.72', '2007', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(16, 2637, 'A19D064P', '800304-11-5276', '1980-03-04', 0, 1, 158, 1, 'MIE', 2, 'Lot 2705 Kampung Tok Kaya\n21000 Kuala Terengganu\nTerengganu\n', 'Terengganu', '019-3824148', 'mentari1980@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Pengurusan)', 'UKM', '2.97', '2004', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(17, 2638, 'A19D065P', '760301-14-5935', '1976-03-01', 1, 1, 158, 1, 'MIE', 2, 'No 3418 Lorong Seri Budiman\nKampung Mengabang Tengah\n20400 Kuala terengganu', 'Terengganu', '013-9303415', 'kerryzuedy@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UPM', '3.15', '2004', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(18, 2639, 'A19D062F', '950203-03-5908', '1995-02-03', 0, 2, 158, 1, 'MIF', 1, 'No.2 Depan Sekolah Kebangsaan Peria\n18000 Kuala Krai\nKelantan\n', 'Kuala Krai', '017-9246893', 'sitiaisahahmadkamal31@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.15', '2019', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 2, 2, 10),
(19, 2640, 'A19D061F', '960813-03-5250', '1996-08-13', 0, 2, 158, 1, 'MIF', 1, 'No 72 Kampung Bukit Merbau\n16810 Pasir Puteh\nKelantan\n', 'Pasir Puteh', '012-8422300', 'nuratie9604@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.3', '2019', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 3, 2, 10),
(20, 2641, 'A19D054F', '940204-03-5142', '1994-02-04', 0, 2, 158, 1, 'MIE', 1, 'Kampung Guar Gajah\nJalan Dewan Tok Bidan\n02600 Arau\nPerlis\n', 'Perlis', '011-21548914', 'nikaishah07@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Korporat', 'UMK', '2.66', '2017', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(21, 2642, 'A19D055P', '831224-03-5390', '1983-12-24', 0, 1, 158, 1, 'MIE', 2, 'Lot 1911 Kampung Chekok\n16600 Pulai Chondong\nKelantan\n', 'Pulai Chondong', '019-2989322', 'izzati@umk.edu.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Sains Pengajian Maklumat', 'UiTM', '3.47', '2006', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(22, 2643, 'A19D053P', '891020-03-5246', '1989-10-20', 0, 1, 158, 1, 'MIF', 2, 'Lot 1005 Kampung Chempaka\n16100 Kota Bharu\nKelantan\n', 'Kota Bharu', '011-10898912', 'widad_sakura@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan)', 'UiTM', '2.67', '2017', 201920202, '2020', '2020-02-17', 'Pembiayaan Sendiri', 4, 2, 10),
(23, 2644, 'A19D067P', '800702-08-5623', '1980-07-02', 1, 1, 158, 1, 'MIE', 2, 'E-532 (No.1921) Kampung Wakaf Peruas\nJalan Kuala Berang\n20500 Kuala Terengganu\nTerengganu', 'Kuala Terengganu', '012-4603753', 'nasir_kda@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Sains (Matematik)\n\nKelulusan Penilaian Rapi Kertas Kerja Edaran JPPSU', 'USM', '2.26', '2004', 201920202, '2020', '2020-03-02', 'Pembiayaan Sendiri', 4, 2, 10),
(24, 2645, 'A20D025P', '950813-03-6350', '1995-08-13', 0, 2, 158, 1, 'MIF', 1, 'Lot 4144, Jalan Dusun Pinang, Kampung Banggol Kemunting, 17500 Tanah Merah, Kelantan', 'Tanah Merah', '0177310053', 'nurulfathiyahzakaria@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.26', '2018', 202020211, '2020', '2020-10-06', 'Pembiayaan Sendiri', 2, 2, 10),
(25, 2646, 'A20D019F', '950213-03-6269', '1995-02-13', 1, 2, 158, 1, 'MIE', 2, 'Lot 812, Jalan Masjid Baung Bayam, 15200 Kota Bharu, Kelantan', 'Kota Bharu', '0192454169', 'salihanzak13@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan dengan Kepujian', 'UMK', '2.89', '2020', 202020211, '2020', '2020-10-06', 'Pembiayaan Sendiri', 2, 2, 10),
(26, 2647, 'A20D024F', '970917-03-5692', '1997-09-17', 0, 2, 158, 1, 'MIF', 2, 'No. 4176-H, Lorong Che Majid, 15050 Kota Bharu, Kelantan', 'Kota Bharu', '01128324284', 'izaty970917@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Kewangan dan Perbankan Islam)', 'UMK', '3.39', '2020', 202020211, '2020', '2020-10-08', 'Pembiayaan Sendiri', 2, 2, 10),
(27, 2648, 'A20D004F', '950513-03-5102', '1995-05-13', 0, 2, 158, 1, 'MIE', 1, 'Lot 2387, Taman Paduka, Kubang Kerian, 16150 Kota Bharu, Kelantan', 'Kota Bharu', '01115656486', 'nurainabasyira@gmail.com', 1, 1, 'Sarjana Muda:\nBachelor of Aircraft Engineering Technology (Hons) in Avionics', 'UniKL', '3.66', '2019', 202020211, '2020', '2020-10-08', 'Pembiayaan Sendiri', 2, 2, 10),
(28, 2649, 'A20D026P', '761217-02-5548', '1976-12-17', 0, 1, 158, 1, 'MIE', 2, 'PT 3806, Lorong 3C, Seksyen C, Taman Merbau Utama, 16810 Selising, Pasir Puteh, Kelantan', 'Pasir Puteh', '0192004809', 'amirah17.mohammad@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.06', '2002', 202020211, '2020', '2020-10-09', 'Pembiayaan Sendiri', 2, 2, 10),
(29, 2650, 'A20D012F', '930503-03-6509', '1993-05-03', 1, 2, 158, 1, 'MIE', 1, 'Lot 3182, Kg. Wakaf Zain Tawang, 16020 Bachok, Kelantan', 'Bachok', '0137002779', 'nikshukri7777@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keusahawanan', 'UMK', '3.29', '2018', 202020211, '2020', '2020-10-19', 'Pembiayaan Sendiri', 1, 2, 10),
(30, 2651, 'A20D017F', '970826-03-5509', '1997-08-26', 1, 2, 158, 1, 'MIF', 1, 'No. 627, Lorong Kota Kenari 3/5, Taman Kota Kenari, 09000 Kulim, Kedah', 'Kulim', '0139330826', 'syahirnizam.sn@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.46', '2020', 202020211, '2020', '2020-10-19', 'Pembiayaan Sendiri', 1, 2, 10),
(31, 2652, 'A20D031F', '880807-03-5443', '1988-08-07', 1, 2, 158, 1, 'MIE', 1, 'PT 1508 Taman Bendahara\nBaung Seksyen 36\nJalan Pengkalan Chepa\n16100 Kota Bharu\nKelantan', 'Kota Bharu', '017-9074074', 'niknaim@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan', 'UMK', '3.06', '2019', 202020211, '2020', '1970-01-01', 'Pembiayaan Sendiri', 1, 2, 10),
(32, 2653, 'A20D030F', '961107-11-5266', '1996-11-07', 0, 2, 158, 1, 'MIF', 1, 'No 27 Felda Kerteh 4,\nBandar Ketengah Jaya,\n23300 Dungun, Terengganu', 'Dungun', '014-8159327', 'cwhni.nurlisa@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.6', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10),
(33, 2654, 'A20D018F', '970329-07-5460', '1997-03-29', 0, 2, 158, 1, 'MIF', 1, '210 Pokok Tampang, 13300 Tasek Gelugor, Pulau Pinang', 'Tasek Gelugor', '011-14682695', 'aisyahmad293@yahoo.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.22', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10),
(34, 2655, 'A20D034P', '960702-10-5463', '1996-07-02', 0, 2, 158, 1, 'MIE', 1, 'No 31 Jalan Langat Murni, 6/A Taman Langa Murni, Bukit Changgang, 42700 Banting, Selangor', 'Banting', '0126047100', 'taufiq.a16a0364@siswa.umk.edu.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Keushawanan', 'UMK', '3.11', '2020', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10),
(35, 2656, 'A20D033F', '810812-11-5079', '1981-08-12', 0, 1, 158, 1, 'MIF', 1, '161 Kg Lak Lok, 22000 Jerteh, Terengganu', 'Jerteh', '0139287343', 'mdrazi5088@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Undang-Undang', 'IIUM', '2.83', '2005', 202020211, '2020', '2020-10-20', 'Pembiayaan Sendiri', 2, 2, 10),
(36, 2657, 'A20D016F', '961007-02-5474', '1996-10-07', 0, 2, 158, 1, 'MIF', 1, 'No. 63 Jalan Kedidi,\nTaman Sempadan,\n14300 Nibong Tebal,\nPulau Pinang', 'Nibong Tebal', '0183604574', 'amirahamni7@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.54', '2020', 202020211, '2020', '2020-10-22', 'Pembiayaan Sendiri', 2, 2, 10),
(37, 2658, 'A20D032F', '970530-02-5035', '1997-05-30', 0, 2, 158, 1, 'MIF', 1, '47 Villa Nasibah, Jalan Indah 6, Taman Jitra Indah, 06000 Jitra, Kedah', 'Jitra', '013-5829885', 'ayyubabrahman97@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pentadbiran Perniagaan (Perbankan dan Kewangan Islam)', 'UMK', '3.32', '2020', 202020211, '2020', '2020-11-02', 'Pembiayaan Sendiri', 2, 2, 10),
(38, 2659, 'A20D037F', '890209-03-5149', '1989-02-09', 0, 2, 158, 1, 'MIF', 1, 'A-1 Taman Sri Pauh,\n18400 Temangan, Kelantan', 'Temangan', '0145150187', 'zulfaris99@gmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Sains Komputer (Kejuruteraan Perisian)', 'UMP', '3.17', '2012', 202020211, '2020', '2020-11-03', 'Pembiayaan Sendiri', 2, 2, 10),
(39, 2660, 'A20D035P', '760829-71-5051', '1976-08-29', 0, 1, 158, 1, 'MIF', 2, 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0124083344', 'ashrof.shamsuddin@lth.gov.my', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda Pengurusan Perniagaan', 'UUM', '3.06', '2009', 202020211, '2020', '2020-11-05', 'Pembiayaan Sendiri', 1, 2, 10),
(40, 2661, 'A20D038P', '891027-14-5720', '1989-10-27', 0, 1, 158, 1, 'MIF', 2, 'Lembaga Tabung Haji, Menara TH Kota Bharu, Jalan Doktor, 15000 Kota Bharu, Kelantan', 'Kota Bharu', '0193747197', 'zatierahman@gmail.com', 1, 1, 'Sarjana Muda:\nIjazah Sarjana Muda (Kepujian) Perakaunan', 'UiTM', '2.82', '2012', 202020211, '2020', '2020-11-05', 'Pembiayaan Sendiri', 1, 2, 10),
(41, 2662, 'A20D040F', '750802-03-5823', '1975-08-02', 0, 1, 158, 1, 'MIF', 1, 'Pondok Pengkalan Machang To\' Uban, 17050 Pasir Mas, Kelantan', 'Pasir Mas', '0193803804', 'haszlihisham@jkptg.gov.my', 1, 1, 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UKM', '2.4', '1999', 202020211, '2020', '2020-11-10', 'Pembiayaan Sendiri', 2, 2, 10),
(42, 2663, 'A20D041P', '770818-02-5660', '1977-08-18', 0, 1, 158, 1, 'MIF', 1, 'No 1. Taman Sri Pelangi , 06000 Jitra, Kedah', 'Jitra', '0194171177', 'nhhasnita@hotmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Pengurusan Perniagaan', 'UUM', '2.67', '2009', 202020211, '2020', '2020-11-10', 'Pembiayaan Sendiri', 1, 2, 10),
(43, 2664, 'A20D043P', '961203-08-5562', '1996-12-03', 0, 2, 158, 1, 'MIE', 2, 'No. 15, Jalan JH 2, Taman Jana Harmoni,\n34600 Kamunting, \nPerak', 'Kamunting, Perak', '017-7164136', 'tharshini5562@gmail.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Keusahawanan (Peruncitan)', 'UMK', '2.93', '2020', 202020211, '2020', '2020-11-29', 'Pembiayaan Sendiri', 1, 2, 10),
(44, 2665, 'A20D042F', '950416-14-5684', '1995-04-16', 0, 2, 158, 1, 'MIF', 1, 'Lot 1005 Kampung Chempaka, \n Jalan Panji \n 16100 Kota Bharu,\n Kelantan', 'Kota Bharu', '014-5281445', 'lcr_13@yahoo.com', 1, 1, 'Sarjana Muda:\nSarjana Muda Pentadbiran Perniagaan', 'UiTM', '3.09', '2020', 202020211, '2020', '2020-12-13', 'Pembiayaan Sendiri', 1, 2, 10),
(45, 2666, 'A20D036F', '940716-02-5001', '1994-07-16', 0, 1, 158, 1, 'MIF', 1, 'Hadapan Sek. keb. Padang Perahu,\nJalan Kodiang,\n06000 Jitra,\nKedah', 'Jitra, Kedah', '013-4667690', 'fadzlul94@gmail.com', 1, 1, 'Sarjana Muda:\nBachelor of Business Administration (Islamic Banking and Finance)', 'UMK', '3.61', '2017', 202020211, '2020', '2021-02-02', 'Pembiayaan Sendiri', 1, 2, 10),
(46, 2667, 'A20D049F', '911007-11-5810', '1991-10-07', 0, 2, 158, 1, 'MIE', 1, 'Lot PT 794 435A Kampung Kubang Kura 20050, Kuala Terengganu', 'Kuala Terengganu', '010-4425800', 'majidatulkamalia@yahoo.com', 1, 1, 'Sarjana Muda: Undang-Undang dengan Kepujian', 'UUM', '2.8', '2015', 202020212, '2020', '2021-03-14', 'Pembiayaan Sendiri', 1, 2, 10),
(47, 2668, 'A20D051F\n', '950603-03-6192', '1995-06-03', 0, 2, 158, 1, 'MIF', 1, 'PT 2050, Jalan Wira 1 KM40 Jalan Kuala Krai, 18500 Machang Kelantan ', 'Machang', '019-9445267', 'farahnabila950603@gmail.com\n', 1, 1, 'Iajazah Sarjana Muda Pentadbiran Perniagaan (Perbangkan dan Kewangan Islam) Dengan Kepujian', '', '3.81', '2020', 202020212, '2020', '2021-03-16', 'Pembiayaan Sendiri', 1, 2, 10),
(48, 2669, 'A20D047F', 'BK4855272', '1993-09-19', 0, 2, 178, 2, 'MIE', 1, 'House: 11 Street: 20, MVHS, B17', 'Islamabad', '9.23336E+11', 'm_kasim@hotmail.com', 1, 1, 'Bachelor Of Entrepreneurship (Hospitality) With Honours', '', '3.17', '2017', 202020212, '2020', '2021-03-25', 'Pembiayaan Sendiri', 1, 2, 10),
(49, 2528, 'abc123', '830720035643', '2021-09-14', 1, 1, 158, 1, 'MIE', 1, 'PT1068 Kg Telok Kemunting\r\nPauh Sembilan', 'Bachok', '+60133671531', 'zulkarom@gmail.com', 1, 1, '-', '-', '-', '11', 202020212, '88', '2021-09-23', '-', 1, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_sem`
--

CREATE TABLE `pg_student_sem` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `date_register` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `fee_amount` decimal(11,2) DEFAULT NULL,
  `fee_paid_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_student_sv`
--

CREATE TABLE `pg_student_sv` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `appoint_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_supervisor`
--

CREATE TABLE `pg_supervisor` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `external_id` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `is_internal` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pg_sv_field`
--

CREATE TABLE `pg_sv_field` (
  `id` int(11) NOT NULL,
  `sv_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `pg_module`
--
ALTER TABLE `pg_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_res_stage`
--
ALTER TABLE `pg_res_stage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_student`
--
ALTER TABLE `pg_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_no` (`matric_no`);

--
-- Indexes for table `pg_student_sem`
--
ALTER TABLE `pg_student_sem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_student_sv`
--
ALTER TABLE `pg_student_sv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_supervisor`
--
ALTER TABLE `pg_supervisor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pg_sv_field`
--
ALTER TABLE `pg_sv_field`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pg_external`
--
ALTER TABLE `pg_external`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pg_field`
--
ALTER TABLE `pg_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pg_module`
--
ALTER TABLE `pg_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pg_res_stage`
--
ALTER TABLE `pg_res_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pg_student`
--
ALTER TABLE `pg_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pg_student_sem`
--
ALTER TABLE `pg_student_sem`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pg_sv_field`
--
ALTER TABLE `pg_sv_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
