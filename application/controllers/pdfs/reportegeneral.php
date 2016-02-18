<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportegeneral extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->database();
        $this->load->library('Pdf');
        $this->load->model('evento/evento_model');
        $this->load->library(array('session'));
        // date_default_timezone_set('America/Caracas');
    }

    public function generarReporteEventoGeneral() {


        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';
        $html .="<h1>Reporte General de Eventos</h1>";
        $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                    </tr>';
        $reporte = $this->evento_model->cargarListaEventoPDF();
        foreach ($reporte->result_array() as $fila2) {
            $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                        </tr>';
        }
        $html .='<tr>
                         <td colspan="16"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';



        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTodos() {
        $alcance = $this->input->get('alcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $tipo = $this->input->get('tipoEvento');
        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');

        $nalcance = $this->input->get('nalcance');
        $ntipo = $this->input->get('ntipoEvento');
        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                            
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td> 
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.sector=' . $sector . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="14"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

//================= Reportes con Tipo de Evento Seleccionado=====================================================================================
    public function generarReporteEventoGeneralSeleccionTipoEvento() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con el tipo de evento seleccionado.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoSector() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                       <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>                                
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="14"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgente() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.agente=' . $agente . ' and evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcance() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente Emisor</b></p></td>
                       <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoSectorAgente() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcance() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sectpr</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceSector() {

        $tipo = $this->input->get('tipoevento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>  Sector</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>  Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>  Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                                  <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoEstatusFecha() {

        $tipoE = $this->input->get('tipoevento');
        $estatus = $this->input->get('estatus');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $ntipoE = $this->input->get('ntipoEvento');
        $nestatus = $this->input->get('nestatus');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipoE . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipoE . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="29"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoSectorFecha() {

        $tipoE = $this->input->get('tipoevento');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $ntipoE = $this->input->get('ntipoEvento');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipoE . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipoE . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="29"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoSectorEstatus() {

        $tipoE = $this->input->get('tipoevento');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $ntipoE = $this->input->get('ntipoEvento');
        $nestatus = $this->input->get('nestatus');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipoE . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipoE . ' and evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                         
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                           
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoSectorAgenteAlcance() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance  </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                      
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                           
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance  </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                      
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                           
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');

        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance  </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $fecha . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                         <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $fecha . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.sector=' . $sector . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                         <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo . ' and evento.sector=' . $sector . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['agente'] . '</p></td>
                           
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

     public function generarReporteEventoGeneralSeleccionTipoEventoSectorEstatusFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $fecha . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.tipoevento=' . $tipo . ' and evento.sector=' . $sector . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                         <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="15"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }
    
    
   
    public function generarReporteEventoGeneralSeleccionTipoEventoSectorAgenteAlcanceEstatus() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                      
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                           
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="11"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

     public function generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceSectorFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance . ' and evento.fechatope="' . $fecha.'"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="3"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="3"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    
    
    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteAlcanceEstatusFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.alcance=' . $alcance . ' and evento.fechatope="' . $fecha.'"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="3"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="3"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    
    public function generarReporteEventoGeneralSeleccionTipoEventoAgenteSectorEstatusFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.agente=' . $agente . ' and evento.estatus=' . $estatus . ' and evento.fechatope="' . $fecha.'"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="3"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="3"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    
    public function generarReporteEventoGeneralSeleccionTipoEventoAlcanceSectorEstatusFecha() {

        $tipo = $this->input->get('tipoEvento');
        $ntipo = $this->input->get('ntipoEvento');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Tipo de Evento </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $ntipo . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.tipoevento=' . $tipo . ' and evento.estatus=' . $estatus . ' and evento.alcance=' . $alcance . ' and evento.fechatope="' . $fecha.'"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="3"><p align="center">' . $fila2['agente'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="13"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="3"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //====================================Reportes con Agente Seleccionado===========================================================================================

    public function generarReporteEventoGeneralSeleccionAgente() {

        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente Emisor </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con el agente seleccionado.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcance() {

        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteFecha() {

        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                                <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteSector() {

        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteEstatus() {

        $agente = $this->input->get('agente');
        $nagente = $this->input->get('nagente');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Agente </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.agente=' . $agente;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                       <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceSectorEstatusFecha() {
        $alcance = $this->input->get('alcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td> 
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '" and evento.sector=' . $sector . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceSectorEstatus() {
        $alcance = $this->input->get('alcance');
        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                         
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.sector=' . $sector . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteSectorEstatusFecha() {

        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                         
                    </tr>
                     
                    </table>';

        $condicion = 'evento.agente=' . $agente . ' and evento.sector=' . $sector . ' and evento.estatus=' . $estatus . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                                  <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="27"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceEstatusFecha() {
        $alcance = $this->input->get('alcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');


        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');




        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                       
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td> 
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '" and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                          <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="27"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceSectorFecha() {
        $alcance = $this->input->get('alcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));
        $agente = $this->input->get('agente');
        $sector = $this->input->get('sector');

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                        
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td> 
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '" and evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                                  <td colspan="5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="27"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceSector() {
        $alcance = $this->input->get('alcance');
        $agente = $this->input->get('agente');
        $sector = $this->input->get('sector');

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceFecha() {
        $alcance = $this->input->get('alcance');
        $agente = $this->input->get('agente');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');




        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="29"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteAlcanceEstatus() {
        $alcance = $this->input->get('alcance');
        $agente = $this->input->get('agente');
        $sector = $this->input->get('estatus');

        $nalcance = $this->input->get('nalcance');
        $nagente = $this->input->get('nagente');
        $nsector = $this->input->get('nestatus');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nalcance . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.agente=' . $agente . ' and evento.estatus=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteSectorEstatus() {
        $estatus = $this->input->get('estatus');
        $agente = $this->input->get('agente');
        $sector = $this->input->get('sector');

        $nestatus = $this->input->get('nestatus');
        $nagente = $this->input->get('nagente');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.agente=' . $agente . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteSectorFecha() {

        $agente = $this->input->get('agente');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nagente = $this->input->get('nagente');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAgenteEstatusFecha() {

        $agente = $this->input->get('agente');
        $estatus = $this->input->get('estatus');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nagente = $this->input->get('nagente');
        $nestatus = $this->input->get('nestatus');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Agente Emisor </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nagente . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.agente=' . $agente . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="29"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    //====================================Reportes con Alcance Seleccionado===========================================================================================


    public function generarReporteEventoGeneralSeleccionAlcance() {

        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con el alcance seleccionado.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceSectorEstatus() {
        $estatus = $this->input->get('estatus');
        $alcance = $this->input->get('alcance');
        $sector = $this->input->get('sector');

        $nestatus = $this->input->get('nestatus');
        $nalcance = $this->input->get('nalcance');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.alcance=' . $alcance . ' and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['agente'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceSectorFecha() {

        $alcance = $this->input->get('alcance');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nalcance = $this->input->get('nalcance');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.alcance=' . $alcance . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="5" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['agente'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                          <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceSectorEstatusFecha() {

        $alcance = $this->input->get('alcance');
        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nalcance = $this->input->get('nalcance');
        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                         
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.sector=' . $sector . ' and evento.estatus=' . $estatus . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                                  <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceSector() {

        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceEstatus() {

        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                       <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceFecha() {

        $alcance = $this->input->get('alcance');
        $nalcance = $this->input->get('nalcance');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Alcance </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.alcance=' . $alcance;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionAlcanceEstatusFecha() {

        $alcance = $this->input->get('alcance');
        $estatus = $this->input->get('estatus');

        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $nalcance = $this->input->get('nalcance');
        $nestatus = $this->input->get('nestatus');




        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                      
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nalcance . '</b></p></td>
                                                  
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                         
                    </tr>
                     
                    </table>';

        $condicion = 'evento.alcance=' . $alcance . ' and evento.estatus=' . $estatus . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    //====================================Reportes con Sector Seleccionado===========================================================================================


    public function generarReporteEventoGeneralSeleccionSector() {

        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con el sector seleccionado.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionSectorEstatus() {

        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus . ' and evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                       <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="17"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionSectorFecha() {

        $sector = $this->input->get('sector');
        $nsector = $this->input->get('nsector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Sector </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nsector . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.sector=' . $sector;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionSectorEstatusFecha() {


        $estatus = $this->input->get('estatus');
        $sector = $this->input->get('sector');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));


        $nestatus = $this->input->get('nestatus');
        $nsector = $this->input->get('nsector');



        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>

                    </tr>
              
                       
                 
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1" >
                   
                    <tr colspan="1"  width="5" heigth="5">
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                       
                        <td colspan="1" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                         <td colspan="1" bgColor="#429DED"><p align="center"><b>Fecha</b></p></td>
                        
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">

                        
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nsector . '</b></p></td>                           
                        <td colspan="1" bgColor=""><p align="center"><b>' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b>' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                         
                    </tr>
                     
                    </table>';

        $condicion = 'evento.sector=' . $sector . ' and evento.estatus=' . $estatus . ' and evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="2">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="16" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="5" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="2">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="16"><p align="center">' . $fila2['descripcion'] . '</p></td>
                             <td colspan="5"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                                  <td colspan="5"><p align="center">' . $fila2['alcance'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="24"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="5"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    //=========================================Estatus===============================================================================
    public function generarReporteEventoGeneralSeleccionEstatus() {

        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con el sector seleccionado.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    public function generarReporteEventoGeneralSeleccionEstatusFecha() {

        $estatus = $this->input->get('estatus');
        $nestatus = $this->input->get('nestatus');
        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Estatus </b></p></td>
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . $nestatus . '</b></p></td>
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("d-m-Y", strtotime($fecha)) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '" and evento.estatus=' . $estatus;
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['sector'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="19"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados con las características indicadas.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

    //======================================Fecha seleccionada====================================


    public function generarReporteEventoGeneralSeleccionFecha() {

        $fecha = date("Y-m-d", strtotime($this->input->get('fecha')));

        $pdf = new Pdf('L', 'mm', 'Legal', true, 'UTF-8', false);
        $pdf->setPageOrientation('l');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 12, '', true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $html = null;
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Image("imagen/logo/bannerprevengo2.png", $x = 5, $y = 5, $w = 290, $h = 40, $type = 'PNG', $link = '', $align = 'right', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->SetTextColor('0', '25', '215');
        $pdf->Text(130, 12, "República Bolivariana de Venezuela", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 17, "Gobernación del Estado Lara", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->Text(130, 23, "Oficina de Personal--División de Planificación y Presupuesto.", $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = 'left', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetTextColor('8', '8', '8');
        // $pdf->Text(50, 35, 'Reporte General de Eventos.');
        // $pdf->Ln(20);
        //$pdf->Text(30, 40, 'Fecha:' . date('d-m-Y'),  $align = 'rigth');
        $pdf->Ln(15);
        $pdf->SetFont('times', '', 11, '', true);
        $ano = date('Y');
        $mesesN = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $mes = $mesesN[date('n')];
        $dia = date('d');

        $html .='
                    <table>
                   
                    <tr colspan="8">
                        <td colspan="2"><p align="center"><b></b></p></td>
                        <td colspan="2" ><p align="center"><b></b></p></td>
                        <td colspan="2"><p align="center"><b>Barquisimeto, ' . $dia . ' de ' . $mes . ' del ' . $ano . '</b></p></td>
                    </tr>
                    </table>';


        $html .="<h1>Reporte General de Eventos con  las siguientes caracteristicas: </h1>";
        $html .='
                    <table border="1">
                    <tr colspan="1"  width="5" heigth="5">
                        <td colspan="1" bgColor="#429DED"><p align="center"><b> Fecha </b></p></td>
                    </tr>
                      <tr colspan="1"  width="5" heigth="5">    
                        <td colspan="1" bgColor=""><p align="center"><b> ' . date("Y-m-d", strtotime($this->input->get('fecha'))) . '</b></p></td>
                    </tr>
                     
                    </table>';

        $condicion = 'evento.fechatope="' . $fecha . '"';
        $reporte = $this->evento_model->cargarListaEventoSeleccionPDF($condicion);
        $html .="<H1></h1>";

        if ($reporte->num_rows() > 0) {
            $html .='
                    <table border="1">
                   
                    <tr colspan="8">
                        <td colspan="3" bgColor="#429DED"><p align="center"><b>Titulo</b></p></td>
                        <td colspan="10" bgColor="#429DED"><p align="center"><b>Descripción</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Tipo de Evento</b></p></td>
                         <td colspan="2" bgColor="#429DED"><p align="center"><b>Sector</b></p></td>
                          <td colspan="2" bgColor="#429DED"><p align="center"><b>Alcance</b></p></td>
                        <td colspan="2" bgColor="#429DED"><p align="center"><b>Agente</b></p></td>
                        <td colspan="2.5" bgColor="#429DED"><p align="center"><b>Estatus</b></p></td>
                        
                    </tr>';

            foreach ($reporte->result_array() as $fila2) {
                $html .='<tr colspan="8">
                            <td colspan="3"><p align="center">' . $fila2['titulo'] . '</p></td>
                            <td colspan="10"><p align="center">' . $fila2['descripcion'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['tipoEv'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['sector'] . '</p></td>
                                 <td colspan="2"><p align="center">' . $fila2['alcance'] . '</p></td>
                            <td colspan="2"><p align="center">' . $fila2['agente'] . '</p></td>
                            <td colspan="2.5"><p align="center">' . $fila2['estatus'] . '</p></td>
                            
                        </tr>';
            }
            $html .='<tr>
                         <td colspan="21"><p align="right"> Cantidad de Eventos:  </p></td>
                         <td colspan="2"><p align="center">' . $reporte->num_rows() . '</p></td>
                        </tr>
                    </table>';
        } else {

            $html.='<h1>No se encuentra eventos registrados para la fecha seleccionada.</h1>';
        }
        $nombre_archivo = utf8_decode("reporteEventos.pdf");
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'C', $autopadding = true);
        $pdf->Output($nombre_archivo, 'I');
    }

}
