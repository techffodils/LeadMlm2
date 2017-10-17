<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Product extends Base_Controller {

    public function product_management($action = "", $product_id = "") {
        $product=array();
        if ($this->session->userdata('product_post_data')!=null)
            $product = $this->session->userdata('product_post_data');
        if ($this->input->post('add_product')) {
            $post = $this->input->post();
            if ($this->validate_add_product()) {
                $res = $this->product_model->addProduct($post);
                if ($res) {
                    $this->session->unset_userdata('product_post_data');
                    $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'product_added', $post);
                    $this->loadPage('Product Added Successfully', 'product/product_management', TRUE);
                } else {
                    $this->loadPage('Failed To Add', 'product/product_management', False);
                }
            } else {
                $this->session->set_userdata('product_post_data', $post);
                $this->loadPage('Validation Error', 'product/product_management', False);
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
                    $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'product_deleted', $data);
                    $this->loadPage('Product Deleted Successfully', 'product/product_management', TRUE);
                } else {
                    $this->loadPage('Failed To Delete', 'product/product_management', False);
                }
            } elseif ($action == "activate") {
                $res = $this->product_model->changeProductStatus($product_id, 1);
                if ($res) {
                    $data['product_id'] = $product_id;
                    $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'product_activate', $data);
                    $this->loadPage('Product Deleted Successfully', 'product/product_management', TRUE);
                } else {
                    $this->loadPage('Failed To Delete', 'product/product_management', False);
                }
            } elseif ($action == "inactivate") {
                $res = $this->product_model->changeProductStatus($product_id, 0);
                if ($res) {
                    $data['product_id'] = $product_id;
                    $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'product_inactivate', $data);
                    $this->loadPage('Product Deleted Successfully', 'product/product_management', TRUE);
                } else {
                    $this->loadPage('Failed To Delete', 'product/product_management', False);
                }
            } else {
                $this->loadPage('Invalid Action', 'product/product_management', False);
            }
        }

        if ($this->input->post('cancel_product')) {
            $this->loadPage('Product Update Canceled', 'product/product_management', TRUE);
        }

        if ($this->input->post('update_product')) {
            $post = $this->input->post();
            if ($this->validate_add_product()) {
                $res = $this->product_model->updateProduct($post);
                if ($res) {
                    $this->session->unset_userdata('product_post_data');
                    $this->helper_model->insertActivity($this->main->get_usersession('mlm_user_id'), 'product_updated', $post);
                    $this->loadPage('Product Added Successfully', 'product/product_management', TRUE);
                } else {
                    $this->loadPage('Failed To Add', 'product/product_management', False);
                }
            } else {
                $this->session->set_userdata('product_post_data', $post);
                $this->loadPage('Validation Error', 'product/product_management', False);
            }
        }

        $all_products = $this->product_model->getAllProducts();

        $this->setData('product_id', $product_id);
        $this->setData('edit_flag', $edit_flag);
        $this->setData('product', $product);
        $this->setData('all_products', $all_products);
        $this->loadView();
    }

    function validate_add_product() {
        $this->form_validation->set_rules('product_name', 'product_name', 'required');
        $this->form_validation->set_rules('product_amount', 'product_amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('product_pv', 'product_pv', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('product_code', 'product_code', 'required');
        $this->form_validation->set_rules('product_type', 'product_type', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $validation = $this->form_validation->run();
        return $validation;
    }

}
