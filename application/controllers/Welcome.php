<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_header');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_top_left_navbars');
        $this->load->view('application_pages/dashboard_pages/dashboard_home');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_footer');
    }
    
    function hospital_login(){
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_header');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_top_left_navbars');
        $this->load->view('application_pages/hospital_pages/hospitals_home');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_footer');
    }
    
    function hosptial_charts(){
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_header');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_top_left_navbars');
        $this->load->view('application_pages/hospital_pages/hospital_summary_charts');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_footer');
    }
    
    function get_patients_per_department(){
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_header');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_top_left_navbars');
        $this->load->view('application_pages/hospital_pages/patients_by_department_summary');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_footer');
    }
    
    function get_department_charts(){
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_header');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_top_left_navbars');
        $this->load->view('application_pages/hospital_pages/department_reports');
        $this->load->view('application_pages/navbars_headers_footers/dashboard_home_footer');
    }
}
