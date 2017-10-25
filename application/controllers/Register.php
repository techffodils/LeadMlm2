<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'admin/Base_Controller.php';

class Register extends Base_Controller {

    public function single_step() {
        $register_data = array();
        $loggeg_user = $this->LOG_USER_ID;
        $mlm_plan = $this->dbvars->MLM_PLAN;
        $leg_type = $this->dbvars->REGISTER_LEG;
        $username_type = $this->dbvars->USERNAME_TYPE;
        $username_size = $this->dbvars->USERNAME_SIZE;
        $logged_username = $this->LOG_USER_NAME;
        $leg_status = FALSE;
        if ($mlm_plan == 'BINARY' && $leg_type == "static") {
            $leg_status = TRUE;
        }
        if ($this->input->post('add_user') && $this->validate_registration('single_step', $leg_status, $username_type)) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['register_type'] = 'single_step';
            if ($username_type == 'dynamic') {
                $user_details['username'] = $this->register_model->generateRandomUsername($username_size);
            }
            $res = $this->register_model->addUser('single_step', $user_details, $mlm_plan, $leg_status);
            if ($res) {
                $this->session->unset_userdata('single_step_post');
                $this->loadPage(lang('register_success'), 'register/single_step');
            } else {
                $this->loadPage(lang('register_failed'), 'register/single_step', 'danger');
            }
        }

        $register_data['sponser_name'] = $logged_username;
        if ($this->session->userdata('single_step_post') != null)
            $register_data = $this->session->userdata('single_step_post');

        $country = '';
        if (isset($register_data['country'])) {
            $country = $register_data['country'];
        }
        $countries = $this->register_model->getAllCountries();
        $states = $this->register_model->getAllStates($country);

        $this->setData('username_type', $username_type);
        $this->setData('username_size', $username_size);
        $this->setData('states', $states);
        $this->setData('countries', $countries);
        $this->setData('leg_status', $leg_status);
        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->setData('loggeg_user', $loggeg_user);
        $this->setData('title', lang('register'));
        $this->loadView();
    }

    public function multiple_step() {
        $register_data = array();
        $loggeg_user = $this->LOG_USER_ID;
        $logged_username = $this->LOG_USER_NAME;
        $mlm_plan = $this->dbvars->MLM_PLAN;
        $leg_type = $this->dbvars->REGISTER_LEG;
        $username_type = $this->dbvars->USERNAME_TYPE;
        $username_size = $this->dbvars->USERNAME_SIZE;
        $leg_status = FALSE;
        if ($mlm_plan == 'BINARY' && $leg_type == "static") {
            $leg_status = TRUE;
        }

        if ($this->input->post('add_user') && $this->validate_registration('multiple_step', $leg_status, $username_type)) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['register_type'] = 'multiple_step';
            if ($username_type == 'dynamic') {
                $user_details['username'] = $this->register_model->generateRandomUsername($username_size);
            }
            $res = $this->register_model->addUser('multiple_step', $user_details, $mlm_plan, $leg_status);
            if ($res) {
                $this->session->unset_userdata('multiple_step_post');
                $this->loadPage(lang('register_success'), 'register/multiple_step');
            } else {
                $this->loadPage(lang('register_failed'), 'register/multiple_step', 'danger');
            }
        }
        $register_data['sponser_name'] = $logged_username;
        if ($this->session->userdata('multiple_step_post') != null)
            $register_data = $this->session->userdata('multiple_step_post');

        $country = '';
        if (isset($register_data['country'])) {
            $country = $register_data['country'];
        }
        $countries = $this->register_model->getAllCountries();
        $states = $this->register_model->getAllStates($country);

        $this->setData('username_type', $username_type);
        $this->setData('username_size', $username_size);
        $this->setData('states', $states);
        $this->setData('countries', $countries);
        $this->setData('leg_status', $leg_status);
        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->setData('title', lang('register'));
        $this->loadView();
    }

    public function advanced() {
        $register_data = array();
        $loggeg_user = $this->LOG_USER_ID;
        $logged_username = $this->LOG_USER_NAME;
        $mlm_plan = $this->dbvars->MLM_PLAN;
        $leg_type = $this->dbvars->REGISTER_LEG;
        $username_type = $this->dbvars->USERNAME_TYPE;
        $username_size = $this->dbvars->USERNAME_SIZE;

        $leg_status = FALSE;
        if ($mlm_plan == 'BINARY' && $leg_type == "static") {
            $leg_status = TRUE;
        }
        $country = '';
        if (isset($register_data['country'])) {
            $country = $register_data['country'];
        }

        $fields = $this->register_model->getAllRegFields($country, $mlm_plan, $leg_type, $username_type);
        if ($this->input->post('add_user') && $this->validate_registration('advanced', $leg_status, $username_type)) {
            $user_details = $this->input->post();
            $user_details['date_of_joining'] = date('Y-m-d H:i:s');
            $user_details['payment_type'] = 'free_join';
            $user_details['register_type'] = 'advanced';
            if ($username_type == 'dynamic') {
                $user_details['username'] = $this->register_model->generateRandomUsername($username_size);
            }
            $res = $this->register_model->addUser('advanced', $user_details, $mlm_plan, $leg_status);
            if ($res) {
                $this->session->unset_userdata('advanced_post');
                $this->loadPage(lang('register_success'), 'register/advanced');
            } else {
                $this->loadPage(lang('register_failed'), 'register/advanced', 'danger');
            }
        }
        $register_data['sponser_name'] = $logged_username;
        if ($this->session->userdata('advanced_post') != null)
            $register_data = $this->session->userdata('advanced_post');

        $this->setData('username_type', $username_type);
        $this->setData('username_size', $username_size);
        $this->setData('leg_status', $leg_status);
        $this->setData('fields', $fields);
        $this->setData('register_data', $register_data);
        $this->setData('register_error', $this->form_validation->error_array());
        $this->setData('title', lang('register'));
        $this->loadView();
    }

    public function validate_registration($type, $leg_status = FALSE, $username_type = 'static') {
        $this->session->set_userdata($type . '_post', $this->input->post());

        $this->form_validation->set_rules('sponser_name', lang('sponser_name'), 'required|callback_validate_sponsor|trim');
        if ($leg_status) {
            $this->form_validation->set_rules('register_leg', lang('register_leg'), 'required');
        }
        if ($username_type == 'static') {
            $this->form_validation->set_rules('username', lang('username'), 'required|callback_validate_username|trim');
        }
        $this->form_validation->set_rules('email', lang('email'), 'required|valid_email|callback_valid_email');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required|matches[confirm_password]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', lang('confirm_password'), 'trim|required|min_length[6]');
        $this->form_validation->set_rules('first_name', lang('first_name'), 'required');
        $this->form_validation->set_rules('country', lang('country'), 'required');
        $this->form_validation->set_rules('agree', lang('agree'), 'required');
        if ($type == "multiple_step") {
            $this->form_validation->set_rules('phone_number', lang('phone_number'), 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('gender', lang('gender'), 'required');
            $this->form_validation->set_rules('address', lang('address'), 'required');
            $this->form_validation->set_rules('country', lang('country'), 'required');
            $this->form_validation->set_rules('zip_code', lang('zip_code'), 'numeric|greater_than[0]');
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
        } elseif ($this->input->get('username')) {
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
        } elseif ($this->input->get('username')) {
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
        } elseif ($this->input->get('email')) {
            if (!$this->helper_model->getUserIdFromEmailId($this->input->get('email'))) {
                echo 'yes';
                exit();
            }
            echo 'no';
            exit();
        }
    }

}
