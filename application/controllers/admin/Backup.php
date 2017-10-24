<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Backup extends Base_Controller {

    function index() {
        $backup_type = $this->dbvars->BACKUP_TYPE;
        $backup_deletion_period = $this->dbvars->BACKUP_DELETION_PERIOD;
        $backups = $this->backup_model->getLastBackups();

        $tab1 = 'active';
        $tab2 = $tab3 = '';	
        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('backup_type', $backup_type);
        $this->setData('backup_deletion_period', $backup_deletion_period);
        $this->setData('backups', $backups);
        $this->setData('title',lang('menu_name_41'));
        $this->loadView();
    }

    function validate_db_settings() {
        $this->form_validation->set_rules('backup_type', 'backup_type', 'required');
        $this->form_validation->set_rules('backup_deletion_period', 'backup_deletion_period', 'required|is_natural_no_zero');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function db_backup() {
        $res = $this->backup_model->dbBackup();
        if ($res) {
            $this->helper_model->insertActivity($this->LOG_USER_ID, 'db_backup_created');
            $data['response'] = 'yes';
            $data['done_by'] = 'Admin';
            $data['date'] = date("Y-m-d H:i:s");
            $data['file'] = $res;
            $path = "admin/backup/download_db/" . $res;
            $data['download'] = '<a href="' . $path . '"><i class="fa fa-download fa-fw"></i>"' . lang('download') . '"</a>';

            echo json_encode($data);
        } else {
            $data['response'] = 'no';
            echo json_encode($data);
        }
        exit;
    }

    function download_db($file_name = "") {
        if ($file_name) {
            $path = FCPATH . "application/backup/" . $file_name;
            $this->load->helper('download');
            force_download($path, NULL);
        }
    }

    function change_settings() {
        $post = $this->input->get();
        if ($post['backup_deletion_period'] && $post['backup_type']) {
            $backup_deletion_period = $this->dbvars->BACKUP_DELETION_PERIOD = $post['backup_deletion_period'];
            $backup_type = $this->dbvars->BACKUP_TYPE = $post['backup_type'];

            if ($this->helper_model->insertActivity($this->LOG_USER_ID, 'db_backup_settings_changed', $post)) {
                $this->backup_model->deleteOlderBackup($backup_deletion_period);
                echo 'yes';exit;
            }
        }
        echo 'no';
        exit;
    }

    function test() {
        $filename = "db-1508237967.sql";
        $filename = FCPATH . "application/backup/" . $filename;
        $mysql_host = $this->db->hostname;
        $mysql_username = $this->db->username;
        $mysql_password = $this->db->password;
        $db_database = 'mlm';

        //Drop all tables
        $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
        $mysqli->query('SET foreign_key_checks = 0');
        if ($result = $mysqli->query("SHOW TABLES")) {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $mysqli->query('DROP TABLE IF EXISTS ' . $row[0]);
            }
        }
        $mysqli->query('SET foreign_key_checks = 1');

        //Import all tables
        mysqli_select_db($mysqli, $mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
        $templine = '';
        $lines = file($filename);
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                mysqli_query($mysqli, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                $templine = '';
            }
        }
        $mysqli->close();
    }

}
