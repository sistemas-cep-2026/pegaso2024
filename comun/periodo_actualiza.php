<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();
$cc_local_vinculado = $_REQUEST['cc_local_vinculado'];
$periodo = $_REQUEST['cont_periodo'];

$anho = substr($periodo, 0, 4);
$mes = substr($periodo, -2);

unset($_SESSION["SES_ANHO"]);
unset($_SESSION["SES_PERIODO"]);
unset($_SESSION["CEP_ADM_SES_LOCAL_VINC"]);

$_SESSION["SES_ANHO"] = $anho;
$_SESSION["SES_PERIODO"] = $mes;
$_SESSION["CEP_ADM_SES_LOCAL_VINC"] = $cc_local_vinculado;
