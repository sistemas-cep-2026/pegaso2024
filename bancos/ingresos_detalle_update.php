<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_banc_items_comprobantes_de_caja.php");

$bo_comprob_det = new bo_banc_items_comprobantes_de_caja();
$ent_comprob_det = new banc_items_comprobantes_de_caja();

try {

    $opcd_encriptado = $_REQUEST['opcd'] ?? '';
    $cc_documento_det_encriptado = $_REQUEST['cc_documento_det'] ?? '';
    $cc_documento_encriptado = $_REQUEST['cc_documento'] ?? '';

    $opcd = ($opcd_encriptado !== '') ? s_crypt($opcd_encriptado, 'out') : '';
    $cc_documento_det = ($cc_documento_det_encriptado !== '')   ? s_crypt($cc_documento_det_encriptado, 'out') : '';
    $cc_documento = ($cc_documento_encriptado !== '') ? s_crypt($cc_documento_encriptado, 'out')  : '';
    $c_personad = $_REQUEST['c_personad'] ?? '';
    $cod_documento = $_REQUEST['cod_documento'] ?? '';
    $num_documento = $_REQUEST['num_documento'] ?? '';
    $c_cuenta = $_REQUEST['c_cuenta'] ?? '';
    $monto = $_REQUEST['monto'] ?? '0';

    $cc_compra = '';

    if ($opcd === 'D') {
        $cc_compra_encriptado = $_REQUEST['cc_compra'] ?? '';
        $cc_compra = ($cc_compra_encriptado !== '') ? s_crypt($cc_compra_encriptado, 'out') : '';
    }

    $ent_comprob_det->setCc_documento_det($cc_documento_det);
    $ent_comprob_det->setCc_documento($cc_documento);
    $ent_comprob_det->setC_persona($c_personad);
    $ent_comprob_det->setCod_documento($cod_documento);
    $ent_comprob_det->setNum_documento($num_documento);
    $ent_comprob_det->setC_cuenta($c_cuenta);
    $ent_comprob_det->setMonto(u_limpiarMonto((string)$monto));
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
