function fn_buscar() {
    var str = $("#frmBuscar").serialize();
    obtenerDatos("divListar", "caja/fracc_rep_lista", str, function () {
        fn_listaDataTable('table-reporte', {
            responsive: false,
            searching: true,
            pageLength: 25,
            lengthChange: false,
            buttons: ''
        });
    });
}
