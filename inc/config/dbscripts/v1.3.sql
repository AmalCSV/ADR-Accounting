-- date: 20-09-2021

CREATE TABLE `salesorderstatus` (
  `id` int(2) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `salesorderstatus`
  ADD PRIMARY KEY (`id`);

INSERT INTO `salesorderstatus` (`id`, `status`) VALUES
(1, 'Created'),
(2, 'Pending'),
(3, 'Close'),
(4, 'Cancel'),
(5, 'Delivered');


CREATE TABLE `purchaseorderstatus` (
  `id` int(2) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `purchaseorderstatus` (`id`, `status`) VALUES
(1, 'Created'),
(2, 'Pending'),
(3, 'Close'),
(4, 'Cancel'),
(5, 'Goods received');


ALTER TABLE `purchaseorderstatus`
  ADD PRIMARY KEY (`id`);
