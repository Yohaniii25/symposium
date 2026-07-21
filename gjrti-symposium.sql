-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2026 at 12:06 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gjrti-symposium`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(2, 'Symposium Admin', 'symposium_admin@gjrti.lk', '$2y$10$9eauYw6daN4KZBfcBGxc/OayJY5L1VP8fjIXPPY2daT8Jj/WRgRiK', '2026-07-21 09:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `reference_no` varchar(20) DEFAULT NULL,
  `title` enum('Prof.','Dr.','Mr.','Ms.') NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nic_passport` varchar(50) DEFAULT NULL,
  `abstract_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `food_preference` enum('Vegetarian','Non-Vegetarian','Vegan','Halal','No Preference') DEFAULT 'No Preference',
  `participant_type` enum('Presenting Author','Co-Author','Other Participants') NOT NULL,
  `country_type` varchar(50) DEFAULT 'local',
  `password` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reference_no`, `title`, `full_name`, `nic_passport`, `abstract_name`, `email`, `phone`, `food_preference`, `participant_type`, `country_type`, `password`, `status`, `created_at`) VALUES
(2, NULL, 'Mr.', 'Uvindu Rathnayaka', '1999999999', 'Test', 'gem_test@sltdigital.site', '+94778439871', 'Non-Vegetarian', 'Presenting Author', 'local', '$2y$10$fAYQ0fQPtX/DMT9iVjRhXu4yC9D8HlAL8QM84zxjm4.vx8bANyal.', 'pending', '2025-12-11 05:50:27'),
(3, NULL, 'Mr.', 'Presenter Test', '111111111V', 'Abstract Test', 'presenter_test@example.com', '0771234567', NULL, 'Presenting Author', 'local', '$2y$10$6Sfo7ngXLB2wzBxyJldgHOmgw8NmLafGGkLKRylv6CRQz8/bicGIK', 'pending', '2026-07-21 10:00:00'),
(4, NULL, 'Ms.', 'Other Test 1', '', NULL, 'other_test1@example.com', '0771234568', NULL, '', 'local', NULL, 'pending', '2026-07-21 10:00:00'),
(6, 'GJRTI_SYMP_2026_0006', 'Prof.', 'Yohani Abeykoon', '199456567789', 'Yohani Abeykoon', 'yohanii725@gmail.com', '+94778439871', 'No Preference', 'Presenting Author', 'local', '$2y$10$0idN5ajHs2PBRgugYeu9KuvYCpw/ALOE0FkZWOEy9sAqF402xIRmC', 'pending', '2026-07-21 10:05:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nic_passport` (`nic_passport`),
  ADD UNIQUE KEY `reference_no` (`reference_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
