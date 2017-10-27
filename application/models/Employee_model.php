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
                'date_of_birth' => $data['year'] . '-' . $data['month'] . '-' . $data['day'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country'],
                'state' => $data['state'],
                'user_photo' => $data['photo'],
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
        if ($result > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * function for list all Regstered Employee
     * @autho Techffodils
     * @date 2017-10-23
     */
    function getAllRegisteredEmployee() {
        $result = $this->db->select('id,employee_login.employee_id,user_photo,employee_login.status,user_name,first_name,last_name,email,address,phone,country,zipcode,gender,date_of_birth')->from('employee_details')->join('employee_login', 'employee_login.employee_id=employee_details.employee_id', 'left')->get();
        $i = 0;
        $details = array();
        foreach ($result->result_array() as $row) {
            $details[$i]['id'] = $row['id'];
            $details[$i]['employee_id'] = $row['employee_id'];
            $details[$i]['user_name'] = $row['user_name'];
            $details[$i]['first_name'] = $row['first_name'];
            $details[$i]['last_name'] = $row['last_name'];
            $details[$i]['email'] = $row['email'];
            $details[$i]['address'] = $row['address'];
            $details[$i]['phone'] = $row['phone'];
            $explode = explode('-', $row['date_of_birth']);
            $details[$i]['month'] = $explode[1];
            $details[$i]['year'] = $explode[0];
            $details[$i]['day'] = $explode[2];
            $details[$i]['country'] = $row['country'];
            $details[$i]['gender'] = $row['gender'];
            $details[$i]['status'] = $row['status'];
            $details[$i]['user_photo'] = $row['user_photo'];
            $details[$i]['date_of_birth'] = $row['date_of_birth'];
            $i++;
        }
        return $details;
    }

    function getSelectedUserData($id) {
        $result = $this->db->select('ed.id,el.status,ed.user_photo,el.user_name,first_name,last_name,email,gender,address,phone,country,zipcode,gender,date_of_birth')
                ->from('employee_details as ed')
                ->join('employee_login as el', 'el.employee_id=ed.employee_id', 'left')
                ->where('ed.id', $id)
                ->get();
        $i = 0;
        $details = array();
        foreach ($result->result() as $row) {
            $details['id'] = $row->id;
            $details['user_name'] = $row->user_name;
            $details['first_name'] = $row->first_name;
            $details['last_name'] = $row->last_name;
            $details['email'] = $row->email;
            $details['address'] = $row->address;
            $details['phone'] = $row->phone;
            $details['gender'] = $row->gender;
            $details['status'] = $row->status;
            $details['country'] = $row->country;
            $details['zipcode'] = $row->zipcode;
            $details['user_photo'] = $row->user_photo;
            $details['date_of_birth'] = $row->date_of_birth;
            $orderdate = explode('-', $row->date_of_birth);
            $details['month'] = $orderdate[1];
            $details['day'] = $orderdate[2];
            $details['year'] = $orderdate[0];
            $i++;
        }
        return $details;
    }

    /**
     * 
     * Delete option
     * 0 inactive
     * 1 active
     * 3 delete
     * 
     */
    function deleteEmployee($delete_id) {
        $result = $this->db->set('status', 3)->where('employee_id', $delete_id)->update('employee_login');
        return $result;
    }

    /**
     * 
     * For activate user
     * @author Techffodils
     * @date 2017-10-23
     */
    function editEmployee($activate_id) {
        $result = $this->db->set('status', 1)->where('employee_id', $activate_id)->update('employee_login');
        return $result;
    }

    function updateEmployeeDetails($data) {
        $this->db->trans_start();

        if (!empty($data)) {
            $emp_data = array(
                'first_name' => $data['firstname'],
                'last_name' => $data['lastname'],
                'gender' => $data['gender'],
                'date_of_birth' => $data['year'] . '-' . $data['month'] . '-' . $data['day'],
                'email' => $data['email'],
                'user_photo' => $data['photo'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'zipcode' => $data['zipcode'],
            );
            $res = $this->db->where('employee_id', $data['id'])->update('employee_details', $emp_data);
            $this->helper_model->insertActivity($data['user_id'], 'Update Employee Details', serialize($data));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * 
     * 
     */
    function getAllActiveEmployeeList($query) {
        if ($query != '') {
            $res = $this->db->select("user_name")
                    ->from('employee_login')
                    ->like('user_name', trim($query))
                    ->where('status', 1)
                    ->get();
        } else {
            $res = $this->db->select("user_name")
                    ->from('employee_login')
                    ->where('status  ', 1)
                    ->get();
        }
        $json = [];
        foreach ($res->result_array() as $row) {
            $json[] = $row['user_name'];
        }
        return json_encode($json);
    }

    /**
     * For getting All Menus & Sub menus
     * 
     * @author leadMlmSoftware
     * 
     * @date 2017-10-26
     * 
     * 
     */
    function getAllEmployeeMenus() {
        $result = $this->db->select('id,name,link,order,lock,root_id')
                ->from('menus')
                ->where('root_id', '#')
                ->where('employee_permission', 1)
                ->where('status', 1)
                ->get();
        $empl_menu_arr = array();
        $i = 0;
        foreach ($result->result_array() as $row) {
            $sub_menu = ($row['link'] == '#') ? $this->getSubMenus($row['id']) : NULL;
            if ($row['link'] != '#' || $sub_menu) {
                $empl_menu_arr[$i]['id'] = $row['id'];
                $empl_menu_arr[$i]['name'] = $row['name'];
                $empl_menu_arr[$i]['link'] = $row['link'];
                $empl_menu_arr[$i]['root_id'] = $row['root_id'];
                $empl_menu_arr[$i]['sub_menu'] = $sub_menu;
            }
            $i++;
        }
        return $empl_menu_arr;
    }

    function getSubMenus($id) {
        $result = $this->db->select('id,name,link,order,lock,root_id')
                ->from('menus')
                ->where('root_id', $id)
                ->where('employee_permission', 1)
                ->where('status', 1)
                ->get();
        $empl_menu_arr = [];
        $i = 0;
        foreach ($result->result_array() as $row) {
            $empl_menu_arr[$i]['sub_id'] = $row['id'];
            $empl_menu_arr[$i]['name'] = $row['name'];
            $empl_menu_arr[$i]['link'] = $row['link'];
            $i++;
        }
        return $empl_menu_arr;
    }

    function getAllUserAllocatedMenus($user_name) {

        $result = $this->db->select('modules')->from('employee_login')->like('user_name', $user_name)->where('status', 1)->get();
        $arr = [];
        foreach ($result->result_array() as $row) {
            //print_r($row['modules']);die;
            if (!empty($row['modules'])) {
                $arr['menus'] = unserialize($row['modules']);
            }
        }
        return $arr;
    }

    function getEmployeeId($user_name) {
        $employee_id = '';
        $employee = $this->db->select('employee_id')->from('employee_login')->like('user_name', $user_name)->get();
        foreach ($employee->result() as $value) {
            $employee_id = $value->employee_id;
        }
        return $employee_id;
    }

    function upDateModulePermission($post_arr) {
        $user_id = $post_arr['emp_id'];
        $length = count($post_arr);

        $output = array_slice($post_arr, 1, -1);

        $array = array();

        foreach ($output as $value) {
            array_push($array, $value);
        }

        $serialize = serialize($array);

        $result = $this->db->set('modules', $serialize)->where('employee_id', $user_id)->update('employee_login');
        return $result;
    }

}
