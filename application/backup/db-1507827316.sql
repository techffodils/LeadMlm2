

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_activity` (`id`, `mlm_user_id`, `activity`, `ip_address`, `date`, `data`) VALUES
	(1,1900,'login','127.0.0.1','2017-10-11 20:09:47','a:0:{}'),
	(2,1900,'new_registration_field_added','127.0.0.1','2017-10-11 20:10:12','a:17:{s:12:\"edited_field\";s:0:\"\";s:10:\"field_name\";s:3:\"qwe\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"1\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:3:\"int\";s:18:\"data_type_max_size\";s:2:\"11\";s:13:\"default_value\";s:1:\"1\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:7:\"add_new\";s:7:\"Add New\";}'),
	(3,1900,'login','127.0.0.1','2017-10-12 10:14:14','a:0:{}'),
	(4,'0','change_password_admin','127.0.0.1','2017-10-12 10:25:12','s:26:\"change password from admin\";'),
	(5,1900,'registration_field_activated','127.0.0.1','2017-10-12 10:29:20','a:1:{s:2:\"id\";s:1:\"1\";}'),
	(6,1900,'new_registration_field_added','127.0.0.1','2017-10-12 10:35:28','a:17:{s:12:\"edited_field\";s:0:\"\";s:10:\"field_name\";s:6:\"qweqwe\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"1\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:6:\"double\";s:18:\"data_type_max_size\";s:0:\"\";s:13:\"default_value\";s:3:\"111\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:7:\"add_new\";s:7:\"Add New\";}'),
	(7,1900,'logout','127.0.0.1','2017-10-12 11:08:23','a:0:{}'),
	(8,1900,'login','127.0.0.1','2017-10-12 11:10:03','a:0:{}'),
	(9,1900,'new_registration_field_added','127.0.0.1','2017-10-12 11:39:17','a:17:{s:12:\"edited_field\";s:0:\"\";s:10:\"field_name\";s:6:\"kkkkkk\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"2\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:6:\"double\";s:18:\"data_type_max_size\";s:0:\"\";s:13:\"default_value\";s:3:\"111\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:7:\"add_new\";s:7:\"Add New\";}'),
	(10,1900,'registration_field_updated','127.0.0.1','2017-10-12 11:39:38','a:17:{s:12:\"edited_field\";s:1:\"2\";s:10:\"field_name\";s:5:\"hhhhh\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"1\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:6:\"double\";s:18:\"data_type_max_size\";s:1:\"0\";s:13:\"default_value\";s:3:\"111\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:12:\"update_field\";s:6:\"Update\";}'),
	(11,1900,'registration_field_updated','127.0.0.1','2017-10-12 11:39:49','a:17:{s:12:\"edited_field\";s:1:\"3\";s:10:\"field_name\";s:6:\"jjjjjj\";s:15:\"required_status\";s:1:\"0\";s:13:\"register_step\";s:5:\"step1\";s:5:\"order\";s:1:\"2\";s:13:\"unique_status\";s:1:\"0\";s:10:\"data_types\";s:6:\"double\";s:18:\"data_type_max_size\";s:1:\"0\";s:13:\"default_value\";s:3:\"111\";s:10:\"field_type\";s:4:\"text\";s:12:\"radio_value1\";s:0:\"\";s:12:\"radio_value2\";s:0:\"\";s:14:\"select_option1\";s:0:\"\";s:14:\"select_option2\";s:0:\"\";s:14:\"select_option3\";s:0:\"\";s:14:\"select_option4\";s:0:\"\";s:12:\"update_field\";s:6:\"Update\";}'),
	(12,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 11:57:10','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:2:\"10\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(13,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:28:46','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"5\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(14,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:28:49','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:2:\"10\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(15,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:32:12','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"1\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(16,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:33:00','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"1\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(17,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:33:15','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"1\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(18,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:33:56','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"1\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(19,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:34:00','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(20,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:34:10','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(21,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:34:15','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"5\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(22,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 12:44:31','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"6\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(23,1900,'logout','127.0.0.1','2017-10-12 17:03:10','a:0:{}'),
	(24,1900,'login','127.0.0.1','2017-10-12 17:03:14','a:0:{}');

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
	('backup_deletion_period','6'),
	('backup_type','zip'),
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
  `data` varchar(40) NOT NULL DEFAULT 'NA',
  `date` datetime NOT NULL,
  `status` varchar(30) NOT NULL,
  `preferences` text,
  `file_status` varchar(30) NOT NULL DEFAULT 'active',
  `done_by` varchar(30) NOT NULL DEFAULT 'Cron Job',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_cron_job` (`id`, `cron_job`, `ip`, `data`, `date`, `status`, `preferences`, `file_status`, `done_by`) VALUES
	(1,'db_backup','127.0.0.1','db-1507736807.sql.gz','2017-09-11 00:00:00','Success',NULL,'active','Cron Job'),
	(2,'db_backup','127.0.0.1','db-1507736808.sql.gz','2017-09-11 00:00:00','Success',NULL,'active','Cron Job'),
	(3,'db_backup','127.0.0.1','db-1507736809.sql.gz','2017-09-11 00:00:00','Success',NULL,'active','Cron Job'),
	(4,'db_backup','127.0.0.1','db-1507736810.sql.gz','2017-10-11 21:16:50','Success',NULL,'active','Cron Job'),
	(5,'db_backup','127.0.0.1','db-1507736827.sql.gz','2017-10-11 21:17:07','Success',NULL,'active','Cron Job'),
	(6,'db_backup','127.0.0.1','db-1507738351.sql.gz','2017-10-11 21:42:31','Success',NULL,'active','Cron Job'),
	(7,'db_backup','127.0.0.1','db-1507793867.sql.gz','2017-10-12 13:07:47','Success',NULL,'active','Cron Job'),
	(8,'db_backup','127.0.0.1','db-1507793885.sql.gz','2017-10-12 13:08:05','Success',NULL,'active','Cron Job'),
	(9,'db_backup','127.0.0.1','db-1507794203.sql.gz','2017-10-12 13:13:23','Success',NULL,'active','Cron Job'),
	(10,'db_backup','127.0.0.1','db-1507794318.sql.gz','2017-10-12 13:15:18','Success',NULL,'active','Cron Job'),
	(11,'db_backup','127.0.0.1','db-1507794755.sql.gz','2017-10-12 13:22:35','Success',NULL,'active','Cron Job'),
	(12,'db_backup','127.0.0.1','db-1507794805.sql.gz','2017-10-12 13:23:25','Success',NULL,'active','Cron Job'),
	(13,'db_backup','127.0.0.1','db-1507794823.sql.gz','2017-10-12 13:23:43','Success',NULL,'active','Cron Job'),
	(14,'db_backup','127.0.0.1','db-1507794876.sql.gz','2017-10-12 13:24:36','Success',NULL,'active','Cron Job'),
	(15,'db_backup','127.0.0.1','db-1507795531.sql.gz','2017-10-12 13:35:31','Success',NULL,'active','Cron Job'),
	(16,'db_backup','127.0.0.1','db-1507796092.sql.gz','2017-10-12 13:44:52','Success',NULL,'active','Cron Job'),
	(17,'db_backup','127.0.0.1','db-1507797201.sql.gz','2017-10-12 14:03:21','Success',NULL,'active','Cron Job'),
	(18,'db_backup','127.0.0.1','db-1507797213.sql.gz','2017-10-12 14:03:33','Success',NULL,'active','Cron Job'),
	(19,'db_backup','127.0.0.1','db-1507797284.sql.gz','2017-10-12 14:04:44','Success',NULL,'active','Cron Job'),
	(20,'db_backup','127.0.0.1','db-1507797622.sql.gz','2017-10-12 14:10:22','Success',NULL,'active','Cron Job'),
	(21,'db_backup','127.0.0.1','db-1507797668.sql.gz','2017-10-12 14:11:08','Success',NULL,'active','Cron Job'),
	(22,'db_backup','127.0.0.1','db-1507797673.sql.gz','2017-10-12 14:11:13','Success',NULL,'active','Cron Job'),
	(23,'db_backup','127.0.0.1','db-1507797713.sql.gz','2017-10-12 14:11:53','Success',NULL,'active','Cron Job'),
	(24,'db_backup','127.0.0.1','db-1507797723.sql.gz','2017-10-12 14:12:03','Success',NULL,'active','Cron Job'),
	(25,'db_backup','127.0.0.1','db-1507797724.sql.gz','2017-10-12 14:12:04','Success',NULL,'active','Cron Job'),
	(26,'db_backup','127.0.0.1','db-1507797750.sql.gz','2017-10-12 14:12:30','Success',NULL,'active','Cron Job'),
	(27,'db_backup','127.0.0.1','db-1507797877.sql.gz','2017-10-12 14:14:37','Success',NULL,'active','Cron Job'),
	(28,'db_backup','127.0.0.1','db-1507797978.sql.gz','2017-10-12 14:16:17','Success',NULL,'active','Cron Job'),
	(29,'db_backup','127.0.0.1','db-1507798115.sql.gz','2017-10-12 14:18:35','Success',NULL,'active','Cron Job'),
	(30,'db_backup','127.0.0.1','db-1507798121.sql.gz','2017-10-12 14:18:41','Success',NULL,'active','Cron Job'),
	(31,'db_backup','127.0.0.1','db-1507798128.sql.gz','2017-10-12 14:18:48','Success',NULL,'active','Cron Job'),
	(32,'db_backup','127.0.0.1','db-1507798130.sql.gz','2017-10-12 14:18:50','Success',NULL,'active','Cron Job'),
	(33,'db_backup','127.0.0.1','db-1507798160.sql.gz','2017-10-12 14:19:20','Success',NULL,'active','Cron Job'),
	(34,'db_backup','127.0.0.1','db-1507800088.sql.gz','2017-10-12 14:51:28','Success',NULL,'active','admin'),
	(35,'db_backup','127.0.0.1','db-1507800129.sql.gz','2017-10-12 14:52:09','Success',NULL,'active','admin'),
	(36,'db_backup','127.0.0.1','db-1507800195.sql.gz','2017-10-12 14:53:15','Success',NULL,'active','admin'),
	(37,'db_backup','127.0.0.1','db-1507800267.sql.gz','2017-10-12 14:54:27','Success',NULL,'active','admin'),
	(38,'db_backup','127.0.0.1','db-1507800310.sql.gz','2017-10-12 14:55:10','Success',NULL,'active','admin'),
	(39,'db_backup','127.0.0.1','db-1507805659.sql.gz','2017-10-12 16:24:19','Success',NULL,'active','Admin'),
	(40,'db_backup','127.0.0.1','db-1507807330.sql.gz','2017-10-12 16:52:10','Success',NULL,'active','Admin'),
	(41,'db_backup','127.0.0.1','db-1507807359.sql.gz','2017-10-12 16:52:39','Success',NULL,'active','Admin'),
	(42,'db_backup','127.0.0.1','db-1507807407.sql.gz','2017-10-12 16:53:27','Success',NULL,'active','Admin'),
	(43,'db_backup','127.0.0.1','db-1507807420.sql.gz','2017-10-12 16:53:40','Success',NULL,'active','Admin'),
	(44,'db_backup','127.0.0.1','db-1507807515.sql.gz','2017-10-12 16:55:15','Success',NULL,'active','Admin'),
	(45,'db_backup','127.0.0.1','NA','2017-10-12 22:25:16','Started',NULL,'active','Cron Job');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES
	(1,'Dashboard','home','#','fa-home',1,1,1,1,NULL,1,'0'),
	(2,'Profile','profile','#','fa-user',1,1,1,1,NULL,1,'0'),
	(3,'New Register','registration','#','fa-user-plus',1,1,1,1,NULL,1,'0'),
	(4,'Register Field Configuration','configuration/set_register_fields','#','fa-bolt',1,'0',1,5,'null',1,'0'),
	(5,'Database Backup','backup','#','fa-database',1,'0',1,5,'null',1,'0');

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
  `payment_method` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_payment_methods` (`id`, `code`, `payment_method`, `status`) VALUES
	(1,'free_registration','Free Registration','inactive'),
	(2,'bank_transfer','Bank Transfer','inactive'),
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_register_fields` (`id`, `field_name`, `required_status`, `unique_status`, `register_step`, `order`, `default_value`, `status`, `editable_status`, `field_type`, `radio_value1`, `radio_value2`, `select_option1`, `select_option2`, `select_option3`, `select_option4`, `data_types`, `data_type_max_size`, `date`) VALUES
	(1,'qwe','0','0','step1',1,'1','deleted',1,'text','','','','','','','int',11,'2017-10-11 20:10:12'),
	(2,'hhhhh','0','0','step1',1,'111','inactive',1,'text','','','','','','','double','0','2017-10-12 10:35:28'),
	(3,'jjjjjj','0','0','step1',2,'111','active',1,'text','','','','','','','double','0','2017-10-12 11:39:17');

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
  `hhhhh` double DEFAULT NULL,
  `jjjjjj` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_user_details` (`id`, `mlm_user_id`, `first_name`, `last_name`, `address_1`, `address_2`, `city`, `district`, `state_id`, `country_id`, `ip`, `user_dp`, `date_of_joining`, `aaaa`, `bbbb`, `test`, `wer`, `ttttttt`, `sarath`, `jipin`, `jjjjjjjjjjj`, `uuuuuuu`, `kkkkkkkk`, `yyyyy`, `uuuuuu`, `techffodils`, `qwe`, `hhhhh`, `jjjjjj`) VALUES
	(1,1901,'hjghjghj','ghjghjghj','address1','address12','city','NA','0','0','NA','','2017-07-01 14:41:57',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(2,1902,'gfdfgd','fgdfgdfg','address1','address12','city','NA','0','0','NA','','2017-07-01 15:59:49',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,1904,'NA','NA','address1','address12','city','NA','0','0','NA','','2017-07-15 19:52:11',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,1905,'NA','NA','address1','address12','city','NA','0','0','NA','','2017-07-16 09:06:24',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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

