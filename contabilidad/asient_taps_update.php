<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_voucher.php");
header('Content-type: application/json; charset=utf-8');
// Inicialización de objetos
$bo_voucher = new bo_cont_voucher();
$ent_voucher = new cont_voucher();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_voucher = s_crypt($_REQUEST["cc_voucher"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    $ent_voucher->setCc_voucher($cc_voucher); 
    $ent_voucher->setC_local(s_local_vinculado());
    $ent_voucher->setAno_contable(s_anho());
    $ent_voucher->setCod_mes_contable(s_periodo());
    $ent_voucher->setC_persona($_REQUEST["c_persona"]); 
    $ent_voucher->setC_subdiario($_REQUEST["c_subdiario"]);
    $ent_voucher->setCod_documento($_REQUEST["cod_documento"]);             
    $ent_voucher->setNum_documento($_REQUEST["num_documento"]);
    $ent_voucher->setObservacion($_REQUEST["observacion"]); 
    $ent_voucher->setUsuario(s_usuario()); 
    $ent_voucher->setFecha(u_fecha($_REQUEST["fecha"]));             
    $ent_voucher->setOpc($opc);
    
    $val = $bo_voucher->procesar($ent_voucher);
    if (!$val) {
        throw new Exception($bo_voucher->errores());
    }

    if ($opc === 'I') {
        $cc_voucher = $bo_voucher->listarIDMax()[0]['maximo'] ?? null;
    }

    echo json_encode([
     'error' => false,
     'message' => null,
     'url' => '?id=' . s_crypt('900001','in') . '&cod=' . s_crypt($cc_voucher) . '&opc=' . s_crypt('U')
 ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
