<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_periodos.php");
$bo_general = new bo_general();
$bo_gen_periodo = new bo_gen_periodos();

$data_cod_mes = periodo_contable();
$data_cod_anho = listarAnhos();
$data_periodo = $bo_gen_periodo->listarPeriodos();

$cc_local = s_local();
$usuario = s_usuario();
$data_regional = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
?>
<div class="row">
    <div class="col-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Reportes Descuento por Planilla MINSA y ESSALUD</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#bbva" aria-controls="bbva" role="tab" aria-selected="true">MINSA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bcp-tab" data-bs-toggle="tab" href="#bcp" aria-controls="bcp" role="tab" aria-selected="false">ESSALUD</a>
                    </li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="bbva" aria-labelledby="bbva-tab" role="tabpanel">
                        <div class="container-fluid mt-1">
                            <div class="row">
                                <div class="col-xxl-12">
                                    <form id="frmFormRegistroMinsa" action="javascript:fn_listarMinsa()" method="post" novalidate>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Local : </span>


                                                    <select class="form-control" id="c_local" name="c_local" onChange="fn_listar_entidad(this.value)" required>
                                                        <option value="">Selecciona...</option>
                                                        <?php foreach ($data_regional as $loc): ?>
                                                            <option value="<?= $loc['c_local'] ?>" <?= $loc['c_local'] == s_local() ? 'selected' : '' ?>>
                                                                <?= $loc['nombre'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Ent. Pag. : </span>
                                                    <select name="c_entidad_pagadora" id="c_entidad_pagadora" class="form-control" required>
                                                        <option value="">Seleccione...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Periodo : </span>
                                                    <select name="cod_mes" id="cod_mes" class="form-control" required>
                                                        <option value="" disabled>Seleccione...</option>
                                                        <?php foreach ($data_cod_mes as $key => $value): ?>
                                                            <option value="<?= htmlspecialchars($key) ?>"
                                                                <?= ($key == date('m')) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($value) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Año : </span>
                                                    <select name="cod_anho" id="cod_anho" class="form-control" required>
                                                        <option value="" disabled>Seleccione...</option>
                                                        <?php foreach ($data_cod_anho as $value): ?>
                                                            <option value="<?= htmlspecialchars($value['anho']) ?>"
                                                                <?= ($value['anho'] == date('Y')) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($value['anho']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo bt_buscar("Buscar") ?> <?php bt_cancelar("Cancelar") ?>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mb-1">
                                        <div class="col-lg-12 table-responsive">
                                            <div id="divReporteMinsa"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                    <!-- Segunda from y pestana -->
                    <div class="tab-pane" id="bcp" aria-labelledby="bcp-tab" role="tabpanel">
                        <div class="container-fluid mt-1">
                            <div class="row">
                                <div class="col-xxl-12">
                                    <form class="needs-validation" id="frmRegistroEssalud" action="javascript:fn_listarEssalud()" method="post" novalidate>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-3">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Periodo : </span>
                                                    <select name="periodo" id="periodo" class="form-control" onchange="submit()" required>
                                                        <?php foreach ($data_periodo as $key) { ?>
                                                            <option value="<?php echo $key['periodo'] ?>"><?php echo $key['periodo'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar("Cancelar") ?>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mb-1">
                                        <div class="col-lg-12 table-responsive">
                                            <div id="divReporteEssalud"></div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable() . importTypeahead();
} ?>