<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
require_once(u_src() . "bo/bo_alm_items_guias_de_salida.php");
require_once u_src() . 'bo/bo_general.php';

$bo_valesalida = new bo_alm_guias_de_salida();
$bo_valesalidaitems = new bo_alm_items_guias_de_salida();
$bo_general = new bo_general();

$ent_valedetalle = new alm_items_guias_de_salida();

$cc_guia=s_crypt($_REQUEST['cc_guia'],'out');

$data_guia=$bo_valesalida->rep_vale_cabec($cc_guia);
foreach ($data_guia as $cab) {
    $entidad=$cab['entidad'];
    $fecha=$cab['fecha']; 
    $solicitante=$cab['solicitante'];
    $justificacion=$cab['justificacion'];
    $area_text=$cab['area_text'];
    $usuario=$cab['usuario'];
    $cc_guia=$cab['cc_guia'];
    $flag_text=$cab['flag_text'];
}
$ent_valedetalle->setCc_guia($cc_guia);
$data_detalle=$bo_valesalidaitems->ListarIdGuia($ent_valedetalle);
ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'balsalid_tabs_print_plantilla.php';
$template = ob_get_clean();

// Configurar y usar Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set([
    'isRemoteEnabled' => true,
    'defaultFont' => 'Arial'
]);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($template);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


// Generar y mostrar el PDF
$dompdf->stream(
    sprintf('%s %s-%s', $nombre_documento, $ruc_local, $full_documento),
    ["Attachment" => false]
);
