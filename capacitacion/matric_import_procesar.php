<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula_temp.php");
header('Content-Type: application/json; charset=utf-8');

$bo_temp = new bo_cap_eventos_matricula_temp();

try {
    $cc_evento = s_crypt($_REQUEST["cc_evento"], 'out');
    if (empty($cc_evento)) {
        throw new Exception("Evento no especificado.");
    }

    $resultado = $bo_temp->procesar($cc_evento, s_usuario());

    if (empty($resultado)) {
        throw new Exception($bo_temp->errores() ?? "No se pudo procesar la importación.");
    }

    echo json_encode([
        'personas_creadas' => $resultado[0]['personas_creadas'],
        'total_procesados' => $resultado[0]['total_procesados'],
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
