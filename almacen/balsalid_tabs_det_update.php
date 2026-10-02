<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_items_guias_de_salida.php";
s_validar_pagina();

// Inicialización de objetos
$bo_guiavaledet = new bo_alm_items_guias_de_salida();

$ent_guiavaledet = new alm_items_guias_de_salida();

try {
    // Validación y desencriptación de parámetros
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
    $cc_guia_det = s_crypt($_REQUEST["cc_guia_det"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    if ($opc ==='E') {
     $ent_guiavaledet->setCc_guia_det($cc_guia_det);
     $val = $bo_guiavaledet->control($ent_guiavaledet, $opc);
     
     if (!$val) {
        throw new Exception($bo_guiavaledet->errores());
    }

}else{
    // Asignar valores según la operación
    $ent_guiavaledet->setCc_guia($cc_guia);
    $ent_guiavaledet->setCc_guia_det($cc_guia_det);

    $ent_guiavaledet->setC_articulo($_REQUEST["c_articulo"]);
    $ent_guiavaledet->setCantidad($_REQUEST["cantidad"]);

    $val = $bo_guiavaledet->control($ent_guiavaledet, $opc);
    if (!$val) {
        throw new Exception($bo_guiavaledet->errores());
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
