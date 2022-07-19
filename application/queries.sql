--18-07-2022
ALTER TABLE `tblestimates` ADD `profit_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`, ADD `profit_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_percent`, ADD `profit_type` VARCHAR(30) NULL AFTER `profit_total`; 
--19-07-2022
ALTER TABLE `tblestimates` ADD `profit_margin_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_type`, ADD `profit_margin_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_percent`, ADD `profit_margin_type` VARCHAR(30) NULL AFTER `profit_margin_total`, ADD `overhead_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_type`, ADD `overhead_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `overhead_percent`, ADD `overhead_type` VARCHAR(30) NULL AFTER `overhead_total`; 

ALTER TABLE `tblproposals` ADD `profit_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `discount_type`, ADD `profit_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_percent`, ADD `profit_type` VARCHAR(30) NULL AFTER `profit_total`; 
ALTER TABLE `tblproposals` ADD `profit_margin_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_type`, ADD `profit_margin_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_percent`, ADD `profit_margin_type` VARCHAR(30) NULL AFTER `profit_margin_total`, ADD `overhead_percent` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `profit_margin_type`, ADD `overhead_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `overhead_percent`, ADD `overhead_type` VARCHAR(30) NULL AFTER `overhead_total`;