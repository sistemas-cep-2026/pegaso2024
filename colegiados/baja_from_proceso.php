<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();

require_once(u_src() . "bo/bo_web_tram_colegiacion_control.php");
$bo_web_tram_colegiacion_cont = new bo_web_tram_colegiacion_control();
$ent_web_tram_colegiacion_cont = new web_tram_colegiacion_control();

$c_persona = $_REQUEST["c_persona"] ?? '';
$cc_psuspendidas = $_REQUEST["cc_psuspendidas"] ?? '';
$flag = s_crypt($_REQUEST["flag"] ?? '', 'out');

$arr_estado = ['A' => 'Aceptar', 'R' => 'Rechazar'];
$arr_estado_color = ['A' => 'success', 'R' => 'danger'];
$arr_estado_icon = ['A' => 'check', 'R' => 'times'];
?>
<div class="offcanvas-header">
    <h5 class="offcanvas-title">PROCESO DEFINITIVO DE BAJA</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-12">
            <?= errors("ESTE PROCESO ES EL PASO FINAL PARA EL PROCESO DE BAJA DEFINITIVA. ESTO ES UNA ACCIÓN IRREVERSIBLE, POR LO CUAL TIENE QUE SER RESPALDADA POR LAS AUTORIDADES DEL CEP CON RESOLUCIÓN EMITIDA.") ?>
        </div>
        <br>
        <div class="col-12">
            <form class="form-horizontal" action="javascript:fn_procesoBaja();" role="form" id="frmGrabaProcesoBaja">
                <input type="hidden" name="c_persona" value="<?= $c_persona ?>">
                <input type="hidden" name="cc_psuspendidas" value="<?= $cc_psuspendidas ?>">
                <input type="hidden" name="flag" value="<?= s_crypt($flag) ?>">
                <input type="hidden" name="opc" value="<?= s_crypt($flag) ?>">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <label for="resol1" class="form-label">Número de resolución</label>
                        <input type="text" name="resol1" id="resol1" class="form-control" placeholder="Número de resolución" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <label for="url" class="form-label">URL de resolución</label>
                        <input type="text" name="url" id="url" class="form-control" placeholder="Ruta de resolución emitida del CEP" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <label for="desde" class="form-label">Fecha de baja</label>
                        <input type="date" name="desde" id="desde" class="form-control" placeholder="Fecha de baja" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <label for="obs" class="form-label">Observaciones</label>
                        <input type="text" name="obs" id="obs" class="form-control" placeholder="Observaciones">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-person-arrow-down-to-line"></i> DAR DE BAJA DEFINITIVO</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#frmGrabaProcesoBaja').validate()
</script>