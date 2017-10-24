<?php

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function addUser($register_type, $user_details) {
        $entry=FALSE;
        $add_user=$this->addToUsers($user_details);
        if($add_user){
            $ud=$this->insertUserDetails($add_user,$user_details);
            $entry=$this->insertUsersEntry($add_user);
        }
        
        if($entry){
            $user_details['new_user_id']=$add_user;            
            if($register_type=='multiple_step'){
                $this->updateUserDetails($add_user,$user_details);
            }elseif($register_type=='advanced'){
                $this->updateAdvancedUserDetails($add_user,$user_details);
            }
            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'user_registered',$user_details);
            $this->insertRegisterHistory($add_user,$register_type, $user_details);
            //Commission
            
            //Register Mails
            
        }
        return $entry;
    }

    public function addToUsers($user_details) {
        $sponsor_id=$this->helper_model->userNameToID($user_details['sponser_name']);
        $father_id=$this->helper_model->userNameToID($user_details['sponser_name']);
        $password=hash("sha256", $user_details['password']);
        $transaction_pass=$this->generateRandomString();
        $position='';
        $res=$this->db->set('user_name ', $user_details['username'])
                ->set('email', $user_details['email'])
                ->set('password ', $password)
                ->set('tran_password',$transaction_pass)
                ->set('user_type', 'user')
                ->set('father_id ', $father_id)
                ->set('sponsor_id', $sponsor_id)
                ->set('position  ', $position)
                ->set('user_status', 'active')
                ->set('date', $user_details['date_of_joining'])
                ->insert('user');

        if ($res) {
            return $this->db->insert_id();
        }
        return false;
    }
    
    public function generateRandomString() {
        $pin = $this->load->helper('string');
        return random_string('alnum', 8);
    }
    
    public function insertUserDetails($user_id,$user_details) {
        return $this->db->set('mlm_user_id ', $user_id)
                ->set('first_name', $user_details['first_name'])
                ->set('date_of_joining', $user_details['date_of_joining'])
                ->insert('user_details');
    }
    
    public function updateUserDetails($user_id,$user_details) {
        return $this->db->set('first_name', $user_details['first_name'])
                ->set('last_name ', $user_details['last_name'])
                ->set('address_1', $user_details['address'])
                ->set('city', $user_details['city'])
                ->set('state_id', $user_details['state_id'])
                ->set('country_id', $user_details['country_id'])
                ->set('zip_code', $user_details['zip_code'])
                ->set('gender', $user_details['gender'])
                ->set('phone_number', $user_details['phone_number'])
                ->where('mlm_user_id',$user_id)
                ->update('user_details');
    }
    
    public function insertUsersEntry($user_id) {
        $user_balance=$this->db->set('mlm_user_id ', $user_id)
                ->set('balance_amount', 0)
                ->set('total_amount ', 0)
                ->set('released_amount', 0)
                ->insert('user_balance');

        $theme_settings=$this->db->set('user_id ', $user_id)
                ->insert('theme_settings');
        if($user_balance && $theme_settings){
            return TRUE;
        }
        return FALSE;
        
    }
    
    public function insertRegisterHistory($add_user,$register_type, $user_details){
        $this->db->set('mlm_user_id ', $add_user)
                ->set('register_type', $register_type)
                ->set('user_details ', serialize($user_details))
                ->set('date', $user_details['date_of_joining'])
                ->set('payment_type',$user_details['payment_type'])
                ->insert('register_history');
    }
    
    
    function getAllRegFields() {
        $data = array();
        $data['step-1']=$data['step-2']=$data['step-3']=array();
        $query = $this->db->select("*")
                ->from("register_fields")
                ->where("status", 'active')
                ->order_by('register_step','ASC')
                ->order_by('order','ASC')                
                ->get();
        $i = 0;        
        foreach ($query->result_array() as $row) {
            $data[$row['register_step']][$i] = $row;            
            $i++;
        }
        return $data;
    }
    
    public function updateAdvancedUserDetails($user_id,$user_details) {
        $res=0;
        $new=$this->getAllNewRegFields();
        if(count($new)){
            foreach ($new as $fld) {
                if($this->checkTable($fld)){
                    $this->db->set($fld, $user_details[$fld]);
                }
            }
            $this->db->where('mlm_user_id',$user_id);
            $res=$this->db->update('user_details');
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
        $query = $this->db->select("field_name")
                ->from("register_fields")
                ->where("status", 'active')
                ->where("editable_status", '1')
                ->get();
        $i = 0;        
        foreach ($query->result_array() as $row) {
            $data[$i] = $row['field_name'];            
            $i++;
        }
        return $data;
    }
    

}
