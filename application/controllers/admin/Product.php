<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_Controller.php';

class Product extends Base_Controller {
    public function product_management() {
        $this->loadView();
    }
}
