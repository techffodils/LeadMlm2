<?php

class Cron_job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function insertCronJobHistory($cron_job) {
        $this->db->set('cron_job', $cron_job)
                ->set('status', 'Started')
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

    function generateBackup($insert_id, $compression = true) {
        $this->load->model("backup_model");
        return $this->backup_model->generateBackup($insert_id, $compression);
    }

    function deleteOlderBackup($day) {
        $deleting_day = date('Y-m-d', strtotime("-$day days"));
        $query = $this->db->select("data")
                ->from("cron_job")
                ->where("cron_job", 'db_backup')
                ->like('date', $deleting_day)
                ->get();
        foreach ($query->result() as $row) {
            $filename = $row->data;
            $path = FCPATH . "application/backup/" . $filename;
            if ($filename != '' && file_exists($path) && is_file($path)) {
                unlink($path);
            }
        }
        return TRUE;
    }

}

?>
