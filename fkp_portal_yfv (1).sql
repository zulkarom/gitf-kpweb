-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2020 at 03:07 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

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
-- Table structure for table `cf_checklist`
--

CREATE TABLE `cf_checklist` (
  `id` int(11) NOT NULL,
  `level` varchar(250) NOT NULL,
  `item` text NOT NULL,
  `item_bi` text NOT NULL,
  `lec_upload` int(11) NOT NULL,
  `coor_upload` int(11) NOT NULL,
  `staff_upload` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cf_checklist`
--

INSERT INTO `cf_checklist` (`id`, `level`, `item`, `item_bi`, `lec_upload`, `coor_upload`, `staff_upload`) VALUES
(1, 'Plan', 'Pro Forma Kursus\r\n', 'Course Pro Forma', 0, 0, 0),
(2, 'Plan', 'Maklumat Kursus', 'Course Information', 0, 0, 0),
(3, 'Plan', 'Penjajaran Konstruktif Kursus dan Program Pengajian\r\n', 'Constructive Alignment of Study Course and Programme', 0, 0, 0),
(4, 'Plan', 'Rubrik Pentaksiran Berterusan – jika berkenaan', 'Continuous Assessment Rubrics (if applicable)', 0, 1, 0),
(5, 'Plan', 'Bahan Pengajaran (jika menggunakan e-learning, nyatakan alamat laman web)', 'Teaching Materials (if using e-learning, state the website address)', 0, 1, 0),
(6, 'Plan', 'Salinan Surat Pelantikan Sebagai Pengajar Kursus', 'Copy of Appointment Letter as Course Lecturer', 0, 0, 1),
(7, 'Plan', 'Jadual Kelas Pengajaran Individu', 'Timetable for Individual Teaching Classes', 0, 0, 1),
(8, 'Do', 'Senarai Pelajar', 'List of Students', 0, 0, 0),
(9, 'Do', 'Rekod Kehadiran Kelas (kuliah, tutorial, studio dll)', 'Class Attendance Record (lecture, tutorial, studio etc)', 0, 0, 0),
(10, 'Do', 'Rekod Pembatalan dan Pindaan Kelas (jika berkaitan)', 'Record of Class Cancellation and Replacement (if applicable)', 1, 0, 0),
(11, 'Do', 'Rekod Penerimaan Tugasan Pelajar', 'Record of Receipt of Students’ Assignment', 1, 0, 0),
(12, 'Do', 'Salinan Bahan Pentaksiran Berterusan', 'Copies of Continous Assessment Materials', 0, 1, 0),
(13, 'Do', 'Salinan Hasil Pentaksiran Berterusan', 'Copy of Continuous Assessment Script', 0, 1, 0),
(14, 'Do', 'Penilaian Sumatif:\r\n<ol>\r\n<li>Peperiksaan Akhir: Salinan Kertas Soalan dan Skema Markah, atau\r\n</li>\r\n<li>\r\nPentaksiran Akhir: Termasuk Salinan Rubrik, Protokol Temuduga dan Salinan Jadual Pelaksanaan\r\n</li>\r\n</ol>', 'Summative Assessment:\r\n<ol>\r\n<li>Final Examination: Copy of Question Paper and Marking Scheme, or\r\n</li>\r\n<li>\r\nFinal Assessment: Including a Copy of Rubrics, Interview Protocol, Implementation Schedule\r\n</li>\r\n</ol>', 0, 1, 0),
(15, 'Do', 'Sembilan (9) salinan Skrip Jawapan Peperiksaan Akhir Pelajar:\r\n<ul>\r\n<li>\r\nTiga (3) Jawapan Terbaik\r\n</li>\r\n<li> \r\nTiga (3) Jawapan Sederhana\r\n</li>\r\n<li>\r\nTiga (3) Jawapan Terendah\r\n</li>\r\n</ul>', 'Nine (9) Copies of Student’s Final Exam Answer Script:\r\n<ul>\r\n<li>\r\nThe three (3) Best Answer Scripts \r\n</li>\r\n<li> \r\nThe three (3) Moderate Answer Scripts\r\n</li>\r\n<li>\r\nThe three (3) Lowest Answer Scripts\r\n</li>\r\n</ul>', 0, 1, 0),
(16, 'Do', 'Rekod Cuti Sakit/ Pelepasan Hadir Kelas Pelajar', 'Record of Student’s Medical Checkup/ Class Exemption', 1, 0, 0),
(17, 'Check', 'Salinan Keputusan Peperiksaan atau Pentaksiran Akhir (termasuk geraf)', 'Copy of Final Exam or Assessment Results (including graphs)', 0, 1, 0),
(18, 'Check', 'Keputusan Penilaian Kursus dan Pengajaran Pelajar', 'Evaluation Results of Course and Teaching by Students', 0, 1, 0),
(19, 'Check', 'Keputusan Pencapaian Hasil Pembelajaran Kursus (CLO)\r\n', 'Results of Course Learning Outcomes (CLO)', 0, 1, 0),
(20, 'Check', 'Analisis Pencapaian Hasil Pembelajaran Kursus (CLO)', 'Analysis on Achievement of Course Learning Outcomes (CLO)', 0, 1, 0),
(21, 'Act', 'Rancangan Penambahbaikan Kursus (jika ada)', 'Plan for Course Improvement (if any)', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cf_lec_cancel_class`
--

CREATE TABLE `cf_lec_cancel_class` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `path_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_tut_cancel_class`
--

CREATE TABLE `cf_tut_cancel_class` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `uploaded_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cf_checklist`
--
ALTER TABLE `cf_checklist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cf_checklist`
--
ALTER TABLE `cf_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
