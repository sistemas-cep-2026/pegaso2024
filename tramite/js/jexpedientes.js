$(document).ready(function () {
    $("#frmRegistroExp").validate();

    $('#c_tipo_de_documento').select2({
        placeholder: "Selecciona tipo de documento",
        width: '100%'
    });

    if ($("fieldset").is(":disabled")) {
        $('#c_tipo_de_documento').prop("disabled", true);
        $('#c_tipo_de_documento').select2().prop("disabled", true);
    }

    window.mostrarCamposExtras();

});

function esExpedienteExistente() {
    var numExp = parseInt($('#c_expediente').val(), 10);
    return !isNaN(numExp) && numExp > 0;
}
if (esExpedienteExistente()) {
    fn_listarDetalleFromExp();
}

window.Expedientes = window.Expedientes || {};
Expedientes.typeaheadOptions = Expedientes.typeaheadOptions || {
    hint: true,
    highlight: true,
    minLength: 3,
};

Expedientes.templates = Expedientes.templates || {
    empty: Handlebars.compile(
        `<div class="text-danger ms-1"><b><i class="fa fa-search"></i> No hay resultados</b></div>`
    ),
    pending: Handlebars.compile(
        `<div class="ms-1"><b><i class="fa fa-spinner fa-spin"></i> Buscando datos</b></div>`
    ),
};

function configurarBloodhound() {
    const tipoPersona = $("#tipo_persona").val();
    let endpoint = "";

    switch (tipoPersona) {
        case "C": endpoint = "comun/json_colegiado"; break;
        case "I": endpoint = "comun/json_personasotros"; break;
        case "E": endpoint = "comun/json_ruc"; break;
    }

    return new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("nombres"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: `${hostname}${endpoint}`,
            replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
            rateLimitWait: 150,
        },
    });
}

function inicializarTypeahead(selector, bloodhound, hiddenInputName, resetCampos = false) {
    try {
        $(selector).typeahead("destroy");
    } catch (_e) {
        // No pasap nada si no estaba inicializado
    }

    if (resetCampos) {
        $(selector).val("");
        $(`input[name="${hiddenInputName}"]`).val("");
    }

    $(selector)
        .typeahead(Expedientes.typeaheadOptions, {
            name: selector.replace("#", ""),
            display: "nombres",
            source: bloodhound.ttAdapter(),
            limit: 15,
            templates: Expedientes.templates,
        })
        .on("typeahead:selected", function (_e, datum) {
            $(`input[name="${hiddenInputName}"]`).val(datum.c_persona);
        });
}

let expedientesPrimeraCarga = true;

window.mostrarCamposExtras = function () {
    let tipoPersona = $("#tipo_persona").val();

    if (tipoPersona === "E") {
        $("#extraFields").show();
    } else {
        $("#extraFields").hide();
    }

    let bloodhound = configurarBloodhound();
    let resetCampos = !expedientesPrimeraCarga;

    inicializarTypeahead("#nombre", bloodhound, "c_persona", resetCampos);
    inicializarTypeahead("#nombre_remitente", bloodhound, "c_persona_pf", resetCampos);

    expedientesPrimeraCarga = false;
};

// ================== RESTO SIN CAMBIOS ==================
function fn_guardarExp() {
    swalProcesando();
    var str = $("#frmRegistroExp").serialize();
    ajax('tramite/exp_taps_update', str)
        .then(function (data) {
            if (data.error || typeof data !== 'object') throw data?.message || data;
            redireccionar(data.url);
        })
        .catch(swalError);
}

function fn_listarDetalleFromExp() {
    var cc_docrecibidos = $('#cc_docrecibidos').val();
    var flag = $('#flag').val();
    if (!cc_docrecibidos || cc_docrecibidos.trim() === '') {
        $('#divDetalleDetalleExp').html('');
        return;
    }
    var str = $.param({
        cc_docrecibidos: cc_docrecibidos, flag: flag
    });
    obtenerDatos('divDetalleDetalleExp', 'tramite/exp_taps_det_from', str);
}

function fn_ArchivarRegistroFrom(str) {
    alertaMensaje('¿Desea archivar el Expediente?', function () {
        return ajax('tramite/exp_taps_update', str)
            .then(function (data) {
                if (data.error || typeof data !== 'object') throw data?.message;
                return data;
            })
            .catch(function (err) { Swal.showValidationMessage(err); });
    }).then(function (result) {
        if (result.value) recargar(750);
    });
}


function fn_subirArchivo() {
    swalProcesando();
    var str_files = new FormData($('#frmSubirArchivo')[0]);
    ajaxArchivo(str_files, "tramite/exp_file_update")
        .then(function (data) {
            if (data !== "0") {
                throw data;
            }
            Swal.close();
            recargar(750, 'O');
        })
        .catch(function (err) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: err,
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: true
            });
        });
}


function fn_eliminarArchivo(...arreglo) {
    alertaMensaje('¿Estás seguro de eliminar el archivo?', function () {
        var str = `cc_docrecibidos=${arreglo[0]}&opc=${arreglo[1]}&file_adjunto=${arreglo[2]}`;
        return ajax("tramite/exp_file_update", str)
            .then(function (data) {
                if (data !== "0") {
                    throw data;
                }
                recargar(750, 'O');
            })
            .catch(function (err) {
                Swal.showValidationMessage(err);
            });
    });
}

/* Segunda pestaña */
function fn_BuscarExp() {
    var str = $("#frm").serialize();
    obtenerDatos("div_listarExp", "tramite/exp_rep_buscar", str, function () {
        fn_reporteExp();
    });
}

function fn_reporteExp() {
    var str = $("#frmListarRegistrosExp").serialize();
    obtenerDatos("div_ReporLista", "tramite/exp_rep_listar", str, function () {
        fn_listaDataTable('table-expedientes', {
            responsive: true,
            searching: true,
            ordering: true,
            pageLength: 60,
            lengthChange: false,
            buttons: []
        });
    });
}

function fn_verSeguimientoExp(cc_docrecibidos_enc) {
    obtenerDatos(modalContainerXl, 'tramite/exp_rep_show', 'cod=' + encodeURIComponent(cc_docrecibidos_enc), function () {
        modalRegistroXl.show();
    });
}