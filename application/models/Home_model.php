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

	/*public function currencyDetailsFromCode($currency_code){

		$res=$this->db->set('color_scheama',$data["skinClass"])
					->set('layout',$data["layoutBoxed"])
					->set('header',$data["headerDefault"])
					->set('footer',$data["footerDefault"])
					->where('user_id',$user_id)
					->update('theme_settings');
		return $res;
	}*/


	public function currencyDetailsFromCode($currency_code){

		$data = array();
		$query = $this->db->select("id,currency_code,currency_name,symbol_left,symbol_right,currency_ratio,icon")
		->where("currency_code",$currency_code)
		->limit(1)
		->get("currencies");

		if($query->num_rows() >0 ){
			foreach ($query->result_array() as $row) {
				$data = $row;
			}
		}

		return $data;

	}

	public function changeUserCurrency($user_id,$currency_id){

		$res = $this->db->set("currency",$currency_id)
		->where("mlm_user_id",$user_id)
		->limit(1)
		->update("user");
		return $res;
	}



	public function langDetailsFromCode($lang_code){

		$data = array();
		$query = $this->db->select("id,lang_code,lang_name,lang_eng_name,lang_flag")
		->where("lang_code",$lang_code)
		->limit(1)
		->get("languages");

		if($query->num_rows() >0 ){
			foreach ($query->result_array() as $row) {
				$data = $row;
			}
		}

		return $data;

	}

	public function changeUserLanguage($user_id,$lang_id){

		$res = $this->db->set("language",$lang_id)
		->where("mlm_user_id",$user_id)
		->limit(1)
		->update("user");
		return $res;
	}
}

