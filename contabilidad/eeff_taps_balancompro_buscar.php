<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");


$bo_general = new bo_general();

$data_anho = listarAnhos();
$periodo=periodo_contable();
$data_region=$bo_general->listarRegiones();

?>
<div class="row">
    <div class="col-xxl-12">
        <form action="contabilidad/eeff_taps_balancompro_listar.php" method="POST" target="reporteEstaFinanciero" id="forEstaFinanciero">
            <div class="row mb-3 justify-content-center">
               <div class="col-sm-2">
                <select name="cc_local" id="cc_local" class="form-control">
                    <?php echo generarOpcionesRegion($data_region, s_local()); ?>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="anho" id="anho" class="form-control">
                    <option value="">Año</option>
                    <?php foreach ($data_anho as $row) { ?>
                        <option value="<?php echo $row['anho']; ?>" <?php if ($row['anho'] == date("Y")) { echo "selected"; } ?>>
                            <?php echo $row['anho']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="desde" id="desde" class="form-control">
                    <option value="">Desde</option>
                    <?php
                    foreach ($periodo as $key=>$value) {
                        ?>
                        <option value="<?php echo $key ?>" <?php if ( $key=='00') {
                            echo "selected";
                        } ?> ><?php echo $value ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="hasta" id="hasta" class="form-control">
                    <option value="">Hasta</option>
                    <?php
                    foreach ($periodo as $key=>$value) {
                        ?>
                        <option value="<?php echo $key ?>" <?php if ( $key==date("m")) {
                            echo "selected";
                        } ?> ><?php echo $value ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-2">
                <select name="version" id="version" class="form-control">
                    <option value="C">Balance de Comprobaci&oacute;n</option>
                    <option value="S">Verificaci&oacute;n Saldos</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="digitos" id="digitos" class="form-control">
                    <option value="10">10</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-sm-3">
                <!-- Botones de Buscar y Cancelar -->
                <button type="submit" class="btn btn-primary btnBuscar" onclick="desactivarBotonBuscar(event, forEstaFinanciero)"><i class="fas fa-search"></i> Filtrar</button>
                <?php bt_cancelar() ?> 
            </div>
        </div>
    </form>
    <!-- Cargador de carga (Spinner) -->
    <div class="row mb-3">
        <div class="col-lg-12 table-responsive">
            <div class="text-center spinner-content d-none" aria-live="polite">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
            </div>
            <iframe name="reporteEstaFinanciero" loading="lazy" class="iframe-loader d-none" id="reporteEstaFinanciero" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes()"></iframe>
        </div>
    </div>
</div>
</div>
