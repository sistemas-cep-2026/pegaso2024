<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_requisicion.php");
require_once(u_src() . "bo/bo_alm_items_requisicion.php");
require_once u_src() . 'bo/bo_general.php';

$bo_requisicion = new bo_alm_requisicion();
$bo_requisicionitems = new bo_alm_items_requisicion();
$bo_general = new bo_general();

$ent_items_requisicion = new alm_items_requisicion();
$ent_requisicion = new alm_requisicion();

$cc_requisicion=s_crypt($_REQUEST['cc_requisicion'],'out');

$ent_requisicion->setCc_requisicion($cc_requisicion);
$ent_items_requisicion->setCc_requisicion($cc_requisicion);

$data_guia=$bo_requisicion->cabecera($ent_requisicion);
foreach ($data_guia as $cab) {
    
    $fecha=$cab['fecha'];
    $observacion=$cab['observacion'];
    $c_usuario=$cab['c_usuario'];
    $c_area_adm=$cab['c_area_adm'];
    $nombre_area_adm=$cab['nombre'];
    $flag_text=$cab['flag_text']; 
    $flag=$cab['flag'];
    $nombre_usuario=$cab['nombre_usuario'];
    $nombre_crea=$cab['nombre_crea'];
    $c_usuario_crea=$cab['c_usuario_crea'];
    
}
$data_detalle=$bo_requisicionitems->ListarIdGuia($ent_items_requisicion);
  
 ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'requisicion_tabs_print_plantilla.php';
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
 