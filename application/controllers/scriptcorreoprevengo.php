<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scriptcorreoprevengo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("email");
    }

    public function emailNuevoComisionado($correo,$nombre, $evento) {
 
        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'P.R.E.V.E.N.G.O.';
        
        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from($from);
        $this->correo->to($correo);
        $this->correo->subject('Asignación a un Evento');

        $html = "<h1>Asignacion</h1>
                <p>Estimado(a): <b>$nombre</b></p>      
                <p>Usted ha sido asignado como <b>COMISIONADO</b> al evento: $evento </p>
                <p>Para más detalle, por favor comuniquese con el administrador del sistema</p>

               <p>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</p>
               <p><b>Sístema P.R.E.V.E.N.G.O.</b></p>
               <p><b>Lara... Tierra Progresista</b></p>";
        
        $this->correo->message($html);
        $this->correo->send();
    }

    
     public function emailNuevoResponsable($correo,$nombre, $evento) {

        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'P.R.E.V.E.N.G.O.';
        
        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from($from);
        $this->correo->to($correo);
        $this->correo->subject('Asignación a un Plan de Acción');

        $html = "<h1>Asignacion</h1>
                <p>Estimado(a): <b>$nombre</b></p>      
                <p>Usted ha sido asignado como <b>RESPONSABLE del PLAN DE ACCION</b> del evento:$evento</p>
                <p>Puede acceder al sistema con su cuenta y registrar las actividades correspondientes al plan de accion</p>
              
               <p>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</b></p>
               <p><b>Sístema P.R.E.V.E.N.G.O.</b></p>
                <p><b>Lara... Tierra Progresista</b></p>";
        $this->correo->message($html);
        $this->correo->send();
    }
    
    
       public function emailNuevoResponsableActividad($correo,$nombre, $evento, $actividad) {

        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'P.R.E.V.E.N.G.O.';
        
        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from($from);
        $this->correo->to($correo);
        $this->correo->subject('Asignación a una Actividad');

        $html = "<h1>Asignacion</h1>
                <p>Estimado(a): <b>$nombre</b></p>      
                <p>Usted ha sido asignado como <b>RESPONSABLE de la actividad:<b> $actividad </b>del PLAN DE ACCION del evento:$evento</p>
                <p>Puede acceder al sistema con su cuenta para las actividades que se realizaran</p>
              
               <p>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</b></p>
               <p><b>Sístema P.R.E.V.E.N.G.O.</b></p>
                <p><b>Lara... Tierra Progresista</b></p>";
        $this->correo->message($html);
        $this->correo->send();
    }
    
    
      public function emailNuevoEjecutor($correo,$nombre,$responsable, $evento, $actividad) {

        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'P.R.E.V.E.N.G.O.';
        
        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from($from);
        $this->correo->to($correo);
        $this->correo->subject('Asignación a una Actividad');

        $html = "<h1>Asignacion</h1>
                <p>Estimado(a): <b>$nombre</b></p>      
                <p>Usted ha sido asignado como <b>EJECUTOR del PLAN DE ACCION: </b>$actividad, del evento: $evento</p>
                <p>Puede acceder al sistema con su cuenta para registrar los avances realizados</p>
                <p>Atentamente:</p>
                <p><b>$responsable</b> responsable de este PLAN DE ACCION</p>
               <p>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</p>
               <p><b>Sístema P.R.E.V.E.N.G.O.</b></p>
               <p><b>Lara... Tierra Progresista</b></p>";
        $this->correo->message($html);
        $this->correo->send();
    } 
    
     public function emailNuevoUsuario($correo,$usuario,$nombre) {

        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'P.R.E.V.E.N.G.O.';
        
        $this->load->library('email', '', 'correo');
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $user,
            'smtp_pass' => $pass,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );
        $this->correo->initialize($configGmail);
        $this->correo->from($from);
        $this->correo->to($correo);
        $this->correo->subject('Registro Usuario- P.R.E.V.E.N.G.O.:');

        $html = "'<h1>Registro</h1>
                <p>Estimado(a): <b>$nombre</b></p>      
                <p>Puede acceder al sistema P.R.E.V.E.N.G.O mediante las siguiente coordenadas:</p>
                <p>USUARIO: <b>$usuario</b></p>
                <p>CLAVE POR DEFECTO: <b>123456</b></p>
                <p></p>

               <p>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</p>
               <p><b>Sístema P.R.E.V.E.N.G.O.</b></p>
               <p><b>Lara... Tierra Progresista</b></p>";
        $this->correo->message($html);
        $this->correo->send();
    }
    
}
