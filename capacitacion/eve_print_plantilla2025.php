<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_cap_eventos.php");
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");
require_once('../tcpdf/tcpdf.php');
s_validar_pagina();
$bo_persona  = new bo_gen_personas();
$bo_eventos  = new bo_cap_eventos();
$bo_eventos_mat  = new cap_eventos_matricula();

$ent_personas = new gen_personas();
$ent_evento = new cap_eventos();

$cc_evento_mat  = s_crypt($_REQUEST["cod"], 'out');
$c_persona      = s_crypt($_REQUEST["pe"], 'out');
$cc_evento      = s_crypt($_REQUEST["eve"], 'out');
$tipo           = s_crypt($_REQUEST["tp"], 'out');

//echo $cc_evento_mat;

$ent_evento->setCc_evento($cc_evento);
$data_evento = $bo_eventos->listarID($ent_evento);
foreach ($data_evento as $eve) {
    $certificado  = $eve["img_certificado"];
    $cuerpo_text  = htmlspecialchars_decode($eve["detalle"], ENT_QUOTES);
    $fecha_text   = $eve["fecha_evento_text"];
    $creditos     = $eve["horascreditos_text"];
    $print_documento = $eve["print_documento"];
}

$ent_personas->setC_persona($c_persona);
$data_per = $bo_persona->listarID($ent_personas);
foreach ($data_per as $row) {
    $grado = ($row["grado"]);
    $nombre = ($row["nombre_completo"]);
}

$calidades = [
    'A' => 'ASISTENTE',
    'P' => 'PONENTE',
    'O' => 'ORGANIZADOR(A)',
];


$tipo = $tipo ?? 'A';
$calidad = $calidades[$tipo] ?? 'ASISTENTE';

$var1 = $certificado;
ob_end_clean();
class MYPDF extends TCPDF
{

    public function Header()
    {
        global $var1;
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = "../capacitacion/img/" . $var1;
        //$img_file = "http://200.37.231.67:8080/pegasoweb/capacitacion/img/" . $var1;
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// add a page
$pdf->AddPage('L', 'A4');
$style = array(
    'border' => 2,
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

// *** Color azul #061d49 ***
$pdf->SetTextColor(6, 29, 73);

$pdf->SetY(75);
$pdf->SetFont("times", "BI", 16, '', 'false');
$html = '<h1 align="center">Otorgado a: ' . $grado . ' ' . $nombre . '</h1>';
$pdf->writeHTML($html, true, 0, true, 0);
$pdf->Ln();

$pdf->SetY(90);
$pdf->Write(0, 'En calidad de: ' . $calidad, '', 0, 'C', true, 0, false, false, 0);

$pdf->SetY(105);
$pdf->SetX(50);
$pdf->SetMargins(40, 40, 40, true);
$pdf->SetFont("times", "BI", 14, '', 'false');
$pdf->Write(0, $cuerpo_text, '', 0, 'C', true, 0, false, false, 0);
/**texto***/

/*fecha*/
$pdf->SetY(135);
$pdf->SetFont("times", "BI", 11, '', 'false');
$html = '<p align="right">' . $fecha_text . '</p>';
$pdf->writeHTML($html, true, 0, true, 0);

/**Creditos*/
$pdf->SetY(135);
$pdf->SetX(150);
$pdf->SetFont("times", "BI", 11, '', 'false');
$html = '<p align="right">' . $creditos . '</p>';
$pdf->writeHTML($html, true, 0, true, 0);

$pdf->write2DBarcode($print_documento . '?id=' . s_crypt_public($cc_evento, 'in') . '&cod=' . s_crypt_public($c_persona, 'in') . '&tipo=' . s_crypt_public($tipo, 'in'), 'QRCODE,H',  35, 125, 30, 30, $style, 'N');



$pdf->Output($nombre . '.pdf', 'D');
