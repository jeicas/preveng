<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportegeneralevento extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->database();
        $this->load->library('Pdf');
        $this->load->model('evento/evento_model');
        $this->load->model('actividad/actividad_model');
        $this->load->model('lineamiento/lineamiento_model');
        $this->load->model('comisionado/comisionado_model');
        $this->load->library(array('session'));
        // date_default_timezone_set('America/Caracas');
    }

    public function generarReporteEventoGeneral() {
        $idEvento = $this->input->get('idEv');
        $html = null;
        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(2);   
        $pdf->SetHeaderData('bannerprevengo4.png', 270, 'Gobernacion de Lara', 'Oficina de Personal--División de Planificación y Presupuesto', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterMargin(12);
        $pdf->setFooterData();
        $pdf->SetAlpha(1,'Normal');
        $pdf->Image('imagen/logo/degradado.PNG',30,54,100,104,
                      '','','N','','','C');
        // recuperamos la opacidad por defecto 
        $pdf->SetAlpha(1,'Normal');
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->AddPage();
        $pdf->SetTextColor('8', '8', '8');
        $pdf->Ln(10);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                     
                        <td colspan="8"><p align="rigth"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';
        $html .="<h1>Reporte General de Eventos</h1>";
        $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha:</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         
                    </tr>';
        $condicion = 'evento.id=' . $idEvento;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        if ($reporte->num_rows > 0) {
            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="1"><p align="center">' . $fila2['fechaEv'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="3"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['estatus'] . '</p></td>
                        </tr>';
            }

            $html .='</table>';
        }
        $html .='<H1></H1>';
// Tabla del plan de accion

        $reporte2 = $this->actividad_model->cargarPlandeAccionDeEventoPDF($idEvento);
        $html .=' <table border="1">';
        $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Plan de Accion</b></p></td>       
                    </tr>';
        if ($reporte2->num_rows > 0) {

            foreach ($reporte2->result_array() as $fila2) {
                $html .='
                   
                    <tr colspan="4">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Actividad:</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Responsable</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Meta</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                         
                    </tr>       
                <tr colspan="4">
                            <td colspan="1" bgColor="#00BFFF"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1" bgColor="#00BFFF"><p align="center">' . $fila2['nombrecompleto'] . '</p></td>
                            <td colspan="1" bgColor="#00BFFF"><p align="center">' . $fila2['metaM'] . '</p></td>
                            <td colspan="1" bgColor="#00BFFF"><p align="center">' . $fila2['estatus'] . '</p></td>
                           
                        </tr>
                        
                         <tr colspan="4">
                            <td colspan="1" bgColor="#58D3F7"><p align="center"><b>Avance:</b></p></td>
                            <td colspan="1" bgColor="#58D3F7"><p align="center"><b>Tipo de Avance:</b></p></td>
                            <td colspan="1" bgColor="#58D3F7"><p align="center"><b>Meta Lograda:</b></p></td>
                            <td colspan="1" bgColor="#58D3F7"><p align="center"><b>Ejecutor</b></p></td>
                    </tr>';

                $reporte1 = $this->actividad_model->consultarListaAvanceActividad($fila2['id']);
                if ($reporte1->num_rows > 0) {
                    foreach ($reporte1->result_array() as $fil) {
                        $html .='<tr colspan="4">
                             <td colspan="1" ><p align="center"><b>' . $fil['descripcion'] . '</b></p></td>
                            <td colspan="1" ><p align="center"><b>' . $fil['tipo'] . '</b></p></td>
                            <td colspan="1" ><p align="center"><b>' . $fil['meta'] . '</b></p></td>
                            <td colspan="1" ><p align="center"><b>' . $fil['ejecutor'] . '</b></p></td>
                     
                        </tr>';
                    }
                } else {
                    $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> No se encuentran avances registrados para esta actividad</b></p></td>    
                        </tr>';
                }
            }
        } else {
            $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> El evento seleccionado no tiene plan de accion registrado.</b></p></td>    
                        </tr>';
        }
        $html .='</table>';

        $html .='<H1></H1>';
//=============tabla de los lineamientos

        $reporte3 = $this->lineamiento_model->cargarListaLineamiento($idEvento);
        $html .='
                    <table border="1">
                   ';
        $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Lineamientos</b></p></td>       
                    </tr>
                   ';
        if ($reporte3->num_rows > 0) {
            $html.='
                    <tr colspan="4">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Descripcion:</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr> ';
            foreach ($reporte3->result_array() as $fi) {
                $html .='
 
                <tr colspan="4">
                            <td colspan="3" ><p align="center">' . $fi['descripcion'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fi['fecha'] . '</p></td>
                           
                           
                        </tr>';
            }
        } else {
            $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> El evento seleccionado no tiene Lineamientos registrado.</b></p></td>    
                        </tr>';
        }

        $html .='</table>';
        $html .='<H1></H1>';

        //============= tabla comisionados  
        $reporte3 = $this->comisionado_model->cargarListaComisionadoPDF($idEvento);
        $html .='
                    <table border="1">
                   ';
        $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Comisionados</b></p></td>       
                    </tr>
                   ';
        if ($reporte3->num_rows > 0) {
            $html.='
                    <tr colspan="4">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Nombre:</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Cargo</b></p></td>
                    </tr> ';
            foreach ($reporte3->result_array() as $fi) {
                $html .='
 
                <tr colspan="4">
                            <td colspan="3" ><p align="center">' . $fi['nombrecompleto'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fi['cargo'] . '</p></td>
                           
                           
                        </tr>';
            }
        } else {
            $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> El evento seleccionado no tiene Comisionados registrados.</b></p></td>    
                        </tr>';
        }

        $html .='</table>';



        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

}
