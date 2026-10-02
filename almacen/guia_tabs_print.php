<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_entrada.php");
require_once(u_src() . "bo/bo_alm_items_guias_de_entrada.php");
require_once u_src() . 'bo/bo_general.php';

$bo_guia = new bo_alm_guias_de_entrada();
$bo_guiaitems = new bo_alm_items_guias_de_entrada();
$bo_general = new bo_general();

$ent_items_guia = new alm_items_guias_de_entrada();
$ent_guia = new alm_guias_de_entrada();

$cc_guia=s_crypt($_REQUEST['cc_guia'],'out');

$ent_guia->setCc_guia($cc_guia);
$ent_items_guia->setCc_guia($cc_guia);

$data_guia=$bo_guia->cabecera($ent_guia);
foreach ($data_guia as $cab) {
    $fecha=$cab['fecha'];
    $observacion=$cab['observacion'];
    $c_usuario=$cab['cc_usuario'];
    $flag_text=$cab['flag_text'];
    $flag=$cab['flag'];
    $nombre_usuario=$cab['nombre_usuario'];
    $cod_documento=$cab['cod_documento'];
    $num_documento=$cab['num_documento'];
    $ruc=$cab['ruc'];
    $nombre=$cab['nombre'];
    $cc_requisicion=$cab['cc_requisicion'];
      
}

$data_detalle=$bo_guiaitems->ListarIdGuia($ent_items_guia);

 ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'guia_tabs_print_plantilla.php';
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
 