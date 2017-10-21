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
        $user_id = $this->main->get_usersession('mlm_user_id');
        if ($this->input->post('add_request') && $this->validate_add_request()) {
            $post = $this->input->post();
            $post['user_id'] = $user_id;
            $res = $this->epin_model->addPinRequest($post);
            if ($res) {
                $this->helper_model->insertActivity($user_id, 'pin_requested', $post);
                $this->loadPage('Pin Request Successfully', 'epin/epin_management', TRUE);
            } else {
                $this->loadPage('Failed To Request', 'epin/epin_management', FALSE);
            }
        }
        $pin_request = $this->epin_model->getAllPinRequests($user_id);
        $pins = $this->epin_model->getAllPins($user_id);
        $this->setData('active_pin', $pins['active']);
        $this->setData('used_pin', $pins['inactive']);

        $this->setData('pin_request', $pin_request);
        $this->setData('pin_error', $this->form_validation->error_array());
        $this->loadView();
    }

    function validate_add_request() {
        $this->form_validation->set_rules('pin_amount', 'pin_amount', 'required|greater_than[0]');
        $this->form_validation->set_rules('pin_count', 'pin_count', 'required|greater_than[0]');

        $validation = $this->form_validation->run();
        return $validation;
    }

}