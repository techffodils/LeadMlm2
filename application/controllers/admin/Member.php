<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Member extends Base_Controller {

    function change_password() {
        $title = "Change Password";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Change Password');
         if ($this->input->post() && $this->validate_change_password()) {
            echo 'asd';
            die;
//            $post = $this->input->post();
        }
        $this->loadView();
    }

    function change_username() {
        $title = "Change User Name";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Change User Name');

//         if ($this->input->post() && $this->validate_register_config()) {//add new fields
        if ($this->input->post()) {
            echo 'asd';
            die;
//            $post = $this->input->post();
        }

        $this->loadView();
    }

    function validate_change_password() {
       // echo'asdasd';die;
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('user_name', 'User Name', 'required|callback_username_valid|trim');
        $this->form_validation->set_rules('re_entry_password', 'Re-Enter Password', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_change_username() {
        $this->form_validation->set_rules('user_name', 'User Name', 'required|callback_username_exisit|trim');
        $this->form_validation->set_rules('new_username', 'New User Name', 'required');
        $this->form_validation->set_rules('re_entry_username', 'Re-Enter User Name', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function username_valid($field) {
        echo $this->member_model->checkUserNameExisit($field);die();
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
