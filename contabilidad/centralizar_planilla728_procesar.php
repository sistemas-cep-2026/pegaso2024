 
<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_contabilidad_centralizar.php");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'mensaje' => 'Método no permitido.']);
    exit;
}

$cc_local = trim((string) ($_POST['cc_local'] ?? ''));
$anho = filter_var($_POST['anho'] ?? null, FILTER_VALIDATE_INT);
$periodo = filter_var($_POST['periodo'] ?? null, FILTER_VALIDATE_INT);

if ($cc_local === '' || strlen($cc_local) > 50 || $anho === false || $anho < 2024 || $anho > 2027 ||
    $periodo === false || $periodo < 1 || $periodo > 12) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'mensaje' => 'Local, año o período inválidos.']);
    exit;
}

// No confiar en el local enviado por el navegador.
if ((string) $cc_local !== (string) s_local_vinculado()) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'mensaje' => 'No tiene permiso para procesar este local.']);
    exit;
}

try {
    $bo = new bo_contabilidad_centralizar();
    $bo->procesarCompras($cc_local, $anho, $periodo);
    echo json_encode(['ok' => true, 'mensaje' => 'El procedimiento de centralización se ejecutó sin errores reportados.']);
} catch (Throwable $e) {
    error_log('Centralización compras: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'mensaje' => 'Error al procesar compras. Consulte el registro del servidor.']);
}
