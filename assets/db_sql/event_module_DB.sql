--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `event_type_id` int(10) NOT NULL,
  `event_type_name` varchar(255) DEFAULT NULL,
  `color_code` varchar(255) NOT NULL DEFAULT '#218838',
  `so` int(10) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`event_type_id`, `event_type_name`, `color_code`, `so`, `created_at`, `updated_at`) VALUES
(1, 'Set Up', '#1c59ca', 1, '2021-07-23 06:41:13', '2021-07-26 02:08:29'),
(2, 'Start Of Production', '#218838', 2, '2021-07-20 22:46:10', '2021-07-20 22:46:10'),
(3, 'First Article Approved', '#218838', 3, '2021-07-20 22:46:26', '2021-07-26 03:38:33'),
(4, 'Line Down', '#bac516', 4, '2021-07-20 22:46:39', '2021-07-26 03:38:21'),
(5, 'Line Up', '#218838', 5, '2021-07-20 22:46:43', '2021-07-26 03:38:40'),
(7, 'End Of Production', '#121212', 7, '2021-07-20 23:05:25', '2021-07-26 03:38:46'),
(6, 'Run Up', '#0a5309', 6, '2021-07-26 03:39:13', '2021-07-26 03:39:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`event_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `event_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Table structure for table `sg_station_event`
--

CREATE TABLE `sg_station_event` (
  `station_event_id` int(10) NOT NULL,
  `line_id` int(10) NOT NULL,
  `part_family_id` int(10) NOT NULL,
  `part_number_id` int(10) NOT NULL,
  `event_type_id` int(10) NOT NULL,
  `event_status` varchar(255) NOT NULL DEFAULT '1',
  `created_on` varchar(255) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `modified_on` varchar(255) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sg_station_event`
--
ALTER TABLE `sg_station_event`
  ADD PRIMARY KEY (`station_event_id`),
  ADD KEY `station_event_id` (`station_event_id`),
  ADD KEY `sg_station_event_ibfk_1` (`part_family_id`),
  ADD KEY `sg_station_event_ibfk_2` (`line_id`),
  ADD KEY `sg_station_event_ibfk_3` (`part_number_id`),
  ADD KEY `sg_station_event_ibfk_4` (`event_type_id`),
  ADD KEY `sg_station_event_ibfk_5` (`created_by`),
  ADD KEY `sg_station_event_ibfk_6` (`modified_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sg_station_event`
--
ALTER TABLE `sg_station_event`
  MODIFY `station_event_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sg_station_event`
--
ALTER TABLE `sg_station_event`
  ADD CONSTRAINT `sg_station_event_ibfk_1` FOREIGN KEY (`part_family_id`) REFERENCES `pm_part_family` (`pm_part_family_id`),
  ADD CONSTRAINT `sg_station_event_ibfk_2` FOREIGN KEY (`line_id`) REFERENCES `cam_line` (`line_id`),
  ADD CONSTRAINT `sg_station_event_ibfk_3` FOREIGN KEY (`part_number_id`) REFERENCES `pm_part_number` (`pm_part_number_id`),
  ADD CONSTRAINT `sg_station_event_ibfk_4` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`event_type_id`),
  ADD CONSTRAINT `sg_station_event_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `cam_users` (`users_id`),
  ADD CONSTRAINT `sg_station_event_ibfk_6` FOREIGN KEY (`modified_by`) REFERENCES `cam_users` (`users_id`);

--
-- Table structure for table `sg_station_event_log`
--

CREATE TABLE `sg_station_event_log` (
  `station_event_log_id` int(10) NOT NULL,
  `station_event_id` int(10) NOT NULL,
  `event_type_id` int(10) NOT NULL,
  `event_status` varchar(255) NOT NULL DEFAULT '1',
  `created_on` varchar(255) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sg_station_event_log`
--
ALTER TABLE `sg_station_event_log`
  ADD PRIMARY KEY (`station_event_log_id`),
  ADD KEY `station_event_log_id` (`station_event_log_id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sg_station_event_log`
--
ALTER TABLE `sg_station_event_log`
  MODIFY `station_event_log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Table structure for table `events_category`
--

CREATE TABLE `events_category` (
  `events_cat_id` int(10) NOT NULL,
  `events_cat_name` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_on` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `events_category`
--
ALTER TABLE `events_category`
  ADD PRIMARY KEY (`events_cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events_category`
--
ALTER TABLE `events_category`
  MODIFY `events_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
