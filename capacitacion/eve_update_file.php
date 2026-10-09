<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/class_upload.php");

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_cap_eventos.php");

    $bo_evento   = new bo_cap_eventos();
    $ent_eventos = new cap_eventos();

    $opc       = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_evento = isset($_REQUEST["cc_evento"]) ? s_crypt($_REQUEST["cc_evento"], 'out') : '';

    if (empty($opc) || empty($cc_evento)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    $ruta_carpeta = __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;

    // Lista blanca: solo estos 2 campos pueden manejarse aquí.
    $camposPermitidos = ['img_asistente', 'img_ponente'];

    if ($opc === 'UPLOAD') {
        $campo = null;
        foreach ($camposPermitidos as $c) {
            if (isset($_FILES[$c])) {
                $campo = $c;
                break;
            }
        }

        if ($campo === null || $_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
            $recibidos = empty($_FILES) ? '(ninguno)' : implode(', ', array_keys($_FILES));
            $detalleError = ($campo !== null) ? " | código de error PHP: {$_FILES[$campo]['error']}" : '';
            throw new Exception("Error al subir el archivo. [Diagnóstico temporal: campos recibidos en \$_FILES = {$recibidos}{$detalleError}]");
        }

        $archivo_cargado = $_FILES[$campo];
        $uploader = new Upload($archivo_cargado);

        if ($uploader->uploaded) {
            $uploader->file_new_name_body = $cc_evento . '_' . $campo . '_' . date('dmYHis');
            $uploader->file_overwrite     = true;
            $uploader->image_convert      = 'jpeg';
            $uploader->jpeg_quality       = 85;

            $uploader->Process($ruta_carpeta);

            if (!$uploader->processed) {
                throw new Exception("Error al procesar imagen: " . $uploader->error);
            }

            $foto = $uploader->file_dst_name;
            $uploader->clean();

            if ($campo === 'img_ponente') {
                $ent_eventos->setImg_ponente($foto);
            } else {
                $ent_eventos->setImg_asistente($foto);
            }
            $ent_eventos->setCc_evento($cc_evento);

            if (!$bo_evento->control($ent_eventos, $opc, $campo)) {
                throw new Exception($bo_evento->errores());
            }

            echo '0';
            exit;
        } else {
            throw new Exception("Error en el archivo: " . $uploader->error);
        }
    }

    if ($opc === 'EA') {
        $campo = $_REQUEST['campo'] ?? '';
        if (!in_array($campo, $camposPermitidos, true)) {
            throw new Exception("Campo de imagen no válido.");
        }

        $archivo = isset($_REQUEST[$campo]) ? $_REQUEST[$campo] : '';
        if (empty($archivo)) {
            throw new Exception("Nombre del archivo no proporcionado.");
        }

        $ruta_archivo = $ruta_carpeta . $archivo;
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }

        if ($campo === 'img_ponente') {
            $ent_eventos->setImg_ponente($archivo);
        } else {
            $ent_eventos->setImg_asistente($archivo);
        }
        $ent_eventos->setCc_evento($cc_evento);

        if (!$bo_evento->control($ent_eventos, $opc, $campo)) {
            throw new Exception($bo_evento->errores());
        }

        echo '0';
        exit;
    }

    throw new Exception("Opción inválida.");
} catch (Exception $e) {
    echo $e->getMessage();
}
