<?php

class Application_model extends CI_Model {
    function __construct() {
        parent::__construct();        
    }
    
    function get_hospitals($hospital_type){  //Function that returns all the details of the bloodbanks.
        $filters = array();
        if($this->input->post('hospital_type')){
            $filters['hospital_type'] = $this->input->post('hospital_type');
        }else if($hospital_type){
            $filters['hospital_type'] = $hospital_type;
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
}
