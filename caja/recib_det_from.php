<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_fin_items_documentos_de_venta.php");
require_once(u_src() . "bo/bo_gen_articulos.php");
require_once(u_src() . "bo/bo_fin_prestamos_socios.php");

$opc = 'I';
$bo_ventas_det = new bo_fin_items_documentos_de_venta();
$bo_articulo   = new bo_gen_articulos();
$bo_fin_fraccionamiento = new bo_fin_prestamos_socios();

$ent_ventas_det = new fin_items_documentos_de_venta();
$ent_articulo   = new gen_articulos();
$ent_fraccionamiento = new fin_prestamos_socios();

$cc_ventas = s_crypt($_REQUEST["cc_ventas"], 'out');
$c_persona = s_crypt($_REQUEST["c_persona"], 'out');

$flag      = $_REQUEST["flag"];
$estados_bloqueados = ['*', 'A'];
$bloquear  = in_array($flag, $estados_bloqueados, true);

$ent_articulo->setC_usuario(s_usuario());
$data_concep = $bo_articulo->ListarConcetosCaja($ent_articulo);
$data_anho   = listarAnhos();
$data_desde  = u_meses_iniciales();
$data_hasta  = u_meses_iniciales();

$ent_fraccionamiento->setC_persona($c_persona);
$data_cuotas = $bo_fin_fraccionamiento->listarCuotasRecibo($ent_fraccionamiento);

$ent_ventas_det->setCc_ventas($cc_ventas);
$data_detall  = $bo_ventas_det->ListarIdVentas($ent_ventas_det);
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm ">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>CONCEPTO</th>
                        <th>AÑO</th>
                        <th>PERIODO</th>
                        <th>CANTIDAD</th>
                        <th>P/U</th>
                        <th class='text-end'>SUBTOTAL</th>
                        <th class='text-center'>OPT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $total_doc = 0;
                    foreach ($data_detall as $row) {
                        $total_doc += $row['venta'];
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($row['c_articulo'] . '-' . $row['nombre_concepto']) ?></td>
                            <td><?= htmlspecialchars($row['ano']) ?></td>
                            <td><?= htmlspecialchars($row['mes_desde'] . ' - ' . $row['mes_hasta']) ?></td>
                            <td><?= decimal($row['cantidad'], 0) ?></td>
                            <td><?= decimal($row['precio'], 2) ?></td>
                            <td class='text-end'><?= decimal($row['venta'], 2) ?></td>
                            <td class="text-center">
                                <?php if ($bloquear): ?>
                                    <span class="text-muted" title="Acción bloqueada">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                <?php else: ?>
                                    <a href="#"
                                        onclick="fn_EliminarDetalle('<?= s_crypt($row['cc_ventadetall']) ?>','<?= s_crypt('E') ?>')"
                                        class="link-danger" title="Eliminar"> <i class="fas fa-trash-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
                <footer>
                    <tr>
                        <th colspan="6" class='text-end'>TOTAL : </th>
                        <input type="hidden" id="total_detalle" value="<?= $total_doc ?>">
                        <th class='text-end'><?= decimal($total_doc, 2) ?></th>
                        <th></th>
                    </tr>
                </footer>
            </table>
        </div>
    </div>
</div>

<form method="post" action="javascript:fn_guardarRegistroDetalle();" id="frmFormRegistroD" novalidate>
    <fieldset <?= $bloquear ? 'disabled' : '' ?>>
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="input-group mb-4">
                    <select name="c_articulo" id="c_articulo" class="form-control"
                        data-placeholder="Conceptos" required <?= $bloquear ? 'disabled' : '' ?>>
                        <option value="">Selecciona Concepto</option>
                        <?php foreach ($data_concep as $con) { ?>
                            <option value="<?= htmlspecialchars($con['c_articulo']); ?>">
                                <?= htmlspecialchars($con['c_articulo'] . ' - ' . $con['nombre_concepto']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="cuotas_container" class="col-md-3 col-12 d-none">
                <div class="input-group mb-3">
                    <span class="input-group-text">Cuotas</span>
                    <select class="form-control" id="cuota_fracc" name="cuota_fracc" disabled>
                        <option value="">Selecciona cuotas</option>
                        <?php foreach ($data_cuotas as $q): ?>
                            <option
                                value="<?= $q['cc_fraccionamiento_d'] ?>"
                                data-monto="<?= htmlspecialchars($q['cuota_capital']) ?>">
                                <?= htmlspecialchars($q['cuota']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div id="periodo_container" class="col-md-4 col-12 d-none">
                <div class="row g-2">
                    <div class="col-md-6 col-12">
                        <div class="input-group mb-3">
                            <select class="form-control" id="cod_anho" name="cod_anho">
                                <option value="">Año</option>
                                <?php foreach ($data_anho as $item):
                                    $selected = ($item['anho'] == date('Y')) ? 'selected' : ''; ?>
                                    <option value="<?= $item['anho'] ?>" <?= $selected ?>><?= $item['anho'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="input-group mb-3">
                            <select class="form-control" id="cod_desde" name="cod_desde">
                                <option value="">Desde</option>
                                <?php foreach ($data_desde as $codigo => $nombre):
                                    $selected = ($codigo == date('n')) ? 'selected' : ''; ?>
                                    <option value="<?= $codigo ?>" <?= $selected ?>><?= $nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="input-group mb-3">
                            <select class="form-control" id="cod_hasta" name="cod_hasta">
                                <option value="">Hasta</option>
                                <?php foreach ($data_hasta as $codigo => $nombre):
                                    $selected = ($codigo == date('n')) ? 'selected' : ''; ?>
                                    <option value="<?= $codigo ?>" <?= $selected ?>><?= $nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1 col-12">
                <div class="input-group mb-2">
                    <input type="number" class="form-control" id="cantidad" name="cantidad"
                        placeholder="1" min="1" step="1" value="1" aria-label="Cantidad">
                </div>
            </div>
            <div class="col-md-2 col-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control input-decimal" id="importe" name="importe"
                        placeholder="0.00" required aria-label="Importe">
                </div>
            </div>
            <div class="col-md-1 col-12">
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="total" name="total"
                        placeholder="0.00" aria-label="Total" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-12 text-center">
                <input type="hidden" name="cc_ventas" id="cc_ventas" value="<?= s_crypt($cc_ventas, 'in') ?>">
                <input type="hidden" name="opc" id="opc" value="<?= s_crypt($opc, 'in') ?>">
                <?= bt_guardar('Agregar items'); ?>
            </div>
        </div>
    </fieldset>
</form>

<script>
    function showPeriodo() {
        $('#periodo_container').removeClass('d-none');
        $('#cod_anho, #cod_desde, #cod_hasta').prop('disabled', false);
    }

    function hidePeriodo() {
        $('#periodo_container').addClass('d-none');
        $('#cod_anho, #cod_desde, #cod_hasta').val('').prop('disabled', true).trigger('change');
    }

    function showCuotas() {
        $('#cuotas_container').removeClass('d-none');
        $('#cuota_fracc').prop('disabled', false);
    }

    function hideCuotas() {
        $('#cuotas_container').addClass('d-none');
        $('#cuota_fracc').val('').prop('disabled', true).trigger('change');
    }

    function setImporteReadonly(readonly) {
        $('#importe').prop('readonly', readonly);
    }

    function setCantidadReadonly(readonly) {
        $('#cantidad').prop('readonly', readonly);
    }

    function updateFormByArticulo() {
        var art = $('#c_articulo').val();

        if (art === '70501') {
            showPeriodo();
            hideCuotas();
            setImporteReadonly(false);
            setCantidadReadonly(false);
            calcularTotal();
        } else if (art === '76666') {
            hidePeriodo();
            showCuotas();
            setImporteReadonly(true);
            setCantidadReadonly(true);
            $('#cantidad').val(1);
            $('#importe').val('');
            $('#total').val('');
        } else if (art) {
            hidePeriodo();
            hideCuotas();
            setImporteReadonly(false);
            setCantidadReadonly(false);
        } else {
            hidePeriodo();
            hideCuotas();
            setImporteReadonly(false);
            setCantidadReadonly(false);
        }

        $('#cod_anho, #cod_desde, #cod_hasta, #cuota_fracc').valid();
    }
    $.validator.addMethod("monthGreaterOrEqual", function(value, element, param) {
        if ($('#c_articulo').val() !== '70501') return true;
        var desde = parseInt($(param).val(), 10);
        var hasta = parseInt(value, 10);
        if (isNaN(desde) || isNaN(hasta)) return true;
        return hasta >= desde;
    }, "‘Hasta’ debe ser mayor o igual que ‘Desde’");

    var validator = $("#frmFormRegistroD").validate({
        ignore: [],
        rules: {
            c_articulo: {
                required: true
            },
            cod_anho: {
                required: {
                    depends: function() {
                        return $('#c_articulo').val() === '70501';
                    }
                }
            },
            cod_desde: {
                required: {
                    depends: function() {
                        return $('#c_articulo').val() === '70501';
                    }
                }
            },
            cod_hasta: {
                required: {
                    depends: function() {
                        return $('#c_articulo').val() === '70501';
                    }
                },
                monthGreaterOrEqual: "#cod_desde"
            },
            cuota_fracc: {
                required: {
                    depends: function() {
                        return $('#c_articulo').val() === '76666';
                    }
                }
            },
            cantidad: {
                required: true,
                digits: true,
                min: 1
            },
            importe: {
                required: true
            }
        },
        messages: {
            c_articulo: {
                required: "Selecciona un concepto"
            },
            cod_anho: {
                required: "Campo obligatorio"
            },
            cod_desde: {
                required: "Campo obligatorio"
            },
            cod_hasta: {
                required: "Campo obligatorio"
            },
            cuota_fracc: {
                required: "Selecciona el número de cuotas"
            },
            cantidad: {
                required: "Ingresa la cantidad",
                digits: "Debe ser entero",
                min: "Mínimo 1"
            },
            importe: {
                required: "Campo obligatorio"
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            if (element.hasClass("select2-hidden-accessible")) error.insertAfter(element.next('span.select2'));
            else error.insertAfter(element);
        },
        highlight: function(el) {
            $(el).addClass('is-invalid');
        },
        unhighlight: function(el) {
            $(el).removeClass('is-invalid');
        }
    });

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

    $(function() {
        var anhoActual = new Date().getFullYear();
        var mesActual = (new Date().getMonth() + 1).toString();

        $('#c_articulo').select2({
            placeholder: $('#c_articulo').data('placeholder'),
            width: 'resolve',
        }).on('change', function() {
            $(this).valid();

            $('#cod_anho').val(anhoActual).trigger('change');
            $('#cod_desde').val(mesActual).trigger('change');
            $('#cod_hasta').val(mesActual).trigger('change');

            $('#importe').val('');
            $('#total').val('');
            $('#cuota_fracc').val('').trigger('change');
            $('#cantidad').val(1);

            updateFormByArticulo();
            calcularTotal();
        });

        if (<?= $bloquear ? 'true' : 'false' ?>) {
            $('#c_articulo').prop('disabled', true).trigger('change.select2');
        }

        $('#cuota_fracc').on('change', function() {
            var opt = $(this).find(':selected');
            var monto = parseFloat(opt.data('monto'));
            if (!isNaN(monto)) {
                $('#importe').inputmask('setvalue', monto.toFixed(2));
                setImporteReadonly(true);
                $('#cantidad').val(1);
                setCantidadReadonly(true);
                calcularTotal();
                $('#importe').valid();
            } else {
                $('#importe').val('');
                $('#total').val('');
            }
        });

        $('#cod_desde, #cod_hasta').on('change', function() {
            if ($('#c_articulo').val() === '70501') {
                var desde = parseInt($('#cod_desde').val(), 10);
                var hasta = parseInt($('#cod_hasta').val(), 10);
                if (!isNaN(desde) && !isNaN(hasta) && hasta >= desde) {
                    var meses = (hasta - desde + 1);
                    $('#cantidad').val(meses);
                }
            }
            $('#cod_hasta').valid();
            calcularTotal();
        });

        $('#importe, #cantidad').on('change keyup blur', function() {
            calcularTotal();
        });
        hidePeriodo();
        hideCuotas();
        setImporteReadonly(false);
        setCantidadReadonly(false);
        $('#cantidad').val(1);
    });

    function calcularTotal() {
        let art = $('#c_articulo').val();
        let periodoVisible = !$('#periodo_container').hasClass('d-none');
        let importeStr = $('#importe').inputmask('unmaskedvalue');
        let importe = parseFloat(importeStr) || 0;

        let cantidad = parseInt($('#cantidad').val(), 10) || 0;
        if (cantidad < 1) cantidad = 1;
        let total = importe * cantidad;
        $('#total').val(total.toFixed(2));
    }
</script>