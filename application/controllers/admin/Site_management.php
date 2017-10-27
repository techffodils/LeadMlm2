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
        $title = lang('site_settings');
        $this->setData('title', $title);
        $this->setData('page_title', $title);
        $site_info = $this->site_management_model->get_site_info();

        if ($this->input->post('update_site_info') && $this->validate_site_info()) {
            $post_arr = $this->input->post(NULL, TRUE);
            $company_name = $post_arr['company_name'];
            $company_address = $post_arr['company_address'];
            $company_email = $post_arr['company_email'];
            $company_phone = $post_arr['company_phone'];
            $admin_email = $post_arr['admin_email'];


            $data = array();

            if ($_FILES['company_logo']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/logos/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['company_logo']['name'];
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


            $result = $this->site_management_model->updateSiteInformation($company_name,$admin_email, $company_address, $company_email, $company_phone, $logo_name, $fav_icon);
            if ($result) {

                $site_info = array(
                    'company_name' => $company_name,
                    'company_logo' => $logo_name,
                    'company_fav_icon' => $fav_icon,
                    'company_address' => $company_address,
                    'company_email' => $company_email,
                    'company_phone' => $company_phone
                );

                $this->session->set_userdata('mlm_site_info', $site_info);

                $data = serialize($this->input->post());
                $res = $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'Site Information Updated', $data);
                $msg = lang('successfully_update_site_settings');
                $this->loadPage($msg, "site_management/site_configuration");
            } else {
                $msg = lang('error_while_entring_site_settings');
                $this->loadPage($msg, "site_management/site_configuration", 'danger');
            }
        } else {
            $this->setData('error', $this->form_validation->error_array());
        }
        $this->setData('site_info', $site_info);
        $this->loadView();
    }

    function validate_site_info() {
        $post_arr = $this->input->post();
        $this->form_validation->set_rules('company_name', lang('company_name'), 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('company_address', lang('address'), 'trim|required');
        $this->form_validation->set_rules('company_email', lang('company_email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('company_phone', lang('company_phone'), 'trim|required');
        
        $result = $this->form_validation->run();
        return $result;
    }

    /**
     * @author leadmlmsoftware.com
     * @dataProvider
     * @date 2017-10-19 Thursday
     */
    function mail_content_management($lang_code = '') {

        $title = lang('mail_content_management');
        $this->setData('title', $title);

        $avail_lang = $this->site_management_model->getAllLangauage('registration');
        $password_rest = $this->site_management_model->getAllLangauage('password_reset');
        $subject = $content = $lang_id = '';
        $array_arr = $details = array();
        $i = 0;
        $default_lang = 'en';

        if ($this->input->post()) {
            $result = '';
            $post_arr = $this->input->post(NULL, TRUE);
            foreach ($avail_lang as $row) {

                if (!empty($post_arr['content' . '_' . $row['lang_code']]) && $post_arr['subject' . '_' . $row['lang_code']] != '') {
                    $content = $post_arr['content' . '_' . $row['lang_code']];
                    $subject = $post_arr['subject' . '_' . $row['lang_code']];
                    $lang_id = $post_arr['lang_id'];

                    $result = $this->site_management_model->insertMailContent($content, $subject, $lang_id, 'registration');
                }
            }
            if ($result) {
                $msg = lang('succesfully_inserted_mail_management');
                $this->loadPage($msg, 'site_management/mail_content_management');
            } else {
                $msg = lang('error_while_insert_mail_management');
                $this->loadPage($msg, 'site_management/mail_content_management', 'danger');
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
        $this->setData('password_reset', $password_rest);

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

                return $validation_status;
                //}
            }
        }
    }

    /**
     * 
     * For Mail Settings
     * @author techffodils
     * @date 2017-10-25
     * 
     */
    function mail_settings() {
        $title = lang('mail_configuration');
        $this->setData('title', $title);

        if ($this->input->post() && $this->validate_mail_settings()) {
            $post_arr = $this->input->post(NULL, TRUE);
            if ($this->LOG_USER_TYPE == 'admin' || $this->LOG_USER_TYPE == 'emloyee') {
                $post_arr['user_id'] = $this->LOG_USER_ID;
            }

            $result = $this->site_management_model->insertMailContenetDetails($post_arr);
            if ($result) {
                $msg = lang('successfully_insert_mail_content');
                $this->loadPage($msg, 'site_management/mail_settings');
            } else {
                $msg = lang('error_while_inserting_mail_settings', danger);
                $this->loadPage($msg, 'site_management/mail_settings');
            }
        } else {

            $this->setData('error', $this->form_validation->error_array());
        }

        $this->setData('page_title', $title);

        $this->loadView();
    }

    function validate_mail_settings() {
        $this->form_validation->set_rules('mail_engine', lang('mail_engine'), 'required');
        $this->form_validation->set_rules('host_name', lang('smtp_hostname'), 'required');
        $this->form_validation->set_rules('smtp_username', lang('smtp_username'), 'required|alpha_dash');
        $this->form_validation->set_rules('smtp_password', lang('smtp_password'), 'required');

        $form_result = $this->form_validation->run();
        return $form_result;
    }

}
