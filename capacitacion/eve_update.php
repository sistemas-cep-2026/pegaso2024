<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos.php");
header('Content-type: application/json; charset=utf-8');

$bo_evento = new bo_cap_eventos();
$ent_eventos = new cap_eventos();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_evento = s_crypt($_REQUEST["cc_evento"], 'out');
    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    if ($opc === 'PU') {
        $ent_eventos->setCc_evento($cc_evento);
        $resultado = $bo_evento->control($ent_eventos, 'PU');
        echo $resultado ? '0' : 'Error al publicar el evento';
        exit;
    }
    $ent_eventos->setOpc($opc);
    $ent_eventos->setCc_evento($cc_evento);
    $ent_eventos->setNombre($_REQUEST['nombre']);
    $ent_eventos->setCc_local($_REQUEST['cc_local']);
    $ent_eventos->setTipo($_REQUEST['tipo']);
    $ent_eventos->setFecha_ini(u_fecha($_REQUEST['fecha_ini']));
    $ent_eventos->setFecha_fin(u_fecha($_REQUEST['fecha_fin']));
    $ent_eventos->setFecha_evento_text($_REQUEST['fecha_evento_text']);
    $ent_eventos->setDetalle($_REQUEST['detalle']);
    $ent_eventos->setDetalle_ponente($_REQUEST['detalle_ponente']);
    $ent_eventos->setPrint_documento($_REQUEST['print_documento']);
    $ent_eventos->setText_documento($_REQUEST['text_documento'] ?? '');
    $ent_eventos->setUser_crea(s_usuario());


    $val = $bo_evento->creaeventos($ent_eventos);
    if (!$val) {
        throw new Exception($bo_evento->errores() ?? 'Error desconocido.');
    }
    if ($opc === 'I') {

        $cc_evento = $val['cc_evento'] ?? null;
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('410001') . '&sec=' . s_crypt('2') . '&cod=' . s_crypt($cc_evento, 'in') . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
