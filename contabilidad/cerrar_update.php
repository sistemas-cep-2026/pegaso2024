<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_contabilidad_centralizar.php");

header('Content-Type: application/json; charset=utf-8');

try {
    $cc_local = trim($_POST['cc_local'] ?? '');
    $anho = trim($_POST['anho'] ?? '');
    $periodo = trim($_POST['periodo'] ?? '');
    $modulo = trim($_POST['modulo'] ?? '');
    $estado = $_POST['estado'] ?? null;

    if (
        $cc_local === '' ||
        !preg_match('/^\d{4}$/', $anho) ||
        !preg_match('/^(0?[1-9]|1[0-2])$/', $periodo) ||
        !in_array($modulo, ['compras', 'bancos', 'contabilidad'], true) ||
        !in_array((string)$estado, ['0', '1'], true)
    ) {
        throw new Exception('Parámetros inválidos.');
    }

    $bo = new bo_contabilidad_centralizar();

    $resultado = $bo->actualizarCierre(
        $cc_local,
        $anho,
        $periodo,
        $modulo,
        (int)$estado
    );

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