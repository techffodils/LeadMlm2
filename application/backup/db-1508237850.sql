

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

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
	(24,1900,'login','127.0.0.1','2017-10-12 17:03:14','a:0:{}'),
	(25,1900,'db_backup_settings_changed','127.0.0.1','2017-10-12 22:25:57','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(26,1900,'login','127.0.0.1','2017-10-13 09:43:05','a:0:{}'),
	(27,1900,'plan_settings_changed','127.0.0.1','2017-10-13 11:04:57','a:3:{s:10:\"pair_bonus\";s:1:\"5\";s:13:\"referal_bonus\";s:1:\"5\";s:14:\"bonus_settings\";s:14:\"bonus_settings\";}'),
	(28,1900,'payment_status_changes','127.0.0.1','2017-10-13 11:05:00','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:6:\"active\";}'),
	(29,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 11:05:02','a:1:{s:6:\"status\";s:6:\"active\";}'),
	(30,1900,'plan_settings_changed','127.0.0.1','2017-10-13 11:05:27','a:2:{s:12:\"register_leg\";s:8:\"balanced\";s:12:\"leg_settings\";s:12:\"leg_settings\";}'),
	(31,1900,'payment_status_changes','127.0.0.1','2017-10-13 13:00:47','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:6:\"active\";}'),
	(32,1900,'payment_status_changes','127.0.0.1','2017-10-13 13:50:09','a:2:{s:4:\"code\";s:1:\"1\";s:6:\"status\";s:8:\"inactive\";}'),
	(33,1900,'login','127.0.0.1','2017-10-13 17:08:37','a:0:{}'),
	(34,1900,'db_backup_created','127.0.0.1','2017-10-13 20:54:55','a:0:{}'),
	(35,1900,'payment_status_changes','127.0.0.1','2017-10-13 20:55:08','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:8:\"inactive\";}'),
	(36,1900,'reg_form_type_changes','127.0.0.1','2017-10-13 20:55:42','a:1:{s:6:\"status\";s:8:\"multiple\";}'),
	(37,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:55:47','a:1:{s:6:\"status\";s:8:\"inactive\";}'),
	(38,1900,'payment_status_changes','127.0.0.1','2017-10-13 20:55:55','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:8:\"inactive\";}'),
	(39,1900,'payment_status_changes','127.0.0.1','2017-10-13 20:56:00','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:6:\"active\";}'),
	(40,1900,'payment_status_changes','127.0.0.1','2017-10-13 20:56:02','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:6:\"active\";}'),
	(41,1900,'payment_status_changes','127.0.0.1','2017-10-13 20:56:04','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:8:\"inactive\";}'),
	(42,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:56:09','a:1:{s:6:\"status\";s:6:\"active\";}'),
	(43,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:56:13','a:1:{s:6:\"status\";s:8:\"inactive\";}'),
	(44,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:57:19','a:1:{s:6:\"status\";s:6:\"active\";}'),
	(45,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:57:21','a:1:{s:6:\"status\";s:8:\"inactive\";}'),
	(46,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:57:36','a:1:{s:6:\"status\";s:6:\"active\";}'),
	(47,1900,'reg_field_config_changes','127.0.0.1','2017-10-13 20:57:38','a:1:{s:6:\"status\";s:8:\"inactive\";}'),
	(48,1900,'login','127.0.0.1','2017-10-17 11:41:09','a:0:{}'),
	(49,1900,'db_backup_created','127.0.0.1','2017-10-17 11:43:55','a:0:{}'),
	(50,1900,'payment_status_changes','127.0.0.1','2017-10-17 11:44:12','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:8:\"inactive\";}'),
	(51,1900,'payment_status_changes','127.0.0.1','2017-10-17 11:44:16','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:6:\"active\";}'),
	(52,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 11:44:41','a:1:{s:6:\"status\";s:6:\"single\";}'),
	(53,1900,'db_backup_created','127.0.0.1','2017-10-17 12:47:04','a:0:{}'),
	(54,1900,'db_backup_created','127.0.0.1','2017-10-17 12:47:11','a:0:{}'),
	(55,1900,'db_backup_created','127.0.0.1','2017-10-17 12:47:38','a:0:{}'),
	(56,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 12:49:19','a:1:{s:6:\"status\";s:8:\"multiple\";}'),
	(57,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:49:27','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:8:\"inactive\";}'),
	(58,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:50:31','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:6:\"active\";}'),
	(59,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:50:35','a:2:{s:4:\"code\";s:7:\"ewallet\";s:6:\"status\";s:8:\"inactive\";}'),
	(60,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:50:39','a:2:{s:4:\"code\";s:7:\"ewallet\";s:6:\"status\";s:6:\"active\";}'),
	(61,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:50:40','a:2:{s:4:\"code\";s:7:\"ewallet\";s:6:\"status\";s:8:\"inactive\";}'),
	(62,1900,'payment_status_changes','127.0.0.1','2017-10-17 12:50:43','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:8:\"inactive\";}'),
	(63,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 12:50:48','a:1:{s:6:\"status\";s:6:\"single\";}'),
	(64,1900,'db_backup_created','127.0.0.1','2017-10-17 12:53:22','a:0:{}'),
	(65,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 12:56:17','a:1:{s:6:\"status\";s:8:\"multiple\";}'),
	(66,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 12:56:21','a:1:{s:6:\"status\";s:6:\"single\";}'),
	(67,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 12:56:23','a:1:{s:6:\"status\";s:8:\"multiple\";}'),
	(68,1900,'db_backup_created','127.0.0.1','2017-10-17 12:56:28','a:0:{}'),
	(69,1900,'db_backup_settings_changed','127.0.0.1','2017-10-17 13:08:01','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(70,1900,'db_backup_settings_changed','127.0.0.1','2017-10-17 13:12:12','a:3:{s:11:\"backup_type\";s:3:\"zip\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(71,1900,'db_backup_settings_changed','127.0.0.1','2017-10-17 13:12:16','a:3:{s:11:\"backup_type\";s:3:\"sql\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(72,1900,'db_backup_created','127.0.0.1','2017-10-17 13:12:20','a:0:{}'),
	(73,1900,'db_backup_created','127.0.0.1','2017-10-17 13:12:23','a:0:{}'),
	(74,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 13:12:30','a:1:{s:6:\"status\";s:6:\"single\";}'),
	(75,1900,'reg_field_config_changes','127.0.0.1','2017-10-17 13:12:33','a:1:{s:6:\"status\";s:6:\"active\";}'),
	(76,1900,'payment_status_changes','127.0.0.1','2017-10-17 13:12:35','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:6:\"active\";}'),
	(77,1900,'db_backup_created','127.0.0.1','2017-10-17 13:15:05','a:0:{}'),
	(78,1900,'db_backup_created','127.0.0.1','2017-10-17 13:15:18','a:0:{}'),
	(79,1900,'payment_status_changes','127.0.0.1','2017-10-17 13:22:50','a:2:{s:4:\"code\";s:13:\"bank_transfer\";s:6:\"status\";s:6:\"active\";}'),
	(80,1900,'payment_status_changes','127.0.0.1','2017-10-17 13:22:53','a:2:{s:4:\"code\";s:7:\"ewallet\";s:6:\"status\";s:6:\"active\";}'),
	(81,1900,'reg_form_type_changes','127.0.0.1','2017-10-17 13:22:59','a:1:{s:6:\"status\";s:8:\"multiple\";}'),
	(82,1900,'product_added','127.0.0.1','2017-10-17 13:44:14','a:7:{s:12:\"product_name\";s:9:\"dfgdfgdfg\";s:14:\"product_amount\";s:2:\"33\";s:10:\"product_pv\";s:2:\"44\";s:12:\"product_code\";s:9:\"dfgdfgdfg\";s:14:\"recurring_type\";s:7:\"monthly\";s:12:\"product_type\";s:10:\"repurchase\";s:11:\"add_product\";s:11:\"add_product\";}'),
	(83,1900,'product_updated','127.0.0.1','2017-10-17 15:06:12','a:8:{s:12:\"product_name\";s:4:\"qqqq\";s:14:\"product_amount\";s:2:\"11\";s:10:\"product_pv\";s:3:\"111\";s:12:\"product_code\";s:6:\"qweqwe\";s:14:\"recurring_type\";s:0:\"\";s:12:\"product_type\";s:8:\"register\";s:9:\"edited_id\";s:1:\"2\";s:14:\"update_product\";s:14:\"update_product\";}'),
	(84,1900,'product_updated','127.0.0.1','2017-10-17 15:06:27','a:8:{s:12:\"product_name\";s:4:\"qqqq\";s:14:\"product_amount\";s:2:\"11\";s:10:\"product_pv\";s:3:\"111\";s:12:\"product_code\";s:6:\"qweqwe\";s:14:\"recurring_type\";s:7:\"monthly\";s:12:\"product_type\";s:8:\"register\";s:9:\"edited_id\";s:1:\"2\";s:14:\"update_product\";s:14:\"update_product\";}'),
	(85,1900,'product_updated','127.0.0.1','2017-10-17 15:12:00','a:8:{s:12:\"product_name\";s:4:\"Test\";s:14:\"product_amount\";s:2:\"11\";s:10:\"product_pv\";s:2:\"11\";s:12:\"product_code\";s:7:\"aaaasss\";s:14:\"recurring_type\";s:6:\"yearly\";s:12:\"product_type\";s:8:\"register\";s:9:\"edited_id\";s:1:\"1\";s:14:\"update_product\";s:14:\"update_product\";}'),
	(86,1900,'product_inactivate','127.0.0.1','2017-10-17 15:12:08','a:1:{s:10:\"product_id\";s:1:\"1\";}'),
	(87,1900,'product_inactivate','127.0.0.1','2017-10-17 15:12:12','a:1:{s:10:\"product_id\";s:1:\"4\";}'),
	(88,1900,'product_deleted','127.0.0.1','2017-10-17 15:12:20','a:1:{s:10:\"product_id\";s:1:\"2\";}'),
	(89,1900,'product_deleted','127.0.0.1','2017-10-17 15:12:59','a:1:{s:10:\"product_id\";s:1:\"7\";}'),
	(90,1900,'product_inactivate','127.0.0.1','2017-10-17 15:13:07','a:1:{s:10:\"product_id\";s:1:\"6\";}'),
	(91,1900,'product_inactivate','127.0.0.1','2017-10-17 15:17:27','a:1:{s:10:\"product_id\";s:1:\"5\";}'),
	(92,1900,'product_added','127.0.0.1','2017-10-17 15:21:16','a:7:{s:12:\"product_name\";s:7:\"dfgdfgd\";s:14:\"product_amount\";s:2:\"11\";s:10:\"product_pv\";s:5:\"34535\";s:12:\"product_code\";s:8:\"dfgdfgdf\";s:14:\"recurring_type\";s:7:\"monthly\";s:12:\"product_type\";s:8:\"register\";s:11:\"add_product\";s:11:\"add_product\";}'),
	(93,1900,'payment_status_changes','127.0.0.1','2017-10-17 15:32:41','a:2:{s:4:\"code\";s:17:\"free_registration\";s:6:\"status\";s:8:\"inactive\";}'),
	(94,1900,'product_activate','127.0.0.1','2017-10-17 15:33:05','a:1:{s:10:\"product_id\";s:1:\"6\";}'),
	(95,1900,'product_inactivate','127.0.0.1','2017-10-17 15:33:11','a:1:{s:10:\"product_id\";s:1:\"3\";}'),
	(96,1900,'product_activate','127.0.0.1','2017-10-17 15:33:15','a:1:{s:10:\"product_id\";s:1:\"5\";}'),
	(97,1900,'db_backup_settings_changed','127.0.0.1','2017-10-17 15:57:10','a:3:{s:11:\"backup_type\";s:3:\"sql\";s:22:\"backup_deletion_period\";s:1:\"3\";s:11:\"db_settings\";s:11:\"db_settings\";}'),
	(98,1900,'db_backup_created','127.0.0.1','2017-10-17 16:26:13','a:0:{}');

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
	('BACKUP_DELETION_PERIOD','3'),
	('BACKUP_TYPE','sql'),
	('BLOCK_ECOMMERCE','0'),
	('BLOCK_LOGIN','0'),
	('BLOCK_REGISTER','0'),
	('COMPANY_NAME','Company'),
	('DEFAULT_CURRENCY_CODE','EUR'),
	('DEFAULT_CURRENCY_VALUE','1'),
	('DEFAULT_SYMBOL_LEFT','$'),
	('DEFAULT_SYMBOL_RIGHT',''),
	('FROM_MOBILE','0'),
	('LANG_ID','1'),
	('LANG_NAME','english'),
	('MAINTENANCE_MODE','0'),
	('MATRIX_DEPTH','5'),
	('MATRIX_WIDTH','5'),
	('MLM_PLAN','BINARY'),
	('MULTI_CURRENCY_STATUS','active'),
	('OPTIONAL_MODULE','0'),
	('PAIR_BONUS','5'),
	('REFEAL_BONUS','5'),
	('REGISTER_FIELD_CONFIGURATION','active'),
	('REGISTER_FORM_TYPE','multiple'),
	('REGISTER_LEG','balanced'),
	('SESS_STATUS','0'),
	('TABLE_PREFIX','mlm_'),
	('USERNAME_PREFIX','lead'),
	('USERNAME_SIZE','8'),
	('USERNAME_TYPE','dynamic');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_cron_job` (`id`, `cron_job`, `ip`, `data`, `date`, `status`, `preferences`, `file_status`, `done_by`) VALUES
	(1,'db_backup','127.0.0.1','NA','2017-10-17 16:27:30','Started',NULL,'active','Admin');

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
  `currency_code` varchar(30) NOT NULL,
  `currency_name` varchar(30) NOT NULL,
  `symbol_left` varchar(30) NOT NULL,
  `symbol_right` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `currency_ratio` decimal(16,8) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `icon` varchar(30) NOT NULL,
  `conversion_status` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_currencies` (`id`, `currency_code`, `currency_name`, `symbol_left`, `symbol_right`, `currency_ratio`, `status`, `icon`, `conversion_status`) VALUES
	(1,'USD','Dollar','$','',1.00000000,'1','fa-dollar','yes'),
	(2,'EUR','Euro','$','',0.84674000,'1','fa-eur','yes'),
	(3,'JPY','Yen ','$','',112.18000000,'0','fa-jpy','yes'),
	(4,'GBP','Pound ','','',0.75343000,'0','fa-gbp','yes'),
	(5,'INR','Rupee','','',64.95500000,'0','fa-rupee','yes'),
	(6,'RUB','Ruble','','',57.68000000,'0','fa-rouble','yes'),
	(7,'TRY','Turkish','','',3.66000000,'0','fa-try','yes'),
	(8,'KRW','Won','','',1129.50000000,'0','fa-krw','yes'),
	(9,'BTC','Bitcoin','$','',0.00017319,'0','fa-bitcoin','yes');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_languages` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(30) NOT NULL,
  `lang_name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lang_eng_name` varchar(30) NOT NULL,
  `lang_flag` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_languages` (`id`, `lang_code`, `lang_name`, `status`, `lang_eng_name`, `lang_flag`) VALUES
	(1,'en','English',1,'',''),
	(2,'fr','French',1,'',''),
	(3,'mal','Malayalam','0','',''),
	(4,'jp','Japanese','0','',''),
	(5,'ch','Chinese','0','','');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_menus` (`id`, `name`, `link`, `root_id`, `icon`, `admin_permission`, `user_permission`, `employee_permission`, `order`, `target`, `status`, `lock`) VALUES
	(1,'Dashboard','home','#','fa-home',1,1,1,1,NULL,1,'0'),
	(2,'Profile','profile','#','fa-user',1,1,1,1,NULL,1,'0'),
	(3,'New Register','registration','#','fa-user-plus',1,1,1,1,NULL,1,'0'),
	(4,'Register Field Configuration','configuration/set_register_fields','#','fa-bolt',1,'0',1,5,'null',1,'0'),
	(5,'Database Backup','backup','#','fa-database',1,'0',1,5,'null',1,'0'),
	(6,'Plan Settings','configuration/plan_settings','#','fa fa-barcode',1,'0',1,5,NULL,1,'0'),
	(7,'Language & Currency','configuration/multiple_options','#','fa fa-venus-double',1,'0',1,7,NULL,1,'0'),
	(8,'Product Management','product/product_management','#','fa fa-tags',1,'0',1,8,NULL,1,'0');

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
	(2,'bank_transfer','Bank Transfer','active'),
	(3,'ewallet','Ewallet','active'),
	(4,'epin','Epin','inactive');

-- ------------------------------------------------ 



CREATE TABLE IF NOT EXISTS `mlm_products` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(30) NOT NULL,
  `product_amount` double NOT NULL,
  `product_pv` double NOT NULL,
  `product_code` varchar(30) NOT NULL,
  `image` text NOT NULL,
  `recurring_type` varchar(30) NOT NULL,
  `product_type` varchar(30) NOT NULL DEFAULT 'register',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_products` (`id`, `product_name`, `product_amount`, `product_pv`, `product_code`, `image`, `recurring_type`, `product_type`, `status`) VALUES
	(1,'Test',11,11,'aaaasss','','yearly','register','0'),
	(3,'wwww',11,11,'aaaasss','','NA','register','0'),
	(4,'eeee',11,11,'aaaasss','','NA','register','0'),
	(5,'rrrr',11,11,'aaaasss','','NA','register',1),
	(6,'tttt',11,11,'aaaasss','','NA','register',1),
	(8,'dfgdfgd',11,34535,'dfgdfgdf','','monthly','register',1);

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



CREATE TABLE IF NOT EXISTS `mlm_theam_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `color_scheama` varchar(50) NOT NULL DEFAULT 'assets/css/themes/theme_default',
  `layout` varchar(20) DEFAULT NULL,
  `header` varchar(20) NOT NULL DEFAULT 'header-fixed',
  `footer` varchar(20) NOT NULL DEFAULT 'footer-default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_theam_settings` (`id`, `user_id`, `color_scheama`, `layout`, `header`, `footer`) VALUES
	(1,1900,'assets/css/themes/theme-style6.css',NULL,'header-fixed','footer-default');

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
  `language` tinyint(4) NOT NULL DEFAULT '1',
  `currency` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `mlm_user` (`id`, `mlm_user_id`, `user_name`, `email`, `password`, `user_type`, `position`, `father_id`, `sponsor_id`, `user_left`, `user_right`, `user_left_carry`, `user_right_carry`, `user_status`, `date`, `language`, `currency`) VALUES
	(1,1900,'admin','admin@lead.in','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','admin','','0','0','0','0','0','0','active',NULL,1,1),
	(5,1901,'asdasdasd','asdasd@fghf.dgd','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','user','L',1900,1900,'0','0','0','0','active','2017-07-01 14:41:57',1,1),
	(6,1902,'ddddddddd','ghjghjgh!@qwe.fgh','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12','user','L',1900,1900,'0','0','0','0','active','2017-07-01 15:59:49',1,1),
	(7,1903,'asdasds','sdfsdf!@qwe.fgh','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b83','user','L',1900,1900,'0','0','0','0','active','2017-07-15 19:50:58',1,1),
	(8,1904,'oooooooo','asd!@qwe.fghf','96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b83','user','L',1900,1900,'0','0','0','0','active','2017-07-15 19:52:11',1,1),
	(9,1905,'jipinu','hjghj@hjk.ghj','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12','user','R',1900,1900,'0','0','0','0','active','2017-07-16 09:06:24',1,1);

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

