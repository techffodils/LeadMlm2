<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'admin/Base_Controller.php';

class Register extends Base_Controller {

    public function single_step() {
        if ($this->input->post('add_user') && $this->validate_registration('single_step')) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['last_name'] = '';
            $user_details['address_1'] = '';
            $user_details['address_2'] = '';
            $user_details['city'] = '';
            $user_details['district'] = '';
            $user_details['state_id'] = '';
            $user_details['country_id'] = '';
            $user_details['register_type'] = 'single_step';
            $res = $this->register_model->addUser($user_details['register_type'], $user_details);
            if ($res) {
                $this->loadPage('User Registered Successfully', 'register/single_step', True);
            } else {
                $this->loadPage('Failed To Register', 'register/single_step', FALSE);
            }
        }
        $this->loadView();
    }
    
    public function multiple_step() {
        if ($this->input->post('add_user') && $this->validate_registration('multiple_step')) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';            
            $user_details['state_id'] = '1';
            $user_details['country_id'] = '1';
            $user_details['register_type'] = 'multiple_step';
            $res = $this->register_model->addUser('multiple_step', $user_details);
            if ($res) {
                $this->loadPage('User Registered Successfully', 'register/single_step', True);
            } else {
                $this->loadPage('Failed To Register', 'register/single_step', FALSE);
            }
        }
        $this->loadView();
    }
    

    public function validate_registration($type) {
        $this->form_validation->set_rules('sponser_name', 'sponser_name', 'required|callback_validate_sponsor|trim');
        $this->form_validation->set_rules('username', 'username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required|matches[confirm_password]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        //$this->form_validation->set_rules('agree', 'agree', 'required');
        if($type=="multiple_step"){
            $this->form_validation->set_rules('phone_number', 'phone_number', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('zip_code', 'zip_code', 'numeric|greater_than[0]');            
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        
//        $error_array = $this->form_validation->error_array();
//        print_r($error_array);die();
//        echo $validation;die();
        return $validation;
    }

    function validate_sponsor($username) {
        $flag = false;
        if ($this->helper_model->userNameToID($username)) {
            $flag = true;
        }
        return $flag;
    }

    function validate_username($username) {
        $flag = false;
        if (!$this->helper_model->userNameToID($username)) {
            $flag = true;
        }
        return $flag;
    }

    function valid_email($email) {
        $flag = false;
        if (!$this->helper_model->getUserIdFromEmailId($email)) {
            $flag = true;
        }
        return $flag;
    }

}
