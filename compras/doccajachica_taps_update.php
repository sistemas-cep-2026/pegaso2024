<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
header('Content-type: application/json; charset=utf-8');
// Inicialización de objetos
$bo_compras = new bo_comp_documentos_de_compras();
$ent_compras = new comp_documentos_de_compras();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_compra = s_crypt($_REQUEST["cc_compra"], 'out');
    $c_persona = s_crypt($_REQUEST["cc_persona"], 'out');

    if (empty($opc)) {
        throw new Exception("Falta: OPC");
    }
    if (empty($_REQUEST["total"]) or $_REQUEST["total"]<0.01) {
            throw new Exception("Monto: Cantidad invalida");
        }
    if ($opc === 'I') {
        $ent_compras->setCod_documento($_REQUEST["cod_documento"]);
        $ent_compras->setNum_documento($_REQUEST["num_documento"]);
        $ent_compras->setCc_persona($c_persona);
        if (empty($c_persona)) {
            throw new Exception("Falta: RUC");
        }
        if (empty($_REQUEST["num_documento"])) {
            throw new Exception("Falta: Num-Documento");
        }
        
        $data_existe = $bo_compras->Validarregistro($ent_compras);
        if (!empty($data_existe)) {
            throw new Exception('El Documento ' . $_REQUEST["num_documento"] . ' ya existe');
        }
    }

    // Asignar valores según la operación
    $ent_compras->setCc_compra($cc_compra);
    $ent_compras->setCod_documento($_REQUEST["cod_documento"]);
    $ent_compras->setNum_documento($_REQUEST["num_documento"]);
    $ent_compras->setCc_persona($c_persona);
    $ent_compras->setFecha_documento(u_fecha($_REQUEST["fecha_documento"]));
    $ent_compras->setFecha_vencimiento(u_fecha($_REQUEST["fecha_vencimiento"]));
    $ent_compras->setTotal(quitarComa($_REQUEST["total"]));
    $ent_compras->setObservacion($_REQUEST["observacion"]);
    $ent_compras->setCc_local(s_local_vinculado());
    $ent_compras->setUser_crea(s_usuario());
    $ent_compras->setOpc($opc);
    $ent_compras->setCod_ano(s_anho());
    $ent_compras->setCod_mes(s_periodo());

    $tipoDesc = $_REQUEST['tipo_desc'];
    $ent_compras->setTipo_desc($tipoDesc);

    $porcentaje = ($tipoDesc === 'D') ? $_REQUEST['porcentaje'] : $_REQUEST['porcentaje_ret'];
    $ent_compras->setPorcentaje($porcentaje);
    $ent_compras->setReten_numero($_REQUEST['reten_numero'] ?? null);
    $ent_compras->setReten_fecha(!empty($_REQUEST['reten_fecha']) ? u_fecha($_REQUEST['reten_fecha']) : null);

    $ent_compras->setC_liquidacion_caja_chica($_REQUEST["cc_caja_chica"]);

    $val = $bo_compras->procesar($ent_compras);
    if (!$val) {
        throw new Exception($bo_compras->errores());
    }

    if ($opc === 'I') {
        $cc_compra = $val['cc_compra'] ?? null;
    }

    echo json_encode([
        'error' => false,
        'message' => null,
        'url' => '?id=' . s_crypt('700003', 'in') . '&cod=' . s_crypt($cc_compra) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
