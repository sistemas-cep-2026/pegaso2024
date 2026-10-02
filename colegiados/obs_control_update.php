<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_gen_personas_obs_matricula.php");
s_validar_pagina();

$bo_personaobs = new bo_gen_personas_obs_matricula();

$ent_personaobs= new gen_personas_obs_matricula();

try {
    $opc='U';
    $cc_personaobs = s_crypt($_REQUEST["cc_personaobs"],'out');
    $fecha_reportado = $_REQUEST["fecha_reportado"];
    $fecha_respuesta = $_REQUEST["fecha_respuesta"];
    $respuesta = $_REQUEST["respuesta"];
    $doc_envio_numero = $_REQUEST["doc_envio_numero"];

    $ent_personaobs->setCc_personaobs($cc_personaobs);
    $ent_personaobs->setFecha_reportado(u_fecha($fecha_reportado));
    $ent_personaobs->setFecha_respuesta(u_fecha($fecha_respuesta));
    $ent_personaobs->setRespuesta($respuesta);
    $ent_personaobs->setDoc_envio_numero($doc_envio_numero);

    $val = $bo_personaobs->control($ent_personaobs, $opc);

    if (!$val) {
        throw new Exception($bo_personaobs->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}