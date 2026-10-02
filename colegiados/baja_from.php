<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();

$c_persona = $_REQUEST["c_persona"] ?? '';
$cc_psuspendidas = $_REQUEST["cc_psuspendidas"] ?? '';
$flag = s_crypt($_REQUEST["flag"] ?? '', 'out');

$arr_estado = ['A' => 'Aceptar', 'R' => 'Rechazar'];
$arr_estado_color = ['A' => 'success', 'R' => 'danger'];
$arr_estado_icon = ['A' => 'check', 'R' => 'times'];
?>
<div class="offcanvas-header">
    <h5 class="offcanvas-title"><?= $arr_estado[$flag] ?> expediente</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal" action="javascript:fn_procesarEstados();" role="form" id="frmGrabarRegistroN">
                <input type="hidden" name="c_persona" value="<?= $c_persona ?>">
                <input type="hidden" name="cc_psuspendidas" value="<?= $cc_psuspendidas ?>">
                <input type="hidden" name="flag" value="<?= s_crypt($flag) ?>">
                <input type="hidden" name="opc" value="<?= s_crypt($flag) ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <textarea name="obs" id="obs" rows="10" class="form-control" placeholder="Escribe las recomendaciones" required></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-<?= $arr_estado_color[$flag] ?>" type="submit"><i class="fa fa-<?= $arr_estado_icon[$flag] ?>"></i> <?= $arr_estado[$flag] ?> Observaciones</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#frmGrabarRegistroN').validate()
</script>