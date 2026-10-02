<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/xlsx_lite.php");

s_validar_pagina();

$headers = [
    'FECHA',
    'NUMERO_OPERACION',
    'MONTO',
    'REFERENCIA01',
    'REFERENCIA02',
    'CUENTA_CONTABLE',
    'BANCO',
    'CUENTA_BANCARIA',
    'C_BANCO',
    'NUM_BANCO'
];


$filename = 'molde_importacion_bancos' . date('Y-m-d_His') . '.xlsx';


xlsx_generar_plantilla($headers, $filename);
