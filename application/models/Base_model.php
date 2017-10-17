<?php

class Base_model extends CI_Model {

      public $BREAD_CRUMBS;
	public function __construct() {
		parent::__construct();
		$this->BREAD_CRUMBS=array();
		$this->main->load_model();
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
	
	/**
	For setting up the breadcrumbs
	@Author:LeadMlm
	@Date:2017-10-14
	@Day Saturday
	*/
	function getBreadCrubms(){
		$user_type="admin";
		$menu=$this->db->select("id, name,link, icon, order, lock,target,root_id")
		->where("status",1)
		->where("root_id",'#')
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("menus");

        $pages=array();$i=$current_path=0;
		foreach($menu->result_array() as $row){

		    //$sub_menu =($row['link'] == '#')?$this->getSubMenu($row['id'],$user_type):null;  
	        //spit the row link and then First one  controller and second one method so changed to page title
	        if($this->main->get_method()!='index'){
	        	$current_path=$this->main->get_controller().'/'.$this->main->get_method();
	        }else{
	        	$current_path=$this->main->get_controller();
	        }

	        if($current_path==$row['link']){

		       if($row['root_id'] == '#'){
		    	   $this->BREAD_CRUMBS['page_title']=$row['name'];
		          }

           	  $this->BREAD_CRUMBS['page_sub_title']=strtolower($row['name']);
           	  $this->BREAD_CRUMBS['page_header']=$row['name'];
           	  $this->BREAD_CRUMBS['page_sub_header']=$this->getSubTitle($row['id']);
             }
           	 $i++;

           }
           return $this->BREAD_CRUMBS;
		}


/**
For getting the sub title

@Author :LeadMlm
@Date :2017-10-17
@Name: LeadMlm

*/
     function getSubTitle($root_id)
      {
	     $name='';
	     $variable=$this->db->select('name')->from('menus')->where('root_id',$root_id)->get();
	     foreach ($variable->result() as $value) {
		        $name=$value->name;
	        }
	    return $name;

     }
}

?>
