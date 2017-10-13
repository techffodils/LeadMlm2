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
		$title="Home";
		$this->setData('title',$title.'|'.$this->main->get_controller() .'::');
		
		$this->BREADCRUM_DATA=array('page_title'=>$title,'page_sub_title'=>$title,'page_header'=>$title,'page_header_small'=>$title);
		
		$this->set_header_lang();
		
		$this->loadView();
	}
}
