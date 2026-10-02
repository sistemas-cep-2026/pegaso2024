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
            <h4 class="card-title mb-0 flex-grow-1">SEGUIMIENTO DE TRAMITE</h4>
        </div><!-- end card header -->
        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center">
                    <form class="needs-validation" id="frmBuscarExp" action="javascript:fn_buscarExp()" method="post" novalidate>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Gestión:</span>
                                    <select name="gestion" id="gestion" class="form-control">
                                        <?php foreach ($data_gestion as $acc): ?>
                                            <option value="<?php echo $acc['cod']; ?>" <?php echo ($acc['cod'] == '07') ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($acc['cod']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Desde:</span>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" placeholder="00/00/0000" value="<?php echo fecha_hoy() ?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Hasta:</span>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" placeholder="00/00/0000" value="<?php echo fecha_hoy() ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 row justify-content-center align-items-center">
                            <div class="col-sm-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Nombre:</span>
                                    <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" placeholder="Nombre" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Exp.:</span>
                                    <input type="text" class="form-control" id="c_expediente" name="c_expediente" placeholder="Expediente" value="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Area.:</span>
                                    <select name="c_area_adm" id="c_area_adm" class="form-control">
                                        <option value="">Selecciona area</option>
                                        <?php foreach ($data_area as $area): ?>
                                            <option value="<?php echo $area['cc_area_adm']; ?>">
                                                <?php echo htmlspecialchars($area['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 text-center">
                                <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="card-body pt-2">
                        <div id="divReporExp"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable();
} ?>