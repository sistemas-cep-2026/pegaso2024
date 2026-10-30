<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$cc_local = s_local();
$sede = ($cc_local == '28') ? 'CN' : 'CR';

$data_area = $bo_general->AreaAdministrativa($sede);
$data_gestion = $bo_general->listarGestionActiva();
$data_region = $bo_general->listar28Regiones();

?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">
                SEGUIMIENTO DE TRAMITE
            </h4>
        </div>

        <div class="card-body">
            <div class="live-preview">
                <div class="row justify-content-center">

                    <form class="needs-validation"
                        id="frmBuscarExp"
                        action="javascript:fn_buscarExp()"
                        method="post"
                        novalidate>

                        <!-- GESTION Y TIPO DE BUSQUEDA -->
                        <div class="mb-1 row justify-content-center align-items-center">

                            <div class="col-sm-3 col-xl-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Gestión:</span>

                                    <select name="gestion" id="gestion" class="form-control">
                                        <?php foreach ($data_gestion as $acc): ?>
                                            <option value="<?php echo htmlspecialchars($acc['cod']); ?>"
                                                <?php echo ($acc['cod'] == '07') ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($acc['cod'].'-'.$acc['ref']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xl-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Filtrar:</span>
                                    <select name="tipo_filtro" id="tipo_filtro" class="form-control">
                                        <option value="01">EXPEDIENTE</option>
                                        <option value="02" selected>FECHA</option>
                                        <option value="03">FECHA Y PERSONA</option>
                                        <option value="04">FECHA Y AREA</option>
                                        <option value="05">FECHA Y (PERSONA-AREA)</option>
                                        <option value="06">FECHA Y CR</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- FECHAS -->
                        <div id="grupo_fechas"
                            class="mb-1 row justify-content-center align-items-center">

                            <div class="col-sm-4 col-xl-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Desde:</span>

                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?php echo fecha_hoy(); ?>">
                                </div>
                            </div>

                            <div class="col-sm-4 col-xl-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Hasta:</span>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?php echo fecha_hoy(); ?>">
                                </div>
                            </div>
                            <div id="grupo_expediente" class="col-sm-3 col-xl-2">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Exp.:</span>
                                    <input type="text" class="form-control" id="c_expediente" name="c_expediente" placeholder="Expediente" value="">
                                </div>
                            </div>

                        </div>

                        <!-- NOMBRE, EXPEDIENTE Y AREA -->
                        <div class="mb-1 row justify-content-center align-items-center">

                            <div id="grupo_nombre" class="col-sm-4 col-xl-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Nombre:</span>

                                    <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" placeholder="Nombre" value="">
                                </div>
                            </div>

                            
                            <div id="grupo_area" class="col-sm-4 col-xl-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">Área:</span>

                                    <select name="c_area_adm" id="c_area_adm" class="form-control">
                                        <option value="">Selecciona área</option>
                                        <?php foreach ($data_area as $area): ?>
                                            <option value="<?php echo htmlspecialchars($area['cc_area_adm']); ?>">
                                                <?php echo htmlspecialchars($area['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div id="grupo_region" class="col-sm-4 col-xl-3">
                                <div class="input-group mb-1">
                                    <span class="input-group-text">CR:</span>

                                    <select name="c_region" id="c_region" class="form-control">
                                        <option value="">Selecciona CR</option>
                                        <?php foreach ($data_region as $region): ?>
                                            <option value="<?php echo htmlspecialchars($region['c_local']); ?>">
                                                <?php echo htmlspecialchars($region['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <!-- BOTONES -->
                        <div class="row mb-2">
                            <div class="col-sm-12 text-center">
                                <?php echo bt_filtrar(); ?>
                                <?php echo bt_cancelar(); ?>
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