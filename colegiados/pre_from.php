<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();

$c_persona = s_crypt($_REQUEST["c_persona"], 'out');
$codigo = $_REQUEST["codigo"];
$estado = $_REQUEST["estado"];
$cr_texto = $_REQUEST["cr"];

$estado_condicion = [
    'A' => [
        'texto' => 'Aceptar',
        'color' => 'success',
        'icono' => 'check',
    ],
    'R' => [
        'texto' => 'Rechazar',
        'color' => 'danger',
        'icono' => 'times',
    ]
];
?>
<div class="offcanvas-header">
    <h5 class="offcanvas-title">Respuesta al documento</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal" action="javascript:fn_procesarNuevoCol();" role="form" id="frmGrabarRegistroN">
                <input type="hidden" name="c_persona" value="<?= s_crypt($c_persona) ?>">
                <input type="hidden" name="codigo" value="<?= $codigo ?>">
                <input type="hidden" name="estado" value="<?= $estado ?>">
                <input type="hidden" name="cr" value="<?= $cr_texto ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <textarea name="detalle" id="detalle" rows="10" class="form-control" placeholder="Escribe las recomendaciones" required></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-<?= $estado_condicion[$estado]['color'] ?>" type="submit"><i class="fa fa-<?= $estado_condicion[$estado]['icono'] ?>"></i> <?= $estado_condicion[$estado]['texto'] ?> Documento</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#frmGrabarRegistroN').validate()
</script>