<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_fin_items_documentos_de_venta.php";
s_validar_pagina();

// Inicialización de objetos
$bo_caja_detall = new bo_fin_items_documentos_de_venta();

$ent_caja_detall = new fin_items_documentos_de_venta();

try {
    $opc = !empty($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_ventas = !empty($_REQUEST["cc_ventas"]) ? s_crypt($_REQUEST["cc_ventas"], 'out') : '';
    $cc_ventadetall = !empty($_REQUEST["cc_ventadetall"]) ? s_crypt($_REQUEST["cc_ventadetall"], 'out') : '';

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    $ent_caja_detall->setCc_ventas($cc_ventas);
    $ent_caja_detall->setCc_ventadetall($cc_ventadetall);
    $ent_caja_detall->setC_articulo($_REQUEST['c_articulo'] ?? '');
    $ent_caja_detall->setAno($_REQUEST['cod_anho'] ?? '');
    $ent_caja_detall->setMes_desde($_REQUEST['cod_desde'] ?? '');
    $ent_caja_detall->setMes_hasta($_REQUEST['cod_hasta'] ?? '');
    $ent_caja_detall->setCantidad(u_limpiarMonto($_REQUEST['cantidad'] ?? '0'));
    $ent_caja_detall->setPrecio(u_limpiarMonto($_REQUEST['importe'] ?? '0'));
    $ent_caja_detall->setVenta($_REQUEST['total'] ?? '0');

    $val = $bo_caja_detall->control($ent_caja_detall, $opc);

    if (!$val) {
        throw new Exception($bo_caja_detall->errores());
    }

    echo json_encode([
        'status' => true,
        'message' => null
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
    ]);
}
