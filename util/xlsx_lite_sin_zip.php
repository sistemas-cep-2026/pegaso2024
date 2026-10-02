<?php
/**
 * PEGASO2024 — xlsx_lite_sin_zip.php
 * 
 * Versión alternativa para leer Excel SIN depender de ZipArchive
 * Usa XML directo con SimpleXML
 * 
 * ⚠️ LIMITACIONES:
 * - Más lenta que xlsx_lite.php
 * - Requiere que el archivo sea validado primero
 * - Mejor para archivos pequeños (<5MB)
 * 
 * USO: Reemplaza xlsx_lite.php si ZipArchive no está disponible
 */

/**
 * Lee archivo .xlsx usando técnica alternativa sin ZipArchive
 * 
 * @param string $archivo Ruta al archivo .xlsx
 * @return array Array de filas [fila1[col1,col2,...], fila2[...], ...]
 * @throws Exception Si hay error al procesar
 */
function xlsx_leer_sin_zip($archivo)
{
    if (!file_exists($archivo)) {
        throw new Exception("Archivo no encontrado: $archivo");
    }

    // Crear directorio temporal
    $temp_dir = sys_get_temp_dir() . '/xlsx_' . uniqid();
    if (!mkdir($temp_dir)) {
        throw new Exception("No se puede crear directorio temporal");
    }

    try {
        // Descomprimir manualmente usando ZIP nativo de PHP
        // Si ZipArchive no está disponible, intentar con comando del sistema
        
        if (function_exists('exec')) {
            // Intentar con comando unzip del sistema
            $cmd = 'cd ' . escapeshellarg($temp_dir) . ' && unzip -q ' . escapeshellarg($archivo);
            @exec($cmd, $output, $return_code);
            
            if ($return_code !== 0) {
                throw new Exception("No se puede descomprimir archivo (requiere comando 'unzip')");
            }
        } else {
            throw new Exception("Requiere extensión PHP zip o comando 'unzip' disponible");
        }

        // Leer workbook.xml para obtener información de hojas
        $workbook_path = $temp_dir . '/xl/workbook.xml';
        if (!file_exists($workbook_path)) {
            throw new Exception("Archivo Excel inválido (sin xl/workbook.xml)");
        }

        // Leer primera hoja (sheet1.xml)
        $sheet_path = $temp_dir . '/xl/worksheets/sheet1.xml';
        if (!file_exists($sheet_path)) {
            throw new Exception("No hay hoja de cálculo (xl/worksheets/sheet1.xml)");
        }

        $filas = _procesar_sheet_xml($sheet_path, $temp_dir);

        // Limpiar directorio temporal
        _eliminar_dir_recursivo($temp_dir);

        return $filas;

    } catch (Exception $e) {
        // Limpiar en caso de error
        if (is_dir($temp_dir)) {
            _eliminar_dir_recursivo($temp_dir);
        }
        throw $e;
    }
}

/**
 * Procesa el archivo sheet1.xml y extrae datos
 * 
 * @param string $sheet_path Ruta a sheet1.xml
 * @param string $temp_dir Directorio temporal
 * @return array Filas de datos
 */
function _procesar_sheet_xml($sheet_path, $temp_dir)
{
    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($sheet_path);
    
    if ($xml === false) {
        throw new Exception("Error al parsear XML de la hoja");
    }

    // Registrar namespaces
    $namespaces = $xml->getNamespaces(true);
    foreach ($namespaces as $prefix => $namespace) {
        if ($prefix === '') {
            $prefix = 'main';
        }
        $xml->registerXPathNamespace($prefix, $namespace);
    }

    // Cargar shared strings (si existen)
    $shared_strings = _cargar_shared_strings($temp_dir);

    $filas = [];
    $fila_num = 0;

    // Obtener datos de sheetData
    $sheet_data = $xml->sheetData ?? $xml->children('http://schemas.openxmlformats.org/spreadsheetml/2006/main')->sheetData;
    
    if (!$sheet_data) {
        return $filas;
    }

    foreach ($sheet_data->row as $row) {
        $fila = [];
        
        foreach ($row->c as $cell) {
            $valor = '';
            $tipo = (string)$cell->attributes()['t'];

            if (isset($cell->v)) {
                $valor = (string)$cell->v;

                // Si es referencia a shared string
                if ($tipo === 's' && isset($shared_strings[$valor])) {
                    $valor = $shared_strings[$valor];
                }
                // Si es número de fecha (Excel serial)
                elseif (is_numeric($valor) && strlen($valor) > 4 && $valor > 30000) {
                    // Posible fecha Excel
                    $fecha = _excel_fecha_a_php($valor);
                    if ($fecha) {
                        $valor = $fecha;
                    }
                }
            } elseif (isset($cell->is)) {
                // Rich text
                $valor = (string)$cell->is->t;
            }

            $fila[] = trim($valor);
        }

        if (!empty(array_filter($fila))) {
            $filas[] = $fila;
        }

        $fila_num++;
    }

    return $filas;
}

/**
 * Carga shared strings desde workbook
 * 
 * @param string $temp_dir Directorio temporal
 * @return array Array de strings [id => valor]
 */
function _cargar_shared_strings($temp_dir)
{
    $strings = [];
    $path = $temp_dir . '/xl/sharedStrings.xml';

    if (!file_exists($path)) {
        return $strings;
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($path);

    if ($xml === false) {
        return $strings;
    }

    $idx = 0;
    foreach ($xml->si as $string_item) {
        $valor = '';
        
        if (isset($string_item->t)) {
            $valor = (string)$string_item->t;
        } else {
            // Texto con formato
            foreach ($string_item->r as $rich_text) {
                $valor .= (string)$rich_text->t;
            }
        }

        $strings[$idx] = $valor;
        $idx++;
    }

    return $strings;
}

/**
 * Convierte fecha Excel a formato YYYY-MM-DD
 * 
 * @param int $excel_date Número de serie Excel
 * @return string Fecha en formato YYYY-MM-DD o false
 */
function _excel_fecha_a_php($excel_date)
{
    // Excel fecha serial comenzó 1900-01-01
    // Pero Excel tiene un bug: trata 1900 como año bisiesto
    
    $excel_date = intval($excel_date);
    
    if ($excel_date < 1 || $excel_date > 2958465) {
        return false;
    }

    // Ajustar por bug de Excel
    if ($excel_date > 60) {
        $excel_date--;
    }

    // Timestamp Unix de 1900-01-01
    $fecha_base = mktime(0, 0, 0, 1, 1, 1900);
    $timestamp = $fecha_base + ($excel_date - 1) * 86400;

    $fecha = date('Y-m-d', $timestamp);
    
    // Validar que sea fecha válida
    if (strtotime($fecha) === false) {
        return false;
    }

    return $fecha;
}

/**
 * Elimina directorio recursivamente
 * 
 * @param string $dir Ruta del directorio
 */
function _eliminar_dir_recursivo($dir)
{
    if (!is_dir($dir)) {
        return;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            _eliminar_dir_recursivo($path);
        } else {
            @unlink($path);
        }
    }

    @rmdir($dir);
}

/**
 * Genera plantilla Excel sin ZipArchive
 * 
 * @param array $headers Encabezados de columnas
 * @param string $filename Nombre del archivo
 */
function xlsx_generar_plantilla_sin_zip($headers, $filename)
{
    // Esta función REQUIERE ZipArchive para generar
    // Se puede usar una alternativa manual pero es muy compleja
    
    throw new Exception("La generación de Excel requiere ZipArchive habilitado en PHP");
}

/**
 * WRAPPER: Detecta automáticamente cuál función usar
 */
if (!function_exists('xlsx_leer_alternativo')) {
    function xlsx_leer_alternativo($archivo)
    {
        // Intentar con ZipArchive primero (más rápido)
        if (class_exists('ZipArchive')) {
            // Usar xlsx_lite original
            return xlsx_leer($archivo);
        }
        // Si no está disponible, usar versión sin ZIP
        else {
            return xlsx_leer_sin_zip($archivo);
        }
    }
}
