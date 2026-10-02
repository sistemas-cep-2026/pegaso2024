<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");


$bo_general = new bo_general();

$data_anho = listarAnhos();
$periodo = u_meses();

$cc_local = s_local();
$usuario = s_usuario();
$data_region = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'C');
?>
<div class="row">
    <div class="col-xxl-12">
        <form action="contabilidad/sunat_bancos_listar_horizontal.php" method="POST" target="reporteIframeBancos" id="formBusquebancos">
            <div class="row mb-3 justify-content-center">
                <div class="col-sm-1">
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
                <!-- <div class="col-sm-1">
                    <select name="desde" id="desde" class="form-control">
                   
                        <?php
                        foreach ($periodo as $key => $value) {
                        ?>
                            <option value="<?php echo $key ?>" <?php if ($key == date("m")) {
                                                                    echo "selected";
                                                                } ?> ><?php echo $value ?></option>
                        <?php } ?>
                    </select>
                </div>-->
                <div class="col-sm-1">
                    <select name="hasta" id="hasta" class="form-control">

                        <?php
                        foreach ($periodo as $key => $value) {
                        ?>
                            <option value="<?php echo $key ?>" <?php if ($key == date("m")) {
                                                                    echo "selected";
                                                                } ?>><?php echo $value ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control" id="cc_local" name="cc_local" onChange="fn_listar_banco(this.value)">
                        <option value="">Selecciona...</option>
                        <?php foreach ($data_region as $loc): ?>
                            <option value="<?= $loc['c_local'] ?>" <?= $loc['c_local'] == s_local() ? 'selected' : '' ?>>
                                <?= $loc['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="col-sm-2">
                    <select name="cc_banco" id="cc_banco" class="form-control">
                    </select>
                </div>
                <div class="col-sm-1">
                    <select name="forma" id="forma" class="form-control" onchange="cambiarDestino()">

                        <option value="H">HORIZONTAL</option>
                        <option value="V">VERTICAL</option>
                    </select>


                </div>
                <div class="col-sm-3">
                    <!-- Botones de Buscar y Cancelar -->
                    <button type="submit" class="btn btn-primary btnBuscar" onclick="desactivarBotonBuscar(event, formBusquebancos)"><i class="fas fa-search"></i> Filtrar</button>
                    <?php bt_cancelar() ?>
                </div>
            </div>
        </form>


        <div class="row mb-3">
            <div class="col-lg-12 table-responsive">
                <div class="text-center spinner-content d-none" aria-live="polite">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
                <iframe name="reporteIframeBancos" loading="lazy" class="iframe-loader d-none" id="reporteIframeBancos" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes()"></iframe>
            </div>
        </div>
    </div>
</div>
<script>
    function cambiarDestino() {
        var forma = document.getElementById("forma").value;
        var form = document.getElementById("formBusquebancos");

        if (forma === "H") {
            form.action = "contabilidad/sunat_bancos_listar_horizontal.php";
        } else if (forma === "V") {
            form.action = "contabilidad/sunat_bancos_listar_vertical.php";
        } else {
            form.action = "contabilidad/..";
        }
    }
</script>