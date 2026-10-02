<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";

s_validar_pagina();

require_once u_src() . "bo/bo_tram_permisos.php";
$bo_permisos  = new bo_tram_permisos();
$ent_permisos = new tram_permisos();

$usuario = s_usuario();

try {

    $opc        = s_crypt($_REQUEST['opc'] ?? '', 'out');
    $cc_permiso = s_crypt($_REQUEST['cc_permisos'] ?? '', 'out');

    if ($opc === 'A') {
        $ent_permisos->setUser_crea($usuario);
        $ent_permisos->setCc_permisos($cc_permiso);
    } elseif ($opc === 'I') {
        $ent_permisos->setTipo_permisos($_REQUEST['tipo_permisos'] ?? null);
        $ent_permisos->setFecha($_REQUEST['fecha'] ?? null);
        $ent_permisos->setFecha_ida($_REQUEST['fecha_ida'] ?? null);
        $ent_permisos->setFecha_retorno($_REQUEST['fecha_retorno'] ?? null);
        $ent_permisos->setCc_area_adm($_REQUEST['cc_area_adm'] ?? null);
        $ent_permisos->setMotivo($_REQUEST['motivo'] ?? null);
        $ent_permisos->setObs($_REQUEST['obs'] ?? null);
        $ent_permisos->setDestinos($_REQUEST['destinos'] ?? null);
        $ent_permisos->setFlag('*');
        $ent_permisos->setCc_usuario_e($_REQUEST['cc_usuario_e'] ?? null);
        $ent_permisos->setUser_crea($usuario);
        $ent_permisos->setC_local(s_local());
    } else {
        throw new Exception("Operación no permitida.");
    }

    if (!$bo_permisos->control($ent_permisos, $opc)) {
        throw new Exception($bo_permisos->errores());
    }

    echo json_encode(['error' => false]);
} catch (Exception $e) {

    echo json_encode([
        'error'   => true,
        'message' => $e->getMessage()
    ]);
}
