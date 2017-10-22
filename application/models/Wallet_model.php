<?php

class Wallet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addFundTransfer($from_user, $to_user, $amount, $wallet_type) {
        return $this->db->set('from_user', $from_user)
                        ->set('to_user', $to_user)
                        ->set('transfer_type', $wallet_type)
                        ->set('date', date("Y-m-d H:i:s"))
                        ->set('amount', $amount)
                        ->insert('wallet_transfer');
    }

}
