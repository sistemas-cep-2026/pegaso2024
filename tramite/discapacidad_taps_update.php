<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";

s_validar_pagina();

require_once u_src() . "bo/bo_gen_personas_discapacidad.php";
require_once u_src() . "bo/bo_gen_personas.php";

$bo_discapacidad  = new bo_gen_personas_discapacidad();
$bo_gen_personas  = new bo_gen_personas();
$ent_discapacidad = new gen_personas_discapacidad();
$usuario          = s_usuario();

try {

    $opc         = s_crypt($_REQUEST['opc'] ?? '', 'out');
    $cc_discapac = s_crypt($_REQUEST['cc_discapac'] ?? '', 'out');
    $cc_per      = s_crypt($_REQUEST['c_persona'] ?? '', 'out');
    $cc_persona  = digitos($cc_per, 6);

    $ultimo = null;

    if ($opc === 'A') {

        $ent_discapacidad->setCc_discapac($cc_discapac);
    } else {

        $ent_discapacidad->setCc_persona($cc_persona);
        $ent_discapacidad->setCod_tipo($_REQUEST['cod_tipo'] ?? null);
        $ent_discapacidad->setObs($_REQUEST['obs'] ?? null);
        $ent_discapacidad->setReg_conadis($_REQUEST['reg_conadis'] ?? null);
        $ent_discapacidad->setFecha_registro(
            isset($_REQUEST['fecha_registro']) ? u_fecha($_REQUEST['fecha_registro']) : null
        );
        $ent_discapacidad->setFlag('*');
        $ent_discapacidad->setUser_crea($usuario);
    }
    if (!$bo_discapacidad->control($ent_discapacidad, $opc)) {
        throw new Exception($bo_discapacidad->errores());
    }
    if ($opc !== 'A') {
        $data_ult = $bo_discapacidad->ultimo();
        if (!empty($data_ult)) {
            $ultimo = $data_ult[0]['ultimo'] ?? null;
        }
    }

    echo json_encode([
        'error'   => false,
        'message' => null,
        'url'     => '?id=' . s_crypt('400013', 'in') . '&cod=' . s_crypt($ultimo) . '&opc=' . s_crypt('U')
    ]);
} catch (Exception $e) {

    echo json_encode([
        'error'   => true,
        'message' => $e->getMessage()
    ]);
}
