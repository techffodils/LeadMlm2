<?php

class Configuration_model extends CI_Model {

    function checkField($name) {
        return $this->db->select('field_name')
                        ->from("register_fields")
                        ->where('field_name', $name)
                        ->where('status !=', "deleted")
                        ->count_all_results();
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
                        ->set('date', date("Y-m-d H:i:s"))
                        ->insert('register_fields');
    }

    function getAllRegFields() {
        $data = array();
        $res = $this->db->select("id,status,field_name,editable_status,required_status,unique_status,register_step,order,default_value")
                ->from("register_fields")
                ->where("status !=", 'deleted')
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['field_name'] = $row->field_name;
            $data[$i]['required_status'] = $row->required_status;
            $data[$i]['unique_status'] = $row->unique_status;
            $data[$i]['register_step'] = $row->register_step;
            $data[$i]['order'] = $row->order;
            $data[$i]['default_value'] = $row->default_value;
            $data[$i]['editable_status'] = $row->editable_status;
            $data[$i]['status'] = $row->status;
            $i++;
        }
        return $data;
    }

    function checkFieldEligibility($id) {
        $numrows = $this->db->select('id')
                ->from("register_fields")
                ->where('status !=', "deleted")
                ->where('editable_status', 1)
                ->where('id', $id)
                ->count_all_results();
        return $numrows;
    }

    function changeFieldStatus($id, $status) {
        return $this->db->set('status ', "$status")
                        ->where('editable_status ', 1)
                         ->where('id ', $id)
                        ->update('register_fields');
    }

    function getRegFieldDetails($id) {
        $data = array();
        $res = $this->db->select("*")
                ->from("register_fields")
                ->where("status !=", 'deleted')
                ->where("id",$id)
                ->get();
        foreach ($res->result() as $row) {
            $data['id'] = $row->id;
            $data['field_name'] = $row->field_name;
            $data['required_status'] = $row->required_status;
            $data['unique_status'] = $row->unique_status;
            $data['register_step'] = $row->register_step;
            $data['order'] = $row->order;
            $data['default_value'] = $row->default_value;
            $data['editable_status'] = $row->editable_status;
            $data['data_types'] = $row->data_types;
            $data['data_type_max_size'] = $row->data_type_max_size;
            $data['field_type'] = $row->field_type;
            $data['radio_value1'] = $row->radio_value1;
            $data['radio_value2'] = $row->radio_value2;
            $data['select_option1'] = $row->select_option1;
            $data['select_option2'] = $row->select_option2;
            $data['select_option3'] = $row->select_option3;
            $data['select_option4'] = $row->select_option4;
            $data['status'] = $row->status;
        }
        return $data;
    }

    function checkUpdatingField($name, $edit_id) {
        return $this->db->select('field_name')
                        ->from("register_fields")
                        ->where('field_name', $name)
                        ->where('status !=', "deleted")
                        ->where('id !=', $edit_id)
                        ->count_all_results();
    }

    public function getFieldOldName($id) {
        $field_name = '';
        $query = $this->db->select('field_name')
                ->from('register_fields')
                ->where('id', $id)
                ->get();
        foreach ($query->result() as $row) {
            $field_name = $row->field_name;
        }
        return $field_name;
    }

    function alterDbField($field_name, $data_types, $constraint, $old_name) {
        $this->load->dbforge();

        if ($data_types == "text" || $data_types == "double") {
            $fields = array(
                $old_name => array(
                    'name' => $field_name,
                    'type' => $data_types,
                ),
            );
        } else {
            $fields = array(
                $old_name => array(
                    'name' => $field_name,
                    'type' => $data_types,
                    'constraint' => $constraint,
                    'null' => true
                ),
            );
        }
        return $this->dbforge->modify_column('user_details', $fields);
    }
    
    function updateRegistrationField($data) {
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
                        ->where('id', $data['edited_field'])
                        ->update('register_fields'); 
    }
    
    function getAllPaymentMethods() {
        $data = array();
        $res = $this->db->select("id,code,payment_method,status")
                ->from("payment_methods")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['payment_method'] = $row->payment_method;
            $data[$i]['code'] = $row->code;
            $data[$i]['status'] = $row->status;
            $i++;
        }
        return $data;
    }
    
    function changePaymentStatus($code, $status) {
        return $this->db->set('status ', "$status")
                        ->where('code ', $code)
                        ->update('payment_methods');
    }

    function getCurrencies() {
        $data = array();
        $res = $this->db->select("id,currency_code,currency_name,status,symbol_left,symbol_right")
                ->from("currencies")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['code'] = $row->currency_code;
            $data[$i]['name'] = $row->currency_name;
            $data[$i]['status'] = $row->status;
            $data[$i]['symbol_left'] = $row->symbol_left;
            $data[$i]['symbol_right'] = $row->symbol_right;
            $i++;
        }
        return $data;
    }
    
    function changeCurrencyStatus($id, $status) {
        return $this->db->set('status ', "$status")
                         ->where('id ', $id)
                        ->update('currencies');
    }

    function getLanguages() {
        
        $data = array();
        $res = $this->db->select("id,lang_code,lang_name,status")
                ->from("languages")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['code'] = $row->lang_code;
            $data[$i]['name'] = $row->lang_name;
            $data[$i]['status'] = $row->status;
            $i++;
        }
        return $data;
    }
    
    function changeLanguageStatus($id, $status) {
        return $this->db->set('status ', "$status")
                         ->where('id ', $id)
                        ->update('languages');
    }
    
}
