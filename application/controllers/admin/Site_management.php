<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'Base_Controller.php';

class Site_management extends Base_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * For Site Management
     * @Author Leadmlmsoftware.com
     * @Date 2017-10-18
     * 
     */
    function site_configuration() {
        $title = "Site Management";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('page_title', $title);
        $site_info = $this->site_management_model->get_site_info();

        if ($this->input->post('update_site_info') && $this->validate_site_info()) {
            $post_arr = $this->input->post(NULL, TRUE);
//print_r($post_arr);print_r($_FILES['company_logo']);die;
            $company_name = $post_arr['company_name'];
            $company_address = $post_arr['company_address'];
            $company_email = $post_arr['company_email'];
            $company_phone = $post_arr['company_phone'];


            $data = array();

            if ($_FILES['company_logo']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/logos/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['company_logo']['name'];
//print_r($config);die;
//Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('company_logo')) {
                    $uploadData = $this->upload->data();
                    $logo_name = $uploadData['file_name'];
                } else {
                    $logo_name = '';
                }
            } else {
                $logo_name = $site_info['company_fav_icon'];
            }
            if ($_FILES['company_fav_icon']['error'] == 0) {
                $config1['upload_path'] = FCPATH . 'assets/images/logos/';
                $config1['allowed_types'] = 'gif|jpg|png';
                $config1['file_name'] = $_FILES['company_fav_icon']['name'];

//Load upload library and initialize configuration
                $this->load->library('upload', $config1);
                $this->upload->initialize($config1);

                if ($this->upload->do_upload('company_fav_icon')) {
                    $uploadData = $this->upload->data();
                    $fav_icon = $uploadData['file_name'];
                } else {
                    $fav_icon = '';
                }
            } else {
                $fav_icon = $site_info['company_fav_icon'];
            }


            $result = $this->site_management_model->updateSiteInformation($company_name, $company_address, $company_email, $company_phone, $logo_name, $fav_icon);
            if ($result) {

                $site_info= array(

                    'company_name' =>$company_name,
                    'company_logo' =>$logo_name,
                    'company_fav_icon' =>$fav_icon,
                    'company_address' => $company_address,
                    'company_email' =>$company_email,
                    'company_phone' =>$company_phone
                );
                
                $this->session->set_userdata('mlm_site_info',$site_info);

                $data = serialize($this->input->post());
                $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'Site Information Updated', $data);
                $msg = "Successfully Updated Site Information";
                $this->loadPage($msg, "site_management/site_configuration", TRUE);
            } else {
                $msg = "Error While Updating Site Information";
                $this->loadPage($msg, "site_management/site_configuration", FALSE);
            }
        }
        $this->setData('site_info', $site_info);
        $this->loadView();
    }

    function validate_site_info() {
        $post_arr = $this->input->post();
        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_address', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_email', 'Company Name', 'trim|required');
        $this->form_validation->set_rules('company_phone', 'Company Name', 'trim|required');
        /* $this->form_validation->set_rules('company_logo', 'Company Name', 'trim|required');
          $this->form_validation->set_rules('company_fav_icon', 'Company Name', 'trim|required'); */
        $result = $this->form_validation->run();
        if ($result == FALSE) {
            $error = validation_errors();
            $msg = "Please Have look Form Contain Some error";
            $this->loadPage($msg, 'site_management/site_configuration', FALSE);
        } else {
            return $result;
        }
    }

    /**
     * @author leadmlmsoftware.com
     * @dataProvider
     * @date 2017-10-19 Thursday
     */
    function mail_content_management($lang_code = '') {

        $title = "Mail Content Management";
        $this->setData('title', $title . "|" . $this->main->get_controller() . "::");

        $avail_lang = $this->site_management_model->getAllLangauage();
        $subject = $content = $lang_id = '';
        $array_arr = $details = array();
        $i = 0;
        foreach ($avail_lang as $row) {
            $mail_content_detials = $this->site_management_model->getAllMailContentDetails($row['lang_id']);
            foreach ($mail_content_detials as $row) {
                array_push($array_arr, $row);
            }
            $i++;
        }
       
        $default_lang = 'en';

        if ($this->input->post()) {
            $result = '';
            $post_arr = $this->input->post(NULL, TRUE);
            foreach ($avail_lang as $row) {
                if (!empty($post_arr['content' . '_' . $row['lang_code']]) && $post_arr['subject' . '_' . $row['lang_code']] != '') {
                    $content = $post_arr['content' . '_' . $row['lang_code']];
                    $subject = $post_arr['subject' . '_' . $row['lang_code']];
                    $lang_id = $post_arr['lang_id'];

                    $result = $this->site_management_model->insertMailContent($content, $subject, $lang_id);
                }
            }
            if ($result) {
                $msg = "Successfully Inserted Mail content";
                $this->loadPage($msg, 'site_management/mail_content_management', TRUE);
            } else {
                $msg = "Filed to Insert Mail content";
                $this->loadPage($msg, 'site_management/mail_content_management', FALSE);
            }
        } else {
            $error = $this->form_validation->error_array();

            $this->setData('form_error', $error);
        }

        $this->setData('default_lang', $default_lang);
        $this->setData('page_header', "Registration Content");
        $this->setData('page_title', "Password Recovery Content");
        $this->setData('title', "MailContent");
        $this->setData('data', $avail_lang);
        $this->setData('key', $array_arr);


        $this->loadView();
    }

    /**
     * For Form Validation 
     * @author Tecffodils@
     * @date 2017-10-19 Thursday
     * @return boolean
     */
    function validate_mail_conent($avail_lang) {
        $post_arr = $this->input->post(NULL, TRUE);
        if (!empty($avail_lang)) {
            foreach ($avail_lang as $row) {
                //if (!empty($post_arr['content_' . $row['lang_code']]) && $post_arr['subject_' . $row['lang_code']] != '') {
                $this->form_validation->set_rules('content_' . $row['lang_code'], 'Mail Content', 'trim|required');
                $this->form_validation->set_rules('subject_' . $row['lang_code'], 'Subject', 'trim|required|strip_tags');
                $this->form_validation->set_error_delimiters("<div style='color:#b94a48;'>", "</div>");
                $validation_status = $this->form_validation->run();
//                    print_r($validation_status);
//                    die;
                return $validation_status;
                //}
            }
        }
    }

}
