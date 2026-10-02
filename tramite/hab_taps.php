<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
$bo_general = new bo_general();

$opc = 'I';
if (isset($_REQUEST["opc"])) {
    $opc = s_crypt($_REQUEST["opc"], 'out');
}

$tipo_docs = $bo_general->tipo_documento();
$arr_tipo_docs = array_values(array_filter($tipo_docs, function ($item) {
    return in_array($item['c_tipo_de_documento'], ['03', '04']);
}));

$data_pais = $bo_general->listarPais();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header align-items-center d-flex border-0">
                <h4 class="card-title mb-0 flex-grow-1">Registro de Habilitaciones (Temporales y Extranjeros)</h4>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#nav-border-top-home" role="tab" aria-selected="false">
                            Nuevo registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="fn_listarRegistroHabilitaciones();" data-bs-toggle="tab" href="#nav-border-top-profile" role="tab" aria-selected="false">
                            Listar registros
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="nav-border-top-home" aria-labelledby="crear_documento-tab" role="tabpanel">
                        <?php require_once("hab_from.php"); ?>
                    </div>
                    <div class="tab-pane" id="nav-border-top-profile" role="tabpanel">
                        <?php require_once("hab_lista.php"); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$include_scripts = function () {
    return importDatatable() . importTypeahead() . importSelect2() . importformmasks();
}
?>