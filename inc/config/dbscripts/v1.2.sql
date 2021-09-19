-- date: 19-09-2021

DROP TABLE `salesorder`;

CREATE TABLE `salesorder` (
  `saleID` int(11) NOT NULL,
  `salesNumber` varchar(45) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `saleDate` date NOT NULL,
  `discount` float NOT NULL DEFAULT 0,
  `discountPercentage` float NOT NULL DEFAULT 0,
  `updatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1,
  `description` varchar(100) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `paidAmount` float DEFAULT 0,
  `vendorID` int(11) NOT NULL DEFAULT 1,
  `isDeleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `salesorder`
  ADD PRIMARY KEY (`saleID`);

ALTER TABLE `salesorder`
  MODIFY `saleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


DROP TABLE `salesorderitem`;

CREATE TABLE `salesorderitem` (
  `orderItemId` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `itemNumber` varchar(255) DEFAULT NULL,
  `itemName` varchar(100) NOT NULL,
  `unitPrice` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `salesOrderId` int(11) NOT NULL,
  `deliveredQuantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `salesorderitem`
  ADD PRIMARY KEY (`orderItemId`),
  ADD KEY `salesOrder_fk_idx` (`salesOrderId`);
  

ALTER TABLE `salesorderitem`
  MODIFY `orderItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `salesorderitem`
  ADD CONSTRAINT `salesOrder_fk` FOREIGN KEY (`salesOrderId`) REFERENCES `salesorder` (`saleID`);
