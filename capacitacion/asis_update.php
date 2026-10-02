<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_asistencia.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_asistencias = new bo_cap_eventos_asistencia();

$ent_asistencias = new cap_eventos_asistencia();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_evento = s_crypt($_REQUEST["cc_evento"], 'out');
    $cc_persona = s_crypt($_REQUEST["cc_persona"], 'out');
    $fecha = s_crypt($_REQUEST["fecha"], 'out');

    $ent_asistencias->setCc_evento($cc_evento);
    $ent_asistencias->setC_persona($cc_persona);
    $ent_asistencias->setFech_crea(u_fecha($fecha));

    $ent_asistencias->setUser_crea(s_usuario());


    $val = $bo_asistencias->control($ent_asistencias, $opc);
    if (!$val) {
        throw new Exception($bo_asistencias->errores() ?? 'Error desconocido.');
    }
    echo "0";
    exit;
} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}
