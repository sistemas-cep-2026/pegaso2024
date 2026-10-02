<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");
header('Content-type: application/json; charset=utf-8');

$bo = new bo_banc_saldos_bancos_cuentas();
$ent = new banc_saldos_bancos_cuentas();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_saldo = s_crypt($_REQUEST["cc_saldo"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $ent->setCc_saldo($cc_saldo ?? null);
    $ent->setFecha(u_fecha($_REQUEST["fecha_registro"] ?? fecha_hoy()));
    $ent->setC_banco(substr($_REQUEST["c_banco"], 0, 6));
    $ent->setC_cta_cte(substr($_REQUEST["c_banco"], 7));
    $ent->setSaldo_final(quitarComa($_REQUEST["saldo_final"]));
    $ent->setCod_ano(s_anho());
    $ent->setCod_mes($_REQUEST["c_mes"]);
    $ent->setCc_local(s_local_vinculado() ?? null);
    $ent->setC_usuario(s_usuario());
    $ent->setOpc($opc ?? null);

    $val = $bo->procesar($ent);
    if (!$val) {
        throw new Exception($bo->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
