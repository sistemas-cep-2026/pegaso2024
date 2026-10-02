<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_items_requisicion.php";
s_validar_pagina();

// Inicialización de objetos
$bo_items_requisicion = new bo_alm_items_requisicion();

$ent = new alm_items_requisicion();

try {
    // Validación y desencriptación de parámetros
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_requisicion = s_crypt($_REQUEST["cc_requisicion"], 'out');
    $cc_requisicion_det = s_crypt($_REQUEST["cc_requisicion_det"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    if ($opc ==='E') {
     $ent->setCc_requisicion_det($cc_requisicion_det);
     $val = $bo_items_requisicion->control($ent, $opc);
     
     if (!$val) {
        throw new Exception($bo_guiavaledet->errores());
    }

}else{
    // Asignar valores según la operación
    $ent->setCc_requisicion($cc_requisicion);
    $ent->setCc_requisicion_det($cc_requisicion_det);

    $ent->setC_articulo($_REQUEST["c_articulo"]);
    $ent->setCantidad($_REQUEST["cantidad"]);

    $val = $bo_items_requisicion->control($ent, $opc);
    if (!$val) {
        throw new Exception($bo_items_requisicion->errores());
    }

 
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
