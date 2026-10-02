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
                        <h5 class="card-title mb-0">REPORTE DE LOS ESTADOS FINANCIEROS</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#balance" onclick="fn_BuscarBalanceComprob();" aria-controls="Balance de Comprobacion" role="tab" aria-selected="true">BALANCE DE COMPROBACIÓN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#financiera" onclick="fn_BuscarVentas();" aria-controls="Situacion Financiera" role="tab" aria-selected="false">SITUACION FINANCIERA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#resultados" onclick="fn_BuscarLibroDiario();" aria-controls="Resultados Integrales" role="tab" aria-selected="false">RESULTADOS INTEGRALES</a>
                    </li>
                    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="balance" aria-labelledby="reporte_documento-tab" role="tabpanel">
                       <div id="divBuscarBalanceComprobacion"></div>
                    </div>
                    <div class="tab-pane" id="financiera" aria-labelledby="reporte_documento-tab" role="tabpanel">
                    <div id="divBuscarVentas"></div>
                    </div>
                    <div class="tab-pane" id="resultados" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarLibroDiario"></div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>

