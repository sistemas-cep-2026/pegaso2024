<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();
header('Content-Type: application/json; charset=utf-8');

$bo_general = new bo_general();

try {
    $cc_local_vinculado = trim((string) ($_REQUEST['cc_local_vinculado'] ?? ''));
    $periodo = trim((string) ($_REQUEST['cont_periodo'] ?? ''));
    $modulo = substr(trim((string) s_mod_id()), 0, 3);

    if (preg_match('/^[0-9]{6}$/', $periodo) !== 1) {
        throw new Exception('Seleccione un período válido.');
    }

    // 1) El consejo debe estar entre los permitidos al usuario.
    $permitidos = array();
    foreach ($bo_general->listarRegionesAdministrativo(s_local(), s_usuario()) as $loc) {
        $permitidos[] = trim($loc['c_local']);
    }
    if ($cc_local_vinculado === '' || !in_array($cc_local_vinculado, $permitidos, true)) {
        throw new Exception('El consejo seleccionado no está permitido.');
    }

    // 2) En Compras (700), Bancos (800) y Contabilidad (900) el período debe estar ABIERTO ('&').
    if (in_array($modulo, array('700', '800', '900'), true)) {
        $abierto = false;
        foreach ($bo_general->listarPeriodosAbiertos($cc_local_vinculado, $modulo) as $row) {
            if (trim($row['periodo']) === $periodo) {
                $abierto = true;
                break;
            }
        }
        if (!$abierto) {
            throw new Exception('El período ' . substr($periodo, 4, 2) . '/' . substr($periodo, 0, 4) . ' está cerrado o no existe para este módulo.');
        }
    }

    $anho = substr($periodo, 0, 4);
    $mes = substr($periodo, -2);

    unset($_SESSION["SES_ANHO"]);
    unset($_SESSION["SES_PERIODO"]);
    unset($_SESSION["CEP_ADM_SES_LOCAL_VINC"]);

    $_SESSION["SES_ANHO"] = $anho;
    $_SESSION["SES_PERIODO"] = $mes;
    $_SESSION["CEP_ADM_SES_LOCAL_VINC"] = $cc_local_vinculado;

    echo json_encode(array('error' => false, 'message' => null));
} catch (Exception $e) {
    echo json_encode(array('error' => true, 'message' => $e->getMessage()));
}
