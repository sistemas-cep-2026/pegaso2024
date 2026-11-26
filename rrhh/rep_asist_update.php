<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");

$bo_asistencia = new bo_cont_asistencia();
$ent_asistencia = new cont_asistencia();

try {
    // Modificar marcaciones es solo para nivel A (igual que el interruptor Recuadre)
    if (s_nivel() !== 'A') {
        throw new Exception("No tiene permiso para modificar asistencias.");
    }

    $opc        = s_crypt($_REQUEST["opc"] ?? '', 'out');
    $id         = s_crypt($_REQUEST["id"] ?? '', 'out');
    $cc_persona = trim((string) s_crypt($_REQUEST["cc_persona"] ?? '', 'out'));

    if ($opc !== 'I' && $opc !== 'U') {
        throw new Exception("Opción inválida.");
    }
    if ($opc === 'U' && !ctype_digit((string) $id)) {
        throw new Exception("Registro no válido.");
    }
    if (!preg_match('/^[0-9A-Za-z]{1,10}$/', $cc_persona)) {
        throw new Exception("Persona no válida.");
    }

    $fecha = trim((string) ($_REQUEST["fecha"] ?? ''));
    $hora = trim((string) ($_REQUEST["hora"] ?? ''));
    $f = DateTime::createFromFormat('Y-m-d H:i', $fecha . ' ' . substr($hora, 0, 5));
    if (!$f) {
        throw new Exception("Ingrese una fecha y hora válidas.");
    }
    $horario = trim((string) ($_REQUEST["horario"] ?? ''));
    if (!ctype_digit($horario) || (int) $horario > 24) {
        throw new Exception("El horario debe ser un número de horas (0 a 24).");
    }
    $flag = (($_REQUEST["flag"] ?? '') === 'A') ? 'A' : 'I';

    $ent_asistencia->setId($id);
    $ent_asistencia->setCc_persona($cc_persona);
    $ent_asistencia->setPunch_time($f->format('Ymd H:i:s'));   // formato ISO, sin depender del idioma de SQL Server
    $ent_asistencia->setFlag($flag);
    $ent_asistencia->setStatus($horario);

    if (!$bo_asistencia->control($ent_asistencia, $opc)) {
        throw new Exception($bo_asistencia->errores());
    }
    echo '0';
} catch (Exception $e) {
    echo $e->getMessage();
}
