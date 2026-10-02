<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
$bo_gen_personas = new bo_gen_personas();
$data = $bo_gen_personas->printFotosColegiacion_limpiar();
echo '0';