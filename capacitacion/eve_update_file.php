<?php
/*
 * capacitacion/eve_update_file.php
 * Sube o elimina la imagen del diploma (img_asistente / img_ponente) de un evento.
 * Los archivos se guardan con util/config_file.php, perfil 'certificado':
 *   CERTIFICADOS_DIR (ej. \\192.168.88.9\capacitacion\certificados) o, si no está definido, capacitacion/img.
 * Responde '0' si todo salió bien, o el mensaje de error (convención de jeventos_from.js).
 */
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/config_file.php");

s_validar_pagina();

try {
    require_once(u_src() . "bo/bo_cap_eventos.php");

    u_file_verificar_post();

    $bo_evento   = new bo_cap_eventos();
    $ent_eventos = new cap_eventos();

    $opc       = isset($_REQUEST["opc"]) ? (string) s_crypt($_REQUEST["opc"], 'out') : '';
    $cc_evento = isset($_REQUEST["cc_evento"]) ? (string) s_crypt($_REQUEST["cc_evento"], 'out') : '';

    if ($opc === '' || !ctype_digit($cc_evento)) {
        throw new Exception("Parámetros requeridos faltantes.");
    }

    // Lista blanca: solo estos 2 campos pueden manejarse aquí.
    $camposPermitidos = array('img_asistente', 'img_ponente');

    // Datos actuales del evento (el nombre del archivo a borrar sale de la BD, nunca del navegador)
    $ent_eventos->setCc_evento($cc_evento);
    $actual = $bo_evento->listarID($ent_eventos);
    if (empty($actual)) {
        throw new Exception("No se encontró el evento.");
    }

    if ($opc === 'UPLOAD') {
        $campo = null;
        foreach ($camposPermitidos as $c) {
            if (isset($_FILES[$c])) {
                $campo = $c;
                break;
            }
        }
        if ($campo === null) {
            throw new Exception("No se recibió ninguna imagen.");
        }

        $nombre = u_file_subir($_FILES[$campo], 'certificado', $cc_evento . '_' . $campo . '_' . date('dmYHis'));

        if ($campo === 'img_ponente') {
            $ent_eventos->setImg_ponente($nombre);
        } else {
            $ent_eventos->setImg_asistente($nombre);
        }

        if (!$bo_evento->control($ent_eventos, $opc, $campo)) {
            u_file_eliminar('certificado', $nombre);
            throw new Exception($bo_evento->errores() ?: "No se pudo registrar la imagen.");
        }

        echo '0';
        exit;
    }

    if ($opc === 'EA') {
        $campo = (string) ($_REQUEST['campo'] ?? '');
        if (!in_array($campo, $camposPermitidos, true)) {
            throw new Exception("Campo de imagen no válido.");
        }

        $archivo = u_file_certificado_nombre_valido($actual[0][$campo] ?? '');

        if (!$bo_evento->control($ent_eventos, $opc, $campo)) {
            throw new Exception($bo_evento->errores() ?: "No se pudo quitar la imagen.");
        }

        // Borrar el archivo (en el repositorio o en la carpeta antigua). Si falla, la BD ya quedó limpia.
        if ($archivo !== '') {
            $ubicacion = u_file_certificado_ubicar($archivo);
            if ($ubicacion !== null) {
                try {
                    u_file_eliminar('certificado', $archivo, $ubicacion['carpeta']);
                } catch (Throwable $e) {
                    error_log("eve_update_file: no se pudo borrar " . $archivo . ": " . $e->getMessage());
                }
            }
        }

        echo '0';
        exit;
    }

    throw new Exception("Opción inválida.");
} catch (Throwable $e) {
    echo $e->getMessage();
}
