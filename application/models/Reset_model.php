<?php

class Reset_model extends CI_Model {

    function wipeOutAllData() {
        $res=$this->cleanAllTables();
        if($res){
            $this->resetDbVars();
            return $res;
        }
    }

    function cleanAllTables() {
        
        
        $tables = array();
        $database_name = $this->db->database;
        $dbprefix = $this->db->dbprefix;

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '$dbprefix%' ");

        foreach ($table_query->result_array() AS $rows) {
            $tables[] = $rows['TABLE_NAME'];
        }


        $user_details = $this->getAdminDetails();
        $admin_id = $this->helper_model->getAdminId();
               
        
        if (in_array($dbprefix . 'user', $tables)) {
            $this->db->truncate('user');
            $user = $dbprefix . "user";
            $this->db->query("ALTER TABLE $user AUTO_INCREMENT=$admin_id");
            $this->db->insert('user', $user_details);
        }

        if (in_array($dbprefix . 'user_details', $tables)) {
            $user_data = $this->getUserData($admin_id);
            $this->db->truncate('user_details');
            $this->db->insert('user_details', $user_data);
        }

        if (in_array($dbprefix . 'user_balance', $tables)) {
            $this->db->truncate('user_balance');
            $user_balance_details = array(
                'mlm_user_id' => $admin_id,
                'balance_amount' => '0',
                'total_amount' => '0',
                'released_amount' => '0'
            );
            $this->db->insert('user_balance', $user_balance_details);
        }

        if (in_array($dbprefix . 'theme_settings', $tables)) {
            $this->db->truncate('theme_settings');
            $theme_settings_details = array(
                'user_id' => $admin_id
            );
            $this->db->insert('theme_settings', $theme_settings_details);
        }

        if (in_array($dbprefix . 'activity', $tables)) {
            $this->db->truncate('activity');
        }
        if (in_array($dbprefix . 'chat_history', $tables)) {
            $this->db->truncate('chat_history');
        }
        if (in_array($dbprefix . 'commission_details', $tables)) {
            $this->db->truncate('commission_details');
        }
        if (in_array($dbprefix . 'curl_history', $tables)) {
            $this->db->truncate('curl_history');
        }
        if (in_array($dbprefix . 'order_details', $tables)) {
            $this->db->truncate('order_details');
        }
        if (in_array($dbprefix . 'rank_history', $tables)) {
            $this->db->truncate('rank_history');
        }
        if (in_array($dbprefix . 'register_history', $tables)) {
            $this->db->truncate('register_history');
        }
        if (in_array($dbprefix . 'temp_reg', $tables)) {
            $this->db->truncate('temp_reg');
        }
        if (in_array($dbprefix . 'wallet_details', $tables)) {
            $this->db->truncate('wallet_details');
        }
        if (in_array($dbprefix . 'wallet_transfer', $tables)) {
            $this->db->truncate('wallet_transfer');
        }
        return TRUE;
    }

    function resetDbVars() {
        //Unset all Config Variables
        $query = $this->db->select('key')
                        ->from('config')
                        ->get();
        foreach ($query->result() as $row) {
            $key = $row->key;
            $this->dbvars->__unset($key);
        }
        $this->db->truncate('config');
        
        //Resett All Config Variables
        $this->dbvars->MLM_PLAN = 'BINARY'; //MATRIX,UNILEVEL,DONATION,INVESTMENT,MONOLINE,GENERATION
        $this->dbvars->MAINTENANCE_MODE = 0;
        $this->dbvars->DEFAULT_CURRENCY_CODE = 'USD';
        $this->dbvars->DEFAULT_CURRENCY_ICON = 'fa-usd';
        $this->dbvars->DEFAULT_CURRENCY_NAME = 'Doller';
        $this->dbvars->DEFAULT_CURRENCY_VALUE = 1;
        $this->dbvars->DEFAULT_SYMBOL_LEFT = '$';
        $this->dbvars->DEFAULT_SYMBOL_RIGHT = '';

        $this->dbvars->LANG_FLAG = 'IN.png';
        $this->dbvars->LANG_ID= 1;
        $this->dbvars->LANG_NAME = 'English';
        $this->dbvars->LANG_COD 'en';

        $this->dbvars->TABLE_PREFIX = 'mlm_';

        $this->dbvars->MULTI_CURRENCY_STATUS = 1; //0
        $this->dbvars->MULTI_LANGUAGE_STATUS = 1; //0
        //Backup
        $this->dbvars->BACKUP_TYPE = 'zip'; //zip,sql
        $this->dbvars->BACKUP_DELETION_PERIOD = '30';

        //Register
        $this->dbvars->REGISTER_FORM_TYPE = 'multiple';
        $this->dbvars->REGISTER_FIELD_CONFIGURATION = '0'; //1

        $this->dbvars->REGISTER_LEG = 'dynamic'; //balanced,left,right
        $this->dbvars->USERNAME_TYPE = 'static'; //dynamic
        $this->dbvars->USERNAME_PREFIX = 'lead';
        $this->dbvars->USERNAME_SIZE = 10;

        $this->dbvars->PAIR_BONUS = 10;
        $this->dbvars->REFEAL_BONUS = 25;
        $this->dbvars->MATRIX_WIDTH = 3;
        $this->dbvars->MATRIX_DEPTH = 3;

        $this->dbvars->ADMIN_USER_ID = $this->helper_model->getAdminId();
        $this->dbvars->ADMIN_USER_ID = 'admin';

        $this->dbvars->BLOCK_LOGIN =0;
        $this->dbvars->BLOCK_REGISTER =0;
        $this->dbvars->MAINTENANCE_MODE =0;

        return 1;
    }

    function getAdminDetails() {

        $data = array();
        $res = $this->db->select("user_name,email,password,user_type,user_status,date,language,currency")
                ->from("user")
                ->where("user_type", 'admin')
                ->limit(1)
                ->get();
        foreach ($res->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

    function getUserData($user_id) {

        $data = array();
        $res = $this->db->select("*")
                ->from("user_details")
                ->where("mlm_user_id", $user_id)
                ->limit(1);
                ->get();
        foreach ($res->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

}
