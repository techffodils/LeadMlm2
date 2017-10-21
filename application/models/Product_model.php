<?php

class Product_model extends CI_Model {

    function addProduct($data, $images = array()) {
        return $this->db->set('product_name', $data['product_name'])
                        ->set('product_amount', $data['product_amount'])
                        ->set('product_pv', $data['product_pv'])
                        ->set('product_code', $data['product_code'])
                        ->set('recurring_type', $data['recurring_type'])
                        ->set('product_type', $data['product_type'])
                        ->set('images', serialize($images))
                        ->insert('products');
    }

    function getAllProducts() {
        $data = array();
        $res = $this->db->select("id,status,product_name,product_amount,product_pv,product_code,recurring_type,product_type")
                ->from("products")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['sl_no'] = $i + 1;
            $data[$i]['id'] = $row->id;
            $data[$i]['product_name'] = $row->product_name;
            $data[$i]['product_amount'] = $row->product_amount;
            $data[$i]['product_pv'] = $row->product_pv;
            $data[$i]['product_code'] = $row->product_code;
            $data[$i]['recurring_type'] = $row->recurring_type;
            $data[$i]['product_type'] = $row->product_type;
            $data[$i]['status'] = $row->status;
            $i++;
        }
        return $data;
    }

    function getProductDetails($prod_id) {
        $data = array();
        $res = $this->db->select("id,status,product_name,images,product_amount,product_pv,product_code,recurring_type,product_type")
                ->from("products")
                ->where('id', $prod_id)
                ->limit(1)
                ->get();
        foreach ($res->result() as $row) {
            $data['id'] = $row->id;
            $data['product_name'] = $row->product_name;
            $data['product_amount'] = $row->product_amount;
            $data['product_pv'] = $row->product_pv;
            $data['product_code'] = $row->product_code;
            $data['recurring_type'] = $row->recurring_type;
            $data['product_type'] = $row->product_type;
            $data['status'] = $row->status;            
            $data['files'] =$this->getAllFiles($row->images);
        }
        return $data;
    }
    
    function getAllExistingfiles($prod_id){
        $files = array();
        $res = $this->db->select("images")
                ->from("products")
                ->where('id', $prod_id)
                ->get();
        foreach ($res->result() as $row) {
            $files =$this->getAllFiles($row->images);
        }
        return $files;
    }

    function getAllFiles($images) {
        $image = unserialize($images);
        //print_r($image);die();
        $files = array();
        $i=0;
        foreach ($image as $key => $img) {
            $files[$i]['id'] = $key;
            $files[$i]['file_name'] = $img['file_name'];
            $i++;
        }
        return $files;
    }

    function updateProduct($data,$files=array()) {
        return $this->db->set('product_name', $data['product_name'])
                        ->set('product_amount', $data['product_amount'])
                        ->set('product_pv', $data['product_pv'])
                        ->set('product_code', $data['product_code'])
                        ->set('recurring_type', $data['recurring_type'])
                        ->set('product_type', $data['product_type'])
                        ->set('images', serialize($files))
                        ->where('id', $data['edited_id'])
                        ->update('products');
    }

    function changeProductStatus($product_id, $status) {
        return $this->db->set('status', $status)
                        ->where('id', $product_id)
                        ->update('products');
    }

    function deleteProduct($product_id) {
        return $this->db->where('id', $product_id)
                        ->delete('products');
    }

}
