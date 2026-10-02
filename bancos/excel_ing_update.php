<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(dirname(__DIR__) . "/util/xlsx_lite.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_banc_excel_migrar.php");
require_once(u_src() . "entidad/banc_excel_migrar.php");

header('Content-Type: application/json; charset=utf-8');

$bo_excel = new bo_banc_excel_migrar();
$opc = $_REQUEST['opc'] ?? '';

try {
    if ($opc === 'I') {
        if (!isset($_FILES['archivo_import']) || $_FILES['archivo_import']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo.");
        }

        $archivo_tmp = $_FILES['archivo_import']['tmp_name'];

        $fileInfo = pathinfo($_FILES['archivo_import']['name']);
        $ext = strtolower($fileInfo['extension'] ?? '');
        if ($ext !== 'xlsx') {
            throw new Exception("El archivo debe ser .xlsx (Excel 2007 o superior).");
        }

        try {

            if (class_exists('ZipArchive')) {
                $filas = xlsx_leer($archivo_tmp);
            } else {
                $archivo_sin_zip = dirname(__DIR__) . "/util/xlsx_lite_sin_zip.php";

                if (file_exists($archivo_sin_zip)) {
                    require_once($archivo_sin_zip);
                    $filas = xlsx_leer_sin_zip($archivo_tmp);
                } else {
                    throw new Exception(
                        "ZipArchive no disponible. Soluciones:<br>" .
                            "1. Habilitar extensión ZIP en php.ini<br>" .
                            "2. Descargar xlsx_lite_sin_zip.php a /util/"
                    );
                }
            }
        } catch (Exception $e) {
            throw new Exception("Error al leer el archivo: " . $e->getMessage());
        }

        if (count($filas) < 2) {
            throw new Exception("El archivo no tiene datos. Mínimo: encabezado + 1 fila de datos.");
        }

        $primera_fila = $filas[0];
        if (count($primera_fila) < 8) {
            throw new Exception("El archivo tiene " . count($primera_fila) . " columnas, se esperan 8. Revise el formato de la plantilla.");
        }

        $cargados = 0;
        $omitidas = 0;
        for ($i = 1; $i < count($filas); $i++) {
            $fila = $filas[$i];

            $fila_vacia = true;
            foreach ($fila as $valor) {
                if (!empty(trim($valor))) {
                    $fila_vacia = false;
                    break;
                }
            }
            if ($fila_vacia) {
                $omitidas++;
                continue;
            }

            $fecha = trim($fila[0] ?? '');
            $numero_op = trim($fila[1] ?? '');
            $monto = trim($fila[2] ?? '');
            $ref01 = trim($fila[3] ?? '');
            $ref02 = trim($fila[4] ?? '');
            $cta_contable = trim($fila[5] ?? '');
            $banco = trim($fila[6] ?? '');
            $cta_bancaria = trim($fila[7] ?? '');
            $c_banco = trim($fila[8] ?? '');
            $num_banco = trim($fila[9] ?? '');

            if (empty($fecha) || empty($numero_op) || empty($monto)) {
                throw new Exception("Fila " . ($i + 1) . ": Los campos Fecha, Operación y Monto son obligatorios.");
            }

            $fecha = trim((string)$fecha);

            if (is_numeric($fecha)) {

                $fecha_excel = new DateTime('1899-12-30');
                $fecha_excel->modify('+' . (int)$fecha . ' days');
                $fecha = $fecha_excel->format('Y-m-d');
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha)) {

                $fecha_obj = DateTime::createFromFormat('d/m/Y', $fecha);

                if (!$fecha_obj || $fecha_obj->format('d/m/Y') !== $fecha) {
                    throw new Exception("Fila " . ($i + 1) . ": Fecha inválida.");
                }

                $fecha = $fecha_obj->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {

                $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);

                if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha) {
                    throw new Exception("Fila " . ($i + 1) . ": Fecha inválida.");
                }
            } else {

                throw new Exception(
                    "Fila " . ($i + 1) . ": Fecha inválida."
                );
            }

            if (!is_numeric($monto)) {
                throw new Exception("Fila " . ($i + 1) . ": Monto debe ser un número válido.");
            }

            // Crear entidad
            $ent_migrar = new banc_excel_migrar();
            $ent_migrar->setFecha($fecha);
            $ent_migrar->setNumero_operacion($numero_op);
            $ent_migrar->setMonto(floatval($monto));
            $ent_migrar->setReferencia01($ref01);
            $ent_migrar->setReferencia02($ref02);
            $ent_migrar->setCuenta_contable($cta_contable);
            $ent_migrar->setBanco($banco);
            $ent_migrar->setCuenta_bancaria($cta_bancaria);
            $ent_migrar->setC_banco($c_banco);
            $ent_migrar->setNum_banco($num_banco);

            // Insertar
            if (!$bo_excel->control($ent_migrar, 'I')) {
                throw new Exception("Fila " . ($i + 1) . ": " . $bo_excel->errores());
            }

            $cargados++;
        }

        echo json_encode([
            'cargados' => $cargados,
            'omitidas' => $omitidas
        ]);
        exit;
    }

    // ═══════════════════════════════════════════════════════════
    // OPC = L (LIMPIAR / ELIMINAR TODOS)
    // ═══════════════════════════════════════════════════════════
    elseif ($opc === 'L') {

        $ent_migrar = new banc_excel_migrar();
        $resultado = $bo_excel->control($ent_migrar, 'L');

        if (!$resultado) {
            throw new Exception($bo_excel->errores());
        }

        echo json_encode([
            'error' => false,
            'message' => 'Registros eliminados correctamente'
        ]);

        exit;
    }

    // ═══════════════════════════════════════════════════════════
    // OPC = P (PROCESAR / EJECUTAR SP)
    // ═══════════════════════════════════════════════════════════
    elseif ($opc === 'P') {
        $ent_migrar = new banc_excel_migrar();
        $resultado = $bo_excel->control($ent_migrar, 'P');
        if (!$resultado) {
            throw new Exception($bo_excel->errores());
        }

        echo json_encode([
            'error' => false,
            'message' => 'Migración completada: sp_v1_migrar_ingresos ejecutado'
        ]);

        exit;
    }

    // ═══════════════════════════════════════════════════════════
    // OPC INVÁLIDA
    // ═══════════════════════════════════════════════════════════
    else {
        throw new Exception("Operación no válida: " . htmlspecialchars($opc));
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
    exit;
}
