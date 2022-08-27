--18-07-2022
ALTER TABLE `tblestimates` ADD `profit_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`, ADD `profit_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_percent`, ADD `profit_type` VARCHAR(30) NULL AFTER `profit_total`; 
--19-07-2022
ALTER TABLE `tblestimates` ADD `profit_margin_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_type`, ADD `profit_margin_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_percent`, ADD `profit_margin_type` VARCHAR(30) NULL AFTER `profit_margin_total`, ADD `overhead_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_type`, ADD `overhead_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `overhead_percent`, ADD `overhead_type` VARCHAR(30) NULL AFTER `overhead_total`; 

ALTER TABLE `tblproposals` ADD `profit_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`, ADD `profit_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_percent`, ADD `profit_type` VARCHAR(30) NULL AFTER `profit_total`; 
ALTER TABLE `tblproposals` ADD `profit_margin_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_type`, ADD `profit_margin_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_percent`, ADD `profit_margin_type` VARCHAR(30) NULL AFTER `profit_margin_total`, ADD `overhead_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_type`, ADD `overhead_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `overhead_percent`, ADD `overhead_type` VARCHAR(30) NULL AFTER `overhead_total`;

--29-07-2022
ALTER TABLE `tblproposals` ADD `subtotal2` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`; 

ALTER TABLE `tblestimates` ADD `subtotal2` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`; 

--04-08-2022
ALTER TABLE `tblitemable` ADD `sectionname` VARCHAR(255) NULL COMMENT 'rel_type=estimate or proposal' AFTER `rel_type`;

--27-08-2022
CREATE TABLE `tblleads_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tblleads_categories` (`id`, `name`) VALUES
(1, 'Commercial'),
(2, 'Property Management'),
(3, 'Residencial');

ALTER TABLE `tblleads_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `tblleads_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

CREATE TABLE `tblleads_work_types` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tblleads_work_types` (`id`, `name`) VALUES
(1, 'Inspection'),
(2, 'Insurance'),
(3, 'New'),
(4, 'Repair'),
(5, 'Retail'),
(6, 'Service'),
(7, 'Warranty');

ALTER TABLE `tblleads_work_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `tblleads_work_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

CREATE TABLE `tblleads_trade_types` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tblleads_trade_types` (`id`, `name`) VALUES
(1, 'Fencing'),
(2, 'Gutters'),
(3, 'Interior'),
(4, 'Oversight'),
(5, 'Painting'),
(6, 'Ruffing'),
(7, 'Screens'),
(8, 'Siding');

ALTER TABLE `tblleads_trade_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `tblleads_trade_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;