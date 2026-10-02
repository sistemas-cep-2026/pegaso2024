<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$_c_persona = $_REQUEST["c_persona"] ?? '';
$c_expediente = $_REQUEST["c_expediente"] ?? '';
$c_persona = s_crypt($_c_persona, 'out');

$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '', '1');
$data_pagos_recaudo = $bo_general->listarPagosRecaudoTramitesXPersona($c_persona);
$data_conceptos_recaudo = $bo_general->listarTramitesRecaudo();
?>
<form action="javascript:fn_insertarPago()" id="frmPagosRecaudo">
    <input type="hidden" name="c_persona" value="<?= $_c_persona; ?>">
    <input type="hidden" name="c_expediente" value="<?= $c_expediente; ?>">
    <input type="hidden" name="opc" value="<?= s_crypt('I') ?>">
    <div class="row mt-1">
        <div class="col-xl-12">
            <?php
            if (empty($data_pagos_recaudo)) {
                echo errors('No hay resultados de pagos en la recaudo.');
            } else {
            ?>
                <table class="table table-sm table-stripted" id="tabla_pagos_recaudo" style="font-size:0.75rem;">
                    <caption class="caption-top">
                        <p class="fs-5 fw-bold">Pagos recaudo</p>
                    </caption>
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j = 1;
                        foreach ($data_pagos_recaudo as $pagos_recaudo) {
                        ?>
                            <tr>
                                <td>
                                    <div class="hstack gap-2 flex-wrap pt-1">
                                        <input type="radio" class="btn-check checkbox-recaudo" name="id_recaudo_bbva" id="pago_recaudo_<?= $j; ?>" onchange="fn_opcionRecaudo($(this));" value="<?= $pagos_recaudo['id']; ?>">
                                        <label class="btn btn-sm btn-outline-primary material-shadow" for="pago_recaudo_<?= $j; ?>"><i class="ri-checkbox-indeterminate-line fa-lg"></i></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div><?= $pagos_recaudo['referencia2']; ?></div>
                                        <div class="text-muted">Fecha: <?= $pagos_recaudo['fecha_pago']; ?> - OP: <?= $pagos_recaudo['num_movimiento']; ?></div>
                                    </div>
                                </td>
                                <td class="align-middle">S/ <?= $pagos_recaudo['total']; ?></td>
                            </tr>
                        <?php
                            $j++;
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="row mt-1">
        <div class="accordion border-0" id="accordionPagos">
            <div class="accordion-item border-0">
                <h2 class="accordion-header border-0">
                    <button class="accordion-button p-1 caret-off bg-white border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsepago" aria-expanded="false" aria-controls="collapsepago" style="width: fit-content;">
                        <span class="btn btn-ghost-info"><i class="fa fa-plus align-bottom"></i> Agregar pago </span>
                    </button>
                </h2>
                <div id="collapsepago" class="accordion-collapse collapse border-0" data-bs-parent="#accordionPagos">
                    <div class="accordion-body border-0 p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_banco">Banco</span>
                                    <select name="banco" id="banco" class="form-select input-pago" aria-label="Banco" aria-describedby="_banco" required disabled>
                                        <option value="">Seleccione banco....</option>
                                        <?php
                                        foreach ($data_bancos as $ban) {
                                        ?>
                                            <option value="<?= "{$ban['c_banco']}-{$ban['c_cta_corriente']}" ?>">
                                                <?= "{$ban['nombre']} =>> {$ban['c_cta_corriente']}" ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_fecha_op">Fecha</span>
                                    <input type="text" name="fecha_op" id="fecha_op" class="form-control input-pago" placeholder="Fecha de operación" aria-label="Fecha" aria-describedby="_fecha_op" required disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_operacion">N° operación</span>
                                    <input type="text" name="operacion" id="operacion" class="form-control input-pago" placeholder="N° de operación" aria-label="N° operación" aria-describedby="_operacion" required disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_monto">Monto</span>
                                    <input type="text" name="monto" id="monto" class="form-control input-pago input-decimal" placeholder="Monto" aria-label="Monto" aria-describedby="_monto" required disabled>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_cod_tram_recaudo">Concepto</span>
                                    <select name="cod_tram_recaudo" id="cod_tram_recaudo" class="form-select input-pago" aria-label="Concepto" aria-describedby="_cod_tram_recaudo" required disabled>
                                        <option value="">Seleccione concepto....</option>
                                        <?php
                                        foreach ($data_conceptos_recaudo as $conceptos) {
                                        ?>
                                            <option value="<?= "{$conceptos['cod_tram_recaudo']}" ?>">
                                                <?= "{$conceptos['rcd_concepto']}" ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="_obs">Observación</span>
                                    <input type="text" name="obs" id="obs" class="form-control input-pago input-decimal" placeholder="Escriba la observación" aria-label="obs" aria-describedby="_obs" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Guardar</button>
            </div>
        </div>
    </div>
</form>
<script>
    $('#frmPagosRecaudo').validate();

    var bsCollapsePagos = new bootstrap.Collapse('#collapsepago', {
        toggle: false
    });

    var bsCollapseContainerPagos = document.getElementById('collapsepago');

    bsCollapseContainerPagos.addEventListener('hide.bs.collapse', event => {
        $('.input-pago').val('').prop('disabled', !0);
        $('input[name="forma_pago"]').val('');
    });

    bsCollapseContainerPagos.addEventListener('show.bs.collapse', event => {
        var $tbody = $('#tabla_pagos_recaudo tbody');

        // Limpiar todas las filas
        $tbody.find('tr').removeClass('table-success');

        // Reiniciar todos los íconos a indeterminado
        $tbody.find('label.btn i')
            .removeClass('ri-checkbox-fill')
            .addClass('ri-checkbox-indeterminate-line');

        $('.checkbox-recaudo').prop('checked', !1);
        $('.input-pago').prop('disabled', !1);
        $('input[name="forma_pago"]').val('V');
    });

    var monto = new Cleave("#monto", {
        numeral: !0,
        numeralThousandsGroupStyle: "thousand",
        numeralDecimalScale: 2,
        numeralPositiveOnly: !0
    });

    var fecha_op = new Cleave('#fecha_op', {
        date: true,
        datePattern: ['d', 'm', 'Y'],
        delimiter: '/'
    });

    function fn_opcionRecaudo($input) {
        var $tbody = $input.closest('tbody');

        // Limpiar todas las filas
        $tbody.find('tr').removeClass('table-success');

        // Reiniciar todos los íconos a indeterminado
        $tbody.find('label.btn i')
            .removeClass('ri-checkbox-fill')
            .addClass('ri-checkbox-indeterminate-line');

        // Marcar fila actual
        var $row = $input.closest('tr');
        $row.addClass('table-success');

        // Cambiar ícono de esta fila a "check"
        $row.find('label.btn i')
            .removeClass('ri-checkbox-indeterminate-line')
            .addClass('ri-checkbox-fill');
        bsCollapsePagos.hide();
        $('input[name="forma_pago"]').val('R');

    }
</script>