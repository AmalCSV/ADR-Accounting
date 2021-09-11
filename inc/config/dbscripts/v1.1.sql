
-- // 2021-09-11 - Not executed
ALTER TABLE item MODIFY COLUMN sellingPrice decimal(16,2);
ALTER TABLE purchaseorderpayment MODIFY COLUMN amount decimal(16,2);
ALTER TABLE purchaseorder MODIFY COLUMN amount decimal(16,2);
ALTER TABLE purchaseorder MODIFY COLUMN paidAmount decimal(16,2);
ALTER TABLE purchaseitem MODIFY COLUMN totalPrice decimal(16,2);
ALTER TABLE purchaseitem MODIFY COLUMN unitPrice decimal(16,2);
