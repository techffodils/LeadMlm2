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

    function translate_new_fields() {
        $this->load->helper('file');
        $trans = new GoogleTranslate();
        $data = $this->translator_model->getUntraslatedData();
        $languages = $this->translator_model->getAllLanguages();
        $source = 'en';
        $i=$j=0;
        foreach ($languages as $l) {
            $target = $l['lang_code'];
            foreach ($data as $d) {
                $text = $d['in_english'];
                $field = $d['field_name'];
                $result = $trans->translate($source, $target, $text);
                if ($result) { 
                    $file_path = FCPATH.'application/language/' . $l['language_folder'] . '/translator_lang.php';
                    if (file_exists($file_path)) {
                        $result=str_replace("'",'', $result);
                        $text = "$"."lang['".$field."']='".$result."';\n";
                        if (write_file($file_path, $text,'a+')) {                            
                            $this->translator_model->updateConversionStatus($d['id']); 
                        }
                    }
                }
            }
        }        
    }

}
