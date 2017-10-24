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
    
    public function getUserWalletTransferDetails($user_id) {
        $data = array();
        $res = $this->db->select("to_user,amount,transfer_type,date")
                ->from("wallet_transfer")
                ->where("from_user", $user_id)
                ->where("transfer_type","transfer_by_user")
                ->order_by('id','desc')
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['slno'] = $i + 1;
            $data[$i]['to_user'] = $this->helper_model->IdToUserName($row->to_user);
            $data[$i]['full_name'] =  $this->helper_model->getUserFullName($row->to_user);
            $data[$i]['transfer_type'] = $row->transfer_type;
            $data[$i]['date'] = $row->date;
            $data[$i]['amount'] = $row->amount;
            $i++;
        }
        return $data;
    }
    

}
