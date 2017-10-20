<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'admin/Base_Controller.php';

class Register extends Base_Controller {

    public function single_step() {
        $loggeg_user=$this->main->get_usersession('mlm_user_id');
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
        $register_data=array();
        if ($this->session->userdata('single_step_post') != null)
            $register_data = $this->session->userdata('single_step_post');

        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->setData('loggeg_user', $loggeg_user);
        $this->loadView();
    }

    public function multiple_step() {
        $register_data = array();

        if ($this->input->post('add_user') && $this->validate_registration('multiple_step')) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['state_id'] = '1';
            $user_details['country_id'] = '1';
            $user_details['register_type'] = 'multiple_step';
            $res = $this->register_model->addUser('multiple_step', $user_details);
            if ($res) {
                $this->session->unset_userdata('multiple_step_post');
                $this->loadPage('User Registered Successfully', 'register/multiple_step', True);
            } else {                
                $this->loadPage('Failed To Register', 'register/multiple_step', FALSE);
            }
        }
        if ($this->session->userdata('multiple_step_post') != null)
            $register_data = $this->session->userdata('multiple_step_post');

        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->loadView();
    }

    public function advanced() {
        $register_data = array();
        $fields=$this->register_model->getAllRegFields();
        if ($this->input->post('add_user') && $this->validate_registration('advanced')) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['state_id'] = '1';
            $user_details['country_id'] = '1';
            $user_details['register_type'] = 'advanced';
            $res = $this->register_model->addUser('advanced', $user_details);
            if ($res) {
                $this->session->unset_userdata('advanced_post');
                $this->loadPage('User Registered Successfully', 'register/advanced', True);
            } else {                
                $this->loadPage('Failed To Register', 'register/advanced', FALSE);
            }
        }
        if ($this->session->userdata('advanced_post') != null)
            $register_data = $this->session->userdata('advanced_post');
        $this->setData('fields', $fields);
        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->loadView();
    }

    public function validate_registration($type) {
        $this->session->set_userdata($type . '_post', $this->input->post());

        $this->form_validation->set_rules('sponser_name', 'sponser_name', 'required|callback_validate_sponsor|trim');
        $this->form_validation->set_rules('username', 'username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required|matches[confirm_password]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('agree', 'agree', 'required');
        if ($type == "multiple_step") {
            $this->form_validation->set_rules('phone_number', 'phone_number', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('gender', 'gender', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('zip_code', 'zip_code', 'numeric|greater_than[0]');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_sponsor($username = '') {
        if ($username != '') {
            $flag = false;
            if ($this->helper_model->userNameToID($username)) {
                $flag = true;
            }
            return $flag;
        } elseif($this->input->get('username')) {
            if ($this->helper_model->userNameToID($this->input->get('username'))) {
                echo 'yes';
                exit();
            }
            echo 'no';
            exit();
        }
    }

    function validate_username($username = '') {
        if ($username != '') {
            $flag = false;
            if (!$this->helper_model->userNameToID($username)) {
                $flag = true;
            }
            return $flag;
        } elseif($this->input->get('username')) {
            if (!$this->helper_model->userNameToID($this->input->get('username'))) {
                echo 'yes';
                exit();
            }
            echo 'no';
            exit();
        }
    }

    function valid_email($email = '') {
        if ($email != '') {
            $flag = false;
            if (!$this->helper_model->getUserIdFromEmailId($email)) {
                $flag = true;
            }
            return $flag;
        } elseif($this->input->get('email')) {
            if (!$this->helper_model->getUserIdFromEmailId($this->input->get('email'))) {
                echo 'yes';
                exit();
            }
            echo 'no';
            exit();
        }
    }

}
