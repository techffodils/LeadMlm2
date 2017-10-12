<?php

class Backup_model extends CI_Model {

    function dbBackup() {
        $this->load->model("cron_job_model");        
        $backup_type = $this->dbvars->BACKUP_TYPE;
        $backup_deletion_period = $this->dbvars->BACKUP_DELETION_PERIOD;
        
        
        $insert_id = $this->cron_job_model->insertCronJobHistory('db_backup','Admin');
        
        $compression = FALSE;
        if ($backup_type == 'zip') {
            $compression = TRUE;
        }
        $this->backup_model->deleteOlderBackup($backup_deletion_period);
        $res =  $this->backup_model->generateBackup($insert_id, $compression);
        
        if ($res) {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Success');
        } else {
            $this->cron_job_model->updateCronJobHistory($insert_id, 'Failed');
        }
        return $res;
    }

    function generateBackup($insert_id, $compression = true) {
        $db_hostname = $this->db->hostname;
        $db_username = $this->db->username;
        $db_password = $this->db->password;
        $db_database = $this->db->database;
        ;
        $DBH = new PDO("mysql:host=$db_hostname;dbname=$db_database; charset=utf8", $db_username, $db_password);

        return $this->backup_tables($DBH, $insert_id, $compression);
    }

    function backup_tables($DBH, $cron_job_id, $compression) {
        $tables = array();
        $DBH->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
        //Script Variables

        $BACKUP_PATH = FCPATH . "application/backup/";
        $nowtimename = 'db-' . time();
        //create/open files
        if ($compression) {
            $zp = gzopen($BACKUP_PATH . $nowtimename . '.sql.gz', "a9");
        } else {
            $handle = fopen($BACKUP_PATH . $nowtimename . '.sql', 'a+');
        }
//array of all database field types which just take numbers 
        $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');
//get all of the tables
        if (empty($tables)) {
            $pstm1 = $DBH->query('SHOW TABLES');
            while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }
//cycle through the table(s)
        foreach ($tables as $table) {
            $result = $DBH->query("SELECT * FROM $table");
            $num_fields = $result->columnCount();
            $num_rows = $result->rowCount();
            $return = "";
//uncomment below if you want 'DROP TABLE IF EXISTS' displayed
//$return.= 'DROP TABLE IF EXISTS `'.$table.'`;'; 
//table structure
            $pstm2 = $DBH->query("SHOW CREATE TABLE $table");
            $row2 = $pstm2->fetch(PDO::FETCH_NUM);
            $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
            $return .= "\n\n" . $ifnotexists . ";\n\n";
            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
//insert values
            if ($num_rows) {
                $return = 'INSERT INTO `' . "$table" . "` (";
                $pstm3 = $DBH->query("SHOW COLUMNS FROM $table");
                $count = 0;
                $type = array();
                while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {
                    if (stripos($rows[1], '(')) {
                        $type[$table][] = stristr($rows[1], '(', true);
                    } else {
                        $type[$table][] = $rows[1];
                    }
                    $return .= "`" . $rows[0] . "`";
                    $count++;
                    if ($count < ($pstm3->rowCount())) {
                        $return .= ", ";
                    }
                }
                $return .= ")" . ' VALUES';
                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $count = 0;
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $return = "\n\t(";
                for ($j = 0; $j < $num_fields; $j++) {
//$row[$j] = preg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) {
//if number, take away "". else leave as string
                        if ((in_array($type[$table][$j], $numtypes)) && (!empty($row[$j])))
                            $return .= $row[$j];
                        else
                            $return .= $DBH->quote($row[$j]);
                    } else {
                        $return .= 'NULL';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $count++;
                if ($count < ($result->rowCount())) {
                    $return .= "),";
                } else {
                    $return .= ");";
                }
                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $return = "\n\n-- ------------------------------------------------ \n\n";
            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }
        $error1 = $pstm2->errorInfo();
        $error2 = $pstm3->errorInfo();
        $error3 = $result->errorInfo();
        echo $error1[2];
        echo $error2[2];
        echo $error3[2];
        if ($compression) {
            gzclose($zp);
        } else {
            fclose($handle);
        }
        if ($compression) {
            $path = $BACKUP_PATH . $nowtimename . '.sql.gz';
            $file = $nowtimename . '.sql.gz';
        } else {
            $path = $BACKUP_PATH . $nowtimename . '.sql';
            $file = $nowtimename . '.sql';
        }
        if (file_exists($path)) {
            $this->db->set('data ', $file);
            $this->db->where('id ', "$cron_job_id");
            $query = $this->db->update('cron_job');
            return $file;
        } else {
            return 0;
        }
    }

    function deleteOlderBackup($day) {
        $deleting_day = date('Y-m-d', strtotime("-$day days"));
        $query = $this->db->select("id,data")
                ->from("cron_job")
                ->where("cron_job", 'db_backup')
                ->where("file_status !=", 'deleted')
                ->where('date <=', $deleting_day)
                ->get();
        foreach ($query->result() as $row) {
            $filename = $row->data;
            $cron_job_id = $row->id;
            $path = FCPATH . "application/backup/" . $filename;
            if ($filename != '' && file_exists($path) && is_file($path)) {
                unlink($path);

                $this->db->set('file_status ', "deleted")
                        ->where('id ', "$cron_job_id")
                        ->update('cron_job');
            }
        }
        return TRUE;
    }

    function getLastBackups(){
        $data = array();
        $res = $this->db->select("id,date,data,done_by")
                ->from("cron_job")
                ->where("cron_job", 'db_backup')
                ->where("file_status !=", 'deleted')
                ->where("status", 'Success')
                ->order_by("id", "desc")
                ->limit(10)
                ->get();
        $slno=1;
        foreach ($res->result() as $row) {
            $data[$slno]['slno'] = $slno;
            $data[$slno]['id'] = $row->id;
            $data[$slno]['date'] = $row->date;
            $data[$slno]['file_name'] = $row->data;
            $data[$slno]['done_by'] = $row->done_by;
            $slno++;
        }
        return $data;
    
    }
}
