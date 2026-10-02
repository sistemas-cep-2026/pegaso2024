<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
try {
    require_once(u_src() . "bo/bo_tram_personas_especialidad.php");
    $bo_personas_esp = new bo_tram_personas_especialidad();
    $ent_personas_esp = new tram_personas_especialidad();

    $cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
    $opc = s_crypt($_REQUEST['opc'], 'out');
    $linea = s_crypt($_REQUEST['linea'], 'out');
    $forma_pago = $_REQUEST['forma_pago'];

    if (empty($forma_pago)) {
        throw new Exception("Falta seleccionar el modo de pago", 1);
    }

    $ent_personas_esp->setOpc($opc);
    $ent_personas_esp->setCc_persona($cc_persona);
    $ent_personas_esp->setLinea($linea);
    $ent_personas_esp->setCc_reg_esp($_REQUEST["cc_reg_esp"]);
    $ent_personas_esp->setTipo_especialidad($_REQUEST["tipo_especialidad"]);
    $ent_personas_esp->setFecha($_REQUEST["fecha"]);
    //$ent_personas_esp->setCc_especialidad($_REQUEST["cc_especialidad"]);
    $ent_personas_esp->setCc_universidad($_REQUEST["cc_universidad"]);
    $ent_personas_esp->setFecha_diploma($_REQUEST["fecha_diploma"]);
    $ent_personas_esp->setFlag_escolarizado($_REQUEST["flag_escolarizado"] ?? '&');
    $ent_personas_esp->setLiteral($_REQUEST["literal"]);
    $ent_personas_esp->setC_local($_REQUEST["c_local"]);
    $ent_personas_esp->setResidentado($_REQUEST["residentado"] ?? '&');
    $ent_personas_esp->setSemipresencial($_REQUEST["semipresencial"]);
    $ent_personas_esp->setflag_regularizado($_REQUEST["flag_regularizado"] ?? '');
    $ent_personas_esp->setObs($_REQUEST["observacion"] ?? '');
    
    $ent_personas_esp->setId_recaudo_bbva($_REQUEST['id_recaudo_bbva']);
    
    if ($forma_pago === 'V') {
        $ent_personas_esp->setBanco($_REQUEST['banco']);
        $ent_personas_esp->setOperacion($_REQUEST['operacion']);
        $ent_personas_esp->setFecha_op($_REQUEST['fecha_op']);
        $ent_personas_esp->setMonto($_REQUEST['monto']);
    }

    $bo_personas_esp->control($ent_personas_esp, $opc);

    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
