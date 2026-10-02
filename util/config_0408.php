<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");
/*error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
//define('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('BASE_URI', 'http://' . $_SERVER['SERVER_NAME'] . '/pegaso2024/');
define('BASE_MAIN_PATH', $_SERVER['CONTEXT_DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'pegaso2024' . DIRECTORY_SEPARATOR);


define('ENV', 'LOCAL');
date_default_timezone_set('America/Lima');

/**CONFIGURACION NOMBRES TITULOS E IMAGENES */
define('nombre', 'CEP-NACIONAL');
define('abr_nombre', 'CEP-NACIONAL');
define('nombre_anho', 'Año de la Esperanza y el Fortalecimiento de la Democracia');
define('logo', url('images/logo_print.jpg'));
define('icon', url('images/favicon.ico'));


function url($value = "")
{
    return BASE_URI . $value;
}

function url_files($value = "")
{
    return BASE_URI_FILES . $value;
}
