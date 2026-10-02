modalLateralRegistroTemplate.addEventListener('shown.bs.offcanvas', event => {
    if (document.getElementById("modalRegistroXl")) {
        $('.offcanvas-backdrop').css({
            'z-index': 1056
        });
        $('.offcanvas.offcanvas-end').css({
            'z-index': 1057
        });
    }
});

flatpickr('.input-desde', {
    dateFormat: "d/m/Y",
    locale: "es",
    maxDate: "today",
    "plugins": [new rangePlugin({ input: ".input-hasta" })],

});

fn_buscarTramites();
function fn_buscarTramites() {
    var str = $('#fn_buscarTramites').serialize();
    obtenerDatos('divListarTramites', 'colegiados/tram_listar', str, function () {
        fn_listaDataTable('table-expedientes-recaudo', {
            buttons: [],
            pageLength: -1,
            ordering: !1,
            responsive: !1
        })
    });
}

function fn_listarTramitesPago(str) {
    obtenerDatos(modalContainerXl, 'colegiados/tram_listar_detalle', str, () => {
        modalRegistroXl.show();
    });
}

function fn_agregarPago(str) {
    swalProcesando();
    obtenerDatos(
        modalLateralRegistroContainer,
        "colegiados/tram_listar_detalle_from",
        str,
        () => {
            modalLateralRegistro.show();
            swalCerrar();
        }
    );
}

function fn_insertarPago() {
    var str = $('#frmPagosRecaudo').serialize();
    alertaMensaje('¿Desea registrar pago?', function () {
        return ajax('colegiados/tram_listar_detalle_update', str)
            .then(function (res) {
                if (res !== '0') {
                    Swal.showValidationMessage(res);
                }
            })
    }).then(function (result) {
        if (result.isConfirmed) {
            swalOk(1500);
            setTimeout(() => {
                fn_listarTramitesPago(str);
                swalCerrar();
                modalLateralRegistro.hide();
            }, 500);
        }
    });
}
