-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2021 at 06:13 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frozen_bottle`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `S.No` int(11) NOT NULL,
  `MenuID` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`S.No`, `MenuID`, `Title`, `Price`) VALUES
(1, 'KB120', 'Kesar Badam', 120),
(2, 'RM70', 'Rose milk', 70),
(3, 'OR100', 'Oreo Milkshake', 100),
(4, 'BB150', 'Berry Blast', 150),
(5, 'SR80', 'Strawberry Rush', 80),
(6, 'BC140', 'Belgium Choco', 140),
(7, 'MM90', 'Mango Madness', 90),
(9, 'VH80', 'Vanilla Heaven', 85),
(10, 'MC40', 'Mint Cooler', 40),
(11, 'LA50', 'Lassi', 50),
(12, 'WC130', 'Watermelon Crushers', 130),
(13, 'CC30', 'Coke', 30),
(14, 'BS70', 'Banana Smoothie', 70),
(15, 'VS60', 'Vanilla Smoothie', 60);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
-- Table to store the receipt number along with the grand total and timestamp for accounting purposes.
--
CREATE TABLE `orders` (
  `ReceiptID` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ReceiptID`, `Price`, `Timestamp`) VALUES
(1, 0, '2021-04-30 16:05:20'),
(2, 0, '2021-04-30 16:05:33'),
(3, 315, '2021-04-30 16:05:41'),
(4, 315, '2021-05-01 10:35:11'),
(5, 646, '2021-05-01 10:39:36'),
(6, 368, '2021-05-01 10:40:01'),
(7, 368, '2021-05-01 10:41:49'),
(8, 1134, '2021-05-01 10:46:19'),
(9, 819, '2021-05-01 10:47:23'),
(10, 504, '2021-05-01 11:27:37'),
(11, 525, '2021-05-01 11:36:45'),
(12, 473, '2021-05-01 11:37:16'),
(13, 368, '2021-05-01 12:44:56'),
(14, 210, '2021-05-01 16:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--
--
--Temporary table to store the cart values which is deleted before the generation of new receipt.
--
CREATE TABLE `receipt` (
  `Num` int(11) NOT NULL,
  `MenuID` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Qnty` int(11) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`S.No`),
  ADD UNIQUE KEY `ID` (`MenuID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ReceiptID`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`Num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `S.No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ReceiptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
