fn_buscarRegistro();
$('#frmBuscarRegistro').validate();

$("#lista").on('change', function () {
    return $("#cepfinal").prop('disabled', !($(this).is(':checked')));
});

function fn_buscarRegistro() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos("divListarRegistro", "colegiados/carnet_listar", str, function(){
        fn_listaDataTable("tabla-carnet",{
            pageLength:-1
        });
    });
}

function fn_verfoto(str) {
    obtenerDatos(modalContainer, "colegiados/carnet_verfoto", str, function () {
        modalRegistro.show();
    });
}

function fn_limpiarfoto() {
    ajax("colegiados/carnet_update", {})
        .then(function (res) {
            if (res !== '0') {
                throw res;
            }
            swalProcesando("Limpiando lista", "Espere un momento...", 1000);
            fn_buscarRegistro();
        }).catch(function (err) {
            swalError(err);
        });
}