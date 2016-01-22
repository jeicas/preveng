<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scriptcorreoprevengo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library("email");
    }




    public function emailResumenParroquia() {
          
        $correocordinador='sistemaelectoralavanzadalara@gmail.com';
        
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
            $this->correo->to($correocordinador);
            $this->correo->subject('Información');

                $html  ="<p><b>Lara Progresista</b></p>'";
                $this->correo->message($html);
                $this->correo->send();
            }

} 