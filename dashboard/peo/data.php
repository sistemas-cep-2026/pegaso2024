<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();

require_once u_src() . "bo/bo_general.php";
require_once u_src() . "bo/bo_nps_respuestas.php";

header('Content-Type: application/json; charset=utf-8');

$bo_nps_resp   = new bo_nps_respuestas();
$ent_nps_resp  = new nps_respuestas();

// Si hay filtros GET, setéalos en $ent_nps_resp

$data_respt = $bo_nps_resp->numeroClasificacion($ent_nps_resp);

$promotores = 0;
$pasivos = 0;
$detractores = 0;

if (is_array($data_respt) && count($data_respt) > 0) {
    $row = $data_respt[0];
    $promotores = (float)($row['promotores'] ?? 0);
    $pasivos    = (float)($row['pasivos'] ?? 0);
    $detractores = (float)($row['detractores'] ?? 0);
}

echo json_encode([
    "series" => [$promotores, $pasivos, $detractores],
    "totals" => [
        "promotores" => $promotores,
        "pasivos"    => $pasivos,
        "detractores" => $detractores
    ]
], JSON_UNESCAPED_UNICODE);

/***************BARRAS************** */
if (isset($_GET['op']) && $_GET['op'] === 'barras_sector') {
    // Limpiar buffers para evitar texto extra
    if (function_exists('ob_get_level')) {
        while (ob_get_level()) {
            ob_end_clean();
        }
    }

    @ini_set('display_errors', 0); // evitar que warnings rompan el JSON

    header('Content-Type: application/json; charset=utf-8');

    $data_barras = $bo_nps_resp->barras_sector($ent_nps_resp);

    $universidad   = (float)($data_barras[0]['u'] ?? 0);
    $ffaa          = (float)($data_barras[0]['f'] ?? 0);
    $essalud       = (float)($data_barras[0]['e'] ?? 0);
    $minsa         = (float)($data_barras[0]['m'] ?? 0);
    $privado       = (float)($data_barras[0]['p'] ?? 0);
    $independiente = (float)($data_barras[0]['i'] ?? 0);

    echo json_encode([
        "series" => [$universidad, $ffaa, $essalud, $minsa, $privado, $independiente],
        "totals" => [
            "u" => $universidad,
            "f" => $ffaa,
            "e" => $essalud,
            "m" => $minsa,
            "p" => $privado,
            "i" => $independiente
        ]
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
