<?php

class Hospital extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('hospital_model');
    }
    
    function get_patients_summary_by_hospital(){
        $patients_summary_by_hospital = $this->hospital_model->get_ip_op_summary_by_hospital(30, 0);
        echo json_encode($patients_summary_by_hospital);
    }
    
    function get_hospitals(){
        $hospital_details = $this->hospital_model->get_hospitals();
        echo json_encode($hospital_details);
    }
    
    function get_lab_summary_by_hospital(){
        $lab_summary = $this->hospital_model->get_lab_summary_by_hospital();
        echo json_encode($lab_summary);
    }
    
    function get_test_areas(){
        $test_areas = $this->hospital_model->get_test_areas();
        echo json_encode($test_areas);
    }
    
    function get_bloodbanks(){
        echo json_encode('0');
    }
    
    function get_patients_by_department(){
        $patients_by_department = $this->hospital_model->get_patients_by_department();
        echo json_encode($patients_by_department);
    }
}

?>