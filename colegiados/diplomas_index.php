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
        <h5 class="card-title">DOCUMENTOS DE COLEGIACIÓN</h5>
    </div>
    <div class="card-body">
        <div class="row mb-1">
            <div class="col-sm-12">
                <form class="form-horizontal" action="javascript:fn_buscarRegistro();" role="form" id="frmBuscarRegistro">
                    <div class="row d-flex justify-content-center mb-2">
                        <div class="col-sm-4">
                            <label for="tipo" class="form-label">TIPO:</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <?php
                                foreach ($arr_tipos_grados as $tipo_especialidad) {
                                ?>
                                    <option value="<?= $tipo_especialidad['cc_codigo']; ?>"><?= $tipo_especialidad['detalle']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="c_tipo" class="form-label">DOCUMENTO:</label>
                            <select name="c_tipo" class="form-select" id="c_tipo" required onchange="this.form.submit()">
                                <option value="Z">DIPLOMA</option>
                                <option value="W">DIPLOMA(DUPLICADO)</option>
                                <option value="Y">RESOLUCION</option>
                                <option value="U">RESOLUCION(DUPLICADO)</option>
                                <option value="T">STIKER</option>
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mb-2">
                        <div class="col-sm-3">
                            <label for="cr" class="form-label">DESDE #:</label>
                            <input name="desde" type="number" id="desde" placeholder="# DESDE" class="form-control" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="cr" class="form-label">HASTA #:</label>
                            <input name="hasta" type="number" id="hasta" placeholder="# HASTA" class="form-control" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="cr" class="form-label">FIRMA?</label>
                            <select name="v" id="v" class="form-select" required onchange="this.form.submit()">
                                <option value="1">SI</option>
                                <option value="X" DE>NO</option>
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
<?php $include_scripts = fn() => importDatatable(); ?>