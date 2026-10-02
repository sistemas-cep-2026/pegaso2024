<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_general = new bo_general();
$data_bancos    = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');
?>

<div class="card-body">
    <div class="live-preview">
        <div class="row justify-content-center text-center">
            <form class="needs-validation" id="frmBuscarIngresos" action="javascript:fn_buscarIngresos()" method="post" novalidate>
                <div class="mb-3 row justify-content-center align-items-center">
                    <div class="col-sm-2">
                        <select name="c_banco" id="c_banco" class="form-control mb-2" onchange="submit()">
                            <?php
                            foreach ($data_bancos as $ban) { ?>
                                <option value="<?= "{$ban['c_banco']}-{$ban['c_cta_corriente']}" ?>">
                                    <?= "{$ban['nombre']} =>> {$ban['c_cta_corriente']}" ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-2">
                            <span class="input-group-text"># : </span>
                            <input type="text" class="form-control" id="num_boleta_cheque" name="num_boleta_cheque" value="">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Monto: </span>
                            <input type="text" class="form-control" id="monto" name="monto" value="">

                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Obs.: </span>
                            <input type="text" class="form-control" id="observacion" name="observacion" value="">
                        </div>
                    </div>
                    <div class="col-sm-3 text-start mb-2">
                        <?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="row mb-1">
            <div class="col-lg-12">
                <div id="divListarIngresos"></div>
            </div>
        </div>
    </div>
</div>
<?php $include_scripts = function () {
    return importDatatable() . importTypeahead() . importToolTip();
} ?>