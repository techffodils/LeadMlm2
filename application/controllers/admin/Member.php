<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Member extends Base_Controller {

    function account_settings() {
        $tab1 = 'active';
        $tab2 = $tab3 = $tab4 = '';

        $title = "Account Setting";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Account Setting');
        if ($this->input->post('submit_password') && $this->validate_change_password()) {
            $tab1 = 'active';
            $tab2 = $tab3 = $tab4 = '';
            $login_id = $this->main->get_usersession('mlm_user_id');
            $pass_password = $this->input->post('pass_password');
            $pass_re_enter_password = $this->input->post('pass_re_enter_password');
            if ($pass_password == $pass_re_enter_password) {
                $this->helper_model->insertActivity($login_id, 'change_password_user', 'change user password from user');
                $this->member_model->updateUserName($login_id, $pass_password);
            }
        }
        if ($this->input->post('submit_username') && $this->validate_change_username()) {
            $tab2 = 'active';
            $tab1 = $tab3 = $tab4 = '';
            $login_id = $this->main->get_usersession('mlm_user_id');
            $uname_new_username = $this->input->post('uname_new_username');
            $uname_re_entry_username = $this->input->post('uname_re_entry_username');
            if ($uname_new_username == $uname_re_entry_username) {
                $this->helper_model->insertActivity($login_id, 'change_username_user', 'change user name from user');
                $this->member_model->updateUserName($login_id, $uname_new_username);
            }
        }

        if ($this->input->post('submit_transation') && $this->validate_change_tran_password()) {
            $tab3 = 'active';
            $tab1 = $tab2 = $tab4 = '';
            $login_id = $this->main->get_usersession('mlm_user_id');
            $tran_pass_password = $this->input->post('tran_pass_password');
            $tran_pass_re_enter_password = $this->input->post('tran_pass_re_enter_password');
            if ($tran_pass_password == $tran_pass_re_enter_password) {
                $this->helper_model->insertActivity($login_id, 'change_transation_password_user', 'change Transation password from user');
                $this->member_model->updateTranPassword($login_id, $tran_pass_password);
            }
        }

        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('tab4', $tab4);
        $this->loadView();
    }

    function validate_change_password() {
        $this->form_validation->set_rules('pass_password', 'New Password', 'required');
        $this->form_validation->set_rules('pass_current_password', 'Current Password', 'required|callback_pass_valid');
        $this->form_validation->set_rules('pass_re_enter_password', 'Re-Enter Password', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_change_username() {
        $this->form_validation->set_rules('uname_current_username', 'Current User Name', 'required|callback_current_username_valid|trim');
        $this->form_validation->set_rules('uname_new_username', 'New User Name', 'required|callback_username_exisit');
        $this->form_validation->set_rules('uname_re_entry_username', 'Re-Enter User Name', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_change_tran_password() {
        $this->form_validation->set_rules('tran_pass_password', 'New Password', 'required');
        $this->form_validation->set_rules('tran_current_password', 'New Password', 'required|callback_tran_pass_valid');
        $this->form_validation->set_rules('tran_pass_re_enter_password', 'Re-Enter password', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function username_exisit($field) {
        $flag = true;
        if ($this->member_model->checkUserNameExisit($field)) {
            $flag = false;
        }
        return $flag;
    }

    function tran_pass_valid($field) {
        $login_id = $this->main->get_usersession('mlm_user_id');
        $old_tran_pass = $this->member_model->getTransationPassword($login_id);
        $flag = false;
        if ($field == $old_tran_pass) {
            $flag = true;
        }
        return $flag;
    }

    function pass_valid($field) {
        $login_id = $this->main->get_usersession('mlm_user_id');
        $old_password = $this->member_model->getTransationPassword($login_id);
        $sha_password = hash("sha256", $field);
        $flag = false;
        if ($sha_password == $old_password) {
            $flag = true;
        }
        return $flag;
    }

    function current_username_valid($field) {
        $login_id = $this->main->get_usersession('mlm_user_id');
        $old_username = $this->member_model->getUserName($login_id);
        $flag = false;
        if ($field == $old_username) {
            $flag = true;
        }
        return $flag;
    }

    function get_usernames() {
        $query = $this->input->post('query');
        $result = $this->member_model->getAllUserNames($query);
        echo $result;
        exit();
    }

    
}
