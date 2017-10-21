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
    
    function getAllLangauage(){
        $result=$this->db->select("id ,lang_code")
                ->from('languages')
                ->where('status',1)
                ->get();
       
        foreach($result->result_array() as $row){
            $data['lang_id']=$row['id'];
            $data['lang_code']=$row['lang_code'];
        }
        return $data;
    }
}
