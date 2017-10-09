<?php 


Class Core_Base_Controller extends CI_Controller {    

    public $DATA_ARR;
	
    function __construct() {

        parent::__construct();

        $this->main->load_model();
		$this->DATA_ARR['BASE_URL']= BASE_PATH;
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
   
   
   
   function setData($key, $value){
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
		$path='';
		
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
	
}