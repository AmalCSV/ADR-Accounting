ALTER TABLE `vendor` ADD `contactPerson` VARCHAR(100) NULL DEFAULT NULL AFTER `fullName`;
ALTER TABLE `customer` ADD `contactPerson` VARCHAR(100) NULL DEFAULT NULL AFTER `fullName`;