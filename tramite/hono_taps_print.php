<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_tram_honorabilidad.php");
require_once('../tcpdf/tcpdf.php');
//s_validar_pagina();
$bo_general    = new bo_general();
$bo_personas    = new bo_gen_personas();
$bo_honorabilidad = new bo_tram_honorabilidad();

$ent_personas  = new gen_personas();
$ent_honorabilidad = new tram_honorabilidad();

$cc_honorab = s_crypt($_REQUEST['cod'], 'out');
//$user = s_crypt($_REQUEST['user']);
//echo $cc_habilitacion;


$data_honor = $bo_honorabilidad->listaIDPersona($cc_honorab);
foreach ($data_honor as $hab) {
	$cc_honorab	= $hab["cc_honorab"];
	$cc_local 	= $hab["cc_local"];
	$cc_persona = $hab["cc_persona"];
	$fecha_text = $hab["fecha_text"];
	$fecha_registro = $hab["fec_registro"];
	$img_fondo_	= $hab["img_fondo"];
	$autoridad	= $hab["autoridad"];
	$cargo	= $hab["cargo"];
	$nombre_anho = $hab["nombre_anho"];
	$anho	= $hab["anho"];
	$cep = $hab["c_cmp"];
	$nombre = $hab["nombre"];
	$numero = $hab["numero"];
}


$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$nombre_col = $loc["nombre"];
}
$val = "https://www.cep.org.pe/pegasoweb/imag/imag_fondo/" . $img_fondo;
ob_end_clean();

error_reporting(0);
ini_set('display_errors', '0');

class MYPDF extends TCPDF
{

	public function Header()
	{
		global $img_fondo_;
		$img_file = '';
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		//$img_file ="../imag/imag_fondo/img_gestion05.jpg";
		$img_file = dirname(__DIR__) . "/imag/imag_fondo/" . $img_fondo_;
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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
$pdf->AddPage();

$style = array(
	'border' => 2,
	'vpadding' => 'auto',
	'hpadding' => 'auto',
	'fgcolor' => array(0, 0, 0),
	'bgcolor' => false, //array(255,255,255)
	'module_width' => 1, // width of a single module in points
	'module_height' => 1 // height of a single module in points
);

//$qr = $pdf->write2DBarcode('https://www.cep.org.pe/pegasoweb/tramite/hon_print.php?codid=' . encriptar($cc_honorab), 'QRCODE,H', 30, 185, 25, 25, $style, 'L');


$html_ = '<div style="font-size: 12px;"><strong>CH N° 000' . $numero . '-' . $anho . '-CN/CEP</strong></div>';
$pdf->WriteHTMLCell(50, 11, 157, 7, $html_);
//$pdf->WriteHTMLCell(50, 11, 159, 11, $html_);
//$pdf->Text(145,10,'CH N°-0003-2023-CN/CEP'); 

//$pdf->SetX(100);
$pdf->SetY(65);
$pdf->SetX(28);
//$pdf->SetFont("times", "BI", 11, '', 'false');
$html = '<table width="560" border="0" align="center">
<tr>
<td><br><br><br></td>
</tr>
<tr>
<td align="center">"' . $nombre_anho . '"</td>
</tr>
<tr>
<td><h1><br>CONSTANCIA DE HONORABILIDAD</h1><br></td>
</tr>
<tr>
<td align="center">
<span>La Decana Nacional del Colegio de Enfermeros del Perú, quién al recibir el Informe del Presidente del Comité de Vigilancia, Ética y Deontología del ' . $nombre_col . ', hace constar:</span> <br><br>
</td>
</tr>
<tr>
<td ><span>Que, la(el) <strong> Lic. ' . $nombre . '</strong> con <strong>CEP: ' . $cep . '</strong> NO REGISTRA a la fecha ningún antecedente en el Comité de Vigilancia, Ética y Deontología para ejercer la profesión de Enfermería, ya sea en nuestro país<br> o fuera de él. </span></td>
</tr>
<tr>
<td ></td >
</tr>
<tr>
<td ><span>Se expide la presente constancia a petición del interesado, para los fines que estime conveniente.</span></td>
</tr>
<tr>
<td ></td >
</tr>
<tr>
<td align="right"><span>' . $fecha_text . '</span></td>
</tr>
<tr>
<td ></td >
</tr>
<tr>
<td align="center"><span>Atentamente,</span></td>
</tr>
<tr>
<td ></td >
</tr>
<tr>
<td height="60"></td >
</tr>
<tr>
<td  align="center">______________________________________<br><strong>' . $autoridad . '</strong><br>' . $cargo . '<br>Colegio de Enfermeros del Perú</td>
</tr>
</table>';

$pdf->writeHTML($html, true, 0, true, 0);
$pdf->SetY(220);
$tablefirma = '<table width="560" border="0" align="center">';

// echo dirname(__DIR__).'/imag/'.$firma_nacional;
// echo dirname(__DIR__).'/imag/' . $firma_region ;
$tablefirma .= '<tr><td width="30"></td>';
$tablefirma .= '</tr>';

$tablefirma .= '</table>';
$pdf->writeHTML($tablefirma, true, 0, true, 0);


$tablea = '<table height="560" border="0" >';
$tablea .= '<tr><td height="20"></td></tr>';
$tablea .= '<tr><td width="40" ></td>';
$tablea .= '</tr><tr><td width="40" ></td>';
//$tablea .= '<td colspan="3" style="font-size:09px times">*Según lo establecido en el Artículo 5, Inciso F del DL N° 1246 el documento se valida con código QR a través de la página Web </td>';
//$tablea .= '</tr><tr><td width="40" ></td>';
//$tablea .= '<td colspan="3" style="font-size:09px times">**Firma digitalizada en amparo del Articulo 2° de la Ley N° 27291 que modifica el articulo 141° del Código Civil.</td>';
$tablea .= '</tr></table>';
$pdf->writeHTML($tablea, true, 0, true, 0);
$pdf->Output($nombre . '.pdf', 'D');//D