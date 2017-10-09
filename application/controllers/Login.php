<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'admin/Base_Controller.php';

class Login extends Base_Controller {

    public function index() {
        $data = array();
        
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
        $sha_password = hash("sha256", $password);
        $login_result = $this->login_model->login($username, $sha_password);
        if ($login_result) {
            $this->login_model->setUserLoginSession($login_result);
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
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
        header('Location: http://localhost/WC/soft');
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
