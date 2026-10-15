fn_buscarExp();

function fn_buscarExp() {
    var str = $("#frmBuscarExp").serialize();
    obtenerDatos('divReporExp', 'tramite/rep_expe_lista', str, function () {
        // Sin resultados la lista no trae tabla: no hay nada que ordenar.
        if (!document.getElementById('table-reporte')) {
            return;
        }
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