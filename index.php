<?php
require_once(__DIR__ . "/util/seguridad.php");
require_once(__DIR__ . "/util/util.php");

if (!isset($_SESSION['CEP_ADM_SES_USUARIO'])) {
    include "login.php";
    exit;
}
//s_validar_pagina();

require_once(u_src() . "bo/bo_seg_modulo.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_seg_modulo_perfil.php");
require_once(u_src() . "bo/bo_seg_modulo_pagina.php");

//require_once(u_src() . "bo/bo_seg_permiso.php");

$bo_modulo  = new bo_seg_modulo();
$bo_general  = new bo_general();
$bo_usuario  = new bo_seg_usuarios();
$bo_mod_perfil = new bo_seg_modulo_perfil();
$bo_modulo_pagina  = new bo_seg_modulo_pagina();

$ent_usuario  = new seg_usuarios();

$url_js = '';
$gs_carpeta = '';
$pagina = __DIR__ . DIRECTORY_SEPARATOR . 'dashboard' . DIRECTORY_SEPARATOR . 'index.php';


$sec = isset($_REQUEST["sec"]) ? s_crypt($_REQUEST["sec"], 'out') : '';

$id = isset($_REQUEST["id"]) ? s_crypt($_REQUEST["id"], 'out') : 100000;

$active_dash = 'active';
$id_dash = substr($id, 0, 2) . '0000';

$nombre_modulo = 'Dashboard';
$mod_tipo_text = 'Dashboard';

if ($sec != "0") {
    $data_seccion = $bo_modulo_pagina->asignado_pagina($id, $sec);
    if (!empty($data_seccion)) {
        foreach ($data_seccion as $row) {
            $pagina     = __DIR__ . DIRECTORY_SEPARATOR . $row["url"];
            $url_js     = $row["js"];
            $gs_carpeta = $row["mod_carpeta"];
            $mod_nombre = $row["mod_nombre"];
            $nombre_modulo = $row["mod_nombre_principal"];
            $mod_tipo_text = $row['mod_vista_text'];
        }
        $active_dash = '';
    } else {
        $data_modulo = $bo_mod_perfil->asignado_modulo($id, s_perfil());
        if (!empty($data_modulo)) {
            foreach ($data_modulo as $row) {
                $mod_id = $row["cc_modulo"];
                $pagina     = __DIR__ . DIRECTORY_SEPARATOR . $row["url"];
                $url_js     = $row["js"];
                $gs_carpeta = $row["mod_carpeta"];
                $mod_nombre = $row["mod_nombre"];
                $nombre_modulo = $row["mod_nombre_principal"];
                $mod_tipo_text = $row['mod_vista_text'];
            }
            $active_dash = '';
        }
    }
    $_SESSION["CEP_ADM_SES_MOD_ID"] = $id;
}

if ($nombre_modulo === 'Dashboard') {
    $data_dash_nombre = $bo_modulo_pagina->asignado_pagina_dashboard($id_dash);
    if (!empty($data_dash_nombre)) {
        $nombre_modulo = $data_dash_nombre[0]['mod_nombre'];
    }
}

if (!is_file($pagina)) {
    $pagina = BASE_MAIN_PATH . 'paginas' . DIRECTORY_SEPARATOR . '404.php';
}

$usuario = s_usuario();
$nombre_usuario = s_usu_nombre();
$codigo =  substr(s_mod_id(), 0, 3); //VARIABLE DE MENU
$path_general = BASE_MAIN_PATH;

?>
<!doctype html>
<html lang="es_PE" data-layout="vertical" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" translate="no">

<head>

    <meta charset="utf-8" />
    <title>CEP| ERP - PEGASO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo s_token(); ?>">
    <!-- App favicon -->
    <link rel="icon" href="<?php echo url('images/logo_print.jpg') ?>" type="image/png">
    <!-- Layout config Js -->
    <script src="<?php echo url('bootstrap/assets/js/layout.js') ?>"></script>

    <!-- Bootstrap Css -->
    <link href="<?php echo url('css/style.css?ver=' . filemtime($path_general . 'css' . DIRECTORY_SEPARATOR . 'style.css')); ?>" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php include __DIR__ . DIRECTORY_SEPARATOR . 'sistema' . DIRECTORY_SEPARATOR . 'cabecera.php'; ?>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <!-- <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo url('imagen aqui'); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo url('imagen aqui'); ?>" alt="" height="17">
                    </span>
                </a> -->
                <!-- Light Logo-->
                <a href="<?php echo url(); ?>" class="logo logo-light">
                    <span class="logo-sm h3 text-white">
                        CEP
                        <!-- <img src="<?php echo url('imagen aqui'); ?>" alt="" height="22"> -->
                    </span>
                    <span class="logo-lg h3 text-white">
                        PEGASO CEP
                        <!-- <img src="<?php echo url('imagen aqui'); ?>" alt="" height="17"> -->
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo $id_dash === $id ? 'active' : '' ?>" href="<?php echo url('?id=' . s_crypt($id_dash)); ?>">
                                <i class='bx bxs-dashboard'></i><span><?php echo $nombre_modulo ?></span>
                            </a>
                        </li>
                        <?php include __DIR__ . DIRECTORY_SEPARATOR . 'sistema' . DIRECTORY_SEPARATOR . 'menu.php'; ?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <?php include __DIR__ . DIRECTORY_SEPARATOR . 'sistema' . DIRECTORY_SEPARATOR . 'url.php'; ?>
                        </div>
                        <div class="col-12">
                            <?php include $pagina; ?>
                        </div>
                    </div>
                    <!-- end page title -->

                </div>
                <!-- container-fluid -->
            </div>
            <?php
            echo "pagi: " . $pagina . "<br>";
            echo "JS: " . $url_js . "<br>";
            echo "cod:" . $id . "<br>";
            echo "user: " . s_usuario() . "<br>";
            echo "DB=>" . $_SESSION["SES_DB"];
            ?>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <?php include __DIR__ . DIRECTORY_SEPARATOR . 'sistema' . DIRECTORY_SEPARATOR . 'pie_pagina.php'; ?>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <div class="offcanvas offcanvas-end" id="modalLateralRegistro"></div>

    <div class="modal fade" id="modalRegistroSm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistro">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistroXl">
        <div class="modal-dialog modal-xl">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistroFull">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content"></div>
        </div>
    </div>

    <!-- Modal solo para imagen-->
    <div class="modal fade" id="modalRegistroimg">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Imagen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="imgModalimg" src="" style="max-width:100%; height:auto; display:block; margin:auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?php echo url('bootstrap/assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo url('bootstrap/assets/libs/simplebar/simplebar.min.js'); ?>"></script>
    <script src="<?php echo url('bootstrap/assets/libs/node-waves/waves.min.js'); ?>"></script>
    <script src="<?php echo url('bootstrap/assets/libs/feather-icons/feather.min.js'); ?>"></script>
    <script src="<?php echo url('bootstrap/assets/js/pages/plugins/lord-icon-2.1.0.js'); ?>"></script>
    <!-- <script src="<?php echo url('bootstrap/assets/js/plugins.js'); ?>"></script> -->

    <!-- JQUERY -->
    <script src="<?php echo url('bootstrap/assets/libs/jquery/jquery.min.js') ?>"></script>

    <!-- JQUERY VALIDATE -->
    <script src="<?php echo url('bootstrap/assets/libs/jquery-validate/jqueryvalidation.min.js') ?>"></script>

    <!-- Sweet alert 2 -->
    <script src="<?php echo url('bootstrap/assets/libs/sweetalert2/sweetalert2.min.js') ?>"></script>

    <!-- CKEditor Classic -->
    <script src="<?php echo url('bootstrap/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') ?>"></script>

    <?php
    if (isset($include_scripts)) {
        echo $include_scripts();
    }
    ?>
    <!-- App js -->
    <script src="<?php echo url('bootstrap/assets/js/app.js') ?>"></script>


    <script src="<?php echo url('js/print.js?ver=' . filemtime($path_general . 'js/print.js')); ?>"></script>
    <script src="<?php echo $url_js ?>?ver=<?php echo filemtime($path_general . $url_js); ?>"></script>
</body>

</html>