<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';


class Home extends Base_Controller{
	
	
	function index(){
		
		
		
		$this->setData('site_title','Home');
		$this->setData('header','Home');
		
			$this->loadView();
	}
	
	
}
