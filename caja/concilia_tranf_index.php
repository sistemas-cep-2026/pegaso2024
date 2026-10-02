<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
$bo_asistencia = new bo_cont_asistencia();
$bo_usuario = new bo_seg_usuarios();

$ent_usuario = new seg_usuarios();

$data_anho = $bo_asistencia->listarAnhos();
$mes = u_meses();

$cc_local = s_local();
$usuario = s_usuario();

$data_region = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">TRANSFERENCIA CONCILIACION </h4>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">TRANF. CONCILIACION </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarBuscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">ASIENTOS CONTABLES</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <form class="needs-validation" id="frmBuscarRegistro" action="javascript:fn_buscarRegistro()" method="post" novalidate>
                            <div class="mb-3 row justify-content-center align-items-center">
                                <div class="col-sm-2">
                                    <select name="cod_anho" id="cod_anho" class="form-control" onchange="submit()" required>
                                        <option value="">Año</option>
                                        <?php foreach ($data_anho as $row):
                                            $anho = $row['anho'];
                                            $selected = ($anho == date("Y")) ? 'selected' : ''; ?>
                                            <option value="<?= $anho ?>" <?= $selected ?>><?= $anho ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="cod_mes" id="cod_mes" class="form-control" onchange="submit()" required>
                                        <option value="">Periodo</option>
                                        <?php foreach ($mes as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= ($key == date("m")) ? 'selected' : '' ?>><?= $value ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3 text-start">
                                    <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div id="divConciliacion"></div>
                            </div>

                            <div class="col-md-6 border-end">
                                <div id="divConciliaciondetalle"></div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <form class="needs-validation" id="frmBuscarAsientos" action="javascript:fn_buscarAsientos()" method="post" novalidate>
                            <div class="mb-3 row justify-content-center align-items-center">
                                <div class="col-sm-2">
                                    <select name="cod_anho" id="cod_anho" class="form-control" onchange="submit()" required>
                                        <option value="">Año</option>
                                        <?php foreach ($data_anho as $row):
                                            $anho = $row['anho'];
                                            $selected = ($anho == date("Y")) ? 'selected' : ''; ?>
                                            <option value="<?= $anho ?>" <?= $selected ?>><?= $anho ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select name="cod_mes" id="cod_mes" class="form-control" onchange="submit()" required>
                                        <option value="">Periodo</option>
                                        <?php foreach ($mes as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= ($key == date("m")) ? 'selected' : '' ?>><?= $value ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3 text-start">
                                    <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="divAsientosContables"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>