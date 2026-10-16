<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/class_upload.php");

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
    require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");

    $bo_doc_recibidos = new bo_tram_documentos_recibidos();
    $ent_doc_recibidos = new tram_documentos_recibidos();

    $opc             = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_docrecibidos = isset($_REQUEST["cc_docrecibidos"]) ? s_crypt($_REQUEST["cc_docrecibidos"], 'out') : '';

    if (empty($opc) || empty($cc_docrecibidos) || !ctype_digit((string) $cc_docrecibidos)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    // Reglas del archivo
    $prefijo_archivo = 'tram_cr';            // nombre final: tram_cr + AAAAMMDDHHMMSS + .pdf
    $maxSizeMb       = 5;
    $maxSizeBytes    = $maxSizeMb * 1024 * 1024;

    // Carpeta de destino. realpath() devuelve false si la carpeta no existe,
    // por eso primero se crea y recién después se resuelve la ruta.
    $carpeta_base = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'file_tramites';
    if (!is_dir($carpeta_base) && !mkdir($carpeta_base, 0775, true)) {
        throw new Exception("No se pudo crear la carpeta de archivos.");
    }
    $ruta_carpeta = realpath($carpeta_base);
    if ($ruta_carpeta === false) {
        throw new Exception("No se pudo resolver la carpeta de archivos.");
    }
    $ruta_carpeta .= DIRECTORY_SEPARATOR;

    // Valor actual de documentos_recibidos.documento_enviado (también valida que el expediente exista)
    $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
    $cabecera = $bo_doc_recibidos->listarId($ent_doc_recibidos);
    if (empty($cabecera)) {
        throw new Exception("No se encontró el expediente.");
    }
    $actual     = trim((string) ($cabecera[0]['documento_enviado'] ?? ''));
    $actual_pdf = ($actual !== '' && preg_match('/\.pdf$/i', $actual) === 1);

    // Bloqueo: la validación se hace aquí, con el estado real de la BD (no con lo que envía el navegador)
    // Bloqueado = expediente archivado ('A') o alguna derivación ya recibida ('T') / atendida ('A'). Misma regla que exp_taps_det_from.php
    $bloqueado = (trim((string) ($cabecera[0]['flag'] ?? '')) === 'A');
    if (!$bloqueado) {
        $bo_derivaciones  = new bo_tram_seguimiento_documentos_recibid();
        $ent_derivaciones = new tram_seguimiento_documentos_recibid();
        $ent_derivaciones->setCc_docrecibidos($cc_docrecibidos);
        foreach ($bo_derivaciones->listaIDExp($ent_derivaciones) as $der) {
            $flag_der = trim((string) ($der['flag'] ?? ''));
            if ($flag_der === 'T' || $flag_der === 'A') {
                $bloqueado = true;
                break;
            }
        }
    }
    $es_super  = (trim((string) s_nivel()) === 'A');                    // superusuario

    if ($opc === 'UPLOAD') {
        if ($bloqueado) {
            throw new Exception("El expediente está bloqueado: no se pueden subir archivos.");
        }
        if ($actual_pdf) {
            throw new Exception("El expediente ya tiene un PDF adjunto. Elimínelo antes de subir otro.");
        }
        if ($actual !== '') {
            throw new Exception("El campo Documento enviado ya contiene un dato ($actual). No se sobrescribe.");
        }

        if (!isset($_FILES['file_adjunto'])) {
            throw new Exception("Error al subir el archivo.");
        }
        $err_subida = $_FILES['file_adjunto']['error'];
        if ($err_subida === UPLOAD_ERR_INI_SIZE || $err_subida === UPLOAD_ERR_FORM_SIZE) {
            // El servidor cortó el archivo antes de llegar al código (upload_max_filesize / post_max_size)
            throw new Exception("El archivo supera el tamaño permitido por el servidor ({$maxSizeMb}MB como máximo).");
        }
        if ($err_subida !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo.");
        }

        $archivo_cargado = $_FILES['file_adjunto'];
        if ($archivo_cargado['size'] <= 0) {
            throw new Exception("El archivo está vacío.");
        }

        if ($archivo_cargado['size'] > $maxSizeBytes) {
            throw new Exception("El archivo supera los {$maxSizeMb}MB");
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
            $uploader->file_new_name_body = $prefijo_archivo . date('YmdHis');
            $uploader->file_overwrite     = false; // si dos usuarios suben en el mismo segundo, no se pisan (se agrega _1, _2...)
            $uploader->mime_check   = true;
            $uploader->allowed      = array('application/pdf');
            $uploader->file_max_size = $maxSizeBytes;
            $uploader->Process($ruta_carpeta);

            if (!$uploader->processed) {
                throw new Exception("Error al procesar archivo: " . $uploader->error);
            }

            $nombre_archivo = $uploader->file_dst_name;
            $uploader->clean();

            // documento_enviado es varchar(30): si el nombre no cabe se descarta el archivo
            if (strlen($nombre_archivo) > 30) {
                @unlink($ruta_carpeta . $nombre_archivo);
                throw new Exception("El nombre del archivo generado supera los 30 caracteres.");
            }

            $ent_doc_recibidos->setDocumento_enviado($nombre_archivo);
            $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);

            if (!$bo_doc_recibidos->control($ent_doc_recibidos, $opc)) {
                @unlink($ruta_carpeta . $nombre_archivo);
                throw new Exception($bo_doc_recibidos->errores());
            }

            // Verifica que realmente quedó grabado (el UPDATE no afecta filas si el campo ya tenía dato)
            $verifica = $bo_doc_recibidos->listarId($ent_doc_recibidos);
            if (trim((string) ($verifica[0]['documento_enviado'] ?? '')) !== $nombre_archivo) {
                @unlink($ruta_carpeta . $nombre_archivo);
                throw new Exception("No se pudo registrar el PDF en el expediente.");
            }

            echo '0';
            exit;
        } else {
            throw new Exception("Error en el archivo: " . $uploader->error);
        }
    }

    if ($opc === 'EA') {
        if ($bloqueado && !$es_super) {
            throw new Exception("El expediente está bloqueado: solo el superusuario puede eliminar el archivo.");
        }

        $archivoRequest = $_REQUEST['file_adjunto'] ?? '';

        if (empty($archivoRequest)) {
            throw new Exception("Nombre del archivo no proporcionado.");
        }
        $archivo = basename(s_crypt($archivoRequest, 'out'));

        // Solo se elimina el PDF registrado en este expediente; nunca un dato antiguo del campo
        if (!$actual_pdf || $archivo !== $actual) {
            throw new Exception("El archivo no corresponde a este expediente.");
        }

        $ruta_archivo = $ruta_carpeta . $archivo;
        if (is_file($ruta_archivo)) {
            if (!unlink($ruta_archivo)) {
                throw new Exception("No se pudo eliminar el archivo del servidor.");
            }
        }

        $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);

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
