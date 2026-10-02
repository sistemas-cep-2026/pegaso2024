<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_general.php");
$bo_parametro = new bo_gen_parametro_det();
$bo_general = new bo_general();
$data_anho = listarAnhos();
//$est_flag = $bo_parametro->listarParametroDet('liquidaciones_caja_chica', 'flag');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orde rList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">REGISTROS DE CAJA CHICA</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_controlCajaChica('','<?php echo s_crypt('I', 'in') ?>')"><i class="ri-add-line align-bottom me-1"></i> Nueva Caja</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-2">
                <div id="divReporCjaChica"></div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>