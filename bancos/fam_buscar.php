<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
    require_once(u_src() . "bo/bo_banc_beneficiofam.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_general = new bo_general();
$bo_fam = new bo_banc_beneficiofam();

$data_anho = $bo_fam->cod_anhos();
$mes = u_meses();
?>
<div class="card-body">
    <div class="live-preview">
        <div class="row justify-content-center text-center">
            <form class="needs-validation" id="frmBuscarFam" action="javascript:fn_buscarFam()" method="post" novalidate>
                <div class="mb-3 row justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <select name="cod_anho" id="cod_anho" class="form-control" onchange="submit()" required>
                            <option value="">Año</option>
                            <?php foreach ($data_anho as $row):
                                $anho = $row['cod_anho'];
                                $selected = ($anho == date("Y")) ? 'selected' : ''; ?>
                                <option value="<?= $anho ?>" <?= $selected ?>><?= $anho ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select name="cod_mes" id="cod_mes" class="form-control" onchange="submit()" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($mes as $key => $value): ?>
                                <option value="<?= $key ?>" <?= ($key == date("m")) ? 'selected' : '' ?>><?= $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 text-start">
                        <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mb-1">
            <div class="col-lg-12">
                <div id="divListarFam"></div>
            </div>
        </div>
    </div>
</div>