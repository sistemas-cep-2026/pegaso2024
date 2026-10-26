<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_tram_documentos_enviados_destinos.php");

$bo_general = new bo_general();

$bo_documentos_dest = new bo_tram_documentos_enviados_destinos();
$ent_documentos_dest = new tram_documentos_enviados_destinos();

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_docenviado = isset($_REQUEST['cc_docenviado']) ? s_crypt($_REQUEST['cc_docenviado'], 'out') : '';
$ent_documentos_dest->setCc_docenviado($cc_docenviado);
$data_detalle = $bo_documentos_dest->listar($ent_documentos_dest);

$disabled = 'disabled';

if ($opc == 'U') {
    $disabled = '';
}

?>

<fieldset <?php echo $disabled; ?>>
    <form id="formGrabarDetalle">
        <table class="table table-borderless table-sm">
            <thead class="table-light">
                <tr class="align-middle">
                    <th>#</th>
                    <th class="col-5">Destinatario(Persona/Entidad) </th>

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
                foreach ($data_detalle as $detalle) {
                ?>
                    <tr id="row<?php echo s_crypt($detalle['cc_docenviado_det']); ?>" class="align-top">

                        <input type="hidden" name="cc_docenviado" value="<?php echo s_crypt($cc_docenviado); ?>">
                        <input type="hidden" name="cc_docenviado_det" value="<?php echo s_crypt($detalle['cc_docenviado_det']); ?>">

                        <td class="text-center"><?php echo $i . '-' . $detalle['cc_docenviado_det']; ?></td>

                        <td class="buscar-cta">

                            <div class="buscar-persona">
                                <input type="hidden" class="form-control form-control-sm" name="c_persona" id="c_persona" value="<?php echo s_crypt($detalle['c_persona']); ?>">
                                <input type="text" class="form-control form-control-sm typeahead" name="nombres" id="nombres" value="<?php echo $detalle['nombre'] ?>">
                            </div>


                        </td>

                        <td class="text-center">
                            <button type="button" class="btn btn-icon bg-transparent" onclick="fn_borrarFila('<?php echo s_crypt($detalle['cc_docenviado_det']); ?>');" <?php echo $disabled; ?>><i class="fa fa-lg fa-trash text-danger"></i></a>

                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
            </tbody>


        </table>
    </form>
</fieldset>

<script>
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
            $(`#${fila}`).find(`input[name="c_persona"]`).val(datum.c_persona);

            fn_actualizarFila(fila);
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
        ajax("tramite/documentos_taps_det_update", `${str}&opcd=<?php echo s_crypt('U') ?>`)
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
        fn_control_Det(`cc_docenviado_det=${cc_docenviado_det}&opcd=<?php echo s_crypt('E'); ?>`)
    }

    function fn_agregarFila() {
        fn_control_Det(`cc_docenviado_det=<?php echo s_crypt($cc_docenviado_det); ?>&opcd=<?php echo s_crypt('I'); ?>`)
    }

     function fn_control_Det(str) {
        swalProcesando();
        ajax("tramite/documentos_taps_det_update", str)
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
</script>