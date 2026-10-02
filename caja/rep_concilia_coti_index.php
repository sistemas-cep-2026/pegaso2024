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
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">CONCILIACION COTIZACIONES</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center text-center">
                    <form class="needs-validation" id="frmBuscarRegistro" action="javascript:fn_buscarRegistro()" method="post" novalidate>
                        <div class="mb-3 row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <select name="cod_anho" id="cod_anho" class="form-control" onchange="submit()" required>

                                    <?php foreach ($data_anho as $row):
                                        $anho = $row['anho'];
                                        $selected = ($anho == date("Y")) ? 'selected' : ''; ?>
                                        <option value="<?= $anho ?>" <?= $selected ?>><?= $anho ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (s_local_vinculado() == '28') { ?>
                                <div class="col-sm-2">
                                    <select name="cod_mes" id="cod_mes" class="form-control" onchange="submit()" required>
                                        <option value="">Periodo</option>
                                        <?php foreach ($mes as $key => $value): ?>
                                            <option value="<?= $key ?>" <?= ($key == date("m")) ? 'selected' : '' ?>><?= $value ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="col-sm-3 text-start">
                                <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mb-1">
                    <div class="col-lg-12">
                        <div id="divConciliacion"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>