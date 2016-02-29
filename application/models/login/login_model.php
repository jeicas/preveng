<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Login_model extends CI_Model {

  public function __construct(){
        parent::__construct();
       
    }
  function verificasession($usu, $password) {
    $db_generica = $this->load->database('bdgenerica', TRUE);
    $db_generica->select('usuario');
    $db_generica->where('usuario', $usu);
     $db_generica->where('clave', $password);
    $resultado=  $db_generica->get('usuario');
    return $resultado;
  }
  function verificaUsuario($usuario, $contrasena) {
     /*$db_generica = $this->load->database('bdgenerica', TRUE);
     $db_generica->select('id, usuario,cedula,nacionalidad');
     $db_generica->where('usuario', $usuario);
     $db_generica->where('clave', $contrasena);
     $db_generica->where('estatus', 1);
     $db_generica->limit(1);
    $query =  $db_generica->get('usuario');*/
      $sql="SELECT u.id, u.usuario, u.cedula, u.nacionalidad, 
                   tu.nombre as tipou, concat(p.nombre,' ', p.apellido) as nombre, e.ente as ente 
                  FROM bdgenerica.usuario u  INNER JOIN bdgenerica.tipousuario tu on u.tipousuario=tu.id
                  INNER JOIN bdgenerica.persona p on p.cedula=u.cedula
                  INNER JOIN bdgenerica.empleado e on e.cedula=u.cedula 
                  WHERE u.usuario='".$usuario."' AND clave='".$contrasena."' and u.estatus=1 LIMIT 1";
    
      $query = $this->db->query($sql);
      return $query;
  }
}
