-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2021 at 01:27 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

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
-- Table structure for table `good_bad_pieces`
--

CREATE TABLE `good_bad_pieces` (
  `good_bad_pieces_id` int(10) NOT NULL,
  `station_event_id` int(10) DEFAULT NULL,
  `event_status` varchar(255) DEFAULT '1',
  `good_pieces` varchar(255) DEFAULT NULL,
  `bad_pieces` varchar(255) DEFAULT NULL,
  `defect_name` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `modified_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `good_bad_pieces`
--
ALTER TABLE `good_bad_pieces`
  ADD PRIMARY KEY (`good_bad_pieces_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `good_bad_pieces`
--
ALTER TABLE `good_bad_pieces`
  MODIFY `good_bad_pieces_id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
