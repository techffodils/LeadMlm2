<?php

class Helper_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

<<<<<<< HEAD
    public function insertActivity($user_id, $activity,$data) {
        $this->db->set('mlm_user_id', $user_id);
        $this->db->set('activity', $activity);
        $this->db->set('ip_address', $this->getUserIP());
        $this->db->set('data', $data);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $result = $this->db->insert('mlm_activity');
        return $result;
=======
    public function insertActivity($user_id, $activity, $data = array()) {
        return $this->db->set('mlm_user_id', $user_id)
                        ->set('activity', $activity)
                        ->set('ip_address', $this->getUserIP())
                        ->set('date', date("Y-m-d H:i:s"))
                        ->set('data', serialize($data))
                        ->insert('activity');
>>>>>>> 03048d1fab64371bcbfe72cb1764808c362fbe47
    }

    function getUserIP() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

    public function stripTagsPost($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = strip_tags($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    function getTotalUserCount($status = 'active') {
        $this->db->select('mlm_user_id');
        $this->db->from("user");
        if ($status)
            $this->db->where('active', $status);
        return $this->db->count_all_results();
    }

    public function getUserFullName($user_id) {
        $user_full_name = 'NA';
        $query = $this->db->select('first_name,last_name ')
                ->from('user_details')
                ->where('mlm_user_d ', "$user_id")
                ->get();
        foreach ($query->result() as $val) {
            $user_full_name = $val->first_name . " " . $val->last_name;
        }
        return $user_full_name;
    }

    public function changeUserStatus($user_id, $status = 'active') {
        return $this->db->set('user_status ', "$status")
                        ->where('mlm_user_id ', "$user_id")
                        ->update('user');
    }

    public function userNameToID($username) {
        $user_id = 0;
        $query = $this->db->select('mlm_user_id')
                ->from('user')
                ->where("(user_name = '$username' OR email = '$username') ")
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $query = $this->db->select('user_name')
                ->from('user')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getFatherId($user_id) {
        $father_id = NULL;
        $query = $this->db->select('father_id')
                ->from('user')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $father_id = $row->father_id;
        }
        return $father_id;
    }

    public function getSponsorId($user_id) {
        $sponsor_id = NULL;
        $query = $this->db->select('sponsor_id')
                ->from('user')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get();

        foreach ($query->result() as $row) {
            $sponsor_id = $row->sponsor_id;
        }
        return $sponsor_id;
    }

    public function getUserEmailId($user_id) {
        $email_id = NULL;
        $query = $this->db->select("email")
                        ->from("user")
                        ->where("mlm_user_id", $user_id)
                        ->limit(1)
                ->db->get();
        foreach ($query->result() as $row) {
            $email_id = $row->email;
        }
        return $email_id;
    }

    public function isUserAvailable($user_id) {
        $flag = false;
        return $this->db->select("mlm_user_id")
                        ->from("user")
                        ->where('mlm_user_id', $user_id)
                        ->count_all_results();
    }

    public function getProductId($user_id) {
        $product_id = '';
        $query = $this->db->select("product_id")
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getAdminId() {
        $user_id = NULL;
        $query = $this->db->select('mlm_user_d')
                        ->from('user')
                        ->where('user_type', 'admin')
                        ->limit(1)
                ->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_d;
        }
        return $user_id;
    }

    public function getAdminUsername() {
        $user_name = NULL;
        $query = $this->db->select('user_name')
                ->from('user')
                ->where('user_type', "admin")
                ->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAdminPassword() {
        $password = NULL;
        $query = $this->db->select("password")
                ->from("user")
                ->where("user_type", 'admin')
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserPassword($user_id) {
        $password = NULL;
        $query = $this->db->select("password")
                ->from("user")
                ->where("mlm_user_id", $user_id)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserLoginStatus($user_id, $password) {
        $user_status = 'NA';
        $query = $this->db->select("user_status")
                ->from("user")
                ->where("mlm_user_id", $user_id)
                ->where("password ", $password)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $user_status = $row->user_status;
        }
        return $user_status;
    }

    public function getJoiningDate($user_id) {
        $date_of_joining = NULL;
        $query = $this->db->select("date")
                ->from("user")
                ->where("mlm_user_d", $user_id)
                ->get();
        foreach ($query->result() as $row) {
            $date_of_joining = $row->date;
        }
        return $date_of_joining;
    }

    public function getUserRank($user_id) {
        $rank = NULL;
        $query = $this->db->select('user_rank_id')
                ->from("user")
                ->where("mlm_user_d", $user_id)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getReferalCount($sponsor_id) {
        $count = NULL;
        $query = $this->db->select("COUNT(*) AS cnt")
                ->from("user")
                ->where('sponsor_id', $sponsor_id)
                ->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getUserType($user_id) {
        $user_type = "";
        $query = $this->db->select('user_type')
                ->from("user")
                ->where("mlm_user_d", $user_id);
        foreach ($query->result_array() as $row) {
            $user_type = $row['user_type'];
        }
        return $user_type;
    }

    function encode($string = '') {
        $encode_key = '';
        if ($string != '') {
            $encrypt_string = $this->encrpt->encode($sting);
            $encode_key = urlencode(base64_encode($encrypt_string));
        }

        return $encode_key;
    }

    function decode($encode_data = '') {
        $decode_key = '';
        if ($encode_data != '') {
            $decode_string = base64_decode(urldecode($encode_data));
            $decode_key = $this->encrypt->decode($decode_string);
        }

        return $decode_key;
    }

}

?>
