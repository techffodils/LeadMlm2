<?php

class Member_model extends CI_Model {

//    function checkUserNameExisit($user_name) {
//        $result = $this->db->select("COUNT(*) as cnt")->where('user_name', $user_name)->count_all_results();
//        return $result;
//    }

    public function updatePassword($user_name, $password) {
        $sha_password = hash("sha256", $password);
        $table = "mlm_user";
        $qr = "UPDATE  $table SET password='$sha_password' WHERE user_name='$user_name' ";
        echo $qr;die;
        return $qr;
    }

    public function updateUserName($user_name, $new_username) {
        $table = "mlm_user";
        $qr = "UPDATE  $table SET user_name='$new_username' WHERE user_name='$user_name' ";
        return $qr;
    }

//    public function checkUserNameExisit($user_name) {
//        $table = "mlm_user";
//        $qr = "SELECT count(user_name) as cnt FROM $table  WHERE user_name='$user_name' ";
//        return $qr;
//    }
    
        public function checkUserNameExisit($user_name) {
        $table = "mlm_user";
        $flag = 'false';
        $qr = "SELECT count(user_name) as cnt FROM $table  WHERE user_name='$user_name' ";
        $result = $this->selectData($qr, "ERROR OCCURED >>>>>> is unilevel");
        $row = mysql_fetch_array($result);
        if ($row["cnt"] > 0)
            $flag = TRUE;
        return $flag;
    }

}
