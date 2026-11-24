<?php
/*
 * capacitacion/eve_portal_update.php
 * Botones del portal en la tarjeta del curso (eve_listar.php). Ejecuta sp_v1_publicar_eventos_portal:
 *   SC subir curso · EC eliminar curso del portal · PU publicar certificados · DP dejar de publicar
 * Por ahora solo el Consejo Nacional (s_local() = '28').
 * Responde JSON {error, message}.
 */
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos.php");
header('Content-type: application/json; charset=utf-8');

try {
    if (s_local() !== '28') {
        throw new Exception("Solo el Consejo Nacional puede publicar cursos en el portal.");
    }

    $cc_evento = (string) s_crypt($_REQUEST['cod'] ?? '', 'out');
    $opc       = (string) s_crypt($_REQUEST['opc'] ?? '', 'out');

    if (!ctype_digit($cc_evento) || !in_array($opc, array('SC', 'EC', 'PU', 'DP'), true)) {
        throw new Exception("Parámetros no válidos. Vuelva a cargar la página.");
    }

    $bo_eventos = new bo_cap_eventos();
    $res = $bo_eventos->publicarPortal((int) $cc_evento, $opc);

    if ((int) ($res['ok'] ?? 0) !== 1) {
        throw new Exception((string) ($res['mensaje'] ?? 'No se pudo completar la operación.'));
    }

    echo json_encode(array('error' => false, 'message' => (string) $res['mensaje']));
} catch (Throwable $e) {
    error_log("eve_portal_update: " . $e->getMessage());
    echo json_encode(array('error' => true, 'message' => $e->getMessage()));
}
