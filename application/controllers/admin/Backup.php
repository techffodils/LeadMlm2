<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Backup extends Base_Controller {

    function index() {
        if(isset($this->dbvars->backup_type)){
            $backup_type=$this->dbvars->backup_type;
        }else{
            $backup_type=$this->dbvars->backup_type = '';
        }
        
        if(isset($this->dbvars->backup_deletion_period)){
            $backup_deletion_period=$this->dbvars->backup_deletion_period;
        }else{
            $backup_deletion_period=$this->dbvars->backup_deletion_period = '30';
        }
        
        if ($this->input->post('db_settings') && $this->validate_db_settings()) {
            $post=$this->input->post();
            $backup_deletion_period=$this->dbvars->backup_deletion_period = $post['backup_deletion_period'];
            $backup_type=$this->dbvars->backup_type = $post['backup_type'];
            
            if($this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'db_backup_settings_changed',$post)){
                $this->backup_model->deleteOlderBackup($backup_deletion_period);
                $this->loadPage('Database Settings Changed', 'backup', TRUE);
            }else{
                $this->loadPage('Failed To Update', 'backup', False);
            }
            
        }
        $tab1 = 'active';
        $tab2 = $tab3 = '';
        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('backup_type', $backup_type);
        $this->setData('backup_deletion_period', $backup_deletion_period);
        $this->loadView();
    }
    
    function validate_db_settings() {
        $this->form_validation->set_rules('backup_type', 'backup_type', 'required');
        $this->form_validation->set_rules('backup_deletion_period', 'backup_deletion_period', 'required|is_natural_no_zero');        
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

}
