<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'admin/Base_Controller.php';

class Register extends Base_Controller {

    public function single_step() {
        if ($this->input->post('add_user') && $this->validate_single_step_registration()) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['register_by'] = 'free_join';
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
        if ($this->input->post('add_user') && $this->validate_single_step_registration()) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['register_by'] = 'free_join';
            $user_details['last_name'] = '';
            $user_details['address_1'] = '';
            $user_details['address_2'] = '';
            $user_details['city'] = '';
            $user_details['district'] = '';
            $user_details['state_id'] = '';
            $user_details['country_id'] = '';
            $res = $this->register_model->addUser('single_step', $user_details);
            if ($res) {
                $this->loadPage('User Registered Successfully', 'register/single_step', True);
            } else {
                $this->loadPage('Failed To Register', 'register/single_step', FALSE);
            }
        }
        $this->loadView();
    }
    

    public function validate_single_step_registration() {
        $this->form_validation->set_rules('sponser_name', 'sponser_name', 'required|callback_validate_sponsor|trim');
        $this->form_validation->set_rules('username', 'username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required|matches[confirm_password]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('agree', 'agree', 'required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
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
        if (!$this->helper_model->getUserIdFromEmailId($username)) {
            $flag = true;
        }
        return $flag;
    }

}
