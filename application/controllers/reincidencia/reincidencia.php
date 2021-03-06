<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reincidencia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('reincidencia/reincidencia_model');
        $this->load->model('anexo/anexo_model');
    }

    public function listaReincidencia() {
        $id = $this->input->get('id');
        $reincidencia = $this->reincidencia_model->cargarListaReincidencia($id);

        if ($reincidencia->num_rows() > 0) {

            foreach ($reincidencia->result_array() as $row) {

                switch ($row['extension']) {
                    case 'html': {
                            $direccion = $row['anexo'];
                            $imagen = "../../imagen/btn/red.png";
                        }
                        break;
                    case 'jpg': {
                            $imagen = "../../imagen/btn/imagen.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . ".jpeg";
                        }
                        break;
                    case 'jpeg': {
                            $imagen = "../../imagen/btn/imagen-icono.jpg";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . ".jpeg";
                        }
                        break;
                    case 'png': {
                            $imagen = "../../imagen/btn/imagen.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . "." . $row['extension'];
                        }
                        break;
                    case 'gif': {
                            $imagen = "../../imagen/btn/imagen.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . "." . $row['extension'];
                        }
                        break;
                    case 'mp3': {
                            $imagen = "../../imagen/btn/sonido.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . "." . $row['extension'];
                        }
                        break;
                  
                    
                    case 'pdf': {
                            $imagen = "../../imagen/btn/pdf-icono.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . "." . $row['extension'];
                        }
                        break;
                    case 'doc': {
                            $imagen = "../../imagen/btn/documento.png";
                            $direccion = "../../anexosReincidencia/" . $row['anexo'] . "." . $row['extension'];
                        }
                        break;
                    default: {
                            $imagen = "../../imagen/btn/delete.png";
                            $direccion = "";
                        }
                }



                $data[] = array(
                    'idEv' => $row['idEv'],
                    'descripcion' => $row['descripcion'],
                    'fecha' => $row['fecha'],
                    'idRein' => $row['idRein'],
                    'anexo' => $imagen,
                    'direccion' => $direccion
                );
            }
            $output = array(
                'success' => true,
                'total' => count($data),
                'data' => array_splice($data, $this->input->get("start"), $this->input->get("limit"))
            );
            echo json_encode($output);
        }  else {
            $output = array(
                'success' => true,  
            );
            
            echo json_encode($output);
        }
    }

//fin listaEventos

    public function buscarReincidencia() {
        $id = $this->input->post('id');
        $valor = $this->reincidencia_model->buscarReincidencia($id);

        if ($valor->num_rows() > 0) {

            $row = $valor->row_array();
            $output = array(
                'success' => true,
                'cuanto' => $row['cuantos'],
            );
            echo json_encode($output);
        }  else {
            $output = array(
                'success' => true,  
            );
            
            echo json_encode($output);
        }
    }

//fin registrar

    public function guardar_Imagen_Reincidencia($nombrefoto, $fotoType, $fotoTmp_name) {
        if ($fotoTmp_name == '') {
            echo ('foto obligatoria');
        } else if ($fotoTmp_name != '' && ($fotoType == "image/gif" || $fotoType == "image/jpeg" || $fotoType == "image/png" || $fotoType == "audio/mp3" || $fotoType == "application/pdf" )) {
            $img_tipo = explode('/', $fotoType);
            $img_nombre = $nombrefoto . "." . $img_tipo[1];

            move_uploaded_file($fotoTmp_name, 'anexosReincidencia/' . $img_nombre);
        }
    }

    public function registrarReincidencia() {

        $idEv = $this->input->post('txtIdEvento');
        $descripcion = $this->input->post('txtDescripcion');
        $costo = $this->input->post('txtCosto');
        $fecha = date('Y-m-d');
        $estatus = 1;
        $resultFoto = false;
        
        $data = array(
            'evento' => $idEv,
            'descripcion' => $descripcion,
            'costo' => $costo,
            'fecha' => $fecha,
            'estatus' => $estatus,
        );

        $result = $this->reincidencia_model->guardarReincidencia($data);
      
        if ($this->input->post('seleccionAgregar') == 2) {
            
             if ($result == 0) {
                    $resultFoto = false;
                } else {
                    $resultFoto = true;
                }
        } else {
            
            if ($this->input->post('seleccion') == 1 || $this->input->post('seleccion') == 2) {
               
                if ($this->input->post('seleccion') == 2) {

                    $img_tipo = explode('/', $_FILES['txtArchivo']['type']);
                    $nombrefoto = "_AneRein" . $result;
                    $fotoType = $_FILES['txtArchivo']['type'];
                    $fotoTmp_name = $_FILES['txtArchivo']['tmp_name'];
                  
                    $this->guardar_Imagen_Reincidencia($nombrefoto, $fotoType, $fotoTmp_name);
                   
                    if ($fotoType == "image/gif" || $fotoType == "image/jpeg" || $fotoType == "image/png" || $fotoType == "application/pdf" || $fotoType == "audio/mp3" ){
                          $dataAnexo = array(
                        'reincidencia' => $result,
                        'direccion' => $nombrefoto,
                        'tipoarchivo' => substr($_FILES['txtArchivo']['name'], -3),
                        'estatus' => 1
                    );
                    $resultFoto = $this->anexo_model->guardarAnexo($dataAnexo);
                    }else {
                       $resultFoto=false;
                    }
                  
                } else {

                    $dataAnexo = array(
                        'reincidencia' => $result,
                        'direccion' => $this->input->post('txtDireccion'),
                        'tipoarchivo' => 'html',
                        'estatus' => 1
                    );
                    $resultFoto = $this->anexo_model->guardarAnexo($dataAnexo);
                }
            } else {
                if ($result == 0) {
                    $resultFoto = false;
                } else {
                    $resultFoto = true;
                }
            }
        }
        if ($resultFoto==1) {
            echo json_encode(array(
                "success" => true,
                "msg" => "Se Guardo con Éxito."//modificado en la base de datos
            ));
        }  else {
            $output = array(
                'success' => true,  
            );
            
            echo json_encode($output);
        }
    }

//fin registrar

    public function actualizarReincidencia() {

        $id = $this->post->input('id');
        $descripcion = $this->post->input('idEv');
        $costo = $this->post->input('idEv');
        $data = array(
            'id' => $id,
            'descripcion' => $descripcion,
        );


        $result = $this->reincidencia_model->actualizarReincidencia($data);

        if ($result) {
            echo json_encode(array(
                "success" => true,
                "msg" => "Se  actualizó con Éxito." //modificado en la base de datos
            ));
        } else {

            echo json_encode(array(
                "success" => false,
                "msg" => "No se pudo Guardar, por favor verifique los datos suministrados" //no se modifico en la base de datos
            ));
        }
    }

//fin actualizar

    public function eliminarReincidencia() {

        $id = $this->input->post('id');
        $estatus = 0;


        $data = array(
            'id' => $id,
            'estatus' => $estatus,
        );
       $dataAne = array(
            'reincidencia' => $id,
            'estatus' => $estatus,
        );

        $result = $this->reincidencia_model->eliminarReincidencia($data);
        $resultAne = $this->anexo_model->eliminarAnexo($dataAne);
        if ($result) {
            echo json_encode(array(
                "success" => true,
                "msg" => "Se  elimino con Éxito el Reincidencia." //modificado en la base de datos
            ));
        } else {

            echo json_encode(array(
                "success" => false,
                "msg" => "No se pudo Guardar, por favor verifique los datos suministrados" //no se modifico en la base de datos
            ));
        }
    }

}

//fin del controller