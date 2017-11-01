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
                        ->set('field_name_en', $data['field_name_en'])
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
                ->where("id", $id)
                ->get();
        foreach ($res->result() as $row) {
            $data['id'] = $row->id;
            $data['field_name'] = $row->field_name;
            $data['field_name_en'] = $row->field_name_en;
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
                        ->set('field_name_en', $data['field_name_en'])
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
        $res = $this->db->select("id,currency_code,currency_name,status,icon,currency_ratio")
                ->from("currencies")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['code'] = $row->currency_code;
            $data[$i]['name'] = $row->currency_name;
            $data[$i]['status'] = $row->status;
            $data[$i]['icon'] = $row->icon;
            $data[$i]['currency_ratio'] = (float) $row->currency_ratio;
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

    public function getCurrencySymbol($code) {
        $icon = '';
        $query = $this->db->select('icon')
                ->from('currencies')
                ->where('currency_code', $code)
                ->get();
        foreach ($query->result() as $row) {
            $icon = $row->icon;
        }
        return $icon;
    }

    function addNewLanguageField($user_id, $field_name, $in_english) {
        return $this->db->set('mlm_user_id', $user_id)
                        ->set('field_name', $field_name)
                        ->set('in_english', $in_english)
                        ->set('date', date("Y-m-d H:i:s"))
                        ->insert('language_conversion');
    }

    /**
     * 
     * 
     * For insert images upload
     * @author Techffodils
     * @date 2017-10-27
     * 
     */
    function insertKycDetails($data_arr) {
        $this->db->trans_start();

        $data_arr = array(
            'bank_name' => $data_arr['bank_name'],
            'bank_branch' => $data_arr['bank_branch'],
            'bank_account_number' => $data_arr['bank_account_no'],
            'bank_proof' => $data_arr['bank_proof'],
            'bank_ifsc_code' => $data_arr['bank_ifc_code'],
            'id_name' => $data_arr['id_name'],
            'id_number' => $data_arr['id_number'],
            'id_proof' => $data_arr['id_proof'],
            'user_id' => $data_arr['user_id'],
        );
        $result = $this->db->insert('kyc_details', $data_arr);

        if ($result) {
            $this->helper_model->insertActivity($data_arr['user_id'], 'Upload Kyc Details', serialize($data_arr));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * For Getting All Kyc Request Details
     * 
     * @author techffodils
     * 
     * @date 2017-10-27
     * 
     * 
     */
    function getAllKycDetails() {
        $query = $this->db->select("kyc_details.user_id,user.user_name,user.email,user.date")
                        ->from('kyc_details')
                        ->where("(id_proof_status ='pending' OR bank_proof_status ='pending')")
                        ->join('user', 'kyc_details.user_id=user.mlm_user_id')->get();
        $i = 0;
        $data = [];
        foreach ($query->result_array() as $row) {
            $data[$i]['user_name'] = $row['user_name'];
            $data[$i]['user_id'] = $row['user_id'];
            $data[$i]['email'] = $row['email'];
            $data[$i]['date'] = $row['date'];
            $i++;
        }
        return $data;
    }

    function gettingUserKycDetails($user_id) {
        $query = $this->db->select('*')
                ->from('kyc_details')
                ->where('user_id', $user_id)
                ->get();
        $data = $bank_status = $id_proof_status = '';
        foreach ($query->result_array() as $row) {
            $bank_status = $row['bank_proof_status'];
            $id_proof_status = $row['id_proof_status'];
            $data .= '<div class="row">';
            $data .= '<input type="hidden" name="user_id" id="user_id" value="' . $row['user_id'] . '">';
            $data .= '<div class="col-md-6">';
            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('bank_name') . '</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="bank_name" id="bank_name" value="' . $row['bank_name'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('bank_branch') . ':</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="bank_branch" id="bank_branch" value="' . $row['bank_branch'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('bank_account_number') . ':</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="bank_account_number" id="bank_account_number" value="' . $row['bank_account_number'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('bank_ifsc_code') . ':</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="bank_ifsc_code" id="bank_ifsc_code" value="' . $row['bank_ifsc_code'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('bank_proof') . ':</label>';
            $data .= '<div class="input-group">';
            $data .= '<img width="150" height="150" src="' . BASE_PATH . 'assets/images/bank_details/' . $row['bank_proof'] . '"/>';

            $data .= '</div>';
            $data .= '</div>';
            $data .= '<div class="form-group">';
            $data .= '<div class="input-group">';
            if ($bank_status == 'accept') {
                $data .= '<input type="hidden" name="bank_proof_status"   id="bank_accept" value="accept" onclick="setIdProofAccept(' . $row['user_id'] . ', 1)" > <span style="color:green" class="fa fa-check">  ' . lang('accepted') . '</span>&nbsp;&nbsp;';
                $data .= '<input type="radio" name="bank_proof_status"  id="bank_reject" value="reject" onclick="setIdProofReject(' . $row['user_id'] . ', 1)"  > ' . lang('reject') . '';
            } elseif ($bank_status == 'reject') {
                $data .= '<input type="radio" name="bank_proof_status"   id="bank_accept" value="accept" onclick="setIdProofAccept(' . $row['user_id'] . ', 1)" > ' . lang('accept') . '</span>&nbsp;&nbsp;';
                $data .= '<input type="hidden" name="bank_proof_status"  id="bank_reject" value="reject" onclick="setIdProofReject(' . $row['user_id'] . ', 1)"  > <span style="color:red" class="fa fa-trash">  ' . lang('rejected') . '</span>';
            } else {
                $data .= '<input type="radio" name="bank_proof_status"   id="bank_accept" value="accept" onclick="setIdProofAccept(' . $row['user_id'] . ', 1)" > ' . lang('accept') . '&nbsp;&nbsp';
                $data .= '<input type="radio" name="bank_proof_status"  id="bank_reject" value="reject" onclick="setIdProofReject(' . $row['user_id'] . ', 1)"  > ' . lang('reject') . '';
            }

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group" id="bank_reject_div" style="display:none;
            ">';
            $data .= '<div class="input-group">';

            $data .= '<textarea type="text" rows="4" cols="50" name="bank_reason" id="bank_reason"></textarea>';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '</div>';

            $data .= '<div class="col-md-6">';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('id_name') . '</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="id_name" id="id_name" value="' . $row['id_name'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class="form-group">';
            $data .= '<label class="control-label">' . lang('id_number') . '</label>';
            $data .= '<div class="input-group">';
            $data .= '<input type="text" name="id_name" id="id_name" value="' . $row['id_number'] . '">';

            $data .= '</div>';
            $data .= '</div>';
            $data .= '<div class="form-group">';
            $data .= '<label class="control-label>' . lang('id_proof') . '</label>';
            $data .= '<div class = "input-group">';
            $data .= '<img width = "150" height = "150" src = "' . BASE_PATH . 'assets/images/id_proof/' . $row['id_proof'] . '">';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class = "form-group">';
            $data .= '<div class = "input-group">';
            if ($id_proof_status == 'accept') {
                $data .= '<input type = "hidden" name = "id_proof_status"  id = "id_accept" value = "accept" onclick = "setIdProofAccept(' . $row['user_id'] . ',2)" ><span style="color:green" class="fa fa-check"> ' . lang('accepted') . '</span>&nbsp;&nbsp;';
                $data .= '<input type = "radio"  name = "id_proof_status"  id = "id_reject" value = "reject" onclick = "setIdProofReject(' . $row['user_id'] . ',2)" > ' . lang('reject') . '';
            } else if ($id_proof_status == 'reject') {
                $data .= '<input type = "radio" name = "id_proof_status"  id = "id_accept" value = "accept" onclick = "setIdProofAccept(' . $row['user_id'] . ',2)" > ' . lang('accept') . '</span>&nbsp;&nbsp;';
                $data .= '<input type = "hidden"  name = "id_proof_status"  id = "id_reject" value = "reject" onclick = "setIdProofReject(' . $row['user_id'] . ',2)" ><span style="color:red" class="fa fa-trash">  ' . lang('rejected') . '</span>';
            } else {
                $data .= '<input type = "radio"  name = "id_proof_status"  id = "id_accept" value = "accept" onclick = "setIdProofAccept(' . $row['user_id'] . ',2)" >' . lang('accept') . '</span>&nbsp;&nbsp;';
                $data .= '<input type = "radio" name = "id_proof_status"  id = "id_reject" value = "reject" onclick = "setIdProofReject(' . $row['user_id'] . ',2)" > ' . lang('reject') . '';
            }
            $data .= '</div>';
            $data .= '</div>';

            $data .= '<div class = "form-group" id = "id_reject_div" style = "display:none;">';
            $data .= '<div class = "input-group">';

            $data .= '<textarea type = "text" rows = "4" cols = "50" name = "id_reason" id = "id_reason" ></textarea>';

            $data .= '</div>';
            $data .= '</div>';

            $data .= '</div>';
        }
        return $data;
    }

    function isUserExits($user_id) {
        $flag = false;
        $result = $this->db->select("count(*) ")
                ->from("kyc_details")
                ->where('user_id', $user_id)
                ->count_all_results();
        if ($result > 0) {
            $flag = true;
        }
        return $flag;
    }

    function updateKycStatus($userid, $status, $type) {
        $result = $this->db->set($type . '_proof_status', $status)->where('user_id', $userid)->update('kyc_details');
        return $result;
    }

    function updateRejectKycDetails($userid, $status, $type, $data) {
        $result = $this->db->set($type . '_proof_status', $status)->set($type . '_proof_cancel_reason',$data)->where('user_id', $userid)->update('kyc_details');

        return $result;
    }

}
