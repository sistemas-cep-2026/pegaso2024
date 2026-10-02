<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_items_guias_de_entrada.php";
s_validar_pagina();

// Inicialización de objetos
$bo_items_guia = new bo_alm_items_guias_de_entrada();

$ent = new alm_items_guias_de_entrada();

try {
    // Validación y desencriptación de parámetros
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
    $cc_guia_det = s_crypt($_REQUEST["cc_guia_det"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    if ($opc ==='E') {
     $ent->setCc_guia_det($cc_guia_det);
     $val = $bo_items_guia->control($ent, $opc);
     
     if (!$val) {
        throw new Exception($bo_guiavaledet->errores());
    }

}else{
    // Asignar valores según la operación
    $ent->setCc_guia($cc_guia);
    $ent->setCc_guia_det($cc_guia_det);

    $ent->setC_articulo($_REQUEST["c_articulo"]);
    $ent->setCantidad($_REQUEST["cantidad"]);

    $val = $bo_items_guia->control($ent, $opc);
    if (!$val) {
        throw new Exception($bo_items_guia->errores());
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
