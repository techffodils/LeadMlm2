<?php

class Cron_job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function insertCronJobHistory($cron_job, $done_by = "Cron Job") {
        $this->db->set('cron_job', $cron_job)
                ->set('status', 'Started')
                ->set('done_by', $done_by)
                ->set('ip', $this->helper_model->getUserIP())
                ->set('date', date("Y-m-d H:i:s"))
                ->insert('cron_job');
        return $this->db->insert_id();
    }

    function updateCronJobHistory($cron_job_id, $status = 'NA') {
        return $this->db->set('status ', "$status")
                        ->where('id ', "$cron_job_id")
                        ->update('cron_job');
    }

    function generateBackup($insert_id, $backup_type = '', $backup_deletion_period = '30') {
        $compression = FALSE;
        if ($backup_type == 'zip') {
            $compression = TRUE;
        }
        $this->load->model("backup_model");
        $this->backup_model->deleteOlderBackup($backup_deletion_period);
        return $this->backup_model->generateBackup($insert_id, $compression);
    }

    public function updateCurrencyRates($default_currency) {
//http://fixer.io/
        $flag = FALSE;
        $result = 0;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://api.fixer.io/latest?base=' . $default_currency);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $content = curl_exec($curl);
        curl_close($curl);

        $decodedText = html_entity_decode($content);
        $data = json_decode($decodedText, true);
        if ($data['base'] == $default_currency) {
            $rates = $data['rates'];
            $currencies = $this->getAllCurrencies();
            $this->resetAllConversionStatus($default_currency);
            foreach ($currencies as $value) {
                $code = $value['code'];
                //echo "<p>$code///";
                if (isset($rates[$code])) {
                    $result=$this->updateCurrencyRatio($code,$rates[$code]);                    
                }
                if ($code == 'BTC') {
                    $flag = TRUE;
                }
            }
        }

        if ($flag) {//updation for BTC
            $btc_value=file_get_contents("https://blockchain.info/tobtc?currency=$default_currency&value=1");
            if($btc_value>0){
                $this->updateCurrencyRatio('BTC',$btc_value);
            }
//            $curl = curl_init();
//            curl_setopt($curl, CURLOPT_URL, "https://blockchain.info/tobtc?currency=$default_currency&value=1");
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($curl, CURLOPT_HEADER, false);
//            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
//            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
//            $btc_value = curl_exec($curl);
//            curl_close($curl);
//            if($btc_value>0){
//                $this->updateCurrencyRatio('BTC',$btc_value);
//            }
        }        
        $this->updateCurrencyRatio($default_currency,1);
        
        return $result;
    }

    function getAllCurrencies() {
        $data = array();
        $res = $this->db->select("id,currency_code")
                ->from("currencies")
                ->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $data[$i]['id'] = $row->id;
            $data[$i]['code'] = $row->currency_code;
            $i++;
        }
        return $data;
    }

    public function resetAllConversionStatus($default_currency) {
        return $this->db->set('conversion_status ', "no")
                        ->where('currency_code !=', $default_currency)
                        ->update('currencies');
    }

    public function updateCurrencyRatio($code, $ratio) {
        return $this->db->set('conversion_status ', "yes")
                        ->set('currency_ratio ', $ratio)
                        ->where('currency_code', $code)
                        ->update('currencies');
    }


}

?>
