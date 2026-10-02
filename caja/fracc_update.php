<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_prestamos_socios.php");
header('Content-type: application/json; charset=utf-8');

$bo = new bo_prestamos_socios();
$ent = new prestamos_socios();

try {
    $opc =$_REQUEST["opc"];
    $cc_persona =$_REQUEST["cc_persona"];
    $num_cuotas =$_REQUEST["cuotas"];
    $cc_fraccionamiento =$_REQUEST["cc_fraccionamiento"];
  
    if (empty($opc)) {
        throw new Exception("Parámetros OPC.");
    }
    $ent->setC_usuario(s_usuario());
    $ent->setC_persona($cc_persona);
    $ent->setNum_cuotas($num_cuotas);
    $ent->setOpc($opc);
    $ent->setCc_fraccionamiento($cc_fraccionamiento);
    
    $val = $bo->control($ent,$opc);
    if (!$val) {
        throw new Exception($bo->errores());
    }
   echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}