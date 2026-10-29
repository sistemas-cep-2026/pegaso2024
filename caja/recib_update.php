<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
header('Content-type: application/json; charset=utf-8');
// Inicialización de objetos
$bo_ventas = new bo_fin_documentos_de_venta();
$ent_ventas = new fin_documentos_de_venta();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_ventas = s_crypt($_REQUEST["cc_ventas"], 'out');
    $c_persona = s_crypt($_REQUEST["c_persona"], 'out');

    if (empty($opc)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    if ($opc === 'I' && empty($c_persona)) {
        throw new Exception("Debe seleccionar al Cliente");
    }

    if ($opc === 'I') {
        $cod_documento_req = strtoupper(trim($_REQUEST['cod_documento'] ?? ''));
        $c_persona_ref_req = strtoupper(trim($_REQUEST['c_persona_ref'] ?? ''));
        $c_punto_venta_req = trim($_REQUEST['c_punto_de_venta'] ?? '');

        if ($c_punto_venta_req === '000137' && !in_array($cod_documento_req, ['FC', 'BC'], true)) {
            throw new Exception("En Doc. Electrónicos solo se permite Factura o Boleta.");
        }
        if (in_array($cod_documento_req, ['FC', 'BC'], true) && $c_persona_ref_req !== 'E') {
            throw new Exception("Para Factura o Boleta el cliente debe ser Razón social.");
        }
    }

    $ent_ventas->setCc_ventas($cc_ventas);
    $ent_ventas->setC_persona_ref($_REQUEST["c_persona_ref"] ?? '');
    $ent_ventas->setC_persona($c_persona);
    $ent_ventas->setCod_documento($_REQUEST["cod_documento"] ?? '');
    $ent_ventas->setC_punto_de_venta($_REQUEST['c_punto_de_venta'] ?? '');
    $ent_ventas->setHost_registro($_REQUEST['host_registro'] ?? '');
    $ent_ventas->setUsuario_registro(s_usuario());
    $ent_ventas->setC_local(!empty($_REQUEST["cc_local"]) ? s_crypt($_REQUEST["cc_local"], 'out') : '');
    $ent_ventas->setObservacion($_REQUEST["obs"] ?? '');
    $ent_ventas->setOpc($opc);

    $val = $bo_ventas->procesarBoleta($ent_ventas);
    if (!$val) {
        throw new Exception($bo_ventas->errores());
    }

    if ($opc === 'I') {
        $cc_ventas = $val['cc_ventas'] ?? null;
        $_SESSION['punto_venta'] = $_REQUEST['c_punto_de_venta'];
    }
    if ($opc === 'AL') {
        echo json_encode([
            'status' => true,
            'message' => null
        ]);
    } else {
        echo json_encode([
            'error' => false,
            'message' => null,
            'url' => '?id=' . s_crypt('940001', 'in') . '&cod=' . s_crypt($cc_ventas, 'in') . '&opc=' . s_crypt('U', 'in')
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
