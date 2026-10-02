<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_permisos.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_permisos = new bo_tram_permisos();

$data_permisos = $bo_parametro_detalle->listarParametroDet("tram_permisos", "tipo_permisos");
$dat_anho = $bo_permisos->listaAnho();

$mes = u_meses();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">REGISTRO DE PERMISOS</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in') ?>')"><i class="ri-add-line align-bottom me-1"></i> Crear registro</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <form class="needs-validation" id="frmFormRegistro" action="javascript:fn_listarReporte()" method="post" novalidate>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Tipo:</span>
                                <select name="tipo_permisos" id="tipo_permisos" class="form-control" onchange="submit()">
                                    <?php
                                    foreach ($data_permisos as $per) { ?>
                                        <option value="<?php echo $per['cc_codigo'] ?>"><?php echo $per['detalle']  ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">📅</span>
                                <select name="cod_anho" id="cod_anho" class="form-control" onchange="submit()">
                                    <?php foreach ($dat_anho as $anho) { ?>
                                        <option value="<?php echo $anho['cod_anho'] ?>" <?= ($anho['cod_anho'] == date('Y')) ? 'selected' : '' ?>>
                                            <?php echo $anho['cod_anho'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text">📅</span>
                                <select name="periodo" id="periodo" class="form-control" onchange="submit()">
                                    <option value="">Periodo</option>
                                    <?php foreach ($mes as $key => $value): ?>
                                        <option value="<?= htmlspecialchars($key) ?>"
                                            <?= ($key == date("m")) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($value) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <?php echo bt_buscar("Buscar") ?> <?php bt_cancelar() ?>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-body pt-2">
                <div id="divReporte"></div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importDatatable() . importTypeahead() . importToolTip();
} ?>