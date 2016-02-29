

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Avance_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function guardarAvance($dataAvance) {
        $this->db->insert('avance', $dataAvance);
        return $this->db->insert_id();
    }

    public function actualizarAvance($dataAvance) {

        $this->db->set($dataAvance);
        $this->db->where('id', $dataAvance['id']);
        return $this->db->update('avance');
    }

    public function cambiarEstatus($dataAvance) {

        $this->db->set($dataAvance);
        $this->db->where('id', $dataAvance['id']);
        return $this->db->update('avance');
    }

    public function consultarAvanceTipoFinal($actividad) {



        $sql = "SELECT id FROM avance where tipo=0  and actividad=$actividad";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $boll = false;
        } else {
            $boll = true;
        }

        return $boll;
    }

    public function consultarListaAvance($usuario) {
        $sql1 = "SELECT actividad FROM avance where usuario=$usuario";
        $query1 = $this->db->query($sql1);
        if ($query1->num_rows() > 0) {
            if ($query1->num_rows() > 1) {
                $i = 0;
                foreach ($query1->result_array() as $act) {
                    if ($i == 0) {
                        $condici = $act['actividad'];
                    } else {
                        $condici = $condici . ',' . $act['actividad'];
                    }
                    $i = $i + 1;
                }
            } else {
                $act = $query1->result_array();
                $condici = $act['actividad'];
            }
            $condicion = '(' . $condici . ')';
            $sql = "SELECT av.id AS id,
              av.descripcion AS descripcion,
              evento.titulo AS evento,
              actividad.descripcion AS actividad,
              av.id AS idAvance,
              av.meta AS meta,
              av.actividad AS idActividad,
              av.tipo AS tipo,
              av.fecharegistro AS fecha,
              av.fechaasignacion AS fechaAsig,
              av.costo AS costo,
              av.observacion AS observacion,
              av.estatus AS estatus,
              actividad.meta as metaact,
              actividad.medida as unidad,
              anexo.direccion as anexo,
              anexo.tipoarchivo as extension,
              bdgenerica.usuario.id AS idUs,
              bdgenerica.persona.nombre AS nombre,
              bdgenerica.persona.apellido AS apellido
              FROM prevengo.avance as av
              INNER JOIN actividad ON actividad.id= av.actividad
              INNER JOIN evento ON actividad.evento=evento.id

              INNER JOIN bdgenerica.usuario ON av.usuario= bdgenerica.usuario.id
              LEFT JOIN anexo on av.id =anexo.avance
              INNER JOIN bdgenerica.persona ON bdgenerica.usuario.cedula=bdgenerica.persona.cedula
              WHERE av.estatus !=1    and av.actividad IN $condicion
              GROUP BY av.id
              ORDER BY av.fecharegistro, av.tipo ASC";
            $query = $this->db->query($sql);
            return $query;
        } else
            return $query1;
    }

    public function sumTotalMetaAvance($idactividad) {

        $sql = "SELECT SUM( av.meta ) AS totalmeta, a.meta AS metaact, a.medida AS medida
                FROM prevengo.avance AS av
                INNER JOIN actividad a ON a.id = av.actividad
                AND av.actividad =$idactividad
                ";


        $query = $this->db->query($sql);

        return $query;
    }

    public function consultarListaAvanceFinal() {

        $sql = "SELECT actividad.id AS id,
                     av.id AS idAv,
                     evento.titulo AS evento, 
                     av.descripcion AS descripcion, 
                     actividad.descripcion AS actividad, 
                     av.tipo AS tipo, 
                     av.meta as meta,
                     av.fecharegistro AS fecha, 
                     bdgenerica.persona.nombre AS nombre, 
                     bdgenerica.persona.apellido AS apellido 

             FROM prevengo.avance AS av 
             INNER JOIN actividad ON actividad.id= av.actividad 
             INNER JOIN evento ON actividad.evento=evento.id 
             INNER JOIN bdgenerica.usuario ON av.usuario= bdgenerica.usuario.id 
             INNER JOIN bdgenerica.persona ON bdgenerica.usuario.cedula=bdgenerica.persona.cedula 
             WHERE av.estatus=5 and av.tipo=0 and actividad.estatus=3
             ORDER BY av.fecharegistro, id ASC";


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

        $query = $this->db->query($sql);

        return $query;
    }
    
    

    public function cargarEmpleadosConPlan($id) {

        $sql = "SELECT 
                    bdgenerica.persona.foto AS foto,
                     bdgenerica.persona.nombre AS nombre, 
                     bdgenerica.persona.apellido AS apellido,
                     bdgenerica.empleado.id AS idEm,
                     av.fechaasignacion AS fecha

             FROM prevengo.avance AS av 
             INNER JOIN actividad ON actividad.id= av.actividad 
             INNER JOIN evento ON actividad.evento=evento.id 
             INNER JOIN bdgenerica.usuario ON av.usuario= bdgenerica.usuario.id 
             INNER JOIN bdgenerica.persona ON bdgenerica.usuario.cedula=bdgenerica.persona.cedula 
             INNER JOIN bdgenerica.empleado ON bdgenerica.usuario.cedula=bdgenerica.empleado.cedula 
             WHERE  av.actividad=$id
             GROUP BY nombre 
             ORDER BY av.fecharegistro ASC";


        $query = $this->db->query($sql);

        return $query;
    }

    public function cargarUsuarios() {


        $sql = "SELECT bdgenerica.usuario.id,
	               bdgenerica.usuario.nacionalidad,
                        bdgenerica.usuario.cedula,
                        bdgenerica.empleado.id as empl,
                        bdgenerica.persona.foto,
                        bdgenerica.persona.nombre,
                        bdgenerica.persona.apellido,
                        bdgenerica.persona.correo,
                        bdgenerica.ente.nombre AS ente,
                        bdgenerica.division.nombre AS division,
                        bdgenerica.tipousuario.nombre AS tipousuario
                        
                     FROM bdgenerica.usuario
                     
                     INNER  JOIN bdgenerica.persona 
                      ON bdgenerica.persona.cedula= bdgenerica.usuario.cedula
                     INNER JOIN  bdgenerica.empleado
                       ON bdgenerica.persona.cedula=bdgenerica.empleado.cedula 
                     INNER JOIN  bdgenerica.ente 
                       ON bdgenerica.empleado.ente= bdgenerica.ente.id
                     INNER JOIN  bdgenerica.division 
                       ON bdgenerica.empleado.division= bdgenerica.division.id
                     INNER JOIN  bdgenerica.tipousuario
                       ON bdgenerica.usuario.tipousuario= bdgenerica.tipousuario.id";
        $query = $this->db->query($sql);

        return $query;
    }

//fin de la funcion

    public function buscarEjecutorDeActividad($id) {
        $query = $this->db->query("select count(*) as cuantos

                                    from prevengo.avance 
                                    
                                    where  prevengo.avance.actividad=$id 					 												   
                                          
                                 ");

        return $query;
    }

    public function buscarAvance($id) {
        $query = $this->db->query("select count(*) as cuantos
                                        from actividad 
                                        inner join avance on actividad.id=avance.actividad
                                        inner join evento on evento.id=actividad.evento
                                        where (evento.estatus in (1,2)) and (actividad.estatus in (1,2)) and (avance.usuario=$id)
                                        order by actividad.estatus, actividad.id					 												   
                                          
                                 ");

        return $query;
    }

}

//fin de la clase


