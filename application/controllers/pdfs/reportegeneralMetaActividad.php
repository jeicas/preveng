<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReportegeneralMetaActividad extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->database();
        $this->load->library('Pdf');
        $this->load->model('evento/evento_model');
        $this->load->model('actividad/actividad_model');
        $this->load->library(array('session'));
        // date_default_timezone_set('America/Caracas');
    }

    public function generarReporteActividadTodo() {
        
        $html = null;
        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(2);
        $pdf->SetHeaderData('bannerprevengo4.png', 270, 'Gobernacion de Lara', 'Oficina de Personal--División de Planificación y Presupuesto', array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterMargin(12);
        $pdf->setFooterData();
        $pdf->SetAlpha(1, 'Normal');
        $pdf->Image('imagen/logo/degradado.PNG', 30, 54, 100, 104, '', '', 'N', '', '', 'C');
        // recuperamos la opacidad por defecto 
        $pdf->SetAlpha(1, 'Normal');
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
        $html .="<h1>Reporte General de Metas alcanzada para las actividades</h1>";

        $reporte = $this->evento_model->cargarListaEventoPDF();
      
        if ($reporte->num_rows > 0) {
            
            foreach ($reporte->result_array() as $fila2) {
                  $html .='
                    <table border="1">
                <tr colspan="4">
                       
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Evento</b></p></td>
                     
                         
                    </tr>   
                    
                      <tr colspan="4">
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         
                    </tr>


                  <tr colspan="4">
                           
                            <td colspan="1"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['estatus'] . '</p></td>
                        </tr>';
 
                $reporte2 = $this->actividad_model->cargarMetaPlandeAccionDeEventoPDF($fila2['idEv']);
               
                $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Plan de Accion</b></p></td>       
                    </tr>';
                if ($reporte2->num_rows > 0) {
                    foreach ($reporte2->result_array() as $fila2) {
                        $html .='
                    <tr colspan="5">
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Actividad:</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Meta Propuesta</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Meta Alcanzada</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Estatus</b></p></td>
                         
            </tr>       
            
                       <tr colspan="4">
                            <td colspan="1" ><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['metap'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['metaa'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['estatus'] . '</p></td>
                           
                        </tr>';
                    }
                } else {
                    $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> El evento no tiene plan de accion registrado.</b></p></td>    
                        </tr>';
                }
                  $html .='</table>';
             $html .='<h1></H1>';
            }
           
        } else {
            $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>No hay Eventos registrados</b></p></td>       
                    </tr>';
             $html .='</table>';
        }
       


        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }
    
    
    
    
     public function generarReporteActividadEvento() {
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
        $pdf->SetAlpha(1, 'Normal');
        $pdf->Image('imagen/logo/degradado.PNG', 30, 54, 100, 104, '', '', 'N', '', '', 'C');
        // recuperamos la opacidad por defecto 
        $pdf->SetAlpha(1, 'Normal');
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
        $html .="<h1>Reporte General de Metas alcanzada para las actividades</h1>";
        
        $condicion = 'evento.id=' . $idEvento;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        if ($reporte->num_rows > 0) {
            
            foreach ($reporte->result_array() as $fila2) {
                  $html .='
                    <table border="1">
                <tr colspan="4">
                       
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Evento</b></p></td>
                     
                         
                    </tr>   
                    
                      <tr colspan="4">
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         
                    </tr>


                  <tr colspan="4">
                           
                            <td colspan="1"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1"><p align="center">' . $fila2['estatus'] . '</p></td>
                        </tr>';
 
                $reporte2 = $this->actividad_model->cargarMetaPlandeAccionDeEventoPDF($fila2['idEv']);
               
                $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>Plan de Accion</b></p></td>       
                    </tr>';
                if ($reporte2->num_rows > 0) {
                    foreach ($reporte2->result_array() as $fila2) {
                        $html .='
                    <tr colspan="5">
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Actividad:</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Meta Propuesta</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Meta Alcanzada</b></p></td>
                        <td colspan="1" bgColor="#00BFFF"><p align="center"><b>Estatus</b></p></td>
                         
            </tr>       
            
                       <tr colspan="4">
                            <td colspan="1" ><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['metap'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['metaa'] . '</p></td>
                            <td colspan="1" ><p align="center">' . $fila2['estatus'] . '</p></td>
                           
                        </tr>';
                    }
                } else {
                    $html .='<tr colspan="4">
                             <td colspan="4"><p align="center"><b> El evento no tiene plan de accion registrado.</b></p></td>    
                        </tr>';
                }
                  $html .='</table>';
             $html .='<h1></H1>';
            }
           
        } else {
            $html.='<tr colspan="4">
                        <td colspan="4" bgColor="#429DED"><p align="center"><b>No hay Eventos registrados</b></p></td>       
                    </tr>';
             $html .='</table>';
        }
       


        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }


}
