<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Backup extends Base_Controller {

    function index() {
        
        $this->loadView();
    }

}
