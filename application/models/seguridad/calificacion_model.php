<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calificacion_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    function findCalificacion() {


        $query = $this->db->get("calificacion");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {

            return FALSE;
        }
    }

    function insertCalificacion($data) {

        return $this->db->insert('calificacion', $data);
    }

    function deleteCalificacion() {

        return $this->db->query("DELETE FROM calificacion");
    }

    function findRango($valor) {

        $query = $this->db->query("SELECT descripcion 
                                    FROM  `calificacion` 
                                    WHERE $valor >= desde
                                    AND $valor <= hasta");
        if ($query->num_rows() > 0) {
            return $query;  
        } else {

            return FALSE;
        }
    }

}
