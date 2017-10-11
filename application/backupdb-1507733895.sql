

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('4lpf9eouor57b8vj5tiablec7sr8bmfi','::1',1507386108,'__ci_last_regenerate|i:1507386106;'),
	('dk1gr7f71srh1o1h9por4pd8abau3ldc','::1',1507386442,'__ci_last_regenerate|i:1507386441;'),
	('dl6d9fco7b92spt7q1h80m47v4o1540n','::1',1500208538,'__ci_last_regenerate|i:1500208538;inf_user_page_load_time|i:1500208538;mlm_logged_arr|a:6:{s:6:\"mlm_id\";s:1:\"1\";s:12:\"mlm_username\";s:5:\"admin\";s:13:\"mlm_user_type\";s:5:\"admin\";s:11:\"mlm_user_id\";s:4:\"1900\";s:9:\"mlm_email\";s:13:\"admin@lead.in\";s:12:\"is_logged_in\";b:1;}mlm_last_activity|i:1500208538;'),
	('eg82p6d4euqpr1tn2df3iqr3qdmnv4ke','::1',1507445277,'__ci_last_regenerate|i:1507445264;'),
	('f1vdp2smslubgctui6q2ag927faqb668','::1',1500204582,'inf_user_page_load_time|i:1500204582;'),
	('gpdtdv8nqsbkk87cpm78ls4s18kd3lps','::1',1507385515,'__ci_last_regenerate|i:1507385408;'),
	('h8npqknadv1n1p6ahh42betgfkbuhrvq','::1',1500216751,'__ci_last_regenerate|i:1500216751;inf_user_page_load_time|i:1500214019;'),
	('jjhj7qcpaba9s5fskd2eqi2fba9cg9ju','::1',1507386632,'__ci_last_regenerate|i:1507386581;'),
	('o8buddlvda9fqpc1a5s4gs7qnoh7msrv','::1',1500204576,'__ci_last_regenerate|i:1500204576;inf_user_page_load_time|i:1500204576;');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mlm_user_id` int(11) NOT NULL,
  `activity` varchar(100) NOT NULL,
  `ip_address` varchar(30) NOT NULL DEFAULT 'NA',
  `date` datetime NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_activity` (`id`, `mlm_user_id`, `activity`, `ip_address`, `date`, `data`) VALUES
	(1,1900,'login','127.0.0.1','2017-10-11 20:09:47','a:0:{}'),
	(2,1900,'new_registration_field_added','127.0.0.1','2017-10-11 20:10:12','a:17:{s:12:\"edited_field\";s:0:\"\";s:10:\"field_name\";s:3:\"qwe\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"1\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:3:\"int\";s:18:\"data_type_max_size\";s:2:\"11\";s:13:\"default_value\";s:1:\"1\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:7:\"add_new\";s:7:\"Add New\";}');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_chat_history` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `from_id` int(30) NOT NULL,
  `to_id` int(30) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_commission_details` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `from_user` int(30) DEFAULT '0',
  `to_user` int(30) NOT NULL,
  `amount_type` varchar(30) NOT NULL,
  `amount` decimal(16,8) NOT NULL DEFAULT '0.00000000',
  `tax_amount` decimal(16,8) NOT NULL DEFAULT '0.00000000',
  `date` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_config` (
  `key` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `mlm_config` (`key`, `value`) VALUES
	('ADMIN_THEME_FOLDER','default'),
	('ADMIN_USER_ID',NULL),
	('ADMIN_USER_NAME',NULL),
	('BLOCK_ECOMMERCE','0'),
	('BLOCK_LOGIN','0'),
	('BLOCK_REGISTER','0'),
	('COMPANY_NAME','Company'),
	('DEFAULT_CURRENCY_CODE','USD'),
	('DEFAULT_CURRENCY_VALUE','1'),
	('DEFAULT_SYMBOL_LEFT','$'),
	('DEFAULT_SYMBOL_RIGHT',''),
	('FROM_MOBILE','0'),
	('LANG_ID','1'),
	('LANG_NAME','english'),
	('MAINTENANCE_MODE','0'),
	('MLM_PLAN','Binary'),
	('OPTIONAL_MODULE','0'),
	('SESS_STATUS','0'),
	('TABLE_PREFIX','mlm_');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_configuration` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `username_type` varchar(30) NOT NULL DEFAULT 'static',
  `language_status` varchar(30) NOT NULL DEFAULT 'yes',
  `currency_status` varchar(30) NOT NULL DEFAULT 'yes',
  `mlm_plan` varchar(30) NOT NULL,
  `opencart_status` varchar(30) NOT NULL,
  `mail_status` varchar(30) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_countries` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `country_id` int(30) NOT NULL,
  `country_name` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `iso_code` varchar(30) NOT NULL DEFAULT 'NA',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_cron_job` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `cron_job` varchar(30) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  `preferences` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_cron_job` (`id`, `cron_job`, `ip`, `date`, `status`, `preferences`) VALUES
	(1,'database_backup','::1','2017-07-16 09:52:56','Success',NULL),
	(2,'database_backup','::1','2017-07-16 12:59:54','Success',NULL),
	(3,'database_backup','::1','2017-07-16 13:00:13','Success',NULL),
	(4,'database_backup','::1','2017-07-16 13:01:35','Success',NULL),
	(5,'database_backup','::1','2017-07-16 13:02:25','Started',NULL),
	(6,'db_backup','127.0.0.1','2017-10-11 20:26:42','Started',NULL),
	(7,'db_backup','127.0.0.1','2017-10-11 20:27:41','Success',NULL),
	(8,'db_backup','127.0.0.1','2017-10-11 20:28:15','Started',NULL);

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_curl_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_email` varchar(20) NOT NULL,
  `data` text NOT NULL,
  `url` varchar(10) NOT NULL,
  `proccess_type` varchar(10) NOT NULL,
  `date` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_currencies` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(30) NOT NULL,
  `symbol_left` varchar(30) NOT NULL,
  `symbol_right` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_languages` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(30) NOT NULL,
  `lng_name` varchar(30) NOT NULL,
  `lang_flag` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL DEFAULT '#',
  `root_id` varchar(11) NOT NULL DEFAULT '#',
  `icon` varchar(30) NOT NULL,
  `admin_permission` tinyint(1) NOT NULL DEFAULT '1',
  `user_permission` tinyint(1) NOT NULL DEFAULT '1',
  `employee_permission` tinyint(1) DEFAULT '1',
  `order` int(11) NOT NULL,
  `target` varchar(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES
	(1,'Dashboard','home','#','fa-home',1,1,1,1,NULL,1,'0'),
	(2,'Profile','profile','#','fa-user',1,1,1,1,NULL,1,'0'),
	(3,'New Register','registration','#','fa-user-plus',1,1,1,1,NULL,1,'0'),
	(4,'Register Field Configuration','configuration/set_register_fields','#','fa-bolt',1,'0',1,5,'null',1,'0');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_order_details` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `total_amount` decimal(16,8) NOT NULL,
  `total_pv` double NOT NULL,
  `products` text NOT NULL,
  `payment_type` varchar(30) NOT NULL DEFAULT 'bank_transfer',
  `order_date` datetime NOT NULL,
  `confirm_date` datetime NOT NULL,
  `recurring_status` varchar(30) NOT NULL DEFAULT 'active',
  `order_status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_payment_methods` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL,
  `payment_methode` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_payment_methods` (`id`, `code`, `payment_methode`, `status`) VALUES
	(1,'free_registration','Free Registration','active'),
	(2,'bank_transfer','Bank Transfer','active'),
	(3,'ewallet','Ewallet','active'),
	(4,'epin','Epin','active');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_name` int(11) NOT NULL,
  `rank_pv` int(11) NOT NULL,
  `rank_bonus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_rank_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mlm_user_id` int(11) NOT NULL,
  `current_rank` int(11) NOT NULL,
  `new_rank` int(11) NOT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_register_fields` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(30) NOT NULL,
  `required_status` int(10) NOT NULL DEFAULT '1',
  `unique_status` int(10) NOT NULL DEFAULT '0',
  `register_step` varchar(30) NOT NULL DEFAULT 'step-2',
  `order` int(30) NOT NULL,
  `default_value` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `editable_status` int(30) NOT NULL DEFAULT '1',
  `field_type` varchar(30) NOT NULL,
  `radio_value1` varchar(30) NOT NULL DEFAULT 'NA',
  `radio_value2` varchar(30) NOT NULL DEFAULT 'NA',
  `select_option1` varchar(30) NOT NULL DEFAULT 'NA',
  `select_option2` varchar(30) NOT NULL DEFAULT 'NA',
  `select_option3` varchar(30) NOT NULL DEFAULT 'NA',
  `select_option4` varchar(30) NOT NULL DEFAULT 'NA',
  `data_types` varchar(30) NOT NULL,
  `data_type_max_size` int(30) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_register_fields` (`id`, `field_name`, `required_status`, `unique_status`, `register_step`, `order`, `default_value`, `status`, `editable_status`, `field_type`, `radio_value1`, `radio_value2`, `select_option1`, `select_option2`, `select_option3`, `select_option4`, `data_types`, `data_type_max_size`, `date`) VALUES
	(1,'qwe','0','0','step1',1,'1','active',1,'text','','','','','','','int',11,'2017-10-11 20:10:12');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_registration_products` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(30) NOT NULL,
  `amount` decimal(16,8) NOT NULL,
  `pv` double NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_site_info` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_logo` varchar(50) NOT NULL,
  `company_fav_icon` varchar(50) NOT NULL,
  `company_address` text NOT NULL,
  `company_email` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_states` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `state_id` int(30) NOT NULL,
  `state_name` varchar(30) NOT NULL,
  `country_id` int(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'avtive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_sub_menus` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `link` varchar(40) NOT NULL DEFAULT '#',
  `admin_permission` int(20) NOT NULL,
  `user_permission` int(20) NOT NULL,
  `level` int(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_sub_menus` (`id`, `link`, `admin_permission`, `user_permission`, `level`, `status`) VALUES
	(1,'#',1,1,1,'yes');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_temp_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `reg_data` text,
  `payment_status` varchar(10) NOT NULL DEFAULT 'pending',
  `reg_status` varchar(10) NOT NULL,
  `date_of_reg` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_user` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `mlm_user_id` int(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `position` varchar(10) NOT NULL,
  `father_id` int(11) NOT NULL DEFAULT '0',
  `sponsor_id` int(11) NOT NULL DEFAULT '0',
  `user_left` int(11) NOT NULL DEFAULT '0',
  `user_right` int(11) NOT NULL DEFAULT '0',
  `user_left_carry` int(11) NOT NULL DEFAULT '0',
  `user_right_carry` int(11) NOT NULL DEFAULT '0',
  `user_status` varchar(30) NOT NULL DEFAULT 'active',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_user` (`id`, `mlm_user_id`, `user_name`, `email`, `password`, `user_type`, `position`, `father_id`, `sponsor_id`, `user_left`, `user_right`, `user_left_carry`, `user_right_carry`, `user_status`, `date`) VALUES
	(1,1900,'admin','admin@lead.in','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','admin','','0','0','0','0','0','0','active',NULL),
	(5,1901,'asdasdasd','asdasd@fghf.dgd','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','user','L',1900,1900,'0','0','0','0','active','2017-07-01 14:41:57'),
	(6,1902,'ddddddddd','ghjghjgh!@qwe.fgh','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12','user','L',1900,1900,'0','0','0','0','active','2017-07-01 15:59:49'),
	(7,1903,'asdasds','sdfsdf!@qwe.fgh','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b83','user','L',1900,1900,'0','0','0','0','active','2017-07-15 19:50:58'),
	(8,1904,'oooooooo','asd!@qwe.fghf','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b83','user','L',1900,1900,'0','0','0','0','active','2017-07-15 19:52:11'),
	(9,1905,'jipinu','hjghj@hjk.ghj','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12','user','R',1900,1900,'0','0','0','0','active','2017-07-16 09:06:24');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_user_balance` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `mlm_user_id` int(30) NOT NULL,
  `balance_amount` decimal(16,8) NOT NULL,
  `total_amount` decimal(16,8) NOT NULL,
  `released_amount` decimal(16,8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_user_balance` (`id`, `mlm_user_id`, `balance_amount`, `total_amount`, `released_amount`) VALUES
	(1,1901,0.00000000,0.00000000,0.00000000),
	(2,1902,0.00000000,0.00000000,0.00000000),
	(3,1904,0.00000000,0.00000000,0.00000000),
	(4,1905,0.00000000,0.00000000,0.00000000);

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_user_details` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `mlm_user_id` int(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL DEFAULT 'NA',
  `address_1` varchar(50) NOT NULL DEFAULT 'NA',
  `address_2` varchar(50) NOT NULL DEFAULT 'NA',
  `city` varchar(30) NOT NULL DEFAULT 'NA',
  `district` varchar(30) NOT NULL DEFAULT 'NA',
  `state_id` int(30) NOT NULL DEFAULT '0',
  `country_id` int(30) NOT NULL DEFAULT '0',
  `ip` varchar(30) NOT NULL DEFAULT 'NA',
  `user_dp` text NOT NULL,
  `date_of_joining` datetime NOT NULL,
  `aaaa` text,
  `bbbb` varchar(1) DEFAULT NULL,
  `test` int(6) DEFAULT NULL,
  `wer` double DEFAULT NULL,
  `ttttttt` double DEFAULT NULL,
  `sarath` int(1) DEFAULT NULL,
  `jipin` int(1) DEFAULT NULL,
  `jjjjjjjjjjj` int(1) DEFAULT NULL,
  `uuuuuuu` int(1) DEFAULT NULL,
  `kkkkkkkk` double DEFAULT NULL,
  `yyyyy` int(1) DEFAULT NULL,
  `uuuuuu` double DEFAULT NULL,
  `techffodils` varchar(30) DEFAULT NULL,
  `qwe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_user_details` (`id`, `mlm_user_id`, `first_name`, `last_name`, `address_1`, `address_2`, `city`, `district`, `state_id`, `country_id`, `ip`, `user_dp`, `date_of_joining`, `aaaa`, `bbbb`, `test`, `wer`, `ttttttt`, `sarath`, `jipin`, `jjjjjjjjjjj`, `uuuuuuu`, `kkkkkkkk`, `yyyyy`, `uuuuuu`, `techffodils`, `qwe`) VALUES
	(1,1901,'hjghjghj','ghjghjghj','address1','address12','city','NA','0','0','NA','','2017-07-01 14:41:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(2,1902,'gfdfgd','fgdfgdfg','address1','address12','city','NA','0','0','NA','','2017-07-01 15:59:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,1904,'NA','NA','address1','address12','city','NA','0','0','NA','','2017-07-15 19:52:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,1905,'NA','NA','address1','address12','city','NA','0','0','NA','','2017-07-16 09:06:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_wallet_details` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `wallet_type` varchar(30) NOT NULL DEFAULT 'credit/debit',
  `amount` decimal(16,8) NOT NULL,
  `amount_type` varchar(30) NOT NULL DEFAULT 'NA',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_wallet_transfer` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `from_user` int(30) NOT NULL,
  `to_user` int(30) NOT NULL DEFAULT '0',
  `transfer_type` varchar(30) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- ------------------------------------------------ 

