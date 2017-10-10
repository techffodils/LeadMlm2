<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';
class Member extends Base_Controller {
    

    function change_password() {
        $title = "Change Password";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Change Password');
        $this->loadView();
    }
    function change_username() {
        $title = "Change User Name";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Change User Name');
        $this->loadView();
    }
    
    

}
