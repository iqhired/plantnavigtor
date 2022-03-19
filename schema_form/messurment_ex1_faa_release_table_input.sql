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
-- Table structure for table `messurment_ex1_faa_release_table_input`
--

CREATE TABLE `messurment_ex1_faa_release_table_input` (
  `id` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `date_of_measurement` varchar(255) DEFAULT NULL,
  `part` varchar(255) DEFAULT NULL,
  `messurment_schema` varchar(255) DEFAULT NULL,
  `work_order_or_lot` varchar(255) DEFAULT NULL,
  `length_part_1` varchar(255) DEFAULT NULL,
  `length_part_2` varchar(255) DEFAULT NULL,
  `length_part_3` varchar(255) DEFAULT NULL,
  `length_part_4` varchar(255) DEFAULT NULL,
  `length_part_5` varchar(255) DEFAULT NULL,
  `avg_all_4_parts_length` varchar(255) DEFAULT NULL,
  `range_of_4_parts_S8mm` varchar(255) DEFAULT NULL,
  `raw_materials` varchar(255) DEFAULT NULL,
  `mylar_specifications` varchar(255) DEFAULT NULL,
  `paramete_notes` varchar(255) NOT NULL,
  `part_id` varchar(255) NOT NULL,
  `vent_holes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messurment_ex1_faa_release_table_input`
--

INSERT INTO `messurment_ex1_faa_release_table_input` (`id`, `notes`, `date_of_measurement`, `part`, `messurment_schema`, `work_order_or_lot`, `length_part_1`, `length_part_2`, `length_part_3`, `length_part_4`, `length_part_5`, `avg_all_4_parts_length`, `range_of_4_parts_S8mm`, `raw_materials`, `mylar_specifications`, `paramete_notes`, `part_id`, `vent_holes`) VALUES
(1, 'aa', '2021-06-06', 'Part1', 'Measurement2', 'aa', 'aaa', 'aa', 'aa', 'aa', 'aa', 'aa', 'fail', 'fail', 'pass', 'a', 'fail', 'fail'),
(2, 'aa', '2021-06-08', 'Part1', 'Measurement1', 'aa', 'aa', 'aa', 'aa', 'aa', 'a', 'aa', 'pass', 'pass', 'fail', 'a', 'fail', 'pass'),
(3, 'a', '2021-06-13', 'Part1', 'Measurement1', 'aa', 'a', 'a', 'a', 'a', 'a', 'a', 'pass', 'pass', 'pass', 'a', 'pass', 'pass'),
(4, ' g', '2021-06-19', 'Part2', 'Measurement1', 'g', 'g', 'g', 'g', 'g', 'g', 'g', 'fail', 'pass', 'fail', 'g', 'fail', 'pass'),
(5, 'c', '2021-06-05', 'Part2', 'Measurement1', 'c', 'c', 'c', 'c', 'cc', 'c', 'c', 'pass', 'pass', 'pass', 'c', 'pass', 'pass'),
(6, 'c', '2021-06-05', 'Part2', 'Measurement1', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'pass', 'fail', 'pass', 'c', 'fail', 'pass'),
(7, 'c', '2021-06-05', 'Part2', 'Measurement1', 'c', 'c', 'c', 'c', 'c', 'c', 'c', 'pass', 'fail', 'pass', 'c', 'fail', 'pass'),
(8, 'aa', '2021-06-08', 'Part1', 'Measurement1', 'aa', 'aa', 'aa', 'aa', 'aa', 'a', 'aa', 'pass', 'pass', 'fail', 'a', 'fail', 'pass'),
(9, 'aa', '2021-06-08', 'Part1', 'Measurement1', 'aa', 'aa', 'aa', 'aa', 'aa', 'a', 'aa', 'pass', 'pass', 'fail', 'a', 'fail', 'pass'),
(10, 'aa', '2021-06-08', 'Part1', 'Measurement1', 'aa', 'aa', 'aa', 'aa', 'aa', 'a', 'aa', 'pass', 'pass', 'fail', 'a', 'fail', 'pass'),
(11, ' ', '2021-06-05', 'Part1', 'Measurement1', ' cc', 'c', 'c', 'c', 'c', 'c', 'c', 'pass', 'pass', 'pass', 'c', 'pass', 'fail'),
(12, 'v', '2021-06-06', 'Part1', 'Measurement2', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'fail', 'fail', 'pass', 'v', 'fail', 'fail'),
(13, 'v', '2021-06-17', 'Part1', 'Measurement1', 'v', 'v', 'v', 'v', 'v', 'v', 'v', 'pass', 'fail', 'fail', 'v', 'pass', 'fail'),
(14, 'f', '2021-06-15', 'Part2', 'Measurement2', 'f', 'f', 'f', 'f', 'f', 'f', 'f', 'pass', 'pass', 'pass', 'f', 'pass', 'fail'),
(15, 'b', '2021-06-13', 'part number11', 'form3', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'fail', 'fail', 'fail', 'b', 'pass', 'fail');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messurment_ex1_faa_release_table_input`
--
ALTER TABLE `messurment_ex1_faa_release_table_input`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messurment_ex1_faa_release_table_input`
--
ALTER TABLE `messurment_ex1_faa_release_table_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
