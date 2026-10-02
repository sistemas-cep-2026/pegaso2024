<?php
header('Access-Control-Allow-Origin: *');
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();

$bo_plan_ctas  = new bo_general();

$buscar = $_REQUEST["query"];


$data_plan_ctas = $bo_plan_ctas->ListarCuentasContables($buscar);

$json = [];
foreach ($data_plan_ctas as $row) {
    $json[] = [
        'c_cuenta' => $row['c_cuenta'],
        'nombre_cta' => $row['nombre_cuenta'],
    ];
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($json);
