<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();

        //$this->main->load_model();

        if (!in_array($this->main->get_controller(), NO_LOGIN_PAGES)) {
            $is_logged_in = $this->checkLogged('admin');
        } else {
            if($this->main->get_controller()=="login" && $this->main->get_method() == "index"){
                $this->checkPages();
            }
        }
    }

}
