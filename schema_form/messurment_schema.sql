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
-- Table structure for table `messurment_schema`
--

CREATE TABLE `messurment_schema` (
  `id` int(11) NOT NULL,
  `header` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `spc` varchar(255) DEFAULT NULL,
  `opt` varchar(50) DEFAULT NULL,
  `normal` varchar(255) DEFAULT NULL,
  `lower_tolerance` varchar(255) DEFAULT NULL,
  `upper_tolerance` varchar(255) DEFAULT NULL,
  `lower_tolerance_ctrl_limit` varchar(255) DEFAULT NULL,
  `upper_tolerance_ctrl_limit` varchar(255) DEFAULT NULL,
  `dimentions` varchar(20) DEFAULT NULL,
  `default_binary` varchar(200) DEFAULT NULL,
  `normal_binary` varchar(200) DEFAULT NULL,
  `yes_alias` varchar(200) DEFAULT NULL,
  `no_alias` varchar(200) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `texts` longtext DEFAULT NULL,
  `colors` longtext DEFAULT NULL,
  `defaults` varchar(255) DEFAULT NULL,
  `targets` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `messurment_schema_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messurment_schema`
--

INSERT INTO `messurment_schema` (`id`, `header`, `alias`, `position`, `spc`, `opt`, `normal`, `lower_tolerance`, `upper_tolerance`, `lower_tolerance_ctrl_limit`, `upper_tolerance_ctrl_limit`, `dimentions`, `default_binary`, `normal_binary`, `yes_alias`, `no_alias`, `value`, `texts`, `colors`, `defaults`, `targets`, `notes`, `messurment_schema_name`) VALUES
(1, 'aa', 'aa', 'aa', 'a', '1', 'a', 'a', 'a', 'a', 'a', 'Z', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aaaa', 'form1'),
(2, 'bb', 'bb', 'bb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NONE', 'NO', 'bb', 'bb', NULL, NULL, NULL, NULL, NULL, 'bbbb', 'form2'),
(3, 'cc', 'cc', 'cc', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ccccc', 'form3'),
(4, 'dd', 'dd', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ddddd', 'form4'),
(5, 'dd', 'dd', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dddd', 'dd'),
(6, 'ff', 'ff', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ffff', 'ff'),
(7, 'bb', 'bb', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bbb', 'bb'),
(8, 'x', 'x', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'x', 'x'),
(9, 'c', 'c', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c', 'c'),
(10, 'ff', 'ff', NULL, '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff', 'ff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messurment_schema`
--
ALTER TABLE `messurment_schema`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messurment_schema`
--
ALTER TABLE `messurment_schema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
