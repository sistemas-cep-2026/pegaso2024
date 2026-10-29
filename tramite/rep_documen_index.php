<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$cc_local = s_local();
$sede = ($cc_local == '28') ? 'CN' : 'CR';
$data_area   = $bo_general->AreaAdministrativa($sede);
$data_gestion = $bo_general->listarGestionActiva();

?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">DOCUMENTOS EMITIDOS</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center">
                    <form class="needs-validation" id="frmListarRegistros" action="javascript:fn_reporte()" method="post" novalidate>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">F. Desde:</span>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?= fecha_hoy() ?>">
                                </div>
                            </div>
                            <!-- Fecha hasta -->
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">F. Hasta:</span>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?= fecha_hoy() ?>">
                                </div>
                            </div>
                        </div>



                        <div class="row mb-2">
                            <div class="col-sm-12 text-center">
                                <?php echo bt_filtrar(); ?>
                                <?php echo bt_cancelar(); ?>
                            </div>
                        </div>

                    </form>


                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <div id="div_ReporLista"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable();
} ?>