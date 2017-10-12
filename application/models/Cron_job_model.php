<?php

class Cron_job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function insertCronJobHistory($cron_job,$done_by="Cron Job") {
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

    function generateBackup($insert_id, $backup_type = '',$backup_deletion_period='30') {
        $compression = FALSE;
        if ($backup_type == 'zip') {
            $compression = TRUE;
        }
        $this->load->model("backup_model");
        $this->backup_model->deleteOlderBackup($backup_deletion_period);
        return $this->backup_model->generateBackup($insert_id, $compression);
    }

}

?>
