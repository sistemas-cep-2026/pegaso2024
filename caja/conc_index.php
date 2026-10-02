<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
$bo_general = new bo_general();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Conceptos de cobraza</h5>
                    </div>

                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form class="needs-validation" id="frmFormRegistro" action="javascript:fn_reporte()" method="post" novalidate>
                    <div class="row g-3 justify-content-center">
                        <div class="col-sm-5">
                            <div class="input-group mb-3">
                                <span class="input-group-text">Conceptos : </span>
                                <input type="text" class="form-control" id="conceptos" name="conceptos" value="">
                            </div>
                        </div>
                        <div class="col-xxl-3 col-sm-6">
                            <?php echo bt_filtrar("Buscar") ?>
                            <?php echo bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xxl-12">
                <div class="card-body">
                    <div id="divConceptors"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importDatatable();
} ?>