<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dependencia_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function consultarDependencias($id) {

        $db_generica = $this->load->database('bdgenerica', TRUE);
        $sql='SELECT d . * 
                FROM dependencia d
                JOIN piso_dependencia ps ON ps.dependencia = d.id
                JOIN piso p ON ps.piso = p.id
                AND p.institucion='.$id;
        $query=$db_generica->query($sql);
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $resultado[] = $row;
            }
            return $resultado;
            $query->free - result();
        }
    }
}// fin de la clase