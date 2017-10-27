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
            $user_details['register_type'] = 'single_step';
            if ($username_type == 'dynamic') {
                $user_details['username'] = $this->register_model->generateRandomUsername($username_size);
            }
            //$payment_method = $user_details['payment_method'];
            $payment_method = $user_details['add_user'];
            //Action based on payment method
            if ($payment_method == "free_registration") {
                $payment_status = TRUE; //for testing purpose only
            } elseif ($payment_method == "bank_transfer") {
                die('insert pending status');
            } elseif ($payment_method == "ewallet") {
                die('ewallet_operation');
            } elseif ($payment_method == "epin") {
                die('epin_operation');
            }
            //Action based on payment method

            if ($payment_method == "free_registration") {
                $payment_status = TRUE; //for testing purpose only
            } elseif ($payment_method == "bank_transfer") {
                die('insert pending status');
            } elseif ($payment_method == "ewallet") {
                die('ewallet_operation');
            } elseif ($payment_method == "epin") {
                die('epin_operation');
            }
            $user_details['payment_type'] = $payment_method;
            if ($payment_status) {
                $res = $this->register_model->addUser('single_step', $user_details, $mlm_plan, $leg_status);
                if ($res) {
                    $this->session->unset_userdata('single_step_post');
                    $this->loadPage(lang('register_success'), 'register/single_step');
                } else {
                    $this->loadPage(lang('register_failed'), 'register/single_step', 'danger');
                }
            } else {
                $this->loadPage(lang('payment_failed'), 'register/single_step', 'danger');
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

        //$payment_options = $this->register_model->getAvailablePaymentMethods();

        $free_registration = $this->register_model->getPaymentMethodStatus('free_registration');
        $bank_transfer = $this->register_model->getPaymentMethodStatus('bank_transfer');
        $ewallet = $this->register_model->getPaymentMethodStatus('ewallet');
        $epin = $this->register_model->getPaymentMethodStatus('epin');

        $free_registration_tab = $bank_transfer_tab = $ewallet_tab = $epin_tab = '';
        if ($free_registration) {
            $free_registration_tab = "active";
        } elseif ($bank_transfer) {
            $bank_transfer_tab = "active";
        } elseif ($ewallet) {
            $ewallet_tab = "active";
        } elseif ($epin) {
            $epin_tab = "active";
        }
        $this->setData('free_registration', $free_registration);
        $this->setData('bank_transfer', $bank_transfer);
        $this->setData('ewallet', $ewallet);
        $this->setData('epin', $epin);

        $this->setData('free_registration_tab', $free_registration_tab);
        $this->setData('bank_transfer_tab', $bank_transfer_tab);
        $this->setData('ewallet_tab', $ewallet_tab);
        $this->setData('epin_tab', $epin_tab);
        
        $this->setData('terms_and_condition', $this->dbvars->TERMS_AND_CONDITION);
        $this->setData('privacy_policy', $this->dbvars->PRIVACY_POLICY);
        //$this->setData('payment_options', $payment_options);
        $this->setData('entry_fee', $this->dbvars->ENTRI_FEE);

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
            $user_details['register_type'] = 'multiple_step';
            if ($username_type == 'dynamic') {
                $user_details['username'] = $this->register_model->generateRandomUsername($username_size);
            }

            $payment_method = $user_details['add_user'];
            //Action based on payment method
            if ($payment_method == "free_registration") {
                $payment_status = TRUE; //for testing purpose only
            } elseif ($payment_method == "bank_transfer") {
                die('insert pending status');
            } elseif ($payment_method == "ewallet") {
                die('ewallet_operation');
            } elseif ($payment_method == "epin") {
                die('epin_operation');
            }
            $user_details['payment_method'] = $payment_method;
            if ($payment_status) {
                $res = $this->register_model->addUser('multiple_step', $user_details, $mlm_plan, $leg_status);
                if ($res) {
                    $this->session->unset_userdata('multiple_step_post');
                    $this->loadPage(lang('register_success'), 'register/multiple_step');
                } else {
                    $this->loadPage(lang('register_failed'), 'register/multiple_step', 'danger');
                }
            } else {
                $this->loadPage(lang('payment_failed'), 'register/multiple_step', 'danger');
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

        $free_registration = $this->register_model->getPaymentMethodStatus('free_registration');
        $bank_transfer = $this->register_model->getPaymentMethodStatus('bank_transfer');
        $ewallet = $this->register_model->getPaymentMethodStatus('ewallet');
        $epin = $this->register_model->getPaymentMethodStatus('epin');

        $free_registration_tab = $bank_transfer_tab = $ewallet_tab = $epin_tab = '';
        if ($free_registration) {
            $free_registration_tab = "active";
        } elseif ($bank_transfer) {
            $bank_transfer_tab = "active";
        } elseif ($ewallet) {
            $ewallet_tab = "active";
        } elseif ($epin) {
            $epin_tab = "active";
        }
        $this->setData('free_registration', $free_registration);
        $this->setData('bank_transfer', $bank_transfer);
        $this->setData('ewallet', $ewallet);
        $this->setData('epin', $epin);

        $this->setData('free_registration_tab', $free_registration_tab);
        $this->setData('bank_transfer_tab', $bank_transfer_tab);
        $this->setData('ewallet_tab', $ewallet_tab);
        $this->setData('epin_tab', $epin_tab);


        $this->setData('terms_and_condition', $this->dbvars->TERMS_AND_CONDITION);
        $this->setData('privacy_policy', $this->dbvars->PRIVACY_POLICY);
        //$this->setData('payment_options',$payment_options);
        $this->setData('entry_fee', $this->dbvars->ENTRI_FEE);

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

        $free_registration = $this->register_model->getPaymentMethodStatus('free_registration');
        $bank_transfer = $this->register_model->getPaymentMethodStatus('bank_transfer');
        $ewallet = $this->register_model->getPaymentMethodStatus('ewallet');
        $epin = $this->register_model->getPaymentMethodStatus('epin');

        $free_registration_tab = $bank_transfer_tab = $ewallet_tab = $epin_tab = '';
        if ($free_registration) {
            $free_registration_tab = "active";
        } elseif ($bank_transfer) {
            $bank_transfer_tab = "active";
        } elseif ($ewallet) {
            $ewallet_tab = "active";
        } elseif ($epin) {
            $epin_tab = "active";
        }
        $this->setData('free_registration', $free_registration);
        $this->setData('bank_transfer', $bank_transfer);
        $this->setData('ewallet', $ewallet);
        $this->setData('epin', $epin);

        $this->setData('free_registration_tab', $free_registration_tab);
        $this->setData('bank_transfer_tab', $bank_transfer_tab);
        $this->setData('ewallet_tab', $ewallet_tab);
        $this->setData('epin_tab', $epin_tab);


        $this->setData('terms_and_condition', $this->dbvars->TERMS_AND_CONDITION);
        $this->setData('privacy_policy', $this->dbvars->PRIVACY_POLICY);
        $this->setData('entry_fee', $this->dbvars->ENTRI_FEE);
        
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
        $this->form_validation->set_rules('privacy_policy', lang('privacy_policy'), 'required');
        if ($type == "single_step") {
            $this->form_validation->set_rules('payment_method', lang('payment_method'), 'required');
        } elseif ($type == "multiple_step") {
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

    function get_states() {
        $options = "<select class='form-control' id='state' name='state'><option>" . lang('select_a_state') . "</option>";

        if ($this->input->get('country_id')) {
            $states = $this->register_model->getAllStates($this->input->get('country_id'));
            foreach ($states as $s) {
                $options.="<option value='" . $s['id'] . "'>" . $s['name'] . "</option>";
            }
        }
        $options.="</select>";

        echo $options;
    }

}
