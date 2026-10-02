<?php

/**
 * Genera un archivo .xlsx mínimo (una sola hoja) y lo envía al navegador para descarga.
 * $headers: array de nombres de columna, ej. ['CEP','NUM_DOCUMENTO','NOMBRE','ASISTENTE','PONENTE','ORGANIZADOR']
 */
function xlsx_generar_plantilla(array $headers, string $filename)
{
    $tmp = tempnam(sys_get_temp_dir(), 'xlsx_');

    $zip = new ZipArchive();
    $zip->open($tmp, ZipArchive::OVERWRITE | ZipArchive::CREATE);

    $zip->addFromString(
        '[Content_Types].xml',
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' .
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' .
            '<Default Extension="xml" ContentType="application/xml"/>' .
            '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>' .
            '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>' .
            '</Types>'
    );

    $zip->addFromString(
        '_rels/.rels',
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>' .
            '</Relationships>'
    );

    $zip->addFromString(
        'xl/_rels/workbook.xml.rels',
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>' .
            '</Relationships>'
    );

    $zip->addFromString(
        'xl/workbook.xml',
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">' .
            '<sheets><sheet name="Datos" sheetId="1" r:id="rId1"/></sheets>' .
            '</workbook>'
    );

    $filas_xml = '';
    $fila_num = 1;
    $filas_xml .= xlsx_fila_xml($fila_num, $headers);

    // 5 filas vacías de ejemplo
    for ($i = 0; $i < 5; $i++) {
        $fila_num++;
        $filas_xml .= xlsx_fila_xml($fila_num, array_fill(0, count($headers), ''));
    }

    $zip->addFromString(
        'xl/worksheets/sheet1.xml',
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' .
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' .
            '<sheetData>' . $filas_xml . '</sheetData>' .
            '</worksheet>'
    );

    $zip->close();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($tmp));
    readfile($tmp);
    unlink($tmp);
    exit;
}

function xlsx_fila_xml($fila_num, array $valores)
{
    $celdas = '';
    $col = 'A';
    foreach ($valores as $valor) {
        $ref = $col . $fila_num;
        $texto = htmlspecialchars((string)$valor, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $celdas .= '<c r="' . $ref . '" t="inlineStr"><is><t xml:space="preserve">' . $texto . '</t></is></c>';
        $col++;
    }
    return '<row r="' . $fila_num . '">' . $celdas . '</row>';
}

/**
 * Lee un archivo .xlsx (una sola hoja) y devuelve un array de filas (cada fila = array de valores en orden de columna).
 * Soporta celdas de texto compartido (sharedStrings), texto en línea (inlineStr) y numéricas.
 */
function xlsx_leer(string $ruta_archivo): array
{
    $zip = new ZipArchive();
    if ($zip->open($ruta_archivo) !== true) {
        throw new Exception('No se pudo abrir el archivo .xlsx (¿está corrupto o no es un xlsx válido?).');
    }

    $shared_strings = [];
    $shared_xml = $zip->getFromName('xl/sharedStrings.xml');
    if ($shared_xml !== false) {
        $dom = new DOMDocument();
        $dom->loadXML($shared_xml);
        foreach ($dom->getElementsByTagName('si') as $si) {
            // concatena todos los <t> dentro del <si> (por si hay texto con formato/runs <r>)
            $texto = '';
            foreach ($si->getElementsByTagName('t') as $t) {
                $texto .= $t->nodeValue;
            }
            $shared_strings[] = $texto;
        }
    }

    $sheet_xml = $zip->getFromName('xl/worksheets/sheet1.xml');
    if ($sheet_xml === false) {
        $zip->close();
        throw new Exception('El archivo .xlsx no contiene la hoja esperada (xl/worksheets/sheet1.xml).');
    }
    $zip->close();

    $dom = new DOMDocument();
    $dom->loadXML($sheet_xml);

    $filas = [];
    foreach ($dom->getElementsByTagName('row') as $row) {
        $fila = [];
        foreach ($row->getElementsByTagName('c') as $c) {
            $ref = $c->getAttribute('r');
            $col_letra = preg_replace('/[0-9]/', '', $ref);
            $col_idx = xlsx_columna_a_indice($col_letra);

            $tipo = $c->getAttribute('t');
            $valor = '';

            if ($tipo === 'inlineStr') {
                $is = $c->getElementsByTagName('is')->item(0);
                if ($is) {
                    foreach ($is->getElementsByTagName('t') as $t) {
                        $valor .= $t->nodeValue;
                    }
                }
            } else {
                $v = $c->getElementsByTagName('v')->item(0);
                $valor_bruto = $v ? $v->nodeValue : '';
                if ($tipo === 's') {
                    $valor = $shared_strings[(int)$valor_bruto] ?? '';
                } else {
                    $valor = $valor_bruto;
                }
            }

            $fila[$col_idx] = trim($valor);
        }
        if (!empty($fila)) {
            ksort($fila);
            $filas[] = $fila;
        }
    }

    return $filas;
}

function xlsx_columna_a_indice($letra)
{
    $letra = strtoupper($letra);
    $indice = 0;
    for ($i = 0; $i < strlen($letra); $i++) {
        $indice = $indice * 26 + (ord($letra[$i]) - ord('A') + 1);
    }
    return $indice - 1;
}
