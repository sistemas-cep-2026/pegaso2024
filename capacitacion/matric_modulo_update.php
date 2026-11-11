<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");
require_once(u_src() . "bo/bo_cap_eventos_modulo_nota.php");
header('Content-Type: text/plain; charset=utf-8');

$bo_matricula = new bo_cap_eventos_matricula();
$bo_modulo = new bo_cap_eventos_modulo();
$bo_modnota = new bo_cap_eventos_modulo_nota();

try {
    // Matrícula: debe existir y ser de un ponente (el evento se toma de la BD, no del formulario)
    $cc_evento_mat = s_crypt($_REQUEST['cc_evento_mat'] ?? '', 'out');
    if (!ctype_digit((string)$cc_evento_mat)) {
        throw new Exception('Matrícula no válida.');
    }
    $ent_matricula = new cap_eventos_matricula();
    $ent_matricula->setCc_evento_mat($cc_evento_mat);
    $data_mat = $bo_matricula->listarID($ent_matricula);
    $mat = $data_mat[0] ?? null;
    if ($mat === null) {
        throw new Exception('La matrícula no existe.');
    }
    if (trim((string)$mat['ponente']) !== '1') {
        throw new Exception('La persona no está marcada como ponente.');
    }

    // Módulos activos del evento
    $ent_modulo = new cap_eventos_modulo();
    $ent_modulo->setCc_evento($mat['cc_evento']);
    $activos = [];
    foreach ($bo_modulo->listar($ent_modulo) as $m) {
        if (trim((string)$m['flag']) === '*') {
            $activos[(int)$m['cc_capmod']] = true;
        }
    }

    // Módulos ya asignados: cc_capmod => [cc_modnota, ...]
    $ent_modnota = new cap_eventos_modulo_nota();
    $ent_modnota->setCc_evento_mat($cc_evento_mat);
    $asignados = [];
    foreach ($bo_modnota->listarID($ent_modnota) as $a) {
        $asignados[(int)$a['cc_capmod']][] = (int)$a['cc_modnota'];
    }

    // Módulo elegido en el formulario (un ponente tiene un solo módulo; vacío = sin módulo)
    $elegido = 0;
    $modulo_in = trim((string)($_REQUEST['modulo'] ?? ''));
    if ($modulo_in !== '') {
        $id = s_crypt($modulo_in, 'out');
        if (!ctype_digit((string)$id)) {
            throw new Exception('Módulo no válido.');
        }
        $elegido = (int)$id;
        // solo se puede asignar un módulo activo del evento; el ya asignado se puede conservar aunque esté anulado
        if (!isset($activos[$elegido]) && !isset($asignados[$elegido])) {
            throw new Exception('El módulo seleccionado no pertenece al evento o está anulado.');
        }
    }

    // 1) primero se agrega el elegido si aún no está (si algo falla no se pierde lo ya asignado)
    if ($elegido > 0 && !isset($asignados[$elegido])) {
        $ent_nuevo = new cap_eventos_modulo_nota();
        $ent_nuevo->setCc_capmod($elegido);
        $ent_nuevo->setCc_evento_mat($cc_evento_mat);
        if (!$bo_modnota->control($ent_nuevo, 'I')) {
            throw new Exception($bo_modnota->errores() ?: 'Error desconocido.');
        }
    }

    // 2) luego se quitan los demás módulos del ponente
    foreach ($asignados as $id => $lista_modnota) {
        if ($id === $elegido) {
            continue;
        }
        foreach ($lista_modnota as $cc_modnota) {
            $ent_quitar = new cap_eventos_modulo_nota();
            $ent_quitar->setCc_modnota($cc_modnota);
            if (!$bo_modnota->control($ent_quitar, 'E')) {
                throw new Exception($bo_modnota->errores() ?: 'Error desconocido.');
            }
        }
    }

    echo "0";
    exit;
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
