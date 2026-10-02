<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_teso_conciliacion_mensual_transferencia.php");
header('Content-type: application/json; charset=utf-8');

$bo_conciliacion_pago = new bo_teso_conciliacion_mensual_transferencia();
$ent_conciliacion_pago = new teso_conciliacion_mensual_transferencia();

try {
    $opc = s_crypt($_REQUEST["opc"],'out');
    $cc_transferencia = s_crypt($_REQUEST["cc_transferencia"],'out');
    $cc_local = s_crypt($_REQUEST["cc_locald"],'out');
    $cod_anho = s_crypt($_REQUEST["cod_anhod"],'out');
    $cod_mes = s_crypt($_REQUEST["cod_mesd"],'out');
    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantesxx.");
    }

    $vfecha = isset($_REQUEST['vfecha']) ? $_REQUEST['vfecha'] : '';
    $vmonto = isset($_REQUEST['vmonto']) ? $_REQUEST['vmonto'] : '';

    $ent_conciliacion_pago->setCc_transferencia($cc_transferencia);
    $ent_conciliacion_pago->setCc_local($cc_local);
    $ent_conciliacion_pago->setCod_anho($cod_anho);
    $ent_conciliacion_pago->setCod_mes($cod_mes);
    $ent_conciliacion_pago->setBanco_cuenta($_REQUEST['banco_cuenta'] );
    $ent_conciliacion_pago->setVnop($_REQUEST['vnop']);
    $ent_conciliacion_pago->setVfecha(u_fecha($vfecha));
    $ent_conciliacion_pago->setVmonto(u_limpiarMonto($vmonto));
    $ent_conciliacion_pago->setObs($_REQUEST['obs']);
    $ent_conciliacion_pago->setUser_crea(s_usuario());
   
    $val = $bo_conciliacion_pago->control($ent_conciliacion_pago, $opc);
    if (!$val) {
        throw new Exception($bo_conciliacion_pago->errores());
    }
   echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}