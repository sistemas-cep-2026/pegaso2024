<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_general.php");

$bo_det = new bo_gen_parametro_det();
$bo_general = new bo_general();

$data_tipos_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$data_local = $bo_general->listarRegionesAdministrativo(s_local(), s_usuario());
$arr_tipos_grados = array_values(array_filter($data_tipos_grados, function ($item) {
    return !in_array($item['cc_codigo'], ['H', 'T']);
}));
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">EXONERACIONES POR VIAJE / SALUD / ESTUDIO</h5>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <div class="col-sm-12">
                <form class="form-horizontal" action="javascript:fn_buscarRegistro();" role="form" id="frmBuscarRegistro">
                    <div class="row d-flex justify-content-center mb-2">
                        <div class="col-sm-3">
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
                        <div class="col-sm-3">
                            <label for="detalle" class="form-label">TOTAL:</label>
                            <select name="detalle" id="detalle" class="form-select" data-placeholder="Selecciona el CR de colegiación" data-placeholder="Seleccione..." required>
                                <option value="C">CONSOLIDADO</option>
                                <option value="D">DETALLE</option>
                            </select>
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
            <div class="col-12 table-responsive">
                <div id="divListarRegistro"></div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = fn() => importDatatable() . importSelect2(); ?>