<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_honorabilidad.php");
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_honorabilidad = new bo_tram_honorabilidad();
$bo_gen_personas = new bo_gen_personas();

$ent_honorabilidad = new tram_honorabilidad();
$usuario = s_usuario();
try {
    $opc =  s_crypt($_REQUEST["opc"], 'out');
    $c_persona = s_crypt($_REQUEST["c_persona"], 'out');
    $cc_honorab        = s_crypt($_REQUEST["cc_honorab"], 'out');
    /*if (!isset($_REQUEST["c_persona"]) || empty($_REQUEST["c_persona"])) {
        throw new Exception("Selecciona datos del Colegiado");
    }*/
    $ent_honorabilidad->setCc_honorab($cc_honorab);
    $ent_honorabilidad->setCc_persona($c_persona);
    $ent_honorabilidad->setFecha_text($_REQUEST["fecha_text"]);
    $ent_honorabilidad->setCargo($_REQUEST["cargo"]);
    $ent_honorabilidad->setAutoridad($_REQUEST["autoridad"]);
    $ent_honorabilidad->setImg_fondo($_REQUEST["img_fondo"]);
    $ent_honorabilidad->setUser_crea($usuario);
    $ent_honorabilidad->setRecaudo_id($_REQUEST["recaudo_id"]);
    $ent_honorabilidad->setNombre_anho($_REQUEST["nombre_anho"]);
    $ent_honorabilidad->setOpc($opc);

    $val = $bo_honorabilidad->control($ent_honorabilidad, $opc);
    if (!$val) {
        throw new Exception($bo_honorabilidad->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
