<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_requisicion.php";
s_validar_pagina();

// Inicialización de objetos
$bo_alm_requisicion = new bo_alm_requisicion();

$ent_requisicion = new alm_requisicion();

try {
    // Validación y desencriptación de parámetros
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_requisicion = s_crypt($_REQUEST["cc_requisicion"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    // Asignar valores según la operación
    $ent_requisicion->setcc_requisicion($cc_requisicion);

    $ent_requisicion->setC_area_adm($_REQUEST["c_area_adm"]);
    $ent_requisicion->setFecha($_REQUEST["fecha"]);
    $ent_requisicion->setC_usuario($_REQUEST["c_usuario"]);
    $ent_requisicion->setObservacion($_REQUEST["observacion"]);
    $ent_requisicion->setCc_local($_REQUEST["cc_local"]);
    $ent_requisicion->setUser_crea(s_usuario());
    $ent_requisicion->setFlag($_REQUEST["flag"]);
    $ent_requisicion->setOpc($opc);

    $val = $bo_alm_requisicion->procesar($ent_requisicion);
    if (!$val) {
        throw new Exception($bo_alm_requisicion->errores());
    }

  if ($opc === 'I') {
        //$cc_docrecibidos = $bo_doc_recibidos->listarIDMax()[0]['maximo'] ?? null;
         $cc_requisicion = $val['cc_requisicion'] ?? null;
    }

    echo json_encode([ 
        'status' => true,
        'url' => '?id=' . s_crypt('600004','in') . '&cc_requisicion=' . s_crypt($cc_requisicion,'in') . '&opc=' . s_crypt('U','in')
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
    ]);
}