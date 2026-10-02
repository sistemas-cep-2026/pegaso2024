<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$cc_persona = $_REQUEST['cc_persona'];
$deuda = $_REQUEST['deuda'];

?>

<div class="modal-header">
    <h4 class="modal-title">FRACCIONAMIENTO <?php echo $cc_persona; ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <form action="javascript:fn_GuardarRegistro();" id="frmGuardarRegistro" novalidate>

        <!-- DEUDA + CUOTAS -->
        <div class="row mb-2">
            <div class="col-md-12">

                <div class="input-group mb-2">
                    <span class="input-group-text">Deuda S/. :</span>
                    <input type="text"
                        class="form-control input-decimal"
                        id="deudax"
                        value="<?php echo decimal($deuda, 2); ?>"
                        readonly>
                </div>

                <select class="form-select" id="cuotas" name="cuotas" required>
     
                    <?php for ($i = 2; $i <= 24; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> cuota<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>

            </div>
        </div>

        <!-- MONTO POR CUOTA -->
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-text">Monto Cuota S/. :</span>
                    <input type="text"
                        class="form-control input-decimal"
                        name="monto"
                        id="monto"
                        placeholder="0.00"
                        readonly>
                </div>

            </div>
        </div>

        <!-- HIDDEN -->
        <input type="hidden" name="deuda_total" id="deuda_total" value="<?= $deuda ?>">

        <div class="row">
            <div class="modal-footer text-center">
                <input type="hidden" name="cc_persona" value="<?= $cc_persona ?>">
                <input type="hidden" name="cc_fraccionamiento" value="<?= '0'; ?>">
                <input type="hidden" name="opc" value="I">
                <?php echo bt_guardar(); ?>
                <?php echo bt_cerrar(); ?>
            </div>
        </div>

    </form>
</div>

<script>
  
    function calcularMonto() {
    let cuotas = parseInt($("#cuotas").val());
    let deuda = parseFloat($("#deuda_total").val()) || 0;

    if (!cuotas || cuotas <= 0) return;

    let resultado = deuda / cuotas;
    resultado = Math.round(resultado * 100) / 100;

    $("#monto").val(resultado.toFixed(2));
}

$(document).on("change", "#cuotas", calcularMonto);

// ejecutar cuando quieras
calcularMonto();

    function fn_GuardarRegistro() {
        swalProcesando();
        var str = $("#frmGuardarRegistro").serialize();
        ajax('caja/fracc_update', str).then(function(res) {
            if (res != '0') {
                throw res;
            }
            swalOk(750);
            modalRegistroSm.hide();
            fn_buscarRegistro();
        }).catch(function(err) {
            swalError(err);
        });
    }
</script>