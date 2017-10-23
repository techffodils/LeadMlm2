<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';


class Home extends Base_Controller{
	
	
function index(){

	$title = lang('home');
	$this->setData('title', $title);
	$this->setHeaderData(array('page_title'=>$title,'page_sub_title'=>$title,'page_header'=>$title,'page_header_small'=>$title));
	$this->loadView();
}

}
