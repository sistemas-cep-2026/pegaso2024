<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/class_upload.php");

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_seg_usuarios.php");

    $bo_usuarios   = new bo_seg_usuarios();

    $ent_usuarios  = new seg_usuarios();

    $opc        = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_usuario = isset($_REQUEST["cc_usuario"]) ? s_crypt($_REQUEST["cc_usuario"], 'out') : '';

    $ent_usuarios->setUsuario($cc_usuario);
    $data_sua = $bo_usuarios->listarId($ent_usuarios);
    foreach ($data_sua as $row) {
        $foto_anterior = $row['foto'];
    }


    if (empty($opc) || empty($cc_usuario)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    $ruta_carpeta = __DIR__ . DIRECTORY_SEPARATOR . '../images/user/' . DIRECTORY_SEPARATOR;

    if ($opc === 'UPLOAD') {
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo.");
        }

        $archivo_cargado = $_FILES['foto'];

        if ($archivo_cargado['size'] > (300 * 1024)) {
            throw new Exception("La imagen supera el límite de 300 KB.");
        }

        $ext = strtolower(pathinfo($archivo_cargado['name'], PATHINFO_EXTENSION));
        $ext_permitidas = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $ext_permitidas)) {
            throw new Exception("Formato no permitido. Solo se aceptan JPG, JPEG o PNG.");
        }

        $uploader = new Upload($archivo_cargado);

        if ($uploader->uploaded) {
            $uploader->file_new_name_body = $cc_usuario . '_' . date('dmYHis');
            $uploader->file_overwrite     = true;
            $uploader->image_convert      = 'jpeg';
            $uploader->jpeg_quality       = 85;

            $uploader->image_resize       = true;
            $uploader->image_ratio_crop   = true;
            $uploader->image_x            = 300;
            $uploader->image_y            = 400;

            $uploader->Process($ruta_carpeta);

            if (!$uploader->processed) {
                throw new Exception("Error al procesar imagen: " . $uploader->error);
            }

            $foto = $uploader->file_dst_name;
            $uploader->clean();

            $ent_usuarios->setFoto($foto);
            $ent_usuarios->setCc_usuario($cc_usuario);

            if (!$bo_usuarios->control($ent_usuarios, $opc)) {
                throw new Exception($bo_usuarios->errores());
            }

            if (!empty($foto_anterior)) {
                $archivo_anterior = $ruta_carpeta . $foto_anterior;
                if (file_exists($archivo_anterior)) {
                    unlink($archivo_anterior);
                }
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'ok'   => true,
                'foto' => $foto
            ]);
            exit;
        } else {
            throw new Exception("Error en el archivo: " . $uploader->error);
        }
    }

    throw new Exception("Opción inválida.");
} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'      => false,
        'mensaje' => $e->getMessage()
    ]);
}
