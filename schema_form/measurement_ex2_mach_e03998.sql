-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 07:34 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saargummi`
--

-- --------------------------------------------------------

--
-- Table structure for table `measurement_ex2_mach_e03998`
--

CREATE TABLE `measurement_ex2_mach_e03998` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `messurment_schema` varchar(200) DEFAULT NULL,
  `chanel` varchar(200) DEFAULT NULL,
  `part` varchar(200) DEFAULT NULL,
  `security_zone` varchar(200) DEFAULT NULL,
  `user_defined_qst` varchar(200) DEFAULT NULL,
  `always_needs_approval` varchar(200) DEFAULT NULL,
  `out_of_tolerance_mailing_list` varchar(200) DEFAULT NULL,
  `out_of_control_limit_mailing_list` varchar(200) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `valid_from` varchar(200) DEFAULT NULL,
  `valid_to` varchar(200) DEFAULT NULL,
  `assigned_data_collection_points` varchar(200) DEFAULT NULL,
  `measurement_items` varchar(200) DEFAULT NULL,
  `measurement__shedule_items` varchar(200) DEFAULT NULL,
  `approval_by` varchar(200) DEFAULT NULL,
  `created_on` varchar(200) DEFAULT NULL,
  `modified_on` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `modified_by` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `uploads` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `measurement_ex2_mach_e03998`
--

INSERT INTO `measurement_ex2_mach_e03998` (`id`, `name`, `messurment_schema`, `chanel`, `part`, `security_zone`, `user_defined_qst`, `always_needs_approval`, `out_of_tolerance_mailing_list`, `out_of_control_limit_mailing_list`, `notes`, `valid_from`, `valid_to`, `assigned_data_collection_points`, `measurement_items`, `measurement__shedule_items`, `approval_by`, `created_on`, `modified_on`, `created_by`, `modified_by`, `image`, `uploads`) VALUES
(1, 'cc', 'form3', 'STL', 'part number11', 'ccc', 'ccc', 'Yes', 'ccc', 'cc', 'cc', '2021-06-03', '2021-06-16', 'ccc', 'scsgbsd, nfcnfh', 'fdfdb, dfb', 'fdbds', '2021-06-25', '2021-05-31', 'ccsdfbd', 'bbvc', 'screenshot (9).png', 'form ex1.png, screenshot (8).png'),
(2, 'cc', 'form3', 'STL', 'part number11', 'ccc', 'ccc', 'Yes', 'ccc', 'cc', 'cc', '2021-06-03', '2021-06-16', 'ccc', 'scsgbsd, nfcnfh', 'fdfdb, dfb', 'fdbds', '2021-06-25', '2021-05-31', 'ccsdfbd', 'bbvc', 'screenshot (9).png', 'form ex1.png, screenshot (8).png'),
(3, 'cc', 'form3', 'STL', 'part number11', 'ccc', 'ccc', 'Yes', 'ccc', 'cc', 'cc', '2021-06-03', '2021-06-16', 'ccc', 'scsgbsd, nfcnfh', 'fdfdb, dfb', 'fdbds', '2021-06-25', '2021-05-31', 'ccsdfbd', 'bbvc', 'screenshot (9).png', 'form ex1.png, screenshot (8).png'),
(4, 'cc', 'form3', 'STL', 'part number11', 'ccc', 'ccc', 'Yes', 'ccc', 'cc', 'cc', '2021-06-03', '2021-06-16', 'ccc', 'scsgbsd, nfcnfh', 'fdfdb, dfb', 'fdbds', '2021-06-25', '2021-05-31', 'ccsdfbd', 'bbvc', 'screenshot (9).png', 'form ex1.png, screenshot (8).png'),
(5, 'cc', 'form3', 'STL', 'part number11', 'ccc', 'ccc', 'Yes', 'ccc', 'cc', 'cc', '2021-06-03', '2021-06-16', 'ccc', 'scsgbsd, nfcnfh', 'fdfdb, dfb', 'fdbds', '2021-06-25', '2021-05-31', 'ccsdfbd', 'bbvc', 'screenshot (9).png', 'form ex1.png, screenshot (8).png'),
(6, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '    dvsVzv', '', '', ''),
(7, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '   gff', '', '', ''),
(8, '', '', '', '', '', '', '', '', '', 'fbfdbd', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dfbsdfgdf', '', '', ''),
(10, 'fbbf', 'form3', 'Line 1', 'part number11', 'fd', 'fdfd', 'No', 'dff', 'dffbd', 'fdf', '2021-07-04', '2021-06-09', '', 'fdbf, fdff, dffdfd', 'dffbdfd, dffffds', 'sfdds', '2021-06-16', '2021-06-30', 'dfs', 'ssfdsd', 'form (1).png', 'screenshot (10).png, screenshot (8).png'),
(11, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ff', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `measurement_ex2_mach_e03998`
--
ALTER TABLE `measurement_ex2_mach_e03998`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `measurement_ex2_mach_e03998`
--
ALTER TABLE `measurement_ex2_mach_e03998`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
