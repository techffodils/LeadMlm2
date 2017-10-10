<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();
		
		$this->main->load_model();
	    $is_logged_in = false;
		
         if (!in_array($this->main->get_controller(), NO_LOGIN_PAGES)){
			 //echo 111;die;
            if ($this->main->get_controller() != 'register') {
				//echo $this->main->get_controller();die;
                $is_logged_in = $this->checkAdminLogged();
            } else {
				
                $is_logged_in = $this->checkLogged();
            }
        }else{
			if ($this->checkSession()) {
                    $is_logged_in = true;
                }
		}


}
}