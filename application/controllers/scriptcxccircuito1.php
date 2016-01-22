<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scriptcxccircuito extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('circuito_model');
        $this->nacionalidad = 'V';
        $this->cedula = $this->input->post('cedula');
        $this->load->library(array('session'));
        $this->load->library("email");
        $this->load->library('Pdf');
        date_default_timezone_set('America/Caracas');
    }

    public function index() {
        $circuito = $this->circuito_model->verificartipousuario();

        if ($circuito->num_rows > 0) {

            foreach ($circuito->result_array() as $row) {

                switch ($row['tipo']) {
                    case 2:$this->resmetacxcestados($row['us']);
                        break;
                    case 3: $this->resmetacxccircuito($row['us']);
                        break;
                    case 4:
                        $this->resmetacxcmunicipio($row['municipio'], $row['us']);
                        break;
                    case 5: $this->resmetacxcparroquia($row['municipio'], $row['parroquia'], $row['us']);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function resmetacxcestados($idus) {
        $data = $this->circuito_model->verificardatos($idus);

        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $row) {
                $result = array(
                    'correo=' => $row['correo'],
                    'nombre=' => $row['nombrecord'],
                    'apellido=' => $row['apellido']
                );


                $correop = $row['correo'];
                $nombrep = $row['nombrecord'] . " " . $row['apellido']. " ";
                if ($correop != NULL || $correop != '') {
                    print_r($nombrep);
                    $this->emailResumenestado($correop, $nombrep);
                }
            }
        }
    }

    public function resmetacxccircuito($tipo) {
        $circuitos = $this->circuito_model->verificarcircuitousuario($tipo);

        if ($circuitos->num_rows > 0) {
            foreach ($circuitos->result_array() as $row) {
                $result = array(
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'correo=' => $row['correo'],
                    'nombre=' => $row['nombre'],
                    'apellido=' => $row['apellido']
                );
                $idcircuito = $row['id'];
                $nombrecircuito = $row['nombre'];
                $correocordinador = $row['correo'];
                $nombrecordinador = $row['nombrecord'] . " " . $row['apellido']. " ";


                if ($correocordinador != NULL || $correocordinador != '') {
                    print_r($nombrecordinador);
                   // $this->emailResumencircuito($idcircuito, $nombrecircuito, $correocordinador, $nombrecordinador);
                }
            }
        }
    }

    public function resmetacxcmunicipio($municipio, $tipo) {

        $cmuni = $this->circuito_model->verificarcircuitousuario($tipo);
        if ($cmuni->num_rows > 0) {
            foreach ($cmuni->result_array() as $row) {
                $idcircuito = $row['id'];
                $nombrecircuito = $row['nombre'];
                $correocordinador = $row['correo'];
                $nombrecordinador = $row['nombrecord'] . " " . $row['apellido']. " ";

                if ($correocordinador != NULL || $correocordinador != '') {
                    print_r($nombrecordinador);
                    //$this->emailResumenMunicipio($idcircuito, $municipio, $nombrecircuito, $correocordinador, $nombrecordinador);
                }
            }
        }
    }

    public function resmetacxcparroquia($idmunicipio, $idparroquia, $tipo) {
        $circuito = $this->circuito_model->verificarcircuitousuario($tipo);

        if ($circuito->num_rows > 0) {
            foreach ($circuito->result_array() as $row) {
                $result = array(
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'correo=' => $row['correo'],
                    'nombre=' => $row['nombre'],
                    'apellido=' => $row['apellido']
                );
                $idcircuito = $row['id'];
                $nombrecircuito = $row['nombre'];
                $correocordinador = $row['correo'];
                $nombrecordinador = $row['nombrecord'] . " " . $row['apellido']. " ";

                if ($correocordinador != NULL || $correocordinador != '') {
                    print_r($nombrecordinador);
                    //$this->emailResumenParroquia($idcircuito, $idmunicipio, $idparroquia, $nombrecircuito, $correocordinador, $nombrecordinador);
                }
            }
        }
    }

    public function emailResumencircuito($idcircuito, $nombrecircuito, $correocordinador, $nombrecordinador) {
        $totalxcircuito = $this->circuito_model->verificartotalcircuito($idcircuito);
        if ($totalxcircuito->num_rows() > 0) {
            $row1 = $totalxcircuito->row_array();
            $cantidad = $row1['cantidad'];
            $user = 'sistemaelectoralavanzadalara@gmail.com';
            $pass = 'avanzadalara';
            $from = 'Sistema Casa x Casa';
            ;
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
            $this->correo->subject('Información de Registro de Contactos Diarios Circuito ' . $idcircuito);




            $totalxmunicipio = $this->circuito_model->verificartotalcirucitometa($idcircuito);
            $totplanixmunicipio = $this->circuito_model->verificartotalVisitasCircuito($idcircuito);

            if ($totplanixmunicipio->num_rows() > 0) {
                foreach ($totplanixmunicipio->result_array() as $muni) {
                    $totalVis = $muni['cantidadmuni'];
                }
            }

            if ($totalxmunicipio->num_rows() > 0) {
                foreach ($totalxmunicipio->result_array() as $met) {
                    $metaTotal = $met['totalcontmun'];
                }
            }
            $fecha = date('d-m-Y', strtotime('-1 day'));
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{ font-weight: bold;align=center}";
            $html .= "td{  align=center}";
            $html .= "</style>";
            $html .="<p>Estimado(a): <b>&nbsp; $nombrecordinador &nbsp;</b><b>&nbsp;</b></p>";
            $html .="<p>El siguiente correo es para informarle el total de registros de contactos CasaXCasa, realizados el día " . $fecha . " correspondientes a su municipio/parroquias</p>";
            $html .="<p>Cantidad de contactos CasaXCasa registrados en el <b>" . $nombrecircuito . "</b>: <b>" . $totalVis . "</b> de <b>" . $metaTotal . "</b> contactos.</p>";
            if ($totalVis > $metaTotal) {

                $html .="<p>Por lo tanto, La meta de hoy fue <b>SUPERADA EN EL " . $nombrecircuito . "</b></p>";
            } else {
                if ($totalVis < $metaTotal) {

                    $html .="<p>  Por lo tanto, <b>NO SE CUMPLIÓ </b> con la meta establecida en el " . $nombrecircuito . ".</p>";
                } else {
                    $html .="<p>Por lo tanto, La meta en el  " . $nombrecircuito . " ha sido <b>CUMPLIDA</b> satisfactoriamente</p>";
                }
            }

            $html .="<p>A continuacion se muestra un resumen detallado de los contactos registrados, correspondientes a su circuito, con el total de contacto registrados a la fecha</p>";
            $totalxmunicipio = $this->circuito_model->verificarmunicipio($idcircuito);
            if ($totalxmunicipio->num_rows() > 0) {
                $html .= "<h2>Resumen de Metas del $nombrecircuito </h2>";
                $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
                $html .= "<tr><td <td colspan='7'  bgcolor='#0000FF' align='center'><em><b> &nbsp;</b></em></td></tr>";
                $html .= "<tr bgcolor='#F3F781'>
		            <th><em>Municipio/Parroquia</em></th>
		            <th><em>Contactos Registrados</em></th>
		            <th><em>Meta Diaria</em></th>  
                            <th><em> % de contactos registrados</em></th>
		            <th><em> Total de contactos registrados a la fecha</em></th>
                            <th><em>Meta Total</em></th>
                             <th><em> % de contactos registrados a la fecha</em></th>
		       </tr>";
                foreach ($totalxmunicipio->result_array() as $mun) {
                    $municipio = substr($mun['municipio'], 4);
                    $idmunicipio = $mun['idmunicipio'];
                    $totplanixmunicipio = $this->circuito_model->verificartotalmunicipio($idcircuito, $idmunicipio);
                    $totcontacxmunicipio = $this->circuito_model->verificartotalmunicipicontac($idcircuito, $idmunicipio);
                    /* metatotal */ $totmetatotalxmunicipio = $this->circuito_model->verificartotalmunicipiometatotal($idcircuito, $idmunicipio);
                    /* acumulado */$totplanixmunicipiotodo = $this->circuito_model->verificartotalmunicipioTodas($idcircuito, $idmunicipio);


                    if ($totalxcircuito->num_rows() > 0) {
                        $row2 = $totplanixmunicipio->row_array();
                        $cantidadmuni = $row2['cantidadmuni'];
                    }
                    if ($totcontacxmunicipio->num_rows() > 0) {
                        $row3 = $totcontacxmunicipio->row_array();
                        $totalcontmuni = $row3['totalcontmun'];
                    }
                    if ($totmetatotalxmunicipio->num_rows() > 0) {
                        $row4 = $totmetatotalxmunicipio->row_array();

                        $totalmetamun = $row4['totalmetamun'];
                    }


                    if ($totplanixmunicipiotodo->num_rows() > 0) {
                        foreach ($totplanixmunicipiotodo->result_array() as $TMun) {
                            $acumMun = $TMun['todoMun'];
                        }
                    }


                    $difMun = ($totalcontmuni - $cantidadmuni);
                    $totalMun = round((($cantidadmuni / $totalcontmuni) * 100), 2) . '%';
                    $totalF = round((($difMun / $totalcontmuni) * 100), 2) . '%';

                    $totalTotalMun ='';
                    $difTotalMun = ($totalmetamun - $acumMun);
                    $totalTotalMun = round((($acumMun / $totalmetamun) * 100), 2) . '%';
                    $totalFTotal = round((($difTotalMun / $totalmetamun) * 100), 2) . '%';



                    $html .= '<tr bgcolor="#FAAC58">
	                <td align="middle">' . mb_convert_case(substr($mun["municipio"], 4), MB_CASE_TITLE, "UTF-8") . '</td>
	                <td align="middle">' . mb_convert_case($cantidadmuni, MB_CASE_TITLE, "UTF-8") . '</td>
	              	<td align="middle">' . mb_convert_case($totalcontmuni, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalMun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($acumMun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalmetamun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalTotalMun, MB_CASE_TITLE, "UTF-8") . '</td>
	              	
	              	
			</tr>';

                    $totalxparroquia = $this->circuito_model->verificarparroquia($idmunicipio, $idcircuito);

                    foreach ($totalxparroquia->result_array() as $parr) {
                        $nombreparr = substr($parr['parroquia'], 4);
                        $idparroquia = $parr['idparroquia'];
                        $totplanixparroquia = $this->circuito_model->verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia);
                        if ($totplanixparroquia->num_rows() > 0) {
                            $row3 = $totplanixparroquia->row_array();
                            $cantidadparr = $row3['cantidadparri'];
                        }
                        $totmeta = $this->circuito_model->verificarmetaparroquia($idparroquia);
                        if ($totmeta->num_rows() > 0) {
                            $row4 = $totmeta->row_array();
                            $meta = $row4['meta_diaria'];
                            $metatotalparr = $row4['total_contacto'];
                            $difParr = $meta - $cantidadparr;
                            $totalrealizada = round(((($cantidadparr) / $meta) * 100), 2) . '%';
                            $total = round((($difParr / $meta) * 100), 2) . '%';
                        }

                        $totalparroquiatodas = $this->circuito_model->verificartotalparroquiatodas($idcircuito, $idmunicipio, $idparroquia);
                        if ($totalparroquiatodas->num_rows() > 0) {
                            foreach ($totalparroquiatodas->result_array() as $Tparr) {
                                $acum = $Tparr['todosParr'];
                            }
                        }
                        $totalTotalParr='';
                        $difTotalParr = ($metatotalparr - $acum);
                        $totalTotalParr = round((($acum / $metatotalparr) * 100), 2) . '%';
                        $totalFTotalParr = round((($difTotalParr / $metatotalparr) * 100), 2) . '%';

                        $html .= '<tr>
			                <td align="middle">' . mb_convert_case($nombreparr, MB_CASE_TITLE, "UTF-8") . '</td>
			                <td align="middle">' . mb_convert_case($cantidadparr, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($meta, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($totalrealizada, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($acum, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($metatotalparr, MB_CASE_TITLE, "UTF-8") . '</td>   
                                        <td align="middle">' . mb_convert_case($totalTotalParr, MB_CASE_TITLE, "UTF-8") . '</td>   
			          	</tr>';
                    }
                }
                $html .= "</table>";
            }

            $html .="<p><b>Lara Progresista</b></p>'";
            $this->correo->message($html);
            $this->correo->send();
        }
    }

    public function emailResumenMunicipio($idcircuito, $idmunicipio, $nombrecircuito, $correocordinador, $nombrecordinador) {
        echo json_encode($idmunicipio);
        $totalxcircuitomunicipio = $this->circuito_model->verificartotalVisitasCircuitoMunicipio($idcircuito, $idmunicipio);
        if ($totalxcircuitomunicipio->num_rows() > 0) {
            $row2 = $totalxcircuitomunicipio->row_array();
            $cantidad = $row2['cantidadmuni'];
            $nombremunicipio = substr($row2['municipio'], 4);
            $user = 'sistemaelectoralavanzadalara@gmail.com';
            $pass = 'avanzadalara';
            $from = 'Sistema Casa x Casa';
            ;
            $this->load->library('email', '', 'correo');
            $configGmail = array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
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
            $this->correo->subject('Información de Registro de Contactos Diarios Municipio ' . $nombremunicipio);

            $totalxmunicipiometa = $this->circuito_model->verificartotalmunicipiometa($idcircuito, $idmunicipio);
            $totplanixmunicipiot = $this->circuito_model->verificartotalVisitasCircuitoMunicipio($idcircuito, $idmunicipio);

            if ($totplanixmunicipiot->num_rows() > 0) {
                foreach ($totplanixmunicipiot->result_array() as $muni) {
                    $totalVisitaM = $muni['cantidadmuni'];
                }
            }

            if ($totalxmunicipiometa->num_rows() > 0) {
                foreach ($totalxmunicipiometa->result_array() as $met) {
                    $metaTotalMun = $met['totalcontmun'];
                }
            }



            $fecha = date('d-m-Y', strtotime('-1 day'));
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{ font-weight: bold;align=center}";
            $html .= "td{  align=center}";
            $html .= "</style>";
            $html .="<p>Estimado(a): <b>&nbsp; $nombrecordinador &nbsp;</b><b>&nbsp;</b></p>";
            $html .="<p>El siguiente correo es para informarle el total de registros de contactos CasaXCasa, realizados el día " . $fecha . " correspondientes a su municipio/parroquias</p>";
            $html .="<p>Cantidad de contactos CasaXCasa registrados municipio <b>" . $nombremunicipio . "</b>:<b>" . $totalVisitaM . "</b> de <b>" . $metaTotalMun . "</b> contactos.</p>";
            if ($totalVisitaM > $metaTotalMun) {

                $html .="<p>Por lo tanto, La meta en el municipio " . $nombremunicipio . " fue <b>SUPERADA</b></p>";
            } else {
                if ($totalVisitaM < $metaTotalMun) {

                    $html .="<p>Por lo tanto, <b>NO SE CUMPLIÓ </b> con la meta establecida EN EL MUNICIPIO " . $nombremunicipio . ".</p>";
                } else {
                    $html .="<p>Por lo tanto, La meta en el municipio " . $nombremunicipio . " ha sido <b>CUMPLIDA </b> satisfactoriamente</p>";
                }
            }


            $html .="<p>A continuacion se muestra un resumen detallado de los contactos registrados, correspondientes a su circuito, con el total de contacto registrados a la fecha</p>";
            $totalxmunicipiocuadro = $this->circuito_model->verificarmunicipio($idcircuito);
            if ($totalxmunicipiocuadro->num_rows() > 0) {
                $html .= "<h2>Resumen de Metas del $nombrecircuito </h2>";
                $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
                $html .= "<tr><td <td colspan='7'  bgcolor='#0000FF' align='center'><em><b> &nbsp;</b></em></td></tr>";
                $html .= "<tr bgcolor='#F3F781'>
		            <th><em>Municipio/Parroquia</em></th>
		            <th><em>Contactos Registrados</em></th>
		            <th><em>Meta Diaria</em></th>
                           
                            <th><em> % de contactos registrados</em></th>
		            <th><em> Total de contactos regsitrados a la fecha</em></th>
                             <th><em>Meta Total</em></th>
                             <th><em> % de contactos registrados a la fecha</em></th>
		       </tr>";
                foreach ($totalxmunicipiocuadro->result_array() as $mun) {
                    $municipio = $mun['municipio'];
                    $idmunicipio = $mun['idmunicipio'];
                    /* meta */ $totmetaxmunicipio = $this->circuito_model->verificartotalmunicipiometa($idcircuito, $idmunicipio);
                    /* metatotal */ $totmetatotalxmunicipio = $this->circuito_model->verificartotalmunicipiometatotal($idcircuito, $idmunicipio);
                    /* registros */ $totcontacxmunicipio = $this->circuito_model->verificartotalmunicipicontac($idcircuito, $idmunicipio);
                    /* acumulado */ $totplanixmunicipiotodo = $this->circuito_model->verificartotalmunicipioTodas($idcircuito, $idmunicipio);


                    if ($totalxcircuitomunicipio->num_rows() > 0) {
                        $row2 = $totalxcircuitomunicipio->row_array();
                        $cantidadmuni = $row2['cantidadmuni'];
                    }


                    if ($totmetaxmunicipio->num_rows() > 0) {
                        $row3 = $totmetaxmunicipio->row_array();
                        $totalcontmuni = $row3['totalcontmun'];
                    }

                    if ($totmetatotalxmunicipio->num_rows() > 0) {
                        $row4 = $totmetatotalxmunicipio->row_array();

                        $totalmetamun = $row4['totalmetamun'];
                    }

                    if ($totplanixmunicipiotodo->num_rows() > 0) {
                        foreach ($totplanixmunicipiotodo->result_array() as $TMun) {
                            $acumMun = $TMun['todoMun'];
                        }
                    }

                    $difMun = ($totalcontmuni - $cantidadmuni);
                    $totalMun = round((($cantidadmuni / $totalcontmuni) * 100), 2) . '%';
                    $totalF = round((($difMun / $totalcontmuni) * 100), 2) . '%';
                     
                    $totalMunT='';
                    $difMunT = ($totalmetamun - $acumMun);
                    $totalMunT = round((($acumMun / $totalmetamun) * 100), 2) . '%';
                    $totalFMunT = round((($difMunT / $totalmetamun) * 100), 2) . '%';



                    $html .= '<tr bgcolor="#FAAC58">
	                <td align="middle">' . mb_convert_case(substr($mun["municipio"], 4), MB_CASE_TITLE, "UTF-8") . '</td>
	                <td align="middle">' . mb_convert_case($cantidadmuni, MB_CASE_TITLE, "UTF-8") . '</td>
	              	<td align="middle">' . mb_convert_case($totalcontmuni, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalMun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($acumMun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalmetamun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalMunT, MB_CASE_TITLE, "UTF-8") . '</td>
			</tr>';

                    $totalxparroquia = $this->circuito_model->verificarparroquia($idmunicipio, $idcircuito);

                    foreach ($totalxparroquia->result_array() as $parr) {
                        $nombreparr = substr($parr['parroquia'], 4);
                        $idparroquia = $parr['idparroquia'];
                        $totplanixparroquia = $this->circuito_model->verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia);
                        if ($totplanixparroquia->num_rows() > 0) {
                            $row3 = $totplanixparroquia->row_array();
                            $cantidadparr = $row3['cantidadparri'];
                        }
                        $totmeta = $this->circuito_model->verificarmetaparroquia($idparroquia);
                        if ($totmeta->num_rows() > 0) {
                            $row4 = $totmeta->row_array();
                            $meta = $row4['meta_diaria'];
                            $metatotalparr = $row4['total_contacto'];
                            $difParr = $meta - $cantidadparr;
                            $totalrealizada = round(((($cantidadparr) / $meta) * 100), 2) . '%';
                            $total = round((($difParr / $meta) * 100), 2) . '%';
                        }

                        $totalparroquiatodas = $this->circuito_model->verificartotalparroquiatodas($idcircuito, $idmunicipio, $idparroquia);
                        if ($totalparroquiatodas->num_rows() > 0) {
                            foreach ($totalparroquiatodas->result_array() as $Tparr) {
                                $acum = $Tparr['todosParr'];
                            }
                        }
                        $totalParrT='';
                        $difParrT = ($metatotalparr - $acum);
                        $totalParrT = round((($acum / $metatotalparr) * 100), 2) . '%';
                        $totalFParrT = round((($difParrT / $metatotalparr) * 100), 2) . '%';

                        $html .= '<tr>
			                <td align="middle">' . mb_convert_case($nombreparr, MB_CASE_TITLE, "UTF-8") . '</td>
			                <td align="middle">' . mb_convert_case($cantidadparr, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($meta, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($totalrealizada, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($acum, MB_CASE_TITLE, "UTF-8") . '</td>
			          	<td align="middle">' . mb_convert_case($metatotalparr, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($totalParrT, MB_CASE_TITLE, "UTF-8") . '</td>  
                                          </tr>';
                    }
                }
                $html .= "</table>";

                $html .="<p><b>Lara Progresista</b></p>'";
                $this->correo->message($html);
                $this->correo->send();
            }
        }
    }

    public function emailResumenParroquia($idcircuito, $idmunicipio, $idparroquia, $nombrecircuito, $correocordinador, $nombrecordinador) {
        print_r($idparroquia);
        $totalxcircuitoparroquia = $this->circuito_model->verificartotalVisitasCircuitoParroquia($idcircuito, $idmunicipio, $idparroquia);
        if ($totalxcircuitoparroquia->num_rows() > 0) {
            $row2 = $totalxcircuitoparroquia->row_array();
            $nombreparroquia = substr($row2['parroquia'], 4);
            $user = 'sistemaelectoralavanzadalara@gmail.com';
            $pass = 'avanzadalara';
            $from = 'Sistema Casa x Casa';
            ;
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
            $this->correo->subject('Información de Registro de Contactos Diarios Parroquia ' . $nombreparroquia);


            //Metas por la parroquia 
            $totmetaparr = $this->circuito_model->verificarmetaparroquia($idparroquia);
            if ($totmetaparr->num_rows() > 0) {
                $row4 = $totmetaparr->row_array();
                $metaParr = $row4['meta_diaria'];
            }

            //Planillas por la parroquia
            $totplanixparroquia = $this->circuito_model->verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia);
            if ($totplanixparroquia->num_rows() > 0) {
                $row3 = $totplanixparroquia->row_array();
                $cantidadparr = $row3['cantidadparri'];
            }

            $fecha = date('d-m-Y', strtotime('-1 day'));
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{ font-weight: bold;align=center}";
            $html .= "td{  align=center}";
            $html .= "</style>";
            $html .="<p>Estimado(a): <b>&nbsp; $nombrecordinador &nbsp;</b><b>&nbsp;</b></p>";
            $html .="<p>El siguiente correo es para informarle el total de registros de contactos CasaXCasa, realizados el día " . $fecha . " correspondientes a su municipio/parroquias</p>";
            $html .="<p>Cantidad de contactos CasaXCasa registrados parroquia <b>" . $nombreparroquia . "</b>:<b>" . $cantidadparr . "</b> de <b>" . $metaParr . "</b> contactos.</p>";
            if ($cantidadparr > $metaParr) {

                $html .="<p>Por lo tanto, La meta en la  parroquia  " . $nombreparroquia . " fue <b>SUPERADA</b></p>";
            } else {
                if ($cantidadparr < $metaParr) {

                    $html .="<p>Por lo tanto, <b>NO SE CUMPLIÓ  </b> con la meta establecida en la PARROQUIA " . $nombreparroquia . ".</p>";
                } else {
                    $html .="<p>Por lo tanto, La meta en la parroquia " . $nombreparroquia . " ha sido <b>CUMPLIDA </b> satisfactoriamente</p>";
                }
            }

            $html .="<p>A continuacion se muestra un resumen detallado de los contactos registrados, correspondientes a su municipio, con el total de contacto registrados a la fecha</p>";

            $totalxmunicipiocuadro = $this->circuito_model->verificarmunicipiocircuito($idcircuito, $idmunicipio);
            if ($totalxmunicipiocuadro->num_rows() > 0) {

                $row2 = $totalxmunicipiocuadro->row_array();
                $html .= "<h2>Resumen de Metas del  Municipio " . substr($row2['municipio'], 4) . " </h2>";
                $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
                $html .= "<tr><td <td colspan='7'  bgcolor='#0000FF' align='center'><em><b> &nbsp;</b></em></td></tr>";
                $html .= "<tr bgcolor='#F3F781'>
                  <th><em>Municipio/Parroquia</em></th>
                  <th><em>Contactos Registrados</em></th>
                  <th><em>Meta Diaria</em></th>
                  <th><em> % de contactos registrados</em></th>
                  <th><em> Total de contactos regsitrados a la fecha</em></th>
                   <th><em>Meta Total</em></th>
                   <th><em> % de contactos registrados a la fecha</em></th>
                  </tr>";
                foreach ($totalxmunicipiocuadro->result_array() as $mun) {
                    $municipio = $mun['municipio'];
                    $totmetaxmunicipio = $this->circuito_model->verificartotalmunicipiometa($idcircuito, $idmunicipio);
                    $totcontacxmunicipio = $this->circuito_model->verificartotalmunicipicontac($idcircuito, $idmunicipio);
                    /* metatotal */ $totmetatotalxmunicipio = $this->circuito_model->verificartotalmunicipiometatotal($idcircuito, $idmunicipio);
                    /* acumulado */ $totplanixmunicipiotodo = $this->circuito_model->verificartotalmunicipioTodas($idcircuito, $idmunicipio);
                    $totalxcircuitomunicipio = $this->circuito_model->verificartotalVisitasCircuitoMunicipio($idcircuito, $idmunicipio);
                    if ($totalxcircuitomunicipio->num_rows() > 0) {
                        $row2 = $totalxcircuitomunicipio->row_array();
                        $cantidadmuni = $row2['cantidadmuni'];
                    }

                    $totmetaxmunicipio = $this->circuito_model->verificartotalmunicipiometa($idcircuito, $idmunicipio);
                    if ($totmetaxmunicipio->num_rows() > 0) {
                        $row3 = $totmetaxmunicipio->row_array();
                        $totalcontmuni = $row3['totalcontmun'];
                    }
                    if ($totmetatotalxmunicipio->num_rows() > 0) {
                        $row4 = $totmetatotalxmunicipio->row_array();

                        $totalmetamun = $row4['totalmetamun'];
                    }

                    if ($totplanixmunicipiotodo->num_rows() > 0) {
                        foreach ($totplanixmunicipiotodo->result_array() as $TMun) {
                            $acumMun = $TMun['todoMun'];
                        }
                    }

                    $difMun = ($totalmetamun - $cantidadmuni);
                    $totalMun = round((($cantidadmuni / $totalmetamun) * 100), 2) . '%';
                    $totalF = round((($difMun / $totalmetamun) * 100), 2) . '%';


                    $difMunT = ($totalcontmuni - $acumMun);
                    $totalMunT = round((($acumMun / $totalcontmuni) * 100), 2) . '%';
                    $totalFMunT = round((($difMunT / $totalcontmuni) * 100), 2) . '%';


                    $html .= '<tr bgcolor="#FAAC58">
                  <td align="middle">' . mb_convert_case(substr($mun["municipio"], 4), MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($cantidadmuni, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalcontmuni, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalMun, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($acumMun, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalmetamun, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalMunT, MB_CASE_TITLE, "UTF-8") . '</td>
                  </tr>';

                    $totalxparroquia = $this->circuito_model->verificarparroquia($idmunicipio, $idcircuito);

                    foreach ($totalxparroquia->result_array() as $parr) {
                        $nombreparr = substr($parr['parroquia'], 4);
                        $idparroquia = $parr['idparroquia'];
                        $totplanixparroquia = $this->circuito_model->verificartotalparroquia($idcircuito, $idmunicipio, $idparroquia);
                        if ($totplanixparroquia->num_rows() > 0) {
                            $row3 = $totplanixparroquia->row_array();
                            $cantidadparr = $row3['cantidadparri'];
                        }
                        $totmeta = $this->circuito_model->verificarmetaparroquia($idparroquia);
                        if ($totmeta->num_rows() > 0) {
                            $row4 = $totmeta->row_array();
                            $meta = $row4['meta_diaria'];
                            $metaparr = $row4['total_contacto'];
                            $difParr = $meta - $cantidadparr;
                            $totalrealizada = round(((($cantidadparr) / $meta) * 100), 2) . '%';
                            $total = round((($difParr / $meta) * 100), 2) . '%';
                        }

                        $totalparroquiatodas = $this->circuito_model->verificartotalparroquiatodas($idcircuito, $idmunicipio, $idparroquia);
                        if ($totalparroquiatodas->num_rows() > 0) {
                            foreach ($totalparroquiatodas->result_array() as $Tparr) {
                                $acum = $Tparr['todosParr'];
                            }
                        }
                        
                        
                    $difParrT = ($metaparr - $acum);
                    $totalParrT = round((($acum / $metaparr) * 100), 2) . '%';
                    $totalFParrT = round((($difParrT / $metaparr) * 100), 2) . '%';

                        $html .= '<tr>
                  <td align="middle">' . mb_convert_case($nombreparr, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($cantidadparr, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($meta, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalrealizada, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($acum, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($metaparr, MB_CASE_TITLE, "UTF-8") . '</td>
                  <td align="middle">' . mb_convert_case($totalParrT, MB_CASE_TITLE, "UTF-8") . '</td>
                  </tr>';
                    }
                }
                $html .= "</table>";

                $html .="<p><b>Lara Progresista</b></p>'";
                $this->correo->message($html);
                $this->correo->send();
            }
        }
    }

    // correo con todos los circuitos
    public function emailResumenestado($correocordinador, $nombrecordinador) {

        print_r($nombrecordinador);

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
        $this->correo->subject('Información de Registro de Contactos Diarios Estado Lara');




        $totalxestado = $this->circuito_model->verificartotalmeta();
        $totplanixestado = $this->circuito_model->verificartotalVisitas();

        if ($totplanixestado->num_rows() > 0) {
            foreach ($totplanixestado->result_array() as $mu) {
                $totalVisiEs = $mu['cantidadtotal'];
            }
        }

        if ($totalxestado->num_rows() > 0) {
            foreach ($totalxestado->result_array() as $mt) {
                $metaTotalEst = $mt['totalcontmun'];
            }
        }


        $fecha = date('d-m-Y', strtotime('-1 day'));
        $html = '';
        $html .= "<style type=text/css>";
        $html .= "th{ font-weight: bold;align=center}";
        $html .= "td{  align=center}";
        $html .= "</style>";
        $html .="<p>Estimado(a): <b>&nbsp; $nombrecordinador &nbsp;</b><b>&nbsp;</b></p>";
        $html .="<p>El siguiente correo es para informarle el total de registros de contactos CasaXCasa, realizados el día " . $fecha . " en el estado Lara</p>";
        $html .="<p>Cantidad de contactos CasaXCasa registrados en el estado <b> LARA </b>: <b>" . $totalVisiEs . "</b> de <b>" . $metaTotalEst . "</b> contactos.</p>";
        if ($totalVisiEs > $metaTotalEst) {

            $html .="<p>Por lo tanto, La meta en el Estado LARA fue <b>SUPERADA</b></p>";
        } else {
            if ($totalVisiEs < $metaTotalEst) {

                $html .="<p>  Por lo tanto, <b>NO SE CUMPLIÓ </b> con la meta establecida en el ESTADO LARA.</p>";
            } else {
                $html .="<p>Por lo tanto, La meta en el Estado LARA ha sido <b>CUMPLIDA</b> satisfactoriamente</p>";
            }
        }

        $html .="<p>A continuacion se muestra un resumen detallado de los contactos registrados del estado, con el total de contacto registrados a la fecha</p>";
        for ($i = 1; $i <= 3; $i++) {

            $totalxmunicipios = $this->circuito_model->verificarmunicipio($i);
            if ($totalxmunicipios->num_rows() > 0) {
                $html .= "<h2>Resumen de Metas del CIRCUITO $i</h2>";
                $html .= "<table width='100%' border='1' cellpadding='0' cellspacing='0' >";
                $html .= "<tr><td <td colspan='7'  bgcolor='#0000FF' align='center'><em><b> &nbsp;</b></em></td></tr>";
                $html .= "<tr bgcolor='#F3F781'>
		            <th><em>Municipio/Parroquia</em></th>
		            <th><em>Contactos Registrados</em></th>
		            <th><em>Meta Diaria</em></th>
                            <th><em> % de contactos registrados</em></th>
		            <th><em> Total de contactos regsitrados a la fecha</em></th>
                            <th><em>Meta Total</em></th>
                            <th><em> % de contactos registrados a la fecha</em></th>                          

		       </tr>";
                foreach ($totalxmunicipios->result_array() as $mni) {
                    $nmunicipio = substr($mni['municipio'], 4);
                    $idmunicip = $mni['idmunicipio'];
                    $totplanixmunicipioes = $this->circuito_model->verificartotalmunicipio($i, $idmunicip);
                    $totcontacxmunicipioes = $this->circuito_model->verificartotalmunicipicontac($i, $idmunicip);
                    /* metatotal */ $totmetatotalxmunicipio = $this->circuito_model->verificartotalmunicipiometatotal($i, $idmunicip);


                    if ($totplanixmunicipioes->num_rows() > 0) {
                        $rowes = $totplanixmunicipioes->row_array();
                        $cantidadmunies = $rowes['cantidadmuni'];
                    }
                    if ($totcontacxmunicipioes->num_rows() > 0) {
                        $rowes3 = $totcontacxmunicipioes->row_array();
                        $totalcontmunies = $rowes3['totalcontmun'];
                    }


                    if ($totmetatotalxmunicipio->num_rows() > 0) {
                        $row4 = $totmetatotalxmunicipio->row_array();

                        $totalmetamun = $row4['totalmetamun'];
                    }
                    $totplanixmunicipiotodoes = $this->circuito_model->verificartotalmunicipioTodas($i, $idmunicip);

                    if ($totplanixmunicipiotodoes->num_rows() > 0) {
                        foreach ($totplanixmunicipiotodoes->result_array() as $TMun) {
                            $acumMunes = $TMun['todoMun'];
                        }
                    }

                    $difeMunEs = ($totalcontmunies - $cantidadmunies);
                    $totalMunEs = round((($cantidadmunies / $totalcontmunies) * 100), 2) . '%';
                    $totalFalEs = round((($difeMunEs / $totalcontmunies) * 100), 2) . '%';

                    $totalEsTotal='';
                    $totalEsTotal = round((($acumMunes / $totalmetamun) * 100), 2) . '%';
                    $difeMunEsTotal = ($totalmetamun - $acumMunes);
                    $totalFalEsTotal = round((($difeMunEsTotal / $totalmetamun) * 100), 2) . '%';

                    $html .= '<tr bgcolor="#FAAC58">
	                <td align="middle">' . mb_convert_case($nmunicipio, MB_CASE_TITLE, "UTF-8") . '</td>
	                <td align="middle">' . mb_convert_case($cantidadmunies, MB_CASE_TITLE, "UTF-8") . '</td>
	              	<td align="middle">' . mb_convert_case($totalcontmunies, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalMunEs, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($acumMunes, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalmetamun, MB_CASE_TITLE, "UTF-8") . '</td>
                        <td align="middle">' . mb_convert_case($totalEsTotal, MB_CASE_TITLE, "UTF-8") . '</td>
	              	
	              	
			</tr>';

                    $totalxparroquiaes = $this->circuito_model->verificarparroquia($idmunicip, $i);

                    foreach ($totalxparroquiaes->result_array() as $parr) {
                        $nombreparres = substr($parr['parroquia'], 4);
                        $idparroquiaes = $parr['idparroquia'];
                        $totalxparroquiaes = $this->circuito_model->verificartotalparroquia($i, $idmunicip, $idparroquiaes);

                        if ($totalxparroquiaes->num_rows() > 0) {
                            $row3 = $totalxparroquiaes->row_array();
                            $cantidadparres = $row3['cantidadparri'];
                        }
                        $totmetaes = $this->circuito_model->verificarmetaparroquia($idparroquiaes);
                        if ($totmetaes->num_rows() > 0) {
                            $row4 = $totmetaes->row_array();
                            $metaes = $row4['meta_diaria'];
                            $metatot = $row4['total_contacto'];
                            $difParr = $metaes - $cantidadparres;
                            //diferencia diaria
                            $totalrealizadaes = round(((($cantidadparres) / $metaes) * 100), 2) . '%';
                            $totaleses = round((($difParr / $metaes) * 100), 2) . '%';
                        }

                        $totalparroquiatodas = $this->circuito_model->verificartotalparroquiatodas($i, $idmunicip, $idparroquiaes);
                        if ($totalparroquiatodas->num_rows() > 0) {
                            foreach ($totalparroquiatodas->result_array() as $Tparr) {
                                $acumes = $Tparr['todosParr'];
                            }
                        }



                        $totalEsParrTotal = round((($acumes / $metatot) * 100), 2) . '%';
                        //diferencia total
                        $difeParrEsTotal = ($metatot - $acumes);
                        $totalFalEsTotal = round((($difeParrEsTotal / $metatot) * 100), 2) . '%';

                        $html .= '<tr>
			                <td align="middle">' . mb_convert_case($nombreparres, MB_CASE_TITLE, "UTF-8") . '</td>
			                <td align="middle">' . mb_convert_case($cantidadparres, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($metaes, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($totalrealizadaes, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($acumes, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($metatot, MB_CASE_TITLE, "UTF-8") . '</td>
                                        <td align="middle">' . mb_convert_case($totalEsParrTotal, MB_CASE_TITLE, "UTF-8") . '</td>
                                    </tr>';
                    }
                }
                $html .= "</table>";
            }
        }
        $html .="<p><b>Lara Progresista</b></p>'";
        $this->correo->message($html);
        $this->correo->send();
    }

} 
