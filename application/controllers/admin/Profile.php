<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Profile extends Base_Controller {

    function index() {
        $logged_user_id = $this->LOG_USER_ID;

        $user_id = $logged_user_id;
        if ($this->input->post('prof_update') && $this->validate_profile_update()) {
            $post = $this->input->post();
            $res = $this->profile_model->updateUserProfile($user_id, $post);
            if ($res) {
                $this->helper_model->insertActivity($user_id, 'profile_updated', $post);
                $this->loadPage(lang('profile_updated'), 'profile/index');
            } else {
                $this->loadPage('profile_updation_failed', 'profile/index', 'danger');
            }
        }

        if ($this->input->post('dp_update')) {
            $config['upload_path'] = FCPATH . 'assets/images/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            $new_name = 'dp_' . time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('prof_pic')) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadPage(lang('failed_to_update_dp'), 'profile/index', 'danger');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $this->profile_model->updateUserPic($user_id, $data);
                $this->loadPage(lang('profile_pic_updated'), 'profile/index');
            }
        }

        if ($this->input->post('cover_update')) {
            $config['upload_path'] = FCPATH . 'assets/images/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            $new_name = 'cover_' . time();
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('cover_pic')) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadPage(lang('failed_to_update_cover'), 'profile/index', 'danger');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $this->profile_model->updateUserCover($user_id, $data);
                $this->loadPage(lang('cover_pic_updated'), 'profile/index');
            }
        }


        $user_details = $this->profile_model->getUserDetails($user_id);
        $def_cov = array("cover1.jpg", "cover2.jpg", "cover3.jpg", "cover4.jpg", "cover5.jpg", "cover6.jpg");
        $def_dp = array("dp1.jpg", "dp2.jpg", "dp3.jpg", "dp4.jpg", "dp5.jpg");
        $user_files = $this->profile_model->getUserFiles($user_id);


        if ($this->input->post('dp_crop')) {//addClass('jcrop-keymgr')
            $new_file = 'dp_' . time() . '.jpg';
            $post = $this->input->post();
            $width = $post['w'];
            $height = $post['h'];
            $x_axis = $post['x1'];
            $y_axis = $post['y1'];
            if($width>=0 && $height>=0 && $x_axis>=0 && $y_axis>=0) {
                $this->load->library('image_lib');
                $config = array(
                    'source_image' => "assets/images/users/" . $user_details['user_dp'],
                    'maintain_ratio' => FALSE,
                    'width' => $width,
                    'height' => $height,
                    'x_axis' => $x_axis,
                    'y_axis' => $y_axis,
                    'new_image' => $new_file
                );

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $res = $this->image_lib->crop();
                if (!$this->image_lib->display_errors()) {
                    if ($this->profile_model->setDp($user_id, $new_file)) {
                        $this->profile_model->insertUserPictureHistory($user_id,$new_file,'user_dp');
                        $this->loadPage(lang('dp_cropped'), 'profile/index');
                    }
                }
            }
            $this->loadPage(lang('dp_cropped_failed'), 'profile/index', 'danger');
        }
        
        if ($this->input->post('cover_crop')) {//addClass('jcrop-keymgr')
            $new_file = 'cover_' . time(). '.jpg';
            $post = $this->input->post();
            $width = $post['w2'];
            $height = $post['h2'];
            $x_axis = $post['x11'];
            $y_axis = $post['y11'];
            if($width>=0 && $height>=0 && $x_axis>=0 && $y_axis>=0) {
                $this->load->library('image_lib');
                $config = array(
                    'source_image' => "assets/images/users/" . $user_details['user_cover'],
                    'maintain_ratio' => FALSE,
                    'width' => $width,
                    'height' => $height,
                    'x_axis' => $x_axis,
                    'y_axis' => $y_axis,
                    'new_image' => $new_file
                );

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $res = $this->image_lib->crop();
                if (!$this->image_lib->display_errors()) {
                    if ($this->profile_model->setCover($user_id, $new_file)) {
                        $this->profile_model->insertUserPictureHistory($user_id,$new_file,'user_cover');
                        $this->loadPage(lang('cover_cropped'), 'profile/index');
                    }
                }
            }
            $this->loadPage(lang('cover_cropped_failed'), 'profile/index', 'danger');
        }
        $country_id=$user_details['country'];
        $countries = $this->profile_model->getAllCountries();
        $states = $this->profile_model->getAllStates($country_id);

        $this->setData('countries', $countries);
        $this->setData('states', $states);
        $this->setData('user_dps', $user_files['dp']);
        $this->setData('def_dp', $def_dp);
        $this->setData('user_cov', $user_files['co']);
        $this->setData('def_cov', $def_cov);
        $this->setData('user_details', $user_details);
        $this->setData('profile_error', $this->form_validation->error_array());
        $this->setData('title', lang('profile'));
        $this->loadView();
    }

    function validate_profile_update() {
        $this->form_validation->set_rules('first_name', lang('first_name'), 'required');
        $this->form_validation->set_rules('phone_number', lang('phone_number'), 'required|greater_than[0]');
        $this->form_validation->set_rules('gender', lang('gender'), 'required');
        $this->form_validation->set_rules('address', lang('address'), 'required');
        $this->form_validation->set_rules('country', lang('country'), 'required');
        $this->form_validation->set_rules('dob', lang('dob'), 'required|callback_validate_dob');

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
                $this->form_validation->set_message('validate_dob', lang('enter_a_valid_dob'));
            }
        }
        return $flag;
    }

    function reset_user_file() {
        if ($this->input->get('id')) {
            $res = $this->profile_model->resetUserFile($this->input->get('id'));
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function set_def_cover() {
        if ($this->input->get('id')) {
            $user_id = $this->LOG_USER_ID;
            $res = $this->profile_model->setCover($user_id, $this->input->get('id'));
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function set_def_dp() {
        if ($this->input->get('id')) {
            $user_id = $this->LOG_USER_ID;
            $res = $this->profile_model->setDp($user_id, $this->input->get('id'));
            if ($res) {
                echo 'yes';
                exit;
            }
        }
        echo 'no';
        exit;
    }

    function show_image() {
        //$upload_path="/var/www/html/WC/";
        $this->load->library('image_lib');
        $config = array(
            'source_image' => "/var/www/html/WC/sago.jpg",
            'maintain_ratio' => FALSE,
            'width' => 396,
            'height' => 175,
            'x_axis' => 97,
            'y_axis' => 119,
            'new_image' => 'test.jpg'
        );

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->crop();

        echo $this->image_lib->display_errors();


        die('///////////');

        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = '/var/www/html/WC/sago.jpg';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 5;
        $config['height'] = 5;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
        echo $this->image_lib->display_errors();

        echo 1111;
        die();
    }

}
