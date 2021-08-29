CREATE TABLE `purchaseorder` (
  `purchaseID` int(11) NOT NULL AUTO_INCREMENT,
  `orderNumber` varchar(20) NOT NULL,
  `orderDate` date NOT NULL,
  `amount` float NOT NULL,
  `vendorID` int(11) NOT NULL,
  `createdDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` bit(1) NOT NULL DEFAULT b'0',
  `description` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`purchaseID`),
  UNIQUE KEY `orderNumber_UNIQUE` (`orderNumber`),
  KEY `vendor_fk_idx` (`vendorID`),
  CONSTRAINT `vendor_fk` FOREIGN KEY (`vendorID`) REFERENCES `vendor` (`vendorID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

CREATE TABLE `purchaseitem` (
   `purchaseItemID` int(11) NOT NULL AUTO_INCREMENT,
   `itemNumber` varchar(255) NOT NULL,
   `purchaseDate` date NOT NULL,
   `itemName` varchar(255) NOT NULL,
   `unitPrice` float NOT NULL DEFAULT '0',
   `quantity` int(11) NOT NULL DEFAULT '0',
   `vendorName` varchar(255) NOT NULL DEFAULT 'Test Vendor',
   `vendorID` int(11) NOT NULL DEFAULT '0',
   `purchaseOrderID` int(11) NOT NULL DEFAULT '1',
   `goodReceivedQuantity` int(11) DEFAULT '0',
   `totalPrice` float NOT NULL DEFAULT '0',
   PRIMARY KEY (`purchaseItemID`),
   KEY `purchaseOrder_fk_idx` (`purchaseOrderID`)
 ) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;



ALTER TABLE `purchaseorder` ADD `paidAmount` FLOAT NULL DEFAULT '0' AFTER `amount`;

