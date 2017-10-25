<?php

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function addUser($register_type, $user_details, $mlm_plan = 'BINARY', $leg_type = "static") {
        $entry = FALSE;
        $add_user = $this->createUsers($user_details, $mlm_plan, $leg_type);
        if ($add_user) {
            $ud = $this->insertUserDetails($add_user, $user_details);
            $entry = $this->insertUsersEntry($add_user);

            if ($entry) {
                $user_details['new_user_id'] = $add_user;
                if ($register_type == 'multiple_step') {
                    $this->updateUserDetails($add_user, $user_details);
                } elseif ($register_type == 'advanced') {
                    $this->updateAdvancedUserDetails($add_user, $user_details);
                }
                $this->helper_model->insertActivity($this->LOG_USER_ID, 'user_registered', $user_details);
                //Commission
                //Register Mails   
                $this->insertRegisterHistory($add_user, $register_type, $user_details);
            }
        }
        return $entry;
    }

    public function createUsers($user_details, $mlm_plan, $leg_type) {
        $sponsor_id = $this->helper_model->userNameToID($user_details['sponser_name']);

        $leg = '';
        if ($mlm_plan == 'BINARY') {
            if ($leg_type == "static") {
                $leg = $user_details['register_leg'];
            } elseif ($leg_type == "left") {
                $leg = 'L';
            } elseif ($leg_type == "right") {
                $leg = 'R';
            } elseif ($leg_type == "balanced") {
                $leg = 'R'; //Find Balanced Leg
            }
        } else {
            $leg = $this->getUserLevel($father_id) + 1;
        }

        $father_id = $this->createFatherID($sponsor_id, $mlm_plan, $leg_type); //find Based On Plan

        $password = hash("sha256", $user_details['password']);
        $transaction_pass = $this->generateRandomString();

        $res = $this->db->set('user_name ', $user_details['username'])
                ->set('email', $user_details['email'])
                ->set('password ', $password)
                ->set('tran_password', $transaction_pass)
                ->set('position', $leg)
                ->set('user_type', 'user')
                ->set('father_id ', $father_id)
                ->set('sponsor_id', $sponsor_id)
                ->set('user_status', 'active')
                ->set('date', $user_details['date_of_joining'])
                ->insert('user');

        if ($res) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function createFatherID($sponsor_id, $mlm_plan, $leg_type) {
        if ($mlm_plan == 'BINARY') {
            return $sponsor_id;
        } elseif ($mlm_plan == 'MATRIX') {
            return $sponsor_id;
        } elseif ($mlm_plan == 'MONOLINE') {
            $this->getLastUserId();
        } else {
            return $sponsor_id;
        }
    }

    public function generateRandomString() {
        $this->load->helper('string');
        return random_string('alnum', 8);
    }

    public function insertUserDetails($user_id, $user_details) {
        return $this->db->set('mlm_user_id ', $user_id)
                        ->set('first_name', $user_details['first_name'])
                        ->set('country_id', $user_details['country'])
                        ->set('state_id', $user_details['state'])
                        ->set('date_of_joining', $user_details['date_of_joining'])
                        ->insert('user_details');
    }

    public function updateUserDetails($user_id, $user_details) {
        return $this->db->set('first_name', $user_details['first_name'])
                        ->set('last_name ', $user_details['last_name'])
                        ->set('address_1', $user_details['address'])
                        ->set('city', $user_details['city'])
                        ->set('state_id', $user_details['state'])
                        ->set('country_id', $user_details['country'])
                        ->set('zip_code', $user_details['zip_code'])
                        ->set('gender', $user_details['gender'])
                        ->set('phone_number', $user_details['phone_number'])
                        ->where('mlm_user_id', $user_id)
                        ->update('user_details');
    }

    public function insertUsersEntry($user_id) {
        $user_balance = $this->db->set('mlm_user_id ', $user_id)
                ->set('balance_amount', 0)
                ->set('total_amount ', 0)
                ->set('released_amount', 0)
                ->insert('user_balance');

        $theme_settings = $this->db->set('user_id ', $user_id)
                ->insert('theme_settings');
        if ($user_balance && $theme_settings) {
            return TRUE;
        }
        return FALSE;
    }

    public function insertRegisterHistory($add_user, $register_type, $user_details) {
        $this->db->set('mlm_user_id ', $add_user)
                ->set('register_type', $register_type)
                ->set('user_details ', serialize($user_details))
                ->set('date', $user_details['date_of_joining'])
                ->set('payment_type', $user_details['payment_type'])
                ->insert('register_history');
    }

    public function updateAdvancedUserDetails($user_id, $user_details) {
        $res = 0;
        $new = $this->getAllNewRegFields();
        if (count($new)) {
            foreach ($new as $fld) {
                if ($this->checkTable($fld['name'])) {
                    if(isset($user_details[$fld['name']])){
                        $val=$user_details[$fld['name']];
                    }else{
                        $val=$fld['default_value'];
                    }
                    $this->db->set($fld['name'], $val);
                }
            }
            $this->db->where('mlm_user_id', $user_id);
            $res = $this->db->update('user_details');
        }
        return $res;
    }

    function checkTable($field) {
        $res = 0;
        $columns = $this->db->list_fields('user_details');
        foreach ($columns AS $key => $value) {
            if ($value == $field) {
                $res = 1;
            }
        }
        return $res;
    }

    function getAllNewRegFields() {
        $data = array();
        $query = $this->db->select("field_name,default_value")
                ->from("register_fields")
                ->where("status", 'active')
                ->where("editable_status", '1')
                ->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $data[$i]['name'] = $row['field_name'];
            $data[$i]['default_value'] = $row['default_value'];
            $i++;
        }
        return $data;
    }

    function getAllCountries() {
        $data = array();
        $query = $this->db->select("country_id,country_name")
                ->from("countries")
                ->where("status", '1')
                ->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $data[$i]['name'] = $row['country_name'];
            $data[$i]['id'] = $row['country_id'];
            $i++;
        }
        return $data;
    }

    function getAllStates($country_id) {
        $data = array();
        $query = $this->db->select("state_id,state_name")
                ->from("states")
                ->where("status", '1')
                ->where('country_id', $country_id)
                ->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $data[$i]['name'] = $row['state_name'];
            $data[$i]['id'] = $row['state_id'];
            $i++;
        }
        return $data;
    }

    function getUserLevel($user_id) {
        return $this->db->select('mlm_user_id')
                        ->from("user")
                        ->where('father_id', $user_id)
                        ->count_all_results();
    }

    function getLastUserId() {
        $mlm_user_id = '';
        $query = $this->db->select('mlm_user_id')
                ->order_by('mlm_user_id', 'DESC')
                ->limit(1)
                ->get('users');
        foreach ($query->result() as $val) {
            $mlm_user_id = $val->mlm_user_id;
        }
        return $mlm_user_id;
    }

    public function generateRandomUsername($length) {
        $username = '';
        $this->load->helper('string');
        $username_prefix = $this->dbvars->USERNAME_PREFIX;
        $prefix_legth = strlen($username_prefix);
        $flag = 1;
        while ($flag) {
            $username = $username_prefix . random_string('alnum', 8);
            if (!$this->helper_model->userNameToID($username)) {
                $flag = 0;
            }
        }
        return $username;
    }

    function getAllRegFields($country = '', $mlm_plan = '', $leg_type = '', $username_type = '') {
        $data = array();
        $data['step-1'] = $data['step-2'] = $data['step-3'] = array();
        $query = $this->db->select("*")
                ->from("register_fields")
                ->where("status", 'active')
                ->order_by('register_step', 'ASC')
                ->order_by('order', 'ASC')
                ->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $flag = 1;
            if ($row['field_name'] == "username" && $username_type == 'dynamic') {
                $flag = 0;
            }
            if ($row['field_name'] == "register_leg" && ($mlm_plan != 'BINARY' || $leg_type != "static")) {
                $flag = 0;
            }
            if ($flag) {
                $data[$row['register_step']][$i] = $row;

                $data[$row['register_step']][$i]['select_box_values'] = array();
                if ($row['field_name'] == "country") {
                    $data[$row['register_step']][$i]['select_box_values'] = $this->getAllCountries();
                } elseif ($row['field_name'] == "state") {
                    $data[$row['register_step']][$i]['select_box_values'] = $this->getAllStates($country);
                } elseif ($row['field_name'] == "register_leg") {
                    $data[$row['register_step']][$i]['select_box_values'][1]['id'] = 'L';
                    $data[$row['register_step']][$i]['select_box_values'][1]['name'] = lang('left');
                    $data[$row['register_step']][$i]['select_box_values'][2]['id'] = 'R';
                    $data[$row['register_step']][$i]['select_box_values'][2]['name'] = lang('right');
                } else {
                    $data[$row['register_step']][$i]['select_box_values'][1]['id'] = $row['select_option1'];
                    $data[$row['register_step']][$i]['select_box_values'][1]['name'] = $row['select_option1'];
                    $data[$row['register_step']][$i]['select_box_values'][2]['id'] = $row['select_option2'];
                    $data[$row['register_step']][$i]['select_box_values'][2]['name'] = $row['select_option2'];
                    $data[$row['register_step']][$i]['select_box_values'][3]['id'] = $row['select_option3'];
                    $data[$row['register_step']][$i]['select_box_values'][3]['name'] = $row['select_option3'];
                    $data[$row['register_step']][$i]['select_box_values'][4]['id'] = $row['select_option4'];
                    $data[$row['register_step']][$i]['select_box_values'][4]['name'] = $row['select_option4'];
                }

                $i++;
            }
        }
        return $data;
    }

}
