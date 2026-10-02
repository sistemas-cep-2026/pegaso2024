<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_modulo_perfil.php");
s_validar_pagina();
$cc_perfil      = 	$_REQUEST["cc_perfil"];
//$cc_modulo		=	$_REQUEST["cc_modulo"];
$cc_modulo = isset($_REQUEST["cc_modulo"]) ? $_REQUEST["cc_modulo"] : [];
$bo_modulo_perfil = new bo_seg_modulo_perfil();
$modulo_perfil    = new seg_modulo_perfil();

$error             = "0";
$mensaje           = "";

if (!(empty($_REQUEST["cc_modulo"]))) {
	if (count($cc_modulo) > 0) {
		$val = $bo_modulo_perfil->eliminar($cc_perfil);
		if (!$val) {
			echo "Ocurrio algo al guardar => " . $bo_modulo_perfil->errores();
			exit;
		}
	}
	foreach ($_REQUEST["cc_modulo"] as $key => $value) {

		$modulo_perfil->setCc_modulo($value);
		$modulo_perfil->setCc_perfil($cc_perfil);

		$val = $bo_modulo_perfil->control($modulo_perfil);
		if (!$val) {
			echo "Ocurrio algo al guardar => " . $bo_modulo_perfil->errores();
			exit;
		}
	}
}
echo '0';