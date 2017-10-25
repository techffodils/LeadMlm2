<?php
require_once ('translator/vendor/autoload.php');
use \Statickidz\GoogleTranslate;
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Translator extends Base_Controller {

    function index() {//https://github.com/statickidz/php-google-translate-free
        $source = 'en';
        $target = 'es';
        $text = 'Good Morning';

        $trans = new GoogleTranslate();
        $result = $trans->translate($source, $target, $text);

        echo $result;
        
        $this->setData('title', lang('translator'));
        $this->loadView();
    }

}
