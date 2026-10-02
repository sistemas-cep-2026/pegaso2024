<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/xlsx_lite.php");
s_validar_pagina();

xlsx_generar_plantilla(
    ['CEP', 'NUM_DOCUMENTO', 'NOMBRE', 'ASISTENTE', 'PONENTE', 'ORGANIZADOR'],
    'plantilla_matricula.xlsx'
);
