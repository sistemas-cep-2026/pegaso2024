<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html; charset=utf-8");

// ENV se define primero para poder condicionar el manejo de errores según el
// entorno. Cambiar a 'PROD' antes de desplegar en un servidor real desactiva
// la salida de errores (y de SQL en los die() de Conecta) al navegador.
define('ENV', 'LOCAL');

if (ENV === 'PROD') {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// Endurecimiento de la cookie de sesión (debe ir antes de session_start()).
// 'secure' solo se activa si la conexión ya es HTTPS, para no romper el
// acceso actual por http://localhost en XAMPP.
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);
session_start();
//define('BASE_URI', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('BASE_URI', 'http://' . $_SERVER['SERVER_NAME'] . '/pegaso2024/');
define('BASE_MAIN_PATH', $_SERVER['CONTEXT_DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'pegaso2024' . DIRECTORY_SEPARATOR);


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
