<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Base_Controller.php';

class Employee extends Base_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * 
     * 
     * For Employee Enroll
     * @author Techffodils
     * @date 2017-10-23
     */
    function employee_register() {
        $title = lang('employee_enroll');
        $this->setData('title', $title);

        $page = $this->CURRENT_CLASS . '/' . $this->CURRENT_METHOD;

        $get_all_details = $this->employee_model->getAllRegisteredEmployee();



        if ($this->input->post() && $this->validate_employee_enroll()) {

            $post_arr = $this->input->post(NULL, TRUE);

            $post_arr['user_id'] = $this->LOG_USER_ID;
            $result = $this->employee_model->enrollEmployee($post_arr);

            if ($result) {
                $msg = lang('employee_enroll_successfully');
                $this->loadPage($msg, $page);
            } else {
                $msg = lang('error_while_enroll_emplyee');
                $this->loadPage($msg, $page);
            }
        } else {
            $this->setData('error', $this->form_validation->error_array());
        }

        $this->setData('details', $get_all_details);

        $this->loadView();
    }

    function validate_employee_enroll() {

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|callback_username_exits');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required|min_length[2]');
        $this->form_validation->set_rules('password_again', lang('password_again'), 'trim|required|matches[password]');
        $this->form_validation->set_rules('firstname', lang('first_name'), 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('lastname', lang('last_name'), 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|alpha_dash');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|numeric');
        $this->form_validation->set_rules('gender', lang('gender'), 'trim|required');
        $this->form_validation->set_rules('month', lang('month'), 'trim|required');
        $this->form_validation->set_rules('day', lang('day'), 'trim|required');
        $this->form_validation->set_rules('year', lang('year'), 'trim|required');
        $this->form_validation->set_rules('country', lang('country'), 'trim|required');
        $this->form_validation->set_rules('zipcode', lang('zipcode'), 'trim|required');
        $validation_result = $this->form_validation->run();
        //print_r(validation_errors());die;
        return $validation_result;
    }

    /**
     * 
     * 
     * For Validate UserName exists or not
     * @author Techffodils
     * @date 2017-10-23
     */
    function username_exits($user_name) {
        $flag = true;
        $result = $this->employee_model->checkIsUserNameExistsOrNot($user_name);
        if ($result) {
            $flag = TRUE;
        }
        return $flag;
    }

    /**
     * 
     * 
     * For Edit Option 
     * @author Techffodils
     * @date 2017-10-23
     * 
     */
    function edit_form() {
        $title = lang('edit_employee_form');
        $id = $this->uri->segment(4);
        $edit_single_data = $this->employee_model->getSelectedUserData($id);
        if ($this->input->post() && $this->validate_employee_enroll()) {
            $post_arr = $this->input->post(NULL, TRUE);
            $post_arr['id'] = $id;
            $post_arr['user_id'] = $this->LOG_USER_ID;
            $result = $this->employee_model->updateEmployeeDetails($post_arr);
            if ($result) {
                $msg = lang('successfully_update_employee_details');
                $this->loadPage($msg, 'employee/employee_register');
            } else {
                $msg = lang('error_while_update_employee_deials');
                $this->loadPage($msg, 'employee/employee_edit/' . $id);
            }
        } else {
            $this->setData('error', $this->form_validation->error_array());
        }
        $this->setData('edit_details', $edit_single_data);
        $this->loadView();
    }

    /**
     * 
     * For Delete Option 
     * @author Techffodils
     * @date 2017-10-23
     */
    function delete_form() {
        $id = $this->uri->segment(4);
        $result = $this->employee_model->deleteEmployee($id);
        if ($result) {
            $msg = lang('employee_deleted_successfully');
            $this->loadPage($msg, 'employee/employee_register');
        } else {
            $msg = lang('error_while_delete_an_employee');
            $this->loadPage($msg, 'employee/employee_register', false);
        }
    }

    /**
     * For activate Employee
     * @author Techffodils
     * @date 2017-10-23
     * 
     * 
     */
    function activate_employee() {
        $activate_id = $this->uri->segment(4);
        $result = $this->employee_model->editEmployee($activate_id);
        if ($result) {
            $msg = lang('employee_activated_successfully');
            $this->loadPage($msg, 'employee/employee_register');
        } else {
            $msg = lang('error_while_activate_an_employee');
            $this->loadPage($msg, 'employee/employee_register', false);
        }
    }

}
