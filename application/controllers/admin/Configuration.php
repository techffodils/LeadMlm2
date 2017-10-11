<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Configuration extends Base_Controller {

    public function set_register_fields($action = '', $field_id = '') {
        $res = $this->configuration_model->checkTable('sdfsd');
        $error_array = $post = array();
        if ($this->input->post('add_new')) {//add new fields
            $post = $this->input->post();
            if ($this->validate_field_addition()) {
                $res = $this->configuration_model->createDbField($post['field_name'], $post['data_types'], $post['data_type_max_size']);
                if ($res) {
                    $res=$this->configuration_model->addNewRegistrationField($post);
                    if($res){
                        $this->session->unset_userdata('post_data');
                        $this->loadPage('New Field Created Successfully', 'configuration/set_register_fields', True);
                    }else{
                        $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                    }
                } else {
                    $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->session->set_userdata('post_data', $post);
                $error_array = $this->form_validation->error_array();
                //print_r($error_array);die();
                $this->loadPage('Validation Error', 'configuration/set_register_fields', FALSE);
            }
        }

        $post_data=$this->session->userdata('post_data');
        
        
        $edit_status = FALSE;
        $editable_fields = array();
        if ($field_id && $action) {//update new fields
            if ($this->configuration_model->checkFieldEligibility($field_id)) {
                if ($action == 'activate') {
                    $this->configuration_model->changeFieldStatus($field_id, 'active');
                } elseif ($action == 'inactivate') {
                    $this->configuration_model->changeFieldStatus($field_id, 'inactive');
                } elseif ($action == 'edit') {
                    $edit_status = TRUE;
                    $editable_fields = $this->configuration_model->getRegFieldDetails($field_id);
                } else {
                    $msg = 'Invalid Action';
                }
            } else {
                $msg = 'This Field Can not be Edited';
            }
        }
        $fields = array(); //$this->configuration_model->getAllRegFields();
//print_r($post_data);die();
        $this->setData('base_path', base_url());
        $this->setData('error_array', $error_array);
        $this->setData('fields', $fields);
        $this->setData('edit_status', $edit_status);
        $this->setData('editable_fields', $editable_fields);
        $this->setData('post_data', $post_data);
        $this->loadView();
    }

    function validate_field_addition() {
        $this->form_validation->set_rules('field_name', 'field_name', 'required|callback_validate_field|trim');
        $this->form_validation->set_rules('required_status', 'required_status', 'required');
        $this->form_validation->set_rules('register_step', 'register_step', 'required');
        $this->form_validation->set_rules('order', 'order', 'required');
        $this->form_validation->set_rules('unique_status', 'unique_status', 'required');
        $this->form_validation->set_rules('data_types', 'data_types', 'required');
        if ($this->input->post('data_types') != 'double' && $this->input->post('data_types') != 'text') {
            $this->form_validation->set_rules('data_type_max_size', 'data_type_max_size', 'required');
        }

        $this->form_validation->set_rules('field_type', 'field_type', 'required');
        if ($this->input->post('field_type') == 'radio') {
            $this->form_validation->set_rules('radio_value1', 'radio_value1', 'required');
            $this->form_validation->set_rules('radio_value2', 'radio_value2', 'required');
        }
        if ($this->input->post('field_type') == 'select_box') {
            $this->form_validation->set_rules('select_option1', 'select_option1', 'required');
            $this->form_validation->set_rules('select_option2', 'select_option2', 'required');
            $this->form_validation->set_rules('select_option3', 'select_option3', 'required');
            $this->form_validation->set_rules('select_option4', 'select_option4', 'required');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_register_config() {
        $this->form_validation->set_rules('field_name', 'Field Name', 'required|callback_validate_field');
        $this->form_validation->set_rules('required_field', 'Req Field', 'required');
        $this->form_validation->set_rules('input_type', 'input_type', 'required');
        $this->form_validation->set_rules('field_type', 'field_type', 'required');
        $this->form_validation->set_rules('unique', 'unique', 'required');
        $this->form_validation->set_rules('min_length', 'Req Field', 'required');
        $this->form_validation->set_rules('max_length', 'Req Field', 'required');

        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_field($field) {
        $flag = false;
        if ($this->configuration_model->checkField($field) || $this->configuration_model->checkTable($field)) {
            $flag = true;
        }
        return $flag;
    }

}
