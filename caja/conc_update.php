<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_articulos.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_concepto = new bo_gen_articulos();
$ent_concepto = new gen_articulos();

try {
    $opc = $_REQUEST["opc"];
    $c_articulo = $_REQUEST["c_articulo"];
    $c_usuario = $_REQUEST["c_usuario"];

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $ent_concepto->setC_articulo($c_articulo ?? null);
    $ent_concepto->setC_usuario($c_usuario ?? null);

    $val = $bo_concepto->control($ent_concepto, $opc);
    if (!$val) {
        throw new Exception($bo_concepto->errores());
    }
    echo '0';
    exit;
} catch (Exception $e) {
    echo $e->getMessage();
}
