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

            if ($this->main->get_controller() != 'register') {

                $is_logged_in = $this->checkUserLogged();
            } else {

                $is_logged_in = $this->checkLogged();
            }
        } else {
            if ($this->checkSession()) {
                if (($this->main->get_usersession('is_logged_in'))) {
                    if ($this->main->get_usersession('mlm_user_type') == 'user') {
                        $this->loadPage('', 'home');
                    }
                }
            }
        }
    }

}
