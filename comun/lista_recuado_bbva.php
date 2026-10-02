<?php
header('Content-Type: application/json; charset=utf-8');

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_recaud_bbva_proceso_detalle.php");

s_validar_pagina();

$bo_recaudobbva = new bo_recaud_bbva_proceso_detalle();

$ent_recaudobbva = new recaud_bbva_proceso_detalle();

$c_persona_enc = $_REQUEST['c_persona'] ?? '';

if ($c_persona_enc === '') {
    echo json_encode([]);
    exit;
}

$c_persona = s_crypt($c_persona_enc, 'out');

$ent_recaudobbva->setC_persona($c_persona);
$data = $bo_recaudobbva->tram_honorabilidad($ent_recaudobbva);

$response = [];
foreach ($data as $row) {
    $response[] = [
        'id'     => $row['id'],
        'nombre' => $row['registro']
    ];
}

echo json_encode($response);
