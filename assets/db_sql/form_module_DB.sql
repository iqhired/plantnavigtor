--
-- Table structure for table `form_item`
--

CREATE TABLE `form_item` (
  `form_item_id` int(10) NOT NULL,
  `form_create_id` varchar(255) DEFAULT NULL,
  `item_desc` varchar(255) DEFAULT NULL,
  `item_val` varchar(255) DEFAULT NULL,
  `numeric_normal` varchar(255) DEFAULT NULL,
  `numeric_lower_tol` varchar(255) DEFAULT NULL,
  `numeric_upper_tol` varchar(255) DEFAULT NULL,
  `binary_default` varchar(255) DEFAULT NULL,
  `binary_normal` varchar(255) DEFAULT NULL,
  `binary_yes_alias` varchar(255) DEFAULT NULL,
  `binary_no_alias` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_item`
--
ALTER TABLE `form_item`
  ADD PRIMARY KEY (`form_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_item`
--
ALTER TABLE `form_item`
  MODIFY `form_item_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `form_settings`
--

CREATE TABLE `form_settings` (
  `form_settings_id` int(10) NOT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `form_schema` varchar(255) DEFAULT NULL,
  `schema_values` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `part_family` varchar(255) DEFAULT NULL,
  `part_number` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `need_approval` varchar(255) DEFAULT NULL,
  `out_of_tolerance_mail_list` varchar(255) DEFAULT NULL,
  `out_of_control_mail_list` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `approval_by` varchar(255) DEFAULT NULL,
  `valid_from` varchar(255) DEFAULT NULL,
  `valid_to` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_settings`
--
ALTER TABLE `form_settings`
  ADD PRIMARY KEY (`form_settings_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_settings`
--
ALTER TABLE `form_settings`
  MODIFY `form_settings_id` int(10) NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `form_create`
--

CREATE TABLE `form_create` (
  `form_create_id` int(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `form_type` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `part_family` varchar(255) DEFAULT NULL,
  `part_number` varchar(255) DEFAULT NULL,
  `po_number` varchar(255) DEFAULT NULL,
  `da_number` varchar(255) DEFAULT NULL,
  `out_of_tolerance_mail_list` varchar(255) DEFAULT NULL,
  `out_of_control_list` varchar(255) DEFAULT NULL,
  `notification_list` varchar(255) DEFAULT NULL,
  `form_create_notes` varchar(255) DEFAULT NULL,
  `need_approval` varchar(255) DEFAULT NULL,
  `approval_by` varchar(255) DEFAULT NULL,
  `valid_from` varchar(255) DEFAULT NULL,
  `valid_till` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_create`
--
ALTER TABLE `form_create`
  ADD PRIMARY KEY (`form_create_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_create`
--
ALTER TABLE `form_create`
  MODIFY `form_create_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `form_user_data`
--

CREATE TABLE `form_user_data` (
  `form_user_data_id` int(10) NOT NULL,
  `form_name` varchar(255) DEFAULT NULL,
  `form_type` varchar(255) DEFAULT NULL,
  `station` varchar(255) DEFAULT NULL,
  `part_family` varchar(255) DEFAULT NULL,
  `part_number` varchar(255) DEFAULT NULL,
  `form_user_data_item` longtext DEFAULT NULL,
  `approval_dept` varchar(255) DEFAULT NULL,
  `approval_initials` varchar(255) DEFAULT NULL,
  `passcode` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_user_data`
--
ALTER TABLE `form_user_data`
  ADD PRIMARY KEY (`form_user_data_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_user_data`
--
ALTER TABLE `form_user_data`
  MODIFY `form_user_data_id` int(10) NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `form_images`
--

CREATE TABLE `form_images` (
  `form_images_id` int(10) NOT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `form_create_id` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_images`
--
ALTER TABLE `form_images`
  ADD PRIMARY KEY (`form_images_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_images`
--
ALTER TABLE `form_images`
  MODIFY `form_images_id` int(10) NOT NULL AUTO_INCREMENT;