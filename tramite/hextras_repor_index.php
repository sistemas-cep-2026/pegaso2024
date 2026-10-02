<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");
require_once(u_src() . "bo/bo_tram_actividad_sustento.php"); 

$bo_actividad = new bo_tram_actividad_sustento();
$bo_usuario = new bo_seg_usuarios();

$ent_actividad= new tram_actividad_sustento();
$ent_usuario = new seg_usuarios();

$data_anho=$bo_actividad->listarAnhos();
$mes=u_meses();
$cc_usuario=s_usuario();
$cc_local=s_local();
$ent_usuario->setCc_local($cc_local);
$data_usuer= $bo_usuario->ListarUsuarios($ent_usuario)

?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">REGISTRO DE ASISTENCIA</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center text-center">
                    <form class="needs-validation" id="frmFormRegistro" action="javascript:fn_ListarRegistro()" method="post" novalidate>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <select name="anho" id="anho" class="form-control" onchange="submit()">
                                    <option value="">Año</option>
                                    <?php foreach ($data_anho as $row) { ?>
                                        <option value="<?php echo $row['anho'] ?>" <?php if ($row['anho'] == date("Y")) {
                                            echo "selected";
                                        } ?>><?php echo $row['anho'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="periodo" id="periodo" class="form-control" onchange="submit()" required>
                                    <option value="">Periodo</option>
                                    <?php
                                    foreach ($mes as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key ?>" <?php if ($key == date("m")) {
                                            echo "selected";
                                        } ?>><?php echo $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="usuario" id="usuario" class="form-control" onchange="submit()" required>
                                    <option value="">Todos los usuarios</option>
                                    <?php foreach ($data_usuer as $user) { ?>
                                        <option value="<?php echo $user["usuario"] ?>"><?php echo $user["nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 text-start">
                                <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="card-body pt-2">
                        <div id="divReportemensual"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
