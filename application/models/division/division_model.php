<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Division_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function cargarDivision() {

        $query = $this->db->query("SELECT * 
                                 FROM bdgenerica.division ");
        $resultado = array();
        $resultdb = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }
     public function cargarDivisiones($dependencia) {

        $query = $this->db->query("SELECT * 
                                 FROM bdgenerica.division where dependencia=$dependencia ");
        $resultado = array();
        $resultdb = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }
}// fin de la clase