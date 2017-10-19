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
            //print_r($_FILES['company_logo']['error']);die;
            if ($_FILES['company_logo']['error']==0) {
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
            if ($_FILES['company_fav_icon']['error']==0) {
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
            print_r($error);
            die;
            $msg = "Please Have look Form Contain Some error";
            $this->loadPage($msg, 'site_management/site_configuration', FALSE);
        } else {
            return $result;
        }
    }

    
    function mail_content_management(){
        $title="Mail Content Management";
        $this->setData('title',$title."|".$this->main->get_controller()."::");
        
        $avail_lang=$this->site_management_model->getAllLangauage();
        print_r($avail_lang);die;
        
        $this->setData('page_header',$title);
        
        $this->loadView();
    }
}
