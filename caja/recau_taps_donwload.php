<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_recaud_excelbcp.php");

$bo_bcp = new bo_recaud_excelbcp();
$data_bcp = $bo_bcp->downloadTodo();

// Nombre del archivo
$filename = "CREP.txt";
$file_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

// Crear y escribir en el archivo
$file = fopen($file_path, "w");
if ($file) {
    foreach ($data_bcp as $bcp) {
        fwrite($file, $bcp['dato'] . "\n");
    }
    fclose($file);

    // Forzar la descarga
    header("Content-Description: File Transfer");
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($file_path));
    readfile($file_path);
    
    // Eliminar el archivo temporal después de la descarga
    unlink($file_path);
    exit;
} else {
    die("Error al crear el archivo");
}
?>