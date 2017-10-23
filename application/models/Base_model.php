<?php

class Base_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}


	public function getSideMenus($user_type ,$currenturl) {

		$side_menu = array();
		$url_id = $this->getUrlId($currenturl);

		if($user_type == 'employee'){

			//employee permission check

		}else{
			$side_menu = $this->getMenuArray($user_type,$url_id);
		}

		return  $side_menu;
	}

	public  function getMenuArray($user_type,$url_id) {

		$menu_array = array();
		$i=0;
		$res = $this->db->select("id, name, link, icon, order, lock, target")
		->where("status",1)
		->where("root_id",'#')
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("menus");

		foreach ($res->result_array() as $row) {
			
			$sub_menu =($row['link'] == '#')?$this->getSubMenu($row['id'],$user_type,$url_id):null;  

			if( $row['link'] != '#' ||   $sub_menu ){
				$menu_array[$i]['id']  =  $row['id']; 
				$menu_array[$i]['name']  =  $row['name']; 
				$menu_array[$i]['link']  =  ($row['link'] != '#')? $user_type.'/'.$row['link']  :'javascript:void(0)';
				$menu_array[$i]['icon']  =  $row['icon'];   
				$menu_array[$i]['sub_menu']  =  $sub_menu;   
				$menu_array[$i]['target']  =  $row['target'];
				$menu_array[$i]['selected']  = (in_array($row['id'], $url_id))? 'selected':null;   
				$menu_array[$i]['lock']  =  $row['lock'];   
				
				$i++;
			}
		}
		return $menu_array;
	}

	public function getSubMenu($menu_id,$user_type,$url_id){

		
		$menu_array = null;
		$i=0;
		$res = $this->db->select("id, name, link, icon, order, lock, target")
		->where("status",1)
		->where("root_id",$menu_id)
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("menus");


		foreach ($res->result_array() as $row) {
			
			$sub_menu =($row['link'] == '#')?$this->getSubSubMenu($row['id'],$user_type,$url_id):null;  
			
			if( $row['link'] != '#' ||   $sub_menu ){
				$menu_array[$i]['name']  =  $row['name']; 
				$menu_array[$i]['id']  =  $row['id']; 
				$menu_array[$i]['link']  = ($row['link'] != '#')? $user_type.'/'.$row['link']  :'javascript:void(0)';
				$menu_array[$i]['icon']  =  $row['icon'];   
				$menu_array[$i]['sub_menu']  =  $sub_menu;   
				$menu_array[$i]['target']  =  $row['target'];  
				$menu_array[$i]['selected']  = (in_array($row['id'], $url_id))? 'selected':null; 
				$menu_array[$i]['lock']  =  $row['lock'];   
				
				$i++;
			}
		}
		return $menu_array;

	}

	public function getSubSubMenu($menu_id,$user_type,$url_id){
		$menu_array = array();
		$i=0;
		$res = $this->db->select("id, name, link, icon, order, lock, target")
		->where("status",1)
		->where("root_id",$menu_id)
		->where($user_type.'_permission',1)
		->order_by("order")
		->get("menus");

		foreach ($res->result_array() as $row) {

			$menu_array[$i]['id']  =  $row['id'];
			$menu_array[$i]['name']  =  $row['name']; 
			$menu_array[$i]['link']  = $user_type.'/'. $row['link'];
			$menu_array[$i]['icon']  =  $row['icon'];   
			$menu_array[$i]['target']  =  $row['target'];  
			$menu_array[$i]['selected']  = (in_array($row['id'], $url_id))? 'selected':null; 
			$menu_array[$i]['lock']  =  $row['lock'];   
			$i++;
		}
		
		return $menu_array;

	}


	public function loadPageScript($currenturl){

		$script_array = array();
		$query = $this->db->select("id")
		//->where("link",$currenturl)
		->like('link',$currenturl,'before')
		->limit(1)
		->get('menus');
		
		if($query->num_rows() >0 ){

			$script_array = $this->script_model->loadScript($query->row()->id);
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


	public function getLanguageDetailsFromCode($lang_code){
		$data = array();
		$query = $this->db->select("id,lang_name,lang_eng_name,lang_flag,lang_code")
		->where("lang_code",$lang_code)
		->get("languages");
		foreach ($query->result_array() as $row) {
			$data = $row;
		}
		return $data;
	}


	public function getThemeDetails($user_id){

		$theme = array(
			'color_scheama' =>'theme_default',
			'body_class' =>'header-fixed footer-default',
			'header' =>'header-fixed',
			'footer' =>'footer-default',
			'layout' =>''
		);

		$query = $this->db->select("color_scheama,layout,header,footer")
		->where("user_id",$user_id)
		->limit(1)
		->get("theme_settings");

		if($query->num_rows() > 0 ){			
			foreach ($query->result_array() as $row) {
				$theme['color_scheama']  =  $row['color_scheama'];
				$theme['header']  =  $row['header'];
				$theme['footer']  =  $row['footer'];
				$theme['layout']  =  $row['layout'];
				$theme['body_class']  =  $row['header'].' '.$row['footer'].' '.$row['layout'];
			}
		}
		return $theme;
	}

	function getBreadCrumbs(){

			$bread_crumb = array(
								'page_title'=>'',
								'page_sub_title'=>'',
								'page_header'=>'',
								'page_header_link'=>'',
							  );

			$path = $this->CURRENT_CLASS;
			if($this->CURRENT_METHOD != 'index' ){
				$path = $this->CURRENT_CLASS.'/'.$this->CURRENT_METHOD;
			}

			$res = $this->db->select('id,name,link')
				->limit(1)
				->like('link', $path, 'before')
				->get('menus');
			if($res->num_rows() > 0){
				$bread_crumb['page_title'] = $res->row()->id;
				$bread_crumb['page_header'] = ($res->row()->id == 1)?'':$res->row()->id;
				$bread_crumb['page_header_link'] = $res->row()->link;
			}		
			
		return $bread_crumb;
	}


/**
For getting the sub title

@Author :LeadMlm
@Date :2017-10-17
@Name: LeadMlm

*/


function getUrlId($currenturl)
{
	$url_ids = array();
	$variable = $this->db->select('id,root_id')
	->where('link',$currenturl)
	->from('menus')
	->limit('1')
	->get();

	if($variable->num_rows() > 0) {

		if($variable->row()->root_id != '#'){
			$url_ids = $this->getRootMenus($variable->row()->root_id,$url_ids);	
		}
		array_push($url_ids, $variable->row()->root_id);	
		array_push($url_ids, $variable->row()->id);
	}
	return $url_ids;
}

function getRootMenus($root_id,$url_ids)
{
	$variable = $this->db->select('root_id')
	->where('id',$root_id)
	->from('menus')
	->limit('1')
	->get();

	if($variable->num_rows() > 0) {
		array_push($url_ids, $variable->row()->root_id);
	}
	return $url_ids;
}


/*function getSubTitle($root_id)
{
	$name='';
	$variable=$this->db->select('name')->from('menus')->where('root_id',$root_id)->get();
	foreach ($variable->result() as $value) {
		$name=$value->name;
	}
	return $name;

}*/


function getSiteInfo()
{
	$data = array();
	$query = $this->db->select('*')
					  ->get('site_info');
		
	foreach ($query->result_array() as $row) {
		$data =  $row;
	}
	return $data;
}

function checkMenuPermitted($user_type,$currenturl)
{

	$status = true;
	$res = $this->db->select('status')
					->where('link',$currenturl)
					->where($user_type.'_permission',1)
					->get('menus');

	if($res->num_rows() > 0){
		 $status = $res->row()->status;
	}

	return $status;
}


function checkMenuLocked($user_type,$currenturl)
{

	$lock = false;
	$res = $this->db->select('lock')
					->where('link',$currenturl)
					->where($user_type.'_permission',1)
					->get('menus');

	if($res->num_rows() > 0){
		 $lock = $res->row()->lock;
	}

	return $lock;
}



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

?>
