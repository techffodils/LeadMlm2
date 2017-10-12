<?php

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function login($username, $password) {
        $email = $username;
        if ($username != '' && $password != '') {
            $query = $this->db->select('mlm_user_id,user_name,user_type,mlm_user_id,email')
                            ->where("(user_name ='$username' OR email ='$username')")
                            ->where('password', $password)
                            ->from('user')
                            ->limit(1)->get();
        } else {
            return false;
        }
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function setUserLoginSession($login_result) {
        $array = array();
        foreach ($login_result as $row) {
            $array = array(
                'mlm_username' => $row->user_name,
                'mlm_user_type' => $row->user_type,
                'mlm_user_id' => $row->mlm_user_id,
                'mlm_email' => $row->email,
                'is_logged_in' => true
            );
        }
        $this->session->set_userdata('mlm_logged_arr', $array);
    }

    /* 
	  For Checking Email Exits or Not
	  @Author Techffodils
	  @Date 2017-10-09
	*/
	function checkEmailExitsOrNot($email){
		
		$result=$this->db->select("COUNT(*) as cnt")->from('mlm_user')->where('email',$email)->count_all_results();
		return $result;
	}
	
	
	/* 
	  For Checking Email Exits or Not
	  @Author Techffodils
	  @Date 2017-10-09
	*/
	
	
	function sendPasswordResetLink($email,$user_id,$subject){
		 
		 $encode_id=$this->helper_model->encode($user_id);
		 
		 $from_email = "jipinu007@gamil.com"; 
         $to_email = $email; 
		
         $this->email->from($from_email, 'Your Name'); 
         $this->email->to($to_email);
         $this->email->subject($subject); 
		 $mail_bodydetails="Please click the below link for Password Reseting";
		 $mail_bodydetails.='<a href="'.BASE_PATH.'login/reset_password/'.$encode_id.'">Click to </a>';
		 echo $mail_bodydetails;die;
         $this->email->message($mail_bodydetails); 
   
         //Send mail 
         if($this->email->send()){	 
             return true;
		 } 
         else{
			 return false;
		 } 
          
         
	}

	function getMlmEmailToUserId($email){
		$user_id='';
		if($email!=''){
			$query=$this->db->select('mlm_user_id')
							->from('user')
							->where('email',$email)
							->get();
							$result=$query->row();
			$user_id=$result->mlm_user_id;
		}
		return $user_id;
	}
	
	function resetPassword($password,$user_id){
		$result=$this->db->set('password',$password)->where('mlm_user_id',$user_id)->update('user');
		//send email to be done
		return $result;
	}

}

?>
