<?php

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function themeChange($data,$user_id) {

      $res=$this->db->set('color_scheama',$data["skinClass"])
				      ->set('layout',$data["layoutBoxed"])
				      ->set('header',$data["headerDefault"])
				      ->set('footer',$data["footerDefault"])
				      ->where('user_id',$user_id)
				      ->update('theme_settings');
	 return $res;
    }

}

