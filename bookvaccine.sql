-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2021 at 09:47 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookvaccine`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `H_id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `idno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`H_id`, `email`, `password`, `name`, `idno`) VALUES
(4, 'mother@child.com', 'hell', 'MOTHER AND CHILD CARE HOSPITAL', 352164),
(5, 'dog@hospital.com', 'james', 'DOGGGO CHEEMS', 5315),
(6, 'hospital@nagar.com', 'hell', 'HIGHWAY TO HELL', 420);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `P_id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `idno` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`P_id`, `email`, `password`, `name`, `dob`, `idno`) VALUES
(18, 'lavangnad@gmail.com', 'care', 'LAVANGNA DUBEY', '1999-08-25', 8933016483),
(20, 'suvighyad@gmail.com', 'hell', 'SUVIGHYA DUBEY', '2000-11-17', 8707428002),
(21, 'lily@lily.com', 'lily', 'LILY', '1999-01-01', 420),
(22, 'kallu@jarauli.com', 'seven', 'MOTA KALLU', '2002-01-01', 1234567),
(23, 'patlakallu@jarauli.com', 'five', 'PATLA KALLU', '2002-01-01', 12345),
(24, 'chimarki@jarauli.com', 'maar', 'CHIMARKI MAMA', '2002-01-01', 456123),
(25, 'akash@mishra.com', 'akash', 'AKASH MISHRA', '2001-08-17', 8081),
(26, 'neera@dubey.com', 'neera', 'NEERA DUBEY', '1992-07-14', 9956729222);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `S_id` int(11) NOT NULL,
  `H_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`S_id`, `H_id`, `count`, `type`) VALUES
(7, 4, 1, 'Covaxin'),
(8, 4, 0, 'SPUTNIK'),
(9, 4, 3, 'Covishield'),
(10, 6, 1, 'Covaxin');

-- --------------------------------------------------------

--
-- Table structure for table `vaccinated`
--

CREATE TABLE `vaccinated` (
  `V_id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `H_id` int(11) NOT NULL,
  `P_id` int(11) NOT NULL,
  `dose` int(11) DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccinated`
--

INSERT INTO `vaccinated` (`V_id`, `type`, `H_id`, `P_id`, `dose`, `date`) VALUES
(4, 'SPUTNIK', 4, 18, 1, NULL),
(5, 'Covaxin', 4, 24, 1, NULL),
(6, 'Covaxin', 4, 20, 1, '2021-12-26'),
(9, 'Covishield', 4, 25, 1, NULL),
(10, 'Covishield', 4, 25, 1, NULL),
(14, 'Covaxin', 6, 26, 1, '2021-10-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`H_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idno` (`idno`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`P_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idno` (`idno`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`S_id`);

--
-- Indexes for table `vaccinated`
--
ALTER TABLE `vaccinated`
  ADD PRIMARY KEY (`V_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `H_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `P_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `S_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vaccinated`
--
ALTER TABLE `vaccinated`
  MODIFY `V_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
