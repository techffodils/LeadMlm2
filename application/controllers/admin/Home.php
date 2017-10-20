<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';


class Home extends Base_Controller{
	
	
	function index(){
		
		$title = lang('home');
/*
echo $title;die();*/

$this->setData('title', $title.'|'.$this->main->get_controller() .'::');

$this->BREADCRUM_DATA=array('page_title'=>$title,'page_sub_title'=>$title,'page_header'=>$title,'page_header_small'=>$title);

$this->set_header_lang();

$this->loadView();
}



function changeThemeSettings(){
	$res =false;
	$data = json_decode(stripslashes($this->input->post('result')),true);
	$user_id=$this->main->get_usersession('mlm_user_id');
	$res = $this->home_model->themeChange($data,$user_id);

	if($res){

		$theme = array(
			'color_scheama' =>$data["skinClass"],
			'header' => $data['headerDefault'],
			'footer' => $data['footerDefault'],
			'layout' => $data['layoutBoxed'],
			'body_class' => $data['headerDefault'].' '.$data['footerDefault'].' '.$data['layoutBoxed']
		);

		$this->session->set_userdata('mlm_theme_details',$theme);
	}

	echo $res;
	exit();
}

function changeCurrencySettings(){

	$res = false;
	$currency_code = stripslashes($this->input->post('currency_code'));
	$user_id = $this->main->get_usersession('mlm_user_id');

	$currency_details = $this->home_model->currencyDetailsFromCode($currency_code);

	$mlm_currency = $this->session->userdata("mlm_data_currency");
	$res = $this->home_model->changeUserCurrency($user_id,$currency_details['id']);
	if($res){

			$currency_data = $this->session->userdata("mlm_data_currency");

			$currency_data['currency_ratio'] = $currency_details['currency_ratio'];
			$currency_data['currency_name'] = $currency_details['currency_name'];
			$currency_data['currency_code'] = $currency_details['currency_code'];
			$currency_data['symbol_left'] = $currency_details['symbol_left'];
			$currency_data['symbol_right'] = $currency_details['symbol_right'];
			$currency_data['icon'] = $currency_details['icon'];
			$currency_data['currency_list'] = $mlm_currency['currency_list'];

			$this->session->set_userdata("mlm_data_currency",$currency_data);
		}

	echo $res;
	exit();
}


function changeLanguageSettings(){

	$res = false;
	$lang_code = stripslashes($this->input->post('lang_code'));
	$user_id = $this->main->get_usersession('mlm_user_id');

	$lang_details = $this->home_model->langDetailsFromCode($lang_code);

	$mlm_language = $this->session->userdata("mlm_data_language");
	$res = $this->home_model->changeUserLanguage($user_id,$lang_details['id']);
	if($res){

		   $lang_data = $this->session->userdata("mlm_data_language");

	       $lang_list['lang_flag'] = $lang_details['lang_flag'];
	       $lang_list['lang_name'] = $lang_details['lang_name'];
	       $lang_list['lang_eng_name'] = $lang_details['lang_eng_name'];
	       $lang_list['lang_list'] = $lang_data['lang_list'];

	       $this->session->set_userdata("mlm_data_language",$lang_list);
	       $this->session->set_userdata("mlm_lang_code",$lang_code);
	}

	echo $res;
	exit();
}

}
