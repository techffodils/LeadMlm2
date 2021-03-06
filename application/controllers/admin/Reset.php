<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Reset extends Base_Controller {

    public function clean() {
        $this->setData('title',lang('menu_name_40'));
        $this->loadView();
    }
    
    public function reset_dbvars() {
        $res=$this->reset_model->resetDbVars();
    }

    public function wipe() {
        if ($this->input->get('wipe_status')) {
            $res=$this->reset_model->wipeOutAllData();
            if($res){
                echo 'yes';
            }else{
                echo 'no';
            }
            exit();
        }
        die('Invalid Data');
    }

}
