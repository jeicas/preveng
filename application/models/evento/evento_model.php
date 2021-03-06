<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evento_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cargarListaEvento() {

        $query = $this->db->query("Select evento.id as idEv, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.fechapreaviso as fechaPA,
                                    evento.presupuesto as presupuesto,
                                    evento.observacion as observacion,
                                    evento.estatus as estatus,
                                    alcance.nombre as alcance,
                                    agente.nombre as agente,
                                    tipoevento.nombre as tipoEv,
                                    sector.nombre as sector,
                                    bdgenerica.persona.nombre as nombre,
                                    bdgenerica.persona.apellido as apellido
                             from evento 
                             inner join agente on agente.id=evento.agente
                             inner join alcance on alcance.id=evento.alcance
                             inner join tipoevento on tipoevento.id=evento.tipoevento
                             inner join sector on sector.id=evento.sector
                             left join actividad
                                    on actividad.evento=evento.id
                             left join actividad_usuario on actividad.id=actividad_usuario.actividad
                             left join  bdgenerica.usuario 
                                    on bdgenerica.usuario.id= actividad_usuario.usuario
                             
                             left join  bdgenerica.persona 
                                    on bdgenerica.usuario.cedula=bdgenerica.persona.cedula
                            left join bdgenerica.empleado on 
                                         bdgenerica.persona.cedula=bdgenerica.empleado.cedula
                            
                             group by idEv
                             order by fechaEv ASC");

        return $query;
    }

    
    
    public function cargarListaEventoPDF() {

        $query = $this->db->query("Select evento.id as idEv, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.fechapreaviso as fechaPA,
                                    evento.presupuesto as presupuesto,
                                    evento.observacion as observacion,
                                     CASE evento.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus,
                                    alcance.nombre as alcance,
                                    agente.nombre as agente,
                                    tipoevento.nombre as tipoEv,
                                    sector.nombre as sector,
                                    bdgenerica.persona.nombre as nombre,
                                    bdgenerica.persona.apellido as apellido
                             from evento 
                             inner join agente on agente.id=evento.agente
                             inner join alcance on alcance.id=evento.alcance
                             inner join tipoevento on tipoevento.id=evento.tipoevento
                             inner join sector on sector.id=evento.sector
                             left join actividad
                                    on actividad.evento=evento.id
                             left join actividad_usuario on actividad.id=actividad_usuario.actividad
                             left join  bdgenerica.usuario 
                                    on bdgenerica.usuario.id= actividad_usuario.usuario
                             
                             left join  bdgenerica.persona 
                                    on bdgenerica.usuario.cedula=bdgenerica.persona.cedula
                            left join bdgenerica.empleado on 
                                         bdgenerica.persona.cedula=bdgenerica.empleado.cedula
                            
                             group by idEv
                             order by fechaEv ASC");

        return $query;
    }
     public function cargarListaEventoSeleccionPDF($condicion) {
       /* $sql="Select evento.id as idEv, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.fechapreaviso as fechaPA,
                                    evento.presupuesto as presupuesto,
                                    evento.observacion as observacion,
                                     CASE evento.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus,
                                    alcance.nombre as alcance,
                                    agente.nombre as agente,
                                    tipoevento.nombre as tipoEv,
                                    sector.nombre as sector,
                                    bdgenerica.persona.nombre as nombre,
                                    bdgenerica.persona.apellido as apellido
                             from evento 
                             inner join agente on agente.id=evento.agente
                             inner join alcance on alcance.id=evento.alcance
                             inner join tipoevento on tipoevento.id=evento.tipoevento
                             inner join sector on sector.id=evento.sector
                             left join actividad
                                    on actividad.evento=evento.id
                             left join actividad_usuario on actividad.id=actividad_usuario.actividad
                             left join  bdgenerica.usuario 
                                    on bdgenerica.usuario.id= actividad_usuario.usuario
                             
                             left join  bdgenerica.persona 
                                    on bdgenerica.usuario.cedula=bdgenerica.persona.cedula
                            left join bdgenerica.empleado on 
                                         bdgenerica.persona.cedula=bdgenerica.empleado.cedula
                            WHERE $condicion
                             group by idEv
                             order by fechaEv ASC";
         print_r($sql);*/
        $query = $this->db->query("Select evento.id as idEv, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.fechapreaviso as fechaPA,
                                    evento.presupuesto as presupuesto,
                                    evento.observacion as observacion,
                                     CASE evento.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus,
                                    alcance.nombre as alcance,
                                    agente.nombre as agente,
                                    tipoevento.nombre as tipoEv,
                                    sector.nombre as sector
                                  
                             from evento 
                             inner join agente on agente.id=evento.agente
                             inner join alcance on alcance.id=evento.alcance
                             inner join tipoevento on tipoevento.id=evento.tipoevento
                             inner join sector on sector.id=evento.sector
                            
                            WHERE $condicion
                             group by idEv
                             order by fechaEv ASC");

        return $query;
    }
    
     public function getDatosEvento($id) {
        $query = $this->db->query("SELECT *
                             from evento 
                             where id=$id");
       
        return $query;
    }
      public function getDatosEventoPDF($id) {
        $query = $this->db->query("SELECT e.titulo,
                                          e.descripcion, 
                                          a.nombre agente, 
                                          te.nombre tipoEv, 
                                          s.nombre sector, 
                                          al.nombre alcance, 
                                          CASE evento.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus
                             from evento e
                              inner join agente a on a.id=e.agente
                             inner join alcance on al al.id=e.alcance
                             inner join tipoevento te on te.id=e.tipoevento
                             inner join sector s on s.id=e.sector
                             where id=$id");
       
        return $query;
    }
    
    
    
    public function cargarListaEventoTodo() {

        $query = $this->db->query("Select evento.id as idEv, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.fechapreaviso as fechaPA,
                                    evento.presupuesto as presupuesto,
                                    evento.estatus as estatus,
                                    alcance.nombre as alcance,
                                    agente.nombre as agente,
                                    tipoevento.nombre as tipoEv,
                                    sector.nombre as sector
                             from evento 
                             inner join agente on agente.id=evento.agente
                             inner join alcance on alcance.id=evento.alcance
                             inner join tipoevento on tipoevento.id=evento.tipoevento
                             inner join sector on sector.id=evento.sector
                             
                             order by fechaEv  ASC");

        return $query;
    }

    public function cargarListaEventosResponsable() {

        $query = $this->db->query("Select evento.id as idEvent, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    bdgenerica.persona.nacionalidad as nacionalidad,
                                     bdgenerica.persona.cedula as cedula,
                                    bdgenerica.persona.nombre as nombre,
                                    bdgenerica.persona.apellido as apellido,
                                    bdgenerica.persona.foto as foto,
                                    bdgenerica.cargo.nombre as cargo,
                                    bdgenerica.ente.nombre AS ente,
                                    bdgenerica.division.nombre AS division,
                                    evento.estatus as estatus,
                                    actividad_usuario.usuario as idUsuario
                                   
                             from evento
                             
                             left join actividad
                                    on actividad.evento=evento.id
                             left join actividad_usuario on actividad.id=actividad_usuario.actividad
                             left join  bdgenerica.usuario 
                                    on bdgenerica.usuario.id= actividad_usuario.usuario
                     		left join  bdgenerica.persona 
                                    on bdgenerica.usuario.cedula=bdgenerica.persona.cedula
                            left join bdgenerica.empleado on 
                                         bdgenerica.persona.cedula=bdgenerica.empleado.cedula
                            left join bdgenerica.cargo 
                                    on bdgenerica.cargo.id=bdgenerica.empleado.cargo
                            left JOIN  bdgenerica.ente 
                                     ON bdgenerica.empleado.ente= bdgenerica.ente.id
                            left JOIN  bdgenerica.division 
                                     ON bdgenerica.empleado.division= bdgenerica.division.id
                           where evento.estatus in (1,2,4)
                           group by evento.id");

        return $query;
    }

    public function cargarListaEventosSinResponsable($id) {

        $query = $this->db->query("Select evento.id as idEvent, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.estatus as estatus
                                   
                            from evento
                           where evento.estatus in (1,2) and evento.id!=$id
                           group by evento.titulo");

        return $query;
    }

    public function cargarListaEventosSinResponsableTodos() {

        $query = $this->db->query("Select evento.id as idEvent, 
                                    evento.titulo as titulo, 
                                    evento.descripcion as descripcion, 
                                    evento.fechatope as fechaEv,
                                    evento.estatus as estatus
                                   
                            from evento
                           where evento.estatus in (1,2) 
                           group by evento.titulo");

        return $query;
    }
    
    
        public function consultarEventoHoy($hoy) {

        $query = $this->db->query("Select evento.id as id, 
       evento.estatus as estatus
                                   
             from evento
             where evento.estatus in (1,2,4) and evento.fechatope <'".$hoy."'");

        return $query;
    }

    public function cambiarEstatus($data) {
        $this->db->set('estatus', $data['estatus']);
        $this->db->where('id', $data['id']);
        return $this->db->update('evento');
    }
    
       public function estatusExpirado($data) {
        $this->db->set('estatus',5);
        $this->db->where('id', $data);
        return $this->db->update('evento');
    }
    

    public function guardarEvento($data) {

        return $this->db->insert('evento', $data);
    }

    public function actualizarEvento($data) {
        $this->db->set($data);
        $this->db->where('id', $data['id']);
        return $this->db->update('evento');
    }

    public function cargarCantidadEventoPorTipo() {

        $query = $this->db->query("SELECT TE.id, TE.nombre, E.estatus,COUNT(E.tipoevento) AS cantidad
                                   FROM  tipoevento TE
                                   LEFT JOIN evento AS E ON E.tipoevento = TE.id
                                   GROUP BY TE.id");

        return $query;
    }
        
   public function cargarCantidadEventoCompletadosPorTipo($tipo) {

        $query = $this->db->query("SELECT (e.tipoevento) as tipo,
                                     If(e.estatus='1' || e.estatus='4',count(e.estatus),0) as pendiente,
                                     If(e.estatus='2',count(e.estatus),0) as ejecucion,
                                     If(e.estatus='0',count(e.estatus),0) as completado,
                                     If(e.estatus='5' || e.estatus='3',count(e.estatus),0) as ce 
                                     FROM  evento as e where e.tipoevento=$tipo
                                        group by e.estatus");
        
        return $query;
        
        
    }
  public function cargarCantidadEventoPorTipos() {

        $query = $this->db->query("SELECT (e.tipoevento) as tipo,
                                     If(e.estatus='1' || e.estatus='4',count(e.estatus),0) as pendiente,
                                     If(e.estatus='2',count(e.estatus),0) as ejecucion,
                                     If(e.estatus='0',count(e.estatus),0) as completado 
                                     FROM  evento as e where e.estatus in (0,1,2,4)
                                        group by e.estatus");
        
        return $query;
        
        
    }
          
   public function cargarCantidadEventoPendientesPorTipo($tipo) {

        $query = $this->db->query("SELECT  estatus, count(E.estatus) AS pendiente
                                     FROM evento AS E 
                                     WHERE E.tipoevento=$tipo AND E.estatus=1
                                     GROUP BY id");

         
       return $query;
    }
      public function cargarCantidadEventoEnEjecucionPorTipo($tipo) {

        $query = $this->db->query("SELECT  estatus, count(E.estatus) AS ee
                                     FROM evento AS E 
                                     WHERE E.tipoevento=$tipo AND E.estatus=2
                                     GROUP BY id");

         
      return $query;
    }
    
    public function cargarCantidadPlan($id) {

        $query = $this->db->query("SELECT  count(*) as total, "
                . "              (SELECT  count(a.estatus) FROM  actividad a where a.evento=$id and a.estatus =0) as completado,
                                 (SELECT  count(a.estatus) FROM  actividad a where a.evento=$id and a.estatus !=0) as completado1    
                                     FROM  actividad E where E.evento=$id");

         
      return $query;
    }
}

// fin de la clase
