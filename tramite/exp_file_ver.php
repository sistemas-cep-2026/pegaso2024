<?php
/*
 * Visor del PDF del expediente.
 * Los PDF se guardan en D:/file_tramites (fuera de la carpeta web), por eso no se abren con una URL
 * directa: este script exige sesión iniciada y envía el archivo.
 *
 * Lo llama exp_file.php / exp_deriv_lista.php con el enlace que arma u_file_url('pdf', $nombre):
 *   tramite/exp_file_ver.php?f=<nombre del PDF cifrado con s_crypt>      (&d=1 para forzar la descarga)
 * El nombre va cifrado con la sesión del usuario: un enlace copiado a otra sesión no funciona.
 */

// Todo lo que escriban los include (un espacio antes de <?php, avisos de PHP) se retiene aquí y
// u_file_servir() lo descarta antes de enviar el PDF, para que ningún byte extra dañe el archivo.
ob_start();

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

// util/config.php activa display_errors en LOCAL: aquí un aviso nunca debe mezclarse con los bytes del PDF.
// Los errores se registran en el log de PHP.
@ini_set('display_errors', '0');

s_validar_pagina();

try {
    $nombre = isset($_GET['f']) ? (string) s_crypt($_GET['f'], 'out') : '';
    if (trim($nombre) === '') {
        throw new Exception("Archivo no especificado o enlace vencido. Vuelva a abrir el expediente.");
    }
    u_file_servir('pdf', $nombre, isset($_GET['d']));
} catch (Throwable $e) {
    error_log("exp_file_ver: " . $e->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
    }
    echo $e->getMessage();
}
