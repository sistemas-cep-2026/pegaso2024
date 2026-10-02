<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas = new bo_gen_personas();
$ent_personas = new gen_personas();

$nombres = $_REQUEST['nombres'];
$num_documento = $_REQUEST['num_documento'];
$cod_documento = $_REQUEST['cod_documento'];
$flag_activo = $_REQUEST['flag_activo'];
$c_local = $_REQUEST["c_local"] === '28' ? '' : $_REQUEST["c_local"];
$desde = digitos($_REQUEST['desde'], 6);
$hasta = digitos($_REQUEST['hasta'], 6);

$ent_personas->setDesde($desde);
$ent_personas->setHasta($hasta);
$ent_personas->setNombre($nombres);
$ent_personas->setNum_documento($num_documento);
$ent_personas->setCod_documento($cod_documento);
$ent_personas->setFlag_activo($flag_activo);
$ent_personas->setFlag_activo($flag_activo);
$ent_personas->setC_local($c_local);

$data_personas = $bo_personas->listarReporteColegiados($ent_personas);
$json = [];
$i = 1;
foreach ($data_personas as $row) {
    $json[] = [
        'row_id' => $i,
        'cep' => $row['cep'],
        'nombre_completo' => $row['nombre_completo'],
        'cod_mun_documento_text' => $row['cod_documento_text'] . ': ' . $row["num_documento"],
        'c_local_abv' => $row['c_local_abv'],
        'fecha_col' => $row['fecha_col'],
        'fecha_nac' => $row['fecha_nac'],
        'Email1' => $row['Email1'],
        'celular1' => $row['celular1'],
        'flag_activo_text' => $row['flag_activo_text'],
        'flag_habil_text' => $row['flag_habil_text'],
        'abono_favor' => decimal($row["abono_favor"], 2)
    ];
    $i++;
}
$arr_json = [
    'data' => $json
];
header('Content-type: application/json; charset=utf-8');
echo json_encode($arr_json);
