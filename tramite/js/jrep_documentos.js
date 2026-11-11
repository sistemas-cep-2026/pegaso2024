fn_reporte();

function fn_reporte() {
    var str = $("#frmListarRegistros").serialize();
    obtenerDatos('div_ReporLista', 'tramite/rep_documen_lista', str, function () {
        // Sin resultados la lista no trae tabla: no hay nada que ordenar.
        if (!document.getElementById('table-reporte')) {
            return;
        }
        fn_listaDataTable('table-reporte', {
            searching: true,
            lengthChange: false,
            paging: true,
            pageLength: 30,
            buttons: buttonsDataTable
        });
    });
}