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
                $this->loadPage('Profile Updated Successfully', 'profile/index', TRUE);
            } else {
                $this->loadPage('Profile Updation Failed', 'profile/index', False);
            }
        }

        if ($this->input->post('dp_update')) {
            $config['upload_path'] = FCPATH . 'assets/images/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            $new_name = 'dp_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('prof_pic')) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadPage('Profile Pic Updation Failed', 'profile/index', FALSE);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $this->profile_model->updateUserPic($user_id,$data);
                $this->loadPage('Profile Pic Updated', 'profile/index', TRUE);
            }
        }
        
        if ($this->input->post('cover_update')) {
            $config['upload_path'] = FCPATH . 'assets/images/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            $new_name = 'dp_'.time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cover_pic')) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadPage('Profile Pic Updation Failed', 'profile/index', FALSE);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $this->profile_model->updateUserCover($user_id,$data);
                $this->loadPage('Profile Pic Updated', 'profile/index', TRUE);
            }
        }
        

        $user_details = $this->profile_model->getUserDetails($user_id);
        
        $user_files = $this->profile_model->getUserFiles($user_id);
        $this->setData('user_dps', $user_files['dp']);
        $this->setData('user_cov', $user_files['co']);
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
    
    function reset_user_file(){
        if($this->input->get('id')){
            $res=$this->profile_model->resetUserFile($this->input->get('id'));
            if($res){
                echo 'yes';exit;
            }
        }
        echo 'no';exit;
    }

}
