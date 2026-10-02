<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
$cc_evento = s_crypt($_REQUEST['cc_evento'], 'out') ?? '';
?>
<div class="modal-header">
    <h4 class="modal-title">NUEVA MATRICULA</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
    <ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="buscar-tab" data-bs-toggle="tab" href="#tap_buscar_persona" aria-controls="tap_buscar_persona" role="tab" aria-selected="true">BUSCAR PERSONA</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="importar-tab" data-bs-toggle="tab" href="#tap_importar_excel" aria-controls="tap_importar_excel" role="tab" aria-selected="false">IMPORTAR EXCEL</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tap_buscar_persona" aria-labelledby="buscar-tab" role="tabpanel">
            <form method="post" action="javascript:fn_grabarMatricula();" role="form" id="frmRegistroMatricula" novalidate>
                <div class="row">
                    <div class="col-lg-3">
                        <select name="c_persona_ref" class="form-control form-select" id="tipo_persona">
                            <option value="C">COLEGIADO</option>
                            <option value="O">OTROS PROF.</option>
                        </select>
                    </div>
                    <div class="col-lg-9">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="c_persona" name="c_persona" value="">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" value="" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="asistente" name="asistente" value="1" checked>
                            <label class="form-check-label">
                                Asistente
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="ponente" name="ponente" value="1">
                            <label class="form-check-label">
                                Ponente
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="organizador" name="organizador" value="1">
                            <label class="form-check-label" for="organizador">
                                Organizador
                            </label>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="cc_evento" id="cc_evento" value="<?php echo s_crypt($cc_evento); ?>">
                            <input type="hidden" class="form-control" name="opc" id="opc" value="<?php echo s_crypt('I'); ?>">
                            <?php echo bt_guardar(); ?>
                            <?php echo bt_cerrar(); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tap_importar_excel" aria-labelledby="importar-tab" role="tabpanel">
            <div class="alert alert-info">
                <a href="capacitacion/file/plantilla_matricula.xlsx" download class="btn btn-sm btn-outline-primary mb-2">
                    <i class="ri-download-2-line align-bottom me-1"></i> Descargar plantilla (.xlsx)
                </a>
                <div>Llena la plantilla y súbela: <b>CEP</b> (colegiados) o <b>NUM_DOCUMENTO</b> (DNI, no colegiados), <b>NOMBRE</b>, y <b>ASISTENTE/PONENTE/ORGANIZADOR</b> con 1 o 0.</div>
            </div>
            <form method="post" action="javascript:fn_cargarExcel();" role="form" id="frmImportarMatricula" novalidate>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="mb-3">
                            <input type="file" class="form-control" id="archivo_import" name="archivo_import" accept=".xlsx" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <button type="submit" class="btn btn-primary w-100"><i class="ri-upload-2-line align-bottom me-1"></i> Cargar</button>
                    </div>
                </div>
                <input type="hidden" name="cc_evento" value="<?php echo s_crypt($cc_evento); ?>">
            </form>
            <div id="divReporteImport"></div>
        </div>
    </div>
</div>
<script>
    $("#frmRegistroMatricula").validate();

    var dataSetColegiados = newBloodhound({
        url: 'comun/json_colegiado'
    });

    var dataSetEmpresas = newBloodhound({
        url: 'comun/json_personasotros'
    });

    $(`#nombre`).typeahead(typeaheadOptions, {
        name: 'nombres',
        display: 'nombres',
        limit: 15,
        templates: templates,
        source: function(query, sync, async) {
            let tipo = $('#tipo_persona').val();
            if (tipo === "C") {
                dataSetColegiados.search(query, sync, async);
            } else {
                dataSetEmpresas.search(query, sync, async);
            }
        }
    }).bind("typeahead:selected", function(_, datum) {
        $("#c_persona").val(datum.c_persona);
    });

    function fn_grabarMatricula() {
        swalProcesando();
        var str = $("#frmRegistroMatricula").serialize();
        ajax('capacitacion/matric_buscar_update', str)
            .then(function(res) {
                if (res != '0') {
                    throw res;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_reporteParticipantes();
            }).catch(function(err) {
                swalError(err);
            });
    }

    function fn_cargarExcel() {
        var archivo = $("#archivo_import")[0].files[0];
        if (!archivo) {
            swalError("Selecciona un archivo .xlsx.");
            return;
        }
        var form = new FormData();
        form.append("archivo_import", archivo);
        form.append("cc_evento", $("#frmImportarMatricula input[name='cc_evento']").val());

        swalProcesando();
        ajaxArchivo(form, 'capacitacion/matric_import_cargar')
            .then(function(res) {
                var data = JSON.parse(res);
                swalOk(750);
                fn_verReporteImport();
            }).catch(function(err) {
                swalError(err.responseText || 'Error al cargar el archivo.');
            });
    }

    function fn_verReporteImport() {
        var str = "cc_evento=" + $("#frmImportarMatricula input[name='cc_evento']").val();
        obtenerDatos("divReporteImport", "capacitacion/matric_import_reporte", str, function() {});
    }

    function fn_procesarImport(cc_evento) {
        alertaMensaje("¿Confirma procesar la importación? Se crearán las personas nuevas y se matricularán todos los registros.", function() {
            const str = `cc_evento=${cc_evento}`;
            return ajax("capacitacion/matric_import_procesar", str)
                .then(function(res) {
                    return JSON.parse(res);
                })
                .catch(function(err) {
                    Swal.showValidationMessage(err.responseText || 'Error al procesar.');
                });
        }).then(function(result) {
            if (result.value) {
                var data = result.value;
                var html = `Personas nuevas creadas: <b>${data.personas_creadas}</b><br>Total procesados: <b>${data.total_procesados}</b>`;
                Swal.fire({
                    icon: 'success',
                    title: 'Importación procesada',
                    html: html
                });
                $("#divReporteImport").html('');
                $("#archivo_import").val('');
                fn_reporteParticipantes();
            }
        });
    }
</script>
