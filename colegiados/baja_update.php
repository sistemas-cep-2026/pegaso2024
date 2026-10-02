<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {

    require_once(u_src() . "bo/bo_gen_personas_suspendidas.php");

    $bo_persona = new bo_gen_personas_suspendidas();
    $ent_persona = new gen_personas_suspendidas();
    $opc = s_crypt($_REQUEST['opc'], 'out');
    $ent_persona->setC_persona(s_crypt($_REQUEST['c_persona'], 'out'));
    $ent_persona->setCc_psuspendidas(s_crypt($_REQUEST['cc_psuspendidas'] ?? '', 'out'));
    $ent_persona->setUser_crea(s_usuario());
    $ent_persona->setFlag(s_crypt($_REQUEST['flag'] ?? '', 'out'));
    $ent_persona->setObs($_REQUEST['obs'] ?? '');
    $ent_persona->setOpc($opc);

    $ent_persona->setResol1($_REQUEST['resol1'] ?? '');
    $ent_persona->setDesde($_REQUEST['desde'] ?? '');
    $ent_persona->setUrl($_REQUEST['url'] ?? '');
    
    $bo_persona->control($ent_persona, $opc);

    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
