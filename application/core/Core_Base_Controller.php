<?php

Class Core_Base_Controller extends CI_Controller {

    public $DATA_ARR;
	public $BREADCRUM_DATA;

    function __construct() {


        parent::__construct();

        $this->main->load_model();
        $this->BREADCRUM_DATA;
        $this->DATA_ARR['BASE_URL'] = BASE_PATH;
        $user_type = $this->main->get_usersession('mlm_user_type');


        if ($user_type) {


            $currenturl     = $this->main->get_currenturl('mlm_user_type');
            $user_id        = $this->main->get_usersession('mlm_user_id');
  
            $user_menu      = $this->base_model->getSideMenus($user_type);
            $script_files   = $this->base_model->loadPageScript($currenturl);
            $theme_details  = $this->base_model->getThemeDetails($user_id);
            $language_details     = $this->setLanguageDetails($user_id,$user_type);

            $currency_details     = $this->setCurrencyDetails($user_id,$user_type);

            $this->setData('USER_MENU', $user_menu);
            $this->setData('SCRIPT_FILES', $script_files);
            $this->setData('THEME', $theme_details);
            $this->DATA_ARR['pages']=$this->base_model->getBreadCrubms($this->main->get_usersession('mlm_user_type'));
        }
       
    }

    /**
     * Add Function For dispaly view
     * @date:2017-10-10 Monday
     * @Author:Techffodils technologies LLP
     */
    function loadView() {

        $this->DATA_ARR['js_path'] = PUBLIC_PATH;

        $mlm_user_type = 'user';

        if ($this->main->get_usersession('mlm_user_type') != 'user') {
            $mlm_user_type = 'admin';
        }


        if (in_array($this->main->get_controller(), COMMON_PAGES)) {
            $this->twig->display($this->main->get_controller() . '/' . $this->main->get_method() . '.twig', $this->DATA_ARR);
        } else {
            $this->twig->display("$mlm_user_type/" . $this->main->get_controller() . '/' . $this->main->get_method() . '.twig', $this->DATA_ARR);
        }
    }

    /**
     * setDataDatas
     * @date:2017-10-10 Monday
     * @Author:Techffodils technologies
     */
    function setData($key, $value) {
        $this->DATA_ARR[$key] = $value;
    }

    /**
     * Add loadPage for Redirect the page
     * @date:2017-10-10 Monday
     * @Author:Techffodils technologies
     */
    function loadPage($msg, $page, $message_type = false, $FLASH_MSG_ARR = array()) {

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
      Add checkSession user is logged or not
      @date:2017-10-10 Monday
      @Author:Techffodils technologies

     */
    function checkSession() {

        $flag = $this->main->get_usersession('is_logged_in') ? true : false;
        //echo $flag;die;
        return $flag;
    }

    /**
      Add setData flash message
      @date:2017-10-10 Monday
      @Author:Techffodils technologies
     */
    function set_flash_message() {
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

//    function checkAdminLogged() {
//        if ($this->checkSession()) {
//            $user_type = $this->main->get_usersession('mlm_user_type');
//            if ($user_type != "admin" && $user_type != "employee") {
//                $this->loadPage("", "../user/home");
//            }
//        } else {
//            //echo "here";die;
//            $login_link = BASE_PATH . "login";
//            $this->loadPage('', $login_link);
//        }
//
//        return true;
//    }
//
//    function checkUserLogged() {
//
//        if ($this->checkSession()) {
//            $user_type = $this->main->get_usersession('mlm_user_type');
//            if ($user_type != "user") {
//                $this->loadPage("", "../admin/home");
//            }
//        } else {
//            $login_link = BASE_PATH . "login";
//            $this->loadPage('', $login_link);
//        }
//        return true;
//    }
			function setNotificationMessage() {


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



function setCurrencyDetails($user_id,$user_type) {
				if ($user_id) {

						//$currency_status = $this->base_model->getCurrencyStatus();

					$currency_status = true;

					if ($currency_status) {

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

						if($user_type =='employee'){
							$user_id = $this->base_model->getAdminUserId();
						}

								$mlm_currency = $this->base_model->getCurrencyDetails($user_id);//load from golbal


								$currency_list = $this->base_model->getAllCurrency();

								$this->setData('MLM_CURRENCY_VALUE',  $mlm_currency['currency_ratio']);
								$this->setData('MLM_CURRENCY_NAME',  $mlm_currency['currency_name']);
								$this->setData('MLM_CURRENCY_CODE',  $mlm_currency['currency_code']);
								$this->setData('MLM_CURRENCY_LEFT',  $mlm_currency['symbol_left']);
								$this->setData('MLM_CURRENCY_RIGHT',  $mlm_currency['symbol_right']);
								$this->setData('MLM_CURRENCY_ICON',  $mlm_currency['icon']);
								$this->setData('MLM_CURRENCY_LIST',  $currency_list);

							}
						}
					}
					return 1;
				}

				function setLanguageDetails($user_id,$user_type) {
					if ($user_id) {
						//$language_status = $this->base_model->getLanguageStatus();
						$language_status = true;
						if ($language_status) {

						 if ($this->session->userdata("mlm_data_language")) {

							$mlm_language = $this->session->userdata("mlm_data_language");
							$this->setData('MLM_LANG_FLAG',  $mlm_language['lang_flag']);
							$this->setData('MLM_LANG_NAME',  $mlm_language['lang_name']);
							$this->setData('MLM_LANG_ENG_NAME',  $mlm_language['lang_name']);
							$this->setData('MLM_LANG_LIST',  $mlm_language['lang_list']);

						}else{

							if($user_type =='employee'){
									$user_id = $this->base_model->getAdminUserId();
							}

							$mlm_language = $this->base_model->getLanguageDetails($user_id);

							$lang_list = $this->base_model->getAllLanguages();

							$this->setData('MLM_LANG_FLAG',  $mlm_language['lang_flag']);
							$this->setData('MLM_LANG_NAME',  $mlm_language['lang_name']);
							$this->setData('MLM_LANG_ENG_NAME',  $mlm_language['lang_name']);
							$this->setData('MLM_LANG_LIST',  $lang_list);

						}
					}
				}
				return 1;
			}

}
