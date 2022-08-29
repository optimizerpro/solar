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

ALTER TABLE `tblleads` ADD `job_category` INT(11) NULL AFTER `assigned`, ADD `work_type` INT(11) NULL AFTER `job_category`, ADD `trade_type` INT(11) NULL AFTER `work_type`;
ALTER TABLE `tblleads` ADD `location_photo` VARCHAR(150) NULL AFTER `lead_value`, ADD `same_as_mailing` TINYINT(2) NULL DEFAULT '0' COMMENT '0=no,1=yes' AFTER `location_photo`, ADD `bill_country` INT(15) NULL AFTER `same_as_mailing`, ADD `bill_zip` VARCHAR(15) NULL AFTER `bill_country`, ADD `bill_city` VARCHAR(100) NULL AFTER `bill_zip`, ADD `bill_state` VARCHAR(50) NULL AFTER `bill_city`; 
ALTER TABLE `tblleads` ADD `bill_address` VARCHAR(100) NULL AFTER `bill_state`; 
ALTER TABLE `tblleads` ADD `ano_email` VARCHAR(255) NULL AFTER `bill_address`, ADD `ano_phone` VARCHAR(255) NULL AFTER `ano_email`; 

--29-08-2022
ALTER TABLE `tblleads` CHANGE `trade_type` `trade_type` VARCHAR(255) NULL DEFAULT NULL COMMENT 'comma separated ids from tblleads_trade_types'; 