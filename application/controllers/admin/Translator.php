<?php
require_once ('translator/vendor/autoload.php');
use \Statickidz\GoogleTranslate;
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Translator extends Base_Controller {

    function index() {
        /*
         * URL: https://github.com/statickidz/php-google-translate-free
         * Run these is terminal
         * sudo apt-get install php7.0-dom php7.0-mbstring
         * composer require statickidz/php-google-translate-free
         * 
         */
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
