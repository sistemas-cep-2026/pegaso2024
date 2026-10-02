<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_dietas_detalles.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_bo_banc_dietas_detalles    =    new bo_banc_dietas_detalles();

$ent_banc_dietas_detalles = new banc_dietas_detalles();

$cc_dietas = s_crypt($_REQUEST['cc_dietas'], 'out');

$flag = $_REQUEST['flag'];

$disabled = in_array($flag, ['*', 'A']) ? 'disabled' : '';

$ent_banc_dietas_detalles->setCc_dietas($cc_dietas);
$data_detalle = $bo_bo_banc_dietas_detalles->listarID($ent_banc_dietas_detalles);

?>
<fieldset <?php echo $disabled;
            ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
            <thead class="table-light">
                <tr class="align-middle">
                    <th class="text-center">#</th>
                    <th class="col-4">Concepto </th>
                    <th class="col-2">Renta Bruta </th>
                    <th class="col-2">% Retencion</th>
                    <th class="col-1">Retencion </th>
                    <th class="text-center col-2">Neto </th>

                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($data_detalle as $detalle) { ?>
                    <tr id="row<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>" class="align-top">
                        <input type="hidden" name="cc_dietas" id="cc_dietas" value="<?php echo s_crypt($cc_dietas, 'in') ?>">

                        <input type="hidden" name="cc_dietas" value="<?php echo s_crypt($detalle['cc_dietas']); ?>">
                        <input type="hidden" name="cc_dietas_detalles" value="<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>">

                        <td class="text-center"><?php echo $detalle['concepto'] . '-' . $detalle['cc_dietas_detalles']; ?></td>
                        <td class="text-left"><?php echo ($detalle['concepto'] == '1') ? 'DIETA' : 'REFRIGERIO – MOVILIDAD Y REPRESENTACION'; ?></td>
                        <td><input type="text" class="form-control form-control-sm input-decimal" name="renta_bruta" id="renta_bruta" value="<?php echo $detalle['renta_bruta'] ?>"></td>
                        <td class="text-end">
                            <select class="form-control form-control-sm" name="retencion" id="retencion">
                                <?php
                                $valorActual = $detalle['retencion'] * 100;
                                for ($i = 0; $i <= 30; $i++):
                                ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($valorActual == $i) ? 'selected' : ''; ?>>
                                        <?php echo $i.'%'; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <span class="retencion-soles-display" data-row="<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>">
                                S/. 0.00
                            </span>
                            <input type="hidden"
                                name="retencion_soles"
                                class="retencion_soles-value"
                                data-row="<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>">
                        </td>

                        <td class="text-center">
                            <span class="neto-display" data-row="<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>">
                                S/. <?php echo decimal($detalle['neto'], 2); ?>
                            </span>
                            <input type="hidden"
                                name="neto"
                                class="neto-value"
                                data-row="<?php echo s_crypt($detalle['cc_dietas_detalles']); ?>"
                                value="<?php echo $detalle['neto']; ?>">
                        </td>


                    </tr>
                <?php

                }
                ?>
            </tbody>
        </table>
    </form>
</fieldset>
<script>
    // =============== FORMATO DE PORCENTAJE ===============
    document.querySelectorAll('input[name="retencion"]').forEach(function(input) {
        input.addEventListener('input', function(e) {
            // Remover todo excepto números y punto
            let valor = this.value.replace(/[^0-9.]/g, '');

            if (valor !== '') {
                this.value = valor;
            }

            // Calcular neto al cambiar retención
            var fila = $(this).parents('tr').attr('id');
            calcularNeto(fila);
        });

        // Al perder el foco, si está vacío poner 0
        input.addEventListener('blur', function(e) {
            if (this.value === '') {
                this.value = '0';
            }
            var fila = $(this).parents('tr').attr('id');
            calcularNeto(fila);
        });
    });

    // =============== CALCULAR NETO ===============
    function calcularNeto(fila) {
        // Obtener valores de la fila
        let montoInput = $(`#${fila}`).find('input[name="renta_bruta"]');
        let retencionInput = $(`#${fila}`).find('input[name="retencion"]');
        let retencionSolesDisplay = $(`#${fila}`).find('.retencion-soles-display');
        let retencionSolesValue = $(`#${fila}`).find('.retencion_soles-value');
        let netoDisplay = $(`#${fila}`).find('.neto-display');
        let netoValue = $(`#${fila}`).find('.neto-value');

        // Limpiar y convertir valores
        let montoTexto = montoInput.val().replace('S/ ', '').replace(/,/g, '');
        let monto = parseFloat(montoTexto) || 0;

        let retencionPorcentaje = parseFloat(retencionInput.val()) || 0;

        // Calcular retención en decimal (8 = 0.08)
        let retencionDecimal = retencionPorcentaje / 100;

        // Calcular retención en soles: monto * retencion%
        let retencionSoles = monto * retencionDecimal;

        // Calcular neto: monto - retencion_soles
        let neto = monto - retencionSoles;

        // Formatear con 2 decimales y separador de miles
        let retencionSolesFormateado = retencionSoles.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        let netoFormateado = neto.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Actualizar displays y valores ocultos
        retencionSolesDisplay.text('S/. ' + retencionSolesFormateado);
        retencionSolesValue.val(retencionSoles.toFixed(2));

        netoDisplay.text('S/. ' + netoFormateado);
        netoValue.val(neto.toFixed(2));
    }

    // =============== CALCULAR NETO AL CAMBIAR MONTO ===============
    $('.input-decimal').on('input', function() {
        var fila = $(this).parents('tr').attr('id');
        calcularNeto(fila);
    });

    // =============== CALCULAR NETO AL CARGAR LA PÁGINA ===============
    $(document).ready(function() {
        $('tbody tr').each(function() {
            var fila = $(this).attr('id');
            calcularNeto(fila);
        });
    });

    // =============== RESTO DEL CÓDIGO ORIGINAL ===============
    var personas = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: hostname + "comun/json_ruc?query=%QUERY",
            wildcard: "%QUERY"
        }
    });
    personas.initialize();

    var opcionesPersona = {
        hint: true,
        highlight: true,
        minLength: 1
    };

    var plantillaPersona = {
        name: "personas",
        display: "nombres",
        source: personas.ttAdapter(),
        limit: Infinity,
        templates: {
            empty: Handlebars.compile(`<div class="text-danger ms-1"><b>No se encontraron personas</b></div>`),
            pending: Handlebars.compile(`<div class="ms-1"><b>Buscando personas...</b></div>`)
        }
    };
    $(".buscar-persona .typeahead")
        .typeahead(opcionesPersona, plantillaPersona)
        .bind("typeahead:selected", function(obj, datum, name) {
            var fila = $(this).parents('tr').attr('id');
            $(`#${fila}`).find(`input[name="c_personad"]`).val(datum.c_persona);
            $(`#${fila}`).find(`a.btn-buscar-compras`).data('cc_persona_busqueda', datum.c_persona);
            fn_actualizarFila(fila);
        });

    /******************* */

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
        ajax("bancos/dietas_detalle_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
            .then(function(res) {
                if (res !== "0") {
                    throw res;
                }

            }).catch(function(err) {
                $(".txt_estado").addClass("invisible");
                swalError(err);
            });
    }

    function fn_controlcompras(str) {
        swalProcesando();
        ajax("bancos/dietas_detalle_update", str)
            .then(function(res) {
                if (res !== "0") {
                    throw res;
                }
                fn_listarDetalleFromIngresos();
                swalCerrar(750);
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>