<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
  @Author Techffodils
  @date 2017-10-9;
 */
require_once 'Base_Controller.php';

class Mail extends Base_Controller {

    /**
     * @Author Techffodils
     * @Date 2017-10-9
     */
    function inbox() {

        $title = "Mail Inbox";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);


        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusTrash($id);
                }
            }
        }
        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllMails($user_id, 'inbox');
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');

        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);


        $this->loadView();
    }

    function compose() {

        $title = "Compose Mail";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);
        $from_id = $this->main->get_usersession('mlm_user_id');
        $reply_user = '';
        $reply_subject = '';
        $forward_content = '';

        if ($this->input->post('send')) {
            $post_data = $this->input->post();
            $to_user = $this->input->post('to_user');
            $user_id = $this->helper_model->userNameToID($to_user);
            $post_data['from_id'] = $from_id;
            $post_data['user_id'] = $user_id;
            $post_data['catagories'] = 'inbox';
            $post_data['date'] = date("Y-m-d h:i:s");
            $post_data['read_status'] = 'unread';
            // print_r($post_data);die;
            if ($user_id) {
                $this->mail_model->insertMailData($post_data);
            } else {
                $user_id = $this->main->get_usersession('mlm_user_id');
                $post_data['user_id'] = $user_id;
                $post_data['catagories'] = 'draft';
                $this->mail_model->insertMailData($post_data);
            }
        }
        if ($this->input->post('draft')) {
            $post_data = $this->input->post();
            $user_id = $this->main->get_usersession('mlm_user_id');
            $post_data['from_id'] = $user_id;
            $post_data['user_id'] = $user_id;
            $post_data['catagories'] = 'draft';
            $post_data['attachment'] = '';
            $post_data['read_status'] = 'unread';
            $post_data['date'] = date("Y-m-d h:i:s");
//            print_r($post_data);die;
            $this->mail_model->insertMailData($post_data);
        }

        if ($this->input->post('reply')) {
            $reply_user = $this->input->post('to_user');
            $reply_subject = $this->input->post('subject');
        }
        if ($this->input->post('forward')) {
            $reply_user = '';
            $forward_content = $this->input->post('content');
            $reply_subject = $this->input->post('subject');
        }
        $this->setData('reply_user', $reply_user);
        $this->setData('reply_subject', $reply_subject);
        $this->setData('forward_content', $forward_content);

        $this->loadView();
    }

    function read($id = '') {

        $title = "Read Mail";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);
        $mail_details = array();

        $user_id = $this->main->get_usersession('mlm_user_id');
        if ($id) {
            $this->mail_model->changeReadStatus($id,$user_id,'read');
            $mail_details = $this->mail_model->getMailDetails($user_id, $id, 'inbox');
        }

        $this->setData('mail_details', $mail_details);


        $this->loadView();
    }

    function sent() {

        $title = "Sent Items";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);

        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusDelete($id);
                }
            }
        }

        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllSentMails($user_id, 'inbox');
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');

        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);


        $this->loadView();
    }

    function draft() {

        $title = "Draft Items";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);

        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusTrash($id);
                }
            }
        }

        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllMails($user_id, 'draft');
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');


        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);


        $this->loadView();
    }

    function stared() {

        $title = "Stared Items";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);

        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusTrash($id);
                }
            }
        }

        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllMailsStared($user_id);
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');


        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);


        $this->loadView();
    }

    function spam() {

        $title = "Spam Items";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);

        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusTrash($id);
                }
            }
        }

        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllMailsSpam($user_id);
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');


        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);

        $this->loadView();
    }

    function trash() {
        $title = "Spam Items";
        $this->setData('title', $title . '|' . $this->main->get_controller() . '::');
        $this->setData('header', $title);
        if ($this->input->post('checkbox') && $this->input->post('delete')) {
            $post_data = $this->input->post();
            $count = count($post_data['checkbox']);
            if ($count) {
                for ($i = 0; $i < $count; $i++) {
                    $id = $post_data['checkbox'][$i];
                    $this->mail_model->changeStatusDelete($id);
                }
            }
        }
        $user_id = $this->main->get_usersession('mlm_user_id');
        $all_mails = $this->mail_model->getAllMails($user_id, 'trash');
        $unread_mail = $this->mail_model->getCountUnReadMail($user_id, 'inbox');
        $this->setData('all_mails', $all_mails);
        $this->setData('unread_mail', $unread_mail);
        $this->loadView();
    }

    function set_stared() {
        $id = $this->input->get('id');
        $user_id = $this->main->get_usersession('mlm_user_id');
        $this->mail_model->changestared($id, $user_id, 'yes');
        echo 'yes';
        exit;
    }

    function unset_stared() {
        $id = $this->input->get('id');
        $user_id = $this->main->get_usersession('mlm_user_id');
        $this->mail_model->changestared($id, $user_id, 'no');
        echo 'yes';
        exit;
    }

    function set_spam() {
        $id = $this->input->get('id');
        $user_id = $this->main->get_usersession('mlm_user_id');
        $this->mail_model->changespam($id, $user_id, 'yes');
        echo 'yes';
        exit;
    }

    function unset_spam() {
        $id = $this->input->get('id');
        $user_id = $this->main->get_usersession('mlm_user_id');
        $this->mail_model->changespam($id, $user_id, 'no');
        echo 'yes';
        exit;
    }

}
