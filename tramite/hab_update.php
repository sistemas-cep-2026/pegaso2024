<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
header('Content-Type: application/json; charset=utf-8');
try {

    require_once(u_src() . "bo/bo_tram_documentos_internos.php");
    $bo_tram_internos = new bo_tram_documentos_internos();
    $ent_tram_internos = new tram_documentos_internos();

    $c_persona = s_crypt($_REQUEST['c_persona'], 'out');
    $id_doc = s_crypt($_REQUEST['id_doc'], 'out');
    $opc = s_crypt($_REQUEST['opc'], 'out');
    $fecha = $_REQUEST['fecha'];
    $c_tipo = $_REQUEST['c_tipo'];
    $c_expediente = $_REQUEST['expediente'];
    $cod_codigo = $_REQUEST['cod_codigo'];
    $fecha_visado = $_REQUEST['fecha_visado'];
    $obs = $_REQUEST['obs'];
    $fecha_entrega = $_REQUEST['fecha_entrega'];
    $c_local = s_local();
    $usuario = s_usuario();

    $ent_tram_internos->setC_persona($c_persona);
    $ent_tram_internos->setId_doc($id_doc);
    $ent_tram_internos->setFecha($fecha);
    $ent_tram_internos->setC_tipo($c_tipo);
    $ent_tram_internos->setC_expediente($c_expediente);
    $ent_tram_internos->setCod_codigo($cod_codigo);
    $ent_tram_internos->setFecha_visado($fecha_visado);
    $ent_tram_internos->setFecha_entrega($fecha_entrega);
    $ent_tram_internos->setC_local($c_local);
    $ent_tram_internos->setOBS($obs);
    $ent_tram_internos->setC_usuario_n($usuario);

    $bo_tram_internos->control($ent_tram_internos, $opc);
    $id_max = $bo_tram_internos->listarMax($ent_tram_internos);
    $ent_tram_internos->setId_doc($id_max[0]['id_doc']);

    echo json_encode([
        "status" => TRUE,
        "url" => url('?id=' . s_crypt(s_mod_id()) . '&cod=' . s_crypt($ent_tram_internos->getId_doc()) . '&opc=' . s_crypt('U')),
        "message" => "Operación realizada con éxito"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => FALSE,
        "message" => "Error al procesar la operación: " . $e->getMessage()
    ]);
}
