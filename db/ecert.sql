-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2022 at 09:17 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

CREATE TABLE `cert_data` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `identifier` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cert_data`
--

INSERT INTO `cert_data` (`id`, `name`, `identifier`) VALUES
(1, 'NUR ATHIRAH BINTI MOHD ALUWI', 'A20D0211F'),
(2, 'WAN NUR FATIN FITRIAH BINTI WAN IZANI', 'A20B2349'),
(3, 'UMMI QURRATUAINI BINTI MOHD RASID', 'A21B3476'),
(4, 'CHIA AI VEE', 'A21B2437'),
(5, 'NAJWA NAJIHAH BINTI ABDUL AMIT', 'A21B3340'),
(6, 'RAIDAH BINTI HASAN BASIR', 'A20B2346'),
(7, 'SITI HANIS BINTI ZAINUDDIN', '940719105656'),
(8, 'INKA RINJANI AMARTA BINTI JAMALUDIN', 'A21A3263'),
(9, 'JOANNA A/P MURUGASAN', 'A21A2519'),
(10, 'JOANNA A/P MURUGASAN', 'A21A2519'),
(11, 'LOSHINNIY NAIR A/P S.BASKARAN', 'A21A2556'),
(12, 'SUBAASHINEE D/O KUPUSAMY', 'A21A3126'),
(13, 'PAVEETHRA A/P MURALI', 'A21A3031'),
(14, 'HASHRINI A/P PRATHY', 'A21A2492'),
(15, 'SITI NURAISAH BINTI SULKIFLY ', 'A21A3106'),
(16, 'LOH ZI LIANG', 'A21A2555'),
(17, 'FOO SIN YI', 'A21A2479'),
(18, 'LIM YUEN YING', 'A21A2551'),
(19, 'NOR ALIA ASYIKIN BINTI YUSOP', 'A21A2717'),
(20, 'NURFADHILAH AMIRAH BINTI MOHAMED KASBI', 'A21A2921'),
(21, 'VISSHA SHALINI', 'A21A3173'),
(22, 'MEERAA A/P MATHIALAGAN ', 'A21A2569'),
(23, 'HASHRINI A/P PRATHY', 'A21A2492'),
(24, 'ROGINESHA A/P RAMESH', 'A21A3053'),
(25, 'FOONG CENG YAN', 'A21A2480'),
(26, 'NURLAILI LIYANA BINTI JAPAR', 'A21A2933'),
(27, 'NUR ADRIANA BINTI MANSOR', 'A21A2753'),
(28, 'JOEY TAN JO YIE', 'A21A3272'),
(29, 'NG GEOK PENG', 'A21A3342'),
(30, 'DANICA LEE JIA YEE', 'A21A3240'),
(31, 'CHENG ZHI XUAN ', 'A21A2436 '),
(32, 'DENESSHWARAN A/L DEVAN', 'A20B2334'),
(33, 'KIRTINI A/P DORAISAMY', 'A20B2338'),
(34, 'BOAZ MARK A/L PHILOMENATHAN ', 'A21A2425'),
(35, 'SITI NURNABILA BINTI MOHD SHAKIRAN', 'A21B3456'),
(36, 'YONG YUK TING', 'A21A3197'),
(37, 'Nur Faradiah binti Jamingon', 'A21A2827'),
(38, 'NAZRIN SHAH BIN KAMARUDIN', 'A184801'),
(39, 'LIM XUAN XUAN', 'A21A2550'),
(40, 'Nurul Hidayah Nasuha binti A Halim', 'A21b2987'),
(41, 'SITI AISYAH MAISARAH BINTI SHAKRONI ', 'A21A3083'),
(42, 'NURUL NADHIRAH BINTI HASHIM ', 'A21A3006'),
(43, 'SITI AISHAH BINTI KHAIRUDIN', 'A21A3079'),
(44, 'KRITHIGA A/P GUNASEGARAN', 'A21A3279'),
(45, 'LYVINIYA A/P THIYAGARASAN', 'A21A2560'),
(46, 'THAHNUHSHAH A/P ARUMUGAM', 'A21A3153'),
(47, 'AIN HUSNINA', 'A21A2706'),
(48, 'NG JIA MENG', 'A188016'),
(49, 'CHUNG ZI YING', 'A21A2446'),
(50, 'TAN HUI LIANG', 'A21A3136'),
(51, 'NUR ADLEEN BINTI AZREE', 'A21A2752 '),
(52, 'SITI NURUL IZZATI BINTI RAZAK', 'A21A3112'),
(53, 'NURAINA NAJWA BINTI MOHAMAD YUSRI', 'A21A3393'),
(54, 'WINLY TEH KAH ERN', 'A21A3191 '),
(55, 'NOORIN SYAMIRA BINTI AZMAN', 'A21A2711'),
(56, 'SITI HARNINI BINTI MOHD ASERI', 'A21A3084'),
(57, 'FAZLIN SHAKINA BINTI FAIZAN HELMY', 'A21A2476'),
(58, 'NURUL NAZIFA BINTI NUZUL ASMADI', 'A20B2344'),
(59, 'NURUL ATIQAH BINTI ABDULLAH', 'A20B2343'),
(60, 'KONG YI CHENG', 'A21A3278'),
(61, 'NURAINA NAJWA BINTI MOHAMAD YUSRI', 'A21A3393'),
(62, 'PHRIYAADHARSHINI A/P PANEERSELVAN', 'A20B2345'),
(63, 'AIDA NAZIRAH BINTI MOHD SOBRI', 'A21A2367'),
(64, 'AMIRA ZAFIRA BINTI MOHD ZAMRI ', 'A21B2389'),
(65, 'NUR ASYIKIN BINTI AZMAN', 'A21A2803'),
(66, 'AMNI ARIZZA BINTI MOHD IDRIS ', 'A21A2394'),
(67, 'MOHAMAD SHAFIQ HAFIZEE BIN MOHD AZALI', 'A21A2591'),
(68, 'AZZUARIA A/P BAKI', 'A21A2424'),
(69, 'NURUL AISHAH BINTI OTSMAN', 'A21A2958'),
(70, 'PANIMALAR D/O VISWANATHAN', 'A21B3428'),
(71, 'MUHAMMAD ZULFAHMIBIN HANAFI', 'A21A2680'),
(72, 'WAN AHMAD AIMAN NUR HAQEEM BIN WAN MUHAMMAD ', 'A21A3177'),
(73, 'POOJAA A/P SUBRAMANIAM', 'A20B2331'),
(74, 'ROSNAH BINTI ISMAIL', 'P21E001F'),
(75, 'NUR IFFAH IZZATI BINTI NORAMIZI', 'A188621'),
(76, 'AINA IRDINA BINTI SAZLI', 'A21A3214'),
(77, 'CARMEN LEE JIA WEN', 'A21A2426'),
(78, 'NUR SYAFIRA NAJWA BINTI BEDOLAH', 'A20B2350'),
(79, 'ROSE HASLINDA BINTI ROSLI', 'A20B2351'),
(80, 'NUR SYAFIQAH BINTI SAMSUDIN', 'A21A3389'),
(81, 'NUR HIDAYAH BINTI AMRAN', 'A21A3377'),
(82, 'RUZANIFAH BINTI KOSNIN', '01807A'),
(83, 'RASYIQAH RAIDAH BINTI RAMLI', 'A21A3432'),
(84, 'LOI TING YING', 'A21A3287'),
(85, 'NOR SYAFIKA MOHD KAMAL', 'A21A2734'),
(86, 'BILLY KANG', 'P13E003P'),
(87, 'LIM CHAO YONG', 'A186201'),
(88, 'NURLIYANA BINTI ROSLI', 'A21B3401'),
(89, 'NURUL NABILAH BINTI NOR HISHAM ', 'A21A3005'),
(90, 'SYAHIRAH BINTI AZMAN', 'A21A3127'),
(91, 'KOH KIE KING', 'A21A2532'),
(92, 'NUR FITRATUN NAIMAH BINTI JAMARUL HISHAM', 'A21A2840'),
(93, 'SITI NASUHA BINTI ALI', 'A21A3090'),
(94, 'YONG YUK TING', 'A21A3197'),
(95, 'LEE WAI FONG', 'A21A2542'),
(96, 'FATIN NORSYAKIRAH BINTI SHAHRON', 'A21A2469'),
(97, 'WAN NURUL AISYAH BINTI MOHD SHUIB', 'A21B3484'),
(98, 'NURUL NADIA BINTI AZMI ', 'A21A3007'),
(99, 'NG KOK YUNG', 'A21A2691'),
(100, 'MUHAMMAD FADHLIL WAFI BIN AHMAD ZAWAWI', '2022758577'),
(101, 'LIM WEI BOON', 'A21A2549'),
(102, 'UVEINTHIRAN A/L SINIVASAN ', 'A20B2347'),
(103, 'TAN ZHENG XIN', 'A21A3142'),
(104, 'NUR HANIM HUSNA BINTI NAZLI', 'A20B2342'),
(105, 'ANGEL SHIM YING YING', 'A21A2399'),
(106, 'SITI NUR FAKHIRA ALANI BINTI MOHD MUSTAFFA KAMAL', 'A21A3102'),
(107, 'IFFAH MUNIRAH BINTI RIHDWAN ', 'A20B2336'),
(108, 'ALI ALI MOHAMMED ALGHAIL ', 'A21A3217'),
(109, 'SITI NUR HANISAH BINTI AHMAD KAMIL', 'A21A3451'),
(110, 'MUHAMMAD AZRIN IQBAL BIN AHMAD TARMIZAN', 'A21A2634'),
(111, 'NOR AEMIERA ADRIANA BINTI NORAZMI ', 'A21A2712 '),
(112, 'SITI NURUL SHUHADA DERAMAN', '00660A'),
(113, 'GAN CHOON HEE', 'A21A2482'),
(114, 'MOHD HANIZUN HANAFI', '01914a'),
(115, 'FARISYA NABILLA BINTI KASMAN', 'A21A2464'),
(116, 'MUHAMMAD IZZUDDIN BIN AZIZZI', 'A21A2660'),
(117, 'SITI NUR DAMIA HUDA BINTI HUSSIN', 'A21A3449'),
(118, 'NURULAIN WAJIHAH BINTI AHMAD', 'A17A0859'),
(119, 'NUR AIMI FARHANA BINTI CHE HUSIN ', 'A21A2757'),
(120, 'Sharmila A/P Sasi kumar', 'A21A3072 '),
(121, 'Ong Lee Jing', 'A21A3029'),
(122, 'FARISYA NABILLA BINTI KASMAN', 'A21A2464'),
(123, 'ROSMILAH BINTI HAMID ', 'A21A3057'),
(124, 'JUHAIRAH BINTI JUHAN', 'A21A2521'),
(125, 'MARIAMAH BINTI ASIS', 'A21A2566'),
(126, 'BAO YING WONG', 'A21A3192'),
(127, 'MUHAMMAD ZIKRY BIN ZAKARIA', 'A21A2679'),
(128, 'NUR DAMIA KHAIRIAH BINTI AZREE', 'A21A2818'),
(129, 'THARISANA D/O KARUNAGARAN ', 'A21B3473'),
(130, 'NUR AMIZAH AQILAH BINTI YA\'ACOB ', 'A21A2789'),
(131, 'SITI FARAHADILAH BINTI ZAINAL', 'A21A3444'),
(132, 'KHAMIINESVARY A/P BALU', 'A21A3277'),
(133, 'HAZIQ ZULHAIRI BIN NORHISHAM', 'A21A2494'),
(134, 'JAYAVARMAN A/L ARUTCHELVAN', 'A21A2518'),
(135, 'RUBINI D/O THAMOTHARAN', 'A21A3058'),
(136, 'PHANYSA A/P AFFINAN', 'A21A3033'),
(137, 'Kishan A/L Ettisamy', 'A21A2530 '),
(138, 'NUR ANISYA BINTI AZIZ', 'A21A2797'),
(139, 'AZIIYAH ROOBIYAH BINTI MD.NOOR', 'A21A3232'),
(140, 'SHANTHINI A/P RAMESH ', 'A21A3439 '),
(141, 'ANG DING HANG', 'A21A2398 '),
(142, 'NURAINA NAJWA BINTI MOHAMAD YUSRI', 'A21A3393'),
(143, 'NUR ANIS SOFIA BINTI HAYUZA ', 'A21A2796 '),
(144, 'GOH QIAN WEN', 'A21A2486'),
(145, 'MUHAMMAD AMIR SYAZWAN BIN ROSLI ', 'A21A2624'),
(146, 'MUHAMMAD TAUFIKHIDAYAT PULUNGAN BIN TAJUDDIN ', 'A21A2676'),
(147, 'NUR ATIKAH BINTI AHMAD TAMIZI', 'A21A2811'),
(148, 'MOHAMAD IKMAL BIN ISHAMUDIN', 'A20A1457'),
(149, 'MOHD RAZIQ SYAHMI BIN SUKRI', 'A21A2596'),
(150, 'DICKSON KOK HAO SON', 'A21A2451'),
(151, 'AUNI SYAFIQAH BINTI ZULKEFLI', 'A21A3230'),
(152, 'MUHAMMAD AIDIL SHAZWAL BIN ABDUL HADI', 'A21A2614'),
(153, 'SHAFIQAH ADRIANA BINTI KHAIRULNIZAD', 'A21B3438'),
(154, 'NURUL ATHIRAH BINTI ABDUL RAZAK ', 'A21B3413'),
(155, 'NUR SYAMIRA ALIA BINTI HUSSIN ', 'A21B3391'),
(156, 'HANOOSURRIYAH A/P SAGER', 'A21A2490'),
(157, 'AMIR FARIS BIN ISHAK', 'A21A2388'),
(158, 'NURUL AIN BINTI NASRI', 'A21A2949'),
(159, 'NURFARISYA HANI BINTI AZHAR', 'A21A2925'),
(160, 'MOHAMAD AIMAN BIN CHE ROSE', 'A21A2577'),
(161, 'SITI SARAH WAHIDA BINTI LATIF', 'A21A3457'),
(162, 'NURUL RABIATULADAWIAH BINTI ZULLIHIP ', 'A21a3014'),
(163, 'NURUL HAZIQAH BINTI ELIAS', 'A21A3415'),
(164, 'NUREZADATUL NAZLIENSYAFIRA BINTI RUSTAM', 'A21A2920'),
(165, 'VANIISHAA A/P NESA RAJA', 'A20B2348'),
(166, 'TENGKU NOR AISYAH BINTI TENGKU ABAS', 'A21A3149'),
(167, 'NIK HALISHA BINTI ROSLI', 'A21A3346'),
(168, 'NUR AZLINA BINTI ABDUL HAZIZ', 'A21A3366'),
(169, 'MOHAMAD AKHMAL NIZARIFF BIN ROSLI', 'A21A2578'),
(170, 'NOR LIYANA ATHIRAH BT MD YUSOF', 'A21B3352'),
(171, 'NUR AINA HUSNA BINTI MOHD JAMIL ', 'A21A3359'),
(172, 'NUR SYAMIMI NADHIRAH BINTI RUSLI', 'A21A2899'),
(173, 'CHIN KAH KEAN', 'A21A2438'),
(174, 'CHAU ZHAN TENG', 'A21A2429'),
(175, 'NATASHA ARINA BINTI MOHD SAIFFUL', 'A21A2687'),
(176, 'NUR ALIAH ADILAH BT JAMALUDIN ', 'A21A2775'),
(177, 'ALYIA NAZHIFA BINTI ZAMRI', 'A21A3219'),
(178, 'MUHAMAD HARIZ BIN YAHYA ', 'A21A3305'),
(179, 'ANIS MUNIRAH BT MD TERMIZI', 'A21A2402'),
(180, 'TAUFIQ HAMDI BIN MOHAMMAD AZMI', 'A21B3143'),
(181, 'MOHD AIDIL AKMAL BIN ARBAIN', 'A20B2340'),
(182, 'TIN LI WEN', 'A21A3159'),
(183, 'SITI HAJAR BINTI MOHD SAAD ', 'A21A3446'),
(184, 'NURZAINE BINTI DENNY TSEN', 'A21A3027'),
(185, 'DAKSHAYANI A/P SHIVARAJ ', 'A21A2447'),
(186, 'MUHAMMAD IZZUDDIN BIN AZIZZI', 'A21A2660'),
(187, 'SUJITAA A/P SELVAM', 'A21A3465'),
(188, 'NUR DINI BINTI KAMARULZAMAN ', 'A21A2819'),
(189, 'NUR KHADIJAH BADIHAH BINTI ABU BAKAR', 'A21A2864'),
(190, 'NURUL AIN SYAZWANIEY BINTI ZAMRI', 'A21A2953'),
(191, 'NORFARISHA ATHIRA BINTI ROSLI', 'a21a2746'),
(192, 'NURUL ATIQAH BINTI A’ADENAN ', 'A21a2968'),
(193, 'SITI WAN AISHAH BINTI WAN MOHD SARIFIZA', 'A21A3117'),
(194, 'SITI NURUL IZZATI BINTI RAZAK', 'A21A3112'),
(195, 'ALIAH AZZAHRAH BINTI SHAHIDANI', 'A20B2333'),
(196, 'NUR LIYANA BT MOHD RODZI', 'A21A2868'),
(197, 'MADIHAH BINTI HARUN', 'A21A2561'),
(198, 'LAW CHEE HONG', 'A21A2541'),
(199, 'NUR SYAKIRAH NAJWA BINTI ZAHURI', 'A21A2898');

-- --------------------------------------------------------

--
-- Table structure for table `cert_data_com`
--

CREATE TABLE `cert_data_com` (
  `id` int(11) NOT NULL,
  `name` varchar(27) DEFAULT NULL,
  `jawatan` varchar(38) DEFAULT NULL,
  `matric` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cert_data_com`
--

INSERT INTO `cert_data_com` (`id`, `name`, `jawatan`, `matric`) VALUES
(1, 'Siti Afiqah Binti Zainuddin', 'Webinar Coordinator', '00685A'),
(2, 'Noorul Azwin Binti Md Nasir', 'Head of Webinar Project', '00185A'),
(3, 'Amira Binti Jamil', 'Promotion and Advertising Committee', '01049A'),
(4, 'Zul Karami Bin Che Musa', 'IT and Technical Committee', '01619A'),
(5, 'Siti Fariha Binti Muhamad', 'Registration and Certificate Committee', '00694A'),
(6, 'Mohd Rushdan Bin Yasoa\'', 'Finance Committee', '01332A'),
(7, 'Tahirah Binti Abdullah', 'Invitation Committee', '00709A'),
(8, 'Nadzirah Binti Mohd Said', 'Publication Committee', '01721A');

-- --------------------------------------------------------

--
-- Table structure for table `cert_doc`
--

CREATE TABLE `cert_doc` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL,
  `participant_name` varchar(225) NOT NULL,
  `field1` varchar(225) DEFAULT NULL,
  `field2` varchar(225) DEFAULT NULL,
  `field3` varchar(225) DEFAULT NULL,
  `field4` varchar(225) DEFAULT NULL,
  `field5` varchar(225) DEFAULT NULL,
  `downloaded` int(11) DEFAULT 0,
  `data_check` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cert_doc`
--

INSERT INTO `cert_doc` (`id`, `identifier`, `type_id`, `participant_name`, `field1`, `field2`, `field3`, `field4`, `field5`, `downloaded`, `data_check`) VALUES
(6, 'A20D0211F', 1, 'NUR ATHIRAH BINTI MOHD ALUWI', '', '', '', '', '', 0, 1),
(7, 'A20B2349', 1, 'WAN NUR FATIN FITRIAH BINTI WAN IZANI', '', '', '', '', '', 0, 1),
(8, 'A21B3476', 1, 'UMMI QURRATUAINI BINTI MOHD RASID', '', '', '', '', '', 0, 1),
(9, 'A21B2437', 1, 'CHIA AI VEE', '', '', '', '', '', 0, 1),
(10, 'A21B3340', 1, 'NAJWA NAJIHAH BINTI ABDUL AMIT', '', '', '', '', '', 0, 1),
(11, 'A20B2346', 1, 'RAIDAH BINTI HASAN BASIR', '', '', '', '', '', 0, 1),
(12, '940719105656', 1, 'SITI HANIS BINTI ZAINUDDIN', '', '', '', '', '', 0, 1),
(13, 'A21A3263', 1, 'INKA RINJANI AMARTA BINTI JAMALUDIN', '', '', '', '', '', 0, 1),
(14, 'A21A2519', 1, 'JOANNA A/P MURUGASAN', '', '', '', '', '', 0, 1),
(15, 'A21A2556', 1, 'LOSHINNIY NAIR A/P S.BASKARAN', '', '', '', '', '', 0, 1),
(16, 'A21A3126', 1, 'SUBAASHINEE D/O KUPUSAMY', '', '', '', '', '', 0, 1),
(17, 'A21A3031', 1, 'PAVEETHRA A/P MURALI', '', '', '', '', '', 0, 1),
(18, 'A21A2492', 1, 'HASHRINI A/P PRATHY', '', '', '', '', '', 0, 1),
(19, 'A21A3106', 1, 'SITI NURAISAH BINTI SULKIFLY ', '', '', '', '', '', 0, 1),
(20, 'A21A2555', 1, 'LOH ZI LIANG', '', '', '', '', '', 0, 1),
(21, 'A21A2479', 1, 'FOO SIN YI', '', '', '', '', '', 0, 1),
(22, 'A21A2551', 1, 'LIM YUEN YING', '', '', '', '', '', 0, 1),
(23, 'A21A2717', 1, 'NOR ALIA ASYIKIN BINTI YUSOP', '', '', '', '', '', 0, 1),
(24, 'A21A2921', 1, 'NURFADHILAH AMIRAH BINTI MOHAMED KASBI', '', '', '', '', '', 0, 1),
(25, 'A21A3173', 1, 'VISSHA SHALINI', '', '', '', '', '', 0, 1),
(26, 'A21A2569', 1, 'MEERAA A/P MATHIALAGAN ', '', '', '', '', '', 0, 1),
(27, 'A21A3053', 1, 'ROGINESHA A/P RAMESH', '', '', '', '', '', 0, 1),
(28, 'A21A2480', 1, 'FOONG CENG YAN', '', '', '', '', '', 0, 1),
(29, 'A21A2933', 1, 'NURLAILI LIYANA BINTI JAPAR', '', '', '', '', '', 0, 1),
(30, 'A21A2753', 1, 'NUR ADRIANA BINTI MANSOR', '', '', '', '', '', 0, 1),
(31, 'A21A3272', 1, 'JOEY TAN JO YIE', '', '', '', '', '', 0, 1),
(32, 'A21A3342', 1, 'NG GEOK PENG', '', '', '', '', '', 0, 1),
(33, 'A21A3240', 1, 'DANICA LEE JIA YEE', '', '', '', '', '', 0, 1),
(34, 'A21A2436', 1, 'CHENG ZHI XUAN ', '', '', '', '', '', 0, 1),
(35, 'A20B2334', 1, 'DENESSHWARAN A/L DEVAN', '', '', '', '', '', 0, 1),
(36, 'A20B2338', 1, 'KIRTINI A/P DORAISAMY', '', '', '', '', '', 0, 1),
(37, 'A21A2425', 1, 'BOAZ MARK A/L PHILOMENATHAN ', '', '', '', '', '', 0, 1),
(38, 'A21B3456', 1, 'SITI NURNABILA BINTI MOHD SHAKIRAN', '', '', '', '', '', 0, 1),
(39, 'A21A3197', 1, 'YONG YUK TING', '', '', '', '', '', 0, 1),
(40, 'A21A2827', 1, 'Nur Faradiah binti Jamingon', '', '', '', '', '', 0, 1),
(41, 'A184801', 1, 'NAZRIN SHAH BIN KAMARUDIN', '', '', '', '', '', 0, 1),
(42, 'A21A2550', 1, 'LIM XUAN XUAN', '', '', '', '', '', 0, 1),
(43, 'A21b2987', 1, 'Nurul Hidayah Nasuha binti A Halim', '', '', '', '', '', 0, 1),
(44, 'A21A3083', 1, 'SITI AISYAH MAISARAH BINTI SHAKRONI ', '', '', '', '', '', 0, 1),
(45, 'A21A3006', 1, 'NURUL NADHIRAH BINTI HASHIM ', '', '', '', '', '', 0, 1),
(46, 'A21A3079', 1, 'SITI AISHAH BINTI KHAIRUDIN', '', '', '', '', '', 0, 1),
(47, 'A21A3279', 1, 'KRITHIGA A/P GUNASEGARAN', '', '', '', '', '', 0, 1),
(48, 'A21A2560', 1, 'LYVINIYA A/P THIYAGARASAN', '', '', '', '', '', 0, 1),
(49, 'A21A3153', 1, 'THAHNUHSHAH A/P ARUMUGAM', '', '', '', '', '', 0, 1),
(50, 'A21A2706', 1, 'AIN HUSNINA', '', '', '', '', '', 0, 1),
(51, 'A188016', 1, 'NG JIA MENG', '', '', '', '', '', 0, 1),
(52, 'A21A2446', 1, 'CHUNG ZI YING', '', '', '', '', '', 0, 1),
(53, 'A21A3136', 1, 'TAN HUI LIANG', '', '', '', '', '', 0, 1),
(54, 'A21A2752', 1, 'NUR ADLEEN BINTI AZREE', '', '', '', '', '', 0, 1),
(55, 'A21A3112', 1, 'SITI NURUL IZZATI BINTI RAZAK', '', '', '', '', '', 0, 1),
(56, 'A21A3393', 1, 'NURAINA NAJWA BINTI MOHAMAD YUSRI', '', '', '', '', '', 0, 1),
(57, 'A21A3191', 1, 'WINLY TEH KAH ERN', '', '', '', '', '', 0, 1),
(58, 'A21A2711', 1, 'NOORIN SYAMIRA BINTI AZMAN', '', '', '', '', '', 0, 1),
(59, 'A21A3084', 1, 'SITI HARNINI BINTI MOHD ASERI', '', '', '', '', '', 0, 1),
(60, 'A21A2476', 1, 'FAZLIN SHAKINA BINTI FAIZAN HELMY', '', '', '', '', '', 0, 1),
(61, 'A20B2344', 1, 'NURUL NAZIFA BINTI NUZUL ASMADI', '', '', '', '', '', 0, 1),
(62, 'A20B2343', 1, 'NURUL ATIQAH BINTI ABDULLAH', '', '', '', '', '', 0, 1),
(63, 'A21A3278', 1, 'KONG YI CHENG', '', '', '', '', '', 0, 1),
(64, 'A20B2345', 1, 'PHRIYAADHARSHINI A/P PANEERSELVAN', '', '', '', '', '', 0, 1),
(65, 'A21A2367', 1, 'AIDA NAZIRAH BINTI MOHD SOBRI', '', '', '', '', '', 0, 1),
(66, 'A21B2389', 1, 'AMIRA ZAFIRA BINTI MOHD ZAMRI ', '', '', '', '', '', 0, 1),
(67, 'A21A2803', 1, 'NUR ASYIKIN BINTI AZMAN', '', '', '', '', '', 0, 1),
(68, 'A21A2394', 1, 'AMNI ARIZZA BINTI MOHD IDRIS ', '', '', '', '', '', 0, 1),
(69, 'A21A2591', 1, 'MOHAMAD SHAFIQ HAFIZEE BIN MOHD AZALI', '', '', '', '', '', 0, 1),
(70, 'A21A2424', 1, 'AZZUARIA A/P BAKI', '', '', '', '', '', 0, 1),
(71, 'A21A2958', 1, 'NURUL AISHAH BINTI OTSMAN', '', '', '', '', '', 0, 1),
(72, 'A21B3428', 1, 'PANIMALAR D/O VISWANATHAN', '', '', '', '', '', 0, 1),
(73, 'A21A2680', 1, 'MUHAMMAD ZULFAHMIBIN HANAFI', '', '', '', '', '', 0, 1),
(74, 'A21A3177', 1, 'WAN AHMAD AIMAN NUR HAQEEM BIN WAN MUHAMMAD ', '', '', '', '', '', 0, 1),
(75, 'A20B2331', 1, 'POOJAA A/P SUBRAMANIAM', '', '', '', '', '', 0, 1),
(76, 'P21E001F', 1, 'ROSNAH BINTI ISMAIL', '', '', '', '', '', 0, 1),
(77, 'A188621', 1, 'NUR IFFAH IZZATI BINTI NORAMIZI', '', '', '', '', '', 0, 1),
(78, 'A21A3214', 1, 'AINA IRDINA BINTI SAZLI', '', '', '', '', '', 0, 1),
(79, 'A21A2426', 1, 'CARMEN LEE JIA WEN', '', '', '', '', '', 0, 1),
(80, 'A20B2350', 1, 'NUR SYAFIRA NAJWA BINTI BEDOLAH', '', '', '', '', '', 0, 1),
(81, 'A20B2351', 1, 'ROSE HASLINDA BINTI ROSLI', '', '', '', '', '', 0, 1),
(82, 'A21A3389', 1, 'NUR SYAFIQAH BINTI SAMSUDIN', '', '', '', '', '', 0, 1),
(83, 'A21A3377', 1, 'NUR HIDAYAH BINTI AMRAN', '', '', '', '', '', 0, 1),
(84, '01807A', 1, 'RUZANIFAH BINTI KOSNIN', '', '', '', '', '', 0, 1),
(85, 'A21A3432', 1, 'RASYIQAH RAIDAH BINTI RAMLI', '', '', '', '', '', 0, 1),
(86, 'A21A3287', 1, 'LOI TING YING', '', '', '', '', '', 0, 1),
(87, 'A21A2734', 1, 'NOR SYAFIKA MOHD KAMAL', '', '', '', '', '', 0, 1),
(88, 'P13E003P', 1, 'BILLY KANG', '', '', '', '', '', 0, 1),
(89, 'A186201', 1, 'LIM CHAO YONG', '', '', '', '', '', 0, 1),
(90, 'A21B3401', 1, 'NURLIYANA BINTI ROSLI', '', '', '', '', '', 0, 1),
(91, 'A21A3005', 1, 'NURUL NABILAH BINTI NOR HISHAM ', '', '', '', '', '', 0, 1),
(92, 'A21A3127', 1, 'SYAHIRAH BINTI AZMAN', '', '', '', '', '', 0, 1),
(93, 'A21A2532', 1, 'KOH KIE KING', '', '', '', '', '', 0, 1),
(94, 'A21A2840', 1, 'NUR FITRATUN NAIMAH BINTI JAMARUL HISHAM', '', '', '', '', '', 0, 1),
(95, 'A21A3090', 1, 'SITI NASUHA BINTI ALI', '', '', '', '', '', 0, 1),
(96, 'A21A2542', 1, 'LEE WAI FONG', '', '', '', '', '', 0, 1),
(97, 'A21A2469', 1, 'FATIN NORSYAKIRAH BINTI SHAHRON', '', '', '', '', '', 0, 1),
(98, 'A21B3484', 1, 'WAN NURUL AISYAH BINTI MOHD SHUIB', '', '', '', '', '', 0, 1),
(99, 'A21A3007', 1, 'NURUL NADIA BINTI AZMI ', '', '', '', '', '', 0, 1),
(100, 'A21A2691', 1, 'NG KOK YUNG', '', '', '', '', '', 0, 1),
(101, '2022758577', 1, 'MUHAMMAD FADHLIL WAFI BIN AHMAD ZAWAWI', '', '', '', '', '', 0, 1),
(102, 'A21A2549', 1, 'LIM WEI BOON', '', '', '', '', '', 0, 1),
(103, 'A20B2347', 1, 'UVEINTHIRAN A/L SINIVASAN ', '', '', '', '', '', 0, 1),
(104, 'A21A3142', 1, 'TAN ZHENG XIN', '', '', '', '', '', 0, 1),
(105, 'A20B2342', 1, 'NUR HANIM HUSNA BINTI NAZLI', '', '', '', '', '', 0, 1),
(106, 'A21A2399', 1, 'ANGEL SHIM YING YING', '', '', '', '', '', 0, 1),
(107, 'A21A3102', 1, 'SITI NUR FAKHIRA ALANI BINTI MOHD MUSTAFFA KAMAL', '', '', '', '', '', 0, 1),
(108, 'A20B2336', 1, 'IFFAH MUNIRAH BINTI RIHDWAN ', '', '', '', '', '', 0, 1),
(109, 'A21A3217', 1, 'ALI ALI MOHAMMED ALGHAIL ', '', '', '', '', '', 0, 1),
(110, 'A21A3451', 1, 'SITI NUR HANISAH BINTI AHMAD KAMIL', '', '', '', '', '', 0, 1),
(111, 'A21A2634', 1, 'MUHAMMAD AZRIN IQBAL BIN AHMAD TARMIZAN', '', '', '', '', '', 0, 1),
(112, 'A21A2712', 1, 'NOR AEMIERA ADRIANA BINTI NORAZMI ', '', '', '', '', '', 0, 1),
(113, '00660A', 1, 'SITI NURUL SHUHADA DERAMAN', '', '', '', '', '', 0, 1),
(114, 'A21A2482', 1, 'GAN CHOON HEE', '', '', '', '', '', 0, 1),
(115, '01914a', 1, 'MOHD HANIZUN HANAFI', '', '', '', '', '', 0, 1),
(116, 'A21A2464', 1, 'FARISYA NABILLA BINTI KASMAN', '', '', '', '', '', 0, 1),
(117, 'A21A2660', 1, 'MUHAMMAD IZZUDDIN BIN AZIZZI', '', '', '', '', '', 0, 1),
(118, 'A21A3449', 1, 'SITI NUR DAMIA HUDA BINTI HUSSIN', '', '', '', '', '', 0, 1),
(119, 'A17A0859', 1, 'NURULAIN WAJIHAH BINTI AHMAD', '', '', '', '', '', 0, 1),
(120, 'A21A2757', 1, 'NUR AIMI FARHANA BINTI CHE HUSIN ', '', '', '', '', '', 0, 1),
(121, 'A21A3072', 1, 'Sharmila A/P Sasi kumar', '', '', '', '', '', 0, 1),
(122, 'A21A3029', 1, 'Ong Lee Jing', '', '', '', '', '', 0, 1),
(123, 'A21A3057', 1, 'ROSMILAH BINTI HAMID ', '', '', '', '', '', 0, 1),
(124, 'A21A2521', 1, 'JUHAIRAH BINTI JUHAN', '', '', '', '', '', 0, 1),
(125, 'A21A2566', 1, 'MARIAMAH BINTI ASIS', '', '', '', '', '', 0, 1),
(126, 'A21A3192', 1, 'BAO YING WONG', '', '', '', '', '', 0, 1),
(127, 'A21A2679', 1, 'MUHAMMAD ZIKRY BIN ZAKARIA', '', '', '', '', '', 0, 1),
(128, 'A21A2818', 1, 'NUR DAMIA KHAIRIAH BINTI AZREE', '', '', '', '', '', 0, 1),
(129, 'A21B3473', 1, 'THARISANA D/O KARUNAGARAN ', '', '', '', '', '', 0, 1),
(130, 'A21A2789', 1, 'NUR AMIZAH AQILAH BINTI YA\'ACOB ', '', '', '', '', '', 0, 1),
(131, 'A21A3444', 1, 'SITI FARAHADILAH BINTI ZAINAL', '', '', '', '', '', 0, 1),
(132, 'A21A3277', 1, 'KHAMIINESVARY A/P BALU', '', '', '', '', '', 0, 1),
(133, 'A21A2494', 1, 'HAZIQ ZULHAIRI BIN NORHISHAM', '', '', '', '', '', 0, 1),
(134, 'A21A2518', 1, 'JAYAVARMAN A/L ARUTCHELVAN', '', '', '', '', '', 0, 1),
(135, 'A21A3058', 1, 'RUBINI D/O THAMOTHARAN', '', '', '', '', '', 0, 1),
(136, 'A21A3033', 1, 'PHANYSA A/P AFFINAN', '', '', '', '', '', 0, 1),
(137, 'A21A2530', 1, 'Kishan A/L Ettisamy', '', '', '', '', '', 0, 1),
(138, 'A21A2797', 1, 'NUR ANISYA BINTI AZIZ', '', '', '', '', '', 0, 1),
(139, 'A21A3232', 1, 'AZIIYAH ROOBIYAH BINTI MD.NOOR', '', '', '', '', '', 0, 1),
(140, 'A21A3439', 1, 'SHANTHINI A/P RAMESH ', '', '', '', '', '', 0, 1),
(141, 'A21A2398', 1, 'ANG DING HANG', '', '', '', '', '', 0, 1),
(142, 'A21A2796', 1, 'NUR ANIS SOFIA BINTI HAYUZA ', '', '', '', '', '', 0, 1),
(143, 'A21A2486', 1, 'GOH QIAN WEN', '', '', '', '', '', 0, 1),
(144, 'A21A2624', 1, 'MUHAMMAD AMIR SYAZWAN BIN ROSLI ', '', '', '', '', '', 0, 1),
(145, 'A21A2676', 1, 'MUHAMMAD TAUFIKHIDAYAT PULUNGAN BIN TAJUDDIN ', '', '', '', '', '', 0, 1),
(146, 'A21A2811', 1, 'NUR ATIKAH BINTI AHMAD TAMIZI', '', '', '', '', '', 0, 1),
(147, 'A20A1457', 1, 'MOHAMAD IKMAL BIN ISHAMUDIN', '', '', '', '', '', 0, 1),
(148, 'A21A2596', 1, 'MOHD RAZIQ SYAHMI BIN SUKRI', '', '', '', '', '', 0, 1),
(149, 'A21A2451', 1, 'DICKSON KOK HAO SON', '', '', '', '', '', 0, 1),
(150, 'A21A3230', 1, 'AUNI SYAFIQAH BINTI ZULKEFLI', '', '', '', '', '', 0, 1),
(151, 'A21A2614', 1, 'MUHAMMAD AIDIL SHAZWAL BIN ABDUL HADI', '', '', '', '', '', 0, 1),
(152, 'A21B3438', 1, 'SHAFIQAH ADRIANA BINTI KHAIRULNIZAD', '', '', '', '', '', 0, 1),
(153, 'A21B3413', 1, 'NURUL ATHIRAH BINTI ABDUL RAZAK ', '', '', '', '', '', 0, 1),
(154, 'A21B3391', 1, 'NUR SYAMIRA ALIA BINTI HUSSIN ', '', '', '', '', '', 0, 1),
(155, 'A21A2490', 1, 'HANOOSURRIYAH A/P SAGER', '', '', '', '', '', 0, 1),
(156, 'A21A2388', 1, 'AMIR FARIS BIN ISHAK', '', '', '', '', '', 0, 1),
(157, 'A21A2949', 1, 'NURUL AIN BINTI NASRI', '', '', '', '', '', 0, 1),
(158, 'A21A2925', 1, 'NURFARISYA HANI BINTI AZHAR', '', '', '', '', '', 0, 1),
(159, 'A21A2577', 1, 'MOHAMAD AIMAN BIN CHE ROSE', '', '', '', '', '', 0, 1),
(160, 'A21A3457', 1, 'SITI SARAH WAHIDA BINTI LATIF', '', '', '', '', '', 0, 1),
(161, 'A21a3014', 1, 'NURUL RABIATULADAWIAH BINTI ZULLIHIP ', '', '', '', '', '', 0, 1),
(162, 'A21A3415', 1, 'NURUL HAZIQAH BINTI ELIAS', '', '', '', '', '', 0, 1),
(163, 'A21A2920', 1, 'NUREZADATUL NAZLIENSYAFIRA BINTI RUSTAM', '', '', '', '', '', 0, 1),
(164, 'A20B2348', 1, 'VANIISHAA A/P NESA RAJA', '', '', '', '', '', 0, 1),
(165, 'A21A3149', 1, 'TENGKU NOR AISYAH BINTI TENGKU ABAS', '', '', '', '', '', 0, 1),
(166, 'A21A3346', 1, 'NIK HALISHA BINTI ROSLI', '', '', '', '', '', 0, 1),
(167, 'A21A3366', 1, 'NUR AZLINA BINTI ABDUL HAZIZ', '', '', '', '', '', 0, 1),
(168, 'A21A2578', 1, 'MOHAMAD AKHMAL NIZARIFF BIN ROSLI', '', '', '', '', '', 0, 1),
(169, 'A21B3352', 1, 'NOR LIYANA ATHIRAH BT MD YUSOF', '', '', '', '', '', 0, 1),
(170, 'A21A3359', 1, 'NUR AINA HUSNA BINTI MOHD JAMIL ', '', '', '', '', '', 0, 1),
(171, 'A21A2899', 1, 'NUR SYAMIMI NADHIRAH BINTI RUSLI', '', '', '', '', '', 0, 1),
(172, 'A21A2438', 1, 'CHIN KAH KEAN', '', '', '', '', '', 0, 1),
(173, 'A21A2429', 1, 'CHAU ZHAN TENG', '', '', '', '', '', 0, 1),
(174, 'A21A2687', 1, 'NATASHA ARINA BINTI MOHD SAIFFUL', '', '', '', '', '', 0, 1),
(175, 'A21A2775', 1, 'NUR ALIAH ADILAH BT JAMALUDIN ', '', '', '', '', '', 0, 1),
(176, 'A21A3219', 1, 'ALYIA NAZHIFA BINTI ZAMRI', '', '', '', '', '', 0, 1),
(177, 'A21A3305', 1, 'MUHAMAD HARIZ BIN YAHYA ', '', '', '', '', '', 0, 1),
(178, 'A21A2402', 1, 'ANIS MUNIRAH BT MD TERMIZI', '', '', '', '', '', 0, 1),
(179, 'A21B3143', 1, 'TAUFIQ HAMDI BIN MOHAMMAD AZMI', '', '', '', '', '', 0, 1),
(180, 'A20B2340', 1, 'MOHD AIDIL AKMAL BIN ARBAIN', '', '', '', '', '', 0, 1),
(181, 'A21A3159', 1, 'TIN LI WEN', '', '', '', '', '', 0, 1),
(182, 'A21A3446', 1, 'SITI HAJAR BINTI MOHD SAAD ', '', '', '', '', '', 0, 1),
(183, 'A21A3027', 1, 'NURZAINE BINTI DENNY TSEN', '', '', '', '', '', 0, 1),
(184, 'A21A2447', 1, 'DAKSHAYANI A/P SHIVARAJ ', '', '', '', '', '', 0, 1),
(185, 'A21A3465', 1, 'SUJITAA A/P SELVAM', '', '', '', '', '', 0, 1),
(186, 'A21A2819', 1, 'NUR DINI BINTI KAMARULZAMAN ', '', '', '', '', '', 0, 1),
(187, 'A21A2864', 1, 'NUR KHADIJAH BADIHAH BINTI ABU BAKAR', '', '', '', '', '', 0, 1),
(188, 'A21A2953', 1, 'NURUL AIN SYAZWANIEY BINTI ZAMRI', '', '', '', '', '', 0, 1),
(189, 'a21a2746', 1, 'NORFARISHA ATHIRA BINTI ROSLI', '', '', '', '', '', 0, 1),
(190, 'A21a2968', 1, 'NURUL ATIQAH BINTI \'ADENAN ', '', '', '', '', '', 0, 1),
(191, 'A21A3117', 1, 'SITI WAN AISHAH BINTI WAN MOHD SARIFIZA', '', '', '', '', '', 0, 1),
(192, 'A20B2333', 1, 'ALIAH AZZAHRAH BINTI SHAHIDANI', '', '', '', '', '', 0, 1),
(193, 'A21A2868', 1, 'NUR LIYANA BT MOHD RODZI', '', '', '', '', '', 0, 1),
(194, 'A21A2561', 1, 'MADIHAH BINTI HARUN', '', '', '', '', '', 0, 1),
(195, 'A21A2541', 1, 'LAW CHEE HONG', '', '', '', '', '', 0, 1),
(196, 'A21A2898', 1, 'NUR SYAKIRAH NAJWA BINTI ZAHURI', '', '', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cert_event`
--

CREATE TABLE `cert_event` (
  `id` int(11) NOT NULL,
  `event_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cert_event`
--

INSERT INTO `cert_event` (`id`, `event_name`) VALUES
(1, 'WEBINAR THE 2ND ACCOUNTING WEBINAR SERIES (AWS) 2022 : Reflecting on Accounting\'s Philosophical and Historical Foundations');

-- --------------------------------------------------------

--
-- Table structure for table `cert_event_type`
--

CREATE TABLE `cert_event_type` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `name_mt` double DEFAULT 10,
  `name_size` double DEFAULT 10,
  `field1_mt` double DEFAULT NULL,
  `field1_size` double DEFAULT NULL,
  `field2_mt` double DEFAULT NULL,
  `field2_size` double DEFAULT NULL,
  `field3_mt` double DEFAULT NULL,
  `field3_size` double DEFAULT NULL,
  `field4_mt` double DEFAULT NULL,
  `field4_size` double DEFAULT NULL,
  `field5_mt` double DEFAULT NULL,
  `field5_size` double DEFAULT NULL,
  `margin_right` double DEFAULT NULL,
  `margin_left` double DEFAULT NULL,
  `set_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=preset,2=custom_html',
  `custom_html` text DEFAULT NULL,
  `template_file` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `published` tinyint(1) DEFAULT 0,
  `is_portrait` tinyint(1) DEFAULT 1,
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cert_event_type`
--

INSERT INTO `cert_event_type` (`id`, `event_id`, `type_name`, `name_mt`, `name_size`, `field1_mt`, `field1_size`, `field2_mt`, `field2_size`, `field3_mt`, `field3_size`, `field4_mt`, `field4_size`, `field5_mt`, `field5_size`, `margin_right`, `margin_left`, `set_type`, `custom_html`, `template_file`, `updated_at`, `published`, `is_portrait`, `published_at`) VALUES
(1, 1, 'Sijil Penyertaan', 10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', 'ecert/1/template_16529436266285eb0a14c644.29305411.png', '2022-05-19 15:00:26', 1, 0, '2022-05-19 15:02:30'),
(2, 1, 'Sijil Jawatankuasa', 10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', NULL, NULL, 0, 1, NULL),
(3, 1, 'Sijil Penghargaan (moderator)', 10, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', NULL, NULL, 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cert_participant`
--

CREATE TABLE `cert_participant` (
  `id` int(11) NOT NULL,
  `identifier` varchar(225) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cert_type`
--

CREATE TABLE `cert_type` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cert_type`
--

INSERT INTO `cert_type` (`id`, `type_name`) VALUES
(1, 'Sijil Penyertaan'),
(2, 'Sijil Penghargaan'),
(3, 'Sijil Penghargaan (Penceramah)'),
(4, 'Sijil Penghargaan (Moderator)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cert_data`
--
ALTER TABLE `cert_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cert_data_com`
--
ALTER TABLE `cert_data_com`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cert_doc`
--
ALTER TABLE `cert_doc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `cert_event`
--
ALTER TABLE `cert_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cert_event_type`
--
ALTER TABLE `cert_event_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `cert_participant`
--
ALTER TABLE `cert_participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `cert_type`
--
ALTER TABLE `cert_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cert_data`
--
ALTER TABLE `cert_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `cert_data_com`
--
ALTER TABLE `cert_data_com`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cert_doc`
--
ALTER TABLE `cert_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `cert_event`
--
ALTER TABLE `cert_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cert_event_type`
--
ALTER TABLE `cert_event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cert_participant`
--
ALTER TABLE `cert_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cert_type`
--
ALTER TABLE `cert_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cert_doc`
--
ALTER TABLE `cert_doc`
  ADD CONSTRAINT `cert_doc_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `cert_type` (`id`);

--
-- Constraints for table `cert_event_type`
--
ALTER TABLE `cert_event_type`
  ADD CONSTRAINT `cert_event_type_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `cert_event` (`id`);

--
-- Constraints for table `cert_participant`
--
ALTER TABLE `cert_participant`
  ADD CONSTRAINT `cert_participant_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `cert_event` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;