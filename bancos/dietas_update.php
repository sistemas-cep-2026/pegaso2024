<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_dietas.php");
header('Content-type: application/json; charset=utf-8');
// Inicialización de objetos
$bo_banc_dietas = new bo_banc_dietas();
$ent_banc_dietas = new banc_dietas();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_dietas = s_crypt($_REQUEST["cc_dietas"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
 
    if ($opc=='I'){
    $ent_banc_dietas->setCc_persona(s_crypt($_REQUEST["cc_persona"], 'out'));
    $ent_banc_dietas->setFecha(u_fecha($_REQUEST["fecha"]) ?? null);
    $ent_banc_dietas->setCc_local($_REQUEST["c_local"]);
        $ent_banc_dietas->setC_area_adm($_REQUEST['c_area_adm']);
    $ent_banc_dietas->setReferencia($_REQUEST['referencia']);
       
    }
    $ent_banc_dietas->setCod_ano(s_anho());
    $ent_banc_dietas->setCod_mes(s_periodo());
     $ent_banc_dietas->setCc_dietas($cc_dietas);
     $ent_banc_dietas->setCc_usuario(s_usuario());
    $ent_banc_dietas->setOpc($opc);

    $val = $bo_banc_dietas->procesarDietas($ent_banc_dietas);
    if (!$val) {
        throw new Exception($bo_banc_dietas->errores());
    }

    if ($opc === 'I') {
        $cc_dietas = $val['cc_dietas'] ?? null;
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('800008', 'in') . '&cod=' . s_crypt($cc_dietas) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
