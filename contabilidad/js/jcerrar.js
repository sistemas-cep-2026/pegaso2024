fn_ListarCerrar();

function fn_ListarCerrar() {
    var str = $("#frmBuscarCerrar").serialize();
    obtenerDatos("divListaCerrar", "contabilidad/cerrar_lista", str);
}

function fn_CambiarCierre(boton) {
    var $boton = $(boton);
    if ($boton.prop("disabled")) return;

    var modulo = $boton.data("modulo");
    var titulo = $boton.data("titulo");
    var anho = $boton.data("anho");
    var periodo = $boton.data("periodo");
    var cerrado = String($boton.data("cerrado")) === "1";

    // '*' = CERRADO, '&' = ABIERTO
    var nuevoEstado = cerrado ? "&" : "*";
    var accion = cerrado ? "ABRIR" : "CERRAR";

    alertaMensaje(
        ["¿" + accion + " el período " + periodo + "/" + anho + "?", "Módulo: <b>" + titulo + "</b>"],
        function () {
            $(".btn-estado-cierre").prop("disabled", true);
            return ajax("contabilidad/cerrar_update", {
                cc_local: $("#cerrar_cc_local").val(),
                anho: anho,
                periodo: periodo,
                modulo: modulo,
                estado: nuevoEstado
            })
                .then(function (respuesta) {
                    if (!respuesta || !respuesta.ok) {
                        throw (respuesta && respuesta.mensaje) || "No se pudo actualizar el período.";
                    }
                    swalOk(750);
                    fn_ListarCerrar();
                })
                .catch(function (err) {
                    $(".btn-estado-cierre").prop("disabled", false);
                    var msg = (err && err.responseJSON && err.responseJSON.mensaje) || (typeof err === "string" ? err : "Error al actualizar el cierre del período.");
                    Swal.showValidationMessage(msg);
                });
        }
    );
}
