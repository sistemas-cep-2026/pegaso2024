$("#frmRegistroCompra").validate();
function getPersonaUrl() {
    var codDocumento = $("#cod_documento").val();
    var documentosEspeciales = ["FE", "RH", "BE", "RS", "BV"];

    return documentosEspeciales.includes(codDocumento)
        ? "comun/json_ruc"
        : "comun/json_personasotros"; // Todos los casos retornan json_ruc ahora
}

function initTypeahead() {
    var engine = newBloodhound({
        url: getPersonaUrl()
    });

    $('#nombre').typeahead('destroy');
    newTypeahead('nombre', engine).on("typeahead:selected", function (e, datum) {
        $('input[name="cc_persona"]').val(datum.c_persona);
    });
}

initTypeahead();
$(document).on("change", "#cod_documento", function () {
    $('input[name="cc_persona"]').val('');
    $('#nombre').val('');
    initTypeahead();
});

function fn_guardarCchica() {
    swalProcesando();
    var str = $("#frmRegistroCchica").serialize();
    ajax('compras/doccajachica_taps_update', str)
        .then(function (data) {
            // var data = JSON.parse(res);
            if (data.error || typeof data !== 'object') {
                throw data?.message || data;
            }
            redireccionar(data.url);

        }).catch(function (err) {
            swalError(err);
        });
}

var parametro = getParameterByName('opc');
if (parametro !== '') {
    fn_listarDetalleFrom();
}

/********************************/
function fn_listarDetalleFrom() {
    var str = $("#frmRegistroCchica").serialize();
    obtenerDatos('divDetalleDetalleCH', 'compras/rep_compras_det_from', str);
}

function fn_procesarRegistro(str) {
    alertaMensaje('¿Desea procesar el Documento?', function () {
        return ajax('compras/comp_taps_update', str)
            .then(function (data) {

                if (data.error || typeof data !== 'object') {
                    throw data?.message;
                }
                return data;
            }).catch(function (err) {
                Swal.showValidationMessage(err);
            });
    }).then(function (result) {
        if (result.value) {
            recargar(750);
        }
    });

}

function fn_anularRegistroFrom(...args) {
    var str = `cc_compra=${args[0]}&opc=${args[1]}`
    alertaMensaje('¿Desea anular el Documento?', function () {
        return ajax('compras/comp_taps_update', str)
            .then(function (data) {
                //var data = JSON.parse(res);
                if (data.error || typeof data !== 'object') {
                    throw data?.message;
                }
                return data;
            }).catch(function (err) {
                Swal.showValidationMessage(err);
            });
    }).then(function (result) {
        if (result.value) {
            recargar(750);
        }
    });

}
function fn_AbrirRegistroFrom(...args) {
    var str = `cc_compra=${args[0]}&opc=${args[1]}`
    alertaMensaje('¿Desea ABRIR el Documento?', function () {
        return ajax('compras/comp_taps_update', str)
            .then(function (data) {
                //var data = JSON.parse(res);
                if (data.error || typeof data !== 'object') {
                    throw data?.message;
                }
                return data;
            }).catch(function (err) {
                Swal.showValidationMessage(err);
            });
    }).then(function (result) {
        if (result.value) {
            recargar(750);
        }
    });

}


function fn_reporteComprasCH() {
    var str = $("#frm").serialize();
    obtenerDatos("divReporComprasCH", "compras/doccajachica_taps_listar", str, function () {
        fn_listaDataTable('table-cjachoca', {
            responsive: false,
            searching: true,
            pageLength: -1,
            lengthChange: false,
            buttons: []
        });
    });
}



/***************calculo y validacion********/
function parseTotal() {
    const v = ($("#total").val() || "").toString();
    const clean = v.replace(/,/g, "").trim();
    const n = parseFloat(clean);
    return isNaN(n) ? 0 : n;
}

function toggleEl(id, show) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle("d-none", !show);
}

function setRequired(id, req) {
    const el = document.getElementById(id);
    if (!el) return;
    if (req) el.setAttribute("required", "required");
    else el.removeAttribute("required");
}

function refreshRetencionUI() {
    const cod = ($("#cod_documento").val() || "").toString().trim();
    const total = parseTotal();
    let tipo = ($("#tipo_desc").val() || "").toString().trim();

    if (cod === "RH") {

        toggleEl("row_tipo_desc", true);

        $("#tipo_desc").val("R");
        // $("#porcentaje").val("8");
        tipo = "R";

        toggleEl("col_porcentaje", false);
        toggleEl("col_porcentaje_ret", true);
        toggleEl("col_reten_numero", false);
        toggleEl("col_reten_fecha", false);

        setRequired("porcentaje", false);
        setRequired("porcentaje_ret", true);
        setRequired("reten_numero", false);
        setRequired("reten_fecha", false);

        return;
    }
    else {
        const showRow = (cod === "FE" || cod === "FP") && total > 0;
        toggleEl("row_tipo_desc", showRow);



        const isR = (tipo === "R");
        const isD = (tipo === "D");

        toggleEl("col_porcentaje", isD);
        toggleEl("col_porcentaje_ret", isR);
        toggleEl("col_reten_numero", isR || isD);
        toggleEl("col_reten_fecha", isR);

        if (!showRow) {
            setRequired("porcentaje", false);
            setRequired("porcentaje_ret", false);
            setRequired("reten_numero", false);
            setRequired("reten_fecha", false);
            return;
        } else {

            setRequired("porcentaje", isD);
            setRequired("porcentaje_ret", isR);
            setRequired("reten_numero", isR || isD);
            setRequired("reten_fecha", isR);
        }

    }
}

$(document).on("change", "#cod_documento", refreshRetencionUI);
$(document).on("change", "#tipo_desc", refreshRetencionUI);
$(document).on("input", "#total", refreshRetencionUI);

document.addEventListener("DOMContentLoaded", refreshRetencionUI);

function formatDocumento(input) {
    let value = input.value.replace(/[^a-zA-Z0-9]/g, "").toUpperCase();
    let serie = value.substring(0, 3);   // Ej: F001
    let numero = value.substring(3, 11);  // Ej: 00001234

    let formatted = serie;

    if (numero.length > 0) {
        // ✅ Rellenar con ceros a la izquierda hasta 8 dígitos
        let numeroPadded = numero.padStart(7, "0");
        formatted += "-" + numeroPadded;
    }

    input.value = formatted;
}


