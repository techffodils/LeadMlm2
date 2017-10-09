<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();

        
        
if(($this->main->get_usersession('is_logged_in') && $this->main->get_controller() == 'login')){
	 if($this->main->get_usersession('mlm_user_type')=='admin'){
		  $this->loadPage('', 'home');
	      }
           
        }
        
    }

}