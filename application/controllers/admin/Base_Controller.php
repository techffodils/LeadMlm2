<?php

class Base_Controller extends Core_Base_Controller {

    function __construct() {

        parent::__construct();
        $this->checkLoginStatus();
    }

function checkLoginStatus(){

    if($this->LOG_STATUS){

        $currenturl = $this->main->get_currentheadurl();

        if ($currenturl == 'login' || $currenturl == '') {
        
            $this->loadPage('', 'home', true);

        }elseif (!in_array($this->CURRENT_CLASS, NO_LOGIN_PAGES)) {

            $menu_status=$this->base_model->checkMenuPermitted($this->LOG_USER_TYPE,$currenturl);

            if(!$menu_status){
                $this->loadPage('', 'login', true);
            }

        } 

    }else{

        if ($this->CURRENT_CLASS != "login") {
            $this->loadPage('', 'login', true);
        }
    }
}

function changeCurrencySettings(){

    $res = false;
    $currency_code = stripslashes($this->input->post('currency_code'));

    $user_id = $this->LOG_USER_ID;

    $currency_details = $this->base_model->currencyDetailsFromCode($currency_code);

    $mlm_currency = $this->session->userdata("mlm_data_currency");
    $res = $this->base_model->changeUserCurrency($user_id,$currency_details['id']);
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
   
    $user_id = $this->LOG_USER_ID;

    $lang_details = $this->base_model->langDetailsFromCode($lang_code);

    $mlm_language = $this->session->userdata("mlm_data_language");
    $res = $this->base_model->changeUserLanguage($user_id,$lang_details['id']);
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

function changeThemeSettings(){
    $res =false;
    $data = json_decode(stripslashes($this->input->post('result')),true);
    
    $user_id = $this->LOG_USER_ID;

    $res = $this->base_model->themeChange($data,$user_id);

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


}
