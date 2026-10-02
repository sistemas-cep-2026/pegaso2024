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
                        <h5 class="card-title mb-0">REPORTE DE LIBROS SUNAT</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#rcompras" onclick="fn_BuscarCompras();" aria-controls="rcompras" role="tab" aria-selected="true">REGISTRO DE COMPRAS(H)</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#rdiario" onclick="fn_BuscarLibroDiario();" aria-controls="rdiario" role="tab" aria-selected="false">LIBRO DIARIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#rmayor" onclick="fn_BuscarLibroMayor();" aria-controls="rmayor" role="tab" aria-selected="false">LIBRO MAYOR(V)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#rbancos" onclick="fn_BuscarBancos('<?php echo s_local();?>');" aria-controls="rbancos" role="tab" aria-selected="false">LIBRO CAJA BANCOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reporte_documento-tab" data-bs-toggle="tab" href="#rventas" onclick="fn_BuscarVentas();" aria-controls="rventas" role="tab" aria-selected="false">REGISTRO DE VENTAS(H)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="rcompras" aria-labelledby="reporte_documento-tab" role="tabpanel">
                       <div id="divBuscarCompras"></div>
                    </div>
                    <div class="tab-pane" id="rventas" aria-labelledby="reporte_documento-tab" role="tabpanel">
                    <div id="divBuscarVentas"></div>
                    </div>
                    <div class="tab-pane" id="rdiario" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarLibroDiario"></div>
                    </div>
                    <div class="tab-pane" id="rmayor" aria-labelledby="reporte_documento-tab" role="tabpanel">
                       <div id="divBuscarLibroMayor"></div>
                    </div>
                    <div class="tab-pane" id="rbancos" aria-labelledby="reporte_documento-tab" role="tabpanel">
                    <div id="divBuscarBancos"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>

