<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Base_Controller.php';

class Epin extends Base_Controller {

    function __construct() {

        parent::__construct();
    }

    function epin_management() {
        $user_id = $this->LOG_USER_ID;
        if ($this->input->post('add_request') && $this->validate_add_request()) {
            $post = $this->input->post();
            $post['user_id'] = $user_id;
            $res = $this->epin_model->addPinRequest($post);
            if ($res) {
                $this->helper_model->insertActivity($user_id, 'pin_requested', $post);
                $this->loadPage(lang('pin_requested'), 'epin/epin_management');
            } else {
                $this->loadPage(lang('pin_request_failed'), 'epin/epin_management', 'danger');
            }
        }
        $pin_request = $this->epin_model->getAllPinRequests($user_id);
        $pins = $this->epin_model->getAllPins($user_id);
        $this->setData('active_pin', $pins['active']);
        $this->setData('used_pin', $pins['inactive']);

        $this->setData('pin_request', $pin_request);
        $this->setData('pin_error', $this->form_validation->error_array());
        $this->setData('title',lang('epin_management'));	
        $this->loadView();
    }

    function validate_add_request() {
        $this->form_validation->set_rules('pin_amount', lang('pin_amount'), 'required|greater_than[0]');
        $this->form_validation->set_rules('pin_count', lang('pin_count'), 'required|greater_than[0]');

        $validation = $this->form_validation->run();
        return $validation;
    }

}