<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_gen_personas.php");
s_validar_pagina();

$bo_personas  = new bo_gen_personas();
$ent_personas = new gen_personas();

$buscar = htmlspecialchars($_GET['query'] ?? '');
if (is_numeric($buscar)) {
    $ent_personas->setC_cmp(digitos($buscar,6));
}else{
    $ent_personas->setNombre($buscar);
}

$data_personas = $bo_personas->buscarColegiadosJson($ent_personas);

$json = [];
foreach ($data_personas as $row) {
    $json[] = [
        'c_persona' => s_crypt($row['c_persona']),
        'nombres' => $row['nombre_completo'],
    ];
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);
