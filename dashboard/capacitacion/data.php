<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");

$bo_eventos = new bo_cap_eventos();
$ent_eventos = new cap_eventos();

$cod_ano = isset($_GET['anho']) && is_numeric($_GET['anho'])
    ? (int) $_GET['anho']
    : s_anho();

$ent_eventos->setCc_local(s_local());
$ent_eventos->setFecha($cod_ano);

$data_asis_regiones = $bo_eventos->asistentes_total_local($ent_eventos);

$serie = array_map('intval', array_column($data_asis_regiones, 'n_asistentes'));

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'series' => $serie,
]);
