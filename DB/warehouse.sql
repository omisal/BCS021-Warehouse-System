-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2020 at 08:32 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `ImportID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ManufactDate` date DEFAULT NULL,
  `ExpireDate` date DEFAULT NULL,
  `Quantity` int(10) UNSIGNED NOT NULL,
  `StoreRoom` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `DateRecieved` datetime NOT NULL,
  `StokeRemain` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`ImportID`, `ProductID`, `ManufactDate`, `ExpireDate`, `Quantity`, `StoreRoom`, `UserName`, `SupplierID`, `DateRecieved`, `StokeRemain`) VALUES
(1, 2, '2020-08-01', '2025-08-01', 100, 1, 'user1', 3, '2020-08-09 15:01:27', 90),
(2, 1, '2020-08-01', '2025-08-29', 500, 2, 'omisal', 2, '2020-08-14 08:31:27', 500),
(3, 4, '2020-08-02', '2024-09-05', 100, 3, 'omisal', 1, '2020-08-14 08:32:11', 100),
(4, 5, '2020-08-01', '2023-08-19', 300, 2, 'omisal', 3, '2020-08-14 08:33:02', 300),
(5, 1, '2020-08-02', '2024-08-24', 350, 1, 'omisal', 2, '2020-08-14 08:34:48', 350);

-- --------------------------------------------------------

--
-- Table structure for table `ordercompleted`
--

CREATE TABLE `ordercompleted` (
  `OCID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ImportID` int(11) NOT NULL,
  `Quantity` int(10) UNSIGNED NOT NULL,
  `DateIssued` datetime NOT NULL,
  `UserName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordercompleted`
--

INSERT INTO `ordercompleted` (`OCID`, `OrderID`, `ImportID`, `Quantity`, `DateIssued`, `UserName`) VALUES
(1, 1, 1, 10, '2020-08-14 06:49:56', 'user1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `ShopID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) UNSIGNED NOT NULL,
  `CompletedQuantity` int(11) NOT NULL,
  `DateOrdered` year(4) NOT NULL,
  `UserName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `ShopID`, `ProductID`, `Quantity`, `CompletedQuantity`, `DateOrdered`, `UserName`) VALUES
(1, 1, 2, 10, 10, 2020, 'user2'),
(2, 2, 1, 70, 0, 2020, 'omisal');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(30) NOT NULL,
  `Brand` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Brand`) VALUES
(1, 'Jasmine Rice', 'Hyatt'),
(2, 'Bottle Watter 1.5ltr', 'Drop'),
(3, 'Mo Power Soap', 'Metl'),
(4, 'Brown Sugar', 'Azam'),
(5, 'White Flour', 'PPF'),
(6, 'Fursana', 'Azam');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(2) NOT NULL,
  `Title` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `Title`) VALUES
(1, 'Manager'),
(2, 'Store Keeper'),
(3, 'Shop Keeper');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `ShopID` int(11) NOT NULL,
  `Label` varchar(30) NOT NULL,
  `Location` varchar(30) NOT NULL,
  `Status` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`ShopID`, `Label`, `Location`, `Status`) VALUES
(1, 'Brainers Shop 1', 'Amani', 1),
(2, 'Brainers Shop 2', 'Fuoni', 1),
(3, 'Brainers Shop 3', 'Kijangwani', 1),
(4, 'Brainers Shop 4 Accesories', 'Darajani', 1),
(5, 'Brainers Shop 9', 'Kwarara', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` char(1) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` char(10) NOT NULL,
  `Photo` varchar(50) NOT NULL,
  `Role` int(2) NOT NULL,
  `LastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`UserName`, `Password`, `FirstName`, `MiddleName`, `LastName`, `DOB`, `Gender`, `Address`, `Email`, `Phone`, `Photo`, `Role`, `LastLogin`) VALUES
('omisal', '8cb2237d0679ca88db6464eac60da96345513964', 'Omar', 'Saleh', 'Suleiman', '1995-07-28', 'M', 'Kijangwani', 'omisal95@gmail.com', '0776538771', '6f6d6973616c.JPG', 1, '2020-08-14 08:54:34'),
('user1', '8cb2237d0679ca88db6464eac60da96345513964', 'Mtoto', 'Baba', 'Babu', '1999-05-29', 'F', 'Mkele', 'mtoto@gmail.com', '0772089955', '8c518555.png', 2, '2020-08-14 07:01:21'),
('user2', '8cb2237d0679ca88db6464eac60da96345513964', 'Mtu', 'Baba', 'Babu', '1999-08-10', 'F', 'Fuoni', 'mtu@gmail.com', '0985756333', 'avatar.png', 3, '2020-08-09 17:58:07'),
('user3', '8cb2237d0679ca88db6464eac60da96345513964', 'Ali', 'Juma', 'Hilali', '2002-07-13', 'M', 'Kianga', 'alijuma@gmail.com', '0987985643', 'avatar.png', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `storeroom`
--

CREATE TABLE `storeroom` (
  `RoomID` int(11) NOT NULL,
  `Label` varchar(30) NOT NULL,
  `Status` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `storeroom`
--

INSERT INTO `storeroom` (`RoomID`, `Label`, `Status`) VALUES
(1, 'Store A', 1),
(2, 'Store B', 1),
(3, 'Store C', 1),
(4, 'Store D', 1),
(5, 'Store E', 1),
(6, 'Store F', 1),
(7, 'Store J', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `Email`, `Phone`) VALUES
(1, 'Supplier A', 'sup_a@gmail.com', '0123456789'),
(2, 'EverGreen', 'evergreen@gmail.com', '0984547424'),
(3, 'FastTransp', 'fast@gmail.com', '0584287653');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`ImportID`),
  ADD KEY `UserName` (`UserName`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `StoreRoom` (`StoreRoom`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `ordercompleted`
--
ALTER TABLE `ordercompleted`
  ADD PRIMARY KEY (`OCID`),
  ADD KEY `UserName` (`UserName`),
  ADD KEY `ImportID` (`ImportID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `ShopID` (`ShopID`),
  ADD KEY `UserName` (`UserName`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`ShopID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`UserName`),
  ADD KEY `Role` (`Role`);

--
-- Indexes for table `storeroom`
--
ALTER TABLE `storeroom`
  ADD PRIMARY KEY (`RoomID`),
  ADD UNIQUE KEY `Label` (`Label`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `ImportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ordercompleted`
--
ALTER TABLE `ordercompleted`
  MODIFY `OCID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `ShopID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `storeroom`
--
ALTER TABLE `storeroom`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_ibfk_1` FOREIGN KEY (`UserName`) REFERENCES `staff` (`UserName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `imports_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `imports_ibfk_3` FOREIGN KEY (`StoreRoom`) REFERENCES `storeroom` (`RoomID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `imports_ibfk_4` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`) ON UPDATE CASCADE;

--
-- Constraints for table `ordercompleted`
--
ALTER TABLE `ordercompleted`
  ADD CONSTRAINT `ordercompleted_ibfk_1` FOREIGN KEY (`UserName`) REFERENCES `staff` (`UserName`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ordercompleted_ibfk_2` FOREIGN KEY (`ImportID`) REFERENCES `imports` (`ImportID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ordercompleted_ibfk_3` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ShopID`) REFERENCES `shops` (`ShopID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`UserName`) REFERENCES `staff` (`UserName`) ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`Role`) REFERENCES `role` (`RoleID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
