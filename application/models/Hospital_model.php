<?php

class Hospital_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_hospitals(){  //Function that returns all the details of the hospitals.
        $filters = array();
        if($this->input->post('hospital_type')){
            $filters['hospital_type'] = $this->input->post('hospital_type');
        }
        $this->db->select('*')
            ->from('hospital_information')
            ->where($filters);
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_hospital_types(){
        $this->db->select('*')
            ->from('hospital_type');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_hospital_sub_types(){
        $this->db->select('*')
            ->from('hospital_subtypes');
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    /*
    function get_ip_op_summary_by_hospital($long_period, $short_period){
        //Set short_period to zero for today.        
        $today = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $hospitals_status = array();
        $this->db->select('hospital_id, host_name,username,database_name,database_password')
        ->from('hospitals');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('hospital_information.*')
            ->from('hospital_information')
            ->where('hospital_information.hospital_id',"$r->hospital_id");
            $query2 = $this->db->get();

            $current_hospital = $query2->result();
            if(sizeof($current_hospital) == 0){
                continue;
            }
            $current_hospital = $current_hospital[0];
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysqli';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $query = $dbt->query("SELECT  total_ip_registrations_long_period, total_op_registrations_long_period,"
                . "total_ip_registrations_short_period, total_op_registrations_short_period,"
                . "'$current_hospital->hospital_id' hospital_id, "
                . "'$current_hospital->hospital_name' hospital_name, '$current_hospital->hospital_short_name' hospital_short_name, '$current_hospital->district' district, '$current_hospital->latitude_n' lattitude, '$current_hospital->longitude_e' longitude,"
                ."repeat_op.repeat_visits_op, total_op_registrations_short_period - repeat_visits_op AS new_op_visits"   
                ." FROM (
                SELECT COUNT( * ) total_ip_registrations_long_period
                    FROM  patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'IP'
                ) AS total_ip_registrations_long_period
                CROSS JOIN (
                SELECT COUNT( * ) total_op_registrations_long_period
                    FROM  patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'OP'
                ) AS total_op_registrations_long_period
                CROSS JOIN(
                    SELECT COUNT(*) total_ip_registrations_short_period
                    FROM patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'IP'
                ) AS total_ip_registrations_short_period "  
                . "CROSS JOIN(
                    SELECT COUNT(*) total_op_registrations_short_period
                    FROM patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'OP'
                ) AS total_op_registrations_short_period"
                ."CROSS JOIN(SELECT COUNT(*) repeat_visits_op
                    FROM (
                        SELECT patient_id
                        FROM patient_visit
                        WHERE admit_date = CURDATE( ) AND visit_type LIKE  'OP'
                        )pv1
                    INNER JOIN (
                        SELECT patient_id
                        FROM patient_visit
                        WHERE admit_date != CURDATE( ) AND visit_type LIKE  'OP'
                )pv2 ON pv2.patient_id = pv1.patient_id) AS repeat_op");
            $hospitals_status[] = $query->row();
        }
        
        foreach($hospitals_status as $hospital_status){ 
            foreach($hospital_status as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value; 
            } 
        } 

        $orderby = "total_op_registrations_short_period"; //change this to whatever key you want from the array 

        array_multisort($sortArray[$orderby], SORT_DESC, $hospitals_status);
        
        return $hospitals_status;
    }
    
    */
    
    function get_ip_op_summary_by_hospital($long_period, $short_period){
        $test=1;
        //Set short_period to zero for today.        
        $today = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $hospitals_status = array();
        $this->db->select('hospital_id, host_name,username,database_name,database_password')
        ->from('hospitals');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('hospital_information.*')
            ->from('hospital_information')
            ->where('hospital_information.hospital_id',"$r->hospital_id");
            $query2 = $this->db->get();

            $current_hospital = $query2->result();
            if(sizeof($current_hospital) == 0){
                continue;
            }
            $current_hospital = $current_hospital[0];
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
            $dbt->select("SUM(CASE WHEN visit_type = 'IP' THEN 1 ELSE 0 END) total_ip_registrations_short_period,"
                . "SUM(CASE WHEN visit_type = 'OP' THEN 1 ELSE 0 END) total_op_registrations_short_period,"
                . "SUM(CASE WHEN visit_type = 'OP' AND patient_id IN (SELECT patient_id FROM patient_visit WHERE admit_date<'$today' AND visit_type='OP') THEN 1 ELSE 0 END) repeat_visits_op,"
                . "'$current_hospital->hospital_id' hospital_id, "
                . "hospital.hospital hospital_short_name,"
                . "'$current_hospital->district' district, '$current_hospital->latitude_n' lattitude, '$current_hospital->longitude_e' longitude")
                ->from('hospital')
                ->join('patient_visit','patient_visit.hospital_id = hospital.hospital_id', 'left')
                ->where('patient_visit.admit_date', "$today")
                ->group_by('hospital.hospital_id');
            $query = $dbt->get();
            if($query->num_rows()>0)
                $hospitals_status[] = $query->result();
        }
        
        $flattened_array = array();
        foreach($hospitals_status as $hospital_status){
            foreach($hospital_status as $record){
                $flattened_array[] = $record;
            }
        }
        
        foreach($flattened_array as $hospital_status){ 
                foreach($hospital_status as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value;
            }
        } 

        $orderby = "total_op_registrations_short_period"; //change this to whatever key you want from the array 

        array_multisort($sortArray[$orderby], SORT_DESC, $flattened_array);
        
        
        
        return $flattened_array;
    }
    
    
    function get_lab_summary_by_hospital(){
        if($this->input->post('from_date') && $this->input->post('to_date')){
            $from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
            $to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
        }
        else if($this->input->post('from_date') || $this->input->post('to_date')){
            if($this->input->post('from_date')){
                $from_date = $this->input->post('from_date');
                $to_date = date("Y-m-d");                    
            }else{
                $to_date = $this->input->post('to_date');
                $from_date = date( "Y-m-d", strtotime( date($this->input->post('to_date'))) . "-1 month" );
            }
        }
        else{
            $from_date=date("Y-m-d");
            $to_date=$from_date;
        }
        $this->db->select('hospital_id,hospital_name,host_name,username,database_name,database_password')
        ->from('hospitals');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('hospital_information.*')
            ->from('hospital_information')
            ->where('hospital_information.hospital_id',"$r->hospital_id");
            $query2 = $this->db->get();

            $current_hospital = $query2->result();
            if(sizeof($current_hospital) == 0){
                continue;
            }
            $current_hospital = $current_hospital[0];
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
            
            $dbt->select("$current_hospital->hospital_id hospital_id, '$current_hospital->hospital_name' hospital_name, '$current_hospital->hospital_short_name' hospital_short_name,
            COUNT(DISTINCT test.test_id) tests,
            test_area.test_area_id, test_area.test_area",false)
            ->from('test')
            ->join('test_master','test.test_master_id = test_master.test_master_id')
            ->join('test_order','test.order_id = test_order.order_id')
            ->join('test_area','test_area.test_area_id=test_order.test_area_id','left')
            ->where('test.test_status',2)                                       //Getting only tests approved.
            ->where("(DATE(test_order.order_date_time) BETWEEN '$from_date' AND '$to_date')")
            ->group_by('test_area.test_area_id');
            $query=$dbt->get();
            $results = $query->result();
            if ($query->num_rows() > 0)
            {
                foreach($results as $result){
                    $dashboard[] = $result;
                }
            }else{
                $dashboard[] = (object) array(
                    'hospital_id' => $r->hospital_id,
                    'hospital_name' => $r->hospital_name,
                    'tests' => '0',
                    'test_area_id' => 'Unset',
                    'test_area' => 'Unset'
                );
            }
        }
        
        return $dashboard;
    }
	
    function get_test_areas(){
        $this->db->select('test_area')
        ->from('test_areas');
        $query=$this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_patients_by_department(){
        $filter =  $this->security->xss_clean($this->input->raw_input_stream);
        $filter = (array)json_decode($this->security->xss_clean($filter));
        
        if(key_exists('from_date', $filter) && key_exists('to_date', $filter)){
            $from_date=date("Y-m-d",strtotime($filter['from_date']));
            $to_date=date("Y-m-d",strtotime($filter['to_date']));
        }
        else if(key_exists('from_date', $filter) || key_exists('to_date', $filter)){
            if(key_exists('from_date', $filter)){
                $from_date = date("Y-m-d",strtotime($filter['from_date']));
                $to_date = date("Y-m-d");
            }else{
                $to_date = $filter['to_date'];
                $from_date = date( "Y-m-d", strtotime( date($filter['to_date'])) . "-1 month" );
            }
        }
        else{
            $from_date=date("Y-m-d");
            $to_date=$from_date;
        }
        $today = date("Y-m-d");
        $this->db->select('hospital_id,hospital_name,host_name,username,database_name,database_password')
        ->from('hospitals');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('hospital_information.*')
            ->from('hospital_information')
            ->where('hospital_information.hospital_id',"$r->hospital_id");
            $query2 = $this->db->get();

            $current_hospital = $query2->result();
            if(sizeof($current_hospital) == 0){
                continue;
            }
            $current_hospital = $current_hospital[0];
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
            
            $dbt->select("$current_hospital->hospital_id hospital_id, hospital.hospital hospital_name, "
                . "SUM(CASE WHEN visit_type = 'IP' THEN 1 ELSE 0 END) department_visits_ip_total,"
                . "SUM(CASE WHEN visit_type = 'OP' THEN 1 ELSE 0 END) department_visits_op_total,"
                . "SUM(CASE WHEN visit_type = 'OP' AND patient_id IN (SELECT patient_id FROM patient_visit WHERE admit_date<'$today' AND visit_type='OP') THEN 1 ELSE 0 END) department_visits_repeat_op,"
                . "COUNT(DISTINCT patient_visit.visit_id) department_visits, patient_visit.department_id, department.department",false)
            ->from('patient_visit')
            ->join('department','department.department_id = patient_visit.department_id', 'left')
            ->join('hospital','department.hospital_id = hospital.hospital_id', 'left')
            ->where("patient_visit.admit_date BETWEEN '$from_date' AND '$to_date'")
            ->group_by('patient_visit.department_id')
            ->group_by('hospital.hospital_id');
            $query=$dbt->get();
            $results = $query->result();
            
            if ($query->num_rows() > 0)
            {
                foreach($results as $result){
                    $dashboard[] = $result;
                }
            }else{
                $dashboard[] = (object) array(
                    'hospital_id' => $r->hospital_id,
                    'hospital_name' => $r->hospital_name,
                    'department' => 'No record',
                    'department_id' => '-1',
                    'department_visits' => '0'
                );
            }
        }
        
        foreach($dashboard as $record){ 
            foreach($record as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value; 
            } 
        } 

        $orderby = "department_visits"; //change this to whatever key you want from the array 

        array_multisort($sortArray[$orderby], SORT_DESC, $dashboard);
        
        return $dashboard;
    }
}
