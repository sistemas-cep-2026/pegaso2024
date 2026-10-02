<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Requisición de Almacen</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">CREAR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarBuscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">REPORTE</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <?php include __DIR__ . '/requisicion_tabs_from.php'; ?>
                    </div>
                    <div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <?php //include __DIR__ . '/balsalid_tabs_busca.php'; ?>
                        <div id="div_listar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>
