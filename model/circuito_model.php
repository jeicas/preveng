<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Circuito_model extends CI_Model {

    function __construct() {
        $this->load->database();
        date_default_timezone_set('America/Caracas');
    }
  public function verificartipousuario() {
            $query = $this->db->query("SELECT 
          u.id as us,                
          u.tipousuario as tipo,
          p.id_parroquia parroquia,
          m.id_municipio as municipio
          FROM usuario u
            LEFT JOIN distribucion d on d.usuario=u.id 
            LEFT JOIN centro_votacion on d.centrovotacion=centro_votacion.id
            LEFT JOIN parroquia p on centro_votacion.parroquia=p.id_parroquia
            LEFT JOIN municipio m on p.id_municipio=m.id_municipio
            LEFT JOIN tipousuario tu on tu.id=u.tipousuario");
        return $query;
    }
    
    
    public function verificarcircuito($tipo) {
        $query = $this->db->query("SELECT c.id as id,
                                     persona.email as correo, 
                                     c.nombre as nombre, 
                                     persona.email, persona.nombre as nombrecord,
                                     persona.apellido 
                                   FROM `circuito`,persona,usuario 
                                    INNER JOIN distribucion d on usuario.id=d.usuario and usuario.id=$tipo
                                    INNER JOIN centro_votacion cv on cv.id=d.centrovotacion
                                    INNER JOIN circuito c on cv.circuito=c.id
                                    WHERE  persona.cedula=usuario.cedula
                                   GROUP BY nombre");
        return $query;
    }
    
       
    public function verificarcircuitousuario($tipo) {
        $query = $this->db->query("SELECT c.id as id,
                                     persona.email as correo, 
                                     c.nombre as nombre, 
                                     persona.email, persona.nombre as nombrecord,
                                     persona.apellido 
                                   FROM `circuito`,persona,usuario 
                                    INNER JOIN distribucion d on usuario.id=d.usuario and usuario.id=$tipo
                                    INNER JOIN centro_votacion cv on cv.id=d.centrovotacion
                                    INNER JOIN circuito c on cv.circuito=c.id
                                    WHERE  persona.cedula=usuario.cedula
                                   GROUP BY nombre");
        return $query;
    }

        public function verificardatos() {
        $query = $this->db->query("SELECT persona.email as correo,
                                          persona.email,persona.nombre as nombrecord,
                                          persona.apellido 
                                   FROM persona,usuario
                                   WHERE  persona.cedula=usuario.cedula AND usuario.tipousuario=2");
        return $query;
    }
    
    
    public function verificartotalcircuito($idcircuito) {
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidad,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito ");
        return $query;
    }

    public function verificartotalmunicipio($idcircuito, $idmunicipio) {
       $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
	INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1	
        inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
        inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio 
        where planilla.fecha='".$fecha."'");
        return $query;
    }
    
       public function verificartotalmunicipioTodas($idcircuito, $idmunicipio) {
       
        $query = $this->db->query("SELECT count(planilla.cedula) as todoMun,municipio.nombre as municipio,centro_votacion.circuito from planilla
		INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
                inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio 
        ");
         
        return $query;
    }
    
    
       public function verificartotalVisitasCircuito($idcircuito) {
        $fecha=date('Y-m-d', strtotime('-1 day'));
     
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio
        where  planilla.fecha='".$fecha."'");
        return $query;
    }
    
    
     public function verificartotalVisitas() {
     $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadtotal from planilla
	INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
	
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id 
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio
        where  planilla.fecha='".$fecha."'");
        return $query;
    }
    
    
    
         public function verificartotalVisitasTotal($idcicuito) {
       
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadtotal from planilla
	INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
	
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcicuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio
        ");
        return $query;
    }
    
    
    public function verificarmunicipio($idcircuito) {
        $query = $this->db->query("SELECT municipio.nombre as municipio,municipio.id_municipio as idmunicipio from parroquia
		 inner join municipio  on parroquia.id_municipio=municipio.id_municipio
        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia
  		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito group by municipio.nombre ");
        return $query;
    }
    public function verificarmunicipiocircuito($idcircuito,$idmun) {
        $query = $this->db->query("SELECT municipio.nombre as municipio,municipio.id_municipio as idmunicipio from parroquia
		 inner join municipio  on parroquia.id_municipio=municipio.id_municipio and municipio.id_municipio=$idmun
        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia
  		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito group by municipio.nombre ");
        return $query;
    }
    public function verificarparroquia($idmunicipio,$idcircuito) {
        //$query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia from parroquia where parroquia.id_municipio=$idmunicipio");
       
         $query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia 
                        from parroquia
                        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia and centro_votacion.circuito=$idcircuito
                        where parroquia.id_municipio=$idmunicipio
                       group by parroquia");
        
        return $query;
    }
    public function verificarparroquiaMun($idmunicipio) {
        //$query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia from parroquia where parroquia.id_municipio=$idmunicipio");
       
         $query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia 
                        from parroquia
                        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia 
                        inner join 
                        where parroquia.id_municipio=$idmunicipio
                       group by parroquia");
        
        return $query;
    }
    public function verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         */
      $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,
                                   municipio.nombre as municipio,
                                   centro_votacion.circuito, 
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from planilla
                INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
        INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			

		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio
        inner join meta_parroquia on parroquia.id_parroquia=meta_parroquia.parroquia
        where  planilla.fecha='".$fecha."'");
        return $query;
    }
    
       public function verificartotalparroquiatodas($idcircuito, $idmunicipio, $idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         */
        
        $query = $this->db->query("SELECT count(planilla.cedula) as todosParr,
                                   municipio.nombre as municipio,
                                   centro_votacion.circuito, 
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from planilla
                INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
                INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio
        inner join meta_parroquia on parroquia.id_parroquia=meta_parroquia.parroquia
         ");
           
           
            //$query = $this->db->query("SELECT * FROM `planilla` where centrovotacion like '$idparroquia%'");
        return $query;
    }
    
      public function verificarmetaparroquia($idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         */
        
        $query = $this->db->query("SELECT  
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from meta_parroquia
        where meta_parroquia.parroquia=$idparroquia");
        return $query;
    }
    
     public function verificartotalmunicipicontac($idcircuito,$idmunicipio){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total, meta_parroquia.total_contacto AS totalmetas
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio and  municipio.id_municipio=$idmunicipio 
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito
    )Tabla");return $query;
      //nuevooooooo
    }
    
    public function verificartotalcirucitometa($idcircuito){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito
    )Tabla");return $query;
      //nuevooooooo
    }
    
    
    //Nuevo
    
    
       public function verificartotalmeta(){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    )Tabla");return $query;
      //nuevooooooo
    }
    
    
    
    
    
    public function verificartotalmunicipi($idcircuito, $idmunicipio) {
      $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
                                      INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
                                      INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
                                      INNER JOIN centro_votacion on centro_votacion.id=planilla.centrovotacion
		                      INNER JOIN circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                                      INNER JOIN parroquia on centro_votacion.parroquia=parroquia.id_parroquia
                                      INNER JOIN municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio 
                                  WHERE planilla.fecha='".$fecha."'");
        return $query;
    }
    
     public function verificartotalVisitasCircuitoMunicipio($idcircuito, $idmunicipio) {
        $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
                                   INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
                                   INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
                                   INNER JOIN centro_votacion on centro_votacion.id=planilla.centrovotacion
		                   INNER JOIN circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                                   INNER JOIN parroquia on centro_votacion.parroquia=parroquia.id_parroquia
                                   INNER JOIN municipio on parroquia.id_municipio=municipio.id_municipio and municipio.id_municipio=$idmunicipio
                                   WHERE  planilla.fecha='".$fecha."'");
        return $query;
    }
    
          public function verificartotalmunicipiometa($idcircuito,$idmunicipio){
             
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito  AND municipio.id_municipio =$idmunicipio
    )Tabla");
         
      return $query;
      //nuevooooooo
    }

              public function verificartotalmunicipiometatotal($idcircuito,$idmunicipio){
             
      $query = $this->db->query("SELECT SUM(total) as totalmetamun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.total_contacto AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito  AND municipio.id_municipio =$idmunicipio
    )Tabla");
         
      return $query;
      //nuevooooooo
    }
    
    
    
    //parroquia
    
       public function verificartotalVisitasCircuitoParroquia($idcircuito, $idmunicipio, $idparroquia) {
       $fecha=date('Y-m-d', strtotime('-1 day'));
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparr,parroquia.nombre as parroquia,centro_votacion.circuito from planilla
                                    INNER JOIN tipocompromiso ON planilla.tipocompromiso = tipocompromiso.id
                                    INNER JOIN tipoplanilla ON tipocompromiso.tipoplanilla = tipoplanilla.id AND tipoplanilla.id =1			
                                    INNER JOIN centro_votacion on centro_votacion.id=planilla.centrovotacion
		                    INNER JOIN circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                                    INNER JOIN parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
                                    INNER JOIN municipio on parroquia.id_municipio=municipio.id_municipio and municipio.id_municipio=$idmunicipio
                                   WHERE planilla.fecha='".$fecha."'");
        return $query;
    }
}

/*
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Circuito_model extends CI_Model {

    function __construct() {
        $this->load->database();
        date_default_timezone_set('America/Caracas');
    }

    public function verificartipousuario() {
        $query = $this->db->query("SELECT u.tipousuario as id,
      p.id_parroquia parroquia,
      m.id_municipio as municipio
      FROM distribucion d
   
      INNER JOIN usuario u on d.usuario=u.id 
      INNER JOIN centro_votacion on d.centrovotacion=centro_votacion.id
      INNER JOIN parroquia p on centro_votacion.parroquia=p.id_parroquia
      INNER JOIN municipio m on p.id_municipio=m.id_municipio
      INNER JOIN tipousuario tu on tu.id=u.id ");
        return $query;
    }
    
    
    public function verificarcircuito() {
        $query = $this->db->query("SELECT circuito.id as id,persona.email as correo,circuito.nombre as nombre,persona.email,persona.nombre as nombrecord,persona.apellido FROM `circuito`,persona,usuario WHERE usuario.circuito=circuito.id and persona.cedula=usuario.cedula ");
        return $query;
    }

    public function verificartotalcircuito($idcircuito) {
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidad,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito ");
        return $query;
    }

    public function verificartotalmunicipi($idcircuito, $idmunicipio) {
        $fecha=date('Y-m-d');
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio 
        where planilla.tipoplanilla=1 and planilla.fecha_registro='".$fecha."'");
        return $query;
    }
    
       public function verificartotalmunicipioTodas($idcircuito, $idmunicipio) {
       
        $query = $this->db->query("SELECT count(planilla.cedula) as todoMun,municipio.nombre as municipio,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio 
        where planilla.tipoplanilla=1 ");
        return $query;
    }
    
    
       public function verificartotalVisitasCircuito($idcircuito) {
        $fecha=date('Y-m-d');
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio
        where planilla.tipoplanilla=1 and planilla.fecha_registro='".$fecha."'");
        return $query;
    }
    
    
      public function verificartotalVisitasCircuitoMunicipio($idcircuito, $idmunicipio) {
        $fecha=date('Y-m-d');
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadmuni,municipio.nombre as municipio,centro_votacion.circuito from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
        inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and municipio.id_municipio=$idmunicipio
        where planilla.tipoplanilla=1 and planilla.fecha_registro='".$fecha."'");
        return $query;
    }
    
    
    public function verificarmunicipio($idcircuito) {
        $query = $this->db->query("SELECT municipio.nombre as municipio,municipio.id_municipio as idmunicipio from parroquia
		 inner join municipio  on parroquia.id_municipio=municipio.id_municipio
        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia
  		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito group by municipio.nombre ");
        return $query;
    }

    public function verificarparroquia($idmunicipio,$idcircuito) {
        //$query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia from parroquia where parroquia.id_municipio=$idmunicipio");
       
         $query = $this->db->query("SELECT parroquia.nombre as parroquia,parroquia.id_parroquia as idparroquia 
                        from parroquia
                        inner join centro_votacion on centro_votacion.parroquia=parroquia.id_parroquia and centro_votacion.circuito=$idcircuito
                        where parroquia.id_municipio=$idmunicipio
                       group by parroquia");
        
        return $query;
    }

    public function verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         
        $fecha=date('Y-m-d');
        $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,
                                   municipio.nombre as municipio,
                                   centro_votacion.circuito, 
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio
        inner join meta_parroquia on parroquia.id_parroquia=meta_parroquia.parroquia
        where planilla.tipoplanilla=1 and planilla.fecha_registro='".$fecha."'");
        return $query;
    }
    
       public function verificartotalparroquiatodas($idcircuito, $idmunicipio, $idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         
        
        $query = $this->db->query("SELECT count(planilla.cedula) as todosParr,
                                   municipio.nombre as municipio,
                                   centro_votacion.circuito, 
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from planilla
		inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
		inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
                inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
        inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio
        inner join meta_parroquia on parroquia.id_parroquia=meta_parroquia.parroquia
        where planilla.tipoplanilla=1 ");
        return $query;
    }
    
      public function verificarmetaparroquia($idparroquia) {
        /* $query = $this->db->query("SELECT count(planilla.cedula) as cantidadparri,municipio.nombre as municipio,centro_votacion.circuito from planilla
          inner join centro_votacion on centro_votacion.id=planilla.centrovotacion
          inner join circuito on centro_votacion.circuito=circuito.id and circuito.id=$idcircuito
          inner join parroquia on centro_votacion.parroquia=parroquia.id_parroquia and parroquia.id_parroquia=$idparroquia
          inner join municipio on parroquia.id_municipio=municipio.id_municipio and  municipio.id_municipio=$idmunicipio ");
         
        
        $query = $this->db->query("SELECT  
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from meta_parroquia
        where meta_parroquia.parroquia=$idparroquia");
        return $query;
    }
    
    
    
       public function verificartotalmunicipio($idcircuito, $idmunicipio) {      
        $query = $this->db->query("SELECT  
                                   meta_parroquia.meta_diaria,  
                                   meta_parroquia.total_contacto 
                from meta_parroquia
        where meta_parroquia.parroquia=$idparroquia");
        return $query;
    }
    
     public function verificartotalmunicipicontac($idcircuito,$idmunicipio){
      $query = $this->db->query("SELECT SUM(total) as totalcontmunplan FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio and  municipio.id_municipio=$idmunicipio 
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito
    )Tabla");return $query;
      //nuevooooooo
    }
    
    
         public function verificartotalparroquiacontac($idcircuito,$idmunicipio,$idparroquia){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio and  municipio.id_municipio=$idmunicipio 
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito AND municipio.id_municipio =$idmunicipio AND parroquia.id_parroquia =$idparroquia
    )Tabla");return $query;
      //nuevooooooo
    }
    
    public function verificartotalcirucitometa($idcircuito){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito
    )Tabla");return $query;
      //nuevooooooo
    }
    
    
       public function verificartotalmunicipiometa($idcircuito,$idmunicipio){
      $query = $this->db->query("SELECT SUM(total) as totalcontmun FROM (SELECT DISTINCT (
    meta_parroquia.parroquia
    ) AS parroquia, meta_parroquia.meta_diaria AS total
    FROM meta_parroquia
    INNER JOIN parroquia ON parroquia.id_parroquia = meta_parroquia.parroquia
    INNER JOIN centro_votacion ON centro_votacion.parroquia = meta_parroquia.parroquia
    AND centro_votacion.parroquia = parroquia.id_parroquia
    INNER JOIN municipio ON municipio.id_municipio = parroquia.id_municipio
    INNER JOIN circuito ON centro_votacion.circuito = circuito.id
    AND circuito.id =$idcircuito  AND municipio.id_municipio =$idmunicipio
    )Tabla");return $query;
      //nuevooooooo
    }
    
     

}

?>

*/

?>
