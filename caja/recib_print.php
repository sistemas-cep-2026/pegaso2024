<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . "/util/numeroLetra.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

s_validar_pagina();
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_fin_items_documentos_de_venta.php");
require_once(u_src() . "bo/bo_fin_items_planilla_de_cobranza.php");
require_once u_src() . 'bo/bo_general.php';

$bo_doc_venta = new bo_fin_documentos_de_venta();
$bo_doc_venta_detall = new bo_fin_items_documentos_de_venta();
$bo_doc_venta_apgo = new bo_fin_items_planilla_de_cobranza();
$bo_general = new bo_general();

$ent_doc_venta = new fin_documentos_de_venta();
$ent_doc_venta_detall = new fin_items_documentos_de_venta();
$ent_doc_venta_apgo = new fin_items_planilla_de_cobranza();

$cc_ventas = s_crypt($_REQUEST['cod'], 'out');
$ent_doc_venta->setCc_ventas($cc_ventas);


$data_venta = $bo_doc_venta->listarIDcabecera($ent_doc_venta);
$c_local = '';
$num_documento = '';
$cod_documento = '';
$cod_documento_text = '';
$razon_social = '';
$c_cmp = '';
$ruc = '';
$fecha_text = '';
$forma_pago = '';
$obs = '';
$direc = '';
$valor_venta = 0;
$flag = '';
foreach ($data_venta as $cab) {
    $c_local = $cab['c_local'];
    $num_documento = $cab['num_documento'];
    $cod_documento = $cab['cod_documento'];
    $cod_documento_text = $cab['cod_documento_text'];
    $razon_social = $cab['razon_social'];
    $c_cmp = $cab['c_cmp'];
    $ruc = $cab['ruc'];
    $fecha_text = $cab['fecha_text'];
    $forma_pago = $cab['forma_pago'];
    $obs = $cab['observacion'];
    $direc = $cab['tipo_direccion'];
    $valor_venta = $cab['valor_venta'];
    $flag = $cab['flag'];
}
$ent_doc_venta_detall->setCc_ventas($cc_ventas);
$data_detall =  $bo_doc_venta_detall->ListarIdVentas($ent_doc_venta_detall);

/*solo para factua y boleta */
$data_total = $bo_doc_venta_detall->ListarIdVentasSuma($ent_doc_venta_detall);
$opera_grabada = 0;
$opera_inafecta = 0;
foreach ($data_total as $row) {
    $opera_grabada = $row['opera_grabada'];
    $opera_inafecta = $row['opera_inafecta'];
}

/***fina**/
$ent_doc_venta_apgo->setCc_ventas($cc_ventas);
$data_pagos =  $bo_doc_venta_apgo->ListarIdVentas($ent_doc_venta_apgo);

$data_local = $bo_general->RegionID($c_local);
$local_nombre = '';
$local_direccion = '';
foreach ($data_local as $loc) {
    $local_nombre = $loc['nombre'];
    $local_direccion = $loc['local_direc'];
}

ob_start();
require_once __DIR__ . DIRECTORY_SEPARATOR . 'recib_print_plantilla.php';
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
    sprintf('%s %s-%s', $cod_documento_text ?: 'Recibo', $ruc ?: '', $num_documento ?: $cc_ventas),
    ["Attachment" => false]
);
