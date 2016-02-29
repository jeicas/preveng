<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Actividad_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardarActividad($dataActividad) {
        $this->db->insert('actividad', $dataActividad);
        return $this->db->insert_id();
    }

    public function guardarActividadUsuario($dataActividad) {
        return $this->db->insert('actividad_usuario', $dataActividad);
    }

    public function cargarPlandeAccion($usuario) {

        $query = $this->db->query("select actividad.id, actividad.descripcion,concat(actividad.meta,' ',actividad.medida) as meta, actividad.medida, avance.fechaasignacion as fecha, evento.titulo as evento
                                        from actividad 
                                        inner join avance on actividad.id=avance.actividad
                                        inner join evento on evento.id=actividad.evento
                                   
                                        where (evento.estatus in (1,2)) and (actividad.estatus in (1,2)) and (avance.usuario=$usuario)
                                        order by actividad.estatus, actividad.id ");
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

    public function buscarUnPlandeAccion($idUsuario, $idActividad) {

        $sql = " SELECT ava.id as avance,act.evento as evento, ava.actividad,ava.fechaasignacion, act.estatus 
              FROM avance AS ava 
              INNER JOIN actividad AS act ON ava.actividad=act.id 
              WHERE ava.usuario=$idUsuario and ava.actividad=$idActividad group by act.id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function buscarActividadEvento($idEvento) {

        $sql = " select count(*) as cuantos

                                  from prevengo.actividad
                                    
                                    where  prevengo.actividad.evento=$idEvento 					 												   
                                          and actividad.estatus in (1,2,3,6)";

        $query = $this->db->query($sql);
        return $query;
    }

    public function buscarActividadUsuarioEvento($id) {

        $sql = "SELECT actividad
                    FROM actividad_usuario au
                    INNER JOIN actividad a ON a.id = au.actividad
                    AND a.evento=$id";

        $query = $this->db->query($sql);
        return $query;
    }

    public function buscarIdActividad($evento) {

        $sql = "SELECT actividad.id as IdAct from actividad 
            inner join evento on evento.id= actividad.evento
            where actividad.evento=$evento and actividad.descripcion='no tiene actividades registrado'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cambiarEstatus($data) {
        $this->db->set('estatus', $data['estatus']);
        $this->db->where('id', $data['id']);
        return $this->db->update('actividad');
    }

    public function cambiarEstatusDependientes($data) {
        $this->db->set('estatus', $data['estatus']);
        $this->db->where('actividadepende', $data['id']);
        $this->db->where('estatus', 6);
        return $this->db->update('actividad');
    }

    public function actualizarActividadUsuario($data) {

        $sql = "UPDATE actividad_usuario 
                INNER JOIN actividad ON actividad_usuario.actividad = actividad.id 
              SET actividad_usuario.usuario =" . $data['usuario'] . "
              WHERE actividad.evento =" . $data['evento'] . ";";

        $query = $this->db->query($sql);
        return $query;
    }

    public function actualizarActividadResponsable($data) {
        $this->db->set('responsable', $data['usuario']);
        $this->db->where('evento', $data['evento']);
        return $this->db->update('actividad');
    }

    public function actualizarActividad($data) {
        $this->db->set($data);
        $this->db->where('actividad', $data['actividad']);
        return $this->db->update('actividad_usuario');
    }

    public function actualizarDataActividad($data) {
        $this->db->set($data);
        $this->db->where('id', $data['id']);
        return $this->db->update('actividad');
    }

    public function cargarEventosConPlandeAccion($usuario) {


        $sql = "SELECT ev.id AS idEvento,
                     ev.titulo AS evento,
                     ev.descripcion AS descripcion,
                     ev.fechatope AS fecha,
                     actividad.id AS idAct,
                     actividad.fechatope AS fechaAct,
                     actividad.descripcion AS actividad,
                     actividad.estatus AS estatus
                         
                FROM evento AS ev 
                INNER JOIN actividad 
                ON actividad.evento= ev.id
                      INNER JOIN actividad_usuario au ON actividad.id=au.actividad
                WHERE ev.estatus IN (1,2,4)
                     AND  au.usuario=$usuario
                         group by actividad.id

               ";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cargarEventosPA($usuario) {


        $sql = "SELECT ev.id AS idEvento,
                     ev.titulo AS evento,
                     ev.descripcion AS descripcion,
                     ev.fechatope AS fecha,
                      ev.estatus AS estatus, 
                      actividad.responsable AS idencargado
                    
                         
                FROM evento AS ev 
                INNER JOIN actividad ON actividad.evento= ev.id
                INNER JOIN actividad_usuario ON actividad.id=actividad_usuario.actividad
                WHERE ev.estatus IN (1,2,4)
                     AND  actividad_usuario.usuario=$usuario 
                           
                 GROUP BY  idEvento
                 ORDER BY fecha ASC
               ";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cargarPlandeAccionDeEvento($id) {

        $sql = " SELECT ac.id AS id,
          ac.descripcion AS descripcion,
          ac.fechatope AS fecha,
          ac.fechaaviso AS fechaPA,
          ac.meta AS meta,
          ac.medida AS medida,
          concat(ac.meta, ' ',  ac.medida) metaM,
          actividad.descripcion AS depende,
          ac.actividadepende AS iddepende,
          ac.observacion as observacion,
          ac.estatus AS estatus,
          concat (p.nombre, ' ',p.apellido) AS nombrecompleto,
          p.foto,
          p.correo,
          concat (p.nacionalidad, '-',p.cedula) AS cedula,
          us.id as usuario,
          ac.responsable as responsable

          FROM actividad AS ac
          LEFT JOIN actividad ON actividad.id=ac.actividadepende
          LEFT JOIN actividad_usuario au ON ac.id=au.actividad
          LEFT JOIN bdgenerica.usuario as us on us.id= au.usuario
          LEFT JOIN bdgenerica.persona as p on us.cedula= p.cedula
          WHERE  ac.evento=$id   GROUP BY ac.id"; 


        $query = $this->db->query($sql);

        return $query;
    }
        public function cargarPlandeAccionDeEventoPDF($id) {

        $sql = " SELECT ac.id AS id,
          ac.descripcion AS descripcion,
          ac.fechatope AS fecha,
          ac.fechaaviso AS fechaPA,
          ac.meta AS meta,
          ac.medida AS medida,
          concat(ac.meta, ' ',  ac.medida) metaM,
          actividad.descripcion AS depende,
          ac.actividadepende AS iddepende,
          ac.observacion as observacion,
          CASE  ac.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus,
          concat (p.nombre, ' ',p.apellido) AS nombrecompleto,
          p.foto,
          p.correo,
          concat (p.nacionalidad, '-',p.cedula) AS cedula,
          us.id as usuario,
          ac.responsable as responsable

          FROM actividad AS ac
          LEFT JOIN actividad ON actividad.id=ac.actividadepende
          LEFT JOIN actividad_usuario au ON ac.id=au.actividad
          LEFT JOIN bdgenerica.usuario as us on us.id= au.usuario
          LEFT JOIN bdgenerica.persona as p on us.cedula= p.cedula
          WHERE  ac.evento=$id   GROUP BY ac.id"; 


        $query = $this->db->query($sql);

        return $query;
    }
  public function cargarMetaPlandeAccionDeEventoPDF($id) {

        $sql = " SELECT SUM( av.meta ) metaa, 
                        ac.descripcion, 
                        CONCAT( ac.meta,  ' ', ac.medida ) metap,
                        CASE  ac.estatus   WHEN 0 THEN 'COMPLETADO'
                                  WHEN 1 THEN 'PENDIENTE'
                                  WHEN 2 THEN 'EN EJECUCION'
                                  WHEN 3 THEN 'CANCELADO'  
                                  WHEN 4 THEN 'SIN PLAN' 
                                  WHEN 5 THEN 'EXPIRADO' END as estatus
                    FROM avance av
                    INNER JOIN actividad ac ON ac.id = av.actividad
                    WHERE ac.evento =$id
                    AND av.estatus =0
                    GROUP BY ac.descripcion"; 

              
        $query = $this->db->query($sql);

        return $query;
    }


    public function cargarActividadDependiente($id) {

        $sql = "SELECT ac.id AS id,
                     ac.descripcion AS descripcion 
                 FROM actividad AS ac 
                 inner join evento on evento.id=ac.evento
                 WHERE ac.estatus in (1,2,3,6) AND evento.estatus!=4 and
                        ac.evento=$id";

        $query = $this->db->query($sql);
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

    public function cargarActividadDependiente2($idEv, $idAct) {

        $sql = "SELECT ac.id AS id,
                     ac.descripcion AS descripcion 
                 FROM actividad AS ac 
                 inner join evento on evento.id=ac.evento
                 WHERE ac.estatus  in (1,2,3,6) AND evento.estatus!=4 and
                        ac.evento=$idEv and ac.id!=$idAct";

        $query = $this->db->query($sql);
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

    public function eventoActividadAvance($id) { // carga la lista del avances y actividades de un evento. 
        $sql = "select actividad.id as idAct,
       actividad.descripcion as actDescripcion, 
       actividad.estatus as actEstatus,
       responsable.nombre as nombreAct, 
       responsable.apellido as apellidoAct,
       avance.descripcion as avDescripcion,
       avance.tipo as tipoAvance,
       avance.fecharegistro as fecha, 
       ejecutor.nombre as nombreAva,
       ejecutor.apellido as apellidoAva

       from actividad 
        inner join  avance on avance.actividad=actividad.id
        left join actividad_usuario as usuAct on usuAct.actividad=actividad.id 
        left join bdgenerica.usuario as usuAva on usuAva.id=avance.usuario 
        left join bdgenerica.usuario as usuAct on usuAct.id= usuAct.usuario
        
         join bdgenerica.persona as ejecutor on usuAva.cedula= ejecutor.cedula
         join bdgenerica.persona as responsable on usuAct.cedula= responsable.cedula
         where actividad.evento=$id
        order by idAct ASC";

        $query = $this->db->query($sql);
        return $query;
    }

    public function eventoActividadAvance2($id) { // carga la lista del avances y actividades de un evento. 
        $sql = "select DISTINCT  avance.descripcion as avDescripcion,
            actividad.id as idAct,
       actividad.descripcion as actDescripcion, 
       actividad.estatus as actEstatus, 
       responsable.nombre as nombreAct, 
       responsable.apellido as apellidoAct, 
       avance.descripcion as avDescripcion,
       avance.tipo as tipoAvance,
       avance.fecharegistro as fecha, 
       ejecutor.nombre as nombreAva,
       ejecutor.apellido as apellidoAva

     from actividad 
       
       left join  avance on avance.actividad=actividad.id
        left join  actividad_usuario on actividad_usuario.actividad=actividad.id
      left join bdgenerica.usuario as usuAct on usuAct.id= actividad_usuario.usuario
      left  join bdgenerica.usuario as usuAva on usuAva.id=avance.usuario 
         
        left join bdgenerica.persona as ejecutor on usuAva.cedula= ejecutor.cedula
       left  join bdgenerica.persona as responsable on usuAct.cedula= responsable.cedula
         where actividad.evento=$id
         
        order by idAct ASC";

        $query = $this->db->query($sql);
        return $query;
    }

    public function cargarCantidadPlan($id) {

        $query = $this->db->query("SELECT  count(*) as total, "
                . "              (SELECT  count(a.estatus) FROM  actividad a where a.evento=$id and a.estatus =0) as completado,
                                 (SELECT  count(a.estatus) FROM  actividad a where a.evento=$id and a.estatus !=0) as completado1    
                                     FROM  actividad E where E.evento=$id");


        return $query;
    }

    public function cargarResponsablePlandeAccion($id) {

        $sql = "SELECT p.foto, concat(p.nombre, ' ', p.apellido) nombrecompleto, 
                                          au.fechaasignacion as fecha,
                                          e.id idEmpleado, au.usuario idUsuario 
                                    FROM actividad_usuario au 
                                    INNER JOIN bdgenerica.usuario u on au.usuario=u.id
                                    INNER JOIN bdgenerica.empleado e ON e.cedula=u.cedula
                                    INNER JOIN bdgenerica.persona p ON p.cedula=u.cedula
                                    INNER JOIN actividad ON au.actividad=actividad.id and actividad.evento=$id";
        $query = $this->db->query($sql);
        return $query;
    }
        public function consultarListaAvanceActividad($id) {

        $sql = "SELECT av.id AS idAv,
                     av.descripcion AS descripcion, 
                     if (av.tipo=1,'PARCIAL', 'FINAL') AS tipo, 
                     concat(av.meta,' ', ac.medida) meta,
                     concat(p.nombre,' ', p.apellido) as ejecutor,
                     av.fecharegistro AS fecha, av.estatus
             FROM prevengo.avance AS av 
              INNER JOIN bdgenerica.usuario u on u.id=av.usuario
              INNER JOIN bdgenerica.persona p on p.cedula= u.cedula
              INNER JOIN actividad ac on ac.id=av.actividad
             Where av.actividad=$id and av.estatus=0";
        //print_r($sql);
        $query = $this->db->query($sql);

        return $query;
    }

}

// fin de la clase