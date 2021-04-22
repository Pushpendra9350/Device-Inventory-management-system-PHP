-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 22, 2020 at 07:06 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dims_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_details`
--

CREATE TABLE `admin_login_details` (
  `email_id` varchar(30) NOT NULL,
  `passcode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_login_details`
--

INSERT INTO `admin_login_details` (`email_id`, `passcode`) VALUES
('rahul@nagarro.com', 'ebaaba27b32928a25f2ad6185fc0cc74');

-- --------------------------------------------------------

--
-- Table structure for table `device_data`
--

CREATE TABLE `device_data` (
  `sno` int(11) NOT NULL,
  `device_name` varchar(30) NOT NULL,
  `total_inventory` int(11) NOT NULL,
  `available_inventory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `device_data`
--

INSERT INTO `device_data` (`sno`, `device_name`, `total_inventory`, `available_inventory`) VALUES
(1, 'iphone 6s', 4, 1),
(2, 'Headphone', 2, 1),
(3, 'monitor', 2, 0),
(4, 'web camera', 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `name`, `email_id`) VALUES
(1234, 'pushpendra', 'pushpendra@gmail.com'),
(2346, 'Harsh', 'harsh@gmail.com'),
(5861, 'Sahil Gupta', 'sahil@nagarro.com'),
(7844, 'surendra', 'surendra@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `issued_device_data`
--

CREATE TABLE `issued_device_data` (
  `sno` int(11) NOT NULL,
  `device_name` varchar(30) NOT NULL,
  `employee_name` varchar(30) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Issued',
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `issued_device_data`
--

INSERT INTO `issued_device_data` (`sno`, `device_name`, `employee_name`, `employee_id`, `device_id`, `status`, `return_date`) VALUES
(1, 'iphone 6s', 'pushpendra', 1234, 1, 'Issued', '2020-08-29'),
(2, 'monitor', 'Harsh', 2346, 3, 'returned', '2020-08-28'),
(3, 'web camera', 'Sahil Gupta', 5861, 4, 'Issued', '2020-08-20'),
(4, 'Headphone', 'surendra', 7844, 2, 'returned', '2020-08-24'),
(5, 'monitor', 'Harsh', 2346, 3, 'Issued', '2020-08-29'),
(6, 'iphone 6s', 'Sahil Gupta', 5861, 1, 'Issued', '2020-08-30'),
(7, 'Headphone', 'Sahil Gupta', 5861, 2, 'Issued', '2020-09-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login_details`
--
ALTER TABLE `admin_login_details`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `device_data`
--
ALTER TABLE `device_data`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `issued_device_data`
--
ALTER TABLE `issued_device_data`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device_data`
--
ALTER TABLE `device_data`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `issued_device_data`
--
ALTER TABLE `issued_device_data`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
