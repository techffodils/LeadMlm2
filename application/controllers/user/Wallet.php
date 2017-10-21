<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Wallet extends Base_Controller {

    function fund_transfer() {
        $logged_user = $this->main->get_usersession('mlm_user_id');
        $user_balance = $this->helper_model->getUserBalance($logged_user);

        if ($this->input->post('trans_button') && $this->validate_transfer()) {
            $post = $this->input->post();
            $from_user = $logged_user;
            $amount = $post['amount_trans'];
            $wallet_type = 'transfer_by_user';
            if ($amount <= $user_balance) {
                $to_user = $this->helper_model->userNameToID($post['to_username']);
                $res = $this->wallet_model->addFundTransfer($from_user, $to_user, $amount, $wallet_type);
                if ($res) {
                    $this->helper_model->insertWalletDetails($from_user, 'debit', $amount, $wallet_type, $to_user);
                    $this->helper_model->insertWalletDetails($to_user, 'credit', $amount, $wallet_type, $from_user);
                    $this->helper_model->insertActivity($logged_user, 'deduct_fund_from_user', $post);
                    $this->loadPage('Fund Transfered Successfully', 'wallet/fund_transfer', TRUE);
                } else {
                    $this->loadPage('Fund Transfer Failed', 'wallet/fund_transfer', FALSE);
                }
            } else {
                $this->loadPage('Insufficient Balance', 'wallet/fund_transfer', FALSE);
            }
        }
        $this->setData('user_balance', $user_balance);
        $this->setData('error', $this->form_validation->error_array());
        $this->loadView();
    }

    function validate_transfer() {
        $this->session->set_userdata('active_fund_tab', 'tab3');
        $this->form_validation->set_rules('to_username', 'to_username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('amount_trans', 'amount_trans', 'required|greater_than[0]');
        $this->form_validation->set_rules('transaction_password', 'transaction_password', 'required|callback_check_tran_password');
        $validation = $this->form_validation->run();
        return $validation;
    }

    function validate_username($username) {
        $flag = false;
        if ($this->helper_model->userNameToID($username)) {
            $flag = true;
        }
        $this->form_validation->set_message('validate_username', 'Please enter a valid Username.');
        return $flag;
    }

    function check_tran_password($password) {
        $logged_user = $this->main->get_usersession('mlm_user_id');
        $tran_pass = $this->helper_model->getTransactionPassword($logged_user);
        $flag = false;
        if ($password == $tran_pass) {
            $flag = true;
        }
        $this->form_validation->set_message('check_tran_password', 'Transaction Password Mismatch');
        return $flag;
    }

    function validate_tran_password() {
        if ($this->input->get('transaction_password')) {
            $transaction_password = $this->input->get('transaction_password');
            $logged_user = $this->main->get_usersession('mlm_user_id');
            $tran_pass = $this->helper_model->getTransactionPassword($logged_user);
            
            if ($transaction_password==$tran_pass) {
                echo 'yes';
                exit();
            }
        }
        echo 'no';
        exit();
    }

}
