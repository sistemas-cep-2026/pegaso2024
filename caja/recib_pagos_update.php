<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once u_src() . "bo/bo_fin_items_planilla_de_cobranza.php";
s_validar_pagina();

$bo_caja_planill = new bo_fin_items_planilla_de_cobranza();

$ent_caja_planill = new fin_items_planilla_de_cobranza();

try {
    $opcp = s_crypt($_REQUEST["opcp"], 'out');
    $cc_ventas = s_crypt($_REQUEST["cc_ventas"], 'out');
    $cc_itemplanilla = !empty($_REQUEST["cc_itemplanilla"]) ? s_crypt($_REQUEST["cc_itemplanilla"], 'out') : '';
    $cod_forma_de_pago = $_REQUEST['cod_forma_de_pago'] ?? '';

    if (empty($opcp)) {
        throw new Exception("Parámetros obligatorios faltantes.");
    }
    $cta_cte_deposito = $_REQUEST['cta_cte_deposito'];
    $c_banco = substr($cta_cte_deposito, 0, 6);
    $cta_cte = (strlen($cta_cte_deposito) > 7) ? substr($cta_cte_deposito, 7) : '';

    $ent_caja_planill->setCc_ventas($cc_ventas);
    $ent_caja_planill->setCc_itemplanilla($cc_itemplanilla);
    $ent_caja_planill->setCod_forma_de_pago($cod_forma_de_pago);
    $ent_caja_planill->setC_banco_ref($c_banco);
    $ent_caja_planill->setCta_cte_deposito($cta_cte);
    $ent_caja_planill->setNum_referencia($_REQUEST['num_referencia']);
    $ent_caja_planill->setFecha_referencia(u_fecha($_REQUEST['fecha_referencia']));
    $ent_caja_planill->setMonto(u_limpiarMonto($_REQUEST['monto']));

    if ($opcp === 'I' && strtoupper((string)$cod_forma_de_pago) === 'V') {
        $val_valida = $bo_caja_planill->validarOperacion($ent_caja_planill);
        $existe = false;
        if (is_array($val_valida)) {
            $existe = count($val_valida) > 0;
        } elseif (is_object($val_valida) && method_exists($val_valida, 'rowCount')) {
            $existe = $val_valida->rowCount() > 0;
        } elseif (!empty($val_valida)) {
            $existe = true;
        }
        if ($existe) {
            echo json_encode([
                'status'  => false,
                'message' => 'El número de Operación ya existe'
            ]);
            exit;
        }
    }

    $val = $bo_caja_planill->control($ent_caja_planill, $opcp);

    if (!$val) {
        throw new Exception($bo_caja_planill->errores());
    }

    echo json_encode([
        'status' => true,
        'message' => null
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
    ]);
}
