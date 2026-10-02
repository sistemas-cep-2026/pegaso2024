<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_modulo.php");
require_once(u_src() . "bo/bo_seg_perfil.php");
$bo_modulo  = new bo_seg_modulo();
$bo_rol  = new bo_seg_perfil();

$data_rol = $bo_rol->listarId(s_perfil());
$data_rol = $data_rol[0];

$data_modulo = $bo_modulo->moduloId($data_rol['cc_modulo_defecto']);

$data_nombre_mod = $bo_modulo->mod_usuario(s_usuario());

$data_nombre_mod = $data_nombre_mod[0];
$nombre_modulo="";
if(isset($mod["mod_nombre"])){
    $nombre_modulo = $mod["mod_nombre"];
}
if (!(count($data_modulo))) {
    echo errors('404');
} else {
    foreach ($data_modulo as $row) {
        $pagina     = $row["url"];
        $url_js     = $row["js"];
        $gs_carpeta = $row["mod_carpeta"];
        /*$mod_nombre = $row["mod_nombre"];
        $mod_vista  = trim($row["mod_vista"]) =='P' ? 'Procesos' : 'Reportes';*/
        //$_SESSION["SES_MOD_ID"]=$row["cc_codigo"];
    }
}
?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <?php require_once "url.php" ?>
    </div>
</div>
<div class="content-body" id="content-pagina">
    <?php
    require_once dirname(__DIR__) .DIRECTORY_SEPARATOR.$pagina;
    ?>
</div>