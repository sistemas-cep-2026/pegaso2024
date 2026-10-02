<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_modulo_nota.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_modnota = new bo_cap_eventos_modulo_nota();

$ent_modnota = new cap_eventos_modulo_nota();

try {
    $opc = s_crypt($_REQUEST["opc"], 'out');
    $cc_evento_mat = s_crypt($_REQUEST["cc_evento_mat"], 'out');
    $cc_modnota = isset($_REQUEST["cc_modnota"]) ? s_crypt($_REQUEST["cc_modnota"], 'out') : '';

    $ent_modnota->setCc_evento_mat($cc_evento_mat);
    $ent_modnota->setCc_modnota($cc_modnota);
    $ent_modnota->setCc_capmod($_REQUEST["cc_capmod"]);
    $ent_modnota->setNota($_REQUEST["nota"]);

    if ($opc === 'I') {
        $data_existe = $bo_modnota->validar($ent_modnota);
        if (!empty($data_existe)) {
            throw new Exception('Esta matrícula ya tiene una nota registrada.');
        }
    }

    $val = $bo_modnota->control($ent_modnota, $opc);
    if (!$val) {
        throw new Exception($bo_modnota->errores() ?? 'Error desconocido.');
    }
    echo "0";
    exit;
} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}
