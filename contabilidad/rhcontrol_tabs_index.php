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
                        <h5 class="card-title mb-0">RH CONTROL</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#RhControl" onclick="fn_BuscarRhControl();" aria-controls="RhControl" role="tab" aria-selected="true">RH CONTROL</a>
                    </li>
                    
                     
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="RhControl" aria-labelledby="reporte_documento-tab" role="tabpanel">
                       <div id="divBuscarRhControl"></div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>

