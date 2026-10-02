<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_doc_recib = new bo_tram_documentos_recibidos();
$ent_doc_recib = new tram_documentos_recibidos();

$buscar = parsear($_REQUEST['buscar']);
$ent_doc_recib->setC_expediente($buscar);
$data_expedientes = $bo_doc_recib->listarxExpediente($ent_doc_recib);
$json = [];

foreach ($data_expedientes as $expedientes) {
    $json[] = [
        'c_expediente' => $expedientes['c_expediente'],
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);