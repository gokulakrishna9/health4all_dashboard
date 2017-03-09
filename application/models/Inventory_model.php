<?php

class Inventory_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_total_inventory(){
        $today = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $total_inventory= 0;
        $this->db->select('bloodbank_id,bloodbank_name,host_name,username,database_name,database_password,bloodbank_type')
        ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $dbt->select("COUNT(*) total_inventory", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1')
            ->where('blood_inventory.expiry_date >=', " $today");
            $query=$dbt->get();
            $result = $query->row();
            $total_inventory += $result->total_inventory;
        }
        return $total_inventory;
    } //DATEDIFF
    
    function get_total_inventory_by_bank(){
        $dbdefault = $this->load->database('default',TRUE);
        $total_inventory_by_banks = array();
        $this->db->select('bloodbank_id,bloodbank_name,host_name,username,database_name,database_password,bloodbank_type')
        ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $dbt->select("COUNT(*) total_inventory, MAX(last_modified_time), $r->bloodbank_id bloodbank_id, '$r->bloodbank_name' bloodbank_name", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1')
            ->where('blood_inventory.expiry_date >=', " $to_date");
            $query = $dbt->get();
            $total_inventory_by_banks[] = $query->result();
        }
        return $total_inventory_by_banks;
    }
    
    function get_inventory_expiring_in($days){
        $dbdefault = $this->load->database('default',TRUE);
        $expiring_inventory = 0;
        $this->db->select('bloodbank_id,bloodbank_name,host_name,username,database_name,database_password,bloodbank_type')
        ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $dbt->select("COUNT(*) expiring_inventory", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1')
            ->where("(blood_inventory.expiry_date BETWEEN now() and date(now() + interval $days day))");
            $query = $dbt->get();
            $result = $query->row();
         //   echo $dbt->last_query()."<br>";
            $expiring_inventory += $result->expiring_inventory;
        }
        return $expiring_inventory;
    }
    
    function get_discarded_inventory($days){
        $dbdefault = $this->load->database('default',TRUE);
        $expiring_inventory = 0;
        $this->db->select('bloodbank_id,bloodbank_name,host_name,username,database_name,database_password,bloodbank_type')
        ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $dbt->select("COUNT(*) expiring_inventory", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1')
            ->where("DATEDIFF(blood_inventory.expiry_date, '$to_date') <=", $days);
            $query = $dbt->get();
            $result = $query->result();
            $expiring_inventory += $query->total_inventory;
        }
    }
    
    function get_inventory_detailed(){        
        $today = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $bloodbanks_status = array();
        $this->db->select('bloodbank_id, host_name,username,database_name,database_password')
        ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('bloodbank_information.*')
            ->from('bloodbank_information')               
            ->where('bloodbank_information.bloodbank_id',"$r->bloodbank_id");
            $query2 = $this->db->get();
            $current_bloodbank = $query2->result();
            if(sizeof($current_bloodbank) == 0){
                continue;
            }
            $current_bloodbank = $current_bloodbank[0];
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $query = $dbt->query("SELECT  last_modified_time, total_inventory, "
                . "'$current_bloodbank->bloodbank_id' bloodbank_id, "
                . "'$current_bloodbank->bloodbank_name' bloodbank_name, "
                . "'$current_bloodbank->bloodbank_short_name' bloodbank_short_name, "
                . "'$current_bloodbank->district' district, "
                . "'$current_bloodbank->latitude_n' lattitude, "
                . "'$current_bloodbank->longitude_e' longitude,"
                . "'$current_bloodbank->bloodbank_type' bloodbank_type,"
                . "'$current_bloodbank->bloodbank_subtype' bloodbank_subtype,"
                . "a_positive, a_positive_prp, a_positive_platelet_concentrate, a_positive_pc, a_positive_wb, a_positive_cryo, a_positive_fp, a_positive_ffp,"
                . "b_positive, b_positive_prp, b_positive_platelet_concentrate, b_positive_pc, b_positive_wb, b_positive_cryo, b_positive_fp, b_positive_ffp,"
                . "o_positive, o_positive_prp, o_positive_platelet_concentrate, o_positive_pc, o_positive_wb, o_positive_cryo, o_positive_fp, o_positive_ffp,"
                . "a_negative, a_negative_prp, a_negative_platelet_concentrate, a_negative_pc, a_negative_wb, a_negative_cryo, a_negative_fp, a_negative_ffp,"
                . "b_negative, b_negative_prp, b_negative_platelet_concentrate, b_negative_pc, b_negative_wb, b_negative_cryo, b_negative_fp, b_negative_ffp,"
                . "o_negative, o_negative_prp, o_negative_platelet_concentrate, o_negative_pc, o_negative_wb, o_negative_cryo, o_negative_fp, o_negative_ffp,"
                . "a_negative, a_negative_prp, a_negative_platelet_concentrate, a_negative_pc, a_negative_wb, a_negative_cryo, a_negative_fp, a_negative_ffp,"
                . "ab_positive, ab_positive_prp, ab_positive_platelet_concentrate, ab_positive_pc, ab_positive_wb, ab_positive_cryo, ab_positive_fp, ab_positive_ffp,"
                . "ab_negative, ab_negative_prp, ab_negative_platelet_concentrate, ab_negative_pc, ab_negative_wb, ab_negative_cryo, ab_negative_fp, ab_negative_ffp"
                ." FROM (
                SELECT MAX( last_modified_time ) last_modified_time
                FROM  bb_donation
                ) AS last_modified_time"
                ." CROSS JOIN (
                    SELECT COUNT(*) total_inventory
                    FROM bb_donation
                    JOIN
                    blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id
                    WHERE
                    blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1
                    AND blood_inventory.expiry_date >= '$today'
                ) AS total_inventory"
                ." CROSS JOIN("
                ." SELECT COUNT(*) a_positive,
                    SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) a_positive_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) a_positive_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) a_positive_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) a_positive_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) a_positive_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) a_positive_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) a_positive_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'A+') AS a_positive"
                ." CROSS JOIN("
                ." SELECT COUNT(*) b_positive,"
                . "SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) b_positive_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) b_positive_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) b_positive_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) b_positive_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) b_positive_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) b_positive_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) b_positive_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'B+') AS b_positive"
                ." CROSS JOIN("
                ." SELECT COUNT(*) o_positive,"
                . "SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) o_positive_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) o_positive_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) o_positive_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) o_positive_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) o_positive_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) o_positive_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) o_positive_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'O+') AS o_positive"
                ." CROSS JOIN("
                ." SELECT COUNT(*) a_negative,"
                . "SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) a_negative_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) a_negative_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) a_negative_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) a_negative_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) a_negative_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) a_negative_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) a_negative_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'A-') AS a_negative"
                ." CROSS JOIN("
                ." SELECT COUNT(*) b_negative,"
                . "SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) b_negative_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) b_negative_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) b_negative_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) b_negative_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) b_negative_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) b_negative_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) b_negative_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'B-') AS b_negative"
                ." CROSS JOIN("
                ." SELECT COUNT(*) o_negative,"
                . "SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) o_negative_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) o_negative_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) o_negative_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) o_negative_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) o_negative_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) o_negative_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) o_negative_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'O-') AS o_negative"
                ." CROSS JOIN("
                ." SELECT COUNT(*) ab_positive,"
                ." SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) ab_positive_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) ab_positive_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) ab_positive_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) ab_positive_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) ab_positive_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) ab_positive_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) ab_positive_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'AB+') AS ab_positive"
                . "CROSS JOIN("
                ." SELECT COUNT(*) ab_negative,"
                ." SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) ab_negative_prp,
                    SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) ab_negative_platelet_concentrate,
                    SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) ab_negative_pc,
                    SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) ab_negative_wb,
                    SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) ab_negative_cryo,
                    SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) ab_negative_fp,
                    SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) ab_negative_ffp"
                ." FROM bb_donation"
                ." JOIN blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id"
                ." JOIN blood_grouping ON blood_grouping.donation_id = bb_donation.donation_id"
                ." WHERE blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1"
                ." AND blood_inventory.expiry_date >= '$today' AND blood_grouping.blood_group = 'AB+') AS ab_negative");
            $bloodbanks_status[] = $query->row();
        }
        foreach($bloodbanks_status as $bloodbank_status){ 
            foreach($bloodbank_status as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value; 
            } 
        } 

        $orderby = "total_inventory"; //change this to whatever key you want from the array 

        array_multisort($sortArray[$orderby],SORT_DESC,$bloodbanks_status); 

        return $bloodbanks_status;
    }
}

?>