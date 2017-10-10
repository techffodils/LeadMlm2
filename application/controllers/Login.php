<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'admin/Base_Controller.php';

class Login extends Base_Controller {



    public function index() {
        
       $is_logged_in =false;
	   
        $this->loadView();
    }
	

    function validate_login() {
	
        $post_data = $this->input->post();
		
        $this->form_validation->set_rules('username', 'User Name', 'required|strip_tags|min_length[3]|max_length[30]|htmlentities'); //callback checking required
        $this->form_validation->set_rules('password', 'Password', 'required|callback_check_login'); //For PAsswprd
        if ($this->form_validation->run()) {
            $user_id = $this->main->get_usersession('mlm_user_id');
            $this->helper_model->insertActivity($user_id, 'login');
            
            $this->loadPage('', 'home');
        } else {
        
            $error = validation_errors();
            $username = $post_data['username'];
            $password = $post_data['password'];
            $msg = '';
            if ($username && $password) {
                $user_id = $this->helper_model->userNameToID($username);
                if ($user_id) {
                    $sha_password = hash("sha256", $password);
                    $user_status = $this->helper_model->getUserLoginStatus($user_id, $sha_password);
                    if ($user_status != 'NA') {
                        if ($user_status == 'active') {
                            $msg = 'Login Failed';
                        } else {
                            $msg = 'Your Account Inactivated';
                        }
                    } else {
                        $msg = 'Invalid Password';
                    }
                } else {
                    $msg = 'Invalid Username or Password';
                }
            } else {
                $msg = 'Username And Password Required';
            }
            $this->loadPage('', 'login');
        }
    }

    function check_login($password) {

        $flag = false;
        $login_details = $this->input->post(NULL, TRUE);
        $login_details = $this->helper_model->stripTagsPost($login_details);
        $username = $login_details['username'];
		
		if($password!=''){
           $sha_password = hash("sha256", $password);
	    }
	
         $login_result = $this->login_model->login($username, $sha_password);
		
        if ($login_result) {
            $this->login_model->setUserLoginSession($login_result);
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }
	
	/**
	*For Fogot Password Function
	*@Author Techffodils
	*@Date 2017-10-09
	
	*/
	function forgot_password(){
		$post_arr=$this->input->post();
		if($post_arr&&$this->validate_email()){
			$email=$post_arr['email'];
			$content="Please Have a ";
			//$link=
			
		}else{
			$msg='Email filed is required';
			$this->loadPage($msg,'login/forgot_password',FALSE);
		}	 
	}
	/**
	*For Validate Email
	*@Author Techffodils
	*@Date 201710-10-09
	
	*/
	function validate_email(){
	$this->form_validation->rules('email','Email','trim|xss_clean|required|callback_email_exists_or_not');
	if($this->form_validation->run()==FLASE){
		$msg="Email Not Exits in Our Database";
		$this->loadPage($msg,'login/forgot_password');
	}else{
		return TRUE;
	}
	}

	function email_exists_or_not($email){
		if(!empty($email)){
			$result=$this->login_model->checkEmailExitsOrNot($email);
			if($result){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		
	}
	
	
	function rest_password(){
		$post_arr=$this->input->post();
		if(!empty($post_arr)&& $this->validate_reset_password()){
			$email=$post_arr['new_password'];
		}
	}
	
	function validate_reset_password(){
		$this->form_validation->rules('new_passowrd','required|trim|xss_clean|match');
	}
	
	
    function logout() {

        $user_id = $this->main->get_usersession('mlm_user_id');
        foreach ($this->session->userdata as $key => $value) {
            if (strpos($key, 'mlm_') === 0) {
                $this->session->unset_userdata($key);
            }
        }
        if ($user_id) {
            $this->helper_model->insertActivity($user_id, 'logout');
        }
	
        $this->loadPage('','../login/index',TRUE);
    }

    public function session_timeout() {
        $lastActivity = $this->session->userdata('mlm_last_activity');
        $configtimeout = $this->config->item("sess_expiration");
        $sessonExpireson = $lastActivity + $configtimeout;
        $current_time = time();
        if ($sessonExpireson <= $current_time) {
            $user_data = $this->session->all_userdata();
            foreach ($this->session->userdata as $key => $value) {
                if (strpos($key, 'mlm_') === 0) {
                    $this->session->unset_userdata($key);
                }
            }
            echo "Session Destroyed";
        }
        exit;
    }

}
