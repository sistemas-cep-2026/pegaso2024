<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_items_documentos_de_compra_cue.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_compra_det = new bo_comp_items_documentos_de_compra_cue();

$bo_general = new bo_general();

$ent_compra_det = new comp_items_documentos_de_compra_cue();

$cc_compra = s_crypt($_REQUEST['cc_compra'], 'out');

$flag = $_REQUEST['flag'];
$disabled = in_array($flag, ['*', 'A']) ? 'disabled' : '';

$cab_total = $_REQUEST['total'] ?? '';
$cod_documento = $_REQUEST['cod_documento'] ?? '';

$ent_compra_det->setCc_compra($cc_compra);

$data_detalle = $bo_compra_det->listaIDCompra($ent_compra_det);
$debe = "Debe";
$haber = "Haber";
if (in_array($cod_documento, ['BE', 'TC', 'CC', 'BP'])) {
    $debe = "EGRESO";
    $haber = "----";
}

?>
<fieldset <?php echo $disabled; ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
            <thead class="table-light">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="col-5">Cuenta Contable </th>
                    <th class="text-end"><?= $debe ?></th>
                    <th class="text-end"><?= $haber ?></th>
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
                    <tr id="row<?php echo s_crypt($detalle['cc_compra_det']); ?>" class="align-top">

                        <input type="hidden" name="cod_documento" value="<?php echo $cod_documento; ?>">
                        <input type="hidden" name="cc_compra_det" value="<?php echo s_crypt($detalle['cc_compra_det']); ?>">

                        <td class="text-center"><?php echo $i; ?></td>

                        <td class="buscar-cta">
                            <input type="hidden" name="c_cuenta" value="<?php echo $detalle['c_cuenta']; ?>">


                            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm typeahead" value="<?php echo !empty($detalle['c_cuenta']) ? $detalle['c_cuenta'] . '-' . $detalle['nombre_cuenta'] : ''; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm input-decimal debex" name="debe" value="<?php echo $detalle['debe']; ?>">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm input-decimal haberx" name="haber" value="<?php echo $detalle['haber']; ?>">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon bg-transparent" onclick="fn_borrarFila('<?php echo s_crypt($detalle['cc_compra_det']); ?>');" <?php echo $disabled; ?>><i class="fa fa-lg fa-trash text-danger"></i></a>

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
            url: hostname + "comun/json_plan_cuentascompras?query=%QUERY",
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
        //  prefix: 'S/ ',
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
        ajax("compras/rep_compras_det_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
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

    function fn_borrarFila(cc_compra_det) {
        fn_controlcompras(`cc_compra_det=${cc_compra_det}&opcd=<?php echo s_crypt('E'); ?>`)
    }

    function fn_agregarFila() {
        fn_controlcompras(`cc_compra=<?php echo s_crypt($cc_compra); ?>&opcd=<?php echo s_crypt('I'); ?>`)
    }

    function fn_controlcompras(str) {
        swalProcesando();
        ajax("compras/rep_compras_det_update", str)
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

    function calculoTotalDebe() {
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
    }
    <?php
    if (!in_array($flag, ['*', 'A'])) {

    ?>

        function bloquearCampos(c_cuenta, cod_documento, filaElem) {
            var fila = $(filaElem).closest('tr');

            // Desbloquear ambos por defecto
            fila.find('input[name="debe"]').prop('readonly', false);
            fila.find('input[name="haber"]').prop('readonly', false);

            // Reglas
            if (cod_documento === 'TT' && c_cuenta.charAt(0) === '6') {
                // Bloquea DEBE, permite HABER
                fila.find('input[name="debe"]').prop('readonly', true).val('0');
                fila.find('input[name="haber"]').prop('readonly', false);
            } else if (c_cuenta.charAt(0) === '4') {
                // Bloquea DEBE, permite HABER
                fila.find('input[name="debe"]').prop('readonly', true).val('0');
                fila.find('input[name="haber"]').prop('readonly', false);
            } else {
                // Caso general: bloquea HABER, permite DEBE
                fila.find('input[name="debe"]').prop('readonly', false);
                fila.find('input[name="haber"]').prop('readonly', true).val('0');
            }
        }

        // 🔹 Aplica la lógica a todas las filas al cargar la página
        $('#formGrabarDetalle .buscar-cta .typeahead').each(function() {
            var fila = $(this).closest('tr');
            var c_cuenta = fila.find('input[name="c_cuenta"]').val();
            var cod_documento = fila.find('input[name="cod_documento"]').val();
            bloquearCampos(c_cuenta, cod_documento, fila);
        });

        // 🔹 Aplica la lógica cuando el usuario selecciona una cuenta del typeahead
        $(".buscar-cta .typeahead").on("typeahead:selected", function(obj, datum) {
            var fila = $(this).closest('tr');
            var c_cuenta = datum.c_cuenta;
            var cod_documento = fila.find('input[name="cod_documento"]').val();
            bloquearCampos(c_cuenta, cod_documento, fila);
        });
    <?php
    }
    ?>
</script>