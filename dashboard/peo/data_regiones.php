<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();
require_once u_src() . "bo/bo_general.php";
require_once u_src() . "bo/bo_nps_respuestas.php";

$bo_nps_resp   = new bo_nps_respuestas();
$ent_nps_resp  = new nps_respuestas();

$data_asis_regiones = $bo_nps_resp->personas_cr($ent_nps_resp);

$serie = array_map('intval', array_column($data_asis_regiones, 'total_personas'));

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'series' => $serie,
]);
