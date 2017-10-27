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
            if ($_FILES['user_photo']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/employees/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['user_photo']['name'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('user_photo')) {
                    $uploadData = $this->upload->data();
                    $post_arr['photo'] = $uploadData['file_name'];
                } else {
                    $post_arr['photo'] = '';
                }
            }

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
        $this->setData('page_header', $title);

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
        $flag = FALSE;
        if ($user_name != '') {
            $result = $this->employee_model->checkIsUserNameExistsOrNot($user_name);
            if ($result) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $user_name = $this->input->post('username');
            $res = $this->employee_model->checkIsUserNameExistsOrNot($user_name);
            if ($res) {
                echo 'yes';
                exit();
            } else {
                echo 'no';
                exit();
            }
        }
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
        if ($this->input->post() && $this->update_form_validation()) {
            $post_arr = $this->input->post(NULL, TRUE);
            $post_arr['id'] = $id;
            $post_arr['user_id'] = $this->LOG_USER_ID;
            if ($_FILES['user_photo']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/employees';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['user_photo']['name'];

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('user_photo')) {
                    $uploadData = $this->upload->data();
                    $post_arr['photo'] = $uploadData['file_name'];
                } else {
                    $post_arr['photo'] = '';
                }
            } else {
                $post_arr['photo'] = $edit_single_data['user_photo'];
            }

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

    /**
     * 
     * @author Techffodils
     * @date 2017-10-23
     * for form validation for update
     * 
     * 
     */
    function update_form_validation() {
        $this->input->post(NULL, TRUE);
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

        return $validation_result;
    }

    /**
     * 
     * For Set Employee Permission
     * 
     * @date 2017-10-23
     * 
     * @author Tcehffofils <techffodils@gmail.com>
     * 
     */
    function menu_permission() {
        $title = lang('set_employee_permission');
        $this->setData('title', $title);

        $flag = $checked = FALSE;
        $allocate_menu = array();
        $menu = $sub_menu = $user_name = $employee_id = '';

        /**
         * For set Employee menu permission
         */
        if ($this->input->post('permission')) {
            $post_arr = $this->input->post(NULL, TRUE);

            $result = $this->employee_model->upDateModulePermission($post_arr);
            if ($result) {
                $msg = lang('successfully_set_menu_permission');
                $this->loadPage($msg, 'employee/menu_permission');
            } else {
                $msg = lang('error_while_set_menu_permission');
                $this->loadPage($msg, 'employee/menu_permission', 'danger');
            }
        }
        /**
         * End here
         */
        /**
         * For select user select show the menu based on details
         */
        if ($this->input->post() && $this->validate_employee()) {
            $user_name = $this->input->post('user_name');
            if ($this->check_validate_employee($user_name)) {
                $employee_id = $this->employee_model->getEmployeeId($user_name);
                $allocate_menu = $this->employee_model->getAllUserAllocatedMenus($user_name);
                $flag = true;

                $allocate_menu_id = [];
                if ($flag) {

                    foreach ($allocate_menu as $data) {
                        $allocate_menu_id = $data;
                    }

                    $employee_menu = $this->employee_model->getAllEmployeeMenus();
                    $menu = "<table style='background:white;height:100px;' class='table table-responsive table-full-width' id='sample_1'>";
                    foreach ($employee_menu as $row) {

                        $menu_id = $row['id'];
                        $menu_name = lang('menu_name_' . $row['id']);

                        if (in_array($menu_id, $allocate_menu_id)) {
                            foreach ($allocate_menu_id as $allocate_id) {
                                if ($menu_id == $allocate_id) {

                                    $checked = true;
                                } else {
                                    $checked = false;
                                }
                            }
                            $menu .= "<tr style='color:#0000'>
                                     <td>
                                     <div class='radio-inline'>
                                        <input checked='" . $checked . "' type='checkbox' name='" . strtolower($menu_name) . "' id='" . $menu_name . "' value='" . $menu_id . "' class='square-teal'/> 
                                        <label for='" . $row['id'] . "'></label>
                                           <font color ='#0000'> $menu_name </font>
                                            </div>
                                          </div>
                                       </td>
                                    <td colspan='2'></td>
                                  </tr>";
                        } else {
                            $menu .= "<tr style='color:#0000'>
                                       <td>
                                        <div class='radio-inline'>
                                             <input  type='checkbox' name='" . strtolower($menu_name) . "' id='" . $menu_name . "' value='" . $menu_id . "' class='square-teal'/> 
                                            <label for='" . $row['id'] . "'></label>
                                           <font color ='#0000'> $menu_name </font>
                                         </div>
                                      </td>
                                    <td colspan='2'></td>
                                  </tr>";
                        }
                        if ($row['sub_menu']) {
                            foreach ($row['sub_menu'] as $value) {
                                $sub_menu_id = $value['sub_id'];
                                $sub_menu_name = lang('menu_name_' . $value['sub_id']);
                                if (in_array($sub_menu_id, $allocate_menu_id)) {
                                    foreach ($allocate_menu_id as $allocate_id) {
                                        if ($sub_menu_id == $allocate_id) {
                                            $checked = TRUE;
                                        } else {
                                            $checked = FALSE;
                                        }
                                    }
                                    $menu .= "<tr tr style='color:#0000'>
                                            <td></td>
                                            <td>
                                             <div class='radio-inline'>
                                                <input checked='" . $checked . "' type='checkbox' name='" . strtolower($sub_menu_name) . "' id='" . $sub_menu_name . "' value='" . $sub_menu_id . "' class='square-teal'/> 
                                                <label for='" . $value['sub_id'] . "'></label>
                                                <font color ='#0000'> $sub_menu_name </font>
                                                    </div>
                                            </td>
                                             <td></td>
                                         </tr>";
                                } else {
                                    $menu .= "<tr tr style='color:#0000'>
                                            <td></td>
                                            <td>
                                             <div class='radio-inline'>
                                                <input  type='checkbox' name='" . strtolower($sub_menu_name) . "' id='" . $sub_menu_name . "' value='" . $sub_menu_id . "' class='square-teal'/> 
                                                <label for='" . $value['sub_id'] . "'></label>
                                                <font color ='#0000'> $sub_menu_name </font>
                                                    </div>
                                            </td>
                                             <td></td>
                                         </tr>";
                                }
                            }
                        }
                        //}
                    }
                    $menu .= "</table>";
                }

                $this->setData('menu', $menu);
                $this->setData('user_name', $user_name);
                $this->setData('employee_id', $employee_id);
            } else {
                $msg = lang('employee_not_found');
                $this->loadPage($msg, 'employee/menu_permission', 'danger');
            }
        }




        $this->setData('page_header', $title);
        $this->setData('flag', $flag);

        $this->loadView();
    }

    function validate_employee() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'required|callback_check_validate_employee');
        $form_result = $this->form_validation->run();

        return $form_result;
    }

    function check_validate_employee($user_name) {

        if ($user_name != '') {
            $flag = false;
            if ($this->employee_model->checkIsUserNameExistsOrNot($user_name)) {
                $flag = true;
            }
            return $flag;
        } elseif ($this->input->post('username')) {
            $user_name = $this->input->post('username');
            echo $user_name;
            die;
            $res = $this->employee_model->checkIsUserNameExistsOrNot($user_name);
            if ($res) {
                echo 'yes';
                exit();
            } else {
                echo 'no';
                exit();
            }
        }
    }

    /**
     * for get dynamic username selection
     */
    function employee_username() {
        $string = $this->input->post('query');
        $details = $this->employee_model->getAllActiveEmployeeList($string);
        echo $details;
        exit();
    }

}
