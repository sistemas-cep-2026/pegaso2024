<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {
    require_once(u_src() . "bo/bo_tram_documentos_recaudo.php");

    $bo_doc_recaudo = new bo_tram_documentos_recaudo();
    $ent_doc_recaudo = new tram_documentos_recaudo();

    $c_persona = s_crypt($_REQUEST['c_persona'], 'out');
    $opc = s_crypt($_REQUEST['opc'], 'out');

    $ent_doc_recaudo->setC_persona($c_persona);
    $ent_doc_recaudo->setC_expediente($_REQUEST["c_expediente"]);
    $ent_doc_recaudo->setC_usuario_ingreso(s_usuario());
    $ent_doc_recaudo->setId_recaudo_bbva($_REQUEST['id_recaudo_bbva']);
    $ent_doc_recaudo->setBanco($_REQUEST['banco'] ?? '');
    $ent_doc_recaudo->setOperacion($_REQUEST['operacion'] ?? '');
    $ent_doc_recaudo->setFecha_op($_REQUEST['fecha_op'] ?? '');
    $ent_doc_recaudo->setMonto($_REQUEST['monto'] ?? '');
    $ent_doc_recaudo->setCod_tram_recaudo($_REQUEST['cod_tram_recaudo'] ?? '');
    $ent_doc_recaudo->setObs($_REQUEST['obs'] ?? '');

    $bo_doc_recaudo->control($ent_doc_recaudo, $opc);
    echo '0';

    
} catch (Exception $e) {
    echo $e->getMessage();
}
