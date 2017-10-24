<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Product extends Base_Controller {

    public function product_management($action = "", $product_id = "") {
        $product = array();
        if ($this->session->userdata('product_post_data') != null)
            $product = $this->session->userdata('product_post_data');
        if ($this->input->post('add_product') && $this->validate_add_product()) {
            $post = $this->input->post();
            $config['upload_path'] = FCPATH . 'assets/images/products/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            
            $new_name = 'pro_'.time();
            $config['file_name'] = $new_name;
            
            $this->load->library('upload', $config);

            $upload_data = array();

            $files = $_FILES;
            $cpt = count($_FILES['images']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['userfile']['name'] = $files['images']['name'][$i];
                $_FILES['userfile']['type'] = $files['images']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['images']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['images']['error'][$i];
                $_FILES['userfile']['size'] = $files['images']['size'][$i];

                $this->upload->initialize($config);
                if ($this->upload->do_upload()) {
                    $upload_data[] = $this->upload->data();
                }
            }
            $res = $this->product_model->addProduct($post, $upload_data);
            if ($res) {
                $this->session->unset_userdata('product_post_data');
                $this->helper_model->insertActivity($this->LOG_USER_ID, 'product_added', $post);
                $this->loadPage(lang('product_added_successfully'), 'product/product_management');
            } else {
                $this->loadPage(lang('product_adding_failed'), 'product/product_management', 'danger');
            }
        }

        $edit_flag = FALSE;
        if ($action && $product_id) {
            if ($action == "edit") {
                $edit_flag = TRUE;
                $product = $this->product_model->getProductDetails($product_id);
            } elseif ($action == "delete") {
                $res = $this->product_model->deleteProduct($product_id);
                if ($res) {
                    $data['product_id'] = $product_id;
                    $this->helper_model->insertActivity($this->LOG_USER_ID, 'product_deleted', $data);
                    $this->loadPage(lang('product_deleted'), 'product/product_management');
                } else {
                    $this->loadPage(lang('product_deletion_failed'), 'product/product_management', 'danger');
                }
            } elseif ($action == "activate") {
                $res = $this->product_model->changeProductStatus($product_id, 1);
                if ($res) {
                    $data['product_id'] = $product_id;
                    $this->helper_model->insertActivity($this->LOG_USER_ID, 'product_activate', $data);
                    $this->loadPage(lang('product_activated'), 'product/product_management');
                } else {
                    $this->loadPage(lang('product_activation_failed'), 'product/product_management', 'danger');
                }
            } elseif ($action == "inactivate") {
                $res = $this->product_model->changeProductStatus($product_id, 0);
                if ($res) {
                    $data['product_id'] = $product_id;
                    $this->helper_model->insertActivity($this->LOG_USER_ID, 'product_inactivate', $data);
                    $this->loadPage(lang('product_inactivated'), 'product/product_management');
                } else {
                    $this->loadPage(lang('product_inactivation_failed'), 'product/product_management', 'danger');
                }
            } else {
                $this->loadPage(lang('invalid_action'), 'product/product_management', 'danger');
            }
        }

        if ($this->input->post('cancel_product')) {
            $this->loadPage(lang('product_updation_canceled'), 'product/product_management');
        }

        if ($this->input->post('update_product') && $this->validate_add_product()) {
            $post = $this->input->post();
            $config['upload_path'] = FCPATH . 'assets/images/products/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 2048;
            $config['max_height'] = 2048;
            $this->load->library('upload', $config);

            $edited_id = $post['edited_id'];
            $existing_files = $this->product_model->getAllExistingfiles($edited_id);
            $upload_data = array();
            $ef_count = 0;
            foreach ($existing_files as $ef) {
                if (!$post['product_delete_status_' . $ef['id']]) {
                    $upload_data[$ef_count] = $ef;
                    $ef_count++;
                }
            }

            $files = $_FILES;
            $cpt = count($_FILES['images']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                $_FILES['userfile']['name'] = $files['images']['name'][$i];
                $_FILES['userfile']['type'] = $files['images']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['images']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['images']['error'][$i];
                $_FILES['userfile']['size'] = $files['images']['size'][$i];

                $this->upload->initialize($config);
                if ($this->upload->do_upload()) {
                    $upload_data[$ef_count] = $this->upload->data();
                    $ef_count++;
                }
            }

            $res = $this->product_model->updateProduct($post, $upload_data);
            if ($res) {
                $this->session->unset_userdata('product_post_data');
                $this->helper_model->insertActivity($this->LOG_USER_ID, 'product_updated', $post);
                $this->loadPage(lang('product_updated_successfully'), 'product/product_management');
            } else {
                $this->loadPage(lang('product_updation_failed'), 'product/product_management', 'danger');
            }
        }

        $all_products = $this->product_model->getAllProducts();
        $this->setData('error', $this->form_validation->error_array());
        $this->setData('product_id', $product_id);
        $this->setData('edit_flag', $edit_flag);
        $this->setData('product', $product);
        $this->setData('all_products', $all_products);
        $this->setData('title',lang('menu_name_21'));
        $this->loadView();
    }

    function validate_add_product() {
        $this->session->set_userdata('product_post_data', $this->input->post());
        $this->form_validation->set_rules('product_name', lang('product_name'), 'required');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('product_pv', lang('product_pv'), 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('product_code', lang('product_code'), 'required');
        $this->form_validation->set_rules('product_type', lang('product_type'), 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }


}
