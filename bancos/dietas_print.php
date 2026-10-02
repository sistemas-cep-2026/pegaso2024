<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_banc_dietas.php");
require_once(u_src() . "bo/bo_banc_dietas_detalles.php");
require_once u_src() . 'bo/bo_general.php';
$bo_general = new bo_general();
$bo_banc_dietas = new bo_banc_dietas();
$bo_banc_dietas_detalles = new bo_banc_dietas_detalles();

$ent_banc_dietas = new banc_dietas();
$ent_banc_dietas_detalles = new banc_dietas_detalles();

$cc_dietas = s_crypt($_REQUEST['cc_dietas'], 'out');

$ent_banc_dietas->setCc_dietas($cc_dietas);


$data_venta = $bo_banc_dietas->listarID($ent_banc_dietas);
foreach ($data_venta as $cab) {


    $nombre_persona = $cab['nombre_persona'];
    $c_cmp = $cab['c_cmp'];

    $voucher = $cab['voucher'];
    $nombre_area = $cab['nombre_area'];
    $ano_contable = $cab['cod_ano'];
    $mes_contable = $cab['cod_mes'];
    $obs = $cab['referencia'];
    $fecha_text = $cab['fecha_text'];
    $flag = $cab['flag'];
    $c_local = $cab['cc_local'];

    $cod_documento = $cab['cod_documento'];
    $num_documento = $cab['num_documento'];
    $ruc = $cab['ruc'];
}

$ent_banc_dietas_detalles->setCc_dietas($cc_dietas);
$data_detall =  $bo_banc_dietas_detalles->listarID($ent_banc_dietas_detalles);


$data_local = $bo_general->RegionID($c_local);
foreach ($data_local as $loc) {
    $local_nombre = $loc['nombre'];
    $local_direccion = $loc['local_direc'];
}

ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dietas_print_plantilla.php';
$template = ob_get_clean();

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

$nombre_documento = 'Recibo Dieta';
$ruc_local = $ruc ?? '';
$full_documento = $cc_dietas;

$dompdf->stream(
    sprintf('%s %s-%s', $nombre_documento, $ruc_local, $full_documento),
    ["Attachment" => false]
);
