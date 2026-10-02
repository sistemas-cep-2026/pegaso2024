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

    if ($opc === 'I') {
        $ent_compras->setCod_documento($_REQUEST["cod_documento"]);
        $ent_compras->setNum_documento($_REQUEST["num_documento"]);

        if (empty($c_persona)) {
            throw new Exception("Falta: RUC");
        }

        if (empty($_REQUEST["num_documento"])) {
            throw new Exception("Falta: Num-Documento");
        }

        $ent_compras->setCc_persona($c_persona);

        $data_existeruc = $bo_compras->ValidarRUC($ent_compras);
        if (!empty($data_existeruc)) {
            $resultado = $data_existeruc[0]['ruc'] ?? 0;
            if ($resultado == 0) {
                throw new Exception('El RUC es inválido. Proveedor sin RUC');
            }
        }

        $data_existe = $bo_compras->Validarregistro($ent_compras);

        if (!empty($data_existe)) {
            $fila = $data_existe[0];
            throw new Exception('El Documento ' . $_REQUEST["num_documento"] . ' de este proveedor ya existe => CR:' . $fila['c_local'] . ' (' . $fila['cod_mes'] . '/' .  $fila['cod_ano'] . ').');
        }
    }

    $ent_compras->setCc_compra($cc_compra);
    $ent_compras->setCod_documento($_REQUEST["cod_documento"]);
    $ent_compras->setNum_documento($_REQUEST["num_documento"]);
    $ent_compras->setCc_persona($c_persona);
    $ent_compras->setFecha_documento(u_fecha($_REQUEST["fecha_documento"]));
    $ent_compras->setFecha_vencimiento(u_fecha($_REQUEST["fecha_vencimiento"]));
    $ent_compras->setTotal(quitarComa(u_limpiarMonto($_REQUEST["total"])));
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

    $ent_compras->setC_liquidacion_caja_chica($_REQUEST["c_liquidacion_caja_chica"] ?? null);

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
        'url' => '?id=' . s_crypt('700001', 'in') . '&cod=' . s_crypt($cc_compra) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
