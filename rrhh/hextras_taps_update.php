<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");
$bo_actividad = new bo_tram_actividad_sustento();

$ent_actividad = new tram_actividad_sustento();

try {
    $opc = s_crypt($_REQUEST['opc'], 'out');
    $cc_sustento        = s_crypt($_REQUEST["cc_sustento"], 'out');

    $ent_actividad->setCc_sustento($cc_sustento);
    $ent_actividad->setUsuario($_REQUEST["usuario"]);
    $ent_actividad->setCc_area_adm($_REQUEST["cc_area_adm"]);
    $ent_actividad->setObs($_REQUEST["obs"]);
    $ent_actividad->setFecha($_REQUEST["fecha"]);
    $ent_actividad->setDia($_REQUEST["dia"]);
    $ent_actividad->setCc_local($_REQUEST["cc_local"]);
    $ent_actividad->setFlag($_REQUEST["flag"]);

    $val = $bo_actividad->control($ent_actividad, $opc);
    if (!$val) {
        throw new Exception($bo_actividad->errores());
    }

    if ($opc == 'I') {
        $data = $bo_actividad->listarIDMax();
        $data = $data[0];
        $id = "930004";
        echo '0|?id=' . s_crypt($id, 'in') . "&cod=" . s_crypt($data['maximo'], 'in') . "&opc=" . s_crypt('U', 'in');
        die();
    } else {
        $id = "930004";
        echo '0|?id=' . s_crypt($id, 'in') . "&cod=" . s_crypt($cc_sustento, 'in') . "&opc=" . s_crypt('U', 'in');
        die();
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
