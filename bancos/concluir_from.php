<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");
$bo_general = new bo_general();
$bo_bancos_saldo = new bo_banc_saldos_bancos_cuentas();

$ent_bancos_saldo = new banc_saldos_bancos_cuentas();

$periodo = u_meses();
$ent_bancos_saldo->setFecha_registro(fecha_hoy());
$cc_local = s_local_vinculado();
$c_anho = s_anho();

$disabled = 'X';

$data_bancos    = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_saldo = isset($_REQUEST['cc_saldo']) ? s_crypt($_REQUEST['cc_saldo'], 'out') : '';

if ($opc == 'U') {
    $ent_bancos_saldo->setCc_saldo($cc_saldo);
    $data = $bo_bancos_saldo->listarID($ent_bancos_saldo);
    foreach ($data as $act) {
        $ent_bancos_saldo->setFecha($act["fecha"]);
        $ent_bancos_saldo->setCod_ano($act["c_anho"]);
        $ent_bancos_saldo->setCod_mes($act["c_mes"]);
        $ent_bancos_saldo->setC_banco($act["c_banco"]);
        $ent_bancos_saldo->setC_cta_cte($act["c_cta_cte"]);
        $ent_bancos_saldo->setSaldo_final($act["saldo_final"]);
        $banco_cta = $act["banco_cta"] ?? '';
    }
    $option = "CONCLUIR CHEQUE = " . $ent_bancos_saldo->getCod_ano();
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardar();" id="frmRegistro" novalidate>
        <div class="row">
            <div class="col-md-12 p-2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Fecha Registro : </span>
                            <input type="date" class="form-control" name="fecha_registro" id="fecha_registro" value="<?php echo $ent_bancos_saldo->getFecha() ?: ''; ?>" placeholder="S/. 0.00" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Periodo : </span>
                            <select name="cod_mes" id="cod_mes" class="form-control" <?php echo $disabled ?>>
                                <?php foreach ($periodo as $key => $value) { ?>
                                    <option value="<?php echo $key ?>" <?php echo ($key == $ent_bancos_saldo->getCod_mes()) ? 'selected' : ''; ?>>
                                        <?php echo $value ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Banco : </span>
                            <select class="form-control" id="c_banco" name="c_banco" required>
                                <option value="">Selecciona</option>
                                <?php foreach ($data_bancos as $ban) { ?>
                                    <option value="<?php echo $ban['c_banco'] . $ban['c_cta_corriente']; ?>"
                                        <?php echo ($banco_cta === $ban['banco_cta']) ? 'selected' : ''; ?>>
                                        <?php echo $ban['nombre'] . ' =>> ' . $ban['c_cta_corriente']; ?>
                                    </option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-2">
                            <span class="input-group-text">Monto. : </span>
                            <input type="text" class="form-control text-end input-pen" name="saldo_final" id="saldo_final" value="<?php echo decimal($ent_bancos_saldo->getSaldo_final(), 2); ?>" placeholder="S/ 0.00" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                        <input type="hidden" name="cc_saldo" value="<?php echo s_crypt($cc_saldo, 'in') ?>">
                        <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function fn_guardar() {
        swalProcesando();
        var str = $("#frmRegistro").serialize();
        ajax('bancos/concluir_update', str)
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