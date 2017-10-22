<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Profile extends Base_Controller {

    function index() {
        $user_id = $this->LOG_USER_ID;

        if ($this->input->post('prof_update') && $this->validate_profile_update()) {
            $post = $this->input->post();
            $res = $this->profile_model->updateUserProfile($user_id, $post);
            if ($res) {
                $this->helper_model->insertActivity($user_id, 'profile_updated', $post);
                //$this->loadPage('Profile Updated Successfully', 'profile/index', TRUE);
            } else {
                //$this->loadPage('Profile Updation Failed', 'profile/index', False);
            }
        }

        $user_details = $this->profile_model->getUserDetails($user_id);

        $this->setData('user_details', $user_details);
        $this->setData('profile_error', $this->form_validation->error_array());
        $this->loadView();
    }

    function validate_profile_update() {
        $this->form_validation->set_rules('firstname', 'firstname', 'required');
        $this->form_validation->set_rules('phone_number', 'pin_amount', 'required|greater_than[0]');
        $this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('dob', 'dob', 'required|callback_validate_dob');

        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_dob($date) {
        $flag = FALSE;
        $test_arr = explode('/', $date);
        if (isset($test_arr[0]) && isset($test_arr[1]) && isset($test_arr[2])) {
            if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
                $flag = TRUE;
            } else {
                $this->form_validation->set_message('validate_username', 'Please enter a valid Date Of Birth.');
            }
        }
        return $flag;
    }

}
