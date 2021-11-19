-- date: 07-11-2021
ALTER TABLE `salesorder` ADD `isDiscountAmount` BOOLEAN NOT NULL DEFAULT FALSE AFTER `saleDate`;