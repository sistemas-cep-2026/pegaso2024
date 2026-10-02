<?php
require_once("../util/seguridad.php");
require_once("../util/util.php");
s_validar_pagina();
try {

    require_once(u_src() . "bo/bo_cap_eventos_matricula.php");

    $bo_matricula = new bo_cap_eventos_matricula();
    $ent_matricula = new cap_eventos_matricula();

    $opc = s_crypt($_REQUEST["opc"] ?? '', 'out');
    $cc_evento_mat = s_crypt($_REQUEST["cc_evento_mat"] ?? '', 'out');
    $cc_persona = s_crypt($_REQUEST["c_persona"],"out");
    $cc_evento = s_crypt($_REQUEST["cc_evento"] ?? '', 'out');

    if($opc==='I'){
        $ent_matricula->setC_persona($cc_persona);
        $ent_matricula->setCc_evento($cc_evento);

        $data_existe = $bo_matricula->validar($ent_matricula);
        if (!empty($data_existe)) {
            throw new Exception('Ya existe');
        }
    }
    $asistente = isset($_REQUEST['asistente']) ? $_REQUEST['asistente'] : 'null';
    $ponente = isset($_REQUEST['ponente']) ? $_REQUEST['ponente'] : 'null';
    $organizador = isset($_REQUEST['organizador']) ? $_REQUEST['organizador'] : 'null';

    $ent_matricula->setCc_evento_mat($cc_evento_mat);
    $ent_matricula->setCc_evento($cc_evento);
    $ent_matricula->setC_persona($cc_persona);
    $ent_matricula->setAsistente($asistente);
    $ent_matricula->setPonente($ponente);
    $ent_matricula->setOrganizador($organizador);
    $ent_matricula->setUser_crea(s_usuario());

    $val = $bo_matricula->control($ent_matricula, $opc);

    if (!$val) {
        throw new Exception($bo_matricula->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
