<?php

class Profile_model extends CI_Model {

    public function getUserDetails($user_id) {

        $data = array();
        $res = $this->db->select("us.user_name,us.email,us.tran_password,us.sponsor_id,us.date")
                ->select("ud.first_name,ud.last_name,ud.date_of_birth,ud.gender,ud.phone_number,ud.address_1,ud.city,ud.zip_code,ud.state_id,ud.country_id,ud.user_dp,ud.user_cover")
                ->from("user as us")
                ->join('user_details as ud', "us.mlm_user_id=ud.mlm_user_id", "INNER")
                ->where("us.mlm_user_id", $user_id)
                ->get();
        foreach ($res->result() as $row) {
            $data['user_name'] = $row->user_name;
            $data['email'] = $row->email;
            $data['tran_password'] = $row->tran_password;
            $data['sponsor_name'] = $this->helper_model->IdToUserName($row->sponsor_id);
            $data['date'] = $row->date;
            $data['first_name'] = $row->first_name;
            $data['last_name'] = $row->last_name;
            $data['address_1'] = $row->address_1;
            $data['zipcode'] = $row->zip_code;
            $data['state'] = $row->state_id;
            $data['country'] = $row->country_id;
            $data['user_dp'] = $row->user_dp;
            $data['user_cover'] = $row->user_cover;
            $data['gender'] = $row->gender;
            $data['city'] = $row->city;
            $data['phone_number'] = $row->phone_number;
            $data['date_of_birth'] = $row->date_of_birth;
            $data['rank_name'] = '';
            $data['replica_link'] = $this->BASE_URL;
        }
        return $data;
    }

    function updateUserProfile($user_id, $post) {
        return $this->db->set('first_name ', $post['firstname'])
                ->set('last_name ', $post['lastname'])
                ->set('address_1 ', $post['address'])
                ->set('city ', $post['city'])
                ->set('zip_code ', $post['zipcode'])
                ->set('state_id ', $post['state'])
                ->set('country_id ', $post['country'])
                ->set('date_of_birth ', $post['dob'])
                ->set('gender ', $post['gender'])
                ->set('phone_number ', $post['phone_number'])
                ->where('mlm_user_id ', "$user_id")
                ->update('user_details');
    }
    
    function updateUserPic($user_id, $file) {
        $res=$this->db->set('user_dp ', $file['upload_data']['file_name'])
                ->where('mlm_user_id ', "$user_id")
                ->update('user_details');
        return $res;
        
    }
    
    function updateUserCover($user_id, $file) {
        $res=$this->db->set('user_cover ', $file['upload_data']['file_name'])
                ->where('mlm_user_id ', "$user_id")
                ->update('user_details');
        return $res;
        
    }

}
