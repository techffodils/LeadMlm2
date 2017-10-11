<?php

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        $email = $username;
        if ($username != '' && $password != '') {
            $query = $this->db->select('mlm_user_id,user_name,user_type,mlm_user_id,email')
                            ->where("(user_name ='$username' OR email ='$username')")
                            ->where('password', $password)
                            ->from('user')
                            ->limit(1)->get();
        } else {
            return false;
        }
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function setUserLoginSession($login_result) {
        $array = array();
        foreach ($login_result as $row) {
            $array = array(
                'mlm_username' => $row->user_name,
                'mlm_user_type' => $row->user_type,
                'mlm_user_id' => $row->mlm_user_id,
                'mlm_email' => $row->email,
                'is_logged_in' => true
            );
        }
        $this->session->set_userdata('mlm_logged_arr', $array);
    }

    function checkEmailExitsOrNot($email) {

        $result = $this->db->select("COUNT(*) as cnt")->where('email', $email)->count_all_results();
        return $result;
    }

}

?>
