<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reincidencia_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function cargarListaReincidencia($id) {

        $query = $this->db->query("SELECT reincidencia.id AS idRein,
                                          reincidencia.evento AS idEv,
                                       
                                        reincidencia.descripcion AS descripcion, 
                                        reincidencia.fecha AS fecha,
                                        anexo.direccion as anexo,
                                        anexo.tipoarchivo as extension
                                  FROM reincidencia left join anexo on reincidencia.id =anexo.reincidencia
                                 WHERE reincidencia.evento=$id and reincidencia.estatus=1
                                 ");
       
            return $query;
            
       }

 
      public function  guardarReincidencia($data){         
         
          
          $this->db->insert('reincidencia',$data);
        return  $this->db->insert_id();
    }
           
    public function  actualizarReincidencia($data){         
         $this->db->set($data);
         $this->db->where('id',$data['id']);
         return  $this->db->update('reincidencia');
    }
    
     public function  eliminarReincidencia($data){         
         $this->db->set('estatus',$data['estatus']);
         $this->db->where('id',$data['id']);
         return  $this->db->update('reincidencia');
    }

       public function  buscarReincidencia($id){         
            $query = $this->db->query("select count(*) as cuantos

                                    from prevengo.reincidencia 
                                    
                                    where  prevengo.reincidencia.evento=$id and 					 												   
                                           prevengo.reincidencia.estatus=1
                                 ");
       
            return $query; 
    }

}// fin de la clase
