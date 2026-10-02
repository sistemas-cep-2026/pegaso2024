<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . "/util/xlsx_lite.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula_temp.php");
header('Content-Type: application/json; charset=utf-8');

$bo_temp = new bo_cap_eventos_matricula_temp();

try {
    $cc_evento = s_crypt($_REQUEST["cc_evento"], 'out');
    if (empty($cc_evento)) {
        throw new Exception("Evento no especificado.");
    }

    if (!isset($_FILES['archivo_import']) || $_FILES['archivo_import']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir el archivo.");
    }

    $filas = xlsx_leer($_FILES['archivo_import']['tmp_name']);

    if (count($filas) < 2) {
        throw new Exception("El archivo no tiene filas de datos.");
    }

    // limpia una carga previa de este mismo evento antes de cargar la nueva
    $ent_limpiar = new cap_eventos_matricula_temp();
    $ent_limpiar->setCc_evento($cc_evento);
    $bo_temp->eliminarPorEvento($ent_limpiar);

    $cargados = 0;
    $omitidas = 0;

    foreach ($filas as $i => $fila) {
        if ($i === 0) continue; // encabezado

        $cep = trim($fila[0] ?? '');
        $num_documento = trim($fila[1] ?? '');
        $nombre = trim($fila[2] ?? '');
        $asistente = trim($fila[3] ?? '');
        $ponente = trim($fila[4] ?? '');
        $organizador = trim($fila[5] ?? '');

        if ($cep === '' && $num_documento === '' && $nombre === '') {
            $omitidas++;
            continue;
        }

        $ent_temp = new cap_eventos_matricula_temp();
        $ent_temp->setCc_evento($cc_evento);
        $ent_temp->setCep($cep);
        $ent_temp->setNum_documento($num_documento);
        $ent_temp->setNombre(mb_strtoupper($nombre, 'UTF-8'));
        $ent_temp->setAsistente($asistente);
        $ent_temp->setPonente($ponente);
        $ent_temp->setOrganizador($organizador);

        if (!$bo_temp->insertar($ent_temp)) {
            throw new Exception("Error al cargar fila " . ($i + 1) . ": " . $bo_temp->errores());
        }
        $cargados++;
    }

    echo json_encode([
        'cargados' => $cargados,
        'omitidas' => $omitidas,
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
