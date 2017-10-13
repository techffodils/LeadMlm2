<?php

class Base_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}


	public function getSideMenus($user_type) {

		$side_menu = array();

		if($user_type == 'employee'){
			//employee permission check
		}else{
			$side_menu = $this->getMenuArray($user_type);
		}

		return  $side_menu;
	}

	public  function getMenuArray($user_type) {

		$menu_array = array();
		$i=0;
		$res = $this->db->select("id, name,link, icon, order, lock,target")
		->where("status",1)
		->where("root_id",'#')
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("mlm_menus");

		foreach ($res->result_array() as $row) {
			
			$sub_menu =($row['link'] == '#')?$this->getSubMenu($row['id'],$user_type):null;  

			if( $row['link'] != '#' ||   $sub_menu ){
				$menu_array[$i]['name']  =  $row['name']; 
				$menu_array[$i]['link']  =  ($row['link'] != '#')? $user_type.'/'.$row['link']  :'javascript:void(0)';
				$menu_array[$i]['icon']  =  $row['icon'];   

				$menu_array[$i]['sub_menu']  =  $sub_menu;   
				$menu_array[$i]['target']  =  $row['target'];
				$menu_array[$i]['lock']  =  $row['lock'];   
				

				$i++;
			}
		}
		return $menu_array;
	}

	public function getSubMenu($menu_id,$user_type){

		
		$menu_array = null;
		$i=0;
		$res = $this->db->select("id, name, link, icon, order, lock, target")
		->where("status",1)
		->where("root_id",$menu_id)
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("mlm_menus");




		foreach ($res->result_array() as $row) {
			
			$sub_menu =($row['link'] == '#')?$this->getSubSubMenu($row['id'],$user_type):null;  
			
			if( $row['link'] != '#' ||   $sub_menu ){
				$menu_array[$i]['name']  =  $row['name']; 
				$menu_array[$i]['link']  = ($row['link'] != '#')? $user_type.'/'.$row['link']  :'javascript:void(0)';
				$menu_array[$i]['icon']  =  $row['icon'];   
				$menu_array[$i]['sub_menu']  =  $sub_menu;   
				$menu_array[$i]['target']  =  $row['target'];  
				$menu_array[$i]['lock']  =  $row['lock'];   
				
				$i++;
			}
		}
		return $menu_array;

	}

	public function getSubSubMenu($menu_id,$user_type){
		$menu_array = array();
		$i=0;
		$res = $this->db->select("id, name, link, icon, order, lock, target")
		->where("status",1)
		->where("root_id",$menu_id)
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("mlm_menus");

		foreach ($res->result_array() as $row) {

			$menu_array[$i]['name']  =  $row['name']; 
			$menu_array[$i]['link']  = $user_type.'/'. $row['link'];
			$menu_array[$i]['icon']  =  $row['icon'];   
			$menu_array[$i]['target']  =  $row['target'];  
			$menu_array[$i]['lock']  =  $row['lock'];   
			$i++;
		}
		
		return $menu_array;

	}


	public function loadPageScript($currenturl){

		$script_array = array();
		$query = $this->db->select("id")
						->where("link",$currenturl)
						->limit(1)
						->get("mlm_menus");
						

		if($query->num_rows() >0 ){
			//$script_array = $this->base_model->loadScript($query->row()->id);
		}

		return $script_array;

	}


    public function getAdminUserId(){

		$query = $this->db->select("id")
						->where("user_type",'admin')
						->limit(1)
						->get("user");
	
		return $query->row()->id;

	}

 	public function getCurrencyDetails($user_id){
 		$data = array();
		$query = $this->db->select("cu.currency_ratio,cu.currency_name,cu.currency_code,cu.symbol_left,cu.symbol_right,cu.icon")
						->from("user as us")
						->join("currencies as cu",'cu.id = us.currency','inner')
						->where("us.mlm_user_id",$user_id)
						->limit(1)
						->get();

		//echo $query->db->last_query();die();
		foreach ($query->result_array() as $row) {
			$data = $row;
		}
		return $data;
	}


    public function getLanguageDetails($user_id){
 		$data = array();
		$query = $this->db->select("la.lang_name,la.lang_eng_name,la.lang_code,la.lang_flag")
						->from("user as us")
						->join("languages as la",'la.id = us.language','inner')
						->where("us.mlm_user_id",$user_id)
						->limit(1)
						->get();

		foreach ($query->result_array() as $row) {
			$data = $row;
		}
		return $data;
	}

   public function getAllCurrency(){
 		$data = array();
		$query = $this->db->select("id,currency_name,currency_code,symbol_left,symbol_right,currency_ratio,icon")
						->where("status",1)
						->get("currencies");
		foreach ($query->result_array() as $row) {
			$data[] = $row;
		}
		return $data;
	}

    public function getAllLanguages(){
 		$data = array();
		$query = $this->db->select("id,lang_name,lang_eng_name,lang_code,lang_flag")
						->where("status",1)
						->get("languages");
		foreach ($query->result_array() as $row) {
			$data[] = $row;
		}
		return $data;
	}

	public function getTheamDetails($user_id){

		$theam = array(
						'color_scheama' =>'theme_default',
						'body_class' =>'header-fixed footer-default'
					);

		
		$query = $this->db->select("color_scheama,layout,header,footer")
						->where("id",$user_id)
						->limit(1)
						->get("theam_settings");
		if($query->num_rows() > 0 ){			
			foreach ($query->result_array() as $row) {
				$theam['color_scheama']  =  $row['color_scheama'];
				$theam['body_class']  =  $row['header'].' '.$row['footer'].' '.$row['layout'];
			}
		}
		return $theam;
	}
}

?>
