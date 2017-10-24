<?php

class Helper_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertActivity($user_id, $activity, $data = array()) {
        if (!$user_id) {
            return FALSE;
        }
        return $this->db->set('mlm_user_id', $user_id)
                        ->set('activity', $activity)
                        ->set('ip_address', $this->getUserIP())
                        ->set('date', date("Y-m-d H:i:s"))
                        ->set('data', serialize($data))
                        ->insert('activity');
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
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get('user_details');
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
                ->where("(user_name = '$username' OR email = '$username') ")
                ->limit(1)
                ->get('user');
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $query = $this->db->select('user_name')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get('user');
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getFatherId($user_id) {
        $father_id = NULL;
        $query = $this->db->select('father_id')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get('user');
        foreach ($query->result() as $row) {
            $father_id = $row->father_id;
        }
        return $father_id;
    }

    public function getSponsorId($user_id) {
        $sponsor_id = NULL;
        $query = $this->db->select('sponsor_id')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get('user');

        foreach ($query->result() as $row) {
            $sponsor_id = $row->sponsor_id;
        }
        return $sponsor_id;
    }

    public function getUserEmailId($user_id) {
        $email_id = NULL;
        $query = $this->db->select("email")
                ->where("mlm_user_id", $user_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $email_id = $row->email;
        }
        return $email_id;
    }

    public function getUserIdFromEmailId($email) {
        $user_id = NULL;
        $query = $this->db->select("mlm_user_id")
                ->where("email", $email)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_id;
        }
        return $user_id;
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
        $query = $this->db->select('mlm_user_id')
                ->where('user_type', 'admin')
                ->limit(1)
                ->get('user');
        foreach ($query->result() as $row) {
            $user_id = $row->mlm_user_id;
        }
        return $user_id;
    }

    public function getAdminUsername() {
        $user_name = NULL;
        $query = $this->db->select('user_name')
                ->where('user_type', "admin")
                ->from('user');
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAdminPassword() {
        $password = NULL;
        $query = $this->db->select("password")
                ->where("user_type", 'admin')
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserPassword($user_id) {
        $password = NULL;
        $query = $this->db->select("password")
                ->where("mlm_user_id", $user_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getUserLoginStatus($user_id, $password) {
        $user_status = 'NA';
        $query = $this->db->select("user_status")
                ->where("mlm_user_id", $user_id)
                ->where("password ", $password)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $user_status = $row->user_status;
        }
        return $user_status;
    }

    public function getJoiningDate($user_id) {
        $date_of_joining = NULL;
        $query = $this->db->select("date")
                ->where("mlm_user_d", $user_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $date_of_joining = $row->date;
        }
        return $date_of_joining;
    }

    public function getUserRank($user_id) {
        $rank = NULL;
        $query = $this->db->select('user_rank_id')
                ->where("mlm_user_d", $user_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getReferalCount($sponsor_id) {
        $count = NULL;
        $query = $this->db->select("COUNT(*) AS cnt")
                ->where('sponsor_id', $sponsor_id)
                ->limit(1)
                ->get("user");
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getUserType($user_id) {
        $user_type = "";
        $query = $this->db->select('user_type')
                ->where("mlm_user_d", $user_id)
                ->limit(1)
                ->from("user");
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

    public function getUserBalance($user_id) {
        $balance_amount = 0;
        $query = $this->db->select('balance_amount')
                ->from('user_balance')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get();
        foreach ($query->result() as $row) {
            $balance_amount = $row->balance_amount;
        }
        return $balance_amount;
    }

    function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    public function insertWalletDetails($user_id, $type = 'credit', $amount = '0', $wallet_type, $from_user = 0) {
        if ($amount > 0 && ($type == 'credit' || $type == 'debit')) {
            $res = $this->db->set('mlm_user_id', $user_id)
                    ->set('type', $type)
                    ->set('amount', $amount)
                    ->set('wallet_type', $wallet_type)
                    ->set('date', date("Y-m-d H:i:s"))
                    ->set('from_user', $from_user)
                    ->insert('wallet_details');
            if ($res) {
                if ($type == 'credit') {
                    $this->addBalance($user_id, $amount);
                } elseif ($type == 'debit') {
                    $this->deductBalance($user_id, $amount);
                }
                return TRUE;
            }
        }
        return FALSE;
    }

    public function addBalance($user_id, $amount) {
        return $this->db->set('balance_amount', 'ROUND(balance_amount +' . $amount . ',8)', FALSE)
                ->set('total_amount', 'ROUND(total_amount +' . $amount . ',8)', FALSE)
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->update('user_balance');

    }

    public function deductBalance($user_id, $amount) {
        return $this->db->set('balance_amount', 'ROUND(balance_amount -' . $amount . ',8)', FALSE)
                ->set('released_amount', 'ROUND(released_amount +' . $amount . ',8)', FALSE)
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->update('user_balance');
    }
    
    
    public function getTransactionPassword($user_id) {
        $tran_password = NULL;
        $query = $this->db->select('tran_password')
                ->where('mlm_user_id', $user_id)
                ->limit(1)
                ->get('user');
        foreach ($query->result() as $row) {
            $tran_password = $row->tran_password;
        }
        return $tran_password;
    }

}

?>
