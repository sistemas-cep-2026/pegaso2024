<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
s_validar_pagina();
try {

    require_once(u_src() . "bo/bo_gen_personas.php");

    $bo_gen_personas = new bo_gen_personas();
    $ent_gen_personas = new gen_personas();

    $opc = s_crypt($_REQUEST["opc"], 'out');
    $c_persona = s_crypt($_REQUEST["c_persona"], "out");
    if ($opc == "I") {
        $data_per = $bo_gen_personas->c_persona_max($ent_gen_personas);
        $c_persona = $data_per[0]['nuevo_c_persona'];
    }

    $ent_gen_personas->setC_persona($c_persona);
    $ent_gen_personas->setGrado($_REQUEST["grado"]);
    $ent_gen_personas->setNombre(mb_strtoupper($_REQUEST["nombre"], 'UTF-8'));
    $ent_gen_personas->setNum_documento($_REQUEST["num_documento"]);

    $val = $bo_gen_personas->control_capacitacion($ent_gen_personas, $opc);

    if (!$val) {
        throw new Exception($bo_gen_personas->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
