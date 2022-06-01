
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
(197, '00685A', 2, 'Siti Afiqah Binti Zainuddin', 'Webinar Coordinator', '', '', '', '', 0, 1),
(198, '00185A', 2, 'Noorul Azwin Binti Md Nasir', 'Head of Webinar Project', '', '', '', '', 0, 1),
(199, '01049A', 2, 'Amira Binti Jamil', 'Promotion and Advertising Committee', '', '', '', '', 0, 1),
(200, '01619A', 2, 'Zul Karami Bin Che Musa', 'IT and Technical Committee', '', '', '', '', 0, 1),
(201, '00694A', 2, 'Siti Fariha Binti Muhamad', 'Registration and Certificate Committee', '', '', '', '', 0, 1),
(202, '01332A', 2, 'Mohd Rushdan Bin Yasoa\'', 'Finance Committee', '', '', '', '', 0, 1),
(203, '00709A', 2, 'Tahirah Binti Abdullah', 'Invitation Committee', '', '', '', '', 0, 1),
(204, '01721A', 2, 'Nadzirah Binti Mohd Said', 'Publication Committee', '', '', '', '', 0, 1),
(404, '00685A', 1, 'Siti Afiqah Binti Zainuddin', '', '', '', '', '', 0, 1),
(405, '00185A', 1, 'Noorul Azwin Binti Md Nasir', '', '', '', '', '', 0, 1),
(406, '01049A', 1, 'Amira Binti Jamil', '', '', '', '', '', 0, 1),
(407, '01619A', 1, 'Zul Karami Bin Che Musa', '', '', '', '', '', 0, 1),
(408, '00694A', 1, 'Siti Fariha Binti Muhamad', '', '', '', '', '', 0, 1),
(409, '01332A', 1, 'Mohd Rushdan Bin Yasoa\'', '', '', '', '', '', 0, 1),
(410, '00709A', 1, 'Tahirah Binti Abdullah', '', '', '', '', '', 0, 1),
(411, '01721A', 1, 'Nadzirah Binti Mohd Said', '', '', '', '', '', 0, 1),
(412, 'A20D0211F', 1, 'NUR ATHIRAH BINTI MOHD ALUWI', '', '', '', '', '', 0, 1),
(413, 'A20B2349', 1, 'WAN NUR FATIN FITRIAH BINTI WAN IZANI', '', '', '', '', '', 0, 1),
(414, 'A21B3476', 1, 'UMMI QURRATUAINI BINTI MOHD RASID', '', '', '', '', '', 0, 1),
(415, 'A21B2437', 1, 'CHIA AI VEE', '', '', '', '', '', 0, 1),
(416, 'A21B3340', 1, 'NAJWA NAJIHAH BINTI ABDUL AMIT', '', '', '', '', '', 0, 1),
(417, 'A20B2346', 1, 'RAIDAH BINTI HASAN BASIR', '', '', '', '', '', 0, 1),
(418, '940719105656', 1, 'SITI HANIS BINTI ZAINUDDIN', '', '', '', '', '', 0, 1),
(419, 'A21A3263', 1, 'INKA RINJANI AMARTA BINTI JAMALUDIN', '', '', '', '', '', 0, 1),
(420, 'A21A2519', 1, 'JOANNA A/P MURUGASAN', '', '', '', '', '', 0, 1),
(421, 'A21A2556', 1, 'LOSHINNIY NAIR A/P S.BASKARAN', '', '', '', '', '', 0, 1),
(422, 'A21A3126', 1, 'SUBAASHINEE D/O KUPUSAMY', '', '', '', '', '', 0, 1),
(423, 'A21A3031', 1, 'PAVEETHRA A/P MURALI', '', '', '', '', '', 0, 1),
(424, 'A21A2492', 1, 'HASHRINI A/P PRATHY', '', '', '', '', '', 0, 1),
(425, 'A21A3106', 1, 'SITI NURAISAH BINTI SULKIFLY ', '', '', '', '', '', 0, 1),
(426, 'A21A2555', 1, 'LOH ZI LIANG', '', '', '', '', '', 0, 1),
(427, 'A21A2479', 1, 'FOO SIN YI', '', '', '', '', '', 0, 1),
(428, 'A21A2551', 1, 'LIM YUEN YING', '', '', '', '', '', 0, 1),
(429, 'A21A2717', 1, 'NOR ALIA ASYIKIN BINTI YUSOP', '', '', '', '', '', 0, 1),
(430, 'A21A2921', 1, 'NURFADHILAH AMIRAH BINTI MOHAMED KASBI', '', '', '', '', '', 0, 1),
(431, 'A21A3173', 1, 'VISSHA SHALINI', '', '', '', '', '', 0, 1),
(432, 'A21A2569', 1, 'MEERAA A/P MATHIALAGAN ', '', '', '', '', '', 0, 1),
(433, 'A21A3053', 1, 'ROGINESHA A/P RAMESH', '', '', '', '', '', 0, 1),
(434, 'A21A2480', 1, 'FOONG CENG YAN', '', '', '', '', '', 0, 1),
(435, 'A21A2933', 1, 'NURLAILI LIYANA BINTI JAPAR', '', '', '', '', '', 0, 1),
(436, 'A21A2753', 1, 'NUR ADRIANA BINTI MANSOR', '', '', '', '', '', 0, 1),
(437, 'A21A3272', 1, 'JOEY TAN JO YIE', '', '', '', '', '', 0, 1),
(438, 'A21A3342', 1, 'NG GEOK PENG', '', '', '', '', '', 0, 1),
(439, 'A21A3240', 1, 'DANICA LEE JIA YEE', '', '', '', '', '', 0, 1),
(440, 'A21A2436', 1, 'CHENG ZHI XUAN ', '', '', '', '', '', 0, 1),
(441, 'A20B2334', 1, 'DENESSHWARAN A/L DEVAN', '', '', '', '', '', 0, 1),
(442, 'A20B2338', 1, 'KIRTINI A/P DORAISAMY', '', '', '', '', '', 0, 1),
(443, 'A21A2425', 1, 'BOAZ MARK A/L PHILOMENATHAN ', '', '', '', '', '', 0, 1),
(444, 'A21B3456', 1, 'SITI NURNABILA BINTI MOHD SHAKIRAN', '', '', '', '', '', 0, 1),
(445, 'A21A3197', 1, 'YONG YUK TING', '', '', '', '', '', 0, 1),
(446, 'A21A2827', 1, 'Nur Faradiah binti Jamingon', '', '', '', '', '', 0, 1),
(447, 'A184801', 1, 'NAZRIN SHAH BIN KAMARUDIN', '', '', '', '', '', 0, 1),
(448, 'A21A2550', 1, 'LIM XUAN XUAN', '', '', '', '', '', 0, 1),
(449, 'A21b2987', 1, 'Nurul Hidayah Nasuha binti A Halim', '', '', '', '', '', 0, 1),
(450, 'A21A3083', 1, 'SITI AISYAH MAISARAH BINTI SHAKRONI ', '', '', '', '', '', 0, 1),
(451, 'A21A3006', 1, 'NURUL NADHIRAH BINTI HASHIM ', '', '', '', '', '', 0, 1),
(452, 'A21A3079', 1, 'SITI AISHAH BINTI KHAIRUDIN', '', '', '', '', '', 0, 1),
(453, 'A21A3279', 1, 'KRITHIGA A/P GUNASEGARAN', '', '', '', '', '', 0, 1),
(454, 'A21A2560', 1, 'LYVINIYA A/P THIYAGARASAN', '', '', '', '', '', 0, 1),
(455, 'A21A3153', 1, 'THAHNUHSHAH A/P ARUMUGAM', '', '', '', '', '', 0, 1),
(456, 'A21A2706', 1, 'AIN HUSNINA', '', '', '', '', '', 0, 1),
(457, 'A188016', 1, 'NG JIA MENG', '', '', '', '', '', 0, 1),
(458, 'A21A2446', 1, 'CHUNG ZI YING', '', '', '', '', '', 0, 1),
(459, 'A21A3136', 1, 'TAN HUI LIANG', '', '', '', '', '', 0, 1),
(460, 'A21A2752', 1, 'NUR ADLEEN BINTI AZREE', '', '', '', '', '', 0, 1),
(461, 'A21A3112', 1, 'SITI NURUL IZZATI BINTI RAZAK', '', '', '', '', '', 0, 1),
(462, 'A21A3393', 1, 'NURAINA NAJWA BINTI MOHAMAD YUSRI', '', '', '', '', '', 0, 1),
(463, 'A21A3191', 1, 'WINLY TEH KAH ERN', '', '', '', '', '', 0, 1),
(464, 'A21A2711', 1, 'NOORIN SYAMIRA BINTI AZMAN', '', '', '', '', '', 0, 1),
(465, 'A21A3084', 1, 'SITI HARNINI BINTI MOHD ASERI', '', '', '', '', '', 0, 1),
(466, 'A21A2476', 1, 'FAZLIN SHAKINA BINTI FAIZAN HELMY', '', '', '', '', '', 0, 1),
(467, 'A20B2344', 1, 'NURUL NAZIFA BINTI NUZUL ASMADI', '', '', '', '', '', 0, 1),
(468, 'A20B2343', 1, 'NURUL ATIQAH BINTI ABDULLAH', '', '', '', '', '', 0, 1),
(469, 'A21A3278', 1, 'KONG YI CHENG', '', '', '', '', '', 0, 1),
(470, 'A20B2345', 1, 'PHRIYAADHARSHINI A/P PANEERSELVAN', '', '', '', '', '', 0, 1),
(471, 'A21A2367', 1, 'AIDA NAZIRAH BINTI MOHD SOBRI', '', '', '', '', '', 0, 1),
(472, 'A21B2389', 1, 'AMIRA ZAFIRA BINTI MOHD ZAMRI ', '', '', '', '', '', 0, 1),
(473, 'A21A2803', 1, 'NUR ASYIKIN BINTI AZMAN', '', '', '', '', '', 0, 1),
(474, 'A21A2394', 1, 'AMNI ARIZZA BINTI MOHD IDRIS ', '', '', '', '', '', 0, 1),
(475, 'A21A2591', 1, 'MOHAMAD SHAFIQ HAFIZEE BIN MOHD AZALI', '', '', '', '', '', 0, 1),
(476, 'A21A2424', 1, 'AZZUARIA A/P BAKI', '', '', '', '', '', 0, 1),
(477, 'A21A2958', 1, 'NURUL AISHAH BINTI OTSMAN', '', '', '', '', '', 0, 1),
(478, 'A21B3428', 1, 'PANIMALAR D/O VISWANATHAN', '', '', '', '', '', 0, 1),
(479, 'A21A2680', 1, 'MUHAMMAD ZULFAHMIBIN HANAFI', '', '', '', '', '', 0, 1),
(480, 'A21A3177', 1, 'WAN AHMAD AIMAN NUR HAQEEM BIN WAN MUHAMMAD ', '', '', '', '', '', 0, 1),
(481, 'A20B2331', 1, 'POOJAA A/P SUBRAMANIAM', '', '', '', '', '', 0, 1),
(482, 'P21E001F', 1, 'ROSNAH BINTI ISMAIL', '', '', '', '', '', 0, 1),
(483, 'A188621', 1, 'NUR IFFAH IZZATI BINTI NORAMIZI', '', '', '', '', '', 0, 1),
(484, 'A21A3214', 1, 'AINA IRDINA BINTI SAZLI', '', '', '', '', '', 0, 1),
(485, 'A21A2426', 1, 'CARMEN LEE JIA WEN', '', '', '', '', '', 0, 1),
(486, 'A20B2350', 1, 'NUR SYAFIRA NAJWA BINTI BEDOLAH', '', '', '', '', '', 0, 1),
(487, 'A20B2351', 1, 'ROSE HASLINDA BINTI ROSLI', '', '', '', '', '', 0, 1),
(488, 'A21A3389', 1, 'NUR SYAFIQAH BINTI SAMSUDIN', '', '', '', '', '', 0, 1),
(489, 'A21A3377', 1, 'NUR HIDAYAH BINTI AMRAN', '', '', '', '', '', 0, 1),
(490, '01807A', 1, 'RUZANIFAH BINTI KOSNIN', '', '', '', '', '', 0, 1),
(491, 'A21A3432', 1, 'RASYIQAH RAIDAH BINTI RAMLI', '', '', '', '', '', 0, 1),
(492, 'A21A3287', 1, 'LOI TING YING', '', '', '', '', '', 0, 1),
(493, 'A21A2734', 1, 'NOR SYAFIKA MOHD KAMAL', '', '', '', '', '', 0, 1),
(494, 'P13E003P', 1, 'BILLY KANG', '', '', '', '', '', 0, 1),
(495, 'A186201', 1, 'LIM CHAO YONG', '', '', '', '', '', 0, 1),
(496, 'A21B3401', 1, 'NURLIYANA BINTI ROSLI', '', '', '', '', '', 0, 1),
(497, 'A21A3005', 1, 'NURUL NABILAH BINTI NOR HISHAM ', '', '', '', '', '', 0, 1),
(498, 'A21A3127', 1, 'SYAHIRAH BINTI AZMAN', '', '', '', '', '', 0, 1),
(499, 'A21A2532', 1, 'KOH KIE KING', '', '', '', '', '', 0, 1),
(500, 'A21A2840', 1, 'NUR FITRATUN NAIMAH BINTI JAMARUL HISHAM', '', '', '', '', '', 0, 1),
(501, 'A21A3090', 1, 'SITI NASUHA BINTI ALI', '', '', '', '', '', 0, 1),
(502, 'A21A2542', 1, 'LEE WAI FONG', '', '', '', '', '', 0, 1),
(503, 'A21A2469', 1, 'FATIN NORSYAKIRAH BINTI SHAHRON', '', '', '', '', '', 0, 1),
(504, 'A21B3484', 1, 'WAN NURUL AISYAH BINTI MOHD SHUIB', '', '', '', '', '', 0, 1),
(505, 'A21A3007', 1, 'NURUL NADIA BINTI AZMI ', '', '', '', '', '', 0, 1),
(506, 'A21A2691', 1, 'NG KOK YUNG', '', '', '', '', '', 0, 1),
(507, '2022758577', 1, 'MUHAMMAD FADHLIL WAFI BIN AHMAD ZAWAWI', '', '', '', '', '', 0, 1),
(508, 'A21A2549', 1, 'LIM WEI BOON', '', '', '', '', '', 0, 1),
(509, 'A20B2347', 1, 'UVEINTHIRAN A/L SINIVASAN ', '', '', '', '', '', 0, 1),
(510, 'A21A3142', 1, 'TAN ZHENG XIN', '', '', '', '', '', 0, 1),
(511, 'A20B2342', 1, 'NUR HANIM HUSNA BINTI NAZLI', '', '', '', '', '', 0, 1),
(512, 'A21A2399', 1, 'ANGEL SHIM YING YING', '', '', '', '', '', 0, 1),
(513, 'A21A3102', 1, 'SITI NUR FAKHIRA ALANI BINTI MOHD MUSTAFFA KAMAL', '', '', '', '', '', 0, 1),
(514, 'A20B2336', 1, 'IFFAH MUNIRAH BINTI RIHDWAN ', '', '', '', '', '', 0, 1),
(515, 'A21A3217', 1, 'ALI ALI MOHAMMED ALGHAIL ', '', '', '', '', '', 0, 1),
(516, 'A21A3451', 1, 'SITI NUR HANISAH BINTI AHMAD KAMIL', '', '', '', '', '', 0, 1),
(517, 'A21A2634', 1, 'MUHAMMAD AZRIN IQBAL BIN AHMAD TARMIZAN', '', '', '', '', '', 0, 1),
(518, 'A21A2712', 1, 'NOR AEMIERA ADRIANA BINTI NORAZMI ', '', '', '', '', '', 0, 1),
(519, '00660A', 1, 'SITI NURUL SHUHADA DERAMAN', '', '', '', '', '', 0, 1),
(520, 'A21A2482', 1, 'GAN CHOON HEE', '', '', '', '', '', 0, 1),
(521, '01914a', 1, 'MOHD HANIZUN HANAFI', '', '', '', '', '', 0, 1),
(522, 'A21A2464', 1, 'FARISYA NABILLA BINTI KASMAN', '', '', '', '', '', 0, 1),
(523, 'A21A2660', 1, 'MUHAMMAD IZZUDDIN BIN AZIZZI', '', '', '', '', '', 0, 1),
(524, 'A21A3449', 1, 'SITI NUR DAMIA HUDA BINTI HUSSIN', '', '', '', '', '', 0, 1),
(525, 'A17A0859', 1, 'NURULAIN WAJIHAH BINTI AHMAD', '', '', '', '', '', 0, 1),
(526, 'A21A2757', 1, 'NUR AIMI FARHANA BINTI CHE HUSIN ', '', '', '', '', '', 0, 1),
(527, 'A21A3072', 1, 'Sharmila A/P Sasi kumar', '', '', '', '', '', 0, 1),
(528, 'A21A3029', 1, 'Ong Lee Jing', '', '', '', '', '', 0, 1),
(529, 'A21A3057', 1, 'ROSMILAH BINTI HAMID ', '', '', '', '', '', 0, 1),
(530, 'A21A2521', 1, 'JUHAIRAH BINTI JUHAN', '', '', '', '', '', 0, 1),
(531, 'A21A2566', 1, 'MARIAMAH BINTI ASIS', '', '', '', '', '', 0, 1),
(532, 'A21A3192', 1, 'BAO YING WONG', '', '', '', '', '', 0, 1),
(533, 'A21A2679', 1, 'MUHAMMAD ZIKRY BIN ZAKARIA', '', '', '', '', '', 0, 1),
(534, 'A21A2818', 1, 'NUR DAMIA KHAIRIAH BINTI AZREE', '', '', '', '', '', 0, 1),
(535, 'A21B3473', 1, 'THARISANA D/O KARUNAGARAN ', '', '', '', '', '', 0, 1),
(536, 'A21A2789', 1, 'NUR AMIZAH AQILAH BINTI YA\'ACOB ', '', '', '', '', '', 0, 1),
(537, 'A21A3444', 1, 'SITI FARAHADILAH BINTI ZAINAL', '', '', '', '', '', 0, 1),
(538, 'A21A3277', 1, 'KHAMIINESVARY A/P BALU', '', '', '', '', '', 0, 1),
(539, 'A21A2494', 1, 'HAZIQ ZULHAIRI BIN NORHISHAM', '', '', '', '', '', 0, 1),
(540, 'A21A2518', 1, 'JAYAVARMAN A/L ARUTCHELVAN', '', '', '', '', '', 0, 1),
(541, 'A21A3058', 1, 'RUBINI D/O THAMOTHARAN', '', '', '', '', '', 0, 1),
(542, 'A21A3033', 1, 'PHANYSA A/P AFFINAN', '', '', '', '', '', 0, 1),
(543, 'A21A2530', 1, 'Kishan A/L Ettisamy', '', '', '', '', '', 0, 1),
(544, 'A21A2797', 1, 'NUR ANISYA BINTI AZIZ', '', '', '', '', '', 0, 1),
(545, 'A21A3232', 1, 'AZIIYAH ROOBIYAH BINTI MD.NOOR', '', '', '', '', '', 0, 1),
(546, 'A21A3439', 1, 'SHANTHINI A/P RAMESH ', '', '', '', '', '', 0, 1),
(547, 'A21A2398', 1, 'ANG DING HANG', '', '', '', '', '', 0, 1),
(548, 'A21A2796', 1, 'NUR ANIS SOFIA BINTI HAYUZA ', '', '', '', '', '', 0, 1),
(549, 'A21A2486', 1, 'GOH QIAN WEN', '', '', '', '', '', 0, 1),
(550, 'A21A2624', 1, 'MUHAMMAD AMIR SYAZWAN BIN ROSLI ', '', '', '', '', '', 0, 1),
(551, 'A21A2676', 1, 'MUHAMMAD TAUFIKHIDAYAT PULUNGAN BIN TAJUDDIN ', '', '', '', '', '', 0, 1),
(552, 'A21A2811', 1, 'NUR ATIKAH BINTI AHMAD TAMIZI', '', '', '', '', '', 0, 1),
(553, 'A20A1457', 1, 'MOHAMAD IKMAL BIN ISHAMUDIN', '', '', '', '', '', 0, 1),
(554, 'A21A2596', 1, 'MOHD RAZIQ SYAHMI BIN SUKRI', '', '', '', '', '', 0, 1),
(555, 'A21A2451', 1, 'DICKSON KOK HAO SON', '', '', '', '', '', 0, 1),
(556, 'A21A3230', 1, 'AUNI SYAFIQAH BINTI ZULKEFLI', '', '', '', '', '', 0, 1),
(557, 'A21A2614', 1, 'MUHAMMAD AIDIL SHAZWAL BIN ABDUL HADI', '', '', '', '', '', 0, 1),
(558, 'A21B3438', 1, 'SHAFIQAH ADRIANA BINTI KHAIRULNIZAD', '', '', '', '', '', 0, 1),
(559, 'A21B3413', 1, 'NURUL ATHIRAH BINTI ABDUL RAZAK ', '', '', '', '', '', 0, 1),
(560, 'A21B3391', 1, 'NUR SYAMIRA ALIA BINTI HUSSIN ', '', '', '', '', '', 0, 1),
(561, 'A21A2490', 1, 'HANOOSURRIYAH A/P SAGER', '', '', '', '', '', 0, 1),
(562, 'A21A2388', 1, 'AMIR FARIS BIN ISHAK', '', '', '', '', '', 0, 1),
(563, 'A21A2949', 1, 'NURUL AIN BINTI NASRI', '', '', '', '', '', 0, 1),
(564, 'A21A2925', 1, 'NURFARISYA HANI BINTI AZHAR', '', '', '', '', '', 0, 1),
(565, 'A21A2577', 1, 'MOHAMAD AIMAN BIN CHE ROSE', '', '', '', '', '', 0, 1),
(566, 'A21A3457', 1, 'SITI SARAH WAHIDA BINTI LATIF', '', '', '', '', '', 0, 1),
(567, 'A21a3014', 1, 'NURUL RABIATULADAWIAH BINTI ZULLIHIP ', '', '', '', '', '', 0, 1),
(568, 'A21A3415', 1, 'NURUL HAZIQAH BINTI ELIAS', '', '', '', '', '', 0, 1),
(569, 'A21A2920', 1, 'NUREZADATUL NAZLIENSYAFIRA BINTI RUSTAM', '', '', '', '', '', 0, 1),
(570, 'A20B2348', 1, 'VANIISHAA A/P NESA RAJA', '', '', '', '', '', 0, 1),
(571, 'A21A3149', 1, 'TENGKU NOR AISYAH BINTI TENGKU ABAS', '', '', '', '', '', 0, 1),
(572, 'A21A3346', 1, 'NIK HALISHA BINTI ROSLI', '', '', '', '', '', 0, 1),
(573, 'A21A3366', 1, 'NUR AZLINA BINTI ABDUL HAZIZ', '', '', '', '', '', 0, 1),
(574, 'A21A2578', 1, 'MOHAMAD AKHMAL NIZARIFF BIN ROSLI', '', '', '', '', '', 0, 1),
(575, 'A21B3352', 1, 'NOR LIYANA ATHIRAH BT MD YUSOF', '', '', '', '', '', 0, 1),
(576, 'A21A3359', 1, 'NUR AINA HUSNA BINTI MOHD JAMIL ', '', '', '', '', '', 0, 1),
(577, 'A21A2899', 1, 'NUR SYAMIMI NADHIRAH BINTI RUSLI', '', '', '', '', '', 0, 1),
(578, 'A21A2438', 1, 'CHIN KAH KEAN', '', '', '', '', '', 0, 1),
(579, 'A21A2429', 1, 'CHAU ZHAN TENG', '', '', '', '', '', 0, 1),
(580, 'A21A2687', 1, 'NATASHA ARINA BINTI MOHD SAIFFUL', '', '', '', '', '', 0, 1),
(581, 'A21A2775', 1, 'NUR ALIAH ADILAH BT JAMALUDIN ', '', '', '', '', '', 0, 1),
(582, 'A21A3219', 1, 'ALYIA NAZHIFA BINTI ZAMRI', '', '', '', '', '', 0, 1),
(583, 'A21A3305', 1, 'MUHAMAD HARIZ BIN YAHYA ', '', '', '', '', '', 0, 1),
(584, 'A21A2402', 1, 'ANIS MUNIRAH BT MD TERMIZI', '', '', '', '', '', 0, 1),
(585, 'A21B3143', 1, 'TAUFIQ HAMDI BIN MOHAMMAD AZMI', '', '', '', '', '', 0, 1),
(586, 'A20B2340', 1, 'MOHD AIDIL AKMAL BIN ARBAIN', '', '', '', '', '', 0, 1),
(587, 'A21A3159', 1, 'TIN LI WEN', '', '', '', '', '', 0, 1),
(588, 'A21A3446', 1, 'SITI HAJAR BINTI MOHD SAAD ', '', '', '', '', '', 0, 1),
(589, 'A21A3027', 1, 'NURZAINE BINTI DENNY TSEN', '', '', '', '', '', 0, 1),
(590, 'A21A2447', 1, 'DAKSHAYANI A/P SHIVARAJ ', '', '', '', '', '', 0, 1),
(591, 'A21A3465', 1, 'SUJITAA A/P SELVAM', '', '', '', '', '', 0, 1),
(592, 'A21A2819', 1, 'NUR DINI BINTI KAMARULZAMAN ', '', '', '', '', '', 0, 1),
(593, 'A21A2864', 1, 'NUR KHADIJAH BADIHAH BINTI ABU BAKAR', '', '', '', '', '', 0, 1),
(594, 'A21A2953', 1, 'NURUL AIN SYAZWANIEY BINTI ZAMRI', '', '', '', '', '', 0, 1),
(595, 'a21a2746', 1, 'NORFARISHA ATHIRA BINTI ROSLI', '', '', '', '', '', 0, 1),
(596, 'A21a2968', 1, 'NURUL ATIQAH BINTI \'ADENAN ', '', '', '', '', '', 0, 1),
(597, 'A21A3117', 1, 'SITI WAN AISHAH BINTI WAN MOHD SARIFIZA', '', '', '', '', '', 0, 1),
(598, 'A20B2333', 1, 'ALIAH AZZAHRAH BINTI SHAHIDANI', '', '', '', '', '', 0, 1),
(599, 'A21A2868', 1, 'NUR LIYANA BT MOHD RODZI', '', '', '', '', '', 0, 1),
(600, 'A21A2561', 1, 'MADIHAH BINTI HARUN', '', '', '', '', '', 0, 1),
(601, 'A21A2541', 1, 'LAW CHEE HONG', '', '', '', '', '', 0, 1),
(602, 'A21A2898', 1, 'NUR SYAKIRAH NAJWA BINTI ZAHURI', '', '', '', '', '', 0, 1),
(603, '00685A', 3, 'Siti Afiqah Binti Zainuddin', '', '', '', '', '', 0, 0),
(604, 'chandana', 4, 'PROF. CHANDANA ALAWATTAGE', '', '', '', '', '', 0, 0);

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
(1, 1, 'Certificate of Participation', 190, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 295, 1, '', 'ecert/1/template_1653183963628995db30cbb5.14206270.jpg', '2022-05-22 09:46:03', 1, 0, '2022-05-22 09:46:06'),
(2, 1, 'Certificate of Recognition', 175, 25, 70, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 295, 1, '', 'ecert/2/template_1653184435628997b36a1337.86060780.jpg', '2022-05-22 09:53:55', 1, 0, '2022-05-22 09:53:57'),
(3, 1, 'Certificate of Appreciation (moderator)', 190, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 295, 1, '', 'ecert/3/template_165318652862899fe00a6956.44784246.jpg', '2022-05-22 10:28:48', 1, 0, '2022-05-22 10:28:50'),
(4, 1, 'Certificate of Appreciation (speaker)', 190, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 295, 1, '', 'ecert/4/template_16531869456289a18149f6e7.15304154.jpg', '2022-05-22 10:35:45', 1, 0, '2022-05-22 10:35:48');

-- --------------------------------------------------------

--
-- Table structure for table `cert_participant`
--

CREATE TABLE `cert_participant` (
  `id` int(11) NOT NULL,
  `identifier` varchar(225) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cert_doc`
--
ALTER TABLE `cert_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=605;

--
-- AUTO_INCREMENT for table `cert_event`
--
ALTER TABLE `cert_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cert_event_type`
--
ALTER TABLE `cert_event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cert_participant`
--
ALTER TABLE `cert_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
