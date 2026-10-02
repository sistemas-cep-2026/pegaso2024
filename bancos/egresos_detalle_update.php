<?php

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_banc_items_comprobantes_de_caja.php");

$bo_comprob_det = new bo_banc_items_comprobantes_de_caja();
$ent_comprob_det = new banc_items_comprobantes_de_caja();

try {

    $opcd = s_crypt($_REQUEST['opcd'] ?? '', 'out');

    $cc_documento_det = !empty($_REQUEST['cc_documento_det']) ? s_crypt($_REQUEST['cc_documento_det'], 'out') : '';

    $cc_documento = !empty($_REQUEST['cc_documento']) ? s_crypt($_REQUEST['cc_documento'], 'out') : '';

    $cc_compra = '';

    if ($opcd === 'D') {
        $cc_compra = !empty($_REQUEST['cc_compra']) ? s_crypt($_REQUEST['cc_compra'], 'out')  : '';
    }

    $ent_comprob_det->setCc_documento_det($cc_documento_det);
    $ent_comprob_det->setCc_documento($cc_documento);
    $ent_comprob_det->setC_persona(s_crypt($_REQUEST['c_persona_hijo'] ?? '', 'out'));
    $ent_comprob_det->setCod_documento($_REQUEST['cod_documento'] ?? '');
    $ent_comprob_det->setNum_documento($_REQUEST['num_documento'] ?? '');
    $ent_comprob_det->setC_cuenta($_REQUEST['c_cuenta'] ?? '');
    $ent_comprob_det->setMonto(u_limpiarMonto($_REQUEST['monto'] ?? '0'));
    $ent_comprob_det->setCc_compra($cc_compra);
    $ent_comprob_det->setOpcd($opcd);

    $val = $bo_comprob_det->procesar_detalle($ent_comprob_det);

    if (!$val) {
        throw new Exception($bo_comprob_det->errores());
    }

    echo '0';
} catch (Exception $e) {

    echo $e->getMessage();
}
