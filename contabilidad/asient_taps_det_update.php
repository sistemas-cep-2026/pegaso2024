<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_items_voucher.php");
$bo_voucher_det = new bo_cont_items_voucher();
$ent_voucher_det = new cont_items_voucher();
try {

    $opcd = s_crypt($_REQUEST['opcd'], 'out');
    $cc_voucher_det = s_crypt($_REQUEST['cc_voucher_det'], 'out');
    $cc_voucher = s_crypt($_REQUEST['cc_voucher'], 'out');

    $ent_voucher_det->setCc_voucher_det($cc_voucher_det);
    $ent_voucher_det->setCc_voucher($cc_voucher);
    $ent_voucher_det->setC_cuenta($_REQUEST['c_cuenta']);
    $ent_voucher_det->setDebe(quitarComa($_REQUEST['debe']));
    $ent_voucher_det->setHaber(quitarComa($_REQUEST['haber']));
    $ent_voucher_det->setOpcd($opcd);

    $val = $bo_voucher_det->procesarDetalle($ent_voucher_det);

    if (!$val) {
        throw new Exception($bo_voucher_det->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
