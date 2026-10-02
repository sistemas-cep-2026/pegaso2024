<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_gen_personas.php";

s_validar_pagina();

$bo_personas  = new bo_gen_personas();
$ent_personas = new gen_personas();

$buscar = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

if ($buscar !== '') {
    if (is_numeric($buscar)) {
        $ent_personas->setNum_documento($buscar);
    } else {
        $ent_personas->setNombre($buscar);
    }

    $data_personas = $bo_personas->buscarPersonasJson($ent_personas);

    $json = array_map(function($row) {
        return [
            'c_persona' => s_crypt($row['c_persona']),
            'nombres'   => $row['nombre_completo']
        ];
    }, $data_personas);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($json);
}