<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");

$bo_usuario    = new bo_seg_usuarios();

$ent_usuario       = new seg_usuarios();

try {
    $opc = s_crypt($_REQUEST['opc'] ?? '', 'out');
    if (!in_array($opc, ['I', 'U', 'A', 'C'], true)) {
        throw new Exception('Operación no válida: [' . htmlspecialchars((string)$opc) . ']');
    }

    if ($opc === 'I') {
        $usuario = trim((string)($_REQUEST['usuario'] ?? ''));
    } else {
        $usuario = s_crypt($_REQUEST['usuario'] ?? '', 'out');
    }
    if (empty($usuario)) {
        throw new Exception('Usuario no válido.');
    }


    if (in_array($opc, ['I', 'C'], true) && trim((string)($_REQUEST['clave'] ?? '')) === '') {
        throw new Exception('Ingrese la clave.');
    }

    $ent_usuario->setCc_persona(isset($_REQUEST["cc_persona"]) ? s_crypt($_REQUEST["cc_persona"], 'out') : null);
    $ent_usuario->setCc_perfil($_REQUEST["cc_perfil"] ?? null);
    $ent_usuario->setCc_local($_REQUEST["cc_local"] ?? null);
    $ent_usuario->setC_area($_REQUEST["c_area"] ?? null);
    $ent_usuario->setTp_user($_REQUEST["tp_user"] ?? null);
    $ent_usuario->setUsuario($usuario);
    $ent_usuario->setClave($_REQUEST["clave"] ?? null);
    $ent_usuario->setTiempo_sesion($_REQUEST["tiempo_sesion"] ?? null);
    $ent_usuario->setObs($_REQUEST["obs"] ?? null);
    $ent_usuario->setUser_crea(s_usuario());
    $ent_usuario->setOpc($opc);

    if ($opc === 'I') {
        $data_existe = $bo_usuario->existeUsuario($ent_usuario->getUsuario());
        if (!empty($data_existe)) {
            throw new Exception("El usuario \"" . htmlspecialchars($usuario) . "\" ya existe. Elige otro nombre de usuario.");
        }
    }

    $val = $bo_usuario->control_usuarios($ent_usuario);
    if (!$val) {
        throw new Exception($bo_usuario->errores());
    }
    echo "0";
} catch (Exception $e) {
    echo $e->getMessage();
}
