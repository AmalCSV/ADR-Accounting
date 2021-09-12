


-- // 2021-09-11 - executed
ALTER TABLE `purchaseitem` CHANGE `itemNumber` `productID` INT(11) NOT NULL;
ALTER TABLE `purchaseitem` ADD `itemNumber` VARCHAR(255) NULL AFTER `purchaseDate`;
ALTER TABLE item MODIFY COLUMN sellingPrice decimal(16,2);
ALTER TABLE item MODIFY COLUMN buyingPrice decimal(16,2);
ALTER TABLE purchaseorderpayment MODIFY COLUMN amount decimal(16,2);
ALTER TABLE purchaseorder MODIFY COLUMN amount decimal(16,2);
ALTER TABLE purchaseorder MODIFY COLUMN paidAmount decimal(16,2);
ALTER TABLE purchaseitem MODIFY COLUMN totalPrice decimal(16,2);
ALTER TABLE purchaseitem MODIFY COLUMN unitPrice decimal(16,2);
ALTER TABLE `purchaseorder` CHANGE `paidAmount` `paidAmount` DECIMAL(16,2) NULL DEFAULT '0.00';
-- // 2021-09-11 - executed