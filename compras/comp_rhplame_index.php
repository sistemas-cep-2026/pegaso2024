<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once u_src() . 'bo/bo_gen_parametro_det.php';
require_once(u_src() . "bo/bo_general.php");
$bo_parametro = new bo_gen_parametro_det();
$bo_general = new bo_general();
$data_anho = listarAnhos();

//$data_region = $bo_general->listarRegionesAdministrativo(s_local_vinculado(), s_usuario());
//$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="orderList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">RH/DIETAS PDT-Plame</h5>
                        <p class="text-muted mt-1" style="font-size: 14px;">
                PROCESO PARA CREAR ARCHIVOS SUNAT *.PS4 Y *.4TA // NO VINCULADO AL REGISTRO COMPRAS O CONTABLE - NO GENERA ASIENTO - PROCESO PLAME
            </p>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                <form class="needs-validation" id="frmListarRegistros" action="javascript:fn_reporte()" method="post" novalidate>
                    <div class="row mb-4 justify-content-center">
                     
                         
                        <div class="col-sm-3">
                            <!-- Botones de Buscar y Cancelar -->
                            <?php echo bt_filtrar() ?>
                            <?php echo bt_cancelar() ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body pt-2">
                <div id="divRepor"></div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>