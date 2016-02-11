<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Institucion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function consultarInstitucion() {

        $db_generica = $this->load->database('bdgenerica', TRUE);
        $sql='SELECT * FROM institucion';
        $query=$db_generica->query($sql);
         $resultado=array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }
}// fin de la clase