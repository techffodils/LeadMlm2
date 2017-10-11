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


}

?>
