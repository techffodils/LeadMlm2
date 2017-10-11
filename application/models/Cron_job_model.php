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
            return $nowtimename;
        } else {
            return 0;
        }
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
