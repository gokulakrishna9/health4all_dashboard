<?php

class Bloodbank_model extends CI_Model {
    function __construct() {
        parent::__construct();        
    }
    
    function get_bloodbanks($bank_type){  //Function that returns all the details of the bloodbanks.
        $filters = array();
        if($this->input->post('bank_type')){
            $filters['bloodbank_type'] = $this->input->post('bank_type');
        }else if($bank_type){
            $filters['bloodbank_type'] = $bank_type;
        }
        
        $this->db->select('*')
            ->from('bloodbank_information')
            ->where($filters);
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_bloodbank_types(){
        $this->db->select('*')
            ->from('bloodbank_type');
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_bloodbank_sub_types(){
        $this->db->select('*')
            ->from('bloodbank_subtypes');
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_update_time(){
        $dbdefault = $this->load->database('default',TRUE);
        $last_modified_time = array();
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
            $dbt->query("SELECT * FROM (
                    SELECT MAX( last_modified_time ) last_modified_time
                    FROM  `bb_donation`
                    ) AS A
                    CROSS JOIN (
                    SELECT COUNT( * ) total
                    FROM  `bb_donation` 
                    WHERE status_id >=3
                    ) AS B
            ");
            $dbt->select("MAX(last_modified_time), $r->bloodbank_id bloodbank_id, '$r->bloodbank_name' bloodbank_name", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1')
            ->where('blood_inventory.expiry_date >=', " $to_date");
            $query = $dbt->get();
            $last_modified_time[] = $query->result();
        }
        return $last_modified_time;
    }
    
    function get_bloodbank_status($long_period, $short_period){
        $far_date = date('Y-m-d', strtotime("-1*$long_period days"));
        $near_date = date('Y-m-d', strtotime("-1*$short_period days"));
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
            $query = $dbt->query("SELECT  last_modified_time, yesterdays_donations, total_inventory, "
                . "total_donors_long_period, expiring_inventory_short_period, '$current_bloodbank->bloodbank_id' bloodbank_id, "
                . "'$current_bloodbank->bloodbank_name' bloodbank_name, '$current_bloodbank->bloodbank_short_name' bloodbank_short_name, '$current_bloodbank->district' district, '$current_bloodbank->latitude_n' lattitude, '$current_bloodbank->longitude_e' longitude FROM (
                SELECT MAX( last_modified_time ) last_modified_time
                FROM  bb_donation
                ) AS last_modified_time
                CROSS JOIN (
                SELECT COUNT( * ) yesterdays_donations
                FROM  bb_donation
                WHERE status_id =3
                ) AS yesterdays_donations
                CROSS JOIN (
                SELECT COUNT( * ) total_donors_long_period
                FROM  bb_donation
                WHERE status_id >=3
                AND (donation_date >= date(now() - interval $long_period day))
                ) AS total_donors_long_period
                CROSS JOIN (
                    SELECT COUNT(*) total_inventory
                    FROM bb_donation
                    JOIN
                    blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id
                    WHERE
                    blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1
                    AND blood_inventory.expiry_date >= '$today'
                ) AS total_inventory                
                CROSS JOIN(
                    SELECT COUNT(*) expiring_inventory_short_period
                    FROM bb_donation
                    JOIN 
                    blood_inventory ON blood_inventory.donation_id = bb_donation.donation_id 
                    WHERE 
                    blood_inventory.status_id = 7 AND bb_donation.status_id = 6 AND bb_donation.screening_result=1
                    AND (blood_inventory.expiry_date = date(now() - interval $short_period day))
                ) AS expiring_inventory_short_period");            
            
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

        array_multisort($sortArray[$orderby], SORT_DESC, $bloodbanks_status); 

        return $bloodbanks_status;
    }
}
