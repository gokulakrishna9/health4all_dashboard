<?php

class Donor_model extends CI_Model{
    function __construct() {
        parent::__construct();        
    }
    
    function get_donations_for($days){        
        $total_donations = 0;
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
            $dbt->select("COUNT(*) total_donations", false)
            ->from('bb_donation')
            ->where('bb_donation.status_id > 3')
            ->where("(donation_date >= date(now() - interval $days day))");
            $query=$dbt->get();
            $result = $query->row();
            $total_donations += $result->total_donations;
        }
        return $total_donations;
    }
    
    //Later
    function get_donor_registrations_mobile_app($days){
        $dbdefault = $this->load->database('default',TRUE);
        $from_date = date('Y-m-d', strtotime("-1*$days days"));
        $to_date = date("Y-m-d");
        $total_donations = 0;
        $this->db->select('bloodbank_id')
            ->from('bloodbanks');
        $query=$this->db->get();
        $result = $query->result();
        
        return $total_donations;
    }
    
    function get_donor_registrations($days){
        $dbdefault = $this->load->database('default',TRUE);
        $from_date = date('Y-m-d', strtotime("-1*$days days"));
        $to_date = date("Y-m-d");
        $total_donors = 0;
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
            $dbt->select("COUNT(*) total_donors", false)
                ->from('blood_donor')
                ->join('bb_donation','bb_donation.donor_id = blood_donor.donor_id')
                ->where("(bb_donation.donation_date >= date(now() - interval $days day))");
            $query=$dbt->get();
            $result = $query->row();
            $total_donors += $result->total_donors;
        }
        return $total_donors;
    }
    
    function get_collections_by_bank($days){
        $dbdefault = $this->load->database('default',TRUE);
        $from_date = date('Y-m-d', strtotime("-1*$days days"));
        $to_date = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $collections_by_banks = array();
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
            $dbt->select("COUNT(*) total_collections, MAX(last_modified_time), $r->bloodbank_id bloodbank_id, '$r->bloodbank_name' bloodbank_name", false)
            ->from('bb_donation')
            ->join('blood_inventory','blood_inventory.donation_id = bb_donation.donation_id')
            ->where('blood_inventory.status_id >= 3')
            ->where("(bb_donation.donation_date BETWEEN '$from_date' AND '$to_date')");
            $query = $dbt->get();
            $collections_by_banks[] = $query->result();
        }
        return $collections_by_banks;
    }
}

?>
