<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Member extends Base_Controller {

    function change_password() {
        $tab1 = 'active';
        $tab2 = $tab3 = '';

        $title = "Account Setting";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->BREADCRUM_DATA=array('page_title'=>$title,'page_sub_title'=>$title,'page_header'=>$title,'page_header_small'=>$title);
		
		$this->set_header_lang();
		
        if ($this->input->post('submit_password') && $this->validate_change_password()) {
            $tab1 = 'active';
            $tab2 = $tab3 = '';

            $pass_user_name = $this->input->post('pass_user_name');
            $pass_password = $this->input->post('pass_password');
            $pass_re_enter_password = $this->input->post('pass_re_enter_password');
            if ($pass_password == $pass_re_enter_password) {
                
            }
        }
        if ($this->input->post('submit_username') && $this->validate_change_username()) {
            $tab2 = 'active';
            $tab1 = $tab3 = '';

            $uname_user_name = $this->input->post('uname_user_name');
            $uname_new_username = $this->input->post('uname_new_username');
            $uname_re_entry_username = $this->input->post('uname_re_entry_username');
            if ($uname_new_username == $uname_re_entry_username) {
                
            }
        }
        if ($this->input->post('submit_transation')) {
            $tab3 = 'active';
            $tab1 = $tab2 = '';

            $tran_user_name = $this->input->post('tran_user_name');
            $tran_pass_password = $this->input->post('tran_pass_password');
            $tran_pass_re_enter_password = $this->input->post('tran_pass_re_enter_password');
            if ($tran_pass_password == $tran_pass_re_enter_password) {
                $user_user_id = $this->helper_model->userNameToID($user_name);
                $this->helper_model->insertActivity($user_user_id, 'change_password_admin', 'change password from admin');
                $this->member_model->updatePassword($user_name, $password);
            }
        }

        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->loadView();
    }

    function validate_change_password() {
        $this->form_validation->set_rules('pass_password', 'New Password', 'required');
        $this->form_validation->set_rules('tran_pass_password', 'User Name', 'required|callback_username_valid|trim');
        $this->form_validation->set_rules('tran_pass_re_enter_password', 'Re-Enter Password', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_change_username() {
        $this->form_validation->set_rules('uname_user_name', 'User Name', 'required|callback_username_exisit|trim');
        $this->form_validation->set_rules('uname_new_username', 'New User Name', 'required');
        $this->form_validation->set_rules('uname_re_entry_username', 'Re-Enter User Name', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_change_tran_password() {
        $this->form_validation->set_rules('tran_user_name', 'User Name', 'required');
        $this->form_validation->set_rules('uname_new_username', 'New User Name', 'required');
        $this->form_validation->set_rules('uname_re_entry_username', 'Re-Enter User Name', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function username_valid($field) {
        $this->member_model->checkUserNameExisit($field);
        $flag = false;
        if ($this->member_model->checkUserNameExisit($field)) {
            $flag = true;
        }
        return $flag;
    }

    function username_exisit($field) {
        $flag = true;
        if ($this->member_model->checkUserNameExisit($field)) {
            $flag = false;
        }
        return $flag;
    }

}
