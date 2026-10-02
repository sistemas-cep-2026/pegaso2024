<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_gen_personas.php");
s_validar_pagina();

$bo_personas = new bo_gen_personas();
$ent_personas = new gen_personas();

//$buscar = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
$buscar = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$ent_personas->setRuc($buscar);

$data_personas = $bo_personas->buscarRucJson($ent_personas);

$json = [];

if ($data_personas) {
    foreach ($data_personas as $row) {
        $json[] = [
            'c_persona' => s_crypt($row['c_persona']),
            'ruc' => $row['ruc'],
            'nombres' => $row['razon_social'],
        ];
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
