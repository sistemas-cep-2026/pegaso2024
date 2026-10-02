<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_general.php");
$bo_parametro = new bo_gen_parametro_det();
$bo_general = new bo_general();
$data_anho = listarAnhos();
$est_flag = $bo_parametro->listarParametroDet('liquidaciones_caja_chica', 'flag');
$cc_local = s_local();
$usuario = s_usuario();
$data_region = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Lista de Caja Chica</h5>
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