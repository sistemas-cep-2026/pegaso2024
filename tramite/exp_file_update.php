<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/class_upload.php");

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

    $bo_doc_recibidos = new bo_tram_documentos_recibidos();
    $ent_doc_recibidos = new tram_documentos_recibidos();

    $opc             = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_docrecibidos = isset($_REQUEST["cc_docrecibidos"]) ? s_crypt($_REQUEST["cc_docrecibidos"], 'out') : '';

    if (empty($opc) || empty($cc_docrecibidos)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    $ruta_carpeta = realpath(__DIR__ . '/../file_tramites') . DIRECTORY_SEPARATOR;

    if (!is_dir($ruta_carpeta)) {
        if (!mkdir($ruta_carpeta, 0777, true)) {
            throw new Exception("No se pudo crear la carpeta de archivos.");
        }
    }

    if ($opc === 'UPLOAD') {
        if (!isset($_FILES['file_adjunto']) || $_FILES['file_adjunto']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo.");
        }

        $archivo_cargado = $_FILES['file_adjunto'];
        $maxSizeBytes = 2 * 1024 * 1024;
        if ($archivo_cargado['size'] <= 0) {
            throw new Exception("El archivo está vacío.");
        }

        if ($archivo_cargado['size'] > $maxSizeBytes) {
            throw new Exception("El archivo supera los 2MB");
        }

        $ext = strtolower(pathinfo($archivo_cargado['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            throw new Exception("Solo se permiten archivos en formato PDF.");
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $archivo_cargado['tmp_name']);
        finfo_close($finfo);

        if ($mime !== 'application/pdf') {
            throw new Exception("El archivo subido no es un PDF válido.");
        }
        $uploader = new Upload($archivo_cargado);

        if ($uploader->uploaded) {
            $uploader->file_new_name_body = $cc_docrecibidos . '_' . date('dmYHis');
            $uploader->file_overwrite     = true;
            $uploader->mime_check   = true;
            $uploader->allowed      = array('application/pdf');
            $uploader->file_max_size = $maxSizeBytes;
            $uploader->Process($ruta_carpeta);

            if (!$uploader->processed) {
                throw new Exception("Error al procesar archivo: " . $uploader->error);
            }

            $nombre_archivo = $uploader->file_dst_name;
            $uploader->clean();

            $ent_doc_recibidos->setFile_adjunto($nombre_archivo);
            $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);

            if (!$bo_doc_recibidos->control($ent_doc_recibidos, $opc)) {
                throw new Exception($bo_doc_recibidos->errores());
            }

            echo '0';
            exit;
        } else {
            throw new Exception("Error en el archivo: " . $uploader->error);
        }
    }

    if ($opc === 'EA') {
        $archivoRequest = $_REQUEST['file_adjunto'] ?? '';

        if (empty($archivoRequest)) {
            throw new Exception("Nombre del archivo no proporcionado.");
        }
        $archivo = s_crypt($archivoRequest, 'out');
        $archivo = basename($archivo);
        $ruta_archivo = $ruta_carpeta . $archivo;

        if (is_file($ruta_archivo)) {
            if (!unlink($ruta_archivo)) {
                throw new Exception("No se pudo eliminar el archivo del servidor.");
            }
        }

        $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
        $ent_doc_recibidos->setFile_adjunto('');

        if (!$bo_doc_recibidos->control($ent_doc_recibidos, $opc)) {
            throw new Exception($bo_doc_recibidos->errores());
        }

        echo '0';
        exit;
    }

    throw new Exception("Opción inválida.");
} catch (Exception $e) {
    echo $e->getMessage();
}
