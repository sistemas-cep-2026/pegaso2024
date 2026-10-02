<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");
header('Content-Type: application/json; charset=utf-8');

$bo_matricula = new bo_cap_eventos_matricula();

$insertados = 0;
$errores = [];

try {
    $cc_evento = s_crypt($_REQUEST["cc_evento"], 'out');
    if (empty($cc_evento)) {
        throw new Exception("Evento no especificado.");
    }

    if (!isset($_FILES['archivo_import']) || $_FILES['archivo_import']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir el archivo.");
    }

    $ruta = $_FILES['archivo_import']['tmp_name'];
    $handle = fopen($ruta, 'r');
    if ($handle === false) {
        throw new Exception("No se pudo leer el archivo.");
    }

    $fila = 0;
    while (($linea = fgetcsv($handle, 0, ';')) !== false) {
        $fila++;

        // encabezado
        if ($fila == 1) {
            continue;
        }

        // fila vacía
        if (count($linea) < 5 || trim($linea[0]) === '') {
            continue;
        }

        $tipo = strtoupper(trim($linea[0]));
        $codigo = trim($linea[1]);
        $asistente = trim($linea[2]) === '1' ? '1' : '0';
        $ponente = trim($linea[3]) === '1' ? '1' : '0';
        $organizador = trim($linea[4]) === '1' ? '1' : '0';

        if (!in_array($tipo, ['C', 'O'])) {
            $errores[] = "Fila {$fila}: TIPO inválido ('{$tipo}'), debe ser C u O.";
            continue;
        }

        if (empty($codigo)) {
            $errores[] = "Fila {$fila}: CODIGO vacío.";
            continue;
        }

        $data_persona = $bo_matricula->buscarPersonaImport($tipo, $codigo);
        if (empty($data_persona)) {
            $errores[] = "Fila {$fila}: persona no encontrada (CODIGO {$codigo}).";
            continue;
        }
        $c_persona = $data_persona[0]['c_persona'];

        $ent_matricula = new cap_eventos_matricula();
        $ent_matricula->setC_persona($c_persona);
        $ent_matricula->setCc_evento($cc_evento);

        $data_existe = $bo_matricula->validar($ent_matricula);
        if (!empty($data_existe)) {
            $errores[] = "Fila {$fila}: ya matriculado (CODIGO {$codigo}).";
            continue;
        }

        $ent_matricula->setAsistente($asistente);
        $ent_matricula->setPonente($ponente);
        $ent_matricula->setOrganizador($organizador);
        $ent_matricula->setUser_crea(s_usuario());

        $val = $bo_matricula->control($ent_matricula, 'I');
        if (!$val) {
            $errores[] = "Fila {$fila}: error al grabar (CODIGO {$codigo}) - " . $bo_matricula->errores();
            continue;
        }

        $insertados++;
    }
    fclose($handle);

    echo json_encode([
        'insertados' => $insertados,
        'errores' => $errores,
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'insertados' => $insertados,
        'errores' => array_merge($errores, [$e->getMessage()]),
    ]);
    exit;
}
