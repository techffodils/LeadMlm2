<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Cron_Job extends Base_Controller {

    function db_backup() {//Daily Cron For Database Backup
        $insert_id = $this->cron_job_model->insertCronJobHistory('db_backup');
        $compression_status=1;
        $delete_intervell=30;
        $res = $this->cron_job_model->generateBackup($insert_id,$compression_status);
        if ($res) {
            $this->cron_job_model->deleteOlderBackup($delete_intervell);
            echo 'Success';
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
        } else {
            echo 'Failed';
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
        }
    }

}
