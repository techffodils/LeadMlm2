<?php

class Helper_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertActivity($user_id, $activity,$data) {
        $this->db->set('mlm_user_id', $user_id);
        $this->db->set('activity', $activity);
        $this->db->set('ip_address', $this->getUserIP());
        $this->db->set('data', $data);
        $this->db->set('date', date("Y-m-d H:i:s"));
        $result = $this->db->insert('mlm_activity');
        return $result;
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
        $this->db->from("mlm_user");
        if ($status)
            $this->db->where('active', $status);
        $numrows = $this->db->count_all_results();
        return $numrows;
    }

    public function getUserFullName($user_id) {
        $user_full_name = 'NA';
        $this->db->select('first_name,last_name ');
        $this->db->from('mlm_user_details');
        $this->db->where('mlm_user_d ', "$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $val) {
            $user_full_name = $val->first_name . " " . $val->last_name;
        }
        return $user_full_name;
    }

    public function changeUserStatus($user_id, $status = 'active') {
        $this->db->set('user_status ', "$status");
        $this->db->where('mlm_user_id ', "$user_id");
        $query = $this->db->update('mlm_user');
        return $query;
    }

    public function userNameToID($username) {
        $user_id = 0;
        $this->db->select('mlm_user_id');
        $this->db->from('mlm_user');
        $this->db->where("(user_name = '$username' OR email = '$username') ");
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('mlm_user');
        $this->db->where('mlm_user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getFatherId($user_id) {
        $father_id = NULL;
        $this->db->select('father_id');
        $this->db->from('mlm_user');
        $this->db->where('mlm_user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $father_id = $row->father_id;
        }
        return $father_id;
    }

    public function getSponsorId($user_id) {
        $sponsor_id = NULL;
        $this->db->select('sponsor_id');
        $this->db->from('mlm_user');
        $this->db->where('mlm_user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sponsor_id = $row->sponsor_id;
        }
        return $sponsor_id;
    }

    public function getUserEmailId($user_id) {
        $email_id = NULL;
        $this->db->select("email");
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_id", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_id = $row->email;
        }
        return $email_id;
    }

    public function isUserAvailable($user_id) {
        $flag = false;
        $this->db->select("mlm_user_id");
        $this->db->from("mlm_user");
        $this->db->where('mlm_user_id', $user_id);
        $qr = $this->db->get();
        $user_avail = $qr->num_rows();
        if ($user_avail > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getProductId($user_id) {
        $product_id = '';
        $this->db->select("product_id");
        $this->db->where('mlm_user_id', $user_id);
        $query = $this->db->get("mlm_user");
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getAdminId() {
        $user_id = NULL;
        $this->db->select('mlm_user_d');
        $this->db->from('mlm_user');
        $this->db->where('user_type', 'admin');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_d;
        }
        return $user_id;
    }

    public function getAdminUsername() {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('mlm_user');
        $this->db->where('user_type', "admin");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAdminPassword() {
        $password = NULL;
        $this->db->select("password");
        $this->db->from("mlm_user");
        $this->db->where("user_type", 'admin');
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserPassword($user_id) {
        $password = NULL;
        $this->db->select("password");
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_id", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserLoginStatus($user_id, $password) {
        $user_status = 'NA';
        $this->db->select("user_status");
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_id", $user_id);
        $this->db->where("password ", $password);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $user_status = $row->user_status;
        }
        return $user_status;
    }

    public function getJoiningDate($user_id) {
        $date_of_joining = NULL;
        $this->db->select("date");
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_d", $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $date_of_joining = $row->date;
        }
        return $date_of_joining;
    }

    public function getUserRank($user_id) {
        $rank = NULL;
        $this->db->select('user_rank_id');
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_d", $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getReferalCount($sponsor_id) {
        $count = NULL;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("mlm_user");
        $this->db->where('sponsor_id', $sponsor_id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getUserType($user_id) {
        $user_type = "";
        $this->db->select('user_type');
        $this->db->from("mlm_user");
        $this->db->where("mlm_user_d", $user_id);
        foreach ($res->result_array() as $row) {
            $user_type = $row['user_type'];
        }
        return $user_type;
    }

}

?>
