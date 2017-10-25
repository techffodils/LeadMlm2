<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Member extends Base_Controller {

    function account_settings() {
        $tab1 = 'active';
        $tab2 = $tab3 = $tab4 = '';
        $title = "Account Setting";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', 'Account Setting');
        $this->setData('tab1', $tab1);
        $this->setData('tab2', $tab2);
        $this->setData('tab3', $tab3);
        $this->setData('tab4', $tab4);
        $this->loadView();
    }

    function get_usernames() {
        $query = $this->input->post('query');
        $result = $this->member_model->getAllUserNames($query);
        echo $result;
        exit();
    }

    function update_password() {
        $post = $this->input->get();
        $user_name = $post['username'];
        $pass_password = $post['pass_password'];
        $pass_re_enter_password = $post['pass_re_enter_password'];
        $user_id = $this->helper_model->userNameToID($user_name);
        if ($user_id) {
            
            if ($pass_password == $pass_re_enter_password && $pass_password !='' && $pass_re_enter_password !='') {
                $res = $this->member_model->updatePassword($user_id, $pass_password);
                $this->helper_model->insertActivity($user_id, 'change_password_admin', 'change user password from admin');
                if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change Password Is Error...!!";exit;
                }
            } else {
                echo "Password Empty Or MissMatching.. Please Try Again..!!";
                exit;
            }
        } else {
            echo'Please Enter The Correct UserName ..!';
            exit;
        }
    }
    function update_username() {
        $post = $this->input->get();
        $uname_user_name = $post['uname_user_name'];
        $uname_new_username = $post['uname_new_username'];
        $uname_re_entry_username = $post['uname_re_entry_username'];
        $user_id = $this->helper_model->userNameToID($uname_user_name);
        if ($user_id) {
            
            if ($uname_new_username == $uname_re_entry_username && $uname_new_username !='' && $uname_re_entry_username !='') {
                $exisit=$this->member_model->checkUserNameExisit($uname_new_username);
                if($exisit){
                    echo "Username Is Alredy Exist Sorry.!!";exit;
                }
                $res = $this->member_model->updateUserName($user_id, $uname_new_username);
                $this->helper_model->insertActivity($user_id, 'change_username_admin', 'change user Name from admin');
                if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change User Name Is Error...!!";exit;
                }
            } else {
                echo "UserName Empty Or MissMatching.. Please Try Again..!!";
                exit;
            }
        } else {
            echo'Please Enter The Correct UserName ..!';
            exit;
        }
    }
    function update_transation() {
        $post = $this->input->get();
        $tran_user_name = $post['tran_user_name'];
        $tran_pass_password = $post['tran_pass_password'];
        $tran_pass_re_enter_password = $post['tran_pass_re_enter_password'];
        $user_id = $this->helper_model->userNameToID($tran_user_name);
        if ($user_id) {
            
            if ($tran_pass_password == $tran_pass_re_enter_password && $tran_pass_password !='' && $tran_pass_re_enter_password !='') {
                $this->helper_model->insertActivity($user_id, 'change_transation_password_user', 'change Transation password from user');
                 $res =$this->member_model->updateTranPassword($user_id, $tran_pass_password);
            if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change Transation Password Is Error...!!";exit;
                }
            } else {
                echo "Empty Or MissMatching.Please Try Again..!";
                exit;
            }
        } else {
            echo'Please Enter The Correct UserName ..!';
            exit;
        }
    }
    function update_act() {
        $post = $this->input->get();
        $act_user_name = $post['act_user_name'];
       $user_id = $this->helper_model->userNameToID($act_user_name);
        if ($user_id) {
            $user_status=$this->member_model->getUserStatus($user_id);
            if($user_status=='active'){
                echo "User Is Alredy Active";exit;
            }
            
                 $res =$this->member_model->updateUserStatus($user_id, 'active');
                $this->helper_model->insertActivity($user_id, 'user_activate_admin', 'change user user status as active from admin');
            if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change User Status Is Error...!!";exit;
                }
            
        } else {
            echo'Please Enter The Correct UserName ..!';
            exit;
        }
    }
    function update_dct() {
        $post = $this->input->get();
        $act_user_name = $post['act_user_name'];
       $user_id = $this->helper_model->userNameToID($act_user_name);
        if ($user_id) {
            $user_status=$this->member_model->getUserStatus($user_id);
            if($user_status=='inactive'){
                echo "User Is Alredy Inactive";exit;
            }
            
                 $res =$this->member_model->updateUserStatus($user_id, 'inactive');
                $this->helper_model->insertActivity($user_id, 'user_inactivate_admin', 'change user user status as inactive from admin');
            if ($res) {
                    echo "yes";
                    exit;
                } else {
                    echo "Change User Status Is Error...!!";exit;
                }
            
        } else {
            echo'Please Enter The Correct UserName ..!';
            exit;
        }
    }

}
