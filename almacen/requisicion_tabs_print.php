<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_requisicion.php");
require_once(u_src() . "bo/bo_alm_items_requisicion.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$bo_requisicion = new bo_alm_requisicion();
$bo_requisicionitems = new bo_alm_items_requisicion();
$ent_requisicion = new alm_requisicion();
$ent_items_requisicion = new alm_items_requisicion();

/** Corta con un mensaje simple (en vez de un PDF vacío o con avisos de PHP). */
function req_error($mensaje)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo $mensaje;
    exit;
}

// cc_requisicion llega cifrado; el BO lo pone en el SQL sin comillas, por eso se exige un número.
$cc_requisicion = trim((string) s_crypt(isset($_REQUEST['cc_requisicion']) ? $_REQUEST['cc_requisicion'] : '', 'out'));
if (!ctype_digit($cc_requisicion)) {
    req_error('Requisición no válida.');
}

$ent_requisicion->setCc_requisicion($cc_requisicion);
$ent_items_requisicion->setCc_requisicion($cc_requisicion);

$data_cab = $bo_requisicion->cabecera($ent_requisicion);
if (empty($data_cab)) {
    req_error('No se encontró la requisición N° ' . $cc_requisicion . '.');
}
$cab = $data_cab[0];
$req = [
    'numero'          => $cc_requisicion,
    'fecha'           => trim((string) $cab['fecha']),
    'observacion'     => trim((string) $cab['observacion']),
    'c_usuario'       => trim((string) $cab['c_usuario']),
    'nombre_usuario'  => trim((string) $cab['nombre_usuario']),
    'nombre_area_adm' => trim((string) $cab['nombre']),
    'flag_text'       => trim((string) $cab['flag_text']),
];

$data_detalle = $bo_requisicionitems->ListarIdGuia($ent_items_requisicion);
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
require __DIR__ . DIRECTORY_SEPARATOR . 'requisicion_tabs_print_plantilla.php';
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

$dompdf->stream('Requisicion_' . $req['numero'] . '.pdf', ['Attachment' => false]);
exit;
