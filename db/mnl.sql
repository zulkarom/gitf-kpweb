
CREATE TABLE `mnl_item` (
  `id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `item_text` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0 = normal, 1 = steps, 3 = bullet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_item`
--

INSERT INTO `mnl_item` (`id`, `title_id`, `item_text`, `type`) VALUES
(1, 1, 'Follow the steps below:', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mnl_module`
--

CREATE TABLE `mnl_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `module_route` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_module`
--

INSERT INTO `mnl_module` (`id`, `module_name`, `module_route`, `is_published`) VALUES
(1, 'Course Management', NULL, 1),
(2, 'Course File', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mnl_section`
--

CREATE TABLE `mnl_section` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_section`
--

INSERT INTO `mnl_section` (`id`, `module_id`, `section_name`, `is_published`) VALUES
(1, 1, 'User Manual', 1),
(2, 1, 'FAQ', 0),
(3, 2, 'General', 1),
(4, 2, 'As Coordinator', 1),
(5, 2, 'As Lecturer', 1),
(6, 2, 'As Tutor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mnl_step`
--

CREATE TABLE `mnl_step` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `step_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_step`
--

INSERT INTO `mnl_step` (`id`, `item_id`, `step_text`) VALUES
(1, 1, '<p>Login to <a href=\"https://fkp-portal.umk.edu.my\" target=\"_blank\" rel=\"noopener\">https://fkp-portal.umk.edu.my</a></p>'),
(2, 1, '<p>Click Course File</p>\r\n<p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"index.php?r=manual%2Fdefault%2Fshow-image&amp;file=1646935842622a3f22d7e167.87101823.jpg\" alt=\"\" width=\"529\" height=\"529\" /></p>\r\n<p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `mnl_title`
--

CREATE TABLE `mnl_title` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `title_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mnl_title`
--

INSERT INTO `mnl_title` (`id`, `section_id`, `title_text`) VALUES
(1, 3, 'Navigate to main page of Course File in FKP Portal.'),
(2, 3, 'Uploding Student Evaluation'),
(3, 3, 'Uploading Timetable');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mnl_item`
--
ALTER TABLE `mnl_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_module`
--
ALTER TABLE `mnl_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_section`
--
ALTER TABLE `mnl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_step`
--
ALTER TABLE `mnl_step`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnl_title`
--
ALTER TABLE `mnl_title`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mnl_item`
--
ALTER TABLE `mnl_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mnl_module`
--
ALTER TABLE `mnl_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mnl_section`
--
ALTER TABLE `mnl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mnl_step`
--
ALTER TABLE `mnl_step`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mnl_title`
--
ALTER TABLE `mnl_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
