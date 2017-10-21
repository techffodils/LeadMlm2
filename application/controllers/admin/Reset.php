<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Reset extends Base_Controller {

    public function clean() {
        $this->loadView();
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
