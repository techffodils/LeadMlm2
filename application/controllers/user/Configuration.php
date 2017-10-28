<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'Base_Controller.php';

class Configuration extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * For Add Kyc Details
     * @author Techffodils
     * @date 2017-10-28
     * 
     */
    public function add_kyc_details() {
        $title = lang('kyc_details');
        $this->setData('title', $title);

        if ($this->input->post() && $this->validate_kyc_details()) {

            $post_arr = $this->input->post(NULL, TRUE);

            $post_arr['user_id'] = $this->LOG_USER_ID;


            if ($_FILES['bank_file']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/bank_details/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['bank_file']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('bank_file')) {
                    $uploadData = $this->upload->data();
                    $post_arr['bank_proof'] = $uploadData['file_name'];
                } else {
                    $$post_arr['bank_proof'] = '';
                }
            }
            if ($_FILES['id_proof']['error'] == 0) {
                $config['upload_path'] = FCPATH . 'assets/images/id_proof/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $_FILES['id_proof']['name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('id_proof')) {
                    $uploadData = $this->upload->data();
                    $post_arr['id_proof'] = $uploadData['file_name'];
                } else {
                    $post_arr['id_proof'] = '';
                }
            }

            $result = $this->configuration_model->insertKycDetails($post_arr);
            if ($result) {
                $msg = lang('successfully_upload_kyc_details');
                $this->loadPage($msg, 'configuration/add_kyc_details');
            } else {
                $msg = lang('error_upload_kyc_details');
                $this->loadPage($msg, 'configuration/add_kyc_details', 'danger');
            }
        } else {
            $this->setData('error', $this->form_validation->error_array());
        }
        $this->loadView();
    }

    /**
     * For Validate Know your customer details
     * @author techffodils
     * @date 2017-10-27
     */
    public function validate_kyc_details() {
        $this->form_validation->set_rules('bank_name', lang('bank_name'), 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('bank_branch', lang('bank_branch'), 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('bank_account_no', lang('bank_account_no'), 'trim|required|numeric');
        $this->form_validation->set_rules('bank_ifc_code', lang('bank_ifc_code'), 'trim|required|alpha_numeric');
        //$this->form_validation->set_rules('bank_file', lang('bank_file'), '');
        $this->form_validation->set_rules('id_name', lang('name_as_per_proof'), 'required');
        $this->form_validation->set_rules('id_number', lang('id_number'), 'required|alpha_numeric');
        //$this->form_validation->set_rules('id_proof', lang('id_proof'), '');
        $result = $this->form_validation->run();
        //print_r($result);die;
        return $result;
    }

    /**
     * 
     * For callback file check
     * @author Techffodils
     * @date 2017-10-27
     * 
     */
    public function file_check($str) {
        $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/jpg');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message($str, lang('please_select_allocated_iamges'));
                return false;
            }
        } else {
            $this->form_validation->set_message($str, lang('please_select_file'));
            return false;
        }
    }

}
