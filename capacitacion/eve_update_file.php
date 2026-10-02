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

    if ($opc === 'UPLOAD') {
        if (!isset($_FILES['img_fondo']) || $_FILES['img_fondo']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo.");
        }

        $archivo_cargado = $_FILES['img_fondo'];
        $uploader = new Upload($archivo_cargado);

        if ($uploader->uploaded) {
            $uploader->file_new_name_body = $cc_evento . '_' . date('dmYHis');
            $uploader->file_overwrite     = true;
            $uploader->image_convert      = 'jpeg';
            $uploader->jpeg_quality       = 85;

            $uploader->Process($ruta_carpeta);

            if (!$uploader->processed) {
                throw new Exception("Error al procesar imagen: " . $uploader->error);
            }

            $foto = $uploader->file_dst_name;
            $uploader->clean();

            $ent_eventos->setImg_certificado($foto);
            $ent_eventos->setCc_evento($cc_evento);

            if (!$bo_evento->control($ent_eventos, $opc)) {
                throw new Exception($bo_evento->errores());
            }

            echo '0';
            exit;
        } else {
            throw new Exception("Error en el archivo: " . $uploader->error);
        }
    }

    if ($opc === 'EA') {
        $archivo = isset($_REQUEST['img_fondo']) ? $_REQUEST['img_fondo'] : '';
        if (empty($archivo)) {
            throw new Exception("Nombre del archivo no proporcionado.");
        }

        $ruta_archivo = $ruta_carpeta . $archivo;
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }

        $ent_eventos->setImg_certificado($archivo);
        $ent_eventos->setCc_evento($cc_evento);

        if (!$bo_evento->control($ent_eventos, $opc)) {
            throw new Exception($bo_evento->errores());
        }

        echo '0';
        exit;
    }

    throw new Exception("Opción inválida.");

} catch (Exception $e) {
    echo $e->getMessage();
}