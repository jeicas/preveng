<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TipoEvento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function cargarTipoEvento() {

        $query = $this->db->query("SELECT * 
                                 FROM tipoevento where estatus=1");
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
    
        public function guardarTipoEvento($data){
        return $this->db->insert('tipoevento',$data);
      }
       public function  actualizarTipoEvento($data){         
         $this->db->set($data);
         $this->db->where('id',$data['id']);
         return  $this->db->update('tipoevento');
    } 
    
     public function contarTiposEventos(){
           $query = $this->db->query("SELECT *  FROM `tipoevento` where estatus=1");
        return $query;
    }

}// fin de la clase