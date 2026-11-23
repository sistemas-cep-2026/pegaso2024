<?php
/*
 * comun/api_foto.php
 * Entrega la foto del colegiado desde el repositorio (FOTOS_DIR, ej. \\192.168.88.9\fotos).
 * Busca <num_documento>.jpg y luego .png; si no hay foto devuelve images/sinfoto.jpg.
 *
 * Dos formas de llamarlo:
 *   1) Desde PEGASO (usuario con sesión), con el enlace que arma u_foto_colegiado($num_documento):
 *        comun/api_foto.php?f=<num_documento cifrado con s_crypt>
 *   2) Desde otros sistemas (portal del colegiado, buscador público) con enlace firmado y con vencimiento:
 *        comun/api_foto.php?c=<cliente>&id=<num_documento>&e=<vence unix>&s=<firma HMAC>
 *      El cliente debe estar en util/api_clientes.php con el tipo 'foto'.
 */
ob_start();

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

@ini_set('display_errors', '0');

function api_foto_sinfoto()
{
    $ruta = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'sinfoto.jpg';
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header_remove('Pragma');
    header_remove('Expires');
    header('Content-Type: image/jpeg');
    header('Cache-Control: private, max-age=300');
    header('X-Content-Type-Options: nosniff');
    if (is_file($ruta)) {
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
    }
}

try {
    if (isset($_GET['s'])) {
        $id = u_file_api_verificar('foto');
    } else {
        s_validar_pagina();
        $id = u_file_id_valido(s_crypt(isset($_GET['f']) ? (string) $_GET['f'] : '', 'out'));
    }

    $nombre = ($id !== '') ? u_file_foto_colegiado_nombre($id) : null;
    if ($nombre === null) {
        api_foto_sinfoto();
        exit;
    }
    u_file_servir('foto_colegiado', $nombre, false, 86400);
} catch (Throwable $e) {
    error_log("api_foto: " . $e->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
    }
    echo $e->getMessage();
}
