function fn_buscarRecibos() {
    var str = $("#frmBuscarRecibos").serialize();
    obtenerDatos("divListarRecibos", "caja/exo_rep_lista", str, function () {
        fn_listaDataTable('table-reporte', {
            responsive: false,
            searching: true,
            pageLength: 25,
            lengthChange: false,
            buttons: ''
        });
    });
}
