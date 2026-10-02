<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cont_items_voucher.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");


$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_voucher_det = new bo_cont_items_voucher();

$bo_general = new bo_general();

$ent_voucher_det = new cont_items_voucher();


$cc_voucher = s_crypt($_REQUEST['cc_voucher'], 'out');

$flag = $_REQUEST['flag'];
$disabled = in_array($flag, ['C', 'A']) ? 'disabled' : '';

$cab_total = $_REQUEST['total'] ?? '';


$ent_voucher_det->setCc_voucher($cc_voucher);
$data_detalle = $bo_voucher_det->listarIDvoucher($ent_voucher_det);


?>


<fieldset <?php echo $disabled; ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
           <thead class="table-light">
            <tr class="align-middle">
                <th>#</th>
                <th class="col-5">Cuenta contable <?php echo $cc_voucher?></th>
                <th class="text-end">Debe</th>
                <th class="text-end">Haber</th>
                <!--  <th class="text-end">Haber</th>-->
                <th class="text-center">
                    <button title="Agregar nuevo Items" class="btn bg-transparent" type="button" onclick="fn_agregarFila();" <?php echo $disabled; ?>>
                        <i class="fas fa-plus fa-lg text-info"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total_debe = array_sum(array_column($data_detalle, 'debe'));
            $total_haber = array_sum(array_column($data_detalle, 'haber'));
            foreach ($data_detalle as $detalle) {
                ?>
                <tr id="row<?php echo s_crypt($detalle['cc_voucher_det']); ?>" class="align-top">
                    <input type="hidden" name="cc_voucher" value="<?php echo s_crypt($detalle['cc_voucher']); ?>">
                    <input type="hidden" name="cc_voucher_det" value="<?php echo s_crypt($detalle['cc_voucher_det']); ?>">
                    <td class="text-center"><?php echo $i; ?></td>

                    <td class="buscar-cta">
                        <input type="hidden" name="c_cuenta" value="<?php echo $detalle['c_cuenta']; ?>">
                        <input type="text" class="form-control form-control-sm typeahead" value="<?php echo !empty($detalle['c_cuenta']) ? $detalle['c_cuenta'].'-'.$detalle['nombre_cuenta'] : ''; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-decimal debex" name="debe" value="<?php echo $detalle['debe']; ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm input-decimal haberx" name="haber" value="<?php echo $detalle['haber']; ?>">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-icon bg-transparent" onclick="fn_borrarFila('<?php echo s_crypt($detalle['cc_voucher_det']); ?>');" <?php echo $disabled; ?>><i class="fa fa-lg fa-trash text-danger"></i></a>

                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="2" class="text-end">TOTAL => </td>
                    <td class="text-end total_debe"><?php echo decimal_millar($total_debe, 2); ?></td>
                    <td class="text-end total_haber"><?php echo decimal_millar($total_haber, 2); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </form>
</fieldset>

<script>
    var plan_ctas = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: hostname + "comun/json_plan_cuentas?query=%QUERY",
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

    var old_value = 0;
    //var cabecera_total = <?php //echo $cab_total; 
    ?>;


    $(".buscar-cta .typeahead")
    .typeahead(opcion1, opcion2)
    .bind("typeahead:selected", function(obj, datum, name) {
        var fila = $(this).parents('tr').attr('id');
        $(`#${fila}`).find(`input[name="c_cuenta"]`).val(datum.c_cuenta);
        fn_actualizarFila(fila);
    });

    $('.input-decimal').inputmask({
        alias: "decimal",
        integerDigits: 10,
        digits: 2,
        allowMinus: false,
        digitsOptional: false,
        placeholder: "0.00",
        groupSeparator: ',',
        // prefix: 'S/ ',
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
        toast({
            icon: 'info',
            title: 'Procesando datos...',
            timer: 0,

        });
        var str = $(`#${fila} :input`).serialize();
        ajax("contabilidad/asient_taps_det_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
        .then(function(res) {
            if (res !== "0") {
                throw res;
            }
            calculoTotalDebe();
            calculoTotalhaber();
            fn_listarDetalleFrom();
            swalCerrar(750);
        }).catch(function(err) {
            $(".txt_estado").addClass("invisible");
            swalError(err);
        });

    }

    function fn_borrarFila(cc_voucher_det) {
        fn_controlVoucher(`cc_voucher_det=${cc_voucher_det}&opcd=<?php echo s_crypt('E'); ?>`)
    }

    function fn_agregarFila() {
        fn_controlVoucher(`cc_voucher=<?php echo s_crypt($cc_voucher); ?>&opcd=<?php echo s_crypt('I'); ?>`)
    }

    function fn_controlVoucher(str) {
        swalProcesando();
        ajax("contabilidad/asient_taps_det_update", str)
        .then(function(res) {
            if (res !== "0") {
                throw res;
            }
            fn_listarDetalleFrom();
            swalCerrar(750);
        }).catch(function(err) {
            swalError(err);
        });
    }
   /*function calculoTotalDebe() {
        var total_debe = 0;
        $(`#formGrabarDetalle input.debex`).each(function(i, el) {
            total_debe += Number.parseFloat($(this).val().replace(/(,)|(\$)|(S\/)/, '')) || 0;
        });
        $('.total_debe').text(decimal(total_debe, 2));
    }

    function calculoTotalhaber() {
        var total_haber = 0;
        $(`#formGrabarDetalle input.haberx`).each(function(i, el) {
            total_haber += Number.parseFloat($(this).val().replace(/(,)|(\$)|(S\/)/, '')) || 0;
        });
        $('.total_haber').text(decimal(total_haber, 2));
    }*/

    function resaltarDiferencia() {
        let totalDebe = parseFloat($('.total_debe').text().replace(/,/g, '')) || 0;
        let totalHaber = parseFloat($('.total_haber').text().replace(/,/g, '')) || 0;

        $('.total_debe, .total_haber').removeClass('text-danger'); // Elimina cualquier color previo

        if (totalDebe !== totalHaber) {
            if (totalDebe < totalHaber) {
                $('.total_debe').addClass('text-danger');
            } else {
                $('.total_haber').addClass('text-danger');
            }
        }
    }

    function calculoTotalDebe() {
        let total_debe = 0;
        $('#formGrabarDetalle input.debex').each(function() {
            total_debe += parseFloat($(this).val().replace(/,/g, '')) || 0;
        });
        $('.total_debe').text(total_debe.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        resaltarDiferencia();
    }

    function calculoTotalhaber() {
        let total_haber = 0;
        $('#formGrabarDetalle input.haberx').each(function() {
            total_haber += parseFloat($(this).val().replace(/,/g, '')) || 0;
        });
        $('.total_haber').text(total_haber.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        resaltarDiferencia();
    }

    // Llamar las funciones cuando se actualicen los valores
    $('#formGrabarDetalle .debex, #formGrabarDetalle .haberx').on('input', function() {
        calculoTotalDebe();
        calculoTotalhaber();
    });

    // Ejecutar una vez para reflejar los valores iniciales
    $(document).ready(function() {
        resaltarDiferencia();
    });

    $('#formGrabarDetalle .debex, #formGrabarDetalle .haberx').each(function() {
        $(this).on("input", function () {
            var $row = $(this).closest('tr');
            var debe = parseFloat($row.find('.debex').val()) || 0;
            var haber = parseFloat($row.find('.haberx').val()) || 0;
            
            if ($(this).hasClass('debex') && debe > 0) {
                $row.find('.haberx').val("0");
            } else if ($(this).hasClass('haberx') && haber > 0) {
                $row.find('.debex').val("0");
            }
        });
    });

</script>