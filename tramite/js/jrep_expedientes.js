fn_buscarExp();

function fn_buscarExp() {
    var str = $("#frmBuscarExp").serialize();
    obtenerDatos('divReporExp', 'tramite/rep_expe_lista', str, function () {
        fn_listaDataTable('table-reporte', {
            searching: false,
            lengthChange: false,
            paging: false,
            buttons: []
        });
    });
}

function fn_verSeguimientoExp(cc_docrecibidos_enc) {
    obtenerDatos(modalContainerXl, 'tramite/exp_rep_show', 'cod=' + encodeURIComponent(cc_docrecibidos_enc), function () {
        modalRegistroXl.show();
    });
}