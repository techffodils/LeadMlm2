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

}
