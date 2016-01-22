<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correosprevengo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library(array('session'));
        $this->load->library("email");
       
    }

 
   
     public function emailComisionadoNuevo($correo,$nombre,$evento){    
    
        $user = 'sistemaelectoralavanzadalara@gmail.com';
        $pass = 'avanzadalara';
        $from = 'Sistema Casa x Casa';
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
        $this->correo->to($nombre);
        $this->correo->subject('Información de Registro de Contactos Diarios Estado Lara');
   /* $this->email->message('<h1>Asignacion</h1>
      <p>Estimado(a): <b>'.$nombre.'</b></p>      
      <p>Usted ha sido asignado como comisionado al evento: '.$evento.'</p>
      <p>Para más detalle, por favor comuniquese con el administrador del sistema</p>

     <p><b>Este correo es enviado automáticamente por nuestro sistema, por favor, no responda, ni reenvíe mensajes a esta cuenta.</b></p>
     <p>Sístema P.R.E.V.E.N.G.O.</p>
      <p><b>Lara... Tierra Progresista</b></p>');*/
      $html='ssssss';
      $this->correo->message($html);
      $this->correo->send();
  }

} 