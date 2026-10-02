<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_beneficiofam.php");

$bo_fam = new bo_banc_beneficiofam();

$ent_fam = new banc_beneficiofam();
$usuario = s_usuario();
try {
    if (empty($_REQUEST["cc_persona"])) {
        throw new Exception("Selecciona datos del Colegiado");
    }
    $ent_fam->setCc_persona(s_crypt($_REQUEST["cc_persona"], 'out'));
    $data_per = $bo_fam->validar($ent_fam);
    if (is_array($data_per) && count($data_per) > 0) {
        throw new Exception("El colegiado ya cuenta con un apoyo FAM registrado.");
    }
    $ent_fam->setFecha(u_fecha($_REQUEST['fecha']));
    $ent_fam->setCc_local($_REQUEST['cc_local']);
    $ent_fam->setReferencia($_REQUEST["referencia"]);
    $ent_fam->setUser_crea($usuario);
    $ent_fam->setC_banco($_REQUEST["c_banco"]);
    $ent_fam->setFecha_operacion(u_fecha($_REQUEST['fecha_operacion']));
    $ent_fam->setMonto(u_limpiarMonto($_REQUEST['monto']));
    $ent_fam->setOperacion($_REQUEST['operacion']);
    $ent_fam->setCod_tipo($_REQUEST['cod_tipo']);

    if (!$bo_fam->control($ent_fam, 'I')) {
        throw new Exception($bo_fam->errores());
    }

    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
