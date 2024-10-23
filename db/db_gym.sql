-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 10:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packages`
--

CREATE TABLE `tbl_packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `charges` decimal(10,2) DEFAULT NULL,
  `duration` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_packages`
--

INSERT INTO `tbl_packages` (`package_id`, `package_name`, `charges`, `duration`) VALUES
(3, 'fatloss', 5000.00, '60');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_amount` int(11) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `p_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE `tbl_plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `height` int(15) DEFAULT NULL,
  `weight` int(15) DEFAULT NULL,
  `bloodgroup` varchar(25) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact` int(10) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`id`, `email`, `password`, `name`, `age`, `height`, `weight`, `bloodgroup`, `address`, `contact`, `registration_date`) VALUES
(3, '22bmiit188@gmail.com', 'Aaditya1820', 'Aaditya', 21, 0, 0, '', '', 0, '2024-09-29 12:44:29'),
(4, 'user1@gmail.com', 'User12345678', 'User123', 24, 0, 0, '', '', 0, '2024-10-23 16:52:16'),
(6, 'user111@gmail.com', 'User11111111', 'User11111', 111, 0, 0, '', '', 0, '2024-10-23 17:18:17'),
(8, 'user123@gmail.com', 'User12345', 'User  1511', 24, 165, 65, 'A+', 'asasasas', 1234567895, '2024-10-23 20:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trainers`
--

CREATE TABLE `tbl_trainers` (
  `trainer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `charges` decimal(10,2) NOT NULL,
  `contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trainers`
--

INSERT INTO `tbl_trainers` (`trainer_id`, `name`, `age`, `specialization`, `charges`, `contact`) VALUES
(7, 'Aaditya', 22, 'professional trainer', 8000.00, '9925076665'),
(8, 'kavit', 21, 'professional trainer', 1200.00, '9925076666');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `bloodgroup` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `name`, `email`, `age`, `height`, `weight`, `bloodgroup`, `address`, `contact_number`) VALUES
(10, 'meet patel', 'meetpatel88@gmail.com', 21, 8.3, 90, 'o+', 'satyam', '9925116965'),
(11, 'meet patel', 'meetpatel78@gmail.com', 21, 8.3, 90, 'o+', 'adajan', '9925116963'),
(12, 'kavit', 'kavit@gmail.com', 21, 5.9, 85, 'o+', 'surat', '9925018965');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_trainers`
--
ALTER TABLE `tbl_trainers`
  ADD PRIMARY KEY (`trainer_id`),
  ADD UNIQUE KEY `contact` (`contact`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_packages`
--
ALTER TABLE `tbl_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_register`
--
ALTER TABLE `tbl_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_trainers`
--
ALTER TABLE `tbl_trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
