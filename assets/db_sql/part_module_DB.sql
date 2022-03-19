--
-- Table structure for table `pm_part_family`
--

CREATE TABLE `pm_part_family` (
  `pm_part_family_id` int(10) NOT NULL,
  `part_family_name` varchar(255) DEFAULT NULL,
  `station` int(10) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_part_family`
--

INSERT INTO `pm_part_family` (`pm_part_family_id`, `part_family_name`, `station`, `notes`, `created_by`) VALUES
(1, 'BMW EPS', 3, '', '1'),
(2, 'VW 411', 3, '', '1'),
(3, 'Tesla X', 4, '', '1'),
(4, 'BMW Endless', 4, '', '1'),
(5, 'MBUSI Endless', 4, '', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pm_part_family`
--
ALTER TABLE `pm_part_family`
  ADD PRIMARY KEY (`pm_part_family_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pm_part_family`
--
ALTER TABLE `pm_part_family`
  MODIFY `pm_part_family_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;


--
-- Table structure for table `pm_part_number`
--

CREATE TABLE `pm_part_number` (
  `pm_part_number_id` int(10) NOT NULL,
  `part_number` varchar(255) DEFAULT NULL,
  `part_name` varchar(255) DEFAULT NULL,
  `customer_part_number` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `part_family` int(10) DEFAULT NULL,
  `npr` varchar(255) DEFAULT NULL,
  `through_put` varchar(255) DEFAULT NULL,
  `budget_scrape_rate` varchar(255) DEFAULT NULL,
  `net_weight` varchar(255) DEFAULT NULL,
  `part_length` varchar(255) DEFAULT NULL,
  `length_range` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_part_number`
--

INSERT INTO `pm_part_number` (`pm_part_number_id`, `part_number`, `part_name`, `customer_part_number`, `station`, `part_family`, `npr`, `through_put`, `budget_scrape_rate`, `net_weight`, `part_length`, `length_range`, `notes`, `created_by`) VALUES
(1, '201166568A', 'BMW - G05 - Front Edge Door Guard Extrusion', '742867807', '3', 1, '344.496', 'TBD', '5', '1.026', '3657', '10', '', '1'),
(2, '201166568B', 'BMW - G05 - Front Edge Door Guard Extrusion', '742869607', '3', 1, '357.497', 'TBD', '5', '0.992', '3525', '10', '', '1'),
(4, '201166568D', 'BMW - G06 - Front Edge Door Guard Extrusion', '743114206', '3', 1, '355.029', 'TBD', '5', '1.026', '3548', '10', '', '1'),
(5, '201166568E', 'BMW - G06 - Front Edge Door Guard Extrusion', '743777907', '3', 1, '391.730', 'TBD', '5', '0.992', '3218', '10', '', '1'),
(6, '201166568C', 'BMW - G07 - Edge Protector Rear Extrusion', '743778807', '3', 1, '326.382', 'TBD', '5', '0.992', '3860', '10', '', '1'),
(7, '201100026', '911 VW 411 Interior Door Extrusion FD LH', '561867911.G', '3', 2, '324.324', 'TBD', '5', '1.220', '3395', '10', '', '1'),
(8, '201100030', '911 VW 411 Interior Door Extrusion FD LH', '561867912.G', '3', 2, '324.324', 'TBD', '5', '1.220', '3395', '10', '', '1'),
(9, '201100027', '911 VW 411 Interior Door Extrusion FD LH', '561867913.G', '3', 2, '344.828', 'TBD', '5', '1.150', '3190', '10', '', '1'),
(10, '201100031', 'BMW - G07 - Edge Protector Rear Extrusion', '561867914.G', '3', 2, '344.828', 'TBD', '5', '1.150', '3190', '10', '', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pm_part_number`
--
ALTER TABLE `pm_part_number`
  ADD PRIMARY KEY (`pm_part_number_id`),
  ADD KEY `pm_part_number_id` (`pm_part_number_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pm_part_number`
--
ALTER TABLE `pm_part_number`
  MODIFY `pm_part_number_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
