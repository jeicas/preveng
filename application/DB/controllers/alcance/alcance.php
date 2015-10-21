<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alcance extends CI_Controller
{
     public function __construct(){
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('alcance/alcance_model');
    } 


    public function obtenerAlcance()
    {
      $resultdbd=array();
        if ($resultdbd=$this->alcance_model->cargarAlcance()){
                $output = array(
                   'success'   => true,
                   'total'     => count($resultdbd),
                   'data'      => array_splice($resultdbd,$this->input->get("start"),$this->input->get("limit"))
                );
           echo json_encode($output);
        }
    }
    
    public function registrarAlcance()
   {
        $nombre = $this->input->post('txtNombre');
        $valor = $this->input->post('txtValor');
        $estatus = 1;

        $dataAgente= array(
            'nombre' => $nombre,
            'valor' => $valor,
            'estatus' => $estatus,
        );

        $result = $this->alcance_model->guardarAlcance($dataAgente);

        if ($result) {
            echo json_encode(array(
                "success" => true,
                "msg" => "Se Guardo con Éxito." //modificado en la base de datos
            ));
        } else {

            echo json_encode(array(
                "success" => false,
                "msg" => "No se pudo Guardar, por favor verifique los datos suministrados" //no se modifico en la base de datos
            ));
        }
    }
    
      public function actualizarAlcance()
   {
        $id = $this->input->post('id');
        $nombre = $this->input->post('txtNombre');
         $valor = $this->input->post('txtValor');
        $estatus = 1;

        $dataAgente= array(
            'id' => $id,
            'nombre' => $nombre,
            'valor' => $valor,
            'estatus' => $estatus,
        );

        $result = $this->alcance_model->actualizarAlcance($dataAgente);

        if ($result) {
            echo json_encode(array(
                "success" => true,
                "msg" => "Se Actualizó con Éxito." //modificado en la base de datos
            ));
        } else {

            echo json_encode(array(
                "success" => false,
                "msg" => "No se pudo Guardar, por favor verifique los datos suministrados" //no se modifico en la base de datos
            ));
        }
    }



    




}//fin del controller