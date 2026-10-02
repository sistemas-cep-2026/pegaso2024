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
                        <h5 class="card-title mb-0">Estado De cuenta - Bancos</h5>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#base-justified-ec" role="tab" aria-selected="true">
                            EC
                        </a>
                    </li>
                 
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#base-justified-cheques" role="tab" aria-selected="false">
                            Cheques
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="base-justified-ec" role="tabpanel">
                        <?php include __DIR__ . '/rep_ec_buscar.php';
                        ?>
                    </div>
                
                    <div class="tab-pane" id="base-justified-cheques" role="tabpanel">
                        <?php include __DIR__ . '/rep_cheques_buscar.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $include_scripts = function () {
    return importInputMask() . importTypeahead() . importDatatable();
}; ?>