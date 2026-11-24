<?php
ob_start();

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

@ini_set('display_errors', '0');

try {
    if (isset($_GET['s'])) {
        // El enlace firmado para la nube (PDF) se habilitará en la siguiente etapa.
        throw new Exception("Acceso externo aún no habilitado.");
    }

    s_validar_pagina();
    $nombre = u_file_certificado_nombre_valido(s_crypt(isset($_GET['f']) ? (string) $_GET['f'] : '', 'out'));
    if ($nombre === '') {
        throw new Exception("Archivo no especificado o enlace vencido.");
    }

    $ubicacion = u_file_certificado_ubicar($nombre);
    if ($ubicacion === null) {
        throw new Exception("No se encontró la imagen del certificado.");
    }
    u_file_servir('certificado', $nombre, false, 86400, $ubicacion['carpeta']);
} catch (Throwable $e) {
    error_log("api_certificado: " . $e->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
    }
    echo $e->getMessage();
}
