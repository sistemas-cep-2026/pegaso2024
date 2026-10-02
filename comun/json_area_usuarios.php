<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();

$bo_general = new bo_general();

$cc_area_adm = $_REQUEST["cc_area_adm"] ?? '';

$data_usuarios = $bo_general->personal_areaAdministrativa(s_local(), $cc_area_adm);

$options = "<option value=''>Seleccione...</option>";
$options .= array_reduce($data_usuarios, function ($html, $row) {
    return $html . "<option value='{$row["usuario"]}'>{$row["nombre"]}</option>";
}, '');

echo $options;
