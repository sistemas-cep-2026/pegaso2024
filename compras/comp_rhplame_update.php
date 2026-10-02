<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_rh_plame.php");
header('Content-type: application/json; charset=utf-8');

$bo = new bo_comp_rh_plame();
$ent = new comp_rh_plame();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_id = s_crypt($_REQUEST["cc_id"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $ent->setCc_id($cc_id ?? null);
    $ent->setCod_anho(s_anho());
    $ent->setCod_mes(s_periodo());
    $ent->setC_usuario(s_usuario());
    $ent->setFecha_registro(fecha_hora_hoy());      
    $ent->setC_persona(s_crypt($_REQUEST["cc_persona"], 'out'));
    $ent->setCod_documento($_REQUEST["cod_documento"]);
    $ent->setNum_documento($_REQUEST["num_documento"]);
    $ent->setFecha_documento(u_fecha($_REQUEST["fecha_documento"]));
    $ent->setFecha_pago(u_fecha($_REQUEST["fecha_pago"]));
    $ent->setCuarta($_REQUEST["cuarta"]);
    $ent->setMonto(quitarComa($_REQUEST["monto"]));
    $ent->setC_local(s_local_vinculado() ?? null);
    $ent->setOpc($opc ?? null);
 


    $val = $bo->control($ent, $opc);
    if (!$val) {
        throw new Exception($bo->errores());
    }
   echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}