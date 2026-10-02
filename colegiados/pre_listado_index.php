<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_local = $bo_general->listarRegionesAdministrativo(s_local(), s_usuario());
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">LISTA DE PRE MATR&Iacute;CULAS PRE PROCESADAS</h5>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <div class="col-sm-12">
                <form class="form-horizontal" action="javascript:fn_buscarRegistro();" role="form" id="frmBuscarRegistro">
                    <div class="row d-flex justify-content-center mb-2">
                        <div class="col-lg-4">
                            <label for="tipo" class="form-label">DOC. O APELLIDOS Y NOMBRES:</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Documento de identidad o apellidos y nombres">
                        </div>
                        <div class="col-lg-3">
                            <label for="tipo" class="form-label">FECHA PROCESO:</label>
                            <div class="input-group mb-3">
                                <input type="text" name="desde" title="Desde" class="form-control bg-white input-desde" placeholder="dd/mm/yyyy" value="<?= u_fechaFormato(restarMeses(2)); ?>" required>
                                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                <input type="text" name="hasta" title="Hasta" class="form-control bg-white input-hasta" placeholder="dd/mm/yyyy" value="<?= date('d/m/Y'); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="c_tipo" class="form-label">CR:</label>
                            <select name="c_local" id="c_local" class="form-select select2" data-placeholder="Selecciona el CR de colegiación" data-placeholder="Seleccione..." required>
                                <?php
                                foreach ($data_local as $local_col) {
                                ?>
                                    <option value="<?= $local_col['c_local']; ?>" <?= $local_col['c_local'] === s_local() ? 'selected' : ''; ?>><?= $local_col['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-3 d-flex align-items-center">
                            <div class="form-check form-switch form-switch-md form-check-inline" dir="ltr">
                                <input class="form-check-input" type="checkbox" role="switch" name="recaudo" id="recaudo" value="1" onchange="fn_buscarRegistro();">
                                <label class="form-check-label" for="recaudo">RECAUDO</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <?= bt_buscar() ?>
                            <?= bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive" id="divListarRegistro"></div>
        </div>
    </div>
</div>
<?php $include_scripts = fn() => importDatatable() . importSelect2() . importDatePicker(); ?>