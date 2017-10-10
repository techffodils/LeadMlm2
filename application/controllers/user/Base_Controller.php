<?php 
/*
@Author :: Techffodil LLP
@Date :: 2017-10-09
*/

class Base_Controller extends Core_Base_Controller {

    function __construct() {

     parent::__construct();
      $is_logged_in = false;
		
         if (!in_array($this->main->get_controller(), NO_LOGIN_PAGES)){
			 //echo 111;die;
            if ($this->main->get_controller() != 'register') {
				//echo $this->main->get_controller();die;
                $is_logged_in = $this->checkUserLogged();
            } else {
				
                $is_logged_in = $this->checkLogged();
            }
        }else{
			if ($this->checkSession()) {
                    $is_logged_in = true;
                }
		}

}