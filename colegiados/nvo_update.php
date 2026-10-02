<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {

    require_once(u_src() . "bo/bo_gen_personas.php");

    $bo_persona = new bo_gen_personas();
    $ent_personas = new gen_personas();

    $ent_personas->setC_persona(s_crypt($_REQUEST['c_persona'], 'out'));
    $ent_personas->setC_cmp($_REQUEST['c_cmp']);
    $ent_personas->setFecha_de_inicio($_REQUEST['fecha_de_inicio']);
    $ent_personas->setRegularizado($_REQUEST['regularizado'] ?? 'NULL');
    $bo_persona->control($ent_personas, 'NVO_CEP');

    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
