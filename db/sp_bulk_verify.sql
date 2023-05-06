
CREATE TABLE `sp_bulk_verify` (
  `id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `fk2_file` text DEFAULT NULL,
  `fk2_date` date DEFAULT NULL,
  `fk2_name` varchar(200) DEFAULT NULL,
  `fk3_file` text DEFAULT NULL,
  `fk3_date` date DEFAULT NULL,
  `fk3_name` varchar(200) DEFAULT NULL,
  `table4_file` text DEFAULT NULL,
  `table4_date` date DEFAULT NULL,
  `table4_name` varchar(200) DEFAULT NULL,
  `fk2_position` text DEFAULT NULL,
  `fk3_position` text DEFAULT NULL,
  `table4_position` text DEFAULT NULL,
  `verified_size` int(11) NOT NULL DEFAULT 0,
  `verified_adj_y` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sp_bulk_verify`
--

INSERT INTO `sp_bulk_verify` (`id`, `semester_id`, `is_enabled`, `fk2_file`, `fk2_date`, `fk2_name`, `fk3_file`, `fk3_date`, `fk3_name`, `table4_file`, `table4_date`, `table4_name`, `fk2_position`, `fk3_position`, `table4_position`, `verified_size`, `verified_adj_y`) VALUES
(1, 202120221, 1, 'signiture/nizam.png', '2021-10-01', 'Dr. Mohd Shahril Nizam Bin Md Radzi', 'signiture/nizam.png', '2022-03-06', 'Dr. Mohd Shahril Nizam Bin Md Radzi', 'signiture/nizam.png', '2021-10-01', 'Dr. Mohd Shahril Nizam Bin Md Radzi', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 0, 0),
(2, 202120222, 1, 'signiture/nizam.png', '2022-03-01', 'Dr. Mohd Shahril Nizam Bin Md Radzi', 'signiture/farha.png', '2022-09-06', 'Dr. Wan Farha Binti Wan Zulkiffli', 'signiture/nizam.png', '2022-03-01', 'Dr. Mohd Shahril Nizam Bin Md Radzi', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 0, 0),
(3, 202220231, 1, 'signiture/farha.png', '2022-10-01', 'Dr. Wan Farha Binti Wan Zulkiffli', 'signiture/farha.png', '2023-02-27', 'Dr. Wan Farha Binti Wan Zulkiffli', 'signiture/farha.png', '2022-10-01', 'Dr. Wan Farha Binti Wan Zulkiffli', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 0, 0),
(4, 202220232, 1, 'signiture/farha.png', '2023-03-10', 'Dr. Wan Farha Binti Wan Zulkiffli', NULL, NULL, NULL, 'signiture/farha.png', '2022-03-10', 'Dr. Wan Farha Binti Wan Zulkiffli', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 'Timbalan Dekan\r\n(Akademik & Pembangunan Pelajar)', 0, 0);

ALTER TABLE `sp_bulk_verify`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sp_bulk_verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
