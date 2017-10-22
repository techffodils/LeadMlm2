<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function enrollEmployee($data) {
       // print_r($data);die;
        $this->db->trans_start();
        $array = array('user_name' => $data['user_name'],
            'password' => hash("sha256", $data['password'])
        );
        $result = $this->db->insert('employee_login', $array);
        $data['insert_id'] = $this->db->insert_id();
        if ($result) {
            $emp_data = array(
                'employee_id' => $data['insert_id'],
                'first_name' => $data['firstname'],
                'last_name' => $data['lastname'],
                'gender' => $data['gender'],
                'date_of_bith' => $data['year'] . '-' . $data['month'] . '-' . $data['day'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'zipcode' => $data['zipcode'],
            );
            $res = $this->db->insert('employee_details', $emp_data);
            $this->helper_model->insertActivity($data['user_id'], 'Enroll New Emolyeee', serialize($data));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function checkIsUserNameExistsOrNot($user_name) {
        $result = $this->db->select('count(*)as  cnt')->from('employee_login')->like('user_name', $user_name)->count_all_results();
        return $result;
    }

}
