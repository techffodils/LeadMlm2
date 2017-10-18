<?php

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function addUser($register_type, $user_details) {
        $entry=FALSE;
        $add_user=$this->addToUsers($user_details);
        if($add_user){
            $user_details=$this->insertUserDetails($add_user,$user_details);
            $entry=$this->insertUsersEntry($add_user);
        }
        
        if($entry){
            $user_details['new_user_id']=$add_user;
            $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'user_registered',$user_details);
            //Commission
            
            //Register Mails
        }
        return $entry;
    }

    public function addToUsers($user_details) {
        $sponsor_id=$this->helper_model->userNameToID($user_details['sponser_name']);
        $father_id=$this->helper_model->userNameToID($user_details['sponser_name']);
        $position='';
        $res=$this->db->set('user_name ', $user_details['username'])
                ->set('email', $user_details['email'])
                ->set('password ', $user_details['password'])
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
                //->set('last_name ', $user_details['last_name'])
                //->set('address_1', $user_details['address_1'])
                //->set('address_2', $user_details['address_2'])
               // ->set('city', $user_details['city'])
               // ->set('district ', $user_details['district'])
               // ->set('state_id', $user_details['state_id'])
               // ->set('country_id', $user_details['country_id'])
                ->set('date_of_joining', $user_details['date_of_joining'])
                ->insert('user_details');

        if ($res) {
            return $this->db->insert_id();
        }
        return false;
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
    

}
