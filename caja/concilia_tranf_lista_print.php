<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
require_once u_src() . 'bo/bo_general.php';
require_once(u_src() . "bo/bo_teso_conciliacion_mensual_transferencia.php");

 
$bo_general = new bo_general();
$ent_concilia = new teso_conciliacion_mensual();
$bo_teso_conc = new bo_teso_conciliacion_mensual();
$bo_tesodetalle = new bo_teso_conciliacion_mensual_transferencia();
$ent_tesodetalle = new teso_conciliacion_mensual_transferencia();

$cod_anho=s_crypt($_REQUEST['cod_anho'],'out');
$cod_mes=s_crypt($_REQUEST['cod_mes'],'out');
 
$ent_concilia->setCod_anho($cod_anho);
$ent_concilia->setCod_mes($cod_mes); 

$ent_tesodetalle->setCod_anho($cod_anho);
$ent_tesodetalle->setCod_mes($cod_mes); 

$data_concilacion = $bo_teso_conc->ListarPeriodoReporte($ent_concilia); 


ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'concilia_tranf_lista_print_data.php';
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
