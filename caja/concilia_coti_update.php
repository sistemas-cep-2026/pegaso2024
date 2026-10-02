<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_teso_conciliacion_mensual.php");
header('Content-type: application/json; charset=utf-8');

$bo_conciliacion = new bo_teso_conciliacion_mensual();
$ent_conciliacion = new teso_conciliacion_mensual();

try {
    $opc = $_REQUEST["opc"];
    $cod_anho =$_REQUEST["cod_anho"];
    $cod_mes =$_REQUEST["cod_mes"];
    $monto = $_REQUEST["monto"];
    $cc_local =$_REQUEST["cc_local"];

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantesxx.");
    }
    $ent_conciliacion->setCod_anho($cod_anho ?? null);
    $ent_conciliacion->setCod_mes($cod_mes ?? null);
    $ent_conciliacion->setCc_local($cc_local ?? null);

    $ent_conciliacion->setUsuario(s_usuario());
    $ent_conciliacion->setMonto(preg_replace('/[^\d.]/', '', $monto));
    $ent_conciliacion->setOpc($opc ?? null);
    
    $val = $bo_conciliacion->procesar($ent_conciliacion);
    if (!$val) {
        throw new Exception($bo_conciliacion->errores());
    }
   echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}