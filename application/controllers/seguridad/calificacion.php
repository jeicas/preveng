
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calificacion extends CI_Controller {
    public function __construct(){
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');
        $this->load->model('seguridad/calificacion_model');
    }
    public function buscarcalificacion() {
    $resultdbd=array();  
 
    if ($resultdbd=$this->calificacion_model->findCalificacion())
        {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode(array(
            "success" => True,
            'data' => $resultdbd)));
        }
    } 
    
    public function guardarCalificacion() {
    $calificacion=$_POST['records']; 
    
        if (isset($calificacion)) {
            $this->calificacion_model->deleteCalificacion();
            
            $records = json_decode($calificacion);
            foreach ($records as $record1) {
                $data = array(
                    'descripcion' => $record1->descripcion,
                     'desde' => $record1->desde,
                     'hasta' => $record1->hasta,
                );
              
             $result= $this->calificacion_model->insertCalificacion($data);
              
            }
            if ($result){
                echo json_encode(array(
                "success" => true,
                "msg" => "Calificación configurada exitosamente" //modificado en la base de datos
            ));
            }else {
                echo json_encode(array(
                "success" => true,
                "msg" => "No se pudo configurar la calificacion. Por verifique los datos." //modificado en la base de datos
            ));
            }
        }
   
    } 
}