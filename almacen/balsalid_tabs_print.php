<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
require_once(u_src() . "bo/bo_alm_items_guias_de_salida.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$bo_valesalida = new bo_alm_guias_de_salida();
$bo_valesalidaitems = new bo_alm_items_guias_de_salida();
$ent_valedetalle = new alm_items_guias_de_salida();

/** Corta con un mensaje simple (en vez de un PDF vacío o con avisos de PHP). */
function vale_error($mensaje)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo $mensaje;
    exit;
}

// cc_guia llega cifrado; se acepta solo un número para no armar SQL con texto libre.
$cc_guia = trim((string) s_crypt(isset($_REQUEST['cc_guia']) ? $_REQUEST['cc_guia'] : '', 'out'));
if (!ctype_digit($cc_guia)) {
    vale_error('Vale de salida no válido.');
}

$data_guia = $bo_valesalida->rep_vale_cabec($cc_guia);
if (empty($data_guia)) {
    vale_error('No se encontró el vale de salida N° ' . $cc_guia . '.');
}
$cab = $data_guia[0];
$vale = [
    'numero'        => trim((string) $cab['cc_guia']),
    'entidad'       => trim((string) $cab['entidad']),
    'fecha'         => trim((string) $cab['fecha']),
    'usuario'       => trim((string) $cab['usuario']),
    'solicitante'   => trim((string) $cab['solicitante']),
    'justificacion' => trim((string) $cab['justificacion']),
    'area_text'     => trim((string) $cab['area_text']),
    'flag_text'     => trim((string) $cab['flag_text']),
];

$ent_valedetalle->setCc_guia($cc_guia);
$data_detalle = $bo_valesalidaitems->ListarIdGuia($ent_valedetalle);
if (!is_array($data_detalle)) {
    $data_detalle = [];
}

// Logo incrustado desde el disco: no depende de que el servidor se llame a sí mismo por URL.
$logo_src = '';
$logo_ruta = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo_print.jpg';
if (is_readable($logo_ruta)) {
    $logo_src = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logo_ruta));
}

$impreso = date('d/m/Y H:i') . ' - ' . s_usuario();

ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . 'balsalid_tabs_print_plantilla.php';
$template = ob_get_clean();

$options = new Options();
$options->set([
    'isRemoteEnabled' => false,   // todo va incrustado (logo y estilos)
    'defaultFont'     => 'Helvetica',
]);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($template, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Pie de página: impreso por y número de página.
$canvas = $dompdf->getCanvas();
$fuente = $dompdf->getFontMetrics()->getFont('Helvetica', 'normal');
$canvas->page_text(42, 810, 'Impreso: ' . $impreso, $fuente, 7, [0.4, 0.4, 0.4]);
$canvas->page_text(500, 810, 'Página {PAGE_NUM} de {PAGE_COUNT}', $fuente, 7, [0.4, 0.4, 0.4]);

$dompdf->stream('Vale_salida_' . $vale['numero'] . '.pdf', ['Attachment' => false]);
exit;
