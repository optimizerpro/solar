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
--30-08-2022
ALTER TABLE `tblcontracts`  ADD `manufacturer_warranty` VARCHAR(50) NOT NULL  AFTER `short_link`,  ADD `roll_yard` VARCHAR(100) NOT NULL  AFTER `manufacturer_warranty`,  ADD `shingle_color` VARCHAR(100) NOT NULL  AFTER `roll_yard`,  ADD `ventilation` VARCHAR(100) NOT NULL  AFTER `shingle_color`,  ADD `install_decking` VARCHAR(100) NOT NULL  AFTER `ventilation`,  ADD `fastners` VARCHAR(100) NOT NULL  AFTER `install_decking`;
ALTER TABLE `tblcontracts` CHANGE `manufacturer_warranty` `manufacturer_warranty` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `roll_yard` `roll_yard` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `shingle_color` `shingle_color` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `ventilation` `ventilation` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `install_decking` `install_decking` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `fastners` `fastners` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
--31-08-2022
ALTER TABLE `tblcontracts` ADD `roof_type` VARCHAR(500) NULL DEFAULT NULL AFTER `fastners`, ADD `layers` VARCHAR(500) NULL DEFAULT NULL AFTER `roof_type`, ADD `pitch` VARCHAR(500) NULL DEFAULT NULL AFTER `layers`, ADD `acv_rcv` VARCHAR(500) NULL DEFAULT NULL AFTER `pitch`, ADD `acv_rcv_plus_tax` VARCHAR(500) NULL DEFAULT NULL AFTER `acv_rcv`, ADD `ad_allowance` VARCHAR(500) NULL DEFAULT NULL AFTER `acv_rcv_plus_tax`, ADD `first_check` VARCHAR(500) NULL DEFAULT NULL AFTER `ad_allowance`, ADD `second_check` VARCHAR(500) NULL DEFAULT NULL AFTER `first_check`, ADD `deductible` VARCHAR(500) NULL DEFAULT NULL AFTER `second_check`, ADD `soffit` VARCHAR(500) NULL DEFAULT NULL AFTER `deductible`, ADD `fascia` VARCHAR(500) NULL DEFAULT NULL AFTER `soffit`, ADD `sidewall` VARCHAR(500) NULL DEFAULT NULL AFTER `fascia`, ADD `driveway` VARCHAR(500) NULL DEFAULT NULL AFTER `sidewall`, ADD `shingle` VARCHAR(500) NULL DEFAULT NULL AFTER `driveway`, ADD `color` VARCHAR(500) NULL DEFAULT NULL AFTER `shingle`, ADD `dripedge` VARCHAR(500) NULL DEFAULT NULL AFTER `color`, ADD `material_drop` VARCHAR(500) NULL DEFAULT NULL AFTER `dripedge`;

--03-09-2022

ALTER TABLE `tblcontracts` ADD `policy_number` VARCHAR(255) NULL AFTER `fastners`, ADD `acv_rcv_aggre` VARCHAR(20) NULL AFTER `policy_number`, ADD `adj_appoint_date` VARCHAR(50) NULL AFTER `acv_rcv_aggre`, ADD `adj_appoint_time` VARCHAR(50) NULL AFTER `adj_appoint_date`; 
--04-09-2022
ALTER TABLE `tblcontracts` ADD `rel_id` INT(11) NULL AFTER `material_drop`, ADD `rel_type` VARCHAR(40) NULL COMMENT 'lead or customer' AFTER `rel_id`; 

--12-09-2022
ALTER TABLE `tblestimates` ADD `rel_id` INT(11) NULL AFTER `deleted_customer_name`, ADD `rel_type` VARCHAR(40) NULL COMMENT 'lead or customer' AFTER `rel_id`, ADD `estimate_to` VARCHAR(191) NULL AFTER `rel_type`; 

ALTER TABLE `tblleads` CHANGE `location_photo` `location_photo` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--17-09-2022
ALTER TABLE `tblcontracts` ADD `created_ip` VARCHAR(40) NULL AFTER `acceptance_ip`; 

--24-09-2022
INSERT INTO `tblcustomfields` (`id`, `fieldto`, `name`, `slug`, `required`, `type`, `options`, `display_inline`, `field_order`, `active`, `show_on_pdf`, `show_on_ticket_form`, `only_admin`, `show_on_table`, `show_on_client_portal`, `disalow_client_to_edit`, `bs_column`, `default_value`) VALUES
(29, 'leads', 'Policy Number', 'leads_policy_number', 0, 'input', '', 0, 7, 1, 0, 0, 0, 0, 0, 0, 6, '');
UPDATE `tblcustomfields` SET `field_order` = '8' WHERE `tblcustomfields`.`id` = 7;

--27-09-2022
CREATE TABLE `tblglobal_tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tblglobal_tasks` (`id`, `name`) VALUES
(1, 'Task 1'),
(2, 'Task 2'),
(3, 'Task 3');

ALTER TABLE `tblglobal_tasks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tblglobal_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;