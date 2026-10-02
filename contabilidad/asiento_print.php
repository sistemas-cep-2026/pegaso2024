<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . "/util/numeroLetra.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_cont_voucher.php");
require_once(u_src() . "bo/bo_cont_items_voucher.php");
require_once u_src() . 'bo/bo_general.php';
$bo_general = new bo_general();
$bo_cont_voucher = new bo_cont_voucher();
$bo_cont_items_voucher = new bo_cont_items_voucher();

$ent_cont_voucher = new cont_voucher();
$ent_cont_items_voucher = new cont_items_voucher();

$cc_voucher = s_crypt($_REQUEST['asiento'], 'out');

$ent_cont_voucher->setCc_voucher($cc_voucher);


$data_venta = $bo_cont_voucher->listarID($ent_cont_voucher);
foreach ($data_venta as $cab) {
    $c_local = $cab['c_local'];
    $num_documento = $cab['num_documento'];
    $cod_documento = $cab['cod_documento'];
    $ruc = $cab['ruc'];
    $razon_social = $cab['razon_social'];
    $c_cmp = $cab['c_cmp'];
    $obs = $cab['observacion'];
    $flag = $cab['flag'];
    $voucher = $cab['voucher'];
    $ano_contable = $cab['ano_contable'];
    $cod_mes_contable = $cab['cod_mes_contable'];
        $nombre_subdiario = $cab['nombre_subdiario'];
         $fecha = $cab['fecha'];
    
    
}

$ent_cont_items_voucher->setCc_voucher($cc_voucher);
$data_detall =  $bo_cont_items_voucher->listarIDvoucher($ent_cont_items_voucher);


$data_local = $bo_general->RegionID($c_local);
foreach ($data_local as $loc) {
    $local_nombre = $loc['nombre'];
    $local_direccion = $loc['local_direc'];
}

ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'asiento_print_plantilla.php';
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

$dompdf->stream(
    sprintf('%s %s-%s', $nombre_documento, $ruc_local, $full_documento),
    ["Attachment" => false]
);
