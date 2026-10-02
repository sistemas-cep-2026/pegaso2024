<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_doc_recib = new bo_tram_documentos_recibidos();
$ent_doc_recib = new tram_documentos_recibidos();

$buscar = digitos(parsear($_REQUEST['query']),7);
$ent_doc_recib->setC_expediente($buscar);
$ent_doc_recib->setC_local(s_local());
$data_expedientes = $bo_doc_recib->buscarExpedienteHabilidad($ent_doc_recib);
$json = [];

foreach ($data_expedientes as $expedientes) {
    $json[] = [
        'nombres' => $expedientes['c_expediente'],
        'c_persona_institucion' => s_crypt($expedientes['c_persona_institucion']),
        'nombre_institucion' => $expedientes['nombre_institucion'],
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);