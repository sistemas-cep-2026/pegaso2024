<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_gen_personas.php");
    require_once(u_src() . "bo/bo_gen_personas_exoneraciones.php");

    $bo_personas = new bo_gen_personas();
    $bo_personas_exo = new bo_gen_personas_exoneraciones();
    $ent_personas = new gen_personas();
    $ent_personas_exo = new gen_personas_exoneraciones();

    $c_persona = s_crypt($_REQUEST["c_persona"], 'out');
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $sin_retorno = isset($_REQUEST["sin_retorno"]) ? $_REQUEST["sin_retorno"]: '&';

    $desde = $_REQUEST["desde"];
    $hasta = $_REQUEST["hasta"];
    $mes_salida = explode("-", $desde)[1];
    $year_salida = explode("-", $desde)[0];
    $mes_retorno = '';
    $year_retorno = '';
    if (!isset($_REQUEST["sin_retorno"])) {
        $mes_retorno = explode("-", $hasta)[1];
        $year_retorno = explode("-", $hasta)[0];
    }

    $ent_personas_exo->setC_persona($c_persona);
    $ent_personas_exo->setPais($_REQUEST["pais"]);
    $ent_personas_exo->setMotivo($_REQUEST["motivo"]);
    $ent_personas_exo->setMes_salida($mes_salida);
    $ent_personas_exo->setYear_salida($year_salida);
    $ent_personas_exo->setMes_retorno($mes_retorno);
    $ent_personas_exo->setYear_retorno($year_retorno);
    $ent_personas_exo->setUsuario(s_usuario());
    $ent_personas_exo->setSustento($_REQUEST["sustento"]);
    $ent_personas_exo->setFlag_no_retorno($sin_retorno);

    $bo_personas_exo->control($ent_personas_exo, $opc);

    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
