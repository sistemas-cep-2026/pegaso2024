<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_dietas_detalles.php");
$bo = new bo_banc_dietas_detalles();
$ent = new banc_dietas_detalles();
try {

    $opcd = 'U';
    $cc_dietas_detalles = s_crypt($_REQUEST['cc_dietas_detalles'], 'out');
    $cc_dietas = s_crypt($_REQUEST['cc_dietas'], 'out');
 
    

    $ent->setCc_dietas_detalles($cc_dietas_detalles);
    $ent->setCc_dietas($cc_dietas);
    $ent->setRenta_bruta(u_limpiarMonto($_REQUEST['renta_bruta']));
    $ent->setRetencion(($_REQUEST['retencion']/100));
 
    $val = $bo->control($ent,$opcd);

    if (!$val) {
        throw new Exception($bo->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
