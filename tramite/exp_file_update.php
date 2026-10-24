<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php"); // reglas de tipo, tamaño y carpeta (perfil 'pdf'); incluye class_upload.php

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
    require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");

    u_file_verificar_post();

    $bo_doc_recibidos  = new bo_tram_documentos_recibidos();
    $ent_doc_recibidos = new tram_documentos_recibidos();

    $opc             = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_docrecibidos = isset($_REQUEST["cc_docrecibidos"]) ? s_crypt($_REQUEST["cc_docrecibidos"], 'out') : '';

    if (empty($opc) || empty($cc_docrecibidos) || !ctype_digit((string) $cc_docrecibidos)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
    $cabecera = $bo_doc_recibidos->listarId($ent_doc_recibidos);
    if (empty($cabecera)) {
        throw new Exception("No se encontró el expediente.");
    }

    $c_expediente    = trim((string) ($cabecera[0]['c_expediente'] ?? ''));
    //$prefijo_archivo = 'TRAM_' . ($c_expediente !== '' ? $c_expediente : $cc_docrecibidos);
    $prefijo_archivo = ($c_expediente !== '' ? $c_expediente : $cc_docrecibidos) . '_E';

    $actual     = trim((string) ($cabecera[0]['documento_enviado'] ?? ''));
    $actual_pdf = ($actual !== '' && preg_match('/\.pdf$/i', $actual) === 1);

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
    $es_super = (trim((string) s_nivel()) === 'A'); // superusuario

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

        $nombre_archivo = u_file_subir($_FILES['file_adjunto'], 'pdf', $prefijo_archivo, array('max_nombre' => 30));

        $ent_doc_recibidos->setDocumento_enviado($nombre_archivo);
        $ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);

        if (!$bo_doc_recibidos->control($ent_doc_recibidos, $opc)) {
            u_file_eliminar('pdf', $nombre_archivo);
            throw new Exception($bo_doc_recibidos->errores());
        }

        $verifica = $bo_doc_recibidos->listarId($ent_doc_recibidos);
        if (trim((string) ($verifica[0]['documento_enviado'] ?? '')) !== $nombre_archivo) {
            u_file_eliminar('pdf', $nombre_archivo);
            throw new Exception("No se pudo registrar el PDF en el expediente.");
        }

        echo '0';
        exit;
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

        if (!$actual_pdf || $archivo !== $actual) {
            throw new Exception("El archivo no corresponde a este expediente.");
        }

        u_file_eliminar('pdf', $archivo);

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
