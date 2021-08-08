-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2021 at 03:21 PM
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
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `productID` int NOT NULL,
  `itemNumber` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `unitOfMeasure` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `buyingPrice` float NOT NULL DEFAULT '0',
  `sellingPrice` float NOT NULL DEFAULT '0',
  `warningQty` int DEFAULT '0',
  `rackNo` varchar(100) DEFAULT NULL,
  `imageURL` varchar(255) NOT NULL DEFAULT 'imageNotAvailable.jpg',
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`productID`, `itemNumber`, `itemName`, `unitOfMeasure`, `stock`, `buyingPrice`, `sellingPrice`, `warningQty`, `rackNo`, `imageURL`, `status`, `description`) VALUES
(34, '1', 'First Bag', '', 28, 1500, 0, NULL, NULL, '1525670999_1.png', 'Active', ''),
(35, '2', 'School Bag', '', 5, 500, 0, NULL, NULL, '1525681111_661539.png', 'Active', ''),
(36, '3', 'Office Bag', '', 5, 1300, 0, NULL, NULL, '1525709924_office bag.jpg', 'Active', ''),
(37, '4', 'Leather Bag', '', 6, 3409, 0, NULL, NULL, '1525710010_leather bag.jpg', 'Active', ''),
(38, '5', 'Travel Bag', '', 17, 1200, 0, NULL, NULL, '1525706032_travel bag.jpg', 'Active', ''),
(39, '6', 'Gym Bag', '', 0, 3000, 0, NULL, NULL, '1525710463_gym bag.jpg', 'Active', ''),
(40, '7', 'Handbag', '', 10, 1650, 0, NULL, NULL, '1525713267_handbag.jpg', 'Active', ''),
(41, '8', 'Laptop Bag', '', 9, 2300, 0, NULL, NULL, '1525750683_661539.png', 'Active', ''),
(43, '10', 'Sports Bag', 'Pcs', 92, 1000, 1500, 5, '11111111', '1525756289_sports bag.jpg', 'Active', ''),
(45, '11', 'First Aid Bag', '', 11, 1200, 0, NULL, NULL, '1525787551_first aid bag.jpg', 'Active', ''),
(49, '14', 'Hiking Bag', '', 6, 1200, 0, NULL, NULL, '1526297640_hiking bag.jpg', 'Active', 'This is a hiking bag. Ideal for long distance hikes. Light-weight and water proof.'),
(57, 't111', 't1111', 'Units', 343, 200, 300, 3, '33434', '1627760640_210378837_1254758121650652_2067640300242825101_n.jpg', 'Active', 't222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
