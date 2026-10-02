<?php

require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";

s_validar_pagina();

require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");

header('Content-type: application/json; charset=utf-8');

$bo_comprobantes = new bo_banc_comprobantes_de_caja();
$ent_comprobantes = new banc_comprobantes_de_caja();

try {

    $opc = s_crypt($_REQUEST["opc"] ?? '', 'out');
    $cc_documento = s_crypt($_REQUEST["cc_documento"] ?? '', 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }

    $banco = $_REQUEST['c_banco'] ?? '';

    $c_banco = ($banco !== '') ? substr($banco, 0, 6) : '';
    $c_cta_cte = ($banco !== '') ? substr($banco, 7) : '';

    $cc_persona = $_REQUEST["cc_persona"] ?? '';
    $fecha = $_REQUEST["fecha"] ?? date('d/m/Y');
    $c_local = $_REQUEST["c_local"] ?? '';
    $c_forma_cancelacion = $_REQUEST["c_forma_cancelacion"] ?? '';
    $num_boleta_cheque = $_REQUEST["num_boleta_cheque"] ?? '';
    $observacion = $_REQUEST["observacion"] ?? '';

    $ent_comprobantes->setCc_documento($cc_documento);

    $ent_comprobantes->setC_persona(
        $cc_persona !== '' ? s_crypt($cc_persona, 'out') : ''
    );

    $ent_comprobantes->setFecha(u_fecha($fecha));
    $ent_comprobantes->setC_local($c_local);
    $ent_comprobantes->setCod_ano(s_anho());
    $ent_comprobantes->setCod_mes(s_periodo());
    $ent_comprobantes->setC_banco($c_banco);
    $ent_comprobantes->setC_cta_corriente($c_cta_cte);
    $ent_comprobantes->setC_forma_cancelacion($c_forma_cancelacion);
    $ent_comprobantes->setNum_boleta_cheque($num_boleta_cheque);
    $ent_comprobantes->setObservacion(strtoupper($observacion));
    $ent_comprobantes->setUsuario(s_usuario());
    $ent_comprobantes->setOpc($opc);

    $val = $bo_comprobantes->procesarIngresos($ent_comprobantes);

    if (!$val) {
        throw new Exception($bo_comprobantes->errores());
    }

    if ($opc === 'I') {
        $cc_documento = $val['cc_documento'] ?? '';
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('800003')
            . '&cod=' . s_crypt($cc_documento)
            . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {

    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
