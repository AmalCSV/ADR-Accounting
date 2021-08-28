CREATE TABLE `salesOrder` (
  `saleID` int(11) NOT NULL AUTO_INCREMENT,
  `salesNumber` varchar(45) NOT NULL,
  `customerID` int(11) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `saleDate` date NOT NULL,
  `discount` float NOT NULL DEFAULT '0',
  `discountPercentage` float NOT NULL DEFAULT '0',
  `updatedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0',
  `description` varchar(100) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`saleID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1

CREATE TABLE `salesOrderItem` (
  `orderItemId` int(11) NOT NULL AUTO_INCREMENT,
  `itemNumber` int(11) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `unitPrice` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` float NOT NULL,
  `salesOrderId` int(11) NOT NULL,
  PRIMARY KEY (`orderItemId`),
  KEY `salesOrder_fk_idx` (`salesOrderId`),
  CONSTRAINT `salesOrder_fk` FOREIGN KEY (`salesOrderId`) REFERENCES `salesOrder` (`saleID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
