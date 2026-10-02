<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");

$usuario  = $_POST["__usuario"];
$clave = $_POST["__clave"];

$data_usuario = array();
$opc = "N";
if (!empty(trim($usuario))) {
    $bo_usuario   = new bo_seg_usuarios();
    $bo_general   = new bo_general();
    $data_usuario = $bo_usuario->validar($usuario, $clave);
    //print_r($data_usuario);
    if (is_array($data_usuario)) {
        if (count($data_usuario) > 0) {
            if ($data_usuario[0] === "S") {
                $opc                  = "S";
                $_SESSION["CEP_ADM_SES_CC_PERSONA"]     = $data_usuario[1];
                $_SESSION["CEP_ADM_SES_USUARIO"]        = $data_usuario[2];
                $_SESSION["CEP_ADM_SES_NN_TIEMPO"]      = $data_usuario[3];
                $_SESSION["CEP_ADM_ULTIMOACCESO"]       = date("Y-n-j H:i:s"); //sesion de hora de acceso
                $_SESSION["CEP_ADM_SEG_PERFIL"]         = $data_usuario[4];
                $_SESSION["CEP_ADM_SES_NIVEL"]          = $data_usuario[5];
                $_SESSION["CEP_ADM_SES_LOCAL"]          = $data_usuario[6];
                $_SESSION["CEP_ADM_SES_USU_NOMBRE"]     = $data_usuario[7];
                $_SESSION["CEP_ADM_SES_MOD_ID"]         = "100000";
                $_SESSION["SES_ANHO"]                   = date("Y");
                $_SESSION["SES_PERIODO"]                = date("m");
                $_SESSION["CEP_ADM_SES_LOCAL_VINC"]     = $data_usuario[6];

                $data_gestion = $bo_general->listarGestionActiva();
                foreach ($data_gestion as $gestion) {
                    $_SESSION["CEP_ADM_SES_GESTION"] = $gestion['cod'];
                }
            }
        }
    }
}
$json = 0;
if ($opc == "N") {
    $json = [
        'error'  => true,
        'message' => 'Credenciales incorrectas'
    ];
} else {
    $json = [
        'error'  => false,
        'message' => NULL
    ];
}

Header("Content-type: application/json; charset=utf-8");
echo json_encode($json);
