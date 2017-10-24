<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Epin extends Base_Controller {

    function epin_management($action = '', $request_id = '', $expiry_date = '') {
        $tab1 = 'active';
        $tab2 = $tab3 = $tab4 = '';
        $user_id = $this->main->get_usersession('mlm_user_id');
        if ($action && $request_id) {
            $this->session->set_userdata('active_pin_tab', 'tab2');
            if ($action == 'cancel') {
                $res = $this->epin_model->updateRequestStatus($request_id, 'canceled');
                if ($res) {
                    $activity['request_id'] = $request_id;
                    $this->helper_model->insertActivity($user_id, 'pin_requested_canceled', $activity);
                    $this->loadPage(lang('request_canceled'), 'epin/epin_management');
                } else {
                    $this->loadPage(lang('canceletion_failed'), 'epin/epin_management', 'danger');
                }
            } elseif ($expiry_date && $action == 'confirm') {
                $d = DateTime::createFromFormat('Y-m-d', $expiry_date);
                if (!$this->helper_model->validateDate($expiry_date) || strtotime(date("Y-m-d H:i:s") < strtotime($expiry_date))) {
                    $this->loadPage(lang('invalid_expiry_date'), 'epin/epin_management', 'danger');
                }
                $data = $this->epin_model->getRequestData($request_id);
                if ($data) {
                    $data['expiry_date'] = $expiry_date;
                    if($this->epin_model->checkUserBalance($data)) {
                        $res = $this->epin_model->addPinToUser($data);
                        if ($res) {
                            $this->helper_model->insertWalletDetails($data['user_id'],'debit',$data['pin_amount']*$data['pin_count'],'pin_purchased');
                            $this->epin_model->updateRequestStatus($request_id, 'confirmed');
                            $this->helper_model->insertActivity($user_id, 'pin_requested_confirmed', $data);
                            $this->loadPage($lang('request_confirmed'), 'epin/epin_management');
                        } else {
                            $this->loadPage(lang('failed_to_confirm'), 'epin/epin_management', 'danger');
                        }
                    }else{
                        $this->loadPage(lang('insuff_balance'), 'epin/epin_management', 'danger');
                    }
                } else {
                    $this->loadPage(lang('invalid_request'), 'epin/epin_management', 'danger');
                }
            }
        }
        if ($this->input->post('add_pin') && $this->validate_add_pin()) {
            $post = $this->input->post();
            $post['user_id'] = $this->helper_model->userNameToID($post['username']);
            $res = $this->epin_model->addPinToUser($post);
            if ($res) {
                $this->helper_model->insertActivity($user_id, 'pin_added', $post);
                $this->loadPage(lang('pin_added_successfully'), 'epin/epin_management', TRUE);
            } else {
                $this->loadPage(lang('failed_to_add'), 'epin/epin_management', FALSE);
            }
        }
        $active_tab = '';
        if ($this->session->userdata('active_pin_tab') != null) {
            $tab1 = $tab2 = $tab3 = $tab4 = '';
            $active_tab = $this->session->userdata('active_pin_tab');
        }
        $pin_request = $this->epin_model->getAllPinRequests();
        $pins = $this->epin_model->getAllPins();

        $this->setData('active_pin', $pins['active']);
        $this->setData('used_pin', $pins['inactive']);
        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('tab4', $tab4);
        $this->setData($active_tab, 'active');
        $this->setData('pin_request', $pin_request);
        $this->setData('pin_error', $this->form_validation->error_array());

        $this->loadView();
    }

    function validate_add_pin() {
        $this->session->set_userdata('active_pin_tab', 'tab1');
        $this->form_validation->set_rules('username', lang('username'), 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('pin_amount', lang('pin_amount'), 'required|greater_than[0]');
        $this->form_validation->set_rules('pin_count', lang('pin_count'), 'required|greater_than[0]');
        $this->form_validation->set_rules('expiry_date', lang('expiry_date'), 'required|callback_validate_date');

        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_username($username) {
        $flag = false;
        if ($this->helper_model->userNameToID($username)) {
            $flag = true;
        }
        $this->form_validation->set_message('validate_username', lang('validate_username'));
        return $flag;
    }

    function validate_date($date) {
        $startDate = strtotime(date("Y-m-d H:i:s"));
        $endDate = strtotime($date);

        if ($endDate >= $startDate)
            return True;
        else {
            $this->form_validation->set_message('validate_date', lang('should_be_greate than today'));
            return False;
        }
    }

}
