<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_alm_guias_de_salida.php";
s_validar_pagina();

// Inicialización de objetos
$bo_guiavale = new bo_alm_guias_de_salida();

$ent_guiavale = new alm_guias_de_salida();

try {
    // Validación y desencriptación de parámetros
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_guia = s_crypt($_REQUEST["cc_guia"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    // Asignar valores según la operación
    $ent_guiavale->setCc_guia($cc_guia);

    $ent_guiavale->setC_area_adm($_REQUEST["c_area_adm"]);
    $ent_guiavale->setFecha($_REQUEST["fecha"]);
    $ent_guiavale->setUser_crea(s_usuario());
    $ent_guiavale->setJustificacion($_REQUEST["justificacion"]);
    $ent_guiavale->setC_local($_REQUEST["cc_local"]);
    $ent_guiavale->setFlag($_REQUEST["flag"]);
    $ent_guiavale->setOpc($opc);

    $val = $bo_guiavale->procesar($ent_guiavale);
    if (!$val) {
        throw new Exception($ent_guiavale->errores());
    }

    if ($opc === 'I') {

        $cc_guia = $val['cc_guia'] ?? null;
    }

    echo json_encode([
        'status' => true,
        'url' => '?id=' . s_crypt('600001', 'in') . '&cc_guia=' . s_crypt($cc_guia, 'in') . '&opc=' . s_crypt('U', 'in')
    ]);
 
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
    ]);
}