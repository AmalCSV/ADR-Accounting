ALTER TABLE `purchase` 
CHANGE COLUMN `purchaseID` `purchaseItemID` INT(11) NOT NULL AUTO_INCREMENT , RENAME TO  `purchaseItem` ;

CREATE TABLE `purchaseOrder` (
  `purchaseID` INT NOT NULL AUTO_INCREMENT,
  `orderNumber` VARCHAR(20) NOT NULL,
  `orderDate` DATE NOT NULL,
  `amount` FLOAT NOT NULL,
  `vendorID` INT(11) NOT NULL,
  `createdDate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `isDeleted` BIT(1) NOT NULL DEFAULT b'0',
  `createdBy` INT(11) NULL,
  INDEX `vendor_fk_idx` (`vendorID` ASC),
  PRIMARY KEY (`purchaseID`),
  UNIQUE INDEX `orderNumber_UNIQUE` (`orderNumber` ASC),
  CONSTRAINT `vendor_fk`
    FOREIGN KEY (`vendorID`)
    REFERENCES `vendor` (`vendorID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


    ALTER TABLE `purchaseOrder` 
ADD INDEX `user_fk_idx` (`createdBy` ASC);
;
ALTER TABLE `purchaseOrder` 
ADD CONSTRAINT `user_fk`
  FOREIGN KEY (`createdBy`)
  REFERENCES `user` (`userID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `purchaseItem` 
ADD COLUMN `purchaseOrderID` INT(11) NOT NULL DEFAULT 1 AFTER `vendorID`,
ADD COLUMN `goodReceivedQuantity` INT(11) NOT NULL DEFAULT 0 ,
ADD INDEX `purchaseOrder_fk_idx` (`purchaseOrderID` ASC);
;
ALTER TABLE `purchaseItem` 
ADD CONSTRAINT `purchaseOrder_fk`
  FOREIGN KEY (`purchaseOrderID`)
  REFERENCES `purchaseOrder` (`purchaseID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `purchaseOrder` 
ADD COLUMN `description` VARCHAR(100) NULL AFTER `createdBy`;

