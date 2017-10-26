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

    function update_transation() {
        $post = $this->input->get();
        $tran_current_password = $post['tran_current_password'];
        $tran_pass_password = $post['tran_pass_password'];
        $tran_pass_re_enter_password = $post['tran_pass_re_enter_password'];
        $user_id = $this->LOG_USER_ID;
        $old_tran_pass = $this->member_model->getTransationPassword($user_id);
        if ($tran_current_password == $old_tran_pass) {
            if ($tran_pass_password == $tran_pass_re_enter_password && $tran_pass_password != '' && $tran_pass_re_enter_password != '') {
                $this->helper_model->insertActivity($user_id, 'change_transation_password_user', $post);
                $res = $this->member_model->updateTranPassword($user_id, $tran_pass_password);
                if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change Transation Password Is Error...!!";
                    exit;
                }
            } else {
                echo "Empty Or MissMatching.Please Try Again..!";
                exit;
            }
        } else {
            echo"Current Password Is Invalid..!";
            exit;
        }
    }

    function update_username() {
        $post = $this->input->get();
        $uname_current_username = $post['uname_current_username'];
        $uname_new_username = $post['uname_new_username'];
        $uname_re_entry_username = $post['uname_re_entry_username'];
        $user_id = $this->LOG_USER_ID;
        $old_username = $this->member_model->getUserName($user_id);

        if ($uname_current_username == $old_username) {

            if ($uname_new_username == $uname_re_entry_username && $uname_new_username != '' && $uname_re_entry_username != '') {
                $exisit = $this->member_model->checkUserNameExisit($uname_new_username);
                if ($exisit) {
                    echo "Username Is Alredy Exist Sorry.!!";
                    exit;
                }
                $res = $this->member_model->updateUserName($user_id, $uname_new_username);
                $this->helper_model->insertActivity($user_id, 'change_username_admin', 'change user Name from admin');
                if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change User Name Is Error...!!";
                    exit;
                }
            } else {
                echo "UserName Empty Or MissMatching.. Please Try Again..!!";
                exit;
            }
        } else {
            echo'Current UserName is Invalid ..!';
            exit;
        }
    }

    function update_password() {
        $post = $this->input->get();
        $pass_current_password = $post['pass_current_password'];
        $pass_password = $post['pass_password'];
        $pass_re_enter_password = $post['pass_re_enter_password'];
        $user_id = $this->LOG_USER_ID;
        $old_password = $this->member_model->getPassword($user_id);
        $sha_password = hash("sha256", $pass_current_password);
        if ($old_password == $sha_password) {
            if ($pass_password == $pass_re_enter_password && $pass_password != '' && $pass_re_enter_password != '') {
                $res = $this->member_model->updatePassword($user_id, $pass_password);
                $this->helper_model->insertActivity($user_id, 'change_password_user', $post);
                if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change Password Is Error...!!";
                    exit;
                }
            } else {
                echo "Password Empty Or MissMatching.. Please Try Again..!!";
                exit;
            }
        } else {
            echo'Current Password Is Invalid..!';
            exit;
        }
    }

}
