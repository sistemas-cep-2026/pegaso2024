<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_gen_articulos.php");
s_validar_pagina();

$bo_articulo = new bo_gen_articulos();
$ent_articulo = new gen_articulos();

$buscar = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$ent_articulo->setC_local(s_local());
$ent_articulo->setNombre($buscar);

// Obtener datos
$data_articulos = $bo_articulo->listarSelect($ent_articulo);

$json = [];

if ($data_articulos) {
    foreach ($data_articulos as $row) {
        $json[] = [
            'c_articulo' => $row['c_articulo'],
            'nombres' => $row['nombre'],
            'stock_actual' => $row['stock_actual'],
            'unidad' => $row['unidad'],
        ];
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($json);