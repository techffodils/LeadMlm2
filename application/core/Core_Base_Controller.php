<?php

Class Core_Base_Controller extends CI_Controller {

	public $LOG_USER_ID = null;
	public $LOG_USER_TYPE = null;
	public $LOG_STATUS = false;
	public $BREADCRUM_DATA = array();
	public $BASE_URL = null;

	public $CURRENT_CLASS = null;
	public $CURRENT_METHOD = null;

	public $MULTI_LANG_STATUS = false; 
	public $MULTI_CURRENCY_STATUS = false;


	function __construct() {

		parent::__construct();

		$this->setPublicVariables();
		$this->langSwitcher();

		if ($this->LOG_STATUS) {
			$this->setLanguageDetails();
			$this->setCurrencyDetails();
			$this->setTheme();
			$this->setScript();
			$this->setMenus();
			$this->getBreadCrubms();
			$this->loadLanguage();
			$this->setSiteInfo();
		}
 }



function setData($key, $value) {
	$this->DATA_ARR[$key] = $value;
}

function loadView() {

	$this->loadPublicVariables();
	$mlm_user_type = 'user';

	if ($this->LOG_USER_TYPE != 'user') {
		$mlm_user_type = 'admin';
	}

	if (in_array($this->CURRENT_CLASS, COMMON_PAGES)) {
		$this->twig->display($this->CURRENT_CLASS . '/' . $this->CURRENT_METHOD . '.twig', $this->DATA_ARR);
	} else {
		$this->twig->display($this->LOG_USER_TYPE.'/'. $this->CURRENT_CLASS . '/' . $this->CURRENT_METHOD . '.twig', $this->DATA_ARR);
	}
}

function checkSession() {

	$flag = ($this->main->get_usersession('is_logged_in')) ? true : false;
	return $flag;
}

/**
* Add loadPage for Redirect the page
* @date:2017-10-10 Monday
* @Author:Techffodils technologies
*/
function loadPage($msg, $page, $message_type = false) {//check

	$FLASH_FLASH_MSG_ARR["MESSAGE"]["DETAIL"] = $msg;
	$FLASH_MSG_ARR["MESSAGE"]["TYPE"] = $message_type;
	$FLASH_MSG_ARR["MESSAGE"]["STATUS"] = true;

	$this->main->set_flashdata('FLASH_MSG_ARR', $FLASH_MSG_ARR);

	$root = BASE_PATH;

	$split_pages = explode("/", $page);
	$controller_name = $split_pages[0];
	$path = '';
//print_r(COMMON_PAGES);die;
	if (in_array($controller_name, COMMON_PAGES)) {


		$path .= $page;
		redirect("$path", 'refresh');
		exit();
	} else {

		if ($this->checkSession()) {

			$user_type = $this->main->get_usersession('mlm_user_type');
			if ($user_type == "admin" || $user_type == "employee") {
				$path .= "admin/" . $page;
			} else {
				$path .= "user/" . $page;
			}
			redirect("$path", 'refresh');
			exit();
		} else {
			if (in_array($controller_name, NO_LOGIN_PAGES)) {

				$path .= $page;
				redirect("$path", 'refresh');
				exit();
			} else {
				$path .= "login";
				redirect("$path", 'refresh');
				exit();
			}
		}
	}
}



/**
Add setData flash message
@date:2017-10-10 Monday
@Author:Techffodils technologies
*/
function set_flash_message() { //check
	$FLASH_ARR_MSG = $this->main->get_flashdata('FLASH_MSG_ARR');
	if ($FLASH_ARR_MSG) {
		$this->setData("MESSAGE_DETAILS", $FLASH_ARR_MSG["MESSAGE"]["DETAIL"]);
		$this->setData("MESSAGE_TYPE", $FLASH_ARR_MSG["MESSAGE"]["TYPE"]);
		$this->setData("MESSAGE_STATUS", $FLASH_ARR_MSG["MESSAGE"]["STATUS"]);
	} else {
		$this->setData("MESSAGE_STATUS", FALSE);
		$this->setData("MESSAGE_DETAILS", FALSE);
		$this->setData("MESSAGE_TYPE", FALSE);
	}
}


function setNotificationMessage() { //check


	$FLASH_MSG_ARR=$this->main->get_flashdata('FLASH_MSG_ARR');

	if ($FLASH_MSG_ARR) {
		$this->setData("MESSAGE_DETAILS", $FLASH_MSG_ARR);
	} else {
		$this->setData("MESSAGE_DETAILS", null);
	}
}

function checkLogged($type="") {

	$login_link = BASE_PATH . "login";

	if (!$this->checkSession()) {

		$this->loadPage('', 'login', true);
	}elseif($type!=$this->main->get_usersession('mlm_user_type')){
		$this->loadPage('', 'home', true);
	}
	return true;
}

function checkPages() {
	if ($this->checkSession()) {
		$user_type = $this->main->get_usersession('mlm_user_type');
		if ($user_type == "user") {
			$this->loadPage("", "../user/home");
		}elseif($user_type == "admin"){
			$this->loadPage("", "../user/home");
		}
	} 
	return true;
}

function set_breadcrumbs($set_key, $set_value) {
	$this->DATA_ARR[$set_key] = $set_value;
}

function set_header_lang(){
	$this->DATA_ARR['HEADER_DATA']=$this->BREADCRUM_DATA;
}



function setCurrencyDetails() {

	$user_id = $this->LOG_USER_ID;

	if ($user_id) {

		if ($this->MULTI_CURRENCY_STATUS) {

			if ($this->session->userdata("mlm_data_currency")) {

				$mlm_currency = $this->session->userdata("mlm_data_currency");

				$this->setData('MLM_CURRENCY_VALUE',  $mlm_currency['currency_ratio']);
				$this->setData('MLM_CURRENCY_NAME',  $mlm_currency['currency_name']);
				$this->setData('MLM_CURRENCY_CODE',  $mlm_currency['currency_code']);
				$this->setData('MLM_CURRENCY_LEFT',  $mlm_currency['symbol_left']);
				$this->setData('MLM_CURRENCY_RIGHT',  $mlm_currency['symbol_right']);
				$this->setData('MLM_CURRENCY_ICON',  $mlm_currency['icon']);
				$this->setData('MLM_CURRENCY_LIST',  $mlm_currency['currency_list']);

			}else{

				if( $this->LOG_USER_TYPE =='employee'){
					$user_id = $this->base_model->getAdminUserId();
				}

					$mlm_currency = $this->base_model->getCurrencyDetails($user_id);//load from global
					$currency_list = $this->base_model->getAllCurrency();

					$this->setData('MLM_CURRENCY_VALUE',  $mlm_currency['currency_ratio']);
					$this->setData('MLM_CURRENCY_NAME',  $mlm_currency['currency_name']);
					$this->setData('MLM_CURRENCY_CODE',  $mlm_currency['currency_code']);
					$this->setData('MLM_CURRENCY_LEFT',  $mlm_currency['symbol_left']);
					$this->setData('MLM_CURRENCY_RIGHT',  $mlm_currency['symbol_right']);
					$this->setData('MLM_CURRENCY_ICON',  $mlm_currency['icon']);
					$this->setData('MLM_CURRENCY_LIST',  $currency_list);

					$currency_data['currency_ratio'] =$mlm_currency['currency_ratio'];
					$currency_data['currency_name'] =$mlm_currency['currency_name'];
					$currency_data['currency_code'] =$mlm_currency['currency_code'];
					$currency_data['symbol_left'] =$mlm_currency['symbol_left'];
					$currency_data['symbol_right'] =$mlm_currency['symbol_right'];
					$currency_data['icon'] =$mlm_currency['icon'];
					$currency_data['currency_list'] =$currency_list;

					$mlm_currency = $this->session->set_userdata("mlm_data_currency",$currency_data);
				}
			}else{

				$this->setData('MLM_CURRENCY_VALUE',   $this->dbvars->DEFAULT_CURRENCY_VALUE);
				$this->setData('MLM_CURRENCY_NAME',   $this->dbvars->MULTI_CURRENCY_NAME);
				$this->setData('MLM_CURRENCY_CODE',   $this->dbvars->DEFAULT_CURRENCY_CODE);
				$this->setData('MLM_CURRENCY_LEFT',   $this->dbvars->DEFAULT_SYMBOL_LEFT);
				$this->setData('MLM_CURRENCY_RIGHT',   $this->dbvars->DEFAULT_SYMBOL_RIGHT);
				$this->setData('MLM_CURRENCY_ICON',   $this->dbvars->DEFAULT_CURRENCY_ICON);

			}
		}
		return 1;
	}


	function setLanguageDetails() {

		$user_id = $this->LOG_USER_ID;

		if ($user_id) {
			if ($this->MULTI_LANG_STATUS) {

				if ($this->session->userdata("mlm_data_language")) {

					$mlm_language = $this->session->userdata("mlm_data_language");
					$this->setData('MLM_LANG_FLAG',  $mlm_language['lang_flag']);
					$this->setData('MLM_LANG_NAME',  $mlm_language['lang_name']);
					$this->setData('MLM_LANG_ENG_NAME',  $mlm_language['lang_eng_name']);
					$this->setData('MLM_LANG_LIST',  $mlm_language['lang_list']);

				}else{

					if($this->LOG_USER_TYPE =='employee'){
						$user_id = $this->base_model->getAdminUserId();
					}

					$mlm_language = $this->base_model->getLanguageDetails($user_id);
					$lang_list = $this->base_model->getAllLanguages();

					$this->setData('MLM_LANG_FLAG',  $mlm_language['lang_flag']);
					$this->setData('MLM_LANG_NAME',  $mlm_language['lang_name']);
					$this->setData('MLM_LANG_ENG_NAME',  $mlm_language['lang_eng_name']);
					$this->setData('MLM_LANG_LIST',  $lang_list);

					$lang_data['lang_flag'] = $mlm_language['lang_flag'];
					$lang_data['lang_name'] = $mlm_language['lang_name'];
					$lang_data['lang_eng_name'] = $mlm_language['lang_eng_name'];
					$lang_data['lang_list'] = $lang_list;

					$this->session->set_userdata("mlm_data_language",$lang_data);
				}
			}else{
				$this->setData('MLM_LANG_FLAG',  $this->dbvars->LANG_FLAG);
				$this->setData('MLM_LANG_NAME',   $this->dbvars->LANG_NAME);
				$this->setData('MLM_LANG_ENG_NAME',   $this->dbvars->LANG_NAME);
			}
		}
		return 1;
	}


	function setTheme() {

		if($this->session->userdata('mlm_theme_details')  != null){
			$theme_details  = $this->session->userdata('mlm_theme_details');
		}else{
			$theme_details  = $this->base_model->getThemeDetails($this->LOG_USER_ID);
		}
		
		$this->setData('THEME',   $theme_details);
		return 1;
	}

 function setSiteInfo() {

		if($this->session->userdata('mlm_site_info')  != null){
			$site_info  = $this->session->userdata('mlm_site_info');
		}else{
			$site_info  = $this->base_model->getSiteInfo();
			$this->session->set_userdata('mlm_site_info',$site_info);
		}
		
		$this->setData('COMPANY_NAME', $site_info['company_name']);
		$this->setData('COMPANY_LOGO', $site_info['company_logo']);
		$this->setData('COMPANY_FAV_ICON', $site_info['company_fav_icon']);
		$this->setData('COMPANY_ADDRESS', $site_info['company_address']);
		$this->setData('COMPANY_EMAIL', $site_info['company_email']);
		$this->setData('COMPANY_PHONE', $site_info['company_phone']);

		return 1;
	}


	function setScript() {

		$currenturl     = $this->main->get_currentheadurl();
		$script_files   = $this->base_model->loadPageScript($currenturl);
		$this->setData('SCRIPT_FILES', $script_files);
		return 1;
	}

	function setMenus() {
		
		$currenturl     = $this->main->get_currentheadurl();
		$user_menu      = $this->base_model->getSideMenus($this->LOG_USER_TYPE ,$currenturl);

		$this->setData('USER_MENU', $user_menu);
		return 1;
	}

	function getBreadCrubms() {
		
		$pages = $this->base_model->getBreadCrubms($this->LOG_USER_TYPE);        
		$this->setData('PAGES', $pages);
		return 1;
	}



 function langSwitcher() {

   /*
	configure new languages in here
	and add in the route file
   */   

	if ($this->session->userdata("mlm_lang_code") == "es") {
		$lang = "spanish";
		$this->config->set_item('language',$lang);
	} elseif ($this->session->userdata("mlm_lang_code") == "fr") {
		$lang = "french";
		$this->config->set_item('language',$lang);
	}elseif ($this->dbvars->LANG_NAME != '') {
		$lang = $this->dbvars->LANG_NAME;
		$this->config->set_item('language',$lang);
	}else {
		$lang = "english";
		$this->config->set_item('language',$lang);
	}

	return true;
}


function setPublicVariables() {

	$this->LOG_USER_ID = $this->main->get_usersession('mlm_user_id');
	$this->LOG_USER_TYPE = $this->main->get_usersession('mlm_user_type');
	$this->LOG_STATUS = $this->checkSession();
	$this->BASE_URL = BASE_PATH;
	$this->CURRENT_CLASS = $this->main->get_controller();
	$this->CURRENT_METHOD = $this->main->get_method();
	$this->MULTI_LANG_STATUS = $this->dbvars->MULTI_LANG_STATUS;
	$this->MULTI_CURRENCY_STATUS = $this->dbvars->MULTI_CURRENCY_STATUS;

}

function loadPublicVariables() {

	 $this->setData('LOG_USER_ID',  $this->LOG_USER_ID);
	 $this->setData('LOG_USER_TYPE',  $this->LOG_USER_TYPE);
	 $this->setData('LOG_STATUS',  $this->LOG_STATUS);
	 $this->setData('BASE_URL',  $this->BASE_URL);
	 $this->setData('CURRENT_CLASS',  $this->CURRENT_CLASS);
	 $this->setData('CURRENT_METHOD',  $this->CURRENT_METHOD);
	 $this->setData('MULTI_LANG_STATUS',  $this->MULTI_LANG_STATUS);
	 $this->setData('MULTI_CURRENCY_STATUS',  $this->MULTI_CURRENCY_STATUS);
	
}

function loadLanguage() {
		$this->lang->load('common');
		if (!in_array($this->CURRENT_CLASS , NO_LANGUAGE_PAGES))
		{
			$this->lang->load( $this->LOG_USER_TYPE.'/'.$this->CURRENT_CLASS);
		}
	}
}
