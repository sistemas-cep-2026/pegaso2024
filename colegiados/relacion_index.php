<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_det = new bo_gen_parametro_det();
$data_tipos_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_tipos_grados = array_values(array_filter($data_tipos_grados, function ($item) {
    return !in_array($item['cc_codigo'], ['H', 'T']);
}));
?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">RELACIÓN DE COLEGIATURA, GRADOS ACADÉMICOS Y OTROS</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" action="javascript:fn_buscarRegistro();" role="form" id="frmBuscarRegistro">
                    <div class="row mt-2 d-flex justify-content-center">
                        <div class="col-sm-3">
                            <label for="grado" class="form-label">TOTAL DE:</label>
                            <select name="grado" id="grado" class="form-control" required>
                                <?php
                                foreach ($arr_tipos_grados as $tipo_especialidad) {
                                ?>
                                    <option value="<?= $tipo_especialidad['cc_codigo']; ?>"><?= $tipo_especialidad['detalle']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="desde" class="form-label">DESDE:</label>
                            <input name="desde" placeholder="012345" type="number" id="desde" class="form-control" min="1" step="1" required />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12 text-center">
                            <?= bt_buscar() ?>
                            <?= bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div id="divListarRegistro"></div>
            </div>
        </div>
    </div>
</div>