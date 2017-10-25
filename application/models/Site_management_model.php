<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Site_management_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @author leadmlmsoftware.com
     * @date 2017-10-18
     * for Site Management Model
     */
    function get_site_info() {
        $result = $this->db->select("*")
                ->from('site_info')
                ->get();
        foreach ($result->result_array() as $row) {
            $site_data['company_name'] = $row['company_name'];
            $site_data['company_address'] = $row['company_address'];
            $site_data['company_logo'] = $row['company_logo'];
            $site_data['company_fav_icon'] = $row['company_fav_icon'];
            $site_data['company_email'] = $row['company_email'];
            $site_data['company_phone'] = $row['company_phone'];
        }
        return $site_data;
    }

    /**
     * For update site information
     * @date 2017-10-18
     * @author LeadMlmsoftware.com
     */
    function updateSiteInformation($company_name, $company_address, $company_email, $company_phone, $logo, $fav_icon) {
        $data_array = array('company_name' => $company_name, 'company_address' => $company_address, 'company_email' => $company_email, 'company_phone' => $company_phone, 'company_logo' => $logo, 'company_fav_icon' => $fav_icon);
        $result = $this->db->where('id', 1)->update('site_info', $data_array);
        return $result;
    }

    /**
     * For Lanaguage Content settings
     * @author Techffodils
     * @date 2017-10-18
     * 
     */
    function getAllLangauage() {
        $result = $this->db->select("languages.id ,lang_code,lang_name,subject,content")
                ->join('mail_content ', 'mail_content.lang_id=languages.id', 'left')
                ->from('languages')
                ->where('languages.status', 1)
                ->get();
        $i = 0;
        $data = array();
        foreach ($result->result_array() as $row) {
            $data[$i]['lang_id'] = $row['id'];
            $data[$i]['lang_code'] = $row['lang_code'];
            $data[$i]['lang_name'] = $row['lang_name'];
            $data[$i]['subject'] = $row['subject'];
            $data[$i]['content'] = $row['content'];
            $i++;
        }
        return $data;
    }

    function insertMailContent($content, $subject, $lang_id) {
        if ($this->checkContentBasedOnIdAlreadyExits($lang_id)) {
            //echo 111;die;
            $result = $this->db->set('content', $content)->set('subject', $subject)->set('lang_id', $lang_id)->set('content_type', 'registration')->set('status', 1)->insert('mail_content');
            return $result;
        } else {

            $data = array('content' => $content, 'subject' => $subject);
            $result = $this->db->where('lang_id', $lang_id)->update('mail_content', $data);
            return $result;
        }
    }

    function checkContentBasedOnIdAlreadyExits($lang_id) {

        $exists = $this->db->select("count(*)")->from('mail_content')->where('lang_id', $lang_id)->count_all_results();
        //echo $exists;die;
        if ($exists > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function getAllMailContentDetails() {

        $result = $this->db->select('subject,content,lang_id')->from('mail_content')->where('status', 1)->get();

        $i = 0;
        $data = array();
        foreach ($result->result() as $row) {
            $index = $this->getLangcode($row->lang_id);
            $data[$index]['subject'] = $row->subject;
            $data[$index]['content'] = $row->content;
            $data[$index]['lang_id'] = $row->lang_id;

            $i++;
        }
        return $data;
    }

    function getLangcode($id) {
        $result = $this->db->select("lang_code")->from('languages')->where('id', $id)->get();
        foreach ($result->result() as $row) {
            $lang_code = $row->lang_code;
        }
        return $lang_code;
    }

}
