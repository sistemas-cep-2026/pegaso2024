<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_actividad_sustento_detalle.php");
$bo_actividad_det = new bo_tram_actividad_sustento_detalle();

$ent_actividad_det = new tram_actividad_sustento_detalle();

try {
    $opcd             = $_REQUEST["opcd"] ?? '';
    $cc_sustento      = $_REQUEST["cc_sustento"] ?? '';
    $cc_sustento_det  = $_REQUEST["cc_sustento_det"] ?? '';

    if ($opcd == 'E') {
        $ent_actividad_det->setCc_sustento_det($cc_sustento_det);
        $val = $bo_actividad_det->control($ent_actividad_det, $opcd);
        if (!$val) {
            throw new Exception($bo_actividad_det->errores());
        }
        echo '0';
    } else {
        $ent_actividad_det->setCc_sustento($cc_sustento);
        $ent_actividad_det->setObs($_REQUEST["obsde"]);
        $ent_actividad_det->setHoraini($_REQUEST["horaini"]);
        $ent_actividad_det->setHorafin($_REQUEST["horafin"]);

        $val = $bo_actividad_det->control($ent_actividad_det, $opcd);
        if (!$val) {
            throw new Exception($bo_actividad_det->errores());
        }

        echo '0';
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
