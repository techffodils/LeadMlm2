<?php

Class Core_Base_Controller extends CI_Controller {

    public $LOG_USER_ID = null;
    public $LOG_USER_NAME = null;
    public $LOG_USER_TYPE = null;
    public $LOG_STATUS = false;
    public $BASE_URL = null;

    public $CURRENT_CLASS = null;
    public $CURRENT_METHOD = null;

    public $MULTI_LANG_STATUS = false; 
    public $MULTI_CURRENCY_STATUS = false;

    public $MLM_LANG_FLAG = null;
    public $MLM_LANG_NAME = null;
    public $MLM_LANG_ENG_NAME = null;
    public $MLM_LANG_LIST = array();

    public $GOOGLE_TRANSLATOR = false;

    public $MLM_CURRENCY_VALUE = null;
    public $MLM_CURRENCY_NAME = null;
    public $MLM_CURRENCY_CODE = null;
    public $MLM_CURRENCY_LEFT = null;
    public $MLM_CURRENCY_RIGHT = null;
    public $MLM_CURRENCY_ICON = null;
    public $MLM_CURRENCY_LIST = array();

    public $COMPANY_NAME = null;
    public $COMPANY_LOGO = null;
    public $COMPANY_FAV_ICON = null;
    public $COMPANY_ADDRESS = null;
    public $COMPANY_EMAIL = null;
    public $COMPANY_PHONE = null;

    public $CAPTCHA_STATUS = null;

    function __construct() {

        parent::__construct();

        $this->setPublicVariables();
        $this->langSwitcher();
        $this->setScript();
        $this->setSiteInfo();
        $this->setFlashMessage();

        if ($this->LOG_STATUS) {
            $this->setLanguageDetails();
            $this->setCurrencyDetails();
            $this->setTheme();
            $this->setMenus();
            $this->getBreadCrumbs();
        }
        $this->loadLanguage();  //auto load lang files
}

function setPublicVariables() {

    $this->LOG_USER_ID = $this->main->get_usersession('mlm_user_id');
    $this->LOG_USER_NAME = $this->main->get_usersession('mlm_username');
    $this->LOG_USER_TYPE = $this->main->get_usersession('mlm_user_type');
    $this->LOG_STATUS = $this->checkSession();
    $this->BASE_URL = BASE_PATH;
    $this->CURRENT_CLASS = $this->main->get_controller();
    $this->CURRENT_METHOD = $this->main->get_method();
    $this->MULTI_LANG_STATUS = $this->dbvars->MULTI_LANG_STATUS;
    $this->MULTI_CURRENCY_STATUS = $this->dbvars->MULTI_CURRENCY_STATUS;

    $this->MLM_LANG_FLAG = $this->dbvars->LANG_FLAG;
    $this->MLM_LANG_NAME = $this->dbvars->LANG_NAME;
    $this->MLM_LANG_ENG_NAME = $this->dbvars->LANG_NAME;

    $this->MLM_CURRENCY_VALUE =  $this->dbvars->DEFAULT_CURRENCY_VALUE;
    $this->MLM_CURRENCY_NAME = $this->dbvars->DEFAULT_CURRENCY_NAME;
    $this->MLM_CURRENCY_CODE =  $this->dbvars->DEFAULT_CURRENCY_CODE;
    $this->MLM_CURRENCY_LEFT =  $this->dbvars->DEFAULT_SYMBOL_LEFT;
    $this->MLM_CURRENCY_RIGHT =  $this->dbvars->DEFAULT_SYMBOL_RIGHT;
    $this->MLM_CURRENCY_ICON =  $this->dbvars->DEFAULT_CURRENCY_ICON;
    $this->GOOGLE_TRANSLATOR =$this->dbvars->GOOGLE_TRANSLATOR;
    $this->CAPTCHA_STATUS =$this->dbvars->CAPTCHA_STATUS;

    return 1;
}

function loadPublicVariables() {

    $this->setData('LOG_USER_ID',  $this->LOG_USER_ID);
    $this->setData('LOG_USER_NAME', $this->LOG_USER_NAME);
    $this->setData('LOG_USER_TYPE',  $this->LOG_USER_TYPE);
    $this->setData('LOG_STATUS',  $this->LOG_STATUS);
    $this->setData('BASE_URL',  $this->BASE_URL);
    $this->setData('CURRENT_CLASS',  $this->CURRENT_CLASS);
    $this->setData('CURRENT_METHOD',  $this->CURRENT_METHOD);
    $this->setData('MULTI_LANG_STATUS',  $this->MULTI_LANG_STATUS);
    $this->setData('MULTI_CURRENCY_STATUS',  $this->MULTI_CURRENCY_STATUS);

    $this->setData('MLM_LANG_FLAG',  $this->MLM_LANG_FLAG);
    $this->setData('MLM_LANG_NAME',  $this->MLM_LANG_NAME);
    $this->setData('MLM_LANG_ENG_NAME',  $this->MLM_LANG_ENG_NAME);

    $this->setData('MLM_CURRENCY_VALUE',  $this->MLM_CURRENCY_VALUE);
    $this->setData('MLM_CURRENCY_NAME',  $this->MLM_CURRENCY_NAME);
    $this->setData('MLM_CURRENCY_CODE',  $this->MLM_CURRENCY_CODE);
    $this->setData('MLM_CURRENCY_LEFT',  $this->MLM_CURRENCY_LEFT);
    $this->setData('MLM_CURRENCY_RIGHT',  $this->MLM_CURRENCY_RIGHT);
    $this->setData('MLM_CURRENCY_ICON',  $this->MLM_CURRENCY_ICON);
    $this->setData('GOOGLE_TRANSLATOR',  $this->GOOGLE_TRANSLATOR);
    $this->setData('CAPTCHA_STATUS',  $this->CAPTCHA_STATUS);

    return 1;
}

function langSwitcher() {

    /* configure new languages in here
    and add in the route file */   

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

    return 1;
}


function setLanguageDetails() {

    $user_id = $this->LOG_USER_ID;

    if ($user_id) {
        if ($this->MULTI_LANG_STATUS) {

            if ($this->session->userdata("mlm_data_language")) {

                $mlm_language = $this->session->userdata("mlm_data_language");
                $this->MLM_LANG_FLAG =  $mlm_language['lang_flag'];
                $this->MLM_LANG_NAME =  $mlm_language['lang_name'];
                $this->MLM_LANG_ENG_NAME =  $mlm_language['lang_eng_name'];
                $this->MLM_LANG_LIST = $mlm_language['lang_list'];

            }else{

                $mlm_language = $this->base_model->getLanguageDetails($user_id, $this->LOG_USER_TYPE);
                $lang_list = $this->base_model->getAllLanguages();

                $this->MLM_LANG_FLAG =  $mlm_language['lang_flag'];
                $this->MLM_LANG_NAME =  $mlm_language['lang_name'];
                $this->MLM_LANG_ENG_NAME =  $mlm_language['lang_eng_name'];
                $this->MLM_LANG_LIST = $lang_list;

                $lang_data['lang_flag'] = $mlm_language['lang_flag'];
                $lang_data['lang_name'] = $mlm_language['lang_name'];
                $lang_data['lang_eng_name'] = $mlm_language['lang_eng_name'];
                $lang_data['lang_list'] = $lang_list;

                $this->session->set_userdata("mlm_data_language",$lang_data);
            }

            $this->setData('MLM_LANG_FLAG',  $this->MLM_LANG_FLAG);
            $this->setData('MLM_LANG_NAME',  $this->MLM_LANG_NAME);
            $this->setData('MLM_LANG_ENG_NAME',  $this->MLM_LANG_ENG_NAME);
            $this->setData('MLM_LANG_LIST',  $this->MLM_LANG_LIST);

        }
    }
    return 1;
}


function setCurrencyDetails() {

    $user_id = $this->LOG_USER_ID;

    if ($user_id) {

        if ($this->MULTI_CURRENCY_STATUS) {

            if ($this->session->userdata("mlm_data_currency")) {

                $mlm_currency = $this->session->userdata("mlm_data_currency");

                $this->MLM_CURRENCY_VALUE = $mlm_currency['currency_ratio'];
                $this->MLM_CURRENCY_NAME = $mlm_currency['currency_name'];
                $this->MLM_CURRENCY_CODE =  $mlm_currency['currency_code'];
                $this->MLM_CURRENCY_LEFT =  $mlm_currency['symbol_left'];
                $this->MLM_CURRENCY_RIGHT =  $mlm_currency['symbol_right'];
                $this->MLM_CURRENCY_ICON =  $mlm_currency['icon'];
                $this->MLM_CURRENCY_LIST =  $mlm_currency['currency_list'];


            }else{

                if( $this->LOG_USER_TYPE =='employee'){
                    $user_id = $this->base_model->getAdminUserId();
                }

                $mlm_currency = $this->base_model->getCurrencyDetails($user_id,$this->LOG_USER_TYPE);//load from global
                $currency_list = $this->base_model->getAllCurrency();

                $this->MLM_CURRENCY_VALUE = $mlm_currency['currency_ratio'];
                $this->MLM_CURRENCY_NAME = $mlm_currency['currency_name'];
                $this->MLM_CURRENCY_CODE =  $mlm_currency['currency_code'];
                $this->MLM_CURRENCY_LEFT = $mlm_currency['symbol_left'];
                $this->MLM_CURRENCY_RIGHT =  $mlm_currency['symbol_right'];
                $this->MLM_CURRENCY_ICON =  $mlm_currency['icon'];
                $this->MLM_CURRENCY_LIST =  $currency_list;

                $currency_data['currency_ratio'] = $mlm_currency['currency_ratio'];
                $currency_data['currency_name'] = $mlm_currency['currency_name'];
                $currency_data['currency_code'] = $mlm_currency['currency_code'];
                $currency_data['symbol_left'] = $mlm_currency['symbol_left'];
                $currency_data['symbol_right'] = $mlm_currency['symbol_right'];
                $currency_data['icon'] = $mlm_currency['icon'];
                $currency_data['currency_list'] = $currency_list;

                $mlm_currency = $this->session->set_userdata("mlm_data_currency",$currency_data);
                
                }

        }

        $this->setData('MLM_CURRENCY_VALUE', $this->MLM_CURRENCY_VALUE);
        $this->setData('MLM_CURRENCY_NAME', $this->MLM_CURRENCY_NAME);
        $this->setData('MLM_CURRENCY_CODE', $this->MLM_CURRENCY_CODE);
        $this->setData('MLM_CURRENCY_LEFT', $this->MLM_CURRENCY_LEFT);
        $this->setData('MLM_CURRENCY_RIGHT', $this->MLM_CURRENCY_RIGHT);
        $this->setData('MLM_CURRENCY_ICON', $this->MLM_CURRENCY_ICON);
        $this->setData('MLM_CURRENCY_LIST', $this->MLM_CURRENCY_LIST);

    }
return 1;
}



function setMenus() {

    $currenturl     = $this->main->get_currentheadurl();
    $user_menu      = $this->base_model->getSideMenus($this->LOG_USER_ID ,$this->LOG_USER_TYPE ,$currenturl);

    $this->setData('USER_MENU', $user_menu);
    return 1;
}

function setData($key, $value) {
    $this->DATA_ARR[$key] = $value;
}

function loadLanguage() {

    if (!in_array($this->CURRENT_CLASS , NO_LANGUAGE_PAGES))
    {
        if (!in_array($this->CURRENT_CLASS , COMMON_PAGES) && $this->LOG_STATUS){
            $this->lang->load($this->LOG_USER_TYPE.'/'.$this->CURRENT_CLASS);
        }else{
            $this->lang->load($this->CURRENT_CLASS);
        }
    }

return 1;
}

function setSiteInfo() {

    if($this->session->userdata('mlm_site_info')  != null){
        $site_info  = $this->session->userdata('mlm_site_info');
    }else{
        $site_info  = $this->base_model->getSiteInfo();
        $this->session->set_userdata('mlm_site_info',$site_info);
    }

    $this->COMPANY_NAME =  $site_info['company_name'];
    $this->COMPANY_LOGO = $site_info['company_logo'];
    $this->COMPANY_FAV_ICON = $site_info['company_fav_icon'];
    $this->COMPANY_ADDRESS = $site_info['company_address'];
    $this->COMPANY_EMAIL = $site_info['company_email'];
    $this->COMPANY_PHONE = $site_info['company_phone'];

    $this->setData('COMPANY_NAME',$this->COMPANY_NAME);
    $this->setData('COMPANY_LOGO',  $this->COMPANY_LOGO);
    $this->setData('COMPANY_FAV_ICON', $this->COMPANY_FAV_ICON);
    $this->setData('COMPANY_ADDRESS', $this->COMPANY_ADDRESS);
    $this->setData('COMPANY_EMAIL', $this->COMPANY_EMAIL);
    $this->setData('COMPANY_PHONE', $this->COMPANY_PHONE);

    return 1;
}

function loadView() {

    $this->loadPublicVariables();

    $lock_status =false;
    if($this->LOG_STATUS){

        $currenturl = $this->main->get_currentheadurl();
        $lock_status=$this->base_model->checkMenuLocked($this->LOG_USER_TYPE,$currenturl);

    }

    $user_type = ($this->LOG_USER_TYPE == 'employee')?'admin': $this->LOG_USER_TYPE;

    if (in_array($this->CURRENT_CLASS, COMMON_PAGES)) {
        $this->twig->display($this->CURRENT_CLASS . '/' . $this->CURRENT_METHOD . '.twig', $this->DATA_ARR);

    }elseif($lock_status){
        $this->twig->display($user_type .'/access_denied.twig', $this->DATA_ARR);
    }else {
        $this->twig->display($user_type .'/'. $this->CURRENT_CLASS . '/' . $this->CURRENT_METHOD . '.twig', $this->DATA_ARR);
    }
}

function checkSession() {

    return ($this->main->get_usersession('is_logged_in')) ? true : false;
}

function loadPage($msg, $page, $message_type = false) {

    $flash_message= array('message' => $msg, 'type' => $message_type);
    $this->session->set_userdata('flash_msg_arr', $flash_message);

    $path = '';

    $split_pages = explode('/', $page);
    $controller_name = $split_pages[0];

    if (in_array($controller_name, COMMON_PAGES)) {
        $path .= $page;
    } else {

        if ($this->checkSession()) {

            $user_type = $this->main->get_usersession('mlm_user_type');
            $user_type = ($user_type == 'employee')?'admin':$user_type;

            $path .= $user_type.'/' . $page;

        } else {

            if (in_array($controller_name, NO_LOGIN_PAGES)) {
                $path .= $page;
            } else {
                $path .= 'login';
            }

        }
    }

    redirect($path, 'refresh');
    exit();
    return 1;
}


function setFlashMessage() { 

    $flash_msg_arr = $this->session->userdata('flash_msg_arr');
    if ($flash_msg_arr) {
        $this->setData("FLASH_MESSAGE_DETAILS", $flash_msg_arr['message']);
        $this->setData("FLASH_MESSAGE_TYPE", $flash_msg_arr['type']);
        $this->session->unset_userdata('flash_msg_arr');
    } else {
        $this->setData("FLASH_MESSAGE_DETAILS", FALSE);
        $this->setData("FLASH_MESSAGE_TYPE", FALSE);
    }

    return 1;
}

function setTheme() {

    if($this->session->userdata('mlm_theme_details')  != null){
        $theme_details  = $this->session->userdata('mlm_theme_details');
    }else{

        $user_id = $this->LOG_USER_ID;
        if($this->LOG_USER_TYPE == 'employee'){
            $user_id = $this->base_model->getAdminUserId();
        }

        $theme_details  = $this->base_model->getThemeDetails($user_id);
    }

    $this->setData('THEME',   $theme_details);
    return 1;
}


function setScript() {

    $currenturl     = $this->main->get_currentheadurl();
    $script_files   = $this->base_model->loadPageScript($currenturl);
    $this->setData('SCRIPT_FILES', $script_files);
    return 1;
}


function getBreadCrumbs() {  

    $data = $this->base_model->getBreadCrumbs($this->CURRENT_CLASS,$this->CURRENT_METHOD,$this->LOG_USER_TYPE);        
    $this->setData('BREADCRUMBS', $data);
    return 1;
}

}
