<?php

/**
 * @author Techffodils LLP
 * @date 2017-10-10
 * 
 */

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();
        $is_logged_in = false;

        if (!in_array($this->main->get_controller(), NO_LOGIN_PAGES)) {
            $is_logged_in = $this->checkLogged('user');
        } else {
            if($this->main->get_controller()=="login" && $this->main->get_method() == "index"){
                $this->checkPages();
            }
        }
    }

}
