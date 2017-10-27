<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';
class Home extends Base_Controller{
		
function index(){

	$title = lang('home');
	$this->setData('title', $title);
	$this->loadView();
}

}



