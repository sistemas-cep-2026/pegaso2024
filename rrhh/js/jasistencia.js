//fn_buscarRegistro();

$("#frmBuscarRegistro").validate();

function fn_buscarRegistro() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos('divReporAsistencia', 'rrhh/rep_asist_listar', str, function () {
        fn_listaDataTable('table-reporte', {
            searching: false,
            lengthChange: false,
            paging: false,
            buttons: []
        });
    });
}

function fn_controlAsistencia(id, cc_persona, opc) {
    var str = 'id=' + id + '&cc_persona=' + cc_persona + '&opc=' + opc;
    obtenerDatos(modalContainer, 'rrhh/rep_asist_from', str, function () {
        modalRegistro.show();
    });
}

function fn_grabarRegistro() {
    var $_ = this;
    console.log($_);
    var str = $("#frmGrabarRegistro").serialize();
    ajax('rrhh/rep_asist_update', str)
        .then(function (data) {
            if (data !== "0") {
                throw data;
            }
            swalOk(750);
            modalRegistro.hide();
            fn_buscarRegistro();
        }).catch(function (err) {
            swalError(err);
        });
}