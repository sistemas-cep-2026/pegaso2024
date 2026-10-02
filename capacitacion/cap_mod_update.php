<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_capmod = new bo_cap_eventos_modulo();

$ent_capmod = new cap_eventos_modulo();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_evento = isset($_REQUEST["cc_evento"]) ? s_crypt($_REQUEST["cc_evento"], 'out') : '';
    $cc_capmod = isset($_REQUEST["cc_capmod"]) ? s_crypt($_REQUEST["cc_capmod"], 'out') : '';

    $flag = isset($_REQUEST["flag"]) && $_REQUEST["flag"] === '*' ? '*' : 'A';

    $ent_capmod->setCc_evento($cc_evento);
    $ent_capmod->setCc_capmod($cc_capmod);
    $ent_capmod->setFlag($flag);
    if ($opc !== 'E') {
        $ent_capmod->setCt_modulo($_REQUEST["ct_modulo"]);
    }

    $val = $bo_capmod->control($ent_capmod, $opc);
    if (!$val) {
        throw new Exception($bo_capmod->errores() ?? 'Error desconocido.');
    }
    echo "0";
    exit;
} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}
