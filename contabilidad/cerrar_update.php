<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_contabilidad_centralizar.php");
$bo = new bo_contabilidad_centralizar();

header('Content-Type: application/json; charset=utf-8');

try {
    $cc_local = trim($_POST['cc_local'] ?? '');
    $anho = trim($_POST['anho'] ?? '');
    $periodo = trim($_POST['periodo'] ?? '');
    $modulo = trim($_POST['modulo'] ?? '');
    $estado = $_POST['estado'] ?? null;

    $resultado = $bo->procesarCerrrar($cc_local, $anho, $periodo, $modulo, $estado);

    echo json_encode([
        'ok' => (bool)$resultado,
        'mensaje' => $resultado
            ? 'Estado actualizado correctamente.'
            : 'No se pudo actualizar el período.'
    ]);
} catch (Throwable $e) {
    http_response_code(400);

    echo json_encode([
        'ok' => false,
        'mensaje' => 'No se pudo actualizar el cierre.'
    ]);
}
