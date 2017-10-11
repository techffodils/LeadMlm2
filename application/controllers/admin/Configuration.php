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
                    $res = $this->configuration_model->addNewRegistrationField($post);
                    if ($res) {
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'new_registration_field_added');
                        $this->session->unset_userdata('post_data');
                        $this->loadPage('New Field Created Successfully', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                    }
                } else {
                    $this->loadPage('New Field Creation Failed', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->session->set_userdata('post_data', $post);
                $error_array = $this->form_validation->error_array();
                $this->loadPage('Validation Error', 'configuration/set_register_fields', FALSE);
            }
        }

        $post_data = $this->session->userdata('post_data');


        $edit_status = FALSE;
        $editable_fields = array();
        if ($field_id && $action) {//update new fields
            if ($this->configuration_model->checkFieldEligibility($field_id)) {
                if ($action == 'activate') {
                    $res = $this->configuration_model->changeFieldStatus($field_id, 'active');
                    if ($res) {
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'registration_field_activated');
                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'inactivate') {
                    $this->configuration_model->changeFieldStatus($field_id, 'inactive');
                    if ($res) {
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'registration_field_inactivated');
                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'delete') {
                    $this->configuration_model->changeFieldStatus($field_id, 'delete');
                    if ($res) {
                        $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'registration_field_deleted');
                        $this->loadPage('', 'configuration/set_register_fields', True);
                    } else {
                        $this->loadPage('', 'configuration/set_register_fields', FALSE);
                    }
                } elseif ($action == 'edit') {
                    $edit_status = TRUE;
                    $post_data = $this->configuration_model->getRegFieldDetails($field_id);
                } else {
                    $this->loadPage('Invalid Action', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->loadPage('This Field Can not be Edited', 'configuration/set_register_fields', FALSE);
            }
        }

        if ($this->input->post('update_field')) {//add new fields
            $post = $this->input->post();
            if ($this->configuration_model->checkFieldEligibility($post['edited_field'])) {
                if ($this->validate_field_updation()) {
                    $old_name=$this->configuration_model->getFieldOldName($post['edited_field']);
                    if($this->configuration_model->checkTable($old_name)){
                        $upd_res = $this->configuration_model->alterDbField($post['field_name'], $post['data_types'], $post['data_type_max_size'],$old_name);
                    }else{
                        $upd_res = $this->configuration_model->createDbField($post['field_name'], $post['data_types'], $post['data_type_max_size']);
                    }                    
                    if ($upd_res) {
                        $res = $this->configuration_model->updateRegistrationField($post);
                        if ($res) {
                            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'),'registration_field_updated');
                            $this->loadPage('Registration Field Updated Successfully', 'configuration/set_register_fields', True);
                        } else {
                            $this->loadPage('Failed To Update', 'configuration/set_register_fields', FALSE);
                        }
                    } else {
                        $this->loadPage('Failed To Update', 'configuration/set_register_fields', FALSE);
                    }
                } else {                    
                    $this->loadPage('Validation Error', 'configuration/set_register_fields', FALSE);
                }
            } else {
                $this->loadPage('This Field Can not be Edited', 'configuration/set_register_fields', FALSE);
            }
        }


        $fields = $this->configuration_model->getAllRegFields();


        $this->setData('fields', $fields);
        $this->setData('post_data', $post_data);
        $this->setData('edit_status', $edit_status);
        $this->setData('edited_field', $field_id);
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

    function validate_field_updation() {
        $this->form_validation->set_rules('field_name', 'field_name', 'required|callback_validate_field_update|trim');
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

    function validate_field($field) {
        $flag = true;
        $edit_field = $this->input->post('edited_field');
        if ($this->configuration_model->checkField($field) || $this->configuration_model->checkTable($field)) {
            $flag = false;
        }
        return $flag;
    }

    function validate_field_update($field) {
        $flag = true;
        $edit_field = $this->input->post('edited_field');
        if ($this->configuration_model->checkUpdatingField($field, $edit_field)) {
            $flag = false;
        }
        return $flag;
    }

}
