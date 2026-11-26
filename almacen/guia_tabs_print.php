<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_entrada.php");
require_once(u_src() . "bo/bo_alm_items_guias_de_entrada.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$bo_guia = new bo_alm_guias_de_entrada();
$bo_guiaitems = new bo_alm_items_guias_de_entrada();
$ent_guia = new alm_guias_de_entrada();
$ent_items_guia = new alm_items_guias_de_entrada();

/** Corta con un mensaje simple (en vez de un PDF vacío o con avisos de PHP). */
function guia_error($mensaje)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: text/plain; charset=utf-8');
    echo $mensaje;
    exit;
}

// cc_guia llega cifrado; el BO lo pone en el SQL sin comillas, por eso se exige un número.
$cc_guia = trim((string) s_crypt(isset($_REQUEST['cc_guia']) ? $_REQUEST['cc_guia'] : '', 'out'));
if (!ctype_digit($cc_guia)) {
    guia_error('Guía de entrada no válida.');
}

$ent_guia->setCc_guia($cc_guia);
$ent_items_guia->setCc_guia($cc_guia);

$data_cab = $bo_guia->cabecera($ent_guia);
if (empty($data_cab)) {
    guia_error('No se encontró la guía de entrada N° ' . $cc_guia . '.');
}
$cab = $data_cab[0];
$guia = [
    'numero'         => $cc_guia,
    'fecha'          => trim((string) $cab['fecha']),
    'observacion'    => trim((string) $cab['observacion']),
    'c_usuario'      => trim((string) $cab['cc_usuario']),
    'nombre_usuario' => trim((string) $cab['nombre_usuario']),
    'flag_text'      => trim((string) $cab['flag_text']),
    'ruc'            => trim((string) $cab['ruc']),
    'proveedor'      => trim((string) $cab['nombre']),
    'cod_documento'  => trim((string) $cab['cod_documento']),
    'num_documento'  => trim((string) $cab['num_documento']),
    'cc_requisicion' => trim((string) $cab['cc_requisicion']),
];

$data_detalle = $bo_guiaitems->ListarIdGuia($ent_items_guia);
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
require __DIR__ . DIRECTORY_SEPARATOR . 'guia_tabs_print_plantilla.php';
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

$dompdf->stream('Guia_entrada_' . $guia['numero'] . '.pdf', ['Attachment' => false]);
exit;
