<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_general.php");
$bo_parametro = new bo_gen_parametro_det();
$bo_general = new bo_general();
$data_anho = listarAnhos();
$periodo = u_meses();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Requisici&oacute;n</h5>
                    </div>

                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <form class="needs-validation" id="frmListarRegistrosch" action="javascript:fn_reporte()" method="post" novalidate>
                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-2">
                            <select name="anho" id="anho" class="form-control">
                                <?php foreach ($data_anho as $row) { ?>
                                    <option value="<?php echo $row['anho']; ?>" <?php if ($row['anho'] == date("Y")) {
                                                                                    echo "selected";
                                                                                } ?>>
                                        <?php echo $row['anho']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select name="periodo" id="periodo" class="form-control">
                                <?php
                                foreach ($periodo as $key => $value) {
                                ?>
                                    <option value="<?php echo $key ?>" <?php if ($key == date("m")) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">

                            <?php echo bt_filtrar() ?>
                            <?php echo bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-2">
                <div id="divReport"></div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>