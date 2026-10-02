var derivacionEnProceso = false;
if ($("#frmFormRegistroDeriv").length) {
    $("#frmFormRegistroDeriv").validate();
}

function fn_buscarRegistroDeriv(seccion) {
    var str = $("#frmFormRegistroDeriv").serialize();
    if (seccion === undefined || seccion === null || seccion === '') {
        obtenerDatos("div_derivaciones", "tramite/exp_deriv_lista", str, function () {
            if (window.initTooltips) {
                window.initTooltips(document.getElementById("div_derivaciones"));
            }
        });
        return;
    }
    str += "&seccion=" + encodeURIComponent(seccion);
    ajax("tramite/exp_deriv_lista", str)
        .then(function (html) {
            $("#sec_" + seccion).replaceWith(html);
            if (window.initTooltips) {
                window.initTooltips(document.getElementById("sec_" + seccion));
            }
        })
        .catch(function (err) {
            swalError(err);
        });
}

function fn_agregarDeriv(cc_docrecibidos_det, cc_docrecibidos, opcd, linea, seccion) {
    if (derivacionEnProceso) {
        return;
    }
    derivacionEnProceso = true;
    swalProcesando();
    ajax("tramite/exp_deriv_update", {
        cc_docrecibidos_det: cc_docrecibidos_det,
        cc_docrecibidos: cc_docrecibidos,
        opcd: opcd,
        linea: linea
    })
        .then(function (res) {
            if (res !== "0") {
                throw res;
            }

            derivacionEnProceso = false;
            fn_buscarRegistroDeriv(seccion);
            swalCerrar(750);
        })
        .catch(function (err) {
            derivacionEnProceso = false;
            swalError(err);
        });
}

$(document).on("change", ".det-form select.auto-save", function () {
    fn_autoguardarDetalle($(this).closest("form.det-form"));
});

$(document).on("blur", ".det-form input.auto-save, .det-form textarea.auto-save", function () {
    fn_autoguardarDetalle($(this).closest("form.det-form"));
});

function fn_autoguardarDetalle($form) {
    if (!$form.length) {
        return;
    }

    var opcd = $form.data("opcd-u");
    var seccion = $form.data("seccion");
    var str = $form.serialize();

    Swal.fire({
        title: 'Guardando...',
        icon: 'info',
        position: 'top-end',
        toast: true,
        showConfirmButton: false,
        timerProgressBar: true,
        didOpen: function () {
            Swal.showLoading();
        }
    });

    ajax("tramite/exp_deriv_update", str + "&opcd=" + encodeURIComponent(opcd) + "&seccion=" + encodeURIComponent(seccion))
        .then(function (res) {
            if (res !== "0") {
                throw res;
            }
            Swal.close();
            Swal.fire({
                title: 'Guardado',
                icon: 'success',
                position: 'top-end',
                toast: true,
                showConfirmButton: false,
                timer: 1000
            });
        })
        .catch(function (err) {
            Swal.close();
            swalError(err);
        });
}

function fn_recibirDeriv(cc_docrecibidos_det, cc_docrecibidos, opcd, seccion) {
    if (derivacionEnProceso) {
        return;
    }

    derivacionEnProceso = true;
    swalProcesando();

    ajax("tramite/exp_deriv_update", {
        cc_docrecibidos_det: cc_docrecibidos_det,
        cc_docrecibidos: cc_docrecibidos,
        opcd: opcd
    })
        .then(function (data) {
            if (data !== "0") {
                throw data;
            }

            derivacionEnProceso = false;
            fn_buscarRegistroDeriv(seccion);
            swalCerrar(750);
        })
        .catch(function (err) {
            derivacionEnProceso = false;
            swalError(err);
        });
}

function fn_marcarAtendido(cc_docrecibidos_det, opcd, seccion) {
    var str = "cc_docrecibidos_det=" + encodeURIComponent(cc_docrecibidos_det)
        + "&opcd=" + encodeURIComponent(opcd)
        + "&seccion=" + encodeURIComponent(seccion);

    alertaMensaje(
        "¿Confirma que el trámite fue atendido? Esta acción no se puede deshacer.",
        function () {
            return ajax("tramite/exp_deriv_update", str)
                .then(function (data) {
                    if (data !== "0") {
                        throw data;
                    }

                    return data;
                });
        }
    )
        .then(function (result) {
            if (result && result.value) {
                swalOk(750);
                fn_buscarRegistroDeriv(seccion);
            }
        })
        .catch(function (err) {
            swalError(err);
        });
}

function fn_EliminarDeriv(cc_docrecibidos_det, opcd, seccion) {
    var str = "cc_docrecibidos_det=" + encodeURIComponent(cc_docrecibidos_det)
        + "&opcd=" + encodeURIComponent(opcd)
        + "&seccion=" + encodeURIComponent(seccion);

    alertaMensaje(
        "¿Desea eliminar esta derivación?",
        function () {
            return ajax("tramite/exp_deriv_update", str)
                .then(function (data) {
                    if (data !== "0") {
                        throw data;
                    }

                    return data;
                });
        }
    )
        .then(function (result) {
            if (result && result.value) {
                swalOk(750);
                fn_buscarRegistroDeriv(seccion);
            }
        })
        .catch(function (err) {
            swalError(err);
        });
}

$(document).on(
    "keydown",
    ".det-form input, .det-form select, .det-form textarea",
    function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            $(this).blur();
            return false;
        }
    }
);