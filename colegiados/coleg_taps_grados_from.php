<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_personas_especialidad.php");
require_once(u_src() . "bo/bo_tram_especialidad.php");

$bo_especialidad = new bo_tram_especialidad();
$bo_personas_especialidad = new bo_tram_personas_especialidad();
$bo_det = new bo_gen_parametro_det();
$bo_personas = new bo_gen_personas();
$bo_general = new bo_general();

$ent_personas_especialidad = new tram_personas_especialidad();
$ent_personas = new gen_personas();

$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
$tipo_especialidad = $_REQUEST['tipo_especialidad'];
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';

$linea = $_REQUEST['linea']??'';
$flag_escolarizado_checked = 'checked';
$residentado_checked = '';
$libro_folio = '';
$fecha_registro = date('d/m/Y');
$semipresencial = 'X';
$title = 'Nueva';
$forma_pago = '';
$literal = '';
$flag_regularizado = '0';
$obs = '';
$fecha_diploma = '';

$container_pagos = "";
$container_grados = "col-xl-8";

$data_local = $bo_general->listar28Regiones();
$data_universidad = $bo_general->listarUniversidad();
$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '', '1');
$data_pagos_recaudo = $bo_general->listarPagosRecaudoGradosXPersona($cc_persona);

$ent_personas->setC_persona($cc_persona);
$data_per = $bo_personas->listarID($ent_personas);

foreach ($data_per as $row) {
    $nombres = $row['nombre_completo'];
    $cep = $row['c_cmp'];
    $num_documento = $row['num_documento'];
    $cod_documento = $row['cod_documento'];
    $c_local = $row['c_local'];
}
$data_modalidad = $bo_det->listarParametroDet('personas_especialidad', 'semipresencial');
$data_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_filt = array_values(array_filter($data_grados, function ($item) {
    global $tipo_especialidad;
    return $item['cc_codigo'] == $tipo_especialidad;
}));
$val_xx = $arr_filt[0]['detalle_corto'];
$val = $arr_filt[0]['detalle'];

//$data_especialidad = $bo_especialidad->listarXTipo($tipo_especialidad);
$data_max_especialidad = $bo_especialidad->listarMaxXTipo($tipo_especialidad);
$data_max_especialidad = $data_max_especialidad[0];
$cc_reg_esp = $data_max_especialidad['numero'];

if ($opc === 'U') {
    $container_pagos = "d-none";
    $container_grados = "col-xl-12";
    $title = 'Modificar';
    $ent_personas_especialidad->setLinea($linea);
    $ent_personas_especialidad->setCc_persona($cc_persona);
    $ent_personas_especialidad->setTipo_especialidad($tipo_especialidad);
    $data_persona_especialidad = $bo_personas_especialidad->listarIDLinea($ent_personas_especialidad);
    //print_r($data_persona_especialidad);
    foreach ($data_persona_especialidad as $persona_especialidad) {
        $cc_reg_esp =  $persona_especialidad['c_reg_esp'];
        $fecha_registro = $persona_especialidad['fecha'];
        $linea = $persona_especialidad['linea'];
        $literal = $persona_especialidad['literal'];
        $cc_especialidad = $persona_especialidad['c_especialidad'];
        $cc_universidad = $persona_especialidad['c_universidad'];
        $fecha_diploma = $persona_especialidad['fecha_diploma'];
        $c_local = $persona_especialidad['c_local'];
        $semipresencial = $persona_especialidad['semipresencial'];
        $tipo_especialidad = $persona_especialidad['tipo_especialidad'];
        $flag_escolarizado_checked = trim($persona_especialidad['flag_escolarizado']) === '*' ? 'checked' : '';
        $residentado_checked = trim($persona_especialidad['residentado']) === '*' ? 'checked' : '';
        $libro_folio = "Registrado en el Libro de $val N° {$persona_especialidad['n_libro_cole']}, con Folio N° {$persona_especialidad['n_folio_cole']}";
        $obs = $persona_especialidad['obs'];
        $flag_regularizado = $persona_especialidad['flag_regularizado'];
    }
    $forma_pago = 'X';
}
?>
<div class="modal-header">
    <h5 class="modal-title"><?= $title; ?> <?= $val; ?> [<?= $cep; ?> - <?= $nombres; ?>]<br><small><?= $cod_documento; ?>: <?= $num_documento; ?></small></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <p class="fst-italic"><b><?= $libro_folio; ?></b></p>
    <form class="needs-validation" id="frmFormRegistroGrados" action="javascript:fn_guardarRegistroGrados()" method="post" novalidate>
        <input type="hidden" class="form-control" name="cc_persona" id="cc_persona" value="<?= s_crypt($cc_persona); ?>">
        <input type="hidden" class="form-control" name="opc" id="opc" value="<?= s_crypt($opc); ?>">
        <input type="hidden" class="form-control" name="linea" id="linea" value="<?= s_crypt($linea); ?>">
        <input type="hidden" class="form-control" name="tipo_especialidad" id="tipo_especialidad" value="<?= $tipo_especialidad; ?>">
        <input type="hidden" name="forma_pago" value="<?= $forma_pago; ?>">
        <div class="row">
            <div class="<?= $container_grados; ?>">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">N° Registro : </span>
                            <input type="text" class="form-control" id="cc_reg_esp" name="cc_reg_esp" placeholder="Número de registro" value="<?= $cc_reg_esp ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fecha Registro : </span>
                            <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha de registro" value="<?= $fecha_registro; ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Literal : </span>
                            <input type="text" class="form-control" id="literal" name="literal" placeholder="Literal del título o diplomado" spellcheck="true" value="<?= $literal; ?>" required>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Mención : </span>
                            <select name="cc_especialidad" id="cc_especialidad" class="form-select select2" data-placeholder="Seleccione la mención del título o diplomado" required>
                                <option value="">Seleccione la mención del título o diplomado</option>
                                <?php
                                /* foreach ($data_especialidad as $especialidad) {
                                    $select_especialidad = $cc_especialidad === $especialidad['codigo'] ? 'selected' : ''; */
                                ?>
                                    <option value="<?= '';//$especialidad['codigo']; ?>" <?= '';//$select_especialidad; ?>><?= '';//$especialidad['codigo'] . ' - ' . $especialidad['nombre']; ?></option>
                                <?php
                                //}
                                ?>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Universidad : </span>
                            <select name="cc_universidad" id="cc_universidad" class="form-select select2 " data-placeholder="Seleccione la universidad emisora" required>
                                <option value="">Seleccione la universidad emisora</option>
                                <?php
                                foreach ($data_universidad as $universidad) {
                                    $selected_univ = ($cc_universidad == $universidad['c_universidad']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $universidad['c_universidad']; ?>" <?= $selected_univ; ?>>
                                        <?= $universidad['nombre']; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Fecha emisión : </span>
                            <input type="text" class="form-control" id="fecha_diploma" name="fecha_diploma" placeholder="Fecha de emision del título o diplomado" value="<?= $fecha_diploma; ?>" required>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Consejo Regional : </span>
                            <select name="c_local" id="c_local" class="form-select select2" data-placeholder="Seleccione el CR" required>
                                <option value="">Seleccione el CR</option>
                                <?php
                                foreach ($data_local as $local) {
                                    $select_local = trim($c_local) === trim($local['c_local']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $local['c_local']; ?>" <?= $select_local; ?>><?= $local['nombre_abv'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Modalidad : </span>
                            <select name="semipresencial" id="semipresencial" class="form-select" required>
                                <option value="">Seleccione la modalidad de estudios</option>
                                <?php
                                foreach ($data_modalidad as $modalidad) {
                                    $selected_modalidad = $semipresencial === $modalidad['cc_codigo'] ? 'selected' : '';
                                ?>
                                    <option value="<?= $modalidad['cc_codigo']; ?>" <?= $selected_modalidad; ?>><?= $modalidad['detalle']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 pt-2">
                        <?= input_checkbox('Escolarizado', 'flag_escolarizado', '*', $flag_escolarizado_checked); ?>
                        <?= input_checkbox('Residentado', 'residentado',  $residentado_checked); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3 pt-2">
                        <div class="form-check form-switch form-switch-md form-check-inline" dir="ltr">
                            <input class="form-check-input" type="checkbox" role="switch" name="flag_regularizado" id="flag_regularizado" value="1" <?= $flag_regularizado === '1' ? 'checked' : ''; ?> aria-invalid="false" onchange="fn_regularizado($(this));">
                            <label class="form-check-label" for="flag_regularizado">Regularización</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Observación : </span>
                            <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Observación del registro" value="<?= $obs; ?>" <?= $flag_regularizado !== '1' ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 <?= $container_pagos; ?>">
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
        <div class="row mt-1 <?= $container_pagos; ?>">
            <div class="accordion border-0" id="accordionPagos">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header border-0">
                        <button class="accordion-button p-1 caret-off bg-white border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsepago" aria-expanded="false" aria-controls="collapsepago" style="width: fit-content;">
                            <span class="btn btn-ghost-info"><i class="fa fa-plus align-bottom"></i> Agregar pago </span>
                        </button>
                    </h2>
                    <div id="collapsepago" class="accordion-collapse collapse border-0" data-bs-parent="#accordionPagos">
                        <div class="accordion-body border-0">
                            <div class="row">
                                <div class="col-lg-3">
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
                                <div class="col-lg-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="_fecha_op">Fecha</span>
                                        <input type="text" name="fecha_op" id="fecha_op" class="form-control input-pago" placeholder="Fecha de operación" aria-label="Fecha" aria-describedby="_fecha_op" required disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="_operacion">N° operación</span>
                                        <input type="text" name="operacion" id="operacion" class="form-control input-pago" placeholder="N° de operación" aria-label="N° operación" aria-describedby="_operacion" required disabled>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="_monto">Monto</span>
                                        <input type="text" name="monto" id="monto" class="form-control input-pago input-decimal" placeholder="Monto" aria-label="Monto" aria-describedby="_monto" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12 col-12 text-center">
                <?= bt_guardar('Procesar registro'); ?>
                <?= bt_cerrar(); ?>
            </div>
        </div>
    </form>
    <!--end row-->
</div>
<script>
    var fecha_diploma = new Cleave('#fecha_diploma', {
        date: true,
        datePattern: ['d', 'm', 'Y'],
        delimiter: '/'
    });


    $('select.form-select.select2').select2({
        width: 'resolve',
        dropdownAutoWidth: true,
        dropdownParent: $(`#${modalContainerXl}`),
        placeholder: $(this).data('placeholder'),
        language: {
            noResults: function() {
                return "No hay resultados";
            }
        }
    });

    var validateFormGrados = $('#frmFormRegistroGrados').validate({
        rules: {
            fecha_diploma: {
                regexp: /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/
            },
            fecha_op: {
                regexp: /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/
            },
        },
        messages: {
            fecha_diploma: {
                regexp: 'Fecha con formato dd/mm/aaaa'
            },
            fecha_op: {
                regexp: 'Fecha con formato dd/mm/aaaa'
            },
        },
        ignore: [],
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2')); // después del select2 visible
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2').find('.select2-selection').addClass('is-invalid');
            } else {
                $(element).addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2').find('.select2-selection').removeClass('is-invalid');
            } else {
                $(element).removeClass('is-invalid');
            }
        }
    });


    $('select.form-select.select2').on('select2:select', function(e) {
        validateFormGrados.form();
    });

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

    function fn_regularizado(el) {
        var $this = el;
        if ($this.is(':checked')) {
            $('input[name="observacion"]').prop('disabled', !1);
            return $('input[name="forma_pago"]').val('RX');
        }
        $('input[name="observacion"]').prop('disabled', !0);
        return $('input[name="forma_pago"]').val('');
    }
</script>