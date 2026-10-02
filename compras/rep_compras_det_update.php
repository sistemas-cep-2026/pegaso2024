<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_items_documentos_de_compra_cue.php");
$bo_compra_det = new bo_comp_items_documentos_de_compra_cue();
$ent_compra_det = new comp_items_documentos_de_compra_cue();
try {

    $opcd = s_crypt($_REQUEST['opcd'] ?? '', 'out');
    $cc_compra_det = s_crypt($_REQUEST['cc_compra_det'] ?? '', 'out');
    // $cc_compra = s_crypt($_REQUEST['cc_compra'], 'out');

    $cc_compra = s_crypt($_REQUEST['cc_compra'] ?? '', 'out');

    $ent_compra_det->setCc_compra_det($cc_compra_det);
    $ent_compra_det->setCc_compra($cc_compra);
    $ent_compra_det->setC_cuenta($_REQUEST['c_cuenta'] ?? '');
    $ent_compra_det->setDebe(quitarComa($_REQUEST['debe'] ?? ''));
    $ent_compra_det->setHaber(quitarComa($_REQUEST['haber'] ?? ''));
    $ent_compra_det->setOpcd($opcd);

    $val = $bo_compra_det->procesar_detalle($ent_compra_det);

    if (!$val) {
        throw new Exception($bo_compra_det->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
