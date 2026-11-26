<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_tram_permisos.php");
require_once(u_src() . "bo/bo_general.php");

// TCPDF (librería de terceros, sin actualizar) genera "Deprecated: Implicit conversion
// from float to int" en PHP 8.1+. Esos avisos se imprimen ANTES del binario del PDF y
// lo corrompen. Se silencian solo los deprecated, solo en este script.
error_reporting(E_ALL & ~E_DEPRECATED);
// Cualquier otro aviso de la librería va al log, no a la pantalla, para no corromper el PDF.
ini_set('display_errors', '0');

require_once('../tcpdf/tcpdf.php');
s_validar_pagina();

/** Corta con un mensaje simple (en vez de un PDF vacío o con avisos de PHP). */
function permiso_error($mensaje)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo $mensaje;
    exit;
}

function permiso_h($texto)
{
    return htmlspecialchars(trim((string) $texto), ENT_QUOTES, 'UTF-8');
}

$bo_permisos = new bo_tram_permisos();
$bo_general = new bo_general();
$ent_permisos = new tram_permisos();

// El BO pone cc_permisos en el SQL sin comillas: se exige un número.
$cc_permisos = trim((string) s_crypt(isset($_REQUEST['cod']) ? $_REQUEST['cod'] : '', 'out'));
if (!ctype_digit($cc_permisos)) {
    permiso_error('Permiso no válido.');
}
$ent_permisos->setCc_permisos($cc_permisos);

$data = $bo_permisos->listarID($ent_permisos);
if (empty($data)) {
    permiso_error('Permiso no encontrado.');
}
$permiso = $data[0];

$nombre_local = '';
foreach ($bo_general->RegionID(s_local()) as $loc) {
    $nombre_local = trim((string) $loc['nombre']);
}

$p = [
    'numero'    => trim((string) $permiso['cc_permisos']),
    'tipo'      => mb_strtoupper(trim((string) ($permiso['tipo_permisos_text'] ?? '')), 'UTF-8'),
    'fecha'     => $permiso['fecha_emi'] ?? '',
    'salida'    => $permiso['fecha_ida'] ?? '',
    'retorno'   => $permiso['fecha_retorno'] ?? '',
    'usuario'   => $permiso['cc_usuario_e'] ?? '',
    'nombre'    => $permiso['nombre'] ?? '',
    'area'      => $permiso['area_nombre'] ?? '',
    'motivo'    => $permiso['motivo'] ?? '',
    'destinos'  => $permiso['destinos'] ?? '',
    'obs'       => trim((string) ($permiso['obs'] ?? '')) !== '' ? $permiso['obs'] : 'S/O',
];

while (ob_get_level() > 0) {
    ob_end_clean();
}

/** PDF con pie: impreso por y número de página. */
class PermisoPDF extends TCPDF
{
    public $impreso = '';

    public function Footer()
    {
        $this->SetY(-12);
        $this->SetFont('helvetica', '', 7);
        $this->SetTextColor(110, 110, 110);
        $this->Cell(0, 5, 'Impreso: ' . $this->impreso, 0, 0, 'L');
        $this->Cell(0, 5, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

$pdf = new PermisoPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->impreso = date('d/m/Y H:i') . ' - ' . s_usuario();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($nombre_local);
$pdf->SetTitle('Permiso N° ' . $p['numero']);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(true);
$pdf->SetMargins(15, 12, 15);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 18);
$pdf->setCellHeightRatio(1.25);
$pdf->AddPage();

// Se dibuja con funciones nativas de TCPDF y HTML sin estilos de borde: la versión de TCPDF
// de producción lanza avisos con bordes CSS y eso rompe el PDF.
$x = 15;
$w = $pdf->getPageWidth() - 30;
$azul = [11, 46, 89];

// --- Encabezado: logo | institución y título | recuadro con el N.° ----------
$y0 = 12;
$logo = dirname(__DIR__) . '/images/logo_print.jpg';
if (is_readable($logo)) {
    $pdf->Image($logo, $x, $y0, 24, 24);
}
$wc = $w - 28 - 46;            // ancho del bloque central
$xc = $x + 28;
$pdf->SetTextColorArray($azul);
$pdf->SetXY($xc, $y0 + 1);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell($wc, 6, 'COLEGIO DE ENFERMEROS DEL PERÚ', 0, 1, 'C');
$pdf->SetX($xc);
$pdf->SetFont('helvetica', '', 8.5);
$pdf->SetTextColor(85, 85, 85);
$pdf->Cell($wc, 4.5, $nombre_local, 0, 1, 'C');
$pdf->SetX($xc);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetTextColorArray($azul);
$pdf->Cell($wc, 7.5, 'HOJA DE TRÁMITE', 0, 1, 'C');
$pdf->SetX($xc);
$pdf->SetFont('helvetica', 'B', 9.5);
$pdf->SetTextColor(30, 90, 110);
$pdf->Cell($wc, 5, $p['tipo'], 0, 1, 'C');

$xb = $x + $w - 44;
$pdf->SetDrawColorArray($azul);
$pdf->SetLineWidth(0.4);
$pdf->Rect($xb, $y0 + 1, 44, 22);
$pdf->SetXY($xb, $y0 + 2.5);
$pdf->SetFont('helvetica', '', 7.5);
$pdf->SetTextColor(85, 85, 85);
$pdf->Cell(44, 4, 'N.°', 0, 1, 'C');
$pdf->SetX($xb);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetTextColorArray($azul);
$pdf->Cell(44, 8, $p['numero'], 0, 1, 'C');
$pdf->SetX($xb + 3);
$pdf->SetFont('helvetica', '', 7);
$pdf->SetTextColor(51, 51, 51);
$pdf->SetFillColor(232, 238, 247);
$pdf->Cell(38, 5, 'PERMISO POR VALIDAR', 0, 1, 'C', true);

// raya fina y clara
$yl = $y0 + 28;
$pdf->SetDrawColor(201, 211, 224);
$pdf->SetLineWidth(0.25);
$pdf->Line($x, $yl, $x + $w, $yl);

// --- Datos (texto simple) ------------------------------------------------------
$pdf->SetTextColor(34, 34, 34);
$pdf->SetFont('helvetica', '', 9.5);
$datos = '
<table cellpadding="3">
    <tr>
        <td width="18%"><b>Fecha</b></td>
        <td width="32%">' . permiso_h($p['fecha']) . '</td>
        <td width="18%"><b>Hora de salida</b></td>
        <td width="12%">' . permiso_h($p['salida']) . '</td>
        <td width="10%"><b>Retorno</b></td>
        <td width="10%">' . permiso_h($p['retorno']) . '</td>
    </tr>
    <tr>
        <td><b>Nombres</b></td>
        <td colspan="5">' . permiso_h(trim($p['usuario'] . ' - ' . $p['nombre'], ' -')) . '</td>
    </tr>
    <tr>
        <td><b>Dependencia</b></td>
        <td colspan="5">' . permiso_h($p['area']) . '</td>
    </tr>
</table>';
$pdf->writeHTMLCell($w, 0, $x, $yl + 4, $datos, 0, 1, false, true, 'L', true);

// --- Recuadro: motivo, destino y observaciones (borde nativo de la celda) ----------
$titulo = function ($t) {
    return '<span style="color:#0b2e59;font-size:8pt;"><b>' . $t . '</b></span><br>';
};
$bloques = $titulo('MOTIVO DE SALIDA') . nl2br(permiso_h($p['motivo']));
if (trim((string) $p['destinos']) !== '') {
    $bloques .= '<br><br>' . $titulo('DESTINO') . nl2br(permiso_h($p['destinos']));
}
$bloques .= '<br><br>' . $titulo('OBSERVACIONES') . nl2br(permiso_h($p['obs']));

$pdf->SetDrawColor(201, 211, 224);
$pdf->SetLineWidth(0.25);
$pdf->setCellPaddings(3, 3, 3, 3);
$pdf->writeHTMLCell($w, 0, $x, $pdf->GetY() + 5, $bloques, 1, 1, false, true, 'L', true);
$pdf->setCellPaddings(0, 0, 0, 0);

// --- Firmas ---------------------------------------------------------------------
$w_half = $w / 2;
$y = $pdf->GetY() + 28;
$pdf->SetDrawColor(60, 60, 60);
$pdf->SetLineWidth(0.25);
$pdf->Line($x + 12, $y, $x + $w_half - 12, $y);
$pdf->Line($x + $w_half + 12, $y, $x + $w - 12, $y);

$pdf->SetFont('helvetica', 'B', 8.5);
$pdf->SetTextColor(34, 34, 34);
$pdf->SetXY($x, $y + 1.5);
$pdf->Cell($w_half, 4.5, 'AUTORIZADO POR', 0, 0, 'C');
$pdf->Cell($w_half, 4.5, 'RECIBÍ CONFORME', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 7.5);
$pdf->SetX($x);
$pdf->Cell($w_half, 4, 'Firma y sello del jefe inmediato', 0, 0, 'C');
$pdf->Cell($w_half, 4, 'Firma del comisionado', 0, 1, 'C');

// --- Nota ---------------------------------------------------------------------
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'I', 7.5);
$pdf->SetTextColor(110, 110, 110);
$pdf->MultiCell($w, 4, 'Este documento no representa la conformidad de la salida correspondiente si no tiene la firma y sello del jefe inmediato.', 0, 'C');

$pdf->Output('permiso_' . $p['numero'] . '.pdf', 'I');
