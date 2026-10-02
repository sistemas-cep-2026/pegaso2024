<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_fin_items_planilla_de_cobranza.php");
require_once(u_src() . "bo/bo_gen_articulos.php");
require_once(u_src() . "bo/bo_general.php");
$opcp = 'I';
$bo_ventas_det = new bo_fin_items_planilla_de_cobranza();
$bo_articulo = new bo_gen_articulos();
$bo_general = new bo_general();

$ent_ventas_det = new fin_items_planilla_de_cobranza();
$ent_articulo = new gen_articulos();

$cc_ventas = s_crypt($_REQUEST["cc_ventas"], 'out');
$ent_ventas_det->setCc_ventas($cc_ventas);

$flag = $_REQUEST["flag"];
$estados_bloqueados = ['*', 'A'];
$bloquear = in_array($flag, $estados_bloqueados, true);

$lista_banco_cuenta = $bo_general->ListarcuentasBancarias_activas(s_local(), '', '', '');

$data_detall =  $bo_ventas_det->ListarIdVentas($ent_ventas_det);
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="table-light">
                    <tr>
                        <th>GLOSA</th>
                        <th class='text-end'>MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $subtotal = 0;
                    foreach ($data_detall as $row) {
                        $subtotal += $row['monto'];
                    ?>
                        <tr>
                            <td><?= $row['cod_forma_de_pago_text'] ?>
                                <?php if ($row['cod_forma_de_pago'] === 'V'): ?><br>
                                    <small class="text-muted">
                                        <?= $row['c_banco_ref_text'] . ' ' . $row['cta_cte_deposito'] . " | " . $row['fecha_referencia_text'] . " | " . $row['num_referencia'] ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <?php if ($bloquear): ?>
                                    <span class="text-muted" title="Acción bloqueada">
                                        <?= decimal($row['monto'], 2) ?> <i class="fas fa-trash-alt"></i>
                                    </span>
                                <?php else: ?>
                                    <?= decimal($row['monto'], 2) ?> <a href="#" onclick="fn_EliminarPago('<?= s_crypt($row['cc_itemplanilla']) ?>','<?= s_crypt('E') ?>')" class="link-danger" title="Eliminar"><i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <footer>
                    <tr>
                        <th colspan="2" class='text-end'>Total : <?php echo decimal($subtotal, 2) ?></th>
                        <input type="hidden" id="total_pagos" value="<?= $subtotal ?>">
                        <th class='text-end'></th>
                    </tr>
                </footer>
            </table>
        </div>
    </div>
</div>

<form method="post" action="javascript:fn_guardarRegistroPagos();" id="frmFormRegistroPagos" novalidate>
    <fieldset <?= $bloquear ? 'disabled' : '' ?>>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cod_forma_de_pago" id="cod_forma_de_pago_efec" value="E" checked>
                                        <label class="form-check-label" for="cod_forma_de_pago_efec">Efectivo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="cod_forma_de_pago" id="cod_forma_de_pago_voucher" value="V">
                                        <label class="form-check-label" for="cod_forma_de_pago_voucher">Voucher</label>
                                    </div>
                                </td>
                            </tr>
                            <tr id="row_cta_cte" class="d-none">
                                <td>
                                    <select class="form-select" name="cta_cte_deposito" id="cta_cte_deposito">
                                        <option value="">-- Seleccione una cuenta --</option>
                                        <?php foreach ($lista_banco_cuenta  as $ban) { ?>
                                            <option value="<?= $ban['banco_cta'] ?>"><?= $ban['nombre'] . " " . $ban['c_cta_corriente'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr id="row_fecha_ref" class="d-none">
                                <td>
                                    <input type="date" class="form-control" id="fecha_referencia" name="fecha_referencia">
                                </td>
                            </tr>
                            <tr id="row_num_ref" class="d-none">
                                <td>
                                    <input type="text" class="form-control" id="num_referencia" name="num_referencia" placeholder="N° OP">
                                </td>
                            </tr>
                            <tr id="row_monto">
                                <td>
                                    <input type="text" class="form-control input-decimal" id="monto" name="monto" placeholder="0.00" required>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center">
                                    <input type="hidden" name="cc_ventas" id="cc_ventas" value="<?= s_crypt($cc_ventas, 'in') ?>">
                                    <input type="hidden" name="opcp" id="opcp" value="<?= s_crypt('I', 'in') ?>">
                                    <?php echo bt_guardar('Insertar') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<script>
    var validator = $("#frmFormRegistroPagos").validate({});
    $('.input-decimal').inputmask({
        alias: "decimal",
        integerDigits: 10,
        digits: 2,
        allowMinus: false,
        digitsOptional: false,
        placeholder: "0.00",
        groupSeparator: ',',
        prefix: 'S/ ',
        autoGroup: true,
        rightAlign: false
    });

    function validardatos() {
        var forma = $('input[name="cod_forma_de_pago"]:checked').val();
        var $rowCta = $("#row_cta_cte");
        var $rowFec = $("#row_fecha_ref");
        var $rowNum = $("#row_num_ref");

        var $cta = $("#cta_cte_deposito");
        var $fecha = $("#fecha_referencia");
        var $numRef = $("#num_referencia");

        if (forma === 'E') {
            $rowCta.addClass("d-none");
            $rowFec.addClass("d-none");
            $rowNum.addClass("d-none");

            $cta.prop("required", false).val("");
            $fecha.prop("required", false).val("");
            $numRef.prop("required", false).val("");

        } else if (forma === 'V') {
            $rowCta.removeClass("d-none");
            $rowFec.removeClass("d-none");
            $rowNum.removeClass("d-none");

            $cta.prop("required", true);
            $fecha.prop("required", true);
            $numRef.prop("required", true);
        }

    }
    $(document).on('change', 'input[name="cod_forma_de_pago"]', validardatos);
    $(function() {
        validardatos();
    });
</script>