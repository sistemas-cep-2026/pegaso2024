<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_guias_de_entrada.php";
s_validar_pagina();

// Inicialización de objetos
$bo_alm_guia = new bo_alm_guias_de_entrada();

$ent_guia = new alm_guias_de_entrada();

try {

    //$opc2 = $_REQUEST["opc2"];
    /*if ($opc2 === 'J') {
        $ent_guia->setCc_requisicion($_REQUEST["cc_requisicion"]);
        $opc = $opc2;
    } else {*/
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $ent_guia->setCc_requisicion($_REQUEST["cc_requisicion"]);
    //}
    $cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');
    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
    $ent_guia->setCc_local($_REQUEST["cc_local"]);
    $ent_guia->setCc_persona($cc_persona);
    $ent_guia->setCod_documento($_REQUEST["cod_documento"]);
    $ent_guia->setNum_documento($_REQUEST["num_documento"]);
    $ent_guia->setFecha(u_fecha($_REQUEST["fecha"]));
    $ent_guia->setCc_requisicion($_REQUEST["cc_requisicion"]);
    $ent_guia->setcc_guia($cc_guia);
    $ent_guia->setCc_usuario(s_usuario());
    $ent_guia->setObservacion($_REQUEST["observacion"]);
    $ent_guia->setOpc($opc);
    $val = $bo_alm_guia->procesar($ent_guia);
    if (!$val) {
        throw new Exception($bo_alm_guia->errores());
    }

    if ($opc === 'I') {

        $cc_guia = $val['cc_guia'] ?? null;
    }

    echo json_encode([
        'status' => true,
        'url' => '?id=' . s_crypt('600002', 'in') . '&cc_guia=' . s_crypt($cc_guia, 'in') . '&opc=' . s_crypt('U', 'in')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
    ]);
}
