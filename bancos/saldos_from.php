<?php

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");

$bo_general = new bo_general();
$bo_saldobancos = new bo_banc_saldos_bancos_cuentas();

$ent_saldobancos = new banc_saldos_bancos_cuentas();

$banco_cta_var = $_REQUEST['c_banco'] ?? '';
$periodo = u_meses();

$ent_saldobancos->setCc_local(s_local_vinculado());

$cc_local = s_local_vinculado();
$cod_anho = s_anho();

$ent_saldobancos->setCod_mes(date("m"));

$disabled = '';

$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_saldo = isset($_REQUEST['cc_saldo']) ? s_crypt($_REQUEST['cc_saldo'], 'out') : '';

$fecha_registro = fecha_hoy();
$saldo_final = 0;

$option = "NUEVO SALDO CUENTA BANCARIA => " . $cod_anho;

if ($opc == 'U') {

    $ent_saldobancos->setCc_saldo($cc_saldo);

    $data = $bo_saldobancos->listarID($ent_saldobancos);

    foreach ($data as $act) {

        $ent_saldobancos->setCod_ano($act["c_anho"] ?? '');
        $ent_saldobancos->setCod_mes($act["c_mes"] ?? '');
        $ent_saldobancos->setC_banco($act["c_banco"] ?? '');
        $ent_saldobancos->setC_cta_cte($act["c_cta_cte"] ?? '');
        $ent_saldobancos->setSaldo_final($act["saldo_final"] ?? 0);

        $fecha_registro = $act["fecha"] ?? fecha_hoy();
        $saldo_final = $act["saldo_final"] ?? 0;
        $banco_cta_var = $act["banco_cta"] ?? '';

        $disabled = 'disabled';
    }

    $option = "MODIFICAR SALDO CUENTA BANCARIA = " . $ent_saldobancos->getCod_ano();
}
?>

<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>

<div class="modal-body">
    <form action="javascript:fn_guardar();" id="frmRegistro" novalidate>
        <div class="row">
            <div class="col-sm-6">
                <label for="fecha_registro" class="form-label text-muted fs-13 mb-1">Fecha</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light-subtle">
                        <i class="ri-calendar-2-line"></i>
                    </span>
                    <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo $fecha_registro; ?>"
                        <?php echo $disabled ?>>
                </div>
            </div>
            <div class="col-sm-6">
                <label for="c_mes" class="form-label text-muted fs-13 mb-1">Periodo</label>
                <select name="c_mes" id="c_mes" class="form-control mb-3" <?php echo $disabled ?>>
                    <?php
                    foreach ($periodo as $key => $value) { ?>
                        <option value="<?php echo $key ?>"
                            <?= ($key == $ent_saldobancos->getCod_mes()) ? 'selected' : '' ?>>
                            <?php echo $value ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if ($opc == 'U') { ?>
                    <input type="hidden" name="c_mes" value="<?php echo $ent_saldobancos->getCod_mes(); ?>">
                <?php } ?>
            </div>

            <div class="col-sm-7">
                <label for="c_banco" class="form-label text-muted fs-13 mb-1">Banco</label>
                <select class="form-control mb-3" id="c_banco" name="c_banco" required <?php echo $disabled ?>>
                    <option value="">Selecciona</option>
                    <?php
                    foreach ($data_bancos as $ban) { ?>
                        <option value="<?php echo $ban['c_banco'] . '-' . $ban['c_cta_corriente']; ?>" <?= ($banco_cta_var == $ban['banco_cta']) ? 'selected' : '' ?>>
                            <?php echo $ban['nombre'] . " =>> " . $ban['c_cta_corriente'] ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if ($opc == 'U') { ?>
                    <input type="hidden" name="c_banco" value="<?php echo $ent_saldobancos->getC_banco() . '-' . $ent_saldobancos->getC_cta_cte(); ?>">
                <?php } ?>
            </div>
            <div class="col-sm-5">
                <label for="saldo_final" class="form-label text-muted fs-13 mb-1">Monto S/</label>
                <input type="text" class="form-control text-end input-pen mb-3" name="saldo_final" id="saldo_final" value="<?php echo decimal_millar($saldo_final, 2); ?>" placeholder="0.00" required>
            </div>

            <div class="col-sm-12 text-center">

                <?php echo bt_guardar(); ?>
                <?php echo bt_cerrar(); ?>

                <input type="hidden"
                    name="cc_saldo"
                    value="<?php echo s_crypt($cc_saldo, 'in') ?>">

                <input type="hidden"
                    name="opc"
                    value="<?php echo s_crypt($opc, 'in') ?>">

            </div>

        </div>

    </form>

</div>

<script>
    function fn_guardar() {

        swalProcesando();

        var str = $("#frmRegistro").serialize();

        ajax('bancos/saldos_update', str)
            .then(function(res) {

                if (res != '0') {
                    throw res;
                }

                swalOk(750);
                modalRegistro.hide();
                fn_reporte();

            }).catch(function(err) {

                swalError(err);

            });
    }
</script>