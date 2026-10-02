function fn_buscarRecibos() {
    var str = $("#frmBuscarRecibos").serialize();
    var flag = $("#flag").val();

    var url = "";

    if (flag === "D") {
        // Detalle
        url = "caja/recib_repor_listar_detalle";
    } else if (flag === "L") {
        // Listado
        url = "caja/recib_repor_listar";
    } else {
        alert("El tipo de reporte no es válido.");
        return;
    }

    obtenerDatos("divListarRecibos", url, str, function () {

        fn_listaDataTable('table-reporte', {

            responsive: false,
            searching: true,
            pageLength: 25,
            lengthChange: false,
            buttons: ''

        });

    });
}
