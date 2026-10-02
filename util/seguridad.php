<?php
require_once 'config.php';

function s_validar_pagina($is_validated_token = false)
{
    $redirect_to = "<script>window.location.href = '" . url('sistema/salir.php') . "'</script>";

    if (!isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        http_response_code(401);
        exit($redirect_to);
    }

    $time = $_SESSION["CEP_ADM_SES_NN_TIEMPO"];
    $fechaGuardada = $_SESSION["CEP_ADM_ULTIMOACCESO"];
    $ahora = date("Y-n-j H:i:s");

    $tiempo_transcurrido = strtotime($ahora) - strtotime($fechaGuardada);

    if ($tiempo_transcurrido >= $time) {
        http_response_code(401);
        exit($redirect_to);
    }

    if ($is_validated_token && !s_validar_token()) {
        http_response_code(401);
        exit($redirect_to);
    }

    $_SESSION["CEP_ADM_ULTIMOACCESO"] = $ahora;
}

function s_perfil()
{
    $usu_id = "0";
    if (isset($_SESSION["CEP_ADM_SEG_PERFIL"])) {
        $perfil = $_SESSION["CEP_ADM_SEG_PERFIL"];
    }
    return $perfil;
}

function s_usuario()
{
    $usuario = "X";
    if (isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        $usuario = $_SESSION["CEP_ADM_SES_USUARIO"];
    }
    return trim($usuario);
}


function s_cpersona()
{/*clave primaria del c_persona*/
    $cc_persona = "X";
    if (isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        $cc_persona = $_SESSION["CEP_ADM_SES_CC_PERSONA"];
    }
    return $cc_persona;
}

function s_usu_nombre()
{/*clave primaria del c_persona*/
    $usu_nombre = "X";
    if (isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        $usu_nombre = $_SESSION["CEP_ADM_SES_USU_NOMBRE"];
    }
    return $usu_nombre;
}


function s_mod_id()
{
    $s_mod_id = "";
    if (isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        $s_mod_id = $_SESSION["CEP_ADM_SES_MOD_ID"];
    }
    return $s_mod_id;
}

function s_nivel()
{
    $s_user_nivel = "";
    if (isset($_SESSION["CEP_ADM_SES_USUARIO"])) {
        $s_user_nivel = $_SESSION["CEP_ADM_SES_NIVEL"];
    }
    return $s_user_nivel;
}

function s_token()
{
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(64));
    }
    return $_SESSION['token'];
}

function s_validar_token()
{
    if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
        return 0;
    }
    /*EL SERVIDOR BUSCARÁ LA CABECERA DE TOKEN YA SEA POR FORMULARIO O POR AJAX.
        SI ES FALSO MANDARA UN ERROR 403(PAGINA PROHIBIDA POR FALTA DE CREDENCIALES)*/
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
        return 0;
    }
    // OBTENDRÁ EL TOKEN DE LA PETICIÓN
    if (!hash_equals($_SESSION['token'], $_SERVER['HTTP_X_CSRF_TOKEN'])) {
        return 0;
    }
    return 1;
}


/*function s_crypt($cadena, $opcion = 'in')
{
    if (empty($cadena)) return;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'HF?Q{J(bZcsxp7k';
    $secret_iv = $_SESSION["token"];
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($opcion == 'in') {
        $output = openssl_encrypt($cadena, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($opcion == 'out') {
        $output = openssl_decrypt(base64_decode($cadena), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}*/

function s_crypt($cadena, $opcion = 'in')
{
    if (empty($cadena)) return;
    if (is_resource($cadena)) {
        if (get_resource_type($cadena) === 'stream') {
            $tmp = @stream_get_contents($cadena);
            $cadena = ($tmp === false) ? '' : $tmp;
        } else {
            $cadena = '';
        }
    } elseif (!is_string($cadena)) {
        $cadena = (string)$cadena;
    }
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'HF?Q{J(bZcsxp7k';
    $secret_iv = $_SESSION["token"];
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($opcion == 'in') {
        $output = openssl_encrypt($cadena, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($opcion == 'out') {
        $output = openssl_decrypt(base64_decode($cadena), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}


function s_crypt_public($cadena, $opcion = 'in')
{
    if (empty($cadena)) return;
    $encrypt_method = "AES-256-CBC";
    $secret_key = '4Lb8!408c7eN';
    $secret_iv = '1234567890';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($opcion == 'in') {
        $output = openssl_encrypt($cadena, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($opcion == 'out') {
        $output = openssl_decrypt(base64_decode($cadena), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function s_local()
{
    return trim($_SESSION["CEP_ADM_SES_LOCAL"] ?? "X");
}
function s_local_vinculado()
{
    return trim($_SESSION["CEP_ADM_SES_LOCAL_VINC"] ?? "X");
}

function s_gestion()
{
    $s_gestion = "X";
    if (isset($_SESSION["CEP_ADM_SES_GESTION"])) {
        $s_gestion = $_SESSION["CEP_ADM_SES_GESTION"];
    }
    return trim($s_gestion);
}

function s_anho()
{
    $s_anho = "X";
    if (isset($_SESSION["SES_ANHO"])) {
        $s_anho = $_SESSION["SES_ANHO"];
    }
    return trim($s_anho);
}

function s_periodo()
{
    $s_periodo = "X";
    if (isset($_SESSION["SES_PERIODO"])) {
        $s_periodo = $_SESSION["SES_PERIODO"];
    }
    return trim($s_periodo);
}

function generarContrasenaSegura($longitud = 8)
{
    if ($longitud < 8) {
        $longitud = 8;
    }

    $letrasMinusculas = 'abcdefghijklmnopqrstuvwxyz';
    $letrasMayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numeros = '0123456789';

    $todosLosCaracteres = $letrasMinusculas . $letrasMayusculas . $numeros;

    $contrasena = $letrasMinusculas[random_int(0, strlen($letrasMinusculas) - 1)];
    $contrasena .= $letrasMayusculas[random_int(0, strlen($letrasMayusculas) - 1)];
    $contrasena .= $numeros[random_int(0, strlen($numeros) - 1)];

    for ($i = 3; $i < $longitud; $i++) {
        $contrasena .= $todosLosCaracteres[random_int(0, strlen($todosLosCaracteres) - 1)];
    }
    $contrasena = str_shuffle($contrasena);
    return $contrasena;
}
