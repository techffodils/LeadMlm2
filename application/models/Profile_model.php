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
        return $this->db->set('first_name ', $post['first_name'])
                        ->set('last_name ', $post['last_name'])
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
        $res = $this->db->set('user_dp ', $file['upload_data']['file_name'])
                ->where('mlm_user_id ', "$user_id")
                ->update('user_details');
        if ($res) {
            $this->insertUserPictureHistory($user_id, $file['upload_data']['file_name'], 'user_dp');
        }
        return $res;
    }

    function updateUserCover($user_id, $file) {
        $res = $this->db->set('user_cover ', $file['upload_data']['file_name'])
                ->where('mlm_user_id ', "$user_id")
                ->update('user_details');
        if ($res) {
            $this->insertUserPictureHistory($user_id, $file['upload_data']['file_name'], 'user_cover');
        }
        return $res;
    }

    function insertUserPictureHistory($user_id, $file_name, $file_type) {
        return $this->db->set('mlm_user_id', $user_id)
                        ->set('file_name', $file_name)
                        ->set('file_type', $file_type)
                        ->set('date', date("Y-m-d H:i:s"))
                        ->insert('user_files');
    }

    public function getUserFiles($user_id) {
        $data['dp'] = $data['co'] = array();
        $dp = $co = 0;
        $res = $this->db->select("id,file_name,file_type")
                ->from("user_files")
                ->where("mlm_user_id", $user_id)
                ->get();
        foreach ($res->result() as $row) {
            if ($row->file_type == "user_dp") {
                $data['dp'][$dp]['id'] = $row->id;
                $data['dp'][$dp]['file'] = $row->file_name;
                $dp++;
            } else {
                $data['co'][$co]['id'] = $row->id;
                $data['co'][$co]['file'] = $row->file_name;
                $co++;
            }
        }
        return $data;
    }

    public function resetUserFile($id) {
        $flag = 0;
        $res = $this->db->select("mlm_user_id,file_name,file_type")
                ->from("user_files")
                ->where("id", $id)
                ->limit(1)
                ->get();
        foreach ($res->result() as $row) {
            if ($row->file_type == "user_cover") {
                $flag=$this->setCover($row->mlm_user_id,$row->file_name);                
            } elseif ($row->file_type == "user_dp") {
                $flag=$this->setDp($row->mlm_user_id,$row->file_name); 
            }
        }
        return $flag;
    }

    public function setCover($mlm_user_id,$file_name) {
        return $this->db->set('user_cover ', $file_name)
        ->where('mlm_user_id ', $mlm_user_id)
        ->update('user_details');
    }
    
    public function setDp($mlm_user_id,$file_name) {
        return $this->db->set('user_dp ', $file_name)
        ->where('mlm_user_id ', $mlm_user_id)
        ->update('user_details');
    }

}
