<?php

class Translator_model extends CI_Model {
    function getUntraslatedData() {
        $data = array();
        $res = $this->db->select("id,field_name,in_english")
                ->from("language_conversion")
                ->where('conv_stat','0')
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['field_name'] = $row->field_name;
            $data[$i]['in_english'] = $row->in_english;
            $i++;
        }
        return $data;
    }
    
    function getAllLanguages() {
        $data = array();
        $res = $this->db->select("lang_code,lang_name,language_folder")
                ->from("languages")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['lang_code'] = $row->lang_code;
            $data[$i]['lang_name'] = $row->lang_name;
            $data[$i]['language_folder'] = $row->language_folder;
            $i++;
        }
        return $data;
    }
    
    function updateConversionStatus($id){
        return $this->db->set('conv_stat ', "1")
                         ->where('id ', $id)
                        ->update('language_conversion');
    }
    
}
