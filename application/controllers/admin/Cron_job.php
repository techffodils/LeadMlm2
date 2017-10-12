<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_Controller.php';

class Cron_Job extends Base_Controller {

    function db_backup() {//Daily Cron For Database Backup
        $backup_type=$this->dbvars->BACKUP_TYPE;
        $backup_deletion_period=$this->dbvars->BACKUP_DELETION_PERIOD;
        $insert_id = $this->cron_job_model->insertCronJobHistory('db_backup');
        $res = $this->cron_job_model->generateBackup($insert_id,$backup_type,$backup_deletion_period);
        if ($res) {            
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
            echo 'Success';
        } else {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
            echo 'Failed';
        }
    }
    
    function dbvars() {
        $this->dbvars->BACKUP_TYPE = 'zip';//zip,sql
        $this->dbvars->BACKUP_DELETION_PERIOD = '30';
        $this->dbvars->MLM_PLAN = 'BINARY';//Matrix,Unilevel,Donation,Investment,Monoline,Generation
        $this->dbvars->USERNAME_TYPE='static';//dynamic
        $this->dbvars->USERNAME_PREFIX='lead';
        $this->dbvars->REGISTER_FORM_TYPE='multiple';
        $this->dbvars->REGISTER_FIELD_CONFIGURATION='active';
    }
    

}
