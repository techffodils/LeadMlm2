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
                $this->updateUserDetails($add_user,$user_details);
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
        $position='';
        $res=$this->db->set('user_name ', $user_details['username'])
                ->set('email', $user_details['email'])
                ->set('password ', $password)
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
    
    public function insertUserDetails($user_id,$user_details) {
        $res=$this->db->set('mlm_user_id ', $user_id)
                ->set('first_name', $user_details['first_name'])
                ->set('date_of_joining', $user_details['date_of_joining'])
                ->insert('user_details');

        if ($res) {
            return $this->db->insert_id();
        }
        return false;
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
    

}
