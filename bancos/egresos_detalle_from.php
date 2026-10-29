<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_banc_items_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_comprob_caja = new bo_banc_comprobantes_de_caja();
$bo_comprob_deta = new bo_banc_items_comprobantes_de_caja();

$bo_general = new bo_general();

$ent_comprob_deta = new banc_items_comprobantes_de_caja();

$cc_documento = s_crypt($_REQUEST['cc_documento'], 'out');
$data_tipodoc = $bo_comprob_caja->listaTipoDocumento();
$c_local = s_local_vinculado();

$ent_comprob_deta->setCc_documento($cc_documento);
$data_detalle = $bo_comprob_deta->ListarIdComprobante($ent_comprob_deta);
$disabled = '';
$flag = $_REQUEST['flag'];
$disabled = in_array($flag, ['*', 'A']) ? 'disabled' : '';

$c_liquidacion_caja_chica = $_REQUEST['c_liquidacion_caja_chica'] ?? '';
$disabledCajaChica = empty($c_liquidacion_caja_chica) ? 'disabled' : '';
?>
<fieldset <?php echo $disabled; ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
            <thead class="table-light">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="col-2">Documento </th>
                    <th class="col-4">Razón social / Referencia </th>
                    <th class="col-0"> </th>
                    <th class="col-1"># </th>
                    <th class="col-1">Monto </th>
                    <th class="col-3">C. Contable</th>
                    <!--  <th class="text-end">Haber</th>-->
                    <th class="text-center">
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm <?php echo $disabledCajaChica; ?>" title="Procesar Caja" onclick="<?php echo $disabledCajaChica ? 'return false;' : "fn_recibosCaja('" . s_crypt($cc_documento, 'in') . "','" . s_crypt('C', 'in') . "'); return false;"; ?>">
                                <i class="ri-cash-line"></i>
                            </a>
                            <button type="button" class="btn btn-outline-info btn-sm" title="Agregar nuevo item" onclick="fn_agregarFila();" <?php echo $disabled; ?>>
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($data_detalle as $detalle) { ?>
                    <tr id="row<?php echo s_crypt($detalle['cc_documento_det']); ?>" class="align-top">
                        <input type="hidden" name="cc_documento" value="<?php echo s_crypt($detalle['cc_documento']); ?>">
                        <input type="hidden" name="cc_documento_det" value="<?php echo s_crypt($detalle['cc_documento_det']); ?>">
                        <input type="hidden" name="c_local" value="<?php echo s_crypt($c_local); ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td>
                            <select class="form-control form-control-sm" id="cod_documento" name="cod_documento" <?php //echo $disabled_temp_prima 
                                                                                                                    ?> required>
                                <option value="">Selecciona</option>
                                <?php foreach ($data_tipodoc as $uni): ?>
                                    <option value="<?php echo $uni['c_tipo_de_documento']; ?>"
                                        <?php echo ($detalle['cod_documento'] == $uni['c_tipo_de_documento']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($uni['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <div class="buscar-persona">
                                <?php $v_persona = $detalle['c_persona_hijo'] ?? $detalle['c_persona'] ?? ''; ?>
                                <input type="hidden" class="form-control form-control-sm" name="c_persona_hijo" id="c_persona_hijo" value="<?php echo $v_persona !== '' ? s_crypt($v_persona) : ''; ?>">
                                <input type="text" class="form-control form-control-sm typeahead" name="nombres" id="nombres" value="<?php echo $detalle['nombre_completo'] ?>">
                            </div>
                        </td>
                        <td>
                            <a href="#" class="btn-buscar-compras<?php echo $disabled ? ' text-muted pe-none opacity-50' : ''; ?>" onclick="<?php echo $disabled ? 'return false;' : 'fn_showCompras($(this)); return false;'; ?>"><i class='fas fa-tags'></i></a>
                        </td>
                        <td><input type="text" class="form-control form-control-sm" name="num_documento" id="num_documento" value="<?php echo $detalle['num_documento'] ?>"></td>
                        <td><input type="text" class="form-control form-control-sm input-decimal" name="monto" id="monto" value="<?php echo $detalle['monto'] ?>"></td>
                        <td class="buscar-cta">
                            <input type="hidden" name="c_cuenta" value="<?php echo $detalle['c_cuenta']; ?>">
                            <input type="text" class="form-control form-control-sm typeahead" value="<?php echo !empty($detalle['c_cuenta']) ? $detalle['c_cuenta'] . '-' . $detalle['nombre_cuenta'] : ''; ?>">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon bg-transparent" onclick="fn_borrarFila('<?php echo s_crypt($detalle['cc_documento_det']); ?>');" <?php echo $disabled; ?>><i class="fa fa-lg fa-trash text-danger"></i></a>

                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="align-middle">
                    <th colspan="5" class="text-end">Total</th>
                    <th>
                        <span id="totalMonto" class="fw-bold">S/ 0.00</span>
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </form>
</fieldset>

<script>
    function fn_calcularTotalMonto() {
        var total = 0;
        $('.input-decimal[name="monto"]').each(function() {
            var val = $(this).val();
            val = val.replace('S/', '').replace(/,/g, '').trim();
            var num = parseFloat(val);
            if (!isNaN(num)) {
                total += num;
            }
        });
        $('#totalMonto').text('S/ ' + total.toFixed(2));
    }

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
    });

    // Calcula el total al cargar
    fn_calcularTotalMonto();

    $('#formGrabarDetalle .form-control').not('.typeahead').on('blur', function() {
        if ($(this).val() === "" || $(this).val() === '0.000' || $(this).attr("readonly") === 'readonly' || old_value === $(this).val()) {
            return false;
        }
        var fila = $(this).parents('tr').attr('id');
        fn_actualizarFila(fila);
    }).on('focus', function() {
        old_value = $(this).val();
        $(this).select();
    });

    // Recalcula total en cualquier cambio de un input de monto
    $(document).on('blur keyup', '.input-decimal[name="monto"]', function() {
        fn_calcularTotalMonto();
    });


    var personas = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: hostname + "comun/json_ruc?query=%QUERY",
            wildcard: "%QUERY"
        }
    });
    personas.initialize();

    var buscarPersonas = personas.ttAdapter();

    function fuentePersonas(query, sync, async) {
        var m = $.trim(query).match(/^(\d{8,11})\s*-/);
        return buscarPersonas(m ? m[1] : query, sync, async);
    }

    var opcionesPersona = {
        hint: true,
        highlight: true,
        minLength: 1
    };

    var plantillaPersona = {
        name: "personas",
        display: "nombres",
        source: fuentePersonas,
        limit: Infinity,
        templates: {
            empty: Handlebars.compile(`<div class="text-danger ms-1"><b>No se encontraron RUC o Razon Social</b></div>`),
            pending: Handlebars.compile(`<div class="ms-1"><b>Buscando RUC o Razon Social...</b></div>`)
        }
    };
    $(".buscar-persona .typeahead")
        .typeahead(opcionesPersona, plantillaPersona)
        .bind("typeahead:selected", function(obj, datum, name) {
            var fila = $(this).parents('tr').attr('id');
            $(`#${fila}`).find(`input[name="c_persona_hijo"]`).val(datum.c_persona);
            $(`#${fila}`).find(`a.btn-buscar-compras`).data('cc_persona_busqueda', datum.c_persona);
            fn_actualizarFila(fila);
        });

    /******************* */
    var plan_ctas = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: hostname + "comun/json_plan_cuentasBancosEgreso?query=%QUERY",
            wildcard: "%QUERY",
        },
    });
    plan_ctas.initialize();

    var opcion1 = {
        hint: true,
        highlight: true,
        minLength: -1,
    };

    var opcion2 = {
        name: "nombre",
        display: "nombre_cta",
        source: plan_ctas.ttAdapter(),
        limit: Infinity,
        templates: {
            empty: Handlebars.compile(`<div class="text-danger ms-1"><b>No hay resultados</b></div>`),
            pending: Handlebars.compile(`<div class="ms-1"><b>Buscando datos...</b></div>`),
        }
    };

    $(".buscar-cta .typeahead")
        .typeahead(opcion1, opcion2)
        .bind("typeahead:selected", function(obj, datum, name) {
            var fila = $(this).parents('tr').attr('id');
            $(`#${fila}`).find(`input[name="c_cuenta"]`).val(datum.c_cuenta);
            fn_actualizarFila(fila);
        });

    /*********************************************** */

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
    });

    $('#formGrabarDetalle .form-control').not('.typeahead').on('blur', function() {
        if ($(this).val() === "" || $(this).val() === '0.000' || $(this).attr("readonly") === 'readonly' || old_value === $(this).val()) {
            return false;
        }
        var fila = $(this).parents('tr').attr('id');
        fn_actualizarFila(fila);
    }).on('focus', function() {
        old_value = $(this).val();
        $(this).select();
    });

    function fn_actualizarFila(fila) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'info',
            title: 'Procesando datos...'
        });
        var str = $(`#${fila} :input`).serialize();
        ajax("bancos/egresos_detalle_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
            .then(function(res) {
                if (res !== "0") {
                    throw res;
                }
                //fn_listarDetalleFromEgresos();
            }).catch(function(err) {
                $(".txt_estado").addClass("invisible");
                swalError(err);
            });
    }

    function fn_borrarFila(cc_documento_det) {
        fn_controlcompras(`cc_documento_det=${cc_documento_det}&opcd=<?php echo s_crypt('E'); ?>`)
    }

    function fn_agregarFila() {
        fn_controlcompras(`cc_documento=<?php echo s_crypt($cc_documento); ?>&opcd=<?php echo s_crypt('I'); ?>`)
    }

    function fn_controlcompras(str) {
        swalProcesando();
        ajax("bancos/egresos_detalle_update", str)
            .then(function(res) {
                if (res !== "0") {
                    throw res;
                }
                fn_listarDetalleFromEgresos();
                fn_calcularTotalMonto();
                swalCerrar(750);
            }).catch(function(err) {
                swalError(err);
            });
    }

    $(".buscar-cta .typeahead").on("typeahead:selected", function(obj, datum) {
        var c_cuenta = datum.c_cuenta;
        bloquearCampos.call(this, c_cuenta);
    });
</script>