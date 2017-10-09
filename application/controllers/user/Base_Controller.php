<?php 


class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();

        //$is_logged_in = false;
        
      if($this->main->get_usersession('is_logged_in') && $this->main->get_controller() == 'login'&& $this->main->get_usersession('mlm_user_type')=='user'){

            $this->loadPage('', 'home');
        }
        
    }

}