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
		
        $this->form_validation->set_rules('username', 'User Name', 'required|strip_tags|min_length[3]|max_length[30]|htmlentities');
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
		if($this->input->post()&&$this->validate_email()){
			$email=$post_arr['email'];
			 if($this->login_model->checkEmailExitsOrNot($email)){
				 $mlm_user_id=$this->login_model->getMlmEmailToUserId($email);
				 $result=$this->login_model->sendPasswordResetLink($email,$mlm_user_id,'password reset');
				 if($result){
					 $msg="Please check the you email we send a Password Reset Forwarded";
					 $this->loadPage('','login/forgot_password',true);
				 }else{
					 $msg="Failed to send email";
					 $this->loadPage('','login/forgot_password',false);
				 }
				 
			 }else{
				 $msg="You have entered Email Doesnt Exists";
				 $this->loadPage($msg,'login/forgot_password',FLASE);
			 }
			
		}
	$this->loadView();
	}
	/**
	*For Validate Email
	*@Author Techffodils
	*@Date 201710-10-09
	
	*/
	function validate_email(){
	    $this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_email_exists_or_not');
	    $validate_form = $this->form_validation->run();
        return  $validate_form;
	}

	function email_exists_or_not($email){
		$flag=false;
		$result=$this->login_model->checkEmailExitsOrNot($email);
	    if($result>0){
			 $flag=true;
		}else{
			 $flag= false;
		 }
		 return $flag;
	}
	
	
	/**
	For Reset Password
	*/
	
	function reset_password($encrypt_key=""){

		$title="Reset Password";
		$this->setData("title",$this->main->get_controller().'|'.$this->main->get_method());
		$userid=$this->helper_model->decode($encrypt_key);
		
		$this->setData('user_id',$userid);
		
		if($this->input->post('submit')=='Reset'&& $this->validate_reset_password()){
			
			
			$post_arr=$this->input->post();
			
			$new_password=$post_arr['new_password'];
			$password = hash("sha256", $new_password);
			$userid=$post_arr['user_id'];
			$result=$this->login_model->resetPassword($password,$userid);
			$this->helper_model->insertActivity($userid,'Reset password');
			if($result){
				$msg="Password Reset Successfully we send and email to you";
				$this->loadPage('','login',true);
				
			}else{
				$msg="Faled to Reset Passwords";
				$this->loadPage('','login/forgot_password',true);
			}	
		}
		
		$this->loadView();
	}
	
	function validate_reset_password(){
		$this->form_validation->set_rules('new_password','New Password','required|trim|min_length[6]');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required|trim|min_length[6]|matches[new_password]');
		$validate_form = $this->form_validation->run();
		
        return $validate_form;
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
