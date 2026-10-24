<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_tram_permisos.php");
require_once(u_src() . "bo/bo_general.php");

// TCPDF (librería de terceros, sin actualizar) genera "Deprecated: Implicit conversion
// from float to int" en PHP 8.1+. Esos avisos se imprimen ANTES del binario del PDF y
// lo corrompen. Se silencian solo los deprecated, solo en este script.
error_reporting(E_ALL & ~E_DEPRECATED);

require_once('../tcpdf/tcpdf.php');
s_validar_pagina();

$bo_permisos = new bo_tram_permisos();
$bo_general = new bo_general();
$ent_permisos = new tram_permisos();

$cc_permisos = s_crypt($_REQUEST['cod'], 'out');
$ent_permisos->setCc_permisos($cc_permisos);

$data = $bo_permisos->listarID($ent_permisos);
if (empty($data)) {
	die('Permiso no encontrado.');
}
$permiso = $data[0];

$data_local = $bo_general->RegionID(s_local());
$nombre_local = '';
foreach ($data_local as $loc) {
	$nombre_local = $loc['nombre'];
}

ob_end_clean();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($nombre_local);
$pdf->SetTitle('Permiso N° ' . $permiso['cc_permisos']);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();

$x = 15;
$w = $pdf->getPageWidth() - 30; // ancho útil total

// paleta: gris suave para líneas, gris oscuro (no negro puro) para texto,
// un acento sobrio para el subtítulo
$colorLinea   = [180, 180, 180];
$colorTexto   = [40, 40, 40];
$colorAccento = [30, 90, 110];

$pdf->SetDrawColorArray($colorLinea);
$pdf->SetLineWidth(0.2);
$pdf->SetTextColorArray($colorTexto);

// --- LOGO + ENCABEZADO -------------------------------------------------
$logo = dirname(__DIR__) . '/images/logo_print.jpg';
if (file_exists($logo)) {
    $pdf->Image($logo, $x, 15, 20, 20);
}

$pdf->SetXY($x, 17);
$pdf->SetFont('helvetica', 'B', 13);
$pdf->SetTextColorArray($colorTexto);
$pdf->Cell($w, 6, 'HOJA DE TRAMITE', 0, 1, 'C');
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColorArray($colorAccento);
$pdf->Cell($w, 6, strtoupper($permiso['tipo_permisos_text'] ?? ''), 0, 1, 'C');
$pdf->SetX($x);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColorArray($colorTexto);
$pdf->Cell($w, 6, 'PERMISO POR VALIDAR', 0, 1, 'C');

// línea fina de separación bajo el encabezado
$pdf->SetY(40);
$pdf->SetLineWidth(0.3);
$pdf->Line($x, 40, $x + $w, 40);
$pdf->SetLineWidth(0.2);

$pdf->SetY(45);
$pdf->SetX($x);
$pdf->SetFont('helvetica', '', 9.5);

// --- FILA: FECHA | HORA SALIDA | HORA RETORNO --------------------------
$h = 11;
$w3 = $w / 3;
$y = $pdf->GetY();
$pdf->writeHTMLCell($w3, $h, $x, $y, '<b>FECHA</b>: ' . ($permiso['fecha_emi'] ?? ''), 1, 0, false, true, 'L');
$pdf->writeHTMLCell($w3, $h, $x + $w3, $y, '<b>HORA DE SALIDA</b>: ' . ($permiso['fecha_ida'] ?? ''), 1, 0, false, true, 'L');
$pdf->writeHTMLCell($w3, $h, $x + (2 * $w3), $y, '<b>HORA DE RETORNO</b>: ' . ($permiso['fecha_retorno'] ?? ''), 1, 1, false, true, 'L');

// --- FILA: NOMBRES | DEPENDENCIA ---------------------------------------
$h = 15;
$w_nom = $w * 0.62;
$w_dep = $w - $w_nom;
$y = $pdf->GetY();
$pdf->writeHTMLCell($w_nom, $h, $x, $y, '<b>NOMBRES</b>: ' . ($permiso['nombre'] ?? ''), 1, 0, false, true, 'L');
$pdf->writeHTMLCell($w_dep, $h, $x + $w_nom, $y, '<b>DEPENDENCIA</b>: ' . ($permiso['area_nombre'] ?? ''), 1, 1, false, true, 'L');

// --- FILA: MOTIVO DE SALIDA ---------------------------------------------
$h = 15;
$y = $pdf->GetY();
$pdf->writeHTMLCell($w, $h, $x, $y, '<b>MOTIVO DE SALIDA</b>: ' . ($permiso['motivo'] ?? ''), 1, 1, false, true, 'L');

// --- FILA: OBSERVACIONES ------------------------------------------------
$h = 13;
$y = $pdf->GetY();
$obs_text = !empty($permiso['obs']) ? $permiso['obs'] : 'S/O';
$pdf->writeHTMLCell($w, $h, $x, $y, '<b>OBSERVACIONES</b>: ' . $obs_text, 1, 1, false, true, 'L');

// --- BLOQUE DE FIRMAS -----------------------------------------------------
// un solo borde exterior fino + una línea vertical divisoria (sin recuadros
// pesados individuales), y líneas de firma como trazo real, no guiones bajos
$h = 42;
$w_half = $w / 2;
$y = $pdf->GetY();

$pdf->Rect($x, $y, $w, $h);
$pdf->Line($x + $w_half, $y, $x + $w_half, $y + $h);

$pdf->SetXY($x, $y + 4);
$pdf->SetFont('helvetica', 'B', 9.5);
$pdf->Cell($w_half, 5, 'AUTORIZADO POR:', 0, 1, 'C');
$pdf->SetX($x);
$pdf->Cell($w_half, 5, 'NOMBRES:', 0, 1, 'C');

$pdf->SetXY($x + $w_half, $y + 4);
$pdf->Cell($w_half, 5, 'RECIBI CONFORME:', 0, 1, 'C');

$lineaY = $y + $h - 10;
$pdf->SetLineWidth(0.25);
$pdf->Line($x + 15, $lineaY, $x + $w_half - 15, $lineaY);
$pdf->Line($x + $w_half + 15, $lineaY, $x + $w - 15, $lineaY);

$pdf->SetXY($x, $lineaY + 2);
$pdf->SetFont('helvetica', 'B', 8.5);
$pdf->Cell($w_half, 5, 'FIRMA Y SELLO', 0, 1, 'C');
$pdf->SetXY($x + $w_half, $lineaY + 2);
$pdf->Cell($w_half, 5, 'FIRMA DEL COMISIONADO', 0, 1, 'C');

// --- PIE -----------------------------------------------------------------
$pdf->SetY($y + $h + 5);
$pdf->SetFont('helvetica', 'I', 7.5);
$pdf->SetTextColorArray([120, 120, 120]);
$pdf->Cell($w, 5, 'Este documento no representa la conformidad de la salida correspondiente si no tiene la firma y sello del jefe inmediato', 0, 1, 'C');

$pdf->Output('permiso_' . $permiso['cc_permisos'] . '.pdf', 'I');
