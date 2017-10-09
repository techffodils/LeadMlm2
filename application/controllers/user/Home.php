<?php


defined('BASEPATH') OR exit('No direct script access allowed');
/**
@Author Techffodils
@date 2017-10-9;
*/
require_once 'Base_Controller.php';

class Home extends Base_Controller{

	/**
	*@Author Techffodils
	*@Date 2017-10-9
	*/
	function index(){
		$this->loadView();
	}
}