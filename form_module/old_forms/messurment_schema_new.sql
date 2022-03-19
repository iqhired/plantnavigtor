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
-- Table structure for table `messurment_schema_new`
--

CREATE TABLE `messurment_schema_new` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `messurment_schema` varchar(255) DEFAULT NULL,
  `chanel` varchar(255) DEFAULT NULL,
  `part` varchar(255) DEFAULT NULL,
  `user_defined_qst` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `always_needs_approval` varchar(255) DEFAULT NULL,
  `out_of_tolerance_mailing_list` varchar(255) DEFAULT NULL,
  `out_of_control_limit_mailing_list` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `valid_from` varchar(255) DEFAULT NULL,
  `valid_to` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messurment_schema_new`
--

INSERT INTO `messurment_schema_new` (`id`, `name`, `messurment_schema`, `chanel`, `part`, `user_defined_qst`, `image`, `always_needs_approval`, `out_of_tolerance_mailing_list`, `out_of_control_limit_mailing_list`, `notes`, `valid_from`, `valid_to`) VALUES
(1, 'ccc', '0', '0', '0', '0', '0', '1', 'ccc', 'cc', 'cc', '2021-06-26', '2021-06-26'),
(2, 'ccc', 'form2', 'General / Annual', '', 'ccc', 'upload_file', '1', 'ccc', 'dffbd', 'ccc', '2021-06-17', '2021-06-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messurment_schema_new`
--
ALTER TABLE `messurment_schema_new`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messurment_schema_new`
--
ALTER TABLE `messurment_schema_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
