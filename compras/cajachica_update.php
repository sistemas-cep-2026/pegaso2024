<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");
header('Content-type: application/json; charset=utf-8');

$bo_chica = new bo_comp_liquidaciones_caja_chica();
$ent_chica = new comp_liquidaciones_caja_chica();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_caja_chica = s_crypt($_REQUEST["cc_caja_chica"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $ent_chica->setCc_caja_chica($cc_caja_chica ?? null);
    $ent_chica->setNro_cheque($_REQUEST["nro_cheque"] ?? null);
    $ent_chica->setC_banco(substr($_REQUEST["c_banco"], 0, 6) ?? null);
    $ent_chica->setC_cta_corriente(substr($_REQUEST["c_banco"],7) ?? null);
    $ent_chica->setMonto(quitarComa($_REQUEST["monto"]) ?? null);
    $ent_chica->setFecha_operacion(u_fecha($_REQUEST["fecha_operacion"]) ?? null);
    $ent_chica->setC_local(s_local_vinculado() ?? null);
    $ent_chica->setMonto_apertura(quitarComa($_REQUEST["monto_apertura"]) ?? null);
    $ent_chica->setC_persona($_REQUEST["c_persona"] ?? null);
    $ent_chica->setC_usuario(s_usuario());
    $ent_chica->setOpc($opc ?? null);
    
    $val = $bo_chica->procesar($ent_chica);
 if (!$val) {
        throw new Exception($bo_chica->errores());
    }
   echo '0';

} catch (Exception $e) {
    echo $e->getMessage();
}