<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Wallet extends Base_Controller {

    function fund_transfer() {
        $logged_user = $this->main->get_usersession('mlm_user_id');
        $tab1 = 'active';
        $tab2 = $tab3 = '';
        if ($this->input->post('add_button') && $this->validate_add_fund()) {
            $post = $this->input->post();
            $user_id = $this->helper_model->userNameToID($post['username_add']);
            $amount = $post['amount_add'];
            $wallet_type = 'credited_by_admin';
            $res = $this->wallet_model->addFundTransfer(0, $user_id, $amount, $wallet_type);
            if ($res) {
                $this->helper_model->insertWalletDetails($user_id, 'credit', $amount, $wallet_type);
                $this->helper_model->insertActivity($logged_user, 'add_fund_to_user', $post);
                $this->loadPage(lang('fund_added_successfully'), 'wallet/fund_transfer');
            } else {
                $this->loadPage(lang('fund_add_failed'), 'wallet/fund_transfer', 'danger');
            }
        }

        if ($this->input->post('ded_button') && $this->validate_ded_fund()) {
            $post = $this->input->post();
            $user_id = $this->helper_model->userNameToID($post['username_ded']);
            $amount = $post['amount_ded'];
            $wallet_type = 'debited_by_admin';
            if ($amount < $this->helper_model->getUserBalance($user_id)) {
                $res = $this->wallet_model->addFundTransfer($user_id, 0, $amount, $wallet_type);
                if ($res) {
                    $this->helper_model->insertWalletDetails($user_id, 'debit', $amount, $wallet_type);
                    $this->helper_model->insertActivity($logged_user, 'deduct_fund_from_user', $post);
                    $this->loadPage(lang('fund_deducted_successfully'), 'wallet/fund_transfer', TRUE);
                } else {
                    $this->loadPage(lang('fund_deducted_failed'), 'wallet/fund_transfer', FALSE);
                }
            } else {
                $this->loadPage(lang('insufficient_balance'), 'wallet/fund_transfer', FALSE);
            }
        }

        if ($this->input->post('trans_button') && $this->validate_transfer()) {
            $post = $this->input->post();
            $from_user = $this->helper_model->userNameToID($post['from_username']);
            $amount = $post['amount_trans'];
            $wallet_type = 'transfer_by_admin';
            if ($amount < $this->helper_model->getUserBalance($from_user)) {
                $to_user = $this->helper_model->userNameToID($post['to_username']);
                $res = $this->wallet_model->addFundTransfer($from_user, $to_user, $amount, $wallet_type);
                if ($res) {
                    $this->helper_model->insertWalletDetails($from_user, 'debit', $amount, $wallet_type, $to_user);
                    $this->helper_model->insertWalletDetails($to_user, 'credit', $amount, $wallet_type, $from_user);
                    $this->helper_model->insertActivity($logged_user, 'deduct_fund_from_user', $post);
                    $this->loadPage(lang('fund_transfered_successfully'), 'wallet/fund_transfer', TRUE);
                } else {
                    $this->loadPage(lang('fund_transfered_failed'), 'wallet/fund_transfer', FALSE);
                }
            } else {
                $this->loadPage(lang('insufficient_balance'), 'wallet/fund_transfer', FALSE);
            }
        }

        $active_tab = '';
        if ($this->session->userdata('active_fund_tab') != null) {
            $tab1 = $tab2 = $tab3 = '';
            $active_tab = $this->session->userdata('active_fund_tab');
        }

        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData($active_tab, 'active');
        $this->setData('error', $this->form_validation->error_array());
        $this->loadView();
    }

    function validate_add_fund() {
        $this->session->set_userdata('active_fund_tab', 'tab1');
        $this->form_validation->set_rules('username_add', lang('username'), 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('amount_add', lang('amount'), 'required|greater_than[0]');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_ded_fund() {
        $this->session->set_userdata('active_fund_tab', 'tab2');
        $this->form_validation->set_rules('username_ded', lang('username'), 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('amount_ded',  lang('amount'), 'required|greater_than[0]');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_transfer() {
        $this->session->set_userdata('active_fund_tab', 'tab3');
        $this->form_validation->set_rules('from_username',  lang('from_username'), 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('to_username',  lang('to_username'), 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('amount_trans',  lang('amount'), 'required|greater_than[0]');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_username($username) {
        $flag = false;
        if ($this->helper_model->userNameToID($username)) {
            $flag = true;
        }
        $this->form_validation->set_message('validate_username', lang('enter_a_valid_username'));
        return $flag;
    }

    function get_user_balance() {
        if ($this->input->get('username')) {
            $user_id = $this->helper_model->userNameToID($this->input->get('username'));
            if ($user_id) {
                $balance = $this->helper_model->getUserBalance($user_id);
                echo $balance;
                exit();
            }
        }
        echo '';
    }

}
