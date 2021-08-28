-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2021 at 07:48 PM
-- Server version: 8.0.23
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `salesorderpayment`
--

CREATE TABLE `salesorderpayment` (
  `id` int NOT NULL,
  `salesOrderID` int NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `type` tinytext NOT NULL,
  `chequeNo` varchar(50) DEFAULT NULL,
  `chequeStatus` tinytext,
  `realisationDate` date DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salesorderpayment`
--
ALTER TABLE `salesorderpayment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salesOrderID` (`salesOrderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `salesorderpayment`
--
ALTER TABLE `salesorderpayment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `salesorderpayment`
--
ALTER TABLE `salesorderpayment`
  ADD CONSTRAINT `salesorderpayment_ibfk_1` FOREIGN KEY (`salesOrderID`) REFERENCES `salesorder` (`saleID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
