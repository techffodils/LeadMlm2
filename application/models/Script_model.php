<?php

/**
 * For Login Model
 * @author Techffodils
 * @Date:201-10-10
 *
 *
 */
class Script_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function loadScript($url_id) {
        $script = array();

        switch ($url_id) {
            case 1:
                $script[0]['type'] = 'css';
                $script[0]['file'] = 'filename';
                break;
            case 6:
                $script[0]['type'] = 'js';
                $script[0]['file'] = 'employee_enroll.js';
                $script[1]['type'] = 'js';
                $script[1]['file'] = 'plugins/jquery.maskedinput/src/jquery.maskedinput.js';
                break;
            default:
                break;
        }

        return $script;
    }

}

?>
