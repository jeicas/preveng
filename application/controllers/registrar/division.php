<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Division extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('division/division_model');
        
    }
    
 public function buscarDivision() {
        $dependencia= $this->input->get('dependencia');
        $resultdbd = array();
        if ($resultdbd = $this->division_model->cargarDivisiones($dependencia)) {
            $output = array(
                'success' => true,
                'total' => count($resultdbd),
                'data' => array_splice($resultdbd, $this->input->get("start"), $this->input->get("limit"))
            );
            echo json_encode($output);
        }
        
    }

}
