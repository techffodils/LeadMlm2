<?php
// ALTER TABLE `mlm_activity` ADD `data` TEXT NOT NULL ;
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Register Field Configuration', 'configuration/set_register_fields', '#', 'fa-bolt', '1', '0', '1', '5', 'null', '1', '0');
//ALTER TABLE `mlm_cron_job` ADD `data` VARCHAR( 40 ) NOT NULL DEFAULT 'NA' AFTER `ip` ;
//ALTER TABLE `mlm_cron_job` ADD `file_status` VARCHAR( 30 ) NOT NULL DEFAULT 'active';
//ALTER TABLE `mlm_cron_job` ADD `done_by` VARCHAR( 30 ) NOT NULL DEFAULT 'Cron Job';
//ALTER TABLE `mlm_payment_methods` CHANGE `payment_methode` `payment_method` VARCHAR( 30 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Plan Settings', 'configuration/plan_settings', '#', 'fa fa-barcode', '1', '0', '1', '5', NULL, '1', '0');
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Database Backup', 'backup', '#', 'fa-database', '1', '0', '1', '5', 'null', '1', '0');
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Language & Currency', 'configuration/multiple_options', '#', 'fa fa-venus-double', '1', '0', '1', '7', NULL, '1', '0');

//CREATE TABLE IF NOT EXISTS `mlm_products` (
//  `id` int(30) NOT NULL AUTO_INCREMENT,
//  `product_name` varchar(30) NOT NULL,
//  `product_amount` double NOT NULL,
//  `product_pv` double NOT NULL,
//  `product_code` varchar(30) NOT NULL,
//  `image` text NOT NULL,
//  `recurring_type` varchar(30) NOT NULL,
//  `product_type` varchar(30) NOT NULL DEFAULT 'register',
//  `status` tinyint(1) NOT NULL DEFAULT '1',
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
    
    
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Product Management', 'product/product_management', '#', 'fa fa-tags', '1', '0', '1', '8', NULL, '1', '0');    

//ALTER TABLE `mlm_products` ADD `images` TEXT NOT NULL AFTER `product_type` ;
//ALTER TABLE `mlm_user` DROP `mlm_user_id`;


//CREATE TABLE IF NOT EXISTS `mlm_register_history` (
//  `id` int(30) NOT NULL AUTO_INCREMENT,
//  `mlm_user_id` int(30) NOT NULL,
//  `register_type` varchar(30) NOT NULL,
//  `payment_type` varchar(30) NOT NULL,
//  `date` datetime NOT NULL,
//  `user_details` text NOT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

//ALTER TABLE `mlm_user_details` CHANGE `district` `zip_code` VARCHAR( 10 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ;

//ALTER TABLE `mlm_user_details` ADD `gender` VARCHAR( 10 ) NOT NULL ;

//ALTER TABLE `mlm_user_details` ADD `phone_number` DOUBLE NOT NULL ;

//ALTER TABLE `mlm_user_details`
//  DROP `address_2`,
//  DROP `ip`;




//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Single Step', 'register/single_step', '3', 'fa-random', '1', '1', '1', '1', NULL, '1', '0');
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Multiple Step', 'register/multiple_step', '3', 'fa-random', '1', '1', '1', '2', NULL, '1', '0');
//INSERT INTO `lead_mlm`.`mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES (NULL, 'Multiple Step', 'register/advanced', '3', 'fa-random', '1', '1', '1', '3', NULL, '1', '0');







