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
                        <h5 class="card-title mb-0">CENTRALIZAR</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#compras" onclick="fn_BuscarCompras('<?php echo s_local(); ?>');" aria-controls="rcompras" role="tab" aria-selected="true">COMPRAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#bancos" onclick="fn_BuscarBancos('<?php echo s_local(); ?>');" aria-controls="rbancos" role="tab" aria-selected="false">BANCOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#planilla728" onclick="fn_BuscarPlanilla();" aria-controls="rdiario" role="tab" aria-selected="false">PLANILLA 728</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#ventas" onclick="fn_BuscarVentas();" aria-controls="rventas" role="tab" aria-selected="false">VENTAS</a>
                    </li>




                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="compras" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarCompras"></div>
                    </div>
                     
                    <div class="tab-pane" id="bancos" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarBancos"></div>
                    </div>
                    <div class="tab-pane" id="planilla728" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarPlanilla728"></div>
                    </div>
                    <div class="tab-pane" id="ventas" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarVentas"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>