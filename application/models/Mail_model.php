<?php

class Mail_model extends CI_Model {

    function getAllMails($user_id, $catagories) {
        $data = array();
        $res = $this->db->select("from_id,id,user_id,subject,attachment_name,catagories,date,read_status,content")
                ->from("mail_system")
                ->where("catagories", $catagories)
                ->where("user_id", $user_id)
                ->where("stared", 'no')
                ->where("spam", 'no')
                ->order_by("read_status","DESC")
                ->order_by("date","DESC")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['user_id'] = $row->user_id;
            $data[$i]['subject'] = $row->subject;
            $data[$i]['content'] = $row->content;
            $data[$i]['show_subject'] = implode(' ', array_slice(explode(' ', $row->subject), 0,3)).'..';
            $data[$i]['show_content'] = implode(' ', array_slice(explode(' ', $row->content), 0,4)).'....';
            $data[$i]['attachment_name'] = $row->attachment_name;
            $data[$i]['catagories'] = $row->catagories;
            $data[$i]['date'] = $row->date;
            $data[$i]['read_status'] = $row->read_status;
            $data[$i]['username'] =$this->helper_model->IdToUserName($row->user_id);
            $data[$i]['from_username'] =$this->helper_model->IdToUserName($row->from_id);
            $i++;
        }
        return $data;
    }
    function getMailDetails($user_id, $id,$catagories) {
        $data = array();
        $res = $this->db->select("from_id,id,user_id,subject,attachment_name,catagories,date,read_status,content")
                ->limi(1)
                ->where("id", $id)               
                ->get('mail_system');
        
        foreach ($res->result() as $row) {
            $data['id'] = $row->id;
            $data['user_id'] = $row->user_id;
            $data['subject'] = $row->subject;
            $data['content'] = $row->content;
            $data['show_subject'] = implode(' ', array_slice(explode(' ', $row->subject), 0,3)).'..';
            $data['show_content'] = implode(' ', array_slice(explode(' ', $row->content), 0,4)).'....';
            $data['attachment_name'] = $row->attachment_name;
            $data['catagories'] = $row->catagories;
            $data['date'] = $row->date;
            $data['read_status'] = $row->read_status;
            $data['username'] =$this->helper_model->IdToUserName($row->user_id);
            $data['from_username'] =$this->helper_model->IdToUserName($row->from_id);
           
        }
        return $data;
    }

    function getCountUnReadMail($user_id, $catagories) {
        $numrows = $this->db->select('id')
                ->from("mail_system")
                ->where('read_status', "unread")
                ->where("catagories", $catagories)
                ->where("user_id", $user_id)
                ->count_all_results();
        return $numrows;
    }

    function insertMailData($data) {
        return $this->db->set('user_id', $data['user_id'])
                        ->set('from_id', $data['from_id'])
                        ->set('subject', $data['subject'])
                        ->set('content', $data['content'])
                        ->set('attachment_name', $data['attachment'])
                        ->set('catagories', $data['catagories'])
                        ->set('date', $data['date'])
                        ->set('read_status', $data['read_status'])
                        ->insert('mail_system');
    }

    function changeCatagories($id, $user_id, $catogories) {
        return $this->db->set('catagories ', $catogories)
                        ->where('user_id ', $user_id)
                        ->where('id ', $id)
                        ->update('mail_system');
    }
    function changestared($id, $user_id, $catogories) {
        return $this->db->set('stared ', $catogories)
                        ->where('user_id ', $user_id)
                        ->where('id ', $id)
                        ->update('mail_system');
    }
    function changespam($id, $user_id, $catogories) {
        return $this->db->set('spam ', $catogories)
                        ->where('user_id ', $user_id)
                        ->where('id ', $id)
                        ->update('mail_system');
    }

    function changeReadStatus($id, $user_id, $read_status) {
        return $this->db->set('read_status ', $read_status)
                        ->where('user_id ', $user_id)
                        ->where('id ', $id)
                        ->update('mail_system');
    }
    function getAllSentMails($user_id, $catagories) {
        $data = array();
        $res = $this->db->select("from_id,id,user_id,subject,attachment_name,catagories,date,read_status,content")
                ->from("mail_system")
                ->where("catagories", $catagories)
                ->where("from_id", $user_id)
                ->order_by("read_status","DESC")
                ->order_by("date","DESC")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['user_id'] = $row->from_id;
            $data[$i]['subject'] = $row->subject;
            $data[$i]['content'] = $row->content;
            $data[$i]['show_subject'] = implode(' ', array_slice(explode(' ', $row->subject), 0,3)).'..';
            $data[$i]['show_content'] = implode(' ', array_slice(explode(' ', $row->content), 0,4)).'....';
            $data[$i]['attachment_name'] = $row->attachment_name;
            $data[$i]['catagories'] = $row->catagories;
            $data[$i]['date'] = $row->date;
            $data[$i]['read_status'] = $row->read_status;
            $data[$i]['username'] =$this->helper_model->IdToUserName($row->from_id);
            $data[$i]['from_username'] =$this->helper_model->IdToUserName($row->user_id);
            $i++;
        }
        return $data;
    }
    
    function changeStatusTrash($id) {
        return $this->db->set('catagories ', 'trash')
                        ->where('id ', $id)
                        ->update('mail_system');
    }
    function changeStatusDelete($id) {
        return $this->db->set('catagories ', 'delete')
                        ->where('id ', $id)
                        ->update('mail_system');
    }
    
    function getAllMailsSpam($user_id) {
        $data = array();
        $res = $this->db->select("from_id,id,user_id,subject,attachment_name,catagories,date,read_status,content")
                ->from("mail_system")
                ->where("user_id", $user_id)
                ->where("spam", 'yes')
                ->order_by("read_status","DESC")
                ->order_by("date","DESC")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['user_id'] = $row->user_id;
            $data[$i]['subject'] = $row->subject;
            $data[$i]['content'] = $row->content;
            $data[$i]['show_subject'] = implode(' ', array_slice(explode(' ', $row->subject), 0,3)).'..';
            $data[$i]['show_content'] = implode(' ', array_slice(explode(' ', $row->content), 0,4)).'....';
            $data[$i]['attachment_name'] = $row->attachment_name;
            $data[$i]['catagories'] = $row->catagories;
            $data[$i]['date'] = $row->date;
            $data[$i]['read_status'] = $row->read_status;
            $data[$i]['username'] =$this->helper_model->IdToUserName($row->user_id);
            $data[$i]['from_username'] =$this->helper_model->IdToUserName($row->from_id);
            $i++;
        }
        return $data;
    }
    function getAllMailsStared($user_id) {
        $data = array();
        $res = $this->db->select("from_id,id,user_id,subject,attachment_name,catagories,date,read_status,content")
                ->from("mail_system")
                ->where("user_id", $user_id)
                ->where("stared", 'yes')
                ->order_by("read_status","DESC")
                ->order_by("date","DESC")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['user_id'] = $row->user_id;
            $data[$i]['subject'] = $row->subject;
            $data[$i]['content'] = $row->content;
            $data[$i]['show_subject'] = implode(' ', array_slice(explode(' ', $row->subject), 0,3)).'..';
            $data[$i]['show_content'] = implode(' ', array_slice(explode(' ', $row->content), 0,4)).'....';
            $data[$i]['attachment_name'] = $row->attachment_name;
            $data[$i]['catagories'] = $row->catagories;
            $data[$i]['date'] = $row->date;
            $data[$i]['read_status'] = $row->read_status;
            $data[$i]['username'] =$this->helper_model->IdToUserName($row->user_id);
            $data[$i]['from_username'] =$this->helper_model->IdToUserName($row->from_id);
            $i++;
        }
        return $data;
    }

}
