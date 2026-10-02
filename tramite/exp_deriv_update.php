<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");
$bo_exp_det = new bo_tram_seguimiento_documentos_recibid();
$ent_exp_det = new tram_seguimiento_documentos_recibid();
try {
    $opcd = s_crypt($_REQUEST['opcd'] ?? '',        'out');
    $cc_docrecibidos_det = s_crypt($_REQUEST['cc_docrecibidos_det'] ?? '', 'out');
    $cc_docrecibidos = s_crypt($_REQUEST['cc_docrecibidos'] ?? '', 'out');

    $linea = $_REQUEST['linea'] ?? 0;

    $ent_exp_det->setCc_docrecibidos_det($cc_docrecibidos_det);
    $ent_exp_det->setCc_docrecibidos($cc_docrecibidos);
    $ent_exp_det->setC_area_adm($_REQUEST['c_area_adm'] ?? '');
    $ent_exp_det->setCod_original($_REQUEST['cod_original'] ?? '');
    $ent_exp_det->setObservacion($_REQUEST['observacion'] ?? '');
    $ent_exp_det->setC_accion($_REQUEST['c_accion'] ?? '');
    $ent_exp_det->setFlag($_REQUEST['flag'] ?? '');
    $ent_exp_det->setLinea($linea);
    $ent_exp_det->setC_usuario(s_usuario());
    $ent_exp_det->setAccion_a_tomar($_REQUEST['accion_a_tomar'] ?? '');
    $ent_exp_det->setOpc($opcd);

    $val = $bo_exp_det->procesar_docRecibidos_detalle($ent_exp_det);
    if (!$val) {
        throw new Exception(
            $bo_exp_det->errores()
        );
    }
    echo '0';
} catch (Exception $e) {

    echo $e->getMessage();
}
