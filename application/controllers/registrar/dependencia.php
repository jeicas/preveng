<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dependencia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('dependencia/dependencia_model');
       
    }

    public function buscarDependencia() {
        $institucion= 1;
        $resultdbd = array();
        if ($resultdbd = $this->dependencia_model->consultarDependencias($institucion)) {
            $output = array(
                'success' => true,
                'total' => count($resultdbd),
                'data' => array_splice($resultdbd, $this->input->get("start"), $this->input->get("limit"))
            );
            echo json_encode($output);
        }
        
    }

    
}
