<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_cap_eventos.php");

s_validar_pagina();

$bo_eventos = new bo_cap_eventos();
$c_local = $_REQUEST["c_local"] ?? '';
$anho = $_REQUEST["anho"] ?? '';

$data_cursos = $bo_eventos->ListarEventos($c_local, $anho);

$options = array_reduce($data_cursos, function($html, $row) {
    return $html . "<option value='{$row["cc_evento"]}'>{$row["nombre_evento_text"]}</option>";
}, '');

echo $options;