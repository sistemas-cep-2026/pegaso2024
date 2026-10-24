<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");

$bo_asistencia = new bo_cont_asistencia();


$ent_asistencia = new cont_asistencia();

try {
    $opc =  s_crypt($_REQUEST["opc"],'out');
    $id        = s_crypt($_REQUEST["id"],'out');
    $cc_persona = s_crypt($_REQUEST["cc_persona"],'out');
    if($opc=='A'){
        $ent_asistencia->setId($id);
        $val=$bo_asistencia->control($ent_asistencia, $opc);
        if (!$val) {
            throw new Exception($bo_honorabilidad->errores());
        }
        echo '0';
    }else{

        $ent_asistencia->setId($id);
        $ent_asistencia->setCc_persona($cc_persona);
        $ent_asistencia->setPunch_time(u_fecha($_REQUEST["fecha"]).' '.$_REQUEST["hora"]);
        $flag = $_REQUEST["flag"] ?? 'I';
        $ent_asistencia->setFlag($flag);
        $ent_asistencia->setStatus($_REQUEST["horario"]);

        $val = $bo_asistencia->control($ent_asistencia, $opc);
        if (!$val) {
            throw new Exception($bo_asistencia->errores());
        }
        echo '0';
    }

} catch (Exception $e) {
    echo $e->getMessage();
}