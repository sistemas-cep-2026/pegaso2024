<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();

$cc_local = s_local();
$usuario = s_usuario();
$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'C');

$flag = $bo_parametro_detalle->listarParametroDet('documentos_de_venta', 'flag');
?> 
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Reporte de Fraccionamientos</h5>
                    </div>

                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form class="needs-validation" id="frmBuscar" action="javascript:fn_buscar()" method="post" novalidate>
                    <div class="row g-3 justify-content-center">
                        <div class="col-sm-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text">CR: </span>
                                <select class="form-control" id="c_local" name="c_local">
                                    <option value="">Selecciona...</option>
                                    <?php foreach ($data_local as $loc): ?>
                                        <option value="<?= $loc['c_local'] ?>" <?= $loc['c_local'] == s_local() ? 'selected' : '' ?>>
                                            <?= $loc['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Desde : </span>
                                <input type="date" class="form-control" id="cod_desde" name="cod_desde" value="<?php echo fecha_hoy() ?>">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Hasta : </span>
                                <input type="date" class="form-control" id="cod_hasta" name="cod_hasta" value="<?php echo fecha_hoy() ?>">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Estado : </span>
                                <select name="flag" class="form-control" id="flag">
                                    <?php foreach ($flag as $row) { ?>
                                        <option value="<?= $row['cc_codigo'] ?>"
                                            <?= ('*' == $row['cc_codigo']) ? 'selected' : '' ?>>
                                            <?= $row['detalle'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <?php echo bt_filtrar("Buscar") ?>
                            <?php echo bt_cancelar() ?>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
            </div>
            <div class="col-xxl-12">
                <div class="card-body">
                    <div id="divListar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable();
} ?>