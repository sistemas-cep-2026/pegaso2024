<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");


$bo_general = new bo_general();

$data_anho = listarAnhos();
$periodo = u_meses();
$cc_local = s_local_vinculado();
$usuario = s_usuario();
 
//print_r($data_region);
?>
<div class="row">
    <div class="col-xxl-12">

        <form action="contabilidad/centralizar_compras_listar.php" method="POST" target="reporteIframeCompras" id="formlibroCompras">
            <div class="row mb-3 justify-content-center">
                <div class="col-sm-1">
                     <input type="hidden" name="cc_local" value="<?php echo $cc_local; ?>">
                    <select name="anho" id="anho" class="form-control">
                        <?php foreach ($data_anho as $row) { ?>
                            <option value="<?php echo $row['anho']; ?>" <?php if ($row['anho'] == date("Y")) {
                                                                            echo "selected";
                                                                        } ?>>
                                <?php echo $row['anho']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="periodo" id="periodo" class="form-control">
                        <?php
                        foreach ($periodo as $key => $value) {
                        ?>
                            <option value="<?php echo $key ?>" <?php if ($key == date("m")) {
                                                                    echo "selected";
                                                                } ?>><?php echo $value ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                    
                         
                       
                
                   
                <div class="col-sm-3">
                   

                    <button type="submit" class="btn btn-primary btnBuscar" onclick="desactivarBotonBuscar(event, formlibroCompras)"><i class="fas fa-search"></i> Buscar</button>
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
                <iframe name="reporteIframeCompras" loading="lazy" class="iframe-loader d-none" id="reporteIframeCompras" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes()"></iframe>

            </div>
        </div>
    </div>
</div>