<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {
	require_once(u_src() . "bo/bo_web_tram_colegiacion_control.php");

	$bo_control  = new bo_web_tram_colegiacion_control();
	$ent_control = new web_tram_colegiacion_control();

	$ent_control->setC_persona(s_crypt($_REQUEST["c_persona"], 'out'));
	$ent_control->setCodigo($_REQUEST["codigo"]);
	$ent_control->setDetalle($_REQUEST["detalle"]);
	$ent_control->setEstado($_REQUEST["estado"]);
	$ent_control->setCc_usuario(s_usuario());
	$bo_control->procesarControl_CL($ent_control);
	echo '0';
} catch (Exception $e) {
	echo $e->getMessage();
}
