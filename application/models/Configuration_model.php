<?php

class Configuration_model extends CI_Model {

    function checkField($status) {
        $numrows = $this->db->select('field_name')
                ->from("register_fields")
                ->where('status !=', "deleted")
                ->count_all_results();
        return $numrows;
    }
    
    function checkTable($field) {
        $res=0;
        $columns=$this->db->list_fields('user_details');
        foreach ($columns AS $key => $value) {
            if($value==$field){
                $res=1;
            }
        }
        return $res;
    }

    function createDbField($field_name, $data_types, $constraint) {
        $this->load->dbforge();
        if ($data_types == "text" || $data_types == "double") {
            $fields = array(
                $field_name => array('type' => $data_types)
            );
        } else {
            $fields = array(
                $field_name => array('type' => $data_types,
                    'constraint' => $constraint,
                    'null' => true
                )
            );
        }
        return $this->dbforge->add_column('user_details', $fields);
    }
    
    function addNewRegistrationField($data) {
        return $this->db->set('field_name', $data['field_name'])
                        ->set('required_status', $data['required_status'])
                        ->set('unique_status', $data['unique_status'])
                        ->set('register_step', $data['register_step'])
                        ->set('order', $data['order'])
                        ->set('default_value', $data['default_value'])
                        ->set('data_types', $data['data_types'])
                        ->set('data_type_max_size', $data['data_type_max_size'])
                        ->set('field_type', $data['field_type'])
                        ->set('radio_value1', $data['radio_value1'])
                        ->set('radio_value2', $data['radio_value2'])
                        ->set('select_option1', $data['select_option1'])
                        ->set('select_option2', $data['select_option2'])
                        ->set('select_option3', $data['select_option3'])
                        ->set('select_option4', $data['select_option4'])
                        ->set('status', "active")
                        ->insert('register_fields');
    }
}
