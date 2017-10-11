<?php

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();

        if (!in_array($this->main->get_controller(), NO_LOGIN_PAGES)) {
            $this->checkLogged('user');
        } else {
            if ($this->main->get_controller() == "login" && $this->main->get_method() == "index") {
                $this->checkPages();
            }
        }
    }

}
