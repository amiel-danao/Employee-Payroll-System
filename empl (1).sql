-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2023 at 02:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empl`
--

-- --------------------------------------------------------

--
-- Table structure for table `abs_calendar`
--

CREATE TABLE `abs_calendar` (
  `id` int(11) NOT NULL,
  `emp_name` text NOT NULL,
  `reason` text NOT NULL,
  `status` text NOT NULL,
  `date_ad` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `emp_name` text NOT NULL,
  `timein` text NOT NULL,
  `timeout` text NOT NULL,
  `breakk` text NOT NULL,
  `late` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `a_manage_emp`
--

CREATE TABLE `a_manage_emp` (
  `id` int(11) NOT NULL,
  `emp_name` text NOT NULL,
  `tasks` text NOT NULL,
  `date_employed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empl_users`
--

CREATE TABLE `empl_users` (
  `id` int(11) NOT NULL,
  `uname` text NOT NULL,
  `typeof_user` text NOT NULL,
  `password` text NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `profilepic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empl_users`
--

INSERT INTO `empl_users` (`id`, `uname`, `typeof_user`, `password`, `fname`, `lname`, `email`, `profilepic`) VALUES
(1, 'employee', 'employee', '$2y$10$U5DOhMwx4vKmhhLmQ7ydkuhNrgVzXSo9VFdATCx5kBOucgrReXFxq', 'Med', 'Tech', '', ''),
(2, 'manager', 'manager', '$2y$10$U5DOhMwx4vKmhhLmQ7ydkuhNrgVzXSo9VFdATCx5kBOucgrReXFxq', 'milo', 'brand', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `rate` text NOT NULL,
  `ot` text NOT NULL,
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productivity`
--

CREATE TABLE `productivity` (
  `id` int(11) NOT NULL,
  `ot` text NOT NULL,
  `timely` text NOT NULL,
  `late` text NOT NULL,
  `responsiveness` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uname` text NOT NULL,
  `pass` text NOT NULL,
  `isonline` text NOT NULL,
  `user_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abs_calendar`
--
ALTER TABLE `abs_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_manage_emp`
--
ALTER TABLE `a_manage_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empl_users`
--
ALTER TABLE `empl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productivity`
--
ALTER TABLE `productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abs_calendar`
--
ALTER TABLE `abs_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `a_manage_emp`
--
ALTER TABLE `a_manage_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empl_users`
--
ALTER TABLE `empl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productivity`
--
ALTER TABLE `productivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
