-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 10, 2021 at 06:55 AM
-- Server version: 5.7.32
-- PHP Version: 7.3.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sg_supplier`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_files`
--

CREATE TABLE `order_files` (
  `file_id` int(10) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_files`
--

INSERT INTO `order_files` (`file_id`, `order_id`, `file_type`, `file_name`, `created_at`) VALUES
(13, '1', 'invoice', '1__5459XXXXXXXXXX46_15-07-2021.PDF', ''),
(40, '1', 'attachment', '1__74817050_1627879905399.pdf', ''),
(41, '1', 'attachment', '1__74817050_1627879951573.pdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `sup_account`
--

CREATE TABLE `sup_account` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(20) DEFAULT NULL,
  `c_type` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `c_mobile` varchar(20) DEFAULT NULL,
  `c_address` varchar(225) DEFAULT NULL,
  `c_website` varchar(225) DEFAULT NULL,
  `c_status` int(1) NOT NULL DEFAULT '1',
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sup_account`
--

INSERT INTO `sup_account` (`c_id`, `c_name`, `c_type`, `logo`, `c_mobile`, `c_address`, `c_website`, `c_status`, `created_at`) VALUES
(1, 'Supp 1', '5', '', '', '', '', 1, '2021-08-04 18:55:48'),
(2, 'Supp 2', '5', '', '', '', '', 1, '2021-08-04 18:55:48'),
(3, 'Supp3', '5', NULL, '987654345', 'Sample', 'https://cdcw.com', 1, '2021-08-06 07:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `sup_account_type`
--

CREATE TABLE `sup_account_type` (
  `sup_account_type_id` int(10) NOT NULL,
  `sup_account_type_name` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup_account_type`
--

INSERT INTO `sup_account_type` (`sup_account_type_id`, `sup_account_type_name`, `created_at`) VALUES
(1, 'System Super Admin', '2021-08-04 13:30:20'),
(2, 'System Admin', '2021-08-04 13:30:56'),
(3, 'Customer', '2021-08-04 13:32:35'),
(4, 'Manufacturer', '2021-08-04 13:33:35'),
(5, 'Supplier', '2021-08-04 18:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `sup_account_users`
--

CREATE TABLE `sup_account_users` (
  `u_id` int(11) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `role` int(10) DEFAULT NULL,
  `u_email` varchar(30) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_firstname` varchar(30) NOT NULL,
  `u_lastname` varchar(30) NOT NULL,
  `u_mobile` int(30) NOT NULL,
  `u_address` text NOT NULL,
  `u_profile_pic` varchar(255) NOT NULL,
  `u_type` varchar(30) NOT NULL,
  `u_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sup_account_users`
--

INSERT INTO `sup_account_users` (`u_id`, `c_id`, `user_name`, `role`, `u_email`, `u_password`, `u_firstname`, `u_lastname`, `u_mobile`, `u_address`, `u_profile_pic`, `u_type`, `u_status`) VALUES
(1, NULL, 'Supp1', 3, 'supp@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Supplier', 'One', 234543524, '', '', 'user', '1'),
(2, NULL, 'Supp2', 3, 'supp2@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Supplier', 'Two', 23453465, '', '', 'user', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sup_order`
--

CREATE TABLE `sup_order` (
  `order_id` int(10) NOT NULL,
  `c_id` int(10) NOT NULL,
  `order_name` varchar(255) DEFAULT NULL,
  `order_desc` varchar(255) NOT NULL,
  `order_status_id` int(10) NOT NULL,
  `order_active` varchar(10) NOT NULL DEFAULT '1',
  `shipment_details` varchar(255) DEFAULT NULL,
  `created_on` varchar(255) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `modified_on` varchar(255) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup_order`
--

INSERT INTO `sup_order` (`order_id`, `c_id`, `order_name`, `order_desc`, `order_status_id`, `order_active`, `shipment_details`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
(1, 1, 'Sample Order', 'Sample Order 1', 2, '1', 'Sample Shipped', '2021-08-04 19:10:35', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sup_order_log`
--

CREATE TABLE `sup_order_log` (
  `sup_order_log_id` int(10) NOT NULL,
  `order_seq` int(11) DEFAULT NULL,
  `order_status_id` int(10) NOT NULL,
  `sup_order_status` varchar(255) NOT NULL DEFAULT '1',
  `created_on` varchar(255) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sup_order_status`
--

CREATE TABLE `sup_order_status` (
  `sup_order_status_id` int(10) NOT NULL,
  `sup_order_status` varchar(255) DEFAULT NULL,
  `sup_os_access` int(1) NOT NULL DEFAULT '0',
  `sup_sa_os_access` int(1) NOT NULL DEFAULT '0',
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup_order_status`
--

INSERT INTO `sup_order_status` (`sup_order_status_id`, `sup_order_status`, `sup_os_access`, `sup_sa_os_access`, `created_at`) VALUES
(1, 'Order Placed', 0, 1, '2021-08-04 13:41:47'),
(2, 'Order Acknowledged', 1, 0, '2021-08-04 13:41:47'),
(3, 'Awaiting Shipment', 1, 0, '2021-08-04 13:43:53'),
(4, 'Order Shipped', 1, 0, '2021-08-04 13:43:53'),
(5, 'Order Received', 0, 1, '2021-08-04 13:43:53'),
(6, 'Order Closed', 0, 1, '2021-08-04 13:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `sup_role`
--

CREATE TABLE `sup_role` (
  `role_id` int(10) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `side_menu` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup_role`
--

INSERT INTO `sup_role` (`role_id`, `role_name`, `type`, `side_menu`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super', '4,9,11,12,5,6,7,8,13,14,15,17,16,18,24,25,26,27,28,29,43,,19,31,32,33,20,34,35,21,22,36,37,40,23,38,39,42,44,45,46,47,48,49,50,51,52,', '2020-11-09 10:36:12', '2020-12-24 17:46:03'),
(2, 'Admin', 'admin', '4,9,11,12,5,6,7,8,13,14,15,17,16,18,24,25,26,27,28,29,43,,19,31,32,33,20,34,35,21,22,36,37,40,23,38,39,42,44,45,46,47,48,49,50,51,52,', '2020-11-09 10:36:54', '2021-07-23 08:05:25'),
(3, 'User', 'user', '4,9,6,7,21,', '2020-11-09 10:37:03', '2021-07-14 02:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `sup_session_log`
--

CREATE TABLE `sup_session_log` (
  `session_log_id` int(10) NOT NULL,
  `u_id` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sup_session_log`
--

INSERT INTO `sup_session_log` (`session_log_id`, `u_id`, `created_at`) VALUES
(1, '1', '2021-08-05 08:22:10'),
(2, '1', '2021-08-05 08:22:38'),
(3, '1', '2021-08-05 08:24:16'),
(4, '1', '2021-08-05 08:39:47'),
(5, '1', '2021-08-05 10:13:15'),
(6, '1', '2021-08-05 10:45:19'),
(7, '1', '2021-08-05 10:57:57'),
(8, '1', '2021-08-05 11:22:05'),
(9, '1', '2021-08-05 11:35:10'),
(10, '1', '2021-08-05 15:17:50'),
(11, '1', '2021-08-05 22:56:17'),
(12, '1', '2021-08-06 06:46:09'),
(13, '1', '2021-08-06 09:03:45'),
(14, '1', '2021-08-06 09:10:31'),
(15, '1', '2021-08-06 09:23:43'),
(16, '1', '2021-08-10 06:10:55'),
(17, '1', '2021-08-10 06:36:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_files`
--
ALTER TABLE `order_files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `order_id` (`order_id`,`file_type`,`file_name`);

--
-- Indexes for table `sup_account`
--
ALTER TABLE `sup_account`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `sup_account_type`
--
ALTER TABLE `sup_account_type`
  ADD PRIMARY KEY (`sup_account_type_id`);

--
-- Indexes for table `sup_account_users`
--
ALTER TABLE `sup_account_users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `sup_order`
--
ALTER TABLE `sup_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `sup_order_ibfk_1` (`c_id`),
  ADD KEY `sup_order_ibfk_2` (`order_status_id`);

--
-- Indexes for table `sup_order_log`
--
ALTER TABLE `sup_order_log`
  ADD PRIMARY KEY (`sup_order_log_id`),
  ADD KEY `sup_order_log_id` (`sup_order_log_id`);

--
-- Indexes for table `sup_order_status`
--
ALTER TABLE `sup_order_status`
  ADD PRIMARY KEY (`sup_order_status_id`);

--
-- Indexes for table `sup_role`
--
ALTER TABLE `sup_role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name_2` (`role_name`),
  ADD KEY `role_name` (`role_name`);

--
-- Indexes for table `sup_session_log`
--
ALTER TABLE `sup_session_log`
  ADD PRIMARY KEY (`session_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_files`
--
ALTER TABLE `order_files`
  MODIFY `file_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `sup_account`
--
ALTER TABLE `sup_account`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sup_account_type`
--
ALTER TABLE `sup_account_type`
  MODIFY `sup_account_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sup_account_users`
--
ALTER TABLE `sup_account_users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sup_order`
--
ALTER TABLE `sup_order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sup_order_log`
--
ALTER TABLE `sup_order_log`
  MODIFY `sup_order_log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sup_order_status`
--
ALTER TABLE `sup_order_status`
  MODIFY `sup_order_status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sup_role`
--
ALTER TABLE `sup_role`
  MODIFY `role_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sup_session_log`
--
ALTER TABLE `sup_session_log`
  MODIFY `session_log_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
