<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#cerrar" onclick="fn_BuscarCerrar('<?php echo s_local_vinculado(); ?>');" aria-controls="rcerrar" role="tab" aria-selected="true">CERRAR PERIODOS</a>
                    </li>
                    




                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="cerrar" aria-labelledby="reporte_documento-tab" role="tabpanel">
                        <div id="divBuscarCerrar"></div>
                    </div>
                     
                    

                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>