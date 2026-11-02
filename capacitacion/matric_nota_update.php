<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_modnota = new bo_cap_eventos_matricula();

$ent_modnota = new cap_eventos_matricula();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_evento_mat = s_crypt($_REQUEST["cc_evento_mat"], 'out');

    $nota_in = trim((string)($_REQUEST["nota"] ?? ''));
    if (!preg_match('/^\d{1,2}$/', $nota_in) || (int)$nota_in <= 10 || (int)$nota_in > 20) {
        throw new Exception('La nota debe ser mayor a 10 y menor o igual a 20.');
    }

    $ent_modnota->setCc_evento_mat($cc_evento_mat);
    $ent_modnota->setNota($nota_in);

    $val = $bo_modnota->control($ent_modnota, $opc);
    if (!$val) {
        throw new Exception($bo_modnota->errores() ?? 'Error desconocido.');
    }
    echo "0";
    exit;
} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}
