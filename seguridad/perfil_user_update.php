<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
header('Content-type: application/json; charset=utf-8');

$bo_usuarios = new bo_seg_usuarios();
$ent_usuarios = new seg_usuarios();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_usuario = s_crypt($_REQUEST["cc_usuario"], 'out');
    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    $ent_usuarios->setCc_usuario($cc_usuario);
    $ent_usuarios->setUsuario(s_crypt($_REQUEST['usuario'], 'out'));
    $ent_usuarios->setClave($_REQUEST['clave']);

    $val = $bo_usuarios->control($ent_usuarios, $opc);

    if (!$val) {
        throw new Exception($bo_usuarios->errores() ?? 'Error desconocido.');
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => url('sistema/salir.php')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
