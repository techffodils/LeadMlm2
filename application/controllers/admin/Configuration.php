<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Configuration extends Base_Controller {
	public function set_register_fields($action='',$field_id='') {
        $data = array();
        if($this->input->post() && $this->validate_register_config()){//add new fields
        	$post=$this->input->post();
        	$res=$this->configuration_model->addNewRegistrationField($post);
        	if($res){
        		$this->configuration_model->alterTable($post['field_name']);
        	}else{

        	}
        }
        $error_array=$this->form_validation->error_array();

        $edit_status=FALSE;
        $editable_fields=array();
        if($field_id && $action){//update new fields
        	if($this->configuration_model->checkFieldEligibility($field_id)){
        		if($action=='activate'){
        			$this->configuration_model->changeFieldStatus($field_id,'active');
        		}elseif($action=='inactivate'){
        			$this->configuration_model->changeFieldStatus($field_id,'inactive');
        		}elseif($action=='edit'){
        			$edit_status=TRUE;
        			$editable_fields=$this->configuration_model->getRegFieldDetails($field_id);
        		}else{
        			$msg='Invalid Action';
        		}
        	}else{
        		$msg='This Field Can not be Edited';
        	}

        }
        $fields=$this->configuration_model->getAllRegFields();

        $this->setData('base_path',base_url());
        $this->setData('error_array',$error_array);
        $this->setData('fields',$fields);
        $this->setData('edit_status',$edit_status);
        $this->setData('editable_fields',$editable_fields);
        $this->loadView();
    }
    
    function validate_register_config() {
        $this->form_validation->set_rules('field_name', 'Field Name', 'required|callback_validate_field|trim');
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
        $flag = true;
        if ($this->configuration_model->checkField($field)) {
            $flag = false;
        }
        return $flag;
    }

}