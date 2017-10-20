<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'user/Base_Controller.php';

class Epin extends Base_Controller {

    function __construct() {

        parent::__construct();
    }
/**
 * For Epin Request 
 * @author Techffodils
 * @date 2017-10-18
 */
    function epin_request() {
        $title = "Epin Request";
        $this->setData('title', $this->main->get_controller().'|'.$value);
        $this->loadView();
        }

    function view_my_epin() {
        
    }

}
