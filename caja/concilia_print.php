<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
require_once u_src() . 'bo/bo_general.php';

$bo_concilia = new bo_teso_conciliacion_mensual();
$bo_general = new bo_general();

$ent_concilia = new teso_conciliacion_mensual();



$cod_anho = s_crypt($_REQUEST['cod_anho'] ?? '', 'out');
$cod_mes = s_crypt($_REQUEST['cod_mes'] ?? '', 'out');
$cc_local = s_crypt($_REQUEST['cc_local'] ?? '', 'out');

$ent_concilia->setCod_anho($cod_anho);
$ent_concilia->setCod_mes($cod_mes);
$ent_concilia->setCc_local($cc_local);

$nombre_local = '';
$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $nombre_local = $loc['nombre'];
}


$data_concilia = $bo_concilia->ListarPeriodo_resumen($ent_concilia);
$data_concilia_pend = $bo_concilia->ListarPeriodo_resumen_pend($ent_concilia);

ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'concilia_print_plantilla.php';
//exit;
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
$nombre_documento = 'Conciliacion';
$ruc_local = $nombre_local ?: $cc_local;
$full_documento = $cod_mes . '-' . $cod_anho;

$dompdf->stream(
    sprintf('%s %s-%s', $nombre_documento, $ruc_local, $full_documento),
    ["Attachment" => false]
);
