<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Configuration extends Base_Controller {

    public function set_register_fields($action = '', $field_id = '') {
        $error_array = $post = $post_data = array();
        if ($this->session->userdata('post_data') != null)
            $post_data = $this->session->userdata('post_data');
        if ($this->input->post('add_new')) {//add new fields
            $post = $this->input->post();
            if ($this->validate_field_addition()) {
                $res = $this->configuration_model->createDbField($post['field_name'], $post['data_types'], $post['data_type_max_size']);
                if ($res) {
                    $res = $this->configuration_model->addNewRegistrationField($post);
                    if ($res) {

                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'new_registration_field_added', $post);

                        $this->session->unset_userdata('post_data');
                        $this->loadPage('New Field Created Successfully', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                    }
                } else {
                    $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->session->set_userdata('post_data', $post);
                $error_array = $this->form_validation->error_array();
                print_r($error_array);die();
                $this->loadPage('Validation Error', 'configuration/set_register_fields', FALSE);
            }
        }




        $edit_status = FALSE;
        $editable_fields = array();
        if ($field_id && $action) {//update new fields
            if ($this->configuration_model->checkFieldEligibility($field_id)) {
                if ($action == 'activate') {

                    $actived_field['id'] = $field_id;
                    $res = $this->configuration_model->changeFieldStatus($field_id, 'active');
                    if ($res) {
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'registration_field_activated', $actived_field);

                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'inactivate') {
                    $this->configuration_model->changeFieldStatus($field_id, 'inactive');
                    if ($res) {

                        $inactivated_data['id'] = $field_id;
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'registration_field_inactivated', $inactivated_data);

                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'delete') {

                    $this->configuration_model->changeFieldStatus($field_id, 'deleted');
                    if ($res) {
                        $deletedted_data['id'] = $field_id;
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'registration_field_deleted', $deletedted_data);

                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'edit') {
                    $edit_status = TRUE;
                    $post_data = $this->configuration_model->getRegFieldDetails($field_id);
                } else {
                    $this->loadPage('Invalid Action', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->loadPage('This Field Can not be Edited', 'configuration/set_register_fields', FALSE);
            }
        }

        if ($this->input->post('update_field')) {//add new fields
            $post = $this->input->post();
            if ($this->configuration_model->checkFieldEligibility($post['edited_field'])) {
                if ($this->validate_field_updation()) {
                    $old_name = $this->configuration_model->getFieldOldName($post['edited_field']);
                    if ($this->configuration_model->checkTable($old_name)) {
                        $upd_res = $this->configuration_model->alterDbField($post['field_name'], $post['data_types'], $post['data_type_max_size'], $old_name);
                    } else {
                        $upd_res = $this->configuration_model->createDbField($post['field_name'], $post['data_types'], $post['data_type_max_size']);
                    }
                    if ($upd_res) {
                        $res = $this->configuration_model->updateRegistrationField($post);
                        if ($res) {

                            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'registration_field_updated', $post);

                            $this->loadPage('Registration Field Updated Successfully', 'configuration/set_register_fields', True);
                        } else {
                            $this->loadPage('Failed To Update', 'configuration/set_register_fields', FALSE);
                        }
                    } else {
                        $this->loadPage('Failed To Update', 'configuration/set_register_fields', FALSE);
                    }
                } else {
                    $this->loadPage('Validation Error', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->loadPage('This Field Can not be Edited', 'configuration/set_register_fields', FALSE);
            }
        }


        if ($this->input->post('update_cancel')) {//cancel updates
            $this->loadPage('Updation Canceled', 'configuration/set_register_fields', TRUE);
        }
        $fields = $this->configuration_model->getAllRegFields();


        $this->setData('fields', $fields);
        $this->setData('post_data', $post_data);
        $this->setData('edit_status', $edit_status);
        $this->setData('edited_field', $field_id);
        $this->loadView();
    }

    function validate_field_addition() {
        $this->form_validation->set_rules('field_name', 'field_name', 'required|callback_validate_field|trim');
        $this->form_validation->set_rules('required_status', 'required_status', 'required');
        $this->form_validation->set_rules('register_step', 'register_step', 'required');
        $this->form_validation->set_rules('order', 'order', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('unique_status', 'unique_status', 'required');
        $this->form_validation->set_rules('data_types', 'data_types', 'required');
        if ($this->input->post('data_types') != 'double' && $this->input->post('data_types') != 'text') {
            $this->form_validation->set_rules('data_type_max_size', 'data_type_max_size', 'required|numeric|greater_than[0]');
        }

        $this->form_validation->set_rules('field_type', 'field_type', 'required');
        if ($this->input->post('field_type') == 'radio') {
            $this->form_validation->set_rules('radio_value1', 'radio_value1', 'required');
            $this->form_validation->set_rules('radio_value2', 'radio_value2', 'required');
        }
        if ($this->input->post('field_type') == 'select_box') {
            $this->form_validation->set_rules('select_option1', 'select_option1', 'required');
            $this->form_validation->set_rules('select_option2', 'select_option2', 'required');
            $this->form_validation->set_rules('select_option3', 'select_option3', 'required');
            $this->form_validation->set_rules('select_option4', 'select_option4', 'required');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_field_updation() {
        $this->form_validation->set_rules('field_name', 'field_name', 'required|callback_validate_field_update|trim');
        $this->form_validation->set_rules('required_status', 'required_status', 'required');
        $this->form_validation->set_rules('register_step', 'register_step', 'required');
        $this->form_validation->set_rules('order', 'order', 'requiredrequired|is_natural|numeric|greater_than[0]');
        $this->form_validation->set_rules('unique_status', 'unique_status', 'required');
        $this->form_validation->set_rules('data_types', 'data_types', 'required');
        if ($this->input->post('data_types') != 'double' && $this->input->post('data_types') != 'text') {
            $this->form_validation->set_rules('data_type_max_size', 'data_type_max_size', 'requiredrequired|is_natural|numeric|greater_than[0]');
        }

        $this->form_validation->set_rules('field_type', 'field_type', 'required');
        if ($this->input->post('field_type') == 'radio') {
            $this->form_validation->set_rules('radio_value1', 'radio_value1', 'required');
            $this->form_validation->set_rules('radio_value2', 'radio_value2', 'required');
        }
        if ($this->input->post('field_type') == 'select_box') {
            $this->form_validation->set_rules('select_option1', 'select_option1', 'required');
            $this->form_validation->set_rules('select_option2', 'select_option2', 'required');
            $this->form_validation->set_rules('select_option3', 'select_option3', 'required');
            $this->form_validation->set_rules('select_option4', 'select_option4', 'required');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_field($field) {
        $flag = true;
        $edit_field = $this->input->post('edited_field');
        if ($this->configuration_model->checkField($field) || $this->configuration_model->checkTable($field)) {
            $flag = false;
        }
        return $flag;
    }

    function validate_field_update($field) {
        $flag = true;
        $edit_field = $this->input->post('edited_field');
        if ($this->configuration_model->checkUpdatingField($field, $edit_field)) {
            $flag = false;
        }
        return $flag;
    }

    public function plan_settings() {
        $tab1 = $tab2 = $tab3 = $tab3 = $tab4 = $tab5 = $tab6 = '';
        if ($this->session->userdata('plan_active_tab') == '') {
            $this->session->set_userdata('plan_active_tab', 'tab1');
        }

        $mlm_plan = $this->dbvars->MLM_PLAN;

//        if ($this->input->post('bonus_settings') && $this->validate_bonus_settings($mlm_plan)) {
//            $this->session->set_userdata('plan_active_tab', 'tab2');
//            $post = $this->input->post();
//            if ($this->dbvars->MLM_PLAN == "BINARY")
//                $this->dbvars->PAIR_BONUS = $post['pair_bonus'];
//            $this->dbvars->REFEAL_BONUS = $post['referal_bonus'];
//            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
//            $this->loadPage('Bonus Settings Changed', 'configuration/plan_settings', TRUE);
//        }elseif ($this->input->post('username_settings') && $this->validate_username_settings()) {
//            $this->session->set_userdata('plan_active_tab', 'tab3');
//            $post = $this->input->post();
//            $this->dbvars->USERNAME_TYPE = $post['username_type'];
//            $this->dbvars->USERNAME_PREFIX = $post['username_prefix'];
//            $this->dbvars->USERNAME_SIZE = $post['username_size'];
//            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
//            $this->loadPage('Username Settings Changed', 'configuration/plan_settings', TRUE);
//        } elseif ($this->input->post('matrix_settings') && $this->validate_matrix_settings()) {
//            $this->session->set_userdata('plan_active_tab', 'tab5');
//            $post = $this->input->post();
//            $this->dbvars->MATRIX_WIDTH = $post['matrix_width'];
//            $this->dbvars->MATRIX_DEPTH = $post['matrix_depth'];
//            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
//            $this->loadPage('Depth & Width Changed', 'configuration/plan_settings', TRUE);
//        } elseif ($this->input->post('leg_settings') && $this->validate_leg_settings()) {
//            $this->session->set_userdata('plan_active_tab', 'tab6');
//            $post = $this->input->post();
//            $this->dbvars->REGISTER_LEG = $post['register_leg'];
//            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
//            $this->loadPage('User Position Changed', 'configuration/plan_settings', TRUE);
//        }

        $payment_method = $this->configuration_model->getAllPaymentMethods();

        $pair_bonus = $this->dbvars->PAIR_BONUS;
        $referal_bonus = $this->dbvars->REFEAL_BONUS;
        $username_type = $this->dbvars->USERNAME_TYPE;
        $username_prefix = $this->dbvars->USERNAME_PREFIX;
        $username_size = $this->dbvars->USERNAME_SIZE;
        $register_form_type = $this->dbvars->REGISTER_FORM_TYPE;
        $register_field_configuration = $this->dbvars->REGISTER_FIELD_CONFIGURATION;
        $matrix_depth = $this->dbvars->MATRIX_DEPTH;
        $matrix_width = $this->dbvars->MATRIX_WIDTH;
        $register_leg = $this->dbvars->REGISTER_LEG;

        $this->setData('register_leg', $register_leg);
        $this->setData('matrix_depth', $matrix_depth);
        $this->setData('matrix_width', $matrix_width);
        $this->setData('register_form_type', $register_form_type);
        $this->setData('register_field_configuration', $register_field_configuration);
        $this->setData('payment_method', $payment_method);
        $this->setData('mlm_plan', $mlm_plan);
        $this->setData('pair_bonus', $pair_bonus);
        $this->setData('referal_bonus', $referal_bonus);
        $this->setData('username_type', $username_type);
        $this->setData('username_prefix', $username_prefix);
        $this->setData('username_size', $username_size);

        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('tab4', $tab4);
        $this->setData('tab5', $tab5);
        $this->setData('tab6', $tab6);
        $this->setData($this->session->userdata('plan_active_tab'), 'active');
        $this->loadView();
    }

    function change_bonus_settings() {
        $post = $this->input->get();
        if ($post['referal_bonus']>=0) {
            if ($this->dbvars->MLM_PLAN == "BINARY")
                $this->dbvars->PAIR_BONUS = $post['pair_bonus'];
            $this->dbvars->REFEAL_BONUS = $post['referal_bonus'];
            $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function change_username_settings() {
        $post = $this->input->get();
        if ($post['username_type'] && $post['username_size'] && $post['username_prefix']) {
            $this->dbvars->USERNAME_TYPE = $post['username_type'];
            $this->dbvars->USERNAME_PREFIX = $post['username_prefix'];
            $this->dbvars->USERNAME_SIZE = $post['username_size'];
            $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function change_leg_settings() {
        $post = $this->input->get();
        if ($post['register_leg']) {
            $this->dbvars->REGISTER_LEG = $post['register_leg'];
            $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function change_matrix_settings() {

        $post = $this->input->get();
        if ($post['matrix_width'] && $post['matrix_depth']) {
            $this->dbvars->MATRIX_WIDTH = $post['matrix_width'];
            $this->dbvars->MATRIX_DEPTH = $post['matrix_depth'];
            $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'plan_settings_changed', $post);
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function validate_bonus_settings($mlm_plan) {
        $this->form_validation->set_rules('referal_bonus', 'referal_bonus', 'required|is_natural');
        if ($mlm_plan == "BINARY") {
            $this->form_validation->set_rules('pair_bonus', 'pair_bonus', 'required|is_natural');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_username_settings() {
        $this->form_validation->set_rules('username_type', 'username_type', 'required');
        $this->form_validation->set_rules('username_prefix', 'username_prefix', 'max_length[4]');
        $this->form_validation->set_rules('username_size', 'username_size', 'required|is_natural|numeric|greater_than[4]|less_than[16]');

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_matrix_settings() {
        $this->form_validation->set_rules('matrix_width', 'matrix_width', 'required|is_natural|numeric|greater_than[0]');
        $this->form_validation->set_rules('matrix_depth', 'matrix_depth', 'required|is_natural|numeric|greater_than[0]');

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_leg_settings() {
        $this->form_validation->set_rules('register_leg', 'register_leg', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function change_payment_status() {
        $this->session->set_userdata('plan_active_tab', 'tab1');
        $payment_code = $this->input->get('payment_code');
        $status = $this->input->get('status');
        if ($payment_code && $status) {
            $res = $this->configuration_model->changePaymentStatus($payment_code, $status);
            if ($res) {
                $post['code'] = $payment_code;
                $post['status'] = $status;
                $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'payment_status_changes', $post);

                echo 'yes';
                exit;
            }
        }
        echo 'no';
    }

    function change_reg_field_status() {
        $this->session->set_userdata('plan_active_tab', 'tab4');
        $status = $this->input->get('status');
        if ($status == 'active' || $status == 'inactive') {
            $this->dbvars->REGISTER_FIELD_CONFIGURATION = $status;
            $post['status'] = $status;
            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'reg_field_config_changes', $post);

            echo 'yes';
            exit;
        }
        echo 'no';
    }

    function change_register_form_type() {
        $this->session->set_userdata('plan_active_tab', 'tab4');
        $status = $this->input->get('status');
        if ($status == 'single' || $status == 'multiple') {
            $this->dbvars->REGISTER_FORM_TYPE = $status;
            $post['status'] = $status;
            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'reg_form_type_changes', $post);

            echo 'yes';
            exit;
        }
        echo 'no';
    }

    public function multiple_options() {
        $error_array = $post = array();
        $langs = $this->configuration_model->getLanguages();
        $curns = $this->configuration_model->getCurrencies();
        $default_currency = $this->dbvars->DEFAULT_CURRENCY_CODE;
        $default_currency_symbol = $this->configuration_model->getCurrencySymbol($default_currency);
        $this->setData('default_currency', $default_currency);
        $this->setData('default_currency_symbol', $default_currency_symbol);
        $this->setData('langs', $langs);
        $this->setData('curns', $curns);
        $this->loadView();
    }

    public function change_language_status() {
        $lang_id = $this->input->get('lang_id');
        $status = $this->input->get('status');
        if ($lang_id && $status) {
            $flag = 0;
            if ($status == 'active')
                $flag = 1;
            if ($this->configuration_model->changeLanguageStatus($lang_id, $flag)) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
    }

    public function change_currency_status() {
        $currency_id = $this->input->get('currency_id');
        $status = $this->input->get('status');
        if ($currency_id && $status) {
            $flag = 0;
            if ($status == 'active')
                $flag = 1;
            if ($this->configuration_model->changeCurrencyStatus($currency_id, $flag)) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
    }

}
