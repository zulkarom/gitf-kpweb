-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2021 at 12:43 PM
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
-- Table structure for table `aaa`
--

CREATE TABLE `aaa` (
  `id` int(11) NOT NULL,
  `psss` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adu_aduan`
--

CREATE TABLE `adu_aduan` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=staff,2=student,3=others',
  `nric` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `topic_id` varchar(100) DEFAULT NULL,
  `title` varchar(225) DEFAULT NULL,
  `aduan` text DEFAULT NULL,
  `declaration` tinyint(1) NOT NULL DEFAULT 0,
  `upload_url` text DEFAULT NULL,
  `captcha` varchar(225) DEFAULT NULL,
  `progress_id` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email_code` varchar(10) DEFAULT NULL,
  `email_verfied` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adu_aduan_action`
--

CREATE TABLE `adu_aduan_action` (
  `id` int(11) NOT NULL,
  `aduan_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `action_text` text DEFAULT NULL,
  `progress_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adu_aduan_progress`
--

CREATE TABLE `adu_aduan_progress` (
  `id` int(11) NOT NULL,
  `progress` varchar(30) NOT NULL,
  `admin_action` tinyint(1) NOT NULL,
  `user_action` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adu_aduan_topic`
--

CREATE TABLE `adu_aduan_topic` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adu_guideline`
--

CREATE TABLE `adu_guideline` (
  `id` int(11) NOT NULL,
  `guideline_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adu_setting`
--

CREATE TABLE `adu_setting` (
  `id` int(11) NOT NULL,
  `penyelia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `author` text DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `abstract` text DEFAULT NULL,
  `reference` text DEFAULT NULL,
  `pdf_file` varchar(6) DEFAULT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `volume` int(1) DEFAULT NULL,
  `issue` int(1) DEFAULT NULL,
  `priod` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cf_checklist`
--

CREATE TABLE `cf_checklist` (
  `id` int(11) NOT NULL,
  `level` varchar(250) DEFAULT NULL,
  `item` text DEFAULT NULL,
  `item_bi` text DEFAULT NULL,
  `lec_upload` int(11) DEFAULT 0,
  `coor_upload` int(11) DEFAULT 0,
  `staff_upload` int(11) DEFAULT 0,
  `upload_url` varchar(225) DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `progress_function` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_assess_material_class`
--

CREATE TABLE `cf_coor_assess_material_class` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `file_name` varchar(200) DEFAULT NULL,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_assess_result_class`
--

CREATE TABLE `cf_coor_assess_result_class` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_assess_script_class`
--

CREATE TABLE `cf_coor_assess_script_class` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `file_name` varchar(200) DEFAULT NULL,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_result_final`
--

CREATE TABLE `cf_coor_result_final` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_rubrics`
--

CREATE TABLE `cf_coor_rubrics` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_coor_sum_assess_class`
--

CREATE TABLE `cf_coor_sum_assess_class` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_date`
--

CREATE TABLE `cf_date` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL DEFAULT 0,
  `open_deadline` date DEFAULT NULL,
  `audit_deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_lec_cancel_class`
--

CREATE TABLE `cf_lec_cancel_class` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date_old` date DEFAULT NULL,
  `date_new` date DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_lec_exempt_class`
--

CREATE TABLE `cf_lec_exempt_class` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `ex_date` date DEFAULT NULL,
  `matric_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_lec_receipt_class`
--

CREATE TABLE `cf_lec_receipt_class` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_material`
--

CREATE TABLE `cf_material` (
  `id` int(11) NOT NULL,
  `material_name` varchar(200) DEFAULT NULL,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `mt_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=pdf, 2=others',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=draft,10=submit',
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_material_item`
--

CREATE TABLE `cf_material_item` (
  `id` int(11) NOT NULL,
  `item_category` int(11) NOT NULL DEFAULT 0,
  `material_id` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(200) DEFAULT NULL,
  `item_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_student_lec`
--

CREATE TABLE `cf_student_lec` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `matric_no` varchar(20) DEFAULT NULL,
  `assess_result` text DEFAULT NULL,
  `stud_check` tinyint(1) NOT NULL DEFAULT 0,
  `attendance_check` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_student_tut`
--

CREATE TABLE `cf_student_tut` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL DEFAULT 0,
  `matric_no` varchar(20) DEFAULT NULL,
  `stud_check` tinyint(1) NOT NULL DEFAULT 0,
  `attendance_check` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_tut_cancel_class`
--

CREATE TABLE `cf_tut_cancel_class` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `date_old` date DEFAULT NULL,
  `date_new` date DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_tut_exempt_class`
--

CREATE TABLE `cf_tut_exempt_class` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `ex_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cf_tut_receipt_class`
--

CREATE TABLE `cf_tut_receipt_class` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL DEFAULT 0,
  `path_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conference`
--

CREATE TABLE `conference` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `conf_url` varchar(100) DEFAULT NULL,
  `conf_name` varchar(200) DEFAULT NULL,
  `conf_abbr` varchar(50) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `conf_venue` varchar(200) DEFAULT NULL,
  `logo_file` text DEFAULT NULL,
  `conf_address` text DEFAULT NULL,
  `conf_theme` varchar(200) DEFAULT NULL,
  `banner_file` text DEFAULT NULL,
  `conf_background` text DEFAULT NULL,
  `announcement` text DEFAULT NULL,
  `conf_scope` text DEFAULT NULL,
  `conf_lang` text DEFAULT NULL,
  `conf_publication` text DEFAULT NULL,
  `conf_contact` text DEFAULT NULL,
  `conf_submission` text DEFAULT NULL,
  `conf_accommodation` text DEFAULT NULL,
  `conf_award` text DEFAULT NULL,
  `conf_committee` text DEFAULT NULL,
  `payment_info` text DEFAULT NULL,
  `payment_info_inv` text DEFAULT NULL,
  `early_date` int(11) NOT NULL DEFAULT 0,
  `currency_local` varchar(10) DEFAULT NULL,
  `currency_int` varchar(10) DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `page_featured` text DEFAULT NULL,
  `page_menu` text DEFAULT NULL,
  `phone_contact` varchar(100) DEFAULT NULL,
  `email_contact` varchar(100) DEFAULT NULL,
  `fax_contact` varchar(100) DEFAULT NULL,
  `commercial` tinyint(1) NOT NULL DEFAULT 0,
  `type_name` int(11) NOT NULL DEFAULT 1 COMMENT '1=Conference, 2=Colloquium'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `confv_adv`
--

CREATE TABLE `confv_adv` (
  `id` int(11) NOT NULL,
  `adv_icon` varchar(20) NOT NULL,
  `adv_title` varchar(100) NOT NULL,
  `adv_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_author`
--

CREATE TABLE `conf_author` (
  `id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `author_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_date`
--

CREATE TABLE `conf_date` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL DEFAULT 0,
  `date_id` int(11) NOT NULL DEFAULT 0,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `date_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_date_name`
--

CREATE TABLE `conf_date_name` (
  `id` int(11) NOT NULL,
  `date_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conf_download`
--

CREATE TABLE `conf_download` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL DEFAULT 0,
  `download_name` varchar(200) DEFAULT NULL,
  `download_file` text DEFAULT NULL,
  `download_order` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_email_tmplt`
--

CREATE TABLE `conf_email_tmplt` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `templ_id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conf_email_tmplt_set`
--

CREATE TABLE `conf_email_tmplt_set` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conf_fee`
--

CREATE TABLE `conf_fee` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `fee_name` varchar(200) DEFAULT NULL,
  `fee_currency` varchar(10) DEFAULT NULL,
  `fee_amount` decimal(11,2) DEFAULT NULL,
  `fee_early` decimal(11,2) DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `minimum_paper` tinyint(4) NOT NULL DEFAULT 1,
  `fee_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_organizer`
--

CREATE TABLE `conf_organizer` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `logo_file` text NOT NULL,
  `org_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_paper`
--

CREATE TABLE `conf_paper` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `confly_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pap_title` text NOT NULL,
  `scope_id` int(11) DEFAULT 0,
  `status` int(11) NOT NULL,
  `pap_abstract` text NOT NULL,
  `keyword` varchar(200) DEFAULT NULL,
  `paper_file` text DEFAULT NULL,
  `repaper_file` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `abstract_at` datetime DEFAULT NULL,
  `full_paper_at` datetime DEFAULT NULL,
  `fp_accept_ts` int(11) DEFAULT NULL,
  `myrole` int(11) DEFAULT NULL,
  `invoice_ts` int(11) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `invoice_final` double DEFAULT NULL,
  `invoice_early` double DEFAULT NULL,
  `invoice_currency` varchar(5) DEFAULT NULL,
  `invoice_confly_no` int(11) DEFAULT NULL,
  `reject_note` text DEFAULT NULL,
  `reject_at` datetime DEFAULT NULL,
  `payment_at` datetime DEFAULT NULL,
  `payment_amount` double DEFAULT NULL,
  `payment_info` varchar(200) DEFAULT NULL,
  `payment_file` text DEFAULT NULL,
  `receipt_ts` int(11) DEFAULT NULL,
  `receipt_confly_no` int(11) DEFAULT NULL,
  `attending` tinyint(1) DEFAULT NULL,
  `reviewer_user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_paper_reviewer`
--

CREATE TABLE `conf_paper_reviewer` (
  `id` int(11) NOT NULL,
  `paper_id` int(11) NOT NULL DEFAULT 0,
  `scope_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => ''Appoint'', 10 => ''Review In Progress'', 20 => ''Completed'', 30 => ''Reject'', 40 => ''Canceled'', 50 => ''Error''',
  `q_1` tinyint(1) NOT NULL DEFAULT 0,
  `q_2` tinyint(1) NOT NULL DEFAULT 0,
  `q_3` tinyint(1) NOT NULL DEFAULT 0,
  `q_4` tinyint(1) NOT NULL DEFAULT 0,
  `q_5` tinyint(1) NOT NULL DEFAULT 0,
  `q_6` tinyint(1) NOT NULL DEFAULT 0,
  `q_7` tinyint(1) NOT NULL DEFAULT 0,
  `q_8` tinyint(1) NOT NULL DEFAULT 0,
  `q_9` tinyint(1) NOT NULL DEFAULT 0,
  `q_10` tinyint(1) NOT NULL DEFAULT 0,
  `q_11` tinyint(1) NOT NULL DEFAULT 0,
  `q_1_note` text DEFAULT NULL,
  `q_2_note` text DEFAULT NULL,
  `q_3_note` text DEFAULT NULL,
  `q_4_note` text DEFAULT NULL,
  `q_5_note` text DEFAULT NULL,
  `q_6_note` text DEFAULT NULL,
  `q_7_note` text DEFAULT NULL,
  `q_8_note` text DEFAULT NULL,
  `q_9_note` text DEFAULT NULL,
  `q_10_note` text DEFAULT NULL,
  `q_11_note` text DEFAULT NULL,
  `review_option` tinyint(1) DEFAULT NULL,
  `review_note` text DEFAULT NULL,
  `reviewed_file` varchar(200) DEFAULT NULL,
  `review_at` datetime DEFAULT NULL,
  `paper_rate` tinyint(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `cancel_at` datetime DEFAULT NULL,
  `reject_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_reg`
--

CREATE TABLE `conf_reg` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reg_at` datetime NOT NULL,
  `confly_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_review_form`
--

CREATE TABLE `conf_review_form` (
  `id` int(11) NOT NULL,
  `form_quest` text DEFAULT NULL,
  `cat_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_scope`
--

CREATE TABLE `conf_scope` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `scope_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_secretariat`
--

CREATE TABLE `conf_secretariat` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `sec_name` varchar(200) NOT NULL,
  `sec_office` varchar(200) NOT NULL,
  `phone1` varchar(30) NOT NULL,
  `phone2` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_status`
--

CREATE TABLE `conf_status` (
  `id` int(11) NOT NULL,
  `status_code` int(11) NOT NULL,
  `status_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_ttf_day`
--

CREATE TABLE `conf_ttf_day` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `conf_date` date NOT NULL,
  `day_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conf_ttf_time`
--

CREATE TABLE `conf_ttf_time` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `ttf_time` varchar(20) NOT NULL,
  `ttf_item` varchar(200) NOT NULL,
  `ttf_location` varchar(200) NOT NULL,
  `ttf_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `idCountry` int(5) NOT NULL,
  `countryCode` char(2) NOT NULL DEFAULT '',
  `countryName` varchar(45) NOT NULL DEFAULT '',
  `currencyCode` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(5) NOT NULL,
  `country_code` char(2) NOT NULL DEFAULT '',
  `country_name` varchar(45) NOT NULL DEFAULT '',
  `currency_code` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cp_chapterinbook`
--

CREATE TABLE `cp_chapterinbook` (
  `id` int(11) NOT NULL,
  `chap_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `image_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `chap_url` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cp_chapter_paper`
--

CREATE TABLE `cp_chapter_paper` (
  `id` int(11) NOT NULL,
  `chap_id` int(11) NOT NULL DEFAULT 0,
  `paper_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paper_no` int(11) NOT NULL DEFAULT 0,
  `paper_page` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paper_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `biz_type` int(11) NOT NULL,
  `expired_date` date NOT NULL,
  `sale_amt` double NOT NULL,
  `sale_at` int(11) NOT NULL,
  `is_block` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `database_access`
--

CREATE TABLE `database_access` (
  `acc_id` int(11) NOT NULL,
  `db_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `access_read` tinyint(1) NOT NULL,
  `access_write` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `database_names`
--

CREATE TABLE `database_names` (
  `db_id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `db_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dep_name` varchar(200) NOT NULL,
  `dep_name_bi` varchar(200) NOT NULL,
  `faculty` int(11) NOT NULL,
  `head_dep` int(11) NOT NULL,
  `position_stamp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dwd_download`
--

CREATE TABLE `dwd_download` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `nric` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dwd_download_cat`
--

CREATE TABLE `dwd_download_cat` (
  `id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `faculty_name` varchar(200) NOT NULL,
  `faculty_name_bi` varchar(250) NOT NULL,
  `academic` tinyint(1) NOT NULL,
  `scode` varchar(10) NOT NULL,
  `syncing` tinyint(1) NOT NULL DEFAULT 1,
  `showing` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_article`
--

CREATE TABLE `jeb_article` (
  `id` int(11) NOT NULL,
  `manuscript_no` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_sc` text DEFAULT NULL,
  `keyword` text DEFAULT NULL,
  `abstract` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `scope_id` tinyint(2) NOT NULL DEFAULT 0,
  `status` varchar(100) DEFAULT NULL,
  `submission_file` varchar(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `draft_at` datetime DEFAULT NULL,
  `submit_at` datetime DEFAULT NULL,
  `pre_evaluate_at` datetime DEFAULT NULL,
  `pre_evaluate_by` int(11) NOT NULL DEFAULT 0,
  `associate_editor` int(11) NOT NULL DEFAULT 0,
  `review_file` varchar(200) DEFAULT NULL,
  `pre_evaluate_note` text DEFAULT NULL,
  `asgn_reviewer_at` datetime DEFAULT NULL,
  `asgn_reviewer_by` int(11) NOT NULL DEFAULT 0,
  `review_at` datetime DEFAULT NULL,
  `recommend_by` int(11) NOT NULL DEFAULT 0,
  `recommend_at` datetime DEFAULT NULL,
  `recommend_note` text DEFAULT NULL,
  `recommend_option` tinyint(1) NOT NULL DEFAULT 0,
  `evaluate_option` tinyint(1) NOT NULL DEFAULT 0,
  `evaluate_note` text DEFAULT NULL,
  `evaluate_by` int(11) NOT NULL DEFAULT 0,
  `evaluate_at` datetime DEFAULT NULL,
  `response_by` int(11) NOT NULL DEFAULT 0,
  `response_at` datetime DEFAULT NULL,
  `response_note` text DEFAULT NULL,
  `correction_at` datetime DEFAULT NULL,
  `correction_note` text DEFAULT NULL,
  `correction_file` varchar(100) DEFAULT NULL,
  `post_evaluate_by` int(11) DEFAULT NULL,
  `post_evaluate_at` datetime DEFAULT NULL,
  `assistant_editor` int(11) NOT NULL DEFAULT 0,
  `galley_proof_at` datetime DEFAULT NULL,
  `galley_proof_by` int(11) NOT NULL DEFAULT 0,
  `galley_proof_note` text DEFAULT NULL,
  `galley_file` varchar(200) DEFAULT NULL,
  `finalise_at` datetime DEFAULT NULL,
  `finalise_option` tinyint(1) NOT NULL DEFAULT 0,
  `finalise_note` text DEFAULT NULL,
  `finalise_file` varchar(200) DEFAULT NULL,
  `asgn_profrdr_at` datetime DEFAULT NULL,
  `asgn_profrdr_by` int(11) NOT NULL DEFAULT 0,
  `asgn_profrdr_note` text DEFAULT NULL,
  `proof_reader` int(11) NOT NULL DEFAULT 0,
  `post_finalise_at` datetime DEFAULT NULL,
  `post_finalise_by` int(11) NOT NULL DEFAULT 0,
  `postfinalise_file` varchar(200) DEFAULT NULL,
  `post_finalise_note` text DEFAULT NULL,
  `proofread_at` datetime DEFAULT NULL,
  `proofread_by` int(11) NOT NULL DEFAULT 0,
  `proofread_note` text DEFAULT NULL,
  `proofread_file` varchar(200) DEFAULT NULL,
  `camera_ready_at` datetime DEFAULT NULL,
  `camera_ready_by` int(11) NOT NULL DEFAULT 0,
  `camera_ready_note` text DEFAULT NULL,
  `cameraready_file` varchar(200) DEFAULT NULL,
  `assign_journal_at` datetime DEFAULT NULL,
  `journal_at` datetime DEFAULT NULL,
  `journal_by` int(11) NOT NULL DEFAULT 0,
  `journal_id` int(11) NOT NULL DEFAULT 0,
  `reject_at` datetime DEFAULT NULL,
  `reject_by` int(11) NOT NULL DEFAULT 0,
  `reject_note` text DEFAULT NULL,
  `publish_number` varchar(10) DEFAULT NULL,
  `withdraw_by` int(11) NOT NULL DEFAULT 0,
  `withdraw_at_status` varchar(100) DEFAULT NULL,
  `withdraw_note` text DEFAULT NULL,
  `withdraw_at` datetime DEFAULT NULL,
  `withdraw_request_at` datetime DEFAULT NULL,
  `page_from` int(11) NOT NULL DEFAULT 0,
  `page_to` int(11) DEFAULT 0,
  `doi_ref` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_article_author`
--

CREATE TABLE `jeb_article_author` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL DEFAULT 0,
  `firstname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_article_reviewer`
--

CREATE TABLE `jeb_article_reviewer` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL DEFAULT 0,
  `scope_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => ''Appoint'', 10 => ''Review In Progress'', 20 => ''Completed'', 30 => ''Reject'', 40 => ''Canceled'', 50 => ''Error''',
  `q_1` tinyint(1) NOT NULL DEFAULT 0,
  `q_2` tinyint(1) NOT NULL DEFAULT 0,
  `q_3` tinyint(1) NOT NULL DEFAULT 0,
  `q_4` tinyint(1) NOT NULL DEFAULT 0,
  `q_5` tinyint(1) NOT NULL DEFAULT 0,
  `q_6` tinyint(1) NOT NULL DEFAULT 0,
  `q_7` tinyint(1) NOT NULL DEFAULT 0,
  `q_8` tinyint(1) NOT NULL DEFAULT 0,
  `q_9` tinyint(1) NOT NULL DEFAULT 0,
  `q_10` tinyint(1) NOT NULL DEFAULT 0,
  `q_11` tinyint(1) NOT NULL DEFAULT 0,
  `review_option` tinyint(1) NOT NULL DEFAULT 0,
  `review_note` text DEFAULT NULL,
  `reviewed_file` varchar(200) DEFAULT NULL,
  `review_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `cancel_at` datetime DEFAULT NULL,
  `reject_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_article_scope`
--

CREATE TABLE `jeb_article_scope` (
  `id` int(11) NOT NULL,
  `scope_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_associate`
--

CREATE TABLE `jeb_associate` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `institution` varchar(200) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `admin_creation` tinyint(1) DEFAULT NULL,
  `sv_main` varchar(100) DEFAULT NULL,
  `sv_co1` varchar(100) DEFAULT NULL,
  `sv_co2` varchar(100) DEFAULT NULL,
  `sv_co3` varchar(100) DEFAULT NULL,
  `matric_no` varchar(50) DEFAULT NULL,
  `cumm_sem` tinyint(4) NOT NULL DEFAULT 0,
  `pro_study` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=master,2=phd',
  `title` varchar(100) DEFAULT NULL,
  `assoc_address` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_email_template`
--

CREATE TABLE `jeb_email_template` (
  `id` int(11) NOT NULL,
  `on_enter_workflow` varchar(100) DEFAULT NULL,
  `target_role` text DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `notification_subject` varchar(100) DEFAULT NULL,
  `notification` text DEFAULT NULL,
  `do_reminder` tinyint(1) DEFAULT 0,
  `reminder_subject` varchar(100) DEFAULT NULL,
  `reminder` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_journal`
--

CREATE TABLE `jeb_journal` (
  `id` int(11) NOT NULL,
  `journal_name` varchar(200) DEFAULT NULL,
  `volume` int(11) NOT NULL DEFAULT 0,
  `issue` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `published_at` date DEFAULT NULL,
  `archived_at` datetime DEFAULT NULL,
  `is_special` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_review_form`
--

CREATE TABLE `jeb_review_form` (
  `id` int(11) NOT NULL,
  `form_quest` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_setting`
--

CREATE TABLE `jeb_setting` (
  `id` int(11) NOT NULL,
  `template_file` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeb_user_scope`
--

CREATE TABLE `jeb_user_scope` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `scope_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id` int(11) NOT NULL,
  `code` varchar(8) DEFAULT NULL,
  `name` varchar(53) DEFAULT NULL,
  `name2` varchar(52) DEFAULT NULL,
  `credit` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lec_lecturer`
--

CREATE TABLE `lec_lecturer` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `li_senarai`
--

CREATE TABLE `li_senarai` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `matrik` varchar(9) DEFAULT NULL,
  `nric` bigint(12) DEFAULT NULL,
  `program` varchar(82) DEFAULT NULL,
  `jilid` int(2) DEFAULT NULL,
  `surat` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `li_senaraix`
--

CREATE TABLE `li_senaraix` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `matrik` varchar(10) DEFAULT NULL,
  `nric` varchar(18) DEFAULT NULL,
  `program` varchar(82) DEFAULT NULL,
  `jilid` varchar(5) DEFAULT NULL,
  `surat` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mail_queue`
--

CREATE TABLE `mail_queue` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `attempts` int(11) DEFAULT NULL,
  `last_attempt_time` datetime DEFAULT NULL,
  `sent_time` datetime DEFAULT NULL,
  `time_to_send` datetime NOT NULL,
  `swift_message` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `option_option`
--

CREATE TABLE `option_option` (
  `ooption_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `ooption_text` varchar(200) NOT NULL,
  `ooption_value` int(4) NOT NULL,
  `ooption_order` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `proceeding`
--

CREATE TABLE `proceeding` (
  `id` int(11) NOT NULL,
  `proc_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `image_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `proc_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proc_paper`
--

CREATE TABLE `proc_paper` (
  `id` int(11) NOT NULL,
  `proc_id` int(11) NOT NULL,
  `paper_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author` text COLLATE utf8_unicode_ci NOT NULL,
  `paper_no` int(11) DEFAULT 0,
  `paper_page` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paper_file` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `tm` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stage` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_award`
--

CREATE TABLE `rp_award` (
  `id` int(11) NOT NULL,
  `awd_staff` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `awd_name` varchar(300) NOT NULL,
  `awd_level` tinyint(1) NOT NULL,
  `awd_type` varchar(100) NOT NULL,
  `awd_by` varchar(300) NOT NULL,
  `awd_date` date NOT NULL,
  `awd_file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `reviewed_at` datetime NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `review_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_award_tag`
--

CREATE TABLE `rp_award_tag` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `award_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_consultation`
--

CREATE TABLE `rp_consultation` (
  `id` int(11) NOT NULL,
  `csl_staff` int(11) NOT NULL,
  `csl_title` varchar(500) DEFAULT NULL,
  `csl_funder` varchar(500) DEFAULT NULL,
  `csl_amount` decimal(11,2) DEFAULT NULL,
  `csl_level` tinyint(1) DEFAULT NULL COMMENT '1=local,2=international',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `csl_file` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `review_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_consultation_tag`
--

CREATE TABLE `rp_consultation_tag` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `consult_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_knowledge_transfer`
--

CREATE TABLE `rp_knowledge_transfer` (
  `id` int(11) NOT NULL,
  `ktp_title` varchar(600) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `ktp_research` varchar(200) NOT NULL,
  `ktp_community` varchar(200) NOT NULL,
  `ktp_source` varchar(200) NOT NULL,
  `ktp_amount` decimal(11,2) NOT NULL,
  `ktp_description` text NOT NULL,
  `ktp_file` varchar(200) NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `reviewed_at` datetime NOT NULL,
  `review_note` text NOT NULL,
  `created_at` datetime NOT NULL,
  `reminder` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_knowledge_transfer_member`
--

CREATE TABLE `rp_knowledge_transfer_member` (
  `id` int(11) NOT NULL,
  `ktp_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `ext_name` varchar(200) NOT NULL,
  `ktp_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_membership`
--

CREATE TABLE `rp_membership` (
  `id` int(11) NOT NULL,
  `msp_staff` int(11) NOT NULL,
  `msp_body` varchar(500) NOT NULL,
  `msp_type` varchar(500) NOT NULL,
  `msp_level` tinyint(1) NOT NULL COMMENT '1=local,2=international',
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `msp_file` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `reviewed_at` datetime NOT NULL,
  `review_note` text NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_publication`
--

CREATE TABLE `rp_publication` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `pub_type` int(11) NOT NULL,
  `pub_year` int(11) NOT NULL,
  `pub_title` varchar(500) NOT NULL,
  `pub_journal` varchar(500) NOT NULL,
  `pub_volume` varchar(100) NOT NULL,
  `pub_issue` varchar(100) NOT NULL,
  `pub_page` varchar(500) NOT NULL,
  `pub_city` varchar(500) NOT NULL,
  `pub_state` varchar(500) NOT NULL,
  `pub_publisher` varchar(500) NOT NULL,
  `pub_isbn` varchar(200) NOT NULL,
  `pub_organizer` varchar(200) NOT NULL,
  `pub_inbook` varchar(500) NOT NULL,
  `pub_month` varchar(500) NOT NULL,
  `pub_day` varchar(100) NOT NULL,
  `pub_date` varchar(100) NOT NULL,
  `pub_index` varchar(200) NOT NULL,
  `has_file` tinyint(1) NOT NULL,
  `pubupload_file` text NOT NULL,
  `pubother_file` text NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL,
  `reviewed_at` datetime NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `review_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_pub_author`
--

CREATE TABLE `rp_pub_author` (
  `id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL,
  `au_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_pub_editor`
--

CREATE TABLE `rp_pub_editor` (
  `id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL,
  `edit_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_pub_tag`
--

CREATE TABLE `rp_pub_tag` (
  `id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_pub_type`
--

CREATE TABLE `rp_pub_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_research`
--

CREATE TABLE `rp_research` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `res_title` varchar(600) NOT NULL,
  `res_staff` int(11) NOT NULL,
  `res_progress` tinyint(1) NOT NULL COMMENT '1=finish,0 = ongoing',
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `res_grant` int(11) NOT NULL,
  `res_grant_others` varchar(200) NOT NULL,
  `res_source` varchar(200) NOT NULL,
  `sponsor_category` int(2) NOT NULL,
  `res_amount` decimal(11,2) NOT NULL,
  `res_file` text NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL,
  `reminder` tinyint(1) NOT NULL,
  `reviewed_at` datetime NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `review_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_researcher`
--

CREATE TABLE `rp_researcher` (
  `id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `ext_name` varchar(200) NOT NULL,
  `res_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_research_grant`
--

CREATE TABLE `rp_research_grant` (
  `id` int(11) NOT NULL,
  `gra_name` varchar(200) NOT NULL,
  `gra_abbr` varchar(20) NOT NULL,
  `gra_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rp_status`
--

CREATE TABLE `rp_status` (
  `id` int(11) NOT NULL,
  `status_code` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL,
  `status_color` varchar(50) NOT NULL,
  `admin_show` tinyint(1) NOT NULL,
  `admin_action` tinyint(1) NOT NULL,
  `user_show` tinyint(1) NOT NULL,
  `user_edit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `open_at` date DEFAULT NULL,
  `close_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `result_date` date DEFAULT NULL,
  `template_appoint_letter` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_category`
--

CREATE TABLE `sponsor_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_assessment_cat`
--

CREATE TABLE `sp_assessment_cat` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_name_bi` varchar(100) NOT NULL,
  `form_sum` tinyint(1) NOT NULL,
  `is_direct` tinyint(1) NOT NULL,
  `showing` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_clo_verb`
--

CREATE TABLE `sp_clo_verb` (
  `id` int(11) NOT NULL,
  `verb` varchar(100) NOT NULL,
  `verb_bi` varchar(100) NOT NULL,
  `C1` tinyint(1) NOT NULL DEFAULT 0,
  `C2` tinyint(1) NOT NULL DEFAULT 0,
  `C3` tinyint(1) NOT NULL DEFAULT 0,
  `C4` tinyint(1) NOT NULL DEFAULT 0,
  `C5` tinyint(1) NOT NULL DEFAULT 0,
  `C6` tinyint(1) NOT NULL DEFAULT 0,
  `A1` tinyint(1) NOT NULL DEFAULT 0,
  `A2` tinyint(1) NOT NULL DEFAULT 0,
  `A3` tinyint(1) NOT NULL DEFAULT 0,
  `A4` tinyint(1) NOT NULL DEFAULT 0,
  `A5` tinyint(1) NOT NULL DEFAULT 0,
  `P1` tinyint(1) NOT NULL DEFAULT 0,
  `P2` tinyint(1) NOT NULL DEFAULT 0,
  `P3` tinyint(1) NOT NULL DEFAULT 0,
  `P4` tinyint(1) NOT NULL DEFAULT 0,
  `P5` tinyint(1) NOT NULL DEFAULT 0,
  `P6` tinyint(1) NOT NULL DEFAULT 0,
  `P7` tinyint(1) NOT NULL DEFAULT 0,
  `L0` tinyint(1) NOT NULL,
  `L1` tinyint(1) NOT NULL,
  `L2` tinyint(1) NOT NULL,
  `L3` tinyint(1) NOT NULL,
  `L4` tinyint(1) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course`
--

CREATE TABLE `sp_course` (
  `id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(250) NOT NULL,
  `course_name_bi` varchar(250) NOT NULL,
  `credit_hour` tinyint(1) NOT NULL,
  `study_level` varchar(10) NOT NULL DEFAULT 'UG',
  `course_type` int(11) DEFAULT 0,
  `course_level` tinyint(1) DEFAULT NULL,
  `course_class` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL DEFAULT 1,
  `department_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `method_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=classroom, 2=non-classroom',
  `lec_hour` double NOT NULL DEFAULT 2,
  `tut_hour` double NOT NULL DEFAULT 1,
  `is_dummy` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_access`
--

CREATE TABLE `sp_course_access` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `acc_order` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_assessment`
--

CREATE TABLE `sp_course_assessment` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL DEFAULT 0,
  `assess_name` varchar(100) DEFAULT NULL,
  `assess_name_bi` varchar(100) DEFAULT NULL,
  `assess_cat` int(11) NOT NULL DEFAULT 0,
  `assess_f2f` double DEFAULT 0,
  `assess_f2f_tech` double NOT NULL DEFAULT 0,
  `assess_nf2f` double NOT NULL DEFAULT 0,
  `trash` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_class`
--

CREATE TABLE `sp_course_class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_name_bi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_clo`
--

CREATE TABLE `sp_course_clo` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL,
  `verb` varchar(100) DEFAULT NULL,
  `clo_text` text DEFAULT NULL,
  `clo_text_bi` text DEFAULT NULL,
  `percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `PLO1` tinyint(1) NOT NULL DEFAULT 0,
  `PLO2` tinyint(1) NOT NULL DEFAULT 0,
  `PLO3` tinyint(1) NOT NULL DEFAULT 0,
  `PLO4` tinyint(1) NOT NULL DEFAULT 0,
  `PLO5` tinyint(1) NOT NULL DEFAULT 0,
  `PLO6` tinyint(1) NOT NULL DEFAULT 0,
  `PLO7` tinyint(1) NOT NULL DEFAULT 0,
  `PLO8` tinyint(1) NOT NULL DEFAULT 0,
  `PLO9` tinyint(1) NOT NULL DEFAULT 0,
  `PLO10` tinyint(1) NOT NULL DEFAULT 0,
  `PLO11` tinyint(1) NOT NULL DEFAULT 0,
  `PLO12` tinyint(1) NOT NULL DEFAULT 0,
  `C1` tinyint(1) NOT NULL DEFAULT 0,
  `C2` tinyint(1) NOT NULL DEFAULT 0,
  `C3` tinyint(1) NOT NULL DEFAULT 0,
  `C4` tinyint(1) NOT NULL DEFAULT 0,
  `C5` tinyint(1) NOT NULL DEFAULT 0,
  `C6` tinyint(1) NOT NULL DEFAULT 0,
  `A1` tinyint(1) NOT NULL DEFAULT 0,
  `A2` tinyint(1) NOT NULL DEFAULT 0,
  `A3` tinyint(1) NOT NULL DEFAULT 0,
  `A4` tinyint(1) NOT NULL DEFAULT 0,
  `A5` tinyint(1) NOT NULL DEFAULT 0,
  `P1` tinyint(1) NOT NULL DEFAULT 0,
  `P2` tinyint(1) NOT NULL DEFAULT 0,
  `P3` tinyint(1) NOT NULL DEFAULT 0,
  `P4` tinyint(1) NOT NULL DEFAULT 0,
  `P5` tinyint(1) NOT NULL DEFAULT 0,
  `P6` tinyint(1) NOT NULL DEFAULT 0,
  `P7` tinyint(1) NOT NULL DEFAULT 0,
  `CS1` tinyint(1) NOT NULL DEFAULT 0,
  `CS2` tinyint(1) NOT NULL DEFAULT 0,
  `CS3` tinyint(1) NOT NULL DEFAULT 0,
  `CS4` tinyint(1) NOT NULL DEFAULT 0,
  `CS5` tinyint(1) NOT NULL DEFAULT 0,
  `CS6` tinyint(1) NOT NULL DEFAULT 0,
  `CS7` tinyint(1) NOT NULL DEFAULT 0,
  `CS8` tinyint(1) NOT NULL DEFAULT 0,
  `CT1` tinyint(1) NOT NULL DEFAULT 0,
  `CT2` tinyint(1) NOT NULL DEFAULT 0,
  `CT3` tinyint(1) NOT NULL DEFAULT 0,
  `CT4` tinyint(1) NOT NULL DEFAULT 0,
  `CT5` tinyint(1) NOT NULL DEFAULT 0,
  `CT6` tinyint(1) NOT NULL DEFAULT 0,
  `CT7` tinyint(1) NOT NULL DEFAULT 0,
  `TS1` tinyint(1) NOT NULL DEFAULT 0,
  `TS2` tinyint(1) NOT NULL DEFAULT 0,
  `TS3` tinyint(1) NOT NULL DEFAULT 0,
  `TS4` tinyint(1) NOT NULL DEFAULT 0,
  `TS5` tinyint(1) NOT NULL DEFAULT 0,
  `LL1` tinyint(1) NOT NULL DEFAULT 0,
  `LL2` tinyint(1) NOT NULL DEFAULT 0,
  `LL3` tinyint(1) NOT NULL DEFAULT 0,
  `ES1` tinyint(1) NOT NULL DEFAULT 0,
  `ES2` tinyint(1) NOT NULL DEFAULT 0,
  `ES3` tinyint(1) NOT NULL DEFAULT 0,
  `ES4` tinyint(1) NOT NULL DEFAULT 0,
  `EM1` tinyint(1) NOT NULL DEFAULT 0,
  `EM2` tinyint(1) NOT NULL DEFAULT 0,
  `EM3` tinyint(1) NOT NULL DEFAULT 0,
  `LS1` tinyint(1) NOT NULL DEFAULT 0,
  `LS2` tinyint(1) NOT NULL DEFAULT 0,
  `LS3` tinyint(1) NOT NULL DEFAULT 0,
  `LS4` tinyint(1) NOT NULL DEFAULT 0,
  `trash` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_clo_assess`
--

CREATE TABLE `sp_course_clo_assess` (
  `id` int(11) NOT NULL,
  `clo_id` int(11) DEFAULT 0,
  `assess_id` int(11) DEFAULT 0,
  `percentage` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_clo_delivery`
--

CREATE TABLE `sp_course_clo_delivery` (
  `id` int(11) NOT NULL,
  `clo_id` int(11) NOT NULL DEFAULT 0,
  `delivery_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_delivery`
--

CREATE TABLE `sp_course_delivery` (
  `id` int(11) NOT NULL,
  `delivery_name` varchar(50) NOT NULL,
  `delivery_name_bi` varchar(50) NOT NULL,
  `is_main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_level`
--

CREATE TABLE `sp_course_level` (
  `id` int(11) NOT NULL,
  `lvl_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_pic`
--

CREATE TABLE `sp_course_pic` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `pic_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_profile`
--

CREATE TABLE `sp_course_profile` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL,
  `prerequisite` int(11) DEFAULT NULL,
  `offer_sem` tinyint(1) DEFAULT 0,
  `offer_year` tinyint(2) DEFAULT 0,
  `offer_remark` varchar(255) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `synopsis_bi` text DEFAULT NULL,
  `transfer_skill` text DEFAULT NULL,
  `transfer_skill_bi` text DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `feedback_bi` text DEFAULT NULL,
  `staff_academic` text DEFAULT NULL,
  `requirement` text DEFAULT NULL,
  `additional` text DEFAULT NULL,
  `requirement_bi` text DEFAULT NULL,
  `additional_bi` text DEFAULT NULL,
  `offer_at` varchar(200) DEFAULT NULL,
  `objective` text DEFAULT NULL,
  `objective_bi` text DEFAULT NULL,
  `rational` text DEFAULT NULL,
  `rational_bi` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_reference`
--

CREATE TABLE `sp_course_reference` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL,
  `ref_full` text DEFAULT NULL,
  `ref_year` year(4) DEFAULT NULL,
  `is_classic` tinyint(1) DEFAULT 0,
  `is_main` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_slt`
--

CREATE TABLE `sp_course_slt` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL DEFAULT 0,
  `lecture_jam` double NOT NULL DEFAULT 0,
  `lecture_mggu` tinyint(2) NOT NULL DEFAULT 0,
  `tutorial_jam` double NOT NULL DEFAULT 0,
  `tutorial_mggu` tinyint(2) NOT NULL DEFAULT 0,
  `practical_jam` double NOT NULL DEFAULT 0,
  `practical_mggu` tinyint(2) NOT NULL DEFAULT 0,
  `others_jam` double NOT NULL DEFAULT 0,
  `others_mggu` tinyint(2) NOT NULL DEFAULT 0,
  `independent` double NOT NULL DEFAULT 0,
  `nf2f` double NOT NULL DEFAULT 0,
  `is_practical` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_staff`
--

CREATE TABLE `sp_course_staff` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL DEFAULT 0,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `staff_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_syllabus`
--

CREATE TABLE `sp_course_syllabus` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL,
  `clo` varchar(255) DEFAULT NULL,
  `week_num` varchar(20) DEFAULT NULL,
  `duration` tinyint(1) DEFAULT 1,
  `topics` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pnp_lecture` double DEFAULT 0,
  `pnp_tutorial` double DEFAULT 0,
  `pnp_practical` double DEFAULT 0,
  `pnp_others` double DEFAULT 0,
  `tech_lecture` double DEFAULT 0,
  `tech_tutorial` double DEFAULT 0,
  `tech_practical` double DEFAULT 0,
  `tech_others` double DEFAULT 0,
  `independent` double DEFAULT 0,
  `assessment` double DEFAULT 0,
  `nf2f` double DEFAULT 0,
  `syl_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_transfer`
--

CREATE TABLE `sp_course_transfer` (
  `id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL DEFAULT 0,
  `transferable_id` int(11) NOT NULL DEFAULT 0,
  `transfer_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_type`
--

CREATE TABLE `sp_course_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(250) NOT NULL,
  `main_type` tinyint(1) NOT NULL,
  `type_order` tinyint(4) NOT NULL,
  `showing` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_type_main`
--

CREATE TABLE `sp_course_type_main` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `name_bi` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_course_version`
--

CREATE TABLE `sp_course_version` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `version_name` varchar(200) DEFAULT NULL,
  `version_type_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_developed` tinyint(1) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `trash` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `senate_approve_show` tinyint(1) DEFAULT NULL,
  `final_week` varchar(20) DEFAULT NULL,
  `syllabus_break` text DEFAULT NULL,
  `study_week` varchar(20) DEFAULT NULL,
  `prepared_by` int(11) DEFAULT NULL,
  `prepared_at` date DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` date DEFAULT NULL,
  `faculty_approve_at` date DEFAULT NULL,
  `senate_approve_at` date DEFAULT NULL,
  `pgrs_info` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_clo` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_plo` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_tax` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_soft` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_syll` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_slt` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_assess` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_assess_per` tinyint(1) NOT NULL DEFAULT 0,
  `pgrs_ref` tinyint(1) NOT NULL DEFAULT 0,
  `preparedsign_file` text DEFAULT NULL,
  `verifiedsign_file` text DEFAULT NULL,
  `prepared_adj_y` double NOT NULL DEFAULT 0,
  `verified_adj_y` double DEFAULT 0,
  `prepared_size` double NOT NULL DEFAULT 0,
  `verified_size` double NOT NULL DEFAULT 0,
  `verifier_position` text DEFAULT NULL,
  `verified_note` text DEFAULT NULL,
  `justification` text DEFAULT NULL,
  `what_change` text DEFAULT NULL,
  `duplicated_from` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program`
--

CREATE TABLE `sp_program` (
  `id` int(11) NOT NULL,
  `pro_name` varchar(250) NOT NULL,
  `pro_name_bi` varchar(250) NOT NULL,
  `pro_name_short` varchar(50) NOT NULL,
  `pro_level` tinyint(1) NOT NULL COMMENT '4=diploma,6=sarjana muda, 7=sarjana,8=phd',
  `faculty_id` int(11) NOT NULL DEFAULT 1,
  `department_id` int(11) DEFAULT NULL,
  `head_program` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0=under development,1=offered',
  `pro_cat` int(11) NOT NULL DEFAULT 1,
  `pro_field` int(11) DEFAULT NULL,
  `grad_credit` tinyint(3) DEFAULT NULL,
  `prof_body` varchar(250) DEFAULT NULL,
  `coll_inst` varchar(250) DEFAULT NULL,
  `study_mode` tinyint(1) DEFAULT NULL COMMENT '1=coursework,2=mix,3=research',
  `sesi_start` varchar(250) DEFAULT NULL,
  `pro_sustain` text DEFAULT NULL,
  `full_week_long` tinyint(3) DEFAULT NULL,
  `full_week_short` tinyint(3) DEFAULT NULL,
  `full_sem_long` tinyint(3) DEFAULT NULL,
  `full_sem_short` tinyint(3) DEFAULT NULL,
  `part_week_long` tinyint(3) DEFAULT NULL,
  `part_week_short` tinyint(3) DEFAULT NULL,
  `part_sem_long` tinyint(3) DEFAULT NULL,
  `part_sem_short` tinyint(3) DEFAULT NULL,
  `full_time_year` decimal(2,1) DEFAULT NULL,
  `full_max_year` decimal(2,1) DEFAULT NULL,
  `part_max_year` decimal(2,1) DEFAULT NULL,
  `part_time_year` decimal(2,1) DEFAULT NULL,
  `synopsis` text DEFAULT NULL,
  `synopsis_bi` text DEFAULT NULL,
  `objective` text DEFAULT NULL,
  `just_stat` text DEFAULT NULL,
  `just_industry` text DEFAULT NULL,
  `just_employ` text DEFAULT NULL,
  `just_tech` text DEFAULT NULL,
  `just_others` text DEFAULT NULL,
  `nec_perjawatan` text DEFAULT NULL,
  `nec_fizikal` text DEFAULT NULL,
  `nec_kewangan` text DEFAULT NULL,
  `kos_yuran` text DEFAULT NULL,
  `kos_beven` text DEFAULT NULL,
  `pro_tindih_pub` text DEFAULT NULL,
  `pro_tindih_pri` text DEFAULT NULL,
  `jumud` text DEFAULT NULL,
  `admission_req` text DEFAULT NULL,
  `admission_req_bi` text DEFAULT NULL,
  `career` text DEFAULT NULL,
  `career_bi` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `trash` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_access`
--

CREATE TABLE `sp_program_access` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `acc_order` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_category`
--

CREATE TABLE `sp_program_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_level`
--

CREATE TABLE `sp_program_level` (
  `id` int(11) NOT NULL,
  `code` tinyint(1) NOT NULL,
  `level_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_pic`
--

CREATE TABLE `sp_program_pic` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `pic_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_structure`
--

CREATE TABLE `sp_program_structure` (
  `id` int(11) NOT NULL,
  `prg_version_id` int(11) NOT NULL,
  `crs_version_id` int(11) NOT NULL,
  `course_type_id` int(11) NOT NULL,
  `sem_num` tinyint(1) NOT NULL COMMENT 'e.g. 1 or 2 = semester 1, semester dua',
  `year` tinyint(2) NOT NULL,
  `sem_num_part` tinyint(1) NOT NULL,
  `year_part` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_program_version`
--

CREATE TABLE `sp_program_version` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `version_name` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `version_type_id` int(11) NOT NULL,
  `is_developed` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `trash` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `prepared_by` int(11) NOT NULL,
  `prepared_at` date NOT NULL,
  `verified_by` int(11) NOT NULL,
  `verified_at` date NOT NULL,
  `faculty_approve_at` date NOT NULL,
  `senate_approve_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_study_mode`
--

CREATE TABLE `sp_study_mode` (
  `id` int(11) NOT NULL,
  `mode_name` varchar(50) NOT NULL,
  `mode_name_bi` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_transferable`
--

CREATE TABLE `sp_transferable` (
  `id` int(11) NOT NULL,
  `transferable_text` text NOT NULL,
  `transferable_text_bi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sp_version_type`
--

CREATE TABLE `sp_version_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(200) NOT NULL,
  `plo_num` tinyint(4) NOT NULL,
  `plo1` text NOT NULL,
  `plo2` text NOT NULL,
  `plo3` text NOT NULL,
  `plo4` text NOT NULL,
  `plo5` text NOT NULL,
  `plo6` text NOT NULL,
  `plo7` text NOT NULL,
  `plo8` text NOT NULL,
  `plo9` text NOT NULL,
  `plo10` text NOT NULL,
  `plo11` text NOT NULL,
  `plo12` text NOT NULL,
  `plo1_bi` text NOT NULL,
  `plo2_bi` text NOT NULL,
  `plo3_bi` text NOT NULL,
  `plo4_bi` text NOT NULL,
  `plo5_bi` text NOT NULL,
  `plo6_bi` text NOT NULL,
  `plo7_bi` text NOT NULL,
  `plo8_bi` text NOT NULL,
  `plo9_bi` text NOT NULL,
  `plo10_bi` text NOT NULL,
  `plo11_bi` text NOT NULL,
  `plo12_bi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `staff_no` char(10) DEFAULT NULL,
  `staff_title` varchar(20) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `faculty_id` int(11) NOT NULL DEFAULT 1,
  `staff_edu` varchar(300) DEFAULT NULL,
  `is_academic` tinyint(4) NOT NULL DEFAULT 0,
  `nationality` varchar(10) NOT NULL DEFAULT 'MY',
  `position_id` int(5) NOT NULL DEFAULT 0,
  `position_status` int(11) NOT NULL DEFAULT 0,
  `working_status` int(5) NOT NULL DEFAULT 1,
  `leave_start` date DEFAULT NULL,
  `leave_end` date DEFAULT NULL,
  `leave_note` text DEFAULT NULL,
  `rotation_post` varchar(500) DEFAULT NULL,
  `staff_expertise` varchar(300) DEFAULT NULL,
  `staff_gscholar` varchar(500) DEFAULT NULL,
  `officephone` varchar(20) DEFAULT NULL,
  `handphone1` varchar(20) DEFAULT NULL,
  `handphone2` varchar(20) DEFAULT NULL,
  `staff_ic` varchar(15) DEFAULT NULL,
  `staff_dob` date DEFAULT NULL,
  `date_begin_umk` date DEFAULT NULL,
  `date_begin_service` date DEFAULT NULL,
  `staff_note` varchar(100) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `ofis_location` varchar(100) DEFAULT NULL,
  `staff_cv` varchar(300) DEFAULT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `staff_level` int(1) NOT NULL DEFAULT 0,
  `staff_interest` text DEFAULT NULL,
  `staff_department` int(11) NOT NULL DEFAULT 0,
  `research_focus` text DEFAULT NULL,
  `trash` tinyint(1) NOT NULL DEFAULT 0,
  `publish` tinyint(1) NOT NULL DEFAULT 1,
  `staff_active` tinyint(1) NOT NULL DEFAULT 1,
  `high_qualification` varchar(10) DEFAULT NULL,
  `hq_specialization` varchar(100) DEFAULT NULL,
  `hq_year` year(4) DEFAULT NULL,
  `hq_country` varchar(10) DEFAULT NULL,
  `hq_institution` varchar(200) DEFAULT NULL,
  `teaching_submit` tinyint(1) NOT NULL DEFAULT 0,
  `teaching_submit_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `signiture_file` text DEFAULT NULL,
  `tbl4_verify_y` double NOT NULL DEFAULT 0,
  `tbl4_verify_size` double NOT NULL DEFAULT 0,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_department_name`
--

CREATE TABLE `staff_department_name` (
  `dep_id` int(11) NOT NULL,
  `department_name` varchar(250) NOT NULL,
  `department_name_bi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_education`
--

CREATE TABLE `staff_education` (
  `id` int(11) NOT NULL,
  `edu_staff` int(11) NOT NULL,
  `edu_level` int(11) NOT NULL,
  `edu_qualification` varchar(150) NOT NULL,
  `edu_institution` varchar(150) NOT NULL,
  `edu_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_edu_level`
--

CREATE TABLE `staff_edu_level` (
  `id` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_letter_desig`
--

CREATE TABLE `staff_letter_desig` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_main_position`
--

CREATE TABLE `staff_main_position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(200) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `staff_position`
--

CREATE TABLE `staff_position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(46) DEFAULT NULL,
  `position_en` varchar(100) DEFAULT NULL,
  `position_plain` varchar(100) DEFAULT NULL,
  `position_gred` varchar(4) DEFAULT NULL,
  `position_order` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_position_status`
--

CREATE TABLE `staff_position_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(300) NOT NULL,
  `status_cat` varchar(50) NOT NULL,
  `status_order` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_position_type`
--

CREATE TABLE `staff_position_type` (
  `pos_id` int(11) NOT NULL,
  `pos_name_bm` varchar(250) NOT NULL,
  `pos_name_bi` varchar(250) NOT NULL,
  `pos_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_reg_course`
--

CREATE TABLE `staff_reg_course` (
  `stf_reg_id` int(255) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `course_offer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_rotate_name`
--

CREATE TABLE `staff_rotate_name` (
  `rotate_id` int(11) NOT NULL,
  `rotate_name` varchar(300) NOT NULL,
  `rotate_staff` int(11) NOT NULL,
  `date_end` date NOT NULL,
  `date_start` date NOT NULL,
  `rotate_publish` tinyint(1) NOT NULL,
  `rotate_order` decimal(11,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_working_status`
--

CREATE TABLE `staff_working_status` (
  `id` int(11) NOT NULL,
  `work_name` varchar(300) NOT NULL,
  `work_order` decimal(3,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `st_dean_list`
--

CREATE TABLE `st_dean_list` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `st_download`
--

CREATE TABLE `st_download` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `matric_no` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `st_download_cat`
--

CREATE TABLE `st_download_cat` (
  `id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `is_default` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `st_student`
--

CREATE TABLE `st_student` (
  `id` int(11) NOT NULL,
  `matric_no` varchar(20) DEFAULT NULL,
  `nric` varchar(20) DEFAULT NULL,
  `st_name` varchar(100) DEFAULT NULL,
  `program` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  `sync` tinyint(1) NOT NULL DEFAULT 0,
  `faculty_id` int(11) NOT NULL DEFAULT 1,
  `study_level` varchar(10) NOT NULL DEFAULT 'UG'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `saya_awak` int(11) NOT NULL,
  `wer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_appoint_letter`
--

CREATE TABLE `tld_appoint_letter` (
  `id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL DEFAULT 0,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `ref_no` varchar(225) DEFAULT NULL,
  `date_appoint` date DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `steva_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `prg_appoint_letter` double DEFAULT NULL,
  `appoint_check` tinyint(1) NOT NULL DEFAULT 0,
  `manual_file` text DEFAULT NULL,
  `tutorial_only` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_course_lec`
--

CREATE TABLE `tld_course_lec` (
  `id` int(11) NOT NULL,
  `offered_id` int(11) NOT NULL DEFAULT 0,
  `lec_name` varchar(50) DEFAULT NULL,
  `student_num` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `attendance_header` text DEFAULT NULL,
  `attendance_file` text DEFAULT NULL,
  `total_mark` varchar(200) DEFAULT NULL,
  `clo_achieve` varchar(200) DEFAULT NULL,
  `prg_stu_list` tinyint(1) NOT NULL DEFAULT 0,
  `prg_stu_attend` double NOT NULL DEFAULT 0,
  `prg_attend_complete` tinyint(1) NOT NULL DEFAULT 0,
  `prg_stu_assess` double NOT NULL DEFAULT 0,
  `prg_class_cancel` double NOT NULL DEFAULT 0,
  `na_class_cancel` tinyint(1) NOT NULL DEFAULT 0,
  `na_receipt_assess` tinyint(1) NOT NULL DEFAULT 0,
  `prg_receipt_assess` double NOT NULL DEFAULT 0,
  `na_class_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `prg_class_exempt` double NOT NULL DEFAULT 0,
  `prg_overall` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_course_offered`
--

CREATE TABLE `tld_course_offered` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT 0,
  `coordinator` int(11) NOT NULL DEFAULT 0,
  `coor_access` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=draft,10=sbumit',
  `total_students` int(11) NOT NULL DEFAULT 0,
  `max_lec` int(11) NOT NULL DEFAULT 0,
  `prefix_lec` varchar(10) DEFAULT NULL,
  `max_tut` int(11) NOT NULL DEFAULT 0,
  `prefix_tut` varchar(10) DEFAULT NULL,
  `course_version` int(11) DEFAULT 0,
  `material_version` int(11) DEFAULT 0,
  `scriptbest1_file` text DEFAULT NULL,
  `scriptbest2_file` text DEFAULT NULL,
  `scriptbest3_file` text DEFAULT NULL,
  `scriptmod1_file` text DEFAULT NULL,
  `scriptmod2_file` text DEFAULT NULL,
  `scriptmod3_file` text DEFAULT NULL,
  `scriptlow1_file` text DEFAULT NULL,
  `scriptlow2_file` text DEFAULT NULL,
  `scriptlow3_file` text DEFAULT NULL,
  `na_script_final` tinyint(1) NOT NULL DEFAULT 0,
  `course_cqi` text DEFAULT NULL,
  `prg_overall` double DEFAULT 0,
  `prg_crs_ver` decimal(2,1) NOT NULL,
  `prg_material` decimal(2,1) NOT NULL,
  `na_cont_rubrics` tinyint(1) NOT NULL DEFAULT 0,
  `prg_cont_rubrics` double NOT NULL DEFAULT 0,
  `na_cont_material` tinyint(1) NOT NULL DEFAULT 0,
  `prg_cont_material` double NOT NULL DEFAULT 0,
  `na_sum_assess` tinyint(1) NOT NULL DEFAULT 0,
  `prg_sum_assess` double DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  `na_result_final` tinyint(1) NOT NULL DEFAULT 0,
  `prg_result_final` double NOT NULL DEFAULT 0,
  `na_cont_script` tinyint(1) NOT NULL DEFAULT 0,
  `prg_cont_script` double NOT NULL DEFAULT 0,
  `prg_sum_script` double NOT NULL DEFAULT 0,
  `na_cqi` tinyint(1) NOT NULL DEFAULT 0,
  `prg_cqi` double NOT NULL DEFAULT 0,
  `prg_coordinator` double NOT NULL DEFAULT 0,
  `auditor_staff_id` int(11) DEFAULT 0,
  `auditor_file` text DEFAULT NULL,
  `is_audited` tinyint(1) NOT NULL DEFAULT 0,
  `verified_file` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `verified_by` int(11) NOT NULL DEFAULT 0,
  `verified_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_lec_lecturer`
--

CREATE TABLE `tld_lec_lecturer` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `staff_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_max_hour`
--

CREATE TABLE `tld_max_hour` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `max_hour` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_out_course`
--

CREATE TABLE `tld_out_course` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `course_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_past_expe`
--

CREATE TABLE `tld_past_expe` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `employer` varchar(200) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `start_end` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_setting`
--

CREATE TABLE `tld_setting` (
  `id` int(11) NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `max_hour` int(11) NOT NULL DEFAULT 0,
  `accept_hour` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_staff_inv`
--

CREATE TABLE `tld_staff_inv` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `semester_id` int(11) NOT NULL DEFAULT 0,
  `timetable_file` text DEFAULT NULL,
  `staff_check` int(11) NOT NULL DEFAULT 0,
  `prg_timetable` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_teach_course`
--

CREATE TABLE `tld_teach_course` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `rank` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_tem_autoload`
--

CREATE TABLE `tld_tem_autoload` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `running_name` varchar(100) DEFAULT NULL,
  `load_hour` int(11) NOT NULL DEFAULT 0,
  `stop_run` tinyint(1) NOT NULL DEFAULT 0,
  `no_lecture` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_tgt_course`
--

CREATE TABLE `tld_tgt_course` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tld_tmpl_appoint`
--

CREATE TABLE `tld_tmpl_appoint` (
  `id` int(11) NOT NULL,
  `template_name` varchar(200) DEFAULT NULL,
  `dekan` varchar(100) DEFAULT NULL,
  `yg_benar` text DEFAULT NULL,
  `tema` text DEFAULT NULL,
  `per1` text DEFAULT NULL,
  `per1_en` text DEFAULT NULL,
  `signiture_file` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `adj_y` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_tutorial_lec`
--

CREATE TABLE `tld_tutorial_lec` (
  `id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL DEFAULT 0,
  `lec_prefix` varchar(20) DEFAULT NULL,
  `tutorial_name` varchar(50) DEFAULT NULL,
  `student_num` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `prg_class_exempt` double NOT NULL DEFAULT 0,
  `na_class_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `prg_class_cancel` double NOT NULL DEFAULT 0,
  `na_class_cancel` tinyint(1) NOT NULL DEFAULT 0,
  `prg_receipt_assess` double NOT NULL DEFAULT 0,
  `na_receipt_assess` tinyint(1) NOT NULL DEFAULT 0,
  `prg_overall` double NOT NULL DEFAULT 0,
  `prg_stu_attend` double NOT NULL DEFAULT 0,
  `prg_attend_complete` tinyint(1) NOT NULL DEFAULT 0,
  `attendance_header` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tld_tutorial_tutor`
--

CREATE TABLE `tld_tutorial_tutor` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL DEFAULT 0,
  `staff_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_tutor`
--

CREATE TABLE `tutorial_tutor` (
  `id` int(11) NOT NULL,
  `tutorial_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `urlredirect`
--

CREATE TABLE `urlredirect` (
  `id` int(11) NOT NULL,
  `url_to` text NOT NULL,
  `hit_counter` int(11) NOT NULL,
  `latest_hit` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` int(11) DEFAULT NULL,
  `last_login_at` int(11) DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `user_image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_event`
--

CREATE TABLE `web_event` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `city` varchar(100) NOT NULL,
  `venue` varchar(200) NOT NULL,
  `register_link` text NOT NULL,
  `intro_promo` text NOT NULL,
  `promoimg_file` text NOT NULL,
  `newsimg_file` text NOT NULL,
  `report_1` text NOT NULL,
  `report_2` text NOT NULL,
  `imagetop_file` text NOT NULL,
  `imagemiddle_file` text NOT NULL,
  `imagebottom_file` text NOT NULL,
  `publish_promo` tinyint(1) NOT NULL,
  `publish_report` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `target_participant` text NOT NULL,
  `fee` decimal(11,2) NOT NULL,
  `objective` text NOT NULL,
  `register_deadline` date NOT NULL,
  `contact_pic` text NOT NULL,
  `brochure_file` text NOT NULL,
  `speaker` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_front_slider`
--

CREATE TABLE `web_front_slider` (
  `id` int(11) NOT NULL,
  `slide_name` varchar(100) NOT NULL,
  `image_file` text NOT NULL,
  `slide_url` varchar(200) NOT NULL,
  `caption` text NOT NULL,
  `slide_order` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_publish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aaa`
--
ALTER TABLE `aaa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_aduan`
--
ALTER TABLE `adu_aduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_aduan_action`
--
ALTER TABLE `adu_aduan_action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_aduan_progress`
--
ALTER TABLE `adu_aduan_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_aduan_topic`
--
ALTER TABLE `adu_aduan_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_guideline`
--
ALTER TABLE `adu_guideline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adu_setting`
--
ALTER TABLE `adu_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `cf_checklist`
--
ALTER TABLE `cf_checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_assess_material_class`
--
ALTER TABLE `cf_coor_assess_material_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_assess_result_class`
--
ALTER TABLE `cf_coor_assess_result_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_assess_script_class`
--
ALTER TABLE `cf_coor_assess_script_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_result_final`
--
ALTER TABLE `cf_coor_result_final`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_rubrics`
--
ALTER TABLE `cf_coor_rubrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_coor_sum_assess_class`
--
ALTER TABLE `cf_coor_sum_assess_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_date`
--
ALTER TABLE `cf_date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_lec_cancel_class`
--
ALTER TABLE `cf_lec_cancel_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_lec_exempt_class`
--
ALTER TABLE `cf_lec_exempt_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_lec_receipt_class`
--
ALTER TABLE `cf_lec_receipt_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_material`
--
ALTER TABLE `cf_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_material_item`
--
ALTER TABLE `cf_material_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_student_lec`
--
ALTER TABLE `cf_student_lec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_student_tut`
--
ALTER TABLE `cf_student_tut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_tut_cancel_class`
--
ALTER TABLE `cf_tut_cancel_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_tut_exempt_class`
--
ALTER TABLE `cf_tut_exempt_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cf_tut_receipt_class`
--
ALTER TABLE `cf_tut_receipt_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference`
--
ALTER TABLE `conference`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conf_url` (`conf_url`),
  ADD UNIQUE KEY `conf_abbr` (`conf_abbr`);

--
-- Indexes for table `confv_adv`
--
ALTER TABLE `confv_adv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_author`
--
ALTER TABLE `conf_author`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paper_id` (`paper_id`);

--
-- Indexes for table `conf_date`
--
ALTER TABLE `conf_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conf_id` (`conf_id`);

--
-- Indexes for table `conf_date_name`
--
ALTER TABLE `conf_date_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_download`
--
ALTER TABLE `conf_download`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conf_id` (`conf_id`);

--
-- Indexes for table `conf_email_tmplt`
--
ALTER TABLE `conf_email_tmplt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_email_tmplt_set`
--
ALTER TABLE `conf_email_tmplt_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_fee`
--
ALTER TABLE `conf_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_organizer`
--
ALTER TABLE `conf_organizer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_paper`
--
ALTER TABLE `conf_paper`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conf_id` (`conf_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `conf_paper_reviewer`
--
ALTER TABLE `conf_paper_reviewer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_reg`
--
ALTER TABLE `conf_reg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conf_id` (`conf_id`);

--
-- Indexes for table `conf_review_form`
--
ALTER TABLE `conf_review_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_scope`
--
ALTER TABLE `conf_scope`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_secretariat`
--
ALTER TABLE `conf_secretariat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_status`
--
ALTER TABLE `conf_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conf_ttf_day`
--
ALTER TABLE `conf_ttf_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conf_id` (`conf_id`);

--
-- Indexes for table `conf_ttf_time`
--
ALTER TABLE `conf_ttf_time`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`idCountry`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_code` (`country_code`);

--
-- Indexes for table `cp_chapterinbook`
--
ALTER TABLE `cp_chapterinbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cp_chapter_paper`
--
ALTER TABLE `cp_chapter_paper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `database_access`
--
ALTER TABLE `database_access`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `database_names`
--
ALTER TABLE `database_names`
  ADD PRIMARY KEY (`db_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dwd_download`
--
ALTER TABLE `dwd_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dwd_download_cat`
--
ALTER TABLE `dwd_download_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_article`
--
ALTER TABLE `jeb_article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manuscript_no` (`manuscript_no`);

--
-- Indexes for table `jeb_article_author`
--
ALTER TABLE `jeb_article_author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_article_reviewer`
--
ALTER TABLE `jeb_article_reviewer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_article_scope`
--
ALTER TABLE `jeb_article_scope`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_associate`
--
ALTER TABLE `jeb_associate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_email_template`
--
ALTER TABLE `jeb_email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_journal`
--
ALTER TABLE `jeb_journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_review_form`
--
ALTER TABLE `jeb_review_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_setting`
--
ALTER TABLE `jeb_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeb_user_scope`
--
ALTER TABLE `jeb_user_scope`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lec_lecturer`
--
ALTER TABLE `lec_lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `li_senarai`
--
ALTER TABLE `li_senarai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `li_senaraix`
--
ALTER TABLE `li_senaraix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_queue`
--
ALTER TABLE `mail_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_time_to_send` (`time_to_send`),
  ADD KEY `IX_sent_time` (`sent_time`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `option_option`
--
ALTER TABLE `option_option`
  ADD PRIMARY KEY (`ooption_id`);

--
-- Indexes for table `proceeding`
--
ALTER TABLE `proceeding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proc_paper`
--
ALTER TABLE `proc_paper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `rp_award`
--
ALTER TABLE `rp_award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_award_tag`
--
ALTER TABLE `rp_award_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_consultation`
--
ALTER TABLE `rp_consultation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_consultation_tag`
--
ALTER TABLE `rp_consultation_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_knowledge_transfer`
--
ALTER TABLE `rp_knowledge_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_knowledge_transfer_member`
--
ALTER TABLE `rp_knowledge_transfer_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_membership`
--
ALTER TABLE `rp_membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_publication`
--
ALTER TABLE `rp_publication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_pub_author`
--
ALTER TABLE `rp_pub_author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_pub_editor`
--
ALTER TABLE `rp_pub_editor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_pub_tag`
--
ALTER TABLE `rp_pub_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_pub_type`
--
ALTER TABLE `rp_pub_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_research`
--
ALTER TABLE `rp_research`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_researcher`
--
ALTER TABLE `rp_researcher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_research_grant`
--
ALTER TABLE `rp_research_grant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rp_status`
--
ALTER TABLE `rp_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_unique` (`provider`,`client_id`),
  ADD UNIQUE KEY `account_unique_code` (`code`),
  ADD KEY `fk_user_account` (`user_id`);

--
-- Indexes for table `sponsor_category`
--
ALTER TABLE `sponsor_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_assessment_cat`
--
ALTER TABLE `sp_assessment_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_clo_verb`
--
ALTER TABLE `sp_clo_verb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course`
--
ALTER TABLE `sp_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_access`
--
ALTER TABLE `sp_course_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `sp_course_assessment`
--
ALTER TABLE `sp_course_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_class`
--
ALTER TABLE `sp_course_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_clo`
--
ALTER TABLE `sp_course_clo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_clo_assess`
--
ALTER TABLE `sp_course_clo_assess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clo_id` (`clo_id`);

--
-- Indexes for table `sp_course_clo_delivery`
--
ALTER TABLE `sp_course_clo_delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clo_id` (`clo_id`),
  ADD KEY `delivery_id` (`delivery_id`);

--
-- Indexes for table `sp_course_delivery`
--
ALTER TABLE `sp_course_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_level`
--
ALTER TABLE `sp_course_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_pic`
--
ALTER TABLE `sp_course_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `sp_course_profile`
--
ALTER TABLE `sp_course_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crs_version_id` (`crs_version_id`);

--
-- Indexes for table `sp_course_reference`
--
ALTER TABLE `sp_course_reference`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_slt`
--
ALTER TABLE `sp_course_slt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_staff`
--
ALTER TABLE `sp_course_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `course_id` (`crs_version_id`);

--
-- Indexes for table `sp_course_syllabus`
--
ALTER TABLE `sp_course_syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_transfer`
--
ALTER TABLE `sp_course_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_type`
--
ALTER TABLE `sp_course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_type_main`
--
ALTER TABLE `sp_course_type_main`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_course_version`
--
ALTER TABLE `sp_course_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_program`
--
ALTER TABLE `sp_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_level` (`pro_level`);

--
-- Indexes for table `sp_program_access`
--
ALTER TABLE `sp_program_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `course_id` (`program_id`);

--
-- Indexes for table `sp_program_category`
--
ALTER TABLE `sp_program_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_program_level`
--
ALTER TABLE `sp_program_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_program_pic`
--
ALTER TABLE `sp_program_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `course_id` (`program_id`);

--
-- Indexes for table `sp_program_structure`
--
ALTER TABLE `sp_program_structure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_program_version`
--
ALTER TABLE `sp_program_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_study_mode`
--
ALTER TABLE `sp_study_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_transferable`
--
ALTER TABLE `sp_transferable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sp_version_type`
--
ALTER TABLE `sp_version_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`id`);

--
-- Indexes for table `staff_department_name`
--
ALTER TABLE `staff_department_name`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `staff_education`
--
ALTER TABLE `staff_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_edu_level`
--
ALTER TABLE `staff_edu_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_letter_desig`
--
ALTER TABLE `staff_letter_desig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_main_position`
--
ALTER TABLE `staff_main_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_position`
--
ALTER TABLE `staff_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_position_status`
--
ALTER TABLE `staff_position_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_position_type`
--
ALTER TABLE `staff_position_type`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `staff_reg_course`
--
ALTER TABLE `staff_reg_course`
  ADD PRIMARY KEY (`stf_reg_id`);

--
-- Indexes for table `staff_rotate_name`
--
ALTER TABLE `staff_rotate_name`
  ADD PRIMARY KEY (`rotate_id`);

--
-- Indexes for table `staff_working_status`
--
ALTER TABLE `staff_working_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_dean_list`
--
ALTER TABLE `st_dean_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_download`
--
ALTER TABLE `st_download`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_download_cat`
--
ALTER TABLE `st_download_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `st_student`
--
ALTER TABLE `st_student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matric_no` (`matric_no`);

--
-- Indexes for table `tld_appoint_letter`
--
ALTER TABLE `tld_appoint_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_course_lec`
--
ALTER TABLE `tld_course_lec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_course_offered`
--
ALTER TABLE `tld_course_offered`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_lec_lecturer`
--
ALTER TABLE `tld_lec_lecturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_max_hour`
--
ALTER TABLE `tld_max_hour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_out_course`
--
ALTER TABLE `tld_out_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_past_expe`
--
ALTER TABLE `tld_past_expe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_setting`
--
ALTER TABLE `tld_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_staff_inv`
--
ALTER TABLE `tld_staff_inv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_teach_course`
--
ALTER TABLE `tld_teach_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_tem_autoload`
--
ALTER TABLE `tld_tem_autoload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_tgt_course`
--
ALTER TABLE `tld_tgt_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_tmpl_appoint`
--
ALTER TABLE `tld_tmpl_appoint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_tutorial_lec`
--
ALTER TABLE `tld_tutorial_lec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tld_tutorial_tutor`
--
ALTER TABLE `tld_tutorial_tutor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `tutorial_tutor`
--
ALTER TABLE `tutorial_tutor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `urlredirect`
--
ALTER TABLE `urlredirect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_event`
--
ALTER TABLE `web_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_front_slider`
--
ALTER TABLE `web_front_slider`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aaa`
--
ALTER TABLE `aaa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adu_aduan`
--
ALTER TABLE `adu_aduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adu_aduan_action`
--
ALTER TABLE `adu_aduan_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adu_aduan_topic`
--
ALTER TABLE `adu_aduan_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adu_guideline`
--
ALTER TABLE `adu_guideline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adu_setting`
--
ALTER TABLE `adu_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_checklist`
--
ALTER TABLE `cf_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_assess_material_class`
--
ALTER TABLE `cf_coor_assess_material_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_assess_result_class`
--
ALTER TABLE `cf_coor_assess_result_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_assess_script_class`
--
ALTER TABLE `cf_coor_assess_script_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_result_final`
--
ALTER TABLE `cf_coor_result_final`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_rubrics`
--
ALTER TABLE `cf_coor_rubrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_coor_sum_assess_class`
--
ALTER TABLE `cf_coor_sum_assess_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_date`
--
ALTER TABLE `cf_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_lec_cancel_class`
--
ALTER TABLE `cf_lec_cancel_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_lec_exempt_class`
--
ALTER TABLE `cf_lec_exempt_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_lec_receipt_class`
--
ALTER TABLE `cf_lec_receipt_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_material`
--
ALTER TABLE `cf_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_material_item`
--
ALTER TABLE `cf_material_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_student_lec`
--
ALTER TABLE `cf_student_lec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_student_tut`
--
ALTER TABLE `cf_student_tut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_tut_cancel_class`
--
ALTER TABLE `cf_tut_cancel_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_tut_exempt_class`
--
ALTER TABLE `cf_tut_exempt_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cf_tut_receipt_class`
--
ALTER TABLE `cf_tut_receipt_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conference`
--
ALTER TABLE `conference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `confv_adv`
--
ALTER TABLE `confv_adv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_author`
--
ALTER TABLE `conf_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_date`
--
ALTER TABLE `conf_date`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_date_name`
--
ALTER TABLE `conf_date_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_download`
--
ALTER TABLE `conf_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_email_tmplt`
--
ALTER TABLE `conf_email_tmplt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_email_tmplt_set`
--
ALTER TABLE `conf_email_tmplt_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_fee`
--
ALTER TABLE `conf_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_organizer`
--
ALTER TABLE `conf_organizer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_paper`
--
ALTER TABLE `conf_paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_paper_reviewer`
--
ALTER TABLE `conf_paper_reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_reg`
--
ALTER TABLE `conf_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_scope`
--
ALTER TABLE `conf_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_secretariat`
--
ALTER TABLE `conf_secretariat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_status`
--
ALTER TABLE `conf_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_ttf_day`
--
ALTER TABLE `conf_ttf_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_ttf_time`
--
ALTER TABLE `conf_ttf_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `idCountry` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_chapterinbook`
--
ALTER TABLE `cp_chapterinbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cp_chapter_paper`
--
ALTER TABLE `cp_chapter_paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_access`
--
ALTER TABLE `database_access`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `database_names`
--
ALTER TABLE `database_names`
  MODIFY `db_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dwd_download`
--
ALTER TABLE `dwd_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dwd_download_cat`
--
ALTER TABLE `dwd_download_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_article`
--
ALTER TABLE `jeb_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_article_author`
--
ALTER TABLE `jeb_article_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_article_reviewer`
--
ALTER TABLE `jeb_article_reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_article_scope`
--
ALTER TABLE `jeb_article_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_associate`
--
ALTER TABLE `jeb_associate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_email_template`
--
ALTER TABLE `jeb_email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_journal`
--
ALTER TABLE `jeb_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_review_form`
--
ALTER TABLE `jeb_review_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_setting`
--
ALTER TABLE `jeb_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeb_user_scope`
--
ALTER TABLE `jeb_user_scope`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lec_lecturer`
--
ALTER TABLE `lec_lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_senarai`
--
ALTER TABLE `li_senarai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `li_senaraix`
--
ALTER TABLE `li_senaraix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_queue`
--
ALTER TABLE `mail_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `option_option`
--
ALTER TABLE `option_option`
  MODIFY `ooption_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proceeding`
--
ALTER TABLE `proceeding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proc_paper`
--
ALTER TABLE `proc_paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_award`
--
ALTER TABLE `rp_award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_award_tag`
--
ALTER TABLE `rp_award_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_consultation`
--
ALTER TABLE `rp_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_consultation_tag`
--
ALTER TABLE `rp_consultation_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_knowledge_transfer`
--
ALTER TABLE `rp_knowledge_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_knowledge_transfer_member`
--
ALTER TABLE `rp_knowledge_transfer_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_membership`
--
ALTER TABLE `rp_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_publication`
--
ALTER TABLE `rp_publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_pub_author`
--
ALTER TABLE `rp_pub_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_pub_editor`
--
ALTER TABLE `rp_pub_editor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_pub_tag`
--
ALTER TABLE `rp_pub_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_pub_type`
--
ALTER TABLE `rp_pub_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_research`
--
ALTER TABLE `rp_research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_researcher`
--
ALTER TABLE `rp_researcher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_research_grant`
--
ALTER TABLE `rp_research_grant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rp_status`
--
ALTER TABLE `rp_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sponsor_category`
--
ALTER TABLE `sponsor_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_assessment_cat`
--
ALTER TABLE `sp_assessment_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_clo_verb`
--
ALTER TABLE `sp_clo_verb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course`
--
ALTER TABLE `sp_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_access`
--
ALTER TABLE `sp_course_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_assessment`
--
ALTER TABLE `sp_course_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_class`
--
ALTER TABLE `sp_course_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_clo`
--
ALTER TABLE `sp_course_clo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_clo_assess`
--
ALTER TABLE `sp_course_clo_assess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_clo_delivery`
--
ALTER TABLE `sp_course_clo_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_delivery`
--
ALTER TABLE `sp_course_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_level`
--
ALTER TABLE `sp_course_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_pic`
--
ALTER TABLE `sp_course_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_profile`
--
ALTER TABLE `sp_course_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_reference`
--
ALTER TABLE `sp_course_reference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_slt`
--
ALTER TABLE `sp_course_slt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_staff`
--
ALTER TABLE `sp_course_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_syllabus`
--
ALTER TABLE `sp_course_syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_transfer`
--
ALTER TABLE `sp_course_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_type`
--
ALTER TABLE `sp_course_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_type_main`
--
ALTER TABLE `sp_course_type_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_course_version`
--
ALTER TABLE `sp_course_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program`
--
ALTER TABLE `sp_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_access`
--
ALTER TABLE `sp_program_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_category`
--
ALTER TABLE `sp_program_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_level`
--
ALTER TABLE `sp_program_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_pic`
--
ALTER TABLE `sp_program_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_structure`
--
ALTER TABLE `sp_program_structure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_program_version`
--
ALTER TABLE `sp_program_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_study_mode`
--
ALTER TABLE `sp_study_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_transferable`
--
ALTER TABLE `sp_transferable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sp_version_type`
--
ALTER TABLE `sp_version_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_department_name`
--
ALTER TABLE `staff_department_name`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_education`
--
ALTER TABLE `staff_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_edu_level`
--
ALTER TABLE `staff_edu_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_letter_desig`
--
ALTER TABLE `staff_letter_desig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_main_position`
--
ALTER TABLE `staff_main_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_position`
--
ALTER TABLE `staff_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_position_status`
--
ALTER TABLE `staff_position_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_position_type`
--
ALTER TABLE `staff_position_type`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_reg_course`
--
ALTER TABLE `staff_reg_course`
  MODIFY `stf_reg_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_rotate_name`
--
ALTER TABLE `staff_rotate_name`
  MODIFY `rotate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_working_status`
--
ALTER TABLE `staff_working_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_dean_list`
--
ALTER TABLE `st_dean_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_download`
--
ALTER TABLE `st_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_download_cat`
--
ALTER TABLE `st_download_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_student`
--
ALTER TABLE `st_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_appoint_letter`
--
ALTER TABLE `tld_appoint_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_course_lec`
--
ALTER TABLE `tld_course_lec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_course_offered`
--
ALTER TABLE `tld_course_offered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_lec_lecturer`
--
ALTER TABLE `tld_lec_lecturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_max_hour`
--
ALTER TABLE `tld_max_hour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_out_course`
--
ALTER TABLE `tld_out_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_past_expe`
--
ALTER TABLE `tld_past_expe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_setting`
--
ALTER TABLE `tld_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_staff_inv`
--
ALTER TABLE `tld_staff_inv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_teach_course`
--
ALTER TABLE `tld_teach_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_tem_autoload`
--
ALTER TABLE `tld_tem_autoload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_tgt_course`
--
ALTER TABLE `tld_tgt_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_tmpl_appoint`
--
ALTER TABLE `tld_tmpl_appoint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_tutorial_lec`
--
ALTER TABLE `tld_tutorial_lec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tld_tutorial_tutor`
--
ALTER TABLE `tld_tutorial_tutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutorial_tutor`
--
ALTER TABLE `tutorial_tutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `urlredirect`
--
ALTER TABLE `urlredirect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_event`
--
ALTER TABLE `web_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_front_slider`
--
ALTER TABLE `web_front_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `conf_author`
--
ALTER TABLE `conf_author`
  ADD CONSTRAINT `conf_author_ibfk_1` FOREIGN KEY (`paper_id`) REFERENCES `conf_paper` (`id`);

--
-- Constraints for table `conf_date`
--
ALTER TABLE `conf_date`
  ADD CONSTRAINT `conf_date_ibfk_1` FOREIGN KEY (`conf_id`) REFERENCES `conference` (`id`);

--
-- Constraints for table `conf_download`
--
ALTER TABLE `conf_download`
  ADD CONSTRAINT `conf_download_ibfk_1` FOREIGN KEY (`conf_id`) REFERENCES `conference` (`id`);

--
-- Constraints for table `conf_paper`
--
ALTER TABLE `conf_paper`
  ADD CONSTRAINT `conf_paper_ibfk_1` FOREIGN KEY (`conf_id`) REFERENCES `conference` (`id`),
  ADD CONSTRAINT `conf_paper_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `conf_reg`
--
ALTER TABLE `conf_reg`
  ADD CONSTRAINT `conf_reg_ibfk_1` FOREIGN KEY (`conf_id`) REFERENCES `conference` (`id`);

--
-- Constraints for table `conf_ttf_day`
--
ALTER TABLE `conf_ttf_day`
  ADD CONSTRAINT `conf_ttf_day_ibfk_1` FOREIGN KEY (`conf_id`) REFERENCES `conference` (`id`);

--
-- Constraints for table `conf_ttf_time`
--
ALTER TABLE `conf_ttf_time`
  ADD CONSTRAINT `conf_ttf_time_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `conf_ttf_day` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sp_course_access`
--
ALTER TABLE `sp_course_access`
  ADD CONSTRAINT `sp_course_access_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `sp_course` (`id`);

--
-- Constraints for table `sp_course_clo_delivery`
--
ALTER TABLE `sp_course_clo_delivery`
  ADD CONSTRAINT `sp_course_clo_delivery_ibfk_2` FOREIGN KEY (`delivery_id`) REFERENCES `sp_course_delivery` (`id`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
