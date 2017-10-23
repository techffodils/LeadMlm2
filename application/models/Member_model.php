<?php

class Member_model extends CI_Model {

    public function checkUserNameExisit($user_name) {        
        $table = "mlm_user";
        $query = $this->db->query("SELECT COUNT(`user_name`) AS count FROM $table WHERE `user_name` = '$user_name'");
        $count = $query->row_array()['count'];
        return $count !== NULL && $count > 0;
    }

    function updateTranPassword($user_id, $tran_password) {
        return $this->db->set('tran_password ', "$tran_password")
                        ->where('mlm_user_id ', $user_id)
                        ->update('user');
    }

    function updateUserName($user_id, $user_name) {
        return $this->db->set('user_name ', "$user_name")
                        ->where('mlm_user_id ', $user_id)
                        ->update('user');
    }

    function updatePassword($user_id, $password) {
        $sha_password = hash("sha256", $password);
        return $this->db->set('password ', "$sha_password")
                        ->where('mlm_user_id ', $user_id)
                        ->update('user');
    }

    function getAllUserNames($query) {
        $data = array();
        if ($query != '') {
            $res = $this->db->select("user_name")
                    ->from('user')
                    ->like('user_name', trim($query))
                    ->where('user_type != ', 'admin')
                    ->get();
        } else {
            $res = $this->db->select("user_name")
                    ->from('user')
                    ->where('user_type != ', 'admin')
                    ->get();
        }
        $json = [];
        foreach ($res->result_array() as $row) {
            $json[] = $row['user_name'];
        }

        return json_encode($json);
    }
    
    function activateInactivateUser($user_id, $status) {
        return $this->db->set('user_status ', $status)
                        ->where('mlm_user_id ', $user_id)
                        ->update('user');
    }
    
    public function getTransationPassword($id) {
        $tran_password = '';
        $query = $this->db->select('tran_password')
                ->from('user')
                ->where('mlm_user_id', $id)
                ->get();
        foreach ($query->result() as $row) {
            $tran_password = $row->tran_password;
        }
        return $tran_password;
    }

    public function getPassword($id) {
        $password = '';
        $query = $this->db->select('password')
                ->from('user')
                ->where('mlm_user_id', $id)
                ->get();
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }
    public function getUserName($id) {
        $user_name = '';
        $query = $this->db->select('user_name')
                ->from('user')
                ->where('mlm_user_id', $id)
                ->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

}
