<?php

class Epin_model extends CI_Model {

    public function addPinToUser($data) {
        $res = 0;
        for ($i = 0; $i < $data['pin_count']; $i++) {
            $pin_number = $this->generatePin();
            $res = $this->db->set('mlm_user_id', $data['user_id'])
                    ->set('pin_number', $pin_number)
                    ->set('allocate_amount', $data['pin_amount'])
                    ->set('balance_amount', $data['pin_amount'])
                    ->set('allocate_date', date("Y-m-d H:i:s"))
                    ->set('expiry_date', $data['expiry_date'])
                    ->insert('pin_numbers');
        }
        return $res;
    }

    public function generatePin() {
        $pin = $this->load->helper('string');
        $pin = '';
        $flag = 1;
        while ($flag) {
            $pin = random_string('alnum', 16);
            if (!$this->pinExist($pin)) {
                $flag = 0;
            }
        }
        return $pin;
    }

    public function pinExist($pin) {
        return $this->db->select("id")
                        ->from("pin_numbers")
                        ->where('pin_number', $pin)
                        ->count_all_results();
    }

    public function getAllPinRequests() {
        $data = array();
        $res = $this->db->select("id,mlm_user_id,amount,count,date,status")
                ->from("pin_request")
                ->where("status", 'requested')
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['slno'] = $i + 1;
            $data[$i]['id'] = $row->id;
            $data[$i]['amount'] = $row->amount;
            $data[$i]['count'] = $row->count;
            $data[$i]['mlm_user_id'] = $row->mlm_user_id;
            $data[$i]['username'] = $this->helper_model->IdToUserName($row->mlm_user_id);
            $data[$i]['user_balance'] = $this->helper_model->getUserBalance($row->mlm_user_id);
            $data[$i]['date'] = $row->date;
            $data[$i]['status'] = $row->status;
            $i++;
        }
        return $data;
    }

    public function updateRequestStatus($id,$status) {
        return $this->db->set('status ', $status)
                        ->where('id ', "$id")
                        ->update('pin_request');
    }

    public function getRequestData($id){
        $data = array();
        $res = $this->db->select("mlm_user_id,amount,count")
                ->from("pin_request")
                ->where("id", $id)
                ->get();
        foreach ($res->result() as $row) {
            $data['pin_amount'] = $row->amount;
            $data['pin_count'] = $row->count;
            $data['user_id'] = $row->mlm_user_id;
        }
        return $data;
    }
    
    public function getAllPins() {
        $today=strtotime(date("Y-m-d H:i:s"));
        $data['inactive'] =$data['active']= array();
        $res = $this->db->select("mlm_user_id,pin_number,allocate_amount,balance_amount,allocate_date,expiry_date,status,used_by,used_for")
                ->from("pin_numbers")
                ->where('mlm_user_id !=',0)
                ->get();
        $i =$j= 0;
        foreach ($res->result() as $row) {
            if(!$row->status && $row->used_by){
                $data['inactive'][$i]['slno'] = $i+1;
                $data['inactive'][$i]['username'] = $this->helper_model->IdToUserName($row->mlm_user_id);
                $data['inactive'][$i]['pin_number'] = $row->pin_number;
                $data['inactive'][$i]['allocate_amount'] = $row->allocate_amount;
                $data['inactive'][$i]['balance_amount'] = $row->balance_amount;
                $data['inactive'][$i]['used_by'] = $this->helper_model->IdToUserName($row->used_by);
                $data['inactive'][$i]['used_for'] = $row->used_for;
                $i++;
            }elseif(strtotime($row->expiry_date)>$today){
                $data['active'][$j]['slno'] = $j + 1;
                $data['active'][$j]['username'] = $this->helper_model->IdToUserName($row->mlm_user_id);
                $data['active'][$j]['pin_number'] = $row->pin_number;
                $data['active'][$j]['allocate_amount'] = $row->allocate_amount;
                $data['active'][$j]['balance_amount'] = $row->balance_amount;
                $data['active'][$j]['allocate_date'] = $row->allocate_date;
                $data['active'][$j]['expiry_date'] = $row->expiry_date;
                $j++;
            }            
        }
        return $data;
    }
    
}
