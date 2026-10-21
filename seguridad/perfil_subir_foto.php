<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php"); // perfil 'foto_perfil': JPG/PNG, 300 KB, 300x400, images/user/

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_seg_usuarios.php");

    // Si el envío superó post_max_size PHP vacía $_REQUEST/$_FILES: se avisa con el mensaje correcto
    u_file_verificar_post();

    $bo_usuarios  = new bo_seg_usuarios();
    $ent_usuarios = new seg_usuarios();

    $opc        = isset($_REQUEST["opc"]) ? s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_usuario = isset($_REQUEST["cc_usuario"]) ? s_crypt($_REQUEST["cc_usuario"], 'out') : '';

    if (empty($opc) || empty($cc_usuario)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    $foto_anterior = '';
    $ent_usuarios->setUsuario($cc_usuario);
    $data_sua = $bo_usuarios->listarId($ent_usuarios);
    foreach ($data_sua as $row) {
        $foto_anterior = trim((string) ($row['foto'] ?? ''));
    }

    if ($opc === 'UPLOAD') {
        if (!isset($_FILES['foto'])) {
            throw new Exception("Error al subir el archivo.");
        }

        // Valida (JPG/PNG reales, máx. 300 KB) y guarda en images/user/ como JPEG 300x400 recortado, calidad 85
        $foto = u_file_subir($_FILES['foto'], 'foto_perfil', $cc_usuario . '_' . date('dmYHis'));

        $ent_usuarios->setFoto($foto);
        $ent_usuarios->setCc_usuario($cc_usuario);

        if (!$bo_usuarios->control($ent_usuarios, $opc)) {
            u_file_eliminar('foto_perfil', $foto);
            throw new Exception($bo_usuarios->errores());
        }

        // Elimina la foto anterior (si es otro archivo; el nuevo nunca se borra)
        if ($foto_anterior !== '' && $foto_anterior !== $foto) {
            try {
                u_file_eliminar('foto_perfil', $foto_anterior);
            } catch (Exception $e) {
                // la foto nueva ya quedó registrada: un archivo viejo que no se pueda borrar no debe fallar la operación
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok'   => true,
            'foto' => $foto
        ]);
        exit;
    }

    throw new Exception("Opción inválida.");
} catch (Exception $e) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok'      => false,
        'mensaje' => $e->getMessage()
    ]);
}
