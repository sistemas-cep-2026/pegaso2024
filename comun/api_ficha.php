<?php
/*
 * comun/api_ficha.php
 * Entrega la ficha del colegiado (<cep>.pdf con toda su documentación) desde FICHAS_DIR
 * (ej. \\192.168.88.9\fichas). Busca el CEP tal como llega, con 6 dígitos y sin ceros a la izquierda.
 * Datos personales sensibles: NUNCA dar el tipo 'ficha' al buscador público.
 *
 * Formas de llamarlo:
 *   1) Desde PEGASO (usuario con sesión):
 *        comun/api_ficha.php?f=<cep cifrado con s_crypt>    (enlace que arma u_ficha_colegiado($cep))
 *        comun/api_ficha.php?cep=<cep>                      (directo, también exige sesión)
 *        agregar &d=1 para descargar en vez de abrir
 *   2) Desde el portal del colegiado, con enlace firmado (cliente con tipo 'ficha' en util/api_clientes.php):
 *        comun/api_ficha.php?c=<cliente>&id=<cep>&e=<vence unix>&s=<firma HMAC>
 *      El portal es responsable de firmar SOLO el CEP del colegiado que inició sesión.
 */
ob_start();

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

@ini_set('display_errors', '0');

try {
    if (isset($_GET['s'])) {
        $cep = u_file_api_verificar('ficha');
    } else {
        s_validar_pagina();
        if (isset($_GET['f'])) {
            $cep = (string) s_crypt((string) $_GET['f'], 'out');
        } else {
            $cep = isset($_GET['cep']) ? (string) $_GET['cep'] : '';
        }
    }

    $cep = u_file_cep_valido($cep);
    if ($cep === '') {
        throw new Exception("CEP no especificado o enlace vencido.");
    }

    $nombre = u_file_ficha_colegiado_nombre($cep);
    if ($nombre === null) {
        throw new Exception("No se encontró la ficha del CEP " . $cep . ".");
    }
    u_file_servir('ficha_colegiado', $nombre, isset($_GET['d']));
} catch (Throwable $e) {
    error_log("api_ficha: " . $e->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
    }
    echo $e->getMessage();
}
